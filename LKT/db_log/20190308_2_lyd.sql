ALTER TABLE `lkt_third_mini_info`
ADD COLUMN `review_mark`  tinyint(2) NULL DEFAULT 1 COMMENT '���״̬ 1��δ��� 2������� 3�����ʧ�� 4����˳ɹ�' AFTER `auditid`,
ADD COLUMN `issue_mark`  tinyint(2) NULL DEFAULT 1 COMMENT '����״̬ 1��δ����  2������ʧ�� 3�������ɹ�' AFTER `review_mark`;