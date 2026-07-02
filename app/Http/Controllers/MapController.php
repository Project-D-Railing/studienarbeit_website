<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
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
     * @return Response
     */
    public function index()
    {
        $haltestellen = DB::connection('mysql2')->select("select *,REPLACE(BREITE, ',', '.') AS BREITEDOT,REPLACE(LAENGE, ',', '.') AS LAENGEDOT from haltestellen2 where BREITE IS NOT NULL and LAENGE IS NOT NULL");

        return view('map', ['haltestellen' => $haltestellen]);

    }
}
