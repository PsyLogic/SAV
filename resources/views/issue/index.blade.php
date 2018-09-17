@extends('layouts.main')
@section('css')
<style>
    td,th{
        text-align: center;
        font-size:16px;
    }
</style>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header text-center text-uppercase">List of request reparations</h5>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">IMEI</th>
                        <th scope="col">Commercial Agent</th>
                        <th scope="col">SAV Agent</th>
                        <th scope="col">Request</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($issues as $issue)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $issue->imei ?? 'UNKOWN' }}</td>
                            <td>{{ $issue->commercial->full_name }}</td>
                            <td>{{ $issue->user->name ?? 'Not Assigned' }}</td>
                            <td>{!! $issue->stage() !!}</td>
                            <td>
                                <div class="btn-group">
                                    @if ($issue->stage == 1)
                                        <button type="button" class="btn btn-secondary btn-md btn-fix" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="Fix"><i class="fas fa-wrench"></i></button>
                                    @endif
                                    @if($issue->stage == 2)
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                           <i class="fas fa-wrench"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item btn-fix" href="#" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="software" >Software</a>
                                            <a class="dropdown-item btn-fix" href="#" data-stage="{{ $issue->stage }}" data-id="{{$issue->id}}" title="hardware" >Hardware</a>
                                        </div>
                                    @endif
                                    &nbsp;
                                    <button type="button" class="btn btn-info btn-md" data-id="{{$issue->id}}" title="Details"><i class="fas fa-info-circle"></i></button>
                                </div>
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
</div>

@include('issue.stages')

@endsection

