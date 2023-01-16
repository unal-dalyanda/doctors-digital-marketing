@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{!! get_asset('admin/plugins/tagify/tagify.css', 'v=1.8.2') !!}">
    <style>
        .tagify {
            width: 100%;
            border-radius: .25rem;
        }</style>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#general-settings"
                                                        data-toggle="tab">General Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="#contact-settings" data-toggle="tab">Contact
                                        Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="#seo-settings" data-toggle="tab">SEO
                                        Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="general-settings">
                                    <form id="general-settings-form"
                                          action="{!! route('settings_save', ['type' => 'general']) !!}" method="post"
                                          class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Site Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="site_name" class="form-control"
                                                       id="inputName" value="{!! $general_settings->site_name !!}"
                                                       placeholder="Site name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSlogan" class="col-sm-2 col-form-label">Site
                                                Slogan</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="site_slogan" class="form-control"
                                                       id="inputSlogan" value="{!! $general_settings->site_slogan !!}"
                                                       placeholder="Site slogan">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="siteDescription"
                                                   class="col-sm-2 col-form-label">Site Description</label>
                                            <div class="col-sm-10">
                                                    <textarea
                                                        name="site_description" class="form-control"
                                                        id="siteDescription"
                                                        placeholder="Site description">{!! $general_settings->site_description !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="siteLogo" class="col-sm-2 col-form-label">Site Logo</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="site_logo"
                                                               class="custom-file-input" id="siteLogo">
                                                        <label class="custom-file-label" for="exampleInputFile">Select
                                                            image</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 clearfix">
                                                <img
                                                    src="@if(!empty($general_settings->site_logo)) {!! get_asset('uploads/site/' . $general_settings->site_logo) !!} @endif"
                                                    class="img-fluid img-thumbnail mt-sm-2 float-sm-none float-md-right @if(empty($general_settings->site_logo)) d-none @endif"
                                                    style="max-width: 250px" id="preview"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-outline-success">Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="contact-settings">
                                    <form id="contact-settings-form"
                                          action="{!! route('settings_save', ['type' => 'contact']) !!}" method="post"
                                          class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="phoneNumber" class="col-sm-2 col-form-label">Main Phone
                                                Number</label>
                                            <div class="col-sm-10">
                                                <input type="tel" name="phone_number" class="form-control"
                                                       id="phoneNumber"
                                                       value="{!! $contact_settings->phone_number !!}"
                                                       placeholder="Phone number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="faxNumber" class="col-sm-2 col-form-label">FAX
                                                Number</label>
                                            <div class="col-sm-10">
                                                <input type="tel" name="fax_number" class="form-control"
                                                       id="faxNumber"
                                                       value="{!! $contact_settings->fax_number !!}"
                                                       placeholder="FAX number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="eMail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="main_email" class="form-control"
                                                       id="eMail"
                                                       value="{!! $contact_settings->main_email !!}"
                                                       placeholder="Email address">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mainOfficeAddress"
                                                   class="col-sm-2 col-form-label">Main Office Address</label>
                                            <div class="col-sm-10">
                                                    <textarea name="main_office_address" class="form-control" rows="4"
                                                              id="mainOfficeAddress"
                                                              placeholder="Main office address">{!! $contact_settings->main_office_address !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Opening Hours</label>
                                            <div class="col-sm-10">
                                                    <textarea name="opening_hours" class="form-control" rows="4"
                                                              placeholder="Opening hours detail">{!! $contact_settings->opening_hours !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-md-2 col-form-label">Other Phone
                                                Numbers</label>
                                            <div class="col-sm-10 col-md-6">
                                                <div class="other_phone_container">
                                                    @php
                                                        $numbers_count = 0;
                                                    @endphp

                                                    @if(!empty($contact_settings->phone_numbers[0]))
                                                        @foreach($contact_settings->phone_numbers as $phone_number)
                                                            <div class="row">
                                                                <div class="form-group col-sm-12">
                                                                    <label>Phone number</label>
                                                                    <div class="input-group">
                                                                        <input type="tel" name="phone_numbers[]"
                                                                               class="form-control"
                                                                               value="{!! $phone_number !!}"
                                                                               placeholder="Enter phone number ...">
                                                                        <span class="input-group-append">
                                                                                    <button type="button"
                                                                                            onclick="fieldDelete(this, 'phone')"
                                                                                            class="btn btn-outline-danger btn-flat delete">
                                                                                        <i class="fas fa-times"></i> Delete
                                                                                    </button>
                                                                                </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @php $numbers_count++ @endphp
                                                        @endforeach
                                                    @else
                                                        <div class="row">
                                                            <div class="form-group col-sm-12">
                                                                <label>Phone number</label>
                                                                <input type="tel" name="phone_numbers[]"
                                                                       class="form-control"
                                                                       placeholder="Enter phone number ...">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="phone_button clearfix">
                                                    <button type="button" onclick="addField('phone')"
                                                            class="btn btn-outline-primary float-right mt-2 add_office_field">
                                                        <i class="fa fa-plus"></i> Add phone number
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-md-2 col-form-label">Other Office
                                                Address</label>
                                            <div class="col-sm-10 col-md-6">
                                                <div class="other_office_container">
                                                    @php
                                                        $office_count = 0;
                                                    @endphp

                                                    @if(!empty($contact_settings->office_address[0]))
                                                        @foreach($contact_settings->office_address as $oth_office)
                                                            <div class="row">
                                                                <div class="form-group col-sm-12">
                                                                    <label>Office address</label>
                                                                    <div class="input-group">
                                                                        <textarea name="office_address[]"
                                                                                  class="form-control" rows="3"
                                                                                  placeholder="Enter office address ...">{!! $oth_office !!}</textarea>
                                                                        <span class="input-group-append">
                                                                            <button type="button"
                                                                                    onclick="fieldDelete(this, 'office')"
                                                                                    class="btn btn-outline-danger btn-flat delete">
                                                                                <i class="fas fa-times"></i> Delete
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @php $office_count++ @endphp
                                                        @endforeach
                                                    @else
                                                        <div class="row">
                                                            <div class="form-group col-sm-12">
                                                                <label>Office address</label>
                                                                <textarea name="office_address[]" class="form-control"
                                                                          rows="3"
                                                                          placeholder="Enter office address ..."></textarea>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="office_button clearfix">
                                                    <button type="button" onclick="addField('office')"
                                                            class="btn btn-outline-primary float-right mt-2 add_office_field">
                                                        <i class="fa fa-plus"></i> Add office
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-md-2 col-form-label">Social Media
                                                Accounts</label>
                                            <div class="col-sm-10 col-md-6">
                                                <div class="social_account_container">

                                                    @php
                                                        $social_count = 0;
                                                    @endphp

                                                    @if(!empty($contact_settings->social[0]))
                                                        @foreach($contact_settings->social as $social)
                                                            <div class="row">
                                                                <div class="form-group col-sm-4">
                                                                    <label>Select social media</label>
                                                                    <select name="social[type][]" class="form-control">
                                                                        <option value="" disabled hidden>Please select</option>
                                                                        <option value="fa-twitter" {!! $social->type == 'fa-twitter' ? 'selected' : '' !!}>Twitter</option>
                                                                        <option value="fa-instagram" {!! $social->type == 'fa-instagram' ? 'selected' : '' !!}>Instagram</option>
                                                                        <option value="fa-linkedin-in" {!! $social->type == 'fa-linkedin-in' ? 'selected' : '' !!}>LinkedIn</option>
                                                                        <option value="fa-facebook-f" {!! $social->type == 'fa-facebook-f' ? 'selected' : '' !!}>Facebook</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-8">
                                                                    <label>Account link</label>
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                               name="social[url][]"
                                                                               class="form-control"
                                                                               value="{!! $social->url !!}"
                                                                               placeholder="Enter account link ...">
                                                                        <span class="input-group-append">
                                                                            <button type="button"
                                                                                    onclick="fieldDelete(this, 'social')"
                                                                                    class="btn btn-outline-danger btn-flat delete">
                                                                                <i class="fas fa-times"></i> Delete
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @php $social_count++ @endphp
                                                        @endforeach
                                                    @else
                                                        <div class="row">
                                                            <div class="form-group col-sm-4">
                                                                <label>Select social media</label>
                                                                <select name="social[type][]" class="form-control">
                                                                    <option value="" selected disabled hidden>Please
                                                                        select
                                                                    </option>
                                                                    <option value="fa-twitter">Twitter</option>
                                                                    <option value="fa-instagram">Instagram</option>
                                                                    <option value="fa-linkedin-in">LinkedIn</option>
                                                                    <option value="fa-facebook-f">Facebook</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-sm-8">
                                                                <label>Account link</label>
                                                                <input type="text" name="social[url][]"
                                                                       class="form-control" value=""
                                                                       placeholder="Enter account link ...">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="social_button clearfix">
                                                    <button type="button" onclick="addField('social')"
                                                            class="btn btn-outline-primary float-right mt-2 add_form_field">
                                                        <i class="fa fa-plus"></i> Add social account
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-outline-success">Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="seo-settings">
                                    <form id="seo-settings-form"
                                          action="{!! route('settings_save', ['type' => 'seo']) !!}" method="post"
                                          class="form-horizontal">
                                        <div class="callout callout-info">
                                            <p>If you leave the SEO settings for a page or post blank, the general
                                                SEO settings you set here will be applied.</p>
                                        </div>
                                        <div class="form-group row">
                                            <label for="seoTitle" class="col-sm-2 col-form-label">General SEO
                                                Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control"
                                                       name="seo_title" id="seoTitle"
                                                       value="{!! $seo_settings->seo_title !!}"
                                                       placeholder="SEO title">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="seoDescription"
                                                   class="col-sm-2 col-form-label">General SEO Description</label>
                                            <div class="col-sm-10">
                                                    <textarea class="form-control" rows="5"
                                                              name="seo_description" id="seoDescription"
                                                              placeholder="SEO description">{!! $seo_settings->seo_description !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="seoKeywords" class="col-sm-2 col-form-label">
                                                General Keywords <small class="text-muted">Press enter or put a
                                                    comma
                                                    after each keyword.</small>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seo_keywords"
                                                       name="seo_keywords" id="seoKeywords"
                                                       value="{{ $seo_settings->seo_keywords }}"
                                                       placeholder="write some tags">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-outline-success">Save Changes
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script
        src="{!! get_asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js', 'v=1.8.2') !!}"></script>
    <script src="{!! get_asset('admin/plugins/tagify/jQuery.tagify.min.js', 'v=1.8.2') !!}"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();

            $("#siteLogo").on('change', function () {
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
        var max_fields = 4;
        var delete_wrapper = null;
        var wrapper_office = $(".other_office_container");
        var wrapper_phone = $(".other_phone_container");
        var wrapper_social = $(".social_account_container");

        var office_append = '<div class="row"><div class="form-group col-sm-12"> <label>Office address</label> <div class="input-group"> <textarea name="office_address[]" class="form-control" rows="3" placeholder="Enter office address ..."></textarea> <span class="input-group-append"> <button type="button" onclick="fieldDelete(this, \'office\')" class="btn btn-outline-danger btn-flat delete"> <i class="fas fa-times"></i> Delete </button> </span> </div> </div> </div>';
        var phone_append = '<div class="row"><div class="form-group col-sm-12"> <label>Phone number</label> <div class="input-group"> <input type="tel" name="phone_numbers[]" class="form-control" placeholder="Enter phone number ..."> <span class="input-group-append"> <button type="button" onclick="fieldDelete(this, \'phone\')" class="btn btn-outline-danger btn-flat delete"> <i class="fas fa-times"></i> Delete </button> </span> </div> </div> </div>';
        var social_append = '<div class="row"> <div class="form-group col-sm-4"> <label>Select social media</label> <select name="social[type][]" class="form-control"> <option value="" selected disabled hidden>Please select</option> <option value="fa-twitter">Twitter</option> <option value="fa-instagram">Instagram</option> <option value="fa-linkedin-in">LinkedIn</option> <option value="fa-facebook-f">Facebook</option> </select> </div>  <div class="form-group col-sm-8"> <label>Account link</label> <div class="input-group"> <input type="text" name="social[url][]" class="form-control" placeholder="Enter account link ..."> <span class="input-group-append"> <button type="button" onclick="fieldDelete(this, \'social\')" class="btn btn-outline-danger btn-flat delete"> <i class="fas fa-times"></i> Delete </button> </span> </div> </div> </div>';

        var social_x = 1;
        var office_x = 1;
        var phone_x = 1;

        function addField(btnType) {
            var wrapper;
            var append;
            var x;

            if (btnType === 'social') {
                wrapper = wrapper_social;
                append = social_append;
                x = social_x;
                max_fields = 4 - {!! $social_count !!} + 1;
            } else if (btnType === 'office') {
                wrapper = wrapper_office;
                append = office_append;
                x = office_x;
                max_fields = 10 - {!! $office_count !!} + 1;
            } else if (btnType === 'phone') {
                wrapper = wrapper_phone;
                append = phone_append;
                x = phone_x;
                max_fields = 10 - {!! $numbers_count !!} + 1;
            }

            if (x < max_fields) {
                switch (btnType) {
                    case 'social':
                        social_x++;
                        break;
                    case 'office':
                        office_x++;
                        break;
                    case 'phone':
                        phone_x++;
                }

                $(wrapper).append(append);
            } else {
                alert('You\'ve reached the field adding limits')
            }
        }

        function fieldDelete(element, btnType) {
            $(element).parent().parent().parent().parent().remove();

            switch (btnType) {
                case 'social':
                    social_x--;
                    break;
                case 'office':
                    office_x--;
                    break;
                case 'phone':
                    phone_x--;
            }
        }

        var tagInput = document.querySelector('input[name=seo_keywords]');
        new Tagify(tagInput);
    </script>
@endsection
