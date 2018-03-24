<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $haltestellen = DB::select("select *,REPLACE(BREITE, ',', '.') AS BREITEDOT,REPLACE(LAENGE, ',', '.') AS LAENGEDOT from haltestellen2");

        return view('map', ['haltestellen' => $haltestellen]);

    }
}