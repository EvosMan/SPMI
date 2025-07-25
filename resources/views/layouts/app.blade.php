<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <link rel="stylesheet" href="/theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> --}}
    <!-- iCheck -->
    <link rel="stylesheet" href="/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href="/theme/plugins/jqvmap/jqvmap.min.css"> --}}
    @stack('sub-styles')
    <!-- Theme style -->
    <link rel="stylesheet" href="/theme/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    {{-- <link rel="stylesheet" href="/theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> --}}
    <!-- Daterange picker -->
    {{-- <link rel="stylesheet" href="/theme/plugins/daterangepicker/daterangepicker.css"> --}}
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="/theme/plugins/summernote/summernote-bs4.min.css"> --}}
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/theme/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->
        @include('components.app.sidebar')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('breadcrumb')
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} Ariesta Gaming All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    {{-- <b>Version</b> 3.2.0 --}}
                </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/theme/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/theme/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/theme/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    {{-- <script src="/theme/plugins/chart.js/Chart.min.js"></script> --}}
    <!-- Sparkline -->
    {{-- <script src="/theme/plugins/sparklines/sparkline.js"></script> --}}
    <!-- JQVMap -->
    {{-- <script src="/theme/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/theme/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
    <!-- jQuery Knob Chart -->
    {{-- <script src="/theme/plugins/jquery-knob/jquery.knob.min.js"></script> --}}
    <!-- daterangepicker -->
    {{-- <script src="/theme/plugins/moment/moment.min.js"></script>
    <script src="/theme/plugins/daterangepicker/daterangepicker.js"></script> --}}
    <!-- Tempusdominus Bootstrap 4 -->
    {{-- <script src="/theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> --}}
    <!-- Summernote -->
    {{-- <script src="/theme/plugins/summernote/summernote-bs4.min.js"></script> --}}
    <!-- overlayScrollbars -->
    {{-- <script src="/theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> --}}
    <!-- AdminLTE App -->
    <script src="/theme/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="/theme/dist/js/demo.js"></script> --}}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="/theme/dist/js/pages/dashboard.js"></script> --}}
    @stack('sub-scripts')
</body>