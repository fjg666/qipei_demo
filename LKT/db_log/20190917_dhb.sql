-- 数据字典名称表
create table lkt_data_dictionary_name (
  id int(11) unsigned primary key auto_increment comment ''id'',
  name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''名称'',
  status tinyint(4) NOT NULL DEFAULT 0 COMMENT ''是否生效 0:不是 1:是'',
  admin_name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''管理员名称'',
  recycle tinyint(4) NOT NULL DEFAULT 0 COMMENT ''回收站 0:正常 1:回收'',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT ''添加时间''
) engine=''myisam'' charset=''utf8'' comment ''数据字典名称表'';

INSERT INTO `lkt_data_dictionary_name` VALUES (1, ''分页'', 1, ''admin'', 0, ''2019-09-12 18:04:52'');
INSERT INTO `lkt_data_dictionary_name` VALUES (2, ''商品类型'', 1, ''admin'', 0, ''2019-09-12 18:05:08'');
INSERT INTO `lkt_data_dictionary_name` VALUES (3, ''商品状态'', 1, ''admin'', 0, ''2019-09-12 18:05:34'');
INSERT INTO `lkt_data_dictionary_name` VALUES (4, ''订单状态'', 1, ''admin'', 0, ''2019-09-12 18:05:49'');
INSERT INTO `lkt_data_dictionary_name` VALUES (5, ''来源'', 1, ''admin'', 0, ''2019-09-12 18:05:59'');
INSERT INTO `lkt_data_dictionary_name` VALUES (6, ''退货状态'', 1, ''admin'', 0, ''2019-09-12 18:06:06'');
INSERT INTO `lkt_data_dictionary_name` VALUES (7, ''评价'', 1, ''admin'', 0, ''2019-09-12 18:06:12'');
INSERT INTO `lkt_data_dictionary_name` VALUES (8, ''单位'', 1, ''admin'', 0, ''2019-09-12 18:06:22'');
INSERT INTO `lkt_data_dictionary_name` VALUES (9, ''商品展示位置'', 1, ''admin'', 0, ''2019-09-12 18:06:34'');
INSERT INTO `lkt_data_dictionary_name` VALUES (10, ''小程序模板行业'', 1, ''admin'', 0, ''2019-09-12 18:06:45'');
INSERT INTO `lkt_data_dictionary_name` VALUES (11, ''轮播图跳转方式'', 1, ''admin'', 0, ''2019-09-12 18:07:01'');
INSERT INTO `lkt_data_dictionary_name` VALUES (12, ''商品分类'', 1, ''admin'', 0, ''2019-09-12 18:07:08'');
INSERT INTO `lkt_data_dictionary_name` VALUES (13, ''属性名'', 1, ''admin'', 0, ''2019-09-12 18:07:16'');
INSERT INTO `lkt_data_dictionary_name` VALUES (14, ''属性值'', 1, ''admin'', 0, ''2019-09-12 18:07:24'');

-- 数据字典表
create table lkt_data_dictionary_list (
  id int(11) unsigned primary key auto_increment comment ''id'',
  code varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''编码'',
  sid int(11) NOT NULL DEFAULT 0 COMMENT ''数据字典名称ID'',
  s_name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''上级名称'',
  value varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''value'',
  text varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''值'',
  status tinyint(4) NOT NULL DEFAULT 0 COMMENT ''是否生效 0:不是 1:是'',
  admin_name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT ''管理员名称'',
  recycle tinyint(4) NOT NULL DEFAULT 0 COMMENT ''回收站 0:正常 1:回收'',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT ''添加时间''
) engine=''myisam'' charset=''utf8'' comment ''数据字典表'';

