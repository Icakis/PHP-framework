<div id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center">User profile</h1>
            </div>
            <div class="modal-body">
                <div class="form col-md-12 center-block" name="registerForm">
                    <div class="form-group">
                        <label>Username: <?php echo htmlspecialchars($data['user']['username']); ?></label>
                    </div>
                    <div class="form-group">
                        <label>Name: <?php echo htmlspecialchars($data['user']['name']); ?></label>
                    </div>
                    <div class="form-group">
                        <label>Email: <a href="<?php echo 'mailto:'.$data['user']['email'];?>"><?php echo htmlspecialchars($data['user']['email']); ?></a></label>
                    </div>
                    <div class="form-group">
                        <label>Phone: <?php echo htmlspecialchars($data['user']['phone']); ?></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12  text-center">
                    <a href=<?php echo DX_ROOT_URL ?> class="btn-lg" data-dismiss="modal" aria-hidden="true">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>