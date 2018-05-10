ALTER TABLE `sma_sales` ADD `rounding` DECIMAL(10,4) NULL;
ALTER TABLE `sma_categories` ADD `parent_id` INT(11) NULL;
ALTER TABLE `sma_settings` ADD `qa_prefix` VARCHAR(55) NULL;
ALTER TABLE `sma_order_ref` ADD `qa` INT(11) NULL DEFAULT '1';
RENAME TABLE `sma_adjustments` TO `sma_adjustment_items`;
ALTER TABLE `sma_adjustment_items` CHANGE `created_by` `serial_no` VARCHAR(255) NULL DEFAULT NULL,
ADD `adjustment_id` INT NOT NULL, ADD INDEX(`adjustment_id`);
ALTER TABLE `sma_adjustment_items` DROP `date`, DROP `updated_by`, DROP `note`;
CREATE TABLE IF NOT EXISTS `sma_adjustments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL,
  `reference_no` varchar(55) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `note` text NULL,
  `attachment` VARCHAR(55) NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `sma_price_groups` (`name`) VALUES ('Default');

UPDATE `sma_settings` SET `version` = '3.0.2.15' WHERE `setting_id` = 1;

ALTER TABLE `sma_pos_settings` ADD `toggle_brands_slider` VARCHAR(55) NULL;