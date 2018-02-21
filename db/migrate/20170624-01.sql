ALTER TABLE `orders`
ADD COLUMN `close_date` DATE NULL AFTER `post_date`;
ALTER TABLE `orders`
ADD COLUMN `work_days_of_week` INT NULL AFTER `work_time_of_month`;
