ALTER TABLE `lkt_user_rule`
MODIFY COLUMN `active`  char(50) NULL DEFAULT 1 COMMENT '֧�ֵĲ��ʹ�����ʣ�1--������Ʒ 2--֧��ƴ�� 3--֧�ֿ��� 4--֧�־���\' 5--���� 6--�Ż�ȯ' AFTER `rate_now`;