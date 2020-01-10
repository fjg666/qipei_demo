ALTER TABLE `lkt_config`
ADD COLUMN `app_domain_name`  varchar(255) NOT NULL COMMENT 'APP域名' AFTER
`domain`;
ALTER TABLE `lkt_sign_config`
ADD COLUMN `Instructions`  text NULL COMMENT '积分使用说明' AFTER `detail`;

ALTER TABLE `lkt_mch_config`
ADD COLUMN `min_charge`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '最低提现金额
' AFTER `settlement`,
ADD COLUMN `max_charge`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '最大提现金额
' AFTER `min_charge`;
ALTER TABLE `lkt_mch`
ADD COLUMN `business_hours`  varchar(255) NULL COMMENT '营业时间' AFTER
`confines`;