ALTER TABLE `lkt_user_grade`
MODIFY COLUMN `imgurl`  char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员充值背景图' AFTER `remark`,
MODIFY COLUMN `imgurl_s`  char(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '等级中心背景图' AFTER `imgurl`,
ADD COLUMN `level`  int(11) NULL DEFAULT NULL COMMENT '会员级别 普通-0   白银-1  黄金-2  黑金-3' AFTER `imgurl_s`;

