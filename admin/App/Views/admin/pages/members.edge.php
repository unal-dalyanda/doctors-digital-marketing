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
                    <h1>Team Members</h1>
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
                        <li class="breadcrumb-item active">Members</li>
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
                            <h3 class="card-title">Member list</h3>
                            <div class="card-tools">
                                <a href="{!! route('member_add') !!}" class="btn btn-tool btn-sm btn-outline-success">
                                    <i class="fas fa-plus"></i> Add new member
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table id="example2" class="table table-striped table-hover projects">
                                <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th>Team Member Name</th>
                                    <th>Department Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $member)
                                    <tr>
                                        <td>{!! $member->ID !!}</td>
                                        <td>
                                            {!! $member->member_name !!}
                                        </td>
                                        <td>
                                            {!! $member->department_name !!}
                                        </td>
                                        <td class="project-actions text-right">
                                            <div class="btn-group">
                                                <a href="{!! route('member_edit', ['memberId' => $member->ID]) !!}"
                                                   type="button" class="btn btn-outline-dark btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{!! route('member_delete', ['memberId' => $member->ID]) !!}"
                                                   type="button" class="btn btn-outline-danger btn-sm" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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
                                    <th>Team Member Name</th>
                                    <th>Department Name</th>
                                    <th>Action</th>
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

    <div class="modal fade" id="modal-add-department" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Department</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="{!! route('department_add') !!}" method="post" class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Department Name</label>
                            <input type="text" name="department_name" class="form-control" placeholder="Enter name ...">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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
