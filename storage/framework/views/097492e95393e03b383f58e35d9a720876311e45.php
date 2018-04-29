<section class="content-header" ui-view="header">
<h1>{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">
       <div class="row">
        <div class="col-md-12">
             <div class="box">
                <div class="box-header with-border">
                  <?php if($action_btn_add && checkAccess('groups','createAcc')): ?>
                    <h3 class="box-title"><a class="btn btn-block btn-primary btn-flat"  data-toggle="modal" data-target="#createMainModal"><i class="fa fa-plus"></i> Create <?php echo e($label); ?></a></h3>
                  <?php endif; ?>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" id="tblMain">
                        <thead>
                            <tr>
                             <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($c['label']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <h4 class="modal-title">Create <?php echo e($label); ?></h4>
      </div>
        <form class="form-horizontal" id="form-create_main" method="post" accept-charset="utf-8">
      <div class="modal-body">
            
            <?php echo csrf_field(); ?>

            <?php echo $formsAdd; ?>

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
<div id="editMainModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <form  class="form-horizontal" id="form-edit_main" method="put" accept-charset="utf-8">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit <?php echo e($label); ?></h4>
      </div>
      <div class="modal-body">
            
            <?php echo csrf_field(); ?>

            
            <input type="hidden" name="editMainid" value="" id="editMainuID" class="form-control editMain"/>
            <?php echo $formsEdit; ?>

            <!-- CUSTUM IN HERE -->
            <!-- <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="editMainname" value="" id="editMainname" class="form-control editMain"/>
                </div>
            </div> -->
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
            <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                { data: "<?php echo e($c['name']); ?>", name: "<?php echo e($c['name']); ?>" },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ]
        groups_list.datat = data
        groups_list.APIUrl = '<?php echo e(url("API")); ?>/<?php echo e($APIUrl); ?>'
    </script>