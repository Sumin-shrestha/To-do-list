

CREATE DATABASE IF NOT EXISTS `crud`;
USE `crud`;
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
);

CREATE TABLE `tasks` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_text` TEXT NOT NULL,
  `status` ENUM('pending', 'completed') DEFAULT 'pending',
  `user_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);


INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES
('adminuser', 'admin@example.com', 'admin123', 'admin'),
('regularuser', 'user@example.com', 'user123', 'user');



INSERT INTO `tasks` (`task_text`, `status`, `user_id`) VALUES
('Sample task for admin', 'pending', 1),
('Sample task for user', 'pending', 2),

('Another task for admin', 'completed', 1);
('Sample task for user', 'completed', 2),


ALTER TABLE `tasks` AUTO_INCREMENT = 100;
ALTER TABLE `users` AUTO_INCREMENT = 2;
