DROP TABLE IF EXISTS `lkt_return_record`;
CREATE TABLE `lkt_return_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `user_id` varchar(20) NOT NULL COMMENT '用户userid',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `re_type` tinyint(1) NOT NULL COMMENT '售后类型：1退货退款 2仅退款 3换货',
  `r_type` int(3) NOT NULL COMMENT '售后状态',
  `content` text COMMENT '拒绝原因',
  `sNo` varchar(50) NOT NULL COMMENT '售后订单号',
  `money` decimal(10,2) NOT NULL COMMENT '售后金额',
  `real_money` decimal(10,2) DEFAULT NULL COMMENT '实际退款金额',
  `re_photo` varchar(255) NOT NULL DEFAULT '' COMMENT '上传凭证',
  `product_id` int(5) NOT NULL COMMENT '商品id',
  `attr_id` int(11) NOT NULL COMMENT '属性id',
  `express_id` int(11) DEFAULT NULL COMMENT '快递公司id',
  `courier_num` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号',
  `re_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加日期',
  `explain` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `p_id` int(11) NOT NULL COMMENT '上级详情订单id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='售后记录表';
