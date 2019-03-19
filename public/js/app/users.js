/**
 * URL of user resources 
 * 
 */
var url_user = "/users"
var users_table = null;
var id = null;

function initDataTable(newData){
    // destroy and Initial table with datatable if it is initialized
    if(newData !== undefined){
        users_table.destroy();
        $('.table tbody').empty();
        $('.table tbody').html(newData);
    }
    users_table =  $('.table').DataTable({
        responsive: true,
        stateSave: true,
        "columnDefs": [ {
            "targets": '_all',
            "orderable": false
        }],
    });
}

function raiseError(response){
    var errors = "";
    if (response.status == 404) {
        errors = "User not found";
    }
    else if (response.status == 422) {
        $.each(response.responseJSON.errors, function (field, error) {
            errors += "- " + error[0] + "\n";
        });
    } else if (response.status == 500) {
        errors = "Message: " + response.responseJSON.message +
            "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

    }
    swal("Error", errors, "error");
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
                rows += `
                    <tr>
                        <td>${user.name}</td>
                        <td>${user.username}</td>
                        <td>${user.type}</td>
                        <td>
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn-sm btn btn-danger" data-id="${user.id}" title="Delete"><i class="fa fa-times"></i></button>
                                <button type="button" class="m-btn btn-sm btn btn-info" data-id="${user.id}" title="Edit"><i class="far fa-edit"></i></button>
                                <button type="button" class="m-btn btn-sm btn btn-metal change-password" data-id="${user.id}" title="Changer Mot de passe"><i class="fas fa-key"></i></button>
                            </div>
                        </td>
                    </tr>`;
            });
            initDataTable(rows);
        },
        error: function (response) {
            raiseError(response);
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
                raiseError(response)
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
                raiseError(response);
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
            success: function () {
                $('#update-user').modal('toggle');
                swal("Done", "user updated successfully !", "success");
                getUsers();
            },
            error: function (response) {
                raiseError(response);
            }
        });

    });

    // Delete User
    $('body').on('click', '.btn-danger', function () {
        $this = $(this);
        id = $this.data('id');
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
                        success: function () {
                            swal("Done", "user deleted successfully !", "success");
                            $this.parentsUntil('tbody').fadeOut(500,function() { $(this).remove() });
                        },
                        error: function (response) {
                            raiseError(response);
                        }
                    });
                }
            });
    });


    // Toggle Password Modal
    $('body').on('click', '.change-password', function () {
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
                    $('#update-user-password').modal('toggle');
                    swal("Done", "Password updated successfully !", "success");
                },
                error: function (response) {
                    raiseError(response);
                }
            });
        });
    });

});
