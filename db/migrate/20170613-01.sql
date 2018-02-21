ALTER TABLE `person`
ADD COLUMN `is_read` TINYINT NOT NULL DEFAULT 0 AFTER `workplace_sssale_id`;
