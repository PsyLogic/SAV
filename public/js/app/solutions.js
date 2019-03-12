/**
 * URL of Solution resources 
 * 
 */
var url_solution = "/solutions"
var solution_table = null;
var id = null;

function initDataTable(){
    // destroy and Initial table with datatable if it is initialized
    solution_table = $(".table").DataTable();
}


/**
 *  Return list of Solutions 
 * 
 */
function getSolutions() {
    $.ajax({
        type: 'GET',
        url: url_solution,
        dataType: 'json',
        success: function (data) {
            var rows = '';
            $.each(data, function (i, solution) {
                rows += '\
                   <tr>\
                       <th scope="row">' + (parseInt(i) + 1) + '</th>\
                       <td>' + solution.content + '</td>\
                       <td>\
                           <button type="button" class="btn btn-danger" data-id="' + solution.id + '" title="Delete"><i class="fa fa-times"></i></button>\
                           <button type="button" class="btn btn-info" data-id="' + solution.id + '" title="Edit"><i class="far fa-edit"></i></button>\
                       </td>\
                   </tr>\
                   ';
            });
            solution_table.destroy();
            $('.table tbody').empty();
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
    // Insert new Solution
    $('#add-frm-solution').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: url_solution,
            dataType: 'json',
            data: formData,
            success: function (data) {
                swal("Done", "Solution added successfully !", "success");
                $('#content').val('');
                getSolutions();
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
                swal("Error", errors, "error");
            }
        });

    });


    // Raise update modal
    $('body').on('click', '.btn-info', function () {
        id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: url_solution + '/' + id,
            dataType: 'json',
            success: function (solution) {
                $('#update_content').val(solution.content);
                $('#update-solution').modal('toggle');
            },
            error: function (response) {
                console.log(response);
                var errors = "";
                if (response.status == 404) {
                    errors = "Solution not found";
                } else if (response.status == 500) {
                    errors = "Message: " + response.responseJSON.message +
                        "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                }
                swal("Error", "Error occured: \n" + errors, "error");
            }
        });
    });

    // Update Solution info
    $('#update-frm-solution').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'PUT',
            url: url_solution + '/' + id,
            dataType: 'json',
            data: formData,
            success: function (data) {
                console.log(data);
                swal("Done", "solution updated successfully !", "success");
                getSolutions();
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

    // Delete Solution
    $('body').on('click', '.btn-danger', function () {
        id = $(this).data('id');
        swal({
                title: "Delete confirmation",
                text: "Do you want to delete this Solution, we will keep it information for tracking reasons",
                icon: "warning",
                buttons: ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: url_solution + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            swal("Done", "Solution deleted successfully !", "success");
                            getSolutions();

                        },
                        error: function (response) {
                            console.log(response);
                            var errors = "";
                            if (response.status == 500) {
                                errors = "Message: " + response.responseJSON.message +
                                    "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                            } else if (response.status == 404) {
                                errors = "Solution Not Found";
                            }
                            swal("Error", errors, "error");
                        }
                    });
                }
            });
    });

});
