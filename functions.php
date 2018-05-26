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
function time_to_midnight(){
    $dif_ts = strtotime('00:00:00') - time();
    $dif_all_min = floor($dif_ts / 60) + 24 * 60;
    $dif = floor($dif_all_min / 60). ':' .floor($dif_all_min % 60);

    return $dif;
};
/*Валидация полей на пустоту*/
function validateEmptyPost($required = ['name'], $errors) {
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
             $errors[$key] = 'Это поле надо заполнить';
        }
    }
    return $errors;
};
/*Валидация полей на целое положительное число*/
function validateIntPost($required = ['price'], $errors) {
    foreach ($required as $key) {
        if (!empty($_POST[$key])) {
            if (!filter_var($_POST[$key], FILTER_VALIDATE_INT) OR $_POST[$key]<0) {
                 $errors[$key] = 'Неверный формат';
            }
        }
    }
    return $errors;
};
/*Валидация даты*/
function validateDatePost($required =['date'], $errors) {
    if (!empty($_POST[$required])) {
        $dif = strtotime($_POST[$required]) - time() - 86400;
        if ($dif<0) {
            $errors['lot-date'] = 'Дата истечения лота неккоректна';
        };
        }
    return $errors;
};
/*Проверяет наличие файла и его формат, аргументы: 1) имя формы, 2) формат файла, 3) массив, куда добавляем ошибки, 4) если 1, то отсутствие файла также записывается в ошибки*/
function validateFile($required, $format = ['image/png'], $errors, $empty_er) {
    if (!empty($_FILES[$required]['name'])) {
        $file_type = mime_content_type($_FILES[$required]['tmp_name']);
        $errors['file'] = 'Загрузите файл в нужном формате';
        foreach ($format as $form) {
            if ($file_type === $form) {
                $errors['file'] = NULL;
            };
        };
    }
    else {
        if ($empty_er === 1) {
        $errors['file'] = 'Вы не загрузили файл';
        };
    };
    return $errors;
};
/*Получить имя файла, сгенерировав уникальное имя*/
function getFilePath($required, $place) {
    if (isset($_FILES[$required]['name'])) {
                $tmp_name = $_FILES[$required]['tmp_name'];
                $path = uniqid().'.jpg';
                move_uploaded_file($tmp_name, $place . $path);
                $file_path = $place.$path;
            }
    return $file_path;

};
/*Если 1 аргумент, то в случае успешной проверки его существования, возвращает его, если имеется второй аргумент, то возвращает второй аргумент. Если элемент не существует возвращает пустоту */
function insertIfIsset($var, $str = 0) {
    if (!empty($var)) {
        if ($str === 0) {
            $v = $var;
        }
        else {
            $v=$str;
        }
    }
    else {
            $v='';
        }
    return $v;
};
?>
