CREATE TABLE `lkt_third` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '����id' ,
`ticket`  varchar(255) NULL COMMENT '��ȡtoken��ƾ֤' ,
`ticket_create_time`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'ƾ֤���ʱ��' ,
PRIMARY KEY (`id`)
)
;