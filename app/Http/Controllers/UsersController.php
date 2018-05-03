<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends YuuController
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

        $this->table = "users";
        $this->accessRole = "users";
        $this->label = "Users";
        $this->title = "Users Managementss";
        $this->jsClass = "users_list";
        $this->APIUrl = "user";
        $this->action_btn = true;
        $this->action_btn_add = true;
        $this->action_btn_edit = true;
        $this->btn_import = true;
        $this->btn_export = true;
        $this->action_btn_delete = true;

        # START COLUMNS DO NOT REMOVE THIS LINE
        #datatables config
        $this->col = array();
        $this->col[] = array("label"=>"Name","name"=>"name");
        $this->col[] = array("label"=>"Email","name"=>"email");
        $this->col[] = array("label"=>"Groups","name"=>"group_name","dbcustom"=>true);
        $this->col[] = array("label"=>"Status","name"=>"active");
        $this->col[] = array("label"=>"Action","name"=>"action","dbcustom"=>true);
        $this->col[] = array("name" =>"id");
        $this->col[] = array("name" =>"group_id");
        # END COLUMNS DO NOT REMOVE THIS LINE


        # START FORM DO NOT REMOVE THIS LINE

            $this->form = [];
            $this->form[] = ['label'=>'Username','name'=>'name','type'=>'text','validation'=>'required|min:1|max:255'];
            $this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|string|email|max:255|unique:users'];
            $this->form[] = ['label'=>'Phone','name'=>'phone','type'=>'number','atrib'=>['pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$'],'validation'=>'required|min:1|max:255'];
            $this->form[] = ['label'=>'Gender','name'=>'sex','type'=>'select','option'=>['l' => 'Male','p'=> 'Female'],'validation'=>'required|string|max:2'];
            $this->form[] = ['label'=>'Password','name'=>'password','type'=>'password','validation'=>'required|string|min:6|same:password_confirm',"unset" => true];
            $this->form[] = ['label'=>'Password confirm','name'=>'password_confirm','type'=>'password','validation'=>'required|string|min:6',"dbcustom"=>true];
            // $this->form[] = ['name'=>'id','type'=>'hiden','validation'=>''];
            // $this->form[] = ['name'=>'group_id','type'=>'hiden','validation'=>''];

            $this->formEdit = [];
            $this->formEdit[] = ['name'=>'id','type'=>'hidden','validation'=>'required'];
            $this->formEdit[] = ['label'=>'Username','name'=>'name','type'=>'text','validation'=>'required|min:1|max:255'];
            $this->formEdit[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|string|email|max:255'];
            $this->formEdit[] = ['label'=>'Phone','name'=>'phone','type'=>'number','atrib'=>['pattern' => '^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$'],'validation'=>'required|min:1|max:255'];
            $this->formEdit[] = ['label'=>'Gender','name'=>'sex','type'=>'select','option'=>['l' => 'Male','p'=> 'Female'],'validation'=>'required|string|max:2'];
            $this->formEdit[] = ['label'=>'Member of Group','name'=>'group_id','type'=>'select','option_from'=>['table'=>'groups','key' => 'id' ,'label' => 'name'],'validation'=>'required|string|max:2'];

        # END FORM DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
            $this->hiddenField = ['password','remember_token','last_login'];
            $this->importArr = [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
                'last_login',
                'phone',
                'active'
            ];
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
        return $this->yuuView('user.listCustom');
        // $col = $this->columndt();
        // $title = $this->title;
        // $label = $this->label;
        // $APIUrl = $this->APIUrl;
        // $jsClass = $this->jsClass;
        // $action_btn_add = $this->action_btn_add;
        // $formsAdd = $this->formHtml($this->form);
        // $formsEdit = $this->formHtml($this->formEdit,'editMain');
        // return view('vendor.yuu.list',compact('title','jsClass','col','label','APIUrl','formsAdd','formsEdit' ,'action_btn_add'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $datatables = $this->datatables();
        $datatables->addColumn('group_name', function ($table) {
            $groups = DB::table('groups')->where('id', $table->group_id)->first();
            if (!empty($groups)) {
                return '<a ><span class="label" style="background:'.str_replace("-light", "", $groups->bgcolor).';">'.$groups->name.'</span></a>';
            } else {
                return '<a ><span class="label" style="background:grey;"> Not Set</span></a>';
            }
        });
        $datatables->editColumn('active', function ($users) {
                $checked =  ($users->active) ? "checked" : "";
                $checkedHtml =  ($users->active) ? "Active" : "Inactive";
                $activeHTML = '<a onclick="users_list.changeStatus('.$users->id.')"><input type="checkbox" '.$checked.' class="btnC" id="check'.$users->id.'"></a>';

                return checkAccess('users','editAcc') ? $activeHTML : $checkedHtml;
                });
        $datatables->escapeColumns([]);
        #custome datatable yajra in here        
        return $datatables->make(true);
    }
    public function export(Request $request)
    {
        $this->selectsql = array_keys($request->input('exportField'));
        return $this->downloadExcel();
    }
    public function import(Request $request)
    {
        $this->selectsql = ['id','name','email','phone'];
        return $this->importExcel($request);
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
     
    public function hook_before_add_api(&$arrUpdate) {
        if (!empty($arrUpdate['password'])) {
            $arrUpdate['password'] = bcrypt($arrUpdate['password']);    
        } else {
            $arrUpdate['password'] = bcrypt("password");    
        }
        if (empty($arrUpdate['created_at'])) {
            $arrUpdate['created_at'] = new \DateTime();
        }
        if (empty($arrUpdate['updated_at'])) {
            $arrUpdate['updated_at'] = new \DateTime();
        }
    }
    public function hook_before_edit_api(&$arrUpdate ,$request ) {
         if (!empty($request['editMainpassword'])) {
            $pars['password'] = $request['editMainpassword'];
            $pars['password_confirm'] = $request['editMainpassword_confirm'];

            $valid['password'] = 'required|string|min:6|same:password_confirm';
            $valid['password_confirm'] = 'required|string|min:6|';
            $validator = Validator::make($pars, $valid);

            if ($validator->passes()) {
                $arrUpdate['password'] = bcrypt($pars['password']);

            } else {;
                $result = [
                            'status'=>'validate',
                            'statusCode'=>'501',
                            'desc'=>'Validate',
                            'uID'=>$uID,
                            'error' => $validator->errors()->all()
                          ];
                return response()->json($result);
            }
        }
    }

    public function editProfile()
    {

        return view('user.editProfile',compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $uID = Auth::user()->id;
        $pars = array();
        foreach ($request->all() as $key => $value) {
            $pars[str_replace("editUser_", "", $key)] = $value;
        }
        $valid = [
            'phone' => 'required|numeric',
        ];

        if (!empty($pars['password'])) {
            $valid['password'] = 'required|string|min:6|same:password_confirm';
            $valid['password_confirm'] = 'required|string|min:6|';
        }
        // echo json_encode($pars);
        $validator = Validator::make($pars, $valid);

        if ($validator->passes()) {
            $this->backUp($uID,'update');
            $arrUpdate = [
                                'phone' => $pars['phone'],
                            ];

            if (!empty($pars['password'])) {
                $arrUpdate['password'] = bcrypt($pars['password']);
            }
            DB::table($this->table)->where('id', $uID)
                    ->update($arrUpdate);

            $result = [
                        'status'=>'success',
                        'statusCode'=>'202',
                        'desc'=>'success update data',
                        'uID'=>$uID,
                      ];

            // $this->log->apiLog('backup_update_users',$backUp,'backup');
        } else {;
            $result = [
                        'status'=>'validate',
                        'statusCode'=>'501',
                        'desc'=>'Validate',
                        'uID'=>$uID,
                        'error' => $validator->errors()->all()
                      ];
        }
        return response()->json($result);
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


    public function active($uID , $active)
    {
        //
        // $active = $active == "true" ? 1 : 0 ;
        DB::table($this->table)->where('id', $uID)
            ->update(['active' => $active]);

         return response()->json([
                                    'status'=>'success',
                                    'statusCode'=>'202',
                                    'active'=> $active,
                                    'desc'=>'success update data',
                                ]);
    }


    public function hook_before_delete($uID) {
        if (Auth::user()->id == $uID) {
            $this->apiLog('api_delete_group',['uID'=>$uID]);
            return response()->json([
                                            'status'=>'delete',
                                            'statusCode'=>'504',
                                            'desc'=>"can't delete your use id"
                                        ]);
        }
    }

}
