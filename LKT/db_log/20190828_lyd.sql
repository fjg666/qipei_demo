ALTER TABLE `lkt_user`
ADD COLUMN `lock_score`  int(11) UNSIGNED NULL DEFAULT 0 COMMENT '冻结的积分' AFTER `score`;
ALTER TABLE `lkt_sign_record`
ADD COLUMN `sNo`  char(100) NULL DEFAULT NULL COMMENT '订单编号' AFTER `recovery`;