ALTER TABLE `uos`.`job`
    ADD COLUMN `conscription_start_date` DATE NULL AFTER `is_conscription`,
    ADD COLUMN `conscription_end_date` DATE NULL AFTER `conscription_start_date`,
    ADD COLUMN `pickup_start_date` DATE NULL AFTER `is_pickup`,
    ADD COLUMN `pickup_end_date` DATE NULL AFTER `pickup_start_date`;