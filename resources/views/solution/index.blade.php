@extends('layouts.main')
@section('title','Manage Request\'s Solution')
@section('content')
<div class="row justify-content-center">
    <div class="col-4">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new Solution</h5>
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
    <div class="col-8">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">List of commen Solutions</h5>
            <div class="card-body" class="">
                <table class="table text-center" >
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Content</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($solutions as $solution)
                        <tr class="">
                            <th scope="row">{{  $loop->iteration  }}</th>
                            <td>{{ $solution->content }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" data-id="{{ $solution->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info" data-id="{{ $solution->id }}" title="Modifier"><i class="far fa-edit"></i></button>
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

    {{-- Modal - Updating Solution Information --}}
    @include('solution.update')
    {{-- End Modal - Updating Solution Information --}}
    
</div>
@endsection

@section('js')
<script src="{{ asset('js/app/solutions.js') }}"></script>
@stop