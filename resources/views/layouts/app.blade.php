<!DOCTYPE html>
<html lang="en" style="height: auto;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('global.app_name') }} - @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <!-- Custom Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/custom_dark-mode.css') }}">
    <!-- Page Styles -->
    @yield('styles')
    <!-- Stack Styles -->
    @stack('styles')
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed text-md">
    <!-- wrapper -->
    <div class="wrapper">
        <!-- navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light text-md">
            <!-- Left navbar links -->
            @include('layouts.partials.app_navbar_left')
            <!-- Right navbar links -->
            @include('layouts.partials.app_navbar_right')
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-maroon elevation-4" style="background-color:#2c3e50 !important">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('adminlte/img/AdminLTELogo.png') }}" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity:.8">
                <span class="brand-text font-weight-light">{{ __('global.app_name') }}</span>
            </a>

            <!-- sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @auth
                            @php
                                $photo = auth()->user()->photo;
                                $isExternal = Str::startsWith($photo, ['http://', 'https://']);
                            @endphp

                            <img src="{{ $isExternal ? $photo : asset('storage/' . $photo) }}"
                                class="img-circle elevation-2" alt="User" width="100">
                        @else
                            <img src="{{ asset('adminlte/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                                alt="Guest" width="100">
                        @endauth
                    </div>
                    <div class="info">
                        <a class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    @include('layouts.partials.app_sidebar_left')
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1024px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ LaravelLocalization::getLocalizedURL(null, '/') }}">
                                        {{ __('global.home') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">@yield('title_navbar')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer text-md">
            @include('layouts.partials.app_footer')
        </footer>
        <!-- /.Main Footer -->

        <!-- Control Right Sidebar -->
        <aside class="control-sidebar control-sidebar-dark" style="display:none;">
            <div class="p-3 control-sidebar-content">
                @include('layouts.partials.app_sidebar_right')
            </div>
        </aside>
        <!-- /.Control Right Sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <!-- Custom Scripts -->
    <script src="{{ asset('adminlte/js/custom.js') }}"></script>
    <script src="{{ asset('adminlte/js/custom_dark-mode.js') }}"></script>
    <!-- Sweetalert2 -->
    @include('layouts.plugins.sweetalert2')
    <!-- Parsley -->
    @include('layouts.plugins.parsley')
    <!-- Page Scripts -->
    @yield('scripts')
    <!-- Stack Scripts -->
    @stack('scripts')
</body>

</html>
