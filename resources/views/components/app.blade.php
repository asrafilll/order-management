<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    >
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="{{ url('/') }}/plugins/fontawesome-free/css/all.min.css"
    >
    <!-- iCheck -->
    <link
        rel="stylesheet"
        href="{{ url('/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css"
    >
    <!-- Theme style -->
    <link
        rel="stylesheet"
        href="{{ url('/themes') }}/css/adminlte.light.min.css"
    >
    <!-- overlayScrollbars -->
    <link
        rel="stylesheet"
        href="{{ url('/') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"
    >
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <x-preloader />
        <x-navbar />
        <x-sidebar />
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {!! $slot !!}
        </div>
        <!-- /.content-wrapper -->
        <x-footer />
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ url('/') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('/') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('/themes') }}/js/adminlte.min.js"></script>
</body>

</html>
