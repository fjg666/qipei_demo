CREATE TABLE `lkt_third` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id' ,
`ticket`  varchar(255) NULL COMMENT '获取token的凭证' ,
`ticket_create_time`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '凭证添加时间' ,
PRIMARY KEY (`id`)
)
;