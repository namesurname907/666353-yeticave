<?php
error_reporting(E_NOTICE);
require('init.php');
require('mysql_helper.php');
if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {
    //Поисвоим переменным пустоту
    $user = [];
    $user['avatar'] = NULL;
    $lot = [];
    $lot['user_id'] = NULL;
    $lot['name'] = NULL;
    $user['id'] = NULL;
    $user['name'] = NULL;
    $lot['date_end'] = NULL;
    $bets = [];
    $yourBet = NULL;
    $error_bet = NULL;
    $max_bet_user_id = NULL;

    try{ $categories = getCategoryList($link);
         $lots = getLotsSortedByNew($link);
    } catch (Exception $e) {
        http_response_code(500); exit();
    }

    session_start();

    //Проверяем наличие параметра запроса с id лота и проверяем существует ли лот
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

    try{ $bets = getBetsById($link, $id);
         $lot = getLotById($link, $id);
         $yourBet = yourBet($link, $id, $lot);
    } catch (Exception $e) {
        http_response_code(500); exit();
    }

    if (isset($bets[0]['user_id'])) {
        $max_bet_user_id = $bets[0]['user_id'];
    }

    //Если сессия существует, то получаем данные пользователя
    if (isset($_SESSION['user'])) {
         try{ $user = getUserInfo($link, $_SESSION['user']);
         } catch (Exception $e) {
                http_response_code(500); exit();
         }

       if (isset($_POST['cost'])) {
            $cost = intval($_POST['cost']);
            if ($cost >= $yourBet) {
                $ins_bet = insertBet($link, $cost, $user['id'], $id);
                if (!$ins_bet) {
                    header('Location: lot.php');
                    exit();}
                else {
                    http_response_code(500); exit();
                }
            }
            else {
                $error_bet = 'Ставка должны быть больше текущей цены как минимум на шаг ставки';
            };
        }
    }

     $content = render_template('templates/lot.php', ['categories' => $categories, 'lot' => $lot, 'user_id' => $lot['user_id'], 'user' => $user, 'bets' => $bets, 'yourBet' => $yourBet, 'error_bet' => $error_bet, 'error_class' => 'form__item--invalid', 'log_user_id' => $user['id'], 'lot_user_id' => $lot['user_id'], 'max_bet_user_id' => $max_bet_user_id]);
     $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'user_name' => $user['name'], 'user_avatar' => $user['avatar']]);
     print($all_content);
};
?>
