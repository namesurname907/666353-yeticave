<?php
/**
 * Создает строку с отформатированной ценой на основе целого числа
 *
 * @param int $price Цена
 * @return string Отформатированная цена
 */
function price_format($price) {
    $price = ceil($price);

    if ($price >= 1000) {
        $price = number_format($price, 0, '', ' ');
    }
    return $price." ₽";
};
/**
 * Подключение шаблона на основе пути к этому шаблону и данных для него
 *
 * @param string $path Путь к шаблону
 * @param array $data Массив с данными
 *
 * @return string Html-код с переменными PHP
 */
function render_template($path, $data = []) {
    $content = null;
    extract($data);
    if (file_exists($path)){
        ob_start();
        include($path);
        $content=ob_get_clean();
    } else {
        $content = "";
    }

    return $content;
};
/**
 * Защита от XSS
 *
 * @param string $str Строка, которая нуждается в преобразовании
 * @return string Преобразованная строка
 */
function esc($str) {
    return htmlspecialchars($str);
};
/**
 * Валидация полей на пустоту
 * ключ переменной из массива, который необходимо провалидировать, будет ключем в массиве ошибок
 *
 * @param array $required Массив с переменными, которые необходимо проверить
 * @param array $errors Массив, куда запишем ошибку, в случае ее возникновения
 *
 * @return array $errors Массив, со всеми накопленными ошибками
 */
function validateEmpty($required, $errors) {
    foreach ($required as $key => $value) {
        if (empty($value)) {
             $errors[$key] = 'Это поле надо заполнить';
        }
    }
    return $errors;
};
/**
 * Валидация полей на целое положительное число
 *
 * @param array $required Поля, которое необходимо проверить
 * @param array $errors Массив, куда запишем ошибку, в случае ее возникновения
 *
 * @return array $errors Массив, со всеми накопленными ошибками
 */
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
/**
 * Валидация даты
 *
 * @param array $required Поля, которое необходимо проверить
 * @param array $errors Массив, куда запишем ошибку, в случае ее возникновения
 *
 * @return array $errors Массив, со всеми накопленными ошибками
 */
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
/**
 * Проверка формата файла
 *
 * @param string $required Путь к файлу, который необходимо проверить
 * @param array $format Массив, с допустимыми форматами
 * @param array $errors Массив, куда запишем ошибку, в случае ее возникновения
 *
 * @return array $errors Массив, со всеми накопленными ошибками
 */
function validateFile($required, $format, $errors) {
    if (!empty($required)) {
        $file_type = mime_content_type($required);
        $errors['file'] = 'Загрузите файл в нужном формате';
        foreach ($format as $form) {
            if ($file_type === $form) {
                unset($errors['file']);
            };
        };
    }
    return $errors;
};
/**
 * Создает строку с оставшимся временем до заданной даты
 * если количеством часов или минут являются числа с одной цифрой, то вереди к ним приписывается ноль
 *
 * @param string $date Дата окончания
 * @return string Строка с количеством оставшихся дней, часов и минут
 */
function timeToEnd($date){
    $dif = strtotime($date) - time();
    $days_to_end = floor($dif/86400);
    $hours_to_end = floor(($dif%86400)/3600);
        if ($hours_to_end<10) {
            $hours_to_end = '0'.$hours_to_end ;
        }
    $mins_to_end = floor((($dif%86400)%3600)/60);
        if ($mins_to_end<10) {
            $mins_to_end = '0'.$mins_to_end ;
        }
    return $days_to_end.':'.$hours_to_end.':'.$mins_to_end;
};

