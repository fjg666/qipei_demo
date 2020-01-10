ALTER TABLE `lkt_sign_config`
MODIFY COLUMN `reset` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '00:00' COMMENT '间隔时间' AFTER `is_remind`,
ADD COLUMN `is_many_time` tinyint(4) DEFAULT 0 COMMENT '是否允许多次 0:不允许  1:允许' AFTER `modify_date`;
ALTER TABLE `lkt_sign_config`
MODIFY COLUMN `reset` int(11) NOT NULL DEFAULT '00:00' COMMENT '间隔时间' AFTER `is_remind`;