@extends('layouts.main')
@section('title', 'Create new Issue')
@section('breadcrumb')
    @breadcrumb(['title' => 'Issue'])
        Update existant issue info
    @endbreadcrumb    
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg m-portlet--bordered">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="fa fa-ticket-alt"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Update Client Information
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-12">
                        <!-- Search Form -->
                        <form class="m-form" id="search-form">
                            <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group">
                                    <label>IMEI:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="999999999999999" name="imei" id="imei" required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End Search Form -->
                    </div>
                </div>
                <div id="info" class="row">
                    <div class="col-12">
                        <!-- Client Information -->
                        <hr>
                        <h4>Client Information:</h4>
                        <form class="m-form" id="update-form">
                            @method('PUT')
                            <div class="m-form__section m-form__section--first">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Full Name:</label>
                                            <input type="text" class="form-control" id="full_name" name="full_name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Phone:</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>City:</label>
                                            <input type="text" class="form-control" id="city" name="city">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success float-right"><i class="fa fa-pencil-alt"></i> Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- End Client Information -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/app/update_issue.js')}}"></script>
@stop