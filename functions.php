<?php
/*Форматирование цены*/
function price_format($price) {
    $price = ceil($price);

    if ($price > 1000) {
        $price = number_format($price, 0, '', ' ');
    }
    return $price." ₽";
};
/*Вставка шаблона*/
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
/*Защита от XSS*/
function esc($str) {
    return htmlspecialchars($str);
};
/*Таймер расчета остатка времени до полуночи*/
function timeToMidnight(){
    $dif_ts = strtotime('00:00:00') - time();
    $dif_all_min = floor($dif_ts / 60) + 24 * 60;
    $dif = floor($dif_all_min / 60). ':' .floor($dif_all_min % 60);

    return $dif;
};
/*Время до окончания аукциона*/
function dateBeforeEnd($date) {
        return (strtotime($date) - time());
};
/*Валидация полей на пустоту*/
function validateEmpty($required, $errors) {
    foreach ($required as $key => $value) {
        if (empty($value)) {
             $errors[$key] = 'Это поле надо заполнить';
        }
    }
    return $errors;
};
/*Валидация полей на целое положительное число*/
function validateInt($required, $errors) {
    foreach ($required as $key => $value) {
        if (!empty($value)) {
            if (!filter_var($value, FILTER_VALIDATE_INT) OR $value<0) {
                 $errors[$key] = 'Неверный формат';
            }
        }
    }
    return $errors;
};
/*Валидация даты*/
function validateDate($required, $errors) {
    foreach ($required as $key => $value) {
        if (!empty($value)) {
            $dif = strtotime($value) - time() - 86400;
            if ($dif<0) {
                $errors[$key] = 'Дата истечения лота неккоректна';
            }
        }
    };
    return $errors;
};
/*Проверяет формат файла*/
function validateFile($required, $format, $errors) {
    if (!empty($required)) {
        $file_type = mime_content_type($required);
        $errors['file'] = 'Загрузите файл в нужном формате';
        foreach ($format as $form) {
            if ($file_type == $form) {
                unset($errors['file']);
            };
        };
    }
    return $errors;
};
