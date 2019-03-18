@extends('layouts.main')
@section('title','Manage Commercials Agents')
@section('content')
<div class="row justify-content-center">
    <div class="col-sm-12 col-lg-4">
        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                            <span>Add new Commercial</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <form action="" method="post" id="add-frm-commercial">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="full_name" >Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required> 
                        </div>
                        <div class="form-group">
                            <label for="phone" >Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required> 
                        </div>
                        <div class="form-group">
                            <label for="type" >Belong To</label>
                            <select class="form-control" name="belong_to" id="update_belong_to">
                                <option value="FNAC">FNAC</option>
                                <option value="ORANGE">ORANGE</option>
                                <option value="JUMIA">JUMIA</option>
                                <option value="STG TELECOM">STG TELECOM</option>
                                <option value="Traditionelle">Traditionelle</option>
                            </select> 
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary float-right"><i class="far fa-plus-square"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-8">
        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                            <span>List of Commercials</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <table class="table table-striped table-bordered table-hover text-center compact display">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Full Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Belong To</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commercials as $commercial)
                        <tr>
                            <td>{{$commercial->full_name}}</td>
                            <td>{{$commercial->phone}}</td>
                            <td>{{$commercial->belong_to}}</td>
                            <td class="text-center">
                                <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                    <button type="button" class="m-btn btn btn-sm btn-danger" data-id="{{$commercial->id}}" title="Delete"><i class="fa fa-times"></i></button>
                                    <button type="button" class="m-btn btn btn-sm btn-info" data-id="{{$commercial->id}}" title="Edit"><i class="far fa-edit"></i></button>
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

    {{-- Modal - Updating Commercial Information --}}
    @include('commercial.update')
    {{-- End Modal - Updating Commercial Information --}}
    
</div>
@endsection

@section('js')
<script src="{{ asset('js/app/commercials.js') }}"></script>
@stop