ALTER TABLE `lkt_order_details`
ADD COLUMN `real_money`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '实际退款金额' AFTER `re_money`;