/**
 * URL of issue resources 
 * 
 */
var url_issue = "/issues"

var id = null;

var listIssuesTable = null;


/**
 * 
 * @param {int} stage
 * @returns {string} HTML Markup 
 */
function stageProcess(stage) {
    if (stage == 1)
        return '<span class="badge badge-pill badge-danger">OPEN</span>';
    else if (stage == 2)
        return '<span class="badge badge-pill badge-warning">IN PROCESS</span>';
    else
        return '<span class="badge badge-pill badge-success">Closed</span>';
}


function ableLoading(element,html='<i class="fas fa-spinner fa-spin"></i>'){
    element.html(html);
    element.prop('disabled',true);
}
function disableLoading(element, html='<i class="far fa-edit"></i> Update'){
    element.html(html);
    element.prop('disabled',false);
}


function initDataTable(){

    // destroy and Initial table with datatable if it is initialized
    if(listIssuesTable){
        listIssuesTable.destroy();
    }
    
    listIssuesTable =  $('.table').DataTable({
        // stateSave: true,
        // "scrollX": "800px",
        "columnDefs": [ {
            "targets": [6,8],
            // "searchable": false,
            "orderable": false
          } ],
          initComplete: function () {
  
              var column = this.api().column(6);
              console.log(column.header());
              var select ='<select>\
                            <optgroup label="Request">\
                            <option value=""></option>\
                            <option value="Open">Open</option>\
                            <option value="IN PROCESS">IN PROCESS</option>\
                            <option value="Closed">Closed</option>\
                            </select>';
              
              $(select).appendTo( $(column.header()).empty() )
                      .on( 'change', function () {
                          var val = $.fn.dataTable.util.escapeRegex(
                              $(this).val()
                          );
                          column
                              .search( val ? '^'+val+'$' : '', true, false )
                              .draw();
                      });
          }
    });

    // Compact Table View
    //$('.dataTable td').css('padding','0.2em');

    var toggleColumns = '';
    // Add Toggle for table
    $('.table thead tr:eq(0) th').each( function (i) {
        var title = $(this).text();
        if(i==6)
            title = 'Request';
        toggleColumns += '<a href="" class="btn btn-outline-dark toggle-vis" data-column="'+i+'">'+title+'</a>';
    } );
    $('.toggle-group').html(toggleColumns);
}

/**
 *  @returns list of issues 
 * 
 */
function getIssues() {
    $.ajax({
        type: 'GET',
        url: url_issue,
        dataType: 'json',
        success: function (data) {

            var rows = '';
            $.each(data, function (i, issue) {
                rows += '\
                   <tr id="row'+issue.id+'">\
                       <td>' + issue.delivered_at + '</td>\
                       <td>' + issue.client["model"] + '</td>\
                       <td>' + (issue.imei || "999999999999999") + '</td>\
                       <td class="text-center"><a tabindex="0" class="btn btn-sm float-left" role="button" data-toggle="tooltip" data-placement="right" title="'+issue.client["tel"]+'"><i class="fas fa-info-circle"></i></a><span class="">' + issue.client["full_name"] + '</span></td>\
                       <td class="text-center"><a tabindex="0" class="btn btn-sm float-right" role="button" data-toggle="tooltip" data-placement="right" title="'+issue.commercial.phone+'"><i class="fas fa-info-circle"></i></a><span class="">' + issue.commercial.full_name + '</span></td>\
                       <td>' + (issue.user ? issue.user.name : "Not Assigned") + '</td>\
                       <td>' + stageProcess(issue.stage) + '</td>\
                       <td>' + (issue.diagnostic || "----") + '</td>\
                       <td>\
                           <div class="btn-group">';
                if (issue.stage == 1)
                    rows += '<button type="button" class="btn btn-secondary btn-md btn-fix" data-stage="' + issue.stage + '" data-id="' + issue.id + '" title="Fix"><i class="fas fa-wrench"></i></button>';
                if (issue.stage == 2) {
                    rows += '<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                                       <i class="fas fa-wrench"></i>\
                                   </button>\
                                   <div class="dropdown-menu">\
                                       <a class="dropdown-item btn-fix" href="#" data-stage="' + issue.stage + '" data-id="' + issue.id + '" title="software" >Software</a>\
                                       <a class="dropdown-item btn-fix" href="#" data-stage="' + issue.stage + '" data-id="' + issue.id + '" title="hardware" >Hardware</a>\
                                   </div>';
                }
                rows += '&nbsp;<a href="/issues/' + issue.id + '" class="btn btn-primary btn-md" data-id="{{$issue->id}}" title="Details"><i class="fas fa-info-circle"></i></a>';
                if(issue.stage == 3){
                    rows += '<a href="/issues/' + issue.id + '" class="btn btn-warning btn-md btn-del" data-id="{{$issue->id}}" title="Report"><i class="fas fa-times"></i></a>';
                }           
                rows +='</div>\
                       </td>\
                   </tr>';
            });
            $('.table tbody').html(rows);
            //console.log('Heere');
            
            initDataTable();
        },
        error: function (response) {
            console.log(response);
        }
    });
}
// getIssues();


