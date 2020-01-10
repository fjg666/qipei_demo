ALTER TABLE `lkt_config`
ADD COLUMN `H5_domain`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'H5域名' AFTER `app_domain_name`;

