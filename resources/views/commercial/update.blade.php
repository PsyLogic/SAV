<div class="modal fade" id="update-commercial" tabindex="-1" role="dialog" aria-labelledby="update-commercial" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update Commercial details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" id="update-frm-commercial">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="update_full_name" name="full_name" required> 
                </div>
                <div class="form-group">
                    <label for="phone" >Phone</label>
                    <input type="text" class="form-control" id="update_phone" name="phone" required> 
                </div>
                <div class="form-group">
                    <label for="update_belong_to" >Belong To</label>
                    <select class="form-control" name="belong_to" id="update_belong_to">
                        <option value="FNAC">FNAC</option>
                        <option value="ORANGE">ORANGE</option>
                        <option value="JUMIA">JUMIA</option>
                        <option value="STG TELECOM">STG TELECOM</option>
                        <option value="Traditionelle">Traditionelle</option>
                    </select> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success float-right"><i class="far fa-edit"></i> Update</button>
            </div>
        </form>
        </div>
    </div>
</div>