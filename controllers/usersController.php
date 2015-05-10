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
        // $todos = $this->model->find(array('columns' => array('user_id', 'id'), 'limit' => 1));

        $template_file = DX_ROOT_DIR . $this->views_dir . 'index.php';

        // include_once DX_ROOT_DIR . '/views/layouts/' . $this->layout;
    }

    public function register()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->title = 'Register';

        if ($this->isPost()) {
            try {
                if (!isset($_POST['register_token']) || $_POST['register_token'] != $_SESSION['register_token']) {
                    array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                    die;
                }

                $this->model->createUser($_POST['username'], $_POST['pass'], $_POST['passConfirm'], $_POST['name'], $_POST['email'], $_POST['phone']);

                $user_data = $this->model->loginUser($_POST['username'], $_POST['pass']);
                $this->setUserSessionData($user_data);

                array_push($_SESSION['messages'], new notyMessage('User registered.', 'success'));
                header('Location: ' . DX_ROOT_URL . 'playlists/index.php');
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

        if ($this->isPost()) {
            try {
                if (!isset($_POST['login_token']) || $_POST['login_token'] != $_SESSION['login_token']) {
                    array_push($_SESSION['messages'], new notyMessage('Possible CSRF...', 'alert'));
                    die;
                }

                if ($_POST['username'] == '') {
                    throw new \Exception('Username is required. Login failed.');
                }

                if ($_POST['pass'] == '') {
                    throw new \Exception('Password is required. Login failed.');
                }

                $user_data = $this->model->loginUser($_POST['username'], $_POST['pass']);
                $this->setUserSessionData($user_data);

                array_push($_SESSION['messages'], new notyMessage('Successful login', 'success'));
                header('Location: ' . DX_ROOT_URL . 'playlists/index');
                exit();
            } catch (\Exception $e) {
                array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
            }
        }

        $template_file = DX_ROOT_DIR . $this->views_dir . 'login.php';
        $this->renderView($template_file);
    }

    public function logout()
    {
        session_start();
        session_destroy(); // Delete all data in $_SESSION[]

        // Remove the PHPSESSID cookie
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        header('Location: ' . DX_ROOT_URL);
        die;
    }

    private function setUserSessionData($user_data)
    {
        if (is_array($user_data)) {
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['user_id'] = $user_data['user_id'];
            $_SESSION['name'] = $user_data['name'];
        } else {
            array_push($_SESSION['messages'], new notyMessage('Invalid username or password.', 'warning'));
            header('Location: ' . DX_ROOT_URL . 'users/login');
            die;
        }
    }

    public function show($username)
    {

        if (!$this->isAuthorize()) {
            array_push($_SESSION['messages'], new notyMessage('Login first', 'warning'));
            header('Location: ' . DX_ROOT_URL);
        }


        try {
            $user = $this->model->getUserByUsername($username);
            $template_file = DX_ROOT_DIR . $this->views_dir . 'show.php';
//            var_dump($template_file);
            $data['user'] = $user;
            $this->renderView($template_file, $data);
        } catch (\Exception $e) {
            array_push($_SESSION['messages'], new notyMessage($e->getMessage(), 'warning'));
        }
    }
} 