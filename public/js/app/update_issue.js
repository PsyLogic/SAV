function raiseError(response){
    var errors = "";
    if (response.status == 404) {
        errors = response.responseJSON || response.responseJSON.message;
    } else if (response.status == 422) {
        $.each(response.responseJSON.errors, function (field, error) {
            errors += "- " + error[0] + "\n";
        });
    } else if (response.status == 412) {
        errors = response.responseJSON.message;
    } else if (response.status == 500) {
        errors = "Message: " + response.responseJSON.message +
            "\nFile: " + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line;
    }
    swal("Error", errors, "error");
}


$('#info').hide();

// Get All issues related to given IMEI
$('#search-form').submit(function(e){
    e.preventDefault();
    if($('#imei').val() == '999999999999999'){
        alert('Please enter a valid IMEI');
        return;
    }
    var formData = new FormData($(this)[0]);
    $.ajax({
        type:'GET',
        url:'/issue/modify',
        data: {imei: $('#imei').val()},
        success: function(client){
            
            // Client Information
            $('#full_name').val(client.full_name);
            $('#phone').val(client.tel);
            $('#city').val(client.city);
            // show client block
            $('#info').show();
        },
        error: function(error) {
            raiseError(error)
        }
    });
});

// Update Client Information
$('#update-form').submit(function(e){
    e.preventDefault();
    var formData = new $(this).serialize();
    $.ajax({
        type:'PUT',
        url:'/issue/modify/client/'+$('#imei').val(),
        data: formData,
        success: function(client){
            swal("Success", 'Client Updated Successfully', "success");
        },
        error: function(error) {
            raiseError(error)
        }
    });
})


