ALTER TABLE `sma_pos_settings` ADD `after_sale_page` TINYINT(1) NULL DEFAULT '0',
 ADD `item_order` TINYINT(1) NULL DEFAULT '0';
UPDATE `sma_migrations` SET `version` = 311;
UPDATE `sma_settings` SET `version` = '3.0.2.3' where `setting_id` = 1;