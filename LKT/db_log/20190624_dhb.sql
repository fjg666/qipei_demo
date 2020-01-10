-- 满减表
create table lkt_subtraction (
  id int(11) unsigned primary key auto_increment comment 'id',
  store_id int(11) not null default 0 comment '商城id',
  mch_id int(11) not null default 0 comment '店主id',
  title varchar(255) NOT NULL COMMENT '活动标题',
  name varchar(255) NOT NULL COMMENT '活动名称',
  subtraction_range varchar(255) NOT NULL COMMENT '满减应用范围 ',
  subtraction_parameter text COMMENT '满减范围参数',
  subtraction_type tinyint(4) NOT NULL DEFAULT '0' COMMENT '满减类型 1.阶梯满减 2.循环满减 3.满赠 4.满件折扣',
  subtraction text COMMENT '满减',
  starttime timestamp NULL DEFAULT NULL COMMENT '活动开始时间',
  endtime timestamp NULL DEFAULT NULL COMMENT '活动结束时间',
  position_zfc varchar(255) NOT NULL COMMENT '满减图片显示位置',
  image varchar(255) NOT NULL COMMENT '满减图片',
  status tinyint(3) NOT NULL DEFAULT '1' COMMENT '活动状态 1.未开始 2.开启 3.关闭 4.已结束',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '满减表';

-- 满减设置表
create table lkt_subtraction_config (
  id int(11) unsigned primary key auto_increment comment 'id',
  store_id int(11) not null default 0 comment '商城id',
  is_subtraction tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否开启满减 0.否 1.是',
  range_zfc text COMMENT '满减应用范围',
  pro_id text COMMENT '满赠商品',
  position_zfc text COMMENT '满减图片显示位置',
  is_shipping tinyint(3) NOT NULL DEFAULT '0' COMMENT '满减包邮设置 0.否 1.是',
  z_money decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '单笔满多少包邮',
  address_id text COMMENT '不参与包邮地区',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '满减设置表';

-- 满减记录表
create table lkt_subtraction_record (
  id int(11) unsigned primary key auto_increment comment 'ID',
  h_id int(11) not null default 0 comment '满减活动ID',
  sNo varchar(255) DEFAULT NULL COMMENT '订单号',
  user_id char(15) NOT NULL COMMENT '用户id',
  content text COMMENT '活动内容',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '满减记录表';
