ALTER TABLE `lkt_user`
ADD COLUMN `is_box`  tinyint(2) NULL DEFAULT 1 COMMENT '是否同意续费弹框 0-不同意 1 同意' AFTER `is_out`;