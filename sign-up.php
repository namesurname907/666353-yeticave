<?php
require('init.php');
require('mysql_helper.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {

    //Получаем список категорий

    try{ $categories = getCategoryList($link);
    } catch (Exception $e) {
        http_response_code(503); exit();
    }

    //Присваиваем пустоту, чтобы в случае отсутствия запроса не возникало ошибки
    $errors = NULL;
    $name = NULL;
    $email = NULL;
    $message = NULL;
    $password = NULL;
    $file_path = '';

    $user_name = NULL;
    $user_avatar = NULL;
    $lot['name'] = NULL;
    $lot['message'] = NULL;

    //Проверяем отправлена ли форма
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Переменные для сохранения значений полей
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $message = $_POST['message'];

        //Проверяем все поля на заполненость
        $errors=validateEmpty(['email' => $email, 'password' => $password, 'name' => $name, 'message' => $message], $errors);

        //Проверяем формат почты и существует ли уже пользователь с такой почтой
        $errors=validateEmail($link, $email, $errors);

        //Если файл существует, то проверяем его формат
        if (!empty($_FILES['avatar']['tmp_name'])) {
            $errors = validateFile($_FILES['avatar']['tmp_name'], ["image/jpeg", "image/png"], $errors);
            /*Если формат корректен, загружаем файл и получаем путь файла*/
            if (empty($errors['file'])) {
                $path = uniqid().'.jpg';
                $place = "public/";
                $file_path = $place . $path;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $file_path);
            }
        };

        //Проверяем собрали ли мы какие-нибудь ошибки
        if (empty($errors)) {
            $error = insertUser($link, $email, $name, $password, $file_path, $message);
            if ((empty($errors)) && (empty($error))) {
                header("Location: /login.php");
            }
        };
    };

    $content = render_template('templates/sign-up.php', ['categories' => $categories, 'errors' => $errors, 'error_class' => 'form__item--invalid', 'name' => $name, 'email' => $email, 'message' => $message , 'password' => $password]);
    $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'user_name' => $user_name, 'user_avatar' => $user_avatar]);
    print($all_content);
};

?>
