<?php
use \Lib\TokenGenerator;
if($this->isGet()){
    include_once 'lib/tokenGenerator.php';
    $randnum = new TokenGenerator();
    $randnum->getToken();
    $_SESSION['login_token'] = $randnum->getToken();
}
?>

<div id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center">Login</h1>
            </div>
            <div class="modal-body">
                <form class="form col-md-12 center-block" name="loginForm"  method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control input-lg" placeholder="Username" required="required">
                    </div>
                    <div class="form-group">
                        <input name="pass" type="password" class="form-control input-lg" placeholder="Password" required="required">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Sign In" />
                        <p class="btn-lg text-center"><a href=<?php echo DX_ROOT_URL . 'users/register' ?>>Register</a></p>
                    </div>
                    <input type="hidden" name="login_token" value="<?php echo $_SESSION['login_token']; ?>">
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