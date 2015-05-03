<?php

namespace Controllers;

use Lib\notyMessage;

class TodosController extends BaseController
{
    //protected $layout = 'default/default.php';
    protected $title = 'Todos';
    protected $items;

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

        parent::__construct(get_class(), 'todos', '/views/todos/');
        include_once 'models\todosModel.php';
        $this->model = new \Models\TodosModel();
    }

    public function index()
    {
        // $todos = $this->model->find(array('columns'=> array('user_id','id'),'limit'=>1));
        $this->items = $this->model->getTodoItems($_SESSION['user_id']);
        // var_dump($this->items);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';
        $this->renderView($template_file);
    }

    public function add()
    {
        if (isset($_POST['todo_item'])) {
            $user_id = $_SESSION['user_id'];
            $item_text = $_POST['todo_item'];
            try {
                $this->model->addTodoItems($user_id, $item_text);
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

        $this->index();
    }

    public function delete($delete_item_id)
    {
        try {
            $user_id = $_SESSION['user_id'];
            if(!$this->model->deleteTodoItem($user_id, $delete_item_id)){
                throw new \Exception('Cannot delete item.');
            }

            array_push($_SESSION['messages'], new notyMessage('Item deleted.', 'success'));
            header('Location: ' . DX_ROOT_URL . 'todos/index.php');
            die;
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
        }


        $this->index();
    }
} 