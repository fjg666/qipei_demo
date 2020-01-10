ALTER TABLE `lkt_user`
ADD COLUMN `grade_m`  tinyint NULL COMMENT '开通方式 1-包月 2-包季 3-包年' AFTER `grade_add`;

