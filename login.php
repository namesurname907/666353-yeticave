<?php
require('init.php');
require_once('mysql_helper.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {

    //Получаем список категорий
    $categories = getCategoryList($link);

    //Присваиваем пустоту, чтобы в случае отсутствия запроса не возникало ошибки
    $errors = NULL;
    $name = NULL;
    $email = NULL;
    $message = NULL;
    $password = NULL;
    $lot['name'] = NULL;
    $user_name = NULL;
    $user_avatar = NULL;

    //Проверяем отправлена ли форма
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Переменные для сохранения значений полей
        $email = $_POST['email'];
        $password = $_POST['password'];

        //Проверяем все поля на заполненость
        $errors=validateEmpty(['email' => $email, 'password' => $password], $errors);

        //Проверяем формат email и существует ли он в базе
        try{ $errors = validateEmail($link, $email, $errors, 0);
            //Если поле пароля не пустое, то проверяем и его
            if (!empty($password)) {
                $errors = validatePasswordByEmail($link, $password, $email, $errors);
            }
        } catch (Exception $e) {
            http_response_code(500); exit();
        }

        //Проверяем собрали ли мы какие-нибудь ошибки, если нет, то переадресовываем пользователя
        if (empty($errors)) {
            session_start();
            $_SESSION['user'] = $_POST['email'];
            header("Location: /");
        }
    };
    $content = render_template('templates/login.php', ['categories' => $categories, 'errors' => $errors, 'error_class' => 'form__item--invalid', 'name' => $name, 'email' => $email, 'message' => $message , 'password' => $password]);
    $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'user_name' => $user_name, 'user_avatar' => $user_avatar]);
    print($all_content);
};

?>
