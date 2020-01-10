ALTER TABLE `lkt_upload_set`
CHANGE COLUMN `store_id` `upserver`  tinyint(4) NOT NULL DEFAULT 2 COMMENT '上
传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云' AFTER `id`;