ALTER TABLE `lkt_third`
CHANGE COLUMN `ticket_create_time` `ticket_time`  timestamp NULL DEFAULT NULL COMMENT 'ƾ֤����ʱ��' AFTER `ticket`,
ADD COLUMN `token`  varchar(255) NULL COMMENT '��Ȩtoken' AFTER `ticket_time`,
ADD COLUMN `token_time`  timestamp NULL COMMENT 'token����ʱ��' AFTER `token`,
ADD COLUMN `appid`  varchar(50) NULL COMMENT '������ƽ̨appid' AFTER `token_time`,
ADD COLUMN `appsecret`  varchar(100) NULL COMMENT '������ƽ̨��Կ' AFTER `appid`;