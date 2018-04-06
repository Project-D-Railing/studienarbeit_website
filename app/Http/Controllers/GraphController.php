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

    /* Return diff in integer format (in minutes) between two times*/
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
    
        
    public function somedata($evanr)
    {
        $trains = DB::connection('mysql2')->select("SELECT zuege.* FROM zuege WHERE zuege.evanr= :evanr ORDER by zuege.id desc LIMIT 1000", ['evanr' => $evanr]);
            
        $trainformatted = array();
        foreach ($trains as $train) {
                        
            $trainformatted['delay1'][] = $this->calc_diff($train->arzeitsoll, $train->arzeitist);
            $trainformatted['delay2'][] = $this->calc_diff($train->dpzeitsoll, $train->dpzeitist);
            //$trainformatted['dataset1'][] = $train->arzeitsoll;
            //$trainformatted['dataset2'][] = $train->arzeitist;
            //$trainformatted['dataset3'][] = $train->dpzeitsoll;
            //$trainformatted['dataset4'][] = $train->dpzeitist;
            
        }

        
        return Response::json($trainformatted);
    }


}
