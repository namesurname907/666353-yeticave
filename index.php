<?php
require('init.php');
require_once('mysql_helper.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {
    //Объявляем переменные
    $lots = [];
    $user = [];
    $user['name'] = NULL;
    $user['avatar'] = NULL;

    //Получаем список категорий и лотов
    try{ $categories = getCategoryList($link);
         $lots = getLotsSortedByNew($link);
    } catch (Exception $e) {
        http_response_code(500); exit();
    }

    //Если пользователь залогинен, получаем информацию о нем для отображения на странице
    session_start();
    if (isset($_SESSION['user'])) {
        try{ $user = getUserInfo($link, $_SESSION['user']);
         } catch (Exception $e) {
                http_response_code(500); exit();
         }
    };

    $content = render_template('templates/index.php', ['lots' => $lots, 'categories' => $categories]);
    $all_content = render_template('templates/layout.php', ['lots' => $lots, 'categories' => $categories, 'content' => $content, 'title' => 'Главная', 'user_name' => $user['name'], 'user_avatar' => $user['avatar']]);
    print($all_content);
}
?>
