<div class="modal fade" id="update-solution" tabindex="-1" role="dialog" aria-labelledby="update-solution" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update Solution</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" id="update-frm-solution">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="content" >Content</label>
                    <input type="text" class="form-control" id="update_content" name="content" autocomplete="off" required> 
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