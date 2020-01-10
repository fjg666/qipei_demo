ALTER TABLE `lkt_order`
MODIFY COLUMN `red_packet`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '������' AFTER `coupon_price`,
MODIFY COLUMN `allow`  int(8) NULL DEFAULT 0 COMMENT '����' AFTER `red_packet`,
MODIFY COLUMN `parameter`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '����' AFTER `allow`,
MODIFY COLUMN `source`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '��Դ 1.С���� 2.app' AFTER `parameter`,
MODIFY COLUMN `delivery_status`  int(1) NULL DEFAULT 0 COMMENT '���ѷ���' AFTER `source`,
MODIFY COLUMN `readd`  int(2) NOT NULL DEFAULT 0 COMMENT '�Ƿ��Ѷ���0��δ��  1 �Ѷ���' AFTER `delivery_status`,
MODIFY COLUMN `remind`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '����\r\n\r\n����ʱ����' AFTER `readd`,
MODIFY COLUMN `offset_balance`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '�ֿ����' AFTER `remind`,
MODIFY COLUMN `mch_id`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '����ID' AFTER `offset_balance`,
MODIFY COLUMN `zhekou`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '�����ۿ�' AFTER `mch_id`,
CHANGE COLUMN `grade_price` `grade_rate`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '��Ա�ȼ��ۿ�' AFTER `zhekou`;

