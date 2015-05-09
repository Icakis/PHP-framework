<?php

namespace Controllers;

use Lib\notyMessage;

class RanksController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Rank';

    // required fields
    protected $pageSize;
    protected $controllerName = 'ranks';
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
        $this->model = new \Models\RanksModel();
    }

    public function index($pageSize = '', $page = 1, $filter = null)
    {
        $this->mine($pageSize, $page, $filter);
    }

    public function rankplaylist($playlist_id, $is_like, $pageSize = '', $page = 1, $filter = null)
    {
        if($this->isPost()){
            try {
                if ($is_like != '-1' && $is_like != '1') {

                    throw new \Exception('Invalid vote vaule');
                }

                if (strlen((int)$playlist_id) != strlen( $playlist_id )) {

                    throw new \Exception('Invalid playlist id');
                }


                $is_like = (int) $is_like;
                if($is_like === 1){
                    $is_like = true;
                }else{
                    $is_like = false;
                }

                $playlist_id = (int)$playlist_id;

                $this->model->rankPlaylist($playlist_id, $_SESSION['user_id'], $is_like);
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
                die;
            }


            if($is_like){
                $message ='Succesfully like playlist';
            }else{
                $message ='Succesfully dislike playlist';
            }

            array_push($_SESSION['messages'], new notyMessage($message, 'success'));
        }
    }

    public function getplaylistrank($playlist_id)
    {
        if ($this->isPost()) {
            $user_id = $_SESSION['user_id'];

            try {
                return $this->model->getPlaylistLikesDislikes($playlist_id);
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