<?php
date_default_timezone_set("Europe/Moscow");

require_once('functions.php');
require_once('sql_functions.php');

$link = mysqli_connect('localhost', 'root', '', 'yeticave');
mysqli_set_charset($link, "utf8");
?>
