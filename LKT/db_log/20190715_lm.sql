ALTER TABLE `lkt_order_details` ADD `re_apply_money` FLOAT(12,2) NULL COMMENT '用户申请退款金额' AFTER `re_type`;
ALTER TABLE `lkt_group_product` ADD `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否删除' AFTER `is_show`;
ALTER TABLE `lkt_group_open` ADD `group_title` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '拼团标题' AFTER `ptstatus`;
ALTER TABLE `lkt_group_open` ADD `group_data` TEXT NOT NULL DEFAULT '' COMMENT '拼团数据' AFTER `group_level`;