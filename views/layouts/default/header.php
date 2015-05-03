<!DOCTYPE html>
<html>
<head>
    <script src=<?php echo '/' . DX_ROOT_PATH . "/js/noty-2.3.5/demo/jquery-1.7.2.min.js" ?>></script>
    <script
        src=<?php echo '/' . DX_ROOT_PATH . "/js/noty-2.3.5/js/noty/packaged/jquery.noty.packaged.min.js" ?>></script>
    <title><?php echo htmlspecialchars($this->title) ?></title>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['messages'])&& is_array($_SESSION['messages'])) {
        foreach ($_SESSION['messages'] as $message) {
            echo $message->__toString();
        }
    }
    $_SESSION['messages'] = [];
    ?>
</head>
<body>
<header>
    <ul class="menu">
        <li><a href=<?php echo DX_ROOT_URL ?>>Home</a></li>
        <li><a href=<?php echo DX_ROOT_URL . 'users/register' ?>>Register</a></li>
        <li><a href=<?php echo DX_ROOT_URL . 'users/login' ?>>Login</a></li>
        <li><a href=<?php echo DX_ROOT_URL . 'users/logout' ?>>Logout</a></li>
        <li><a href=<?php echo DX_ROOT_URL . 'todos/index' ?>>Todos</a></li>
    </ul>
</header>
<hr/>