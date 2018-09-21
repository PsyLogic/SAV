@extends('layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-4">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new Commercial</h5>
            <form action="" method="post" id="add-frm-commercial">
                <div class="card-body">
                    <div class="form-group">
                        <label for="full_name" >Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required> 
                    </div>
                    <div class="form-group">
                        <label for="phone" >Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required> 
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
            <h5 class="card-header text-center text-uppercase">List of Commercials</h5>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($commercials as $commercial)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$commercial->full_name}}</td>
                            <td>{{$commercial->phone}}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" data-id="{{$commercial->id}}" title="Delete"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info" data-id="{{$commercial->id}}" title="Edit"><i class="far fa-edit"></i></button>
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
<script srd="{{ asset('js/app/commercials.js') }}"></script>
@stop