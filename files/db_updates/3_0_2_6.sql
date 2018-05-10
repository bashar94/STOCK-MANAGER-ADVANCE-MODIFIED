ALTER TABLE `sma_settings` ADD `returnp_prefix` varchar(20) DEFAULT NULL;
ALTER TABLE `sma_payments` ADD `approval_code` VARCHAR(50) NULL;
ALTER TABLE `sma_pos_settings` ADD `authorize` TINYINT(1) NULL DEFAULT '0';
ALTER TABLE `sma_purchases` ADD `return_id` int(11) DEFAULT NULL,
  ADD `surcharge` decimal(25,4) NOT NULL DEFAULT '0.00';
ALTER TABLE `sma_quotes` ADD `supplier_id` INT NULL, ADD `supplier` VARCHAR(55) NULL;
ALTER TABLE `sma_order_ref` ADD `rep` INT(11) NOT NULL DEFAULT '1';
CREATE TABLE IF NOT EXISTS `sma_return_purchase_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) unsigned NOT NULL,
  `return_id` int(11) unsigned NOT NULL,
  `purchase_item_id` int(11) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `product_code` varchar(55) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type` varchar(20) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `net_unit_cost` decimal(25,4) NOT NULL,
  `quantity` decimal(15,4) DEFAULT '0.00',
  `warehouse_id` int(11) DEFAULT NULL,
  `item_tax` decimal(25,4) DEFAULT NULL,
  `tax_rate_id` int(11) DEFAULT NULL,
  `tax` varchar(55) DEFAULT NULL,
  `discount` varchar(55) DEFAULT NULL,
  `item_discount` decimal(25,4) DEFAULT NULL,
  `subtotal` decimal(25,4) NOT NULL,
  `real_unit_cost` DECIMAL(25,4) NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_id` (`purchase_id`),
  KEY `product_id` (`product_id`),
  KEY `product_id_2` (`product_id`,`purchase_id`),
  KEY `purchase_id_2` (`purchase_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `sma_return_purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reference_no` varchar(55) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(55) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total` decimal(25,4) NOT NULL,
  `product_discount` decimal(25,4) DEFAULT '0.00',
  `order_discount_id` varchar(20) DEFAULT NULL,
  `total_discount` decimal(25,4) DEFAULT '0.00',
  `order_discount` decimal(25,4) DEFAULT '0.00',
  `product_tax` decimal(25,4) DEFAULT '0.00',
  `order_tax_id` int(11) DEFAULT NULL,
  `order_tax` decimal(25,4) DEFAULT '0.00',
  `total_tax` decimal(25,4) DEFAULT '0.00',
  `surcharge` decimal(25,4) DEFAULT '0.00',
  `grand_total` decimal(25,4) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attachment` VARCHAR(55) NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `sma_expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `sma_expenses` ADD `category_id` INT NULL ;
ALTER TABLE `sma_permissions` ADD `products-barcode` TINYINT(1) NOT NULL DEFAULT '0',
  ADD `purchases-return_purchases` TINYINT(1) NOT NULL DEFAULT '0',
  ADD `reports-expenses` TINYINT(1) NOT NULL DEFAULT '0';
UPDATE `sma_migrations` SET `version` = 313;
UPDATE `sma_settings` SET `version` = '3.0.2.6' where `setting_id` = 1;