ALTER TABLE `lkt_order`
ADD COLUMN `grade_price`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '��Ա�ػݽ��' AFTER `coupon_price`;