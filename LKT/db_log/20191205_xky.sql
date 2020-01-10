CREATE TABLE `lkt_score_over` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `user_id` varchar(15) NOT NULL COMMENT '用户ID',
  `old_score` int(11) NOT NULL DEFAULT '0' COMMENT '原积分',
  `now_score` int(11) DEFAULT '0' COMMENT '现积分',
  `last_pay` int(11) DEFAULT '0' COMMENT '已计算花费积分',
  `count_time` timestamp NULL DEFAULT NULL COMMENT '上次过期时间',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '计算时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='积分过期记录表';