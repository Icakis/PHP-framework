<?php

namespace Controllers;

class TodosController extends BaseController {
    protected $layout = 'default/default.php';
    protected $title = 'Todos';
    
    public function __construct() {
        parent::__construct( get_class(), 'todos', '/views/todos/' );
        include_once 'models\todosModel.php';
        $this->model = new \Models\TodosModel();
    }

    public function index() {
        var_dump($this->messages);
//        $todos = $this->model->find(array('columns'=> array('user_id','id'),'limit'=>1));
//        $todos = $this->model->getTodoItems(1);
//        var_dump($todos);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once DX_ROOT_DIR . '/views/layouts/' . $this->layout;
    }

} 