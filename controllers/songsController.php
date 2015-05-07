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
    protected $contollerName = 'songs';
    protected $methodName;

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

        parent::__construct(get_class(), $this->contollerName, '/views/' . $this->contollerName . '/');
        $this->model = new \Models\SongsModel();

//        $modelsFileLocation = 'models\\' . $this->contollerName . 'Model.php';
//        include_once $modelsFileLocation;
//        $modelClass = '\Models\\' . ucfirst($this->contollerName) . 'Model';
//        $this->model = new $modelClass();
    }

    public function index($playlist_id, $pageSize = '', $page = 1)
    {
        $this->methodName = __FUNCTION__.'/'.$playlist_id ;

        $playlist_id_string = $playlist_id;
        $playlist_id = (int)$playlist_id;
        if(!isset($playlist_id) || strlen($playlist_id_string) != strlen($playlist_id) ){
            array_push($_SESSION['messages'], new notyMessage('Error getting playlist id.', 'error'));
            header('Location: ' . DX_ROOT_URL .'playlists/index/' . $this->pageSize . '/1');
        }

        $this->generatePaging($this->methodName, $pageSize, $page, $data);

        $items_count = $this->model->getPlaylistSongsCount($playlist_id);
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->contollerName . '/' . $this->methodName . $this->pageSize . '/1');
        }

        $offset = $this->pageSize * ($data['page'] - 1);
        $this->songs = $this->model->getPlaylistSongs($playlist_id, $offset, $this->pageSize);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        $this->renderView($template_file, $data);
    }

    public function add()
    {
        if ($this->isPost()) {
            $user_id = $_SESSION['user_id'];
            $playlist_title = $_POST['title'];
            $playlist_description = $_POST['description'];

            try {
                $this->model->addPlaylist($user_id, $playlist_title, $playlist_description, isset($_POST['isPrivate']));
                array_push($_SESSION['messages'], new notyMessage('Successful created playlist.', 'success'));
                // var_dump($this->pageSize);
                header('Location: ' . DX_ROOT_URL .$this->contollerName.'/index/' . $this->pageSize . '/1');
                die;
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

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
            header('Location: ' . DX_ROOT_URL . $this->contollerName.'/index');
            die;
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }

      //  $this->index();
    }

    public function all($pageSize = '', $page = 1)
    {
        $this->methodName = __FUNCTION__;
        $this->generatePaging($this->methodName , $pageSize, $page, $data);

        $offset = $this->pageSize * ($data['page'] - 1);
        $this->playlists = $this->model->getAllPublicPlaylists( $offset, $this->pageSize);

        $items_count = $this->model->getPublicPlaylistsCount();
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->contollerName . '/' . $this->methodName . '/' . $this->pageSize . '/1');
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'all.php';
        $this->renderView($template_file, $data);
    }


} 