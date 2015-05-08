<?php

namespace Controllers;

use Lib\notyMessage;

class SongsController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Songs';
    protected $songs;

    // required fields
    protected $pageSize;
    protected $controllerName = 'songs';
    protected $methodName;
    protected $playlist_id;

    public function __construct()
    {
        if (!$this->isAuthorize()) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            array_push($_SESSION['messages'], new notyMessage('Login first!!', 'alert'));
            header('Location: ' . DX_ROOT_URL . 'users/login');
            die;
        }

        if (!isset($_SESSION['page_size'])) {
            $this->pageSize = PAGE_SIZE;
        } else {
            $this->pageSize = $_SESSION['page_size'];
        }

        parent::__construct(get_class(), $this->controllerName, '/views/' . $this->controllerName . '/');
        $this->model = new \Models\SongsModel();

//        $modelsFileLocation = 'models\\' . $this->contollerName . 'Model.php';
//        include_once $modelsFileLocation;
//        $modelClass = '\Models\\' . ucfirst($this->contollerName) . 'Model';
//        $this->model = new $modelClass();
    }

    public function index($playlist_id, $pageSize = '', $page = 1, $filter = null)
    {
        $this->methodName = __FUNCTION__ . '/' . $playlist_id;
        if ($filter) {
            $filter = urldecode($filter);
        }

        $playlist_id_string = $playlist_id;
        $playlist_id = (int)$playlist_id;
        if (!isset($playlist_id) || strlen($playlist_id_string) != strlen($playlist_id)) {
            array_push($_SESSION['messages'], new notyMessage('Error getting playlist id.', 'error'));
            header('Location: ' . DX_ROOT_URL . 'playlists/index/' . $this->pageSize . '/1');
        }

        $this->playlist_id = $playlist_id;

        $this->generatePaging($this->methodName, $pageSize, $page, $data, $filter);
        if (isset($_POST['search'])) {
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1/' . urlencode($_POST['search']));
            die;
        }

        $items_count = $this->model->getPlaylistSongsCount($playlist_id, $filter);
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->contollerName . '/' . $this->methodName . $this->pageSize . '/1');
        }

        $offset = $this->pageSize * ($data['page'] - 1);
        $data['songs'] = $this->model->getPlaylistSongs($playlist_id, $offset, $this->pageSize, $filter);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        $this->renderView($template_file, $data);
    }

    public function upload($playlist_id)
    {
        $this->methodName = 'index/' . $playlist_id;
        if ($this->isPost()) {
            $user_id = $_SESSION['user_id'];
            $song_title = $_POST['title'];
            $song_artist = $_POST['artist'];
            $song_album = $_POST['album'];
            if(isset($_POST['genre_id'])){
                $song_genre_id = $_POST['genre_id'];
            }else{
                $song_genre_id = '';
            }

            $song_genre_type_id = $_POST['genre_type_id'];

            //TODO check file size with $_FILE
            try {
                $playlist_id_string = $playlist_id;
                $playlist_id = (int)$playlist_id;
                if ($playlist_id == 0 || strlen($playlist_id) != strlen($playlist_id_string)) {
                    throw new \Exception('Invalid playlist id.');
                }
                // Undefined | Multiple Files | $_FILES Corruption Attack
                // If this request falls under any of them, treat it invalid.
                if (!isset($_FILES['audio-file']['error'])) {
                    throw new \Exception("Sorry, invalid file or uploading failed.");
                }

                if (is_array($_FILES['audio-file']['error'])) {
                    throw new \Exception("Only single file can be uploaded.");
                }

                // Check $_FILES['audio-file']['error'] value.
                switch ($_FILES['audio-file']['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new \RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new \RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new \RuntimeException('Unknown errors.');
                }

                // Check file size
                if ($_FILES['audio-file']['size'] > MAX_UPLOAD_SIZE) {
                    throw new \Exception("Sorry, your file is too large.");
                    $uploadOk = 0;
                }


                $upload_mime_type = strtolower($_FILES['audio-file']['type']);

                if (!($upload_mime_type != 'audio/mp3' ||
                    $upload_mime_type != 'audio/mpeg' ||
                    $upload_mime_type != 'audio/ogg' ||
                    $upload_mime_type != 'audio/wav' ||
                    $upload_mime_type != 'audio/wave')
                ) {
                    throw new \Exception('Unsupported filetype uploaded.');
                }

                // Supported >= PHP 5.3
//                // DO NOT TRUST $_FILES['audio-file']['mime'] VALUE !!
//                // Check MIME Type by yourself.
//                $finfo = new \finfo(FILEINFO_MIME_TYPE);
//                if (false === $ext = array_search(
//                        $finfo->file($_FILES['audio-file']['tmp_name']),
//                        array(
//                            'mp3' => 'audio/mpeg',
//                            'ogg' => 'audio/ogg',
//                            'wav' => 'audio/wav',
//                        ),
//                        true
//                    )) {
//                    throw new \RuntimeException('Invalid file format.');
//                }
                $file_name = $_FILES['audio-file']['name'];
                $uploadfile = UPLOAD_DIR . basename($_FILES['audio-file']['name']);

                // TODO: check existing file name and rename upload file
                if (file_exists($uploadfile)) {
                    $x = 1;
                    do {
                        $file_name = "($x)" . $_FILES['audio-file']['name'];
                        $uploadfile = UPLOAD_DIR . basename($file_name);
                        $x++;
                    } while (file_exists($uploadfile));
                }

                if (move_uploaded_file($_FILES['audio-file']['tmp_name'], $uploadfile)) {
                    // echo "File is valid, and was successfully uploaded.\n";
                } else {
                    throw new \Exception('Possible file upload attack!');
                }

                // $this->model->addPlaylist($user_id, $playlist_title, $playlist_description, isset($_POST['isPrivate']));
                $this->model->addPlaylistSong($playlist_id, $user_id, $song_title, $song_artist, $file_name, $song_album, $song_genre_id, $song_genre_type_id);
                array_push($_SESSION['messages'], new notyMessage('Successful song added.', 'success'));
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

        header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize.'/' );
        // $this->index();
    }

    public function delete($delete_playlist_id)
    {
        try {
            $user_id = $_SESSION['user_id'];
            if (!$this->model->deletePlaylist($user_id, $delete_playlist_id)) {
                throw new \Exception('Cannot delete playlist.');
            }

            array_push($_SESSION['messages'], new notyMessage('Playlist deleted.', 'success'));
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/index');
            die;
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }

        //  $this->index();
    }

    public function all($pageSize = '', $page = 1)
    {
        $this->methodName = __FUNCTION__;
        $this->generatePaging($this->methodName, $pageSize, $page, $data);

        $offset = $this->pageSize * ($data['page'] - 1);
        $this->playlists = $this->model->getAllPublicPlaylists($offset, $this->pageSize);

        $items_count = $this->model->getPublicPlaylistsCount();
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1');
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'all.php';
        $this->renderView($template_file, $data);
    }


} 