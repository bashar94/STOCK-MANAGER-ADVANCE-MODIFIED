ALTER TABLE `sma_users` ADD `view_right` TINYINT(1) NOT NULL DEFAULT '0', ADD `edit_right` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `sma_purchase_items` ADD `quantity_received` DECIMAL(15,4) NULL ;
ALTER TABLE `sma_settings` ADD `display_symbol` TINYINT(1) NULL, ADD `symbol` VARCHAR(50) NULL;
ALTER TABLE `sma_permissions` ADD `products-adjustments` TINYINT(1) NOT NULL DEFAULT '0';
UPDATE `sma_migrations` SET `version` = 309;
UPDATE `sma_settings` SET `version` = '3.0.2.0' where `setting_id` = 1;