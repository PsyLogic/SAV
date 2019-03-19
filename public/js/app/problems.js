/**
 * URL of Problems resources 
 * 
 */
var url_problem = "/problems"
var problems_table= null;
var id = null;


function initDataTable(newData){
    // destroy and Initial table with datatable if it is initialized
    if(newData !== undefined){
        problems_table.destroy();
        $('.table tbody').empty();
        $('.table tbody').html(newData);
    }
    problems_table =  $('.table').DataTable({
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
        errors = "Problem not found";
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
                rows += `
                   <tr>
                       <td>${problem.content}</td>
                       <td>${eligibility}</td>
                       <td>
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn btn-danger btn-sm" data-id="${problem.id}" title="Supprimer"><i class="fa fa-times"></i></button>
                                <button type="button" class="m-btn btn btn-info btn-sm" data-id="${problem.id}" title="Modifier"><i class="far fa-edit"></i></button>
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
                raiseError(response);
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
                raiseError(response);
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
            success: function () {
                $('#update-problem').modal('toggle');
                swal("Done", "problem updated successfully !", "success");
                getProblems();
            },
            error: function (response) {
                raiseError(response);
            }
        });

    });

    // Delete Problem
    $('body').on('click', '.btn-danger', function () {
        $this = $(this);
        id = $this.data('id');
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
                        success: function () {
                            swal("Done", "Problem deleted successfully !", "success");
                            $this.parentsUntil('tbody').fadeOut(500,function() { $(this).remove() });
                        },
                        error: function (response) {
                            raiseError(response);
                        }
                    });
                }
            });
    });

});
