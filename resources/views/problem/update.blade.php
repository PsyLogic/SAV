<div class="modal fade" id="update-problem" tabindex="-1" role="dialog" aria-labelledby="update-problem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update Problem</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" id="update-frm-problem">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="content" >Content</label>
                    <input type="text" class="form-control" id="update_content" name="content" autocomplete="off" required> 
                </div>
                <div class="form-group">
                    <label for="" >Eligibility : </label>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="update_eligibility" name="eligibility" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="update_eligibility">No</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="update_eligibility2" name="eligibility" class="custom-control-input" value="1" checked>
                        <label class="custom-control-label" for="update_eligibility2">Yes</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-metal" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success float-right"><i class="far fa-edit"></i> Update</button>
            </div>
        </form>
        </div>
    </div>
</div>