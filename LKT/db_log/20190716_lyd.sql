CREATE TABLE `lkt_user_grade` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(120) DEFAULT NULL COMMENT '�ȼ�����',
  `rate` decimal(12,2) DEFAULT NULL COMMENT '������',
  `money` decimal(12,2) DEFAULT NULL COMMENT '����',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='��Ա�ȼ���';
CREATE TABLE `lkt_user_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `rate_now` decimal(12,2) DEFAULT NULL COMMENT 'Ĭ������',
  `active` int(11) DEFAULT '1' COMMENT '֧�ֵĲ��ʹ�����ʣ�1--������Ʒ 2--֧��ƴ�� 3--֧�ֿ��� 4--֧�־���'' 5--���� 6--�Ż�ȯ',
  `rule` text COMMENT '��Ա�ȼ���������',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='��Ա�ȼ��ƶȹ����';
