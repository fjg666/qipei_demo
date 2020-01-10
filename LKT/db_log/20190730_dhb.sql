ALTER TABLE `lkt_coupon_activity`
ADD COLUMN `grade_id` int(11) COMMENT ''会员等级ID'' AFTER `activity_type`;
ALTER TABLE `lkt_coupon_activity`
ADD COLUMN `day` int(11) COMMENT ''有效时间'' AFTER `recycle`;