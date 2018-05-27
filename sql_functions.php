<?php
/*Получение списка категорий
---*/
function getCategoryList($link) {
    $sql =  'SELECT id, name FROM categories ORDER BY id ASC';
    $result = mysqli_query($link, $sql);
    if (!$result) {
        throw new Exception("DATABASE ERROR");
    }
    else {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
};
/*Получение списка новых лотов, отсортированного по новизне
---*/
function getLotsSortedByNew($link) {
    $sql = 'SELECT id, name, date_start,  description, image, price_start, category_id FROM lots WHERE date_end>NOW() ORDER BY date_start DESC';
    $result = mysqli_query($link, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        throw new Exception("DATABASE ERROR");
    }
};
/*Получение всех ставок для лота по его id
Приведение к типу*/
function getBetsById($link, $id) {
    $id = intval($id);
    $sql = "SELECT b.date_start, b.price, u.name as user_name FROM bets b
                LEFT JOIN users u
                ON b.user_id = u.id
                WHERE lot_id='$id' ORDER BY date_start DESC";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        throw new Exception('DATABASE ERROR');
    }
    return $array;
};
/*Получаем данные лота по его id
Приведение к типу*/
function getLotById($link, $id) {
    $id = intval($id);
    $sql = "SELECT name, image, description, price_start, step_bet, category_id, date_end FROM lots WHERE id='$id'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_assoc($result);
    }
    else {
        throw new Exception('DATABASE ERROR');
    }
    return $array;
};
/*Рассчитываем плэйсхолдер для поля "Ваша ставка"
Приведение к типу ($lot получен из БД)*/
function yourBet($link, $id, $lot) {
    $id = intval($id);
    $sql = "SELECT l.price_start as price_start, l.step_bet as step_bet, COUNT(b.id) as bet_total, MAX(b.price) as cur_max_price FROM bets b
                LEFT JOIN lots l
                ON b.lot_id = l.id
            	WHERE date_end>NOW() AND l.id = '$id' GROUP BY l.id ORDER BY cur_max_price DESC";
    $result = mysqli_query($link, $sql);
    if ($result) {
       $array = mysqli_fetch_assoc($result);
       if (empty($array['cur_max_price'])) {
            $yourBet = $lot['price_start'] + $lot['step_bet'];
       }
       else {
            $yourBet = $array['cur_max_price'] + $array['step_bet'];
       }
   }
    else {
        throw new Exception('DATABASE ERROR');
    };
    return $yourBet;
};
/*Проверка пароля по email пользователя
Экранирование данных (с паролем ничего не делаем, потому что в БД его не отправляем)*/
function validatePasswordByEmail($link, $password, $email, $errors) {
    $email = mysqli_real_escape_string($link, $email);
    $sql = "SELECT password FROM users WHERE email='$email'";
    $res = mysqli_query($link, $sql);
        if ($res) {
            $user = mysqli_fetch_assoc($res);
            if (!password_verify($password, $user['password'])) {
                $errors['password'] = "Пароль введен неверно. Повторите попытку";
            }
        }
        else {
            throw new Exception('DATABASE ERROR');
        };
    return $errors;
};
/*Добавление пользователя в БД
Подготовленные выражения*/
function insertUser($link, $email, $name, $password, $file_path, $message) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (date_register, email, name, password, avatar, contact) VALUES (NOW(), ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, ['email' => $email, 'name' => $name, 'password' => $password, 'file_path' => $file_path, 'message' => $message]);
    $res = mysqli_stmt_execute($stmt);

    if (!$res) {
        $error = 'Не удалось зарегестрировать пользователя';
    }
    return $error;
};

/*Добавление лота в БД
Подготовленные выражения*/
function insertLot($link, $data = []) {
    $sql = 'INSERT INTO lots (date_start, name, category_id, image, price_start, user_id, step_bet, date_end, description) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        return $lot_id = mysqli_insert_id($link);
    }
    else {
        throw new Exception("DATABASE ERROR");
    }
};
/*Валидация email на формат и существование в БД; $up = 1 - для регитрации, другое для входа
Экранирование данных*/
function validateEmail($link, $required, $errors, $up = 1) {
    $email = mysqli_real_escape_string($link, $_POST[$required]);
    if (!empty($_POST[$required])) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $errors[$required] = 'Неверный формат email';
        }
        else {
            $sql = "SELECT id FROM users WHERE email = '$email'";
            $res = mysqli_query($link, $sql);
            if (mysqli_error($link)) {
                throw new Exception("DATABASE ERROR");
            }
            else {
                $num_rows = mysqli_num_rows($res);
                if ($num_rows > 0) {
                     if ($up === 1) {
                         $errors[$required] = 'Пользователь с этим email уже зарегистрирован';
                     }
                }
                else {
                    if ($up !== 1) {
                        $errors[$required] = 'Пользователя с таким email не существует';
                    };
                };
            };
        };
    };
    return $errors;
};
/*Получаем данные пользователя по его email
Приведение к типу*/
function getUserInfo($link, $email) {
    $email = mysqli_real_escape_string($link, $email);
    $sql = "SELECT id, name, avatar, contact FROM users WHERE email='$email'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        $array = mysqli_fetch_assoc($result);
    }
    else {
        throw new Exception('DATABASE ERROR');
    }
    return $array;
};
/*Добавление ставки в БД
Приведение к типу*/
function insertBet($link, $price, $user_id, $lot_id) {
   $price = intval($price);
   $user_id = intval($user_id);
   $lot_id = intval($lot_id);
   $sql = "INSERT INTO bets (date_start, price, user_id, lot_id) VALUES (NOW(), '$price', '$user_id', '$lot_id')";
   $res = mysqli_query($link, $sql);
   if (!$res) {
        $error = 'Не удалось вставить лот';
   }
   return $error;
};
?>
