ALTER TABLE `lkt_user`
ADD COLUMN `grade_add`  timestamp NULL DEFAULT NULL COMMENT '��ֵ��Ա�ȼ�ʱ��' AFTER `grade`,
ADD COLUMN `grade_end`  timestamp NULL DEFAULT NULL COMMENT '��Ա�ȼ�����ʱ��' AFTER `grade_add`;