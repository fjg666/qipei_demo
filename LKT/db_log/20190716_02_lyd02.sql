ALTER TABLE `lkt_user`
ADD COLUMN `grade`  int(11) NULL DEFAULT 0 COMMENT '��Ա���� 0--��ͨ��Ա 1--����  2--�ƽ�  3--�ڽ�' AFTER `last_time`;