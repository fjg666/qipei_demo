ALTER TABLE `lkt_order`
CHANGE `sheng` `sheng` VARCHAR(100) NULL DEFAULT NULL COMMENT '省',
CHANGE `shi` `shi` VARCHAR(100) NULL DEFAULT NULL COMMENT '市',
CHANGE `xian` `xian` VARCHAR(100) NULL DEFAULT NULL COMMENT '县',
CHANGE  `consumer_money`  `consumer_money` VARCHAR( 20 ) NULL DEFAULT  '0' COMMENT  '消费金';