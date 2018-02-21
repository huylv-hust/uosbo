ALTER TABLE `person`
ADD COLUMN `workplace_sssale_id` INT UNSIGNED NOT NULL AFTER `training_user_id`,
ADD INDEX `fk_person_sssale1_idx` (`workplace_sssale_id` ASC);

UPDATE `person` SET workplace_sssale_id = sssale_id;

ALTER TABLE `person`
ADD CONSTRAINT `fk_person_sssale1`
  FOREIGN KEY (`workplace_sssale_id`)
  REFERENCES `sssale` (`sssale_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
