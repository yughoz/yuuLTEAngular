<section class="content-header" ui-view="header">
<h1>{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">
        <form action="#edit" class="form-horizontal col-sm-6" id="form-edit_user" method="put" accept-charset="utf-8">  
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" name="editUser_name" readonly="readonly" id="editUser_name" class="form-control editUser" value="<?php echo e(Auth::user()->name); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="editUser_email" readonly="readonly" id="editUser_email" class="form-control editUser" value="<?php echo e(Auth::user()->email); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-sm-2 control-label">Phone</label>
                <div class="col-sm-10">
                    <input type="tel" name="editUser_phone" id="editUser_phone" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" class="form-control editUser" value="<?php echo e(Auth::user()->phone); ?>" />
                </div>
            </div>
            <div class="form-group">
                <section class="content-header">
                <h1>Change Password</h1>
                </section>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="password" class="form-control editUser"/>
                    <div class="progress" style="margin:0">
                        <div class="pwstrength_viewport_progress"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-sm-2 control-label">Password confirm</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control editUser"/>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btnEdit">Save</button>
                </div>
            </div>

    </form>
</section>

  <script type="text/javascript" language="javascript" > 
        
        editProfile.baseUrl = "<?php echo e(url('')); ?>/"; 
        editProfile.init();
    </script>