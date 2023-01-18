@extends('admin.master')

@section('css')
    <link rel="stylesheet"
          href="{!! get_asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css', 'v=2.0.5') !!}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{!! $page_title !!}</h1>

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
                        <li class="breadcrumb-item active">{!! $page_title !!}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content data-table-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{!! $page_title !!} <small>(Listed from newest to oldest.)</small>
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <table id="example2" class="table table-striped table-hover projects">
                                <thead>
                                    <tr>
                                        <th style="width: 1%">
                                            #
                                        </th>
                                        <th>Client Name</th>
                                        <th style="width: 8%" class="text-center">Status</th>
                                        <th style="width: 20%" class="text-center">Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{!! $application->ID !!}</td>
                                            <td>
                                                {!! json_decode($application->application_data)->name !!}
                                            </td>
                                            <td class="project-state">
                                                @if($application->status == 0)
                                                    <small class="badge badge-light"><i class="fas fa-clock"></i> Unread</small>
                                                @elseif($application->status == 1)
                                                    <small class="badge badge-primary"><i class="fas fa-clock"></i> Waiting</small>
                                                @elseif($application->status == 2)
                                                    <small class="badge badge-success"><i class="fas fa-check"></i> Approved</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($application->appointment_date))
                                                    Approve date: {!! Date::set($application->appointment_date)->get('d.m.Y | H:i') !!}
                                                @endif
                                                <br/>
                                                <small>
                                                    Creation date: {!! Date::set($application->created_at)->get('d.m.Y | H:i') !!}
                                                </small>
                                            </td>
                                            <td class="project-actions text-right">
                                                <div class="btn-group">
                                                    <a href="{!! route('application_detail', ['applicationId' => $application->ID]) !!}"
                                                       type="button" class="btn btn-outline-dark btn-sm" title="View details"><i
                                                            class="far fa-eye"></i> View details</a>
                                                    <button type="button"
                                                            class="btn btn-outline-dark btn-sm dropdown-toggle dropdown-hover dropdown-icon"
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                        <a class="dropdown-item"
                                                           href="{!! route('application_mark', ['markType' => 'unread', 'applicationId' => $application->ID]) !!}">
                                                            Mark as unread
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="{!! route('application_mark', ['markType' => 'approved', 'applicationId' => $application->ID]) !!}">
                                                            Mark as approved
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="{!! route('application_delete', ['applicationId' => $application->ID]) !!}">
                                                            <i class="fa fa-trash"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 1%">
                                            #
                                        </th>
                                        <th>Client Name</th>
                                        <th style="width: 8%" class="text-center">Status</th>
                                        <th style="width: 20%" class="text-center">Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="{!! get_asset('admin/plugins/datatables/jquery.dataTables.min.js', 'v=2.0.5') !!}"></script>
    <script src="{!! get_asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 'v=2.0.5') !!}"></script>
    <script
        src="{!! get_asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js', 'v=2.0.5') !!}"></script>
    <script
        src="{!! get_asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js', 'v=2.0.5') !!}"></script>
    <script
        src="{!! get_asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js', 'v=2.0.5') !!}"></script>
    <script
        src="{!! get_asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js', 'v=2.0.5') !!}"></script>
    <script src="{!! get_asset('admin/plugins/pdfmake/vfs_fonts.js', 'v=2.0.5') !!}"></script>
    <script src="{!! get_asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js', 'v=2.0.5') !!}"></script>

    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
