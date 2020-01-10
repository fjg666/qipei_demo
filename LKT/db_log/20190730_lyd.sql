ALTER TABLE `lkt_order`
MODIFY COLUMN `red_packet`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '红包金额' AFTER `coupon_price`,
MODIFY COLUMN `allow`  int(8) NULL DEFAULT 0 COMMENT '积分' AFTER `red_packet`,
MODIFY COLUMN `parameter`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '参数' AFTER `allow`,
MODIFY COLUMN `source`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '来源 1.小程序 2.app' AFTER `parameter`,
MODIFY COLUMN `delivery_status`  int(1) NULL DEFAULT 0 COMMENT '提醒发货' AFTER `source`,
MODIFY COLUMN `readd`  int(2) NOT NULL DEFAULT 0 COMMENT '是否已读（0，未读  1 已读）' AFTER `delivery_status`,
MODIFY COLUMN `remind`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '提醒\r\n\r\n发货时间间隔' AFTER `readd`,
MODIFY COLUMN `offset_balance`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '抵扣余额' AFTER `remind`,
MODIFY COLUMN `mch_id`  varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '店铺ID' AFTER `offset_balance`,
MODIFY COLUMN `zhekou`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '分销折扣' AFTER `mch_id`,
CHANGE COLUMN `grade_price` `grade_rate`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '会员等级折扣' AFTER `zhekou`;

