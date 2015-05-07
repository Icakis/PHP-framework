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
                        </div>
                    </div>
                    <div id="buttonContainer">
                        <input type="submit" class="btn btn-default btn-lg" value="Create playlist"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php

include_once DX_ROOT_DIR.'views/partials/select_page_size.php';
include_once DX_ROOT_DIR.'views/partials/filter_by_text.php';

if (count($data['playlists']) > 0) {
   // var_dump($data);
    ?>
    <ul>
        <?php
        foreach ($data['playlists'] as $playlist) {
            ?>
            <li>
                <a href=<?php echo DX_ROOT_URL .'songs/index/' . $playlist['id'] ?>><?php echo $playlist['title'] ?></a>
                <a href=<?php echo DX_ROOT_URL . $this->contollerName. '/delete/' . $playlist['id'] ?>>Delete</a>
            </li>
        <?php
        }
        ?>
    </ul>

<?php
} else {
    echo "<p>No playlists.</p>";
}

include_once DX_ROOT_DIR.'views/partials/paging.php';
?>