INSERT INTO `lkt_data_dictionary_list` VALUES (1, ''LKT_FY_001'', 1, '''', ''10'', ''10'', 1, ''admin'', 0, ''2019-09-12 19:21:11'');
INSERT INTO `lkt_data_dictionary_list` VALUES (2, ''LKT_FY_002'', 1, '''', ''25'', ''25'', 1, ''admin'', 0, ''2019-09-12 19:22:27'');
INSERT INTO `lkt_data_dictionary_list` VALUES (3, ''LKT_FY_003'', 1, '''', ''50'', ''50'', 1, ''admin'', 0, ''2019-09-12 19:22:36'');
INSERT INTO `lkt_data_dictionary_list` VALUES (4, ''LKT_FY_004'', 1, '''', ''100'', ''100'', 1, ''admin'', 0, ''2019-09-12 19:22:45'');
INSERT INTO `lkt_data_dictionary_list` VALUES (5, ''LKT_SPLX_001'', 2, '''', ''1'', ''新品'', 1, ''admin'', 0, ''2019-09-12 19:24:34'');
INSERT INTO `lkt_data_dictionary_list` VALUES (6, ''LKT_SPLX_002'', 2, '''', ''2'', ''热销'', 1, ''admin'', 0, ''2019-09-12 19:25:05'');
INSERT INTO `lkt_data_dictionary_list` VALUES (7, ''LKT_SPLX_003'', 2, '''', ''3'', ''推荐'', 1, ''admin'', 0, ''2019-09-12 19:25:15'');
INSERT INTO `lkt_data_dictionary_list` VALUES (8, ''LKT_SPZT_001'', 3, '''', ''1'', ''待上架'', 1, ''admin'', 0, ''2019-09-12 19:25:51'');
INSERT INTO `lkt_data_dictionary_list` VALUES (9, ''LKT_SPZT_002'', 3, '''', ''2'', ''上架'', 1, ''admin'', 0, ''2019-09-12 19:26:07'');
INSERT INTO `lkt_data_dictionary_list` VALUES (10, ''LKT_SPZT_003'', 3, '''', ''3'', ''下架'', 1, ''admin'', 0, ''2019-09-12 19:26:21'');
INSERT INTO `lkt_data_dictionary_list` VALUES (11, ''LKT_DDZT_001'', 4, '''', ''0'', ''待付款'', 1, ''admin'', 0, ''2019-09-12 19:39:38'');
INSERT INTO `lkt_data_dictionary_list` VALUES (12, ''LKT_DDZT_002'', 4, '''', ''1'', ''待发货'', 1, ''admin'', 0, ''2019-09-16 09:51:02'');
INSERT INTO `lkt_data_dictionary_list` VALUES (13, ''LKT_DDZT_003'', 4, '''', ''2'', ''待收货'', 1, ''admin'', 0, ''2019-09-16 09:51:21'');
INSERT INTO `lkt_data_dictionary_list` VALUES (14, ''LKT_DDZT_004'', 4, '''', ''3'', ''待评价'', 1, ''admin'', 0, ''2019-09-16 09:51:42'');
INSERT INTO `lkt_data_dictionary_list` VALUES (15, ''LKT_DDZT_005'', 4, '''', ''4'', ''退货'', 1, ''admin'', 0, ''2019-09-16 09:52:02'');
INSERT INTO `lkt_data_dictionary_list` VALUES (16, ''LKT_DDZT_006'', 4, '''', ''5'', ''已完成'', 1, ''admin'', 0, ''2019-09-16 09:52:17'');
INSERT INTO `lkt_data_dictionary_list` VALUES (17, ''LKT_DDZT_007'', 4, '''', ''6'', ''已关闭'', 1, ''admin'', 0, ''2019-09-16 09:52:28'');
INSERT INTO `lkt_data_dictionary_list` VALUES (18, ''LKT_LY_001'', 5, '''', ''1'', ''小程序'', 1, ''admin'', 0, ''2019-09-16 09:54:12'');
INSERT INTO `lkt_data_dictionary_list` VALUES (19, ''LKT_LY_002'', 5, '''', ''2'', ''APP'', 1, ''admin'', 0, ''2019-09-16 09:54:21'');
INSERT INTO `lkt_data_dictionary_list` VALUES (20, ''LKT_THZT_001'', 6, '''', ''1'', ''审核中'', 1, ''admin'', 0, ''2019-09-16 09:54:37'');
INSERT INTO `lkt_data_dictionary_list` VALUES (21, ''LKT_THZT_002'', 6, '''', ''2'', ''待买家发货'', 1, ''admin'', 0, ''2019-09-16 09:54:52'');
INSERT INTO `lkt_data_dictionary_list` VALUES (22, ''LKT_THZT_003'', 6, '''', ''3'', ''已拒绝'', 1, ''admin'', 0, ''2019-09-16 09:55:06'');
INSERT INTO `lkt_data_dictionary_list` VALUES (23, ''LKT_THZT_004'', 6, '''', ''4'', ''待商家收货'', 1, ''admin'', 0, ''2019-09-16 09:55:21'');
INSERT INTO `lkt_data_dictionary_list` VALUES (24, ''LKT_THZT_005'', 6, '''', ''5'', ''已退款'', 1, ''admin'', 0, ''2019-09-16 09:55:34'');
INSERT INTO `lkt_data_dictionary_list` VALUES (25, ''LKT_THZT_006'', 6, '''', ''6'', ''拒绝并退回商品'', 1, ''admin'', 0, ''2019-09-16 09:55:48'');
INSERT INTO `lkt_data_dictionary_list` VALUES (26, ''LKT_PJ_001'', 7, '''', ''0'', ''全部'', 1, ''admin'', 0, ''2019-09-16 09:56:00'');
INSERT INTO `lkt_data_dictionary_list` VALUES (27, ''LKT_PJ_002'', 7, '''', ''GOOD'', ''好评'', 1, ''admin'', 0, ''2019-09-16 09:56:21'');
INSERT INTO `lkt_data_dictionary_list` VALUES (28, ''LKT_PJ_003'', 7, '''', ''NOTBAD'', ''中评'', 1, ''admin'', 0, ''2019-09-16 10:03:52'');
INSERT INTO `lkt_data_dictionary_list` VALUES (29, ''LKT_PJ_004'', 7, '''', ''BAD'', ''差评'', 1, ''admin'', 0, ''2019-09-16 10:04:07'');
INSERT INTO `lkt_data_dictionary_list` VALUES (30, ''LKT_DW_001'', 8, '''', ''盒'', ''盒'', 1, ''admin'', 0, ''2019-09-16 10:04:26'');
INSERT INTO `lkt_data_dictionary_list` VALUES (31, ''LKT_DW_002'', 8, '''', ''篓'', ''篓'', 1, ''admin'', 0, ''2019-09-16 10:04:47'');
INSERT INTO `lkt_data_dictionary_list` VALUES (32, ''LKT_DW_003'', 8, '''', ''箱'', ''箱'', 1, ''admin'', 0, ''2019-09-16 10:05:03'');
INSERT INTO `lkt_data_dictionary_list` VALUES (33, ''LKT_DW_004'', 8, '''', ''个'', ''个'', 1, ''admin'', 0, ''2019-09-16 10:05:23'');
INSERT INTO `lkt_data_dictionary_list` VALUES (34, ''LKT_DW_005'', 8, '''', ''套'', ''套'', 1, ''admin'', 0, ''2019-09-16 10:05:38'');
INSERT INTO `lkt_data_dictionary_list` VALUES (35, ''LKT_DW_006'', 8, '''', ''包'', ''包'', 1, ''admin'', 0, ''2019-09-16 10:05:51'');
INSERT INTO `lkt_data_dictionary_list` VALUES (36, ''LKT_DW_007'', 8, '''', ''支'', ''支'', 1, ''admin'', 0, ''2019-09-16 10:06:04'');
INSERT INTO `lkt_data_dictionary_list` VALUES (37, ''LKT_DW_008'', 8, '''', ''条'', ''条'', 1, ''admin'', 0, ''2019-09-16 10:06:15'');
INSERT INTO `lkt_data_dictionary_list` VALUES (38, ''LKT_DW_009'', 8, '''', ''根'', ''根'', 1, ''admin'', 0, ''2019-09-16 10:07:03'');
INSERT INTO `lkt_data_dictionary_list` VALUES (39, ''LKT_PJ_005'', 8, '''', ''本'', ''本'', 1, ''admin'', 0, ''2019-09-16 10:07:15'');
INSERT INTO `lkt_data_dictionary_list` VALUES (40, ''LKT_PJ_006'', 8, '''', ''瓶'', ''瓶'', 1, ''admin'', 0, ''2019-09-16 10:07:28'');
INSERT INTO `lkt_data_dictionary_list` VALUES (41, ''LKT_PJ_007'', 8, '''', ''块'', ''块'', 1, ''admin'', 0, ''2019-09-16 10:07:38'');
INSERT INTO `lkt_data_dictionary_list` VALUES (42, ''LKT_PJ_008'', 8, '''', ''片'', ''片'', 1, ''admin'', 0, ''2019-09-16 10:07:50'');
INSERT INTO `lkt_data_dictionary_list` VALUES (43, ''LKT_PJ_009'', 8, '''', ''把'', ''把'', 1, ''admin'', 0, ''2019-09-16 10:08:01'');
INSERT INTO `lkt_data_dictionary_list` VALUES (44, ''LKT_PJ_010'', 8, '''', ''组'', ''组'', 1, ''admin'', 0, ''2019-09-16 10:08:14'');
INSERT INTO `lkt_data_dictionary_list` VALUES (45, ''LKT_PJ_011'', 8, '''', ''双'', ''双'', 1, ''admin'', 0, ''2019-09-16 10:08:27'');
INSERT INTO `lkt_data_dictionary_list` VALUES (46, ''LKT_PJ_012'', 8, '''', ''台'', ''台'', 1, ''admin'', 0, ''2019-09-16 10:08:40'');
INSERT INTO `lkt_data_dictionary_list` VALUES (47, ''LKT_PJ_013'', 8, '''', ''件'', ''件'', 1, ''admin'', 0, ''2019-09-16 10:08:52'');
INSERT INTO `lkt_data_dictionary_list` VALUES (48, ''LKT_SPZSWZ_001'', 9, '''', ''0'', ''全部商品'', 1, ''admin'', 0, ''2019-09-16 10:09:11'');
INSERT INTO `lkt_data_dictionary_list` VALUES (49, ''LKT_SPZSWZ_002'', 9, '''', ''1'', ''首页'', 1, ''admin'', 0, ''2019-09-16 10:09:33'');
INSERT INTO `lkt_data_dictionary_list` VALUES (50, ''LKT_SPZSWZ_003'', 9, '''', ''2'', ''购物车'', 1, ''admin'', 0, ''2019-09-16 10:09:44'');
INSERT INTO `lkt_data_dictionary_list` VALUES (51, ''LKT_XCXMBXY_001'', 10, '''', ''1'', ''广告'', 1, ''admin'', 0, ''2019-09-16 10:10:03'');
INSERT INTO `lkt_data_dictionary_list` VALUES (52, ''LKT_XCXMBXY_002'', 10, '''', ''2'', ''生活'', 1, ''admin'', 0, ''2019-09-16 10:10:17'');
INSERT INTO `lkt_data_dictionary_list` VALUES (53, ''LKT_XCXMBXY_003'', 10, '''', ''3'', ''电影'', 1, ''admin'', 0, ''2019-09-16 10:10:33'');
INSERT INTO `lkt_data_dictionary_list` VALUES (54, ''LKT_LBTTZFS_001'', 11, '''', ''1'', ''商品分类'', 1, ''admin'', 0, ''2019-09-16 10:10:59'');
INSERT INTO `lkt_data_dictionary_list` VALUES (55, ''LKT_LBTTZFS_002'', 11, '''', ''2'', ''指定商品'', 1, ''admin'', 0, ''2019-09-16 10:11:10'');
INSERT INTO `lkt_data_dictionary_list` VALUES (56, ''LKT_LBTTZFS_003'', 11, '''', ''3'', ''不跳转'', 1, ''admin'', 0, ''2019-09-16 10:11:23'');
INSERT INTO `lkt_data_dictionary_list` VALUES (57, ''LKT_SPFL_001'', 12, '''', ''1'', ''一级'', 1, ''admin'', 0, ''2019-09-16 10:11:36'');
INSERT INTO `lkt_data_dictionary_list` VALUES (58, ''LKT_SPFL_002'', 12, '''', ''2'', ''二级'', 1, ''admin'', 0, ''2019-09-16 10:11:48'');
INSERT INTO `lkt_data_dictionary_list` VALUES (59, ''LKT_SPFL_003'', 12, '''', ''3'', ''三级'', 1, ''admin'', 0, ''2019-09-16 10:12:01'');
INSERT INTO `lkt_data_dictionary_list` VALUES (60, ''LKT_SPFL_004'', 12, '''', ''4'', ''四级'', 1, ''admin'', 0, ''2019-09-16 10:12:16'');
INSERT INTO `lkt_data_dictionary_list` VALUES (61, ''LKT_SPFL_005'', 12, '''', ''5'', ''五级'', 1, ''admin'', 0, ''2019-09-16 10:12:30'');
INSERT INTO `lkt_data_dictionary_list` VALUES (62, ''LKT_SXM_001'', 13, '''', ''1'', ''颜色'', 1, ''admin'', 0, ''2019-09-16 10:12:49'');
INSERT INTO `lkt_data_dictionary_list` VALUES (63, ''LKT_SXM_002'', 13, '''', ''2'', ''尺码'', 1, ''admin'', 0, ''2019-09-16 10:13:04'');
INSERT INTO `lkt_data_dictionary_list` VALUES (64, ''LKT_SXZ_001'', 14, ''颜色'', ''1'', ''蓝色'', 1, ''admin'', 0, ''2019-09-16 10:23:09'');
INSERT INTO `lkt_data_dictionary_list` VALUES (65, ''LKT_SXZ_002'', 14, ''颜色'', ''2'', ''黑色'', 1, ''admin'', 0, ''2019-09-16 10:25:36'');
INSERT INTO `lkt_data_dictionary_list` VALUES (66, ''LKT_SXZ_003'', 14, ''颜色'', ''3'', ''红色'', 1, ''admin'', 0, ''2019-09-16 10:26:43'');
INSERT INTO `lkt_data_dictionary_list` VALUES (67, ''LKT_SXZ_004'', 14, ''颜色'', ''4'', ''黄色'', 1, ''admin'', 0, ''2019-09-16 10:26:59'');
INSERT INTO `lkt_data_dictionary_list` VALUES (68, ''LKT_SXZ_005'', 14, ''尺码'', ''5'', ''M'', 1, ''admin'', 0, ''2019-09-16 10:27:19'');
INSERT INTO `lkt_data_dictionary_list` VALUES (69, ''LKT_SXZ_006'', 14, ''尺码'', ''6'', ''L'', 1, ''admin'', 0, ''2019-09-16 10:27:35'');
INSERT INTO `lkt_data_dictionary_list` VALUES (70, ''LKT_SXZ_007'', 14, ''尺码'', ''7'', ''XL'', 1, ''admin'', 0, ''2019-09-16 10:27:51'');
INSERT INTO `lkt_data_dictionary_list` VALUES (71, ''LKT_SXZ_008'', 14, ''尺码'', ''8'', ''XXL'', 1, ''admin'', 0, ''2019-09-16 11:58:51'');
INSERT INTO `lkt_data_dictionary_list` VALUES (72, ''LKT_SXZ_009'', 14, ''颜色'', ''9'', ''粉色'', 1, ''admin'', 0, ''2019-09-17 10:18:22'');
INSERT INTO `lkt_data_dictionary_list` VALUES (73, ''LKT_SXZ_010'', 14, ''颜色'', ''10'', ''天蓝'', 1, ''admin'', 0, ''2019-09-17 10:21:44'');

-- 客户端表
CREATE TABLE `lkt_client`  (
  id int(11) unsigned primary key auto_increment comment ''id'',
  name varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '''' COMMENT ''角色名称'',
  permission text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT ''许可'',
  admin_id int(11) NOT NULL DEFAULT 0 COMMENT ''管理员id'',
  add_date timestamp NULL DEFAULT NULL COMMENT ''添加时间''
) engine=''myisam'' charset=''utf8'' comment ''客户端表'';

INSERT INTO `lkt_client` VALUES (1, ''通用'', ''a:133:{i:0;s:3:\"1/8\";i:1;s:3:\"2/9\";i:2;s:4:\"3/10\";i:3;s:4:\"3/11\";i:4;s:4:\"3/12\";i:5;s:4:\"3/13\";i:6;s:4:\"3/14\";i:7;s:4:\"3/15\";i:8;s:4:\"3/16\";i:9;s:5:\"3/352\";i:10;s:5:\"3/403\";i:11;s:4:\"2/17\";i:12;s:4:\"3/18\";i:13;s:4:\"3/19\";i:14;s:4:\"3/20\";i:15;s:4:\"3/21\";i:16;s:5:\"4/311\";i:17;s:5:\"4/312\";i:18;s:5:\"3/307\";i:19;s:5:\"3/308\";i:20;s:4:\"2/22\";i:21;s:4:\"3/23\";i:22;s:4:\"3/24\";i:23;s:4:\"3/25\";i:24;s:4:\"3/26\";i:25;s:4:\"3/27\";i:26;s:5:\"2/327\";i:27;s:5:\"3/328\";i:28;s:5:\"4/333\";i:29;s:5:\"3/329\";i:30;s:5:\"4/334\";i:31;s:5:\"3/330\";i:32;s:5:\"3/331\";i:33;s:5:\"3/332\";i:34;s:5:\"2/404\";i:35;s:5:\"3/416\";i:36;s:4:\"1/31\";i:37;s:4:\"2/32\";i:38;s:4:\"3/33\";i:39;s:4:\"3/34\";i:40;s:4:\"3/35\";i:41;s:4:\"3/36\";i:42;s:4:\"3/37\";i:43;s:4:\"3/38\";i:44;s:5:\"3/387\";i:45;s:5:\"3/414\";i:46;s:4:\"2/39\";i:47;s:4:\"3/40\";i:48;s:4:\"3/41\";i:49;s:4:\"3/42\";i:50;s:5:\"2/101\";i:51;s:5:\"3/102\";i:52;s:5:\"3/103\";i:53;s:5:\"3/104\";i:54;s:5:\"3/105\";i:55;s:5:\"3/240\";i:56;s:5:\"2/111\";i:57;s:5:\"3/112\";i:58;s:5:\"3/113\";i:59;s:5:\"3/114\";i:60;s:5:\"3/115\";i:61;s:5:\"2/415\";i:62;s:4:\"2/85\";i:63;s:3:\"1/1\";i:64;s:3:\"2/2\";i:65;s:3:\"3/3\";i:66;s:3:\"3/4\";i:67;s:3:\"3/5\";i:68;s:3:\"3/6\";i:69;s:3:\"3/7\";i:70;s:5:\"3/351\";i:71;s:5:\"3/409\";i:72;s:5:\"3/410\";i:73;s:5:\"3/411\";i:74;s:5:\"3/412\";i:75;s:5:\"3/413\";i:76;s:4:\"2/56\";i:77;s:4:\"3/57\";i:78;s:4:\"3/59\";i:79;s:4:\"3/60\";i:80;s:4:\"3/61\";i:81;s:5:\"3/397\";i:82;s:4:\"2/62\";i:83;s:5:\"3/278\";i:84;s:4:\"2/63\";i:85;s:4:\"3/64\";i:86;s:4:\"3/65\";i:87;s:4:\"3/66\";i:88;s:4:\"2/67\";i:89;s:4:\"3/68\";i:90;s:4:\"3/69\";i:91;s:4:\"3/70\";i:92;s:5:\"1/257\";i:93;s:5:\"2/258\";i:94;s:5:\"3/259\";i:95;s:5:\"3/260\";i:96;s:5:\"3/261\";i:97;s:5:\"3/262\";i:98;s:4:\"2/99\";i:99;s:5:\"3/135\";i:100;s:5:\"3/136\";i:101;s:4:\"2/74\";i:102;s:4:\"3/75\";i:103;s:4:\"3/76\";i:104;s:4:\"3/77\";i:105;s:4:\"3/78\";i:106;s:5:\"3/305\";i:107;s:4:\"1/86\";i:108;s:5:\"2/287\";i:109;s:5:\"3/288\";i:110;s:5:\"3/289\";i:111;s:5:\"3/290\";i:112;s:5:\"3/291\";i:113;s:5:\"3/292\";i:114;s:5:\"2/313\";i:115;s:5:\"3/314\";i:116;s:5:\"2/317\";i:117;s:5:\"3/318\";i:118;s:5:\"3/319\";i:119;s:5:\"4/320\";i:120;s:5:\"4/321\";i:121;s:5:\"4/322\";i:122;s:5:\"3/323\";i:123;s:5:\"4/324\";i:124;s:5:\"4/325\";i:125;s:5:\"4/326\";i:126;s:5:\"2/381\";i:127;s:5:\"3/382\";i:128;s:5:\"3/383\";i:129;s:5:\"4/384\";i:130;s:5:\"4/385\";i:131;s:5:\"4/386\";i:132;s:5:\"2/402\";}'', 1, ''2019-09-17 05:50:44'');
INSERT INTO `lkt_client` VALUES (2, ''小程序'', ''a:17:{i:0;s:5:\"1/267\";i:1;s:5:\"2/116\";i:2;s:5:\"3/117\";i:3;s:5:\"3/118\";i:4;s:5:\"3/119\";i:5;s:5:\"3/120\";i:6;s:5:\"3/400\";i:7;s:5:\"1/269\";i:8;s:5:\"2/140\";i:9;s:5:\"2/218\";i:10;s:5:\"2/372\";i:11;s:5:\"3/373\";i:12;s:5:\"3/374\";i:13;s:5:\"3/375\";i:14;s:5:\"3/376\";i:15;s:5:\"2/388\";i:16;s:5:\"2/398\";}'', 1, ''2019-09-17 05:51:18'');
INSERT INTO `lkt_client` VALUES (3, ''APP'', ''a:14:{i:0;s:5:\"1/282\";i:1;s:5:\"2/283\";i:2;s:5:\"3/284\";i:3;s:5:\"3/285\";i:4;s:5:\"3/286\";i:5;s:5:\"3/401\";i:6;s:5:\"1/219\";i:7;s:5:\"2/220\";i:8;s:5:\"3/221\";i:9;s:5:\"3/222\";i:10;s:5:\"3/223\";i:11;s:5:\"3/224\";i:12;s:5:\"2/336\";i:13;s:5:\"2/395\";}'', 1, ''2019-09-17 05:51:30'');
INSERT INTO `lkt_client` VALUES (4, ''微信公众号'', ''a:103:{i:0;s:3:\"1/8\";i:1;s:3:\"2/9\";i:2;s:4:\"3/10\";i:3;s:4:\"3/11\";i:4;s:4:\"3/12\";i:5;s:4:\"3/13\";i:6;s:4:\"3/14\";i:7;s:4:\"3/15\";i:8;s:4:\"3/16\";i:9;s:4:\"2/17\";i:10;s:4:\"3/18\";i:11;s:4:\"3/19\";i:12;s:4:\"3/20\";i:13;s:4:\"3/21\";i:14;s:4:\"2/22\";i:15;s:4:\"3/23\";i:16;s:4:\"3/24\";i:17;s:4:\"3/25\";i:18;s:4:\"3/26\";i:19;s:4:\"3/27\";i:20;s:4:\"2/28\";i:21;s:4:\"3/29\";i:22;s:4:\"3/30\";i:23;s:4:\"1/31\";i:24;s:4:\"2/32\";i:25;s:4:\"3/33\";i:26;s:4:\"3/34\";i:27;s:4:\"3/35\";i:28;s:4:\"3/36\";i:29;s:4:\"3/37\";i:30;s:4:\"3/38\";i:31;s:4:\"2/39\";i:32;s:4:\"3/40\";i:33;s:4:\"3/41\";i:34;s:4:\"3/42\";i:35;s:5:\"2/101\";i:36;s:5:\"3/102\";i:37;s:5:\"3/103\";i:38;s:5:\"3/104\";i:39;s:5:\"3/105\";i:40;s:5:\"3/240\";i:41;s:5:\"2/111\";i:42;s:5:\"3/112\";i:43;s:5:\"3/113\";i:44;s:5:\"3/114\";i:45;s:5:\"3/115\";i:46;s:4:\"2/85\";i:47;s:3:\"1/1\";i:48;s:3:\"2/2\";i:49;s:3:\"3/3\";i:50;s:3:\"3/4\";i:51;s:3:\"3/5\";i:52;s:3:\"3/6\";i:53;s:3:\"3/7\";i:54;s:4:\"2/56\";i:55;s:4:\"3/57\";i:56;s:4:\"3/59\";i:57;s:4:\"3/60\";i:58;s:4:\"3/61\";i:59;s:4:\"2/62\";i:60;s:5:\"3/278\";i:61;s:4:\"2/63\";i:62;s:4:\"3/64\";i:63;s:4:\"3/65\";i:64;s:4:\"3/66\";i:65;s:4:\"2/67\";i:66;s:4:\"3/68\";i:67;s:4:\"3/69\";i:68;s:4:\"3/70\";i:69;s:5:\"1/257\";i:70;s:5:\"2/258\";i:71;s:5:\"3/259\";i:72;s:5:\"3/260\";i:73;s:5:\"3/261\";i:74;s:5:\"3/262\";i:75;s:4:\"2/99\";i:76;s:5:\"3/135\";i:77;s:5:\"3/136\";i:78;s:4:\"2/74\";i:79;s:4:\"3/75\";i:80;s:4:\"3/76\";i:81;s:4:\"3/77\";i:82;s:4:\"3/78\";i:83;s:4:\"1/86\";i:84;s:4:\"2/87\";i:85;s:4:\"3/88\";i:86;s:4:\"3/89\";i:87;s:4:\"3/90\";i:88;s:4:\"3/91\";i:89;s:4:\"2/92\";i:90;s:4:\"3/93\";i:91;s:4:\"3/94\";i:92;s:4:\"3/95\";i:93;s:4:\"3/96\";i:94;s:4:\"3/97\";i:95;s:4:\"3/98\";i:96;s:5:\"2/248\";i:97;s:5:\"2/287\";i:98;s:5:\"3/288\";i:99;s:5:\"3/289\";i:100;s:5:\"3/290\";i:101;s:5:\"3/291\";i:102;s:5:\"3/292\";}'', 1, ''2019-09-17 05:52:01'');
INSERT INTO `lkt_client` VALUES (5, ''PC'', ''a:94:{i:0;s:3:\"1/8\";i:1;s:3:\"2/9\";i:2;s:4:\"3/10\";i:3;s:4:\"3/11\";i:4;s:4:\"3/12\";i:5;s:4:\"3/13\";i:6;s:4:\"3/14\";i:7;s:4:\"3/15\";i:8;s:4:\"3/16\";i:9;s:4:\"2/17\";i:10;s:4:\"3/18\";i:11;s:4:\"3/19\";i:12;s:4:\"3/20\";i:13;s:4:\"3/21\";i:14;s:4:\"2/22\";i:15;s:4:\"3/23\";i:16;s:4:\"3/24\";i:17;s:4:\"3/25\";i:18;s:4:\"3/26\";i:19;s:4:\"3/27\";i:20;s:4:\"1/31\";i:21;s:4:\"2/32\";i:22;s:4:\"3/33\";i:23;s:4:\"3/34\";i:24;s:4:\"3/35\";i:25;s:4:\"3/36\";i:26;s:4:\"3/37\";i:27;s:4:\"3/38\";i:28;s:4:\"2/39\";i:29;s:4:\"3/40\";i:30;s:4:\"3/41\";i:31;s:4:\"3/42\";i:32;s:5:\"2/101\";i:33;s:5:\"3/102\";i:34;s:5:\"3/103\";i:35;s:5:\"3/104\";i:36;s:5:\"3/105\";i:37;s:5:\"3/240\";i:38;s:5:\"2/111\";i:39;s:5:\"3/112\";i:40;s:5:\"3/113\";i:41;s:5:\"3/114\";i:42;s:5:\"3/115\";i:43;s:4:\"2/85\";i:44;s:3:\"1/1\";i:45;s:3:\"2/2\";i:46;s:3:\"3/3\";i:47;s:3:\"3/4\";i:48;s:3:\"3/5\";i:49;s:3:\"3/6\";i:50;s:3:\"3/7\";i:51;s:5:\"3/351\";i:52;s:5:\"3/409\";i:53;s:5:\"3/410\";i:54;s:5:\"3/411\";i:55;s:5:\"3/412\";i:56;s:5:\"3/413\";i:57;s:4:\"2/56\";i:58;s:4:\"3/57\";i:59;s:4:\"3/59\";i:60;s:4:\"3/60\";i:61;s:4:\"3/61\";i:62;s:4:\"2/62\";i:63;s:5:\"3/278\";i:64;s:4:\"2/63\";i:65;s:4:\"3/64\";i:66;s:4:\"3/65\";i:67;s:4:\"3/66\";i:68;s:4:\"2/67\";i:69;s:4:\"3/68\";i:70;s:4:\"3/69\";i:71;s:4:\"3/70\";i:72;s:5:\"1/257\";i:73;s:5:\"2/258\";i:74;s:5:\"3/259\";i:75;s:5:\"3/260\";i:76;s:5:\"3/261\";i:77;s:5:\"3/262\";i:78;s:4:\"2/99\";i:79;s:5:\"3/135\";i:80;s:5:\"3/136\";i:81;s:4:\"2/74\";i:82;s:4:\"3/75\";i:83;s:4:\"3/76\";i:84;s:4:\"3/77\";i:85;s:4:\"3/78\";i:86;s:4:\"1/86\";i:87;s:5:\"2/287\";i:88;s:5:\"3/288\";i:89;s:5:\"3/289\";i:90;s:5:\"3/290\";i:91;s:5:\"3/291\";i:92;s:5:\"3/292\";i:93;s:5:\"1/417\";}'', 1, ''2019-09-17 05:52:10'');
INSERT INTO `lkt_client` VALUES (6, ''生活号'', ''a:103:{i:0;s:3:\"1/8\";i:1;s:3:\"2/9\";i:2;s:4:\"3/10\";i:3;s:4:\"3/11\";i:4;s:4:\"3/12\";i:5;s:4:\"3/13\";i:6;s:4:\"3/14\";i:7;s:4:\"3/15\";i:8;s:4:\"3/16\";i:9;s:4:\"2/17\";i:10;s:4:\"3/18\";i:11;s:4:\"3/19\";i:12;s:4:\"3/20\";i:13;s:4:\"3/21\";i:14;s:4:\"2/22\";i:15;s:4:\"3/23\";i:16;s:4:\"3/24\";i:17;s:4:\"3/25\";i:18;s:4:\"3/26\";i:19;s:4:\"3/27\";i:20;s:4:\"2/28\";i:21;s:4:\"3/29\";i:22;s:4:\"3/30\";i:23;s:4:\"1/31\";i:24;s:4:\"2/32\";i:25;s:4:\"3/33\";i:26;s:4:\"3/34\";i:27;s:4:\"3/35\";i:28;s:4:\"3/36\";i:29;s:4:\"3/37\";i:30;s:4:\"3/38\";i:31;s:4:\"2/39\";i:32;s:4:\"3/40\";i:33;s:4:\"3/41\";i:34;s:4:\"3/42\";i:35;s:5:\"2/101\";i:36;s:5:\"3/102\";i:37;s:5:\"3/103\";i:38;s:5:\"3/104\";i:39;s:5:\"3/105\";i:40;s:5:\"3/240\";i:41;s:5:\"2/111\";i:42;s:5:\"3/112\";i:43;s:5:\"3/113\";i:44;s:5:\"3/114\";i:45;s:5:\"3/115\";i:46;s:4:\"2/85\";i:47;s:3:\"1/1\";i:48;s:3:\"2/2\";i:49;s:3:\"3/3\";i:50;s:3:\"3/4\";i:51;s:3:\"3/5\";i:52;s:3:\"3/6\";i:53;s:3:\"3/7\";i:54;s:4:\"2/56\";i:55;s:4:\"3/57\";i:56;s:4:\"3/59\";i:57;s:4:\"3/60\";i:58;s:4:\"3/61\";i:59;s:4:\"2/62\";i:60;s:5:\"3/278\";i:61;s:4:\"2/63\";i:62;s:4:\"3/64\";i:63;s:4:\"3/65\";i:64;s:4:\"3/66\";i:65;s:4:\"2/67\";i:66;s:4:\"3/68\";i:67;s:4:\"3/69\";i:68;s:4:\"3/70\";i:69;s:5:\"1/257\";i:70;s:5:\"2/258\";i:71;s:5:\"3/259\";i:72;s:5:\"3/260\";i:73;s:5:\"3/261\";i:74;s:5:\"3/262\";i:75;s:4:\"2/99\";i:76;s:5:\"3/135\";i:77;s:5:\"3/136\";i:78;s:4:\"2/74\";i:79;s:4:\"3/75\";i:80;s:4:\"3/76\";i:81;s:4:\"3/77\";i:82;s:4:\"3/78\";i:83;s:4:\"1/86\";i:84;s:4:\"2/87\";i:85;s:4:\"3/88\";i:86;s:4:\"3/89\";i:87;s:4:\"3/90\";i:88;s:4:\"3/91\";i:89;s:4:\"2/92\";i:90;s:4:\"3/93\";i:91;s:4:\"3/94\";i:92;s:4:\"3/95\";i:93;s:4:\"3/96\";i:94;s:4:\"3/97\";i:95;s:4:\"3/98\";i:96;s:5:\"2/248\";i:97;s:5:\"2/287\";i:98;s:5:\"3/288\";i:99;s:5:\"3/289\";i:100;s:5:\"3/290\";i:101;s:5:\"3/291\";i:102;s:5:\"3/292\";}'', 1, ''2019-09-17 05:52:18'');
INSERT INTO `lkt_client` VALUES (7, ''报表'', ''a:7:{i:0;s:5:\"1/276\";i:1;s:5:\"2/293\";i:2;s:5:\"3/294\";i:3;s:5:\"3/295\";i:4;s:5:\"3/296\";i:5;s:5:\"2/297\";i:6;s:5:\"2/298\";}'', 1, ''2019-09-17 05:52:27'');
INSERT INTO `lkt_client` VALUES (8, ''支付宝小程序'', ''a:7:{i:0;s:5:\"1/423\";i:1;s:5:\"2/424\";i:2;s:5:\"2/425\";i:3;s:5:\"3/426\";i:4;s:5:\"3/427\";i:5;s:5:\"3/428\";i:6;s:5:\"3/429\";}'', 1, ''2019-09-17 05:52:41'');

ALTER TABLE `lkt_core_menu`
MODIFY COLUMN `type` tinyint(4) DEFAULT 0 COMMENT '类型 0.后台管理 1.小程序 2.app 3.微信公众号 4.PC 5.生活号 6.报表 7.支付宝小程序' AFTER `is_plug_in`;