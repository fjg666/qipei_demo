
ALTER TABLE `lkt_user_rule`
ADD COLUMN `is_birthday`  tinyint(2) NULL DEFAULT 0 COMMENT '�Ƿ���������Ȩ 0-������ 1-����' AFTER `upgrade`,
ADD COLUMN `bir_multiple`  int(11) NULL DEFAULT 1 COMMENT '������Ȩ���ֱ���' AFTER `is_birthday`,
ADD COLUMN `is_product`  tinyint(2) NULL DEFAULT 0 COMMENT '�Ƿ�����Ա������Ʒ 0-������ 1-����' AFTER `bir_multiple`;