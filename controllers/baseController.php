<?php

namespace Controllers;
include_once '/models/ranksModel.php';
include_once '/models/genresModel.php';
include_once '/models/playlistsModel.php';
class BaseController
{
    protected $layout = 'default/';
    protected $views_dir = 'views/home/';
    protected $model = null;
    protected $controller = null;
    protected $title = 'Home';


    protected $pageSize;
    protected $controllerName = 'base';
    protected $methodName;
    protected $rank_model;

    public function __construct($controllerName = '\Controllers\BaseController', $model = 'base', $views_dir = '/views/home/')
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Get caller classes
        $this->controller = $controllerName;
        $this->model = $model;
        $this->views_dir = $views_dir;

        include_once DX_ROOT_DIR . "models/{$model}Model.php";
        $model_class = "\Models\\" . ucfirst($model) . "Model";

        $this->model = new $model_class(array('table' => 'none'));

        if (!isset($_SESSION['page_size'])) {
            $this->pageSize = PAGE_SIZE;
        } else {
            $this->pageSize = $_SESSION['page_size'];
        }
    }

    public function home()
    {
        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        // var_dump($template_file);
        $this->renderView($template_file);
    }

    public function index()
    {
//        var_dump(DX_ROOT_DIR);
//        var_dump(DX_ROOT_PATH);
//        var_dump(DX_ROOT_URL);

//        include_once DX_ROOT_DIR . 'controllers/ranksController.php';

        $this->rank_model = new \Models\RanksModel();
        $this->data['top-playlists'] = $this->rank_model->highRatedPlaylists();

        $this->genres_model = new \Models\GenresModel();
        $this->genres = $this->genres_model->getGenres();
        foreach($this->genres as  $key => $value){
            $this->genres[$key]['genres_types']= $this->genres_model->getGenreTypesByGenreType($value['id']);
        }

        $this->playlists_model = new \Models\PlaylistsModel();
        include_once DX_ROOT_DIR.'controllers/playlistsController.php';
        //$c = new PlaylistsController();
        //$c->all();

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        // var_dump($template_file);

        $this->renderView($template_file);
    }

    public function renderView($viewName = null, $data = null, $includeLayout = true, $layoutName = null)
    {
        // check render file
        if ($viewName == null) {
            $viewFileName = DX_ROOT_DIR . $this->views_dir . 'index.php';
        }

        $viewFileName = $viewName;
        // var_dump($viewFileName);

        if ($includeLayout === true) {
            if ($layoutName) {
                $headerFile = DX_ROOT_DIR . 'views/layouts/' . $layoutName . '/header.php';
            } else {
                $headerFile = DX_ROOT_DIR . 'views/layouts/' . $this->layout . '/header.php';
            }

            include_once($headerFile);
        }

        include($viewFileName);

        if ($includeLayout === true) {
            if ($layoutName) {
                $footerFile = DX_ROOT_DIR . 'views/layouts/' . $layoutName . '/footer.php';
            } else {
                $footerFile = DX_ROOT_DIR . 'views/layouts/' . $this->layout . '/footer.php';
            }

            include_once($footerFile);
        }
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    protected function isAuthorize()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION) && isset($_SESSION['username']) && $_SESSION['username'] && isset($_SESSION['user_id'])) {
            // $this->logged_user = array('username' => $_SESSION['username'], 'user_id' => $_SESSION['id']);
            return true;
        }

        return false;
    }

    protected function generatePaging($actionName, $pageSize, $page, &$data, $filter = null)
    {
        $is_wrong_page_params = false;
        if (!is_int($pageSize)) {
            $pageSizeSting = $pageSize;
            $pageSize = (int)$pageSize;
            if ($pageSize <= 0 || $pageSize > 100 || strlen($pageSizeSting) != strlen($pageSize)) {
                $is_wrong_page_params = true;
            } else {
                $this->pageSize = $pageSize;
                $_SESSION['page_size'] = $pageSize;
            }
        }

        $data['items_per_page'] = $this->pageSize;

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
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $actionName . '/' . $this->pageSize . '/1/' . urlencode($filter));
            die;
        }


        if ((isset($_POST['items_per_page']) && ((int)$_POST['items_per_page'] !== 0))) {
            $data['items_per_page'] = (int)$_POST['items_per_page'];
            $this->pageSize = (int)$_POST['items_per_page'];
            header('Location: ' . DX_ROOT_URL . $this->controllerName . '/' . $actionName . '/' . $this->pageSize . '/1/' . urlencode($filter));
            die;
        }
    }
} 