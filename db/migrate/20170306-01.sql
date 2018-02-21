CREATE TABLE IF NOT EXISTS `mail_group` (
  `mail_group_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail_group_name` VARCHAR(100) NOT NULL,
  `users` TEXT NULL,
  `partner_sales` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`mail_group_id`))
ENGINE = InnoDB
