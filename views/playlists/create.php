<?php
use \Lib\TokenGenerator;

if($this->isGet()){
    include_once 'lib/tokenGenerator.php';
    $randnum = new TokenGenerator();
    $randnum->getToken();
    $_SESSION['create_playlist_token'] = $randnum->getToken();
}

?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default" id="panel1">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-target="#collapseOne">
                    Create Playlist
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <form method="post" action=<?php echo DX_ROOT_URL . 'playlists/add' ?>>
                    <div class="row">
                        <div class="col-md-2">
                            <img id="defaultPlaylistImageId"
                                 src=<?php echo DX_ROOT_URL . 'content/images/playlist/default.png' ?>>
                        </div>
                        <div class="col-md-10">
                            <div>
                                <label for="titleInput">Title:</label>
                                <input name="title" type="text" id="titleInput" required="required"/>
                            </div>
                            <div>
                                <label for="descriptionInput">Description:</label>
                                <textarea id="descriptionInput" name="description"></textarea>
                            </div>
                            <div>
                                <label for="isPrivateInput">Private:</label>
                                <input type="checkbox" id="isPrivateInput" name="isPrivate" value="1"/>
                            </div>
                            <div id="buttonContainer">
                                <input type="submit" class="btn btn-default btn-lg" value="Create playlist"/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="create_playlist_token" value="<?php echo $_SESSION['create_playlist_token']; ?>">
                </form>
            </div>
        </div>
    </div>
</div>
