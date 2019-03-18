@extends('layouts.main')
@section('title','Manage Request\'s Solution')
@section('breadcrumb')
    @breadcrumb(['title' => 'Solutions'])
        Solutions management
    @endbreadcrumb    
@endsection
@section('content')
<div class="row justify-content-center">
<div class="col-8">
    <div class="row">
        <div class="col-sm-12 col-lg-5">
            <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                                <span>Insert new Solution</span>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form action="" method="post" id="add-frm-solution">
                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label for="content" >Content</label>
                                <input type="text" class="form-control" id="content" name="content" autocomplete="off" required> 
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
                                <span>List of commen solutions</span>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <table class="table table-striped table-bordered table-hover compact display text-center" >
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Content</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($solutions as $solution)
                            <tr class="">
                                <td>{{ $solution->content }}</td>
                                <td class="text-center">
                                    <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                        <button type="button" class="m-btn btn btn-sm btn-danger" data-id="{{ $solution->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                        <button type="button" class="m-btn btn btn-sm btn-info" data-id="{{ $solution->id }}" title="Modifier"><i class="far fa-edit"></i></button>
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
    {{-- Modal - Updating Solution Information --}}
    @include('solution.update')
    {{-- End Modal - Updating Solution Information --}}
</div>
@endsection

@section('js')
<script src="{{ asset('js/app/solutions.js') }}"></script>
@stop