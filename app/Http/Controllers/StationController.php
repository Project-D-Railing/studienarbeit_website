<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

        return view('stationindex', ['route' => $query]);

    }
    
    
    public function show($id)
    {
        $station = DB::select("select * from haltestellen2 where EVA_NR = :evanr", ['evanr' => $id]);
        return view('stationdetail', ['station' => $station]);

    }

    public function showdate($id, $date)
    {
        $stationdate = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE datum= :datum and zuege.evanr= :evanr", ['evanr' => $id, 'datum' => $date]);
        //return view('stationdetail', ['stationdate' => $stationdate]);

        return View::make("stationdetaildate")->with("zuege", $stationdate)->render();

    }

}
