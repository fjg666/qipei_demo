ALTER TABLE `lkt_order_details`
MODIFY COLUMN `r_type`  tinyint(4) NULL DEFAULT 100 COMMENT '���� 100:�����˻��˿�״̬0:����� 1:ͬ\r\n�Ⲣ���û��Ļ� 2:�ܾ�(�˻��˿�) 3:�û��ѿ�� 4:�յ��Ļ���Ʒ,ͬ�Ⲣ�˿� 5���ܾ�\r\n���˻���Ʒ 8:�ܾ�(�˿�) 9:ͬ�Ⲣ�˿�' AFTER `r_content`;