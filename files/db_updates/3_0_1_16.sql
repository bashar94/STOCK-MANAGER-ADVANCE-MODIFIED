ALTER TABLE `sma_settings` ADD `display_all_products` TINYINT(1) NULL DEFAULT '0' ;
UPDATE `sma_migrations` SET `version` = 308;
UPDATE `sma_settings` SET `version` = '3.0.1.16' where `setting_id` = 1;