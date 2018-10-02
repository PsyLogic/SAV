/**
 * URL of user resources 
 * 
 */
var url_user = "/users"
var users_table = null;
var id = null;

function initDataTable(){
    // destroy and Initial table with datatable if it is initialized
    if(users_table){
        users_table.destroy();
    }
    users_table =  $('.table').DataTable();
}


/**
 *  Return list of users 
 * 
 */
function getUsers() {
    $.ajax({
        type: 'GET',
        url: url_user,
        dataType: 'json',
        success: function (data) {
            var rows = '';
            $.each(data, function (i, user) {
                rows += '\
                    <tr>\
                        <th scope="row">' + (i + 1) + '</th>\
                        <td>' + user.name + '</td>\
                        <td>' + user.username + '</td>\
                        <td>' + user.type + '</td>\
                        <td>\
                            <button type="button" class="btn btn-danger" data-id="' + user.id + '" title="Delete"><i class="fa fa-times"></i></button>\
                            <button type="button" class="btn btn-info" data-id="' + user.id + '" title="Edit"><i class="far fa-edit"></i></button>\
                            <button type="button" class="btn btn-secondary" data-id="' + user.id + '" title="Changer Mot de passe"><i class="fas fa-key"></i></button>\
                        </td>\
                    </tr>\
                    ';
            });
            $('.table tbody').html(rows);
            initDataTable();
        },
        error: function (response) {
            console.log(response);
        }
    });
}

$(document).ready(function () {

    initDataTable();
    // Insert new Commercial
    $('#add-frm-user').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: url_user,
            dataType: 'json',
            data: formData,
            success: function (data) {
                swal("Done", "user added successfully !", "success");
                $('#add-frm-user :input').val('');
                getUsers();
            },
            error: function (response) {
                console.log(response);
                var errors = "";
                if (response.status == 412) {
                    errors = response.responseJSON.message;
                } else if (response.status == 422) {
                    $.each(response.responseJSON.errors, function (field, error) {
                        errors += "- " + error[0] + "\n";
                    });
                } else if (response.status == 500) {
                    errors = "Message: " + response.responseJSON.message +
                        "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                }
                swal("Error", errors, "error");
            }
        });

    });


    // Raise update modal
    $('body').on('click', '.btn-info', function () {
        id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: url_user + '/' + id,
            dataType: 'json',
            success: function (user) {
                $('#update-frm-user #update_name').val(user.name);
                $('#update-frm-user #update_username').val(user.username);
                $('#update-frm-user #update_email').val(user.email);
                $('#update-frm-user #update_type').val(user.type);
                $('#update-user').modal('toggle');
            },
            error: function (response) {
                console.log(response);
                var errors = "";
                if (response.status == 404) {
                    errors = "User not found";
                } else if (response.status == 500) {
                    errors = "Message: " + response.responseJSON.message +
                        "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                }
                swal("Error", "Error occured: \n" + errors, "error");
            }
        });
    });

    // Update User info
    $('#update-frm-user').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'PUT',
            url: url_user + '/' + id,
            dataType: 'json',
            data: formData,
            success: function (data) {
                console.log(data);
                swal("Done", "user updated successfully !", "success");
                getUsers();
            },
            error: function (response) {
                console.log(response);
                var errors = "";
                if (response.status == 422) {
                    $.each(response.responseJSON.errors, function (field, error) {
                        errors += "- " + error[0] + "\n";
                    });
                } else if (response.status == 500) {
                    errors = "Message: " + response.responseJSON.message +
                        "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;
                }

                swal("Error", "Error occured: \n" + errors, "error");
            }
        });

    });

    // Delete User
    $('body').on('click', '.btn-danger', function () {
        id = $(this).data('id');
        swal({
                title: "Delete confirmation",
                text: "Do you want to delete this User, we will keep it information for tracking reasons",
                icon: "warning",
                buttons: ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: url_user + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            swal("Done", "user deleted successfully !", "success");
                            getUsers();
                        },
                        error: function (response) {
                            console.log(response);
                            var errors = "";
                            if (response.status == 500) {
                                errors = "Message: " + response.responseJSON.message +
                                    "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                            } else if (response.status == 404) {
                                errors = "User Not Found";
                            }
                            swal("Error", errors, "error");
                        }
                    });
                }
            });
    });


    // Toggle Password Modal
    $('body').on('click', '.btn-secondary', function () {
        id = $(this).data('id');
        $('#update-user-password').modal('toggle');

        // Update User password
        $('#update-frm-user-password').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'PUT',
                url: url_user + '/password/' + id,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);
                    swal("Done", "Password updated successfully !", "success");
                },
                error: function (response) {
                    var errors = "";
                    console.log(response);
                    if (response.status == 422) {
                        $.each(response.responseJSON.errors, function (field, error) {
                            errors += "- " + error[0] + "\n";
                        });
                    } else if (response.status == 500) {
                        errors = "Message: " + response.responseJSON.message +
                            "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                    }
                    swal("Error", "Error occured: \n" + errors, "error");
                }
            });
        });
    });

});
