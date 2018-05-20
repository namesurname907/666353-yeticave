<?php
require_once 'functions.php';

$is_auth = (bool) rand(0, 1);
$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$link = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($link, "utf8");
?>
