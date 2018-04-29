<?php 
namespace App\Http\Controllers;

error_reporting(E_ALL ^ E_NOTICE);
use Yajra\DataTables\DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class YuuController extends Controller
{

    public $title ;
    public $table ;
    public $accessRole ;
    public $jsClass ;
    public $request ;
    public $action_btn = false;
    public $action_btn_add = false;
    public $action_btn_edit = false;
    public $action_btn_delete = false;
    public $selectsql = [] ;
    private $startTime;
    protected $hiddenReq = [
        'password','password_confirm','columns'
    ];
    protected $hidden = [
        'password', 'remember_token','desc','status','success',
    ];

    public function yuuInit(Request $request)
    {
        $this->request = $request->all();
        $this->startTime = microtime(true);
    }

    public function apiLog($nameLog = "generalLog", $paramSave = "",$custom = 'api') {
        if ($custom == "api") {
            foreach ($this->hiddenReq as $key => $value) {
                if (isset($this->request[$value])) {
                    unset($this->request[$value]);
                }
            }
            // foreach ($this->hidden as $key => $value) {
            //     if (isset($paramSave[$value])) {
            //         unset($paramSave[$value]);
            //     }
            // }

            $fileContents = [
                                "timeProcces" => microtime(true)-$this->startTime,
                                "time" => time(),
                                "request" => $this->request,
                                // "requestPath" => $this->request->path(),
                                $paramSave,
                            ];
        } else {
            $fileContents = [
                                "time" => time(),
                                "datas" => $paramSave,
                            ];
        }
        // Storage::append('log/'.date("Y")."/".date("m")."/".date("d")."/".$nameLog."_".date("Ymd"), date("Y-m-d H:i:s")."\t".json_encode($fileContents));
        Storage::append('log/'.date("Y")."/".date("m")."/".date("d")."/".$nameLog."v3_".date("Ymd"), date("Y-m-d H:i:s")."\t".$this->parsing_arr($fileContents));
        return true;
    }

    public function parsing_arr($arr, $keySalt = "") {
        $string = "";

        $keySalt = ($keySalt == "0_" ? "" : $keySalt);
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $string .= $this->parsing_arr($value , $keySalt.$key."_");
            } else {
                if (!in_array($key, $this->hidden)) {
                    $string .= $keySalt.$key."=".urlencode($value)."\t"; 
                }
            }
        }
        return $string;
    }

    public function yuuView($view = 'vendor.yuu.list') {
        $col = $this::columndt();
        $title = $this->title;
        $label = $this->label;
        $APIUrl = $this->APIUrl;
        $jsClass = $this->jsClass;
        $action_btn_add = $this->action_btn_add;
        $formsAdd = $this->formHtml($this->form);
        $formsEdit = $this->formHtml($this->formEdit,'editMain');
        return view($view,compact('title','jsClass','col','label','APIUrl','formsAdd','formsEdit' ,'action_btn_add'));
    }
    public function formCreateValidation($form = "") {
        if (empty($form)) {
            $form = $this->form;
        }
        $validation = [];
        foreach ($form as $key => $f) {
           $validation[$f['name']] = $f['validation'];
        }

        return $validation;
    }
    public function formPasing($form = "") {
        if (empty($form)) {
            $form = $this->form;
        }
        $parseArr = [];
        foreach ($form as $key => $f) {
           $parseArr[$f['name']] = $f;
        }

        return $parseArr;
    }

    public function formHtml($forms,$customC='')
    {
        $htm = '';
        foreach ($forms as $key => $f) {
            $atrib = '';
            if (!empty($f['atrib'])) {
                foreach ($f['atrib'] as $key => $value) {
                    $atrib .= $key.'="'.$value.'" ';
                }
            }

            $htm .='<div class="form-group">';
            $htm .='    <label for='.$f["name"].' class="col-sm-2 control-label">'.$f["label"].'</label>';
            $htm .='    <div class="col-sm-10">';
            if (in_array($f["type"], ['text','email','number','password'])) {
                $htm .='        <input type="'.$f["type"].'" name="'.$customC.$f["name"].'" id="'.$customC.$f["name"].'" class="form-control '.$customC.'" '.$atrib.' value=""/>';
            } elseif ($f['type'] == "select") {
                if (!empty($f['option_from'])) {
                    $dbOption = DB::table($f['option_from']['table'])->get();
                    $dbOption = json_decode(json_encode($dbOption),true);
                    foreach ($dbOption as $key => $value) {
                        $f['option'][$value[$f['option_from']['key']]] = $value[$f['option_from']['label']];
                    }
                }
                $htm .='        <select name="'.$customC.$f["name"].'" id="'.$customC.$f["name"].'" class="form-control '.$customC.'">';
                $option = $f['option'] ?? [];              
                foreach ($option as $key => $o) {
                    $htm .='        <option value="'.$key.'">'.$o.'</option>';
                }
                $htm .='        </select>';
            }
            $htm .='    </div>';
            $htm .='</div>';
        }


        return $htm;
    }
    public function datatables()
    {
        $this->selectsql = [];
        foreach ($this->col as $key => $value) {
            if (isset($value['dbcustom']) && $value['dbcustom'] === true) {
            } else {
                $this->selectsql[] = $this->table.".".$value['name'];
            }
        }

        $tb = DB::table($this->table)
            ->select($this->selectsql);
        $dtbs = Datatables::of($tb);
        if ($this->action_btn) {
            $dtbs->addColumn('action', function ($table) {
                    $actionHtml = "";
                    if ($this->action_btn_edit && checkAccess($this->accessRole,'updateAcc')) {
                        $actionHtml .= '<a class="btn btn-xs btn-primary" title="edit-data" onclick="'.$this->jsClass.'.editModal('.$table->id.')"><i class="glyphicon glyphicon-edit"></i> </a> ';
                    }
                    if ($this->action_btn_delete && checkAccess($this->accessRole,'deleteAcc')) {
                        $actionHtml .= '<a class="btn btn-xs btn-danger" title="delete-data" onclick="'.$this->jsClass.'.deleteModal('.$table->id.')"><i class="glyphicon glyphicon-remove"></i> </a> ';
                    }
                        return empty($actionHtml) ? "No action" : $actionHtml;
                    });
        }
        return $dtbs;
    }

    public function columndt()
    {
        $table = [];
        foreach ($this->col as $key => $value) {
            if (!empty($value['label']) && !empty($value['name'])) {
                $table[] = $value;
            }
        }
        return $table;
    }

    public function backUp($uID,$action='update')
    {
        $backUp = DB::table($this->table)->where('id', $uID)->first();
        $backUp = json_decode(json_encode($backUp),true);
        $this->apiLog('backup_'.$action.'_'.$this->table,$backUp);
    }
    public function createAPI(Request $request)
    {
        $arrValidator = $this->formCreateValidation();
        $validator = Validator::make($request->all(), $arrValidator);
        if ($validator->passes()) {
            $paramInsert = [];
            foreach ($this->form as $key => $value) {
                if (isset($value['dbcustom']) && $value['dbcustom'] === true) {

                } else {
                    $paramInsert[$value['name']] = $request->input($value['name']);
                }
            }
            // foreach ($arrValidator as $key => $f) {
            //     $paramInsert[$key] = $request->input($key);
            // }

            $resultID = DB::table($this->table)->insertGetId($paramInsert);

            $result = [
                            'status'=>'success',
                            'statusCode'=>'201',
                            'desc'=>'success insert data',
                            'lastID'=> $resultID,
                            'success'=>'Added new records.'
                        ];
        } else {
            $result = [
                            'status'=>'validate',
                            'statusCode'=> 501,
                            'desc'=>'Validate',
                            'error'=> $validator->errors()->all()
                        ];
        }

        $this->apiLog('api_create_'.$this->table,$result);        
        return response()->json($result);

    }
    public function getAPI($uID,$form = "")
    {
        if (empty($form)) {
            $form = $this->form;
        }
        // $form = $form ?? $this->form;              
        // echo print_r($form);die();
        $this->selectsql = [];
        foreach ($form as $key => $value) {
            if (isset($value['dbcustom']) && $value['dbcustom'] === true) {
            } elseif (isset($value['unset']) && $value['unset'] === true) {
            } else {
                $this->selectsql[] = $this->table.".".$value['name'];
            }
        }

        $datas = DB::table($this->table)->select($this->selectsql)->where('id', $uID)->first();

        $this->apiLog('api_get_'.$this->table,$uID);
        return response()->json([
                                    'status'=>'success',
                                    'statusCode'=>'202',
                                    'data'=> $datas,
                                    'desc'=>'exists',
                                ]);
    }
    public function updateAPI(Request $request, $uID, $form)
    {
        $pars = array();
        foreach ($request->all() as $key => $value) {
            $pars[str_replace("editMain", "", $key)] = $value;
        }
        $arrValidator = $this->formCreateValidation($form);
        $validator = Validator::make($pars, $arrValidator);

        if ($validator->passes()) {
            $paramUpdate = [];
            foreach ($arrValidator as $key => $f) {
                $paramUpdate[$key] = $pars[$key];
            }
            $this->backUp($uID,'update');


            if ($hook_before_edit_api = $this->hook_before_edit_api($paramUpdate ,$request->all())) {
                return $hook_before_edit_api;
            }
            DB::table($this->table)->where('id', $uID)
                    ->update($paramUpdate);

            if ($hook_after_edit = $this->hook_after_edit($request->all() ,$uID)) {
                return $hook_after_edit;
            }

            $result = [
                            'status'=>'success',
                            'statusCode'=>'202',
                            'desc'=>'success update data',
                            'success'=>'Added new records.'
                        ];
        } else {
            $result = [
                            'status'=>'validate',
                            'statusCode'=>'501',
                            'desc'=>'Validate',
                            'error' => $validator->errors()->all()
                        ];
        }
        // $this->log->apiLog('api_get_groups',$result);
        return response()->json($result);
    }
    public function deleteAPI($uID)
    {
        if ($hook_before_delete = $this->hook_before_delete($uID)) {
            return $hook_before_delete;
        }

        DB::table($this->table)->where('id', $uID)
            ->delete();

        if ($hook_after_delete = $this->hook_after_delete($uID)) {
            return $hook_after_delete;
        }
        
        return response()->json([
                                        'status'=>'delete',
                                        'statusCode'=>'204',
                                        'desc'=>'success delete data'
                                    ]);
    }
    public function hook_query_index(&$query)
    {
    }

    public function hook_row_index($index, &$value)
    {
    }

    public function hook_before_add(&$arr)
    {
    }

    public function hook_after_add($id)
    {
    }

    public function hook_before_edit(&$arr, $id)
    {
    }
    public function hook_before_edit_api(&$arr, $req)
    {
    }

    public function hook_after_edit($arr,$id)
    {
    }

    public function hook_before_delete($id)
    {
    }

    public function hook_after_delete($id)
    {
    }
}