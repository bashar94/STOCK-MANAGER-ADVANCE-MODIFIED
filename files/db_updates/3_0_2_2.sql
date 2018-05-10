ALTER TABLE `sma_settings` ADD `remove_expired` TINYINT(1) NULL DEFAULT '0' ;
ALTER TABLE `sma_users` ADD `allow_discount` TINYINT(1) NULL DEFAULT '0' ;
UPDATE `sma_migrations` SET `version` = 310;
UPDATE `sma_settings` SET `version` = '3.0.2.2' where `setting_id` = 1;