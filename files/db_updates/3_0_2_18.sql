ALTER TABLE `sma_settings` ADD `update_cost` TINYINT(1) NULL;
ALTER TABLE `sma_permissions` ADD `products-stock_count` TINYINT(1) NULL DEFAULT '0',
ADD `edit_price` TINYINT(1) NULL DEFAULT '0';

UPDATE `sma_settings` SET `version` = '3.0.2.18' WHERE `setting_id` = 1;