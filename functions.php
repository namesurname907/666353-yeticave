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
     $sql =  'SELECT * FROM categories';
     $result = mysqli_query($link, $sql);
     if ($result) {
         $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
     }
     else {
         $error = mysqli_error($link);
         print('Ошибка выполнения запроса: '.$error);
     }
     return $array;
 }

function getLotsSortedByNew($link) {
    $sql =  'SELECT date_start, name, discription, image, price_start, category_id FROM lots WHERE date_end IS NULL ORDER BY date_start DESC';
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        print('Ошибка выполнения запроса: '.$error);
    }
    return $array;
}
?>
