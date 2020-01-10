ALTER TABLE `lkt_user_rule`
ADD COLUMN `score`  int(11) NULL DEFAULT 0 COMMENT '积分过期设置' AFTER `valid`;

ALTER TABLE `lkt_sign_record`
MODIFY COLUMN `type`  int(4) NOT NULL DEFAULT 0 COMMENT '类型: 0:签到 1:消费 2:首次关注得积分 3:转积分给好友 4:好友转积分 5:系统扣除 6:系统充值 7:抽奖 8:会员购物积分 9:分销升级奖励积分 10:积分过期' AFTER `sign_time`;

