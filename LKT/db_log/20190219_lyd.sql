ALTER TABLE `lkt_user`
ADD COLUMN `lock`  tinyint(2) NULL DEFAULT 0 COMMENT '�Ƿ񶳽� 0-������ 1-����' AFTER `parameter`;