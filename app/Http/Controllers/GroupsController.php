<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class GroupsController extends YuuController
{

    /*
    *change "**$Var**" to example : $varUsers
    *change **TBLNAME** to example : Users
    *change **tblname** to example : users
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');


        $this->table = "groups";
        $this->accessRole = "groups";
        $this->label = "Groups";
        $this->title = "Groups Managementss";
        $this->jsClass = "groups_list";
        $this->APIUrl = "Groups";
        $this->action_btn = true;
        $this->action_btn_add = true;
        $this->action_btn_edit = true;
        $this->action_btn_delete = true;

        # START COLUMNS DO NOT REMOVE THIS LINE
        #datatables config
        $this->col = array();
        $this->col[] = array("label"=>"Name","name"=>"name");
        $this->col[] = array("label"=>"Descrition","name"=>"description");
        $this->col[] = array("label"=>"Color","name"=>"bgcolor");
        $this->col[] = array("label"=>"Action","name"=>"action","dbcustom"=>true);
        $this->col[] = array("name" =>"id");
        # END COLUMNS DO NOT REMOVE THIS LINE


        # START FORM DO NOT REMOVE THIS LINE
            $this->form = [];
            $this->form[] = ['label'=>'Name','name'=>'name','type'=>'text','validation'=>'required|min:1|max:255'];
            $this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','validation'=>'required|min:1|max:255'];
            $this->form[] = ['label'=>'Color','name'=>'bgcolor','type'=>'select','option'=>['blue' => 'Blue','black' => 'Black','purple' => 'Purple','yellow' => 'Yellow','red' => 'Red','green' => 'Green','blue-ligh' => 'Blue-Light','black-light' => 'Black-Light','purple-light' => 'Purple-Light','yellow-light' => 'Yellow-Light','red-light' => 'Red-Light','green-light' => 'Green-Light'],'validation'=>'required|min:1|max:255'];
            $this->formEdit = $this->form;
            $this->formEdit[] = ['name'=>'id','type'=>'hidden','validation'=>'required'];

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
     * @param  \App\Groups  
     * @return \Illuminate\Http\Response
     */
    public function get($uID)
    {
        return $this->getAPI($uID,$this->formEdit);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Groups  $groups
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


    public function hook_before_delete($uID) {
        if (Auth::user()->group_id == $uID) {
            $this->apiLog('api_delete_group',['uID'=>$uID]);
            return response()->json([
                                            'status'=>'delete',
                                            'statusCode'=>'504',
                                            'desc'=>"can't delete your use id"
                                        ]);
        }
    }

    public function hook_after_delete($uID) {
        DB::table('group_access')
        ->where('group_id', $uID)
            ->delete();
    }
}
