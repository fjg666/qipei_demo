
ALTER TABLE `lkt_user_rule`
ADD COLUMN `is_birthday`  tinyint(2) NULL DEFAULT 0 COMMENT '是否开启生日特权 0-不开启 1-开启' AFTER `upgrade`,
ADD COLUMN `bir_multiple`  int(11) NULL DEFAULT 1 COMMENT '生日特权积分倍数' AFTER `is_birthday`,
ADD COLUMN `is_product`  tinyint(2) NULL DEFAULT 0 COMMENT '是否开启会员赠送商品 0-不开启 1-开启' AFTER `bir_multiple`;