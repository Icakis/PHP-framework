<div class="panel panel-default" id="genres-panel">
    <div class="panel-heading">Top Rated Playlists</div>
    <div class="panel-body">
        <ul class="list-group" id="top-rated-list">
            <?php foreach ($this->data['top-playlists'] as $playlist) { ?>
                <li class="genre_li row">
                    <div class="li-bullet col-md-1 collapsed">
                        <a class="collapseSymbol" data-toggle="collapse"
                           data-target=<?php echo '#collapse' . $playlist['playlist_id']; ?>>
                            <img id="noteBulletId" src=<?php echo DX_ROOT_URL . 'content/images/genres/notebullet.png' ?>>
                        </a>
                    </div>
                    <div class="col-md-10">
                        <a href=<?php echo DX_ROOT_URL . 'songs/index/' . $playlist['playlist_id']; ?> class="list-group-item
                           the_genre">
                        <?php echo htmlspecialchars($playlist['title']); ?>
                        </a>
                    </div>
                </li>
            <?php } ?>
    </div>
    </ul>
</div>
