CREATE TABLE `lkt_third_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `template_id` varchar(50) DEFAULT NULL COMMENT '΢�Ŷ�ģ��id',
  `wx_desc` varchar(100) DEFAULT NULL COMMENT 'wxģ������',
  `wx_version` varchar(100) DEFAULT NULL COMMENT 'wxģ��汾��',
  `wx_create_time` int(11) DEFAULT NULL COMMENT '��ӽ�����ƽ̨ģ���ʱ���',
  `lk_version` varchar(255) DEFAULT NULL COMMENT '��̨�����ģ����',
  `lk_desc` text COMMENT '��̨ģ������',
  `img_url` varchar(150) DEFAULT NULL COMMENT 'ģ��ͼƬ·��',
  `store_id` int(11) DEFAULT NULL COMMENT '�̳�id',
  `trade` int(11) unsigned DEFAULT NULL COMMENT '��ҵ',
  `is_use` tinyint(2) DEFAULT '1' COMMENT '�Ƿ�Ӧ�� 0����Ӧ�� 1��Ӧ��',
  `update_time` datetime DEFAULT NULL COMMENT 'ģ�����ʱ��',
  `title` varchar(255) DEFAULT NULL COMMENT 'ģ������',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='С����ģ���';