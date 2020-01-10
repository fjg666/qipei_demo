ALTER TABLE `lkt_mch_config`
ADD COLUMN `service_charge`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '手续费'
AFTER `settlement`,
ADD COLUMN `illustrate`  text NULL COMMENT '提现说明' AFTER `service_charge`;
ALTER TABLE `lkt_user_bank_card`
ADD COLUMN `mch_id`  int(11) NULL DEFAULT 0 COMMENT '店铺ID' AFTER
`is_default`;
ALTER TABLE `lkt_record`
ADD COLUMN `is_mch`  int(2) NULL DEFAULT 0 COMMENT '是否是店铺提现 0.不是店铺
提现 1.是店铺提现' AFTER `type`;
ALTER TABLE `lkt_mch_account_log`
ADD COLUMN `account_money`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '商户
余额' AFTER `price`;
ALTER TABLE `lkt_product_list`
MODIFY COLUMN `show_adr`  varchar(100) NOT NULL DEFAULT 1 COMMENT '展示位置:1.
首页 2.购物车' AFTER `search_num`;
ALTER TABLE `lkt_sign_record`
ADD COLUMN `recovery`  tinyint(2) NULL DEFAULT 0 COMMENT '是否删除 0.未删除 1.
删除' AFTER `type`;