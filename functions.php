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
        include_once($path);
        $content=ob_get_clean();
    } else {
        $content = "";
    }

    return $content;
};

function esc($str) {
    return htmlspecialchars($str);
};

?>
