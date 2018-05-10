ALTER TABLE `sma_products` 
    ADD `promotion` TINYINT(1) NULL DEFAULT 0,
    ADD `promo_price` DECIMAL(25,4) NULL DEFAULT NULL,
    ADD `start_date` DATE NULL,
    ADD `end_date` DATE NULL,
    ADD `supplier1_part_no` VARCHAR(50) NULL,
    ADD `supplier2_part_no` VARCHAR(50) NULL,
    ADD `supplier3_part_no` VARCHAR(50) NULL,
    ADD `supplier4_part_no` VARCHAR(50) NULL,
    ADD `supplier5_part_no` VARCHAR(50) NULL;
ALTER TABLE `sma_purchases`
    ADD `payment_term` TINYINT NULL,
    ADD `due_date` DATE NULL;
ALTER TABLE `sma_purchase_items`
    ADD `supplier_part_no` VARCHAR(50) NULL;
ALTER TABLE `sma_settings`
    ADD `barcode_separator` VARCHAR(2) NOT NULL DEFAULT '_';
ALTER TABLE `sma_permissions` 
    ADD `bulk_actions` TINYINT(1) NOT NULL DEFAULT '0',
    ADD `customers-deposits` TINYINT(1) NOT NULL DEFAULT '0',
    ADD `customers-delete_deposit` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `sma_companies` ADD `deposit_amount` DECIMAL(25,4) NULL;
CREATE TABLE IF NOT EXISTS `sma_deposits` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `company_id` INT(11) NOT NULL,
    `amount` DECIMAL(25,4) NOT NULL,
    `paid_by` VARCHAR(50) NULL,
    `note` VARCHAR(255) NULL,
    `created_by` INT NOT NULL,
    `updated_by` INT NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
UPDATE `sma_migrations` SET `version` = 312;
UPDATE `sma_settings` SET `version` = '3.0.2.4' where `setting_id` = 1;