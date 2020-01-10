ALTER TABLE `lkt_auction_product`
MODIFY COLUMN `starttime`  timestamp NULL DEFAULT NULL COMMENT '开始时间' AFTER `content`;