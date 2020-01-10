
ALTER TABLE `lkt_mch`
ADD COLUMN `shop_range`  text NULL COMMENT '经营范围' AFTER
`shop_information`;
ALTER TABLE `lkt_mch_config`
ADD COLUMN `logo`  varchar(255) NULL COMMENT '店铺默认logo' AFTER `store_id`;
ALTER TABLE `lkt_mch_browse`
ADD COLUMN `token`  varchar(255) NULL COMMENT 'token' AFTER `mch_id`;
ALTER TABLE `lkt_order`
MODIFY COLUMN `mch_id`  varchar(11) NULL DEFAULT '' COMMENT '店铺ID' AFTER
`offset_balance`;
ALTER TABLE `lkt_order_details`
MODIFY COLUMN `freight`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '运费' AFTER
`courier_num`;

ALTER TABLE `lkt_order_details`
MODIFY COLUMN `r_type`  tinyint(4) NULL DEFAULT 0 COMMENT '类型 0:审核中 1:同
意并让用户寄回 2:拒绝(退货退款) 3:用户已快递 4:收到寄回商品,同意并退款 5：拒绝
并退回商品 8:拒绝(退款) 9:同意并退款' AFTER `r_content`;