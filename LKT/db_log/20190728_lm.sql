ALTER TABLE `lkt_group_product`
ADD `activity_no` INT(11) NOT NULL COMMENT '活动编号' AFTER `endtime`,
ADD `group_title` VARCHAR(255) NOT NULL COMMENT '活动标题' AFTER `store_id`;