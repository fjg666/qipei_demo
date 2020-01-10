CREATE TABLE `lkt_user_first` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` char(50) DEFAULT NULL COMMENT '用户id',
  `grade_id` int(11) DEFAULT NULL COMMENT '会员等级id',
  `level` int(11) DEFAULT NULL COMMENT '首次开通会员级别',
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT='等级会员首次开通表' ROW_FORMAT = Fixed;