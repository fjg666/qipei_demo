ALTER TABLE `lkt_third`
ADD COLUMN `check_token`  varchar(255) NULL COMMENT '消息检验Token，第三方平台设置' AFTER `appsecret`,
ADD COLUMN `encrypt_key`  varchar(255) NULL COMMENT '消息加减密key' AFTER `check_token`;