ALTER TABLE `lkt_auction_product`
ADD COLUMN `s_type`  varchar(50) NULL COMMENT '竞拍商品标签类型，根据数据字典' AFTER `recycle`,
ADD COLUMN `is_show`  tinyint(2) NULL DEFAULT 1 COMMENT '是否显示 0 不显示  ， 1 显示' AFTER `s_type`;