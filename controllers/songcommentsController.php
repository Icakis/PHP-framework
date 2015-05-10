<?php

namespace Controllers;

use Lib\notyMessage;

class SongcommentsController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Song Comments';
    protected $comments;

    // required fields
    protected $pageSize;
    protected $controllerName = 'songcomments';
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
        $this->model = new \Models\SongCommentsModel();

//        $modelsFileLocation = 'models\\' . $this->contollerName . 'Model.php';
//        include_once $modelsFileLocation;
//        $modelClass = '\Models\\' . ucfirst($this->contollerName) . 'Model';
//        $this->model = new $modelClass();
    }

    public function index($pageSize = '', $page = 1, $filter = null)
    {
        $this->show($pageSize, $page, $filter);
    }

    public function show($song_id, $pageSize = null, $page = 1, $filter = null)
    {
        $this->methodName = __FUNCTION__ . '/' . $song_id;
        if ($filter) {
            $filter = urldecode($filter);
        }

        $this->generatePaging($this->methodName, $pageSize, $page, $data, $filter);
        if (isset($_POST['search'])) {
            if (!isset($_POST['search_token']) || $_POST['search_token'] != $_SESSION['search_token']) {
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }

            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1/' . urlencode($_POST['search']));
            die;
        }

        $items_count = $this->model->songCommentsCount($song_id, $filter);
        $data['items_count'] = $items_count;
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        $data['filter'] = $filter;
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1');
        }

        $offset = $this->pageSize * ($data['page'] - 1);

        $data['song_comments'] = $this->model->songComments($song_id, $offset, $this->pageSize, $filter);
        $template_file = DX_ROOT_DIR . $this->views_dir . 'show.php';
        $this->renderView($template_file, $data, false);
    }

    public function add($song_id)
    {
        if ($this->isPost()) {
            if (!isset($_POST['song_comment_token']) || $_POST['song_comment_token'] != $_SESSION['song_comment_token']) {
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }

            try {
                $user_id = $_SESSION['user_id'];
                $comment = $_POST['text'];
                $song_id = (int)$song_id;
                $this->model->addSongComment($song_id, $user_id, $comment);
                array_push($_SESSION['messages'], new notyMessage('Successful comment added.', 'success'));
//                header('Location: ' . DX_ROOT_URL . '/songs/' . $this->pageSize . '/1');
                die;
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }
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


} 