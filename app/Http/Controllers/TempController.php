<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class TempController extends YuuController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');


        $this->table = "[CHANGEHERE]";
        $this->accessRole = "[CHANGEHERE]";
        $this->label = "[CHANGEHERE]";
        $this->title = "[CHANGEHERE]";
        $this->jsClass = "[CHANGEHERE]";
        $this->APIUrl = "[CHANGEHERE]";
        $this->action_btn = true;
        $this->action_btn_add = true;
        $this->action_btn_edit = true;
        $this->action_btn_delete = true;

        # START COLUMNS DO NOT REMOVE THIS LINE
        #datatables config
        $this->col = array();
        // $this->col[] = array("label"=>"Name","name"=>"name");#EXAMPLE
        // $this->col[] = array("name" =>"id");
        # END COLUMNS DO NOT REMOVE THIS LINE


        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        // $this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|min:1|max:255'];#EXAMPLE
        $this->formEdit = $this->form;
        # END FORM DO NOT REMOVE THIS LINE

        $this->yuuInit($request);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->yuuView();
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $datatables = $this->datatables();
        #custome datatable yajra in here        
        return $datatables->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $this->createAPI($request);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($uID)
    {
        return $this->getAPI($uID, $this->formEdit);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uID)
    {
        return $this->updateAPI($request,$uID, $this->formEdit);
        
    }
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function delete($uID)
    {
        return $this->deleteAPI($uID);
    }

}
