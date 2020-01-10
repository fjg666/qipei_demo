ALTER TABLE `lkt_coupon`
MODIFY COLUMN `type`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0:未使用 1:使用中 2:已使
用 3:已过期' AFTER `hid`,
ADD COLUMN `status`  tinyint(4) NULL DEFAULT 0 COMMENT '状态 0.开启 1.禁用' AFTER `type`;