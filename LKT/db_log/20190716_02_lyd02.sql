ALTER TABLE `lkt_user`
ADD COLUMN `grade`  int(11) NULL DEFAULT 0 COMMENT '会员级别 0--普通会员 1--白银  2--黄金  3--黑金' AFTER `last_time`;