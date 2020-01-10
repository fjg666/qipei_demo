ALTER TABLE `lkt_user_rule`
ADD COLUMN `back`  tinyint(2) NULL COMMENT '是否开启返现 0-不开启 1-开启' AFTER `jifen_m`,
ADD COLUMN `back_scale`  decimal(12,2) NULL DEFAULT NULL COMMENT '返现比例' AFTER `back`,
ADD COLUMN `poster`  char(50) NULL DEFAULT NULL COMMENT '会员分享海报' AFTER `back_scale`,
ADD COLUMN `is_limit`  tinyint(2) NULL DEFAULT 0 COMMENT '是否开启推荐限制 0-不限制  1-限制' AFTER `poster`,
ADD COLUMN `level`  int(11) NULL DEFAULT NULL COMMENT '可以推荐的会员级别' AFTER `is_limit`,
ADD COLUMN `distribute_l`  int(11) NULL DEFAULT 0 COMMENT '可以参与分销的会员级别id' AFTER `level`,
ADD COLUMN `valid`  int(11) NULL DEFAULT 7 COMMENT '增送商品的有效天数' AFTER `distribute_l`;

ALTER TABLE `lkt_user_grade`
ADD COLUMN `font_color`  char(50) NULL DEFAULT NULL COMMENT '会员昵称字体颜色' AFTER `pro_id`,
ADD COLUMN `date_color`  char(50) NULL DEFAULT NULL COMMENT '标识文字颜色' AFTER `font_color`;

ALTER TABLE `lkt_user_first`
ADD COLUMN `sNo`  char(50) NULL DEFAULT NULL COMMENT '订单编号' AFTER `is_use`,
ADD COLUMN `end_time`  datetime NULL DEFAULT NULL COMMENT '兑换券失效时间' AFTER `sNo`,
ADD COLUMN `attr_id`  int(11) NULL DEFAULT NULL COMMENT '兑换商品的规格id' AFTER `end_time`;