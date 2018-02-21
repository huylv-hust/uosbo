CREATE TABLE IF NOT EXISTS `cache` (
  `cache_key` VARCHAR(64) NOT NULL,
  `cache_value` TEXT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`cache_key`))
ENGINE = InnoDB