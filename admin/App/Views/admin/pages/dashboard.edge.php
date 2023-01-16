@extends('admin.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fab fa-wpforms"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Contact Requests</span>
                            <span class="info-box-number">
                                {!! $appointment_count->count !!} <small>total</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-edit"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Blogs</span>
                            <span class="info-box-number">
                                {!! $blog_count !!} <small>total</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Team Member</span>
                            <span class="info-box-number">
                                {!! $member_count !!} <small>total</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Recent Appointments</h3>
                            <div class="card-tools">
                                <a href="{!! route('application_list', ['applicationType' => 'all']) !!}" class="btn btn-tool btn-sm">View all</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_applications as $application)
                                        <tr>
                                            <td>{!! $application->ID !!}</td>
                                            <td>{!! json_decode($application->application_data)->name !!}</td>
                                            <td>{!! Date::set($application->created_at)->get('d.m.Y | H:i') !!}</td>
                                            <td>
                                                <a href="{!! route('application_detail', ['applicationId' => $application->ID]) !!}" class="text-muted" title="Detayları gör">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Today's Appointments</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($today_applications as $application)
                                        <tr>
                                            <td>{!! $application->ID !!}</td>
                                            <td>{!! json_decode($application->application_data)->name !!}</td>
                                            <td>{!! Date::set($application->created_at)->get('d.m.Y | H:i') !!}</td>
                                            <td>
                                                <a href="{!! route('application_detail', ['applicationId' => $application->ID]) !!}" class="text-muted" title="Detayları gör">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

@endsection
