ALTER TABLE `lkt_auction_promise`
MODIFY COLUMN `type`  tinyint(2) NOT NULL COMMENT '֧����ʽ : 1-΢��֧��, 2-Ǯ��֧��, 3-֧����֧��' AFTER `store_id`;