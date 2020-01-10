ALTER TABLE `lkt_coupon_config`
ADD COLUMN `coupon_day` int(11) COMMENT '优惠券删除天数' AFTER `coupon_del`,
ADD COLUMN `activity_day` int(11) COMMENT '优惠券活动删除天数' AFTER `activity_del`;

ALTER TABLE `lkt_coupon_activity`
ADD COLUMN `Instructions` text COMMENT '使用说明' AFTER `day`;