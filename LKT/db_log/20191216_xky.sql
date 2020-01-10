ALTER TABLE `lkt_payment_config`
MODIFY COLUMN `status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否显示 0否 1是' AFTER `pid`;

