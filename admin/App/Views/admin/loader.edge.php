<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/dist/css/adminlte.min.css">
    @yield('css')
</head>
<body class="hold-transition sidebar-hidden">
<div class="wrapper">
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<script src="{{ PUBLIC_DIR }}admin/plugins/jquery/jquery.min.js"></script>
<script src="{{ PUBLIC_DIR }}admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
@yield('js')
</body>
</html>
