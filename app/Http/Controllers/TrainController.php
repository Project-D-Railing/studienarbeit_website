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
        $trains = DB::connection('mysql2')->select("select DISTINCT(zugnummerfull), zugklasse as class, zugnummer as number from zuege where zugnummerfull like :zugnummerfull LIMIT 10", ['zugnummerfull' => '%'.$q.'%']);
        return Response::json($trains);

    }

    public function show($id)
    {
        $station = DB::select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
       
        $zugklassen = Cache::remember('showstation'.$id, 30, function() use ($id){             
            $zugklassen = DB::connection('mysql2')->select("SELECT DISTINCT(zugklasse) as name FROM zuege WHERE evanr= :evanr", ['evanr' => $id]);
            
            return $zugklassen;
        }); 

        return view('stationdetail', ['station' => $station,'zugklassen' => $zugklassen]);

    }

    public function showdate($id, $date)
    {
        $stats = Cache::remember('somedate'.$id.'-'.$date, 30, function() use ($id, $date){             
            $stationdate = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE datum= :datum and zuege.evanr= :evanr", ['evanr' => $id, 'datum' => $date]);
            
            return $stationdate;
        });       
        return view("stationdetaildate", ['zuege' => $stats])->render();

    }

}
