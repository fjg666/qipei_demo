ALTER TABLE `test`.`lkt_order`
ADD COLUMN `subtraction_id` int(11) COMMENT '满减活动ID' AFTER `coupon_id`;