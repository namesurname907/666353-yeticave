CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE category (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64)
);

CREATE TABLE lot (
id INT AUTO_INCREMENT PRIMARY KEY,
date_start DATETIME,
name VARCHAR(64),
discription TEXT,
image VARCHAR(255),
price_start INT UNSIGNED,
date_end DATETIME,
step_bet INT UNSIGNED,
user_id INT(10),
category_id INT
);

CREATE TABLE bet (
id INT AUTO_INCREMENT PRIMARY KEY,
date_start DATETIME,
price INT UNSIGNED,
user_id INT,
lot_id INT
);

CREATE TABLE user (
id INT AUTO_INCREMENT PRIMARY KEY,
date_register DATETIME,
email VARCHAR(128),
name VARCHAR(128),
password VARCHAR(128),
avatar VARCHAR(255),
contact TEXT
);

CREATE INDEX l_name ON lot(name);
CREATE INDEX l_price_start ON lot(price_start);
CREATE INDEX u_name ON user(name);

CREATE UNIQUE INDEX email ON user(email);
CREATE UNIQUE INDEX c_name ON category(name);