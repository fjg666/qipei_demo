ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `active`  char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 1 COMMENT '支持的插件使用折率：1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍  5--分销  6--秒杀' AFTER `rate_now`;
