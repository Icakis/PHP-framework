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
        if ($this->isPost()) {
            if(!isset($_POST['vote_token']) || $_POST['vote_token'] != $_SESSION['vote_token']){
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }
            try {
                if ($is_like != '-1' && $is_like != '1') {

                    throw new \Exception('Invalid vote vaule');
                }

                if (strlen((int)$playlist_id) != strlen($playlist_id)) {

                    throw new \Exception('Invalid playlist id');
                }


                $is_like = (int)$is_like;
                if ($is_like === 1) {
                    $is_like = true;
                } else {
                    $is_like = false;
                }

                $playlist_id = (int)$playlist_id;

                $this->model->rankPlaylist($playlist_id, $_SESSION['user_id'], $is_like);
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
                die;
            }


            if ($is_like) {
                $message = 'Succesfully like playlist';
            } else {
                $message = 'Succesfully dislike playlist';
            }

            array_push($_SESSION['messages'], new notyMessage($message, 'success'));
        }
    }

    public function getplaylistrank($playlist_id)
    {
        if ($this->isPost()) {


            try {
                $user_id = $_SESSION['user_id'];
                return $this->model->getPlaylistLikesDislikes($playlist_id);
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }
    }

    public function highratedplaylists($top_count = 10)
    {
        try {
          $data['top-playlists']=  $this->model->highRatedPlaylists($top_count);
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'top-rated.php';
        $this->renderView($template_file, $data, false);
    }

    public function  isUserPlaylist($playlist_id)
    {
        try {
            $user_id = $_SESSION['user_id'];
            return $this->isUserPlaylist($playlist_id, $user_id);
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }
    }

    public function ranksong($song_id, $is_like)
    {
        if ($this->isPost()) {
            if(!isset($_POST['vote_song_token']) || $_POST['vote_song_token'] != $_SESSION['vote_song_token']){
                array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                die;
            }
            try {
                if ($is_like != '-1' && $is_like != '1') {

                    throw new \Exception('Invalid vote vaule');
                }

                if (!$song_id || strlen((int)$song_id) != strlen($song_id)) {

                    throw new \Exception('Invalid song id');
                }


                $is_like = (int)$is_like;
                if ($is_like === 1) {
                    $is_like = true;
                } else {
                    $is_like = false;
                }

                $song_id = (int)$song_id;

                $this->model->rankSong($song_id, $_SESSION['user_id'], $is_like);
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
                die;
            }


            if ($is_like) {
                $message = 'Successfully like song.';
            } else {
                $message = 'Successfully dislike song.';
            }

            array_push($_SESSION['messages'], new notyMessage($message, 'success'));
        }
    }

} 