ALTER TABLE `lkt_user`
ADD COLUMN `lock`  tinyint(2) NULL DEFAULT 0 COMMENT '是否冻结 0-不冻结 1-冻结' AFTER `parameter`;