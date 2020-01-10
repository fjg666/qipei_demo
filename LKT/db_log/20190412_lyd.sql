ALTER TABLE `lkt_auction_promise`
MODIFY COLUMN `type`  tinyint(2) NOT NULL COMMENT '支付方式 : 1-微信支付, 2-钱包支付, 3-支付宝支付' AFTER `store_id`;