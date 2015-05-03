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
        // var_dump($todos);

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once DX_ROOT_DIR . '/views/layouts/' . $this->layout;
    }

    public function register()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->title = 'Register';

        if (isset($_POST['user']) && isset($_POST['pass'])) {
            try {
                $this->model->createUser($_POST['user'], $_POST['pass']);
                array_push($_SESSION['messages'], new notyMessage('User registered.', 'success'));
                header('Location: ' . DX_ROOT_URL . 'todos/index.php');
                exit();
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'error'));
            }
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'register.php';
        $this->renderView($template_file);
    }

    public function login()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->title = 'Login';

        if (isset($_POST['user']) && isset($_POST['pass'])) {
            try {
                if ($_POST['user'] == '') {
                    throw new \Exception('Username is required. Login failed.');
                }

                if ($_POST['pass'] == '') {
                    throw new \Exception('Password is required. Login failed.');
                }

                $user_data = $this->model->isValidUser($_POST['user'], $_POST['pass']);
                if(is_array($user_data)){
                    $_SESSION['username'] = $user_data['username'];
                    $_SESSION['user_id'] = $user_data['user_id'];
                }else{
                    throw new \Exception('Invalid username or password');
                }

                array_push($_SESSION['messages'], new notyMessage('Successful login', 'success'));
                header('Location: ' . DX_ROOT_URL . 'todos/index.php');
                exit();
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'login.php';
        $this->renderView($template_file);
    }

    public function logout(){
        session_start();
        session_destroy(); // Delete all data in $_SESSION[]

        // Remove the PHPSESSID cookie
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        header('Location: ' . DX_ROOT_URL );
        die;
    }
} 