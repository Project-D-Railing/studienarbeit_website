<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ToplistController extends Controller
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
        $users = User::all();
        // useless comment in old controller to test autodeploy.
        return view('toplist', compact('users'));
    }
}
