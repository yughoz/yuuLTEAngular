var yuuAPP = angular.module('yuuAPP', [
                                    'oc.lazyLoad',
                                    'ui.router',
                                    'angular-loading-bar',
                                    'chieffancypants.loadingBar', 
                                    // 'ngAnimate',
                                    ]);

yuuAPP.config(function($stateProvider, $urlRouterProvider, $ocLazyLoadProvider ,cfpLoadingBarProvider) {
    
    cfpLoadingBarProvider.includeSpinner = true;
    $urlRouterProvider.otherwise('/dashboard');
    
      $ocLazyLoadProvider.config({
        debug: false,
        events: true,
      });

    $stateProvider
        // HOME STATES AND NESTED VIEWS ========================================
        .state('dashboard', {
            url: '/dashboard',
            templateUrl: 'dashboard',
            controller: 'homeCtrl',

        })
        
        // nested list with custom controller
        .state('editProfile', {
            url: '/editProfile',
            templateUrl: 'admin/editProfile',
            controller: function($scope) {
                $scope.title = "Edit editProfile";
            },
            resolve: {
                loadMyFiles: function($ocLazyLoad) {
                  return $ocLazyLoad.load({
                    name: 'yuuAPP',
                    files: [
                      {type: 'css', path: 'vendor/adminlte/vendor/toastr-master/build/toastr.css'},
                      "vendor/adminlte/vendor/toastr-master/toastr.js",
                      "vendor/adminlte/vendor/blockui-master/jquery.blockUI.js",
                      "js/dll/users/editProfile.js",
                    ]
                  })
                }
              }
        })
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
                      'js/dll/users/ng-list.js',
                    ]
                  })
                }
              }
        })
        .state('roles', {
            url: '/admin/roles',
            templateUrl: 'admin/roles',
            controller: function($scope) {
                roles_list.baseUrl = yuuAPP.baseUrl; 
                roles_list.init();
                $scope.title = "Group Access";
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
                      'js/dll/role/list.js',
                    ]
                  })
                }
              }
        })
        .state('chat', {
            url: '/admin/chat',
            templateUrl: 'admin/chat',
            controller: function($scope) {
                $scope.title = "Chat (beta)";
                $scope.$on('$destroy', function (event) {
                  yuuAPP.socket.removeAllListeners();
                });
            },
            resolve: {
                loadMyFiles: function($ocLazyLoad) {
                  return $ocLazyLoad.load({
                    name: 'yuuAPP',
                    // files: [
                      // 'js/dll/chats/socket.io.js',
                      // 'js/dll/chats/vue.min.js',
                      // 'js/dll/chats/chats.js',
                    // ]
                  })
                }
              }
        })
        .state('groups', {
            url: '/groups',
            templateUrl: 'admin/groups',
            controller: function($scope) {
                $scope.title = "Groups Management";
                groups_list.baseUrl = yuuAPP.baseUrl; 
                groups_list.init();

            },
            resolve: {
                loadMyFiles: function($ocLazyLoad) {
                  return $ocLazyLoad.load({
                    name: 'yuuAPP',
                    files: [
                      'vendor/adminlte/vendor/datatables/jquery.dataTables.min.js',
                      'vendor/adminlte/vendor/datatables/dataTables.bootstrap.min.js',
                      'vendor/adminlte/vendor/toastr-master/toastr.js',
                      'vendor/adminlte/vendor/blockui-master/jquery.blockUI.js',
                      'vendor/adminlte/vendor/bootstrap-toggle-master/js/bootstrap-toggle.js',
                      'vendor/adminlte/plugins/bootstrap-colorpickersliders-master/dist/bootstrap.colorpickersliders.min.js',
                      'vendor/adminlte/plugins/bootstrap-colorpickersliders-master/tynycolor.min.js',
                      'js/dll/groups/list.js',
                      {type: 'css', path: 'vendor/adminlte/vendor/datatables/dataTables.bootstrap.css'},
                      {type: 'css', path: 'vendor/adminlte/vendor/toastr-master/build/toastr.css'},
                      {type: 'css', path: 'vendor/adminlte/plugins/bootstrap-colorpickersliders-master/dist/bootstrap.colorpickersliders.min.css'},
                    ]
                  })
                }
              }
        })
        
        // nested list with just some random string data
        .state('dummy2', {
            url: '/dummy2',
            templateUrl: 'dummy2',
            // template: 'I could sure use a drink right now.',
            controller: function($scope) {
                alert("dummy2");
                $scope.dogs = ['Bernese', 'Husky', 'Goldendoodle'];
                $scope.title = "TITLE DUMMY 22";
            }
        })        
        .state('dummy3', {
            url: '/dummy3',
            templateUrl: 'dummy3',
            controller: function($scope) {
                $scope.title = "TITLE DUMMY 3";
                     alert("TIGAS");
                $scope.dogs = ['Bernese', 'Husky', 'Goldendoodle'];
           
            }
        })
        
        // ABOUT PAGE AND MULTIPLE NAMED VIEWS =================================
        .state('dummy1', {
            url: '/dummy1',
            templateUrl: 'dummy1',
            controller: function($scope) {
                $scope.title = "TITLE DUMMY 3";
                $scope.dogs = ['Bernese', 'Husky', 'Goldendoodle'];
           
            }
            // template: 'I could sure use a drink right now.',
            // views: {
            //     '': { templateUrl: 'dummy1' },
            //     'columnOne@about': { template: 'Look I am a column!' },
            //     'columnTwo@about': { 
            //         templateUrl: 'table-data.html',
            //         controller: 'scotchController'
            //     }
            // }
            
        });
        
});
yuuAPP.run(['$rootScope', '$state', '$stateParams',
  function ($rootScope, $state, $stateParams) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
}])

yuuAPP.controller('createUserCtrl', function($scope, $http) {
    
    // $scope.fcu.nameCreate = "BAms45";
    self = users_list;
        $scope.submitFunc = function () {
          $('#createUserModal').modal('hide');
      // $.blockUI({
            //     message: '<h4>  Please wait... <img src='+self.baseUrl+'public/images/spinner.gif></h4>',
            // });
          $http({
            url: self.baseUrl+"userCreate",
            method: 'POST',
            data: $.param($scope.fcu),
            headers : {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8',"APIKey": self.APIKey}
        }).then(function(response) {
            //First function handles success
            console.log(response.data);
            if(response.data.statusCode == 201){
          document.getElementById("form-create_user").reset();
          self.tblUser.draw();
          toastr.success(response.data.desc);
        } else{
          toastr.warning(response.data.desc);
          toastr.warning(response.data.error.join('<br>'));
          $('#createUserModal').modal('show');
        }
        }, function(response) {
            //Second function handles error
          toastr.error('Internal Server Error');
        $('#createUserModal').modal('show');
        });

    }

});
yuuAPP.controller('homeCtrl', function($scope) {
    $scope.title = 'Dashboard';
    
});
yuuAPP.controller('scotchController', function($scope) {
    
    $scope.message = 'test';
    $scope.title = 'test title';
   
    $scope.scotches = [
        {
            name: 'Macallan 12',
            price: 50
        },
        {
            name: 'Chivas Regal Royal Salute',
            price: 10000
        },
        {
            name: 'Glenfiddich 1937',
            price: 20000
        }
    ];
    
});