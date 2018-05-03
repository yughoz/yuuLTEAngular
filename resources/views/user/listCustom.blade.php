<section class="content-header" ui-view="header">
<h1>{{ $title }}</h1>

</section>

<!-- Main content -->
<section class="content">
       <div class="row">
        <div class="col-md-12">
             <div class="box">
                <div class="box-header with-border">
                  @if($action_btn_add)
                    <h3 class="box-title"><a class="btn btn-block btn-primary btn-flat"  data-toggle="modal" data-target="#createMainModal"><i class="fa fa-plus"></i> Create {{$label}}</a></h3>
                  @endif
                  @if($btn_import)
                    <h3 class="box-title"><a class="btn btn-block btn-primary btn-flat"  data-toggle="modal" data-target="#importModal"><i class="fa fa-download"></i>Import  </a></h3>
                  @endif
                  @if($btn_export)
                  <!-- target="_blank" href="{{url("API")}}/{{$APIUrl}}/export" -->
                    <h3 class="box-title"><a class="btn btn-block btn-primary btn-flat" data-toggle="modal" data-target="#exportModal" ><i class="fa fa-upload"></i> Export </a></h3>
                  @endif
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" id="tblMain">
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
<div id="createMainModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create {{$label}}</h4>
      </div>
        <form class="form-horizontal" id="form-create_main" method="post" accept-charset="utf-8">
      <div class="modal-body">
            
            {!! csrf_field() !!}
            {!! $formsAdd !!}
            <!-- CUSTUM IN HERE -->
            <!-- <div class="form-group">
                <label for="name" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="" id="name" class="form-control"/>
                </div>
            </div> -->

      </div>
      <div id="wraperStatus"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="reset" class="btn btn-warning btn-flat">Reset</button>
        <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
      </div>
        </form>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="exportModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Export {{$label}}</h4>
      </div>
        <form class="form-horizontal" id="form-export_main" method="post" accept-charset="utf-8">
      <div class="modal-body">
            
            {!! csrf_field() !!}
            <!-- CUSTUM IN HERE -->
            
            @foreach($selectsql as $sel)
              <div class="col-md-4">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="exportField[{{$sel}}]" id="{{$sel}}">
                  <label class="form-check-label" for="exampleCheck1">{{$sel}}</label>
                </div>
              </div>
            @endforeach
            <!-- <div class="form-group">
                <label for="name" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="" id="name" class="form-control"/>
                </div>
            </div> -->

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" >Export</button>
      </div>
        </form>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="importModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import {{$label}}</h4>
      </div>
        <form class="form-horizontal" id="form-import_main" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <div class="modal-body">
            
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">File XLS / CSV</label>
                <div class="col-sm-10">
                    <input type="file" name="import_file" value="" id="import_file" class="form-control"/>
                </div>
            </div>
            <!-- CUSTUM IN HERE -->
            <!-- <div class="form-group">
                <label for="name" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="" id="name" class="form-control"/>
                </div>
            </div> -->

        <div class="alert alert-danger alert-dismissible" id="containerAlertImport">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Failed!</h4>
          <p id="alertImport"></p>
        </div>
      </div>
      <div id="wraperStatus"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="reset" class="btn btn-warning btn-flat">Reset</button>
        <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
      </div>
        </form>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="editMainModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <form  class="form-horizontal" id="form-edit_main" method="put" accept-charset="utf-8">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit {{$label}}</h4>
      </div>
      <div class="modal-body">
            
            {!! csrf_field() !!}
            
            <input type="hidden" name="editMainid" value="" id="editMainuID" class="form-control editMain"/>
            {!! $formsEdit !!}
            <!-- CUSTUM IN HERE -->
            <!-- <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="editMainname" value="" id="editMainname" class="form-control editMain"/>
                </div>
            </div> -->
        </div>
        <div class="modal-header" style="padding-top: 30px">
            <h4 class="modal-title">Reset Password</h4>
          </div>
          <div class="modal-body">         
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="editMainpassword" value="" id="editMainpassword" class="form-control editMain" ng-model="fuu.password"/>
                        <div class="progress" style="margin:0">
                            <div class="pwstrength_viewport_progress"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirm" class="col-sm-2 control-label">Password confirm</label>
                    <div class="col-sm-10">
                        <input type="password" name="editMainpassword_confirm" value="" id="editMainpassword_confirm" class="form-control editMain" ng-model="fuu.password_confirm"/>
                    </div>
                </div>

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
            <p>Are you sure want to delete this data..?</p>
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
        data = [
            @foreach($col as $c)
                { data: "{{$c['name']}}", name: "{{$c['name']}}" },
            @endforeach
        ]
        {{$jsClass}}.datat = data
        {{$jsClass}}.APIUrl = '{{url("API")}}/{{$APIUrl}}'
    </script>