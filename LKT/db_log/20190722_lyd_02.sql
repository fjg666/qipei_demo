ALTER TABLE `lkt_user_rule`
ADD COLUMN `upgrade`  tinyint(2) NULL COMMENT '������ʽ 1-�����Ա���� 2-�����' AFTER `is_wallet`;