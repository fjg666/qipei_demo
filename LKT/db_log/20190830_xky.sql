ALTER TABLE `lkt_mch`
ADD COLUMN `sheng`  char(100) NULL AFTER `tel`,
ADD COLUMN `shi`  char(100) NULL AFTER `sheng`,
ADD COLUMN `xian`  char(100) NULL AFTER `shi`;

