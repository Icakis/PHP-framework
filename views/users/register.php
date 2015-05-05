<div id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center">Register</h1>
            </div>
            <div class="modal-body">
                <form class="form col-md-12 center-block" name="registerForm" method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control input-lg" placeholder="Username" required="required">
                    </div>
                    <div class="form-group">
                        <input name="pass" type="password" class="form-control input-lg" placeholder="Password" required="required" pattern=".{2,100}" title="Password length should be inclusive between 2 and 100.">
                    </div>
                    <div class="form-group">
                        <input name="passConfirm" type="password" class="form-control input-lg" placeholder="Confirm password" required="required" pattern=".{2,100}" title="Password length should be inclusive between 2 and 100.">
                    </div>
                    <div class="form-group">
                        <input name="name" type="text" class="form-control input-lg" placeholder="Name" required="required">
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control input-lg" placeholder="Email" required="required">
                    </div>
                    <div class="form-group">
                        <input name="phone" type="tel" class="form-control input-lg" placeholder="Phone">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Register" />
                        <p class="btn-lg text-center"><a href=<?php echo DX_ROOT_URL . 'users/login' ?>>Login</a></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12  text-center">
                    <a href=<?php echo DX_ROOT_URL ?> class="btn-lg" data-dismiss="modal" aria-hidden="true">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>