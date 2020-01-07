USE clock;
DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
	`id` INT(15) NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(20) NULL DEFAULT NULL,
	`password` VARCHAR(20) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `login` (`login`)
);

INSERT INTO `users` (`login`, `password`) VALUES 
('admin', '111'),
('user', '123');