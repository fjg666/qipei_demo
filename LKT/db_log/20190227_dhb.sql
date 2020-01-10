ALTER TABLE `lkt_product_list`
ADD COLUMN `display_position`  int(2) NULL DEFAULT 1 COMMENT '显示位置 1:首页 2：购物车' AFTER `volume`,
ADD COLUMN `hxaddress`  varchar(255) NULL COMMENT '核销地址' AFTER `is_hexiao`;