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
        $query = DB::connection('mysql2')->select('SELECT zuege.*,haltestellen.NAME FROM zuege,haltestellen WHERE zuege.evanr=haltestellen.EVA_NR AND zuege.zugid like "-6843069272511463904-1712011109-%" ORDER BY arzeitsoll asc LIMIT 5000');

        return view('station.index', ['route' => $query]);

    }
    
    public function find(Request $request)
    {
        $q = $request->get('q');
        $stationen = DB::select("select EVA_NR, NAME from haltestellen2 where NAME like :name", ['name' => '%'.$q.'%']);
        return Response::json($stationen);

    }

    public function detail($id)
    {
        $station = DB::select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
       
        return view('station.detail', ['station' => $station]);

    }

    public function timetable($id, $date)
    {
        $station = DB::select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
        $stats = Cache::remember('timetable'.$id.'-'.$date, 60, function() use ($id, $date){             
            $stationdate = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE datum= :datum and zuege.evanr= :evanr", ['evanr' => $id, 'datum' => $date]);
            
            return $stationdate;
        });       
        return view("station.detaildate", ['zuege' => $stats, 'station' => $station, 'datum' => $date])->render();

    }

    public function platform($id)
    {
        $station = DB::select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
        $zugklassen = Cache::remember('showstation'.$id, 240, function() use ($id){             
            $zugklassen = DB::connection('mysql2')->select("SELECT DISTINCT(zugklasse) as name FROM zuege WHERE evanr= :evanr", ['evanr' => $id]);
            
            return $zugklassen;
        }); 
        return view("station.detailgleis", ['station' => $station,'zugklassen' => $zugklassen])->render();

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
        
        return view('station.detailzug', ['stats' => Response::json($stats)])->render();

    }
}
