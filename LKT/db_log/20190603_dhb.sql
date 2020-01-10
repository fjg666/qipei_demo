ALTER TABLE `lkt_stock`
ADD COLUMN `total_num` int(11) NOT NULL COMMENT '总库存' AFTER `attribute_id`;
ALTER TABLE `lkt_admin`
ADD COLUMN `portrait` varchar(255) NULL COMMENT '管理员头像' AFTER `status`;

-- 满减设置表
create table lkt_subtraction_config (
  id int(11) unsigned primary key auto_increment comment 'id',
  store_id int(11) not null default 0 comment '商城id',
  is_subtraction tinyint(3) NOT NULL DEFAULT '2' COMMENT '包邮状态 0.否 1.是',
  range_zfc text COMMENT '满减应用范围',
  pro_id text COMMENT '满赠商品',
  position_zfc text COMMENT '满减图片显示位置',
  is_shipping tinyint(3) NOT NULL DEFAULT '2' COMMENT '满减包邮设置 0.否 1.是',
  z_money decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '单笔满多少包邮',
  address_id text COMMENT '不参与包邮地区',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '满减设置表';