ALTER TABLE `sma_suspended_items` ADD `comment` VARCHAR(255) NULL;
ALTER TABLE `sma_suspended_bills` ADD `shipping` DECIMAL(15,4) NULL DEFAULT '0';

ALTER TABLE `sma_pos_settings` ADD `remote_printing` TINYINT(1) NULL DEFAULT '1',
ADD `printer` INT(11) NULL,
ADD `order_printers` VARCHAR(55) NULL,
ADD `auto_print` TINYINT(1) NULL DEFAULT '0',
ADD `customer_details` TINYINT(1) NULL;

CREATE TABLE IF NOT EXISTS `sma_printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) NOT NULL,
  `type` varchar(25) NOT NULL,
  `profile` varchar(25) NOT NULL,
  `char_per_line` TINYINT UNSIGNED NULL,
  `path` varchar(255) DEFAULT NULL,
  `ip_address` varbinary(45) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

UPDATE `sma_pos_settings` SET `version` = '3.0.2.23' WHERE `pos_id` = 1;
