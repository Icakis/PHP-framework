<div class="panel panel-default" id="genres-panel">
    <div class="panel-heading">Genres</div>
    <div class="panel-body">
        <ul class="list-group" id="genres-list">
            <li class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10"><a href="" class="list-group-item">All</a></div>
            </li>

            <?php foreach ($this->genres as $genre) { ?>
                <li class="genre_li row">
                    <div class="li-bullet col-md-1 collapsed">
                        <?php if (count($genre['genres_types']) > 0) { ?>
                            <a class="collapseSymbol" data-toggle="collapse"
                               data-target=<?php echo '#collapse' . $genre['id']; ?>>
                                <img id="noteBulletId"
                                     src=<?php echo DX_ROOT_URL . 'content/images/genres/notebullet.png' ?>></a>
                        <?php } ?>
                    </div>
                    <div class="col-md-10">
                        <a href="" class="list-group-item the_genre">
                            <span class="badge"><?php echo $genre['genre_types_count']; ?></span>
                            <?php echo $genre['name'] ?>
                        </a>
                        <?php if (count($genre['genres_types']) > 0) { ?>
                            <div id=<?php echo 'panel' . $genre['id']; ?>>
                                <div id=<?php echo 'collapse' . $genre['id']; ?> class="panel-collapse collapse
                                ">
                                <div class="panel-body">
                                    <?php foreach ($genre['genres_types'] as $type) {
                                        echo "<a href='' class='list-group-item'>".htmlspecialchars($type['name'])."</a>";
                                    } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </li>
            <?php } ?>
    </div>
    </ul>
</div>
</div>