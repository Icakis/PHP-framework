<?php

namespace Controllers;

use Lib\notyMessage;

class PlaylistsController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Playlists';
    protected $playlists;
    protected $pageSize = PAGE_SIZE;
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

        parent::__construct(get_class(), 'playlists', '/views/playlists/');
        include_once 'models\playlistsModel.php';
        $this->model = new \Models\PlaylistsModel();
    }

    public function index($pageSize = PAGE_SIZE, $page = 1)
    {
        $is_wrong_page_params = false;
        if (!is_int($pageSize)) {
            $pageSizeSting = $pageSize;
            $pageSize = (int)$pageSize;
            if ($pageSize <= 0 || $pageSize > 100 || strlen($pageSizeSting) != strlen($pageSize)) {
                $pageSize = PAGE_SIZE;
                $is_wrong_page_params = true;
            }else{
                $this->pageSize = $pageSize;
            }
        }

        $data['items_per_page'] = $pageSize;

        if (!is_int($page)) {
            $pageSting = $page;
            $page = (int)$page;
            if ($page <= 0 || strlen($pageSting) != strlen($page)) {
                $page = 1;
                $is_wrong_page_params = true;
            }
        }

        $data['page'] = $page;

        if ($is_wrong_page_params) {
            header('Location: ' . DX_ROOT_URL . 'playlists/index/' . $data['items_per_page'].'/1');
            die;
        }


        if ((isset($_POST['items_per_page']) && ((int)$_POST['items_per_page'] !== 0))) {
            $data['items_per_page'] = (int)$_POST['items_per_page'];
            header('Location: ' . DX_ROOT_URL . 'playlists/index/' . $data['items_per_page'].'/1');
            die;
        }


        $items_count = $this->model->getPlaylistsCount($_SESSION['user_id']);
        $data['num_pages'] = (int)ceil($items_count / $data['items_per_page']);
        if ($data['page'] > $data['num_pages']) {
            $data['page'] = 1;
            header('Location: ' . DX_ROOT_URL . 'playlists/index/'. $data['items_per_page'].'/1');
        }

        $offset = $data['items_per_page'] * ($data['page'] - 1);
        $this->playlists = $this->model->getPlaylists($_SESSION['user_id'], $offset, $data['items_per_page']);
        // var_dump($this->items);

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
                header('Location: ' . DX_ROOT_URL . 'playlists/index');
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
            header('Location: ' . DX_ROOT_URL . 'playlists/index');
            die;
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }

        $this->index();
    }
} 