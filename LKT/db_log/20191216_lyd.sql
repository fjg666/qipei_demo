ALTER TABLE `lkt_agreement`
ADD COLUMN `name`  char(200) NULL COMMENT '协议名称' AFTER `store_id`;