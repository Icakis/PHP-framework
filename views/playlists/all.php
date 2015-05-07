<script>
    function loadComments(el) {
        var container = $($(el).attr('data-target'))[0];
        var playlistId = $(container).attr('data-playlist-id');
        console.log(playlistId);
//        console.log(container);
        $.ajax({
            url: '<?php echo DX_ROOT_URL ?>playlistcomments/show/' + playlistId,
            method: 'get'
        }).success(function (data) {
            $(container).html(data);
        });

    }
</script>

<?php
include_once DX_ROOT_DIR . 'views/playlists/create.php';
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
        $counter = 0;
        foreach ($data['playlists'] as $playlist) {
            $counter++;
            ?>
            <li class="playlistItem">
                <div class="row">
                    <div class="col-md-1 "><img class="playlistImageClass" alt="Playlist image"
                                                src=<?php echo DX_ROOT_URL . 'content/images/playlist/default.png'; ?>>
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
                            <label class="col-md-12">Creator: <a
                                    href=<?php echo DX_ROOT_URL . 'users/show/' . $playlist['username'] ?>><?php echo $playlist['username'] ?></a></label>
                        </div>
                        <div class="row">
                            <label class="col-md-12">Songs: <?php echo $playlist['songs_count']; ?></label>
                        </div>
                        <div class="row">
                            <label class="col-md-12">Date
                                created: <?php $date = new DateTime($playlist['date_created']);
                                echo date_format($date, TIME_FORMAT); ?></label>
                        </div>
                    </div>
                    <div class="col-md-5 likesCountContainer ">
                        <div class="row vertical-align">
                            <div class="col-md-4">
                                <div class="row ">
                                    <form method="post">
                                        <input type="hidden" name="like" value="1">
                                        <button type="submit" class="cleanStyleButton" disabled><span
                                                class="glyphicon glyphicon-thumbs-up" style="color:blue"
                                                aria-hidden="true"></span>
                                        </button>
                                        <?php echo $playlist['likes']; ?>
                                    </form>
                                </div>
                                <div class="row">
                                    <form method="post">
                                        <input type="hidden" name="dislike" value="-1">
                                        <button type="submit" class="cleanStyleButton"><span
                                                class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                                        </button>
                                        <?php echo $playlist['dislikes']; ?>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4 vertical-align">
                                <div class="row likesBalanceContainer">
                                    <span class="glyphicon glyphicon-heart"
                                          aria-hidden="true"></span><?php echo($playlist['likes'] - $playlist['dislikes']); ?>
                                </div>
                            </div>
                            <div class="col-md-4 vertical-align">
                                <div class="row likesBalanceContainer">
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span><?php echo '0'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="accordion" style="text-align: center">
                    <a data-toggle="collapse" data-target=<?php echo "#collapseComment" . $counter ?> onclick = '
                    loadComments(this)'>Show Comments</a>
                </div>
                <div
                    id=<?php echo "collapseComment" . $counter ?> data-playlist-id=<?php echo $playlist['playlist_id']; ?>
                    class=" collapse
                ">
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

