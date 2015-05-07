
<?php

include_once DX_ROOT_DIR.'views/partials/select_page_size.php';

if (count($this->songs) > 0) {
    // var_dump($data);
    ?>
    <ul>
        <?php
        foreach ($this->songs as $song) {
            ?>
            <li>
                <audio controls>
                    <source src=<?php echo DX_ROOT_URL.'content/songs/'.$song['file_name'] ?> type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <?php echo $song['title'] ?> --- Uploader: <a href=<?php echo DX_ROOT_URL .  'users/show/' . $song['user_id'] ?>><?php echo $song['user_id']; ?></a>
            </li>
        <?php
        }
        ?>
    </ul>

<?php
} else {
    echo "<p>No Songs.</p>";
}

include_once DX_ROOT_DIR.'views/partials/paging.php';
?>

