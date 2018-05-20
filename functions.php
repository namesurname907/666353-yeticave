<?php
function price_format($price) {
    $price = ceil($price);

    if ($price > 1000) {
        $price = number_format($price, 0, '', ' ');
    }
    return $price." ₽";
};

function render_template($path, $array) {
    extract($array);

    if (file_exists($path)){
        ob_start();
        include($path);
        $content=ob_get_clean();
    } else {
        $content = "";
    }

    return $content;
};

function esc($str) {
    return htmlspecialchars($str);
};

function time_to_midnight(){
    $dif_ts = strtotime('00:00:00') - time();
    $dif_all_min = floor($dif_ts / 60) + 24 * 60;
    $dif = floor($dif_all_min / 60). ':' .floor($dif_all_min % 60);

    return $dif;
};

function getCategoryList($link) {
    $sql =  'SELECT id, name FROM categories ORDER BY id ASC;';
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $errors[] = mysqli_error($link);
    }
    return $array;
};

function getLotsSortedByNew($link) {
    $sql = 'SELECT id, name, date_start,  discription, image, price_start, category_id FROM lots WHERE date_end IS NULL ORDER BY date_start DESC';
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $errors[] = mysqli_error($link);
    }
    return $array;
};

function getBetsById($link, $id) {
    $sql = "SELECT b.date_start, b.price, u.name as user_name FROM bets b
                        	LEFT JOIN users u
                        	ON b.user_id = u.id
                        WHERE lot_id='$id' ORDER BY date_start DESC";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $array;
};

/*Получаем данные лота, где его id равен полученному из параметра запроса*/
function getLotById($link, $id) {
    $sql = "SELECT name, image, discription, price_start, step_bet, category_id FROM lots WHERE id = '$id'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return array_shift($array);
};

/*Рассчитываем плэйсхолдер для поля "Ваша ставка"*/
function yourBet($link, $id, $lot) {
    $sql = "SELECT l.price_start as price_start, l.step_bet as step_bet, COUNT(b.id) as bet_total, MAX(b.price) as cur_max_price FROM bets b
               LEFT JOIN lots l
            	ON b.lot_id = l.id
            	WHERE date_end IS NULL AND l.id = '$id' GROUP BY l.id";
       $result = mysqli_query($link, $sql);
       if ($result) {
           $array = array_shift(mysqli_fetch_all($result, MYSQLI_ASSOC));
           if (empty($array['cur_max_price'])) {
           $yourBet = $lot['price_start'] + $lot['step_bet'];
           }
           else {
           $yourBet = $array['cur_max_price'] + $array['step_bet'];
           };

       }
       return $yourBet;
   };

?>
