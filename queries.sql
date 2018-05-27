USE yeticave;

INSERT INTO categories(name) VALUES ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное'), ('Аксессуары');

INSERT INTO `users` (`id`, `date_register`, `email`, `name`, `password`, `avatar`, `contact`) VALUES
	(1, '2018-05-27 02:14:06', 'test-avatar@e.mail', 'Keks', '$2y$10$u8kkriv8bR9QEx0ehSkf7O0tV7wzpoFTleFrKSH4h/QzMmhjCfOfm', 'public/5b09ce1e8ae26.jpg', '1234'),
	(2, '2018-05-27 02:26:31', 'test-noavatar@e.m', 'Bird', '$2y$10$pxnn0.JBjcIw2qOIBDXF.O7SHoxLX19mreoAEO3SPGoMdzEbnf2gu', '', 'qwerty123'),
	(3, '2018-05-27 02:30:33', 'test-noavatar2@e.m', 'John', '$2y$10$Nh9JEbYQSr0zXI.GAqNO5OIw7YWT7KlDsjhSZ8oyzchxTVkutiGle', '', '1234'),
	(4, '2018-05-27 02:31:15', 'test-noavatar3@e.m', 'Alice', '$2y$10$I3Gqx193jRx/g.Ow.84Dm.9TVdVH0ipGr9wz7EMckpgAW8rzin6sy', 'public/5b09d223ab3dc.jpg', '1234'),
	(5, '2018-05-27 02:35:18', 'test-noavatar4@e.m', 'Anton', '$2y$10$ZJTq00aubu2eQkt1OQq3XOj19jF30SdBSs/OG3.z7pgmSpjUn1Y5.', '', '1234'),
	(6, '2018-05-27 03:12:12', 'jane-no@e.m', 'Jane', '$2y$10$5xg6uP3arWW1eW1ErvTI3.lB15/juoEyENbEVIrVuwZMB/SttUf26', '', '1234'),
	(7, '2018-05-27 03:13:58', 'alice-yes@e.m', 'Alice', '$2y$10$wZmcsBcuA3.YbhPHOtSDVeeIRz1anAqcoE7iQsQ.gu1eOxJ/t100u', 'public/5b09dc26d0e51.jpg', '1234'),
	(8, '2018-05-27 03:16:01', '100-no@mail.ru', 'Keks', '$2y$10$MduAMlt2GvzG9l3lLUD0YeDDfqdOTjxRvfh4KYxF8KDjNXj9s2FMG', '', '1234');

