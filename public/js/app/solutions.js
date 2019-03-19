/**
 * URL of Solution resources 
 * 
 */
var url_solution = "/solutions"
var solution_table = null;
var id = null;

function initDataTable(newData){

    if (newData !== undefined) {
        solution_table.destroy();
        $('.table tbody').empty();
        $('.table tbody').html(newData);
    }
    solution_table = $(".table").DataTable({
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
        errors = "Solution not found";
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
                rows += `
                   <tr>
                       <td>${solution.content}</td>
                       <td>
                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">
                                <button type="button" class="m-btn btn btn-sm btn-danger" data-id="${solution.id }" title="Supprimer"><i class="fa fa-times"></i></button>
                                <button type="button" class="m-btn btn btn-sm btn-info" data-id="${solution.id }" title="Modifier"><i class="far fa-edit"></i></button>
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
                raiseError(response);                
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
                raiseError(response);
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
                $('#update-solution').modal('toggle');
                swal("Done", "solution updated successfully !", "success");
                getSolutions();
            },
            error: function (response) {
                raiseError(response);
            }
        });

    });

    // Delete Solution
    $('body').on('click', '.btn-danger', function () {
        $this = $(this);
        id = $this.data('id');
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
                        success: function () {
                            swal("Done", "Solution deleted successfully !", "success");
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
