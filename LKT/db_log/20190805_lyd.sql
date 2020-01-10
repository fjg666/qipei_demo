ALTER TABLE `lkt_auction_config`
ADD COLUMN `is_open`  tinyint(2) NULL DEFAULT 1 COMMENT '是否开启插件 0-不开启 1-开启' AFTER `store_id`;

ALTER TABLE `lkt_user_rule`
ADD COLUMN `is_jifen`  tinyint(2) NULL DEFAULT 0 COMMENT '会员等比例积分 0-不开启 1-开启' AFTER `is_product`,
ADD COLUMN `jifen_m`  tinyint(2) NULL DEFAULT 1 COMMENT '积分发送规则 0-付款后 1-收货后' AFTER `is_jifen`;

ALTER TABLE `lkt_sign_record`
MODIFY COLUMN `type`  int(4) NOT NULL DEFAULT 0 COMMENT '类型: 0:签到 1:消费 2:首次关注得积分 3:转积分给好友 4:好友转积分 5:系统扣除 6:系统充值 7:抽奖 8:会员购物积分' AFTER `sign_time`;

