CREATE TABLE `lkt_user_grade` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(120) DEFAULT NULL COMMENT '等级名称',
  `rate` decimal(12,2) DEFAULT NULL COMMENT '打折率',
  `money` decimal(12,2) DEFAULT NULL COMMENT '费用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='会员等级表';
CREATE TABLE `lkt_user_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `rate_now` decimal(12,2) DEFAULT NULL COMMENT '默认折率',
  `active` int(11) DEFAULT '1' COMMENT '支持的插件使用折率：1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍'' 5--满减 6--优惠券',
  `rule` text COMMENT '会员等级规则详情',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='会员等级制度规则表';
