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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
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
            $routes[] = explode('|',$route);
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
    
    public function cancel()
    {
        $train = array();
        //SEE:  SELECT count(zugstatus) as anzahl, evanr, zugstatus, name from zuege,haltestellen2 where zuege.evanr=haltestellen2.EVA_NR and zugklasse="ICE" and zugnummer="1000" and zuege.id > 5200000 group by zugstatus,evanr order by anzahl desc


        return view('train.cancel', ['train' => $train]);

    }
    
    public function delay()
    {
        $train = array();
        // SEE GraphController@getTrainDelayStatistic
        return view('train.delay', ['train' => $train]);

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
