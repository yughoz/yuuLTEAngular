<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DummyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $data = [];
    public function __construct()
    {
        $this->yuuLTElib = new \App\library\yuuLTElib;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dummy0()
    {
        $data['header'] = "DUMMMY!11";
        return view('dummy.dummy2',$data);
    }
    public function dummy1()
    {
        $data['header'] = "DUMMMY!11";
        return view('dummy.dummy1',$data);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dummy2()
    {
        $data['header'] = "DUMMMY!22";
        return view('dummy.dummy2',$data);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dummy3()
    {
        $var1 = $this->yuuLTElib->test("function");
        echo "hello ".$var1;
    }
}