@section('js')
<script>
    /**
     * URL of issue resources 
     * 
    */
    var url_issue = "/issues"

    var id = null;

   

    function stageProcess(stage){
        if(stage == 1)
            return '<span class="badge badge-pill badge-secondary">OPEN</span>';
        else if (stage == 2)
            return '<span class="badge badge-pill badge-warning">IN PROCESS</span>';
        else
            return '<span class="badge badge-pill badge-success">Closed</span>';
    }



    /**
     *  Return list of issues 
     * 
    */
    function getIssues(){
        $.ajax({
            type:'GET',
            url:url_issue,
            dataType: 'json',
            success: function(data){
                var rows = '';
                $.each(data,function(i,issue)
                {
                    rows += '\
                    <tr>\
                        <th scope="row">'+(parseInt(i) + 1)+'</th>\
                        <td>'+(issue.imei || "UNKOWN")+'</td>\
                        <td>'+issue.commercial.full_name+'</td>\
                        <td>'+( issue.user ?  issue.user.name : "Not Assigned" )+'</td>\
                        <td>'+stageProcess(issue.stage)+'</td>\
                        <td>\
                            <div class="btn-group">';
                                if(issue.stage == 1)
                                    rows +='<button type="button" class="btn btn-secondary btn-md btn-fix" data-stage="'+ issue.stage+'" data-id="'+issue.id+'" title="Fix"><i class="fas fa-wrench"></i></button>';
                                if(issue.stage == 2){
                                    rows +='<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                                        <i class="fas fa-wrench"></i>\
                                    </button>\
                                    <div class="dropdown-menu">\
                                        <a class="dropdown-item btn-fix" href="#" data-stage="'+ issue.stage+'" data-id="'+issue.id+'" title="software" >Software</a>\
                                        <a class="dropdown-item btn-fix" href="#" data-stage="'+ issue.stage+'" data-id="'+issue.id+'" title="hardware" >Hardware</a>\
                                    </div>';
                                }
                                rows +='&nbsp;<button type="button" class="btn btn-info btn-md" data-id="{{$issue->id}}" title="Details"><i class="fas fa-info-circle"></i></button>\
                            </div>\
                        </td>\
                    </tr>';
                });
                $('.table tbody').html(rows);
            },
            error: function(response){
                console.log(response);
            }
        });
    }
    // getIssues();


    function updateToStage3(formId){
        // Sumbit the form of stage 3
        var formData = new FormData($('#'+formId)[0]);
        $.ajax({
            type:'POST',
            url:url_issue + '/final-step/' + id,
            dataType:'json',
            cache:false,
            contentType:false,
            processData:false,
            data: formData,
            success: function (data) {
                // console.log(data);
                swal("Done", "The phone is fixed and the issue is closed, Thank you!", "success");
                getIssues();
                $('#'+ formId +' :input').val('');
                $('#update-to-stage-' + (stage+1)).modal('toggle')
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
                }else if(response.status == 412){
                    errors = response.responseJSON.message;
                }else if(response.status == 500){
                    errors = "Message: " + response.responseJSON.message
                        + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;
                }
                swal("Error", errors, "error");
            }
        });

        return false;
    }

    $(document).ready(function(){

        // Button fix pop up a modal on which stage the issue in
        $('body').on('click','.btn-fix',function(){

            id = $(this).data('id'); // get id of the issue
            stage = $(this).data('stage'); // get stage of the issue
            var imei = $(this).parent().parent().parent().children().eq(1).text(); // get selected imei from table
            $('#update-to-stage-' + (stage+1)).modal('toggle'); // toggle modal based on stage of the issue
            $('#update_imei').val(imei); // assign the imei to update_imei input (modal in stage 2) 

            // Sumbit the form of stage 2
            $('#update-frm-to-stage-2').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                if( isNaN($('#update_imei').val())  || ( $('#update_imei').val() != '' && $('#update_imei').val().length != 15 )){
                    alert('IMEI must be a valid of 15 number');
                    return;
                }

                var formData = new FormData($(this)[0]);
                $.ajax({
                    type:'POST',
                    url:url_issue + '/' + id,
                    dataType:'json',
                    cache:false,
                    contentType:false,
                    processData:false,
                    data: formData,
                    success: function (data) {
                        // console.log(data);
                        swal("Done", "Reparation request is in process right now", "success");
                        getIssues();
                        $('#update-frm-to-stage-2 :input').val('');
                        $('#update-to-stage-' + (stage+1)).modal('toggle')
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
                        }else if(response.status == 412){
                            errors = response.responseJSON.message;
                        }else if(response.status == 500){
                            errors = "Message: " + response.responseJSON.message
                                + "\nFile: "  + response.responseJSON.file.split('\\').slice(-1)[0] + ":" + response.responseJSON.line ;
                        }
                        swal("Error", errors, "error");
                    }

                });

                return false;
            });
            
            var diagnostic = $(this).text(); // Type of the problem (software or hadware)
            $('.other-problem').hide();
            $('.client-permission').hide();
            if(diagnostic=="Hardware"){
                $('#hardware').show();
                $('#software').hide();
            }else{
                $('#hardware').hide();
                $('#software').show();
            }


            $('#update-frm-software').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                updateToStage3('update-frm-software');
            });

            $('#update-frm-hardware').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                updateToStage3('update-frm-hardware');
            });

            $('#problem_hardware').change(function(){
                var elg = false;
                var selected = $(this).find('option:selected', this);
                
                selected.each(function(){
                    if($(this).data('eligible') == 0)
                    {
                        elg = true
                        return;
                    }
                })
                
                if(elg)
                    $('.client-permission').show();
                else
                    $('.client-permission').hide();


                if($(this).val() == -1){
                    $('.other-problem').show();
                }else{
                    $('.other-problem').hide();
                }
            });

            $('input[type=radio][name=eligibility]').change(function() {
                if (this.value == 0) 
                    $('.client-permission').show();
                else
                    $('.client-permission').hide();
            });



            
            
        });
        

        /**
        *
        * Empty all input when modal is closed
        *
        */
        $('#update-to-stage-2').on('hidden.bs.modal', function (e) {
            $('#update-frm-to-stage-2 :input').val('');
        });
    });
</script>

@stop