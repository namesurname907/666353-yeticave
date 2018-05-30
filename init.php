<?php
//Установка временной зоны
date_default_timezone_set("Europe/Moscow");

require_once('functions.php');
require_once('sql_functions.php');

//Установка соединения
$link = mysqli_connect('localhost', 'root', '', 'yeticave');
?>
