ALTER TABLE `lkt_order`
ADD COLUMN `grade_score`  int(11) NULL DEFAULT NULL COMMENT '会员购物积分' AFTER `grade_rate`,
ADD COLUMN `grade_fan`  decimal(12,2) NULL DEFAULT NULL COMMENT '会员返现金额' AFTER `grade_score`;
