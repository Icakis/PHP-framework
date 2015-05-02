<!DOCTYPE html>
<html>
<head>
    <script src=<?php echo '/'. DX_ROOT_PATH."/js/noty-2.3.5/demo/jquery-1.7.2.min.js" ?>></script>
    <script src=<?php echo '/'. DX_ROOT_PATH."/js/noty-2.3.5/js/noty/packaged/jquery.noty.packaged.min.js"?>></script>
    <title><?php echo htmlspecialchars($this->title) ?></title>
    <?php
        foreach($this->messages as $message) {
            echo $message->__toString();
        }
    ?>
</head>
<body>
<header>
    <ul class="menu">
        <li><a href="#">Home</a></li>
        <li><a href="create">Register</a></li>
        <li><a href="todos/index">Todos</a></li>
    </ul>
</header>
<hr/>