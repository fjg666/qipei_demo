CREATE TABLE `lkt_auction_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `low_pepole` int(11) unsigned DEFAULT NULL COMMENT '最低开拍人数',
  `wait_time` int(11) unsigned DEFAULT NULL COMMENT '出价等待时间',
  `days` int(11) unsigned DEFAULT NULL COMMENT '保留天数',
  `desc` text COMMENT '竞拍规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='竞拍规则表';