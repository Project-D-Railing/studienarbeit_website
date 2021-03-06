<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
    
    private function generate_delay_statistic($evanr, $zugklasse, $zugnummer) 
    {
        // this query returns stats on trains and their platform they are departing from.
        // SELECT Count(id), gleisist, zugklasse FROM k42174_bahnapi.zuege where evanr= 8000191 group by gleisist, zugklasse limit 1000
        // get this data to c3js and show as stacked bar chart for each platform, like ICE green, RB red, ....
        
        $trains = DB::connection('mysql2')->select("SELECT * FROM k42174_bahnapi.zuege where evanr= :evanr and zugklasse= :zugklasse AND zugnummer= :nummer LIMIT 250", ['evanr' => $evanr, 'zugklasse' => $zugklasse, 'nummer' => $zugnummer]);
        $trainformatted = array();
        foreach ($trains as $train) {
            if($train->zugstatus == 'n') {
                $trainformatted['delay1'][] = $this->calc_diff($train->arzeitsoll, $train->arzeitist);
                $trainformatted['delay2'][] = $this->calc_diff($train->dpzeitsoll, $train->dpzeitist);
            } else {
                $trainformatted['delay1'][] = NULL;
                $trainformatted['delay2'][] = NULL;
            }
            
        }
        
        return $trainformatted;
    }
        
    private function generate_delay_statistic_overall($zugklasse, $zugnummer) 
    {
        // this query returns stats on trains and their platform they are departing from.
        // SELECT Count(id), gleisist, zugklasse FROM k42174_bahnapi.zuege where evanr= 8000191 group by gleisist, zugklasse limit 1000
        // get this data to c3js and show as stacked bar chart for each platform, like ICE green, RB red, ....
        
        $trains = DB::connection('mysql2')->select("SELECT datum, evanr, arzeitsoll, arzeitist, dpzeitsoll, dpzeitist, zugstatus, NAME FROM zuege,haltestellen2 where zuege.evanr=haltestellen2.EVA_NR AND zugklasse= :zugklasse and zugnummer= :zugnummer and datum > (SELECT CURRENT_DATE - INTERVAL 14 DAY) ORDER BY id desc", ['zugklasse' => $zugklasse, 'zugnummer' => $zugnummer]);
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
    
    public function getTrainclassPerPlatformStatistic($evanr) 
    {
     $stats = Cache::remember('getTrainclassPerPlatformStatistic'.$evanr, 240, function() use ($evanr){
       $statsraw = DB::connection('mysql2')->select("SELECT Count(id) as anzahl, gleisist, zugklasse FROM k42174_bahnapi.zuege where evanr= :evanr group by gleisist, zugklasse limit 10000", ['evanr' => $evanr]);
       $stats = array();
       $savelastgleis = "";
       $savelastzugklasse = "";
       foreach ($statsraw as $zuginfo)
       {
         if ($zuginfo->gleisist == NULL) {
          $zuginfo->gleisist = 'keine Angabe';   
         }
         $stats[] = array("name"=>$zuginfo->gleisist,$zuginfo->zugklasse=>$zuginfo->anzahl);
         $savelastgleis = $zuginfo->gleisist;
         $savelastzugklasse = $zuginfo->zugklasse;
       }            
       return Response::json($stats);     
     });
     return $stats;
    }

    public function getTrainStatisticForStation($id, $type, $number)
    {
       
        $stats = Cache::remember('getTrainStatisticForStation'.$id.'-'. $type.'-' . $number, 60, function() use ($id, $type, $number){             
            $trainformatted = $this->generate_delay_statistic($id, $type, $number);
            
            return Response::json($trainformatted);
        });
        return $stats;
    }


}
