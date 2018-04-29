<link rel='stylesheet' href='<?php echo asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css")?>'/>
        <style>
            .select2-container--default .select2-selection--single {
                border-radius: 0px !important
            }

            .select2-container .select2-selection--single {
                height: 35px
            }
        </style>
        <script src='<?php echo asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js")?>'></script>
        <script>
            $(function () {
                $('.select2').select2();

            })
            $(function () {
                $('select[name=table]').change(function () {
                    var v = $(this).val().replace(".", "_");
                    $.get("{{ url('CRUDBOOSTER/check-slug') }}/" + v, function (resp) {
                        if (resp.total == 0) {
                            $('input[name=path]').val(v);
                        } else {
                            v = v + resp.lastid;
                            $('input[name=path]').val(v);
                        }
                    })

                })
            })
        </script>
<section class="content-header" ui-view="header">
<h1>@{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">
     <div class="row">
        <div class="col-md-12">
             <div class="box">
                <div class="box-header with-border">
                    @if(checkAccess('modules','createAcc'))
                        <h3 class="box-title"><a  class="btn btn-block btn-primary btn-flat"  data-toggle="modal" data-target="#createModuleModal"><i class="fa fa-plus"></i> Create module</a></h3>
                    @endif
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" id="tblModule">
                        <thead>
                            <tr>
                             @foreach($col as $c)
                                <th>{{$c['label']}}</th>
                            @endforeach
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
         </div>
    </div>

    <!-- Modal -->
    <div id="createModuleModal" class="modal fade" role="dialog" >
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Module</h4>
          </div>
          <div class="modal-body">
                
            <form class="" id="form-create_module">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label for="">Table</label>
                    <select name="table" id="table" required class="select2 form-control" value="">
                        <option value="">{{trans('crudbooster.text_prefix_option')}} Table</option>
                        @foreach($tables_list as $table)
                            <option value="{{$table}}">{{$table}}</option>
                        @endforeach
                    </select>
                    <div class="help-block">
                        Do not use cms_* as prefix on your tables name
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Module Name</label>
                    <input type="text" class="form-control" required name="name" value="">
                </div>

                <div class="form-group">
                    <label for="">Icon</label>
                    <select name="icon" id="icon" required class="select2 form-control">
                        @foreach($fontawesome as $f)
                            <option value="fa fa-{{$f}}">{{$f}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Module Slug</label>
                    <input type="text" class="form-control" required name="path" value="">
                    <div class="help-block">Please alpha numeric only, without space instead _ and or special character</div>
                </div>
            <input checked type='checkbox' name='create_menu' value='1'/> Also create menu for this module <a href='#' title='If you check this, we will create the menu for this module'>(?)</a>
                <div class='pull-right'>
                    <a class='btn btn-default' href='{{url("CRUDBOOSTER/ModulsControllerGetIndex")}}'> {{trans('crudbooster.button_back')}}</a>
                    <input type="submit" class="btn btn-primary" value="Step 2 &raquo;">
                </div>
            </form>
                

          </div>
          <div id="wraperStatus"></div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="reset" class="btn btn-warning btn-flat">Reset</button>
            <button type="submit" class="btn btn-primary" id="btnSave" data-dismiss="modal">Save</button>
          </div>
            </form>
        </div>

      </div>
    </div>

    <!-- Modal -->
    <div id="editModuleModal" class="modal fade" role="dialog" >
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="form-horizontal" id="form-edit_module" >
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Module</h4>
          </div>
          <div class="modal-body">
                
                {!! csrf_field() !!}
                
                
            </div>
          <div class="modal-header" style="padding-top: 30px">
            <h4 class="modal-title">Reset Password</h4>
          </div>
          <div class="modal-body">         
                

          </div>
          <div id="wraperStatus"></div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btnEdit">Save</button>
          </div>
            </form>
        </div>

      </div>
    </div>

    <!-- Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Confirm Delete</h4>
          </div>
          <div class="modal-body">
                <p>Are you sure want to delete this module..?</p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" id="btnDelete">Delete</button>
          </div>
            </form>
        </div>

      </div>
    </div>

</section>

    <script type="text/javascript" language="javascript" > 
        // { data: 'name', name: 'name' },
        // { data: 'email', name: 'email' },
            // <th>{{$c['label']}}</th>
        data = [
            @foreach($col as $c)
                { data: "{{$c['name']}}", name: "{{$c['name']}}" },
            @endforeach
        ]
        module_list.datat = data
        module_list.urlData = "{{url('CRUDBOOSTER/ModulsControllerPostStep2')}}";
        // var app = angular.module("createModuleApp", []);
        // list.baseUrl = "{{ url('') }}/"; 
        // list.app = app;
        // list.init();
    </script>