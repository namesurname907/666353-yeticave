<?php
require('init.php');
require('mysql_helper.php');

if (!$link) {
    print('Ошибка подключения: '.mysqli_connect_error());
}
else {
    //Присовим переменным пустоту
    $user = NULL;
    $errors = [];
    $lot = [];
    $file_path = '';
    $lot['name'] = NULL;
    $lot['message'] = NULL;
    $lot['category'] = NULL;
    $lot['rate'] = NULL;
    $lot['step'] = NULL;
    $lot['date'] = NULL;

    //Закрываем доступ к странице, если пользователь неавторизован, а если авторизован получаем его данные
    session_start();
    if (!isset($_SESSION['user'])) {
        http_response_code(404);
        exit();
    }
    else {
        try{ $user = getUserInfo($link, $_SESSION['user']);
        } catch (Exception $e) {
            http_response_code(500); exit();
        }

    };

    //Получаем список категорий и проверяем не произошла ли ошибка при запросе
    try{ $categories = getCategoryList($link);
    } catch (Exception $e) {
        http_response_code(500); exit();
    }

    //Проверяем отправлена ли форма
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Переменные для сохранения значений полей
        $user['name'] = NULL;
        $user['avatar'] = NULL;
        $lot['name'] = $_POST['lot-name'];
        $lot['category'] = $_POST['category'];
        $lot['message'] = $_POST['message'];
        $lot['rate'] = $_POST['lot-rate'];
        $lot['step'] = $_POST['lot-step'];
        $lot['date'] = $_POST['lot-date'];

        //Проверяем все поля на заполненость
        $errors=validateEmpty($lot, $errors);

        //Проверяем формат полей
        $errors=validateInt(['rate' => $lot['rate'], 'step' => $lot['step']], $errors);

        //Проверяем дату окончания
        $errors=validateDate(['date' => $lot['date']], $errors);

        //Проверяем существование и формат файла
        if (!empty($_FILES['lot-img']['tmp_name'])) {
            $errors = validateFile($_FILES['lot-img']['tmp_name'], ['image/jpeg', 'image/png'], $errors);
        }
        else {
            $errors['file'] = 'Вы не загрузили файл';
        }

        //Проверяем собрали ли мы какие-нибудь ошибки, если нет, то загружаем файл и переадресовываем на страницу с только что созданным лотом
        if (empty($errors)) {
            $path = uniqid().'.jpg';
            $place = "img/";
            $file_path = $place . $path;
            move_uploaded_file($_FILES['lot-img']['tmp_name'], $file_path);

            try { $lot_id = insertLot($link, ['name' => $lot['name'], 'category' => $lot['category'], 'file_path' => $file_path, 'rate' => $lot['rate'], 'id' => $user['id'], 'step' => $lot['step'], 'date' => $lot['date'], 'message' => $lot['message']]);
            } catch (Exception $e) {
              http_response_code(500); exit();
            }

            header("Location: lot.php?id=" . $lot_id);

        };
    };
    $content = render_template('templates/add.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot, 'message' => $lot['message'], 'error_class' => 'form__item--invalid']);
    $all_content = render_template('templates/layout.php', ['categories' => $categories, 'content' => $content, 'title' => $lot['name'], 'user_name' => $user['name'], 'user_avatar' => $user['avatar']]);
    print($all_content);
};
?>
