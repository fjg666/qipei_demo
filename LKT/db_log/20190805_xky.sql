ALTER TABLE `lkt_bargain_config`
ADD COLUMN `status`  int(5) NOT NULL DEFAULT 0 COMMENT '插件状态 0关闭 1开启' AFTER `updatetime`;

ALTER TABLE `lkt_integral_config`
ADD COLUMN `status`  int(5) NOT NULL DEFAULT 0 COMMENT '插件状态 0关闭 1开启' AFTER `content`;

ALTER TABLE `lkt_distribution_config`
ADD COLUMN `status`  int(5) NOT NULL DEFAULT 0 COMMENT '插件状态 0关闭 1开启' AFTER `sets`;

ALTER TABLE `lkt_bargain_config`
ADD COLUMN `store_id`  int(11) NOT NULL DEFAULT 1 COMMENT '商城id' AFTER `id`;

