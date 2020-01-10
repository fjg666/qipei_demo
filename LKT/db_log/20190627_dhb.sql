ALTER TABLE `lkt_coupon_activity` 
MODIFY COLUMN `activity_type` int(11) DEFAULT 0 COMMENT '优惠券类型' AFTER `name`;

ALTER TABLE `lkt_customer` 
MODIFY COLUMN `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0:启用 1:到期 2:锁定' 
AFTER `end_date`;

ALTER TABLE `lkt_coupon_config` 
ADD COLUMN `coupon_del` tinyint(4) COMMENT '优惠券删除' AFTER `is_status`,
ADD COLUMN `activity_del` tinyint(4) COMMENT '优惠券活动删除' AFTER `coupon_del`;