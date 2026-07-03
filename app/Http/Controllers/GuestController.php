<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {

        return view('welcome');
    }
}
