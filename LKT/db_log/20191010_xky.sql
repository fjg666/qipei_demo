ALTER TABLE `lkt_order`
ADD COLUMN `orderId`  text COMMENT '官方订单号' AFTER `real_sno`,
ADD COLUMN `baiduId` varchar(200) DEFAULT NULL COMMENT '百度用户ID' AFTER `orderId`;