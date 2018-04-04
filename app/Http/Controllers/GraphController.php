<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Response;

class GraphController extends Controller
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
        return FALSE;

    }    
    
    public function somedata($evanr)
    {
        $trains = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE zuege.evanr= :evanr ORDER by zuege.id desc LIMIT 10000", ['evanr' => $evanr]);
            
        $trainformatted = array();
        foreach ($trains as $train) {
            trainformatted['dataset1'][] = $train['arzeitsoll'];
            trainformatted['dataset2'][] = $train['arzeitist'];
            trainformatted['dataset3'][] = $train['dpzeitsoll'];
            trainformatted['dataset4'][] = $train['dpzeitist'];
            
        }

        
        return Response::json($trainformatted);
    }


}
