ALTER TABLE `lkt_user`
ADD COLUMN `grade_add`  timestamp NULL DEFAULT NULL COMMENT '充值会员等级时间' AFTER `grade`,
ADD COLUMN `grade_end`  timestamp NULL DEFAULT NULL COMMENT '会员等级到期时间' AFTER `grade_add`;