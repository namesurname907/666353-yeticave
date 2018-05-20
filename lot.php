<?php
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

    /*Проверяем наличие параметра запроса с id лота и проверяем существует ли лот*/
    if (isset($_GET['id']) && in_array(intval($_GET['id']), array_column($lots, 'id'))) {

        $id = intval($_GET['id']);
        $bets = getBetsById($link, $id);
        $lot = getLotByID($link, $id);
        $yourBet = yourBet($link, $id, $lot);

        $content = render_template('templates/lot.php', ['categories' => $categories, 'lot' => $lot, 'bets' => $bets, 'yourBet' => $yourBet]);
        $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'is_auth' => $is_auth, 'user_name' => $user_name, 'user_avatar' => $user_avatar]);
        print($all_content);
        }
     else {
         http_response_code(404);
     }
    }
?>
