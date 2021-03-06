<?php

namespace App\Http\Controllers;

use App\Users;
use App\Groups;
use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // use RegistersUsers;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->log = new \App\library\logging;
        $this->log->request = $request->all();


        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label"=>"Name","name"=>"name");
        $this->col[] = array("label"=>"Email","name"=>"email");
        $this->col[] = array("label"=>"Groups","name"=>"group_name");
        $this->col[] = array("label"=>"Status","name"=>"active");
        $this->col[] = array("label"=>"Action","name"=>"action");
        # END COLUMNS DO NOT REMOVE THIS LINE

    }
    public function index()
    {
        // echo "string";
        $this->data['groups'] = Groups::all();
        $this->data['col'] = $this->col;
        return view('user.list', $this->data);
    }
    
    public function editProfile()
    {
        // echo "string";
        // $user = Users::where('id', Auth::user()->id)->first();
        // echo print_r($user);
        return view('user.editProfile',compact('user'));
    }
    
    public function getIndex()
    {
        return view('datatables.index');
    }
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $users = DB::table('users')
            ->select(['users.name', 'users.id', 'users.email', 'users.group_id', 'users.created_at',
                'users.updated_at', 'users.active']);
        
        $this->log->apiLog('api_list_user');
        return Datatables::of($users)
            ->addColumn('action', function ($users) {
                    $actionHtml = "";
                    if (checkAccess('users','updateAcc')) {
                        $actionHtml .= '<a class="btn btn-xs btn-primary" onclick="users_list.editModal('.$users->id.')"><i class="glyphicon glyphicon-edit"></i> Edit</a> ';
                    }
                    if (checkAccess('users','deleteAcc')) {
                        $actionHtml .= '<a class="btn btn-xs btn-danger" onclick="users_list.deleteModal('.$users->id.')"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
                    }

                    return empty($actionHtml) ? "No action" : $actionHtml;
                })
            ->addColumn('group_name', function ($users) {
                    $groups = DB::table('groups')->where('id', $users->group_id)->first();
                    if (!empty($groups)) {
                        return '<a ><span class="label" style="background:'.str_replace("-light", "", $groups->bgcolor).';">'.$groups->name.'</span></a>';
                    } else {
                        return '<a ><span class="label" style="background:grey;"> Not Set</span></a>';
                    }
                })
            ->addColumn('num', function ($users) {
                    return 1;
                })
            ->editColumn('active', function ($users) {
                $checked =  ($users->active) ? "checked" : "";
                $checkedHtml =  ($users->active) ? "Active" : "Inactive";
                $activeHTML = '<a onclick="users_list.changeStatus('.$users->id.')"><input type="checkbox" '.$checked.' class="btnC" id="check'.$users->id.'"></a>';

                return checkAccess('users','editAcc') ? $activeHTML : $checkedHtml;
                })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|same:password_confirm',
            'sex' => 'required|string|max:2',
            'password_confirm' => 'required|string|min:6|',
        ]);

        if ($validator->passes()) {
            // $result =  Users::create([
            //     'name' => $request->input('name'),
            //     'email' => $request->input('email'),
            //     'password' => bcrypt($request->input('password')),
            //     'group_id' =>  config('adminlte.default_group'),
            // ]);
            $resultID = Users::insertGetId(
                array(  
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'sex' => $request->input('sex'),
                    'password' => bcrypt($request->input('password')),
                    'group_id' =>  config('adminlte.default_group'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                    )
            );
            // echo json_encode($request->input('name'));
            // echo json_encode($resultID);
            $result = [
                        'status'=>'success',
                        'statusCode'=>'201',
                        'desc'=>'success insert data',
                        'lastID'=> $resultID,
                        'success'=>'Added new records.'
                    ];
            $this->log->apiLog('api_create_user',$result);
            return response()->json($result);
        } else {
            $valid = [
                        'status' => "validate",
                        'statusCode' => 501,
                        "desc" => "Validate",
                        "error" => $validator->errors()->all(),
                    ];
            // $valid['status'] = "validate";
            // $valid['statusCode'] = 501;
            // $valid["desc"] = "Validate";
            // $valid["error"] = $validator->errors()->all();
            $this->log->apiLog('api_create_user',$valid);
            return response()->json($valid);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function active($uID , $active)
    {
        //
        // $active = $active == "true" ? 1 : 0 ;
        Users::where('id', $uID)
            ->update(['active' => $active]);

         return response()->json([
                                    'status'=>'success',
                                    'statusCode'=>'202',
                                    'active'=> $active,
                                    'desc'=>'success update data',
                                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function get($uID)
    {
        $user = Users::where('id', $uID)->first();
        // $user = Users::findOrFail($uID);
                    // ->where('id', $uID)->first();

       return response()->json([
                                    'status'=>'success',
                                    'statusCode'=>'202',
                                    'data'=> $user,
                                    'desc'=>'exists',
                                ]);
    }

    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uID)
    {
        $pars = array();
        foreach ($request->all() as $key => $value) {
            $pars[str_replace("editUser_", "", $key)] = $value;
        }
        $valid = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'sex' => 'required|string|max:2',
            'phone' => 'required|numeric',
        ];

        if (!empty($pars['group_id'])) {
            $valid['group_id'] = 'required|integer';
        }
        if (!empty($pars['password'])) {
            $valid['password'] = 'required|string|min:6|same:password_confirm';
            $valid['password_confirm'] = 'required|string|min:6|';
        }
        // echo json_encode($pars);
        $validator = Validator::make($pars, $valid);

        if ($validator->passes()) {
            $backUp = Users::where('id', $uID)->first()->toArray();
            $arrUpdate = [
                                'name' => $pars['name'],
                                'email' => $pars['email'],
                                'sex' => $pars['sex'],
                                'phone' => $pars['phone'],
                            ];
            if (!empty($pars['group_id'])) {
                $arrUpdate['group_id'] = $pars['group_id'];
            }
            if (!empty($pars['password'])) {
                $arrUpdate['password'] = bcrypt($pars['password']);
            }
            Users::where('id', $uID)
                    ->update($arrUpdate);

            $result = [
                        'status'=>'success',
                        'statusCode'=>'202',
                        'desc'=>'success update data',
                        'uID'=>$uID,
                        'success'=>'Added new records.'
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

        $this->log->apiLog('api_update_user',compact('result','backUp'));
        return response()->json($result);
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
            $backUp = Users::where('id', $uID)->first()->toArray();
            $arrUpdate = [
                                'phone' => $pars['phone'],
                            ];

            if (!empty($pars['password'])) {
                $arrUpdate['password'] = bcrypt($pars['password']);
            }
            Users::where('id', $uID)
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

        $this->log->apiLog('api_update_user',compact('result' , 'backUp'));
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
        // echo Auth::user()->id;
        if (Auth::user()->id == $uID) {
            $this->log->apiLog('api_delete_users',['uID'=>$uID]);
            return response()->json([
                                            'status'=>'delete',
                                            'statusCode'=>'504',
                                            'desc'=>"can't delete your use group"
                                        ]);
        }
        $backUp = Users::where('id', $uID)->first()->toArray();
        Users::where('id', $uID)
            ->delete();
        // $this->log->apiLog('backup_delete_users',$backUp,'backup');
        $this->log->apiLog('api_delete_users',compact('uID','backUp'));
        return response()->json([
                                        'status'=>'delete',
                                        'statusCode'=>'204',
                                        'desc'=>'success delete data'
                                    ]);
    }
}
