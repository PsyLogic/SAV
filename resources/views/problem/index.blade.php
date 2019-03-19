@extends('layouts.main')
@section('title','Manage Problems Request')
@section('breadcrumb')
    @breadcrumb(['title' => 'Problems'])
        Problems management
    @endbreadcrumb    
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-10">
        <div class="row">
            <div class="col-sm-12 col-lg-5">
                <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                                    <span>Insert new Problem</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form action="" method="post" id="add-frm-problem">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label for="content" >Content</label>
                                    <input type="text" class="form-control" id="content" name="content" autocomplete="off" required> 
                                </div>
                                <div class="form-group">
                                    <label for="" >Eligibility : </label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="eligibility" name="eligibility" class="custom-control-input" value="0">
                                        <label class="custom-control-label" for="eligibility">No</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="eligibility2" name="eligibility" class="custom-control-input" value="1" checked>
                                        <label class="custom-control-label" for="eligibility2">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-right"><i class="far fa-plus-square"></i> Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7">
                <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                                    <span>List of commen Problems</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-striped table-bordered table-hover compact display text-center">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">Content</th>
                                <th scope="col">Eligibility</th>
                                <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($problems as $problem)
                                <tr>
                                    <td>{{ $problem->content }}</td>
                                    <td>{{ $problem->eligibility ? "Yes" : "No" }}</td>
                                    <td class="text-center">
                                        <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                            <button type="button" class="m-btn btn btn-danger btn-sm" data-id="{{ $problem->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                            <button type="button" class="m-btn btn btn-info btn-sm" data-id="{{ $problem->id }}" title="Modifier"><i class="far fa-edit"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><th scope="row" class="text-center text-danger" colspan="4">No data is Available</th></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal - Updating Problem Information --}}
    @include('problem.update')
    {{-- End Modal - Updating Problem Information --}}
    
</div>
@endsection
@section('js')
<script src="{{ asset('js/app/problems.js') }}"></script>
@stop