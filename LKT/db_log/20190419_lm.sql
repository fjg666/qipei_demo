ALTER TABLE `lkt_bargain_order` ADD `bargain_id` INT(11) NOT NULL COMMENT '砍价活动id' AFTER `status_data`;
ALTER TABLE `lkt_bargain_goods` ADD `status` INT(11) NOT NULL DEFAULT '0' COMMENT '状态：0 - 正常 1 - 未开始 2 - 已结束' AFTER `status_data`;