ALTER TABLE `lkt_order`
ADD COLUMN `grade_price`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '会员特惠金额' AFTER `coupon_price`;