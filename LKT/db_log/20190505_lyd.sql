ALTER TABLE `lkt_auction_product`
ADD COLUMN `recycle`  tinyint(2) NULL DEFAULT 0 COMMENT '�Ƿ����  0��������  1������' AFTER `mch_id`;