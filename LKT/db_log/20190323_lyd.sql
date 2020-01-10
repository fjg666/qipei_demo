ALTER TABLE `lkt_notice`
ADD COLUMN `update_time`  datetime NULL COMMENT '更新时间' AFTER `receive`;