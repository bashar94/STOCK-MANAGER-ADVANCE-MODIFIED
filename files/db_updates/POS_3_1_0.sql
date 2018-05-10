ALTER TABLE `sma_pos_settings` ADD `local_printers` TINYINT(1) NULL;
UPDATE `sma_pos_settings` SET `version` = '3.1.0' WHERE `pos_id` = 1;
