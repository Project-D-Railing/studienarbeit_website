<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Response;

class StationController extends Controller
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
        $query = DB::connection('mysql2')->select('SELECT zuege.*,haltestellen2.NAME FROM zuege,haltestellen2 WHERE zuege.evanr=haltestellen2.EVA_NR AND zuege.zugid like "-6843069272511463904-1712011109-%" ORDER BY arzeitsoll asc LIMIT 5000');

        return view('station.index', ['route' => $query]);

    }
    
    public function find(Request $request)
    {
        $q = $request->get('q');
        $stationen = DB::connection('mysql2')->select("select EVA_NR, NAME from haltestellen2 where NAME like :name", ['name' => '%'.$q.'%']);
        return Response::json($stationen);

    }

    public function detail($id)
    {
        $station = DB::connection('mysql2')->select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
       
        return view('station.detail', ['station' => $station]);

    }

    public function timetable($id, $date)
    {
        $station = DB::connection('mysql2')->select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
        $stats = Cache::remember('timetable'.$id.'-'.$date, 60, function() use ($id, $date){             
            $stationdate = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE datum= :datum and zuege.evanr= :evanr and stopid != 1 order by arzeitsoll asc", ['evanr' => $id, 'datum' => $date]);
            $stationdatedepart = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE datum= :datum and zuege.evanr= :evanr and stopid = 1 order by dpzeitsoll asc", ['evanr' => $id, 'datum' => $date]);
            $stationarray = array();
            foreach($stationdate as $train) {
                if ($train->stopid !== 1 && $train->dpzeitsoll == $train->dpzeitist && $train->dpzeitsoll == "00:00:00" && ($train->arzeitsoll !== "00:00:00" || $train->arzeitsoll !== "23:59:00")) {
                    $train->dpzeitsoll = NULL;
                    $train->dpzeitist = "Zug endet";
                }
                $stationarray[] = $train; 
            }         
            foreach($stationdatedepart as $train2) {
                $einfug = FALSE;
                $train2->arzeitsoll = NULL;
                $train2->arzeitist = "Zug beginnt";
        
                for ($i = 0; $i < count($stationarray); $i++) {
                    if(!is_object($stationarray[$i])) {
                        continue;
                    }                    
                    if($stationarray[$i]->arzeitsoll > $train2->dpzeitsoll) {
                        array_splice($stationarray, $i, 0, array($train2)); 
                        $einfug = TRUE;
                        break;
                    }
                    continue;                    
                }
                if($einfug === FALSE)  {
                    
                    $stationarray[] = $train2;
                    break;
                }
            }
            return $stationarray;
        });

        $stats_start = Cache::remember('statsstart', 720, function() {
            $result = DB::connection('mysql2')->select("SELECT datum FROM `zuege` ORDER BY id ASC LIMIT 1");

            return date("d.m.Y", strtotime($result[0]->datum));
        });

        return view("station.detaildate", ['zuege' => $stats, 'station' => $station, 'datum' => $date, 'stats_start' => $stats_start])->render();
    }

    public function platform($id)
    {
        $station = DB::connection('mysql2')->select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
        $zugklassen = Cache::remember('showstation'.$id, 240, function() use ($id){             
            $zugklassen = DB::connection('mysql2')->select("SELECT DISTINCT(zugklasse) as name FROM zuege WHERE evanr= :evanr", ['evanr' => $id]);
            
            return $zugklassen;
        });

        $stats_start = Cache::remember('statsstart', 720, function() {
            $result = DB::connection('mysql2')->select("SELECT datum FROM `zuege` ORDER BY id ASC LIMIT 1");

            return date("d.m.Y", strtotime($result[0]->datum));
        });

        return view("station.detailgleis", ['station' => $station,'zugklassen' => $zugklassen, 'stats_start' => $stats_start])->render();
    }

    public function train($id)
    {
        // SELECT Count(id) as anzahl, zugklasse FROM k42174_bahnapi.zuege where evanr=8000191 group by zugklasse limit 10000

        $zugklassen = Cache::remember('showstationzugklassengesamt'.$id, 1440, function() use ($id){             
            $zugklassen = DB::connection('mysql2')->select("SELECT Count(id) as anzahl, zugklasse FROM k42174_bahnapi.zuege where evanr= :evanr group by zugklasse limit 10000", ['evanr' => $id]);
            
            return $zugklassen;
        }); 
        $stats = array();
        $stats[] = array("x");
        $stats[] = array("Zugklassen");
        foreach ($zugklassen as $klasse) {
            $stats[0][] = $klasse->zugklasse;
            $stats[1][] = $klasse->anzahl;
        }

        $stats_start = Cache::remember('statsstart', 720, function() {
            $result = DB::connection('mysql2')->select("SELECT datum FROM `zuege` ORDER BY id ASC LIMIT 1");

            return date("d.m.Y", strtotime($result[0]->datum));
        });
        
        return view('station.detailzug', ['stats' => Response::json($stats), 'stats_start' => $stats_start])->render();
    }
}
