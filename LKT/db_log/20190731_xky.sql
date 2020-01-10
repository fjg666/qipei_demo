ALTER TABLE `lkt_product_list`
MODIFY COLUMN `active`  char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1' COMMENT '支持活动:1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍 7--支持积分商城' AFTER `hxaddress`;

CREATE TABLE `lkt_integral_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `attr_id` int(11) NOT NULL COMMENT '属性id',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '兑换所需积分',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '兑换所需余额',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `is_delete` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否删除:0否   1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分商城商品表';

-- ----------------------------
-- Table structure for `lkt_integral_config`
-- ----------------------------
DROP TABLE IF EXISTS `lkt_integral_config`;
CREATE TABLE `lkt_integral_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `bg_img` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='积分商城设置表';

-- ----------------------------
-- Table structure for `lkt_integral_class`
-- ----------------------------
DROP TABLE IF EXISTS `lkt_integral_class`;
CREATE TABLE `lkt_integral_class` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `sid` int(11) NOT NULL COMMENT '上级id',
  `pname` char(15) NOT NULL COMMENT '分类名称',
  `img` varchar(200) DEFAULT '' COMMENT '分类图片',
  `bg` varchar(255) DEFAULT NULL COMMENT '小图标',
  `level` int(11) NOT NULL COMMENT '级别',
  `sort` int(11) DEFAULT '100' COMMENT '排序',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `recycle` tinyint(4) DEFAULT '0' COMMENT '回收站 0.不回收 1.回收',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=312 DEFAULT CHARSET=utf8 COMMENT='积分商城分类';