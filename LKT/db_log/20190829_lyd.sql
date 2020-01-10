ALTER TABLE `lkt_user`
ADD COLUMN `tui_id`  char(50) NULL COMMENT '会员推荐人id' AFTER `grade`;

ALTER TABLE `lkt_sign_record`
ENGINE=InnoDB;