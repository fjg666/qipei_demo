ALTER TABLE `lkt_third`
ADD COLUMN `redirect_url`  text NULL COMMENT '��Ȩ�ص���ַ' AFTER `work_domain`,
ADD COLUMN `mini_url`  text NULL COMMENT 'С����ӿڵ�ַ' AFTER `redirect_url`,
ADD COLUMN `kefu_url`  text NULL COMMENT '�ͷ��ӿ�url' AFTER `mini_url`,
ADD COLUMN `qr_code`  text NULL COMMENT '�����ά��url' AFTER `kefu_url`;