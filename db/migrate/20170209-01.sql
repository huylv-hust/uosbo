CREATE TABLE IF NOT EXISTS `mail_queue` (
  `queue_id` INT NOT NULL AUTO_INCREMENT,
  `send_time` DATETIME NOT NULL,
  `mail_to` VARCHAR(255) NULL,
  `mail_from` VARCHAR(255) NULL,
  `subject` VARCHAR(255) NULL,
  `body` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`queue_id`))
ENGINE = InnoDB;
