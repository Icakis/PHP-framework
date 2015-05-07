<form class="createCommentForm" method="post" action=<?php echo DX_ROOT_URL . 'playlistcomments/add' ?>>
    <div class="row">
        <div class="col-md-8">
            <textarea name="text" type="text" id="commentInput" required="required" placeholder="Your comment..."></textarea>
        </div>
        <div id="buttonContainer" class="col-md-2">
            <input type="submit" class="btn btn-default btn-lg" value="Add comment"/>
        </div>
    </div>
</form>