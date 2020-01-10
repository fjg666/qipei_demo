ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `method`  char(50) NULL DEFAULT NULL COMMENT '开通方式 1-包月 2-包季 3-包年' AFTER `auto_time`;