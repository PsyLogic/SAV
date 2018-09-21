/**
 * URL of commercial resources 
 * 
 */
var url_commercial = "/commercials"

var id = null;

/**
 *  Return list of commercials 
 * 
 */
function getCommercials() {
    $.ajax({
        type: 'GET',
        url: url_commercial,
        dataType: 'json',
        success: function (data) {
            var rows = '';
            $.each(data, function (i, commercial) {
                rows += '\
                   <tr>\
                       <th scope="row">' + (i + 1) + '</th>\
                       <td>' + commercial.full_name + '</td>\
                       <td>' + commercial.phone + '</td>\
                       <td>\
                       <button type="button" class="btn btn-danger" data-id="' + commercial.id + '" title="Delete"><i class="fa fa-times"></i></button>\
                       <button type="button" class="btn btn-info" data-id="' + commercial.id + '" title="Edit"><i class="far fa-edit"></i></button>\
                       </td>\
                   </tr>\
                   ';
            });
            $('.table tbody').html(rows);
        },
        error: function (response) {
            console.log(response);
        }
    });
}

$(document).ready(function () {

    // Insert new Commercial
    $('#add-frm-commercial').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: url_commercial,
            dataType: 'json',
            data: formData,
            success: function (data) {
                console.log(data);
                swal("Done", "Commercial added successfully !", "success");
                $('#add-frm-commercial :input').val('');
                getCommercials();
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
            }
        });

    });


    // Raise update modal
    $('body').on('click', '.btn-info', function () {
        id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: url_commercial + '/' + id,
            dataType: 'json',
            success: function (commercial) {
                $('#update-frm-commercial #update_full_name').val(commercial.full_name);
                $('#update-frm-commercial #update_phone').val(commercial.phone);
                $('#update-commercial').modal('toggle');
            },
            error: function (response) {
                console.log(response);
                var errors = "";
                if (response.status == 404) {
                    errors = "Commercial not found";
                } else if (response.status == 500) {
                    errors = "Message: " + response.responseJSON.message +
                        "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                }
                swal("Error", "Error occured: \n" + errors, "error");
            }
        });
    });

    // Update Commercial info
    $('#update-frm-commercial').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'PUT',
            url: url_commercial + '/' + id,
            dataType: 'json',
            data: formData,
            success: function (data) {
                console.log(data);
                swal("Done", "Commercial updated successfully !", "success");
                getCommercials();
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

    // Delete Commercial
    $('body').on('click', '.btn-danger', function () {
        id = $(this).data('id');
        swal({
                title: "Delete confirmation",
                text: "Do you want to delete the commercial",
                icon: "warning",
                buttons: ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: url_commercial + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            swal("Done", "Commercial deleted successfully !", "success");
                            getCommercials();
                        },
                        error: function (response) {
                            console.log(response);
                            var errors = "";
                            if (response.status == 500) {
                                errors = "Message: " + response.responseJSON.message +
                                    "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;

                            } else if (response.status == 404) {
                                errors = "Commercial Not Found";
                            }
                            swal("Error", errors, "error");
                        }
                    });
                }
            });



    });


});
