
<?php
use \Lib\TokenGenerator;

if($this->isGet()){
    include_once 'lib/tokenGenerator.php';
    $randnum = new TokenGenerator();
    $randnum->getToken();
    $_SESSION['song_comment_token'] = $randnum->getToken();
}

?>


<form class="createCommentForm" method="post"  onsubmit="return addComment(this)">
    <div class="row">
        <div class="col-md-8">
            <textarea name="text" type="text" class="commentInput" required="required" placeholder="Your comment..."></textarea>
        </div>
        <div id="buttonContainer" class="col-md-2">
            <input type="submit" class="btn btn-default btn-lg" value="Add comment"/>
        </div>
    </div>
    <input type="hidden" name="song_comment_token" value="<?php echo $_SESSION['song_comment_token']; ?>">
</form>