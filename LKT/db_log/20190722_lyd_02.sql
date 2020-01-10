ALTER TABLE `lkt_user_rule`
ADD COLUMN `upgrade`  tinyint(2) NULL COMMENT '升级方式 1-购买会员服务 2-补差额' AFTER `is_wallet`;