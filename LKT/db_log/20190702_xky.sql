ALTER TABLE `lkt_bargain_goods`
ADD COLUMN `is_type`  varchar(20) NOT NULL COMMENT '产品属性值1.猜你喜欢，2.热销，3.新品' AFTER `attr_id`;

