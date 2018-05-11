USE yeticave;

INSERT INTO category(name) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');

INSERT INTO user(name, email, password, avatar, date_register) VALUES ('Иван', 'ivan80@e.mail', 'pas1', '', '2017-04-24 14:20:10'), 
('Константин', 'kostik777@e.mail', 'passWORD', 'img/user.jpg', '2017-04-04 12:07:05'),
('Евгений', 'jeka@e.mail', '123456789', '', '2016-03-24 14:20:10'),
('Семён', 'semki666@e.mail', 'qwerty123', '', '2017-09-24 11:11:00');

INSERT INTO lot(name, category_id, image, price_start, date_start, user_id, step_bet, date_end) VALUES ('2014 Rossignol District Snowboard', '1', 'img/lot-1.jpg', '10999', '2018-04-02 00:05:10', '3', '200', '2018-04-08 18:15:10'),
('DC Ply Mens 2016/2017 Snowboard', '1', 'img/lot-2.jpg', '159999', '2018-04-16 14:32:10', '1', '2000', '2018-04-25 14:25:10'),
('Крепления Union Contact Pro 2015 года размер L/XL', '2', 'img/lot-3.jpg', '8000', '2018-04-18 00:05:10', '1', '500','2018-04-28 10:45:18'),
('Ботинки для сноуборда DC Mutiny Charocal', '3', 'img/lot-4.jpg', '10999', '2018-04-28 00:05:10', '2', '200', NULL),
('Куртка для сноуборда DC Mutiny Charocal', '4', 'img/lot-5.jpg', '7500', '2018-04-28 12:05:47', '4', '150', NULL),
('Маска Oakley Canopy', '6', 'img/lot-6.jpg', '5400', '2017-05-01 00:05:10', '2', '500', NULL);

INSERT INTO bet(user_id, price, lot_id, date_start) VALUES ('1', '5900', '6', '2018-05-01 23:30:45'),
('2', '11399', '4', '2018-05-07 17:30:02'),
('3', '7800', '5', '2018-05-04 07:30:00'),
('1', '6400', '6', '2018-05-08 11:50:49'),
('1', '6900', '6', '2018-05-08 17:30:59');


/*Выводим все лоты*/
SELECT * FROM lot;
/*Выводим все ставки*/
SELECT * FROM bet;
/*Выводим всех пользвателей*/
SELECT * FROM user;
/*Выводим все категории*/
SELECT * FROM category;

/*Получим самые новые, открытые лоты. Каждый лот в итоговой таблице включает название, стартовую цену, ссылку на изображение, цену (текущая максимальная ставка по лоту), количество ставок, название категории*/
SELECT l.id, l.name, c.name, image, l.date_start, price_start, COUNT(b.id) as bet_total, MAX(b.price) as cur_max_price FROM bet b
   LEFT JOIN lot l
	ON b.lot_id = l.id      
   LEFT JOIN category c
   ON l.category_id = c.id
	WHERE date_end IS NULL GROUP BY l.id ORDER BY l.date_start DESC;


/*Показываем лот по его id. Получием также название категории, к которой принадлежит лот*/
SELECT l.name, c.name FROM lot l
	LEFT JOIN category c
	ON l.category_id = c.id 
	WHERE c.id = '3';

/*Обновляем название лота по его идентификатору*/
UPDATE lot SET name = '2015 Rossignol District Snowboard'
WHERE id = '1';

/*Получаем список самых свежих ставок для лота по его индексу
По индексу 6*/
SELECT * FROM bet
WHERE lot_id = '6' ORDER BY date_start DESC;
/*По индексу 4*/
SELECT * FROM bet
WHERE lot_id = '4' ORDER BY date_start DESC;
/*По индексу 5*/
SELECT * FROM bet
WHERE lot_id = '5' ORDER BY date_start DESC;
