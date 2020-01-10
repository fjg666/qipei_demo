ALTER TABLE `lkt_order`
ADD COLUMN `self_lifting` tinyint(4) DEFAULT 0 COMMENT '自提 0.配送 1.自提' AFTER
`remarks`;
ALTER TABLE `lkt_order`
ADD COLUMN `extraction_code` varchar(255) COMMENT '提现码' AFTER `self_lifting`;
ALTER TABLE `lkt_order`
ADD COLUMN `extraction_code_img` varchar(255) COMMENT '提现码二维码' AFTER `extraction_code`;

-- 店铺门店表
create table lkt_mch_store (
  id int(11) unsigned primary key auto_increment comment 'ID',
  store_id int(11) not null default 0 comment '商城id',
  mch_id int(11) not null default 0 comment '店铺ID',
  name varchar(255) DEFAULT NULL COMMENT '门店名称',
  mobile char(15) NOT NULL COMMENT '联系电话',
  business_hours text NOT NULL COMMENT '营业时间',
  sheng char(200) DEFAULT NULL COMMENT '省',
  shi char(200) DEFAULT NULL COMMENT '市',
  xian char(200) DEFAULT NULL COMMENT '县',
  address text COMMENT '详细地址',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '店铺门店表';