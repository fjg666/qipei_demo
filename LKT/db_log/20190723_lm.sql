ALTER TABLE `lkt_group_product`
ADD `starttime` TIMESTAMP NULL COMMENT '开始日期' AFTER `group_data`,
ADD `endtime` TIMESTAMP NULL COMMENT '结束日期' AFTER `starttime`;