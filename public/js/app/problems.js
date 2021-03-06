/**
 * URL of Problems resources 
 * 
 */
var url_problem = "/problems"
var problems_table= null;
var id = null;


function initDataTable(){
    // destroy and Initial table with datatable if it is initialized
    if(problems_table){
        problems_table.destroy();
    }
    problems_table =  $('.table').DataTable();
}


/**
 *  Return list of Problems 
 * 
 */
function getProblems() {
    $.ajax({
        type: 'GET',
        url: url_problem,
        dataType: 'json',
        success: function (data) {
            var rows = '';
            var eligibility = "";
            $.each(data, function (i, problem) {
                eligibility = problem.eligibility ? 'Yes' : 'No';
                rows += '\
                   <tr>\
                       <th scope="row">' + (i + 1) + '</th>\
                       <td>' + problem.content + '</td>\
                       <td>' + eligibility + '</td>\
                       <td>\
                           <button type="button" class="btn btn-danger" data-id="' + problem.id + '" title="Delete"><i class="fa fa-times"></i></button>\
                           <button type="button" class="btn btn-info" data-id="' + problem.id + '" title="Edit"><i class="far fa-edit"></i></button>\
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
    $('#add-frm-problem').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: url_problem,
            dataType: 'json',
            data: formData,
            success: function (data) {
                swal("Done", "Problem added successfully !", "success");
                $('#content').val('');
                getProblems();
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
            url: url_problem + '/' + id,
            dataType: 'json',
            success: function (problem) {
                $('#update_content').val(problem.content);
                if (problem.eligibility)
                    $('#update_eligibility2').prop("checked", true);
                else
                    $('#update_eligibility').prop("checked", true);

                $('#update-problem').modal('toggle');
            },
            error: function (response) {
                console.log(response);
                var errors = "";
                if (response.status == 404) {
                    errors = "Problem not found";
                } else if (response.status == 500) {
                    errors = "Message: " + response.responseJSON.message +
                        "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                }
                swal("Error", "Error occured: \n" + errors, "error");
            }
        });
    });

    // Update Problem info
    $('#update-frm-problem').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'PUT',
            url: url_problem + '/' + id,
            dataType: 'json',
            data: formData,
            success: function (data) {
                console.log(data);
                swal("Done", "problem updated successfully !", "success");
                getProblems();
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

    // Delete Problem
    $('body').on('click', '.btn-danger', function () {
        id = $(this).data('id');
        swal({
                title: "Delete confirmation",
                text: "Do you want to delete this Problem, we will keep it information for tracking reasons",
                icon: "warning",
                buttons: ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: url_problem + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            swal("Done", "Problem deleted successfully !", "success");
                            getProblems();
                        },
                        error: function (response) {
                            console.log(response);
                            var errors = "";
                            if (response.status == 500) {
                                errors = "Message: " + response.responseJSON.message +
                                    "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                            } else if (response.status == 404) {
                                errors = "Problem Not Found";
                            }
                            swal("Error", errors, "error");
                        }
                    });
                }
            });
    });

});
