ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `method`  char(50) NULL DEFAULT NULL COMMENT '��ͨ��ʽ 1-���� 2-���� 3-����' AFTER `auto_time`;