<?php

namespace Controllers;

use Lib\notyMessage;

class GenresController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Genres';
    protected $genres;

    // required fields
    protected $pageSize;
    protected $contollerName = 'genres';
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

        parent::__construct(get_class(), $this->contollerName, '/views/' . $this->contollerName . '/');
        $this->model = new \Models\GenresModel();

//        $modelsFileLocation = 'models\\' . $this->contollerName . 'Model.php';
//        include_once $modelsFileLocation;
//        $modelClass = '\Models\\' . ucfirst($this->contollerName) . 'Model';
//        $this->model = new $modelClass();
    }

    public function index()
    {
        $this->methodName = __FUNCTION__;

        $this->genres = $this->model->getGenres();
        foreach($this->genres as  $key => $value){
            $this->genres[$key]['genres_types']= $this->model->getGenreTypesByGenreType($value['id']);
        }


        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        $this->renderView($template_file, $this->genres);
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
            header('Location: ' . DX_ROOT_URL . $this->contollerName.'/index');
            die;
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }

        $this->index();
    }

    public function allGenresAndTypes()
    {
        $this->genres = $this->model->getGenres();
        foreach($this->genres as  $key => $value){
            $this->genres[$key]['genres_types']= $this->model->getGenreTypesByGenreType($value['id']);
        }

       echo json_encode($this->genres);
    }

    public function allGenreTypes()
    {
        $this->genres = $this->model->getGenreTypesGroupByGenreId();

        echo json_encode($this->genres);
    }
} 