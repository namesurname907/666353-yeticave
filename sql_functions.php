<?php
/**
 * Получение списка категорий в порядке их идентификатаров
 *
 * @param $link mysqli Ресурс соединения
 * @return array|null Массив со списком категорий или ничего в случае ошибки
 * @throws Exception
 */
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
/**
 * Получение списка новых лотов, отсортированных по новизне
 *
 * @param $link mysqli Ресурс соединения
 * @return array|null Массив со списком новых лотов или ничего в случае ошибки
 * @throws Exception
 */
function getLotsSortedByNew($link) {
    $sql = 'SELECT id, name, date_start,  description, image, price_start, category_id, date_end FROM lots WHERE date_end>NOW() ORDER BY date_start DESC';
    $result = mysqli_query($link, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        throw new Exception("DATABASE ERROR");
    }
};
/**
 * Получение всех ставок для лота по его id
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param int $id Идентификатор лота
 *
 * @return array|null Массив со ставками или ничего в случае ошибки
 * @throws Exception
 */
function getBetsById($link, $id) {
    $array = [];
    $sql = "SELECT b.date_start, b.price, u.name as user_name, b.user_id FROM bets b LEFT JOIN users u ON b.user_id = u.id WHERE lot_id=? ORDER BY date_start DESC";
    $stmt = db_get_prepare_stmt($link, $sql, ['id' => $id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $array[$i] = $row;
            $i++;
        }
    }
    else {
        throw new Exception("DATABASE ERROR");
    }
    return $array;
};
/**
 * Получение информации лота по его id
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param int $id Идентификатор лота
 *
 * @return array|null Массив с описанием лота или ничего в случае ошибки
 * @throws Exception
 */
function getLotById($link, $id) {
    $array = NULL;
    $sql = "SELECT name, image, description, price_start, step_bet, category_id, date_end, user_id FROM lots WHERE id=?";
    $stmt = db_get_prepare_stmt($link, $sql, ['id' => $id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $array = mysqli_fetch_assoc($result);
    }
    else {
        throw new Exception('DATABASE ERROR');
    }
    return $array;
};
/**
 * Расчет плэйсхолдера для поля "Ваша ставка" на основе идентификатора лота и его описания
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param int $id Идентификатор лота
 * @param array $lot Массив с информацией о лоте
 *
 * @return int|null Ставка или ничего в случае ошибки
 * @throws Exception
 */
function yourBet($link, $id, $lot) {
    $array = [];
    $sql = "SELECT l.price_start as price_start, l.step_bet as step_bet, COUNT(b.id) as bet_total, MAX(b.price) as cur_max_price FROM bets b
                LEFT JOIN lots l
                ON b.lot_id = l.id
            	WHERE date_end>NOW() AND l.id = ? GROUP BY l.id ORDER BY cur_max_price DESC";
    $stmt = db_get_prepare_stmt($link, $sql, ['id' => $id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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
    }
        return $yourBet;
};
/**
 * Проверка пароля пользователя по его email
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param string $password Пароль пользоавателя
 * @param string $email Email пользователя
 * @param array $errors Массив для записи ошибки
 *
 * @return array $errors Массив с ошибками, где появилась новая или нет
 * @throws Exception
 */
function validatePasswordByEmail($link, $password, $email, $errors) {
    $sql = "SELECT password FROM users WHERE email=?";
    $stmt = db_get_prepare_stmt($link, $sql, ['email' => $email]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            $user = mysqli_fetch_assoc($result);
            if (!password_verify($password, $user['password'])) {
                $errors['password'] = "Пароль введен неверно. Повторите попытку";
            }
        }
        else {
            throw new Exception('DATABASE ERROR');
        };

    return $errors;
};
/**
 * Добавление пользователя в Базу данных
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param string $email Email пользователя
 * @param string $name Имя
 * @param string $password Пароль
 * @param string $file_path Аватар
 * @param string $message Контакты
 *
 * @return null|string В случае успеха не вовзвращает ничего, в случае неудачи - ошибку
 */
function insertUser($link, $email, $name, $password, $file_path, $message) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $error = NULL;
    $sql = 'INSERT INTO users (date_register, email, name, password, avatar, contact) VALUES (NOW(), ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($link, $sql, ['email' => $email, 'name' => $name, 'password' => $password, 'file_path' => $file_path, 'message' => $message]);
    $res = mysqli_stmt_execute($stmt);

    if (!$res) {
        $error = 'Не удалось зарегестрировать пользователя';
    }
     $error;
};
/**
 * Добавление лота в Базу данных
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param array $data Информация о лоте, которую необхолимо занести
 *
 * @return int|null В случае успеха возвращает id лота, неудачи - ничего
 * @throws Exception
 */
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
/**
 * Валидация email на формат и существование в БД;
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param string $email Email, который необходимо провалидировать
 * @param array $errors Массив, куда запишем ошибку
 * @param int $up 1 - для регитрации, любое другое для входа
 *
 * @return array $errors Массив с ошибками, где появилась новая или нет
 * @throws Exception
 */
function validateEmail($link, $email, $errors, $up = 1) {
    $user = NULL;
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $errors['email'] = 'Неверный формат email';
        }
        else {
            $sql = "SELECT password FROM users WHERE email=?";
            $stmt = db_get_prepare_stmt($link, $sql, ['email' => $email]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                $user = mysqli_fetch_assoc($result);
                $num_rows = mysqli_num_rows($result);
                if ($num_rows > 0) {
                     if ($up === 1) {
                         $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
                     }
                }
                else {
                    if ($up !== 1) {
                        $errors['email'] = 'Пользователя с таким email не существует';
                    };
                };

            }
            else {
                throw new Exception('DATABASE ERROR');
            }
        }
    }
    return $errors;
};
/**
 * Получаем данные пользователя по его email
 * с использованием подготовленных выражений
 *
 * @param $link  mysqli Ресурс соединения
 * @param string $email Email пользователя
 *
 * @return array|null В случае удачи возвращает массив с информацией о пользоавателе, в случае неудачи - ничего
 * @throws Exception
 */
function getUserInfo($link, $email) {
    $user = NULL;
    $sql = "SELECT id, name, avatar, contact FROM users WHERE email=?";
    $stmt = db_get_prepare_stmt($link, $sql, ['email' => $email]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
    }
    else {
        throw new Exception('DATABASE ERROR');
    }
    return $user;
};
/**
 * Добавление ставки в БД
 * с использованием подготовленных выражений
 *
 * @param $link mysqli Ресурс соединения
 * @param int $price
 * @param int $user_id
 * @param int $lot_id
 * 
 * @return null|string В случае удачи не возвращает ничего, в противном - ошибку
 */
function insertBet($link, $price, $user_id, $lot_id) {
   $error = NULL;
   $sql = "INSERT INTO bets (date_start, price, user_id, lot_id) VALUES (NOW(), ?, ?, ?)";
   $stmt = db_get_prepare_stmt($link, $sql, ['price' => $price, 'user_id' => $user_id, 'lot_id' => $lot_id]);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
   if ($result) {
        $error = 'Не удалось вставить лот';
   }
   return $error;
};
?>
