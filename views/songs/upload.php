<script>
    $(document).ready(function () {
        $.ajax({
            url: '<?php echo DX_ROOT_URL ?>genres/allGenreTypes/',
            method: 'get'
        }).success(function (data) {
            //console.log(data);
            data = JSON.parse(data);
            $('#genreSelect').change(function () {
               // console.log($('#genreSelect').val())
                genreTypeSelect = $('#genreTypeSelect');
                genreTypeSelect.empty();
                genreTypeSelect.append($('<option value="">-</option>'));
                genre_id = $('#genreSelect').val();
                if(genre_id){
                    for(i in data){
                        // console.log(data[i]);
                        if(data[i]['genre_id']== genre_id){
                            genreTypeSelect.append($("<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>"));
                        }
                    }
                }
            });
        });
    });


</script>
<?php

use \Lib\TokenGenerator;
if($this->isGet()){
    include_once 'lib/tokenGenerator.php';
    $randnum = new TokenGenerator();
    $randnum->getToken();
    $_SESSION['upload_token'] = $randnum->getToken();
}

?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default" id="panel-upload">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-target="#collapseUpload">
                    Add Song
                </a>
            </h4>
        </div>
        <div id="collapseUpload" class="panel-collapse collapse">
            <div class="panel-body">
                <form method="post" enctype="multipart/form-data"
                      action=<?php echo DX_ROOT_URL . 'songs/upload/' . $this->playlist_id; ?>>
                    <div class="row">
                        <div class="col-md-1">
                            <img id="defaultPlaylistImageId"
                                 src=<?php echo DX_ROOT_URL . 'content/images/playlist/default.png' ?>>
                        </div>
                        <div class="col-md-10">
                            <div>
                                <label for="titleInput">Title:</label>
                                <input name="title" type="text" id="titleInput" required="required"/>
                            </div>
                            <div>
                                <label for="artistInput">Artist:</label>
                                <textarea id="artistInput" name="artist"></textarea>
                            </div>
                            <div>
                                <label for="albumInput">Album:</label>
                                <textarea id="albumInput" name="album"></textarea>
                            </div>
                            <div>
                                <label for="genreSelect">Genre:</label>
                                <select name='genre_id' id="genreSelect">
                                    <option value="">-</option>
                                    <?php
                                    foreach ($data['genres'] as $genre) {
                                        echo "<option value={$genre['id']}>".htmlspecialchars($genre['name'])."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label for="genreTypeSelect">Genre type:</label>
                                <select name='genre_type_id' id="genreTypeSelect">
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div>
                                <label>Max upload size is 5MB</label>
                                <input type="hidden" name="MAX_FILE_SIZE" value=<?php echo MAX_UPLOAD_SIZE; ?>/>
                                <input type="file" id="fileInput" name="audio-file" accept="audio/*">
                            </div>
                            <div id="buttonContainer">
                                <input type="submit" class="btn btn-default btn-lg" value="Upload song"/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="upload_token" value="<?php echo $_SESSION['upload_token']; ?>">
                </form>

            </div>
        </div>
    </div>
</div>
