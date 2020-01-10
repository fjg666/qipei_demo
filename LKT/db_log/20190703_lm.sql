ALTER TABLE `lkt_group_config`
ADD `group_time` INT(11) NOT NULL COMMENT '拼团时限' AFTER `refunmoney`,
ADD `open_num` INT(11) NOT NULL COMMENT '开团数量' AFTER `group_time`,
ADD `can_num` INT(11) NOT NULL COMMENT '参团数量' AFTER `open_num`,
ADD `can_again` TINYINT(1) NOT NULL COMMENT '是否可重复参团1 是 0 否' AFTER `can_num`,
ADD `open_discount` TINYINT(1) NOT NULL COMMENT '是否开启团长优惠 1 是 0 否' AFTER `can_again`,
ADD `image` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '轮播图' AFTER `open_discount`,
ADD `rule` TEXT NOT NULL DEFAULT '' COMMENT '规则' AFTER `image`;

ALTER TABLE  `lkt_group_product` ADD  `group_title` VARCHAR( 255 ) NOT NULL DEFAULT  '' COMMENT  '拼团活动标题' AFTER  `id`