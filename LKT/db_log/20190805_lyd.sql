ALTER TABLE `lkt_auction_config`
ADD COLUMN `is_open`  tinyint(2) NULL DEFAULT 1 COMMENT '�Ƿ������ 0-������ 1-����' AFTER `store_id`;

ALTER TABLE `lkt_user_rule`
ADD COLUMN `is_jifen`  tinyint(2) NULL DEFAULT 0 COMMENT '��Ա�ȱ������� 0-������ 1-����' AFTER `is_product`,
ADD COLUMN `jifen_m`  tinyint(2) NULL DEFAULT 1 COMMENT '���ַ��͹��� 0-����� 1-�ջ���' AFTER `is_jifen`;

ALTER TABLE `lkt_sign_record`
MODIFY COLUMN `type`  int(4) NOT NULL DEFAULT 0 COMMENT '����: 0:ǩ�� 1:���� 2:�״ι�ע�û��� 3:ת���ָ����� 4:����ת���� 5:ϵͳ�۳� 6:ϵͳ��ֵ 7:�齱 8:��Ա�������' AFTER `sign_time`;

