ALTER TABLE `lkt_product_list`
MODIFY COLUMN `active`  char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1' COMMENT '支持活动:1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍 5--会员特惠' AFTER `hxaddress`;

