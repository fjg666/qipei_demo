ALTER TABLE `lkt_user_first`
ADD COLUMN `is_use`  tinyint(2) NULL DEFAULT 0 COMMENT '是否使用了首次开通赠送商品券 0-未使用 1-已使用' AFTER `store_id`;