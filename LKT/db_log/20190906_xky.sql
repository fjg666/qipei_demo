CREATE TABLE `lkt_printing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `r_userid` varchar(200) DEFAULT NULL COMMENT '收货人userid',
  `s_id` varchar(200) DEFAULT NULL COMMENT '发货id',
  `sNo` varchar(255) DEFAULT NULL COMMENT '订单号',
  `d_sNo` varchar(255) DEFAULT NULL COMMENT '详情订单id',
  `title` varchar(255) DEFAULT NULL COMMENT '商品详情',
  `num` int(11) DEFAULT NULL COMMENT '商品总数',
  `weight` decimal(10,2) DEFAULT NULL COMMENT '总重',
  `sender` varchar(200) DEFAULT NULL COMMENT '寄件人',
  `s_mobile` varchar(32) DEFAULT NULL COMMENT '寄件人手机',
  `s_sheng` text,
  `s_shi` text,
  `s_xian` text,
  `s_address` text COMMENT '寄件人地址',
  `recipient` varchar(200) DEFAULT NULL COMMENT '收件人',
  `r_mobile` varchar(32) DEFAULT NULL COMMENT '收件人手机',
  `r_sheng` text,
  `r_shi` text,
  `r_xian` text,
  `r_address` text COMMENT '收件人地址',
  `status` int(5) DEFAULT '0' COMMENT '打印状态 0.未 1.已',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `print_time` timestamp NULL DEFAULT NULL COMMENT '打印时间',
  `type` int(4) DEFAULT '1' COMMENT '打印类型 1.发货单 2.快递单',
  `remark` text COMMENT '备注',
  `express` varchar(255) DEFAULT NULL COMMENT '快递名称',
  `expresssn` varchar(40) DEFAULT NULL COMMENT '快递单号',
  `put_type` int(4) DEFAULT '0' COMMENT '平台代发 0.关 1.开',
  `mini_sno` varchar(200) DEFAULT NULL COMMENT '小订单号 用于区分同一个订单不同快递',
  `origincode` char(50) DEFAULT NULL COMMENT '原寄地区域代码,可用于顺丰电子面单标签打印',
  `destcode` char(50) DEFAULT NULL COMMENT '目的地区域代码,可用于顺丰电子面单标签打印',
  `isopen` int(10) DEFAULT '0' COMMENT '平台代发  0.关  1.开',
  `img_url` text COMMENT '快递单地址',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `sNo` (`sNo`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='打印记录表';

CREATE TABLE `lkt_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '示例图',
  `type` tinyint(4) DEFAULT '1' COMMENT '单据类型 1.发货单 2.快递单',
  `name` varchar(100) NOT NULL COMMENT '模版名称',
  `e_name` varchar(100) DEFAULT NULL COMMENT 'tpl文件名称',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `width` int(10) DEFAULT NULL,
  `height` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='单据模版表';

CREATE TABLE `lkt_mch_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `mch_id` int(20) NOT NULL DEFAULT '1' COMMENT '商户id',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '示例图',
  `type` tinyint(4) DEFAULT '1' COMMENT '单据类型 1.发货单 2.快递单',
  `name` varchar(100) NOT NULL COMMENT '模版名称',
  `e_name` varchar(100) DEFAULT NULL COMMENT 'tpl文件名称',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `width` int(10) DEFAULT NULL,
  `height` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='商户单据模版表';






