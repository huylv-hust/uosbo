CREATE TABLE IF NOT EXISTS `uos`.`webtoku_plan` (
  `department_id` INT NOT NULL,
  `start_date` DATE NOT NULL,
  `month` TINYINT UNSIGNED NOT NULL,
  `budget` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`department_id`, `start_date`, `month`))
ENGINE = InnoDB;
