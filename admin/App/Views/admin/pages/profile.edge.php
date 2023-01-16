@extends('admin.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Profile</h1>
                    @if(Session::hasFlash())
                        @php $flash = Session::getFlash() @endphp
                        @if($flash['code'] == 0)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                {!! $flash['text'] !!}
                            </div>
                        @else
                            <div class="alert alert-success alert-dismissible mt-2">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {!! $flash['text'] !!}
                            </div>
                        @endif
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class="">
                        <h2>{!! $user->user_first_name !!} <strong>{!! $user->user_last_name !!}</strong></h2>
                        <p class="lead mb-5">
                            {!! $user->user_name !!}<br>
                            {!! $user->user_email !!}
                        </p>
                    </div>
                </div>
                <div class="col-7">
                    <form action="{!! route('profile_edit_save', ['userId' => $user->ID]) !!}" method="post">
                        <div class="form-group">
                            <label for="inputEmail">E-Mail <small>(User login)</small></label>
                            <input type="email" name="user_email" id="inputEmail" class="form-control" value="{!! $user->user_email !!}">
                        </div>
                        <div class="form-group">
                            <label for="inputOldPass">Old Password</label>
                            <input type="password" name="old_password" id="inputOldPass" class="form-control" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="inputSubject">New Password</label>
                            <input type="password" name="user_pass" id="inputSubject" class="form-control" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Update user">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
