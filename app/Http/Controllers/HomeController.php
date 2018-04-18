<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Groups;
use App\Users;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $data = [];
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
        $groupCount = Groups::count();
        $userCount = Users::count();
        // return view('home.home',compact('groupCount','userCount'));
        return view('home',compact('groupCount','userCount'));
    }
    public function dashboard()
    {
        $groupCount = Groups::count();
        $userCount = Users::count();
        return view('home.home',compact('groupCount','userCount'));
        // return view('home',compact('groupCount','userCount'));
    }
}
