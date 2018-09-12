@extends('layouts.main')
@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">Insert new Problem</h5>
            <form action="" method="post" id="add-frm-problem">
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label for="content" >Content</label>
                        <input type="text" class="form-control" id="content" name="content" autocomplete="off" required> 
                    </div>
                    <div class="form-group">
                        <label for="" >Eligibility : </label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="eligibility" name="eligibility" class="custom-control-input" value="0">
                            <label class="custom-control-label" for="eligibility">No</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="eligibility2" name="eligibility" class="custom-control-input" value="1" checked>
                            <label class="custom-control-label" for="eligibility2">Yes</label>
                        </div>
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
            <h5 class="card-header text-center text-uppercase">List of commen Problems</h5>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Content</th>
                        <th scope="col">Eligibility</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($problems as $problem)
                        <tr>
                            <th scope="row">{{  $loop->iteration  }}</th>
                            <td>{{ $problem->content }}</td>
                            <td>{{ $problem->eligibility ? "Yes" : "No" }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger" data-id="{{ $problem->id }}" title="Supprimer"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-info" data-id="{{ $problem->id }}" title="Modifier"><i class="far fa-edit"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr><th scope="row" class="text-center text-danger" colspan="4">No data is Available</th></tr>
                        @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

    {{-- Modal - Updating Commercial Information --}}
    @include('problem.update')
    {{-- End Modal - Updating Commercial Information --}}
    
</div>
@endsection

@section('js')
<script>
    /**
     * URL of user resources 
     * 
    */
    var url_problem = "/problems"

    var id = null;

    /**
     *  Return list of Problems 
     * 
    */
    function getProblems(){
        $.ajax({
            type:'GET',
            url:url_problem,
            dataType: 'json',
            success: function(data){
                var rows = '';
                var eligibility=""; 
                $.each(data,function(i,problem){
                    eligibility = problem.eligibility ? 'Yes' : 'No';
                    rows += '\
                    <tr>\
                        <th scope="row">'+(i+1)+'</th>\
                        <td>'+problem.content+'</td>\
                        <td>'+eligibility+'</td>\
                        <td>\
                            <button type="button" class="btn btn-danger" data-id="'+problem.id+'" title="Delete"><i class="fa fa-times"></i></button>\
                            <button type="button" class="btn btn-info" data-id="'+problem.id+'" title="Edit"><i class="far fa-edit"></i></button>\
                        </td>\
                    </tr>\
                    ';
                });
                $('.table tbody').html(rows);
            },
            error: function(response){
                console.log(response);
            }
        });
    }

    $(document).ready(function(){

        // Insert new Commercial
        $('#add-frm-problem').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type:'POST',
                url:url_problem,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    swal("Done", "Problem added successfully !", "success");
                    $('#content').val('');
                    getProblems();
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 422){
                        $.each(response.responseJSON.errors, function(field,error){
                            errors +="- " + error[0] + "\n";
                        });
                    }else if(response.status == 500){
                        errors = "Message: " + response.responseJSON.message
                               + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                    }
                    swal("Error", errors, "error");
                }
            });

        });


        // Raise update modal
        $('body').on('click','.btn-info',function(){
            id  = $(this).data('id');
            
            $.ajax({
                type:'GET',
                url:url_problem + '/' + id,
                dataType: 'json',
                success: function (problem) {
                    $('#update_content').val(problem.content);
                    if(problem.eligibility)
                        $('#update_eligibility2').prop("checked", true);
                    else
                        $('#update_eligibility').prop("checked", true);
                    
                    $('#update-problem').modal('toggle');
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 404){
                        errors = "Problem not found";
                    }else if(response.status == 500){
                        errors = "Message: " + response.responseJSON.message
                            + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                    }
                    swal("Error", "Error occured: \n" + errors, "error");
                }
            });
        });

        // Update Problem info
        $('#update-frm-problem').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type:'PUT',
                url:url_problem + '/' + id,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);
                    swal("Done", "problem updated successfully !", "success");
                    getProblems();
                },
                error: function(response){
                    console.log(response);
                    var errors="";
                    if(response.status == 422){
                        $.each(response.responseJSON.errors, function(field,error){
                            errors +="- " + error[0] + "\n";
                        });
                    }else if(response.status == 500){
                        errors = "Message: " + response.responseJSON.message
                            + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;
                    }

                    swal("Error", "Error occured: \n" + errors, "error");
                }
            });

        });
        
        // Delete User
        $('body').on('click','.btn-danger',function(){
            id = $(this).data('id');
            swal({
                title: "Delete confirmation",
                text: "Do you want to delete this Problem, we will keep it information for tracking reasons",
                icon: "warning",
                buttons:  ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:'DELETE',
                        url:url_problem + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            swal("Done", "Problem deleted successfully !", "success");
                            getProblems();
                        },
                        error: function(response){
                            console.log(response);
                            var errors="";
                            if(response.status == 500){
                                errors = "Message: " + response.responseJSON.message
                                    + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;

                            }else if(response.status == 404){
                                errors = "Problem Not Found";
                            }
                                swal("Error", errors, "error");
                        }
                    });
                }
            });
        });

    });
</script>
@stop