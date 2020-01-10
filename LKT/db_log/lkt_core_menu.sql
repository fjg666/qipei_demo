/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 04/12/2019 09:23:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lkt_core_menu
-- ----------------------------
DROP TABLE IF EXISTS `lkt_core_menu`;
CREATE TABLE `lkt_core_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `s_id` int(11) DEFAULT NULL COMMENT '上级id',
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单标识',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图标',
  `image1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '点击后图标',
  `module` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单模块标识',
  `action` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单文件标识',
  `url` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '路径',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `level` int(11) DEFAULT NULL COMMENT '第几级',
  `is_core` tinyint(4) DEFAULT 0 COMMENT '是否是核心',
  `is_plug_in` tinyint(4) DEFAULT 0 COMMENT '是否是插件',
  `type` tinyint(4) DEFAULT 0 COMMENT '类型 0.后台管理 1.小程序 2.app 3.微信公众号 4.PC 5.生活号 6.报表 7.支付宝小程序',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `recycle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '回收站 0.不回收 1.回收',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 361 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '核心菜单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_core_menu
-- ----------------------------
INSERT INTO `lkt_core_menu` VALUES (1, 0, '商户管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768997927.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768980615.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-23 11:03:37', 0);
INSERT INTO `lkt_core_menu` VALUES (2, 1, '商户列表', '', '', '', 'Customer', 'Index', 'index.php?module=Customer&action=Index', 100, 2, 1, 0, 0, '2019-10-23 10:54:31', 0);
INSERT INTO `lkt_core_menu` VALUES (3, 2, '添加', '', '', '', 'Customer', 'Add', 'index.php?module=Customer&action=Add', 100, 3, 1, 0, 0, '2019-10-23 10:55:26', 0);
INSERT INTO `lkt_core_menu` VALUES (4, 2, '锁定', '', '', '', 'Customer', 'Sstatus', 'index.php?module=Customer&action=Sstatus', 100, 3, 1, 0, 0, '2019-10-23 10:56:42', 0);
INSERT INTO `lkt_core_menu` VALUES (5, 2, '查看', '', '', '', 'Customer', 'See', 'index.php?module=Customer&action=See', 100, 3, 1, 0, 0, '2019-10-23 10:58:22', 0);
INSERT INTO `lkt_core_menu` VALUES (6, 2, '编辑', '', '', '', 'Customer', 'Modify', 'index.php?module=Customer&action=Modify', 100, 3, 1, 0, 0, '2019-10-23 10:59:09', 0);
INSERT INTO `lkt_core_menu` VALUES (7, 2, '密码重置', '', '', '', 'Customer', 'Reset', 'index.php?module=Customer&action=Reset', 100, 3, 1, 0, 0, '2019-10-23 10:59:49', 0);
INSERT INTO `lkt_core_menu` VALUES (8, 2, '浏览', '', '', '', 'Customer', 'Index', 'index.php?module=Customer&action=Index', 100, 3, 1, 0, 0, '2019-10-23 11:02:09', 0);
INSERT INTO `lkt_core_menu` VALUES (9, 0, '权限管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769445242.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769454769.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-23 11:03:14', 0);
INSERT INTO `lkt_core_menu` VALUES (10, 9, '菜单列表', '', '', '', 'menu', 'Index', 'index.php?module=menu&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:04:07', 0);
INSERT INTO `lkt_core_menu` VALUES (11, 10, '添加', '', '', '', 'menu', 'Add', 'index.php?module=menu&action=Add', 100, 3, 1, 0, 0, '2019-10-23 11:04:53', 0);
INSERT INTO `lkt_core_menu` VALUES (12, 10, '编辑', '', '', '', 'menu', 'Modify', 'index.php?module=menu&action=Modify', 100, 3, 1, 0, 0, '2019-10-23 11:05:33', 0);
INSERT INTO `lkt_core_menu` VALUES (13, 10, '删除', '', '', '', 'menu', 'Del', 'index.php?module=menu&action=Del', 100, 3, 1, 0, 0, '2019-10-23 11:06:12', 0);
INSERT INTO `lkt_core_menu` VALUES (14, 10, '浏览', '', '', '', 'menu', 'Index', 'index.php?module=menu&action=Index', 100, 3, 1, 0, 0, '2019-10-23 11:07:16', 0);
INSERT INTO `lkt_core_menu` VALUES (15, 9, '客户端列表', '', '', '', 'client', 'Index', 'index.php?module=client&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:14:48', 0);
INSERT INTO `lkt_core_menu` VALUES (16, 15, '添加', '', '', '', 'client', 'Add', 'index.php?module=client&action=Add', 100, 3, 1, 0, 0, '2019-10-23 11:15:18', 0);
INSERT INTO `lkt_core_menu` VALUES (17, 15, '查看', '', '', '', 'client', 'See', 'index.php?module=client&action=See', 100, 3, 1, 0, 0, '2019-10-23 11:16:01', 0);
INSERT INTO `lkt_core_menu` VALUES (18, 15, '编辑', '', '', '', 'client', 'Modify', 'index.php?module=client&action=Modify', 100, 3, 1, 0, 0, '2019-10-23 11:16:29', 0);
INSERT INTO `lkt_core_menu` VALUES (19, 15, '删除', '', '', '', 'client', 'Del', 'index.php?module=client&action=Del', 100, 3, 1, 0, 0, '2019-10-23 11:17:03', 0);
INSERT INTO `lkt_core_menu` VALUES (20, 15, '浏览', '', '', '', 'client', 'Index', 'index.php?module=client&action=Index', 100, 3, 1, 0, 0, '2019-10-23 11:17:51', 0);
INSERT INTO `lkt_core_menu` VALUES (21, 9, '支付管理', '', '', '', 'payment', 'Index', 'index.php?module=payment&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:26:00', 0);
INSERT INTO `lkt_core_menu` VALUES (22, 21, '添加/修改', '', '', '', 'payment', 'Set', 'index.php?module=payment&action=Set', 100, 3, 1, 0, 0, '2019-10-23 11:31:27', 0);
INSERT INTO `lkt_core_menu` VALUES (23, 0, '图片管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769185257.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769192751.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-23 11:37:47', 0);
INSERT INTO `lkt_core_menu` VALUES (24, 23, '图片设置', '', '', '', 'setupload', 'Index', 'index.php?module=setupload&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:38:18', 0);
INSERT INTO `lkt_core_menu` VALUES (25, 21, '浏览', '', '', '', 'payment', 'Index', 'index.php?module=payment&action=Index', 100, 3, 1, 0, 0, '2019-10-23 11:38:55', 0);
INSERT INTO `lkt_core_menu` VALUES (26, 0, '公告管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769084517.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769079478.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-23 11:40:02', 0);
INSERT INTO `lkt_core_menu` VALUES (27, 26, '系统公告', '', '', '', 'systemtell', 'Index', 'index.php?module=systemtell&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:40:23', 0);
INSERT INTO `lkt_core_menu` VALUES (28, 27, '添加', '', '', '', 'systemtell', 'add', 'index.php?module=systemtell&action=add', 100, 3, 1, 0, 0, '2019-10-23 11:41:00', 0);
INSERT INTO `lkt_core_menu` VALUES (29, 27, '编辑', '', '', '', 'systemtell', 'modify', 'index.php?module=systemtell&action=modify', 100, 3, 1, 0, 0, '2019-10-23 11:41:31', 0);
INSERT INTO `lkt_core_menu` VALUES (30, 27, '删除', '', '', '', 'systemtell', 'del', 'index.php?module=systemtell&action=del', 100, 3, 1, 0, 0, '2019-10-23 11:42:02', 0);
INSERT INTO `lkt_core_menu` VALUES (31, 27, '浏览', '', '', '', 'systemtell', 'Index', 'index.php?module=systemtell&action=Index', 100, 3, 1, 0, 0, '2019-10-23 11:42:41', 0);
INSERT INTO `lkt_core_menu` VALUES (32, 0, '插件管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/155376953062.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769535290.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-24 11:22:13', 0);
INSERT INTO `lkt_core_menu` VALUES (33, 32, '插件列表', '', '', '', 'plug_ins', 'Index', 'index.php?module=plug_ins&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:45:37', 0);
INSERT INTO `lkt_core_menu` VALUES (34, 33, '添加', '', '', '', 'plug_ins', 'Add', 'index.php?module=plug_ins&action=Add', 100, 3, 1, 0, 0, '2019-10-23 11:46:16', 0);
INSERT INTO `lkt_core_menu` VALUES (35, 33, '编辑', '', '', '', 'plug_ins', 'Modify', 'index.php?module=plug_ins&action=Modify', 100, 3, 1, 0, 0, '2019-10-23 11:47:04', 0);
INSERT INTO `lkt_core_menu` VALUES (36, 33, '删除', '', '', '', 'plug_ins', 'Del', 'index.php?module=plug_ins&action=Del', 100, 3, 1, 0, 0, '2019-10-23 11:48:55', 0);
INSERT INTO `lkt_core_menu` VALUES (37, 33, '浏览', '', '', '', 'plug_ins', 'Index', 'index.php?module=plug_ins&action=Index', 100, 3, 1, 0, 0, '2019-10-23 11:49:20', 0);
INSERT INTO `lkt_core_menu` VALUES (38, 0, '数据字典', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769244965.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769239411.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-23 11:50:13', 0);
INSERT INTO `lkt_core_menu` VALUES (39, 38, '数据字典列表', '', '', '', 'data_dictionary', 'Index', 'index.php?module=data_dictionary&action=Index', 100, 2, 1, 0, 0, '2019-10-23 11:50:48', 0);
INSERT INTO `lkt_core_menu` VALUES (40, 39, '添加', '', '', '', 'data_dictionary', 'Add', 'index.php?module=data_dictionary&action=Add', 100, 3, 1, 0, 0, '2019-10-23 11:51:45', 0);
INSERT INTO `lkt_core_menu` VALUES (41, 39, '编辑', '', '', '', 'data_dictionary', 'Modify', 'index.php?module=data_dictionary&action=Modify', 100, 3, 1, 0, 0, '2019-10-23 11:52:19', 0);
INSERT INTO `lkt_core_menu` VALUES (42, 39, '删除', '', '', '', 'data_dictionary', 'Del', 'index.php?module=data_dictionary&action=Del', 100, 3, 1, 0, 0, '2019-10-23 11:52:56', 0);
INSERT INTO `lkt_core_menu` VALUES (43, 39, '数据名称管理', '', '', '', 'data_dictionary', 'List', 'index.php?module=data_dictionary&action=List', 100, 3, 0, 0, 0, '2019-10-23 11:55:15', 0);
INSERT INTO `lkt_core_menu` VALUES (44, 39, '添加数据名称', '', '', '', 'data_dictionary', 'Add_name', 'index.php?module=data_dictionary&action=Add_name', 100, 3, 1, 0, 0, '2019-10-23 11:59:34', 0);
INSERT INTO `lkt_core_menu` VALUES (45, 39, '编辑数据名称', '', '', '', 'data_dictionary', 'Modify_name', 'index.php?module=data_dictionary&action=Modify_name', 100, 3, 1, 0, 0, '2019-10-23 12:01:21', 0);
INSERT INTO `lkt_core_menu` VALUES (46, 39, '删除数据名称', '', '', '', 'data_dictionary', 'Del_name', 'index.php?module=data_dictionary&action=Del_name', 100, 3, 1, 0, 0, '2019-10-23 12:01:54', 0);
INSERT INTO `lkt_core_menu` VALUES (47, 0, '授权管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768005360.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767999837.png', '', '', '', 100, 1, 1, 0, 0, '2019-10-23 13:54:32', 0);
INSERT INTO `lkt_core_menu` VALUES (48, 47, '模板设置', '', '', '', 'third', 'Template', 'index.php?module=third&action=Template', 100, 2, 1, 0, 0, '2019-10-23 13:55:12', 0);
INSERT INTO `lkt_core_menu` VALUES (49, 48, '添加', '', '', '', 'third', 'TemplateAdd', 'index.php?module=third&action=TemplateAdd', 100, 3, 1, 0, 0, '2019-10-23 13:55:51', 0);
INSERT INTO `lkt_core_menu` VALUES (50, 48, '编辑/删除', '', '', '', 'third', 'TemplateModify', 'index.php?module=third&action=TemplateModify', 100, 3, 1, 0, 0, '2019-10-23 13:58:04', 0);
INSERT INTO `lkt_core_menu` VALUES (51, 48, '浏览', '', '', '', 'third', 'Template', 'index.php?module=third&action=Template', 100, 3, 1, 0, 0, '2019-10-23 13:58:25', 0);
INSERT INTO `lkt_core_menu` VALUES (52, 47, '发布管理', '', '', '', 'third', 'Review', 'index.php?module=third&action=Review', 100, 2, 1, 0, 0, '2019-10-23 14:01:56', 0);
INSERT INTO `lkt_core_menu` VALUES (53, 47, '参数设置', '', '', '', 'third', 'ThirdInfo', 'index.php?module=third&action=ThirdInfo', 100, 2, 1, 0, 0, '2019-10-23 14:03:30', 0);
INSERT INTO `lkt_core_menu` VALUES (54, 0, '商品管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767545337.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767551766.png', '', '', '', 100, 1, 0, 0, 0, '2019-10-23 14:05:23', 0);
INSERT INTO `lkt_core_menu` VALUES (55, 54, '商品列表', '', '', '', 'product', 'Index', 'index.php?module=product&action=Index', 100, 2, 0, 0, 0, '2019-10-23 14:19:01', 0);
INSERT INTO `lkt_core_menu` VALUES (56, 55, '添加', '', '', '', 'product', 'Add', 'index.php?module=product&action=Add', 100, 3, 0, 0, 0, '2019-10-23 14:19:33', 0);
INSERT INTO `lkt_core_menu` VALUES (57, 55, '编辑', '', '', '', 'product', 'Modify', 'index.php?module=product&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 14:20:36', 0);
INSERT INTO `lkt_core_menu` VALUES (58, 55, '删除', '', '', '', 'product', 'Del', 'index.php?module=product&action=Del', 100, 3, 0, 0, 0, '2019-10-23 14:20:57', 0);
INSERT INTO `lkt_core_menu` VALUES (59, 55, '批量操作', '', '', '', 'product', 'Operation', 'index.php?module=product&action=Operation', 100, 3, 0, 0, 0, '2019-10-23 14:23:59', 0);
INSERT INTO `lkt_core_menu` VALUES (60, 55, '上架/下架', '', '', '', 'product', 'Shelves', 'index.php?module=product&action=Shelves', 100, 3, 0, 0, 0, '2019-10-23 14:27:10', 0);
INSERT INTO `lkt_core_menu` VALUES (61, 55, '复制', '', '', '', 'product', 'Copy', 'index.php?module=product&action=Copy', 100, 3, 0, 0, 0, '2019-10-23 14:25:50', 0);
INSERT INTO `lkt_core_menu` VALUES (62, 55, '置顶/上移/下移', '', '', '', 'product', 'Stick', 'index.php?module=product&action=Stick', 100, 3, 0, 0, 0, '2019-10-23 14:27:23', 0);
INSERT INTO `lkt_core_menu` VALUES (63, 55, '浏览', '', '', '', 'product', 'Index', 'index.php?module=product&action=Index', 100, 3, 0, 0, 0, '2019-10-23 14:28:59', 0);
INSERT INTO `lkt_core_menu` VALUES (64, 54, '商品分类', '', '', '', 'product_class', 'Index', 'index.php?module=product_class&action=Index', 100, 2, 0, 0, 0, '2019-10-23 14:29:25', 0);
INSERT INTO `lkt_core_menu` VALUES (65, 64, '添加', '', '', '', 'product_class', 'Add', 'index.php?module=product_class&action=Add', 100, 3, 0, 0, 0, '2019-10-23 14:30:08', 0);
INSERT INTO `lkt_core_menu` VALUES (66, 64, '编辑', '', '', '', 'product_class', 'Modify', 'index.php?module=product_class&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 14:31:38', 0);
INSERT INTO `lkt_core_menu` VALUES (67, 64, '置顶', '', '', '', 'product_class', 'Stick', 'index.php?module=product_class&action=Stick', 100, 3, 0, 0, 0, '2019-10-23 14:32:17', 0);
INSERT INTO `lkt_core_menu` VALUES (68, 64, '删除', '', '', '', 'product_class', 'Del', 'index.php?module=product_class&action=Del', 100, 3, 0, 0, 0, '2019-10-23 14:32:45', 0);
INSERT INTO `lkt_core_menu` VALUES (69, 64, '浏览', '', '', '', 'product_class', 'Index', 'index.php?module=product_class&action=Index', 100, 3, 0, 0, 0, '2019-10-23 14:33:38', 0);
INSERT INTO `lkt_core_menu` VALUES (70, 54, '品牌管理', '', '', '', 'brand_class', 'Index', 'index.php?module=brand_class&action=Index', 100, 2, 0, 0, 0, '2019-10-23 14:34:20', 0);
INSERT INTO `lkt_core_menu` VALUES (71, 70, '添加', '', '', '', 'brand_class', 'Add', 'index.php?module=brand_class&action=Add', 100, 3, 0, 0, 0, '2019-10-23 14:34:54', 0);
INSERT INTO `lkt_core_menu` VALUES (72, 70, '编辑', '', '', '', 'brand_class', 'Modify', 'index.php?module=brand_class&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 14:35:48', 0);
INSERT INTO `lkt_core_menu` VALUES (73, 70, '删除', '', '', '', 'brand_class', 'Del', 'index.php?module=brand_class&action=Del', 100, 3, 0, 0, 0, '2019-10-23 14:36:10', 0);
INSERT INTO `lkt_core_menu` VALUES (74, 70, '置顶', '', '', '', 'brand_class', 'Status', 'index.php?module=brand_class&action=Status', 100, 3, 0, 0, 0, '2019-10-23 14:36:37', 0);
INSERT INTO `lkt_core_menu` VALUES (75, 70, '浏览', '', '', '', 'brand_class', 'Index', 'index.php?module=brand_class&action=Index', 100, 3, 0, 0, 0, '2019-10-23 14:42:22', 0);
INSERT INTO `lkt_core_menu` VALUES (76, 54, '库存管理', '', '', '', 'stock', 'Index', 'index.php?module=stock&action=Index', 100, 2, 0, 0, 0, '2019-10-23 14:49:57', 0);
INSERT INTO `lkt_core_menu` VALUES (77, 76, '库存列表', '', '', '', 'stock', 'Index', 'index.php?module=stock&action=Index', 100, 3, 0, 0, 0, '2019-10-23 14:51:21', 0);
INSERT INTO `lkt_core_menu` VALUES (78, 76, '库存预警', '', '', '', 'stock', 'Warning', 'index.php?module=stock&action=Warning', 100, 3, 0, 0, 0, '2019-10-23 14:51:41', 0);
INSERT INTO `lkt_core_menu` VALUES (79, 76, '入货详情', '', '', '', 'stock', 'Enter', 'index.php?module=stock&action=Enter', 100, 3, 0, 0, 0, '2019-10-23 14:52:25', 0);
INSERT INTO `lkt_core_menu` VALUES (80, 76, '出货详情', '', '', '', 'stock', 'Shipment', 'index.php?module=stock&action=Shipment', 100, 3, 0, 0, 0, '2019-10-23 14:52:49', 0);
INSERT INTO `lkt_core_menu` VALUES (81, 76, '库存详情', '', '', '', 'stock', 'See', 'index.php?module=stock&action=See', 100, 3, 0, 0, 0, '2019-10-23 14:55:00', 0);
INSERT INTO `lkt_core_menu` VALUES (82, 76, '添加库存', '', '', '', 'stock', 'Add', 'index.php?module=stock&action=Add', 100, 3, 0, 0, 0, '2019-10-23 15:06:48', 0);
INSERT INTO `lkt_core_menu` VALUES (83, 76, '预警记录', '', '', '', 'stock', 'Seewarning', 'index.php?module=stock&action=Seewarning', 100, 3, 0, 0, 0, '2019-10-23 15:09:12', 0);
INSERT INTO `lkt_core_menu` VALUES (84, 54, '淘宝助手', '', '', '', 'taobao', 'Index', 'index.php?module=taobao&action=Index', 100, 2, 0, 0, 0, '2019-10-23 15:18:44', 0);
INSERT INTO `lkt_core_menu` VALUES (85, 84, '查看详情', '', '', '', 'taobao', 'See', 'index.php?module=taobao&action=See', 100, 3, 0, 0, 0, '2019-10-23 15:21:09', 0);
INSERT INTO `lkt_core_menu` VALUES (86, 0, '订单管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767583457.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/155376758861.png', '', '', '', 100, 1, 0, 0, 0, '2019-10-23 15:21:54', 0);
INSERT INTO `lkt_core_menu` VALUES (87, 86, '订单列表', '', '', '', 'orderslist', 'Index', 'index.php?module=orderslist&action=Index', 100, 2, 0, 0, 0, '2019-10-23 15:23:05', 0);
INSERT INTO `lkt_core_menu` VALUES (88, 87, '订单详情', '', '', '', 'orderslist', 'Detail', 'index.php?module=orderslist&action=Detail', 100, 3, 0, 0, 0, '2019-10-23 15:23:50', 0);
INSERT INTO `lkt_core_menu` VALUES (89, 87, '编辑订单', '', '', '', 'orderslist', 'Modify', 'index.php?module=orderslist&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 15:24:17', 0);
INSERT INTO `lkt_core_menu` VALUES (90, 87, '发货页面', '', '', '', 'orderslist', 'Delivery', 'index.php?module=orderslist&action=Delivery', 100, 3, 0, 0, 0, '2019-10-23 15:40:53', 0);
INSERT INTO `lkt_core_menu` VALUES (91, 87, '查看物流', '', '', '', 'orderslist', 'Kuaidishow', 'index.php?module=orderslist&action=Kuaidishow', 100, 3, 0, 0, 0, '2019-10-23 15:25:33', 0);
INSERT INTO `lkt_core_menu` VALUES (92, 87, '关闭订单', '', '', '', 'orderslist', 'Close', 'index.php?module=orderslist&action=Close', 100, 3, 0, 0, 0, '2019-10-23 15:26:13', 0);
INSERT INTO `lkt_core_menu` VALUES (93, 87, '发货', '', '', '', 'orderslist', 'Addsign', 'index.php?module=orderslist&action=Addsign', 100, 3, 0, 0, 0, '2019-10-23 15:41:21', 0);
INSERT INTO `lkt_core_menu` VALUES (94, 87, '浏览', '', '', '', 'orderslist', 'Index', 'index.php?module=orderslist&action=Index', 100, 3, 0, 0, 0, '2019-10-23 15:47:37', 0);
INSERT INTO `lkt_core_menu` VALUES (95, 86, '退货列表', '', '', '', 'return', 'Index', 'index.php?module=return&action=Index', 100, 2, 0, 0, 0, '2019-10-23 15:48:37', 0);
INSERT INTO `lkt_core_menu` VALUES (96, 95, '查看', '', '', '', 'return', 'View', 'index.php?module=return&action=View', 100, 3, 0, 0, 0, '2019-10-23 15:51:21', 0);
INSERT INTO `lkt_core_menu` VALUES (97, 95, '通过/拒绝', '', '', '', 'return', 'Examine', 'index.php?module=return&action=Examine', 100, 3, 0, 0, 0, '2019-10-23 15:52:08', 0);
INSERT INTO `lkt_core_menu` VALUES (98, 95, '浏览', '', '', '', 'return', 'Index', 'index.php?module=return&action=Index', 100, 3, 0, 0, 0, '2019-10-23 16:04:53', 0);
INSERT INTO `lkt_core_menu` VALUES (99, 86, '评价管理', '', '', '', 'comments', 'Index', 'index.php?module=comments&action=Index', 100, 2, 0, 0, 0, '2019-10-23 16:05:45', 0);
INSERT INTO `lkt_core_menu` VALUES (100, 99, '回复评论', '', '', '', 'comments', 'Reply', 'index.php?module=comments&action=Reply', 100, 3, 0, 0, 0, '2019-10-23 16:07:15', 0);
INSERT INTO `lkt_core_menu` VALUES (101, 99, '修改评论', '', '', '', 'comments', 'Modify', 'index.php?module=comments&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 16:07:46', 0);
INSERT INTO `lkt_core_menu` VALUES (102, 99, '删除评论', '', '', '', 'comments', 'Del', 'index.php?module=comments&action=Del', 100, 3, 0, 0, 0, '2019-10-23 16:08:24', 0);
INSERT INTO `lkt_core_menu` VALUES (103, 99, '浏览', '', '', '', 'comments', 'Index', 'index.php?module=comments&action=Index', 100, 3, 0, 0, 0, '2019-10-23 16:08:56', 0);
INSERT INTO `lkt_core_menu` VALUES (104, 86, '运费设置', '', '', '', 'freight', 'Index', 'index.php?module=freight&action=Index', 100, 2, 0, 0, 0, '2019-10-23 16:11:56', 0);
INSERT INTO `lkt_core_menu` VALUES (105, 104, '添加', '', '', '', 'freight', 'Add', 'index.php?module=freight&action=Add', 100, 3, 0, 0, 0, '2019-10-23 16:13:01', 0);
INSERT INTO `lkt_core_menu` VALUES (106, 104, '编辑', '', '', '', 'freight', 'Modify', 'index.php?module=freight&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 16:13:45', 0);
INSERT INTO `lkt_core_menu` VALUES (107, 104, '删除', '', '', '', 'freight', 'Del', 'index.php?module=freight&action=Del', 100, 3, 0, 0, 0, '2019-10-23 16:14:11', 0);
INSERT INTO `lkt_core_menu` VALUES (108, 104, '设置默认运费', '', '', '', 'freight', 'Is_default', 'index.php?module=freight&action=Is_default', 100, 3, 0, 0, 0, '2019-10-23 16:21:09', 0);
INSERT INTO `lkt_core_menu` VALUES (109, 104, '浏览', '', '', '', 'freight', 'Index', 'index.php?module=freight&action=Index', 100, 3, 0, 0, 0, '2019-10-23 16:26:11', 0);
INSERT INTO `lkt_core_menu` VALUES (110, 86, '打印单据', '', '', '', 'invoice', 'Index', 'index.php?module=invoice&action=Index', 100, 2, 0, 0, 0, '2019-10-23 16:26:55', 0);
INSERT INTO `lkt_core_menu` VALUES (111, 110, '发货单', '', '', '', 'invoice', 'Index', 'index.php?module=invoice&action=Index', 100, 3, 0, 0, 0, '2019-10-23 16:30:28', 0);
INSERT INTO `lkt_core_menu` VALUES (112, 110, '快递单', '', '', '', 'invoice', 'indexx', 'index.php?module=invoice&action=indexx', 100, 3, 0, 0, 0, '2019-10-23 16:30:54', 0);
INSERT INTO `lkt_core_menu` VALUES (113, 110, '模板管理', '', '', '', 'invoice', 'template', 'index.php?module=invoice&action=template', 100, 3, 0, 0, 0, '2019-10-23 16:32:26', 0);
INSERT INTO `lkt_core_menu` VALUES (114, 110, '编辑', '', '', '', 'invoice', 'creat_list', 'index.php?module=invoice&action=creat_list', 100, 3, 0, 0, 0, '2019-10-23 16:34:23', 0);
INSERT INTO `lkt_core_menu` VALUES (115, 110, '浏览', '', '', '', 'invoice', 'Index', 'index.php?module=invoice&action=Index', 100, 3, 0, 0, 0, '2019-10-23 16:46:07', 0);
INSERT INTO `lkt_core_menu` VALUES (116, 86, '订单设置', '', '', '', 'orderslist', 'Config', 'index.php?module=orderslist&action=Config', 100, 2, 0, 0, 0, '2019-10-23 16:46:38', 0);
INSERT INTO `lkt_core_menu` VALUES (117, 0, '会员管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767294444.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/155376731135.png', '', '', '', 100, 1, 0, 0, 0, '2019-10-23 16:47:33', 0);
INSERT INTO `lkt_core_menu` VALUES (118, 117, '会员列表', '', '', '', 'userlist', 'Index', 'index.php?module=userlist&action=Index', 100, 2, 0, 0, 0, '2019-10-23 16:47:59', 0);
INSERT INTO `lkt_core_menu` VALUES (119, 118, '会员等级', '', '', '', 'userlist', 'Grade', 'index.php?module=userlist&action=Grade', 100, 3, 0, 0, 0, '2019-10-23 16:48:48', 0);
INSERT INTO `lkt_core_menu` VALUES (120, 118, '会员设置', '', '', '', 'userlist', 'Config', 'index.php?module=userlist&action=Config', 100, 3, 0, 0, 0, '2019-10-23 16:49:13', 0);
INSERT INTO `lkt_core_menu` VALUES (121, 134, '添加会员', '', '', '', 'userlist', 'Add', 'index.php?module=userlist&action=Add', 100, 4, 0, 0, 0, '2019-10-24 10:43:33', 0);
INSERT INTO `lkt_core_menu` VALUES (122, 134, '查看会员', '', '', '', 'userlist', 'View', 'index.php?module=userlist&action=View', 100, 4, 0, 0, 0, '2019-10-24 10:43:36', 0);
INSERT INTO `lkt_core_menu` VALUES (123, 134, '编辑会员', '', '', '', 'userlist', 'Modify', 'index.php?module=userlist&action=Modify', 100, 4, 0, 0, 0, '2019-10-24 10:43:37', 0);
INSERT INTO `lkt_core_menu` VALUES (124, 134, '删除会员', '', '', '', 'userlist', 'Del', 'index.php?module=userlist&action=Del', 100, 4, 0, 0, 0, '2019-10-24 10:43:38', 0);
INSERT INTO `lkt_core_menu` VALUES (125, 134, '充值', '', '', '', 'userlist', 'Recharge', 'index.php?module=userlist&action=Recharge', 100, 4, 0, 0, 0, '2019-10-24 10:43:39', 0);
INSERT INTO `lkt_core_menu` VALUES (126, 119, '添加等级', '', '', '', 'userlist', 'GradeAdd', 'index.php?module=userlist&action=GradeAdd', 100, 4, 0, 0, 0, '2019-10-24 10:44:22', 0);
INSERT INTO `lkt_core_menu` VALUES (127, 119, '编辑等级', '', '', '', 'userlist', 'GradeModify', 'index.php?module=userlist&action=GradeModify', 100, 4, 0, 0, 0, '2019-10-24 10:44:29', 0);
INSERT INTO `lkt_core_menu` VALUES (128, 134, '浏览', '', '', '', 'userlist', 'Index', 'index.php?module=userlist&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:07:58', 0);
INSERT INTO `lkt_core_menu` VALUES (129, 117, '提现管理', '', '', '', 'finance', 'Index', 'index.php?module=finance&action=Index', 100, 2, 0, 0, 0, '2019-10-23 17:02:15', 0);
INSERT INTO `lkt_core_menu` VALUES (130, 129, '提现审核', '', '', '', 'finance', 'Index', 'index.php?module=finance&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:03:20', 0);
INSERT INTO `lkt_core_menu` VALUES (131, 129, '提现记录', '', '', '', 'finance', 'List', 'index.php?module=finance&action=List', 100, 3, 0, 0, 0, '2019-10-23 17:03:42', 0);
INSERT INTO `lkt_core_menu` VALUES (132, 129, '钱包参数', '', '', '', 'finance', 'Config', 'index.php?module=finance&action=Config', 100, 3, 0, 0, 0, '2019-10-23 17:04:08', 0);
INSERT INTO `lkt_core_menu` VALUES (133, 130, '通过/拒绝', '', '', '', 'finance', 'Del', 'index.php?module=finance&action=Del', 100, 4, 0, 0, 0, '2019-10-23 17:04:54', 0);
INSERT INTO `lkt_core_menu` VALUES (134, 118, '会员列表', '', '', '', 'userlist', 'Index', 'index.php?module=userlist&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:07:03', 0);
INSERT INTO `lkt_core_menu` VALUES (135, 119, '浏览', '', '', '', 'userlist', 'Grade', 'index.php?module=userlist&action=Grade', 100, 4, 0, 0, 0, '2019-10-23 17:09:32', 0);
INSERT INTO `lkt_core_menu` VALUES (136, 130, '浏览', '', '', '', 'finance', 'Index', 'index.php?module=finance&action=Index', 100, 4, 0, 0, 0, '2019-10-23 17:10:30', 0);
INSERT INTO `lkt_core_menu` VALUES (137, 117, '充值列表', '', '', '', 'finance', 'Recharge', 'index.php?module=finance&action=Recharge', 100, 2, 0, 0, 0, '2019-10-23 17:10:54', 0);
INSERT INTO `lkt_core_menu` VALUES (138, 117, '资金管理', '', '', '', 'finance', 'Yue', 'index.php?module=finance&action=Yue', 100, 2, 0, 0, 0, '2019-10-23 17:11:26', 0);
INSERT INTO `lkt_core_menu` VALUES (139, 138, '查看详情', '', '', '', 'finance', 'Yue_see', 'index.php?module=finance&action=Yue_see', 100, 3, 0, 0, 0, '2019-10-23 17:11:57', 0);
INSERT INTO `lkt_core_menu` VALUES (140, 138, '浏览', '', '', '', 'finance', 'Yue', 'index.php?module=finance&action=Yue', 100, 3, 0, 0, 0, '2019-10-23 17:12:48', 0);
INSERT INTO `lkt_core_menu` VALUES (141, 117, '积分管理', '', '', '', 'finance', 'Jifen', 'index.php?module=finance&action=Jifen', 100, 2, 0, 0, 0, '2019-10-23 17:13:13', 0);
INSERT INTO `lkt_core_menu` VALUES (142, 141, '查看详情', '', '', '', 'finance', 'Jifen_see', 'index.php?module=finance&action=Jifen_see', 100, 3, 0, 0, 0, '2019-10-23 17:13:49', 0);
INSERT INTO `lkt_core_menu` VALUES (143, 141, '浏览', '', '', '', 'finance', 'Jifen', 'index.php?module=finance&action=Jifen', 100, 3, 0, 0, 0, '2019-10-23 17:14:11', 0);
INSERT INTO `lkt_core_menu` VALUES (144, 0, '权限管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767725740.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767745940.png', '', '', '', 100, 1, 0, 0, 0, '2019-10-23 17:16:22', 0);
INSERT INTO `lkt_core_menu` VALUES (145, 144, '管理员列表', '', '', '', 'member', 'Index', 'index.php?module=member&action=Index', 100, 2, 0, 0, 0, '2019-10-23 17:17:02', 0);
INSERT INTO `lkt_core_menu` VALUES (146, 145, '添加', '', '', '', 'member', 'Add', 'index.php?module=member&action=Add', 100, 3, 0, 0, 0, '2019-10-23 17:17:57', 0);
INSERT INTO `lkt_core_menu` VALUES (147, 145, '启用/禁用', '', '', '', 'member', 'Status', 'index.php?module=member&action=Status', 100, 3, 0, 0, 0, '2019-10-23 17:18:34', 0);
INSERT INTO `lkt_core_menu` VALUES (148, 145, '编辑', '', '', '', 'member', 'Modify', 'index.php?module=member&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 17:18:56', 0);
INSERT INTO `lkt_core_menu` VALUES (149, 145, '删除', '', '', '', 'member', 'Del', 'index.php?module=member&action=Del', 100, 3, 0, 0, 0, '2019-10-23 17:19:15', 0);
INSERT INTO `lkt_core_menu` VALUES (150, 145, '浏览', '', '', '', 'member', 'Index', 'index.php?module=member&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:19:40', 0);
INSERT INTO `lkt_core_menu` VALUES (151, 144, '管理员日志', '', '', '', 'member', 'MemberRecord', 'index.php?module=member&action=MemberRecord', 100, 2, 0, 0, 0, '2019-10-23 17:20:38', 0);
INSERT INTO `lkt_core_menu` VALUES (152, 151, '批量删除', '', '', '', 'member', 'MemberRecordDel', 'index.php?module=member&action=MemberRecordDel', 100, 3, 0, 0, 0, '2019-12-03 16:04:27', 0);
INSERT INTO `lkt_core_menu` VALUES (153, 151, '浏览', '', '', '', 'member', 'MemberRecord', 'index.php?module=member&action=MemberRecord', 100, 3, 0, 0, 0, '2019-10-23 17:22:25', 0);
INSERT INTO `lkt_core_menu` VALUES (154, 144, '角色管理', '', '', '', 'role', 'Index', 'index.php?module=role&action=Index', 100, 2, 0, 0, 0, '2019-10-24 14:53:07', 0);
INSERT INTO `lkt_core_menu` VALUES (155, 154, '添加角色', '', '', '', 'role', 'Add', 'index.php?module=role&action=Add', 100, 3, 0, 0, 0, '2019-10-23 17:26:16', 0);
INSERT INTO `lkt_core_menu` VALUES (156, 154, '查看', '', '', '', 'role', 'See', 'index.php?module=role&action=See', 100, 3, 0, 0, 0, '2019-10-23 17:26:45', 0);
INSERT INTO `lkt_core_menu` VALUES (157, 154, '编辑', '', '', '', 'role', 'Modify', 'index.php?module=role&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 17:27:20', 0);
INSERT INTO `lkt_core_menu` VALUES (158, 154, '删除', '', '', '', 'role', 'Del', 'index.php?module=role&action=Del', 100, 3, 0, 0, 0, '2019-10-23 17:27:41', 0);
INSERT INTO `lkt_core_menu` VALUES (159, 154, '浏览', '', '', '', 'role', 'Index', 'index.php?module=role&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:28:05', 0);
INSERT INTO `lkt_core_menu` VALUES (160, 0, '插件管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768258740.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768262469.png', '', '', '', 100, 1, 0, 0, 0, '2019-12-03 16:06:12', 0);
INSERT INTO `lkt_core_menu` VALUES (161, 0, '系统管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767887610.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767893432.png', '', '', '', 100, 1, 0, 0, 0, '2019-10-23 17:31:22', 0);
INSERT INTO `lkt_core_menu` VALUES (162, 161, '售后地址管理', '', 'index.php?module=sale&action=Index', '', 'sale', 'Index', 'index.php?module=sale&action=Index', 100, 2, 0, 0, 0, '2019-10-23 17:31:53', 0);
INSERT INTO `lkt_core_menu` VALUES (163, 162, '添加', '', '', '', 'sale', 'add', 'index.php?module=sale&action=add', 100, 3, 0, 0, 0, '2019-10-23 17:32:50', 0);
INSERT INTO `lkt_core_menu` VALUES (164, 162, '编辑', '', '', '', 'sale', 'modify', 'index.php?module=sale&action=modify', 100, 3, 0, 0, 0, '2019-10-23 17:33:30', 0);
INSERT INTO `lkt_core_menu` VALUES (165, 162, '设为默认', '', 'index.php?module=sale&action=is_default', '', 'sale', 'is_default', 'index.php?module=sale&action=is_default', 100, 3, 0, 0, 0, '2019-10-23 17:33:59', 0);
INSERT INTO `lkt_core_menu` VALUES (166, 162, '删除', '', '', '', 'sale', 'del', 'index.php?module=sale&action=del', 100, 3, 0, 0, 0, '2019-10-23 17:34:21', 0);
INSERT INTO `lkt_core_menu` VALUES (167, 162, '浏览', '', '', '', 'sale', 'Index', 'index.php?module=sale&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:34:51', 0);
INSERT INTO `lkt_core_menu` VALUES (168, 161, '支付管理', '', '', '', 'payment', 'Index', 'index.php?module=payment&action=Index', 100, 2, 0, 0, 0, '2019-10-23 17:35:23', 0);
INSERT INTO `lkt_core_menu` VALUES (169, 168, '参数修改', '', '', '', 'payment', 'Modify', 'index.php?module=payment&action=Modify', 100, 3, 0, 0, 0, '2019-10-23 17:36:08', 0);
INSERT INTO `lkt_core_menu` VALUES (170, 168, '浏览', '', '', '', 'payment', 'Index', 'index.php?module=payment&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:36:39', 0);
INSERT INTO `lkt_core_menu` VALUES (171, 161, '短信配置', '', '', '', 'message', 'Index', 'index.php?module=message&action=Index', 100, 2, 0, 0, 0, '2019-10-23 17:37:24', 0);
INSERT INTO `lkt_core_menu` VALUES (172, 171, '短信列表', '', '', '', 'message', 'Index', 'index.php?module=message&action=Index', 100, 3, 0, 0, 0, '2019-10-23 17:38:23', 0);
INSERT INTO `lkt_core_menu` VALUES (173, 171, '短信模板', '', '', '', 'message', 'List', 'index.php?module=message&action=List', 100, 3, 0, 0, 0, '2019-10-23 17:38:50', 0);
INSERT INTO `lkt_core_menu` VALUES (174, 171, '核心设置', '', '', '', 'message', 'Config', 'index.php?module=message&action=Config', 100, 3, 0, 0, 0, '2019-10-23 17:39:10', 0);
INSERT INTO `lkt_core_menu` VALUES (175, 172, '添加', '', '', '', 'message', 'Add', 'index.php?module=message&action=Add', 100, 4, 0, 0, 0, '2019-10-23 17:39:51', 0);
INSERT INTO `lkt_core_menu` VALUES (176, 172, '编辑', '', '', '', 'message', 'Modify', 'index.php?module=message&action=Modify', 100, 4, 0, 0, 0, '2019-10-23 17:40:14', 0);
INSERT INTO `lkt_core_menu` VALUES (177, 172, '删除', '', '', '', 'message', 'Del', 'index.php?module=message&action=Del', 100, 4, 0, 0, 0, '2019-10-23 17:40:39', 0);
INSERT INTO `lkt_core_menu` VALUES (178, 172, '浏览', '', '', '', 'message', 'Index', 'index.php?module=message&action=Index', 100, 4, 0, 0, 0, '2019-10-23 17:41:01', 0);
INSERT INTO `lkt_core_menu` VALUES (179, 173, '添加', '', '', '', 'message', 'Addlist', 'index.php?module=message&action=Addlist', 100, 4, 0, 0, 0, '2019-10-23 17:41:35', 0);
INSERT INTO `lkt_core_menu` VALUES (180, 173, '编辑', '', '', '', 'message', 'Modifylist', 'index.php?module=message&action=Modifylist', 100, 4, 0, 0, 0, '2019-10-23 17:42:06', 0);
INSERT INTO `lkt_core_menu` VALUES (181, 173, '删除', '', '', '', 'message', 'Dellist', 'index.php?module=message&action=Dellist', 100, 4, 0, 0, 0, '2019-10-23 17:42:31', 0);
INSERT INTO `lkt_core_menu` VALUES (182, 173, '浏览', '', '', '', 'message', 'List', 'index.php?module=message&action=List', 100, 4, 0, 0, 0, '2019-10-23 17:42:57', 0);
INSERT INTO `lkt_core_menu` VALUES (183, 161, '系统设置', '', '', '', 'system', 'Config', 'index.php?module=system&action=Config', 100, 2, 0, 0, 0, '2019-10-23 17:43:46', 0);
INSERT INTO `lkt_core_menu` VALUES (184, 183, '基础配置', '', '', '', 'system', 'Config', 'index.php?module=system&action=Config', 100, 3, 0, 0, 0, '2019-10-23 17:44:09', 0);
INSERT INTO `lkt_core_menu` VALUES (185, 183, '协议配置', '', '', '', 'system', 'Agreement', 'index.php?module=system&action=Agreement', 100, 3, 0, 0, 0, '2019-10-23 17:45:07', 0);
INSERT INTO `lkt_core_menu` VALUES (186, 183, '关于我们', '', '', '', 'system', 'Aboutus', 'index.php?module=system&action=Aboutus', 100, 3, 0, 0, 0, '2019-10-23 17:45:38', 0);
INSERT INTO `lkt_core_menu` VALUES (187, 185, '添加', '', '', '', 'system', 'Agreement_add', 'index.php?module=system&action=Agreement_add', 100, 4, 0, 0, 0, '2019-10-23 17:46:26', 0);
INSERT INTO `lkt_core_menu` VALUES (188, 185, '编辑', '', '', '', 'system', 'Agreement_modify', 'index.php?module=system&action=Agreement_modify', 100, 4, 0, 0, 0, '2019-10-23 17:46:54', 0);
INSERT INTO `lkt_core_menu` VALUES (189, 185, '删除', '', '', '', 'system', 'Agreement_del', 'index.php?module=system&action=Agreement_del', 100, 4, 0, 0, 0, '2019-10-23 17:47:21', 0);
INSERT INTO `lkt_core_menu` VALUES (190, 161, '搜索配置', '', '', '', 'search_configuration', 'Index', 'index.php?module=search_configuration&action=Index', 100, 2, 0, 0, 0, '2019-10-23 17:48:02', 0);
INSERT INTO `lkt_core_menu` VALUES (191, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 1, '2019-10-23 17:51:48', 0);
INSERT INTO `lkt_core_menu` VALUES (192, 191, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 1, '2019-10-23 17:53:55', 0);
INSERT INTO `lkt_core_menu` VALUES (193, 192, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 1, '2019-10-23 17:53:58', 0);
INSERT INTO `lkt_core_menu` VALUES (194, 192, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 1, '2019-10-23 17:53:45', 0);
INSERT INTO `lkt_core_menu` VALUES (195, 192, '编辑', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 1, '2019-10-23 17:54:25', 0);
INSERT INTO `lkt_core_menu` VALUES (196, 192, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 1, '2019-10-23 17:54:48', 0);
INSERT INTO `lkt_core_menu` VALUES (197, 192, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 1, '2019-10-23 17:56:22', 0);
INSERT INTO `lkt_core_menu` VALUES (198, 0, '小程序设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768781361.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768790321.png', '', '', '', 100, 1, 0, 0, 1, '2019-10-23 17:56:16', 0);
INSERT INTO `lkt_core_menu` VALUES (199, 198, '接口配置', '', '', '', 'system', 'Index', 'index.php?module=system&action=Index', 100, 2, 0, 0, 1, '2019-10-24 11:13:48', 0);
INSERT INTO `lkt_core_menu` VALUES (200, 198, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 2, 0, 0, 1, '2019-10-23 18:00:04', 0);
INSERT INTO `lkt_core_menu` VALUES (201, 200, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 1, '2019-10-23 17:58:26', 0);
INSERT INTO `lkt_core_menu` VALUES (202, 200, '编辑', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 1, '2019-10-23 17:58:53', 0);
INSERT INTO `lkt_core_menu` VALUES (203, 200, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 1, '2019-10-23 17:59:15', 0);
INSERT INTO `lkt_core_menu` VALUES (204, 200, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 1, '2019-10-23 17:59:57', 0);
INSERT INTO `lkt_core_menu` VALUES (205, 198, '授权设置', '', '', '', 'third', 'Auth', 'index.php?module=third&action=Auth', 100, 2, 0, 0, 1, '2019-10-23 18:00:38', 0);
INSERT INTO `lkt_core_menu` VALUES (206, 198, '模板消息', '', '', '', 'system', 'Template_message', 'index.php?module=system&action=Template_message', 100, 2, 0, 0, 1, '2019-10-23 18:02:31', 0);
INSERT INTO `lkt_core_menu` VALUES (207, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 2, '2019-10-23 18:11:43', 0);
INSERT INTO `lkt_core_menu` VALUES (208, 207, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 2, '2019-10-23 18:11:44', 0);
INSERT INTO `lkt_core_menu` VALUES (209, 208, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 2, '2019-10-23 18:11:45', 0);
INSERT INTO `lkt_core_menu` VALUES (210, 208, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 2, '2019-10-23 18:11:47', 0);
INSERT INTO `lkt_core_menu` VALUES (211, 208, '编辑', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 2, '2019-10-23 18:11:48', 0);
INSERT INTO `lkt_core_menu` VALUES (212, 208, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 2, '2019-10-23 18:11:49', 0);
INSERT INTO `lkt_core_menu` VALUES (213, 208, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 2, '2019-10-23 18:11:50', 0);
INSERT INTO `lkt_core_menu` VALUES (214, 0, 'APP设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768745668.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768749874.png', '', '', '', 100, 1, 0, 0, 2, '2019-10-23 18:13:19', 0);
INSERT INTO `lkt_core_menu` VALUES (215, 214, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 2, 0, 0, 2, '2019-10-23 18:00:04', 0);
INSERT INTO `lkt_core_menu` VALUES (216, 215, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 2, '2019-10-23 18:14:38', 0);
INSERT INTO `lkt_core_menu` VALUES (217, 215, '编辑', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 2, '2019-10-23 18:14:40', 0);
INSERT INTO `lkt_core_menu` VALUES (218, 215, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 2, '2019-10-23 18:14:42', 0);
INSERT INTO `lkt_core_menu` VALUES (219, 215, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 2, '2019-10-23 18:14:44', 0);
INSERT INTO `lkt_core_menu` VALUES (220, 214, '版本配置', '', '', '', 'edition', 'Index', 'index.php?module=edition&action=Index', 100, 2, 0, 0, 2, '2019-10-23 18:15:23', 0);
INSERT INTO `lkt_core_menu` VALUES (221, 214, 'H5配置', '', '', '', 'system', 'App', 'index.php?module=system&action=App', 100, 2, 0, 0, 2, '2019-10-23 18:16:04', 0);
INSERT INTO `lkt_core_menu` VALUES (222, 0, '报表管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768890262.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768894221.png', '', '', '', 100, 1, 0, 0, 6, '2019-10-23 18:17:22', 0);
INSERT INTO `lkt_core_menu` VALUES (223, 222, '报表管理', '', '', '', 'report', 'Index', 'index.php?module=report&action=Index', 100, 2, 0, 0, 6, '2019-10-23 18:18:25', 0);
INSERT INTO `lkt_core_menu` VALUES (224, 223, '新增会员', '', '', '', 'report', 'Index', 'index.php?module=report&action=Index', 100, 3, 0, 0, 6, '2019-10-23 18:19:12', 0);
INSERT INTO `lkt_core_menu` VALUES (225, 223, '会员消费报表', '', '', '', 'report', 'UserConsume', 'index.php?module=report&action=UserConsume', 100, 3, 0, 0, 6, '2019-10-23 18:19:44', 0);
INSERT INTO `lkt_core_menu` VALUES (226, 223, '会员比例', '', '', '', 'report', 'UserSource', 'index.php?module=report&action=UserSource', 100, 3, 0, 0, 6, '2019-10-23 18:20:09', 0);
INSERT INTO `lkt_core_menu` VALUES (227, 222, '订单报表', '', '', '', 'report', 'OrderNum', 'index.php?module=report&action=OrderNum', 100, 2, 0, 0, 6, '2019-10-23 18:22:57', 0);
INSERT INTO `lkt_core_menu` VALUES (228, 222, '商品报表', '', '', '', 'report', 'ProductNum', 'index.php?module=report&action=ProductNum', 100, 2, 0, 0, 6, '2019-10-23 18:24:05', 0);
INSERT INTO `lkt_core_menu` VALUES (229, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 7, '2019-10-23 18:11:43', 0);
INSERT INTO `lkt_core_menu` VALUES (230, 229, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 7, '2019-10-23 18:11:44', 0);
INSERT INTO `lkt_core_menu` VALUES (231, 230, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 7, '2019-10-23 18:11:45', 0);
INSERT INTO `lkt_core_menu` VALUES (232, 230, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 7, '2019-10-23 18:11:47', 0);
INSERT INTO `lkt_core_menu` VALUES (233, 230, '编辑', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 7, '2019-10-23 18:11:48', 0);
INSERT INTO `lkt_core_menu` VALUES (234, 230, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 7, '2019-10-23 18:11:49', 0);
INSERT INTO `lkt_core_menu` VALUES (235, 230, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 7, '2019-10-23 18:11:50', 0);
INSERT INTO `lkt_core_menu` VALUES (236, 0, '支付宝小程序设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768781361.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768790321.png', '', '', '', 100, 1, 0, 0, 7, '2019-10-23 18:29:54', 0);
INSERT INTO `lkt_core_menu` VALUES (237, 236, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 2, 0, 0, 7, '2019-10-23 18:00:04', 0);
INSERT INTO `lkt_core_menu` VALUES (238, 237, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 7, '2019-10-23 18:14:38', 0);
INSERT INTO `lkt_core_menu` VALUES (239, 237, '编辑', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 7, '2019-10-23 18:14:40', 0);
INSERT INTO `lkt_core_menu` VALUES (240, 237, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 7, '2019-10-23 18:14:42', 0);
INSERT INTO `lkt_core_menu` VALUES (241, 237, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 7, '2019-10-23 18:14:44', 0);
INSERT INTO `lkt_core_menu` VALUES (242, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 8, '2019-10-23 18:11:43', 0);
INSERT INTO `lkt_core_menu` VALUES (243, 242, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 8, '2019-10-23 18:11:44', 0);
INSERT INTO `lkt_core_menu` VALUES (244, 243, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 8, '2019-10-23 18:11:45', 0);
INSERT INTO `lkt_core_menu` VALUES (245, 243, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 8, '2019-10-23 18:11:47', 0);
INSERT INTO `lkt_core_menu` VALUES (246, 243, '编辑', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 8, '2019-10-23 18:11:48', 0);
INSERT INTO `lkt_core_menu` VALUES (247, 243, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 8, '2019-10-23 18:11:49', 0);
INSERT INTO `lkt_core_menu` VALUES (248, 243, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 8, '2019-10-23 18:11:50', 0);
INSERT INTO `lkt_core_menu` VALUES (249, 0, '百度小程序设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768781361.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768790321.png', '', '', '', 100, 1, 0, 0, 8, '2019-10-23 18:29:54', 0);
INSERT INTO `lkt_core_menu` VALUES (250, 249, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 2, 0, 0, 8, '2019-10-23 18:00:04', 0);
INSERT INTO `lkt_core_menu` VALUES (251, 250, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 8, '2019-10-23 18:14:38', 0);
INSERT INTO `lkt_core_menu` VALUES (252, 250, '编辑', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 8, '2019-10-23 18:14:40', 0);
INSERT INTO `lkt_core_menu` VALUES (253, 250, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 8, '2019-10-23 18:14:42', 0);
INSERT INTO `lkt_core_menu` VALUES (254, 250, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 8, '2019-10-23 18:14:44', 0);
INSERT INTO `lkt_core_menu` VALUES (255, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 9, '2019-10-23 18:11:43', 0);
INSERT INTO `lkt_core_menu` VALUES (256, 255, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 9, '2019-10-23 18:11:44', 0);
INSERT INTO `lkt_core_menu` VALUES (263, 0, '头条小程序设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768781361.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768790321.png', '', '', '', 100, 1, 0, 0, 9, '2019-10-24 18:17:53', 0);
INSERT INTO `lkt_core_menu` VALUES (258, 256, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 9, '2019-10-23 18:11:45', 0);
INSERT INTO `lkt_core_menu` VALUES (259, 256, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 9, '2019-10-23 18:11:47', 0);
INSERT INTO `lkt_core_menu` VALUES (260, 256, '编辑', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 9, '2019-10-23 18:11:48', 0);
INSERT INTO `lkt_core_menu` VALUES (261, 256, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 9, '2019-10-23 18:11:49', 0);
INSERT INTO `lkt_core_menu` VALUES (262, 256, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 9, '2019-10-23 18:11:50', 0);
INSERT INTO `lkt_core_menu` VALUES (264, 263, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 2, 0, 0, 9, '2019-10-23 18:00:04', 0);
INSERT INTO `lkt_core_menu` VALUES (265, 264, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 9, '2019-10-23 18:14:38', 0);
INSERT INTO `lkt_core_menu` VALUES (266, 264, '编辑', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 9, '2019-10-23 18:14:40', 0);
INSERT INTO `lkt_core_menu` VALUES (267, 264, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 9, '2019-10-23 18:14:42', 0);
INSERT INTO `lkt_core_menu` VALUES (268, 264, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 9, '2019-10-23 18:14:44', 0);
INSERT INTO `lkt_core_menu` VALUES (269, 160, '卡券', '', '', '', 'coupon', 'Index', 'index.php?module=coupon&action=Index', 100, 2, 0, 0, 0, '2019-11-13 14:40:59', 0);
INSERT INTO `lkt_core_menu` VALUES (270, 269, '优惠券列表', '', '', '', 'coupon', 'Index', 'index.php?module=coupon&action=Index', 100, 3, 0, 0, 0, '2019-11-13 14:42:07', 0);
INSERT INTO `lkt_core_menu` VALUES (271, 269, '优惠券参数', '', '', '', 'coupon', 'Config', 'index.php?module=coupon&action=Config', 100, 3, 0, 0, 0, '2019-11-13 14:42:36', 0);
INSERT INTO `lkt_core_menu` VALUES (272, 270, '添加', '', '', '', 'coupon', 'Add', 'index.php?module=coupon&action=Add', 100, 4, 0, 0, 0, '2019-11-13 14:43:02', 0);
INSERT INTO `lkt_core_menu` VALUES (273, 270, '查看', '', '', '', 'coupon', 'Coupon', 'index.php?module=coupon&action=Coupon', 100, 4, 0, 0, 0, '2019-11-13 14:44:25', 0);
INSERT INTO `lkt_core_menu` VALUES (274, 270, '编辑', '', '', '', 'coupon', 'Modify', 'index.php?module=coupon&action=Modify', 100, 4, 0, 0, 0, '2019-11-13 14:45:17', 0);
INSERT INTO `lkt_core_menu` VALUES (275, 270, '删除', '', '', '', 'coupon', 'Del', 'index.php?module=coupon&action=Del', 100, 4, 0, 0, 0, '2019-11-13 14:45:43', 0);
INSERT INTO `lkt_core_menu` VALUES (276, 270, '删除优惠券', '', '', '', 'coupon', 'Coupondel', 'index.php?module=coupon&action=Coupondel', 100, 4, 0, 0, 0, '2019-11-13 14:46:30', 0);
INSERT INTO `lkt_core_menu` VALUES (277, 270, '浏览', '', '', '', 'coupon', 'Index', 'index.php?module=coupon&action=Index', 100, 4, 0, 0, 0, '2019-11-13 15:00:50', 0);
INSERT INTO `lkt_core_menu` VALUES (278, 160, '满减', '', '', '', 'subtraction', 'Index', 'index.php?module=subtraction&action=Index', 100, 2, 0, 0, 0, '2019-11-13 15:12:43', 0);
INSERT INTO `lkt_core_menu` VALUES (279, 278, '满减活动', '', '', '', 'subtraction', 'Index', 'index.php?module=subtraction&action=Index', 100, 3, 0, 0, 0, '2019-11-13 16:28:51', 0);
INSERT INTO `lkt_core_menu` VALUES (280, 278, '满减设置', '', '', '', 'subtraction', 'Config', 'index.php?module=subtraction&action=Config', 100, 3, 0, 0, 0, '2019-11-13 16:32:16', 0);
INSERT INTO `lkt_core_menu` VALUES (281, 279, '添加', '', '', '', 'subtraction', 'Add', 'index.php?module=subtraction&action=Add', 100, 4, 0, 0, 0, '2019-11-13 16:37:09', 0);
INSERT INTO `lkt_core_menu` VALUES (282, 279, '编辑', '', '', '', 'subtraction', 'Modify', 'index.php?module=subtraction&action=Modify', 100, 4, 0, 0, 0, '2019-11-13 16:37:43', 0);
INSERT INTO `lkt_core_menu` VALUES (283, 279, '开始/结束', '', '', '', 'subtraction', 'Change', 'index.php?module=subtraction&action=Change', 100, 4, 0, 0, 0, '2019-11-13 16:50:24', 0);
INSERT INTO `lkt_core_menu` VALUES (284, 279, '删除', '', '', '', 'subtraction', 'Del', 'index.php?module=subtraction&action=Del', 100, 4, 0, 0, 0, '2019-11-13 16:51:38', 0);
INSERT INTO `lkt_core_menu` VALUES (285, 279, '满减记录', '', '', '', 'subtraction', 'Record', 'index.php?module=subtraction&action=Record', 100, 4, 0, 0, 0, '2019-11-13 16:52:42', 0);
INSERT INTO `lkt_core_menu` VALUES (286, 279, '删除满减记录', '', '', '', 'subtraction', 'Subtraction_del', 'index.php?module=subtraction&action=Subtraction_del', 100, 4, 0, 0, 0, '2019-11-13 16:57:37', 0);
INSERT INTO `lkt_core_menu` VALUES (287, 279, '浏览', '', '', '', 'subtraction', 'Index', 'index.php?module=subtraction&action=Index', 100, 4, 0, 0, 0, '2019-11-13 16:58:06', 0);
INSERT INTO `lkt_core_menu` VALUES (288, 160, '店铺', '', '', '', 'mch', 'Index', 'index.php?module=mch&action=Index', 100, 2, 0, 0, 0, '2019-11-13 17:02:06', 0);
INSERT INTO `lkt_core_menu` VALUES (289, 288, '店铺', '', '', '', 'mch', 'Index', 'index.php?module=mch&action=Index', 100, 3, 0, 0, 0, '2019-11-13 17:03:00', 0);
INSERT INTO `lkt_core_menu` VALUES (290, 289, '查看', '', '', '', 'mch', 'See', 'index.php?module=mch&action=See', 100, 3, 0, 0, 0, '2019-11-13 17:18:05', 0);
INSERT INTO `lkt_core_menu` VALUES (291, 289, '修改', '', '', '', 'mch', 'Modify', 'index.php?module=mch&action=Modify', 100, 4, 0, 0, 0, '2019-11-13 17:18:14', 0);
INSERT INTO `lkt_core_menu` VALUES (292, 288, '审核列表', '', '', '', 'mch', 'List', 'index.php?module=mch&action=List', 100, 3, 0, 0, 0, '2019-11-13 17:18:22', 0);
INSERT INTO `lkt_core_menu` VALUES (293, 292, '审核', '', '', '', 'mch', 'Examine', 'index.php?module=mch&action=Examine', 100, 4, 0, 0, 0, '2019-11-13 17:18:28', 0);
INSERT INTO `lkt_core_menu` VALUES (294, 288, '多商户设置', '', '', '', 'mch', 'Set', 'index.php?module=mch&action=Set', 100, 3, 0, 0, 0, '2019-11-13 17:18:34', 0);
INSERT INTO `lkt_core_menu` VALUES (295, 288, '商品审核', '', '', '', 'mch', 'Product', 'index.php?module=mch&action=Product', 100, 3, 0, 0, 0, '2019-11-13 17:18:42', 0);
INSERT INTO `lkt_core_menu` VALUES (296, 295, '查看', '', '', '', 'mch', 'Product_see', 'index.php?module=mch&action=Product_see', 100, 4, 0, 0, 0, '2019-11-13 17:10:05', 0);
INSERT INTO `lkt_core_menu` VALUES (297, 295, '通过/拒绝', '', '', '', 'mch', 'Product_shelves', 'index.php?module=mch&action=Product_shelves', 100, 4, 0, 0, 0, '2019-11-13 17:10:39', 0);
INSERT INTO `lkt_core_menu` VALUES (298, 288, '提现审核', '', '', '', 'mch', 'Withdraw', 'index.php?module=mch&action=Withdraw', 100, 3, 0, 0, 0, '2019-11-13 17:11:37', 0);
INSERT INTO `lkt_core_menu` VALUES (299, 298, '通过/拒绝', '', '', '', 'mch', 'Withdraw_examine', 'index.php?module=mch&action=Withdraw_examine', 100, 4, 0, 0, 0, '2019-11-13 17:19:36', 0);
INSERT INTO `lkt_core_menu` VALUES (300, 160, '签到', '', '', '', 'sign', 'Index', 'index.php?module=sign&action=Index', 100, 2, 0, 0, 0, '2019-12-03 16:08:35', 0);
INSERT INTO `lkt_core_menu` VALUES (301, 300, '签到列表', '', '', '', 'sign', 'Index', 'index.php?module=sign&action=Index', 100, 3, 0, 0, 0, '2019-12-03 16:09:38', 0);
INSERT INTO `lkt_core_menu` VALUES (302, 300, '签到设置', '', '', '', 'sign', 'Config', 'index.php?module=sign&action=Config', 100, 3, 0, 0, 0, '2019-12-03 16:10:18', 0);
INSERT INTO `lkt_core_menu` VALUES (303, 301, '详情', '', '', '', 'sign', 'Record', 'index.php?module=sign&action=Record', 100, 4, 0, 0, 0, '2019-12-03 16:10:57', 0);
INSERT INTO `lkt_core_menu` VALUES (304, 301, '删除', '', '', '', 'sign', 'Del', 'index.php?module=sign&action=Del', 100, 4, 0, 0, 0, '2019-12-03 16:11:24', 0);
INSERT INTO `lkt_core_menu` VALUES (305, 301, '浏览', '', '', '', 'sign', 'Index', 'index.php?module=sign&action=Index', 100, 4, 0, 0, 0, '2019-12-03 16:11:50', 0);
INSERT INTO `lkt_core_menu` VALUES (306, 160, '分销', '', '', '', 'distribution', 'Index', 'index.php?module=distribution&action=Index', 100, 2, 0, 0, 0, '2019-12-03 16:14:13', 0);
INSERT INTO `lkt_core_menu` VALUES (307, 306, '分销商管理', '', '', '', 'distribution', 'Index', 'index.php?module=distribution&action=Index', 100, 3, 0, 0, 0, '2019-12-03 16:14:48', 0);
INSERT INTO `lkt_core_menu` VALUES (308, 307, '查看详情', '', '', '', 'distribution', 'See', 'index.php?module=distribution&action=See', 100, 4, 0, 0, 0, '2019-12-03 16:16:00', 0);
INSERT INTO `lkt_core_menu` VALUES (309, 307, '编辑', '', '', '', 'distribution', 'Edit', 'index.php?module=distribution&action=Edit', 100, 4, 0, 0, 0, '2019-12-03 16:16:32', 0);
INSERT INTO `lkt_core_menu` VALUES (310, 307, '查看下级', '', '', '', 'distribution', 'Lower', 'index.php?module=distribution&action=Lower', 100, 4, 0, 0, 0, '2019-12-03 16:17:10', 0);
INSERT INTO `lkt_core_menu` VALUES (311, 307, '浏览', '', '', '', 'distribution', 'Index', 'index.php?module=distribution&action=Index', 100, 4, 0, 0, 0, '2019-12-03 16:17:33', 0);
INSERT INTO `lkt_core_menu` VALUES (312, 307, '删除', '', '', '', 'distribution', 'Del', 'index.php?module=distribution&action=Del', 100, 4, 0, 0, 0, '2019-12-03 16:18:15', 0);
INSERT INTO `lkt_core_menu` VALUES (313, 306, '分销等级', '', '', '', 'distribution', 'Distribution_grade', 'index.php?module=distribution&action=Distribution_grade', 100, 3, 0, 0, 0, '2019-12-03 16:19:07', 0);
INSERT INTO `lkt_core_menu` VALUES (314, 313, '添加分销等级', '', '', '', 'distribution', 'Distribution_add', 'index.php?module=distribution&action=Distribution_add', 100, 4, 0, 0, 0, '2019-12-03 16:19:52', 0);
INSERT INTO `lkt_core_menu` VALUES (315, 313, '上移/下移', '', '', '', 'distribution', 'Move', 'index.php?module=distribution&action=Move', 100, 4, 0, 0, 0, '2019-12-03 16:20:43', 0);
INSERT INTO `lkt_core_menu` VALUES (316, 313, '编辑', '', '', '', 'distribution', 'Distribution_modify', 'index.php?module=distribution&action=Distribution_modify', 100, 4, 0, 0, 0, '2019-12-03 16:21:12', 0);
INSERT INTO `lkt_core_menu` VALUES (317, 313, '删除', '', '', '', 'distribution', 'Distribution_del', 'index.php?module=distribution&action=Distribution_del', 100, 4, 0, 0, 0, '2019-12-03 16:21:42', 0);
INSERT INTO `lkt_core_menu` VALUES (318, 313, '浏览', '', '', '', 'distribution', 'Distribution_grade', 'index.php?module=distribution&action=Distribution_grade', 100, 4, 0, 0, 0, '2019-12-03 16:22:15', 0);
INSERT INTO `lkt_core_menu` VALUES (319, 306, '佣金记录', '', '', '', 'distribution', 'Commission', 'index.php?module=distribution&action=Commission', 100, 3, 0, 0, 0, '2019-12-03 16:23:03', 0);
INSERT INTO `lkt_core_menu` VALUES (320, 306, '提现记录', '', '', '', 'distribution', 'Cash', 'index.php?module=distribution&action=Cash', 100, 3, 0, 0, 0, '2019-12-03 16:23:38', 0);
INSERT INTO `lkt_core_menu` VALUES (321, 320, '通过/拒绝', '', '', '', 'distribution', 'Cash_del', 'index.php?module=distribution&action=Cash_del', 100, 4, 0, 0, 0, '2019-12-03 16:24:55', 0);
INSERT INTO `lkt_core_menu` VALUES (322, 320, '浏览', '', '', '', 'distribution', 'Cash', 'index.php?module=distribution&action=Cash', 100, 4, 0, 0, 0, '2019-12-03 16:25:18', 0);
INSERT INTO `lkt_core_menu` VALUES (323, 306, '分销设置', '', '', '', 'distribution', 'Distribution_config', 'index.php?module=distribution&action=Distribution_config', 100, 3, 0, 0, 0, '2019-12-03 16:25:46', 0);
INSERT INTO `lkt_core_menu` VALUES (324, 160, '拼团', '', '', '', 'go_group', 'Index', 'index.php?module=go_group&action=Index', 100, 2, 0, 0, 0, '2019-12-03 16:27:40', 0);
INSERT INTO `lkt_core_menu` VALUES (325, 324, '拼团活动', '', '', '', 'go_group', 'Index', 'index.php?module=go_group&action=Index', 100, 3, 0, 0, 0, '2019-12-03 16:34:13', 0);
INSERT INTO `lkt_core_menu` VALUES (326, 325, '添加拼团', '', '', '', 'go_group', 'Addproduct', 'index.php?module=go_group&action=Addproduct', 100, 4, 0, 0, 0, '2019-12-03 16:35:17', 0);
INSERT INTO `lkt_core_menu` VALUES (327, 325, '查看详情', '', '', '', 'go_group', 'Canrecord', 'index.php?module=go_group&action=Canrecord', 100, 4, 0, 0, 0, '2019-12-03 16:36:12', 0);
INSERT INTO `lkt_core_menu` VALUES (328, 325, '编辑/查看', '', '', '', 'go_group', 'Modify', 'index.php?module=go_group&action=Modify', 100, 4, 0, 0, 0, '2019-12-03 16:37:44', 0);
INSERT INTO `lkt_core_menu` VALUES (329, 325, '显示/隐藏/开始/停止/复制', '', '', '', 'go_group', 'Member', 'index.php?module=go_group&action=Member', 100, 4, 0, 0, 0, '2019-12-03 16:41:43', 0);
INSERT INTO `lkt_core_menu` VALUES (331, 324, '拼团设置', '', '', '', 'go_group', 'Config', 'index.php?module=go_group&action=Config', 100, 3, 0, 0, 0, '2019-12-03 16:43:17', 0);
INSERT INTO `lkt_core_menu` VALUES (332, 325, '浏览', '', '', '', 'go_group', 'Index', 'index.php?module=go_group&action=Index', 100, 4, 0, 0, 0, '2019-12-03 16:43:52', 0);
INSERT INTO `lkt_core_menu` VALUES (333, 160, '砍价', '', '', '', 'bargain', 'Index', 'index.php?module=bargain&action=Index', 100, 2, 0, 0, 0, '2019-12-03 16:45:45', 0);
INSERT INTO `lkt_core_menu` VALUES (334, 333, '砍价商品', '', '', '', 'bargain', 'Index', 'index.php?module=bargain&action=Index', 100, 3, 0, 0, 0, '2019-12-03 16:46:39', 0);
INSERT INTO `lkt_core_menu` VALUES (335, 334, '添加商品', '', '', '', 'bargain', 'Addpro', 'index.php?module=bargain&action=Addpro', 100, 4, 0, 0, 0, '2019-12-03 16:47:17', 0);
INSERT INTO `lkt_core_menu` VALUES (336, 334, '编辑/查看', '', '', '', 'bargain', 'Modify', 'index.php?module=bargain&action=Modify', 100, 4, 0, 0, 0, '2019-12-03 16:48:01', 0);
INSERT INTO `lkt_core_menu` VALUES (337, 334, '砍价详情', '', '', '', 'bargain', 'Record', 'index.php?module=bargain&action=Record', 100, 4, 0, 0, 0, '2019-12-03 16:48:34', 0);
INSERT INTO `lkt_core_menu` VALUES (338, 334, '开始/删除', '', '', '', 'bargain', 'Member', 'index.php?module=bargain&action=Member', 100, 4, 0, 0, 0, '2019-12-03 16:50:37', 0);
INSERT INTO `lkt_core_menu` VALUES (339, 333, '砍价设置', '', '', '', 'bargain', 'Config', 'index.php?module=bargain&action=Config', 100, 3, 0, 0, 0, '2019-12-03 16:51:20', 0);
INSERT INTO `lkt_core_menu` VALUES (340, 334, '浏览', '', '', '', 'bargain', 'Index', 'index.php?module=bargain&action=Index', 100, 4, 0, 0, 0, '2019-12-03 16:51:43', 0);
INSERT INTO `lkt_core_menu` VALUES (341, 160, '竞拍', '', '', '', 'auction', 'Index', 'index.php?module=auction&action=Index', 100, 2, 0, 0, 0, '2019-12-03 16:55:22', 0);
INSERT INTO `lkt_core_menu` VALUES (342, 341, '竞拍商品', '', '', '', 'auction', 'Index', 'index.php?module=auction&action=Index', 100, 3, 0, 0, 0, '2019-12-03 16:57:42', 0);
INSERT INTO `lkt_core_menu` VALUES (343, 342, '添加', '', '', '', 'auction', 'Add', 'index.php?module=auction&action=Add', 100, 4, 0, 0, 0, '2019-12-03 16:58:19', 0);
INSERT INTO `lkt_core_menu` VALUES (344, 342, '详情', '', '', '', 'auction', 'Record', 'index.php?module=auction&action=Record', 100, 4, 0, 0, 0, '2019-12-03 16:58:56', 0);
INSERT INTO `lkt_core_menu` VALUES (345, 342, '编辑', '', '', '', 'auction', 'Modify', 'index.php?module=auction&action=Modify', 100, 4, 0, 0, 0, '2019-12-03 16:59:28', 0);
INSERT INTO `lkt_core_menu` VALUES (346, 342, '开始/停止/删除', '', '', '', 'auction', 'Change', 'index.php?module=auction&action=Change', 100, 4, 0, 0, 0, '2019-12-03 17:00:24', 0);
INSERT INTO `lkt_core_menu` VALUES (347, 342, '浏览', '', '', '', 'auction', 'Index', 'index.php?module=auction&action=Index', 100, 4, 0, 0, 0, '2019-12-03 17:01:27', 0);
INSERT INTO `lkt_core_menu` VALUES (348, 341, '竞拍设置', '', '', '', 'auction', 'Config', 'index.php?module=auction&action=Config', 100, 3, 0, 0, 0, '2019-12-03 17:01:52', 0);
INSERT INTO `lkt_core_menu` VALUES (349, 160, '积分商城', '', '', '', 'integral', 'Index', 'index.php?module=integral&action=Index', 100, 2, 0, 0, 0, '2019-12-03 17:03:19', 0);
INSERT INTO `lkt_core_menu` VALUES (350, 349, '积分商城', '', '', '', 'integral', 'Index', 'index.php?module=integral&action=Index', 100, 3, 0, 0, 0, '2019-12-03 17:04:45', 0);
INSERT INTO `lkt_core_menu` VALUES (351, 350, '添加/编辑/删除', '', '', '', 'integral', 'Addpro', 'index.php?module=integral&action=Addpro', 100, 4, 0, 0, 0, '2019-12-03 17:06:08', 0);
INSERT INTO `lkt_core_menu` VALUES (352, 350, '浏览', '', '', '', 'integral', 'Index', 'index.php?module=integral&action=Index', 100, 4, 0, 0, 0, '2019-12-03 17:07:07', 0);
INSERT INTO `lkt_core_menu` VALUES (353, 349, '商城设置', '', '', '', 'integral', 'Config', 'index.php?module=integral&action=Config', 100, 3, 0, 0, 0, '2019-12-03 17:07:28', 0);
INSERT INTO `lkt_core_menu` VALUES (354, 160, '秒杀', '', '', '', 'seconds', 'Index', 'index.php?module=seconds&action=Index', 100, 2, 0, 0, 0, '2019-12-03 17:08:27', 0);
INSERT INTO `lkt_core_menu` VALUES (355, 354, '秒杀列表', '', '', '', 'seconds', 'Index', 'index.php?module=seconds&action=Index', 100, 3, 0, 0, 0, '2019-12-03 17:09:26', 0);
INSERT INTO `lkt_core_menu` VALUES (356, 355, '添加/编辑/删除', '', '', '', 'seconds', 'Member', 'index.php?module=seconds&action=Member', 100, 4, 0, 0, 0, '2019-12-03 17:19:02', 0);
INSERT INTO `lkt_core_menu` VALUES (357, 355, '秒杀时段列表', '', '', '', 'seconds', 'Settime', 'index.php?module=seconds&action=Settime', 100, 4, 0, 0, 0, '2019-12-03 17:14:31', 0);
INSERT INTO `lkt_core_menu` VALUES (358, 355, '添加商品', '', '', '', 'seconds', 'Addpro', 'index.php?module=seconds&action=Addpro', 100, 4, 0, 0, 0, '2019-12-03 17:15:34', 0);
INSERT INTO `lkt_core_menu` VALUES (359, 355, '秒杀记录', '', '', '', 'seconds', 'Record', 'index.php?module=seconds&action=Record', 100, 4, 0, 0, 0, '2019-12-03 17:18:20', 0);
INSERT INTO `lkt_core_menu` VALUES (360, 354, '秒杀设置', '', '', '', 'seconds', 'Config', 'index.php?module=seconds&action=Config', 100, 3, 0, 0, 0, '2019-12-03 17:24:35', 0);

SET FOREIGN_KEY_CHECKS = 1;
