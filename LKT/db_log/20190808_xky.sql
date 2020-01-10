CREATE TABLE `lkt_taobao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `link` text NOT NULL COMMENT '淘宝链接',
  `itemid` char(100) DEFAULT NULL COMMENT '商品ID',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态：0.待获取 1.获取中 2.获取成功 -1.获取失败',
  `msg` varchar(255) DEFAULT NULL COMMENT '返回说明',
  `creattime` timestamp NULL DEFAULT NULL COMMENT '任务创建时间',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '执行时间',
  `cid` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='淘宝任务列表';

