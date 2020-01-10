ALTER TABLE `lkt_user_rule`ADD COLUMN `store_id`  int(11) UNSIGNED NULL COMMENT '商城id' AFTER `wait`;
ALTER TABLE `lkt_user_rule`
ADD COLUMN `is_auto`  tinyint(2) NULL DEFAULT 1 COMMENT '是否开启自动续费 0-不开启 1-开启' AFTER `store_id`,
ADD COLUMN `auto_time`  int(11) UNSIGNED NULL COMMENT '自动续费提前提醒时间（天）' AFTER `is_auto`,
ADD COLUMN `method`  tinyint(2) NULL DEFAULT NULL COMMENT '开通方式 1-包月 2-包季 3-包年' AFTER `auto_time`,
ADD COLUMN `is_wallet`  tinyint(2) NULL DEFAULT 1 COMMENT '是否开启余额支付 0-不开启 1-开启' AFTER `method`,
COMMENT='会员规则表';

