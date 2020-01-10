ALTER TABLE `lkt_order_config`
ADD COLUMN `accesscode`  char(100) NULL DEFAULT '' COMMENT '顾客编码' AFTER `remind`,
ADD COLUMN `checkword`  text NULL COMMENT '校验码' AFTER `accesscode`,
ADD COLUMN `custid`  char(100) NULL COMMENT '月结卡号' AFTER `checkword`;

ALTER TABLE `lkt_order_details`
ADD COLUMN `express_type`  tinyint(4) NULL DEFAULT 1 COMMENT '发货类型 1.手动发货 2.自动发货' AFTER `courier_num`;

