ALTER TABLE `lkt_user_grade`
MODIFY COLUMN `money`  decimal(12,2) NULL DEFAULT NULL COMMENT '包月金额' AFTER `rate`,
ADD COLUMN `money_j`  decimal(12,2) NULL DEFAULT NULL COMMENT '包季金额' AFTER `store_id`,
ADD COLUMN `money_n`  decimal(12,2) NULL DEFAULT NULL COMMENT '包年金额' AFTER `money_j`,
ADD COLUMN `remark`  text NULL COMMENT '备注' AFTER `money_n`;
