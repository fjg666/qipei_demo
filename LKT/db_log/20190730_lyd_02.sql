CREATE TABLE `lkt_user_first` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����id',
  `user_id` char(50) DEFAULT NULL COMMENT '�û�id',
  `grade_id` int(11) DEFAULT NULL COMMENT '��Ա�ȼ�id',
  `level` int(11) DEFAULT NULL COMMENT '�״ο�ͨ��Ա����',
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT='�ȼ���Ա�״ο�ͨ��' ROW_FORMAT = Fixed;