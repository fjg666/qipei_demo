ALTER TABLE `lkt_third`
ADD COLUMN `check_token`  varchar(255) NULL COMMENT '��Ϣ����Token��������ƽ̨����' AFTER `appsecret`,
ADD COLUMN `encrypt_key`  varchar(255) NULL COMMENT '��Ϣ�Ӽ���key' AFTER `check_token`;