ALTER TABLE `lkt_mch_account_log`
ADD COLUMN `integral`  int(12) NULL DEFAULT 0 COMMENT '积分' AFTER `mch_id`;

ALTER TABLE `lkt_mch`
ADD COLUMN `integral_money`  decimal(12,0) NULL DEFAULT 0 COMMENT '商户积分' AFTER `review_result`;

ALTER TABLE `lkt_mch_account_log`
ADD COLUMN `integral_money`  decimal(12,0) NULL DEFAULT 0 COMMENT '商户积分' AFTER `integral`;

