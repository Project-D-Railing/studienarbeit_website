<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Response;

class TrainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function calc_diff($time1, $time2)
    {
        $time1 = strtotime($time1);
        $time2 = strtotime($time2);
        $midnight = strtotime("00:00");
        $diff = 0;
        // lookup if times are on possible different days
        if($time2 - $midnight < $time1 - $midnight) {
            // look if diff is negative by over 5 hours. This is an identicator of a dayshift
            $diff = $time2 - $time1;
            if($diff < -20000) {
                // add a day to prevent dayshift event
                $diff = $diff + 86400;
            }
        } else {
            
            $diff = $time2 - $time1;
        }  
        // return the value rounded so instead of 60 (for seconds) we get 1 (for minutes) because our data is only accurate by minutes
        // here shouldnt be any data loss by throwing away the seconds which are always zero
        return round($diff / 60);
    }

    private function generate_delay_statistic_overall($zugklasse, $zugnummer) 
    {
        // this query returns stats on trains and their platform they are departing from.
        // SELECT Count(id), gleisist, zugklasse FROM k42174_bahnapi.zuege where evanr= 8000191 group by gleisist, zugklasse limit 1000
        // get this data to c3js and show as stacked bar chart for each platform, like ICE green, RB red, ....
        
        $trains = DB::connection('mysql2')->select("SELECT datum, evanr, arzeitsoll, arzeitist, dpzeitsoll, dpzeitist, zugstatus, NAME FROM zuege,haltestellen2 where zuege.evanr=haltestellen2.EVA_NR AND zugklasse= :zugklasse and zugnummer= :zugnummer and datum > (SELECT CURRENT_DATE - INTERVAL 14 DAY) ORDER BY zuege.stopid desc", ['zugklasse' => $zugklasse, 'zugnummer' => $zugnummer]);
        $trainformatted = array();
        foreach ($trains as $train) {
            if (!array_key_exists($train->evanr, $trainformatted)) {
                $trainformatted[$train->evanr][] = array('x','Ankunft','Abfahrt');
            }
            if($train->zugstatus == 'n') {
                $trainformatted[$train->evanr][] = array($train->datum, $this->calc_diff($train->arzeitsoll, $train->arzeitist), $this->calc_diff($train->dpzeitsoll, $train->dpzeitist), $train->NAME);
            } else {
                $trainformatted[$train->evanr][] = array($train->datum, NULL, NULL, $train->NAME);
            }
            
        }
        
        return $trainformatted;
    }    

    public function index()
    {
        $train = array();
        
        return view('train.index', ['train' => $train]);

    }
    
    public function find(Request $request)
    {
        $q = $request->get('q');
        $trains = DB::connection('mysql2')->select("select DISTINCT(zugnummerfull), zugklasse as class, zugnummer as number from zugsuche where zugnummerfull like :zugnummerfull LIMIT 10", ['zugnummerfull' => '%'.$q.'%']);
        return Response::json($trains);

    }
    
    public function detail($zugklasse, $zugnummer)
    {
        $train = Cache::remember('showtrain'.$zugklasse.'-'.$zugnummer, 1440, function() use ($zugklasse,$zugnummer){             
            $train = DB::connection('mysql2')->select("SELECT * from zuege where zugklasse= :zugklasse AND zugnummer= :zugnummer LIMIT 1", ['zugklasse' => $zugklasse,'zugnummer' => $zugnummer]);
            
            return $train;
        });       
       
        return view('train.detail', ['train' => $train]);

    }
    
    public function route($zugklasse, $zugnummer)
    {
        $result = Cache::remember('showtrainstationroute'.$zugklasse.'-'.$zugnummer, 1440, function() use ($zugklasse,$zugnummer){             
            $result = DB::connection('mysql2')->select("SELECT haltestellen from strecken2 where hashwertneu in (SELECT distinct(streckengeplanthash) from zuege where zugklasse= :zugklasse and zugnummer= :zugnummer order by id desc)", ['zugklasse' => $zugklasse,'zugnummer' => $zugnummer]);
            
            return $result;
        });        
        $routes = array();
        foreach($result as $route) {
            $routes[] = explode('|',$route->haltestellen);
        }

        return view('train.route', ['routes' => $routes]);

    }
    
    public function platform($zugklasse, $zugnummer)
    {
        $result = Cache::remember('showtrainstationplatform'.$zugklasse.'-'.$zugnummer, 1440, function() use ($zugklasse,$zugnummer){             
            $result = DB::connection('mysql2')->select("SELECT count(gleisist) as anzahl, evanr, gleisist, name from zuege,haltestellen2 where zuege.evanr=haltestellen2.EVA_NR and zugklasse= :zugklasse and zugnummer= :zugnummer group by gleisist,evanr order by stopid asc, anzahl desc", ['zugklasse' => $zugklasse,'zugnummer' => $zugnummer]);
            
            return $result;
        });
        $stats = array();
        
        foreach($result as $entry) {
            if ($entry->gleisist == NULL) {
               $entry->gleisist = 'keine Angabe';   
            }
            $stats[$entry->evanr][] = array($entry->gleisist,$entry->anzahl,$entry->name);
        }
        
        return view('train.platform', ['stats' => Response::json($stats)]);
    }
    
    public function cancel($zugklasse, $zugnummer)
    {
        $result = Cache::remember('showtrainstationcancel'.$zugklasse.'-'.$zugnummer, 1440, function() use ($zugklasse,$zugnummer){             
            $result = DB::connection('mysql2')->select("SELECT count(zugstatus) as anzahl, evanr, zugstatus, name from zuege,haltestellen2 where zuege.evanr=haltestellen2.EVA_NR and zugklasse= :zugklasse and zugnummer= :zugnummer and zuege.id > 5200000 group by zugstatus,evanr order by anzahl desc", ['zugklasse' => $zugklasse,'zugnummer' => $zugnummer]);
            
            return $result;
        });
        $stats = array();
        
        foreach($result as $entry) {
            $stats[$entry->evanr][] = array($entry->zugstatus,$entry->anzahl,$entry->name);
        }
        
        return view('train.cancel', ['stats' => Response::json($stats)]);
    }
    
    public function delay($zugklasse, $zugnummer)
    {
        $stats = Cache::remember('showtrainDelayStatistic'. $zugklasse.'-' . $zugnummer, 240, function() use ($zugklasse, $zugnummer){             
            $trainformatted = $this->generate_delay_statistic_overall($zugklasse, $zugnummer);
            
            return Response::json($trainformatted);
        });

        return view('train.delay', ['stats' => $stats]);

    }
    
    public function stations($zugklasse, $zugnummer)
    {
        $result = Cache::remember('showtrainstations'.$zugklasse.'-'.$zugnummer, 720, function() use ($zugklasse,$zugnummer){             
            $haltestellen = DB::connection('mysql2')->select("select haltestellen.NAME as name,zuege.* from zuege,haltestellen where dailytripid = (SELECT dailytripid from zuege where zugklasse= :zugklasse AND zugnummer= :zugnummer LIMIT 1) and haltestellen.EVA_NR = zuege.evanr group by evanr order by stopid asc", ['zugklasse' => $zugklasse,'zugnummer' => $zugnummer]);
            
            return $haltestellen;
        });
        // EVA NUMMERN wie folgt: select distinct(evanr) from zuege where dailytripid = (SELECT dailytripid from zuege where zugklasse='ICE' AND zugnummer='513' LIMIT 1) 
        // mit allen infos: select haltestellen.NAME,zuege.* from zuege,haltestellen where dailytripid = (SELECT dailytripid from zuege where zugklasse='ICE' AND zugnummer='513' LIMIT 1) and haltestellen.EVA_NR = zuege.evanr group by evanr        
        return view('train.stations', ['haltestellen' => $result]);

    }
}
