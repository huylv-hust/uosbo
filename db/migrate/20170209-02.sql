ALTER TABLE `uos`.`mail_queue`
CHANGE COLUMN `mail_to` `mail_to` TEXT NOT NULL ,
CHANGE COLUMN `mail_from` `mail_from` VARCHAR(255) NOT NULL ;
