<section class="content-header" ui-view="header">
<h1>{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">
       <div class="row">
        <div class="col-md-12">
             <div class="box">
                <div class="box-header with-border">
                  <?php if(checkAccess('groups','createAcc')): ?>
                    <h3 class="box-title"><a class="btn btn-block btn-primary btn-flat"  data-toggle="modal" data-target="#createGroupsModal"><i class="fa fa-plus"></i> Create Groups</a></h3>
                  <?php endif; ?>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" id="tblGroups">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Descrition</th>
                                <th>Color</th>
                                <th>Action</th>
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
<div id="createGroupsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Groups</h4>
      </div>
        <form class="form-horizontal" id="form-create_groups" method="post" accept-charset="utf-8">
      <div class="modal-body">
            
            <?php echo csrf_field(); ?>

            
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="" id="name" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <input type="text" name="description" value="" id="description" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label for="bgcolor" class="col-sm-2 control-label">Color</label>
                <div class="col-sm-10">
                  <select id="bgcolor" name="bgcolor" class="form-control">
                    <option value="blue">Blue</option>
                    <option value="black">Black</option>
                    <option value="purple">Purple</option>
                    <option value="yellow">Yellow</option>
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="blue-light">Blue-Light</option>
                    <option value="black-light">Black-Light</option>
                    <option value="purple-light">Purple-Light</option>
                    <option value="yellow-light">Yellow-Light</option>
                    <option value="red-light">Red-Light</option>
                    <option value="green-light">Green-Light</option>
                  </select>

                    <!-- <input type="text" name="bgcolor" value="" id="bgcolor" class="form-control bgcolor"/> -->
                </div>
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
<div id="editGroupsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <form  class="form-horizontal" id="form-edit_groups" method="put" accept-charset="utf-8">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Groups</h4>
      </div>
      <div class="modal-body">
            
            <?php echo csrf_field(); ?>

            
            <input type="hidden" name="editGroups_id" value="" id="editGroups_uID" class="form-control editGroups"/>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">name</label>
                <div class="col-sm-10">
                    <input type="text" name="editGroups_name" value="" id="editGroups_name" class="form-control editGroups"/>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <input type="text" name="editGroups_description" value="" id="editGroups_description" class="form-control editGroups"/>
                </div>
            </div>
            <div class="form-group">
                <label for="bgcolor" class="col-sm-2 control-label">Color</label>
                <div class="col-sm-10">
                  
                  <select id="editGroups_bgcolor" name="editGroups_bgcolor" class="form-control editGroups bgcolor">
                    <option value="blue">Blue</option>
                    <option value="black">Black</option>
                    <option value="purple">Purple</option>
                    <option value="yellow">Yellow</option>
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="blue-light">Blue-Light</option>
                    <option value="black-light">Black-Light</option>
                    <option value="purple-light">Purple-Light</option>
                    <option value="yellow-light">Yellow-Light</option>
                    <option value="red-light">Red-Light</option>
                    <option value="green-light">Green-Light</option>
                  </select>
                    <!-- <input type="text"  data-src="#F44336" name="editGroups_bgcolor" value="" id="editGroups_bgcolor" class="form-control editGroups bgcolor"/> -->
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
            <p>Are you sure want to delete this groups..?</p>
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

