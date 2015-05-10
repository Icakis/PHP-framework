<?php
$this->title='Home';
include_once 'header.php';
?>
<main class="row">


    <div class="col-md-3">
        <?php include DX_ROOT_DIR.'views/ranks/top-rated.php';;?>
    </div>
    <div class="col-md-6">
        <h1 style="text-align: center" >Music is ...</h1>
        <hr>
        <div id="homeContainer"><?php if(!isset($_SESSION['user_id'])){
                ?>
                <p>You hava to be logged-in to see content... <a href=<?php echo DX_ROOT_URL.'users/login' ?>>Login</a></p>
                <p>... or <a href=<?php echo DX_ROOT_URL.'users/register' ?>>Registered</a></p>
            <?php
            }else{
                ?>
                <p>Main content here...</p>
                <?php
            } ?>

        </div>

    </div>
    <div class="col-md-3">
        <?php include DX_ROOT_DIR.'views/genres/index.php';?>
    </div>
</main>
<?php


include_once 'footer.php';
