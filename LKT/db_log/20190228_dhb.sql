ALTER TABLE `lkt_product_list`
MODIFY COLUMN `mch_status`  tinyint(2) NULL DEFAULT 1 COMMENT '审核状态：1.待
审核，2.审核通过，3.审核不通过，4.暂不审核' AFTER `mch_id`;
ALTER TABLE `lkt_product_list`
ADD COLUMN `refuse_reasons`  varchar(255) NULL COMMENT '拒绝原因' AFTER `mch_status`;
ALTER TABLE `lkt_mch`
ADD COLUMN `collection_num`  int(11) NULL DEFAULT 0 COMMENT '收藏数量' AFTER
`account_money`;