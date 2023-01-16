@extends('admin.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Team Member</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New Member</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content data-table-content">
        <div class="container-fluid">
            <form action="{!! route('member_add_action') !!}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-9">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Member Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Member Department</label>
                                        <select name="department_id" class="form-control">
                                            <option value="" selected disabled hidden>Please select a department
                                            </option>

                                            @foreach($departments as $department)
                                                <option
                                                    value="{!! $department->ID !!}">{!! $department->department_name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Member Name</label>
                                        <input type="text" name="member_name" class="form-control"
                                               placeholder="Enter name ...">
                                    </div>
                                    <div class="form-group">
                                        <label>Member About</label>
                                        <textarea name="member_detail" class="form-control" rows="8"
                                                  placeholder="Member about ..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="social_account_container">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label>Select social media</label>
                                                <select name="social[type][]" class="form-control">
                                                    <option value="" selected disabled hidden>Please select</option>
                                                    <option value="fa-twitter">Twitter</option>
                                                    <option value="fa-instagram">Instagram</option>
                                                    <option value="fa-linkedin-in">LinkedIn</option>
                                                    <option value="fa-facebook-f">Facebook</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-8">
                                                <label>Account link</label>
                                                <input type="text" name="social[url][]" class="form-control" value="" placeholder="Enter account link ...">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-block mt-2 add_form_field">
                                        <i class="fa fa-plus"></i> Add social account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Publishing tools</h3>
                        </div>

                        <div class="card-footer">
                            <button type="submit" name="submit" value="draft" class="btn btn-default">Save to draft</button>
                            <button type="submit" name="submit" value="publish" class="btn btn-primary float-right">Publish</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Image tools</h3>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputFile">Member image</label>

                                <div class="mb-2">
                                    <img src="" class="img-fluid img-thumbnail d-none" id="preview"/>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="member_image" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Select image</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script
        src="{!! get_asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js', 'v=1.8.2') !!}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();

            $("#exampleInputFile").on('change', function () {
                var input = $(this)[0];
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = $("#preview");
                        preview.attr('src', e.target.result).fadeIn('slow');
                        preview[0].classList.remove("d-none");
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            })
        });
    </script>

    <script>
        $(document).ready(function () {
            var max_fields = 4;
            var wrapper = $(".social_account_container");
            var add_button = $(".add_form_field");

            var x = 1;
            $(add_button).click(function (e) {
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $(wrapper).append('<div class="row"> <div class="form-group col-sm-4"> <label>Select social media</label> <select name="social[type][]" class="form-control"> <option value="" selected disabled hidden>Please select</option> <option value="fa-twitter">Twitter</option> <option value="fa-instagram">Instagram</option> <option value="fa-linkedin-in">LinkedIn</option> <option value="fa-facebook-f">Facebook</option> </select> </div>  <div class="form-group col-sm-8"> <label>Account link</label> <div class="input-group"> <input type="text" name="social[url][]" class="form-control" placeholder="Enter account link ..."> <span class="input-group-append"> <button type="button" class="btn btn-outline-danger btn-flat delete"> <i class="fas fa-times"></i> Delete </button> </span> </div> </div> </div>');
                } else {
                    alert('You Reached the limits')
                }
            });

            $(wrapper).on("click", ".delete", function (e) {
                e.preventDefault();
                $(this).parent().parent().parent().parent().remove();
                x--;
            })
        });
    </script>

@endsection
