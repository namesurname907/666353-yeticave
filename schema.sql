CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64) NOT NULL
);

CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
date_start DATETIME NOT NULL,
name VARCHAR(64) NOT NULL,
description TEXT,
image VARCHAR(255),
price_start INT UNSIGNED NOT NULL,
date_end DATETIME,
step_bet INT UNSIGNED,
user_id INT(10) NOT NULL,
category_id INT NOT NULL
);

CREATE TABLE bets (
id INT AUTO_INCREMENT PRIMARY KEY,
date_start DATETIME NOT NULL,
price INT UNSIGNED NOT NULL,
user_id INT NOT NULL,
lot_id INT NOT NULL
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
date_register DATETIME NOT NULL,
email VARCHAR(128) NOT NULL,
name VARCHAR(128) NOT NULL,
password VARCHAR(255) NOT NULL,
avatar VARCHAR(255),
contact TEXT
);

CREATE INDEX l_name ON lots(name);
CREATE INDEX l_price_start ON lots(price_start);
CREATE INDEX u_name ON users(name);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX c_name ON categories(name);