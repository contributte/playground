CREATE TABLE `messages` (
    `message_id` INT AUTO_INCREMENT NOT NULL,
    `id` varchar(191) NOT NULL,
    `locale` char(5) NOT NULL,
    `message` varchar(191) NOT NULL,
    PRIMARY KEY(message_id),
    KEY `id` (`id`),
    KEY `locale` (`locale`),
    KEY `message` (`message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
