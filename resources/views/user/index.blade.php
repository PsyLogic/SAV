@extends('layouts.main')
@section('title','Manage Agents')
@section('breadcrumb')
    @breadcrumb(['title' => 'Users'])
        Users management
    @endbreadcrumb    
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-sm-12">
        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                            <span>Add new user</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
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
                        <button type="submit" class="btn btn-primary m-btn--pill m-btn--air float-right"><i class="far fa-plus-square"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h2 class="m-portlet__head-label m-portlet__head-label--danger">
                            <span>Users</span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Job</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->type }}</td>
                            <td class="text-center">
                                <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                    <button type="button" class="m-btn btn btn-sm btn-danger" data-id="{{ $user->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                    <button type="button" class="m-btn btn btn-sm btn-info" data-id="{{ $user->id }}" title="Modifier"><i class="far fa-edit"></i></button>
                                    <button type="button" class="m-btn btn btn-sm btn-metal change-password" data-id="{{ $user->id }}" title="Changer Mot de passe"><i class="fas fa-key"></i></button>
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

    {{-- Modal - Updating User Information --}}
        @include('user.update')
    {{-- End Modal - Updating User Information --}}
    
</div>
@endsection

@section('js')
<script src="{{ asset('js/app/users.js') }}"></script>
@stop