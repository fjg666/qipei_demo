ALTER TABLE `lkt_third`
CHANGE COLUMN `ticket_create_time` `ticket_time`  timestamp NULL DEFAULT NULL COMMENT '凭证更新时间' AFTER `ticket`,
ADD COLUMN `token`  varchar(255) NULL COMMENT '授权token' AFTER `ticket_time`,
ADD COLUMN `token_time`  timestamp NULL COMMENT 'token更新时间' AFTER `token`,
ADD COLUMN `appid`  varchar(50) NULL COMMENT '第三方平台appid' AFTER `token_time`,
ADD COLUMN `appsecret`  varchar(100) NULL COMMENT '第三方平台秘钥' AFTER `appid`;