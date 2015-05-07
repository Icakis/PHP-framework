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
include_once DX_ROOT_DIR . 'views/partials/select_page_size.php';
include_once DX_ROOT_DIR . 'views/partials/filter_by_text.php';

if (isset($data['items_count'])) {
    echo "<div>Founded playlist: <span>{$data['items_count']}</span></div>";
}

if (count($data['playlists']) > 0) {
    // var_dump($data);
    ?>
    <ul>
        <?php
        foreach ($data['playlists'] as $playlist) {
            ?>
            <li class="row playlistItem">
                <div class="col-md-1 "><img class="playlistImageClass" alt="Playlist image" src=<?php echo DX_ROOT_URL . 'content/images/playlist/default.png'; ?>>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <h4 class="col-md-9">Title: <a
                                href=<?php echo DX_ROOT_URL . 'songs/index/' . $playlist['id'] ?>><?php echo $playlist['title']; ?></a>
                        </h4>

                        <div class="col-md-3">
                            <label>Public:</label>
                            <?php
                            if ($playlist['is_private']) {
                                echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                            } else {
                                echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-12">Songs: <?php echo $playlist['songs_count']; ?></label>
                    </div>
                    <div class="row">
                        <label class="col-md-12">Date created: <?php $date = new DateTime($playlist['date_created']);
                            echo date_format($date, 'd M Y H:i:s'); ?></label>
                    </div>
                </div>
                <div class="col-md-3 likesCountContainer ">
                    <div class="row vertical-align">
                        <div class="col-md-4">
                            <div class="row ">
                                <form method="post">
                                    <input type="hidden" name="like" value="1">
                                    <button type="submit" class="cleanStyleButton" disabled><span class="glyphicon glyphicon-thumbs-up" style="color:blue" aria-hidden="true"></span>
                                    </button>
                                    <?php echo $playlist['likes']; ?>
                                </form>
                            </div>
                            <div class="row">
                                <form method="post">
                                    <input type="hidden" name="dislike" value="-1">
                                    <button type="submit" class="cleanStyleButton"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
                                    <?php echo $playlist['dislikes']; ?>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 vertical-align">
                            <div class="row likesBalanceContainer">
                                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span><?php echo($playlist['likes'] - $playlist['dislikes']); ?>
                            </div>
                        </div>
                        <div class="col-md-4 vertical-align">
                            <div class="row likesBalanceContainer">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span><?php echo '0'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row playlistActionContainer"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>Actions</div>
                    <div class="row">
                        <a href=<?php echo DX_ROOT_URL . $this->contollerName . '/delete/' . $playlist['id'] ?>>
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Delete</a>
                    </div>
                    <div class="row">
                        <a href=<?php echo DX_ROOT_URL . $this->contollerName . '/edit/' . $playlist['id'] ?>>
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Edit</a>
                    </div>
                </div>
            </li>
        <?php
        }
        ?>
    </ul>

<?php
} else {
    echo "<p>No playlists.</p>";
}

include_once DX_ROOT_DIR . 'views/partials/paging.php';
?>

