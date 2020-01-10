ALTER TABLE `lkt_product_list`
MODIFY COLUMN `status`  tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态 1:待上架 2:上架 3:下架 
' AFTER `min_inventory`;

ALTER TABLE `lkt_coupon_activity`
MODIFY COLUMN `activity_type`  varchar(250) NULL DEFAULT '' COMMENT '优惠券类型' AFTER 
`name`;
ALTER TABLE `lkt_coupon`
ADD COLUMN `recycle`  tinyint(4) NULL DEFAULT 0 COMMENT '回收站 0.不回收 1.回收' AFTER 
`status`;

-- 优惠券设置表
create table lkt_coupon_config (
  id int(11) unsigned primary key auto_increment comment 'id',
  store_id int(11) not null default 0 comment '商城id',
  is_status tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0：未启用 1：启用',
  payment_type tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付设置 0：只使用优惠券 1：可与其他优惠一起使用',
  limit_type tinyint(4) NOT NULL DEFAULT '0' COMMENT '限领设置 0：单张 1：多张',
  coupon_type text COMMENT '优惠券类型',
  modify_date timestamp NULL DEFAULT NULL COMMENT '修改时间'
) engine='myisam' charset='utf8' comment '优惠券设置表';
