ALTER TABLE `lkt_user_first`
ADD COLUMN `is_use`  tinyint(2) NULL DEFAULT 0 COMMENT '�Ƿ�ʹ�����״ο�ͨ������Ʒȯ 0-δʹ�� 1-��ʹ��' AFTER `store_id`;