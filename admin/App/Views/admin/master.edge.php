<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/dist/css/adminlte.min.css?v=15012023">
    @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('admin.partials.header')
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2022.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>CustomCMS Version</b> 1.8.12
        </div>
    </footer>
</div>

<script src="{{ PUBLIC_DIR }}admin/plugins/jquery/jquery.min.js"></script>
<script src="{{ PUBLIC_DIR }}admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ PUBLIC_DIR }}admin/dist/js/adminlte.js"></script>
@yield('js')
</body>
</html>
