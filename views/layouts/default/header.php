<!DOCTYPE html>
<html>
<head>
    <script src=<?php echo '/' . DX_ROOT_PATH . "/js/jquery-2.1.3.js" ?>></script>
    <script src=<?php echo '/' . DX_ROOT_PATH . "/js/jquery.noty.packaged.js" ?>></script>
    <link rel="stylesheet" href=<?php echo '/' . DX_ROOT_PATH . "/js/bootstrap-3.3.4-dist/css/bootstrap.min.css"; ?> rel="stylesheet" >
    <script type="text/javascript" src=<?php echo '/' . DX_ROOT_PATH . "/js/bootstrap-3.3.4-dist/js/bootstrap.min.js"; ?>></script>
    <link href=<?php echo '/' . DX_ROOT_PATH . "/styles/bootstrap.min.css" ?> rel="stylesheet">
    <link href=<?php echo '/' . DX_ROOT_PATH . "/styles/styles.css" ?> rel="stylesheet">

    <title><?php echo htmlspecialchars($this->title) ?></title>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
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
        <?php
        if ($this->isAuthorize()) {
            ?>
            <li>User: <?php echo $_SESSION['username']; ?></li>
            <li><a href=<?php echo DX_ROOT_URL . 'playlists/mine' ?>>My Playlists</a></li>
            <li><a href=<?php echo DX_ROOT_URL . 'playlists/all' ?>>Public Playlists</a></li>
            <li><a href=<?php echo DX_ROOT_URL . 'users/logout' ?>>Logout</a></li>
        <?php
        } else {
            ?>

            <li><a href=<?php echo DX_ROOT_URL . 'users/register' ?>>Register</a></li>
            <li><a href=<?php echo DX_ROOT_URL . 'users/login' ?>>Login</a></li>
        <?php
        }

        ?>
        <li><a href=<?php echo DX_ROOT_URL . 'genres/index' ?>>Genres</a></li>
    </ul>
</header>
<hr/>