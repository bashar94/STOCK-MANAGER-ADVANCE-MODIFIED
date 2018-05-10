CREATE TABLE IF NOT EXISTS `sma_stock_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `initial_file` varchar(50) NOT NULL,
  `final_file` VARCHAR(50) NULL,
  `brands` varchar(50) NULL,
  `brand_names` varchar(100) NULL,
  `categories` varchar(50) NULL,
  `category_names` varchar(100) NULL,
  `note` text NULL,
  `products` int(11) NULL,
  `rows` int(11) NULL,
  `differences` int(11) NULL,
  `matches` int(11) NULL,
  `missing` int(11) NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NULL,
  `updated_at` datetime NULL,
  `finalized` tinyint(1) NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sma_stock_count_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_count_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) NULL,
  `product_name` varchar(255) NULL,
  `product_variant` varchar(55) NULL,
  `product_variant_id` int(11) NULL,
  `expected` DECIMAL(15,4) NOT NULL,
  `counted` DECIMAL(15,4) NOT NULL,
  `cost` DECIMAL(25,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_count_id` (`stock_count_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `sma_adjustments` ADD `count_id` INT NULL;
ALTER TABLE `sma_settings` CHANGE `disable_editing` `disable_editing` SMALLINT NULL DEFAULT '90';
UPDATE `sma_settings` SET `version` = '3.0.2.17' WHERE `setting_id` = 1;