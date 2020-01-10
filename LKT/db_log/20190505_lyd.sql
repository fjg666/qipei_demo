ALTER TABLE `lkt_auction_product`
ADD COLUMN `recycle`  tinyint(2) NULL DEFAULT 0 COMMENT '是否回收  0：不回收  1：回收' AFTER `mch_id`;