ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `upgrade`  char(50) NULL DEFAULT 1 COMMENT '������ʽ 1-�����Ա���� 2-�����' AFTER `is_wallet`;