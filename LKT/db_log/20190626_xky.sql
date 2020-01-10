ALTER TABLE `lkt_user_distribution`
ADD COLUMN `one_put`  decimal(11,2) NOT NULL DEFAULT 0 COMMENT '个人进货奖励已经发放最大条件' AFTER `allamount`,
ADD COLUMN `team_put`  decimal(11,2) NOT NULL DEFAULT 0 COMMENT '团队业绩奖励已经发放最大' AFTER `one_put`;
ALTER TABLE `lkt_distribution_record`
MODIFY COLUMN `type`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 1:转入(收入) 2:提现 3:个人进获奖8:充值积分' AFTER `event`;