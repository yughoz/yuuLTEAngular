Yuu LTE Form Booster
===========

Install new modul
-------------------------
* Copy TempController -> YourController 
* Copy views\vendor\yuu\list.blade -> views\vendor\yourview\list.blade 
* Copy public\js\dll\yuu\list.js -> public\js\dll\yourjs\list.js
* add routes 	

```bash

	Route::group(['prefix' => 'API/user'], function(){
		Route::get('/list','UsersController@anyData')->middleware('role:users--readAcc');
		Route::post('','UsersController@create')->middleware('role:users--createAcc');
		Route::get('{id}','UsersController@get')->middleware('role:users--readAcc');
		Route::post('{id}','UsersController@update')->middleware('role:users--updateAcc');
		Route::delete('{id}','UsersController@delete')->middleware('role:users--deleteAcc');
	 });

```
* add routes 	

```bash
	.state('users', {
            url: '/admin/users',
            templateUrl: 'admin/users',
            controller: function($scope) {
                var app = yuuAPP;
                users_list.baseUrl = yuuAPP.baseUrl; 
                users_list.app = app;
                users_list.init();
                $scope.title = "User Management";
            },
            resolve: {
                loadMyFiles: function($ocLazyLoad) {
                  return $ocLazyLoad.load({
                    name: 'yuuAPP',
                    files: [
                      {type: 'css', path: 'vendor/adminlte/vendor/datatables/dataTables.bootstrap.css'},
                      {type: 'css', path: 'vendor/adminlte/vendor/toastr-master/build/toastr.css'},
                      {type: 'css', path: 'vendor/adminlte/vendor/bootstrap-toggle-master/css/bootstrap-toggle.css'},
                      'vendor/adminlte/vendor/datatables/jquery.dataTables.min.js',
                      'vendor/adminlte/vendor/datatables/dataTables.bootstrap.min.js',
                      'vendor/adminlte/vendor/toastr-master/toastr.js',
                      'vendor/adminlte/vendor/blockui-master/jquery.blockUI.js',
                      'vendor/adminlte/vendor/bootstrap-toggle-master/js/bootstrap-toggle.js',
                      'js/dll/users/listYuu.js',
                    ]
                  })
                }
              }
        })
```


Install new modul
-------------------------
