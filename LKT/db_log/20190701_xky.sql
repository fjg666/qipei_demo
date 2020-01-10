ALTER TABLE `lkt_order`
ADD COLUMN `real_sno`  varchar(255) NULL COMMENT '调起支付所用订单号' AFTER `comm_discount`;

