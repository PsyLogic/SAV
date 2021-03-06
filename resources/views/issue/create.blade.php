@extends('layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new Issue</h5>
            <form action="" method="post" id="add-frm-issue">
                <div class="card-body row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        @csrf
                        <div class="form-group">
                            <label for="imei" >IMEI</label>
                            <input type="text" class="form-control" id="imei" name="imei" autocomplete="off" value="999999999999999"> 
                        </div>
                        <div class="form-group">
                            <label for="commercial_id" >Commercial Agent</label>
                            <select class="form-control" name="commercial_id" id="commercial_id" required>
                                <option value=""></option>
                                @foreach($commercials as $commercial)
                                <option value="{{ $commercial->id }}">{{ $commercial->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="received_at" >Received date:</label>
                            <input type="date" class="form-control" id="received_at" name="received_at" autocomplete="off" required> 
                        </div>

                    </div>
                </div>
                <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-primary float-right btn-submit"><i class="far fa-plus-square"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function ableLoading(element,html='<i class="fas fa-spinner fa-spin"></i>'){
        element.html(html);
        element.prop('disabled',true);
    }
    function disableLoading(element, html='<i class="far fa-plus-square"></i> Add'){
        element.html(html);
        element.prop('disabled',false);
    }

    /**
     * URL of issue resources 
     * 
    */
    var url_issue = "/issues"

    $(document).ready(function(){

        // Insert new Issue
        $('#add-frm-issue').submit(function(e){
            e.preventDefault();

            if( isNaN($('#imei').val())  || ( $('#imei').val() != '' && $('#imei').val().length != 15 )){
                alert('IMEI must be a valid of 15 number');
                return;
            }
            
            ableLoading($('.btn-submit'));
            var formData = $(this).serialize();
            
            $.ajax({
                type:'POST',
                url:url_issue,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);
                    swal("Done", "Reparation request is sent successfully", "success");
                    $('#add-frm-issue :input').val('');
                    disableLoading($('.btn-submit'));
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 404){
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
                    disableLoading($('.btn-submit'));
                }
            });
        });
    });
</script>
@stop