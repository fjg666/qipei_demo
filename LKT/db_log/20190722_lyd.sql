ALTER TABLE `lkt_user_rule`ADD COLUMN `store_id`  int(11) UNSIGNED NULL COMMENT '�̳�id' AFTER `wait`;
ALTER TABLE `lkt_user_rule`
ADD COLUMN `is_auto`  tinyint(2) NULL DEFAULT 1 COMMENT '�Ƿ����Զ����� 0-������ 1-����' AFTER `store_id`,
ADD COLUMN `auto_time`  int(11) UNSIGNED NULL COMMENT '�Զ�������ǰ����ʱ�䣨�죩' AFTER `is_auto`,
ADD COLUMN `method`  tinyint(2) NULL DEFAULT NULL COMMENT '��ͨ��ʽ 1-���� 2-���� 3-����' AFTER `auto_time`,
ADD COLUMN `is_wallet`  tinyint(2) NULL DEFAULT 1 COMMENT '�Ƿ������֧�� 0-������ 1-����' AFTER `method`,
COMMENT='��Ա�����';

