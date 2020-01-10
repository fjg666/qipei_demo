ALTER TABLE `lkt_group_open`
ADD `activity_no` INT(11) NOT NULL DEFAULT '0' COMMENT '拼团活动编号' AFTER `group_data`;

ALTER TABLE `lkt_order_config`
ADD `order_after` int(3) NOT NULL DEFAULT 7 COMMENT '售后时间期限' AFTER `order_failure`;