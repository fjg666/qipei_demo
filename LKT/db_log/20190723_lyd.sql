ALTER TABLE `lkt_user_grade`
MODIFY COLUMN `money`  decimal(12,2) NULL DEFAULT NULL COMMENT '���½��' AFTER `rate`,
ADD COLUMN `money_j`  decimal(12,2) NULL DEFAULT NULL COMMENT '�������' AFTER `store_id`,
ADD COLUMN `money_n`  decimal(12,2) NULL DEFAULT NULL COMMENT '������' AFTER `money_j`,
ADD COLUMN `remark`  text NULL COMMENT '��ע' AFTER `money_n`;
