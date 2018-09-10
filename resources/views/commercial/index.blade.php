@extends('layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new Commercial</h5>
            <form action="" method="post" id="add-frm-commercial">
                <div class="card-body">
                    <div class="form-group">
                        <label for="full_name" >Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required> 
                    </div>
                    <div class="form-group">
                        <label for="phone" >Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required> 
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
            <h5 class="card-header text-center text-uppercase">List of Commercials</h5>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
            </div>
        </div>
    </div>

    {{-- Modal - Updating Commercial Information --}}
    @include('commercial.update')
    {{-- End Modal - Updating Commercial Information --}}
    
</div>
@endsection

@section('js')
<script>
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
    function getCommercials(){
        $.ajax({
            type:'GET',
            url:url_commercial,
            dataType: 'json',
            success: function(data){
                var rows = '';
                $.each(data,function(i,commercial){
                    rows += '\
                    <tr>\
                        <th scope="row">'+(i+1)+'</th>\
                        <td>'+commercial.full_name+'</td>\
                        <td>'+commercial.phone+'</td>\
                        <td>\
                        <button type="button" class="btn btn-danger" data-id="'+commercial.id+'" title="Delete"><i class="far fa-minus-square"></i></button>\
                        <button type="button" class="btn btn-info" data-id="'+commercial.id+'" title="Edit"><i class="far fa-edit"></i></button>\
                        </td>\
                    </tr>\
                    ';
                });
                $('.table tbody').html(rows);
            },
            error: function(erros){
                errorMessages(errors);
            }
        });
    }

    // Init Commercial table
    getCommercials();

    $(document).ready(function(){

        // Insert new Commercial
        $('#add-frm-commercial').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type:'POST',
                url:url_commercial,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);
                    swal("Done", "Commercial added successfully !", "success");
                    $('#add-frm-commercial :input').val('');
                    getCommercials();
                },
                error: function(errors){
                    console.log(errors);
                        swal("Error", "Error occured: \n" + (errors.responseJSON.message || 'Call IT stuff') + "\n line: " + errors.responseJSON.line, "error");
                }
            });

        });


        // Raise update modal
        $('body').on('click','.btn-info',function(){
            id  = $(this).data('id');
            
            $.ajax({
                type:'GET',
                url:url_commercial + '/' + id,
                dataType: 'json',
                success: function (commercial) {
                    $('#update-frm-commercial #full_name').val(commercial.full_name);
                    $('#update-frm-commercial #phone').val(commercial.phone);
                    $('#update-commercial').modal('toggle');
                },
                error: function(errors){
                    console.log(errors);
                    swal("Error", "Error occured: \n" + (errors.responseJSON.message || 'Call IT stuff') + "\n line: " + errors.responseJSON.line, "error");
                }
            });
        });

        // Update Commercial info
        $('#update-frm-commercial').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type:'PUT',
                url:url_commercial + '/' + id,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);
                    swal("Done", "Commercial updated successfully !", "success");
                    getCommercials();
                },
                error: function(errors){
                    console.log(errors);
                        swal("Error", "Error occured: \n" + (errors.responseJSON.message || 'Call IT stuff') + "\n line: " + errors.responseJSON.line, "error");
                }
            });

        });
        
        // Delete Commercial
        $('body').on('click','.btn-danger',function(){
            id  = $(this).data('id');
            swal({
                title: "Delete confirmation",
                text: "Do you want to delete the commercial",
                icon: "warning",
                buttons:  ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'DELETE',
                        url:url_commercial + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            swal("Done", "Commercial deleted successfully !", "success");
                            getCommercials();
                        },
                        error: function(errors){
                            console.log(errors);
                                swal("Error", "Error occured: \n" + (errors.responseJSON.message || 'Call IT stuff') + "\n line: " + errors.responseJSON.line, "error");
                        }
                    });
                }
            });


            
        });
        

    });
</script>
@stop