ALTER TABLE `lkt_group_product`
ADD `is_copy` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否为复制 1为复制 0不是复制' AFTER `is_delete`;