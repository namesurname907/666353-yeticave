<?php
require('init.php');
require('mysql_helper.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {

    /*Получаем список категорий и проверяем не произошла ли ошибка при запросе*/
    $categories = getCategoryList($link);
    if (!empty($errors)) {
        foreach ($errors as $error) {
            Print('Ошибка подключения: '.$error);
            }
    };

    /*Проверяем отправлена ли форма*/
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        /*Переменные для сохранения значений полей*/
        $name = $_POST['lot-name'];
        $category = $_POST['category'];
            $cat[$category] = 'selected';
        $message = $_POST['message'];
        $lot_rate = $_POST['lot-rate'];
        $lot_step = $_POST['lot-step'];
        $lot_date = $_POST['lot-date'];

        /*Проверяем все поля на заполненость*/
        $errors=validateEmptyPost(['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'], $errors);

        /*Проверяем формат полей*/
        $errors=validateIntPost(['lot-rate', 'lot-step'], $errors);

        /*Проверяем дату окончания*/
        $errors=validateDatePost('lot-date', $errors);

        /*Проверяем существование и формат файла*/
        $errors = validateFile('lot-img', ['image/jpeg', 'image/png'], $errors, 1);

        /*Проверяем собрали ли мы какие-нибудь ошибки*/
        if (empty($errors)) {

            $file_path = getFilePath('lot-img', 'img/');

            $answer = insertLot($link, [$name, $category, $file_path, $lot_rate, $lot_step, $lot_date, $message]);
                if (empty($answer['error'])) {
                    $lot_id = $answer['lot-id'];
                    header("Location: lot.php?id=" . $lot_id);
                }
        }
    };

    $content = render_template('templates/add.php', ['categories' => $categories, 'errors' => $errors, 'name' => $name, 'category' => $category, 'message' => $message, 'lot_rate' => $lot_rate, 'lot_step' => $lot_step, 'lot_date' => $lot_date, 'cat' => $cat, 'error_class' => 'form__item--invalid']);
    $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'is_auth' => $is_auth, 'user_name' => $user_name, 'user_avatar' => $user_avatar]);
    print($all_content);
};

?>
