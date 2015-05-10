<?php
include 'config/config.php';
$rootDir = str_replace('\\', DX_DS, dirname(__FILE__));

// Define root dir and root path
define('DX_ROOT_DIR', $rootDir . DX_DS);
define('DX_ROOT_PATH', basename(dirname(__FILE__)) . DX_DS);
define('DX_ROOT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/PHP-Framework/');

//var_dump(DX_ROOT_DIR);
//var_dump(DX_ROOT_PATH);
//var_dump(DX_ROOT_URL);

// Define the request home that will always persist in REQUEST_URI
$request_home = DX_DS . DX_ROOT_PATH;

include_once 'lib/database.php';
include_once 'lib/notyMessage.php';
include_once 'controllers/BaseController.php';

// Read the request
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$components = array();
$controller = DEFAULT_CONTROLLER;
$method = DEFAULT_ACTION;
$admin_routing = false;
$params = array();

$baseControllerName = '\Controllers\\' . $controller . 'Controller';

if (!empty($request)) {
    if (strpos($request, $request_home) === 0) {
        // Clean the request
        $request = substr($request, strlen($request_home));

        // Switch to admin routing
        $nextChar = substr($request, 5, 1);
        if (strpos($request, 'admin') === 0 && ($nextChar == DX_DS || !$nextChar)) {
            $admin_routing = true;
            include_once 'controllers/admin/adminController.php';
            $request = substr($request, strlen('admin/'));
        }

        // Fetch the controller, method and params if any
        $components = explode(DX_DS, $request, 3);

        if (count($components) > 1) {
            list($controller, $method) = $components;
            $params = isset($components[2]) ? $components[2] : array();
        } else {
            $baseController = new $baseControllerName();
            $baseController->index();
            exit;
        }
    }
}

// If the controller is found
if (isset($controller) && file_exists('controllers/' . $controller . 'Controller.php')) {
    $admin_folder = $admin_routing ? 'admin/' : '';
    if ($admin_routing) {
        include_once 'controllers/' . $admin_folder . $controller . '.php';
    }

    // Is admin controller?
    $admin_namespace = $admin_routing ? '\Admin' : '';

    // Form the controller class
    $controller_class = $admin_namespace . '\Controllers\\' . ucfirst(strtolower($controller)) . 'Controller';

    // Include founded Controller
    include_once 'controllers/' . $controller . 'Controller.php';

    // Create Instance
    $instance = new $controller_class();

    // Call the object and the method
    if (method_exists($instance, $method)) {
        if (is_string($params)) {
            $params = explode('/', $params);
        }

        call_user_func_array(array($instance, $method), $params);
        // $instance->$method();
    } else {
        // fallback to index
        call_user_func_array(array($instance, 'index'), array());
    }
} else {
    // TODO 404 NOT FOUND SUCH CONTROLLER
    $baseController = new $baseControllerName();
    $baseController->index();
}

// \Lib\Auth::get_instance()->logout();

// TEST PLAYGROUND
/* include_once 'models/artist.php';

$artist_model = new \Models\Artist_Model();

$artists = $artist_model->find();

var_dump( $artists );
*/

// include_once 'lib/auth.php';
// $auth = \Lib\Auth::get_instance();

// $logged_in = $auth->login( 'test', 'test' );

// var_dump($logged_in);

// var_dump($_SESSION);
