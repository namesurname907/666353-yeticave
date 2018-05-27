<?php
require('init.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {
    /*Поисовим переменным пустоту*/
    $user = [];
    $lot = [];
    $bets = [];
    $yourBet = NULL;
    $error_bet = NULL;

    $lots = getLotsSortedByNew($link);
    $categories = getCategoryList($link);

    session_start();
    /*Проверяем наличие параметра запроса с id лота и проверяем существует ли лот*/
    if (((!isset($_GET['id'])) || (!in_array(intval($_GET['id']), array_column($lots, 'id')))) && (!isset($_SESSION['lot']))) {
        http_response_code(404);
        exit();
    }
    elseif ( (isset($_GET['id'])) && (in_array(intval($_GET['id']), array_column($lots, 'id'))) ) {
        $id = $_GET['id'];
        $_SESSION['lot'] = $id;
    }
    elseif (isset($_SESSION['lot'])) {
        $id = $_SESSION['lot'];
    };

    $bets = getBetsById($link, $id);
    $lot = getLotById($link, $id);
    $yourBet = yourBet($link, $id, $lot);

    /*Если сессия существует, то получаем данные пользователя*/
    if (isset($_SESSION['user'])) {
        $user = getUserInfo($link, $_SESSION['user']);

       if (isset($_POST['cost'])) {
            $cost = intval($_POST['cost']);
            if ($cost >= $yourBet) {
                $ins_bet = insertBet($link, $cost, $user['id'], $id);
                header('Location: lot.php');
                exit();
            }
            else {
                $error_bet = 'Ставка должны быть больше текущей цены как минимум на шаг ставки';
            };
        }
    }

     $content = render_template('templates/lot.php', ['categories' => $categories, 'lot' => $lot, 'bets' => $bets, 'yourBet' => $yourBet, 'error_bet' => $error_bet, 'error_class' => 'form__item--invalid']);
     $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'user_name' => $user['name'], 'user_avatar' => $user['avatar']]);
     print($all_content);
};
?>
