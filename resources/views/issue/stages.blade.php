{{-- Stage 2 --}}
<div class="modal fade" id="update-to-stage-2" tabindex="-1" role="dialog" aria-labelledby="update-to-stage-2" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Verification Step</h5>
        </div>
        <form action="" method="POST" id="update-frm-to-stage-2" enctype="multipart/form-data" >
            <div class="modal-body">
                <div class="form-group">
                    <label for="imei">IMEI</label>
                    <input type="text" class="form-control" id="update_imei" name="imei" required> 
                </div>
                <div class="form-group">
                    <label for="update_images" >Images</label>
                    <input type="file" class="form-control" id="update_images" name="images[]" accept=".png, .jpg, .jpeg" multiple required> 
                    <small class="form-text text-muted">
                        Max Upload File (6 MB), Allowed Extentions: .png, .jpg, .jpeg
                    </small> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success float-right btn-submit"><i class="far fa-edit"></i> Update</button>
            </div>
        </form>
        </div>
    </div>
</div>

{{-- Stage 3 --}}

<div class="modal fade" id="update-to-stage-3" tabindex="-1" role="dialog" aria-labelledby="update-to-stage-2" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Final Step - Resolving the issue</h5>
            </div>
            <div class="modal-body">
                <!-- Software Solution -->
                <div id="software">
                    <h3 class="text-center text-uppercase">SOFTWARE</h3>
                    <form action="" method="POST" id="update-frm-software" enctype="multipart/form-data" >
                        <input type="hidden" name="diagnostic" value="software">
                        
                        <div class="form-group">
                            <label for="imei-stage-3">IMEI</label>
                            <input type="text" class="form-control input-imei-stage-3" id="" name="imei_stage_3"> 
                        </div>
                        
                        <div class="form-group">
                            <label for="solution_software">Solution</label>
                            <select name="solution[]" id="solution_software" class="fastsearch form-control" style="width: 100%" multiple required>
                                <option value=""></option>
                                @foreach ($solutions as $solution)
                                    <option value="{{ $solution->id }}">{{$solution->content}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="extra_solution_software">Extra Solutions</label>
                            <input type="text" class="form-control" id="extra_solution_software" name="extra_solution"> 
                        </div>
                        <div class="form-group">
                            <label for="images_software" >Images</label>
                            <input type="file" class="form-control" id="images_software" name="images[]" accept=".png, .jpg, .jpeg" multiple>
                            <small class="form-text text-muted">
                                Max Upload File (6 MB), Allowed Extentions: .png, .jpg, .jpeg
                            </small> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success float-right btn-submit"><i class="far fa-edit"></i> Update</button>
                        </div>
                    </form>    
                </div>
                <!-- End Software Solution -->

                <!-- Hardware Solution -->
                <div id="hardware">
                    <h3 class="text-center text-uppercase">hardware</h3>
                    <form action="" method="POST" id="update-frm-hardware" enctype="multipart/form-data" >
                        <input type="hidden" name="diagnostic" value="hardware">
                        <div class="form-group">
                            <label for="imei-stage-3">IMEI</label>
                            <input type="text" class="form-control input-imei-stage-3" name="imei_stage_3"> 
                        </div>
                        <div class="form-group">
                            <label for="problem_hardware">Problem</label>
                            <select class="fastsearch form-control" style="width: 100%" name="problems[]" id="problem_hardware" multiple required>
                                <option value=""></option>
                                @foreach($problems as $problem)
                                <option data-eligible="{{ $problem->eligibility }}" value="{{ $problem->id }}">{{ $problem->content }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="extra-problem" style="border: 1px slid #ccc;">
                            <div class="form-group">
                                <label for="extra_problem_hardware">Other Problems</label>
                                <input type="text" class="form-control" id="extra_problem_hardware" name="extra_problem"> 
                            </div>
                            <div class="form-group">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-success active">
                                        <input type="radio" name="eligibility" id="eligible" autocomplete="off" checked value="1"> Eligible
                                    </label>
                                    <label class="btn btn-danger">
                                        <input type="radio" name="eligibility" id="no_eligible" autocomplete="off" value="0"> No Eligible
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="client-permission">
                            <div class="form-group">
                                <div class="alert alert-warning">
                                    <p>You must Call The Client for the charges</p> 
                                    <p>Full Name: {{$issue->client['full_name']}}</p> 
                                    <p>Phone: {{$issue->client['tel']}}</p> 
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="solution_hardware">Solution</label>
                            <select name="solution[]" id="solution_hardware" class="fastsearch form-control" style="width: 100%" multiple required>
                                <option value=""></option>
                                @foreach ($solutions as $solution)
                                    <option value="{{ $solution->id }}">{{$solution->content}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="extra_solution_hardware">Extra Solutions</label>
                            <input type="text" class="form-control" id="extra_solution_hardware" name="extra_solution"> 
                        </div>
                        <div class="form-group">
                            <label for="fee_hardware">Charges</label>
                            <input type="text" class="form-control" id="fee_hardware" name="charges" value="0"> 
                        </div>
                        <div class="form-group">
                            <label for="images_hardware" >Images</label>
                            <input type="file" class="form-control" id="images_hardware" name="images[]" accept=".png, .jpg, .jpeg" multiple required> 
                            <small class="form-text text-muted">
                                Max Upload File (6 MB), Allowed Extentions: .png, .jpg, .jpeg
                            </small> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success float-right btn-submit"><i class="far fa-edit"></i> Update</button>
                        </div>
                    </form>
                </div>
                <!-- End Hardware Solution -->

            </div>
            
        </div>
    </div>
</div>