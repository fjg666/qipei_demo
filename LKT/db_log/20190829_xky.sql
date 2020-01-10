ALTER TABLE `lkt_order`
MODIFY COLUMN `sheng`  text NULL COMMENT '省' AFTER `sNo`,
MODIFY COLUMN `shi`  text NULL COMMENT '市' AFTER `sheng`,
MODIFY COLUMN `xian`  text NULL COMMENT '县' AFTER `shi`;

ALTER TABLE `lkt_service_address`
MODIFY COLUMN `sheng`  char(100) NOT NULL DEFAULT '0' COMMENT '省id' AFTER `tel`,
CHANGE COLUMN `city` `shi`  char(100) NOT NULL DEFAULT '0' COMMENT '市id' AFTER `sheng`,
CHANGE COLUMN `quyu` `xian`  char(100) NOT NULL DEFAULT '0' COMMENT '区域id' AFTER `shi`;

