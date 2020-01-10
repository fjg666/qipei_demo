ALTER TABLE `lkt_config`
ADD COLUMN `is_register`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否需要注册
1.注册 2.免注册' AFTER `store_id`;