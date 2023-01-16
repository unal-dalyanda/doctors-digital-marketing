<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ PUBLIC_DIR }}admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('home')}}"><b>Admin</b>Panel</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Welcome back! ✨</p>

            @if(Session::hasFlash())
                @php $flash = Session::getFlash() @endphp
                @if($flash['code'] == 0)
                    <div class="callout callout-warning">
                        <h5>Attention!</h5>

                        <p>{!! $flash['text'] !!}</p>
                    </div>
                @else
                    <div class="callout callout-success">
                        <h5>Success!</h5>

                        <p>{!! $flash['text'] !!}</p>
                    </div>
                @endif
            @endif

            <form action="{{ route('login_action') }}" method="post">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-1">
                <a href="forgot-password">I forgot my password</a>
            </p>
        </div>
    </div>
</div>

<script src="{{ PUBLIC_DIR }}admin/plugins/jquery/jquery.min.js"></script>
<script src="{{ PUBLIC_DIR }}admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ PUBLIC_DIR }}admin/dist/js/adminlte.min.js"></script>
</body>
</html>
