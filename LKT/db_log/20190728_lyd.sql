ALTER TABLE `lkt_user_grade`
MODIFY COLUMN `imgurl`  char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '��Ա��ֵ����ͼ' AFTER `remark`,
MODIFY COLUMN `imgurl_s`  char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '�ȼ����ı���ͼ' AFTER `imgurl`,
ADD COLUMN `level`  int(11) NULL DEFAULT NULL COMMENT '��Ա���� ��ͨ-0   ����-1  �ƽ�-2  �ڽ�-3' AFTER `imgurl_s`;

