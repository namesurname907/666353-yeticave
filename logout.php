<?php
require('init.php');
require('mysql_helper.php');

    if (!$link) {
        print('Ошибка подключения: '.mysqli_connect_error());
    }
    else {
        session_start();
        unset($_SESSION['user']);
        header("Location: /index.php");
    };
?>
