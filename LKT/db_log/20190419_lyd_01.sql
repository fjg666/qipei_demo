ALTER TABLE `lkt_order_details`
ADD COLUMN `real_money`  decimal(12,2) NULL DEFAULT 0.00 COMMENT 'ʵ���˿���' AFTER `re_money`;