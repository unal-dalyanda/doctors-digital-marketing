@extends('admin.master')

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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @php $application_data = json_decode($application->application_data) @endphp

                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    {!! $application_data->name !!} Appointment Details

                                    @if($application->status == 0)
                                        <small class="badge badge-light"><i class="fas fa-clock"></i> Unread</small>
                                    @elseif($application->status == 1)
                                        <small class="badge badge-primary"><i class="fas fa-clock"></i> Waiting</small>
                                    @elseif($application->status == 2)
                                        <small class="badge badge-success"><i class="fas fa-check"></i> Approved</small>
                                    @endif

                                    <small class="float-right">Creation
                                        date: {!! Date::set($application->created_at)->get('d.m.Y | H:i') !!}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col"><font _mstmutation="1">
                                    From
                                </font>
                                <address>
                                    <strong>{!! $application_data->name !!}</strong><br>
                                    Phone: <a
                                        href="tel:{!! $application_data->phoneNumber !!}">{!! $application_data->phoneNumber !!}</a><br>
                                    Email: <a href="mailto:{!! $application_data->email !!}"
                                              target="_blank">{!! $application_data->email !!}</a>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col"><font _mstmutation="1">
                                    To
                                </font>
                                <address>
                                    <strong>Doctor: {!! $application_data->doctor !!}</strong><br>
                                    Insurance Name: {!! $application_data->insuranceName !!}<br>
                                    Insurance Id: {!! $application_data->insuranceId !!}
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <font _mstmutation="1">
                                    <b _mstmutation="1">Registration ID:</b> #{!! $application->ID !!}<br
                                        _mstmutation="1">
                                    <b _mstmutation="1">Registration IP:</b> {!! long2ip($application->user_long) !!}<br
                                        _mstmutation="1">
                                    <b _mstmutation="1">Registration Agent:</b> {!! $application->user_agent !!}
                                </font></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Appointment Information System</h3>
                                    </div>
                                    <form
                                        action="{!! route('application_admin_save', ['applicationId' => $application->ID]) !!}"
                                        method="post" class="form-horizontal">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="appDate" class="col-sm-3 col-form-label">Appointment
                                                    Datetime</label>
                                                <div class="col-sm-9">
                                                    <input
                                                        type="datetime-local" class="form-control"
                                                        id="appDate" name="appointment_date"
                                                        value="{!! $application->appointment_date !!}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="appNote" class="col-sm-3 col-form-label">Appointment
                                                    Note</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="appointment_note" id="appNote"
                                                              rows="3"
                                                              placeholder="Appointment Note">{!! $application->appointment_note !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Save</button>
                                            <button type="reset" class="btn btn-default float-right">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{!! route('application_mark', ['markType' => 'approved', 'applicationId' => $application->ID]) !!}"
                                   class="btn btn-success float-right mb-1"><i class="fa fa-check"></i> Submit Mark as
                                    approved
                                </a>

                                <a href="{!! route('application_mark', ['markType' => 'unread', 'applicationId' => $application->ID]) !!}"
                                   class="btn btn-warning float-right mb-1 mr-1"><i class="fas fa-clock"></i> Submit Mark as
                                    unread
                                </a>

                                <a href="{!! route('application_delete', ['applicationId' => $application->ID]) !!}"
                                   class="btn btn-danger float-right mb-1" style="margin-right: 5px;">
                                    <i class="fas fa-trash-alt"></i> Delete appointment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
