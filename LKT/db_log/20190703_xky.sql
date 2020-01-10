ALTER TABLE `lkt_bargain_goods`
CHANGE COLUMN `is_delete` `status`  smallint(6) NOT NULL DEFAULT 0 COMMENT '状态0.未开始1.进行中2.已结束' AFTER `status_data`,
ADD COLUMN `is_delete`  smallint(6) NOT NULL DEFAULT 0 COMMENT '是否删除:0否   1是' AFTER `sort`;

