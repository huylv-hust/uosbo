ALTER TABLE `uos`.`orders`
ADD COLUMN `price` INT NOT NULL DEFAULT 0 AFTER `post_id`;