function updateToStage3(formId) {
    ableLoading($('.btn-submit'));

    // Sumbit the form of stage 3
    var formData = new FormData($('#' + formId)[0]);
    // console.log(formData);
    $.ajax({
        type: 'POST',
        url: url_issue + '/final-step/' + id,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (data) {
            // console.log(data);
            swal("Done", "The phone is fixed and the issue is closed, Thank you!", "success");
            getIssues();
            $('#' + formId + ' :input').val('');
            $('#update-to-stage-' + (stage + 1)).modal('toggle');
            ableLoading($('.btn-submit'));
        },
        error: function (response) {
            console.log(response);
            var errors = "";
            if (response.status == 404) {
                errors = response.responseJSON.message;
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
            disableLoading($('.btn-submit'));
        }
    });

    return false;
}

$(document).ready(function () {
    // Init Multi select inputs
    $('.fastsearch').select2();

    initDataTable();

    // Toggle Columns
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = listIssuesTable.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    // Button fix pop up a modal on which stage the issue in
    $('body').on('click', '.btn-fix', function () {

        id = $(this).data('id'); // get id of the issue
        stage = $(this).data('stage'); // get stage of the issue
        var imei = $('#row'+id).children().eq(2).text(); // get selected imei from table
        $('#update-to-stage-' + (stage + 1)).modal('toggle'); // toggle modal based on stage of the issue
        $('#update_imei').val(imei); // assign the imei to update_imei input (modal in stage 2) 

        // Sumbit the form of stage 2
        $('#update-frm-to-stage-2').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            
            if (isNaN($('#update_imei').val()) || ($('#update_imei').val() != '' && $('#update_imei').val().length != 15)) {
                alert('IMEI must be a valid of 15 number');
                return;
            }
            ableLoading($('.btn-submit'));

            var formData = new FormData($(this)[0]);
            $.ajax({
                type: 'POST',
                url: url_issue + '/' + id,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    // console.log(data);
                    swal("Done", "Reparation request is in process right now", "success");
                    getIssues();
                    $('#update-frm-to-stage-2 :input').val('');
                    $('#update-to-stage-' + (stage + 1)).modal('toggle');
                    disableLoading($('.btn-submit'))
                },
                error: function (response) {
                    console.log(response);
                    var errors = "";
                    if (response.status == 404) {
                        errors = response.responseJSON.message;
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
                    disableLoading($('.btn-submit'))
                }

            });

            return false;
        });

        var diagnostic = $(this).text(); // Type of the problem (software or hadware)
        $('.client-permission').hide();

        console.log(imei);
        $('.input-imei-stage-3').val(imei);
        if(imei == "999999999999999"){
            $('.input-imei-stage-3').removeAttr('readonly');
        }else{
            $('.input-imei-stage-3').attr('readonly','readonly');
        }
        
        if (diagnostic == "Hardware") {
            $('#hardware').show();
            $('#software').hide();
        } else {
            $('#hardware').hide();
            $('#software').show();
        }


        $('#update-frm-software').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            updateToStage3('update-frm-software');
        });

        $('#update-frm-hardware').submit(function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            updateToStage3('update-frm-hardware');
        });

        $('#problem_hardware').change(function () {
            var elg = false;
            var selected = $(this).find('option:selected', this);

            selected.each(function () {
                if ($(this).data('eligible') == 0) {
                    elg = true
                    return;
                }
            })

            if (elg)
                $('.client-permission').show();
            else
                $('.client-permission').hide();
        });

        $('input[type=radio][name=eligibility]').change(function () {
            if ($('#extra_problem_hardware').val() == '') {
                alert('Please Fill Other Problem First');
                return;
            }
            if (this.value == 0)
                $('.client-permission').show();
            else
                $('.client-permission').hide();
        });

    });


    /**
     * 
     * Delete an Issue
     */

     $('body').on('click','.btn-del',function(e){
         e.preventDefault();
         e.stopPropagation();
        id = $(this).data('id');
        row = $('#row'+id);
        swal({
                title: "Delete confirmation",
                text: "Do you want to delete this Request, we will keep it information for tracking reasons",
                icon: "warning",
                buttons: ["Cancel", true],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: url_issue + '/' + id,
                        dataType: 'json',
                        success: function (data) {
                            swal("Done", "Problem deleted successfully !", "success");
                            // getIssues();
                            row.fadeOut(1000, function(){ $(this).remove();});

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

            return false;

     });

    /**
     *
     * Empty all input when modal is closed
     *
     */
    $('#update-to-stage-2').on('hidden.bs.modal', function (e) {
        $('#update-frm-to-stage-2 :input').val('');
    });

    /**
     * 
     * Using this method when we use dropdown button or normale dropdown
     * on table that is using datatable
     */
    $('.table').on('show.bs.dropdown', function () {
        $('.table').css( "overflow", "inherit" );
    });
   
    $('.table').on('hide.bs.dropdown', function () {
            $('.table').css( "overflow", "auto" );
    })
});
