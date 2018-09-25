@extends('layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new User</h5>
            <form action="" method="post" id="add-frm-user">
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label for="name" >Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required> 
                    </div>
                    <div class="form-group">
                        <label for="username" >Username</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off" required> 
                    </div>
                    <div class="form-group">
                        <label for="email" >Email</label>
                        <input type="email" class="form-control" id="email" name="email"> 
                    </div>
                    <div class="form-group">
                        <label for="type" >Type</label>
                        <select class="form-control" name="type" id="type" required>
                            <option value=""></option>
                            <option value="Admin">Admin</option>
                            <option value="SAV">SAV</option>
                            <option value="Commercial">Commercial Responsable</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" >Password</label>
                        <input type="password" class="form-control" id="password" name="password" required> 
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" >Re-type Passwod</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required> 
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-primary float-right"><i class="far fa-plus-square"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-5">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">List of Users</h5>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Job</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <th scope="row">{{  $loop->iteration  }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->type }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" data-id="{{ $user->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info" data-id="{{ $user->id }}" title="Modifier"><i class="far fa-edit"></i></button>
                                <button type="button" class="btn btn-secondary" data-id="{{ $user->id }}" title="Changer Mot de passe"><i class="fas fa-key"></i></button>
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

    {{-- Modal - Updating User Information --}}
    @include('user.update')
    {{-- End Modal - Updating User Information --}}
    
</div>
@endsection

@section('js')
<script src="{{ asset('js/app/users.js') }}"></script>
@stop