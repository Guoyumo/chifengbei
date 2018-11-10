<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-lte/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-lte/skins/_all-skins.min.css') }}">

    {{-- Custom --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media_dialog&emotion_editor&msg_tab&emoji&msg_sender&tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('additional-stylesheet')

    <script>
      ROOT_PATH = "{{ url('/') }}";
    </script>
</head>
<body class="skin-green sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="    height: 100%;background-repeat:no-repeat; background-size:100% 100%;-moz-background-size:100%;background-image: url('/caudalie_5_2/public/images/caudalie_logo.png')"> </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><i class="fa  fa-user"></i>&nbsp;{{auth()->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{asset('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">


            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Menu</li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="{{ url('admin/qRcodes') }}"><i class="fa fa-link"></i> <span>{{trans('admin.qr_code')}}</span></a></li>
                <li><a href="{{ url('admin/menus') }}"><i class="fa fa-link"></i> <span>{{trans('admin.menu')}}</span></a></li>
                <li><a href="{{ url('admin/autoReplys') }}"><i class="fa fa-link"></i> <span>{{trans('admin.auto_reply')}}</span></a></li>
                <li><a href="{{ url('admin/subscribeReplys') }}"><i class="fa fa-link"></i> <span>{{trans('admin.subscribe_reply')}}</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">@yield('content-header')</section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
    </div>
</div>

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/admin-lte/adminlte.min.js') }}"></script>
<!-- Vue -->
<script src="{{ asset('js/vue.min.js') }}"></script>
<script src="//unpkg.com/babel-polyfill@latest/dist/polyfill.min.js"></script>
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>
@yield('custom-javascript')
</body>
</html>