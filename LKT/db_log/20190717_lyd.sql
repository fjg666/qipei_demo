ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `active`  char(50) NULL DEFAULT 1 COMMENT '支持的插件使用折率：1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍\' 5--满减 6--优惠券' AFTER `rate_now`;