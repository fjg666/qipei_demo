
ALTER TABLE `lkt_mch`
ADD COLUMN `confines`  varchar(255) NULL COMMENT '店铺经营范围' AFTER
`is_lock`;
ALTER TABLE `lkt_product_list`
ADD COLUMN `publisher`  varchar(255) NULL COMMENT '发布人' AFTER `show_adr`;
ALTER TABLE `lkt_coupon_activity`
MODIFY COLUMN `money`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '优惠券面值'
AFTER `activity_type`,
MODIFY COLUMN `z_money`  decimal(12,2) NULL DEFAULT 0 COMMENT '消费满多少'
AFTER `money`,
MODIFY COLUMN `shopping`  int(11) NOT NULL DEFAULT 0.00 COMMENT '满多少赠券'
AFTER `z_money`,
ADD COLUMN `discount`  decimal(12,2) NULL DEFAULT 0.00 COMMENT '折扣值' AFTER
`money`;
ALTER TABLE `lkt_coupon_activity`
MODIFY COLUMN `activity_type`  int(11) NULL DEFAULT 0 COMMENT '优惠券类型 1:满
减券 2:折扣券' AFTER `name`;

ALTER TABLE `lkt_cart`
ADD COLUMN `token`  varchar(255) NULL COMMENT 'token' AFTER `store_id`;

create table lkt_product_number (
  id int(11) unsigned primary key auto_increment comment 'id',
  store_id int(11) not null default 0 comment '商城id',
  mch_id char(15) DEFAULT NULL COMMENT '店铺id',
  operation varchar(150) DEFAULT NULL COMMENT '操作人账号',
  product_number varchar(100) not null comment '商品编号',
  status tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态：1.使用 2.撤销',
  addtime timestamp NULL DEFAULT NULL COMMENT '时间'
) engine='myisam' charset='utf8' comment '商品编号表';