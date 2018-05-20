<?php
date_default_timezone_set("Europe/Moscow");

require('init.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {
    $lots = getLotsSortedByNew($link);
    $categories = getCategoryList($link);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            Print('Ошибка подключения: '.$error);
            }
    }

    $content = render_template('templates/index.php', ['lots' => $lots, 'categories' => $categories, 'link_lot' => $link_lot]);
    $all_content = render_template('templates/layout.php', ['lots' => $lots, 'categories' => $categories, 'content' => $content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'user_avatar' => $user_avatar]);
    print($all_content);
    }
?>
