DROP TABLE IF EXISTS `lkt_seconds_time`;
CREATE TABLE `lkt_seconds_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `name` varchar(255) NOT NULL COMMENT '时段名称',
  `starttime` datetime NOT NULL COMMENT '开始时间',
  `endtime` datetime NOT NULL COMMENT '结束时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_activity`;
CREATE TABLE `lkt_seconds_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '活动名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '活动状态 1 未开始 2 进行中 3结束',
  `type` tinyint(1) NOT NULL COMMENT '活动类型',
  `starttime` datetime NOT NULL COMMENT '活动开始时间',
  `endtime` datetime NOT NULL COMMENT '活动结束时间',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 1 是 0 否',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 1 是 0 否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_config`;
CREATE TABLE `lkt_seconds_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启 1 是 0 否',
  `buy_num` int(11) NOT NULL COMMENT '秒杀商品默认限购数量',
  `imageurl` text NOT NULL COMMENT '轮播图',
  `remind` int(11) NOT NULL COMMENT '秒杀活动提醒 （单位：分钟）',
  `rule` text NOT NULL COMMENT '规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_pro`;
CREATE TABLE `lkt_seconds_pro` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `pro_id` int(11) NOT NULL COMMENT '商品id',
  `seconds_price` decimal(11,2) NOT NULL COMMENT '秒杀价格',
  `num` int(11) NOT NULL COMMENT '秒杀库存',
  `max_num` INT(11) NULL COMMENT '最大数量',
  `buy_num` int(11) NOT NULL COMMENT '限购数量',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `time_id` int(11) NOT NULL COMMENT '时段id',
  `add_time` DATETIME NOT NULL COMMENT '添加日期',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否删除 1 是 0 否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_record`;
CREATE TABLE `lkt_seconds_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `user_id` varchar(50) NOT NULL COMMENT '用户id',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `time_id` int(11) NOT NULL COMMENT '时段id',
  `pro_id` int(11) NOT NULL COMMENT '商品id',
  `price` decimal(11,2) NOT NULL COMMENT '价格',
  `num` int(11) NOT NULL COMMENT '数量',
  `sNo` VARCHAR(50) NOT NULL COMMENT '秒杀订单',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 1是 0否',
  `add_time` datetime NOT NULL COMMENT '添加日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='秒杀记录表';

DROP TABLE IF EXISTS `lkt_seconds_remind`;
CREATE TABLE `lkt_seconds_remind` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `user_id` varchar(20) NOT NULL COMMENT '用户user_id',
  `is_remind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经提醒 1是 0否',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `time_id` int(11) NOT NULL COMMENT '时段id',
  `pro_id` int(11) NOT NULL COMMENT '商品id',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;