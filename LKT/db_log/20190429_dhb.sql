ALTER TABLE `lkt_coupon_activity`
ADD COLUMN `url`  varchar(255) NULL COMMENT '跳转路径' AFTER `content`;
ALTER TABLE `lkt_coupon_activity`
ADD COLUMN `skip_type`  tinyint(4) NULL DEFAULT 1 COMMENT '跳转方式 1.首页 2.
自定义' AFTER `content`;
ALTER TABLE `lkt_subtraction`
MODIFY COLUMN `status`  tinyint(3) NOT NULL DEFAULT 2 COMMENT '活动状态 1.开启
2.关闭 3.未开始 4.已结束' AFTER `goods`;