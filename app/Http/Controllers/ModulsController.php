<?php

namespace App\Http\Controllers;

use App\Moduls;
use App\Groups;
use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\DataTables\DataTables;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ModulsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // use RegistersModuls;
    
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

        $this->table = "users";

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = ["label" => "Name", "name" => "name"];
        $this->col[] = ["label" => "Table", "name" => "table_name"];
        $this->col[] = ["label" => "Path", "name" => "path"];
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
    
    public function getStep1()
    {
        // echo "string";compact("tables_list", "fontawesome", "row", "id"));
        $this->data['groups'] = Groups::all();
        $this->data['col'] = $this->col;
        $tables = $this->listTables();
        $tables_list = [];
        $this->data['tables_list'] = [];
        $this->data['fontawesome'] = [
            "glass",
            "music",
            "search",
            "envelope-o",
            "heart"];
        foreach ($tables as $tab) {
            foreach ($tab as $key => $value) {
                $label = $value;

                if (substr($label, 0, 4) == 'cms_' && $label != config('crudbooster.USER_TABLE')) {
                    continue;
                }
                if ($label == 'migrations') {
                    continue;
                }

                $this->data['tables_list'][] = $value;
            }
        }
        return view('module.list', $this->data);
    }

    public function getCheckSlug($slug)
    {
        $check = DB::table('cms_moduls')->where('path', $slug)->count();
        $lastId = DB::table('cms_moduls')->max('id') + 1;

        return response()->json(['total' => $check, 'lastid' => $lastId]);
    }

    public function postStep2()
    {

        $name = Request::get('name');
        $table_name = Request::get('table');
        $icon = Request::get('icon');
        $path = Request::get('path');

            /*if (DB::table('cms_moduls')->where('path', $path)->where('deleted_at', null)->count()) {
                // return redirect()->back()->with(['message' => 'Sorry the slug has already exists, please choose another !', 'message_type' => 'warning']);
                $result = [
                            'status'=>'failed',
                            'statusCode'=> 501,
                            'desc'=>'Sorry the slug has already exists, please choose another !'
                        ];
                return response()->json($result);
            }

            $created_at = now();
            $id = DB::table($this->table)->max('id') + 1;

            $controller = CRUDBooster::generateController($table_name, $path);
            DB::table($this->table)->insert(compact("controller", "name", "table_name", "icon", "path", "created_at", "id"));

            //Insert Menu
            if ($controller && Request::get('create_menu')) {
                $parent_menu_sort = DB::table('cms_menus')->where('parent_id', 0)->max('sorting') + 1;

                $id_cms_menus = DB::table('cms_menus')->insertGetId([

                    'created_at' => date('Y-m-d H:i:s'),
                    'name' => $name,
                    'icon' => $icon,
                    'path' => $controller.'GetIndex',
                    'type' => 'Route',
                    'is_active' => 1,
                    'id_cms_privileges' => CRUDBooster::myPrivilegeId(),
                    'sorting' => $parent_menu_sort,
                    'parent_id' => 0,
                ]);
                DB::table('cms_menus_privileges')->insert(['id_cms_menus' => $id_cms_menus, 'id_cms_privileges' => CRUDBooster::myPrivilegeId()]);
            }*/

           /* $user_id_privileges = CRUDBooster::myPrivilegeId();
            DB::table('cms_privileges_roles')->insert([
                'id' => DB::table('cms_privileges_roles')->max('id') + 1,
                'id_cms_moduls' => $id,
                'id_cms_privileges' => $user_id_privileges,
                'is_visible' => 1,
                'is_create' => 1,
                'is_read' => 1,
                'is_edit' => 1,
                'is_delete' => 1,
            ]);*/

            //Refresh Session Roles
            /*$roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', CRUDBooster::myPrivilegeId())->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();
            Session::put('admin_privileges_roles', $roles)*/;

            $result = [
                            'status'=>'success',
                            'statusCode'=>'201',
                            'desc'=>'success insert data',
                            'lastID'=> $id,
                            'success'=>'Added new records.'
                        ];
            return response()->json($result);

    }


    public static function listTables()
    {
        $tables = [];
        // $multiple_db = config('crudbooster.MULTIPLE_DATABASE_MODULE');
        // $multiple_db = ($multiple_db) ? $multiple_db : [];
        $db_database = config('database.connections.mysql.database');

        // if ($multiple_db) {
        //     try {
        //         $multiple_db[] = config('crudbooster.MAIN_DB_DATABASE');
        //         $query_table_schema = implode("','", $multiple_db);
        //         $tables = DB::select("SELECT CONCAT(TABLE_SCHEMA,'.',TABLE_NAME) FROM INFORMATION_SCHEMA.Tables WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA != 'mysql' AND TABLE_SCHEMA != 'performance_schema' AND TABLE_SCHEMA != 'information_schema' AND TABLE_SCHEMA != 'phpmyadmin' AND TABLE_SCHEMA IN ('$query_table_schema')");
        //     } catch (\Exception $e) {
        //         $tables = [];
        //     }
        // } else {
            try {
                $tables = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.Tables WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA = '".$db_database."'");
            } catch (\Exception $e) {
                $tables = [];
            }
        // }

        return $tables;
    }

    
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $users = DB::table($this->table)
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
            // $result =  Moduls::create([
            //     'name' => $request->input('name'),
            //     'email' => $request->input('email'),
            //     'password' => bcrypt($request->input('password')),
            //     'group_id' =>  config('adminlte.default_group'),
            // ]);
            $resultID = Moduls::insertGetId(
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
        Moduls::where('id', $uID)
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
     * @param  \App\Moduls  $users
     * @return \Illuminate\Http\Response
     */
    public function get($uID)
    {
        $user = Moduls::where('id', $uID)->first();
        // $user = Moduls::findOrFail($uID);
                    // ->where('id', $uID)->first();

       return response()->json([
                                    'status'=>'success',
                                    'statusCode'=>'202',
                                    'data'=> $user,
                                    'desc'=>'exists',
                                ]);
    }

    public function show(Moduls $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Moduls  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(Moduls $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Moduls  $users
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
            $backUp = Moduls::where('id', $uID)->first()->toArray();
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
            Moduls::where('id', $uID)
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
            $backUp = Moduls::where('id', $uID)->first()->toArray();
            $arrUpdate = [
                                'phone' => $pars['phone'],
                            ];

            if (!empty($pars['password'])) {
                $arrUpdate['password'] = bcrypt($pars['password']);
            }
            Moduls::where('id', $uID)
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
     * @param  \App\Moduls  $users
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
        $backUp = Moduls::where('id', $uID)->first()->toArray();
        Moduls::where('id', $uID)
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
