DROP DATABASE IF EXISTS clock;
CREATE DATABASE clock;
USE clock;

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
	`id` INT(15) NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(20) NULL DEFAULT NULL,
	`password` VARCHAR(20) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `login` (`login`)
);

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
	`id` INT(15) NOT NULL AUTO_INCREMENT,
	`user_id` INT(15) NULL DEFAULT NULL,
	`name` VARCHAR(20) NULL DEFAULT NULL,
	`date` DATE NULL DEFAULT NULL,
	`start` TIME NULL DEFAULT NULL,
	`end` TIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (user_id)  REFERENCES users (id)
);


INSERT INTO users (`login`, `password`) VALUES 
('admin', '111'),
('user', '123');

INSERT INTO `events` (`user_id`, `name`, `date`, `start`, `end`) VALUES 
(1, 'walk', '2020-01-08', '15:00:00', '16:00:00'),
(1, 'walk', '2020-01-09', '17:00:00', '18:00:00'),
(1, 'sport', '2020-01-09', '12:00:00', '13:00:00'),
(1, 'sport', '2020-01-10', '11:00:00', '13:00:00');
