<?php

namespace Controllers;

class BaseController
{
    protected $layout = 'default/';
    protected $views_dir = 'views/home/';
    protected $model = null;
    protected $controller = null;
    protected $logged_user = array();
    protected $messages = array();

    public function __construct($controllerName = '\Controllers\BaseController', $model = 'todos', $views_dir = '/views/home/')
    {
        // Get caller classes
        $this->controller = $controllerName;
        $this->model = $model;
        $this->views_dir = $views_dir;

//// 		$this_class = get_class();
//// 		$called_class = get_called_class();
//
//// 		if( $this_class !== $called_class ) {
//// 			var_dump( $called_class );
//// 		}
//
        include_once DX_ROOT_DIR . "models/{$model}Model.php";
        $model_class = "\Models\\" . ucfirst($model) . "Model";

        $this->model = new $model_class(array('table' => 'none'));

//        $logged_user = \Lib\Auth::get_instance()->get_logged_user();
//        $this->logged_user = $logged_user;
    }

    public function home()
    {
        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once DX_ROOT_DIR . '/views/layouts/home' . $this->layout;
    }

    public function index()
    {
        var_dump(DX_ROOT_DIR);
        var_dump(DX_ROOT_PATH);
        var_dump(DX_ROOT_URL);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        var_dump($template_file);

        include_once DX_ROOT_DIR . str_replace( 'views/layouts/home/', '/', DX_DS)  .  'index.php';
    }

    public function renderView($viewName = null, $includeLayout = true, $layoutName = null)
    {
        // check render file
        if ($viewName == null) {
            $viewFileName = DX_ROOT_DIR . $this->views_dir . 'index.php';
        }

       $viewFileName = $viewName;
        // var_dump($viewFileName);

        if ($includeLayout === true) {
            if ($layoutName) {
                $headerFile =DX_ROOT_DIR. 'views/layouts/' . $layoutName . '/header.php';
            } else {
                $headerFile = DX_ROOT_DIR.'views/layouts/' . $this->layout . '/header.php';
            }

            include_once($headerFile);
        }

        include($viewFileName);

        if ($includeLayout === true) {
            if ($layoutName) {
                $footerFile = DX_ROOT_DIR.'views/layouts/' . $layoutName . '/footer.php';
            } else {
                $footerFile = DX_ROOT_DIR.'views/layouts/' . $this->layout . '/footer.php';
            }

            include_once($footerFile);
        }
    }
} 