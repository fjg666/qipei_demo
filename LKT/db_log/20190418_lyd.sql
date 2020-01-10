ALTER TABLE `lkt_user`
ADD COLUMN `lase_time`  timestamp NULL COMMENT '最后一次登录时间' AFTER `is_lock`;