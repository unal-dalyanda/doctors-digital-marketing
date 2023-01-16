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
                    <h1>Pages</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pages</li>
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
                            <h3 class="card-title">Page list</h3>
                        </div>
                        <div class="card-body p-0">
                            <table id="example2" class="table table-striped table-hover projects">
                                <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th>Title</th>
                                    <th style="width: 8%" class="text-center">Status</th>
                                    <th style="width: 20%" class="text-center">Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($pages as $page)
                                    <tr>
                                        <td>{!! $page->ID !!}</td>
                                        <td>
                                            {!! $page->title !!}
                                            <br/>
                                            <small>
                                                System
                                            </small>
                                        </td>
                                        <td class="project-state">
                                            @if($page->status == 1)
                                                <small class="badge badge-success"><i class="fas fa-check"></i> Published</small>
                                            @elseif($page->status == 0)
                                                <small class="badge badge-light"><i class="fas fa-times"></i> Draft</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <small>
                                                Edit date: {!! $page->updated_at !!}
                                            </small>
                                        </td>
                                        <td class="project-actions text-right">
                                            <div class="btn-group">
                                                <a href="{!! route('page_edit', ['pageId' => $page->ID]) !!}" type="button" class="btn btn-outline-dark btn-sm"
                                                   title="Edit"><i class="far fa-edit"></i></a>
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
                                    <th>Title</th>
                                    <th style="width: 8%" class="text-center">Status</th>
                                    <th style="width: 20%" class="text-center">Date</th>
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
