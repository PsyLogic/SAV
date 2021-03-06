@extends('layouts.main')
@section('title','Manage Problems Request')
@section('content')
<div class="row justify-content-center">
    <div class="col-4">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new Problem</h5>
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
    <div class="col-8">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">List of commen Problems</h5>
            <div class="card-body">
                <table class="table text-center">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Content</th>
                        <th scope="col">Eligibility</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($problems as $problem)
                        <tr>
                            <th scope="row">{{  $loop->iteration  }}</th>
                            <td>{{ $problem->content }}</td>
                            <td>{{ $problem->eligibility ? "Yes" : "No" }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" data-id="{{ $problem->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info" data-id="{{ $problem->id }}" title="Modifier"><i class="far fa-edit"></i></button>
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

    {{-- Modal - Updating Problem Information --}}
    @include('problem.update')
    {{-- End Modal - Updating Problem Information --}}
    
</div>
@endsection

@section('js')
<script src="{{ asset('js/app/problems.js') }}"></script>
@stop