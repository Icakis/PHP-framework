<?php

namespace Controllers;

use Lib\notyMessage;

class PlaylistcommentsController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Playlist Comments';
    protected $comments;

    // required fields
    protected $pageSize;
    protected $controllerName = 'playlistcomments';
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

        parent::__construct(get_class(), $this->controllerName, '/views/' . $this->controllerName . '/');
        $this->model = new \Models\PlaylistCommentsModel();

//        $modelsFileLocation = 'models\\' . $this->contollerName . 'Model.php';
//        include_once $modelsFileLocation;
//        $modelClass = '\Models\\' . ucfirst($this->contollerName) . 'Model';
//        $this->model = new $modelClass();
    }

    public function index($pageSize = '', $page = 1, $filter = null)
    {
        $this->show($pageSize, $page, $filter);
    }

    public function show($playlist_id, $pageSize = null, $page = 1, $filter = null)
    {
        $this->methodName = __FUNCTION__.'/'.$playlist_id;
        if ($filter) {
            $filter = urldecode($filter);
        }

        $this->generatePaging($this->methodName, $pageSize, $page, $data, $filter);
        if (isset($_POST['search'])) {
            if(!isset($_POST['search_token']) || $_POST['search_token'] != $_SESSION['search_token']){
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }

            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1/' . urlencode($_POST['search']));
            die;
        }



        $items_count = $this->model->getPlaylistCommentsCount($playlist_id, $filter);
        $data['items_count'] = $items_count;
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        $data['filter'] = $filter;
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1');
        }

        $offset = $this->pageSize * ($data['page'] - 1);

        $data['playlist_comments'] = $this->model->getPlaylistComments($playlist_id, $offset, $this->pageSize, $filter);
        $template_file = DX_ROOT_DIR . $this->views_dir . 'show.php';
        $this->renderView($template_file, $data, false);
    }

    public function add($playlist_id)
    {
        if ($this->isPost()) {
            if(!isset($_POST['comment_token']) || $_POST['comment_token'] != $_SESSION['comment_token']){
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }

            $user_id = $_SESSION['user_id'];
            $comment = $_POST['text'];

            try {
                $playlist_id = (int)$playlist_id;
                $this->model->addPlaylistComment($playlist_id, $user_id, $comment);
                array_push($_SESSION['messages'], new notyMessage('Successful comment added.', 'success'));
                header('Location: ' . DX_ROOT_URL . $this->controllerName . '/playlists/' . $this->pageSize . '/1');
                die;
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

//        $this->index();
    }

    public function delete($delete_playlist_id)
    {
        try {
            $user_id = $_SESSION['user_id'];
            if (!$this->model->deletePlaylist($user_id, $delete_playlist_id)) {
                throw new \Exception('Cannot delete playlist.');
            }

            array_push($_SESSION['messages'], new notyMessage('Playlist deleted.', 'success'));
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/mine');
            die;
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }

        $this->index();
    }

    public function all($pageSize = '', $page = 1, $filter = null)
    {
        $this->methodName = __FUNCTION__;

        if ($filter) {
            $filter = urldecode($filter);
        }

        $this->generatePaging($this->methodName, $pageSize, $page, $data, $filter);

        if (isset($_POST['search'])) {
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1/' . urlencode($_POST['search']));
            die;
        }


        $items_count = $this->model->getPublicPlaylistsCount($filter);
        $data['items_count'] = $items_count;
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        $data['filter'] = $filter;
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1/' . $filter);
        }

        $offset = $this->pageSize * ($data['page'] - 1);
        $data['playlists'] = $this->model->getAllPublicPlaylists($offset, $this->pageSize, $filter);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'all.php';
        $this->renderView($template_file, $data);
    }
} 