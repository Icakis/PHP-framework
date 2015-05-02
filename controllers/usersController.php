<?php

namespace Controllers;

use Lib\notyMessage;

class UsersController extends BaseController
{
    // protected $layout = 'default/default.php';
    protected $title;


    public function __construct()
    {
        parent::__construct(get_class(), 'users', 'views/users/');
        include_once 'models\usersModel.php';
        $this->model = new \Models\UsersModel();
        $this->title = 'Users';
    }

    public function index()
    {
        $todos = $this->model->find(array('columns' => array('user_id', 'id'), 'limit' => 1));
        var_dump($todos);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once DX_ROOT_DIR . '/views/layouts/' . $this->layout;
    }

    public function create()
    {
        $this->title = 'Register';

        if (isset($_POST['user']) && isset($_POST['pass'])) {
            $username = htmlentities($_POST['user']);
            $passwordHashed = password_hash(htmlentities($_POST['pass']), PASSWORD_BCRYPT);
            try {
                $this->model->createUser($username, $passwordHashed);
                $_SESSION['messages']= array();
                array_push($_SESSION['messages'], new notyMessage('Registration successful.', 'success'));
                //$this->model->isValidUser($username, $_POST['pass']);
                header('Location: \\'. DX_ROOT_PATH . 'todos/index.php');

                die;
            } catch (\Exception $e) {
                // echo '<p>Invalid registration: ', $e->getMessage(), "</p>";
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(),'error'));
            }
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'register.php';
        $this->renderView($template_file);
    }
} 