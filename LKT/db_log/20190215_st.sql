ALTER TABLE `lkt_home_nav`
ADD COLUMN `uniquely`  varchar(255) NOT NULL COMMENT '标识' AFTER `name`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id`, `uniquely`);


ALTER TABLE `lkt_home_nav`
MODIFY COLUMN `store_id`  int(11) NULL COMMENT '商城id' AFTER `id`,
MODIFY COLUMN `store_type`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '软件类型' AFTER `store_id`;