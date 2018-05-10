ALTER TABLE `sma_purchases`
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;
ALTER TABLE `sma_purchase_items`
 ADD `gst` VARCHAR(20) NULL,
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;

ALTER TABLE `sma_sales`
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;
ALTER TABLE `sma_sale_items`
 ADD `gst` VARCHAR(20) NULL,
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;

ALTER TABLE `sma_quotes`
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;
ALTER TABLE `sma_quote_items`
 ADD `gst` VARCHAR(20) NULL,
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;

ALTER TABLE `sma_transfers`
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;
ALTER TABLE `sma_transfer_items`
 ADD `gst` VARCHAR(20) NULL,
 ADD `cgst` DECIMAL(25,4) NULL,
 ADD `sgst` DECIMAL(25,4) NULL,
 ADD `igst` DECIMAL(25,4) NULL;

ALTER TABLE `sma_products` ADD `hsn_code` INT NULL,
 ADD `views` INT(11) NULL DEFAULT '0',
 ADD `hide` TINYINT(1) NULL DEFAULT '0';

ALTER TABLE `sma_settings` ADD `state` VARCHAR(100) NULL,
 ADD `pdf_lib` VARCHAR(20) NULL DEFAULT 'mpdf';
UPDATE `sma_settings` SET `version` = '3.2.5' WHERE `setting_id` = 1;
