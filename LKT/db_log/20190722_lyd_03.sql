ALTER TABLE `lkt_user`
ADD COLUMN `is_out`  tinyint(2) NULL DEFAULT 0 COMMENT '�Ƿ��� 0-δ����  1-�ѵ���' AFTER `grade_end`;