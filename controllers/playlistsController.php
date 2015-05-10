<?php

namespace Controllers;

use Lib\notyMessage;

include_once '/models/ranksModel.php';

class PlaylistsController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Playlists';
    protected $playlists;

    // required fields
    protected $pageSize;
    protected $controllerName = 'playlists';
    protected $methodName;
    protected $rank_model;

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
        $this->model = new \Models\PlaylistsModel();
        $this->rank_model = new \Models\RanksModel();
    }

    public function index($pageSize = '', $page = 1, $filter = null)
    {
        $this->mine($pageSize, $page, $filter);
    }

    public function mine($pageSize = '', $page = 1, $filter = null)
    {
        $this->methodName = __FUNCTION__;
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

        $items_count = $this->model->getUserPlaylistsCount($_SESSION['user_id'], $filter);
        $data['items_count'] = $items_count;
        $data['num_pages'] = (int)ceil($items_count / $this->pageSize);
        $data['filter'] = $filter;
        if ($data['page'] > $data['num_pages'] && $data['num_pages'] != 0) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $this->methodName . '/' . $this->pageSize . '/1');
        }

        $offset = $this->pageSize * ($data['page'] - 1);

        $data['playlists'] = $this->model->getUsersPlaylists($_SESSION['user_id'], $offset, $this->pageSize, $filter);
        foreach ($data['playlists'] as $k=>$v) {
            $data['playlists'][ $k]['rank_stats'] = $this->rank_model->isPlaylistLikedByUser($v['playlist_id'], $_SESSION['user_id']);
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'mine.php';
        $this->renderView($template_file, $data);
    }

    public function add()
    {
        if ($this->isPost()) {
            if(!isset($_POST['create_playlist_token']) || $_POST['create_playlist_token'] != $_SESSION['create_playlist_token']){
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }

            $user_id = $_SESSION['user_id'];
            $playlist_title = $_POST['title'];
            $playlist_description = $_POST['description'];

            try {
                $this->model->addPlaylist($user_id, $playlist_title, $playlist_description, isset($_POST['isPrivate']));
                array_push($_SESSION['messages'], new notyMessage('Successful created playlist.', 'success'));
                // var_dump($this->pageSize);
                header('Location: ' . DX_ROOT_URL . $this->controllerName . '/mine/' . $this->pageSize . '/1');
                die;
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

        $this->index();
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
        foreach ($data['playlists'] as $k=>$v) {
            $data['playlists'][ $k]['rank_stats'] = $this->rank_model->isPlaylistLikedByUser($v['playlist_id'], $_SESSION['user_id']);
        }
        $template_file = DX_ROOT_DIR . $this->views_dir . 'all.php';
        $this->renderView($template_file, $data);
    }

    public function  isUserPlaylist($playlist_id, $user_id)
    {
        try {
            $user_id = $_SESSION['user_id'];
            return $this->isUserPlaylist($playlist_id, $user_id);
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }
    }
} 