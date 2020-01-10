ALTER TABLE `lkt_seconds_pro`
ADD `is_show` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '是否显示 1显示 0不显示' AFTER `add_time`;