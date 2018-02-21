ALTER TABLE `job`
ADD COLUMN `time_target` INT NOT NULL DEFAULT 0 AFTER `is_webtoku`,
ADD COLUMN `person_target` INT NOT NULL DEFAULT 0 AFTER `time_target`;