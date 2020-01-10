ALTER TABLE `lkt_user`
ADD COLUMN `is_out`  tinyint(2) NULL DEFAULT 0 COMMENT '是否到期 0-未到期  1-已到期' AFTER `grade_end`;