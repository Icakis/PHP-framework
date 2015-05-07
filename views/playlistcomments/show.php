<?php
if (count($data['playlist_comments']) > 0) {
    ?>
    <ul class="playlistCommentUL">
        <?php
        foreach ($data['playlist_comments'] as $comment) {
            ?>
            <li class="playlistCommentItem">
                <div>
                    <a href=<?php echo DX_ROOT_URL .  'users/show/' . $comment['username'] ?>><?php echo htmlspecialchars($comment['username']); ?></a>
                    <time><?php $date = new DateTime($comment['date_created']); echo date_format($date, TIME_FORMAT); ?></time>
                </div>
                <hr>
                <div>
                    <p><?php echo htmlspecialchars($comment['text']); ?></p>
                </div>
            </li>
        <?php
        }
        ?>
    </ul>
<?php
}else{
    echo "<p class='noComment'>No comments.</p>";
}

if ($this->isAuthorize()) {
    include_once DX_ROOT_DIR . 'views/playlistcomments/create.php';
}

