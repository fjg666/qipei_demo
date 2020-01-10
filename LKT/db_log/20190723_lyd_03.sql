ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `upgrade`  char(50) NULL DEFAULT 1 COMMENT '升级方式 1-购买会员服务 2-补差额' AFTER `is_wallet`;