<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>{{ Config::get('app.name') }}</title>

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
    <!-- icheck bootstrap -->
    <link
        rel="stylesheet"
        href="{{ url('/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css"
    >
    <!-- Theme style -->
    <link
        rel="stylesheet"
        href="{{ url('/themes') }}/css/adminlte.light.min.css"
    >
    <script src="{{ url('/') }}/js/app.js"></script>
    <!-- jQuery -->
    <script src="{{ url('/') }}/plugins/jquery/jquery.slim.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('/themes') }}/js/adminlte.min.js"></script>
</head>

<body {!! $attributes->merge(['class' => 'hold-transition']) !!}>
    {!! $slot !!}
</body>

</html>
