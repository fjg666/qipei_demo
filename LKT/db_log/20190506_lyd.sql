CREATE TABLE `lkt_auction_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `low_pepole` int(11) unsigned DEFAULT NULL COMMENT '��Ϳ�������',
  `wait_time` int(11) unsigned DEFAULT NULL COMMENT '���۵ȴ�ʱ��',
  `days` int(11) unsigned DEFAULT NULL COMMENT '��������',
  `desc` text COMMENT '���Ĺ���',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='���Ĺ����';