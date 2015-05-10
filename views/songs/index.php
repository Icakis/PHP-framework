<script>
    function loadComments(el) {
        var defaultText = 'Show Comments';
        if ($(el).text() == defaultText) {
            var container = $($(el).attr('data-target'))[0];
            var songId = $(container).attr('data-song-id');
//        console.log(playlistId);
//        console.log(container);
            $.ajax({
                url: '<?php echo DX_ROOT_URL ?>songcomments/show/' + songId,
                method: 'get'
            }).success(function (data) {
                $(container).html(data);
            });

            $(el).text('Hide Comments');
        } else {
            $(el).text(defaultText);
        }
    }

    function addComment(el) {
        var commentText = $($(el))[0].getElementsByTagName('textarea')[0].value;
        var commentToken = $(el)[0][2].value;
//        var container = $($(el).parent().attr('data-target'))[0];
//        var playlistId = $(container).attr('data-playlist-id');
        var playlistId = $(el).parent().attr('data-song-id');
//        console.log(container);

        $.ajax({
            url: '<?php echo DX_ROOT_URL ?>songcomments/add/' + playlistId,
            method: 'post',
            data: {
                "text": commentText,
                "song_comment_token": commentToken
            }
        }).success(function (data) {
            commentText = '';

            return location.reload();

        }).error(function () {
            return false
        });

    }

    function vote(el) {
        song_id = $(el).data('song-id');
        rank_value = $(el).find('input[name="vote-value"]').val();
        voteToken = $(el).find('input[name="vote_song_token"]').val();

        $.ajax({
            url: '<?php echo DX_ROOT_URL ?>ranks/ranksong/' + song_id + '/' + rank_value,
            method: 'post',
            data:{
                "vote-value":rank_value,
                "vote_song_token": voteToken
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
    $_SESSION['vote_song_token'] = $randnum->getToken();
}

if ($data['is_users_playlist']) {
    include_once DX_ROOT_DIR . 'views/songs/upload.php';
//    $this->upload($this->playlist_id);
}

include_once DX_ROOT_DIR . 'views/partials/select_page_size.php';
$data['search_placeholder'] = 'search in songs names ...';
include_once DX_ROOT_DIR . 'views/partials/filter_by_text.php';


if (isset($data['items_count'])) {
    echo "<div>Founded songs: <span>{$data['items_count']}</span></div>";
}

if (count($data['songs']) > 0) {
    // var_dump($data);
    echo "<h2 class='playlistTitleHeading'>" . htmlspecialchars($data['songs'][0]['playlist_title']) . "</h2>";
    ?>
    <ul>
        <?php
        $counter = 0;
        foreach ($data['songs'] as $song) {
            $counter++;
            ?>
            <li class="playlistItem">
                <div class="row">
                    <div class="col-lg-12 playerContainer">
                        <audio controls class="player">
                            <source
                                src=<?php echo DX_ROOT_URL . 'content/songs/' . $song['file_name'] ?> type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1 ">
                        <a href=<?php echo DX_ROOT_URL . 'content/songs/' . $song['file_name'] ?> download=<?php echo $song['file_name'] ?> ><img
                                class="playlistImageClass" alt="Song image"
                                src=<?php echo DX_ROOT_URL . 'content/images/song/download-song-icon.png'; ?>></a>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <h4><?php echo htmlspecialchars($song['song_title']) . ' - ' . htmlspecialchars($song['song_artist']); ?></h4>
                        </div>
                        <div class="row">
                            <h4>Album: <?php echo htmlspecialchars($song['song_album']); ?></h4>
                        </div>
                        <?php
                        if (isset($song['genre_name']) && $song['genre_name']) {
                            ?>
                            <div class="row">
                                <h4>Genre: <?php echo htmlspecialchars($song['genre_name']); ?></h4>
                            </div>
                        <?php
                        }
                        if (isset($song['genre_name']) && $song['genre_type_name']) {
                            ?>
                            <div class="row">
                                <h4>Genre style: <?php echo htmlspecialchars($song['genre_type_name']); ?></h4>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="row">
                            <h4>Uploader: <a
                                    href=<?php echo DX_ROOT_URL . 'users/show/' . $song['user_id'] ?>><?php echo htmlspecialchars($song['username']); ?></a>
                            </h4>
                        </div>
                        <div class="row">
                            <h4>Date uploaded: <?php $date = new DateTime($song['date_added']);
                                echo date_format($date, TIME_FORMAT); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-5 likesCountContainer ">
                        <div class="row vertical-align">
                            <div class="col-md-4">
                                <div class="row ">
                                    <form method="post" onsubmit="return vote(this)"
                                          data-song-id=<?php echo $song['song_id']; ?>>
                                        <input type="hidden" name="vote-value" value="1">
                                        <input type="hidden" name="vote_song_token" value="<?php echo $_SESSION['vote_song_token']; ?>">
                                        <button type="submit" class="cleanStyleButton"
                                            <?php
                                            $is_liked = !$this->isAuthorize() || (isset($song['rank_stats']) && $song['rank_stats']['is_like']);
                                            if ($is_liked) {
                                                echo "disabled='disabled'";
                                            }
                                            ?>><span class="glyphicon glyphicon-thumbs-up<?php if ($is_liked) {
                                                echo " liked";
                                            } ?>" aria-hidden="true"></span>
                                        </button>
                                        <?php  if ($song['likes_sum']) {
                                            echo $song['likes_sum'];
                                        } else {
                                            echo '0';
                                        }; ?>
                                    </form>
                                </div>
                                <div class="row">
                                    <form method="post" onsubmit="return vote(this)"
                                          data-song-id=<?php echo $song['song_id']; ?>>
                                        <input type="hidden" name="vote-value" value="-1">
                                        <input type="hidden" name="vote_song_token" value="<?php echo $_SESSION['vote_song_token']; ?>">
                                        <button type="submit" class="cleanStyleButton"
                                            <?php
                                            $is_disliked = !$this->isAuthorize() || (isset($song['rank_stats']) && $song['rank_stats']['is_dislike']);
                                            if ($is_disliked) {
                                                echo "disabled='disabled'";
                                            }
                                            ?>><span class="glyphicon glyphicon-thumbs-down<?php if ($is_disliked) {
                                                echo " disliked";
                                            } ?>" aria-hidden="true"></span>
                                        </button>
                                        <?php
                                        if ($song['dislikes_sum']) {
                                            echo $song['dislikes_sum'];
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
                                          aria-hidden="true"></span><?php echo($song['likes_sum'] - $song['dislikes_sum']); ?>
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
                    id=<?php echo "collapseComment" . $counter ?> data-song-id=<?php echo $song['song_id']; ?>
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
    echo "<p>No songs.</p>";
}

include_once DX_ROOT_DIR . 'views/partials/paging.php';
?>

