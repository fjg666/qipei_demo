CREATE TABLE `lkt_third` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `ticket` varchar(255) DEFAULT NULL COMMENT '��ȡtoken��ƾ֤',
  `ticket_time` timestamp NULL DEFAULT NULL COMMENT 'ƾ֤����ʱ��',
  `token` varchar(255) DEFAULT NULL COMMENT '��Ȩtoken',
  `token_expires` int(11) DEFAULT NULL COMMENT 'token����ʱ���',
  `appid` varchar(50) DEFAULT NULL COMMENT '������ƽ̨appid',
  `appsecret` varchar(100) DEFAULT NULL COMMENT '������ƽ̨��Կ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='��������Ȩ��';
CREATE TABLE `lkt_third_mini_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `mini_name` varchar(100) DEFAULT NULL COMMENT 'С��������',
  `authorizer_appid` varchar(100) DEFAULT NULL COMMENT '��ȨС����appid',
  `authorizer_access_token``` varchar(255) DEFAULT NULL COMMENT '��Ȩ���ӿڵ���ƾ�ݣ�����Ȩ�Ĺ��ںŻ�С����߱�APIȨ��ʱ�����д˷���ֵ����Ҳ���Ϊ����',
  `authorizer_expires` int(11) unsigned DEFAULT NULL COMMENT '��Ч�ڣ�����Ȩ�Ĺ��ںŻ�С����߱�APIȨ��ʱ�����д˷���ֵ��',
  `authorizer_refresh_token` varchar(255) DEFAULT NULL COMMENT '�ӿڵ���ƾ��ˢ������',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '����ʱ��',
  `func_info` varchar(255) DEFAULT NULL COMMENT '��Ȩ�������ߵ�Ȩ�޼��б�',
  `expires_time` int(11) DEFAULT NULL COMMENT '����ʱ���',
  `company_id` varchar(100) DEFAULT NULL COMMENT '��˾id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
