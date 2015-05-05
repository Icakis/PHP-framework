<form method="post">
    <label>Show on page:</label>
    <select name='items_per_page' onchange='this.form.submit()'>
        <option value="2" <?php if ($data['items_per_page'] === 2) echo 'selected'; ?>>2</option>
        <option value="5" <?php if ($data['items_per_page'] === 5) echo 'selected'; ?>>5</option>
        <option value="10" <?php if ($data['items_per_page'] === 10) echo 'selected'; ?>>10</option>
        <option value="20" <?php if ($data['items_per_page'] === 20) echo 'selected'; ?>>20</option>
        <option value="50" <?php if ($data['items_per_page'] === 50) echo 'selected'; ?>>50</option>
        <option value="100" <?php if ($data['items_per_page'] === 100) echo 'selected'; ?>>100</option>
    </select>
    <noscript><input type="submit" value="Submit"></noscript>
</form>

<?php
if (count($this->playlists) > 0) {
    var_dump($data);
    ?>
    <ul>
        <?php
        foreach ($this->playlists as $playlist) {
            ?>
            <li>
                <?php echo $playlist['title'] ?> <a
                    href=<?php echo DX_ROOT_URL . 'playlists/delete/' . $playlist['id'] ?>>Delete</a>
            </li>
        <?php
        }
        ?>
    </ul>

<?php
} else {
    echo "<p>No playlists.</p>";
}
?>

<div class="row" id="paginationContainer" data-ng-controller="paginationController">
    <div class="col-md-12">
        <ul class="pagination">
            <?php
            if ($data['num_pages'] > 1) {
                echo '<li><a href="#">First</a></li>';

            for ($i = 0; $i < $data['num_pages']; $i++) {
                $page_num = $i + 1;
                echo "<li><a href=\"#\">$page_num</a></li>";
            }
                echo '<li><a href="#">First</a></li>';
            }
            ?>
        </ul>
    </div>
</div>


<div class="panel-group" id="accordion">
    <div class="panel panel-default" id="panel1">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-target="#collapseOne" href="#">
                    Create Playlist
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
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
