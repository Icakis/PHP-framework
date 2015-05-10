<script>
    function loadComments(el) {
        var defaultText = 'Show Comments';
        if ($(el).text() == defaultText) {
            var container = $($(el).attr('data-target'))[0];
            var playlistId = $(container).attr('data-playlist-id');
//        console.log(playlistId);
//        console.log(container);
            $.ajax({
                url: '<?php echo DX_ROOT_URL ?>playlistcomments/show/' + playlistId,
                method: 'get'
            }).success(function (data) {
                $(container).html(data);
            });

            $(el).text('Hide Comments');
        } else {
            $(el).text(defaultText);
        }
        ;
    }

    function addComment(el) {
        var commentText = $($(el))[0].getElementsByTagName('textarea')[0].value;
        var commentToken = $(el)[0][2].value;
//        var container = $($(el).parent().attr('data-target'))[0];
//        var playlistId = $(container).attr('data-playlist-id');
        var playlistId = $(el).parent().attr('data-playlist-id');
//        console.log(container);

        $.ajax({
            url: '<?php echo DX_ROOT_URL ?>playlistcomments/add/' + playlistId,
            method: 'post',
            data: {"text": commentText,
                "comment_token": commentToken}
        }).success(function (data) {
            commentText = '';

            return false;
        }).error(function () {
            return false
        });
    }

    function vote(el) {
        playlist_id = $(el).data('playlist-id');
        rank_value = $(el).find('input[name="vote-value"]').val();
        voteToken = $(el).find('input[name="vote_token"]').val();

        $.ajax({
            url: '<?php echo DX_ROOT_URL ?>ranks/rankplaylist/' + playlist_id + '/' + rank_value,
            method: 'post',
            data:{
                "vote-value":rank_value,
                "vote_token": voteToken
            }
        }).success(function (data) {
            return location.reload();
        }).error(function (e) {
            console.log(e);
        });

        return false;
    }
</script>

<?php
use \Lib\TokenGenerator;
if($this->isGet()){
    include_once 'lib/tokenGenerator.php';
    $randnum = new TokenGenerator();
    $randnum->getToken();
    $_SESSION['vote_token'] = $randnum->getToken();
}


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
                    <div class="col-md-4">
                        <div class="row">
                            <h4 class="col-md-9">Title: <a
                                    href=<?php echo DX_ROOT_URL . 'songs/index/' . $playlist['playlist_id'] ?>><?php echo htmlspecialchars($playlist['title']); ?></a>
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
                                    href=<?php echo DX_ROOT_URL . 'users/show/' . $playlist['username'] ?>><?php echo htmlspecialchars($playlist['username']); ?></a></label>
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
                    <div class="col-md-4 likesCountContainer ">
                        <div class="row vertical-align">
                            <div class="col-md-4">
                                <div class="row ">
                                    <form method="post" onsubmit="return vote(this)"
                                          data-playlist-id=<?php echo $playlist['playlist_id']; ?>>
                                        <input type="hidden" name="vote-value" value="1">
                                        <input type="hidden" name="vote_token" value="<?php echo $_SESSION['vote_token']; ?>">
                                        <button type="submit" class="cleanStyleButton"
                                            <?php
                                            $is_liked = !$this->isAuthorize() || (isset($playlist['rank_stats']) && $playlist['rank_stats']['is_like']);
                                            if ($is_liked) {
                                                echo "disabled='disabled'";
                                            }
                                            ?>><span class="glyphicon glyphicon-thumbs-up<?php if ($is_liked) {
                                                echo " liked";
                                            } ?>" aria-hidden="true"></span>
                                        </button>

                                        <?php  if ($playlist['likes_sum']) {
                                            echo $playlist['likes_sum'];
                                        } else {
                                            echo '0';
                                        }; ?>
                                    </form>
                                </div>
                                <div class="row">
                                    <form method="post" onsubmit="return vote(this)"
                                          data-playlist-id=<?php echo $playlist['playlist_id']; ?>>
                                        <input type="hidden" name="vote-value" value="-1">
                                        <input type="hidden" name="vote_token" value="<?php echo $_SESSION['vote_token']; ?>">
                                        <button type="submit" class="cleanStyleButton"
                                            <?php
                                            $is_disliked = !$this->isAuthorize() || (isset($playlist['rank_stats']) && $playlist['rank_stats']['is_dislike']);
                                            if ($is_disliked) {
                                                echo "disabled='disabled'";
                                            }
                                            ?>><span class="glyphicon glyphicon-thumbs-down<?php if ($is_disliked) {
                                                echo " disliked";
                                            } ?>" aria-hidden="true"></span>
                                        </button>

                                        <?php
                                        if ($playlist['dislikes_sum']) {
                                            echo $playlist['dislikes_sum'];
                                        } else {
                                            echo '0';
                                        };
                                        ?>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4 vertical-align">
                                <div class="row likesBalanceContainer">
                                    <span class="glyphicon glyphicon-heart"
                                          aria-hidden="true"></span><?php echo($playlist['likes_sum'] - $playlist['dislikes_sum']); ?>
                                </div>
                            </div>
                            <div class="col-md-4 vertical-align">
                                <div class="row likesBalanceContainer">
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span><?php echo '0'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row playlistActionContainer"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>Actions</div>
                        <div class="row">
                            <a href=<?php echo DX_ROOT_URL . $this->controllerName . '/delete/' . $playlist['id'] ?>>
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Delete</a>
                        </div>
                        <div class="row">
                            <a href=<?php echo DX_ROOT_URL . $this->controllerName . '/edit/' . $playlist['id'] ?>>
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Edit</a>
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