INSERT INTO `lots` (`id`, `date_start`, `name`, `description`, `image`, `price_start`, `date_end`, `step_bet`, `user_id`, `category_id`) VALUES
	(1, '2018-04-02 00:05:10', '2015 Rossignol District Snowboard', 'Яркая и стильная доска не оставит незамеченной свою хозяйку. Эта доска покажет вам мир снега и не оставит равнодушной к этому замечательному виду спорта.', 'img/lot-1.jpg', 10999, '2018-04-08 18:15:10', 200, 3, 1),
	(2, '2018-04-16 14:32:10', 'DC Ply Mens 2016/2017 Snowboard', 'Топовая модель для агрессивнового парка и фристайла. У доски классическая форма. Фирменная база в третьем поколении обладает улучшенной динамикой за счет технологии SIDEKICK. Эта модель сочетает в себе лучшие свойства: от стритовой геометрии и мощнейшего щелчка парковых досок до управляемости снарядов из жанра All Mountain.', 'img/lot-2.jpg', 159999, '2018-04-25 14:25:10', 2000, 1, 1),
	(3, '2018-04-18 00:05:10', 'Крепления Union Contact Pro 2015 года размер L/XL', '', 'img/lot-3.jpg', 8000, '2018-04-28 10:45:18', 500, 1, 2),
	(4, '2018-04-28 00:05:10', 'Ботинки для сноуборда DC Mutiny Charocal', '', 'img/lot-4.jpg', 10999, '2018-06-28 10:45:18', 200, 2, 3),
	(5, '2018-04-28 12:05:47', 'Куртка для сноуборда DC Mutiny Charocal', '', 'img/lot-5.jpg', 7500, '2018-07-01 10:45:18', 150, 4, 4),
	(6, '2017-05-01 00:05:10', 'Маска Oakley Canopy', 'Маска среднего размера с большой линзой, которая не будет выглядеть слишком громоздко, но при этом обеспечит отличный обзор. Гибкая рамка оправы O Matter™ адаптируется к форме лица, даже при очень низкой температуре, а тройная прослойка из микрофлиса отводит влагу, благодаря чему маску можно с комфортом носить целый день.', 'img/lot-6.jpg', 5400, '2018-07-29 17:45:18', 500, 2, 6),
	(7, '2017-05-01 00:05:10', 'Fischer TWIN SKIN POWER EF NIS N44416', 'Классическая модель для активного отдыха. В модели использован легкий сердечник Air Channel Basalite. Камус Twin Skin обеспечивает уверенное держание на подьеме.', 'img/lot-7.jpg', 6800, '2018-08-01 10:45:18', 300, 2, 1),
	(8, '2018-05-27 03:26:20', 'Беговые лыжи MARPETTI 2007-08 BAMBINI TR', 'Не требуют дополнительной смазки. Отличаются высокой прочностью и обладают хорошими скоростными характеристиками. \r\nПревосходный выбор для зимних прогулок по снегу. \r\nНасечка TR.', 'img/5b09df0c0ac9b.jpg', 3000, '2018-07-31 00:00:00', 200, 3, 1);

INSERT INTO `bets` (`id`, `date_start`, `price`, `user_id`, `lot_id`) VALUES
	(1, '2018-05-01 23:30:45', 5900, 5, 6),
	(2, '2018-05-07 17:30:02', 11399, 6, 4),
	(3, '2018-05-04 07:30:00', 7800, 5, 5),
	(4, '2018-05-08 11:50:49', 6400, 7, 6),
	(5, '2018-05-08 17:30:59', 6900, 8, 6),
	(6, '2018-05-27 03:27:52', 7400, 7, 6);


/*Выводим все лоты*/
SELECT * FROM lots;
/*Выводим все ставки*/
SELECT * FROM bets;
/*Выводим всех пользвателей*/
SELECT * FROM users;
/*Выводим все категории*/
SELECT * FROM categories;

/*Получим самые новые, открытые лоты. Каждый лот в итоговой таблице включает название, стартовую цену, ссылку на изображение, цену (текущая максимальная ставка по лоту), количество ставок, название категории*/
SELECT l.id, l.name, c.name, image, l.date_start, price_start, COUNT(b.id) as bet_total, MAX(b.price) as cur_max_price FROM bets b
   LEFT JOIN lots l
	ON b.lot_id = l.id
   LEFT JOIN categories c
   ON l.category_id = c.id
	WHERE date_end IS NULL GROUP BY l.id ORDER BY l.date_start DESC;


/*Показываем лот по его id. Получием также название категории, к которой принадлежит лот*/
SELECT l.name, c.name FROM lots l
	LEFT JOIN categories c
	ON l.category_id = c.id
	WHERE c.id = '3';

/*Обновляем название лота по его идентификатору*/
UPDATE lots SET name = '2015 Rossignol District Snowboard'
WHERE id = '1';

/*Получаем список самых свежих ставок для лота по его индексу
По индексу 6*/
SELECT * FROM bets
WHERE lot_id = '6' ORDER BY date_start DESC;
/*По индексу 4*/
SELECT * FROM bets
WHERE lot_id = '4' ORDER BY date_start DESC;
/*По индексу 5*/
SELECT * FROM bets
WHERE lot_id = '5' ORDER BY date_start DESC;
