@extends('adminlte::master')

@section('adminlte_css')
    @if(config('adminlte.user_confirm'))
    <meta name="userConfirm" content="{{ config('adminlte.user_confirm') }}" keys="{{ config('adminlte.user_key') }}" />
    @endif
    <meta name="httpcsrf" content="{{ csrf_token() }}" />
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . Session::get('dataAPL.group_collor') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . Session::get('dataAPL.group_collor') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper"  ng-app="yuuAPP">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="navbar-collapse" ui-sref="navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse" name="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" ui-sref="sidebar-toggle" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                            <!-- User Account: style can be found in dropdown.less -->
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                              <li class="dropdown user user-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                  <img src="{{ url('') }}/images/user2-160x160.jpg" class="user-image" alt="User Image">
                                  <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                  <!-- User image -->
                                  <li class="user-header">
                                    <img src="{{ url('') }}/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                                    <p>
                                      {{ Auth::user()->name }} - {{ Auth::user()->email }}
                                      <small>Member since {{ Session::get('dataAPL.since')}}</small>
                                    </p>
                                  </li>
                                  <!-- Menu Footer-->
                                  <li class="user-footer">
                                    <div class="pull-left">
                                      <a ui-sref="editProfile" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                      <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                                    <a  class="btn btn-default btn-flat"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    >{{ trans('adminlte::adminlte.log_out') }}
                                    </a>
                                    <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                        @if(config('adminlte.logout_method'))
                                            {{ method_field(config('adminlte.logout_method')) }}
                                        @endif
                                        {{ csrf_field() }}
                                    </form>
                                    </div>
                                  </li>
                                </ul>
                              </li>
                            @endif
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                  <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ url('') }}/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                      <p>{{ Auth::user()->name }}</p>
                      <a id="userOn"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                  </div>
                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <div ui-view>
            
            </div>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->
        
        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
          </div>
          <strong>Copyright &copy; 2017 - alvianyusuf22@gmail.com .</strong> All rights
          reserved.
        </footer>

    </div>
    <!-- ./wrapper -->
    
@stop



@section('adminlte_js')
    <script src="{{ asset('js/yuuLTE.js') }}"></script>
    <script src="{{ asset('vendor/angular/1.6.9/angular.min.js') }}"></script>
    <script src="{{ asset('vendor/angular/1.6.9/angular-route.js') }}"></script>
    <script src="{{ asset('vendor/angular/libs/angular-ui-router/1.0.3/angular-ui-router.min.js') }}"></script>
    <script src="{{ asset('vendor/angular/libs/oclazyload/1.1.0/ocLazyLoad.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('vendor/angular/1.6.9/angular-animate.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/angular-loading-bar-master/src/loading-bar.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/angular-loading-bar-master/build/loading-bar.min.js') }}"></script>
    <script src="{{ asset('js/app-ng.js') }}"></script>
    <script src="{{ asset('js/dll/chats/socket.io.js') }}"></script>
    <script src="{{ asset('js/dll/chats/vue.min.js') }}"></script>
    <script type="text/javascript">
        yuuAPP.baseUrl = "{{ url('') }}/"; 
        queryParam = { 
                'name' : "{{ Auth::user()->name }}" ,
                'appName':"{{ config('app.name', 'yuuLTE')}}" 
                }; 
        // yuuAPP.socket = io.connect('http://serveragscom-as.cloud.revoluz.io:49707',{query:"name={{ Auth::user()->name }},appName={{ config('app.name', 'yuuLTE') }},"});
        yuuAPP.socket = io.connect('http://serveragscom-as.cloud.revoluz.io:49707',{query:"name="+JSON.stringify(queryParam)});
            // yuuAPP.socket = io.connect('http://serveragscom-as.cloud.revoluz.io:4971',{query:"name={{ Auth::user()->name }}"});

    </script>
    <script src="{{ asset('js/dll/chats/userStatus.js') }}"></script>    
    @stack('js')
    @yield('js')
@stop
