
<?php

include_once DX_ROOT_DIR.'views/partials/select_page_size.php';

if (count($this->playlists) > 0) {
    // var_dump($data);
    ?>
    <ul>
        <?php
        foreach ($this->playlists as $playlist) {
            ?>
            <li>
                <?php echo $playlist['title'] ?> --- Author: <a href=<?php echo DX_ROOT_URL .  'users/show/' . $playlist['username'] ?>><?php echo $playlist['username'] ?></a>
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

