ALTER TABLE `lkt_user`
ADD COLUMN `is_box`  tinyint(2) NULL DEFAULT 1 COMMENT '�Ƿ�ͬ�����ѵ��� 0-��ͬ�� 1 ͬ��' AFTER `is_out`;