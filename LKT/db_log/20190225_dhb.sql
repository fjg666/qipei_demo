ALTER TABLE `lkt_coupon_activity`
ADD COLUMN `qualifications`  text NULL COMMENT '资格' AFTER `add_time`;

ALTER TABLE `lkt_config`
ADD COLUMN `logo1`  varchar(100) NULL COMMENT '首页logo' AFTER `logo`;