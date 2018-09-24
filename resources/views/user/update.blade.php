<div class="modal fade" id="update-user" tabindex="-1" role="dialog" aria-labelledby="update-user" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update User details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" id="update-frm-user">
            <div class="modal-body">
                    @csrf
                <div class="form-group">
                    <label for="name" >Full Name</label>
                    <input type="text" class="form-control" id="update_name" name="name" autocomplete="off" required> 
                </div>
                <div class="form-group">
                    <label for="username" >Username</label>
                    <input type="text" class="form-control" id="update_username" name="username" autocomplete="off" required> 
                </div>
                <div class="form-group">
                    <label for="email" >Email</label>
                    <input type="email" class="form-control" id="update_email" name="email"> 
                </div>
                <div class="form-group">
                    <label for="type" >Type</label>
                    <select class="form-control" name="type" id="update_type" required>
                        <option value=""></option>
                        <option value="SAV">SAV</option>
                        <option value="Commercial">Commercial Responsable</option>
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

<div class="modal fade" id="update-user-password" tabindex="-1" role="dialog" aria-labelledby="update-user-password" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update User Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" id="update-frm-user-password">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="password" >New Password</label>
                    <input type="password" class="form-control" id="update_password" name="password" autocomplete="off" required> 
                </div>
                <div class="form-group">
                    <label for="password_confirmation" >Re-type Passwod</label>
                    <input type="password" class="form-control" id="update_password_confirmation" name="password_confirmation" autocomplete="off" required> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning float-right"><i class="far fa-edit"></i> Update</button>
            </div>
        </form>
        </div>
    </div>
</div>