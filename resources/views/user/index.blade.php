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

    {{-- Modal - Updating Commercial Information --}}
    @include('user.update')
    {{-- End Modal - Updating Commercial Information --}}
    
</div>
@endsection

@section('js')
<script>
    /**
     * URL of user resources 
     * 
    */
    var url_user = "/users"

    var id = null;

    /**
     *  Return list of users 
     * 
    */
    function getUsers(){
        $.ajax({
            type:'GET',
            url:url_user,
            dataType: 'json',
            success: function(data){
                var rows = '';
                $.each(data,function(i,user){
                    rows += '\
                    <tr>\
                        <th scope="row">'+(i+1)+'</th>\
                        <td>'+user.name+'</td>\
                        <td>'+user.username+'</td>\
                        <td>'+user.type+'</td>\
                        <td>\
                            <button type="button" class="btn btn-danger" data-id="'+user.id+'" title="Delete"><i class="fa fa-times"></i></button>\
                            <button type="button" class="btn btn-info" data-id="'+user.id+'" title="Edit"><i class="far fa-edit"></i></button>\
                            <button type="button" class="btn btn-secondary" data-id="'+user.id+'" title="Changer Mot de passe"><i class="fas fa-key"></i></button>\
                        </td>\
                    </tr>\
                    ';
                });
                $('.table tbody').html(rows);
            },
            error: function(response){
                console.log(response);
            }
        });
    }

    $(document).ready(function(){

        // Insert new Commercial
        $('#add-frm-user').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type:'POST',
                url:url_user,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    swal("Done", "user added successfully !", "success");
                    $('#add-frm-user :input').val('');
                    getUsers();
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 412){
                        errors = response.responseJSON.message;
                    }else if(response.status == 422){
                        $.each(response.responseJSON.errors, function(field,error){
                            errors +="- " + error[0] + "\n";
                        });
                    }else if(response.status == 500){
                        errors = "Message: " + response.responseJSON.message
                               + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                    }
                    swal("Error", errors, "error");
                }
            });

        });


        // Raise update modal
        $('body').on('click','.btn-info',function(){
            id  = $(this).data('id');
            
            $.ajax({
                type:'GET',
                url:url_user + '/' + id,
                dataType: 'json',
                success: function (user) {
                    $('#update-frm-user #update_name').val(user.name);
                    $('#update-frm-user #update_username').val(user.username);
                    $('#update-frm-user #update_email').val(user.email);
                    $('#update-frm-user #update_type').val(user.type);
                    $('#update-user').modal('toggle');
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 404){
                        errors = "User not found";
                    }else if(response.status == 500){
                        errors = "Message: " + response.responseJSON.message
                            + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                    }
                    swal("Error", "Error occured: \n" + errors, "error");
                }
            });
        });

        // Update User info
        $('#update-frm-user').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type:'PUT',
                url:url_user + '/' + id,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);
                    swal("Done", "user updated successfully !", "success");
                    getUsers();
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 422){
                        $.each(response.responseJSON.errors, function(field,error){
                            errors +="- " + error[0] + "\n";
                        });
                    }else if(response.status == 500){
                        errors = "Message: " + response.responseJSON.message
                            + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;
                    }

                    swal("Error", "Error occured: \n" + errors, "error");
                }
            });

        });
        
        // Delete User
        $('body').on('click','.btn-danger',function(){
            id = $(this).data('id');
            swal({
                title: "Delete confirmation",
                text: "Do you want to delete this User, we will keep it information for tracking reasons",
                icon: "warning",
                buttons:  ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'DELETE',
                        url:url_user + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            swal("Done", "user deleted successfully !", "success");
                            getUsers();
                        },
                        error: function(response){
                            console.log(response);
                            var errors="";
                            if(response.status == 500){
                                errors = "Message: " + response.responseJSON.message
                                    + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                            }else if(response.status == 404){
                                errors = "User Not Found";
                            }
                                swal("Error", errors, "error");
                        }
                    });
                }
            });
        });


        // Toggle Password Modal
        $('body').on('click','.btn-secondary',function(){
            id = $(this).data('id');
            $('#update-user-password').modal('toggle');

            // Update User password
            $('#update-frm-user-password').submit(function(e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type:'PUT',
                    url:url_user + '/password/' + id,
                    dataType: 'json',
                    data:formData,
                    success: function (data) {
                        console.log(data);
                        swal("Done", "Password updated successfully !", "success");
                    },
                    error: function(response){
                        var errors="";
                        console.log(response);
                        if(response.status == 422){
                            $.each(response.responseJSON.errors, function(field,error){
                                errors +="- " + error[0] + "\n";
                            });
                        }else if(response.status == 500){
                            errors = "Message: " + response.responseJSON.message
                                + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                        }
                        swal("Error", "Error occured: \n" + errors, "error");
                    }
                });
            });
        });

    });
</script>
@stop