<?php
require('init.php');
require_once('mysql_helper.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {
    $lots = getLotsSortedByNew($link);
    $categories = getCategoryList($link);

    $user = [];

    session_start();
    if (isset($_SESSION['user'])) {
        $user = getUserInfo($link, $_SESSION['user']);
    };

    $content = render_template('templates/index.php', ['lots' => $lots, 'categories' => $categories]);
    $all_content = render_template('templates/layout.php', ['lots' => $lots, 'categories' => $categories, 'content' => $content, 'title' => 'Главная', 'user_name' => $user['name'], 'user_avatar' => $user['avatar']]);
    print($all_content);
}
?>
