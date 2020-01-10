ALTER TABLE `lkt_order_config`
ADD COLUMN `remind`  int(11) NULL DEFAULT 1 COMMENT '提醒限制' AFTER
`order_ship`;
ALTER TABLE `lkt_order`
ADD COLUMN `remind`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '提醒
发货时间间隔' AFTER `readd`;
