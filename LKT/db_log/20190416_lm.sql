ALTER TABLE `lkt_order` ADD `p_sNo` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '父级订单号' AFTER `zhekou`;
ALTER TABLE `lkt_bargain_order` ADD `achievetime` INT(11) NOT NULL DEFAULT '0' AFTER `status_data`;