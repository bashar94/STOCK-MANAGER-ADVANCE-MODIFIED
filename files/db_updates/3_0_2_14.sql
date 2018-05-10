ALTER TABLE `sma_deliveries` ADD `status` VARCHAR(15) NULL,
ADD `attachment` VARCHAR(50) NULL,
ADD `delivered_by` VARCHAR(50) NULL,
ADD `received_by` VARCHAR(50) NULL;

CREATE TABLE IF NOT EXISTS `sma_gift_card_topups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL,
  `card_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `card_id` (`card_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sma_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `line1` varchar(50) NOT NULL,
  `line2` varchar(50) NULL,
  `city` varchar(25) NOT NULL,
  `postal_code` varchar(20) NULL,
  `state` varchar(25) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(50) NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `sma_products` CHANGE `unit` `unit` INT(11) NULL DEFAULT '1',
ADD `sale_unit` INT(11) NULL,
ADD `purchase_unit` INT(11) NULL,
ADD `brand` INT NULL,
ADD INDEX(`unit`),
ADD INDEX(`brand`);

ALTER TABLE `sma_warehouses` ADD `price_group_id` INT NULL;
ALTER TABLE `sma_companies` ADD `price_group_id` INT(11) NULL,
ADD `price_group_name` VARCHAR(50) NULL;

CREATE TABLE IF NOT EXISTS `sma_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sma_price_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sma_product_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price_group_id` int(11) NOT NULL,
  `price` DECIMAL(25,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `price_group_id` (`price_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sma_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(55) NOT NULL,
  `base_unit` int(11) DEFAULT NULL,
  `operator` varchar(1) DEFAULT NULL,
  `unit_value` varchar(55) DEFAULT NULL,
  `operation_value` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `base_unit` (`base_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `sma_units` (`id`, `code`, `name`, `base_unit`, `operator`, `unit_value`, `operation_value`) VALUES
(1, 'pc', 'Piece', NULL, NULL, NULL, NULL);

ALTER TABLE `sma_sale_items` ADD `product_unit_id` INT(11) NULL,
ADD `product_unit_code` VARCHAR(10) NULL,
ADD `unit_quantity` DECIMAL(15,4) NOT NULL;

ALTER TABLE `sma_purchase_items` ADD `product_unit_id` INT(11) NULL,
ADD `product_unit_code` VARCHAR(10) NULL,
ADD `unit_quantity` DECIMAL(15,4) NOT NULL;

ALTER TABLE `sma_transfer_items` ADD `product_unit_id` INT(11) NULL,
ADD `product_unit_code` VARCHAR(10) NULL,
ADD `unit_quantity` DECIMAL(15,4) NOT NULL;

ALTER TABLE `sma_quote_items` ADD `product_unit_id` INT(11) NULL,
ADD `product_unit_code` VARCHAR(10) NULL,
ADD `unit_quantity` DECIMAL(15,4) NOT NULL;

ALTER TABLE `sma_settings` ADD `price_group` INT(11) NULL,
ADD `barcode_img` TINYINT(1) NOT NULL DEFAULT '1',
ADD `ppayment_prefix` VARCHAR(20) NULL DEFAULT 'POP',
ADD `disable_editing` TINYINT NULL DEFAULT '90';

ALTER TABLE `sma_order_ref` ADD `ppay` INT NOT NULL DEFAULT '1';

UPDATE `sma_migrations` SET `version`= 316;
UPDATE `sma_settings` SET `version` = '3.0.2.14' WHERE `setting_id` = 1;

ALTER TABLE `sma_suspended_items` ADD `product_unit_id` INT(11) NULL,
ADD `product_unit_code` VARCHAR(10) NULL,
ADD `unit_quantity` DECIMAL(15,4) NOT NULL;
