ALTER TABLE `lkt_bargain_goods`
MODIFY COLUMN `sort`  int(11) NOT NULL DEFAULT 1 COMMENT '权重值，越大排序越靠前' AFTER `addtime`;

