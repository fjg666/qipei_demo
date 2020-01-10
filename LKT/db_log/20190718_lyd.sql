ALTER TABLE `lkt_user`
MODIFY COLUMN `grade`  int(11) NULL DEFAULT 0 COMMENT '会员级别 0--普通会员 ' AFTER `last_time`;

