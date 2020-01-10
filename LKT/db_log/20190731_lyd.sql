ALTER TABLE `lkt_user`
MODIFY COLUMN `birthday`  timestamp NULL COMMENT '出生日期' AFTER `mobile`;