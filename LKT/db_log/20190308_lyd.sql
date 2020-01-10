CREATE TABLE `lkt_third_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `template_id` varchar(50) DEFAULT NULL COMMENT '微信端模板id',
  `wx_desc` varchar(100) DEFAULT NULL COMMENT 'wx模板描述',
  `wx_version` varchar(100) DEFAULT NULL COMMENT 'wx模板版本号',
  `wx_create_time` int(11) DEFAULT NULL COMMENT '添加进开放平台模板库时间戳',
  `lk_version` varchar(255) DEFAULT NULL COMMENT '后台定义的模板编号',
  `lk_desc` text COMMENT '后台模板描述',
  `img_url` varchar(150) DEFAULT NULL COMMENT '模板图片路劲',
  `store_id` int(11) DEFAULT NULL COMMENT '商城id',
  `trade` int(11) unsigned DEFAULT NULL COMMENT '行业',
  `is_use` tinyint(2) DEFAULT '1' COMMENT '是否应用 0：不应用 1：应用',
  `update_time` datetime DEFAULT NULL COMMENT '模板更新时间',
  `title` varchar(255) DEFAULT NULL COMMENT '模板名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='小程序模板表';