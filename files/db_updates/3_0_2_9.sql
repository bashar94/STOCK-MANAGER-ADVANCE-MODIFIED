ALTER TABLE `sma_settings` ADD `set_focus` TINYINT(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `sma_warehouses_products` ADD `avg_cost` DECIMAL(25,4) NOT NULL ;
ALTER TABLE `sma_permissions` ADD `reports-daily_purchases` TINYINT(1) NULL DEFAULT '0',
    ADD `reports-monthly_purchases` TINYINT(1) NULL DEFAULT '0' ;
ALTER TABLE `sma_expenses` ADD `warehouse_id` INT NULL ;
ALTER TABLE `sma_sales` ADD `return_sale_ref` VARCHAR(55) NULL,
    ADD `sale_id` INT NULL,
    ADD `return_sale_total` DECIMAL(25,4) NOT NULL DEFAULT '0' ;
ALTER TABLE `sma_sale_items` ADD `sale_item_id` INT NULL ;
ALTER TABLE `sma_purchases` ADD `return_purchase_ref` VARCHAR(55) NULL,
    ADD `purchase_id` INT NULL,
    ADD `return_purchase_total` DECIMAL(25,4) NOT NULL DEFAULT '0' ;
ALTER TABLE `sma_purchase_items` ADD `purchase_item_id` INT NULL ;
ALTER TABLE sma_calendar DROP PRIMARY KEY;
ALTER TABLE `sma_calendar` CHANGE `date` `start` DATETIME NOT NULL,
    CHANGE `data` `title` VARCHAR(55) NOT NULL,
    ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ADD `end` DATETIME NULL, 
    ADD `description` VARCHAR(255) NULL, 
    ADD `color` VARCHAR(7) NOT NULL;
UPDATE `sma_migrations` SET `version` = 315;
UPDATE `sma_settings` SET `version` = '3.0.2.9' where `setting_id` = 1;