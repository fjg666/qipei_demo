-- noinspection SqlNoDataSourceInspectionForFile

/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : lkt_rt

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 17/04/2019 13:42:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_cg_group
-- ----------------------------
DROP TABLE IF EXISTS `admin_cg_group`;
CREATE TABLE `admin_cg_group`  (
  `GroupID` int(11) NOT NULL,
  `G_CName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `G_ParentID` int(11) NULL DEFAULT NULL,
  `G_ShowOrder` int(11) NULL DEFAULT NULL,
  `G_Level` int(11) NULL DEFAULT NULL,
  `G_ChildCount` int(11) NULL DEFAULT NULL,
  `G_Delete` int(11) NULL DEFAULT 0,
  `G_Num` int(11) NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_cg_group
-- ----------------------------
INSERT INTO `admin_cg_group` VALUES (2, '北京市', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3, '天津市', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (4, '河北省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (5, '山西省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (6, '内蒙古自治区', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (7, '辽宁省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (8, '吉林省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (9, '黑龙江省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (10, '上海市', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (11, '江苏省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (12, '浙江省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (13, '安徽省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (14, '福建省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (15, '江西省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (16, '山东省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (17, '河南省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (18, '湖北省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (19, '湖南省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (20, '广东省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (21, '广西省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (22, '海南省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (23, '重庆市', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (24, '四川省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (25, '贵州省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (26, '云南省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (27, '西藏自治区', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (28, '陕西省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (29, '甘肃省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (30, '青海省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (31, '宁夏市', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (32, '新疆省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (33, '台湾省', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (34, '香港特别行政区', 0, 100, 2, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (35, '市辖区', 2, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (36, '县', 2, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (37, '市辖区', 3, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (38, '县', 3, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (39, '石家庄市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (40, '唐山市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (41, '秦皇岛市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (42, '邯郸市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (43, '邢台市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (44, '保定市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (45, '张家口市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (46, '承德市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (47, '沧州市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (48, '廊坊市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (49, '衡水市', 4, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (50, '太原市', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (51, '大同市', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (52, '阳泉市', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (53, '长治市', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (54, '晋城市', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (55, '朔州市', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (56, '忻州地区', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (57, '吕梁地区', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (58, '晋中地区', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (59, '临汾地区', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (60, '运城地区', 5, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (61, '呼和浩特市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (62, '包头市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (63, '乌海市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (64, '赤峰市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (65, '呼伦贝尔市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (66, '兴安盟', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (67, '通辽市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (68, '锡林浩特市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (69, '集宁市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (70, '鄂尔多斯市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (71, '临河市', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (72, '阿尔善左旗', 6, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (73, '沈阳市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (74, '大连市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (75, '鞍山市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (76, '抚顺市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (77, '本溪市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (78, '丹东市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (79, '锦州市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (80, '营口市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (81, '阜新市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (82, '辽阳市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (83, '盘锦市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (84, '铁岭市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (85, '朝阳市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (86, '葫芦岛市', 7, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (87, '长春市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (88, '吉林市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (89, '四平市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (90, '辽源市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (91, '通化市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (92, '白山市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (93, '松原市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (94, '白城市', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (95, '延边自治州', 8, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (96, '哈尔滨市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (97, '齐齐哈尔市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (98, '鸡西市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (99, '鹤岗市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (100, '双鸭山市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (101, '大庆市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (102, '伊春市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (103, '佳木斯市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (104, '七台河市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (105, '牡丹江市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (106, '黑河市', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (107, '绥化地区', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (108, '大兴安岭地区', 9, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (109, '市辖区', 10, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (110, '县', 10, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (111, '南京市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (112, '无锡市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (113, '徐州市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (114, '常州市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (115, '苏州市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (116, '南通市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (117, '连云港市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (118, '淮阴市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (119, '盐城市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (120, '扬州市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (121, '镇江市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (122, '泰州市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (123, '宿迁市', 11, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (124, '杭州市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (125, '宁波市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (126, '温州市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (127, '嘉兴市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (128, '湖州市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (129, '绍兴市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (130, '金华市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (131, '衢州市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (132, '舟山市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (133, '台州市', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (134, '丽水地区', 12, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (135, '合肥市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (136, '芜湖市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (137, '蚌埠市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (138, '淮南市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (139, '马鞍山市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (140, '淮北市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (141, '铜陵市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (142, '安庆市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (143, '黄山市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (144, '滁州市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (145, '阜阳市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (146, '宿州市', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (147, '六安地区', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (148, '宣城地区', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (149, '巢湖地区', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (150, '池州地区', 13, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (151, '福州市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (152, '厦门市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (153, '莆田市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (154, '三明市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (155, '泉州市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (156, '漳州市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (157, '南平市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (158, '龙岩市', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (159, '宁德地区', 14, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (160, '南昌市', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (161, '景德镇市', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (162, '萍乡市', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (163, '九江市', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (164, '新余市', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (165, '赣州市', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (166, '宜春地区', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (167, '上饶地区', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (168, '吉安地区', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (169, '抚州地区', 15, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (170, '济南市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (171, '青岛市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (172, '淄博市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (173, '枣庄市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (174, '东营市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (175, '烟台市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (176, '潍坊市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (177, '济宁市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (178, '泰安市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (179, '威海市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (180, '日照市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (181, '莱芜市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (182, '临沂市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (183, '德州市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (184, '聊城市', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (185, '滨州地区', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (186, '荷泽地区', 16, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (187, '郑州市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (188, '开封市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (189, '洛阳市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (190, '平顶山市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (191, '安阳市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (192, '鹤壁市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (193, '新乡市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (194, '焦作市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (195, '濮阳市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (196, '许昌市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (197, '漯河市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (198, '三门峡市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (199, '南阳市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (200, '商丘市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (201, '信阳市', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (202, '周口地区', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (203, '驻马店地区', 17, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (204, '武汉市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (205, '黄石市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (206, '十堰市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (207, '宜昌市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (208, '襄樊市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (209, '鄂州市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (210, '荆门市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (211, '孝感市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (212, '荆州市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (213, '黄冈市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (214, '咸宁市', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (215, '恩施自治州', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (216, '省直辖县', 18, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (217, '长沙市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (218, '株洲市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (219, '湘潭市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (220, '衡阳市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (221, '邵阳市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (222, '岳阳市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (223, '常德市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (224, '张家界市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (225, '益阳市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (226, '郴州市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (227, '永州市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (228, '怀化市', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (229, '娄底地区', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (230, '湘西自治州', 19, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (231, '广州市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (232, '韶关市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (233, '深圳市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (234, '珠海市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (235, '汕头市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (236, '佛山市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (237, '江门市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (238, '湛江市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (239, '茂名市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (240, '肇庆市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (241, '惠州市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (242, '梅州市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (243, '汕尾市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (244, '河源市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (245, '阳江市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (246, '清远市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (247, '东莞市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (248, '中山市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (249, '潮州市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (250, '揭阳市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (251, '云浮市', 20, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (252, '南宁市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (253, '柳州市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (254, '桂林市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (255, '梧州市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (256, '北海市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (257, '防城港市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (258, '钦州市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (259, '贵港市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (260, '玉林市', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (261, '南宁地区', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (262, '柳州地区', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (263, '贺州地区', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (264, '百色地区', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (265, '河池地区', 21, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (266, '海口市', 22, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (267, '三亚市', 22, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (268, '市辖区', 23, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (269, '县', 23, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (270, '市', 23, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (271, '成都市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (272, '自贡市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (273, '攀枝花市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (274, '泸州市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (275, '德阳市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (276, '绵阳市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (277, '广元市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (278, '遂宁市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (279, '内江市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (280, '乐山市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (281, '南充市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (282, '宜宾市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (283, '广安市', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (284, '达川地区', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (285, '雅安地区', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (286, '阿坝藏族羌族自治州', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (287, '甘孜藏族自治州', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (288, '凉山彝族自治州', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (289, '巴中地区', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (290, '眉山地区', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (291, '资阳地区', 24, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (292, '贵阳市', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (293, '六盘水市', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (294, '遵义市', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (295, '铜仁地区', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (296, '黔西南布依族苗族自治州', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (297, '毕节地区', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (298, '安顺地区', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (299, '黔东南苗族侗族自治州', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (300, '黔南布依族苗族自治州', 25, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (301, '昆明市', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (302, '曲靖市', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (303, '玉溪市', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (304, '昭通地区', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (305, '楚雄彝族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (306, '红河哈尼族彝族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (307, '文山壮族苗族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (308, '思茅地区', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (309, '西双版纳傣族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (310, '大理白族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (311, '保山地区', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (312, '德宏傣族景颇族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (313, '丽江地区', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (314, '怒江傈僳族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (315, '迪庆藏族自治州', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (316, '临沧地区', 26, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (317, '拉萨市', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (318, '昌都地区', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (319, '山南地区', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (320, '日喀则地区', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (321, '那曲地区', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (322, '阿里地区', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (323, '林芝地区', 27, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (324, '西安市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (325, '铜川市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (326, '宝鸡市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (327, '咸阳市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (328, '渭南市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (329, '延安市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (330, '汉中市', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (331, '安康地区', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (332, '商洛地区', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (333, '榆林地区', 28, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (334, '兰州市', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (335, '嘉峪关市', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (336, '金昌市', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (337, '白银市', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (338, '天水市', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (339, '酒泉地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (340, '张掖地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (341, '武威地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (342, '定西地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (343, '陇南地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (344, '平凉地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (345, '庆阳地区', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (346, '临夏回族自治州', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (347, '甘南藏族自治州', 29, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (348, '西宁市', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (349, '海东地区', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (350, '海北藏族自治州', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (351, '黄南藏族自治州', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (352, '海南藏族自治州', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (353, '果洛藏族自治州', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (354, '玉树藏族自治州', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (355, '海西蒙古族藏族自治州', 30, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (356, '银川市', 31, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (357, '石嘴山市', 31, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (358, '吴忠市', 31, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (359, '固原地区', 31, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (360, '乌鲁木齐市', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (361, '克拉玛依市', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (362, '吐鲁番地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (363, '哈密地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (364, '昌吉回族自治州', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (365, '博尔塔拉蒙古自治州', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (366, '巴音郭楞蒙古族自治州', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (367, '阿克苏地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (368, '克孜勒苏柯尔克孜自治州', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (369, '喀什地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (370, '和田地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (371, '伊犁哈萨克自治州', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (372, '伊犁地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (373, '塔城地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (374, '阿勒泰地区', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (375, '直辖行政单位', 32, 100, 3, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (376, '东城区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (377, '西城区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (378, '崇文区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (379, '宣武区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (380, '朝阳区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (381, '丰台区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (382, '石景山区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (383, '海淀区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (384, '门头沟区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (385, '房山区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (386, '通州区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (387, '顺义区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (388, '昌平区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (389, '大兴区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (390, '平谷区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (391, '怀柔区', 35, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (392, '密云县', 36, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (393, '延庆县', 36, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (394, '和平区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (395, '河东区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (396, '河西区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (397, '南开区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (398, '河北区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (399, '红桥区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (400, '塘沽区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (401, '汉沽区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (402, '大港区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (403, '东丽区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (404, '西青区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (405, '津南区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (406, '北辰区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (407, '武清区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (408, '宝坻区', 37, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (409, '宁河县', 38, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (410, '静海县', 38, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (411, '蓟县', 38, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (413, '长安区', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (414, '桥东区', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (415, '桥西区', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (416, '新华区', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (417, '郊区', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (418, '井陉矿区', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (419, '井陉县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (420, '正定县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (421, '栾城县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (422, '行唐县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (423, '灵寿县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (424, '高邑县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (425, '沈泽县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (426, '赞皇县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (427, '无极县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (428, '平山县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (429, '元氏县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (430, '赵县', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (431, '辛集市', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (432, '藁城市', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (433, '晋州市', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (434, '新乐市', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (435, '鹿泉市', 39, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (437, '路南区', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (438, '路北区', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (439, '古冶区', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (440, '开平区', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (441, '新区', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (442, '丰润县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (443, '滦县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (444, '滦南县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (445, '乐亭县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (446, '迁西县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (447, '玉田县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (448, '唐海县', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (449, '遵化市', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (450, '丰南市', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (451, '迁安市', 40, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (453, '海港区', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (454, '山海关区', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (455, '北戴河区', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (456, '青龙满族自治县', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (457, '昌黎县', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (458, '抚宁县', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (459, '卢龙县', 41, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (461, '邯山区', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (462, '丛台区', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (463, '复兴区', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (464, '峰峰矿区', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (465, '邯郸县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (466, '临漳县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (467, '成安县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (468, '大名县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (469, '涉县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (470, '磁县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (471, '肥乡县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (472, '永年县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (473, '邱县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (474, '鸡泽县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (475, '广平县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (476, '馆陶县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (477, '魏县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (478, '曲周县', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (479, '武安市', 42, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (481, '桥东区', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (482, '桥西区', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (483, '邢台县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (484, '临城县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (485, '内丘县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (486, '柏乡县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (487, '隆尧县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (488, '任县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (489, '南和县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (490, '宁晋县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (491, '巨鹿县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (492, '新河县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (493, '广宗县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (494, '平乡县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (495, '威县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (496, '清河县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (497, '临西县', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (498, '南宫市', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (499, '沙河市', 43, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (501, '新市区', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (502, '北市区', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (503, '南市区', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (504, '满城县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (505, '清苑县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (506, '涞水县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (507, '阜平县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (508, '徐水县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (509, '定兴县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (510, '唐县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (511, '高阳县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (512, '容城县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (513, '涞源县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (514, '望都县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (515, '安新县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (516, '易县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (517, '曲阳县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (518, '蠡县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (519, '顺平县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (520, '博野县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (521, '雄县', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (522, '涿州市', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (523, '定州市', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (524, '安国市', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (525, '高碑店市', 44, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (527, '桥东区', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (528, '桥西区', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (529, '宣化区', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (530, '下花园区', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (531, '宣化县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (532, '张北县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (533, '康保县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (534, '沽原县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (535, '尚义县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (536, '蔚县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (537, '阳原县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (538, '怀安县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (539, '万全县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (540, '怀来县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (541, '涿鹿县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (542, '赤城县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (543, '崇礼县', 45, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (545, '双桥区', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (546, '双滦区', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (547, '鹰手营子矿区', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (548, '承德县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (549, '兴隆县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (550, '平泉县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (551, '滦平县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (552, '隆化县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (553, '丰宁满族自治县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (554, '宽城满族自治县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (555, '围场满族蒙古族自治县', 46, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (557, '市区', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (558, '运河区', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (559, '沧县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (560, '青县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (561, '东光县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (562, '海兴县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (563, '盐山县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (564, '肃宁县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (565, '南皮县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (566, '吴桥县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (567, '献县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (568, '孟村回族自治县', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (569, '泊头市', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (570, '任丘市', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (571, '黄骅市', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (572, '河间市', 47, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (574, '安次区', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (575, '固安县', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (576, '永清县', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (577, '香河县', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (578, '大城县', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (579, '文安县', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (580, '大厂回族自治县', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (581, '霸州市', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (582, '三河市', 48, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (584, '桃城区', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (585, '枣强县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (586, '武邑县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (587, '武强县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (588, '饶阳县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (589, '安平县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (590, '故城县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (591, '景县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (592, '阜城县', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (593, '冀州市', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (594, '深州市', 49, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (596, '小店区', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (597, '迎泽区', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (598, '杏花岭区', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (599, '尖草坪区', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (600, '万柏林区', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (601, '晋源区', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (602, '清徐县', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (603, '阳曲县', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (604, '娄烦县', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (605, '古交市', 50, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (607, '城区', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (608, '矿区', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (609, '南郊区', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (610, '新荣区', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (611, '阳高县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (612, '天镇县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (613, '广灵县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (614, '灵丘县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (615, '浑源县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (616, '左云县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (617, '大同县', 51, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (619, '城区', 52, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (620, '矿区', 52, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (621, '郊区', 52, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (622, '平定县', 52, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (623, '盂县', 52, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (625, '城区', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (626, '郊区', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (627, '长治县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (628, '襄垣县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (629, '屯留县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (630, '平顺县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (631, '黎城县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (632, '壶关县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (633, '长子县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (634, '武乡县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (635, '沁县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (636, '沁源县', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (637, '潞城市', 53, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (639, '城区', 54, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (640, '沁水县', 54, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (641, '阳城县', 54, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (642, '陵川县', 54, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (643, '泽州县', 54, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (644, '高平市', 54, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (646, '朔城区', 55, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (647, '平鲁区', 55, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (648, '山阴县', 55, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (649, '应县', 55, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (650, '右玉县', 55, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (651, '怀仁县', 55, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (652, '忻州市', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (653, '原平市', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (654, '定襄县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (655, '五台县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (656, '代县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (657, '繁峙县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (658, '宁武县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (659, '静乐县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (660, '神池县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (661, '五寨县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (662, '苛岚县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (663, '河曲县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (664, '保德县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (665, '偏关县', 56, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (666, '孝义市', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (667, '离石市', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (668, '汾阳市', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (669, '文水市', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (670, '交城县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (671, '兴县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (672, '临县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (673, '柳林县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (674, '石楼县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (675, '岚县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (676, '方山县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (677, '中阳县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (678, '交口县', 57, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (679, '榆次市', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (680, '介休市', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (681, '榆社县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (682, '左权县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (683, '和顺县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (684, '昔阳县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (685, '寿阳县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (686, '太谷县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (687, '祁县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (688, '平遥县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (689, '灵石县', 58, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (690, '临汾市', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (691, '侯马市', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (692, '霍州市', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (693, '曲沃县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (694, '翼城县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (695, '襄汾县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (696, '洪洞县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (697, '古县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (698, '安泽县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (699, '浮山县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (700, '吉县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (701, '乡宁县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (702, '浦县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (703, '大宁县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (704, '永和县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (705, '隰县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (706, '汾西县', 59, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (707, '运城市', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (708, '永济市', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (709, '河津市', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (710, '芮城县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (711, '临猗县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (712, '万荣县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (713, '新绛县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (714, '稷山县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (715, '闻喜县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (716, '夏县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (717, '绛县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (718, '平陆县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (719, '垣曲县', 60, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (721, '新城区', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (722, '回民区', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (723, '玉泉区', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (724, '赛罕区', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (725, '土默特左旗', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (726, '托克托县', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (727, '和林格尔县', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (728, '清水河县', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (729, '武川县', 61, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (731, '东河区', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (732, '昆都伦区', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (733, '青山区', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (734, '石拐矿区', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (735, '白云矿区', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (736, '九原区', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (737, '土默特右旗', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (738, '固阳县', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (739, '达尔罕茂明安联合旗', 62, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (741, '海勃湾区', 63, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (742, '海南区', 63, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (743, '乌达区', 63, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (745, '红山区', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (746, '元宝山区', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (747, '松山区', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (748, '阿鲁科尔沁旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (749, '巴林左旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (750, '巴林右旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (751, '林西县', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (752, '克什克腾旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (753, '翁牛特旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (754, '喀喇沁旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (755, '宁城县', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (756, '敖汉旗', 64, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (757, '海拉尔市', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (758, '满洲里市', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (759, '扎兰屯市', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (760, '牙克石市', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (761, '根河市', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (762, '额尔古纳市', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (763, '阿荣旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (764, '莫力达瓦达斡尔族自治旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (765, '鄂伦春自治旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (766, '鄂温克族自治旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (767, '新巴尔虎右旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (768, '新巴尔虎左旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (769, '陈巴尔虎旗', 65, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (770, '乌兰浩特市', 66, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (771, '阿尔山市', 66, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (772, '科尔沁右翼前旗', 66, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (773, '科尔沁右翼中旗', 66, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (774, '扎赉特旗', 66, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (775, '突泉县', 66, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (776, '通辽市', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (777, '科尔沁区', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (778, '科尔沁左翼中旗', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (779, '科尔沁左翼后旗', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (780, '开鲁县', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (781, '库伦旗', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (782, '奈曼旗', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (783, '扎鲁特旗', 67, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (784, '二连浩特市', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (785, '锡林浩特市', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (786, '阿巴嘎旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (787, '苏尼特左旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (788, '苏尼特右旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (789, '东乌珠穆沁旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (790, '西乌珠穆沁旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (791, '太仆寺旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (792, '镶黄旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (793, '正镶白旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (794, '正蓝旗', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (795, '多伦县', 68, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (796, '集宁市', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (797, '丰镇市', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (798, '卓资县', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (799, '化德县', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (800, '商都县', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (801, '兴和县', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (802, '凉城县', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (803, '察哈尔右翼前旗', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (804, '察哈尔右翼中旗', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (805, '察哈尔右翼后旗', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (806, '四子王旗', 69, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (807, '东胜市', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (808, '达拉特旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (809, '准格尔旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (810, '鄂托克前旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (811, '鄂托克旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (812, '杭锦旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (813, '乌审旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (814, '伊金霍洛旗', 70, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (815, '临河市', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (816, '五原县', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (817, '磴口县', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (818, '乌拉特前旗', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (819, '乌拉特中旗', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (820, '乌拉特后旗', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (821, '杭锦后旗', 71, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (822, '阿拉善左旗', 72, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (823, '阿拉善右旗', 72, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (824, '额济纳旗', 72, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (826, '和平区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (827, '沈河区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (828, '大东区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (829, '皇姑区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (830, '铁西区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (831, '苏家屯区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (832, '东陵区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (833, '新城子区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (834, '于洪区', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (835, '辽中县', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (836, '康平县', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (837, '法库县', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (838, '新民市', 73, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (840, '中山区', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (841, '西岗区', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (842, '沙河口区', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (843, '甘井子区', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (844, '旅顺口区', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (845, '金州区', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (846, '长海县', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (847, '瓦房店市', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (848, '普兰店市', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (849, '庄河市', 74, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (851, '铁东区', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (852, '铁西区', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (853, '立山区', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (854, '千山区', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (855, '台安县', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (856, '岫岩满族自治县', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (857, '海城市', 75, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (859, '新抚区', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (860, '露天区', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (861, '望花区', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (862, '顺城区', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (863, '抚顺县', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (864, '新宾满族自治区', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (865, '清原满族自治区', 76, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (867, '平山区', 77, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (868, '溪湖区', 77, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (869, '明山区', 77, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (870, '南芬区', 77, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (871, '本溪满族自治县', 77, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (872, '桓仁满族自治县', 77, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (874, '元宝区', 78, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (875, '振兴区', 78, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (876, '振安区', 78, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (877, '宽甸满族自治县', 78, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (878, '东港市', 78, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (879, '凤城市', 78, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (881, '古塔区', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (882, '凌河区', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (883, '太河区', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (884, '黑山县', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (885, '义县', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (886, '凌海市', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (887, '北宁市', 79, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (889, '站前区', 80, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (890, '西市区', 80, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (891, '鲅鱼圈区', 80, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (892, '老边区', 80, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (893, '盖州市', 80, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (894, '大石桥市', 80, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (896, '海州区', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (897, '新邱区', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (898, '太平区', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (899, '清河门区', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (900, '细河区', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (901, '阜新蒙古族自治县', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (902, '彰武县', 81, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (904, '白塔区', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (905, '文圣区', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (906, '宏伟区', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (907, '弓长岭区', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (908, '太子河区', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (909, '辽阳县', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (910, '灯塔市', 82, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (912, '双台子区', 83, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (913, '兴隆台区', 83, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (914, '大洼县', 83, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (915, '盘山县', 83, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (917, '银州区', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (918, '清河区', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (919, '铁岭县', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (920, '西丰县', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (921, '昌图县', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (922, '铁法市', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (923, '开原市', 84, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (925, '双塔区', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (926, '龙城区', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (927, '朝阳县', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (928, '建平县', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (929, '喀喇沁左翼蒙古族自治县', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (930, '北票市', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (931, '凌源市', 85, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (933, '连山区', 86, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (934, '龙港区', 86, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (935, '南票区', 86, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (936, '绥中县', 86, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (937, '建昌县', 86, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (938, '兴城市', 86, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (940, '南关区', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (941, '宽城区', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (942, '朝阳区', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (943, '二道区', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (944, '绿园区', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (945, '双阳区', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (946, '农安县', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (947, '九台市', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (948, '榆树市', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (949, '德惠市', 87, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (951, '昌邑区', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (952, '龙潭区', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (953, '船营区', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (954, '丰满区', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (955, '永吉县', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (956, '蛟河市', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (957, '桦甸市', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (958, '舒兰市', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (959, '磐石市', 88, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (961, '铁西区', 89, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (962, '铁东区', 89, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (963, '梨树县', 89, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (964, '伊通满族自治县', 89, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (965, '公主岭市', 89, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (966, '双辽市', 89, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (968, '龙山区', 90, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (969, '西安区', 90, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (970, '东丰县', 90, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (971, '东辽县', 90, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (973, '东昌区', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (974, '二道江区', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (975, '通化县', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (976, '辉南县', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (977, '柳河县', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (978, '梅河口市', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (979, '集安市', 91, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (981, '八道江区', 92, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (982, '抚松县', 92, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (983, '靖宇县', 92, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (984, '长白朝县族自治县', 92, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (985, '江源县', 92, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (986, '临江市', 92, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (988, '宁江区', 93, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (989, '前郭尔罗斯蒙古族自治县', 93, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (990, '长岭县', 93, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (991, '乾安县', 93, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (992, '扶余县', 93, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (994, '洮北区', 94, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (995, '镇赉县', 94, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (996, '通榆县', 94, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (997, '洮南市', 94, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (998, '大安市', 94, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (999, '延吉市', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1000, '图们市', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1001, '敦化市', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1002, '珲春市', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1003, '龙井市', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1004, '和龙市', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1005, '汪清县', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1006, '安图县', 95, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1008, '道里区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1009, '南岗区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1010, '道外区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1011, '太平区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1012, '香坊区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1013, '动力区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1014, '平房区', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1015, '呼兰县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1016, '依兰县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1017, '方正县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1018, '宾县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1019, '巴彦县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1020, '木兰县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1021, '通河县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1022, '延寿县', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1023, '阿城市', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1024, '双城市', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1025, '尚志市', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1026, '五常市', 96, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1028, '龙沙区', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1029, '建华区', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1030, '铁峰区', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1031, '昂昂溪区', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1032, '富拉尔基区', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1033, '碾子山区', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1034, '梅里斯达斡尔族', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1035, '龙江县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1036, '依安县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1037, '泰来县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1038, '甘南县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1039, '富裕县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1040, '克山县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1041, '克东县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1042, '拜泉县', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1043, '讷河市', 97, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1045, '鸡冠区', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1046, '恒山区', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1047, '滴道区', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1048, '梨树区', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1049, '城子河区', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1050, '麻山区', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1051, '鸡东县', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1052, '虎林市', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1053, '密山市', 98, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1055, '向阳区', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1056, '工农区', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1057, '南山区', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1058, '兴安区', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1059, '东山区', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1060, '兴山区', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1061, '萝北县', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1062, '绥宾县', 99, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1064, '尖山区', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1065, '岭东区', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1066, '四方台区', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1067, '宝山区', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1068, '集贤县', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1069, '友谊县', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1070, '宝清县', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1071, '饶河县', 100, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1073, '萨尔图区', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1074, '龙凤区', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1075, '让胡路区', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1076, '红岗区', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1077, '大同区', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1078, '肇州县', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1079, '肇源县', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1080, '林甸县', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1081, '杜尔伯特蒙古族自治县', 101, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1083, '伊春区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1084, '南岔区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1085, '友好区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1086, '西林区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1087, '翠峦区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1088, '新青区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1089, '美溪区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1090, '金山屯区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1091, '五营区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1092, '乌马河区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1093, '汤旺河区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1094, '带岭区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1095, '乌伊岭区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1096, '红星区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1097, '上甘岭区', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1098, '嘉阴县', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1099, '铁力市', 102, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1101, '永红区', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1102, '向阳区', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1103, '前进区', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1104, '东风区', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1105, '郊区', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1106, '桦南县', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1107, '桦川县', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1108, '汤原县', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1109, '抚远县', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1110, '同江市', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1111, '富锦市', 103, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1113, '新兴区', 104, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1114, '桃山区', 104, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1115, '茄子河区', 104, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1116, '勃利县', 104, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1118, '东安区', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1119, '阳明区', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1120, '爱民区', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1121, '西安区', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1122, '东宁县', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1123, '林口县', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1124, '绥芬河市', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1125, '海林市', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1126, '宁安市', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1127, '穆棱市', 105, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1129, '爱辉区', 106, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1130, '嫩江县', 106, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1131, '逊克县', 106, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1132, '孙吴县', 106, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1133, '北安市', 106, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1134, '五大连池市', 106, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1135, '绥化市', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1136, '安达市', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1137, '肇东市', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1138, '海伦市', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1139, '望奎县', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1140, '兰西县', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1141, '青冈县', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1142, '庆安县', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1143, '明水县', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1144, '绥棱县', 107, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1145, '呼玛县', 108, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1146, '塔河县', 108, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1147, '漠河县', 108, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1148, '黄浦区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1149, '卢湾区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1150, '徐汇区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1151, '长宁区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1152, '静安区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1153, '普陀区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1154, '闸北区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1155, '虹口区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1156, '杨浦区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1157, '闵行区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1158, '宝山区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1159, '嘉定区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1160, '浦东新区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1161, '金山区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1162, '松江区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1163, '南汇区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1164, '奉贤区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1165, '青浦区', 109, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1166, '崇明县', 110, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1168, '玄武区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1169, '白下区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1170, '秦淮区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1171, '建邺区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1172, '鼓楼区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1173, '下关区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1174, '浦口区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1175, '大厂区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1176, '栖霞区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1177, '雨花台区', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1178, '江宁县', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1179, '江浦县', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1180, '六合县', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1181, '溧水县', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1182, '高淳县', 111, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1184, '崇安区', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1185, '南长区', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1186, '北塘区', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1187, '郊区', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1188, '马山区', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1189, '江阴市', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1190, '宜兴市', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1191, '锡山市', 112, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1193, '鼓楼区', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1194, '云龙区', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1195, '九里区', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1196, '贾汪区', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1197, '泉山区', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1198, '丰县', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1199, '沛县', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1200, '铜山县', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1201, '睢宁县', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1202, '新沂市', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1203, '邳州市', 113, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1205, '天宁区', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1206, '钟楼区', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1207, '戚墅堰区', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1208, '郊区', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1209, '溧阳市', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1210, '金坛市', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1211, '武进市', 114, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1213, '沧浪区', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1214, '平江区', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1215, '金阊区', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1216, '郊区', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1217, '常熟市', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1218, '张家港市', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1219, '昆山市', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1220, '吴江市', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1221, '太仓市', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1222, '吴县市', 115, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1224, '崇川区', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1225, '港闸区', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1226, '海安县', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1227, '如东县', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1228, '启东市', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1229, '如皋市', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1230, '通州市', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1231, '海门市', 116, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1233, '连云区', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1234, '云台区', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1235, '新浦区', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1236, '海州区', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1237, '赣榆县', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1238, '东海县', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1239, '灌云县', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1240, '灌南县', 117, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1242, '清河区', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1243, '清浦区', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1244, '淮阴县', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1245, '涟水县', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1246, '洪泽县', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1247, '盱眙县', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1248, '金湖县', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1249, '淮安市', 118, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1251, '城区', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1252, '响水县', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1253, '滨海县', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1254, '阜宁县', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1255, '射阳县', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1256, '建湖县', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1257, '盐都县', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1258, '东台市', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1259, '大丰市', 119, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1261, '广陵区', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1262, '郊区', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1263, '宝应县', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1264, '邗江县', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1265, '仪征市', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1266, '高邮市', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1267, '江都市', 120, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1269, '东口区', 121, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1270, '润州区', 121, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1271, '丹徒县', 121, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1272, '丹阳市', 121, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1273, '扬中市', 121, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1274, '句容市', 121, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1276, '海陵区', 122, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1277, '高港区', 122, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1278, '兴化市', 122, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1279, '靖江市', 122, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1280, '泰兴市', 122, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1281, '姜堰市', 122, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1283, '宿城区', 123, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1284, '宿豫区', 123, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1285, '沭阳县', 123, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1286, '泗阳县', 123, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1287, '泗洪县', 123, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1289, '上城区', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1290, '下城区', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1291, '江干区', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1292, '拱墅区', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1293, '西湖区', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1294, '滨江区', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1295, '桐庐县', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1296, '淳安县', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1297, '萧山市', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1298, '建德市', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1299, '富阳市', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1300, '余杭市', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1301, '临安市', 124, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1303, '海曙区', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1304, '江东区', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1305, '江北区', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1306, '北仑区', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1307, '镇海区', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1308, '象山县', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1309, '宁海县', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1310, '鄞县', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1311, '余姚市', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1312, '慈溪市', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1313, '奉化市', 125, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1315, '鹿城区', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1316, '龙湾区', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1317, '瓯海区', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1318, '洞头县', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1319, '永嘉县', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1320, '平阳县', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1321, '苍南县', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1322, '文成县', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1323, '泰顺县', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1324, '瑞安市', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1325, '乐清市', 126, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1327, '秀城区', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1328, '郊区', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1329, '嘉善县', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1330, '海盐县', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1331, '海宁市', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1332, '平湖市', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1333, '桐乡市', 127, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1335, '德清县', 128, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1336, '长兴县', 128, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1337, '安吉县', 128, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1339, '越城区', 129, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1340, '绍兴县', 129, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1341, '新昌县', 129, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1342, '诸暨市', 129, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1343, '上虞市', 129, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1344, '嵊州市', 129, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1346, '婺城区', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1347, '金华县', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1348, '武义县', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1349, '浦江县', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1350, '磐安县', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1351, '兰溪市', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1352, '义乌市', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1353, '东阳市', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1354, '永康市', 130, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1356, '柯城区', 131, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1357, '衢县', 131, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1358, '常山县', 131, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1359, '开化县', 131, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1360, '龙游县', 131, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1361, '江山市', 131, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1363, '定海区', 132, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1364, '普陀区', 132, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1365, '岱山县', 132, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1366, '嵊泗县', 132, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1368, '椒江区', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1369, '黄岩区', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1370, '路桥区', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1371, '玉环县', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1372, '三门县', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1373, '天台县', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1374, '仙居县', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1375, '温岭市', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1376, '临海市', 133, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1377, '丽水市', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1378, '龙泉市', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1379, '青田县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1380, '云和县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1381, '庆元县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1382, '缙云县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1383, '遂昌县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1384, '松阳县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1385, '景宁畲族自治县', 134, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1387, '东市区', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1388, '中市区', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1389, '西市区', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1390, '郊区', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1391, '长丰县', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1392, '肥东县', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1393, '肥西县', 135, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1395, '镜湖区', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1396, '马塘区', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1397, '新芜区', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1398, '鸠江区', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1399, '芜湖县', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1400, '繁昌县', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1401, '南陵县', 136, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1403, '东市区', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1404, '中市区', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1405, '西市区', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1406, '郊区', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1407, '怀远县', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1408, '五河县', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1409, '固镇县', 137, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1411, '大通区', 138, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1412, '田家庵区', 138, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1413, '谢家集区', 138, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1414, '八公山区', 138, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1415, '潘集区', 138, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1416, '凤台区', 138, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1418, '金家庄区', 139, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1419, '花山区', 139, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1420, '雨山区', 139, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1421, '向山区', 139, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1422, '当涂县', 139, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1424, '杜集区', 140, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1425, '相山区', 140, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1426, '烈山区', 140, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1427, '濉溪县', 140, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1429, '铜官山区', 141, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1430, '狮子山区', 141, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1431, '郊区', 141, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1432, '铜陵县', 141, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1434, '迎江区', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1435, '大观区', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1436, '郊区', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1437, '怀宁县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1438, '枞阳县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1439, '潜山县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1440, '太湖县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1441, '宿松县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1442, '望江县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1443, '岳西县', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1444, '桐城市', 142, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1446, '屯溪区', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1447, '黄山区', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1448, '徽州区', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1449, '歙县', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1450, '休宁县', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1451, '黟县', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1452, '祁门县', 143, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1454, '琅琊区', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1455, '南谯区', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1456, '来安县', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1457, '全椒县', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1458, '定远县', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1459, '凤阳县', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1460, '天长市', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1461, '明光市', 144, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1463, '颖州区', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1464, '颖东区', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1465, '颖泉区', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1466, '临泉县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1467, '太和县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1468, '涡阳县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1469, '蒙城县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1470, '阜南县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1471, '颖上县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1472, '利辛县', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1473, '亳州市', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1474, '界首市', 145, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1476, '墉桥区', 146, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1477, '砀山县', 146, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1478, '萧县', 146, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1479, '灵璧县', 146, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1480, '泗县', 146, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1481, '六安市', 147, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1482, '寿县', 147, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1483, '霍邱县', 147, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1484, '舒城县', 147, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1485, '金寨县', 147, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1486, '霍山县', 147, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1487, '宣州市', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1488, '宁国市', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1489, '郎溪县', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1490, '广德县', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1491, '泾县', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1492, '旌德县', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1493, '绩溪县', 148, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1494, '巢湖市', 149, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1495, '庐江县', 149, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1496, '无为县', 149, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1497, '含山县', 149, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1498, '和县', 149, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1499, '贵池市', 150, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1500, '东至县', 150, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1501, '石台县', 150, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1502, '青阳县', 150, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1504, '鼓楼区', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1505, '台江区', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1506, '仓山区', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1507, '马尾区', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1508, '晋安区', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1509, '闽侯县', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1510, '连江县', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1511, '罗源县', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1512, '闽清县', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1513, '永泰县', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1514, '平潭县', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1515, '福清市', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1516, '长乐市', 151, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1518, '鼓浪屿区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1519, '思明区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1520, '开元区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1521, '杏林区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1522, '湖里区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1523, '集美区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1524, '同安区', 152, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1526, '城厢区', 153, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1527, '涵江区', 153, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1528, '莆田县', 153, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1529, '仙游县', 153, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1531, '梅列区', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1532, '三元区', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1533, '明溪县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1534, '清流县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1535, '宁化县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1536, '大田县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1537, '尤溪县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1538, '沙县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1539, '将乐县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1540, '泰宁县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1541, '建宁县', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1542, '永安市', 154, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1544, '鲤城区', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1545, '丰泽区', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1546, '洛江区', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1547, '惠安县', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1548, '安溪县', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1549, '永春县', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1550, '德化县', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1551, '金门县', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1552, '石狮市', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1553, '晋江市', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1554, '南安市', 155, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1556, '芗城区', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1557, '龙文区', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1558, '云霄县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1559, '漳浦县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1560, '诏安县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1561, '长泰县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1562, '东山县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1563, '南靖县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1564, '平和县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1565, '华安县', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1566, '龙海市', 156, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1568, '延平区', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1569, '顺昌县', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1570, '浦城县', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1571, '光泽县', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1572, '松溪县', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1573, '政和县', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1574, '邵武市', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1575, '武夷山市', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1576, '建瓯市', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1577, '建阳市', 157, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1579, '新罗区', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1580, '长汀县', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1581, '永定县', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1582, '上杭县', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1583, '武平县', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1584, '连城县', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1585, '漳平市', 158, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1586, '宁德市', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1587, '福安市', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1588, '福鼎市', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1589, '霞浦县', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1590, '古田县', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1591, '屏南县', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1592, '寿宁县', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1593, '周宁县', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1594, '柘荣县', 159, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1596, '东湖区', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1597, '西湖区', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1598, '青云谱区', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1599, '湾里区', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1600, '郊区', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1601, '南昌县', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1602, '新建县', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1603, '安义县', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1604, '进贤县', 160, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1606, '昌江区', 161, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1607, '珠山区', 161, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1608, '浮梁县', 161, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1609, '乐平市', 161, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1611, '安源区', 162, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1612, '湘东区', 162, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1613, '莲花县', 162, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1614, '上栗县', 162, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1615, '芦溪县', 162, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1617, '庐山区', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1618, '浔阳区', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1619, '九江县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1620, '武宁县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1621, '修水县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1622, '永修县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1623, '德安县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1624, '星子县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1625, '都昌县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1626, '湖口县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1627, '彭泽县', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1628, '瑞昌市', 163, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1630, '渝水区', 164, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1631, '分宜县', 164, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1633, '章贡区', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1634, '赣县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1635, '信丰县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1636, '大余县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1637, '上犹县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1638, '崇义县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1639, '安远县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1640, '龙南县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1641, '定南县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1642, '全南县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1643, '宁都县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1644, '于都县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1645, '兴国县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1646, '会昌县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1647, '寻乌县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1648, '石城县', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1649, '瑞金市', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1650, '南康市', 165, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1651, '宜春市', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1652, '丰城市', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1653, '樟树市', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1654, '高安市', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1655, '奉新县', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1656, '万载县', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1657, '上高县', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1658, '宜丰县', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1659, '靖安县', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1660, '铜鼓县', 166, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1661, '上饶市', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1662, '德兴市', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1663, '上饶县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1664, '广丰县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1665, '玉山县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1666, '铅山县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1667, '横峰县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1668, '弋阳县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1669, '余干县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1670, '波阳县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1671, '万年县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1672, '婺源县', 167, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1673, '吉安市', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1674, '井冈山市', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1675, '吉安县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1676, '吉水县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1677, '峡江县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1678, '新干县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1679, '永丰县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1680, '泰和县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1681, '遂川县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1682, '万安县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1683, '安福县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1684, '永新县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1685, '宁冈县', 168, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1686, '临川市', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1687, '南城县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1688, '黎川县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1689, '南丰县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1690, '崇仁县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1691, '乐安县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1692, '宜黄县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1693, '金溪县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1694, '资溪县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1695, '东乡县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1696, '广昌县', 169, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1698, '历下区', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1699, '市中区', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1700, '槐荫区', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1701, '天桥区', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1702, '历城区', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1703, '长清县', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1704, '平阴县', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1705, '济阳县', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1706, '商河县', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1707, '章丘市', 170, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1709, '市南区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1710, '市北区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1711, '四方区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1712, '黄岛区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1713, '崂山区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1714, '李沧区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1715, '城阳区', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1716, '胶州市', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1717, '即墨市', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1718, '平度市', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1719, '胶南市', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1720, '莱西市', 171, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1722, '淄川区', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1723, '张店区', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1724, '博山区', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1725, '临淄区', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1726, '周村区', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1727, '桓台县', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1728, '高青县', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1729, '沂源县', 172, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1731, '市中区', 173, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1732, '薛城区', 173, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1733, '峄城区', 173, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1734, '台儿庄区', 173, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1735, '山亭区', 173, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1736, '滕州市', 173, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1738, '东营区', 174, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1739, '河口区', 174, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1740, '垦利县', 174, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1741, '利津县', 174, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1742, '广饶县', 174, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1744, '芝罘区', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1745, '福山区', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1746, '牟平区', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1747, '莱山区', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1748, '长岛县', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1749, '龙口市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1750, '莱阳市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1751, '莱州市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1752, '蓬莱市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1753, '招远市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1754, '栖霞市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1755, '海阳市', 175, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1757, '潍城区', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1758, '寒亭区', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1759, '坊子区', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1760, '奎文区', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1761, '临朐县', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1762, '昌乐县', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1763, '青州市', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1764, '诸城市', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1765, '寿光市', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1766, '安丘市', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1767, '高密市', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1768, '昌邑市', 176, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1770, '市中区', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1771, '任城区', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1772, '微山县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1773, '鱼台县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1774, '金乡县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1775, '嘉祥县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1776, '汶上县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1777, '泗水县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1778, '梁山县', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1779, '曲阜市', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1780, '兖州市', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1781, '邹城市', 177, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1783, '泰山区', 178, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1784, '郊区', 178, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1785, '宁阳县', 178, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1786, '东平县', 178, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1787, '新泰市', 178, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1788, '肥城市', 178, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1790, '环翠区', 179, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1791, '文登市', 179, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1792, '荣城市', 179, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1793, '乳山市', 179, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1795, '东港区', 180, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1796, '五莲县', 180, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1797, '莒县', 180, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1799, '莱城区', 181, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1800, '钢城区', 181, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1802, '兰山区', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1803, '罗庄区', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1804, '河东区', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1805, '沂南县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1806, '郯城县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1807, '沂水县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1808, '苍山县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1809, '费县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1810, '平邑县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1811, '莒南县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1812, '蒙阴县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1813, '临沭县', 182, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1815, '德城区', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1816, '陵县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1817, '宁津县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1818, '庆云县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1819, '临邑县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1820, '齐河县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1821, '平原县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1822, '夏津县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1823, '武城县', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1824, '乐陵市', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1825, '禹城市', 183, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1827, '东昌府区', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1828, '阳谷县', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1829, '莘县', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1830, '茌平县', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1831, '东阿县', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1832, '冠县', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1833, '高唐县', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1834, '临清市', 184, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1835, '滨州市', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1836, '惠民县', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1837, '阳信县', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1838, '无棣县', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1839, '沾化县', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1840, '博兴县', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1841, '邹平县', 185, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1842, '菏泽市', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1843, '曹县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1844, '定陶县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1845, '成武县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1846, '单县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1847, '巨野县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1848, '郓城县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1849, '鄄城县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1850, '东明县', 186, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1852, '中原区', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1853, '二七区', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1854, '管城回族区', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1855, '金水区', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1856, '上街区', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1857, '邙山区', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1858, '中牟县', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1859, '巩义市', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1860, '荥阳市', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1861, '新密市', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1862, '新郑市', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1863, '登丰市', 187, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1865, '龙亭区', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1866, '顺河回族区', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1867, '鼓楼区', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1868, '南关区', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1869, '郊区', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1870, '杞县', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1871, '通许县', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1872, '尉氏县', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1873, '开封县', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1874, '兰考县', 188, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1876, '老城区', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1877, '西工区', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1878, '壥河回族区', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1879, '涧西区', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1880, '吉利区', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1881, '郊区', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1882, '孟津县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1883, '新安县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1884, '栾川县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1885, '嵩县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1886, '汝阳县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1887, '宜阳县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1888, '洛宁县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1889, '伊川县', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1890, '偃师市', 189, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1892, '新华区', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1893, '卫东区', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1894, '石龙区', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1895, '湛河区', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1896, '宝丰县', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1897, '叶县', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1898, '鲁山县', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1899, '郏县', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1900, '舞钢市', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1901, '汝州市', 190, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1903, '文峰区', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1904, '北关区', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1905, '铁西区', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1906, '郊区', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1907, '安阳县', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1908, '汤阴县', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1909, '滑县', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1910, '内黄县', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1911, '林州市', 191, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1913, '鹤山区', 192, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1914, '山城区', 192, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1915, '郊区', 192, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1916, '浚县', 192, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1917, '淇县', 192, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1919, '红旗区', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1920, '新华区', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1921, '北站区', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1922, '郊区', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1923, '新乡县', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1924, '获嘉县', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1925, '原阳县', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1926, '延津县', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1927, '封丘县', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1928, '长垣县', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1929, '卫辉市', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1930, '辉县市', 193, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1932, '解放区', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1933, '中站区', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1934, '马村区', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1935, '山阳区', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1936, '修武县', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1937, '博爱县', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1938, '武陟县', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1939, '温县', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1940, '济源市', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1941, '沁阳市', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1942, '孟州市', 194, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1944, '市区', 195, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1945, '清丰县', 195, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1946, '南乐县', 195, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1947, '范县', 195, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1948, '台前县', 195, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1949, '濮阳县', 195, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1951, '魏都区', 196, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1952, '许昌县', 196, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1953, '鄢陵县', 196, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1954, '襄城县', 196, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1955, '禹州市', 196, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1956, '长葛市', 196, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1958, '源汇区', 197, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1959, '舞阳县', 197, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1960, '临颍县', 197, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1961, '郾城县', 197, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1963, '湖滨区', 198, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1964, '渑池县', 198, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1965, '陕县', 198, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1966, '卢氏县', 198, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1967, '义马市', 198, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1968, '灵宝市', 198, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1970, '宛城区', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1971, '卧龙区', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1972, '南召县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1973, '方城县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1974, '西峡县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1975, '镇平县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1976, '内乡县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1977, '淅川县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1978, '社旗县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1979, '唐河县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1980, '新野县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1981, '桐柏县', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1982, '邓州市', 199, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1984, '梁园区', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1985, '睢阳区', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1986, '民权县', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1987, '睢县', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1988, '宁陵县', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1989, '柘城县', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1990, '虞城县', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1991, '夏邑县', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1992, '永城市', 200, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1994, '浉河区', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1995, '平桥区', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1996, '罗山县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1997, '光山县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1998, '新县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (1999, '商城县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2000, '固始县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2001, '潢川县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2002, '淮滨县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2003, '息县', 201, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2004, '周口市', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2005, '项城市', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2006, '扶沟县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2007, '西华县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2008, '商水县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2009, '太康县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2010, '鹿邑县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2011, '郸城县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2012, '淮阳县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2013, '沈丘县', 202, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2014, '驻马店市', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2015, '确山县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2016, '泌阳县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2017, '遂平县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2018, '西平县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2019, '上蔡县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2020, '汝南县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2021, '平舆县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2022, '新蔡县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2023, '正阳县', 203, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2025, '江岸区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2026, '江汉区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2027, '硚口区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2028, '汉阳区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2029, '武昌区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2030, '青山区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2031, '洪山区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2032, '东西湖区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2033, '汉南区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2034, '蔡甸区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2035, '江夏区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2036, '黄陂区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2037, '新洲区', 204, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2039, '黄石港区', 205, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2040, '石灰窑区', 205, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2041, '下陆区', 205, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2042, '铁山区', 205, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2043, '阳新县', 205, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2044, '大冶市', 205, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2046, '茅箭区', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2047, '张湾区', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2048, '郧县', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2049, '郧西县', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2050, '竹山县', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2051, '竹溪县', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2052, '房县', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2053, '丹江口市', 206, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2055, '西陵区', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2056, '伍家岗区', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2057, '点军区', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2058, '猇亭区', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2059, '宜昌县', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2060, '远安县', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2061, '兴山县', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2062, '秭归县', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2063, '长阳土家族自治县', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2064, '五峰土家族自治县', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2065, '宜都市', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2066, '当阳市', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2067, '枝江市', 207, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2069, '襄城区', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2070, '樊城区', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2071, '襄阳县', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2072, '南漳县', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2073, '谷城县', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2074, '保康县', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2075, '老河口市', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2076, '枣阳市', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2077, '宜城市', 208, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2079, '梁子湖区', 209, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2080, '华容区', 209, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2081, '鄂城区', 209, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2083, '东宝区', 210, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2084, '京山县', 210, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2085, '沙洋县', 210, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2086, '钟祥县', 210, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2088, '孝南区', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2089, '孝昌县', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2090, '大悟县', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2091, '云梦县', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2092, '应城市', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2093, '安陆市', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2094, '广水市', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2095, '汉川市', 211, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2097, '沙市区', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2098, '荆州区', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2099, '公安县', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2100, '监利县', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2101, '江陵县', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2102, '石首市', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2103, '洪湖市', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2104, '松滋市', 212, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2106, '黄州区', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2107, '团风县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2108, '红安县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2109, '罗田县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2110, '英山县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2111, '浠水县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2112, '蕲春县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2113, '黄梅县', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2114, '麻城市', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2115, '武穴市', 213, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2117, '咸安区', 214, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2118, '嘉鱼县', 214, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2119, '通城县', 214, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2120, '崇阳县', 214, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2121, '通山县', 214, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2122, '赤壁市', 214, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2123, '恩施市', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2124, '利川市', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2125, '建始县', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2126, '巴东县', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2127, '宣恩县', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2128, '咸丰县', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2129, '来凤县', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2130, '鹤峰县', 215, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2131, '随州市', 216, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2132, '仙桃市', 216, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2133, '潜江市', 216, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2134, '天门市', 216, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2135, '神农架林区', 216, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2137, '芙蓉区', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2138, '天心区', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2139, '岳麓区', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2140, '开福区', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2141, '雨花区', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2142, '长沙县', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2143, '望城县', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2144, '宁乡县', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2145, '浏阳市', 217, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2147, '荷塘区', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2148, '芦淞区', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2149, '石峰区', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2150, '天元区', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2151, '株洲县', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2152, '攸县', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2153, '茶陵县', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2154, '炎陵县', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2155, '醴陵市', 218, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2157, '雨湖区', 219, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2158, '岳塘区', 219, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2159, '湘潭县', 219, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2160, '湘乡市', 219, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2161, '韶山市', 219, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2163, '江东区', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2164, '城南区', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2165, '城北区', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2166, '郊区', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2167, '南岳区', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2168, '衡阳县', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2169, '衡南县', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2170, '衡山县', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2171, '衡东县', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2172, '祁东县', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2173, '耒阳市', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2174, '常宁市', 220, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2176, '双清区', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2177, '大祥区', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2178, '北塔区', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2179, '邵东县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2180, '新邵县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2181, '邵阳县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2182, '隆回县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2183, '洞口县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2184, '绥宁县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2185, '新宁县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2186, '城步苗族自治县', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2187, '武冈市', 221, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2189, '岳阳楼区', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2190, '云溪区', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2191, '君山区', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2192, '岳阳县', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2193, '华容县', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2194, '湘阴县', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2195, '平江县', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2196, '汨罗市', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2197, '临湘市', 222, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2199, '武陵区', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2200, '鼎城区', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2201, '安乡县', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2202, '汉寿县', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2203, '澧县', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2204, '临澧县', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2205, '桃源县', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2206, '石门县', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2207, '津市市', 223, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2209, '永定区', 224, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2210, '武陵源区', 224, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2211, '慈利县', 224, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2212, '桑植县', 224, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2214, '资阳区', 225, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2215, '赫山区', 225, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2216, '南县', 225, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2217, '桃江县', 225, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2218, '安化县', 225, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2219, '沅江市', 225, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2221, '北湖区', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2222, '桂阳县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2223, '宜章县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2224, '永兴县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2225, '嘉禾县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2226, '临武县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2227, '汝城县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2228, '桂东县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2229, '安仁县', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2230, '资兴市', 226, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2232, '芝山区', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2233, '冷水滩区', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2234, '祁阳县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2235, '东安县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2236, '双牌县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2237, '道县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2238, '江永县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2239, '宁远县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2240, '蓝山县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2241, '新田县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2242, '江华瑶族自治县', 227, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2244, '鹤城区', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2245, '中方县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2246, '沅陵县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2247, '辰溪县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2248, '溆浦县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2249, '会同县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2250, '麻阳苗族自治县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2251, '新晃侗族自治县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2252, '芷江侗族自治县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2253, '靖州苗族侗族自治县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2254, '通道侗族自治县', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2255, '洪江市', 228, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2256, '娄底市', 229, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2257, '冷水江市', 229, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2258, '涟源市', 229, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2259, '双峰县', 229, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2260, '新化县', 229, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2261, '吉首市', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2262, '泸溪县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2263, '凤凰县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2264, '花垣县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2265, '保靖县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2266, '古丈县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2267, '永顺县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2268, '龙山县', 230, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2270, '东山区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2271, '荔湾区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2272, '越秀区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2273, '海珠区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2274, '天河区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2275, '芳村区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2276, '白云区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2277, '黄埔区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2278, '番禺区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2279, '花都区', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2280, '增城市', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2281, '从化市', 231, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2283, '北江区', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2284, '武江区', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2285, '浈江区', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2286, '曲江县', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2287, '始兴县', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2288, '仁化县', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2289, '翁源县', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2290, '乳源瑶族自治县', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2291, '新丰县', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2292, '乐昌市', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2293, '南雄市', 232, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2295, '罗湖区', 233, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2296, '福田区', 233, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2297, '南山区', 233, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2298, '宝安区', 233, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2299, '龙岗区', 233, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2300, '盐田区', 233, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2301, '金湾区', 234, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2303, '香洲区', 234, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2304, '斗门区', 234, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2306, '潮南区', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2307, '龙湖区', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2308, '金平区', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2309, '南澳县', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2310, '潮阳区', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2311, '澄海区', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2312, '濠江区', 235, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2314, '禅城区', 236, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2315, '顺德区', 236, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2316, '南海区', 236, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2317, '三水区', 236, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2318, '高明区', 236, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2320, '蓬江区', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2321, '江海区', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2322, '台山市', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2323, '新会区', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2324, '开平市', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2325, '鹤山市', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2326, '恩平市', 237, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2328, '赤坎区', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2329, '霞山区', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2330, '坡头区', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2331, '麻章区', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2332, '遂溪县', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2333, '徐闻县', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2334, '廉江市', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2335, '雷州市', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2336, '吴川市', 238, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2337, '茂港区', 239, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2339, '茂南区', 239, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2340, '电白县', 239, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2341, '高州市', 239, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2342, '化州市', 239, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2343, '信宜市', 239, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2345, '端州区', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2346, '鼎湖区', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2347, '广宁县', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2348, '怀集县', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2349, '封开县', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2350, '德庆县', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2351, '高要市', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2352, '四会市', 240, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2354, '惠城区', 241, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2355, '博罗县', 241, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2356, '惠东县', 241, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2357, '龙门县', 241, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2358, '惠阳区', 241, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2360, '梅江区', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2361, '梅县', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2362, '大埔县', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2363, '丰顺县', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2364, '五华县', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2365, '平远县', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2366, '蕉岭县', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2367, '兴宁市', 242, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2369, '城区', 243, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2370, '海丰县', 243, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2371, '陆河县', 243, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2372, '陆丰市', 243, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2374, '源城区', 244, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2375, '紫金县', 244, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2376, '龙川县', 244, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2377, '连平县', 244, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2378, '和平县', 244, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2379, '东源县', 244, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2381, '江城区', 245, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2382, '阳西县', 245, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2383, '阳东县', 245, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2384, '阳春市', 245, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2386, '清城区', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2387, '佛冈县', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2388, '阳山县', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2389, '连山壮族瑶族自治县', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2390, '连山瑶族自治县', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2391, '清新县', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2392, '英德市', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2393, '连州市', 246, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2395, '湘桥区', 249, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2396, '潮安县', 249, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2397, '饶平县', 249, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2399, '榕城区', 250, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2400, '揭东县', 250, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2401, '揭西县', 250, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2402, '惠来县', 250, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2403, '普宁市', 250, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2405, '云城区', 251, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2406, '新兴县', 251, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2407, '郁南县', 251, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2408, '云安县', 251, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2409, '罗定市', 251, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2411, '兴宁区', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2412, '新城区', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2413, '城北区', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2414, '江南区', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2415, '永新区', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2416, '市郊区', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2417, '邕宁县', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2418, '武鸣县', 252, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2420, '城中区', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2421, '鱼峰区', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2422, '柳南区', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2423, '柳北区', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2424, '市郊区', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2425, '柳江县', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2426, '柳城县', 253, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2428, '秀峰区', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2429, '叠彩区', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2430, '象山区', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2431, '七星区', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2432, '雁山区', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2433, '阳朔县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2434, '临桂县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2435, '灵川县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2436, '全州县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2437, '兴安县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2438, '永福县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2439, '灌阳县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2440, '龙胜各族自治县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2441, '资源县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2442, '平乐县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2443, '荔浦县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2444, '恭城瑶族自治县', 254, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2446, '万秀区', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2447, '蝶山区', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2448, '市郊区', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2449, '苍梧县', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2450, '腾县', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2451, '蒙山县', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2452, '岑溪市', 255, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2454, '海城区', 256, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2455, '银海区', 256, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2456, '铁山港区', 256, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2457, '合浦县', 256, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2459, '港口区', 257, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2460, '防城区', 257, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2461, '上思县', 257, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2462, '东兴市', 257, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2464, '钦南区', 258, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2465, '钦北区', 258, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2466, '灵山县', 258, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2467, '浦北县', 258, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2469, '港北区', 259, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2470, '港南区', 259, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2471, '平南县', 259, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2472, '桂平市', 259, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2474, '玉州区', 260, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2475, '容县', 260, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2476, '陆川县', 260, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2477, '博白县', 260, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2478, '兴业县', 260, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2479, '北流市', 260, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2480, '凭祥市', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2481, '横县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2482, '宾阳县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2483, '上林县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2484, '隆安县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2485, '马山县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2486, '扶绥县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2487, '崇左县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2488, '大新县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2489, '天等县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2490, '宁明县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2491, '龙州县', 261, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2492, '合山市', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2493, '鹿寨县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2494, '象州县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2495, '武宣县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2496, '来宾县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2497, '融安县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2498, '三江侗族自治县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2499, '融水苗族自治县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2500, '金秀瑶族自治县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2501, '忻城县', 262, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2502, '贺州市', 263, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2503, '昭平县', 263, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2504, '钟山县', 263, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2505, '富川瑶族自治县', 263, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2506, '百色市', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2507, '田阳县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2508, '田东县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2509, '平果县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2510, '德保县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2511, '靖西县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2512, '那坡县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2513, '凌云县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2514, '乐业县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2515, '田林县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2516, '隆林各族自治县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2517, '西林县', 264, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2518, '河池市', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2519, '宜州市', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2520, '罗城仫佬族自治县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2521, '环江毛南族自治县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2522, '南丹县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2523, '天峨县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2524, '凤山县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2525, '东兰县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2526, '巴马瑶族自治县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2527, '都安瑶族自治县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2528, '大化瑶族自治县', 265, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2529, '琼山区', 266, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2530, '美兰区', 266, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2532, '龙华区', 266, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2533, '秀英区', 266, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2535, '万州区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2536, '涪陵区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2537, '渝中区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2538, '大渡口区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2539, '江北区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2540, '沙坪坝区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2541, '九龙坡区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2542, '南岸区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2543, '北碚区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2544, '万盛区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2545, '双桥区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2546, '渝北区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2547, '巴南区', 268, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2548, '长寿县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2549, '綦江县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2550, '潼南县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2551, '铜梁县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2552, '大足县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2553, '荣昌县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2554, '璧山县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2555, '梁平县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2556, '城口县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2557, '丰都县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2558, '垫江县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2559, '武隆县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2560, '忠县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2561, '开县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2562, '云阳县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2563, '奉节县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2564, '巫山县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2565, '巫溪县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2566, '黔江土家族苗族自治县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2567, '石柱土家族自治县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2568, '秀山土家族苗族自治县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2569, '酉阳土家族苗族自治县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2570, '彭水苗族土家族自治县', 269, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2571, '江津市', 270, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2572, '合川市', 270, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2573, '永川市', 270, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2574, '南川市', 270, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2576, '锦江区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2577, '青羊区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2578, '金牛区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2579, '武侯区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2580, '成华区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2581, '龙泉驿区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2582, '青白江区', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2583, '金堂县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2584, '双流县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2585, '温江县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2586, '郫县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2587, '新都县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2588, '大邑县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2589, '蒲江县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2590, '新津县', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2591, '都江堰市', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2592, '彭州市', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2593, '邛崃市', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2594, '崇州市', 271, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2596, '自流井区', 272, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2597, '恭井区', 272, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2598, '大安区', 272, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2599, '沿滩区', 272, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2600, '荣县', 272, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2601, '富顺县', 272, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2603, '东区', 273, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2604, '西区', 273, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2605, '仁和区', 273, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2606, '米易县', 273, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2607, '盐边县', 273, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2609, '江阳区', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2610, '纳溪区', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2611, '龙马潭区', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2612, '泸县', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2613, '合江县', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2614, '叙永县', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2615, '古蔺县', 274, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2617, '旌阳区', 275, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2618, '中江县', 275, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2619, '罗江县', 275, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2620, '广汉市', 275, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2621, '什邡市', 275, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2622, '绵竹市', 275, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2624, '涪城区', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2625, '游仙区', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2626, '三台县', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2627, '盐亭县', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2628, '安县', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2629, '梓潼县', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2630, '北川县', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2631, '平武县', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2632, '江油市', 276, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2634, '市中区', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2635, '元坝区', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2636, '朝天区', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2637, '旺苍县', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2638, '青川县', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2639, '剑阁县', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2640, '苍溪县', 277, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2642, '市中区', 278, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2643, '蓬溪县', 278, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2644, '射洪县', 278, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2645, '大英县', 278, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2647, '市中区', 279, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2648, '东兴区', 279, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2649, '威远县', 279, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2650, '资中县', 279, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2651, '隆昌县', 279, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2653, '市中区', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2654, '沙湾区', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2655, '五通桥区', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2656, '金口河区', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2657, '犍为县', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2658, '井研县', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2659, '夹江县', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2660, '沐川县', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2661, '峨边彝族自治县', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2662, '马边彝族自治县', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2663, '峨眉山市', 280, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2665, '顺庆区', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2666, '高坪区', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2667, '嘉陵区', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2668, '南部县', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2669, '营山县', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2670, '蓬安县', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2671, '仪陇县', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2672, '西充县', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2673, '阆中市', 281, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2675, '翠屏区', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2676, '宜宾县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2677, '南溪县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2678, '江安县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2679, '长宁县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2680, '高县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2681, '珙县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2682, '筠连县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2683, '兴文县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2684, '屏山县', 282, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2686, '广安区', 283, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2687, '岳池县', 283, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2688, '武胜县', 283, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2689, '邻水县', 283, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2690, '华蓥市', 283, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2691, '达川市', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2692, '万源市', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2693, '达县', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2694, '宣汉县', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2695, '开江县', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2696, '大竹县', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2697, '渠县', 284, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2698, '雅安市', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2699, '名山县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2700, '荥经县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2701, '汉源县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2702, '石棉县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2703, '天全县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2704, '芦山县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2705, '宝兴县', 285, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2706, '汶川县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2707, '理县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2708, '茂县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2709, '松潘县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2710, '九寨沟县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2711, '金川县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2712, '小金县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2713, '黑水县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2714, '马尔康县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2715, '壤塘县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2716, '阿坝县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2717, '若尔盖县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2718, '红原县', 286, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2719, '康定县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2720, '泸定县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2721, '丹巴县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2722, '九龙县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2723, '雅江县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2724, '道孚县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2725, '炉霍县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2726, '甘孜县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2727, '新龙县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2728, '德格县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2729, '白玉县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2730, '石渠县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2731, '色达县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2732, '理塘县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2733, '巴塘县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2734, '乡城县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2735, '稻城县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2736, '得荣县', 287, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2737, '西昌市', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2738, '木里藏族自治县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2739, '盐源县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2740, '德昌县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2741, '会理县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2742, '会东县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2743, '宁南县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2744, '普格县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2745, '布拖县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2746, '金阳县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2747, '昭觉县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2748, '喜德县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2749, '冕宁县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2750, '越西县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2751, '甘洛县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2752, '美姑县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2753, '雷波县', 288, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2754, '巴中市', 289, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2755, '通江县', 289, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2756, '南江县', 289, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2757, '平昌县', 289, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2758, '眉山县', 290, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2759, '仁寿县', 290, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2760, '彭山县', 290, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2761, '洪雅县', 290, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2762, '丹棱县', 290, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2763, '青神县', 290, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2764, '资阳市', 291, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2765, '简阳市', 291, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2766, '安岳县', 291, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2767, '乐至县', 291, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2769, '南明区', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2770, '云岩区', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2771, '花溪区', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2772, '乌当区', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2773, '白云区', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2774, '开阳县', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2775, '息烽县', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2776, '修文县', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2777, '清镇市', 292, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2778, '钟山区', 293, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2779, '盘县特区', 293, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2780, '六枝特区', 293, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2781, '水城县', 293, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2783, '红花岗区', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2784, '遵义县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2785, '桐梓县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2786, '绥阳县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2787, '正阳县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2788, '道真仡佬族苗族自治县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2789, '务川仡佬族苗族自治县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2790, '凤冈县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2791, '湄潭县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2792, '余庆县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2793, '习水县', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2794, '赤水市', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2795, '仁怀市', 294, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2796, '铜仁市', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2797, '江口县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2798, '玉屏侗族自治县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2799, '石阡县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2800, '思南县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2801, '印江土家族苗族自治县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2802, '德江县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2803, '沿河土家族自治县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2804, '松桃苗族自治县', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2805, '万山特区', 295, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2806, '兴义市', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2807, '兴仁县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2808, '普安县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2809, '晴隆县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2810, '贞丰县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2811, '望谟县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2812, '册亨县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2813, '安龙县', 296, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2814, '毕节市', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2815, '大方县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2816, '黔西县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2817, '金沙县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2818, '织金县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2819, '纳雍县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2820, '威宁彝族回族苗族自治县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2821, '赫章县', 297, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2822, '安顺市', 298, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2823, '平坝县', 298, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2824, '普定县', 298, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2825, '关岭布依族苗族自治县', 298, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2826, '镇宁布依族苗族自治县', 298, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2827, '紫云苗族布依族自治县', 298, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2828, '凯里市', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2829, '黄平县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2830, '施秉县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2831, '三穗县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2832, '镇远县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2833, '岑巩县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2834, '天柱县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2835, '锦屏县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2836, '剑河县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2837, '台江县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2838, '黎平县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2839, '榕江县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2840, '从江县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2841, '雷山县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2842, '麻江县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2843, '丹寨县', 299, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2844, '都匀市', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2845, '福泉市', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2846, '荔波县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2847, '贵定县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2848, '瓮安县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2849, '独山县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2850, '平塘县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2851, '罗甸县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2852, '长顺县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2853, '龙里县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2854, '惠水县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2855, '三都水族自治县', 300, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2857, '五华区', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2858, '盘龙区', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2859, '官渡区', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2860, '西山区', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2861, '东川区', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2862, '呈贡县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2863, '晋宁县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2864, '富民县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2865, '宜良县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2866, '石林彝族自治县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2867, '嵩明县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2868, '禄劝彝族苗族自治县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2869, '寻甸回族彝族自治县', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2870, '安宁市', 301, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2872, '麒麟区', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2873, '马龙县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2874, '陆良县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2875, '师宗县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2876, '罗平县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2877, '富源县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2878, '会泽县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2879, '沾益县', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2880, '宣威市', 302, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2882, '红塔区', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2883, '江川县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2884, '澄江县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2885, '通海县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2886, '华宁县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2887, '易门县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2888, '峨山彝族自治县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2889, '新平彝族傣族自治县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2890, '元江哈尼族彝族傣族自治县', 303, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2891, '昭通市', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2892, '鲁甸县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2893, '巧家县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2894, '盐津县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2895, '大关县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2896, '永善县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2897, '绥江县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2898, '镇雄县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2899, '彝良县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2900, '威信县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2901, '水富县', 304, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2902, '楚雄市', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2903, '双柏县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2904, '牟定县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2905, '南华县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2906, '姚安县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2907, '大姚县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2908, '永仁县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2909, '元谋县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2910, '武定县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2911, '禄丰县', 305, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2912, '个旧市', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2913, '开远市', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2914, '蒙自县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2915, '屏边苗族自治县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2916, '建水县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2917, '石屏县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2918, '弥勒县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2919, '泸西县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2920, '元阳县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2921, '红河县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2922, '金平苗族瑶族傣族自治县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2923, '绿春县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2924, '河口瑶族自治县', 306, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2925, '文山县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2926, '砚山县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2927, '西畴县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2928, '麻栗坡县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2929, '马关县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2930, '丘北县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2931, '广南县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2932, '富宁县', 307, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2933, '思茅市', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2934, '普洱哈尼族彝族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2935, '墨江哈尼族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2936, '景东彝族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2937, '景谷傣族彝族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2938, '镇沅彝族哈尼族拉祜族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2939, '江城哈尼族彝族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2940, '孟连傣族拉祜族佤族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2941, '澜沧拉祜族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2942, '西盟佤族自治县', 308, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2943, '景洪市', 309, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2944, '勐海县', 309, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2945, '勐腊县', 309, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2946, '大理市', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2947, '漾濞彝族自治县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2948, '祥云县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2949, '宾川县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2950, '弥渡县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2951, '南涧彝族自治县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2952, '巍山彝族回族自治县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2953, '永平县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2954, '云龙县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2955, '洱源县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2956, '剑川县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2957, '鹤庆县', 310, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2958, '保山市', 311, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2959, '施甸县', 311, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2960, '腾冲县', 311, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2961, '龙陵县', 311, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2962, '昌宁县', 311, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2963, '畹町市', 312, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2964, '瑞丽市', 312, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2965, '潞西市', 312, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2966, '梁河县', 312, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2967, '盈江县', 312, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2968, '陇川县', 312, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2969, '丽江纳西族自治县', 313, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2970, '永胜县', 313, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2971, '华坪县', 313, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2972, '宁蒗彝族自治县', 313, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2973, '泸水县', 314, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2974, '福贡县', 314, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2975, '贡山独龙族怒族自治县', 314, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2976, '兰坪白族普米族自治县', 314, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2977, '中甸县', 315, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2978, '德钦县', 315, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2979, '维西傈僳族自治县', 315, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2980, '临沧县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2981, '凤庆县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2982, '云县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2983, '永德县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2984, '镇康县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2985, '双江拉祜族佤族布朗族傣族自治县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2986, '耿马傣族佤族自治县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2987, '沧源佤族自治县', 316, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2989, '城关区', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2990, '林周县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2991, '当雄县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2992, '尼木县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2993, '曲水县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2994, '堆龙德庆县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2995, '达孜县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2996, '墨竹工卡县', 317, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2997, '昌都县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2998, '江达县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (2999, '贡觉县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3000, '类乌齐县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3001, '丁青县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3002, '察雅县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3003, '八宿县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3004, '左贡县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3005, '芒康县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3006, '洛隆县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3007, '边坝县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3008, '盐井县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3009, '碧土县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3010, '妥坝县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3011, '生达县', 318, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3012, '乃东县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3013, '扎囊县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3014, '贡嘎县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3015, '桑日县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3016, '琼结县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3017, '曲松县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3018, '措美县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3019, '洛扎县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3020, '加查县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3021, '隆子县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3022, '错那县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3023, '浪卡子县', 319, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3024, '日喀则市', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3025, '南木林县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3026, '江孜县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3027, '定日县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3028, '萨迦县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3029, '拉孜县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3030, '昂仁县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3031, '谢通门县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3032, '白朗县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3033, '仁布县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3034, '康马县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3035, '定结县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3036, '仲巴县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3037, '亚东县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3038, '吉隆县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3039, '聂拉木县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3040, '萨嘎县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3041, '岗巴县', 320, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3042, '那曲县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3043, '嘉黎县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3044, '比如县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3045, '聂荣县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3046, '安多县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3047, '申扎县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3048, '索县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3049, '班戈县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3050, '巴青县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3051, '尼玛县', 321, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3052, '普兰县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3053, '札达县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3054, '噶尔县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3055, '日土县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3056, '革吉县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3057, '改则县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3058, '措勤县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3059, '隆格尔县', 322, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3060, '林芝县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3061, '工布江达县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3062, '米林县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3063, '墨脱县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3064, '波密县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3065, '察隅县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3066, '朗县', 323, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3068, '新城区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3069, '碑林区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3070, '莲湖区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3071, '灞桥区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3072, '未央区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3073, '雁塔区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3074, '阎良区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3075, '临潼区', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3076, '长安县', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3077, '蓝田县', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3078, '周至县', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3079, '户县', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3080, '高陵县', 324, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3082, '城区', 325, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3083, '郊区', 325, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3084, '耀县', 325, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3085, '宜君县', 325, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3087, '渭滨区', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3088, '金台区', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3089, '宝鸡县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3090, '凤翔县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3091, '岐山县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3092, '扶风县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3093, '眉县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3094, '陇县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3095, '千阳县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3096, '麟游县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3097, '凤县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3098, '太白县', 326, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3100, '秦都区', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3101, '杨陵区', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3102, '渭城区', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3103, '三原县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3104, '泾阳县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3105, '乾县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3106, '礼泉县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3107, '永寿县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3108, '彬县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3109, '长武县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3110, '旬邑县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3111, '淳化县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3112, '武功县', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3113, '兴平市', 327, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3115, '临渭区', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3116, '华县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3117, '潼关县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3118, '大荔县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3119, '合阳县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3120, '澄城县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3121, '蒲城县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3122, '白水县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3123, '富平县', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3124, '韩城市', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3125, '华阴市', 328, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3127, '宝塔区', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3128, '延长县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3129, '延川县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3130, '子长县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3131, '安塞县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3132, '志丹县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3133, '吴旗县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3134, '甘泉县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3135, '富县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3136, '洛川县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3137, '宜川县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3138, '黄龙县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3139, '黄陵县', 329, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3141, '汉台区', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3142, '南郑县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3143, '城固县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3144, '洋县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3145, '西乡县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3146, '勉县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3147, '宁强县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3148, '略阳县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3149, '镇巴县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3150, '留坝县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3151, '佛坪县', 330, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3152, '安康市', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3153, '汉阴县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3154, '石泉县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3155, '宁陕县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3156, '紫阳县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3157, '岚皋县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3158, '平利县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3159, '镇坪县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3160, '旬阳县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3161, '白河县', 331, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3162, '商州市', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3163, '洛南县', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3164, '丹凤县', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3165, '商南县', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3166, '山阳县', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3167, '镇安县', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3168, '柞水县', 332, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3169, '榆林市', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3170, '神木县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3171, '府谷县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3172, '横山县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3173, '靖边县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3174, '定边县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3175, '绥德县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3176, '米脂县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3177, '佳县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3178, '吴堡县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3179, '清涧县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3180, '子洲县', 333, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3182, '城关区', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3183, '七里河区', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3184, '西固区', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3185, '安宁区', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3186, '红古区', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3187, '永登县', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3188, '皋兰县', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3189, '榆中县', 334, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3192, '金川区', 336, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3193, '永昌县', 336, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3195, '白银区', 337, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3196, '平川区', 337, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3197, '靖远县', 337, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3198, '会宁县', 337, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3199, '景泰县', 337, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3201, '秦城区', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3202, '北道区', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3203, '清水县', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3204, '秦安县', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3205, '甘谷县', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3206, '武山县', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3207, '张家川回族自治县', 338, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3208, '玉门市', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3209, '酒泉市', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3210, '敦煌市', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3211, '金塔县', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3212, '肃北蒙古族自治县', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3213, '阿克塞哈萨克族自治县', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3214, '安西县', 339, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3215, '张掖市', 340, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3216, '肃南裕固族自治县', 340, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3217, '民乐县', 340, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3218, '临泽县', 340, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3219, '高台县', 340, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3220, '山丹县', 340, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3221, '武威市', 341, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3222, '民勤县', 341, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3223, '古浪县', 341, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3224, '天祝藏族自治县', 341, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3225, '定西县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3226, '通渭县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3227, '陇西县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3228, '渭源县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3229, '临洮县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3230, '漳县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3231, '岷县', 342, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3232, '武都县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3233, '宕昌县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3234, '成县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3235, '康县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3236, '文县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3237, '西和县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3238, '礼县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3239, '两当县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3240, '徽县', 343, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3241, '平凉市', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3242, '泾川县', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3243, '灵台县', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3244, '崇信县', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3245, '华亭县', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3246, '庄浪县', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3247, '静宁县', 344, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3248, '西峰市', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3249, '庆阳市', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3250, '环县', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3251, '华池县', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3252, '合水县', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3253, '正宁县', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3254, '宁县', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3255, '镇原县', 345, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3256, '临夏市', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3257, '临夏县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3258, '康乐县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3259, '永靖县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3260, '广河县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3261, '和政县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3262, '东乡族自治县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3263, '积石山保安族东乡族撒拉族自治县', 346, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3264, '合作市', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3265, '临潭县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3266, '卓尼县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3267, '舟曲县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3268, '迭部县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3269, '玛曲县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3270, '碌曲县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3271, '夏河县', 347, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3273, '城东区', 348, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3274, '城中区', 348, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3275, '城西区', 348, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3276, '城北区', 348, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3277, '大通回族土族自治县', 348, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3278, '平安县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3279, '民和回族土族自治县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3280, '乐都县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3281, '湟中县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3282, '湟源县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3283, '互助土族自治县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3284, '化隆回族自治县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3285, '循化撒拉族自治县', 349, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3286, '门源回族自治县', 350, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3287, '祁连县', 350, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3288, '海晏县', 350, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3289, '刚察县', 350, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3290, '同仁县', 351, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3291, '尖扎县', 351, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3292, '泽库县', 351, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3293, '河南蒙古族自治县', 351, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3294, '共和县', 352, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3295, '同德县', 352, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3296, '贵德县', 352, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3297, '兴海县', 352, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3298, '贵南县', 352, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3299, '玛沁县', 353, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3300, '班玛县', 353, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3301, '甘德县', 353, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3302, '达日县', 353, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3303, '久治县', 353, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3304, '玛多县', 353, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3305, '玉树县', 354, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3306, '杂多县', 354, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3307, '称多县', 354, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3308, '治多县', 354, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3309, '囊谦县', 354, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3310, '曲麻莱县', 354, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3311, '格尔木市', 355, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3312, '德令哈市', 355, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3313, '乌兰县', 355, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3314, '都兰县', 355, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3315, '天峻县', 355, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3317, '城区', 356, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3318, '新城区', 356, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3319, '郊区', 356, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3320, '永宁县', 356, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3321, '贺兰县', 356, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3323, '大武口区', 357, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3324, '石嘴山区', 357, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3325, '石炭井区', 357, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3326, '平罗县', 357, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3327, '陶乐县', 357, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3328, '惠农县', 357, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3330, '利通区', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3331, '中卫县', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3332, '中宁县', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3333, '盐池县', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3334, '同心县', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3335, '青铜峡市', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3336, '灵武市', 358, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3337, '固原县', 359, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3338, '海原县', 359, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3339, '西吉县', 359, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3340, '隆德县', 359, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3341, '泾源县', 359, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3342, '彭阳县', 359, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3344, '天山区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3345, '沙依巴克区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3346, '新市区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3347, '水磨沟区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3348, '头屯河区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3349, '南山矿区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3350, '东山区', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3351, '乌鲁木齐县', 360, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3353, '独山子区', 361, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3354, '克拉玛依区', 361, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3355, '白碱滩区', 361, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3356, '乌尔禾区', 361, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3357, '吐鲁番市', 362, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3358, '鄯善县', 362, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3359, '托克逊县', 362, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3360, '哈密市', 363, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3361, '巴里坤哈萨克自治县', 363, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3362, '伊吾县', 363, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3363, '昌吉市', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3364, '阜康市', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3365, '米泉市', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3366, '呼图壁县', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3367, '玛纳斯县', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3368, '奇台县', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3369, '吉木萨尔县', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3370, '木垒哈萨克自治县', 364, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3371, '博乐市', 365, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3372, '精河县', 365, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3373, '温泉县', 365, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3374, '库尔勒市', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3375, '轮台县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3376, '尉犁县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3377, '若羌县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3378, '且末县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3379, '焉耆回族自治县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3380, '和静县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3381, '和硕县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3382, '博湖县', 366, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3383, '阿克苏市', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3384, '温宿县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3385, '库车县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3386, '沙雅县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3387, '新和县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3388, '拜城县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3389, '乌什县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3390, '阿瓦提县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3391, '柯坪县', 367, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3392, '阿图什市', 368, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3393, '阿克陶县', 368, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3394, '阿合奇县', 368, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3395, '乌恰县', 368, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3396, '喀什市', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3397, '疏附县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3398, '疏勒县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3399, '英吉沙县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3400, '泽普县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3401, '莎车县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3402, '叶城县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3403, '麦盖提县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3404, '岳普湖县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3405, '伽师县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3406, '巴楚县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3407, '塔什库尔干塔吉克自治县', 369, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3408, '和田市', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3409, '和田县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3410, '墨玉县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3411, '皮山县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3412, '洛浦县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3413, '策勒县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3414, '于田县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3415, '民丰县', 370, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3416, '奎屯市', 371, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3417, '伊宁市', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3418, '伊宁县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3419, '察布查尔锡伯自治县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3420, '霍城县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3421, '巩留县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3422, '新源县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3423, '昭苏县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3424, '特克斯县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3425, '尼勒克县', 372, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3426, '塔城市', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3427, '乌苏市', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3428, '额敏县', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3429, '沙湾县', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3430, '托里县', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3431, '裕民县', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3432, '和布克塞尔蒙古自治县', 373, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3433, '阿勒泰市', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3434, '布尔津县', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3435, '富蕴县', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3436, '福海县', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3437, '哈巴河县', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3438, '青河县', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3439, '吉木乃县', 374, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3440, '石河子市', 375, 100, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3441, '下关区', 310, 0, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3442, '文殊区', 335, 0, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3443, '乌兰浩特市老城区', 66, 0, 4, 0, 0, 0);
INSERT INTO `admin_cg_group` VALUES (3444, '乌兰浩特市新城区', 66, 0, 4, 0, 0, 0);

-- ----------------------------
-- Table structure for lkt_admin
-- ----------------------------
DROP TABLE IF EXISTS `lkt_admin`;
CREATE TABLE `lkt_admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sid` int(11) NOT NULL DEFAULT 0 COMMENT '上级id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `admin_type` int(11) NULL DEFAULT NULL COMMENT '管理类型',
  `permission` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '许可',
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '角色 ',
  `type` int(11) NULL DEFAULT 0 COMMENT '类型 0:系统管理员 1：客户 2:商城管理员 3:店主',
  `store_id` int(11) NULL DEFAULT 0 COMMENT '商城id',
  `shop_id` int(11) NULL DEFAULT NULL COMMENT '店铺ID',
  `status` int(11) NOT NULL DEFAULT 2 COMMENT '状态 1:禁用 2：启用',
  `portrait` varchar(255) DEFAULT NULL COMMENT '管理员头像',
  `nickname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `birthday` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '生日',
  `sex` int(2) NULL DEFAULT 1 COMMENT '性别（1 男  2 女）',
  `tel` varchar(22) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `token` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '令牌',
  `ip` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登入ip地址',
  `recycle` tinyint(2) NULL DEFAULT NULL COMMENT '回收站 0:不回收 1:回收 ',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `login_num` int(11) NOT NULL DEFAULT 0 COMMENT '登录次数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 52 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_admin
-- ----------------------------

INSERT INTO `lkt_admin` (`id`, `sid`, `name`, `password`, `admin_type`, `permission`, `role`, `type`, `store_id`, `shop_id`, `status`, `portrait`, `nickname`, `birthday`, `sex`, `tel`, `token`, `ip`, `recycle`, `add_date`, `login_num`) VALUES
(1, 0, 'admin', '670b14728ad9902aecba32e22fa4f6bd', 1, '', '1,2', 0, 0, 0, 2, '', '变态细节控！！', '', 1, '18774078193', '3fl18ghpalolal7l804n3h0hr0', '175.10.36.100', 0, '2018-02-03 21:43:10', 0),
(2, 1, 'grsq', '670b14728ad9902aecba32e22fa4f6bd', NULL, '1,2,4,5,7,9,10,11,12,14', '1,2,3,7', 1, 1, 0, 2, NULL, NULL, NULL, 1, '18774078152', 'vs44amj2v3v1ibkkc57ud4j9v0', '175.10.36.100', 0, '2019-01-31 02:59:18', 0);

-- ----------------------------
-- Table structure for lkt_admin_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_admin_record`;
CREATE TABLE `lkt_admin_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NULL DEFAULT 0 COMMENT '商城id',
  `admin_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员账号',
  `event` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '事件',
  `type` tinyint(4) NULL DEFAULT NULL COMMENT '类型 0:登录/退出 1:添加 2:修改 3:删除 4:导出 5:启用/禁用 6:通过/拒绝',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_admin_record
-- ----------------------------

-- ----------------------------
-- Table structure for lkt_agreement
-- ----------------------------
DROP TABLE IF EXISTS `lkt_agreement`;
CREATE TABLE `lkt_agreement`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` char(200) DEFAULT NULL COMMENT '协议名称',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0:注册 1:店铺',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `modify_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '协议表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_agreement
-- ----------------------------
INSERT INTO `lkt_agreement` VALUES (1, 1, 0, '<p><view class=\"title_one\" style=\"white-space: normal; text-align: center;\">来客推客户端用户服务协议</view><view class=\"title_two\" style=\"white-space: normal;\">一、总则</view><view class=\"title_view\" style=\"white-space: normal;\">1.本协议中的【来客推】客户端（包括但不限于现在或未来推出的【来客推】网站产品及各类移动终端上的应用软件，以下简称“来客推”或“本客户端”）的所有权和运营权归湖南壹拾捌号网络技术有限公司（以下简称“壹拾捌号网络”或“我们”）所有。</view><view class=\"title_view\" style=\"white-space: normal;\">2.我们将所有使用壹拾捌号网络来客推客户端提供的服务的自然人称之为“用户”。本客户端原则上仅向自然人提供服务，如非自然人主体申请成为本客户端用户的，需要单独与我们联系申请。本协议就您在使用本客户端服务时的相关事宜做出了详细规定，您需要仔细阅读本协议并接受相关约定，方能成为我们的用户。如您对本协议有任何疑问，可向壹拾捌号网络咨询。如您以其他形式被限制民事行为能力，请在监护人的陪同下阅读本协议，且需要在监护人的参与下方可接受本客户端提供的相关服务。</view><view class=\"title_view\" style=\"white-space: normal;\">3.阅读本协议的过程中，如果您不同意本协议或其中任何条款约定，应立即停止注册程序。当您按照注册页面提示填写信息，阅读并同意本协议，且按步骤完成全部注册程序后，即表示您已充分阅读、理解并接受本协议的全部内容，本协议即构成对双方有约束力的法律文件。</view><view class=\"title_view\" style=\"white-space: normal;\">4.除非本协议另有其他明示规定，新推出的线上产品或服务、增加或强化本服务的任何新功能，均受到本协议的约束。</view><view class=\"title_two\" style=\"white-space: normal;\">二、服务介绍</view><view class=\"title_view\" style=\"white-space: normal;\">1.我们利用本客户端通过互联网为用户提供网络服务。</view><view class=\"title_view\" style=\"white-space: normal;\">2.本客户端的具体内容由我们根据实际情况提供，例如新闻、视频、搜索、图片、新闻群聊等。用户需理解以下内容：来客推仅提供相关的网络服务，除此之外与相关网络服务有关的设备(如个人电脑、手机、及其他与接入互联网或移动网有关的装置)及所需的费用(如为接入互联网而支付的电话费及上网费、为使用移动网而支付的手机费)均应由用户自行负担。</view><view class=\"title_two\" style=\"white-space: normal;\">三、服务的暂停、变更、终止条款</view><view class=\"title_view\" style=\"white-space: normal;\">1.本客户端上的服务标准、服务内容及实现形式，以及能否提供等服务信息随时都有可能发生变动，请随时关注，我们不作特别通知。本客户端显示的信息，可能会有一定的滞后性或差错，对此情形用户明确知悉并理解。</view><view class=\"title_view\" style=\"white-space: normal;\">2.如因系统维护或升级的需要而需暂停网络服务，我们将尽可能事先进行通告。</view><view class=\"title_view\" style=\"white-space: normal;\">3.如发生下列任何一种情形，我们有权单方解除本协议：<br/>(1)用户自愿注销的。<br/>(2)用户违反国家有关法律法规或本客户端管理规定，侵害他人合法权益的。<br/>(3)用户因在本客户端上的不当行为被行政或司法机构查处或制裁的。<br/>(4)用户提供的个人资料不真实的。<br/>(5)用户盗用他人账户、发布违禁信息、骗取他人财物的。<br/>(6)用户传播虚假信息、歪曲事实，经查证属实的。<br/>(7)其他本客户端认为需要终止服务的情况。<br/></view><view class=\"title_view\" style=\"white-space: normal;\">4.用户服务终止后，本客户端仍有以下权利：<br/>(1)用户注销后，有权保留该用户的注册数据及以前的行为记录。<br/>(2)用户注销后，如用户在注销前在本客户端上存在违法或违约的行为，来客推仍可行使本协议所规定的权利。<br/></view><view class=\"title_two\" style=\"white-space: normal;\">四、使用规则</view><view class=\"title_view\" style=\"white-space: normal;\">1.用户在申请使用来客推网络服务时，必须向来客推提供准确的个人资料，如个人资料有任何变动，必须及时更新。</view><view class=\"title_view\" style=\"white-space: normal;\">2.用户有权修改其个人账户中各项可修改信息，自行选择昵称和录入介绍性文字，自行决定是否提供非必填项的内容。</view><view class=\"title_view\" style=\"white-space: normal;\">3.用户不应将其账号、密码转让或出借予他人使用。如用户发现其账号遭他人非法使用，应立即通知来客推。因黑客行为或用户的保管疏忽导致账号、密码遭他人非法使用，来客推不承担任何责任。</view><view class=\"title_view\" style=\"white-space: normal;\">4.用户同意来客推有权在提供网络服务过程中以各种方式投放各种商业性广告或其他任何类型的商业信息，并且用户同意接受来客推通过电子邮件或其他方式向用户发送商品促销或其他相关商业信息。</view><view class=\"title_view\" style=\"white-space: normal;\">5.对于用户通过来客推网络服务(包括但不限于论坛、新闻评论、新闻群聊)上传到来客推网站上可公开获取区域的任何内容，用户同意来客推在全世界范围内具有免费的、永久性的、不可撤销的、非独家的和完全再许可的权利和许可，以使用、复制、修改、改编、出版、翻译、据以创作衍生作品、传播、表演和展示此等内容(整体或部分)，和/或将此等内容编入当前已知的或以后开发的其他任何形式的作品、媒体或技术中。</view><view class=\"title_view\" style=\"white-space: normal;\">6.用户在使用来客推网络服务过程中，必须遵循以下原则：<br/>(1)遵守中国有关的法律和法规。<br/>(2)遵守所有与网络服务有关的网络协议、规定和程序。<br/>(3)不得为任何非法目的而使用网络服务系统。<br/>(4)不得以任何形式使用来客推网络服务侵犯来客推的商业利益，包括并不限于发布非经来客推许可的商业广告。<br/>(5)不得利用来客推网络服务系统进行任何可能对互联网或移动网正常运转造成不利影响的行为。<br/>(6)不得利用来客推提供的网络服务上传、展示或传播任何虚假的、骚扰性的、中伤他人的、辱骂性的、恐吓性的、庸俗淫秽的或其他任何非法的信息资料。<br/>(7)不得侵犯其他任何第三方的专利权、著作权、商标权、名誉权或其他任何合法权益。<br/>(8)不得利用来客推网络服务系统进行任何不利于来客推的行为。<br/></view><view class=\"title_view\" style=\"white-space: normal;\">7.如用户在使用网络服务时违反任何上述规定，来客推或其授权的人有权要求用户改正或直接采取一切必要的措施(包括但不限于更改或删除用户张贴的内容等、暂停或终止用户使用网络服务的权利)以减轻用户不当行为造成的影响。来客推针对某些特定的来客推网络服务的使用通过各种方式(包括但不限于网页公告、电子邮件、短信提醒等)作出的任何声明、通知、警示等内容视为本协议的一部分，用户如使用来客推网络服务，视为用户同意该声明、通知、警示的内容。</view><view class=\"title_two\" style=\"white-space: normal;\">五、新闻群聊评论规则</view><view class=\"title_view\" style=\"white-space: normal;\">1.本协议所称新闻群聊评论服务，是指通过运营网络互动传播技术平台，供用户对本网站传播的各类信息发表评论意见(包括但不限于语音、文字、图片、音频、视频等信息)的服务。用户使用来客推新闻群聊等服务将自觉遵守不得逾越法律法规、社会主义制度、国家利益、公民合法权益、社会公共秩序、道德风尚和信息真实性等七条底线。</view><view class=\"title_view\" style=\"white-space: normal;\">2.用户不得发表下列信息：<br/>(1)反对宪法确定的基本原则的。<br/>(2)危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的。<br/>(3)损害国家荣誉和利益的。<br/>(4)煽动民族仇恨、民族歧视，破坏民族团结。<br/>(5)煽动地域歧视、地域仇恨的。<br/>(6)破坏国家宗教政策，宣扬邪教和迷信的。<br/>(7)散布谣言，扰乱社会秩序、破坏社会稳定的。<br/>(8)散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的。<br/>(9)侮辱或者诽谤他人，侵害他人合法权益的。<br/>(10)对他人进行暴力恐吓、威胁，实施人肉搜索的。<br/>(11)传播他人隐私信息的。<br/>(12)散布污言秽语，损害社会公序良俗的。<br/>(13)侵犯他人知识产权的。<br/>(14)散布商业广告，或类似的商业招揽信息。<br/>(15)使用本网站常用语言文字以外的其他语言文字评论的。<br/>(16)与所评论的信息毫无关系的。<br/>(17)所发表的信息毫无意义的，或刻意使用字符组合以逃避技术审核的。<br/>(18)法律、法规和规章禁止传播的其他信息。<br/></view><view class=\"title_view\" style=\"white-space: normal;\">3.对违反上述承诺的用户，本网站将视情况采取预先警示、拒绝发布、删除跟帖、短期禁止发言直至永久关闭账号等管理措施。对涉嫌违法犯罪的跟帖评论将保存在案、并在接受有关政府部门调查时如实报告。</view><view class=\"title_two\" style=\"white-space: normal;\">六、知识产权</view><view class=\"title_view\" style=\"white-space: normal;\">1.来客推提供的网络服务中包含的任何文本、图片、图形、音频和/或视频资料均受版权、商标和/或其它财产所有权法律的保护，未经相关权利人同意，上述资料均不得在任何媒体直接或间接发布、播放、出于播放或发布目的而改写或再发行，或者被用于其他任何商业目的。</view><view class=\"title_view\" style=\"white-space: normal;\">2.所有这些资料或资料的任何部分仅可作为私人和非商业用途而保存在某台计算机或移动终端内。来客推不对上述资料产生或在传送或递交全部或部分上述资料过程中产生的延误、不准确、错误和遗漏或从中产生或由此产生的任何损害赔偿，以任何形式，向用户或任何第三方负责。</view><view class=\"title_view\" style=\"white-space: normal;\">3.来客推为提供网络服务而使用的任何软件(包括但不限于软件中所含的任何图象、照片、动画、录像、录音、音乐、文字和附加程序、随附的帮助材料)的一切权利均属于该软件。</view><view class=\"title_view\" style=\"white-space: normal;\">4.未经新闻及/或相关权利人明确书面授权，任何人不得复制、转载、摘编、修改、链接、转帖来客推的内容，或在非来客推所属的服务器上做镜像或以其他任何方式进行使用。</view><view class=\"title_view\" style=\"white-space: normal;\">5.获得合法授权的，应在授权范围内使用，必须为作者署名并注明“来源：来客推新闻”字样，并按有关国际公约和中华人民共和国法律的有关规定向相关权利人支付版权费用。违反上述声明者，来客推将依法追究其相关法律责任。对于本站所有形式的原创内容，本站有结集出版的权利。来客推对于用户所发布的内容所引发的版权及其他疑议、纠纷，不承担任何责任。</view><view class=\"title_view\" style=\"white-space: normal;\">6.来客推所转载、链接的内容，出于传递更多信息之目的，并不意味着赞同其观点或证实其内容的真实性。来客推的特约内容，仅代表评论人个人观点，并不代表来客推的观点。</view><view class=\"title_two\" style=\"white-space: normal;\">七、隐私保护</view><view class=\"title_view\" style=\"white-space: normal;\">1.保护用户隐私是来客推的一项基本政策，来客推保证不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在来客推的非公开内容，但下列情况除外：<br/>(1)事先获得用户的明确授权。<br/>(2)根据有关的法律法规要求。<br/>(3)按照相关政府主管部门的要求。<br/>(4)为维护社会公众的利益。<br/>(5)为维护来客推的合法权益。<br/>(6)符合其他相关要求的。<br/></view><view class=\"title_view\" style=\"white-space: normal;\">2.隐私保护具体细节的适用范围：<br/>(1)用户注册时，根据要求提供的所有个人信息。<br/>(2)用户在使用客户端及相关网络平台服务、参加相关活动、访问移动客户端、网络服务平台或网页地址时，来客推自动接收并记录的服务器数据，包括但不限于Iview地址、网站Cookie中的资料及用户要求取用的数据记录。<br/>(3)用户在使用客户端及相关网络平台时，上传的相关数据信息。<br/>(4)我们通过合法途径取得的客户个人资料。<br/>(5)其他我们认为不宜公开的内容。<br/></view><view class=\"title_view\" style=\"white-space: normal;\">3.信息保密：<br/>(1)我们可能会与第三方合作向用户提供相关服务，在此情况下，如该第三方同意承担与我们相同的保护用户隐私的责任，我们有权将用户的注册资料等提供给第三方。<br/>(2)在不透露单个用户隐私资料的前提下，我们有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。<br/></view><view class=\"title_two\" style=\"white-space: normal;\">八、免责声明</view><view class=\"title_view\" style=\"white-space: normal;\">1.除非另有明确的书面说明，本客户端所包含的或以其他方式通过本客户端提供给用户的全部信息、内容、材料、产品（包括软件）和服务，均是在“按现状”和“按现有”的基础上提供的。除非另有明确的书面说明，来客推不对本客户端的运营及包含在本客户端上的信息、内容、资料、产品（包括软件）或服务做任何形式（明示或默示）的声明或保证。</view><view class=\"title_view\" style=\"white-space: normal;\">2.用户明确同意其使用来客推网络服务所存在的风险将完全由其自己承担；因其使用来客推网络服务而产生的一切后果也由其自己承担，来客推对用户不承担任何责任。</view><view class=\"title_view\" style=\"white-space: normal;\">3.用户在来客推发表的内容仅表明其个人的立场和观点，并不代表来客推的立场或观点。作为内容的发表者，需自行对所发表内容负责，因所发表内容引发的一切纠纷，由该内容的发表者承担全部法律及连带责任。来客推不承担任何法律及连带责任。</view><view class=\"title_view\" style=\"white-space: normal;\">4.来客推不担保网络服务一定能满足用户的要求，也不担保网络服务不会中断，对网络服务的及时性、安全性、准确性也都不作担保。来客推不保证为向用户提供便利而设置的外部链接的准确性和完整性，同时，对于该等外部链接指向的不由来客推实际控制的任何网页上的内容，来客推不承担任何责任。</view><view class=\"title_view\" style=\"white-space: normal;\">5.对于因不可抗力或来客推不能控制的原因造成的网络服务中断或其它缺陷，来客推不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。前述状况包括但不限于：<br/>(1)公告系统停机维护期间。<br/>(2)电信设备出现故障不能进行数据传输的。<br/>(3)因台风、地震、海啸、洪水、停电、战争、恐怖袭击等不可抗力的因素，造成系统障碍不能执行业务的。<br/>(4)由于黑客攻击、电信部门技术调整或故障、银行方面的问题等原因而造成的服务中断或延迟。<br/></view><view class=\"title_two\" style=\"white-space: normal;\">九、服务条款的修改</view><view class=\"title_view\" style=\"white-space: normal;\">1.根据国家法律法规变化及网络运营需要，来客推有权对本协议条款不定期地修改，修改后的协议于公示在客户端及相关网络平台上即生效，并代替原来的协议。更新后的协议公示之时即视为用户已阅读并同意，更新后的协议即具有法律效力。</view><view class=\"title_view\" style=\"white-space: normal;\">2.如用户不同意更新后的协议，应立即停止接受本客户端及相关网络平台依据本协议提供的服务；如用户继续使用以上服务，即视为同意更新后的协议。</view><view class=\"title_view\" style=\"white-space: normal;\">3.如本协议中任何一条被视为废止、无效或因任何理由不可执行，不影响协议内其余条款的有效性和可执行性。</view><view class=\"title_two\" style=\"white-space: normal;\">十、通知送达</view><view class=\"title_view\" style=\"white-space: normal;\">1.本协议下来客推给予您所有的通知均可通过网页、公告、电子邮件、手机短信或常规的信件传送等方式进行，此等通知于发送之日视为已送达给您。</view><view class=\"title_view\" style=\"white-space: normal;\">2.您给予来客推的通知应当通过来客推对外正式公布的最新通信地址邮寄送达，此等通知的到达以来客推收悉为准。</view><view class=\"title_two\" style=\"white-space: normal;\">十一、结束服务</view><view class=\"title_view\" style=\"white-space: normal;\">1. 用户可随时根据本协议和实际情况中断一项或多项网络服务，来客推无需对个人或第三方负责，用户对更新的条款有异议，或对来客推的服务不满，可以行使如下权利：<br/>(1)停止使用来客推提供的服务。<br/>(2)通告来客推停止对该用户的服务。结束用户服务后，用户使用本客户端服务的权利马上终止，即刻起，来客推不对用户承担任何义务和责任。<br/></view><view class=\"title_two\" style=\"white-space: normal;\">十二、法律适用和管辖</view><view class=\"title_view\" style=\"white-space: normal;\">1.本协议的订立、执行、解释及争议的解决均应适用中国法律。</view><view class=\"title_view\" style=\"white-space: normal;\">2.如双方就本协议的内容或其执行发生任何争议，双方应尽量友好协商解决；协商不成，任何一方均可向来客推经营者所在地的人民法院提起诉讼。</view><view class=\"title_view\" style=\"white-space: normal;\">湖南壹拾捌号网络技术有限公司“来客推”客户端</view><view class=\"title_view\" style=\"white-space: normal;\">2018年11月</view></p>', '2019-02-19 08:01:35');

-- ----------------------------
-- Table structure for lkt_article
-- ----------------------------
DROP TABLE IF EXISTS `lkt_article`;
CREATE TABLE `lkt_article`  (
  `Article_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `Article_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `Article_prompt` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章提示',
  `Article_imgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章图片',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章内容',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `share_num` int(11) NOT NULL DEFAULT 0 COMMENT '分享次数',
  `total_amount` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '红包总金额',
  `total_num` int(11) NOT NULL DEFAULT 0 COMMENT '红包个数',
  `wishing` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '祝福语',
  PRIMARY KEY (`Article_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '单篇文章表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_auction_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_auction_config`;
CREATE TABLE `lkt_auction_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `low_pepole` int(11) unsigned DEFAULT NULL COMMENT '最低开拍人数',
  `wait_time` int(11) unsigned DEFAULT NULL COMMENT '出价等待时间',
  `days` int(11) unsigned DEFAULT '7' COMMENT '保留天数',
  `content` text COMMENT '竞拍规则',
  `store_id` int(11) DEFAULT NULL COMMENT '商城id',
  `is_open` tinyint(2) DEFAULT '1' COMMENT '是否开启插件 0-不开启 1-开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '竞拍规则表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_auction_product
-- ----------------------------
DROP TABLE IF EXISTS `lkt_auction_product`;
CREATE TABLE `lkt_auction_product` (
  `id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商城id',
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  `title` varchar(200) DEFAULT NULL COMMENT '竞拍标题',
  `content` text COMMENT '内容描述',
  `starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '竞拍状态：0-未开始 1-进行中 2-已结束 3-已流拍',
  `price` decimal(12,2) DEFAULT NULL COMMENT '竞拍起价',
  `add_price` decimal(12,2) DEFAULT NULL COMMENT '竞拍加价',
  `current_price` decimal(12,2) DEFAULT NULL COMMENT '当前价格',
  `imgurl` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `attribute` text COMMENT '产品及规格',
  `market_price` decimal(12,2) DEFAULT NULL COMMENT '市场价',
  `days` int(11) DEFAULT NULL COMMENT '保留显示的天数',
  `invalid_time` timestamp NULL DEFAULT NULL COMMENT '结束显示的时间',
  `promise` decimal(12,2) DEFAULT '99.00' COMMENT '保证金',
  `pepole` int(11) unsigned DEFAULT '0' COMMENT '参与人数',
  `user_id` char(50) DEFAULT NULL COMMENT '最终成交人',
  `is_buy` tinyint(2) DEFAULT '0' COMMENT '是否付款，0-未付款，1-付款',
  `trade_no` char(32) DEFAULT NULL COMMENT '订单编号',
  `low_pepole` int(11) unsigned DEFAULT NULL COMMENT '最低开拍人数',
  `wait_time` int(11) unsigned DEFAULT NULL COMMENT '出价等待时间（单位是秒）',
  `mch_id` int(11) DEFAULT '0' COMMENT '店铺id',
  `recycle` tinyint(2) DEFAULT '0' COMMENT '是否回收  0：不回收  1：回收',
  `s_type` varchar(50) DEFAULT NULL COMMENT '竞拍商品标签类型，根据数据字典',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否显示 0 不显示  ， 1 显示'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='竞拍商品表';

-- ----------------------------
-- Table structure for lkt_auction_promise
-- ----------------------------
DROP TABLE IF EXISTS `lkt_auction_promise`;
CREATE TABLE `lkt_auction_promise`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `promise` decimal(12, 2) NULL DEFAULT NULL COMMENT '保证金额',
  `add_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `a_id` int(11) NULL DEFAULT NULL COMMENT '竞拍商品id',
  `trade_no` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单编号',
  `is_pay` tinyint(2) NULL DEFAULT NULL COMMENT '是否成功支付  0.失败  1.成功',
  `is_back` tinyint(2) NULL DEFAULT NULL COMMENT '是否退款成功  0.成功  1.失败',
  `store_id` int(11) NULL DEFAULT NULL COMMENT '商城id',
  `type` char(15) DEFAULT NULL COMMENT '支付方式 ',
  `allow_back` tinyint(2) NULL DEFAULT 1 COMMENT '是否符合退款标准  0.不符合  1.符合',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_auction_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_auction_record`;
CREATE TABLE `lkt_auction_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `auction_id` int(11) NOT NULL COMMENT '竞拍商品id',
  `add_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `price` decimal(12, 2) NULL DEFAULT NULL COMMENT '竞拍价格',
  `user_id` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '竞拍记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_background_color
-- ----------------------------
DROP TABLE IF EXISTS `lkt_background_color`;
CREATE TABLE `lkt_background_color`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商城id',
  `color_name` char(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '颜色名称',
  `color` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '颜色',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态  0.未启用  1.启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '推广图片表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_background_color
-- ----------------------------
INSERT INTO `lkt_background_color` VALUES (3, '1', '绿色', '#00ff00', 1, 0);
INSERT INTO `lkt_background_color` VALUES (4, '1', '红色', '#000000', 1, 0);
INSERT INTO `lkt_background_color` VALUES (5, '1', '红色', '#DC143C', 1, 0);
INSERT INTO `lkt_background_color` VALUES (6, '1', '橘红', '#FF6347', 1, 1);
INSERT INTO `lkt_background_color` VALUES (7, '22', '1', '#CD5C5C', 1, 1);

-- ----------------------------
-- Table structure for lkt_banner
-- ----------------------------
DROP TABLE IF EXISTS `lkt_banner`;
CREATE TABLE `lkt_banner`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `open_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '跳转方式',
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `type` tinyint(4) NULL DEFAULT 1 COMMENT '类型 1:小程序 2:app',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '轮播图表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_bargain_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_bargain_config`;
CREATE TABLE `lkt_bargain_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id`  int(11) NOT NULL DEFAULT 1 COMMENT '商城id',
  `buy_time` int(11) NOT NULL DEFAULT '10' COMMENT '购买时间',
  `show_time` int(11) NOT NULL DEFAULT '3' COMMENT '商品结束后还显示的时间',
  `only_times` int(11) NOT NULL DEFAULT '2' COMMENT '一个人可对一个商品参加的砍价次数',
  `rule` text NOT NULL COMMENT '砍价规则',
  `imgurl` text NOT NULL COMMENT '砍价顶部图片',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status`  int(5) NOT NULL DEFAULT 0 COMMENT '插件状态 0关闭 1开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '砍价配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_bargain_goods
-- ----------------------------
DROP TABLE IF EXISTS `lkt_bargain_goods`;
CREATE TABLE `lkt_bargain_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL DEFAULT '0',
  `attr_id` int(11) NOT NULL COMMENT '产品属性id',
  `is_type` varchar(20) NOT NULL COMMENT '产品属性值1.猜你喜欢，2.热销，3.新品',
  `min_price` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '最低价',
  `begin_time` char(20) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` char(20) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `buytime` int(11) NOT NULL DEFAULT '0' COMMENT '购买时间',
  `man_num` smallint(6) NOT NULL DEFAULT '0' COMMENT '砍价人数 0为不限制',
  `status_data` varchar(255) NOT NULL DEFAULT '' COMMENT '砍价方式数据',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '状态0.未开始1.进行中2.已结束',
  `is_show` smallint(6) NOT NULL DEFAULT '1' COMMENT '是否显示:0,不显示   1,显示',
  `addtime` char(20) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '权重值，越大排序越靠前',
  `is_delete` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否删除:0否   1是',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for lkt_bargain_order
-- ----------------------------
DROP TABLE IF EXISTS `lkt_bargain_order`;
CREATE TABLE `lkt_bargain_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `user_id` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `order_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `attr_id` int(11) NOT NULL DEFAULT 0,
  `original_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '剩余价格',
  `min_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '商品最低价',
  `goods_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态 -1--失败 0--进行中 1--成功 2--付款',
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `addtime` int(11) NOT NULL DEFAULT 0,
  `status_data` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '砍价方式数据',
  `bargain_id` int(11) NOT NULL COMMENT '砍价活动id',
  `achievetime` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `store_id`(`store_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '发起砍价订单表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_bargain_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_bargain_record`;
CREATE TABLE `lkt_bargain_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NULL DEFAULT NULL,
  `order_no` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '砍价订单',
  `user_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '金额',
  `add_time` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0:砍价中 1:砍价成功 2:逾期失效 3:生成订单',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '砍价免单记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_brand_class
-- ----------------------------
DROP TABLE IF EXISTS `lkt_brand_class`;
CREATE TABLE `lkt_brand_class`  (
  `brand_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `brand_pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '品牌logo',
  `brand_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '品牌名称',
  `brand_y_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '英文名',
  `producer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产地',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0:启用 1:禁用',
  `brand_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  `sort` int(10) NULL DEFAULT 100,
  `recycle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '回收站 0.不回收 1.回收',
  `categories` text COMMENT '所属分类',
  PRIMARY KEY (`brand_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品品牌表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_brand_class
-- ----------------------------
INSERT INTO `lkt_brand_class` VALUES (1, 1, '', '预留品牌', '', '', '', 0, '2019-04-17 03:05:35', 100, 1,'');
INSERT INTO `lkt_brand_class` VALUES (2, 1, '', '计划品牌', '', '', '', 0, '2019-04-17 03:05:31', 100, 1,'');

-- ----------------------------
-- Table structure for lkt_cart
-- ----------------------------
DROP TABLE IF EXISTS `lkt_cart`;
CREATE TABLE `lkt_cart`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'token',
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户id',
  `Uid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信id',
  `Goods_id` int(11) NULL DEFAULT NULL COMMENT '产品id',
  `Goods_num` int(11) NULL DEFAULT NULL COMMENT '数量',
  `Create_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `Size_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品属性id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '购物车' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_combined_pay
-- ----------------------------
DROP TABLE IF EXISTS `lkt_combined_pay`;
CREATE TABLE `lkt_combined_pay`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `weixin_pay` decimal(11, 2) NOT NULL DEFAULT 0.00 COMMENT '微信支付金额',
  `balance_pay` decimal(11, 2) NOT NULL DEFAULT 0.00 COMMENT '余额支付',
  `total` decimal(11, 2) NOT NULL COMMENT '总金额',
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  `user_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_comments
-- ----------------------------
DROP TABLE IF EXISTS `lkt_comments`;
CREATE TABLE `lkt_comments`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `oid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单ID',
  `uid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `pid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品id',
  `attribute_id` int(11) NULL DEFAULT NULL COMMENT '属性id',
  `size` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '默认' COMMENT '商品规格',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '评价内容',
  `CommentType` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '评价类型',
  `anonymous` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '匿名 ',
  `add_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `review` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '追评',
  `review_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '追评时间',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '评价类型-KJ 砍价评论-PT 拼团评论',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '评论表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_comments_img
-- ----------------------------
DROP TABLE IF EXISTS `lkt_comments_img`;
CREATE TABLE `lkt_comments_img`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `comments_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '评论图片',
  `comments_id` int(11) NULL DEFAULT NULL COMMENT '评论id',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `type` tinyint(3) NULL DEFAULT 0 COMMENT '类型  0.评论  1.追评',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '评论图片表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_config`;
CREATE TABLE `lkt_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `is_register` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否需要注册 1.注册 2.免注册',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司logo',
  `logo1` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '首页logo',
  `company` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `appid` char(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '小程序id',
  `appsecret` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '小程序密钥',
  `domain` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '小程序域名',
  `app_domain_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'APP域名',
  `H5_domain`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'H5域名',
  `mch_id` int(11) NULL DEFAULT NULL COMMENT '商户id',
  `ip` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ip地址',
  `uploadImg_domain` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片上传域名',
  `upserver` tinyint(4) NOT NULL DEFAULT 2 COMMENT '上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云',
  `uploadImg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片上传位置',
  `upload_file` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件上传位置',
  `modify_date` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `mch_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '微信支付key',
  `mch_cert` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '支付证书文件地址',
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '用户ID默认前缀',
  `wx_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信默认用户名称',
  `wx_headimgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信默认用户头像',
  `customer_service` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '客服',
  `agreement` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '用户协议',
  `aboutus` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '关于我们',
  `message_day`  int(10) NOT NULL DEFAULT 0 COMMENT '消息保留天数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '配置表' ROW_FORMAT = Dynamic;

INSERT INTO `lkt_config` (`id`, `store_id`, `is_register`, `logo`, `logo1`, `company`, `appid`, `appsecret`, `domain`, `app_domain_name`, `mch_id`, `ip`, `uploadImg_domain`, `upserver`, `uploadImg`, `upload_file`, `modify_date`, `mch_key`, `mch_cert`, `user_id`, `wx_name`, `wx_headimgurl`, `customer_service`, `agreement`, `aboutus`, `message_day`) VALUES
(1, 1, 0, NULL, NULL, 'news2', '', '', 'https://xiaochengxu.houjiemeishi.com/empty', NULL, NULL, NULL, '', 2, '', '', '2019-10-09 09:26:32', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 0);

-- ----------------------------
-- Table structure for lkt_configure
-- ----------------------------
DROP TABLE IF EXISTS `lkt_configure`;
CREATE TABLE `lkt_configure`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `color` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '颜色',
  `size` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '尺码',
  `costprice` decimal(12, 2) NOT NULL COMMENT '成本价',
  `price` decimal(12, 2) NOT NULL COMMENT '出售价格',
  `yprice` decimal(12, 2) NOT NULL COMMENT '原价格',
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片',
  `pid` int(11) NOT NULL COMMENT '商品id',
  `total_num` int(11) NOT NULL DEFAULT 0 COMMENT '总库存',
  `num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '剩余库存',
  `unit` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '单位',
  `bar_code` varchar(255) NOT NULL COMMENT '条形码',
  `bargain_price` decimal(12, 2) NULL COMMENT '砍价开始价格',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0:未开启砍价 1:开启砍价 2 上架 3 缺货 4下架',
  `attribute` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '属性',
  `recycle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '回收站 0.不回收 1.回收',
  `min_inventory` smallint(6) NOT NULL DEFAULT 10 COMMENT '产品预警值',
  `ctime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_core_menu
-- ----------------------------

CREATE TABLE IF NOT EXISTS `lkt_core_menu` (
  `id` int(11) unsigned NOT NULL COMMENT 'id',
  `s_id` int(11) DEFAULT NULL COMMENT '上级id',
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单标识',
  `image` varchar(255) DEFAULT NULL COMMENT '图标',
  `image1` varchar(255) DEFAULT NULL COMMENT '点击后图标',
  `module` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单模块标识',
  `action` varchar(60) NOT NULL DEFAULT '' COMMENT '菜单文件标识',
  `url` varchar(60) NOT NULL DEFAULT '' COMMENT '路径',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `level` int(11) DEFAULT NULL COMMENT '第几级',
  `is_core` tinyint(4) DEFAULT '0' COMMENT '是否是核心',
  `is_plug_in` tinyint(4) DEFAULT '0' COMMENT '是否是插件',
  `type` tinyint(4) DEFAULT '0' COMMENT '类型 0.后台管理 1.小程序 2.app 3.微信公众号 4.PC 5.生活号 6.报表 7.支付宝小程序',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `recycle` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回收站 0.不回收 1.回收'
) ENGINE=MyISAM AUTO_INCREMENT=501 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='核心菜单';

--
-- 转存表中的数据 `lkt_core_menu`
--

INSERT INTO `lkt_core_menu` (`id`, `s_id`, `title`, `name`, `image`, `image1`, `module`, `action`, `url`, `sort`, `level`, `is_core`, `is_plug_in`, `type`, `add_time`, `recycle`) VALUES
(1, 0, '会员管理', 'user', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767294444.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/155376731135.png', '', '', '', 4, 1, 0, 0, 0, '2018-09-26 17:46:49', 0),
(2, 1, '会员列表', 'user', '', NULL, 'userlist', 'Index', 'index.php?module=userlist&action=Index', 100, 2, 0, 0, 0, '2018-09-26 17:47:18', 0),
(3, 2, '浏览', 'user', '', '', 'userlist', 'Index', 'index.php?module=userlist&action=Index', 100, 3, 0, 0, 0, '2018-10-26 03:08:04', 0),
(4, 2, '会员详情', 'user', '', '', 'userlist', 'View', 'index.php?module=userlist&action=View', 100, 3, 0, 0, 0, '2018-10-26 03:09:11', 0),
(5, 2, '私信', 'user', '', NULL, 'userlist', 'seng', 'index.php?module=userlist&action=seng', 100, 3, 0, 0, 0, '2018-09-26 17:48:17', 0),
(6, 2, '删除', 'user', '', NULL, 'userlist', 'Del', 'index.php?module=userlist&action=Del', 100, 3, 0, 0, 0, '2018-09-26 17:54:29', 0),
(7, 2, '充值', 'user', '', NULL, 'userlist', 'Recharge', 'index.php?module=userlist&action=Recharge', 100, 3, 0, 0, 0, '2018-09-26 18:43:27', 0),
(8, 0, '商品管理', 'product', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767545337.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767551766.png', '', '', '', 2, 1, 0, 0, 0, '2018-09-24 22:46:22', 0),
(9, 8, '商品列表', 'product', '', NULL, 'product', 'Index', 'index.php?module=product&action=Index', 100, 2, 0, 0, 0, '2018-09-25 23:26:51', 0),
(10, 9, '查看详细', 'product', '', NULL, 'product', 'See', 'index.php?module=product&action=See', 100, 3, 0, 0, 0, '2019-09-25 07:45:39', 0),
(11, 9, '添加', 'product', '', NULL, 'product', 'Add', 'index.php?module=product&action=Add', 100, 3, 0, 0, 0, '2019-09-25 07:45:45', 0),
(12, 9, '修改', 'product', '', NULL, 'product', 'Modify', 'index.php?module=product&action=Modify', 100, 3, 0, 0, 0, '2019-09-25 07:45:53', 0),
(13, 9, '批量操作', '', '', '', 'product', 'Operation', 'index.php?module=product&action=Operation', 100, 3, 0, 0, 0, '2019-09-25 07:46:03', 0),
(14, 9, '上下架', 'product', '', NULL, 'product', 'Shelves', 'index.php?module=product&action=Shelves', 100, 3, 0, 0, 0, '2019-09-25 07:46:11', 0),
(15, 9, '删除', 'product', '', NULL, 'product', 'Del', 'index.php?module=product&action=Del', 100, 3, 0, 0, 0, '2019-09-25 07:46:18', 0),
(16, 9, '浏览', 'product', '', NULL, 'product', 'Index', 'index.php?module=product&action=Index', 100, 3, 0, 0, 0, '2018-09-25 23:34:51', 0),
(20, 17, '删除', '', '', '', 'product_class', 'Del', 'index.php?module=product_class&action=Del', 100, 3, 0, 0, 0, '2019-09-25 06:41:49', 0),
(19, 17, '修改', '', '', '', 'product_class', 'Modify', 'index.php?module=product_class&action=Modify', 100, 3, 0, 0, 0, '2019-09-25 06:41:56', 0),
(18, 17, '添加', '', '', '', 'product_class', 'Add', 'index.php?module=product_class&action=Add', 100, 3, 0, 0, 0, '2019-09-25 06:42:04', 0),
(17, 8, '商品分类', '', '', '', 'product_class', 'Index', 'index.php?module=product_class&action=Index', 100, 2, 0, 0, 0, '2018-10-26 03:29:13', 0),
(21, 17, '浏览', '', '', '', 'product_class', 'Index', 'index.php?module=product_class&action=Index', 100, 3, 0, 0, 0, '2018-10-26 03:31:53', 0),
(22, 8, '品牌管理', '', '', '', 'brand_class', 'Index', 'index.php?module=brand_class&action=Index', 100, 2, 0, 0, 0, '2018-10-26 03:35:48', 0),
(23, 22, '添加', '', '', '', 'brand_class', 'Add', 'index.php?module=brand_class&action=Add', 100, 3, 0, 0, 0, '2018-10-26 03:36:37', 0),
(24, 22, '修改', '', '', '', 'brand_class', 'Modify', 'index.php?module=brand_class&action=Modify', 100, 3, 0, 0, 0, '2018-10-26 03:37:04', 0),
(25, 22, '删除', '', '', '', 'brand_class', 'Del', 'index.php?module=brand_class&action=Del', 100, 3, 0, 0, 0, '2018-10-26 03:37:27', 0),
(26, 22, '启用/禁用', '', '', '', 'brand_class', 'Status', 'index.php?module=brand_class&action=Status', 100, 3, 0, 0, 0, '2018-10-26 03:38:22', 0),
(27, 22, '浏览', '', '', '', 'brand_class', 'Index', 'index.php?module=brand_class&action=Index', 100, 3, 0, 0, 0, '2018-10-26 03:38:57', 0),
(335, 123, '图片上传', '', '', '', 'extension', 'uploadImg', 'index.php?module=extension&action=uploadImg', 100, 3, 0, 0, 0, '2019-01-23 11:14:14', 1),
(336, 219, '版本配置', '', '', '', 'edition', 'Index', 'index.php?module=edition&action=Index', 100, 2, 0, 0, 2, '2019-01-24 06:08:47', 0),
(31, 0, '订单管理', 'order', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767583457.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/155376758861.png', '', '', '', 3, 1, 0, 0, 0, '2018-09-26 03:49:13', 0),
(32, 31, '订单列表', '', '', '', 'orderslist', 'Index', 'index.php?module=orderslist&action=Index', 100, 2, 0, 0, 0, '2018-10-26 03:55:01', 0),
(33, 32, '发货', '', '', '', 'orderslist', 'addsign', 'index.php?module=orderslist&action=addsign', 100, 3, 0, 0, 0, '2018-10-26 03:56:26', 0),
(34, 32, '订单详情', '', '', '', 'orderslist', 'Detail', 'index.php?module=orderslist&action=Detail', 100, 3, 0, 0, 0, '2018-10-26 03:56:57', 0),
(35, 32, '物流', '', '', '', 'orderslist', 'kuaidishow', 'index.php?module=orderslist&action=kuaidishow', 100, 3, 0, 0, 0, '2018-10-26 03:57:31', 0),
(36, 32, '修改', '', '', '', 'orderslist', 'Modify', 'index.php?module=orderslist&action=Modify', 100, 3, 0, 0, 0, '2018-10-26 03:58:21', 0),
(37, 32, '退款', '', '', '', 'orderslist', 'Status', 'index.php?module=orderslist&action=Status', 100, 3, 0, 0, 0, '2018-10-26 03:59:00', 0),
(38, 32, '浏览', '', '', '', 'orderslist', 'Index', 'index.php?module=orderslist&action=Index', 100, 3, 0, 0, 0, '2018-10-26 04:00:01', 0),
(39, 31, '退货列表', '', '', '', 'return', 'Index', 'index.php?module=return&action=Index', 100, 2, 0, 0, 0, '2018-10-26 04:01:30', 0),
(40, 39, '查看', '', '', '', 'return', 'View', 'index.php?module=return&action=View', 100, 3, 0, 0, 0, '2019-09-19 09:35:01', 0),
(41, 39, '通过/拒绝', '', '', '', 'return', 'Examine', 'index.php?module=return&action=Examine', 100, 3, 0, 0, 0, '2019-09-19 09:35:12', 0),
(42, 39, '浏览', '', '', '', 'return', 'Index', 'index.php?module=return&action=Index', 100, 3, 0, 0, 0, '2018-10-26 04:05:55', 0),
(44, 153, '分销', '', '', '', 'distribution', 'index', 'index.php?module=distribution&action=Index', 2, 2, 0, 1, 0, '2018-10-26 04:11:30', 0),
(45, 44, '查看', '', '', '', 'userlist', 'View', 'index.php?module=userlist&action=View', 100, 3, 0, 1, 0, '2018-10-26 04:12:03', 0),
(46, 44, '详情', '', '', '', 'distribution', 'distribution_informatio', 'index.php?module=distribution&action=distribution_informatio', 100, 3, 0, 1, 0, '2018-10-26 04:13:29', 0),
(47, 44, '删除', '', '', '', 'distribution', 'del', 'index.php?module=distribution&action=del', 100, 3, 0, 1, 0, '2018-10-26 05:38:12', 0),
(48, 44, '浏览', '', '', '', 'distribution', 'Index', 'index.php?module=distribution&action=Index', 100, 3, 0, 1, 0, '2018-10-26 05:38:37', 0),
(49, 44, '分销商等级', '', '', '', 'distribution', 'distribution_grade', 'index.php?module=distribution&action=distribution_grade', 100, 2, 0, 1, 0, '2018-10-26 05:41:08', 0),
(50, 49, '添加', '', '', '', 'distribution', 'distribution_add', 'index.php?module=distribution&action=distribution_add', 100, 3, 0, 1, 0, '2018-10-26 05:41:58', 0),
(51, 49, '修改', '', '', '', 'distribution', 'distribution_modify', 'index.php?module=distribution&action=distribution_modify', 100, 3, 0, 1, 0, '2018-10-26 05:42:23', 0),
(52, 49, '删除', '', '', '', 'distribution', 'distribution_del', 'index.php?module=distribution&action=distribution_del', 100, 3, 0, 1, 0, '2018-10-26 05:42:47', 0),
(53, 49, '浏览', '', '', '', 'distribution', 'distribution_grade', 'index.php?module=distribution&action=distribution_grade', 100, 3, 0, 1, 0, '2018-10-26 05:43:08', 0),
(54, 44, '分销关系修改', '', '', '', 'distribution', 'set', 'index.php?module=distribution&action=set', 100, 2, 0, 1, 0, '2018-10-26 05:43:48', 0),
(257, 0, '权限管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767725740.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767745940.png', '', '', '', 10, 1, 0, 0, 0, '2018-12-14 07:05:49', 0),
(258, 257, '管理员列表', '', '', '', 'member', 'Index', 'index.php?module=member&action=Index', 1, 2, 0, 0, 0, '2018-12-14 07:07:14', 0),
(56, 1, '提现管理', '', '', '', 'finance', 'Index', 'index.php?module=finance&action=Index', 100, 2, 0, 0, 0, '2018-10-26 05:47:39', 0),
(57, 56, '提现列表', '', '', '', 'finance', 'list', 'index.php?module=finance&action=list', 100, 3, 0, 0, 0, '2018-10-26 05:50:21', 0),
(278, 62, '查看', '', '', '', 'finance', 'recharge_see', 'index.php?module=finance&action=recharge_see', 100, 3, 0, 0, 0, '2018-12-18 05:48:52', 0),
(59, 56, '通过/拒绝', '', '', '', 'finance', 'del', 'index.php?module=finance&action=del', 100, 3, 0, 0, 0, '2018-10-26 05:52:44', 0),
(60, 56, '查看', '', '', '', 'finance', 'see', 'index.php?module=finance&action=see', 100, 3, 0, 0, 0, '2018-10-26 05:53:26', 0),
(61, 56, '浏览', '', '', '', 'finance', 'Index', 'index.php?module=finance&action=Index', 100, 3, 0, 0, 0, '2018-10-26 05:54:31', 0),
(62, 1, '充值列表', '', '', '', 'finance', 'Recharge', 'index.php?module=finance&action=Recharge', 100, 2, 0, 0, 0, '2019-09-27 07:59:11', 0),
(63, 1, '资金管理', '', '', '', 'finance', 'Yue', 'index.php?module=finance&action=Yue', 100, 2, 0, 0, 0, '2019-09-27 07:59:27', 0),
(64, 63, '查看', '', '', '', 'finance', 'Yue_see', 'index.php?module=finance&action=Yue_see', 100, 3, 0, 0, 0, '2019-09-27 07:59:40', 0),
(65, 63, '删除', '', '', '', 'finance', 'yuedel', 'index.php?module=finance&action=yuedel', 100, 3, 0, 0, 0, '2018-10-26 05:58:26', 0),
(66, 63, '浏览', '', '', '', 'finance', 'yue', 'index.php?module=finance&action=yue', 100, 3, 0, 0, 0, '2018-10-26 05:58:53', 0),
(67, 1, '积分管理', '', '', '', 'finance', 'Jifen', 'index.php?module=finance&action=Jifen', 100, 2, 0, 0, 0, '2019-09-27 08:00:06', 0),
(68, 67, '查看', '', '', '', 'finance', 'jifen_see', 'index.php?module=finance&action=jifen_see', 100, 3, 0, 0, 0, '2018-10-26 06:05:31', 0),
(69, 67, '删除', '', '', '', 'finance', 'jifendel', 'index.php?module=finance&action=jifendel', 100, 3, 0, 0, 0, '2018-10-26 06:06:02', 0),
(70, 67, '浏览', '', '', '', 'finance', 'jifen', 'index.php?module=finance&action=jifen', 100, 3, 0, 0, 0, '2018-10-26 06:09:57', 0),
(255, 153, '邀请有奖', '', '', '', 'invitation', 'Index', 'index.php?module=invitation&action=Index', 10, 2, 0, 1, 0, '2018-12-12 13:01:39', 0),
(73, 257, '菜单列表', '', '', '', 'menu', 'Index', 'index.php?module=menu&action=Index', 100, 2, 1, 0, 0, '2018-10-26 06:14:08', 0),
(74, 257, '角色管理', '', '', '', 'role', 'Index', 'index.php?module=role&action=Index', 3, 2, 0, 0, 0, '2018-10-26 06:15:19', 0),
(75, 74, '添加', '', '', '', 'role', 'Add', 'index.php?module=role&action=Add', 100, 3, 0, 0, 0, '2019-09-23 11:09:24', 0),
(76, 74, '修改', '', '', '', 'role', 'Modify', 'index.php?module=role&action=Modify', 100, 3, 0, 0, 0, '2019-09-23 11:09:31', 0),
(77, 74, '删除', '', '', '', 'role', 'Del', 'index.php?module=role&action=Del', 100, 3, 0, 0, 0, '2019-09-23 11:09:40', 0),
(78, 74, '浏览', '', '', '', 'role', 'Index', 'index.php?module=role&action=Index', 100, 3, 0, 0, 0, '2018-10-26 06:17:43', 0),
(267, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 1, '2018-12-14 07:39:07', 0),
(84, 44, '分销设置', '', '', '', 'distribution', 'distribution_config', 'index.php?module=distribution&action=distribution_config', 100, 3, 0, 0, 0, '2018-10-26 06:37:15', 0),
(85, 31, '订单设置', '', '', '', 'orderslist', 'Config', 'index.php?module=orderslist&action=Config', 20, 2, 0, 0, 0, '2019-09-29 07:10:20', 0),
(86, 0, '系统管理', 'system', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767887610.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767893432.png', '', '', '', 100, 1, 0, 0, 0, '2018-09-24 23:13:49', 0),
(87, 86, '公告管理', '', '', '', 'notice', 'Index', 'index.php?module=notice&action=Index', 100, 2, 0, 0, 0, '2018-10-26 06:49:19', 1),
(88, 87, '添加', '', '', '', 'notice', 'add', 'index.php?module=notice&action=add', 100, 3, 0, 0, 0, '2018-10-26 06:50:10', 1),
(89, 87, '修改', '', '', '', 'notice', 'modify', 'index.php?module=notice&action=modify', 100, 3, 0, 0, 0, '2018-10-26 06:50:31', 1),
(90, 87, '删除', '', '', '', 'notice', 'del', 'index.php?module=notice&action=del', 100, 3, 0, 0, 0, '2018-10-26 06:50:54', 1),
(91, 87, '只看', '', '', '', 'notice', 'Index', 'index.php?module=notice&action=Index', 100, 3, 0, 0, 0, '2018-10-26 06:51:14', 1),
(392, 0, '授权管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768005360.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767999837.png', '', '', '', 100, 1, 1, 0, 0, '2019-03-13 07:21:08', 0),
(390, 392, '发布管理', '', '', '', 'third', 'Review', 'index.php?module=third&action=Review', 100, 2, 1, 0, 0, '2019-03-12 11:11:04', 0),
(389, 392, '模板设置', '', '', '', 'third', 'Template', 'index.php?module=third&action=Template', 100, 2, 1, 0, 0, '2019-03-08 08:27:41', 0),
(388, 269, '授权设置', '', '', '', 'third', 'Auth', 'index.php?module=third&action=Auth', 100, 2, 0, 0, 1, '2019-02-25 09:51:41', 0),
(99, 257, '管理员日志', '', '', '', 'member', 'MemberRecord', 'index.php?module=member&action=MemberRecord', 2, 2, 0, 0, 0, '2019-09-20 06:16:32', 0),
(155, 153, '卡券', '', '', '', 'coupon', 'Index', 'index.php?module=coupon&action=Index', 6, 2, 0, 1, 0, '2018-10-26 08:09:44', 0),
(101, 31, '运费设置', '', '', '', 'freight', 'Index', 'index.php?module=freight&action=Index', 100, 2, 0, 0, 0, '2018-10-26 07:02:05', 0),
(102, 101, '添加', '', '', '', 'freight', 'Add', 'index.php?module=freight&action=Add', 100, 3, 0, 0, 0, '2018-10-26 07:02:32', 0),
(103, 101, '修改', '', '', '', 'freight', 'Modify', 'index.php?module=freight&action=Modify', 100, 3, 0, 0, 0, '2018-10-26 07:02:56', 0),
(104, 101, '删除', '', '', '', 'freight', 'Del', 'index.php?module=freight&action=Del', 100, 3, 0, 0, 0, '2018-10-26 07:03:28', 0),
(105, 101, '浏览', '', '', '', 'freight', 'Index', 'index.php?module=freight&action=Index', 100, 3, 0, 0, 0, '2018-10-26 07:03:52', 0),
(106, 154, '添加', '', '', '', 'plug_ins', 'Add', 'index.php?module=plug_ins&action=Add', 100, 3, 1, 0, 0, '2019-09-26 06:41:45', 0),
(107, 154, '修改', '', '', '', 'plug_ins', 'Modify', 'index.php?module=plug_ins&action=Modify', 100, 3, 1, 0, 0, '2019-09-26 06:41:52', 0),
(108, 154, '启用/禁用', '', '', '', 'plug_ins', 'Whether', 'index.php?module=plug_ins&action=Whether', 100, 3, 1, 0, 0, '2019-09-26 06:42:00', 0),
(109, 154, '删除', '', '', '', 'plug_ins', 'Del', 'index.php?module=plug_ins&action=Del', 100, 3, 1, 0, 0, '2019-09-26 06:42:09', 0),
(110, 154, '浏览', '', '', '', 'plug_ins', 'Index', 'index.php?module=plug_ins&action=Index', 100, 3, 1, 0, 0, '2018-10-26 07:09:02', 0),
(111, 31, '评价管理', '', '', '', 'comments', 'Index', 'index.php?module=comments&action=Index', 100, 2, 0, 0, 0, '2018-10-26 07:12:17', 0),
(112, 111, '回复', '', '', '', 'comments', 'Reply', 'index.php?module=comments&action=Reply', 100, 3, 0, 0, 0, '2018-10-26 07:12:54', 0),
(113, 111, '修改', '', '', '', 'comments', 'Modify', 'index.php?module=comments&action=Modify', 100, 3, 0, 0, 0, '2018-10-26 07:13:20', 0),
(114, 111, '删除', '', '', '', 'comments', 'Del', 'index.php?module=comments&action=Del', 100, 3, 0, 0, 0, '2018-10-26 07:13:41', 0),
(115, 111, '浏览', '', '', '', 'comments', 'Index', 'index.php?module=comments&action=Index', 100, 3, 0, 0, 0, '2018-10-26 07:14:01', 0),
(116, 267, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 1, '2018-10-26 07:16:10', 0),
(117, 116, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 1, '2018-10-26 07:16:48', 0),
(118, 116, '修改', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 1, '2018-10-26 07:17:10', 0),
(119, 116, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 1, '2018-10-26 07:17:33', 0),
(120, 116, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 1, '2018-10-26 07:17:55', 0),
(264, 0, '推广图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768220442.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768224293.png', '', '', '', 100, 1, 0, 0, 1, '2018-12-14 07:35:19', 1),
(123, 264, '推广图列表', '', '', '', 'extension', 'Index', 'index.php?module=extension&action=Index', 100, 2, 0, 0, 1, '2018-10-26 07:22:03', 1),
(124, 123, '添加', '', '', '', 'extension', 'add', 'index.php?module=extension&action=add', 100, 3, 0, 0, 1, '2018-10-26 07:22:23', 1),
(125, 123, '修改', '', '', '', 'extension', 'modify', 'index.php?module=extension&action=modify', 100, 3, 0, 0, 1, '2018-10-26 07:22:58', 1),
(126, 123, '删除', '', '', '', 'extension', 'del', 'index.php?module=extension&action=del', 100, 3, 0, 0, 1, '2018-10-26 07:23:20', 1),
(127, 123, '清推广图缓存', '', '', '', 'extension', 'del_simg', 'index.php?module=extension&action=del_simg', 100, 3, 0, 0, 1, '2018-10-26 07:24:13', 1),
(128, 123, '浏览', '', '', '', 'extension', 'Index', 'index.php?module=extension&action=Index', 100, 3, 0, 0, 1, '2018-10-26 07:24:35', 1),
(135, 99, '批量删除', '', '', '', 'member', 'MemberRecordDel', 'index.php?module=member&action=MemberRecordDel', 100, 3, 0, 0, 0, '2019-09-20 06:17:11', 0),
(136, 99, '浏览', '', '', '', 'member', 'MemberRecord', 'index.php?module=member&action=MemberRecord', 100, 3, 0, 0, 0, '2019-09-20 06:17:39', 0),
(137, 73, '添加', '', '', '', 'menu', 'Add', 'index.php?module=menu&action=Add', 100, 3, 1, 0, 0, '2019-09-25 01:50:58', 0),
(138, 73, '修改', '', '', '', 'menu', 'Modify', 'index.php?module=menu&action=Modify', 100, 3, 1, 0, 0, '2019-09-25 01:51:12', 0),
(139, 73, '删除', '', '', '', 'menu', 'Del', 'index.php?module=menu&action=Del', 100, 3, 1, 0, 0, '2019-09-25 01:51:19', 0),
(140, 269, '接口配置', '', '', '', 'system', 'Index', 'index.php?module=system&action=Index', 1, 2, 0, 0, 1, '2018-10-26 07:37:52', 0),
(142, 86, '版本控制', '', '', '', 'software', 'Index', 'index.php?module=software&action=Index', 100, 2, 1, 0, 0, '2018-10-26 07:47:29', 0),
(143, 142, '添加', '', '', '', 'software', 'add', 'index.php?module=software&action=add', 100, 3, 1, 0, 0, '2018-10-26 07:47:53', 0),
(144, 142, '修改', '', '', '', 'software', 'modify', 'index.php?module=software&action=modify', 100, 3, 1, 0, 0, '2018-10-26 07:48:18', 0),
(145, 142, '删除', '', '', '', 'software', 'del', 'index.php?module=software&action=del', 100, 3, 1, 0, 0, '2018-10-26 07:48:38', 0),
(146, 277, '商户列表', '', '', '', 'Customer', 'Index', 'index.php?module=Customer&action=Index', 100, 2, 1, 0, 0, '2018-10-26 07:50:05', 0),
(148, 146, '添加', '', '', '', 'Customer', 'Add', 'index.php?module=Customer&action=Add', 100, 3, 1, 0, 0, '2019-09-20 04:04:17', 0),
(149, 146, '修改', '', '', '', 'Customer', 'Modify', 'index.php?module=Customer&action=Modify', 100, 3, 1, 0, 0, '2019-09-20 04:04:25', 0),
(153, 0, '插件管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768258740.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768262469.png', '', '', '', 11, 1, 0, 1, 0, '2018-10-26 07:58:38', 0),
(154, 366, '插件列表', '', '', '', 'plug_ins', 'Index', 'index.php?module=plug_ins&action=Index', 1, 2, 1, 1, 0, '2018-10-26 07:59:57', 0),
(156, 162, '添加', '', '', '', 'coupon', 'add', 'index.php?module=coupon&action=add', 100, 4, 0, 1, 0, '2018-10-26 08:10:50', 0),
(157, 162, '启用/禁用', '', '', '', 'coupon', 'whether', 'index.php?module=coupon&action=whether', 100, 3, 0, 1, 0, '2018-10-26 08:11:46', 0),
(158, 162, '修改', '', '', '', 'coupon', 'modify', 'index.php?module=coupon&action=modify', 100, 3, 0, 1, 0, '2018-10-26 08:12:35', 0),
(159, 162, '删除', '', '', '', 'coupon', 'del', 'index.php?module=coupon&action=del', 100, 3, 0, 1, 0, '2018-10-26 08:13:01', 0),
(160, 162, '浏览', '', '', '', 'coupon', 'Index', 'index.php?module=coupon&action=Index', 100, 3, 0, 1, 0, '2018-10-26 08:13:30', 0),
(161, 155, '优惠券列表', '', '', '', 'coupon', 'coupon', 'index.php?module=coupon&action=coupon', 100, 3, 0, 1, 0, '2018-10-26 08:14:38', 0),
(162, 155, '优惠券活动', '', '', '', 'coupon', 'Index', 'index.php?module=coupon&action=Index', 100, 3, 0, 1, 0, '2018-10-26 08:15:25', 0),
(163, 153, '签到', '', '', '', 'sign', 'Index', 'index.php?module=sign&action=Index', 5, 2, 0, 1, 0, '2018-10-26 08:18:14', 0),
(164, 163, '签到活动', '', '', '', 'sign', 'Index', 'index.php?module=sign&action=Index', 100, 3, 0, 1, 0, '2018-10-26 08:18:52', 0),
(165, 164, '添加', '', '', '', 'sign', 'add', 'index.php?module=sign&action=add', 100, 4, 0, 1, 0, '2018-10-26 08:19:40', 0),
(166, 164, '修改', '', '', '', 'sign', 'modify', 'index.php?module=sign&action=modify', 100, 4, 0, 1, 0, '2018-10-26 08:20:43', 0),
(167, 164, '删除', '', '', '', 'sign', 'del', 'index.php?module=sign&action=del', 100, 4, 0, 1, 0, '2018-10-26 08:22:25', 0),
(168, 164, '浏览', '', '', '', 'sign', 'Index', 'index.php?module=sign&action=Index', 100, 4, 0, 1, 0, '2018-10-26 08:23:18', 0),
(169, 163, '签到记录', '', '', '', 'sign', 'record', 'index.php?module=sign&action=record', 100, 3, 0, 1, 0, '2018-10-26 08:23:58', 0),
(170, 153, '拼团', '', '', '', 'go_group', 'Index', 'index.php?module=go_group&action=Index', 3, 2, 0, 1, 0, '2018-10-26 08:26:22', 0),
(171, 170, '添加', '', '', '', 'go_group', 'addgroup', 'index.php?index.php?module=go_group&action=addgroup', 100, 3, 0, 1, 0, '2018-10-26 08:27:03', 0),
(172, 170, '修改', '', '', '', 'go_group', 'modify', 'index.php?module=go_group&action=modify', 100, 3, 0, 1, 0, '2018-10-26 08:27:39', 0),
(173, 170, '修改商品', '', '', '', 'go_group', 'grouppro', 'index.php?module=go_group&action=grouppro', 100, 3, 0, 1, 0, '2018-10-26 08:28:45', 0),
(174, 170, '删除', '', '', '', 'go_group', 'del', 'index.php?module=go_group&action=del', 100, 3, 0, 1, 0, '2018-10-26 08:29:08', 0),
(175, 170, '浏览', '', '', '', 'go_group', 'Index', 'index.php?module=go_group&action=Index', 100, 3, 0, 1, 0, '2018-10-26 08:29:32', 0),
(394, 392, '关键词获取', '', '', '', 'third', 'Key', 'index.php?module=third&action=Key', 100, 2, 1, 0, 0, '2019-03-28 02:35:54', 1),
(201, 153, '红包', '', '', '', 'dismantling_envelopes', 'Index', 'index.php?module=dismantling_envelopes', 7, 2, 0, 1, 0, '2018-10-26 08:58:35', 0),
(202, 201, '活动', '', '', '', 'dismantling_envelopes', 'Index', 'index.php?module=dismantling_envelopes', 100, 3, 0, 1, 0, '2018-10-26 08:58:58', 0),
(203, 202, '添加', '', '', '', 'dismantling_envelopes', 'add', 'index.php?module=dismantling_envelopes&action=add', 100, 4, 0, 1, 0, '2018-10-26 09:00:09', 0),
(204, 202, '修改', '', '', '', 'dismantling_envelopes', 'modify', 'index.php?module=dismantling_envelopes&action=modify', 100, 4, 0, 1, 0, '2018-10-26 09:00:41', 0),
(205, 202, '启用/禁用', '', '', '', 'dismantling_envelopes', 'whether', 'index.php?module=dismantling_envelopes&action=whether', 100, 4, 0, 1, 0, '2018-10-26 09:01:10', 0),
(206, 202, '删除', '', '', '', 'dismantling_envelopes', 'del', 'index.php?module=dismantling_envelopes&action=del', 100, 4, 0, 1, 0, '2018-10-26 09:01:42', 0),
(207, 202, '浏览', '', '', '', 'dismantling_envelopes', 'Index', 'index.php?module=dismantling_envelopes&action=Index', 100, 4, 0, 1, 0, '2018-10-26 09:02:05', 0),
(209, 201, '记录', '', '', '', 'dismantling_envelopes', 'list', 'index.php?module=dismantling_envelopes&action=list', 100, 3, 0, 1, 0, '2018-10-26 09:03:08', 0),
(211, 153, '满减', '', '', '', 'subtraction', 'Index', 'index.php?module=subtraction&action=Index', 8, 2, 0, 1, 0, '2018-10-26 09:08:39', 0),
(281, 153, '砍价', '', '', '', 'bargain', 'Index', 'index.php?module=bargain&action=Index', 100, 2, 0, 1, 0, '2018-12-18 07:54:11', 0),
(218, 269, '积分配置', '', '', '', 'software', 'jifen', 'index.php?module=software&action=jifen', 100, 2, 0, 0, 1, '2018-10-26 09:15:31', 0),
(219, 0, 'APP设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768745668.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768749874.png', '', '', '', 100, 1, 0, 0, 2, '2018-10-26 09:19:40', 0),
(220, 219, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index&m=2', 100, 2, 0, 0, 2, '2018-10-26 09:20:02', 0),
(221, 220, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 2, '2018-10-26 09:20:40', 0),
(222, 220, '修改', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 2, '2018-10-26 09:21:06', 0),
(223, 220, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 2, '2018-10-26 09:21:28', 0),
(224, 220, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 2, '2018-10-26 09:21:53', 0),
(256, 44, '佣金日志', '', '', '', 'distribution', 'commission', 'index.php?module=distribution&action=commission', 100, 3, 0, 1, 0, '2018-12-14 04:00:27', 0),
(240, 101, '设置默认', '', '', '', 'freight', 'Is_default', 'index.php?module=freight&action=Is_default', 100, 3, 0, 0, 0, '2018-11-21 08:20:44', 0),
(246, 86, '导航配置', '', '', '', 'software', 'navigation', 'index.php?module=software&action=navigation', 4, 2, 0, 0, 0, '2018-11-23 09:55:36', 1),
(259, 258, '添加', '', '', '', 'member', 'Add', 'index.php?module=member&action=Add', 100, 3, 0, 0, 0, '2019-09-20 06:17:56', 0),
(260, 258, '修改', '', '', '', 'member', 'Modify', 'index.php?module=member&action=Modify', 100, 3, 0, 0, 0, '2019-09-20 06:18:08', 0),
(261, 258, '删除', '', '', '', 'member', 'Del', 'index.php?module=member&action=Del', 100, 3, 0, 0, 0, '2019-09-20 06:18:20', 0),
(262, 258, '启用/禁用', '', '', '', 'member', 'Status', 'index.php?module=member&action=Status', 100, 3, 0, 0, 0, '2019-09-20 06:18:35', 0),
(269, 0, '小程序设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768781361.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768790321.png', '', '', '', 100, 1, 0, 0, 1, '2018-12-14 11:12:39', 0),
(282, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 2, 1, 0, 0, 2, '2018-12-18 09:00:33', 0),
(275, 269, '支付设置', '', '', '', 'system', 'Pay', 'index.php?module=system&action=Pay', 100, 2, 0, 0, 1, '2019-09-30 09:34:01', 1),
(276, 0, '报表管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768890262.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768894221.png', '', '', '', 100, 1, 0, 0, 6, '2018-12-17 09:16:07', 0),
(277, 0, '商户管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768997927.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768980615.png', '', '', '', 1, 1, 1, 0, 0, '2018-12-18 03:43:03', 0),
(283, 282, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 2, '2018-12-18 09:01:02', 0),
(284, 283, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 3, 0, 0, 2, '2018-12-18 09:02:30', 0),
(285, 283, '修改', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 2, '2018-12-18 09:03:11', 0),
(286, 283, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 2, '2018-12-18 09:03:33', 0),
(287, 86, '售后地址管理', '', '', '', 'sale', 'Index', 'index.php?module=sale&action=Index', 100, 2, 0, 0, 0, '2018-12-19 10:50:49', 0),
(288, 287, '添加', '', '', '', 'sale', 'add', 'index.php?module=sale&action=add', 100, 3, 0, 0, 0, '2018-12-19 10:51:08', 0),
(289, 287, '修改', '', '', '', 'sale', 'modify', 'index.php?module=sale&action=modify', 100, 3, 0, 0, 0, '2018-12-19 10:51:47', 0),
(290, 287, '删除', '', '', '', 'sale', 'del', 'index.php?module=sale&action=del', 100, 3, 0, 0, 0, '2018-12-19 10:52:10', 0),
(291, 287, '设置默认', '', '', '', 'sale', 'is_default', 'index.php?module=sale&action=is_default', 100, 3, 0, 0, 0, '2018-12-19 10:53:06', 0),
(292, 287, '浏览', '', '', '', 'sale', 'Index', 'index.php?module=sale&action=Index', 100, 3, 0, 0, 0, '2018-12-19 10:53:26', 0),
(293, 276, '报表管理', '', '', '', 'report', 'Index', 'index.php?module=report&action=Index', 100, 2, 0, 0, 6, '2018-12-20 07:02:22', 0),
(294, 293, '新增会员', '', '', '', 'report', 'Index', 'index.php?module=report&action=Index', 100, 3, 0, 0, 6, '2018-12-20 07:03:15', 0),
(295, 293, '用户消费报表', '', '', '', 'report', 'UserConsume', 'index.php?module=report&action=UserConsume', 100, 3, 0, 0, 6, '2018-12-20 07:04:22', 0),
(296, 293, '用户比例', '', '', '', 'report', 'UserSource', 'index.php?module=report&action=UserSource', 100, 3, 0, 0, 6, '2018-12-20 07:04:54', 0),
(297, 276, '订单报表', '', '', '', 'report', 'OrderNum', 'index.php?module=report&action=OrderNum', 100, 2, 0, 0, 6, '2018-12-28 02:55:11', 0),
(298, 276, '商品报表', '', '', '', 'report', 'ProductNum', 'index.php?module=report&action=ProductNum', 100, 2, 0, 0, 6, '2018-12-28 02:56:22', 0),
(305, 74, '查看', '', '', '', 'role', 'See', 'index.php?module=role&action=See', 100, 3, 0, 0, 0, '2019-09-23 11:09:58', 0),
(300, 257, '客户端列表', '', '', '', 'client', 'Index', 'index.php?module=client&action=Index', 100, 2, 1, 0, 0, '2019-01-09 11:25:46', 0),
(301, 300, '添加', '', '', '', 'client', 'Add', 'index.php?module=client&action=Add', 100, 3, 1, 0, 0, '2019-09-23 11:08:01', 0),
(302, 300, '修改', '', '', '', 'client', 'Modify', 'index.php?module=client&action=Modify', 100, 3, 1, 0, 0, '2019-09-23 11:08:09', 0),
(303, 300, '删除', '', '', '', 'client', 'Del', 'index.php?module=client&action=Del', 100, 3, 1, 0, 0, '2019-09-23 11:08:18', 0),
(304, 300, '查看', '', '', '', 'client', 'See', 'index.php?module=client&action=See', 100, 3, 1, 0, 0, '2019-09-23 11:08:25', 0),
(306, 87, '查看详情', '', '', '', 'notice', 'article', 'index.php?module=notice&action=article', 100, 3, 0, 0, 0, '2019-01-11 02:34:43', 1),
(307, 17, '置顶', '', '', '', 'product_class', 'Stick', 'index.php?module=product_class&action=Stick', 100, 3, 0, 0, 0, '2019-09-25 06:42:18', 0),
(308, 17, '查看下级', '', '', '', 'product_class', 'Subordinate', 'index.php?module=product_class&action=Subordinate', 100, 3, 0, 0, 0, '2019-09-25 06:42:26', 0),
(309, 153, '竞拍', '', '', '', 'auction', 'Index', 'index.php?module=auction&action=Index', 101, 2, 0, 1, 0, '2019-01-14 07:05:07', 0),
(310, 246, '图片分组', '', '', '', 'software', 'group', 'index.php?module=software&action=group', 100, 3, 0, 0, 0, '2019-01-16 06:40:38', 1),
(311, 21, '图片分组', '', '', '', 'software', 'group', 'index.php?module=software&action=group', 100, 4, 0, 0, 0, '2019-01-16 06:44:36', 0),
(312, 21, '图片显示', '', '', '', 'system', 'Fupload', 'index.php?module=system&action=Fupload', 100, 4, 0, 0, 0, '2019-09-30 09:33:44', 0),
(313, 86, '支付管理', '', '', '', 'payment', 'Index', 'index.php?module=payment&action=Index', 100, 2, 0, 0, 0, '2019-01-18 07:53:43', 0),
(314, 313, '参数修改', '', '', '', 'payment', 'modify', 'index.php?module=payment&action=modify', 100, 3, 0, 0, 0, '2019-01-18 07:54:29', 0),
(315, 316, '支付设置', '', '', '', 'payment', 'set', 'index.php?module=payment&action=set', 100, 3, 1, 0, 0, '2019-01-18 07:54:57', 0),
(316, 353, '支付管理', '', '', '', 'payment', 'Index', 'index.php?module=payment&action=Index', 3, 1, 1, 0, 0, '2019-01-18 08:41:47', 0),
(317, 86, '短信配置', '', '', '', 'message', 'Index', 'index.php?module=message&action=Index', 100, 2, 0, 0, 0, '2019-01-21 00:52:27', 0),
(318, 317, '核心设置', '', '', '', 'message', 'config', 'index.php?module=message&action=config', 100, 3, 0, 0, 0, '2019-01-21 00:54:10', 0),
(319, 317, '短信模板', '', '', '', 'message', 'list', 'index.php?module=message&action=list', 100, 3, 0, 0, 0, '2019-01-21 00:55:15', 0),
(320, 319, '添加', '', '', '', 'message', 'addlist', 'index.php?module=message&action=addlist', 100, 4, 0, 0, 0, '2019-01-21 00:55:35', 0),
(321, 319, '修改', '', '', '', 'message', 'modifylist', 'index.php?module=message&action=modifylist', 100, 4, 0, 0, 0, '2019-01-21 00:56:22', 0),
(322, 319, '删除', '', '', '', 'message', 'dellist', 'index.php?module=message&action=dellist', 100, 4, 0, 0, 0, '2019-01-21 00:56:49', 0),
(323, 317, '短信列表', '', '', '', 'message', 'Index', 'index.php?module=message&action=Index', 100, 3, 0, 0, 0, '2019-01-21 00:57:44', 0),
(324, 323, '添加', '', '', '', 'message', 'add', 'index.php?module=message&action=add', 100, 4, 0, 0, 0, '2019-01-21 00:58:09', 0),
(325, 323, '修改', '', '', '', 'message', 'modify', 'index.php?module=message&action=modify', 100, 4, 0, 0, 0, '2019-01-21 00:58:44', 0),
(326, 323, '删除', '', '', '', 'message', 'del', 'index.php?module=message&action=del', 100, 4, 0, 0, 0, '2019-01-21 00:59:07', 0),
(327, 8, '库存管理', '', '', '', 'stock', 'Index', 'index.php?module=stock&action=Index', 100, 2, 0, 0, 0, '2019-01-22 06:49:49', 0),
(328, 327, '库存列表', '', '', '', 'stock', 'Index', 'index.php?module=stock&action=Index', 100, 3, 0, 0, 0, '2019-01-22 06:50:10', 0),
(329, 327, '库存预警', '', '', '', 'stock', 'Warning', 'index.php?module=stock&action=Warning', 100, 3, 0, 0, 0, '2019-09-27 05:51:43', 0),
(330, 327, '入货详情', '', '', '', 'stock', 'Enter', 'index.php?module=stock&action=Enter', 100, 3, 0, 0, 0, '2019-09-27 05:51:51', 0),
(331, 327, '出货详情', '', '', '', 'stock', 'Shipment', 'index.php?module=stock&action=Shipment', 100, 3, 0, 0, 0, '2019-09-27 05:51:58', 0),
(332, 327, '增加库存', '', '', '', 'stock', 'Add', 'index.php?module=stock&action=Add', 100, 3, 0, 0, 0, '2019-09-27 05:52:08', 0),
(333, 328, '库存详情', '', '', '', 'stock', 'See', 'index.php?module=stock&action=See', 100, 4, 0, 0, 0, '2019-09-27 05:52:16', 0),
(334, 329, '查看预警记录', '', '', '', 'stock', 'Seewarning', 'index.php?module=stock&action=Seewarning', 100, 4, 0, 0, 0, '2019-09-27 05:52:23', 0),
(337, 0, '推广图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768220442.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768224293.png', '', '', '', 1, 1, 0, 0, 2, '2019-01-25 07:23:13', 1),
(338, 337, '推广图列表', '', '', '', 'extension', 'Index', 'index.php?module=extension&action=Index', 100, 2, 0, 0, 2, '2019-01-25 07:24:00', 1),
(339, 338, '添加', '', '', '', 'extension', 'add', 'index.php?module=extension&action=add', 100, 3, 0, 0, 2, '2019-01-25 07:24:30', 1),
(340, 338, '修改', '', '', '', 'extension', 'modify', 'index.php?module=extension&action=modify', 100, 3, 0, 0, 2, '2019-01-25 07:25:08', 1),
(341, 338, '删除', '', '', '', 'extension', 'del', 'index.php?module=extension&action=del', 100, 3, 0, 0, 2, '2019-01-25 07:25:26', 1),
(342, 338, '清理推广图', '', '', '', 'extension', 'del_simg', 'index.php?module=extension&action=del_simg', 100, 3, 0, 0, 2, '2019-01-25 07:26:36', 1),
(395, 219, 'H5配置', '', '', '', 'system', 'App', 'index.php?module=system&action=App', 100, 2, 0, 0, 2, '2019-09-30 09:35:02', 0),
(344, 146, '查看详情', '', '', '', 'Customer', 'See', 'index.php?module=Customer&action=See', 100, 3, 1, 0, 0, '2019-09-20 04:04:39', 0),
(345, 0, '公告管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769084517.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769079478.png', '', '', '', 100, 1, 1, 0, 0, '2019-01-31 09:52:24', 0),
(346, 345, '系统公告', '', '', '', 'systemtell', 'Index', 'index.php?module=systemtell&action=Index', 100, 2, 1, 0, 0, '2019-01-31 09:53:10', 0),
(347, 346, '添加', '', '', '', 'systemtell', 'add', 'index.php?module=systemtell&action=add', 100, 3, 1, 0, 0, '2019-01-31 09:53:43', 0),
(348, 346, '修改', '', '', '', 'systemtell', 'modify', 'index.php?module=systemtell&action=modify', 100, 3, 1, 0, 0, '2019-01-31 09:54:18', 0),
(349, 346, '删除', '', '', '', 'systemtell', 'del', 'index.php?module=systemtell&action=del', 100, 3, 1, 0, 0, '2019-01-31 09:54:49', 0),
(350, 346, '浏览', '', '', '', 'systemtell', 'Index', 'index.php?module=systemtell&action=Index', 100, 3, 1, 0, 0, '2019-01-31 09:55:08', 0),
(351, 2, '编辑会员信息', '', '', '', 'userlist', 'Modify', 'index.php?module=userlist&action=Modify', 100, 3, 0, 0, 0, '2019-02-01 05:51:42', 0),
(352, 9, '显示图片', '', '', '', 'system', 'Fupload', 'index.php?module=system&action=Fupload', 100, 3, 0, 0, 0, '2019-09-30 09:35:21', 0),
(353, 0, '权限管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769445242.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769454769.png', '', '', '', 2, 1, 1, 0, 0, '2019-02-11 03:11:09', 0),
(354, 353, '菜单列表', '', '', '', 'menu', 'Index', 'index.php?module=menu&action=Index', 1, 2, 1, 0, 0, '2019-02-11 03:12:01', 0),
(355, 354, '添加', '', '', '', 'add', 'Index', 'index.php?module=add&action=Index', 100, 3, 1, 0, 0, '2019-02-11 03:12:28', 0),
(356, 354, '修改', '', '', '', 'menu', 'Modify', 'index.php?module=menu&action=Modify', 100, 3, 1, 0, 0, '2019-09-25 01:51:32', 0),
(357, 354, '删除', '', '', '', 'del', 'Index', 'index.php?module=del&action=Index', 100, 3, 1, 0, 0, '2019-02-11 03:14:01', 0),
(358, 353, '客户端列表', '', '', '', 'client', 'Index', 'index.php?module=client&action=Index', 2, 2, 1, 0, 0, '2019-02-11 03:29:00', 0),
(359, 358, '添加', '', '', '', 'client', 'Add', 'index.php?module=client&action=Add', 100, 3, 1, 0, 0, '2019-09-23 11:08:38', 0),
(360, 358, '查看', '', '', '', 'client', 'See', 'index.php?module=client&action=See', 100, 3, 1, 0, 0, '2019-09-23 11:08:44', 0),
(361, 358, '修改', '', '', '', 'client', 'Modify', 'index.php?module=client&action=Modify', 100, 3, 1, 0, 0, '2019-09-23 11:08:51', 0),
(362, 358, '删除', '', '', '', 'client', 'Del', 'index.php?module=client&action=Del', 100, 3, 1, 0, 0, '2019-09-23 11:08:58', 0),
(363, 316, '参数修改', '', '', '', 'payment', 'modify', 'index.php?module=payment&action=modify', 100, 3, 1, 0, 0, '2019-02-11 09:24:06', 0),
(364, 0, '图片管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769185257.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769192751.png', '', '', '', 10, 1, 1, 0, 0, '2019-02-11 09:27:55', 0),
(365, 364, '图片管理', '', '', '', 'setupload', 'Index', 'index.php?module=setupload&action=Index', 100, 2, 1, 0, 0, '2019-02-11 09:28:47', 0),
(366, 0, '插件管理', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/155376953062.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769535290.png', '', '', '', 100, 1, 1, 0, 0, '2019-02-11 09:29:16', 0),
(367, 0, '数据字典', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769244965.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553769239411.png', '', '', '', 100, 1, 1, 0, 0, '2019-02-11 09:32:57', 0),
(368, 367, '数据字典列表', '', '', '', 'data_dictionary', 'Index', 'index.php?module=data_dictionary&action=Index', 100, 2, 1, 0, 0, '2019-02-11 09:33:45', 0),
(369, 368, '添加数据字典', '', '', '', 'data_dictionary', 'Add', 'index.php?module=data_dictionary&action=Add', 100, 3, 0, 0, 0, '2019-09-18 01:36:06', 0),
(370, 368, '修改数据字典', '', '', '', 'data_dictionary', 'Modify', 'index.php?module=data_dictionary&action=Modify', 100, 3, 0, 0, 0, '2019-09-18 01:36:14', 0),
(419, 368, '数据名称管理', '', '', '', 'data_dictionary', 'List', 'index.php?module=data_dictionary&action=List', 100, 3, 0, 0, 0, '2019-09-18 01:53:28', 0),
(371, 368, '删除', '', '', '', 'data_dictionary', 'Del', 'index.php?module=data_dictionary&action=Del', 100, 3, 1, 0, 0, '2019-02-11 09:35:26', 0),
(372, 269, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index&m=1', 100, 2, 0, 0, 1, '2019-02-14 06:46:43', 0),
(373, 372, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 1, '2019-02-14 06:47:08', 0),
(374, 372, '修改', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 1, '2019-02-14 06:48:00', 0),
(375, 372, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 1, '2019-02-14 06:48:18', 0),
(376, 372, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 1, '2019-02-14 06:49:01', 0),
(377, 364, '图标管理', '', '', '', 'software', 'navindex', 'index.php?module=software&action=navindex', 100, 2, 1, 0, 0, '2019-02-18 07:00:45', 0),
(378, 377, '添加', '', '', '', 'software', 'nav', 'index.php?module=software&action=nav', 100, 3, 1, 0, 0, '2019-02-18 07:01:17', 0),
(379, 377, '修改', '', '', '', 'software', 'nav', 'index.php?module=software&action=nav', 100, 3, 1, 0, 0, '2019-02-18 07:01:52', 0),
(380, 377, '删除', '', '', '', 'software', 'navindex', 'index.php?module=software&action=navindex', 100, 3, 1, 0, 0, '2019-02-18 07:02:23', 0),
(381, 86, '系统设置', '', '', '', 'system', 'Config', 'index.php?module=system&action=Config', 100, 2, 0, 0, 0, '2019-09-30 09:35:31', 0),
(382, 381, '关于我们', '', '', '', 'system', 'Aboutus', 'index.php?module=system&action=Aboutus', 100, 3, 0, 0, 0, '2019-02-19 03:47:39', 0),
(383, 381, '协议配置', '', '', '', 'system', 'Agreement', 'index.php?module=system&action=Agreement', 100, 3, 0, 0, 0, '2019-02-19 03:48:14', 0),
(384, 383, '添加', '', '', '', 'system', 'Agreement_add', 'index.php?module=system&action=Agreement_add', 100, 4, 0, 0, 0, '2019-02-19 03:50:45', 0),
(385, 383, '修改', '', '', '', 'system', 'Agreement_modify', 'index.php?module=system&action=Agreement_modify', 100, 4, 0, 0, 0, '2019-02-19 03:52:04', 0),
(386, 383, '删除', '', '', '', 'system', 'Agreement_del', 'index.php?module=system&action=Agreement_del', 100, 4, 0, 0, 0, '2019-02-19 03:52:38', 0),
(387, 32, '订单发货', '', '', '', 'orderslist', 'delivery', 'index.php?module=orderslist&action=delivery', 100, 3, 0, 0, 0, '2019-02-22 09:38:20', 0),
(393, 392, '消息管理', '', '', '', 'third', 'TemplateMsg', 'index.php?module=third&action=TemplateMsg', 100, 2, 1, 0, 0, '2019-03-23 07:02:05', 1),
(396, 392, '参数设置', '', '', '', 'third', 'ThirdInfo', 'index.php?module=third&action=ThirdInfo', 100, 2, 1, 0, 0, '2019-04-04 09:32:43', 0),
(397, 56, '钱包参数', '', '', '', 'finance', 'config', 'index.php?module=finance&action=config', 100, 3, 0, 0, 0, '2019-04-08 02:19:43', 0),
(398, 269, '模板消息', '', '', '', 'system', 'Template_message', 'index.php?module=system&action=Template_message', 100, 2, 0, 0, 1, '2019-09-30 09:35:54', 0),
(399, 0, '会员管理111', '', '', '', '', '', '', 100, 1, 0, 0, 0, '2019-05-06 10:30:28', 1),
(400, 116, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 1, '2019-05-14 11:49:57', 0),
(401, 283, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 2, '2019-05-14 11:50:15', 0),
(402, 86, '搜索配置', '', '', '', 'search_configuration', 'Index', 'index.php?module=search_configuration&action=Index', 100, 2, 0, 0, 0, '2019-05-16 03:08:47', 0),
(403, 9, '编辑商品', 'product', '', '', 'product', 'Copy', 'index.php?module=product&action=Copy', 100, 3, 0, 0, 0, '2019-09-25 07:46:54', 0),
(404, 8, '淘宝助手', '', '', '', 'taobao', 'Index', 'index.php?module=taobao&action=Index', 100, 2, 0, 0, 0, '2019-07-08 02:03:44', 0),
(412, 2, '编辑等级', '', '', '', 'userlist', 'GradeModify', 'index.php?module=userlist&action=GradeModify', 100, 3, 0, 0, 0, '2019-07-24 06:29:59', 0),
(411, 2, '添加等级', '', '', '', 'userlist', 'GradeAdd', 'index.php?module=userlist&action=GradeAdd', 100, 3, 0, 0, 0, '2019-07-24 06:29:27', 0),
(410, 2, '会员等级', '', '', '', 'userlist', 'Grade', 'index.php?module=userlist&action=Grade', 100, 3, 0, 0, 0, '2019-07-24 06:28:52', 0),
(409, 2, '会员设置', '', '', '', 'userlist', 'Config', 'index.php?module=userlist&action=Config', 100, 3, 0, 0, 0, '2019-07-24 06:28:13', 0),
(413, 2, '添加会员', '', '', '', 'userlist', 'Add', 'index.php?module=userlist&action=Add', 100, 3, 0, 0, 0, '2019-07-24 06:30:37', 0),
(414, 32, '订单关闭', '', '', '', 'orderslist', 'close', 'index.php?module=orderslist&action=close', 100, 3, 0, 0, 0, '2019-07-26 02:37:11', 0),
(415, 31, '打印单据', '', '', '', 'invoice', 'Index', 'index.php?module=invoice&action=Index', 100, 2, 0, 0, 0, '2019-08-28 07:29:33', 0),
(416, 404, '查看详情', '', '', '', 'taobao', 'see', 'index.php?module=taobao&action=see', 100, 3, 0, 0, 0, '2019-09-05 07:43:19', 0),
(417, 0, '托尔斯泰1', '', '', '', '', '', '', 100, 1, 0, 0, 0, '2019-09-16 07:31:09', 0),
(418, 277, 'gdfsgd', '', '', '', 'ndex.php?http://www.360doc.com/content/18/0106/10/51243390_7', 'Index', 'index.php?http://www.360doc.com/content/18/0106/10/51243390_', 100, 2, 0, 0, 0, '2019-09-16 08:24:10', 0),
(420, 368, '添加数据名称', '', '', '', 'data_dictionary', 'Add_name', 'index.php?module=data_dictionary&action=Add_name', 100, 3, 1, 0, 0, '2019-09-17 03:32:51', 0),
(421, 368, '编辑数据名称', '', '', '', 'data_dictionary', 'Modify_name', 'index.php?module=data_dictionary&action=Modify_name', 100, 3, 1, 0, 0, '2019-09-17 03:33:16', 0),
(422, 368, '删除数据名称', '', '', '', 'data_dictionary', 'Del_name', 'index.php?module=data_dictionary&action=Del_name', 100, 3, 1, 0, 0, '2019-09-17 03:33:44', 0),
(423, 0, '轮播图配置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767814501.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553767818339.png', '', '', '', 100, 1, 0, 0, 7, '2019-09-17 03:50:17', 0),
(424, 423, '轮播图列表', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 2, 0, 0, 7, '2019-09-17 03:53:13', 0),
(425, 424, '添加', '', '', '', 'banner', 'Add', 'index.php?module=banner&action=Add', 100, 2, 0, 0, 7, '2019-09-17 03:53:33', 0),
(426, 424, '修改', '', '', '', 'banner', 'Modify', 'index.php?module=banner&action=Modify', 100, 3, 0, 0, 7, '2019-09-17 03:54:01', 0),
(427, 424, '删除', '', '', '', 'banner', 'Del', 'index.php?module=banner&action=Del', 100, 3, 0, 0, 7, '2019-09-17 03:54:21', 0),
(428, 424, '浏览', '', '', '', 'banner', 'Index', 'index.php?module=banner&action=Index', 100, 3, 0, 0, 7, '2019-09-17 03:54:59', 0),
(429, 424, '置顶', '', '', '', 'banner', 'Stick', 'index.php?module=banner&action=Stick', 100, 3, 0, 0, 7, '2019-09-17 03:55:25', 0),
(430, 0, '支付宝小程序设置', '', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768781361.png', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1553768790321.png', '', '', '', 100, 1, 0, 0, 7, '2019-09-17 06:18:52', 0),
(431, 430, '引导图', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index&m=7', 100, 2, 0, 0, 7, '2019-09-17 06:20:04', 0),
(432, 431, '添加', '', '', '', 'guide', 'Add', 'index.php?module=guide&action=Add', 100, 3, 0, 0, 7, '2019-09-17 06:20:33', 0),
(433, 431, '修改', '', '', '', 'guide', 'Modify', 'index.php?module=guide&action=Modify', 100, 3, 0, 0, 7, '2019-09-17 06:20:57', 0),
(434, 431, '删除', '', '', '', 'guide', 'Del', 'index.php?module=guide&action=Del', 100, 3, 0, 0, 7, '2019-09-17 06:21:50', 0),
(435, 431, '浏览', '', '', '', 'guide', 'Index', 'index.php?module=guide&action=Index', 100, 3, 0, 0, 7, '2019-09-17 06:22:13', 0),
(500, 31, '打印单据', '', '', '', 'invoice', 'indexx', 'index.php?module=invoice&action=indexx', 100, 2, 0, 0, 0, '2019-09-25 08:49:24', 1),
(501, 0, '基本设置', '', '', '', '', '', '', 100, 1, 0, 0, 1, '2019-09-20 01:38:02', 0);

-- ----------------------------
-- Table structure for lkt_coupon
-- ----------------------------
DROP TABLE IF EXISTS `lkt_coupon`;
CREATE TABLE `lkt_coupon`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `money` int(11) NOT NULL DEFAULT 0 COMMENT '优惠券金额',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '领取时间',
  `expiry_time` timestamp NULL DEFAULT NULL COMMENT '到期时间',
  `hid` int(11) NOT NULL DEFAULT 0 COMMENT '活动id',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0.未使用 1.使用中 2.已使用 3.已过期',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态 0.开启 1.禁用',
  `recycle` tinyint(4) DEFAULT '0' COMMENT '回收站 0.不回收 1.回收',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '优惠券表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_coupon_activity
-- ----------------------------
DROP TABLE IF EXISTS `lkt_coupon_activity`;
CREATE TABLE `lkt_coupon_activity` (
  `id` int(11) unsigned  PRIMARY KEY  NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `name` varchar(25) NOT NULL COMMENT '优惠券名称',
  `activity_type` int(11) DEFAULT '0' COMMENT '优惠券类型',
  `grade_id` int(11) DEFAULT '0' COMMENT '会员等级ID' ,
  `money` decimal(12,2) DEFAULT '0.00' COMMENT '优惠券面值',
  `discount` decimal(12,2) DEFAULT '0.00' COMMENT '折扣值',
  `z_money` decimal(12,2) DEFAULT '0.00' COMMENT '消费满多少',
  `shopping` int(11) NOT NULL DEFAULT '0' COMMENT '满多少赠券',
  `free_mail_task` tinyint(4) NOT NULL DEFAULT '0' COMMENT '免邮任务 0：完善资料 1：绑定手机',
  `circulation` int(11) DEFAULT NULL COMMENT '发行数量',
  `num` int(11) DEFAULT NULL COMMENT '剩余数量',
  `receive` int(11) DEFAULT NULL COMMENT '领取限制',
  `use_num` int(11) DEFAULT NULL COMMENT '使用限制',
  `start_time` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `type` tinyint(4) DEFAULT '1' COMMENT '优惠券使用范围 1：全部商品 2:指定商品 3：指定分类',
  `product_class_id` text COMMENT '活动指定商品类型id',
  `product_id` text COMMENT '活动指定商品id',
  `content` text COMMENT '备注',
  `skip_type` tinyint(4) DEFAULT '1' COMMENT '跳转方式 1.首页 2.\r\n\r\n自定义',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转路径',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态 0：未启用 1：启用 2:禁用 3：已结束',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `qualifications` text COMMENT '资格',
  `recycle` tinyint(4) DEFAULT '0' COMMENT '回收站 0.不回收 1.回收',
  `day` int(11) DEFAULT '0' COMMENT '有效时间',
  `Instructions` text COMMENT '使用说明'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优惠劵活动表';

-- ----------------------------
-- Table structure for lkt_coupon_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_coupon_config`;
CREATE TABLE `lkt_coupon_config` (
  `id` int(11) unsigned  PRIMARY KEY  NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `is_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0：未启用 1：启用',
  `coupon_del` tinyint(4) DEFAULT NULL COMMENT '优惠券删除',
  `coupon_day` int(11) DEFAULT NULL COMMENT '优惠券删除天数',
  `activity_del` tinyint(4) DEFAULT NULL COMMENT '优惠券活动删除',
  `activity_day` int(11) DEFAULT NULL COMMENT '优惠券活动删除天数',
  `payment_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付设置 0：只使用优惠券 1：可与其他优惠一起使用',
  `limit_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '限领设置 0：单张 1：多张',
  `coupon_type` text COMMENT '优惠券类型',
  `modify_date` timestamp NULL DEFAULT NULL COMMENT '修改时间'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='优惠券设置表';

-- ----------------------------
-- Table structure for lkt_customer
-- ----------------------------
DROP TABLE IF EXISTS `lkt_customer`;
CREATE TABLE `lkt_customer` (
  `id` int(11) unsigned  PRIMARY KEY  NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `customer_number` varchar(250) DEFAULT NULL COMMENT '客户编号',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `company` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名称',
  `function` text NOT NULL COMMENT '功能',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '购买时间',
  `end_date` timestamp NULL DEFAULT NULL COMMENT '到期时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型 0:启用 1:到期 2:锁定',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `recycle` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回收站 0:不回收 1:回收 '
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商城表';

-- ----------------------------
-- Records of lkt_customer
-- ----------------------------
INSERT INTO `lkt_customer` VALUES (1, 2, 'news2', 'news2', '18774078152', 33333.00, 'news2', '2', '2019-04-17 03:45:49', '2020-11-01 15:59:59', 0, 'admin', 0);

-- ----------------------------
-- Table structure for lkt_data_dictionary
-- ----------------------------
DROP TABLE IF EXISTS `lkt_data_dictionary`;
CREATE TABLE `lkt_data_dictionary`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '编码',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新内容',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否生效 0:不是 1:是',
  `admin_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员名称',
  `recycle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '回收站 0:正常 1:回收',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '数据字典表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_data_dictionary
-- ----------------------------

INSERT INTO `lkt_data_dictionary` (`id`, `code`, `name`, `value`, `status`, `admin_name`, `recycle`, `add_date`) VALUES
(1, 'LKT_FY_001', '分页', '10,10', 1, 'admin', 0, '2019-01-25 01:46:45'),
(2, 'LKT_FY_002', '分页', '25,25', 1, 'admin', 0, '2019-01-25 01:46:31'),
(3, 'LKT_FY_003', '分页', '50,50', 1, 'admin', 0, '2019-01-25 01:46:22'),
(4, 'LKT_FY_004', '分页', '100,100', 1, 'admin', 0, '2019-01-25 01:47:16'),
(5, 'LKT_SPLX_001', '商品类型', '1,新品', 1, 'admin', 0, '2019-01-25 04:31:23'),
(6, 'LKT_SPLX_002', '商品类型', '2,热销', 1, 'admin', 0, '2019-01-25 04:31:50'),
(7, 'LKT_SPLX_003', '商品类型', '3,推荐', 1, 'admin', 0, '2019-01-25 04:32:09'),
(8, 'LKT_SPZT_001', '商品状态', '3,下架', 1, 'admin', 0, '2019-06-13 08:04:05'),
(9, 'LKT_SPZT_002', '商品状态', '2,上架', 1, 'admin', 0, '2019-06-13 08:03:21'),
(10, 'LKT_DDZT_001', '订单状态', '0,待付款', 1, 'admin', 0, '2019-01-25 07:11:24'),
(11, 'LKT_DDZT_002', '订单状态', '1,待发货', 1, 'admin', 0, '2019-01-25 07:11:17'),
(12, 'LKT_DDZT_003', '订单状态', '2,待收货', 1, 'admin', 0, '2019-01-25 07:11:10'),
(13, 'LKT_DDZT_004', '订单状态', '3,待评价', 1, 'admin', 0, '2019-01-25 07:11:01'),
(14, 'LKT_DDZT_005', '订单状态', '4,退货', 1, 'admin', 0, '2019-01-25 07:14:05'),
(15, 'LKT_DDZT_006', '订单状态', '5,已完成', 1, 'admin', 0, '2019-01-25 07:14:35'),
(16, 'LKT_DDZT_007', '订单状态', '6,已关闭', 1, 'admin', 0, '2019-01-25 07:14:58'),
(17, 'LKT_LY_001', '来源', '1,小程序', 1, 'admin', 0, '2019-01-29 01:47:34'),
(18, 'LKT_LY_002', '来源', '2,APP', 1, 'admin', 0, '2019-01-29 01:47:47'),
(19, 'LKT_THZT_001', '退货状态', '1,审核中', 1, 'admin', 0, '2019-01-29 01:56:30'),
(20, 'LKT_THZT_002', '退货状态', '2,待买家发货', 1, 'admin', 0, '2019-01-29 01:56:52'),
(21, 'LKT_THZT_003', '退货状态', '3,已拒绝', 1, 'admin', 0, '2019-01-29 01:57:12'),
(22, 'LKT_THZT_004', '退货状态', '4,待商家收货', 1, 'admin', 0, '2019-01-29 01:57:34'),
(23, 'LKT_THZT_005', '退货状态', '5,已退款', 1, 'admin', 0, '2019-01-29 01:57:53'),
(24, 'LKT_THZT_006', '退货状态', '6,拒绝并退回商品', 1, 'admin', 0, '2019-01-29 01:58:10'),
(25, 'LKT_PJ_001', '评价', '0,全部', 1, 'admin', 0, '2019-01-29 02:03:37'),
(26, 'LKT_PJ_002', '评价', 'GOOD,好评', 1, 'admin', 0, '2019-01-29 02:04:04'),
(27, 'LKT_PJ_003', '评价', 'NOTBAD,中评', 1, 'admin', 0, '2019-01-29 02:04:30'),
(28, 'LKT_PJ_004', '评价', 'BAD,差评', 1, 'admin', 0, '2019-01-29 02:04:51'),
(29, 'LKT_DW_001', '单位', '盒,盒', 1, 'admin', 0, '2019-02-27 09:12:50'),
(30, 'LKT_DW_002', '单位', '篓,篓', 1, 'admin', 0, '2019-02-27 09:13:13'),
(31, 'LKT_DW_003', '单位', '箱,箱', 1, 'admin', 0, '2019-02-27 09:13:36'),
(32, 'LKT_DW_004', '单位', '个,个', 1, 'admin', 0, '2019-02-27 09:13:58'),
(33, 'LKT_DW_005', '单位', '套,套', 1, 'admin', 0, '2019-02-27 09:14:16'),
(34, 'LKT_DW_006', '单位', '包,包', 1, 'admin', 0, '2019-02-27 09:46:28'),
(35, 'LKT_DW_007', '单位', '支,支', 1, 'admin', 0, '2019-02-27 09:46:44'),
(36, 'LKT_DW_008', '单位', '条,条', 1, 'admin', 0, '2019-02-27 09:47:01'),
(37, 'LKT_DW_009', '单位', '根,根', 1, 'admin', 0, '2019-02-27 09:47:14'),
(38, 'LKT_DW_010', '单位', '本,本', 1, 'admin', 0, '2019-02-27 09:47:27'),
(39, 'LKT_DW_011', '单位', '瓶,瓶', 1, 'admin', 0, '2019-02-27 09:47:51'),
(40, 'LKT_DW_012', '单位', '块,块', 1, 'admin', 0, '2019-02-27 09:48:05'),
(41, 'LKT_DW_013', '单位', '片,片', 1, 'admin', 0, '2019-02-27 09:48:17'),
(42, 'LKT_DW_014', '单位', '把,把', 1, 'admin', 0, '2019-02-27 09:48:30'),
(43, 'LKT_DW_015', '单位', '组,组', 1, 'admin', 0, '2019-02-27 09:48:45'),
(44, 'LKT_DW_016', '单位', '双,双', 1, 'admin', 0, '2019-02-27 09:49:03'),
(45, 'LKT_DW_017', '单位', '台,台', 1, 'admin', 0, '2019-02-27 09:49:25'),
(46, 'LKT_DW_018', '单位', '件,件', 1, 'admin', 0, '2019-02-27 09:49:39'),
(47, 'LKT_SPZSWZ_001', '商品展示位置', '1,首页', 1, 'admin', 0, '2019-03-04 10:48:07'),
(48, 'LKT_SPZSWZ_002', '商品展示位置', '2,购物车', 1, 'admin', 0, '2019-03-08 02:07:17'),
(49, 'LKT_XCXMBXY_001', '小程序模板行业', '1,广告', 1, 'admin', 0, '2019-03-21 08:11:19'),
(50, 'LKT_XCXMBXY_002', '小程序模板行业', '2,生活', 1, 'admin', 0, '2019-03-21 08:13:07'),
(51, 'LKT_XCXMBXY_003', '小程序模板行业', '3,电影', 1, 'admin', 0, '2019-03-21 08:13:52'),
(52, 'LKT_SPZSWZ_003', '商品展示位置', '0,全部商品', 1, 'admin', 0, '2019-04-17 02:07:08'),
(53, 'LKT_SPZT_003', '商品状态', '1,待上架', 1, 'admin', 0, '2019-06-13 08:03:30'),
(54, 'LKT_LBTTZFS_001', '轮播图跳转方式', '1,商品分类', 1, 'admin', 0, '2019-05-14 11:50:52'),
(55, 'LKT_LBTTZFS_002', '轮播图跳转方式', '2,指定商品', 1, 'admin', 0, '2019-05-14 11:51:05'),
(56, 'LKT_LBTTZFS_003', '轮播图跳转方式', '3,不跳转', 1, 'admin', 0, '2019-05-14 11:51:28'),
(57, 'LKT_SPFL_001', '商品分类', '1,一级', 1, 'admin', 0, '2019-08-21 02:58:40'),
(58, 'LKT_SPFL_002', '商品分类', '2,二级', 1, 'admin', 0, '2019-08-21 02:59:03'),
(59, 'LKT_SPFL_003', '商品分类', '3,三级', 1, 'admin', 0, '2019-08-21 02:59:19'),
(60, 'LKT_SPFL_004', '商品分类', '4,四级', 1, 'admin', 0, '2019-08-21 02:59:39'),
(61, 'LKT_SPFL_005', '商品分类', '5,五级', 1, 'admin', 0, '2019-08-21 02:59:57'),
(62, 'LKT_SXM_001', '属性名', '1,颜色', 1, 'admin', 0, '2019-09-02 08:07:21'),
(63, 'LKT_SXM_002', '属性名', '2,尺码', 1, 'admin', 0, '2019-09-02 08:07:52'),
(64, 'LKT_SXZ_001', '属性值', '颜色,蓝色', 1, 'admin', 0, '2019-09-02 08:09:50'),
(65, 'LKT_SXZ_002', '属性值', '颜色,黑色', 1, 'admin', 0, '2019-09-02 10:58:11'),
(66, 'LKT_SXZ_003', '属性值', '颜色,红色', 1, 'admin', 0, '2019-09-02 10:58:30'),
(67, 'LKT_SXZ_004', '属性值', '颜色,黄色', 1, 'admin', 0, '2019-09-02 10:58:48'),
(68, 'LKT_SXZ_005', '属性值', '尺码,M', 1, 'admin', 1, '2019-09-02 11:00:04'),
(69, 'LKT_SXZ_006', '属性值', '尺码,L', 1, 'admin', 0, '2019-09-02 11:00:20'),
(70, 'LKT_SXZ_007', '属性值', '尺码,XL', 1, 'admin', 0, '2019-09-10 06:14:28'),
(71, 'LKT_SXZ_008', '属性值', '尺码,XXL', 1, 'admin', 0, '2019-09-10 06:14:48'),
(72, 'LKT_SXZ_009', '属性值', '尺码，M', 1, 'admin', 0, '2019-09-11 08:18:04');

-- ----------------------------
-- Table structure for lkt_distribution_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_distribution_config`;
CREATE TABLE `lkt_distribution_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `sets` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status`  int(5) NOT NULL DEFAULT 0 COMMENT '插件状态 0关闭 1开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分销设置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_distribution_config
-- ----------------------------

-- ----------------------------
-- Table structure for lkt_distribution_grade
-- ----------------------------
DROP TABLE IF EXISTS `lkt_distribution_grade`;
CREATE TABLE `lkt_distribution_grade`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `sets` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `datetime` datetime NOT NULL COMMENT '创建时间',
  `is_agent` int(2) NULL DEFAULT 0 COMMENT '是否为代理商',
  `is_ordinary` int(2) NULL DEFAULT 0 COMMENT '是否是普通分销商0 不是 1是',
  `transfer_balance` int(5) NULL DEFAULT 0 COMMENT '推荐后消费金转余额比例',
  `sort` int(4) NULL DEFAULT 1 COMMENT '排序号',
  `discount` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '购物折扣',
  `integral` int(12) NULL DEFAULT 0 COMMENT '积分',
  `member_proportion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '会员专区佣金比例',
  `member_consumer_money` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '会员专区消费金',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分销商等级表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_distribution_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_distribution_record`;
CREATE TABLE `lkt_distribution_record` (
  `id` int(11) unsigned  PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `user_id` char(15) DEFAULT NULL COMMENT '购买员',
  `from_id` char(15) DEFAULT NULL COMMENT '分销员',
  `money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '佣金金额',
  `sNo` varchar(255) DEFAULT NULL COMMENT '订单号',
  `level` int(5) DEFAULT NULL COMMENT '层级',
  `event` varchar(255) DEFAULT NULL COMMENT '事件',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型 1:转入(收入) 2:提现 3:个人进获奖8:充值积分',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `status` int(10) NOT NULL DEFAULT '0' COMMENT '是否发放'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='佣金日志表';

-- ----------------------------
-- Table structure for lkt_distribution_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `lkt_distribution_withdraw`;
CREATE TABLE `lkt_distribution_withdraw`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `wx_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信id',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `Bank_id` int(11) NOT NULL COMMENT '银行卡id',
  `money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '提现金额',
  `z_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '剩余金额',
  `s_charge` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0：审核中 1：审核通过 2：拒绝',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '申请时间',
  `refuse` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '拒绝原因',
  `is_mch` int(2) NULL DEFAULT 0 COMMENT '是否是店铺提现',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '提现列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_edition
-- ----------------------------
DROP TABLE IF EXISTS `lkt_edition`;
CREATE TABLE `lkt_edition`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `edition` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '版本号',
  `edition_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '路径',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否是热更新 0:是 1:不是',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '更新内容',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `appname` varchar(255) DEFAULT NULL,
  `android_url` varchar(100) DEFAULT NULL COMMENT 'android下载地址',
  `ios_url` varchar(100) DEFAULT NULL COMMENT 'ios下载地址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '版本表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_express
-- ----------------------------
DROP TABLE IF EXISTS `lkt_express`;
CREATE TABLE `lkt_express`  (
  `id` int(11) NOT NULL COMMENT 'id',
  `kuaidi_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递名称',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简称'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '快递公司' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of lkt_express
-- ----------------------------
INSERT INTO `lkt_express` VALUES (1, 'aae全球专递', 'aae');
INSERT INTO `lkt_express` VALUES (2, '安捷快递', 'anjie');
INSERT INTO `lkt_express` VALUES (3, '安信达快递', 'anxindakuaixi');
INSERT INTO `lkt_express` VALUES (4, '彪记快递', 'biaojikuaidi');
INSERT INTO `lkt_express` VALUES (5, 'bht', 'bht');
INSERT INTO `lkt_express` VALUES (6, '百福东方国际物流', 'baifudongfang');
INSERT INTO `lkt_express` VALUES (7, '中国东方（COE）', 'coe');
INSERT INTO `lkt_express` VALUES (8, '长宇物流', 'changyuwuliu');
INSERT INTO `lkt_express` VALUES (9, '大田物流', 'datianwuliu');
INSERT INTO `lkt_express` VALUES (10, '德邦物流', 'debangwuliu');
INSERT INTO `lkt_express` VALUES (11, 'dhl', 'dhl');
INSERT INTO `lkt_express` VALUES (12, 'dpex', 'dpex');
INSERT INTO `lkt_express` VALUES (13, 'd速快递', 'dsukuaidi');
INSERT INTO `lkt_express` VALUES (14, '递四方', 'disifang');
INSERT INTO `lkt_express` VALUES (15, 'ems快递', 'ems');
INSERT INTO `lkt_express` VALUES (16, 'fedex（国外）', 'fedex');
INSERT INTO `lkt_express` VALUES (17, '飞康达物流', 'feikangda');
INSERT INTO `lkt_express` VALUES (18, '凤凰快递', 'fenghuangkuaidi');
INSERT INTO `lkt_express` VALUES (19, '飞快达', 'feikuaida');
INSERT INTO `lkt_express` VALUES (20, '国通快递', 'guotongkuaidi');
INSERT INTO `lkt_express` VALUES (21, '港中能达物流', 'ganzhongnengda');
INSERT INTO `lkt_express` VALUES (22, '广东邮政物流', 'guangdongyouzhengwuliu');
INSERT INTO `lkt_express` VALUES (23, '共速达', 'gongsuda');
INSERT INTO `lkt_express` VALUES (24, '百世汇通', 'huitongkuaidi');
INSERT INTO `lkt_express` VALUES (25, '恒路物流', 'hengluwuliu');
INSERT INTO `lkt_express` VALUES (26, '华夏龙物流', 'huaxialongwuliu');
INSERT INTO `lkt_express` VALUES (27, '海红', 'haihongwangsong');
INSERT INTO `lkt_express` VALUES (28, '海外环球', 'haiwaihuanqiu');
INSERT INTO `lkt_express` VALUES (29, '佳怡物流', 'jiayiwuliu');
INSERT INTO `lkt_express` VALUES (30, '京广速递', 'jinguangsudikuaijian');
INSERT INTO `lkt_express` VALUES (31, '急先达', 'jixianda');
INSERT INTO `lkt_express` VALUES (32, '佳吉物流', 'jjwl');
INSERT INTO `lkt_express` VALUES (33, '加运美物流', 'jymwl');
INSERT INTO `lkt_express` VALUES (34, '金大物流', 'jindawuliu');
INSERT INTO `lkt_express` VALUES (35, '嘉里大通', 'jialidatong');
INSERT INTO `lkt_express` VALUES (36, '晋越快递', 'jykd');
INSERT INTO `lkt_express` VALUES (37, '快捷速递', 'kuaijiesudi');
INSERT INTO `lkt_express` VALUES (38, '联邦快递（国内）', 'lianb');
INSERT INTO `lkt_express` VALUES (39, '联昊通物流', 'lianhaowuliu');
INSERT INTO `lkt_express` VALUES (40, '龙邦物流', 'longbanwuliu');
INSERT INTO `lkt_express` VALUES (41, '立即送', 'lijisong');
INSERT INTO `lkt_express` VALUES (42, '乐捷递', 'lejiedi');
INSERT INTO `lkt_express` VALUES (43, '民航快递', 'minghangkuaidi');
INSERT INTO `lkt_express` VALUES (44, '美国快递', 'meiguokuaidi');
INSERT INTO `lkt_express` VALUES (45, '门对门', 'menduimen');
INSERT INTO `lkt_express` VALUES (46, 'OCS', 'ocs');
INSERT INTO `lkt_express` VALUES (47, '配思货运', 'peisihuoyunkuaidi');
INSERT INTO `lkt_express` VALUES (48, '全晨快递', 'quanchenkuaidi');
INSERT INTO `lkt_express` VALUES (49, '全峰快递', 'quanfengkuaidi');
INSERT INTO `lkt_express` VALUES (50, '全际通物流', 'quanjitong');
INSERT INTO `lkt_express` VALUES (51, '全日通快递', 'quanritongkuaidi');
INSERT INTO `lkt_express` VALUES (52, '全一快递', 'quanyikuaidi');
INSERT INTO `lkt_express` VALUES (53, '如风达', 'rufengda');
INSERT INTO `lkt_express` VALUES (54, '三态速递', 'santaisudi');
INSERT INTO `lkt_express` VALUES (55, '盛辉物流', 'shenghuiwuliu');
INSERT INTO `lkt_express` VALUES (56, '申通', 'shentong');
INSERT INTO `lkt_express` VALUES (57, '顺丰', 'shunfeng');
INSERT INTO `lkt_express` VALUES (58, '速尔物流', 'sue');
INSERT INTO `lkt_express` VALUES (59, '盛丰物流', 'shengfeng');
INSERT INTO `lkt_express` VALUES (60, '赛澳递', 'saiaodi');
INSERT INTO `lkt_express` VALUES (61, '天地华宇', 'tiandihuayu');
INSERT INTO `lkt_express` VALUES (62, '天天快递', 'tiantian');
INSERT INTO `lkt_express` VALUES (63, 'tnt', 'tnt');
INSERT INTO `lkt_express` VALUES (64, 'ups', 'ups');
INSERT INTO `lkt_express` VALUES (65, '万家物流', 'wanjiawuliu');
INSERT INTO `lkt_express` VALUES (66, '文捷航空速递', 'wenjiesudi');
INSERT INTO `lkt_express` VALUES (67, '伍圆', 'wuyuan');
INSERT INTO `lkt_express` VALUES (68, '万象物流', 'wxwl');
INSERT INTO `lkt_express` VALUES (69, '新邦物流', 'xinbangwuliu');
INSERT INTO `lkt_express` VALUES (70, '信丰物流', 'xinfengwuliu');
INSERT INTO `lkt_express` VALUES (71, '亚风速递', 'yafengsudi');
INSERT INTO `lkt_express` VALUES (72, '一邦速递', 'yibangwuliu');
INSERT INTO `lkt_express` VALUES (73, '优速物流', 'youshuwuliu');
INSERT INTO `lkt_express` VALUES (74, '邮政包裹挂号信', 'youzhengguonei');
INSERT INTO `lkt_express` VALUES (75, '邮政国际包裹挂号信', 'youzhengguoji');
INSERT INTO `lkt_express` VALUES (76, '远成物流', 'yuanchengwuliu');
INSERT INTO `lkt_express` VALUES (77, '圆通速递', 'yuantong');
INSERT INTO `lkt_express` VALUES (78, '源伟丰快递', 'yuanweifeng');
INSERT INTO `lkt_express` VALUES (79, '元智捷诚快递', 'yuanzhijiecheng');
INSERT INTO `lkt_express` VALUES (80, '韵达快运', 'yunda');
INSERT INTO `lkt_express` VALUES (81, '运通快递', 'yuntongkuaidi');
INSERT INTO `lkt_express` VALUES (82, '越丰物流', 'yuefengwuliu');
INSERT INTO `lkt_express` VALUES (83, '源安达', 'yad');
INSERT INTO `lkt_express` VALUES (84, '银捷速递', 'yinjiesudi');
INSERT INTO `lkt_express` VALUES (85, '宅急送', 'zhaijisong');
INSERT INTO `lkt_express` VALUES (86, '中铁快运', 'zhongtiekuaiyun');
INSERT INTO `lkt_express` VALUES (87, '中通速递', 'zhongtong');
INSERT INTO `lkt_express` VALUES (88, '中邮物流', 'zhongyouwuliu');
INSERT INTO `lkt_express` VALUES (89, '忠信达', 'zhongxinda');
INSERT INTO `lkt_express` VALUES (90, '芝麻开门', 'zhimakaimen');
INSERT INTO `lkt_express` VALUES (91, 'linexsolutions', 'linexsolutions');

-- ----------------------------
-- Table structure for lkt_extension
-- ----------------------------
DROP TABLE IF EXISTS `lkt_extension`;
CREATE TABLE `lkt_extension`  (
  `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商城id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `image` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片路径',
  `sort` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '100' COMMENT '排序号',
  `x` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT 'x坐标',
  `y` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT 'y坐标',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `kuan` int(5) NOT NULL DEFAULT 150 COMMENT '二维码宽度',
  `type` int(2) NOT NULL COMMENT '海报类型 1.文章海报 2.红包海报 3.商品海报 4.分销海报 5.邀请海报 6.竞拍海报',
  `keyword` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键词',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `isdefault` int(2) NULL DEFAULT 0 COMMENT '是否默认',
  `bg` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '背景图片',
  `color` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '颜色',
  `waittext` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '等待语',
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '排序的数据',
  `store_type` tinyint(4) NULL DEFAULT 1 COMMENT '来源 1.小程序 2.app',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '推广图片表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_extension
-- ----------------------------
INSERT INTO `lkt_extension` VALUES (1, '1', '商品分享', '', '100', '0', '0', '2019-03-14 09:41:58', 150, 3, '单肩包', NULL, 1, 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/app/1551682818256.jpeg', '#000', '稍等片刻...', '[{\"left\":\"233px\",\"top\":\"9px\",\"type\":\"qr\",\"width\":\"80px\",\"height\":\"80px\"},{\"left\":\"142px\",\"top\":\"28px\",\"type\":\"nickname\",\"width\":\"80px\",\"height\":\"40px\",\"size\":\"16px\",\"color\":\"#000\"},{\"left\":\"24px\",\"top\":\"18px\",\"type\":\"img\",\"width\":\"80px\",\"height\":\"80px\"},{\"left\":\"128px\",\"top\":\"291px\",\"type\":\"title\",\"width\":\"80px\",\"height\":\"80px\",\"size\":\"16px\",\"color\":\"#000\"},{\"left\":\"122px\",\"top\":\"174px\",\"type\":\"thumb\",\"width\":\"80px\",\"height\":\"80px\"}]', 1);
INSERT INTO `lkt_extension` VALUES (2, '1', '商品', '', '100', '0', '0', '2019-04-16 01:51:14', 150, 3, '商品', '/pages/goods/goodsDetailed', 1, 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1555060900394.jpeg', '', '请稍后...', '[{\"left\":\"86px\",\"top\":\"281px\",\"type\":\"qr\",\"width\":\"137px\",\"height\":\"137px\",\"size\":\"\"}]', 2);
INSERT INTO `lkt_extension` VALUES (3, '1', '分销模块', '', '100', '0', '0', '2019-04-16 01:50:23', 150, 4, '分销', '', 1, 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/2/155537937723.jpeg', '#000', '您的专属海报正在拼命生成中，请等待片刻...', '[{\"left\":\"91px\",\"top\":\"341px\",\"type\":\"qr\",\"width\":\"137px\",\"height\":\"137px\",\"size\":\"\"},{\"left\":\"91px\",\"top\":\"281.5px\",\"type\":\"head\",\"width\":\"54px\",\"height\":\"54px\"},{\"left\":\"153px\",\"top\":\"282px\",\"type\":\"nickname\",\"width\":\"75px\",\"height\":\"53px\",\"size\":\"16px\",\"color\":\"#000\"}]', 2);
INSERT INTO `lkt_extension` VALUES (4, '1', '竞拍海报', '', '100', '0', '0', '2019-04-08 08:15:39', 150, 6, '竞拍分享', NULL, 1, 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1554693225900.jpg', '', '你的竞拍分享正在拼命生成中，请等待片刻...', '[{\"left\":\"125px\",\"top\":\"58px\",\"type\":\"qr\",\"width\":\"80px\",\"height\":\"80px\"}]', 2);

-- ----------------------------
-- Table structure for lkt_files_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_files_record`;
CREATE TABLE `lkt_files_record`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商城id',
  `store_type` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '平台类型',
  `group` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分组',
  `upload_mode` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '上传方式 1:本地 2:阿里云 3:腾讯云 4:七牛云',
  `image_name` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片名称',
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '上传文件记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_finance_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_finance_config`;
CREATE TABLE `lkt_finance_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `plug_ins_id` int(11) NOT NULL DEFAULT 0 COMMENT '插件id',
  `min_cz` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '最小充值金额',
  `min_amount` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '最少提现金额',
  `max_amount` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '最大提现金额',
  `service_charge` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '元' COMMENT '小程序钱包单位',
  `modify_date` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `multiple` int(6) NULL DEFAULT 0 COMMENT '提现倍数',
  `transfer_multiple` int(6) NULL DEFAULT 0 COMMENT '转账倍数',
  `cz_multiple` int(6) NULL DEFAULT 100 COMMENT '充值倍数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '钱包配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_finance_config
-- ----------------------------
INSERT INTO `lkt_finance_config` VALUES (1, 1, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2019-01-04 03:57:51', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (2, 28, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (3, 29, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (4, 1, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (5, 2, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (6, 6, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (7, 7, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);
INSERT INTO `lkt_finance_config` VALUES (8, 1, 2, 100.00, 100.00, 20000.00, 0.05, '元', '2018-11-06 16:24:20', 100, 100, 100);

-- ----------------------------
-- Table structure for lkt_freight
-- ----------------------------
DROP TABLE IF EXISTS `lkt_freight`;
CREATE TABLE `lkt_freight`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0:件 1:重量',
  `freight` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '运费',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0:不默认 1:默认',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_group_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_group_config`;
CREATE TABLE `lkt_group_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `refunmoney` smallint(6) NOT NULL COMMENT '退款方式: 1,自动 2,手动',
  `group_time` int(11) NOT NULL COMMENT '拼团时限',
   `open_num` int(11) NOT NULL COMMENT '开团数量',
  `can_num` int(11) NOT NULL COMMENT '参团数量',
  `can_again` tinyint(1) NOT NULL COMMENT '是否可重复参团1 是 0 否',
  `open_discount` tinyint(1) NOT NULL COMMENT '是否开启团长优惠 1 是 0 否',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '轮播图',
  `rule` text NOT NULL COMMENT '规则',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '拼团参数配置表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of lkt_group_config
-- ----------------------------
INSERT INTO `lkt_group_config` (`id`, `store_id`, `refunmoney`, `group_time`, `open_num`, `can_num`, `can_again`, `open_discount`, `image`, `rule`) VALUES
(1, 1, 1, 1, 100, 3, 1, 1, '', '');
-- ----------------------------
-- Table structure for lkt_group_open
-- ----------------------------
DROP TABLE IF EXISTS `lkt_group_open`;
CREATE TABLE `lkt_group_open`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `uid` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信id',
  `ptgoods_id` int(11) NULL DEFAULT NULL COMMENT '拼团商品id',
  `ptcode` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '拼团编号',
  `groupman` smallint(6) NOT NULL COMMENT '几人团',
  `ptnumber` int(11) NULL DEFAULT NULL COMMENT '拼团人数',
  `addtime` datetime NULL DEFAULT NULL COMMENT '创建日期',
  `endtime` datetime NULL DEFAULT NULL COMMENT '结束时间',
  `ptstatus` tinyint(1) NULL DEFAULT 0 COMMENT '0:未付款 1:拼团中，2:拼团成功, 3：拼团失败, ',
  `group_title` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '拼团标题',
  `group_level` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '拼团等级价格参数',
  `group_data` TEXT NOT NULL DEFAULT '' COMMENT '拼团数据',
  `activity_no` INT(11) NOT NULL DEFAULT '0' COMMENT '拼团活动编号',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户拼团表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_group_product
-- ----------------------------
DROP TABLE IF EXISTS `lkt_group_product`;
CREATE TABLE `lkt_group_product`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `group_title` VARCHAR(255) NOT NULL COMMENT '活动标题',
  `attr_id` int(11) NOT NULL COMMENT '规格id',
  `product_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '产品id',
  `group_level` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '拼团等级价格参数',
  `group_data` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '拼团参数数据',
  `starttime` TIMESTAMP NULL COMMENT '开始日期',
  `endtime` TIMESTAMP NULL COMMENT '结束日期',
  `activity_no` INT(11) NOT NULL COMMENT '活动编号',
  `g_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '活动状态: 1.未开始 2.活动中 3.已结束',
  `is_show` tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否显示',
  `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `is_copy` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否为复制 1为复制 0不是复制',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '拼团产品' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_guide
-- ----------------------------
DROP TABLE IF EXISTS `lkt_guide`;
CREATE TABLE `lkt_guide`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `source` tinyint(4) NULL DEFAULT 0 COMMENT '来源 1:小程序 2:APP',
  `type` int(11) NULL DEFAULT NULL COMMENT '类型',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '引导图表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_home_nav
-- ----------------------------
DROP TABLE IF EXISTS `lkt_home_nav`;
CREATE TABLE `lkt_home_nav`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NULL DEFAULT NULL COMMENT '商城id',
  `store_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '软件类型',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标名称',
  `uniquely` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标识',
  `url` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '页面路径',
  `open_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '打开方式',
  `pic_url` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图标url',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序，升序',
  `is_delete` smallint(1) NOT NULL DEFAULT 0,
  `is_hide` smallint(1) NOT NULL DEFAULT 0 COMMENT '是否隐藏 0.显示 1.隐藏 ',
  PRIMARY KEY (`id`, `uniquely`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '首页导航图标' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_hotkeywords
-- ----------------------------
DROP TABLE IF EXISTS `lkt_hotkeywords`;
CREATE TABLE `lkt_hotkeywords`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `store_id` int(11) NULL DEFAULT NULL COMMENT '商城id',
  `is_open` tinyint(4) DEFAULT '0' COMMENT '是否开启 0.未开启 1.开启',
  `num` int(11) DEFAULT '0' COMMENT '关键词上限',
  `keyword` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '关键词',
  `mch_keyword` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '店铺关键词',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_img_group
-- ----------------------------
DROP TABLE IF EXISTS `lkt_img_group`;
CREATE TABLE `lkt_img_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分组id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分组名称',
  `sort` int(11) NULL DEFAULT 100 COMMENT '排序',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_default` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0.不是默认 1.默认',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图片分组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_index_page
-- ----------------------------
DROP TABLE IF EXISTS `lkt_index_page`;
CREATE TABLE `lkt_index_page`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '值',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块名称',
  `sort` int(11) NULL DEFAULT 10 COMMENT '排序',
  `store_type` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '软件类型',
  `style` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '样式类型',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '首页模块表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_mch
-- ----------------------------
DROP TABLE IF EXISTS `lkt_mch`;
CREATE TABLE `lkt_mch`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺名称',
  `shop_information` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '店铺信息',
  `shop_range` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '经营范围',
  `realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `ID_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证号码',
  `tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系电话',
  `sheng`  char(100) NULL,
  `shi`  char(100) NULL,
  `xian`  char(100) NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系地址',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺Logo',
  `shop_nature` tinyint(3) NOT NULL DEFAULT 0 COMMENT '店铺性质：0.个人 1.企业',
  `business_license` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '营业执照',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '申请时间',
  `review_time` timestamp NULL DEFAULT NULL COMMENT '审核时间',
  `review_status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '审核状态：0.待审核 1.审核通过 2.审核不通过',
  `review_result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '拒绝理由',
  `integral_money`  decimal(12,0) NULL DEFAULT 0 COMMENT '商户积分',
  `account_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '商户余额',
  `collection_num` int(11) NULL DEFAULT 0 COMMENT '收藏数量',
  `is_open` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否营业：0.否 1.是',
  `is_lock` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否被系统关闭：0.否 1.是',
  `confines` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺经营范围',
  `business_hours` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '营业时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商户' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_mch_account_log
-- ----------------------------
DROP TABLE IF EXISTS `lkt_mch_account_log`;
CREATE TABLE `lkt_mch_account_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `mch_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺id',
  `integral`  int(12) NULL DEFAULT 0 COMMENT '积分',
  `integral_money`  decimal(12,0) NULL DEFAULT 0 COMMENT '商户积分',
  `price` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '金额',
  `account_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '商户余额',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态：1.入账 2.出账',
  `type` tinyint(3) NOT NULL DEFAULT 1 COMMENT '类型：1.订单 2.退款 3.提现',
  `addtime` timestamp NULL DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '入驻商户账户收支记录表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for lkt_mch_browse
-- ----------------------------
DROP TABLE IF EXISTS `lkt_mch_browse`;
CREATE TABLE `lkt_mch_browse`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `mch_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺id',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'token',
  `user_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `event` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '事件',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '店铺浏览记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_mch_common_cat
-- ----------------------------
DROP TABLE IF EXISTS `lkt_mch_common_cat`;
CREATE TABLE `lkt_mch_common_cat`  (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT ,
  `store_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 1000 COMMENT '排序，升序',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE = InnoDB AUTO_INCREMENT = 1  CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '入驻商类目' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_mch_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_mch_config`;
CREATE TABLE `lkt_mch_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺默认logo',
  `settlement` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '结算方式',
  `min_charge` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '最低提现金额\r\n\r\n',
  `max_charge` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '最大提现金额\r\n\r\n',
  `service_charge` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '手续费',
  `illustrate` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '提现说明',
  `agreement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '入驻协议',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商户配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_mch_visit_log
-- ----------------------------
DROP TABLE IF EXISTS `lkt_mch_visit_log`;
CREATE TABLE `lkt_mch_visit_log`  (
  `id` bigint(20) UNSIGNED PRIMARY KEY   NOT NULL AUTO_INCREMENT ,
  `user_id` int(11) NOT NULL,
  `mch_id` int(11) NOT NULL,
  `addtime` int(11) NOT NULL,
  `visit_date` date NOT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '店铺浏览记录' ROW_FORMAT = Compact;

-- 店铺门店表
DROP TABLE IF EXISTS `lkt_mch_store`;
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

-- ----------------------------
-- Table structure for lkt_message
-- ----------------------------
DROP TABLE IF EXISTS `lkt_message`;
CREATE TABLE `lkt_message`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `SignName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信签名',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信模板名称',
  `type` int(2) NOT NULL DEFAULT 0 COMMENT '类型 0:验证码 1:自定义',
  `type1` int(2) NOT NULL DEFAULT 0 COMMENT '类别 0:通用 1:申请通过 2:申请拒绝 3:订单提现 4:发货提现 5:收货提现',
  `TemplateCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信模板Code',
  `content` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '内容',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信模板列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_message_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_message_config`;
CREATE TABLE `lkt_message_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `accessKeyId` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'accessKeyId',
  `accessKeySecret` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'accessKeySecret',
  `SignName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信签名',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信配置' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_message_list
-- ----------------------------
DROP TABLE IF EXISTS `lkt_message_list`;
CREATE TABLE `lkt_message_list`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `type` int(2) NOT NULL DEFAULT 0 COMMENT '类型 0:验证码 1:短信通知',
  `type1` int(2) NOT NULL DEFAULT 0 COMMENT '类别 0:通用 1:申请通过 2:申请拒绝 3:订单提现 4:发货提现 5:收货提现',
  `Template_id` int(11) NOT NULL DEFAULT 0 COMMENT '模板id',
  `content` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'code',
  `status` int(2) NOT NULL DEFAULT 0 COMMENT '类型 0:商城 1:店铺',
  `admin_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客户id/店主id',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_money_point
-- ----------------------------
DROP TABLE IF EXISTS `lkt_money_point`;
CREATE TABLE `lkt_money_point`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '奖金类型',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '应发金额',
  `s_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '实发金额',
  `fx_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费一',
  `tax_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费二',
  `o_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费三',
  `si_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费四',
  `w_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费五',
  `isf` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否延迟发放',
  `f_time` time NOT NULL COMMENT '发放时间',
  `from_ordersn` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单编号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '奖金收益表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_notice
-- ----------------------------
DROP TABLE IF EXISTS `lkt_notice`;
CREATE TABLE `lkt_notice`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `pay_success` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '购买成功通知',
  `order_delivery` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单发货提醒',
  `order_success` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单支付成功通知',
  `group_pay_success` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开团成功提醒',
  `group_pending` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '拼团待成团提醒',
  `group_success` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '拼团成功通知',
  `group_fail` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '拼团失败通知',
  `refund_success` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款成功通知',
  `refund_res` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款通知',
  `receive` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '领取通知',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模板消息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_notice_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_notice_config`;
CREATE TABLE `lkt_notice_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `c_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '中文名称',
  `e_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `stock_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信模板库id',
  `stock_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组合关键词',
  `update_time` datetime NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模板消息配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of lkt_notice_config
-- ----------------------------
INSERT INTO `lkt_notice_config` VALUES (2, '购买成功通知', 'pay_success', 'AT0002', '3,4,5,6,7', '2019-03-28 10:56:56');
INSERT INTO `lkt_notice_config` VALUES (3, '订单发货提醒', 'order_delivery', 'AT0007', '2,3,5,7,19,33,51', '2019-03-28 11:04:14');
INSERT INTO `lkt_notice_config` VALUES (4, '订单支付成功通知', 'order_success', 'AT0009', '1,2,4,7,6,8', '2019-03-28 11:07:17');
INSERT INTO `lkt_notice_config` VALUES (5, '开团成功提醒', 'group_pay_success', 'AT0541', '2,4,14,10,17,15,6,22,12', '2019-03-28 11:12:00');
INSERT INTO `lkt_notice_config` VALUES (6, '拼团待成团提醒', 'group_pending', 'AT0911', '1,10,7,18,8,9,3,6', '2019-03-28 11:15:20');
INSERT INTO `lkt_notice_config` VALUES (7, '拼团成功通知', 'group_success', 'AT0051', '6,12,13,21,19,9', '2019-03-28 11:21:58');
INSERT INTO `lkt_notice_config` VALUES (8, '拼团失败通知', 'group_fail', 'AT0310', '2,4,10,6,15,16', '2019-03-28 11:24:51');
INSERT INTO `lkt_notice_config` VALUES (10, '退款成功通知', 'refund_success', 'AT0787', '8,13,17,28,30', '2019-03-28 11:31:46');
INSERT INTO `lkt_notice_config` VALUES (11, '退款通知', 'refund_res', 'AT0036', '65,35,5,28,3,69,27', '2019-03-28 11:35:01');
INSERT INTO `lkt_notice_config` VALUES (12, '领取通知', 'receive', 'AT0551', '30,31,34,35,4,14,27', '2019-03-28 11:39:17');

-- ----------------------------
-- Table structure for lkt_option
-- ----------------------------
DROP TABLE IF EXISTS `lkt_option`;
CREATE TABLE `lkt_option`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类型',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '软件显示类型',
  `value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作值',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '平台控件表' ROW_FORMAT = Dynamic;

--
-- 表的结构 `lkt_order`
--
DROP TABLE IF EXISTS `lkt_order`;
CREATE TABLE `lkt_order` (
  `id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `user_id` char(15) NOT NULL COMMENT '用户id',
  `name` varchar(50) DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `num` int(11) DEFAULT NULL COMMENT '数量',
  `z_price` decimal(12,2) DEFAULT '0.00' COMMENT '总价',
  `sNo` varchar(255) DEFAULT NULL COMMENT '订单号',
  `sheng` text COMMENT '省',
  `shi` text COMMENT '市',
  `xian` text COMMENT '县',
  `address` text COMMENT '详细地址',
  `remark` varchar(32) DEFAULT NULL COMMENT '用户备注',
  `pay` char(15) DEFAULT NULL COMMENT '支付方式',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `pay_time` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `arrive_time` timestamp NULL DEFAULT NULL COMMENT '到货时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态 0:未付款 1:未发货 2:待收货 3:待评论 4:退货 5:已完成 6:订单失效 7:订单  关闭 8:删除订单 9:拼团中 10:拼团失败-未退款 11:拼团失败-已退款 ',
  `coupon_id` int(11) DEFAULT '0' COMMENT '优惠券id',
  `subtraction_id` int(11) DEFAULT NULL COMMENT '满减活动ID',
  `consumer_money` VARCHAR(20) DEFAULT '0' COMMENT '消费金',
  `coupon_activity_name` varchar(50) DEFAULT '0' COMMENT '满减活动名称',
  `drawid` int(11) DEFAULT '0' COMMENT '活动ID',
  `otype` char(30) DEFAULT '' COMMENT '订单类型',
  `ptcode` char(15) DEFAULT '' COMMENT '拼团编号',
  `pid` char(10) DEFAULT NULL COMMENT '拼团订单类型:kaituan开团 cantuan参团',
  `ptstatus` smallint(6) DEFAULT NULL COMMENT '拼团状态:0,未付款 1,拼团中 2,拼团成功 3,拼团失败',
  `groupman` char(5) DEFAULT NULL COMMENT '拼团人数',
  `refundsNo` char(30) DEFAULT '' COMMENT '拼团退款单号',
  `trade_no` char(20) DEFAULT '' COMMENT '微信支付单号',
  `is_anonymous` int(1) DEFAULT '0' COMMENT '是否匿名(0,否  1.是',
  `logistics_service` int(1) DEFAULT NULL COMMENT '物流服务',
  `overall_evaluation` int(1) DEFAULT NULL COMMENT '总体评价',
  `spz_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品总价',
  `reduce_price` decimal(10,2) DEFAULT '0.00' COMMENT '查询出的满减金额',
  `coupon_price` decimal(10,2) DEFAULT '0.00' COMMENT '查询出的优惠券金额',
  `red_packet` varchar(255) DEFAULT '0' COMMENT '红包金额',
  `allow` int(8) DEFAULT '0' COMMENT '积分',
  `parameter` text COMMENT '参数',
  `source` tinyint(4) NOT NULL DEFAULT '1' COMMENT '来源 1.小程序 2.app',
  `delivery_status` int(1) DEFAULT '0' COMMENT '提醒发货',
  `readd` int(2) NOT NULL DEFAULT '0' COMMENT '是否已读（0，未读  1 已读）',
  `remind` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '提醒\r\n\r\n发货时间间隔',
  `offset_balance` decimal(10,2) DEFAULT '0.00' COMMENT '抵扣余额',
  `mch_id` varchar(11) DEFAULT '' COMMENT '店铺ID',
  `zhekou` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销折扣',
  `grade_rate` decimal(10,2) DEFAULT '0.00' COMMENT '会员等级折扣',
  `grade_score` int(11) DEFAULT NULL COMMENT '会员购物积分',
  `grade_fan` decimal(12,2) DEFAULT NULL COMMENT '会员返现金额',
  `p_sNo` varchar(50) NOT NULL DEFAULT '' COMMENT '父类订单号',
  `bargain_id` int(11) NOT NULL DEFAULT '0' COMMENT '砍价活动id',
  `comm_discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销折扣',
  `real_sno` varchar(255) DEFAULT NULL COMMENT '调起支付所用订单号',
  `remarks` varchar(500) NOT NULL DEFAULT '' COMMENT '订单备注',
  `self_lifting` tinyint(4) DEFAULT 0 COMMENT '自提 0.配送 1.自提',
  `extraction_code` varchar(255) COMMENT '提现码',
  `extraction_code_img` varchar(255) COMMENT '提现码二维码',
  `is_put`  tinyint(4) NULL DEFAULT 0 COMMENT '是否发放佣金 0.否 1.是'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='订单列表';

-- ----------------------------
-- Table structure for lkt_order_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_order_config`;
CREATE TABLE `lkt_order_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `days` int(11) NULL DEFAULT NULL COMMENT '承若天数',
  `content` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '承若内容',
  `back` int(11) NULL DEFAULT 2 COMMENT '退货时间',
  `order_failure` int(11) NULL DEFAULT NULL COMMENT '订单失效',
  `order_after` int(3) NOT NULL DEFAULT 7 COMMENT '售后时间期限',
  `company` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '天' COMMENT '单位',
  `order_overdue` int(11) NULL DEFAULT 2 COMMENT '订单过期删除时间',
  `unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '天' COMMENT '单位',
  `modify_date` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `auto_the_goods` int(11) NULL DEFAULT 7 COMMENT '自动收货时间',
  `order_ship` int(11) NOT NULL DEFAULT 0 COMMENT '发货时限',
  `remind` int(11) DEFAULT '1' COMMENT '提醒限制',
  `accesscode`  char(100) NULL DEFAULT '' COMMENT '顾客编码',
  `checkword`  text NULL COMMENT '校验码',
  `custid`  char(100) NULL COMMENT '月结卡号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单设置' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_order_config
-- ----------------------------
INSERT INTO `lkt_order_config` VALUES (1, 1, 0, '', 2, 1, '小时', 3, '天', '2019-09-05 03:21:49', 1, 121, 1, 'AX', 'wBAIrVpEbb3CkpIuke5rlFrzkD6hnLbB', '7551234567');

-- ----------------------------
-- Table structure for lkt_order_data
-- ----------------------------
DROP TABLE IF EXISTS `lkt_order_data`;
CREATE TABLE `lkt_order_data`  (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `trade_no` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信订单号',
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `addtime` datetime NOT NULL COMMENT '创建时间'
) ENGINE = InnoDB AUTO_INCREMENT = 1  CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单临时信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_order_details
-- ----------------------------
DROP TABLE IF EXISTS `lkt_order_details`;
CREATE TABLE `lkt_order_details`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NULL DEFAULT 0 COMMENT '商城id',
  `user_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `p_id` int(11) NULL DEFAULT NULL COMMENT '产品id',
  `p_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品名称',
  `p_price` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '产品价格',
  `num` int(11) NULL DEFAULT NULL COMMENT '数量',
  `unit` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '单位',
  `r_sNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单号',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `deliver_time` timestamp NULL DEFAULT NULL COMMENT '发货时间',
  `arrive_time` timestamp NULL DEFAULT NULL COMMENT '到货时间',
  `r_status` tinyint(4) NULL DEFAULT 0 COMMENT ' \'状态 0：未付款 1：未发货 2：待收货 3：待评论 4：退货 5:已完成 6 订单关闭 9拼团中 10 拼团失败-未退款 11 拼团失败-已退款\'',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '退货原因',
  `reason` char(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'app退款原因',
  `re_type` tinyint(4) NULL DEFAULT 0 COMMENT '退款类型 1:退货退款  2:退款',
  `re_apply_money` FLOAT(12,2) NULL COMMENT '用户申请退款金额',
  `re_money` float(12, 2) NULL DEFAULT NULL COMMENT '退款金额',
  `real_money` decimal(12,2) DEFAULT '0.00' COMMENT '实际退款金额',
  `re_time` datetime NULL DEFAULT NULL COMMENT '申请退款时间',
  `re_photo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '上传凭证',
  `r_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '拒绝原因',
  `r_type` tinyint(4) NULL DEFAULT 0 COMMENT '类型 0:审核中 1:同意并让用户寄回 2:拒绝(退货退款) 3:用户已快递 4:收到寄回商品,同意并退款 5：拒绝并退回商品 8:拒绝(退款) 9:同意并退款',
  `express_id` int(255) NULL DEFAULT NULL COMMENT '快递公司id',
  `courier_num` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递单号',
  `express_type`  tinyint(4) NULL DEFAULT 1 COMMENT '发货类型 1.手动发货 2.自动发货',
  `freight` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '运费',
  `size` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `sid` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单详情列表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_payment
-- ----------------------------
DROP TABLE IF EXISTS `lkt_payment`;
CREATE TABLE `lkt_payment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付名称',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:线上 2:线下',
  `class_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付类名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '描述',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付方式logo图片路径',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 0.启用 1.禁用',
  `sort` smallint(5) NOT NULL DEFAULT 99 COMMENT '排序',
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '支付说明',
  `poundage` decimal(15, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `poundage_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '手续费方式 1百分比 2固定值',
  `client_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1:PC端 2:移动端 3:通用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付方式表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_payment
-- ----------------------------
INSERT INTO `lkt_payment` (`id`, `name`, `type`, `class_name`, `description`, `logo`, `status`, `sort`, `note`, `poundage`, `poundage_type`, `client_type`) VALUES
(1, '支付宝手机支付', 1, 'alipay', '支付宝的手机网站支付方式。需要企业账号单独签约设置密钥。不能与电脑版本的支付宝混用。<a href="http://www.alipay.com/" target="_blank">立即申请</a>', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1547705358393.png', 0, 99, '', '0.00', 1, 2),
(2, '中国银联手机支付', 1, 'wap_unionpay', '中国银联unionpay手机网站支付接口。费率相对较低，而且支持银行数量最广泛，注意：商户的 <签名证书>和<密码加密证书>都必须放置到商城根目录下的 "/plugins/payments/pay_wap_unionpay/key" 目录中。<a href="https://open.unionpay.com/ajweb/index" target="_blank">立即申请</a>', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1547705291753.png', 1, 99, '', '0.00', 1, 2),
(3, '钱包', 2, 'wallet_pay', '货到付款', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1547705407776.png', 0, 99, NULL, '0.00', 1, 3),
(4, '微信APP支付', 1, 'app_wechat', '微信APP支付接口，必须有官方打包的独立APP才可以使用此支付方式。<a href="https://open.weixin.qq.com/" target="_blank">立即申请</a>', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1547705326604.png', 0, 99, NULL, '0.00', 1, 2),
(5, '微信小程序支付', 1, 'mini_wechat', '微信小程序支付接口，去微信公众平台申请。<a href="https://mp.weixin.qq.com/cgi-bin/registermidpage?action=index" target="_blank">立即申请</a>', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1547705326604.png', 0, 99, '1111', '1111.00', 0, 2),
(6, '微信公众号支付', 1, 'jsapi_wechat', '微信公众号支付接口，去微信公众平台申请。<a href="https://mp.weixin.qq.com/cgi-bin/registermidpage?action=index" target="_blank">立即申请</a>', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1555385328993.png', 0, 0, '', '0.00', 0, 2),
(7, '支付宝小程序', 1, 'alipay_minipay', NULL, '', 0, 99, '支付宝', '0.00', 0, 2),
(8, '百度小程序支付', 1, 'baidu_pay', '百度小程序支付', 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/0/0/1570584633525.png', 0, 99, '百度小程序支付', '0.00', 0, 2);
-- ----------------------------
-- Table structure for lkt_payment_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_payment_config`;
CREATE TABLE `lkt_payment_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `pid` int(11) NOT NULL COMMENT '支付方式id',
  `status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否显示 0否 1是',
  `config_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置参数,json数据对象',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '支付方式参数表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of lkt_payment_config
-- ----------------------------
INSERT INTO `lkt_payment_config` VALUES (11, 1, 5, 1, '{\"appid\":\"wx5ae2bb641565e4a3\",\"appsecret\":\"2327dae72eb0fc78a3695cf5f343c45a\",\"mch_id\":\"1499256602\",\"mch_key\":\"td153g1d2f321g23ggrd123g12fd1g22\",\"js_api_call_url\":\"https://xiaochengxu.laiketui.com/V2.4/js_api_call.php\",\"sslcert_path\":\"/alidata/www/xiaochengxu/V2.4/webapp/lib/wxpayv3/cert/1fe9e85444b885cc149cc9a52951b285/apiclient_cert.pem\",\"sslkey_path\":\"/alidata/www/xiaochengxu/V2.4/webapp/lib/wxpayv3/cert/1fe9e85444b885cc149cc9a52951b285/apiclient_key.pem\",\"notify_url\":\"https://xiaochengxu.laiketui.com/V2.4/notify_url.php\"}');
INSERT INTO `lkt_payment_config` VALUES (12, 1, 4, 1, '{\"appid\":\"wxf6e29bcc719cf499\",\"appsecret\":\"228265f899b4f6f55e1f0638d267f3f7\",\"mch_id\":\"1516978921\",\"mch_key\":\"sdfsdfsefrq3434rerfsdfqw4r234rf3\",\"js_api_call_url\":\"https://xiaochengxu.laiketui.com/ceshi/js_api_call.php\",\"sslcert_path\":\"/alidata/www/xiaochengxu/ceshi/webapp/lib/wxpayv3/cert/c6a0591d8f033115aba1b64d9764bba0/apiclient_cert.pem\",\"sslkey_path\":\"/alidata/www/xiaochengxu/ceshi/webapp/lib/wxpayv3/cert/c6a0591d8f033115aba1b64d9764bba0/apiclient_key.pem\",\"notify_url\":\"https://xiaochengxu.laiketui.com/ceshi/notify_url.php\"}');
INSERT INTO `lkt_payment_config` VALUES (13, 1, 1, 1, '{\"appid\":\"2019030763497116\",\"encryptKey\":\"rZAvYTk3b97fzcqe0Utpjg==\",\"signType\":\"RSA2\",\"rsaPrivateKey\":\"MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCw3ZIuS617UaAP6rJOgkcpuLQlLFdxUc3idq2W9RShsKeXu/zDHwGkAguPsYbzo3R5ZgsMlj39lmJfuosOvfUNdmkI2coy7eXaw9uxZTbBdpaMfDwKzdfWY3s4Ly00wlGsiKklF+Z7Eu8WmzPK5+wZO2RqR4qkwJghotWfiNcBftNNcC7O2LuvC8ypZWo1dGr/2S/OM5j1RJ1pj1JiaQXmGkiOcoTBOsOIEfBD+fkSfBvtnbTuxn+V1NcZyxVkmhOmpkOxIjMr0l7OK1QxM+VIKuDPw7M9T1hAk9bFaNaoGJ5Vjl1tH5LZwio4kq+YBXpb35GBgkcAo4GxzE4Jmcf5AgMBAAECggEARMNgei9iG3f4yzdsa6mrEUWGhI1g0eYELfAGPZK7msGb5xpng1UixiklZZCX71G1jx1lXldrcpRtWtqkBe9Evx8yZwaF3pcvroZHfAjl6QG6NpR2o5y0Nd4nogh1gvWp23KmkI1iRqdt3VQqJtFUsdqth8SY2sUmYK12cLg7H5ERhc8qI8yEx96WN9zfOeJERINCpb7wZYH+jtf6YSqNUx+t0xvc8WZitxnovUrOSI9l+RwRpZI7cTXLtOPr3t1stp0Ow7QX0ZoPemEDeEB/DkdqFbNBIqrx7v+7ouCuC/Or7sVNMowy1ijvPoMoF3u4YacyhS9nPu2GIldqYeISgQKBgQDmuEAD3SnM/Yj0jHvv2JMaIlEIRPlUgUdIjZunB/erC6oI6Dc3jvPWzPz7S8mgZ0thCvr7V+4O+bERYX8TjRWb886DGCuI84yzpSXlutrbd+MSkCrubZDxq46A6GF0GLJucjnhA9oO3L8aYqe/GnCg//JO4WkZO7q/Qe7uweZcHQKBgQDEPrIjMri7h5nZ5ZTuR1L8uSA8V/DSWpEF67hrXKTPqgBayebnydWNWUwY01c2eYpx+nyt1ncDV+MuLsanjP7D2u7YyISTLMJnCVkLgXr222NKdaL9BActA0fw9t3mu7/4FP2PD2VzkVl+Ms8koOiu8lDisR5waxSYKP8+ZJd8jQKBgQCWNs3O9jaZ9VQuzCyBGwOjV0Zk2OtwXn83uKLn3CMfJQf+ppoUvSj66Bmpz00l9zq3ovuHm1cuPtlPFKg05X11PQZuidUGZHNuHw8OhFqr22FnG6An/gQJpIWyXhndCZtal1ohq21UkdqGZkcLAD7mQ93SB6ZyvFW44kebAXlm7QKBgFmG6KmaGCClShDX5cuWikt1ATnGPL0aSBLVaLrB9wYt3h+NAGQ59cyYMlkZAS5+4CQDTCHaN001KRUGjeYeMpOTK2eGgsTJpJ5w60iOd1Rq3a84X3TiA4wLdSR+2tjKSleY69v6ACRq6NLjxxBEwCIftbrVZreOgkSwX1FNfrZ5AoGAVa7xVlgJCTUICEkOnddEU99xp8ggBg9sDBB3dpFbgLGaK/7FIwR/tZTg807E6iIJOGKPI9TeqcgnYzVnjws0scgiPqUq5jgL0ZauaUXuZFqkabdjsklubECqraX5rEUeYlzXc0cTZoFY5hz4WSBuXOeRPE5YJ5cxI/LjAQq+LbM=\",\"alipayrsaPublicKey\":\"\",\"js_api_call_url\":\"https://xiaochengxu.laiketui.com/V2.4/js_api_call.php\",\"rsaPrivateKeyFilePath\":\"/alidata/www/xiaochengxu/V2.4/webapp/lib/alipay/cert/95652a155478da65db9db4296e9f3fb0/rsaPrivateKey.pem\",\"rsaPublicKeyFilePath\":\"/alidata/www/xiaochengxu/V2.4/webapp/lib/alipay/cert/95652a155478da65db9db4296e9f3fb0/alipayrsaPublicKey.pem\",\"notify_url\":\"https://xiaochengxu.laiketui.com/V2.4/zfbnotify_url.php\",\"encryptType\":\"AES\"}');
INSERT INTO `lkt_payment_config` VALUES (14, 1, 6, 1, '{\"appid\":\"wx5ae2bb641565e4a3\",\"appsecret\":\"595b9c5c82f75fa1027d562d99ce3f8f\",\"mch_id\":\"1499256602\",\"mch_key\":\"td153g1d2f321g23ggrd123g12fd1g22\",\"js_api_call_url\":\"https://xiaochengxu.laiketui.com/V2.4/js_api_call.php\",\"sslcert_path\":\"/alidata/www/xiaochengxu/V2.4/webapp/lib/wxpayv3/cert/1fe9e85444b885cc149cc9a52951b285/apiclient_cert.pem\",\"sslkey_path\":\"/alidata/www/xiaochengxu/V2.4/webapp/lib/wxpayv3/cert/1fe9e85444b885cc149cc9a52951b285/apiclient_key.pem\",\"notify_url\":\"https://xiaochengxu.laiketui.com/V2.4/notify_url.php\"}');

-- ----------------------------
-- Table structure for lkt_plug_ins
-- ----------------------------
DROP TABLE IF EXISTS `lkt_plug_ins`;
CREATE TABLE `lkt_plug_ins`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '插件名称',
  `Identification` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标识',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0：未启用 1：启用',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '插件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_plug_ins
-- ----------------------------

INSERT INTO `lkt_plug_ins` (`id`, `name`, `Identification`, `sort`, `status`, `add_time`) VALUES
(1, '分销', 'distribution', 100, 0, '2019-01-15 03:31:13'),
(2, '拼团', 'go_group', 100, 0, '2019-01-15 03:31:36'),
(4, '签到', 'sign', 100, 0, '2019-01-15 03:32:11'),
(5, '卡券', 'coupon', 100, 0, '2019-01-15 03:32:25'),
(7, '满减', 'subtraction', 100, 0, '2019-01-15 03:32:48'),
(9, '砍价', 'bargain', 100, 0, '2019-01-15 03:33:15'),
(10, '竞拍', 'auction', 100, 0, '2019-01-15 03:33:29'),
(11, '店铺', 'mch', 100, 0, '2019-01-28 08:41:21'),
(12, '积分商城', 'integral', 100, 0, '2019-07-17 09:53:12'),
(14, '秒杀', 'seconds', 100, 0, '2019-08-22 01:22:41');

-- ----------------------------
-- Table structure for lkt_product_class
-- ----------------------------
DROP TABLE IF EXISTS `lkt_product_class`;
CREATE TABLE `lkt_product_class`  (
  `cid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `sid` int(11) NOT NULL COMMENT '上级id',
  `pname` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `img` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分类图片',
  `bg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小图标',
  `level` int(11) NOT NULL COMMENT '级别',
  `sort` int(11) NULL DEFAULT 100 COMMENT '排序',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `recycle` tinyint(4) NULL DEFAULT 0 COMMENT '回收站 0.不回收 1.回收',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品分类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_product_class
-- ----------------------------
INSERT INTO `lkt_product_class` VALUES (1, 0, '预留分类', '', '', 0, 100, 1, '2019-04-17 02:19:48', 1);
INSERT INTO `lkt_product_class` VALUES (2, 0, '预留分类', '', '', 0, 100, 1, '2019-04-17 05:41:21', 0);

-- ----------------------------
-- Table structure for lkt_product_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_product_config`;
CREATE TABLE `lkt_product_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_product_img
-- ----------------------------
DROP TABLE IF EXISTS `lkt_product_img`;
CREATE TABLE `lkt_product_img`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `product_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产品图片',
  `product_id` int(11) NOT NULL COMMENT '所属产品id',
  `seller_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户id',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图片表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_product_list
-- ----------------------------
DROP TABLE IF EXISTS `lkt_product_list`;
--
-- 表的结构 `lkt_product_list`
--
CREATE TABLE `lkt_product_list` (
  `id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `product_number` varchar(100) NOT NULL COMMENT '商品编号',
  `product_title` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名字',
  `subtitle` varchar(100) DEFAULT NULL COMMENT '副标题',
  `label` varchar(100) DEFAULT NULL COMMENT '商品标签',
  `scan` varchar(250) NOT NULL COMMENT '条形码',
  `product_class` varchar(32) NOT NULL COMMENT '产品类别',
  `imgurl` varchar(200) NOT NULL DEFAULT '' COMMENT '产品图片',
  `content` text DEFAULT NULL COMMENT '产品内容',
  `richList` text DEFAULT NULL COMMENT '前端店铺商品详情插件',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `upper_shelf_time` timestamp NULL DEFAULT NULL COMMENT '上架时间',
  `volume` int(12) NOT NULL DEFAULT '0' COMMENT '销量',
  `initial` text COMMENT '初始值',
  `s_type` varchar(20) DEFAULT NULL COMMENT '产品值属性 1：新品,2：热销，3：推荐',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `min_inventory` int(11) NOT NULL DEFAULT '10' COMMENT '库存预警',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态 1:待上架 2:上架 3:下架 \r\n\r\n',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `is_distribution` int(2) NOT NULL DEFAULT '0' COMMENT '是否为分销商品',
  `is_default_ratio` int(2) NOT NULL DEFAULT '0' COMMENT '是否默认比例',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关键词',
  `weight` varchar(100) DEFAULT NULL COMMENT '重量',
  `distributor_id` int(5) DEFAULT '0' COMMENT '分销等级id 购买就升级',
  `freight` text NOT NULL COMMENT '运费',
  `is_zhekou` int(2) DEFAULT '0' COMMENT '是否开启会员',
  `separate_distribution` varchar(50) DEFAULT '0' COMMENT '单独分销',
  `recycle` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回收站 0.显示 1.回收',
  `gongyingshang` varchar(100) NOT NULL DEFAULT '' COMMENT '供应商',
  `is_hexiao` tinyint(4) DEFAULT '0' COMMENT '是否支持线下核销:0--不支持　1--支持',
  `hxaddress` varchar(255) DEFAULT NULL COMMENT '核销地址',
  `active` char(10) DEFAULT '1' COMMENT '支持活动:1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍 5--支持分销 6--会员特惠 7--支持积分商城',
  `mch_id` int(10) DEFAULT '0' COMMENT '商户ID',
  `mch_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '审核状态：1.待审核，2.审核通过，3.审核不通过，4.暂不审核',
  `refuse_reasons` varchar(255) DEFAULT NULL COMMENT '拒绝原因',
  `search_num` int(11) NOT NULL DEFAULT '0' COMMENT '搜索次数',
  `show_adr` varchar(100) NOT NULL DEFAULT '1' COMMENT '展示位置:1.\r\n首页 2.购物车',
  `publisher` varchar(255) DEFAULT NULL COMMENT '发布人'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Table structure for lkt_product_number
-- ----------------------------
DROP TABLE IF EXISTS `lkt_product_number`;
CREATE TABLE `lkt_product_number`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `mch_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺id',
  `operation` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作人账号',
  `product_number` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品编号',
  `status` tinyint(3) NOT NULL DEFAULT 1 COMMENT '状态：1.使用 2.撤销',
  `addtime` timestamp NULL DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品编号表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_record`;
CREATE TABLE `lkt_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '操作金额',
  `oldmoney` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '原有金额',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `event` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '事件',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0:登录/退出 1:充值 2:申请提现 3:分享 4:余额消费 5:退款 6:红包提现 7:佣金 8:管理佣金 9:待定 10:消费金 11:系统扣款   12:给好友转余额 13:转入余额 14:系统充值 15:系统充积分 16:系统充消费金 17:系统扣积分 18:系统扣消费金 19:消费金解封 21:  提现成功 22:提现失败 23.取消订单  24分享获取红包 26 交竞拍押金 27 退竞拍押金 28 售后（仅退款） 29 售后（退货退款）30 会员返现',
  `is_mch` int(2) NULL DEFAULT 0 COMMENT '是否是店铺提现 0.不是店铺提现 1.是店铺提现',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_record
-- ----------------------------
INSERT INTO `lkt_record` VALUES (1, 0, 'admin', 0.00, 0.00, '2019-04-17 05:39:55', '安全退出成功', 0, 0);
INSERT INTO `lkt_record` VALUES (2, 0, 'admin', 0.00, 0.00, '2019-04-17 05:39:56', '安全退出成功', 0, 0);
INSERT INTO `lkt_record` VALUES (3, 0, 'admin', 0.00, 0.00, '2019-04-17 05:39:57', '安全退出成功', 0, 0);
INSERT INTO `lkt_record` VALUES (4, 0, 'admin', 0.00, 0.00, '2019-04-17 05:39:58', '安全退出成功', 0, 0);
INSERT INTO `lkt_record` VALUES (5, 0, 'admin', 0.00, 0.00, '2019-04-17 05:39:59', '安全退出成功', 0, 0);

-- ----------------------------
-- Table structure for lkt_reply_comments
-- ----------------------------
DROP TABLE IF EXISTS `lkt_reply_comments`;
CREATE TABLE `lkt_reply_comments`  (
  `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `cid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论ID',
  `uid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评价内容',
  `add_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '回复评论表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_return_goods
-- ----------------------------
DROP TABLE IF EXISTS `lkt_return_goods`;
CREATE TABLE `lkt_return_goods`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人',
  `tel` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系方式',
  `express` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递名称',
  `express_num` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递单号',
  `uid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '用户ID',
  `oid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '订单id',
  `add_data` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '填写时间',
  `user_id` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户退货表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_role
-- ----------------------------
DROP TABLE IF EXISTS `lkt_role`;
CREATE TABLE `lkt_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `permission` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '许可',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0:角色 1:客户端',
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '管理员id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_role
-- ----------------------------

INSERT INTO `lkt_role` (`id`, `name`, `permission`, `status`, `admin_id`, `store_id`, `add_date`) VALUES
(1, '通用', 'a:135:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:5:"3/352";i:10;s:5:"3/403";i:11;s:4:"2/17";i:12;s:4:"3/18";i:13;s:4:"3/19";i:14;s:4:"3/20";i:15;s:4:"3/21";i:16;s:5:"4/311";i:17;s:5:"4/312";i:18;s:5:"3/307";i:19;s:5:"3/308";i:20;s:4:"2/22";i:21;s:4:"3/23";i:22;s:4:"3/24";i:23;s:4:"3/25";i:24;s:4:"3/26";i:25;s:4:"3/27";i:26;s:5:"2/327";i:27;s:5:"3/328";i:28;s:5:"4/333";i:29;s:5:"3/329";i:30;s:5:"4/334";i:31;s:5:"3/330";i:32;s:5:"3/331";i:33;s:5:"3/332";i:34;s:5:"2/404";i:35;s:5:"3/416";i:36;s:4:"1/31";i:37;s:4:"2/32";i:38;s:4:"3/33";i:39;s:4:"3/34";i:40;s:4:"3/35";i:41;s:4:"3/36";i:42;s:4:"3/37";i:43;s:4:"3/38";i:44;s:5:"3/387";i:45;s:5:"3/414";i:46;s:4:"2/39";i:47;s:4:"3/40";i:48;s:4:"3/41";i:49;s:4:"3/42";i:50;s:5:"2/101";i:51;s:5:"3/102";i:52;s:5:"3/103";i:53;s:5:"3/104";i:54;s:5:"3/105";i:55;s:5:"3/240";i:56;s:5:"2/111";i:57;s:5:"3/112";i:58;s:5:"3/113";i:59;s:5:"3/114";i:60;s:5:"3/115";i:61;s:5:"2/415";i:62;s:4:"2/85";i:63;s:3:"1/1";i:64;s:3:"2/2";i:65;s:3:"3/3";i:66;s:3:"3/4";i:67;s:3:"3/5";i:68;s:3:"3/6";i:69;s:3:"3/7";i:70;s:5:"3/351";i:71;s:5:"3/409";i:72;s:5:"3/410";i:73;s:5:"3/411";i:74;s:5:"3/412";i:75;s:5:"3/413";i:76;s:4:"2/56";i:77;s:4:"3/57";i:78;s:4:"3/59";i:79;s:4:"3/60";i:80;s:4:"3/61";i:81;s:5:"3/397";i:82;s:4:"2/62";i:83;s:5:"3/278";i:84;s:4:"2/63";i:85;s:4:"3/64";i:86;s:4:"3/65";i:87;s:4:"3/66";i:88;s:4:"2/67";i:89;s:4:"3/68";i:90;s:4:"3/69";i:91;s:4:"3/70";i:92;s:5:"1/257";i:93;s:5:"2/258";i:94;s:5:"3/259";i:95;s:5:"3/260";i:96;s:5:"3/261";i:97;s:5:"3/262";i:98;s:4:"2/99";i:99;s:5:"3/135";i:100;s:5:"3/136";i:101;s:4:"2/74";i:102;s:4:"3/75";i:103;s:4:"3/76";i:104;s:4:"3/77";i:105;s:4:"3/78";i:106;s:5:"3/305";i:107;s:4:"1/86";i:108;s:5:"2/287";i:109;s:5:"3/288";i:110;s:5:"3/289";i:111;s:5:"3/290";i:112;s:5:"3/291";i:113;s:5:"3/292";i:114;s:5:"2/313";i:115;s:5:"3/314";i:116;s:5:"2/317";i:117;s:5:"3/318";i:118;s:5:"3/319";i:119;s:5:"4/320";i:120;s:5:"4/321";i:121;s:5:"4/322";i:122;s:5:"3/323";i:123;s:5:"4/324";i:124;s:5:"4/325";i:125;s:5:"4/326";i:126;s:5:"2/381";i:127;s:5:"3/382";i:128;s:5:"3/383";i:129;s:5:"4/384";i:130;s:5:"4/385";i:131;s:5:"4/386";i:132;s:5:"2/402";i:133;s:5:"2/398";i:134;s:5:"1/501";}', 1, 1, 0, '2018-11-29 02:00:36'),
(2, '小程序', 'a:119:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:4:"2/22";i:15;s:4:"3/23";i:16;s:4:"3/24";i:17;s:4:"3/25";i:18;s:4:"3/26";i:19;s:4:"3/27";i:20;s:4:"1/31";i:21;s:4:"2/32";i:22;s:4:"3/33";i:23;s:4:"3/34";i:24;s:4:"3/35";i:25;s:4:"3/36";i:26;s:4:"3/37";i:27;s:4:"3/38";i:28;s:4:"2/39";i:29;s:4:"3/40";i:30;s:4:"3/41";i:31;s:4:"3/42";i:32;s:5:"2/101";i:33;s:5:"3/102";i:34;s:5:"3/103";i:35;s:5:"3/104";i:36;s:5:"3/105";i:37;s:5:"3/240";i:38;s:5:"2/111";i:39;s:5:"3/112";i:40;s:5:"3/113";i:41;s:5:"3/114";i:42;s:5:"3/115";i:43;s:4:"2/85";i:44;s:3:"1/1";i:45;s:3:"2/2";i:46;s:3:"3/3";i:47;s:3:"3/4";i:48;s:3:"3/5";i:49;s:3:"3/6";i:50;s:3:"3/7";i:51;s:4:"2/56";i:52;s:4:"3/57";i:53;s:4:"3/59";i:54;s:4:"3/60";i:55;s:4:"3/61";i:56;s:4:"2/62";i:57;s:5:"3/278";i:58;s:4:"2/63";i:59;s:4:"3/64";i:60;s:4:"3/65";i:61;s:4:"3/66";i:62;s:4:"2/67";i:63;s:4:"3/68";i:64;s:4:"3/69";i:65;s:4:"3/70";i:66;s:5:"1/257";i:67;s:5:"2/258";i:68;s:5:"3/259";i:69;s:5:"3/260";i:70;s:5:"3/261";i:71;s:5:"3/262";i:72;s:4:"2/99";i:73;s:5:"3/135";i:74;s:5:"3/136";i:75;s:4:"2/74";i:76;s:4:"3/75";i:77;s:4:"3/76";i:78;s:4:"3/77";i:79;s:4:"3/78";i:80;s:4:"1/86";i:81;s:5:"2/246";i:82;s:5:"3/310";i:83;s:4:"2/87";i:84;s:4:"3/88";i:85;s:4:"3/89";i:86;s:4:"3/90";i:87;s:4:"3/91";i:88;s:5:"2/287";i:89;s:5:"3/288";i:90;s:5:"3/289";i:91;s:5:"3/290";i:92;s:5:"3/291";i:93;s:5:"3/292";i:94;s:5:"1/264";i:95;s:5:"2/123";i:96;s:5:"3/124";i:97;s:5:"3/125";i:98;s:5:"3/126";i:99;s:5:"3/127";i:100;s:5:"3/128";i:101;s:5:"1/267";i:102;s:5:"2/116";i:103;s:5:"3/117";i:104;s:5:"3/118";i:105;s:5:"3/119";i:106;s:5:"3/120";i:107;s:5:"1/269";i:108;s:5:"2/140";i:109;s:5:"2/218";i:110;s:5:"2/275";i:111;s:5:"2/372";i:112;s:5:"3/373";i:113;s:5:"3/374";i:114;s:5:"3/375";i:115;s:5:"3/376";i:116;s:5:"2/388";i:117;s:5:"2/398";i:118;s:5:"3/400";}', 1, 1, 0, '2018-11-29 02:01:36'),
(3, 'APP', 'a:20:{i:0;s:5:"1/219";i:1;s:5:"2/220";i:2;s:5:"3/221";i:3;s:5:"3/222";i:4;s:5:"3/223";i:5;s:5:"3/224";i:6;s:5:"2/336";i:7;s:5:"1/282";i:8;s:5:"2/283";i:9;s:5:"3/284";i:10;s:5:"3/285";i:11;s:5:"3/286";i:12;s:5:"1/337";i:13;s:5:"2/338";i:14;s:5:"3/339";i:15;s:5:"3/340";i:16;s:5:"3/341";i:17;s:5:"3/342";i:18;s:5:"2/395";i:19;s:5:"3/401";}', 1, 1, 0, '2018-11-29 02:02:13'),
(4, '微信公众号', 'a:103:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:4:"2/22";i:15;s:4:"3/23";i:16;s:4:"3/24";i:17;s:4:"3/25";i:18;s:4:"3/26";i:19;s:4:"3/27";i:20;s:4:"2/28";i:21;s:4:"3/29";i:22;s:4:"3/30";i:23;s:4:"1/31";i:24;s:4:"2/32";i:25;s:4:"3/33";i:26;s:4:"3/34";i:27;s:4:"3/35";i:28;s:4:"3/36";i:29;s:4:"3/37";i:30;s:4:"3/38";i:31;s:4:"2/39";i:32;s:4:"3/40";i:33;s:4:"3/41";i:34;s:4:"3/42";i:35;s:5:"2/101";i:36;s:5:"3/102";i:37;s:5:"3/103";i:38;s:5:"3/104";i:39;s:5:"3/105";i:40;s:5:"3/240";i:41;s:5:"2/111";i:42;s:5:"3/112";i:43;s:5:"3/113";i:44;s:5:"3/114";i:45;s:5:"3/115";i:46;s:4:"2/85";i:47;s:3:"1/1";i:48;s:3:"2/2";i:49;s:3:"3/3";i:50;s:3:"3/4";i:51;s:3:"3/5";i:52;s:3:"3/6";i:53;s:3:"3/7";i:54;s:4:"2/56";i:55;s:4:"3/57";i:56;s:4:"3/59";i:57;s:4:"3/60";i:58;s:4:"3/61";i:59;s:4:"2/62";i:60;s:5:"3/278";i:61;s:4:"2/63";i:62;s:4:"3/64";i:63;s:4:"3/65";i:64;s:4:"3/66";i:65;s:4:"2/67";i:66;s:4:"3/68";i:67;s:4:"3/69";i:68;s:4:"3/70";i:69;s:5:"1/257";i:70;s:5:"2/258";i:71;s:5:"3/259";i:72;s:5:"3/260";i:73;s:5:"3/261";i:74;s:5:"3/262";i:75;s:4:"2/99";i:76;s:5:"3/135";i:77;s:5:"3/136";i:78;s:4:"2/74";i:79;s:4:"3/75";i:80;s:4:"3/76";i:81;s:4:"3/77";i:82;s:4:"3/78";i:83;s:4:"1/86";i:84;s:4:"2/87";i:85;s:4:"3/88";i:86;s:4:"3/89";i:87;s:4:"3/90";i:88;s:4:"3/91";i:89;s:4:"2/92";i:90;s:4:"3/93";i:91;s:4:"3/94";i:92;s:4:"3/95";i:93;s:4:"3/96";i:94;s:4:"3/97";i:95;s:4:"3/98";i:96;s:5:"2/248";i:97;s:5:"2/287";i:98;s:5:"3/288";i:99;s:5:"3/289";i:100;s:5:"3/290";i:101;s:5:"3/291";i:102;s:5:"3/292";}', 1, 1, 0, '2018-11-29 10:58:56'),
(5, 'PC', 'a:94:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:4:"2/22";i:15;s:4:"3/23";i:16;s:4:"3/24";i:17;s:4:"3/25";i:18;s:4:"3/26";i:19;s:4:"3/27";i:20;s:4:"1/31";i:21;s:4:"2/32";i:22;s:4:"3/33";i:23;s:4:"3/34";i:24;s:4:"3/35";i:25;s:4:"3/36";i:26;s:4:"3/37";i:27;s:4:"3/38";i:28;s:4:"2/39";i:29;s:4:"3/40";i:30;s:4:"3/41";i:31;s:4:"3/42";i:32;s:5:"2/101";i:33;s:5:"3/102";i:34;s:5:"3/103";i:35;s:5:"3/104";i:36;s:5:"3/105";i:37;s:5:"3/240";i:38;s:5:"2/111";i:39;s:5:"3/112";i:40;s:5:"3/113";i:41;s:5:"3/114";i:42;s:5:"3/115";i:43;s:4:"2/85";i:44;s:3:"1/1";i:45;s:3:"2/2";i:46;s:3:"3/3";i:47;s:3:"3/4";i:48;s:3:"3/5";i:49;s:3:"3/6";i:50;s:3:"3/7";i:51;s:5:"3/351";i:52;s:5:"3/409";i:53;s:5:"3/410";i:54;s:5:"3/411";i:55;s:5:"3/412";i:56;s:5:"3/413";i:57;s:4:"2/56";i:58;s:4:"3/57";i:59;s:4:"3/59";i:60;s:4:"3/60";i:61;s:4:"3/61";i:62;s:4:"2/62";i:63;s:5:"3/278";i:64;s:4:"2/63";i:65;s:4:"3/64";i:66;s:4:"3/65";i:67;s:4:"3/66";i:68;s:4:"2/67";i:69;s:4:"3/68";i:70;s:4:"3/69";i:71;s:4:"3/70";i:72;s:5:"1/257";i:73;s:5:"2/258";i:74;s:5:"3/259";i:75;s:5:"3/260";i:76;s:5:"3/261";i:77;s:5:"3/262";i:78;s:4:"2/99";i:79;s:5:"3/135";i:80;s:5:"3/136";i:81;s:4:"2/74";i:82;s:4:"3/75";i:83;s:4:"3/76";i:84;s:4:"3/77";i:85;s:4:"3/78";i:86;s:4:"1/86";i:87;s:5:"2/287";i:88;s:5:"3/288";i:89;s:5:"3/289";i:90;s:5:"3/290";i:91;s:5:"3/291";i:92;s:5:"3/292";i:93;s:5:"1/417";}', 1, 1, 0, '2018-11-29 11:02:27'),
(28, '测试', 'a:172:{i:0;s:1:"/";i:1;s:3:"1/8";i:2;s:3:"2/9";i:3;s:4:"3/10";i:4;s:4:"3/11";i:5;s:4:"3/12";i:6;s:4:"3/13";i:7;s:4:"3/14";i:8;s:4:"3/15";i:9;s:4:"3/16";i:10;s:5:"3/352";i:11;s:5:"3/403";i:12;s:4:"2/17";i:13;s:4:"3/18";i:14;s:4:"3/19";i:15;s:4:"3/20";i:16;s:4:"3/21";i:17;s:5:"4/311";i:18;s:5:"4/312";i:19;s:5:"3/307";i:20;s:5:"3/308";i:21;s:4:"2/22";i:22;s:4:"3/23";i:23;s:4:"3/24";i:24;s:4:"3/25";i:25;s:4:"3/26";i:26;s:4:"3/27";i:27;s:5:"2/327";i:28;s:5:"3/328";i:29;s:5:"4/333";i:30;s:5:"3/329";i:31;s:5:"4/334";i:32;s:5:"3/330";i:33;s:5:"3/331";i:34;s:5:"3/332";i:35;s:5:"2/404";i:36;s:5:"3/416";i:37;s:4:"1/31";i:38;s:4:"2/32";i:39;s:4:"3/33";i:40;s:4:"3/34";i:41;s:4:"3/35";i:42;s:4:"3/36";i:43;s:4:"3/37";i:44;s:4:"3/38";i:45;s:5:"3/387";i:46;s:5:"3/414";i:47;s:4:"2/39";i:48;s:4:"3/40";i:49;s:4:"3/41";i:50;s:4:"3/42";i:51;s:5:"2/101";i:52;s:5:"3/102";i:53;s:5:"3/103";i:54;s:5:"3/104";i:55;s:5:"3/105";i:56;s:5:"3/240";i:57;s:5:"2/111";i:58;s:5:"3/112";i:59;s:5:"3/113";i:60;s:5:"3/114";i:61;s:5:"3/115";i:62;s:5:"2/415";i:63;s:4:"2/85";i:64;s:3:"1/1";i:65;s:3:"2/2";i:66;s:3:"3/3";i:67;s:3:"3/4";i:68;s:3:"3/5";i:69;s:3:"3/6";i:70;s:3:"3/7";i:71;s:5:"3/351";i:72;s:5:"3/409";i:73;s:5:"3/410";i:74;s:5:"3/411";i:75;s:5:"3/412";i:76;s:5:"3/413";i:77;s:4:"2/56";i:78;s:4:"3/57";i:79;s:4:"3/59";i:80;s:4:"3/60";i:81;s:4:"3/61";i:82;s:5:"3/397";i:83;s:4:"2/62";i:84;s:5:"3/278";i:85;s:4:"2/63";i:86;s:4:"3/64";i:87;s:4:"3/65";i:88;s:4:"3/66";i:89;s:4:"2/67";i:90;s:4:"3/68";i:91;s:4:"3/69";i:92;s:4:"3/70";i:93;s:5:"1/257";i:94;s:5:"2/258";i:95;s:5:"3/259";i:96;s:5:"3/260";i:97;s:5:"3/261";i:98;s:5:"3/262";i:99;s:4:"2/99";i:100;s:5:"3/135";i:101;s:5:"3/136";i:102;s:4:"2/74";i:103;s:4:"3/75";i:104;s:4:"3/76";i:105;s:4:"3/77";i:106;s:4:"3/78";i:107;s:5:"3/305";i:108;s:4:"1/86";i:109;s:5:"2/287";i:110;s:5:"3/288";i:111;s:5:"3/289";i:112;s:5:"3/290";i:113;s:5:"3/291";i:114;s:5:"3/292";i:115;s:5:"2/313";i:116;s:5:"3/314";i:117;s:5:"2/317";i:118;s:5:"3/318";i:119;s:5:"3/319";i:120;s:5:"4/320";i:121;s:5:"4/321";i:122;s:5:"4/322";i:123;s:5:"3/323";i:124;s:5:"4/324";i:125;s:5:"4/325";i:126;s:5:"4/326";i:127;s:5:"2/381";i:128;s:5:"3/382";i:129;s:5:"3/383";i:130;s:5:"4/384";i:131;s:5:"4/385";i:132;s:5:"4/386";i:133;s:5:"2/402";i:134;s:5:"1/267";i:135;s:5:"2/116";i:136;s:5:"3/117";i:137;s:5:"3/118";i:138;s:5:"3/119";i:139;s:5:"3/120";i:140;s:5:"3/400";i:141;s:5:"1/269";i:142;s:5:"2/398";i:143;s:5:"2/140";i:144;s:5:"2/218";i:145;s:5:"2/372";i:146;s:5:"3/373";i:147;s:5:"3/374";i:148;s:5:"3/375";i:149;s:5:"3/376";i:150;s:5:"2/388";i:151;s:5:"1/219";i:152;s:5:"2/220";i:153;s:5:"3/221";i:154;s:5:"3/222";i:155;s:5:"3/223";i:156;s:5:"3/224";i:157;s:5:"2/336";i:158;s:5:"2/395";i:159;s:5:"1/282";i:160;s:5:"2/283";i:161;s:5:"3/284";i:162;s:5:"3/285";i:163;s:5:"3/286";i:164;s:5:"3/401";i:165;s:5:"1/276";i:166;s:5:"2/293";i:167;s:5:"3/294";i:168;s:5:"3/295";i:169;s:5:"3/296";i:170;s:5:"2/297";i:171;s:5:"2/298";}', 0, 1, 1, '2019-09-18 03:35:24'),
(6, '生活号', 'a:103:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:4:"2/22";i:15;s:4:"3/23";i:16;s:4:"3/24";i:17;s:4:"3/25";i:18;s:4:"3/26";i:19;s:4:"3/27";i:20;s:4:"2/28";i:21;s:4:"3/29";i:22;s:4:"3/30";i:23;s:4:"1/31";i:24;s:4:"2/32";i:25;s:4:"3/33";i:26;s:4:"3/34";i:27;s:4:"3/35";i:28;s:4:"3/36";i:29;s:4:"3/37";i:30;s:4:"3/38";i:31;s:4:"2/39";i:32;s:4:"3/40";i:33;s:4:"3/41";i:34;s:4:"3/42";i:35;s:5:"2/101";i:36;s:5:"3/102";i:37;s:5:"3/103";i:38;s:5:"3/104";i:39;s:5:"3/105";i:40;s:5:"3/240";i:41;s:5:"2/111";i:42;s:5:"3/112";i:43;s:5:"3/113";i:44;s:5:"3/114";i:45;s:5:"3/115";i:46;s:4:"2/85";i:47;s:3:"1/1";i:48;s:3:"2/2";i:49;s:3:"3/3";i:50;s:3:"3/4";i:51;s:3:"3/5";i:52;s:3:"3/6";i:53;s:3:"3/7";i:54;s:4:"2/56";i:55;s:4:"3/57";i:56;s:4:"3/59";i:57;s:4:"3/60";i:58;s:4:"3/61";i:59;s:4:"2/62";i:60;s:5:"3/278";i:61;s:4:"2/63";i:62;s:4:"3/64";i:63;s:4:"3/65";i:64;s:4:"3/66";i:65;s:4:"2/67";i:66;s:4:"3/68";i:67;s:4:"3/69";i:68;s:4:"3/70";i:69;s:5:"1/257";i:70;s:5:"2/258";i:71;s:5:"3/259";i:72;s:5:"3/260";i:73;s:5:"3/261";i:74;s:5:"3/262";i:75;s:4:"2/99";i:76;s:5:"3/135";i:77;s:5:"3/136";i:78;s:4:"2/74";i:79;s:4:"3/75";i:80;s:4:"3/76";i:81;s:4:"3/77";i:82;s:4:"3/78";i:83;s:4:"1/86";i:84;s:4:"2/87";i:85;s:4:"3/88";i:86;s:4:"3/89";i:87;s:4:"3/90";i:88;s:4:"3/91";i:89;s:4:"2/92";i:90;s:4:"3/93";i:91;s:4:"3/94";i:92;s:4:"3/95";i:93;s:4:"3/96";i:94;s:4:"3/97";i:95;s:4:"3/98";i:96;s:5:"2/248";i:97;s:5:"2/287";i:98;s:5:"3/288";i:99;s:5:"3/289";i:100;s:5:"3/290";i:101;s:5:"3/291";i:102;s:5:"3/292";}', 1, 1, 0, '2018-11-29 11:02:54'),
(7, '报表', 'a:7:{i:0;s:5:"1/276";i:1;s:5:"2/293";i:2;s:5:"3/294";i:3;s:5:"3/295";i:4;s:5:"3/296";i:5;s:5:"2/297";i:6;s:5:"2/298";}', 1, 1, 0, '2018-11-29 11:16:19'),
(18, 'test23', 'a:97:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:4:"2/22";i:15;s:4:"3/23";i:16;s:4:"3/24";i:17;s:4:"3/25";i:18;s:4:"3/26";i:19;s:4:"3/27";i:20;s:4:"2/28";i:21;s:4:"3/29";i:22;s:4:"3/30";i:23;s:4:"1/31";i:24;s:4:"2/32";i:25;s:4:"3/33";i:26;s:4:"3/34";i:27;s:4:"3/35";i:28;s:4:"3/36";i:29;s:4:"3/37";i:30;s:4:"3/38";i:31;s:4:"2/39";i:32;s:4:"3/40";i:33;s:4:"3/41";i:34;s:4:"3/42";i:35;s:5:"2/101";i:36;s:5:"3/102";i:37;s:5:"3/103";i:38;s:5:"3/104";i:39;s:5:"3/105";i:40;s:5:"3/240";i:41;s:5:"2/111";i:42;s:5:"3/112";i:43;s:5:"3/113";i:44;s:5:"3/114";i:45;s:5:"3/115";i:46;s:4:"2/85";i:47;s:3:"1/1";i:48;s:3:"2/2";i:49;s:3:"3/3";i:50;s:3:"3/4";i:51;s:3:"3/5";i:52;s:3:"3/6";i:53;s:3:"3/7";i:54;s:4:"2/56";i:55;s:4:"3/57";i:56;s:4:"3/58";i:57;s:4:"3/59";i:58;s:4:"3/60";i:59;s:4:"3/61";i:60;s:4:"2/62";i:61;s:4:"2/63";i:62;s:4:"3/64";i:63;s:4:"3/65";i:64;s:4:"3/66";i:65;s:4:"2/67";i:66;s:4:"3/68";i:67;s:4:"3/69";i:68;s:4:"3/70";i:69;s:5:"1/257";i:70;s:5:"2/258";i:71;s:5:"3/259";i:72;s:5:"3/260";i:73;s:5:"3/261";i:74;s:5:"3/262";i:75;s:4:"2/99";i:76;s:5:"3/135";i:77;s:5:"3/136";i:78;s:4:"2/74";i:79;s:4:"3/75";i:80;s:4:"3/76";i:81;s:4:"3/77";i:82;s:4:"3/78";i:83;s:4:"1/86";i:84;s:4:"2/87";i:85;s:4:"3/88";i:86;s:4:"3/89";i:87;s:4:"3/90";i:88;s:4:"3/91";i:89;s:4:"2/92";i:90;s:4:"3/93";i:91;s:4:"3/94";i:92;s:4:"3/95";i:93;s:4:"3/96";i:94;s:4:"3/97";i:95;s:4:"3/98";i:96;s:5:"2/248";}', 0, 1, 23, '2018-12-16 18:27:28'),
(16, '访客', 'a:49:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/16";i:4;s:4:"2/17";i:5;s:4:"3/18";i:6;s:4:"2/22";i:7;s:4:"3/23";i:8;s:4:"1/31";i:9;s:4:"2/32";i:10;s:4:"3/34";i:11;s:4:"3/38";i:12;s:3:"1/1";i:13;s:3:"2/2";i:14;s:3:"3/3";i:15;s:3:"3/4";i:16;s:3:"3/5";i:17;s:3:"3/6";i:18;s:3:"3/7";i:19;s:4:"2/56";i:20;s:4:"3/57";i:21;s:4:"3/59";i:22;s:4:"3/60";i:23;s:4:"3/61";i:24;s:4:"2/62";i:25;s:5:"3/278";i:26;s:4:"2/63";i:27;s:4:"3/64";i:28;s:4:"3/65";i:29;s:4:"3/66";i:30;s:4:"2/67";i:31;s:4:"3/68";i:32;s:4:"3/69";i:33;s:4:"3/70";i:34;s:5:"1/257";i:35;s:5:"2/258";i:36;s:5:"3/259";i:37;s:5:"3/260";i:38;s:5:"3/261";i:39;s:5:"3/262";i:40;s:4:"2/99";i:41;s:5:"3/135";i:42;s:5:"3/136";i:43;s:4:"2/74";i:44;s:4:"3/75";i:45;s:4:"3/76";i:46;s:4:"3/77";i:47;s:4:"3/78";i:48;s:5:"3/305";}', 0, 1, 1, '2018-12-06 02:17:52'),
(17, '1', 'a:23:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:4:"2/22";i:15;s:4:"3/23";i:16;s:4:"3/24";i:17;s:4:"3/25";i:18;s:4:"3/26";i:19;s:4:"3/27";i:20;s:4:"2/28";i:21;s:4:"3/29";i:22;s:4:"3/30";}', 0, 34, 27, '2018-12-12 21:33:59'),
(23, '访客', 'a:6:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/16";i:4;s:4:"2/17";i:5;s:4:"3/21";}', 0, 42, 28, '2019-01-07 01:41:27'),
(24, '客服', 'a:13:{i:0;s:4:"1/31";i:1;s:4:"2/32";i:2;s:4:"3/33";i:3;s:4:"2/39";i:4;s:4:"3/40";i:5;s:4:"3/41";i:6;s:4:"3/42";i:7;s:5:"2/101";i:8;s:5:"3/102";i:9;s:5:"3/103";i:10;s:5:"3/104";i:11;s:5:"3/105";i:12;s:5:"3/240";}', 0, 42, 28, '2019-01-07 02:00:00'),
(25, '报表', 'a:58:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:4:"2/17";i:10;s:4:"3/18";i:11;s:4:"3/19";i:12;s:4:"3/20";i:13;s:4:"3/21";i:14;s:5:"3/307";i:15;s:5:"3/308";i:16;s:4:"2/22";i:17;s:4:"3/23";i:18;s:4:"3/24";i:19;s:4:"3/25";i:20;s:4:"3/26";i:21;s:4:"3/27";i:22;s:5:"2/327";i:23;s:5:"3/328";i:24;s:5:"3/329";i:25;s:5:"3/330";i:26;s:5:"3/331";i:27;s:5:"3/332";i:28;s:4:"1/31";i:29;s:4:"2/32";i:30;s:4:"3/33";i:31;s:4:"3/34";i:32;s:4:"3/35";i:33;s:4:"3/37";i:34;s:4:"3/38";i:35;s:5:"3/387";i:36;s:4:"2/39";i:37;s:4:"3/40";i:38;s:4:"3/41";i:39;s:4:"3/42";i:40;s:5:"2/101";i:41;s:5:"3/102";i:42;s:5:"3/103";i:43;s:5:"3/104";i:44;s:5:"3/105";i:45;s:5:"3/240";i:46;s:5:"2/111";i:47;s:5:"3/112";i:48;s:5:"3/113";i:49;s:5:"3/114";i:50;s:5:"3/115";i:51;s:5:"1/276";i:52;s:5:"2/293";i:53;s:5:"3/294";i:54;s:5:"3/295";i:55;s:5:"3/296";i:56;s:5:"2/297";i:57;s:5:"2/298";}', 0, 1, 1, '2019-01-22 10:02:11'),
(8, '商户管理', 'a:47:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:5:"2/327";i:10;s:5:"3/328";i:11;s:5:"4/333";i:12;s:5:"3/329";i:13;s:5:"4/334";i:14;s:5:"3/330";i:15;s:5:"3/331";i:16;s:5:"3/332";i:17;s:4:"1/31";i:18;s:4:"2/32";i:19;s:4:"3/33";i:20;s:4:"3/34";i:21;s:4:"3/35";i:22;s:4:"3/36";i:23;s:4:"3/37";i:24;s:4:"3/38";i:25;s:4:"2/39";i:26;s:4:"3/40";i:27;s:4:"3/41";i:28;s:4:"3/42";i:29;s:5:"2/111";i:30;s:5:"3/112";i:31;s:5:"3/113";i:32;s:5:"3/114";i:33;s:5:"3/115";i:34;s:3:"1/1";i:35;s:4:"2/56";i:36;s:4:"3/57";i:37;s:4:"3/59";i:38;s:4:"3/60";i:39;s:4:"3/61";i:40;s:4:"1/86";i:41;s:5:"2/287";i:42;s:5:"3/288";i:43;s:5:"3/289";i:44;s:5:"3/290";i:45;s:5:"3/291";i:46;s:5:"3/292";}', 2, 1, 0, '2019-01-31 02:57:06'),
(27, '商品发布', 'a:33:{i:0;s:3:"1/8";i:1;s:3:"2/9";i:2;s:4:"3/10";i:3;s:4:"3/11";i:4;s:4:"3/12";i:5;s:4:"3/13";i:6;s:4:"3/14";i:7;s:4:"3/15";i:8;s:4:"3/16";i:9;s:5:"3/352";i:10;s:4:"2/17";i:11;s:4:"3/18";i:12;s:4:"3/19";i:13;s:4:"3/20";i:14;s:4:"3/21";i:15;s:5:"4/311";i:16;s:5:"4/312";i:17;s:5:"3/307";i:18;s:5:"3/308";i:19;s:4:"2/22";i:20;s:4:"3/23";i:21;s:4:"3/24";i:22;s:4:"3/25";i:23;s:4:"3/26";i:24;s:4:"3/27";i:25;s:5:"2/327";i:26;s:5:"3/328";i:27;s:5:"4/333";i:28;s:5:"3/329";i:29;s:5:"4/334";i:30;s:5:"3/330";i:31;s:5:"3/331";i:32;s:5:"3/332";}', 0, 1, 1, '2019-06-20 06:13:00'),
(29, '超级管理员', NULL, 0, 1, 1, '2019-09-25 10:04:05');

-- ----------------------------
-- Table structure for lkt_service_address
-- ----------------------------
DROP TABLE IF EXISTS `lkt_service_address`;
CREATE TABLE `lkt_service_address`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '售后地址id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人姓名',
  `tel` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系电话',
  `sheng` char(100) NOT NULL DEFAULT 0 COMMENT '省id',
  `shi` char(100) NOT NULL DEFAULT 0 COMMENT '市id',
  `xian` char(100) NOT NULL DEFAULT 0 COMMENT '区域id',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货地址（不加省，市，区）',
  `address_xq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省市区+详细地址',
  `code` int(11) NOT NULL DEFAULT 0 COMMENT '邮政编号',
  `uid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '代表该地址是售后地址',
  `is_default` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否为默认收货地址 1.是  0.不是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_session_id
-- ----------------------------
DROP TABLE IF EXISTS `lkt_session_id`;
CREATE TABLE `lkt_session_id`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `session_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'session_id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `type` tinyint(4) DEFAULT '0' COMMENT '类型 0.发送短信 1.商品 2.退货申请 3.评论',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'session_id表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_set_notice
-- ----------------------------
DROP TABLE IF EXISTS `lkt_set_notice`;
CREATE TABLE `lkt_set_notice`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告名称',
  `detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `img_url` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `user` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布者',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '公告列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_setscore
-- ----------------------------
DROP TABLE IF EXISTS `lkt_setscore`;
CREATE TABLE `lkt_setscore`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `lever` smallint(6) NULL DEFAULT NULL COMMENT '等级',
  `ordernum` int(11) NULL DEFAULT NULL COMMENT '订单金额',
  `scorenum` int(11) NULL DEFAULT NULL COMMENT '可抵用消费金额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '积分抵用消费金额表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for lkt_share
-- ----------------------------
DROP TABLE IF EXISTS `lkt_share`;
CREATE TABLE `lkt_share`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户id',
  `wx_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信id',
  `wx_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信昵称',
  `sex` int(11) NULL DEFAULT NULL COMMENT '性别 0:未知 1:男 2:女',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类别 0：新闻 1：文章',
  `Article_id` int(11) NOT NULL DEFAULT 0 COMMENT '新闻id',
  `share_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '分享时间',
  `coupon` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '礼券',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分享列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_sign_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_sign_config`;
CREATE TABLE `lkt_sign_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `is_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '签到插件是否启用 0：未启用 1：启用',
  `score_num` int(11) NOT NULL DEFAULT 0 COMMENT '签到次数',
  `starttime` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '签到有效开始时间',
  `endtime` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '签到有效结束时间',
  `is_remind` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否提醒 0：不提醒 1：提醒',
  `reset` int(11) NOT NULL DEFAULT 0 COMMENT '间隔时间',
  `is_many_time` tinyint(4) DEFAULT 0 COMMENT '是否允许多次 0:不允许  1:允许',
  `imgurl` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图片',
  `score` int(11) NOT NULL DEFAULT 0 COMMENT '领取积分',
  `continuity` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '连续设置',
  `detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '签到详情',
  `Instructions` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '积分使用说明',
  `modify_date` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '签到配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_sign_record
-- ----------------------------
DROP TABLE IF EXISTS `lkt_sign_record`;
CREATE TABLE `lkt_sign_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `sign_score` int(11) NOT NULL DEFAULT 0 COMMENT '签到积分',
  `record` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '事件',
  `sign_time` timestamp NULL DEFAULT NULL COMMENT '签到时间',
  `type` int(4) NOT NULL DEFAULT '0' COMMENT '类型: 0:签到 1:消费 2:首次关注得积分 3:转积分给好友 4:好友转积分 5:系统扣除 6:系统充值 8:会员购物积分 9:分销升级奖励积分 10:积分过期',
  `recovery` tinyint(2) NULL DEFAULT 0 COMMENT '是否删除 0.未删除 1.\r\n删除',
  `sNo` char(100) DEFAULT NULL COMMENT '订单编号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '签到记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_software_jifen
-- ----------------------------
DROP TABLE IF EXISTS `lkt_software_jifen`;
CREATE TABLE `lkt_software_jifen`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `jifennum` int(11) NULL DEFAULT NULL COMMENT '首次关注小程序积分',
  `switch` int(11) NOT NULL DEFAULT 0 COMMENT '是否开启积分转让（0.关闭 1.开启）',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '积分规则',
  `xiaofeibili` int(11) NOT NULL DEFAULT 10 COMMENT '积分消费比例',
  `xiaofeiguize` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '积分消费规则',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '首次关注小程序积分表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_stock
-- ----------------------------
DROP TABLE IF EXISTS `lkt_stock`;
CREATE TABLE `lkt_stock`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `product_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品id',
  `attribute_id` int(11) NOT NULL DEFAULT 0 COMMENT '属性id',
  `total_num` int(11) NOT NULL DEFAULT 0 COMMENT '总库存',
  `flowing_num` int(11) NOT NULL DEFAULT 0 COMMENT '入库/出库',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型 0.入库 1.出库 2.预警',
  `user_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '购买方',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '库存记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_subtraction
-- ----------------------------
DROP TABLE IF EXISTS `lkt_subtraction`;
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
) engine='innodb' AUTO_INCREMENT = 1 charset='utf8' comment '满减表';

-- ----------------------------
-- Table structure for lkt_subtraction_config
-- ----------------------------
DROP TABLE IF EXISTS `lkt_subtraction_config`;
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
) engine='myisam' AUTO_INCREMENT = 1 charset='utf8' comment '满减设置表';

DROP TABLE IF EXISTS `lkt_subtraction_record`;
-- 满减记录表
create table lkt_subtraction_record (
  id int(11) unsigned primary key auto_increment comment 'ID',
  h_id int(11) not null default 0 comment '满减活动ID',
  sNo varchar(255) DEFAULT NULL COMMENT '订单号',
  user_id char(15) NOT NULL COMMENT '用户id',
  content text COMMENT '活动内容',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' AUTO_INCREMENT = 1 charset='utf8' comment '满减记录表';

-- ----------------------------
-- Table structure for lkt_system_message
-- ----------------------------
DROP TABLE IF EXISTS `lkt_system_message`;
CREATE TABLE `lkt_system_message`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `senderid` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送人ID',
  `recipientid` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接收人ID',
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `time` datetime NULL DEFAULT NULL COMMENT '时间',
  `type` int(2) NOT NULL DEFAULT 1 COMMENT '1未读  2 已读',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统消息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_system_tell
-- ----------------------------
DROP TABLE IF EXISTS `lkt_system_tell`;
CREATE TABLE `lkt_system_tell`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '公告标题',
  `type` tinyint(4) NULL DEFAULT NULL COMMENT '公告类型: 1.系统维护  2.版本更新',
  `startdate` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '开始时间',
  `enddate` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '结束时间',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统公告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_third
-- ----------------------------
DROP TABLE IF EXISTS `lkt_third`;
CREATE TABLE `lkt_third`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `ticket` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '获取token的凭证',
  `ticket_time` timestamp NULL DEFAULT NULL COMMENT '凭证更新时间',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权token',
  `token_expires` int(11) NULL DEFAULT NULL COMMENT 'token过期时间戳',
  `appid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '第三方平台appid',
  `appsecret` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '第三方平台秘钥',
  `check_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '消息检验Token，第三方平台设置',
  `encrypt_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '消息加减密key',
  `serve_domain` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '服务器域名',
  `work_domain` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '业务域名',
  `redirect_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '授权回调地址',
  `mini_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '小程序接口地址',
  `kefu_url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '客服接口url',
  `qr_code` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '体验二维码url',
  `H5` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'H5页面地址',
  `endurl` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '根目录路径',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '第三方授权表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_third_mini_info
-- ----------------------------
DROP TABLE IF EXISTS `lkt_third_mini_info`;
CREATE TABLE `lkt_third_mini_info`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `nick_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权方昵称',
  `authorizer_appid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权小程序appid',
  `authorizer_access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权方接口调用凭据（在授权的公众号或小程序具备API权限时，才有此返回值），也简称为令牌',
  `authorizer_expires` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '有效期（在授权的公众号或小程序具备API权限时，才有此返回值）',
  `authorizer_refresh_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '接口调用凭据刷新令牌',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `func_info` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '授权给开发者的权限集列表',
  `expires_time` int(11) NULL DEFAULT NULL COMMENT '过期时间戳',
  `company_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司id',
  `head_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权方头像',
  `verify_type_info` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授权方认证类型，-1代表未认证，0代表微信认证',
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小程序的原始ID',
  `signature` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '帐号介绍',
  `principal_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小程序的主体名称',
  `business_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开通状况（0代表未开通，1代表已开通）',
  `qrcode_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '二维码图片的URL，开发者最好自行也进行保存',
  `miniprograminfo` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '根据这个字段判断是否为小程序类型授权',
  `store_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商城id',
  `auditid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '审核编号',
  `review_mark` tinyint(2) NULL DEFAULT 1 COMMENT '审核状态 1：未审核 2：审核中 3：审核失败 4：审核成功',
  `issue_mark` tinyint(2) NULL DEFAULT 1 COMMENT '发布状态 1：未发布  2：发布失败 3：发布成功',
  `submit_time` datetime NULL DEFAULT NULL COMMENT '审核提价时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '授权小程序信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_third_template
-- ----------------------------
DROP TABLE IF EXISTS `lkt_third_template`;
CREATE TABLE `lkt_third_template`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `template_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信端模板id',
  `wx_desc` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'wx模板描述',
  `wx_version` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'wx模板版本号',
  `wx_create_time` int(11) NULL DEFAULT NULL COMMENT '添加进开放平台模板库时间戳',
  `lk_version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '后台定义的模板编号',
  `lk_desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '后台模板描述',
  `img_url` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模板图片路劲',
  `store_id` int(11) NULL DEFAULT NULL COMMENT '商城id',
  `trade_data` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数据字典-行业',
  `is_use` tinyint(2) NULL DEFAULT 1 COMMENT '是否应用 0：不应用 1：应用',
  `update_time` datetime NULL DEFAULT NULL COMMENT '模板更新时间',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模板名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '小程序模板表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lkt_score_over
-- ----------------------------
DROP TABLE IF EXISTS `lkt_score_over`;
CREATE TABLE `lkt_score_over` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `user_id` varchar(15) NOT NULL COMMENT '用户ID',
  `old_score` int(11) NOT NULL DEFAULT '0' COMMENT '原积分',
  `now_score` int(11) DEFAULT '0' COMMENT '现积分',
  `last_pay` int(11) DEFAULT '0' COMMENT '已计算花费积分',
  `count_time` timestamp NULL DEFAULT NULL COMMENT '上次过期时间',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '计算时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='积分过期记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_upload_set
-- ----------------------------
DROP TABLE IF EXISTS `lkt_upload_set`;
CREATE TABLE `lkt_upload_set`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `upserver` tinyint(4) NULL DEFAULT '2' COMMENT '上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云',
  `type` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类别',
  `attr` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '属性',
  `attrvalue` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '值',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 348 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '上传配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lkt_upload_set
-- ----------------------------
INSERT INTO `lkt_upload_set` (`id`, `upserver`, `type`, `attr`, `attrvalue`) VALUES
(346, 2, '七牛云', 'imagestyle', ''),
(345, 2, '七牛云', 'SecretKey', ''),
(344, 2, '七牛云', 'AccessKey', ''),
(343, 2, '七牛云', 'Endpoint', ''),
(342, 2, '七牛云', 'Bucket', ''),
(341, 2, '腾讯云', 'SecretKey', ''),
(340, 2, '腾讯云', 'SecretId', ''),
(339, 2, '腾讯云', 'zidingyi', ''),
(335, 2, '阿里云OSS', 'AccessKeySecret', 'NP6d3Nqow5aUzfM9kthylZKs0VWsmU'),
(338, 2, '腾讯云', 'Endpoint', ''),
(337, 2, '腾讯云', 'Bucket', ''),
(336, 2, '阿里云OSS', 'imagestyle', ''),
(333, 2, '阿里云OSS', 'isopenzdy', '0'),
(334, 2, '阿里云OSS', 'AccessKeyID', 'PkrNOfg21LOG980i'),
(332, 2, '阿里云OSS', 'Endpoint', 'oss-cn-shenzhen.aliyuncs.com'),
(331, 2, '阿里云OSS', 'Bucket', 'laikeds'),
(329, 2, '本地', 'uploadImg_domain', 'https://xiaochengxu.laiketui.com/V2.6'),
(330, 2, '本地', 'uploadImg', './images/');

-- ----------------------------
-- Table structure for lkt_user
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user`;
CREATE TABLE `lkt_user` (
  `id` int(11) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `user_id` char(15) DEFAULT NULL COMMENT '用户id',
  `user_name` varbinary(100) DEFAULT NULL COMMENT '用户昵称',
  `access_id` varchar(255) DEFAULT NULL COMMENT '授权id',
  `access_key` varchar(32) DEFAULT NULL COMMENT '授权密钥',
  `wx_id` varchar(50) DEFAULT NULL COMMENT '微信id',
  `wx_name` varbinary(150) DEFAULT NULL COMMENT '微信昵称',
  `gzh_id` varchar(50) DEFAULT '' COMMENT '公众号id',
  `zfb_id` varchar(50) DEFAULT NULL COMMENT '支付宝id',
  `bd_id` varchar(50) DEFAULT NULL COMMENT '百度id',
  `tt_id` varchar(50) DEFAULT NULL COMMENT '头条id',
  `clientid` varchar(255) DEFAULT NULL COMMENT '推送客户端ID',
  `sex` int(11) DEFAULT NULL COMMENT '性别 0:未知 1:男 2:女',
  `headimgurl` mediumtext COMMENT '微信头像',
  `province` varchar(50) DEFAULT '' COMMENT '省',
  `city` varchar(50) DEFAULT '' COMMENT '市',
  `county` varchar(50) DEFAULT '' COMMENT '县',
  `detailed_address` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `money` decimal(12,2) DEFAULT '0.00' COMMENT '金额',
  `score` int(11) unsigned DEFAULT '0' COMMENT '积分',
  `lock_score` int(11) unsigned DEFAULT '0' COMMENT '冻结的积分',
  `password` char(32) DEFAULT NULL COMMENT '支付密码',
  `Register_data` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `e_mail` varchar(30) DEFAULT NULL COMMENT '邮箱',
  `real_name` varchar(100) DEFAULT NULL COMMENT '真实姓名',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `birthday` timestamp NULL DEFAULT NULL COMMENT '出生日期',
  `wechat_id` varchar(50) DEFAULT '' COMMENT '微信号',
  `address` varchar(300) DEFAULT NULL COMMENT '地址',
  `Bank_name` varchar(30) DEFAULT NULL COMMENT '银行名称',
  `Cardholder` varchar(30) DEFAULT NULL COMMENT '持卡人',
  `Bank_card_number` varchar(30) DEFAULT NULL COMMENT '银行卡号',
  `share_num` int(11) DEFAULT '0' COMMENT '分享次数',
  `Referee` char(15) DEFAULT NULL COMMENT '推荐人',
  `access_token` varchar(32) DEFAULT '' COMMENT '访问令牌',
  `consumer_money` decimal(12,2) DEFAULT '0.00' COMMENT '消费金',
  `img_token` varchar(32) DEFAULT NULL COMMENT '分享图片id',
  `zhanghao` varchar(32) DEFAULT NULL COMMENT '账号',
  `mima` varchar(32) DEFAULT NULL COMMENT '密码',
  `source` tinyint(4) NOT NULL DEFAULT '1' COMMENT '来源 1.小程序 2.app',
  `login_num` int(11) DEFAULT '0' COMMENT '登录次数',
  `verification_time` timestamp NULL DEFAULT NULL COMMENT '验证支付密码时间',
  `parameter` text COMMENT '参数',
  `is_lock` tinyint(2) DEFAULT '0' COMMENT '是否冻结 0-不冻结 1-冻结',
  `last_time` timestamp NULL DEFAULT NULL COMMENT '最后一次登录时间',
  `grade` int(11) DEFAULT '0' COMMENT '会员级别 0--普通会员 ',
  `tui_id` char(50) DEFAULT NULL COMMENT '会员推荐人id',
  `grade_add` timestamp NULL DEFAULT NULL COMMENT '充值会员等级时间',
  `grade_m` tinyint(4) DEFAULT NULL COMMENT '开通方式 1-包月 2-包季 3-包年',
  `grade_end` timestamp NULL DEFAULT NULL COMMENT '会员等级到期时间',
  `is_out` tinyint(2) DEFAULT '0' COMMENT '是否到期 0-未到期  1-已到期',
  `is_box` tinyint(2) DEFAULT '1' COMMENT '是否同意续费弹框 0-不同意 1 同意'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='会员列表';

-- ----------------------------
-- Table structure for lkt_user_address
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_address`;
CREATE TABLE `lkt_user_address`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '地址id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人',
  `tel` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系方式',
  `sheng` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '省id',
  `city` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '市id',
  `quyu` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '区域id',
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货地址（不加省市区）',
  `address_xq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省市区+详细地址',
  `code` int(11) NOT NULL DEFAULT 0 COMMENT '邮政编号',
  `uid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '用户ID',
  `is_default` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否默认地址 1默认',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户收货地址表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_user_bank_card
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_bank_card`;
CREATE TABLE `lkt_user_bank_card`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `Cardholder` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '持卡人',
  `id_card` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证',
  `Bank_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行名称',
  `branch` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支行名称',
  `Bank_card_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行卡号',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否默认地址 1默认',
  `mch_id` int(11) NULL DEFAULT 0 COMMENT '店铺ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户退货表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_user_collection
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_collection`;
CREATE TABLE `lkt_user_collection`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '用户ID',
  `p_id` int(11) NULL DEFAULT NULL COMMENT '产品id',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `mch_id` int(11) NULL DEFAULT 0 COMMENT '店铺ID',
  `type`  int(11) NULL DEFAULT 1 COMMENT '收藏类型 1.普通收藏 2.积分商城收藏',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '收藏表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_user_distribution
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_distribution`;
CREATE TABLE `lkt_user_distribution` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `user_id` varchar(32) NOT NULL COMMENT '用户ID',
  `pid` varchar(32) NOT NULL COMMENT '上级id',
  `level` int(11) NOT NULL COMMENT '等级',
  `lt` int(11) NOT NULL COMMENT 'lt',
  `rt` int(11) NOT NULL COMMENT 'rt',
  `uplevel` int(11) NOT NULL COMMENT '第几代',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `usets` varchar(255) DEFAULT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计佣金',
  `onlyamount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '累计消费',
  `allamount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '销售业绩',
  `one_put` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '个人进货奖励已经发放最大条件',
  `team_put` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '团队业绩奖励已经发放最大',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='分销关联表';

-- ----------------------------
-- Table structure for lkt_user_footprint
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_footprint`;
CREATE TABLE `lkt_user_footprint`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户ID',
  `p_id` int(11) NULL DEFAULT NULL COMMENT '产品id',
  `app_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'mini_program' COMMENT '平台类型',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '足迹表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lkt_user_fromid
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_fromid`;
CREATE TABLE `lkt_user_fromid`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `open_id` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户openid',
  `fromid` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户fromid',
  `lifetime` datetime NULL DEFAULT NULL COMMENT '生命周期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户fromid' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for lkt_user_first
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_first`;
CREATE TABLE `lkt_user_first` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` char(50) DEFAULT NULL COMMENT '用户id',
  `grade_id` int(11) DEFAULT NULL COMMENT '会员等级id',
  `level` int(11) DEFAULT NULL COMMENT '首次开通会员级别',
  `store_id` int(11) DEFAULT NULL COMMENT '商城id',
  `is_use` tinyint(2) DEFAULT '0' COMMENT '是否使用了首次开通赠送商品券 0-未使用 1-已使用',
  `sNo` char(50) DEFAULT NULL COMMENT '订单编号',
  `end_time` datetime DEFAULT NULL COMMENT '兑换券失效时间',
  `attr_id` int(11) DEFAULT NULL COMMENT '兑换商品的规格id',
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT='等级会员首次开通表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for lkt_user_grade
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_grade`;
CREATE TABLE `lkt_user_grade` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(120) DEFAULT NULL COMMENT '等级名称',
  `rate` decimal(12,2) DEFAULT NULL COMMENT '打折率',
  `money` decimal(12,2) DEFAULT NULL COMMENT '包月金额',
  `store_id` int(11) unsigned DEFAULT NULL COMMENT '商城id',
  `money_j` decimal(12,2) DEFAULT NULL COMMENT '包季金额',
  `money_n` decimal(12,2) DEFAULT NULL COMMENT '包年金额',
  `remark` text COMMENT '备注',
  `imgurl` char(150) DEFAULT NULL COMMENT '会员充值背景图',
  `imgurl_my` char(150) DEFAULT NULL COMMENT '我的会员背景展示图',
  `imgurl_s` char(150) DEFAULT NULL COMMENT '等级中心背景图',
  `level` int(11) DEFAULT NULL COMMENT '会员级别 普通-0   白银-1  黄金-2  黑金-3',
  `pro_id` int(11) DEFAULT NULL COMMENT '赠送商品id',
  `font_color` char(50) DEFAULT NULL COMMENT '会员昵称字体颜色',
  `date_color` char(50) DEFAULT NULL COMMENT '标识文字颜色',
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员等级表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for lkt_user_rule
-- ----------------------------
DROP TABLE IF EXISTS `lkt_user_rule`;
CREATE TABLE `lkt_user_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `rate_now` decimal(12,2) DEFAULT NULL COMMENT '默认折率',
  `active` char(50) DEFAULT '1' COMMENT '支持的插件使用折率：1--正价商品 2--支持拼团 3--支持砍价 4--支持竞拍  5--分销  6--秒杀',
  `rule` text COMMENT '会员等级规则详情',
  `wait` int(11) DEFAULT NULL COMMENT '有效期',
  `store_id` int(11) unsigned DEFAULT NULL COMMENT '商城id',
  `is_auto` tinyint(2) DEFAULT '1' COMMENT '是否开启自动续费 0-不开启 1-开启',
  `auto_time` int(11) unsigned DEFAULT NULL COMMENT '自动续费提前提醒时间（天）',
  `method` char(50) DEFAULT NULL COMMENT '开通方式 1-包月 2-包季 3-包年',
  `is_wallet` tinyint(2) DEFAULT '1' COMMENT '是否开启余额支付 0-不开启 1-开启',
  `upgrade` char(50) DEFAULT '1' COMMENT '升级方式 1-购买会员服务 2-补差额',
  `is_birthday` tinyint(2) DEFAULT '0' COMMENT '是否开启生日特权 0-不开启 1-开启',
  `bir_multiple` int(11) DEFAULT '1' COMMENT '生日特权积分倍数',
  `is_product` tinyint(2) DEFAULT '0' COMMENT '是否开启会员赠送商品 0-不开启 1-开启',
  `is_jifen` tinyint(2) DEFAULT '0' COMMENT '会员等比例积分 0-不开启 1-开启',
  `jifen_m` tinyint(2) DEFAULT '1' COMMENT '积分发送规则 0-付款后 1-收货后',
  `back` tinyint(2) DEFAULT NULL COMMENT '是否开启返现 0-不开启 1-开启',
  `back_scale` decimal(12,2) DEFAULT NULL COMMENT '返现比例',
  `poster` char(50) DEFAULT NULL COMMENT '会员分享海报',
  `is_limit` tinyint(2) DEFAULT '0' COMMENT '是否开启推荐限制 0-不限制  1-限制',
  `level` int(11) DEFAULT NULL COMMENT '可以推荐的会员级别',
  `distribute_l` int(11) DEFAULT '0' COMMENT '可以参与分销的会员级别id',
  `valid` int(11) DEFAULT '7' COMMENT '增送商品的有效天数',
  `score`  int(11) NULL DEFAULT 0 COMMENT '积分过期设置',
  PRIMARY KEY (`id`)
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员规则表' ROW_FORMAT = Fixed;
-- ----------------------------
-- Table structure for lkt_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `lkt_withdraw`;
CREATE TABLE `lkt_withdraw`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT 0 COMMENT '商城id',
  `user_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `wx_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信id',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `Bank_id` int(11) NOT NULL COMMENT '银行卡id',
  `money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '提现金额',
  `z_money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '剩余金额',
  `s_charge` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态 0：审核中 1：审核通过 2：拒绝',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '申请时间',
  `refuse` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '拒绝原因',
  `is_mch` int(2) NULL DEFAULT 0 COMMENT '是否是店铺提现',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '提现列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Triggers structure for table lkt_product_list
-- ----------------------------
DROP TRIGGER IF EXISTS `ismarket`;
delimiter ;;
CREATE TRIGGER `ismarket` AFTER UPDATE ON `lkt_product_list` FOR EACH ROW begin
 IF new.status=1 then
   update lkt_group_product set g_status=3 where product_id=new.id;
   update lkt_bargain_goods set is_delete=0 where goods_id=new.id;
 end if;
end
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------
-- Table structure for `lkt_integral_goods`
-- ----------------------------
DROP TABLE IF EXISTS `lkt_integral_goods`;
CREATE TABLE `lkt_integral_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `goods_id` int(11) NOT NULL COMMENT '商品ID',
  `attr_id` int(11) NOT NULL COMMENT '属性id',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '兑换所需积分',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '兑换所需余额',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `is_delete` smallint(6) NOT NULL DEFAULT '0' COMMENT '是否删除:0否   1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分商城商品表';

-- ----------------------------
-- Records of lkt_integral_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `lkt_integral_config`
-- ----------------------------
DROP TABLE IF EXISTS `lkt_integral_config`;
CREATE TABLE `lkt_integral_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `bg_img` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `content` text,
  `status`  int(5) NOT NULL DEFAULT 0 COMMENT '插件状态 0关闭 1开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='积分商城设置表';

-- ----------------------------
-- Records of lkt_integral_config
-- ----------------------------

-- ----------------------------
-- Table structure for `lkt_integral_class`
-- ----------------------------
DROP TABLE IF EXISTS `lkt_integral_class`;
CREATE TABLE `lkt_integral_class` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `sid` int(11) NOT NULL COMMENT '上级id',
  `pname` char(15) NOT NULL COMMENT '分类名称',
  `img` varchar(200) DEFAULT '' COMMENT '分类图片',
  `bg` varchar(255) DEFAULT NULL COMMENT '小图标',
  `level` int(11) NOT NULL COMMENT '级别',
  `sort` int(11) DEFAULT '100' COMMENT '排序',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `recycle` tinyint(4) DEFAULT '0' COMMENT '回收站 0.不回收 1.回收',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=312 DEFAULT CHARSET=utf8 COMMENT='积分商城分类';

DROP TABLE IF EXISTS `lkt_taobao`;
CREATE TABLE `lkt_taobao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `link` text NOT NULL COMMENT '淘宝链接',
  `itemid` char(100) DEFAULT NULL COMMENT '商品ID',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态：0.待获取 1.获取中 2.获取成功 -1.获取失败',
  `msg` varchar(255) DEFAULT NULL COMMENT '返回说明',
  `creattime` timestamp NULL DEFAULT NULL COMMENT '任务创建时间',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '执行时间',
  `cid` varchar(200) DEFAULT NULL COMMENT '分类名称',
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌id',
  `title`  text NULL COMMENT '任务标题'
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='淘宝任务列表';


DROP TABLE IF EXISTS `lkt_seconds_time`;
CREATE TABLE `lkt_seconds_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `name` varchar(255) NOT NULL COMMENT '时段名称',
  `starttime` datetime NOT NULL COMMENT '开始时间',
  `endtime` datetime NOT NULL COMMENT '结束时间',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_activity`;
CREATE TABLE `lkt_seconds_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '活动名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '活动状态 1 未开始 2 进行中 3结束',
  `type` tinyint(1) NOT NULL COMMENT '活动类型',
  `starttime` datetime NOT NULL COMMENT '活动开始时间',
  `endtime` datetime NOT NULL COMMENT '活动结束时间',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 1 是 0 否',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 1 是 0 否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_config`;
CREATE TABLE `lkt_seconds_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启 1 是 0 否',
  `buy_num` int(11) NOT NULL COMMENT '秒杀商品默认限购数量',
  `imageurl` text NOT NULL COMMENT '轮播图',
  `remind` int(11) NOT NULL COMMENT '秒杀活动提醒 （单位：分钟）',
  `rule` text NOT NULL COMMENT '规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_pro`;
CREATE TABLE `lkt_seconds_pro` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `pro_id` int(11) NOT NULL COMMENT '商品id',
  `seconds_price` decimal(11,2) NOT NULL COMMENT '秒杀价格',
  `num` int(11) NOT NULL COMMENT '秒杀库存',
  `max_num` INT(11) NULL COMMENT '最大数量',
  `buy_num` int(11) NOT NULL COMMENT '限购数量',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `time_id` int(11) NOT NULL COMMENT '时段id',
  `add_time` DATETIME NOT NULL COMMENT '添加日期',
  `is_show` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '是否显示 1显示 0不显示',
  `is_delete` tinyint(1) NOT NULL COMMENT '是否删除 1 是 0 否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_seconds_record`;
CREATE TABLE `lkt_seconds_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `user_id` varchar(50) NOT NULL COMMENT '用户id',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `time_id` int(11) NOT NULL COMMENT '时段id',
  `pro_id` int(11) NOT NULL COMMENT '商品id',
  `price` decimal(11,2) NOT NULL COMMENT '价格',
  `num` int(11) NOT NULL COMMENT '数量',
  `sNo` VARCHAR(50) NOT NULL COMMENT '秒杀订单',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除 1是 0否',
  `add_time` datetime NOT NULL COMMENT '添加日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='秒杀记录表';

DROP TABLE IF EXISTS `lkt_seconds_remind`;
CREATE TABLE `lkt_seconds_remind` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `user_id` varchar(20) NOT NULL COMMENT '用户user_id',
  `is_remind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经提醒 1是 0否',
  `activity_id` int(11) NOT NULL COMMENT '活动id',
  `time_id` int(11) NOT NULL COMMENT '时段id',
  `pro_id` int(11) NOT NULL COMMENT '商品id',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lkt_ds_country`;
CREATE TABLE `lkt_ds_country` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `zh_name` varchar(50) NOT NULL,
  `code` varchar(5) NOT NULL DEFAULT '',
  `code2` varchar(5) NOT NULL DEFAULT '',
  `is_show` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否显示 1 显示 0 不显示',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8 COMMENT='世界国家表';


INSERT INTO `lkt_ds_country` (`id`, `name`, `zh_name`, `code`, `code2`, `is_show`) VALUES
(1, 'Afghanistan', '阿富汗', 'AF', '93', 1),
(2, 'Albania', '阿尔巴尼亚', 'AL', '355', 1),
(3, 'Algeria', '阿尔及利亚', 'DZ', '213', 1),
(4, 'American Samoa', '萨摩亚', 'AS', '684', 1),
(5, 'Andorra', '安道尔共和国', 'AD', '376', 1),
(6, 'Angola', '安哥拉', 'AO', '244', 1),
(7, 'Anguilla', '安圭拉', 'AI', '1-264', 1),
(8, 'Antarctica', '南极洲', 'AQ', '672', 1),
(9, 'Antigua and Barbuda', '安提瓜和巴布达', 'AG', '1-268', 1),
(10, 'Argentina', '阿根廷', 'AR', '54', 1),
(11, 'Armenia', '亚美尼亚', 'AM', '374', 1),
(12, 'Aruba', '阿鲁巴', 'AW', '297', 1),
(13, 'Australia', '澳大利亚', 'AU', '61', 1),
(14, 'Austria', '奥地利', 'AT', '43', 1),
(15, 'Azerbaijan', '阿塞拜疆', 'AZ', '994', 1),
(16, 'Bahamas', '巴哈马', 'BS', '1-242', 1),
(17, 'Bahrain', '巴林', 'BH', '973', 1),
(18, 'Bangladesh', '孟加拉国', 'BD', '880', 1),
(19, 'Barbados', '巴巴多斯', 'BB', '1-246', 1),
(20, 'Belarus', '白俄罗斯', 'BY', '375', 1),
(21, 'Belgium', '比利时', 'BE', '32', 1),
(22, 'Belize', '伯利兹城', 'BZ', '501', 1),
(23, 'Benin', '贝宁', 'BJ', '229', 1),
(24, 'Bermuda', '百慕大', 'BM', '1-441', 1),
(25, 'Bhutan', '不丹', 'BT', '975', 1),
(26, 'Bolivia', '玻利维亚', 'BO', '591', 1),
(27, 'Bosnia and Herzegovina', '波斯尼亚和黑塞哥维那', 'BA', '387', 1),
(28, 'Botswana', '博茨瓦纳', 'BW', '267', 1),
(29, 'Bouvet Island', '布维岛', 'BV', '', 1),
(30, 'Brazil', '巴西', 'BR', '55', 1),
(31, 'British Indian Ocean Territory', '英属印度洋领地', 'IO', '1-284', 1),
(32, 'Brunei Darussalam', '文莱达鲁萨兰国', 'BN', '673', 1),
(33, 'Bulgaria', '保加利亚', 'BG', '359', 1),
(34, 'Burkina Faso', '布基纳法索', 'BF', '226', 1),
(35, 'Burundi', '布隆迪', 'BI', '257', 1),
(36, 'Cambodia', '柬埔寨', 'KH', '855', 1),
(37, 'Cameroon', '喀麦隆', 'CM', '237', 1),
(38, 'Canada', '加拿大', 'CA', '1', 1),
(39, 'Cape Verde', '佛得角', 'CV', '238', 1),
(40, 'Cayman Islands', '开曼群岛', 'KY', '1-345', 1),
(41, 'Central African Republic', '中非共和国', 'CF', '236', 1),
(42, 'Chad', '乍得', 'TD', '235', 1),
(43, 'Chile', '智利', 'CL', '56', 1),
(44, 'China', '中国', 'CN', '86', 1),
(45, 'Christmas Island', '圣延岛', 'CX', '61', 1),
(46, 'Cocos (Keeling) Islands', '科科斯群岛', 'CC', '61', 1),
(47, 'Colombia', '哥伦比亚', 'CO', '57', 1),
(48, 'Comoros', '科摩罗', 'KM', '269', 1),
(49, 'Congo', '刚果', 'CG', '242', 1),
(50, 'Congo, The Democratic Republic Of The', '刚果民主共和国', 'ZR', '243', 1),
(51, 'Cook Islands', '库克群岛', 'CK', '682', 1),
(52, 'Costa Rica', '哥斯达黎加', 'CR', '506', 1),
(53, 'Cote D''Ivoire', 'Cote D''Ivoire', 'CI', '225', 1),
(54, 'Croatia (local name: Hrvatska)', '克罗地亚', 'HR', '385', 1),
(55, 'Cuba', '古巴', 'CU', '53', 1),
(56, 'Cyprus', '塞浦路斯', 'CY', '357', 1),
(57, 'Czech Republic', '捷克', 'CZ', '420', 1),
(58, 'Denmark', '丹麦', 'DK', '45', 1),
(59, 'Djibouti', '吉布提', 'DJ', '253', 1),
(60, 'Dominica', '多米尼克国', 'DM', '1-767', 1),
(61, 'Dominican Republic', '多米尼加共和国', 'DO', '1-809', 1),
(62, 'East Timor', '东帝汶', 'TP', '670', 1),
(63, 'Ecuador', '厄瓜多尔', 'EC', '593', 1),
(64, 'Egypt', '埃及', 'EG', '20', 1),
(65, 'El Salvador', '萨尔瓦多', 'SV', '503', 1),
(66, 'Equatorial Guinea', '赤道几内亚', 'GQ', '240', 1),
(67, 'Eritrea', '厄立特里亚国', 'ER', '291', 1),
(68, 'Estonia', '爱沙尼亚', 'EE', '372', 1),
(69, 'Ethiopia', '埃塞俄比亚', 'ET', '251', 1),
(70, 'Falkland Islands (Malvinas)', '福克兰群岛', 'FK', '500', 1),
(71, 'Faroe Islands', '法罗群岛', 'FO', '298', 1),
(72, 'Fiji', '斐济', 'FJ', '679', 1),
(73, 'Finland', '芬兰', 'FI', '358', 1),
(74, 'France', '法国', 'FR', '33', 1),
(75, 'France Metropolitan', '法国大都会', 'FX', '33', 1),
(76, 'French Guiana', '法属圭亚那', 'GF', '594', 1),
(77, 'French Polynesia', '法属玻里尼西亚', 'PF', '689', 1),
(78, 'French Southern Territories', 'French Southern Territories', 'TF', '', 1),
(79, 'Gabon', '加蓬', 'GA', '241', 1),
(80, 'Gambia', ' 冈比亚', 'GM', '220', 1),
(81, 'Georgia', '格鲁吉亚', 'GE', '995', 1),
(82, 'Germany', '德国', 'DE', '49', 1),
(83, 'Ghana', '加纳', 'GH', '233', 1),
(84, 'Gibraltar', '直布罗陀', 'GI', '350', 1),
(85, 'Greece', '希腊', 'GR', '30', 1),
(86, 'Greenland', '格陵兰', 'GL', '299', 1),
(87, 'Grenada', '格林纳达', 'GD', '1-473', 1),
(88, 'Guadeloupe', '瓜德罗普岛', 'GP', '590', 1),
(89, 'Guam', '关岛', 'GU', '1-671', 1),
(90, 'Guatemala', '危地马拉', 'GT', '502', 1),
(91, 'Guinea', '几内亚', 'GN', '224', 1),
(92, 'Guinea-Bissau', '几内亚比绍', 'GW', '245', 1),
(93, 'Guyana', '圭亚那', 'GY', '592', 1),
(94, 'Haiti', '海地', 'HT', '509', 1),
(95, 'Heard and Mc Donald Islands', 'Heard and Mc Donald Islands', 'HM', '', 1),
(96, 'Honduras', '洪都拉斯', 'HN', '504', 1),
(97, 'Hong Kong', '中国香港', 'HK', '852', 1),
(98, 'Hungary', '匈牙利', 'HU', '36', 1),
(99, 'Iceland', '冰岛', 'IS', '354', 1),
(100, 'India', '印度', 'IN', '91', 1),
(101, 'Indonesia', '印度尼西亚', 'ID', '62', 1),
(102, 'Iran (Islamic Republic of)', 'Iran (Islamic Republic of)', 'IR', '98', 1),
(103, 'Iraq', '伊拉克', 'IQ', '964', 1),
(104, 'Ireland', '爱尔兰', 'IE', '353', 1),
(105, 'Isle of Man', '英国属地曼岛', 'IM', '', 1),
(106, 'Israel', '以色列', 'IL', '972', 1),
(107, 'Italy', '意大利', 'IT', '39', 1),
(108, 'Jamaica', '牙买加', 'JM', '1-876', 1),
(109, 'Japan', '日本', 'JP', '81', 1),
(110, 'Jordan', '约旦', 'JO', '962', 1),
(111, 'Kazakhstan', '哈萨克', 'KZ', '7', 1),
(112, 'Kenya', '肯尼亚', 'KE', '254', 1),
(113, 'Kiribati', '吉尔巴斯', 'KI', '686', 1),
(114, 'Kuwait', '科威特', 'KW', '965', 1),
(115, 'Kyrgyzstan', '吉尔吉斯', 'KG', '996', 1),
(116, 'Lao People''s Democratic Republic', 'Lao People''s Democratic Republic', 'LA', '', 1),
(117, 'Latvia', '拉脱维亚', 'LV', '371', 1),
(118, 'Lebanon', '黎巴嫩', 'LB', '961', 1),
(119, 'Lesotho', '莱索托', 'LS', '266', 1),
(120, 'Liberia', '利比里亚', 'LR', '231', 1),
(121, 'Libyan Arab Jamahiriya', '利比亚', 'LY', '218', 1),
(122, 'Liechtenstein', '列支敦士登', 'LI', '423', 1),
(123, 'Lithuania', '立陶宛', 'LT', '370', 1),
(124, 'Luxembourg', '卢森堡', 'LU', '352', 1),
(125, 'Macau', '澳门地区', 'MO', '853', 1),
(126, 'Madagascar', '马达加斯加', 'MG', '261', 1),
(127, 'Malawi', '马拉维', 'MW', '265', 1),
(128, 'Malaysia', '马来西亚', 'MY', '60', 1),
(129, 'Maldives', '马尔代夫', 'MV', '960', 1),
(130, 'Mali', '马里', 'ML', '223', 1),
(131, 'Malta', '马尔他', 'MT', '356', 1),
(132, 'Marshall Islands', '马绍尔群岛', 'MH', '692', 1),
(133, 'Martinique', '马提尼克岛', 'MQ', '596', 1),
(134, 'Mauritania', '毛里塔尼亚', 'MR', '222', 1),
(135, 'Mauritius', '毛里求斯', 'MU', '230', 1),
(136, 'Mayotte', '马约特', 'YT', '269', 1),
(137, 'Mexico', '墨西哥', 'MX', '52', 1),
(138, 'Micronesia', '密克罗尼西亚', 'FM', '691', 1),
(139, 'Moldova', '摩尔多瓦', 'MD', '373', 1),
(140, 'Monaco', '摩纳哥', 'MC', '377', 1),
(141, 'Mongolia', '外蒙古', 'MN', '976', 1),
(142, 'Montenegro', 'Montenegro', 'MNE', '382', 1),
(143, 'Montserrat', '蒙特色纳', 'MS', '1-664', 1),
(144, 'Morocco', '摩洛哥', 'MA', '212', 1),
(145, 'Mozambique', '莫桑比克', 'MZ', '258', 1),
(146, 'Myanmar', '缅甸', 'MM', '95', 1),
(147, 'Namibia', '那米比亚', 'NA', '264', 1),
(148, 'Nauru', '瑙鲁', 'NR', '674', 1),
(149, 'Nepal', '尼泊尔', 'NP', '977', 1),
(150, 'Netherlands', '荷兰', 'NL', '31', 1),
(151, 'Netherlands Antilles', '荷兰安的列斯群岛', 'AN', '599', 1),
(152, 'New Caledonia', '新加勒多尼亚', 'NC', '687', 1),
(153, 'New Zealand', '新西兰', 'NZ', '64', 1),
(154, 'Nicaragua', '尼加拉瓜', 'NI', '505', 1),
(155, 'Niger', '尼日尔', 'NE', '227', 1),
(156, 'Nigeria', '尼日利亚', 'NG', '234', 1),
(157, 'Niue', '纽鄂岛', 'NU', '683', 1),
(158, 'Norfolk Island', '诺福克岛', 'NF', '672', 1),
(159, 'North Korea', '朝鲜', 'KP', '850', 1),
(160, 'Northern Mariana Islands', '北马里亚纳群岛', 'MP', '1670', 1),
(161, 'Norway', '挪威', 'NO', '47', 1),
(162, 'Oman', '阿曼', 'OM', '968', 1),
(163, 'Pakistan', '巴基斯坦', 'PK', '92', 1),
(164, 'Palau', '帛琉', 'PW', '680', 1),
(165, 'Palestine', '巴勒斯坦', 'PS', '970', 1),
(166, 'Panama', '巴拿马', 'PA', '507', 1),
(167, 'Papua New Guinea', '巴布亚新几内亚', 'PG', '675', 1),
(168, 'Paraguay', '巴拉圭', 'PY', '595', 1),
(169, 'Peru', '秘鲁', 'PE', '51', 1),
(170, 'Philippines', '菲律宾共和国', 'PH', '63', 1),
(171, 'Pitcairn', '皮特凯恩岛', 'PN', '872', 1),
(172, 'Poland', '波兰', 'PL', '48', 1),
(173, 'Portugal', '葡萄牙', 'PT', '351', 1),
(174, 'Puerto Rico', '波多黎各', 'PR', '1-787', 1),
(175, 'Qatar', '卡塔尔', 'QA', '974', 1),
(176, 'Reunion', 'Reunion', 'RE', '262', 1),
(177, 'Romania', '罗马尼亚', 'RO', '40', 1),
(178, 'Russian Federation', '俄罗斯联邦', 'RU', '7', 1),
(179, 'Rwanda', '卢旺达', 'RW', '250', 1),
(180, 'Saint Kitts and Nevis', '圣吉斯和尼维斯', 'KN', '', 1),
(181, 'Saint Lucia', '圣卢西亚', 'LC', '', 1),
(182, 'Saint Vincent and the Grenadines', '圣文森和格林纳丁斯', 'VC', '', 1),
(183, 'Samoa', '美属萨摩亚', 'WS', '685', 1),
(184, 'San Marino', 'San Marino', 'SM', '378', 1),
(185, 'Sao Tome and Principe', '圣多美和普林西比', 'ST', '', 1),
(186, 'Saudi Arabia', '沙特阿拉伯', 'SA', '966', 1),
(187, 'Senegal', '塞内加尔', 'SN', '221', 1),
(188, 'Serbia', '塞尔维亚共和国', 'SRB', '381', 1),
(189, 'Seychelles', '塞锡尔群岛', 'SC', '248', 1),
(190, 'Sierra Leone', '塞拉利昂', 'SL', '232', 1),
(191, 'Singapore', '新加坡', 'SG', '65', 1),
(192, 'Slovakia (Slovak Republic)', '斯洛伐克（斯洛伐克人的共和国）', 'SK', '421', 1),
(193, 'Slovenia', '斯洛文尼亚', 'SI', '386', 1),
(194, 'Solomon Islands', '索罗门群岛', 'SB', '677', 1),
(195, 'Somalia', '索马里', 'SO', '252', 1),
(196, 'South Africa', '南非', 'ZA', '27', 1),
(197, 'South Korea', '韩国', 'KR', '82', 1),
(198, 'Spain', '西班牙', 'ES', '34', 1),
(199, 'Sri Lanka', '斯里兰卡', 'LK', '94', 1),
(200, 'St. Helena', '圣海伦娜', 'SH', '290', 1),
(201, 'St. Pierre and Miquelon', '圣皮埃尔和密克罗', 'PM', '508', 1),
(202, 'Sudan', '苏丹', 'SD', '249', 1),
(203, 'Suriname', '苏里南', 'SR', '597', 1),
(204, 'Svalbard and Jan Mayen Islands', '冷岸和央麦恩群岛', 'SJ', '', 1),
(205, 'Swaziland', '斯威士兰', 'SZ', '268', 1),
(206, 'Sweden', '瑞典', 'SE', '46', 1),
(207, 'Switzerland', '瑞士', 'CH', '41', 1),
(208, 'Syrian Arab Republic', '叙利亚', 'SY', '963', 1),
(209, 'Taiwan', '台湾地区', 'TW', '886', 1),
(210, 'Tajikistan', '塔吉克', 'TJ', '992', 1),
(211, 'Tanzania', '坦桑尼亚', 'TZ', '255', 1),
(212, 'Thailand', '泰国', 'TH', '66', 1),
(213, 'The former Yugoslav Republic of Macedonia', '前马其顿南斯拉夫共和国', 'MK', '389', 1),
(214, 'Togo', '多哥', 'TG', '228', 1),
(215, 'Tokelau', '托克劳', 'TK', '690', 1),
(216, 'Tonga', '汤加', 'TO', '676', 1),
(217, 'Trinidad and Tobago', '千里达托贝哥共和国', 'TT', '1-868', 1),
(218, 'Tunisia', '北非共和国', 'TN', '216', 1),
(219, 'Turkey', '土耳其', 'TR', '90', 1),
(220, 'Turkmenistan', '土库曼', 'TM', '993', 1),
(221, 'Turks and Caicos Islands', '土克斯和开科斯群岛', 'TC', '1-649', 1),
(222, 'Tuvalu', '图瓦卢', 'TV', '688', 1),
(223, 'Uganda', '乌干达', 'UG', '256', 1),
(224, 'Ukraine', '乌克兰', 'UA', '380', 1),
(225, 'United Arab Emirates', '阿拉伯联合酋长国', 'AE', '971', 1),
(226, 'United Kingdom', '英国', 'UK', '44', 1),
(227, 'United States', '美国', 'US', '1', 1),
(228, 'United States Minor Outlying Islands', '美国小离岛', 'UM', '', 1),
(229, 'Uruguay', '乌拉圭', 'UY', '598', 1),
(230, 'Uzbekistan', '乌兹别克斯坦', 'UZ', '998', 1),
(231, 'Vanuatu', '瓦努阿图', 'VU', '678', 1),
(232, 'Vatican City State (Holy See)', '梵蒂冈(罗马教廷)', 'VA', '39', 1),
(233, 'Venezuela', '委内瑞拉', 'VE', '58', 1),
(234, 'Vietnam', '越南', 'VN', '84', 1),
(235, 'Virgin Islands (British)', '维尔京群岛(英国)', 'VG', '1284', 1),
(236, 'Virgin Islands (U.S.)', '维尔京群岛(美国)', 'VI', '1340', 1),
(237, 'Wallis And Futuna Islands', '沃利斯和富图纳群岛', 'WF', '681', 1),
(238, 'Western Sahara', '西撒哈拉', 'EH', '685', 1),
(239, 'Yemen', '也门', 'YE', '967', 1),
(240, 'Yugoslavia', '南斯拉夫', 'YU', '381', 1),
(241, 'Zambia', '赞比亚', 'ZM', '260', 1),
(242, 'Zimbabwe', '津巴布韦', 'ZW', '263', 1);

CREATE TABLE `lkt_printing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `r_userid` varchar(200) DEFAULT NULL COMMENT '收货人userid',
  `s_id` varchar(200) DEFAULT NULL COMMENT '发货id',
  `sNo` varchar(255) DEFAULT NULL COMMENT '订单号',
  `d_sNo` varchar(255) DEFAULT NULL COMMENT '详情订单id',
  `title` varchar(255) DEFAULT NULL COMMENT '商品详情',
  `num` int(11) DEFAULT NULL COMMENT '商品总数',
  `weight` decimal(10,2) DEFAULT NULL COMMENT '总重',
  `sender` varchar(200) DEFAULT NULL COMMENT '寄件人',
  `s_mobile` varchar(32) DEFAULT NULL COMMENT '寄件人手机',
  `s_sheng` text,
  `s_shi` text,
  `s_xian` text,
  `s_address` text COMMENT '寄件人地址',
  `recipient` varchar(200) DEFAULT NULL COMMENT '收件人',
  `r_mobile` varchar(32) DEFAULT NULL COMMENT '收件人手机',
  `r_sheng` text,
  `r_shi` text,
  `r_xian` text,
  `r_address` text COMMENT '收件人地址',
  `status` int(5) DEFAULT '0' COMMENT '打印状态 0.未 1.已',
  `create_time` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `print_time` timestamp NULL DEFAULT NULL COMMENT '打印时间',
  `type` int(4) DEFAULT '1' COMMENT '打印类型 1.发货单 2.快递单',
  `remark` text COMMENT '备注',
  `express` varchar(255) DEFAULT NULL COMMENT '快递名称',
  `expresssn` varchar(40) DEFAULT NULL COMMENT '快递单号',
  `put_type` int(4) DEFAULT '0' COMMENT '平台代发 0.关 1.开',
  `mini_sno` varchar(200) DEFAULT NULL COMMENT '小订单号 用于区分同一个订单不同快递',
  `origincode` char(50) DEFAULT NULL COMMENT '原寄地区域代码,可用于顺丰电子面单标签打印',
  `destcode` char(50) DEFAULT NULL COMMENT '目的地区域代码,可用于顺丰电子面单标签打印',
  `isopen` int(10) DEFAULT '0' COMMENT '平台代发  0.关  1.开',
  `img_url` text COMMENT '快递单地址',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `sNo` (`sNo`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='打印记录表';

CREATE TABLE `lkt_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '示例图',
  `type` tinyint(4) DEFAULT '1' COMMENT '单据类型 1.发货单 2.快递单',
  `name` varchar(100) NOT NULL COMMENT '模版名称',
  `e_name` varchar(100) DEFAULT NULL COMMENT 'tpl文件名称',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `width` int(10) DEFAULT NULL,
  `height` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='单据模版表';

CREATE TABLE `lkt_mch_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商城id',
  `mch_id` int(20) NOT NULL DEFAULT '1' COMMENT '商户id',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '示例图',
  `type` tinyint(4) DEFAULT '1' COMMENT '单据类型 1.发货单 2.快递单',
  `name` varchar(100) NOT NULL COMMENT '模版名称',
  `e_name` varchar(100) DEFAULT NULL COMMENT 'tpl文件名称',
  `add_date` timestamp NULL DEFAULT NULL COMMENT '添加时间',
  `width` int(10) DEFAULT NULL,
  `height` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='商户单据模版表';

-- 数据字典名称表
create table lkt_data_dictionary_name (
  id int(11) unsigned primary key auto_increment comment 'id',
  name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  status tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否生效 0:不是 1:是',
  admin_name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员名称',
  recycle tinyint(4) NOT NULL DEFAULT 0 COMMENT '回收站 0:正常 1:回收',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '数据字典名称表';

INSERT INTO `lkt_data_dictionary_name` (`id`, `name`, `status`, `admin_name`, `recycle`, `add_date`) VALUES
(1, '分页', 1, 'admin', 0, '2019-09-12 10:04:52'),
(2, '商品类型', 1, 'admin', 0, '2019-09-12 10:05:08'),
(3, '商品状态', 1, 'admin', 0, '2019-09-12 10:05:34'),
(4, '订单状态', 1, 'admin', 0, '2019-09-12 10:05:49'),
(5, '来源', 1, 'admin', 0, '2019-09-12 10:05:59'),
(6, '退货状态', 1, 'admin', 0, '2019-09-12 10:06:06'),
(7, '评价', 1, 'admin', 0, '2019-09-12 10:06:12'),
(8, '单位', 1, 'admin', 0, '2019-09-12 10:06:22'),
(9, '商品展示位置', 1, 'admin', 0, '2019-09-12 10:06:34'),
(10, '小程序模板行业', 1, 'admin', 0, '2019-09-12 10:06:45'),
(11, '轮播图跳转方式', 1, 'admin', 0, '2019-09-12 10:07:01'),
(12, '商品分类', 1, 'admin', 0, '2019-09-12 10:07:08'),
(13, '属性名', 1, 'admin', 0, '2019-09-12 10:07:16'),
(14, '属性值', 1, 'admin', 0, '2019-09-12 10:07:24'),
(15, '导航栏', 1, 'admin', 0, '2019-09-20 09:26:52'),
(16, '短信模板类型', 1, 'admin', 0, '2019-09-26 03:38:41'),
(17, '短信模板类别', 1, 'admin', 0, '2019-09-26 03:38:49');

-- 数据字典表
create table lkt_data_dictionary_list (
  id int(11) unsigned primary key auto_increment comment 'id',
  code varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '编码',
  sid int(11) NOT NULL DEFAULT 0 COMMENT '数据字典名称ID',
  s_name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '上级名称',
  value varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'value',
  text varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '值',
  status tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否生效 0:不是 1:是',
  admin_name varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员名称',
  recycle tinyint(4) NOT NULL DEFAULT 0 COMMENT '回收站 0:正常 1:回收',
  add_date timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '数据字典表';


INSERT INTO `lkt_data_dictionary_list` (`id`, `code`, `sid`, `s_name`, `value`, `text`, `status`, `admin_name`, `recycle`, `add_date`) VALUES
(1, 'LKT_FY_001', 1, '', '10', '10', 1, 'admin', 0, '2019-09-12 11:21:11'),
(2, 'LKT_FY_002', 1, '', '25', '25', 1, 'admin', 0, '2019-09-12 11:22:27'),
(3, 'LKT_FY_003', 1, '', '50', '50', 1, 'admin', 0, '2019-09-12 11:22:36'),
(4, 'LKT_FY_004', 1, '', '100', '100', 1, 'admin', 0, '2019-09-12 11:22:45'),
(5, 'LKT_SPLX_001', 2, '', '1', '新品', 1, 'admin', 0, '2019-09-12 11:24:34'),
(6, 'LKT_SPLX_002', 2, '', '2', '热销', 1, 'admin', 0, '2019-09-12 11:25:05'),
(7, 'LKT_SPLX_003', 2, '', '3', '推荐', 1, 'admin', 0, '2019-09-12 11:25:15'),
(8, 'LKT_SPZT_001', 3, '', '1', '待上架', 1, 'admin', 0, '2019-09-12 11:25:51'),
(9, 'LKT_SPZT_002', 3, '', '2', '上架', 1, 'admin', 0, '2019-09-12 11:26:07'),
(10, 'LKT_SPZT_003', 3, '', '3', '下架', 1, 'admin', 0, '2019-09-12 11:26:21'),
(11, 'LKT_DDZT_001', 4, '', '0', '待付款', 1, 'admin', 0, '2019-09-12 11:39:38'),
(12, 'LKT_DDZT_002', 4, '', '1', '待发货', 1, 'admin', 0, '2019-09-16 01:51:02'),
(13, 'LKT_DDZT_003', 4, '', '2', '待收货', 1, 'admin', 0, '2019-09-16 01:51:21'),
(14, 'LKT_DDZT_004', 4, '', '3', '待评价', 1, 'admin', 0, '2019-09-16 01:51:42'),
(15, 'LKT_DDZT_005', 4, '', '4', '退货', 1, 'admin', 0, '2019-09-16 01:52:02'),
(16, 'LKT_DDZT_006', 4, '', '5', '已完成', 1, 'admin', 0, '2019-09-16 01:52:17'),
(17, 'LKT_DDZT_007', 4, '', '6', '已关闭', 1, 'admin', 0, '2019-09-16 01:52:28'),
(18, 'LKT_LY_001', 5, '', '1', '小程序', 1, 'admin', 0, '2019-09-16 01:54:12'),
(19, 'LKT_LY_002', 5, '', '2', 'APP', 1, 'admin', 0, '2019-09-16 01:54:21'),
(20, 'LKT_THZT_001', 6, '', '1', '审核中', 1, 'admin', 0, '2019-09-16 01:54:37'),
(21, 'LKT_THZT_002', 6, '', '2', '待买家发货', 1, 'admin', 0, '2019-09-16 01:54:52'),
(22, 'LKT_THZT_003', 6, '', '3', '已拒绝', 1, 'admin', 0, '2019-09-16 01:55:06'),
(23, 'LKT_THZT_004', 6, '', '4', '待商家收货', 1, 'admin', 0, '2019-09-16 01:55:21'),
(24, 'LKT_THZT_005', 6, '', '5', '已退款', 1, 'admin', 0, '2019-09-16 01:55:34'),
(25, 'LKT_THZT_006', 6, '', '6', '拒绝并退回商品', 1, 'admin', 0, '2019-09-16 01:55:48'),
(26, 'LKT_PJ_001', 7, '', '0', '全部', 1, 'admin', 0, '2019-09-16 01:56:00'),
(27, 'LKT_PJ_002', 7, '', 'GOOD', '好评', 1, 'admin', 0, '2019-09-16 01:56:21'),
(28, 'LKT_PJ_003', 7, '', 'NOTBAD', '中评', 1, 'admin', 0, '2019-09-16 02:03:52'),
(29, 'LKT_PJ_004', 7, '', 'BAD', '差评', 1, 'admin', 0, '2019-09-16 02:04:07'),
(30, 'LKT_DW_001', 8, '', '盒', '盒', 1, 'admin', 0, '2019-09-16 02:04:26'),
(31, 'LKT_DW_002', 8, '', '篓', '篓', 1, 'admin', 0, '2019-09-16 02:04:47'),
(32, 'LKT_DW_003', 8, '', '箱', '箱', 1, 'admin', 0, '2019-09-16 02:05:03'),
(33, 'LKT_DW_004', 8, '', '个', '个', 1, 'admin', 0, '2019-09-16 02:05:23'),
(34, 'LKT_DW_005', 8, '', '套', '套', 1, 'admin', 0, '2019-09-16 02:05:38'),
(35, 'LKT_DW_006', 8, '', '包', '包', 1, 'admin', 0, '2019-09-16 02:05:51'),
(36, 'LKT_DW_007', 8, '', '支', '支', 1, 'admin', 0, '2019-09-16 02:06:04'),
(37, 'LKT_DW_008', 8, '', '条', '条', 1, 'admin', 0, '2019-09-16 02:06:15'),
(38, 'LKT_DW_009', 8, '', '根', '根', 1, 'admin', 0, '2019-09-16 02:07:03'),
(39, 'LKT_PJ_005', 8, '', '本', '本', 1, 'admin', 0, '2019-09-16 02:07:15'),
(40, 'LKT_PJ_006', 8, '', '瓶', '瓶', 1, 'admin', 0, '2019-09-16 02:07:28'),
(41, 'LKT_PJ_007', 8, '', '块', '块', 1, 'admin', 0, '2019-09-16 02:07:38'),
(42, 'LKT_PJ_008', 8, '', '片', '片', 1, 'admin', 0, '2019-09-16 02:07:50'),
(43, 'LKT_PJ_009', 8, '', '把', '把', 1, 'admin', 0, '2019-09-16 02:08:01'),
(44, 'LKT_PJ_010', 8, '', '组', '组', 1, 'admin', 0, '2019-09-16 02:08:14'),
(45, 'LKT_PJ_011', 8, '', '双', '双', 1, 'admin', 0, '2019-09-16 02:08:27'),
(46, 'LKT_PJ_012', 8, '', '台', '台', 1, 'admin', 0, '2019-09-16 02:08:40'),
(47, 'LKT_PJ_013', 8, '', '件', '件', 1, 'admin', 0, '2019-09-16 02:08:52'),
(48, 'LKT_SPZSWZ_001', 9, '', '0', '全部商品', 1, 'admin', 0, '2019-09-16 02:09:11'),
(49, 'LKT_SPZSWZ_002', 9, '', '1', '首页', 1, 'admin', 0, '2019-09-16 02:09:33'),
(50, 'LKT_SPZSWZ_003', 9, '', '2', '购物车', 1, 'admin', 0, '2019-09-16 02:09:44'),
(51, 'LKT_XCXMBXY_001', 10, '', '1', '广告', 1, 'admin', 0, '2019-09-16 02:10:03'),
(52, 'LKT_XCXMBXY_002', 10, '', '2', '生活', 1, 'admin', 0, '2019-09-16 02:10:17'),
(53, 'LKT_XCXMBXY_003', 10, '', '3', '电影', 1, 'admin', 0, '2019-09-16 02:10:33'),
(54, 'LKT_LBTTZFS_001', 11, '', '1', '商品分类', 1, 'admin', 0, '2019-09-16 02:10:59'),
(55, 'LKT_LBTTZFS_002', 11, '', '2', '指定商品', 1, 'admin', 0, '2019-09-16 02:11:10'),
(56, 'LKT_LBTTZFS_003', 11, '', '3', '不跳转', 1, 'admin', 0, '2019-09-16 02:11:23'),
(57, 'LKT_SPFL_001', 12, '', '1', '一级', 1, 'admin', 0, '2019-09-16 02:11:36'),
(58, 'LKT_SPFL_002', 12, '', '2', '二级', 1, 'admin', 0, '2019-09-16 02:11:48'),
(59, 'LKT_SPFL_003', 12, '', '3', '三级', 1, 'admin', 0, '2019-09-16 02:12:01'),
(60, 'LKT_SPFL_004', 12, '', '4', '四级', 1, 'admin', 0, '2019-09-16 02:12:16'),
(61, 'LKT_SPFL_005', 12, '', '5', '五级', 1, 'admin', 0, '2019-09-16 02:12:30'),
(62, 'LKT_SXM_001', 13, '', '1', '颜色', 1, 'admin', 0, '2019-09-16 02:12:49'),
(63, 'LKT_SXM_002', 13, '', '2', '尺码', 1, 'admin', 0, '2019-09-16 02:13:04'),
(64, 'LKT_SXZ_001', 14, '颜色', '1', '蓝色', 1, 'admin', 0, '2019-09-16 02:23:09'),
(65, 'LKT_SXZ_002', 14, '颜色', '2', '黑色', 1, 'admin', 0, '2019-09-16 02:25:36'),
(66, 'LKT_SXZ_003', 14, '颜色', '3', '红色', 1, 'admin', 0, '2019-09-16 02:26:43'),
(67, 'LKT_SXZ_004', 14, '颜色', '4', '黄色', 1, 'admin', 0, '2019-09-16 02:26:59'),
(68, 'LKT_SXZ_005', 14, '尺码', '5', 'M', 1, 'admin', 0, '2019-09-16 02:27:19'),
(69, 'LKT_SXZ_006', 14, '尺码', '6', 'L', 1, 'admin', 0, '2019-09-16 02:27:35'),
(70, 'LKT_SXZ_007', 14, '尺码', '7', 'XL', 1, 'admin', 0, '2019-09-16 02:27:51'),
(71, 'LKT_SXZ_008', 14, '尺码', '8', 'XXL', 1, 'admin', 0, '2019-09-16 03:58:51'),
(72, 'LKT_SXZ_009', 14, '颜色', '9', '粉色', 1, 'admin', 0, '2019-09-17 02:18:22'),
(73, 'LKT_SXZ_010', 14, '颜色', '10', '天蓝', 1, 'admin', 0, '2019-09-17 02:21:44'),
(74, 'LKT_DHL_008', 15, '', '7', '支付宝小程序', 1, 'admin', 0, '2019-09-20 09:02:49'),
(75, 'LKT_DHL_007', 15, '', '6', '报表', 1, 'admin', 0, '2019-09-20 09:02:34'),
(76, 'LKT_DHL_006', 15, '', '5', '生活号', 1, 'admin', 0, '2019-09-20 09:02:19'),
(77, 'LKT_DHL_005', 15, '', '4', 'PC', 1, 'admin', 0, '2019-09-20 09:02:06'),
(78, 'LKT_DHL_004', 15, '', '3', '微信公众号', 1, 'admin', 0, '2019-09-20 09:01:49'),
(79, 'LKT_DHL_003', 15, '', '2', 'APP', 1, 'admin', 0, '2019-09-20 09:01:26'),
(80, 'LKT_DHL_002', 15, '', '1', '小程序', 1, 'admin', 0, '2019-09-20 09:01:12'),
(81, 'LKT_DHL_001', 15, '', '0', '平台', 1, 'admin', 0, '2019-09-20 09:22:23'),
(90, 'LKT_DXMBLB_007', 17, '短信通知', '7', '通用', 1, 'admin', 0, '2019-09-25 08:44:17'),
(89, 'LKT_DXMBLB_006', 17, '验证码', '6', '提现', 1, 'admin', 0, '2019-09-25 08:44:17'),
(88, 'LKT_DXMBLB_005', 17, '验证码', '5', '修改支付密码', 1, 'admin', 0, '2019-09-25 08:44:17'),
(87, 'LKT_DXMBLB_004', 17, '验证码', '4', '修改登录密码', 1, 'admin', 0, '2019-09-25 08:44:17'),
(86, 'LKT_DXMBLB_003', 17, '验证码', '3', '修改手机号', 1, 'admin', 0, '2019-09-25 08:42:00'),
(85, 'LKT_DXMBLB_002', 17, '验证码', '2', '注册', 1, 'admin', 0, '2019-09-25 08:41:39'),
(84, 'LKT_DXMBLB_001', 17, '验证码', '1', '登录', 1, 'admin', 0, '2019-09-25 08:41:15'),
(83, 'LKT_DXMBLX_002', 16, '', '1', '短信通知', 1, 'admin', 0, '2019-09-25 08:17:10'),
(82, 'LKT_DXMBLX_001', 16, '', '0', '验证码', 1, 'admin', 0, '2019-09-25 08:16:45');

-- 权限菜单
CREATE TABLE `lkt_role_menu`  (
  role_id int(11) NOT NULL DEFAULT 0 COMMENT '角色ID',
  menu_id int(11) NOT NULL DEFAULT 0 COMMENT '菜单ID',
  add_date timestamp NULL DEFAULT NULL COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '权限菜单';


INSERT INTO `lkt_role_menu` (`role_id`, `menu_id`, `add_date`) VALUES
(2, 373, '2019-09-30 09:27:04'),
(1, 402, '2019-10-08 10:38:38'),
(1, 386, '2019-10-08 10:38:38'),
(1, 385, '2019-10-08 10:38:38'),
(1, 384, '2019-10-08 10:38:38'),
(1, 383, '2019-10-08 10:38:38'),
(1, 382, '2019-10-08 10:38:38'),
(1, 381, '2019-10-08 10:38:38'),
(1, 326, '2019-10-08 10:38:38'),
(1, 325, '2019-10-08 10:38:38'),
(1, 324, '2019-10-08 10:38:38'),
(1, 323, '2019-10-08 10:38:38'),
(1, 322, '2019-10-08 10:38:38'),
(1, 321, '2019-10-08 10:38:38'),
(1, 320, '2019-10-08 10:38:38'),
(1, 319, '2019-10-08 10:38:38'),
(1, 318, '2019-10-08 10:38:38'),
(1, 317, '2019-10-08 10:38:38'),
(1, 314, '2019-10-08 10:38:38'),
(1, 313, '2019-10-08 10:38:38'),
(1, 292, '2019-10-08 10:38:38'),
(1, 291, '2019-10-08 10:38:38'),
(1, 290, '2019-10-08 10:38:38'),
(1, 289, '2019-10-08 10:38:38'),
(1, 288, '2019-10-08 10:38:38'),
(1, 287, '2019-10-08 10:38:38'),
(1, 86, '2019-10-08 10:38:38'),
(1, 305, '2019-10-08 10:38:38'),
(1, 78, '2019-10-08 10:38:38'),
(1, 77, '2019-10-08 10:38:38'),
(1, 76, '2019-10-08 10:38:38'),
(1, 75, '2019-10-08 10:38:38'),
(1, 74, '2019-10-08 10:38:38'),
(1, 136, '2019-10-08 10:38:38'),
(1, 135, '2019-10-08 10:38:38'),
(1, 99, '2019-10-08 10:38:38'),
(1, 262, '2019-10-08 10:38:38'),
(1, 261, '2019-10-08 10:38:38'),
(1, 260, '2019-10-08 10:38:38'),
(1, 259, '2019-10-08 10:38:38'),
(1, 258, '2019-10-08 10:38:38'),
(1, 257, '2019-10-08 10:38:38'),
(1, 70, '2019-10-08 10:38:38'),
(1, 69, '2019-10-08 10:38:38'),
(1, 68, '2019-10-08 10:38:38'),
(1, 67, '2019-10-08 10:38:38'),
(1, 66, '2019-10-08 10:38:38'),
(1, 65, '2019-10-08 10:38:38'),
(1, 64, '2019-10-08 10:38:38'),
(1, 63, '2019-10-08 10:38:38'),
(1, 278, '2019-10-08 10:38:38'),
(1, 62, '2019-10-08 10:38:38'),
(1, 397, '2019-10-08 10:38:38'),
(1, 61, '2019-10-08 10:38:38'),
(1, 60, '2019-10-08 10:38:38'),
(1, 59, '2019-10-08 10:38:38'),
(1, 57, '2019-10-08 10:38:38'),
(1, 56, '2019-10-08 10:38:38'),
(1, 413, '2019-10-08 10:38:38'),
(1, 412, '2019-10-08 10:38:38'),
(1, 411, '2019-10-08 10:38:38'),
(1, 410, '2019-10-08 10:38:38'),
(1, 409, '2019-10-08 10:38:38'),
(1, 351, '2019-10-08 10:38:38'),
(1, 7, '2019-10-08 10:38:38'),
(1, 6, '2019-10-08 10:38:38'),
(1, 5, '2019-10-08 10:38:38'),
(1, 4, '2019-10-08 10:38:38'),
(1, 3, '2019-10-08 10:38:38'),
(1, 2, '2019-10-08 10:38:38'),
(1, 1, '2019-10-08 10:38:38'),
(1, 415, '2019-10-08 10:38:38'),
(1, 115, '2019-10-08 10:38:38'),
(1, 114, '2019-10-08 10:38:38'),
(1, 113, '2019-10-08 10:38:38'),
(1, 112, '2019-10-08 10:38:38'),
(1, 111, '2019-10-08 10:38:38'),
(1, 240, '2019-10-08 10:38:38'),
(1, 105, '2019-10-08 10:38:38'),
(1, 104, '2019-10-08 10:38:38'),
(1, 103, '2019-10-08 10:38:38'),
(1, 102, '2019-10-08 10:38:38'),
(1, 101, '2019-10-08 10:38:38'),
(1, 42, '2019-10-08 10:38:38'),
(1, 41, '2019-10-08 10:38:38'),
(1, 40, '2019-10-08 10:38:38'),
(1, 39, '2019-10-08 10:38:38'),
(1, 414, '2019-10-08 10:38:38'),
(1, 387, '2019-10-08 10:38:38'),
(1, 38, '2019-10-08 10:38:38'),
(1, 37, '2019-10-08 10:38:38'),
(1, 36, '2019-10-08 10:38:38'),
(1, 35, '2019-10-08 10:38:38'),
(1, 34, '2019-10-08 10:38:38'),
(1, 33, '2019-10-08 10:38:38'),
(1, 32, '2019-10-08 10:38:38'),
(1, 85, '2019-10-08 10:38:38'),
(1, 31, '2019-10-08 10:38:38'),
(1, 416, '2019-10-08 10:38:38'),
(1, 404, '2019-10-08 10:38:38'),
(1, 332, '2019-10-08 10:38:38'),
(1, 331, '2019-10-08 10:38:38'),
(1, 330, '2019-10-08 10:38:38'),
(1, 334, '2019-10-08 10:38:38'),
(1, 329, '2019-10-08 10:38:38'),
(1, 333, '2019-10-08 10:38:38'),
(1, 328, '2019-10-08 10:38:38'),
(1, 327, '2019-10-08 10:38:38'),
(1, 27, '2019-10-08 10:38:38'),
(1, 26, '2019-10-08 10:38:38'),
(1, 25, '2019-10-08 10:38:38'),
(1, 24, '2019-10-08 10:38:38'),
(1, 23, '2019-10-08 10:38:38'),
(1, 22, '2019-10-08 10:38:38'),
(1, 308, '2019-10-08 10:38:38'),
(1, 307, '2019-10-08 10:38:38'),
(1, 312, '2019-10-08 10:38:38'),
(1, 311, '2019-10-08 10:38:38'),
(1, 21, '2019-10-08 10:38:38'),
(1, 20, '2019-10-08 10:38:38'),
(1, 19, '2019-10-08 10:38:38'),
(1, 18, '2019-10-08 10:38:38'),
(1, 17, '2019-10-08 10:38:38'),
(1, 403, '2019-10-08 10:38:38'),
(1, 352, '2019-10-08 10:38:38'),
(1, 16, '2019-10-08 10:38:38'),
(1, 15, '2019-10-08 10:38:38'),
(1, 14, '2019-10-08 10:38:38'),
(1, 13, '2019-10-08 10:38:38'),
(1, 12, '2019-10-08 10:38:38'),
(1, 11, '2019-10-08 10:38:38'),
(1, 10, '2019-10-08 10:38:38'),
(1, 9, '2019-10-08 10:38:38'),
(1, 8, '2019-10-08 10:38:38'),
(2, 372, '2019-09-30 09:27:04'),
(2, 218, '2019-09-30 09:27:04'),
(2, 140, '2019-09-30 09:27:04'),
(2, 269, '2019-09-30 09:27:04'),
(2, 400, '2019-09-30 09:27:04'),
(2, 120, '2019-09-30 09:27:04'),
(2, 119, '2019-09-30 09:27:04'),
(2, 118, '2019-09-30 09:27:04'),
(2, 117, '2019-09-30 09:27:04'),
(2, 116, '2019-09-30 09:27:04'),
(2, 267, '2019-09-30 09:27:04'),
(3, 282, '2019-09-23 11:11:15'),
(3, 283, '2019-09-23 11:11:15'),
(3, 284, '2019-09-23 11:11:15'),
(3, 285, '2019-09-23 11:11:15'),
(3, 286, '2019-09-23 11:11:15'),
(3, 401, '2019-09-23 11:11:15'),
(3, 219, '2019-09-23 11:11:15'),
(3, 220, '2019-09-23 11:11:15'),
(3, 221, '2019-09-23 11:11:15'),
(3, 222, '2019-09-23 11:11:15'),
(3, 223, '2019-09-23 11:11:15'),
(3, 224, '2019-09-23 11:11:15'),
(3, 336, '2019-09-23 11:11:15'),
(3, 395, '2019-09-23 11:11:15'),
(4, 8, '2019-09-23 11:11:27'),
(4, 9, '2019-09-23 11:11:27'),
(4, 10, '2019-09-23 11:11:27'),
(4, 11, '2019-09-23 11:11:27'),
(4, 12, '2019-09-23 11:11:27'),
(4, 13, '2019-09-23 11:11:27'),
(4, 14, '2019-09-23 11:11:27'),
(4, 15, '2019-09-23 11:11:27'),
(4, 16, '2019-09-23 11:11:27'),
(4, 352, '2019-09-23 11:11:27'),
(4, 403, '2019-09-23 11:11:27'),
(4, 17, '2019-09-23 11:11:27'),
(4, 18, '2019-09-23 11:11:27'),
(4, 19, '2019-09-23 11:11:27'),
(4, 20, '2019-09-23 11:11:27'),
(4, 21, '2019-09-23 11:11:27'),
(4, 311, '2019-09-23 11:11:27'),
(4, 312, '2019-09-23 11:11:27'),
(4, 307, '2019-09-23 11:11:27'),
(4, 308, '2019-09-23 11:11:27'),
(4, 22, '2019-09-23 11:11:27'),
(4, 23, '2019-09-23 11:11:27'),
(4, 24, '2019-09-23 11:11:27'),
(4, 25, '2019-09-23 11:11:27'),
(4, 26, '2019-09-23 11:11:27'),
(4, 27, '2019-09-23 11:11:27'),
(4, 327, '2019-09-23 11:11:27'),
(4, 328, '2019-09-23 11:11:27'),
(4, 333, '2019-09-23 11:11:27'),
(4, 329, '2019-09-23 11:11:27'),
(4, 334, '2019-09-23 11:11:27'),
(4, 330, '2019-09-23 11:11:27'),
(4, 331, '2019-09-23 11:11:27'),
(4, 332, '2019-09-23 11:11:27'),
(4, 404, '2019-09-23 11:11:27'),
(4, 416, '2019-09-23 11:11:27'),
(4, 31, '2019-09-23 11:11:27'),
(4, 32, '2019-09-23 11:11:27'),
(4, 33, '2019-09-23 11:11:27'),
(4, 34, '2019-09-23 11:11:27'),
(4, 35, '2019-09-23 11:11:27'),
(4, 36, '2019-09-23 11:11:27'),
(4, 37, '2019-09-23 11:11:27'),
(4, 38, '2019-09-23 11:11:27'),
(4, 387, '2019-09-23 11:11:27'),
(4, 414, '2019-09-23 11:11:27'),
(4, 39, '2019-09-23 11:11:27'),
(4, 40, '2019-09-23 11:11:27'),
(4, 41, '2019-09-23 11:11:27'),
(4, 42, '2019-09-23 11:11:27'),
(4, 101, '2019-09-23 11:11:27'),
(4, 102, '2019-09-23 11:11:27'),
(4, 103, '2019-09-23 11:11:27'),
(4, 104, '2019-09-23 11:11:27'),
(4, 105, '2019-09-23 11:11:27'),
(4, 240, '2019-09-23 11:11:27'),
(4, 111, '2019-09-23 11:11:27'),
(4, 112, '2019-09-23 11:11:27'),
(4, 113, '2019-09-23 11:11:27'),
(4, 114, '2019-09-23 11:11:27'),
(4, 115, '2019-09-23 11:11:27'),
(4, 415, '2019-09-23 11:11:27'),
(4, 500, '2019-09-23 11:11:27'),
(4, 85, '2019-09-23 11:11:27'),
(4, 1, '2019-09-23 11:11:27'),
(4, 2, '2019-09-23 11:11:27'),
(4, 3, '2019-09-23 11:11:27'),
(4, 4, '2019-09-23 11:11:27'),
(4, 5, '2019-09-23 11:11:27'),
(4, 6, '2019-09-23 11:11:27'),
(4, 7, '2019-09-23 11:11:27'),
(4, 351, '2019-09-23 11:11:27'),
(4, 409, '2019-09-23 11:11:27'),
(4, 410, '2019-09-23 11:11:27'),
(4, 411, '2019-09-23 11:11:27'),
(4, 412, '2019-09-23 11:11:27'),
(4, 413, '2019-09-23 11:11:27'),
(4, 56, '2019-09-23 11:11:27'),
(4, 57, '2019-09-23 11:11:27'),
(4, 59, '2019-09-23 11:11:27'),
(4, 60, '2019-09-23 11:11:27'),
(4, 61, '2019-09-23 11:11:27'),
(4, 397, '2019-09-23 11:11:27'),
(4, 62, '2019-09-23 11:11:27'),
(4, 278, '2019-09-23 11:11:27'),
(4, 63, '2019-09-23 11:11:27'),
(4, 64, '2019-09-23 11:11:27'),
(4, 65, '2019-09-23 11:11:27'),
(4, 66, '2019-09-23 11:11:27'),
(4, 67, '2019-09-23 11:11:27'),
(4, 68, '2019-09-23 11:11:27'),
(4, 69, '2019-09-23 11:11:27'),
(4, 70, '2019-09-23 11:11:27'),
(4, 257, '2019-09-23 11:11:27'),
(4, 258, '2019-09-23 11:11:27'),
(4, 259, '2019-09-23 11:11:27'),
(4, 260, '2019-09-23 11:11:27'),
(4, 261, '2019-09-23 11:11:27'),
(4, 262, '2019-09-23 11:11:27'),
(4, 99, '2019-09-23 11:11:27'),
(4, 135, '2019-09-23 11:11:27'),
(4, 136, '2019-09-23 11:11:27'),
(4, 74, '2019-09-23 11:11:27'),
(4, 75, '2019-09-23 11:11:27'),
(4, 76, '2019-09-23 11:11:27'),
(4, 77, '2019-09-23 11:11:27'),
(4, 78, '2019-09-23 11:11:27'),
(4, 305, '2019-09-23 11:11:27'),
(4, 86, '2019-09-23 11:11:27'),
(4, 287, '2019-09-23 11:11:27'),
(4, 288, '2019-09-23 11:11:27'),
(4, 289, '2019-09-23 11:11:27'),
(4, 290, '2019-09-23 11:11:27'),
(4, 291, '2019-09-23 11:11:27'),
(4, 292, '2019-09-23 11:11:27'),
(4, 313, '2019-09-23 11:11:27'),
(4, 314, '2019-09-23 11:11:27'),
(4, 317, '2019-09-23 11:11:27'),
(4, 318, '2019-09-23 11:11:27'),
(4, 319, '2019-09-23 11:11:27'),
(4, 320, '2019-09-23 11:11:27'),
(4, 321, '2019-09-23 11:11:27'),
(4, 322, '2019-09-23 11:11:27'),
(4, 323, '2019-09-23 11:11:27'),
(4, 324, '2019-09-23 11:11:27'),
(4, 325, '2019-09-23 11:11:27'),
(4, 326, '2019-09-23 11:11:27'),
(4, 381, '2019-09-23 11:11:27'),
(4, 382, '2019-09-23 11:11:27'),
(4, 383, '2019-09-23 11:11:27'),
(4, 384, '2019-09-23 11:11:27'),
(4, 385, '2019-09-23 11:11:27'),
(4, 386, '2019-09-23 11:11:27'),
(4, 402, '2019-09-23 11:11:27'),
(5, 8, '2019-09-23 11:11:41'),
(5, 9, '2019-09-23 11:11:41'),
(5, 10, '2019-09-23 11:11:41'),
(5, 11, '2019-09-23 11:11:41'),
(5, 12, '2019-09-23 11:11:41'),
(5, 13, '2019-09-23 11:11:41'),
(5, 14, '2019-09-23 11:11:41'),
(5, 15, '2019-09-23 11:11:41'),
(5, 16, '2019-09-23 11:11:41'),
(5, 352, '2019-09-23 11:11:41'),
(5, 403, '2019-09-23 11:11:41'),
(5, 17, '2019-09-23 11:11:41'),
(5, 18, '2019-09-23 11:11:41'),
(5, 19, '2019-09-23 11:11:41'),
(5, 20, '2019-09-23 11:11:41'),
(5, 21, '2019-09-23 11:11:41'),
(5, 311, '2019-09-23 11:11:41'),
(5, 312, '2019-09-23 11:11:41'),
(5, 307, '2019-09-23 11:11:41'),
(5, 308, '2019-09-23 11:11:41'),
(5, 22, '2019-09-23 11:11:41'),
(5, 23, '2019-09-23 11:11:41'),
(5, 24, '2019-09-23 11:11:41'),
(5, 25, '2019-09-23 11:11:41'),
(5, 26, '2019-09-23 11:11:41'),
(5, 27, '2019-09-23 11:11:41'),
(5, 327, '2019-09-23 11:11:41'),
(5, 328, '2019-09-23 11:11:41'),
(5, 333, '2019-09-23 11:11:41'),
(5, 329, '2019-09-23 11:11:41'),
(5, 334, '2019-09-23 11:11:41'),
(5, 330, '2019-09-23 11:11:41'),
(5, 331, '2019-09-23 11:11:41'),
(5, 332, '2019-09-23 11:11:41'),
(5, 404, '2019-09-23 11:11:41'),
(5, 416, '2019-09-23 11:11:41'),
(5, 31, '2019-09-23 11:11:41'),
(5, 32, '2019-09-23 11:11:41'),
(5, 33, '2019-09-23 11:11:41'),
(5, 34, '2019-09-23 11:11:41'),
(5, 35, '2019-09-23 11:11:41'),
(5, 36, '2019-09-23 11:11:41'),
(5, 37, '2019-09-23 11:11:41'),
(5, 38, '2019-09-23 11:11:41'),
(5, 387, '2019-09-23 11:11:41'),
(5, 414, '2019-09-23 11:11:41'),
(5, 39, '2019-09-23 11:11:41'),
(5, 40, '2019-09-23 11:11:41'),
(5, 41, '2019-09-23 11:11:41'),
(5, 42, '2019-09-23 11:11:41'),
(5, 101, '2019-09-23 11:11:41'),
(5, 102, '2019-09-23 11:11:41'),
(5, 103, '2019-09-23 11:11:41'),
(5, 104, '2019-09-23 11:11:41'),
(5, 105, '2019-09-23 11:11:41'),
(5, 240, '2019-09-23 11:11:41'),
(5, 111, '2019-09-23 11:11:41'),
(5, 112, '2019-09-23 11:11:41'),
(5, 113, '2019-09-23 11:11:41'),
(5, 114, '2019-09-23 11:11:41'),
(5, 115, '2019-09-23 11:11:41'),
(5, 415, '2019-09-23 11:11:41'),
(5, 500, '2019-09-23 11:11:41'),
(5, 85, '2019-09-23 11:11:41'),
(5, 1, '2019-09-23 11:11:41'),
(5, 2, '2019-09-23 11:11:41'),
(5, 3, '2019-09-23 11:11:41'),
(5, 4, '2019-09-23 11:11:41'),
(5, 5, '2019-09-23 11:11:41'),
(5, 6, '2019-09-23 11:11:41'),
(5, 7, '2019-09-23 11:11:41'),
(5, 351, '2019-09-23 11:11:41'),
(5, 409, '2019-09-23 11:11:41'),
(5, 410, '2019-09-23 11:11:41'),
(5, 411, '2019-09-23 11:11:41'),
(5, 412, '2019-09-23 11:11:41'),
(5, 413, '2019-09-23 11:11:41'),
(5, 56, '2019-09-23 11:11:41'),
(5, 57, '2019-09-23 11:11:41'),
(5, 59, '2019-09-23 11:11:41'),
(5, 60, '2019-09-23 11:11:41'),
(5, 61, '2019-09-23 11:11:41'),
(5, 397, '2019-09-23 11:11:41'),
(5, 62, '2019-09-23 11:11:41'),
(5, 278, '2019-09-23 11:11:41'),
(5, 63, '2019-09-23 11:11:41'),
(5, 64, '2019-09-23 11:11:41'),
(5, 65, '2019-09-23 11:11:41'),
(5, 66, '2019-09-23 11:11:41'),
(5, 67, '2019-09-23 11:11:41'),
(5, 68, '2019-09-23 11:11:41'),
(5, 69, '2019-09-23 11:11:41'),
(5, 70, '2019-09-23 11:11:41'),
(5, 257, '2019-09-23 11:11:41'),
(5, 258, '2019-09-23 11:11:41'),
(5, 259, '2019-09-23 11:11:41'),
(5, 260, '2019-09-23 11:11:41'),
(5, 261, '2019-09-23 11:11:41'),
(5, 262, '2019-09-23 11:11:41'),
(5, 99, '2019-09-23 11:11:41'),
(5, 135, '2019-09-23 11:11:41'),
(5, 136, '2019-09-23 11:11:41'),
(5, 74, '2019-09-23 11:11:41'),
(5, 75, '2019-09-23 11:11:41'),
(5, 76, '2019-09-23 11:11:41'),
(5, 77, '2019-09-23 11:11:41'),
(5, 78, '2019-09-23 11:11:41'),
(5, 305, '2019-09-23 11:11:41'),
(5, 86, '2019-09-23 11:11:41'),
(5, 287, '2019-09-23 11:11:41'),
(5, 288, '2019-09-23 11:11:41'),
(5, 289, '2019-09-23 11:11:41'),
(5, 290, '2019-09-23 11:11:41'),
(5, 291, '2019-09-23 11:11:41'),
(5, 292, '2019-09-23 11:11:41'),
(5, 313, '2019-09-23 11:11:41'),
(5, 314, '2019-09-23 11:11:41'),
(5, 317, '2019-09-23 11:11:41'),
(5, 318, '2019-09-23 11:11:41'),
(5, 319, '2019-09-23 11:11:41'),
(5, 320, '2019-09-23 11:11:41'),
(5, 321, '2019-09-23 11:11:41'),
(5, 322, '2019-09-23 11:11:41'),
(5, 323, '2019-09-23 11:11:41'),
(5, 324, '2019-09-23 11:11:41'),
(5, 325, '2019-09-23 11:11:41'),
(5, 326, '2019-09-23 11:11:41'),
(5, 381, '2019-09-23 11:11:41'),
(5, 382, '2019-09-23 11:11:41'),
(5, 383, '2019-09-23 11:11:41'),
(5, 384, '2019-09-23 11:11:41'),
(5, 385, '2019-09-23 11:11:41'),
(5, 386, '2019-09-23 11:11:41'),
(5, 402, '2019-09-23 11:11:41'),
(6, 8, '2019-09-23 11:12:00'),
(6, 31, '2019-09-23 11:12:00'),
(6, 32, '2019-09-23 11:12:00'),
(6, 33, '2019-09-23 11:12:00'),
(6, 34, '2019-09-23 11:12:00'),
(6, 35, '2019-09-23 11:12:00'),
(6, 36, '2019-09-23 11:12:00'),
(6, 37, '2019-09-23 11:12:00'),
(6, 38, '2019-09-23 11:12:00'),
(6, 387, '2019-09-23 11:12:00'),
(6, 414, '2019-09-23 11:12:00'),
(6, 39, '2019-09-23 11:12:00'),
(6, 40, '2019-09-23 11:12:00'),
(6, 41, '2019-09-23 11:12:00'),
(6, 42, '2019-09-23 11:12:00'),
(6, 101, '2019-09-23 11:12:00'),
(6, 102, '2019-09-23 11:12:00'),
(6, 103, '2019-09-23 11:12:00'),
(6, 104, '2019-09-23 11:12:00'),
(6, 105, '2019-09-23 11:12:00'),
(6, 240, '2019-09-23 11:12:00'),
(6, 111, '2019-09-23 11:12:00'),
(6, 112, '2019-09-23 11:12:00'),
(6, 113, '2019-09-23 11:12:00'),
(6, 114, '2019-09-23 11:12:00'),
(6, 115, '2019-09-23 11:12:00'),
(6, 415, '2019-09-23 11:12:00'),
(6, 500, '2019-09-23 11:12:00'),
(6, 85, '2019-09-23 11:12:00'),
(6, 1, '2019-09-23 11:12:00'),
(6, 2, '2019-09-23 11:12:00'),
(6, 3, '2019-09-23 11:12:00'),
(6, 4, '2019-09-23 11:12:00'),
(6, 5, '2019-09-23 11:12:00'),
(6, 6, '2019-09-23 11:12:00'),
(6, 7, '2019-09-23 11:12:00'),
(6, 351, '2019-09-23 11:12:00'),
(6, 409, '2019-09-23 11:12:00'),
(6, 410, '2019-09-23 11:12:00'),
(6, 411, '2019-09-23 11:12:00'),
(6, 412, '2019-09-23 11:12:00'),
(6, 413, '2019-09-23 11:12:00'),
(6, 56, '2019-09-23 11:12:00'),
(6, 57, '2019-09-23 11:12:00'),
(6, 59, '2019-09-23 11:12:00'),
(6, 60, '2019-09-23 11:12:00'),
(6, 61, '2019-09-23 11:12:00'),
(6, 397, '2019-09-23 11:12:00'),
(6, 62, '2019-09-23 11:12:00'),
(6, 278, '2019-09-23 11:12:00'),
(6, 63, '2019-09-23 11:12:00'),
(6, 64, '2019-09-23 11:12:00'),
(6, 65, '2019-09-23 11:12:00'),
(6, 66, '2019-09-23 11:12:00'),
(6, 67, '2019-09-23 11:12:00'),
(6, 68, '2019-09-23 11:12:00'),
(6, 69, '2019-09-23 11:12:00'),
(6, 70, '2019-09-23 11:12:00'),
(6, 257, '2019-09-23 11:12:00'),
(6, 258, '2019-09-23 11:12:00'),
(6, 259, '2019-09-23 11:12:00'),
(6, 260, '2019-09-23 11:12:00'),
(6, 261, '2019-09-23 11:12:00'),
(6, 262, '2019-09-23 11:12:00'),
(6, 99, '2019-09-23 11:12:00'),
(6, 135, '2019-09-23 11:12:00'),
(6, 136, '2019-09-23 11:12:00'),
(6, 74, '2019-09-23 11:12:00'),
(6, 75, '2019-09-23 11:12:00'),
(6, 76, '2019-09-23 11:12:00'),
(6, 77, '2019-09-23 11:12:00'),
(6, 78, '2019-09-23 11:12:00'),
(6, 305, '2019-09-23 11:12:00'),
(6, 86, '2019-09-23 11:12:00'),
(6, 287, '2019-09-23 11:12:00'),
(6, 288, '2019-09-23 11:12:00'),
(6, 289, '2019-09-23 11:12:00'),
(6, 290, '2019-09-23 11:12:00'),
(6, 291, '2019-09-23 11:12:00'),
(6, 292, '2019-09-23 11:12:00'),
(6, 313, '2019-09-23 11:12:00'),
(6, 314, '2019-09-23 11:12:00'),
(6, 317, '2019-09-23 11:12:00'),
(6, 318, '2019-09-23 11:12:00'),
(6, 319, '2019-09-23 11:12:00'),
(6, 320, '2019-09-23 11:12:00'),
(6, 321, '2019-09-23 11:12:00'),
(6, 322, '2019-09-23 11:12:00'),
(6, 323, '2019-09-23 11:12:00'),
(6, 324, '2019-09-23 11:12:00'),
(6, 325, '2019-09-23 11:12:00'),
(6, 326, '2019-09-23 11:12:00'),
(6, 381, '2019-09-23 11:12:00'),
(6, 382, '2019-09-23 11:12:00'),
(6, 383, '2019-09-23 11:12:00'),
(6, 384, '2019-09-23 11:12:00'),
(6, 385, '2019-09-23 11:12:00'),
(6, 386, '2019-09-23 11:12:00'),
(6, 402, '2019-09-23 11:12:00'),
(7, 276, '2019-09-23 11:12:27'),
(7, 293, '2019-09-23 11:12:27'),
(7, 294, '2019-09-23 11:12:27'),
(7, 295, '2019-09-23 11:12:27'),
(7, 296, '2019-09-23 11:12:27'),
(7, 297, '2019-09-23 11:12:27'),
(7, 298, '2019-09-23 11:12:27'),
(25, 276, '2019-09-23 11:15:42'),
(25, 293, '2019-09-23 11:15:42'),
(25, 294, '2019-09-23 11:15:42'),
(25, 295, '2019-09-23 11:15:42'),
(25, 296, '2019-09-23 11:15:42'),
(25, 297, '2019-09-23 11:15:42'),
(25, 298, '2019-09-23 11:15:42'),
(16, 8, '2019-09-23 11:15:57'),
(16, 9, '2019-09-23 11:15:57'),
(16, 10, '2019-09-23 11:15:57'),
(16, 11, '2019-09-23 11:15:57'),
(16, 12, '2019-09-23 11:15:57'),
(16, 13, '2019-09-23 11:15:57'),
(16, 14, '2019-09-23 11:15:57'),
(16, 15, '2019-09-23 11:15:57'),
(16, 16, '2019-09-23 11:15:57'),
(16, 352, '2019-09-23 11:15:57'),
(16, 403, '2019-09-23 11:15:57'),
(16, 17, '2019-09-23 11:15:57'),
(16, 18, '2019-09-23 11:15:57'),
(16, 19, '2019-09-23 11:15:57'),
(16, 20, '2019-09-23 11:15:57'),
(16, 21, '2019-09-23 11:15:57'),
(16, 311, '2019-09-23 11:15:57'),
(16, 312, '2019-09-23 11:15:57'),
(16, 307, '2019-09-23 11:15:57'),
(16, 308, '2019-09-23 11:15:57'),
(16, 22, '2019-09-23 11:15:57'),
(16, 23, '2019-09-23 11:15:57'),
(16, 24, '2019-09-23 11:15:57'),
(16, 25, '2019-09-23 11:15:57'),
(16, 26, '2019-09-23 11:15:57'),
(16, 27, '2019-09-23 11:15:57'),
(16, 327, '2019-09-23 11:15:57'),
(16, 328, '2019-09-23 11:15:57'),
(16, 333, '2019-09-23 11:15:57'),
(16, 329, '2019-09-23 11:15:57'),
(16, 334, '2019-09-23 11:15:57'),
(16, 330, '2019-09-23 11:15:57'),
(16, 331, '2019-09-23 11:15:57'),
(16, 332, '2019-09-23 11:15:57'),
(16, 404, '2019-09-23 11:15:57'),
(16, 416, '2019-09-23 11:15:57'),
(16, 31, '2019-09-23 11:15:57'),
(16, 32, '2019-09-23 11:15:57'),
(16, 33, '2019-09-23 11:15:57'),
(16, 34, '2019-09-23 11:15:57'),
(16, 35, '2019-09-23 11:15:57'),
(16, 36, '2019-09-23 11:15:57'),
(16, 37, '2019-09-23 11:15:57'),
(16, 38, '2019-09-23 11:15:57'),
(16, 387, '2019-09-23 11:15:57'),
(16, 414, '2019-09-23 11:15:57'),
(16, 39, '2019-09-23 11:15:57'),
(16, 40, '2019-09-23 11:15:57'),
(16, 41, '2019-09-23 11:15:57'),
(16, 42, '2019-09-23 11:15:57'),
(16, 101, '2019-09-23 11:15:57'),
(16, 102, '2019-09-23 11:15:57'),
(16, 103, '2019-09-23 11:15:57'),
(16, 104, '2019-09-23 11:15:57'),
(16, 105, '2019-09-23 11:15:57'),
(16, 240, '2019-09-23 11:15:57'),
(16, 111, '2019-09-23 11:15:57'),
(16, 112, '2019-09-23 11:15:57'),
(16, 113, '2019-09-23 11:15:57'),
(16, 114, '2019-09-23 11:15:57'),
(16, 115, '2019-09-23 11:15:57'),
(16, 415, '2019-09-23 11:15:57'),
(16, 500, '2019-09-23 11:15:57'),
(16, 85, '2019-09-23 11:15:57'),
(28, 8, '2019-09-23 11:16:14'),
(28, 9, '2019-09-23 11:16:14'),
(28, 10, '2019-09-23 11:16:14'),
(28, 11, '2019-09-23 11:16:14'),
(28, 12, '2019-09-23 11:16:14'),
(28, 13, '2019-09-23 11:16:14'),
(28, 14, '2019-09-23 11:16:14'),
(28, 15, '2019-09-23 11:16:14'),
(28, 16, '2019-09-23 11:16:14'),
(28, 352, '2019-09-23 11:16:14'),
(28, 403, '2019-09-23 11:16:14'),
(28, 17, '2019-09-23 11:16:14'),
(28, 18, '2019-09-23 11:16:14'),
(28, 19, '2019-09-23 11:16:14'),
(28, 20, '2019-09-23 11:16:14'),
(28, 21, '2019-09-23 11:16:14'),
(28, 311, '2019-09-23 11:16:14'),
(28, 312, '2019-09-23 11:16:14'),
(28, 307, '2019-09-23 11:16:14'),
(28, 308, '2019-09-23 11:16:14'),
(28, 22, '2019-09-23 11:16:14'),
(28, 23, '2019-09-23 11:16:14'),
(28, 24, '2019-09-23 11:16:14'),
(28, 25, '2019-09-23 11:16:14'),
(28, 26, '2019-09-23 11:16:14'),
(28, 27, '2019-09-23 11:16:14'),
(28, 327, '2019-09-23 11:16:14'),
(28, 328, '2019-09-23 11:16:14'),
(28, 333, '2019-09-23 11:16:14'),
(28, 329, '2019-09-23 11:16:14'),
(28, 334, '2019-09-23 11:16:14'),
(28, 330, '2019-09-23 11:16:14'),
(28, 331, '2019-09-23 11:16:14'),
(28, 332, '2019-09-23 11:16:14'),
(28, 404, '2019-09-23 11:16:14'),
(28, 416, '2019-09-23 11:16:14'),
(28, 31, '2019-09-23 11:16:14'),
(28, 32, '2019-09-23 11:16:14'),
(28, 33, '2019-09-23 11:16:14'),
(28, 34, '2019-09-23 11:16:14'),
(28, 35, '2019-09-23 11:16:14'),
(28, 36, '2019-09-23 11:16:14'),
(28, 37, '2019-09-23 11:16:14'),
(28, 38, '2019-09-23 11:16:14'),
(28, 387, '2019-09-23 11:16:14'),
(28, 414, '2019-09-23 11:16:14'),
(28, 39, '2019-09-23 11:16:14'),
(28, 40, '2019-09-23 11:16:14'),
(28, 41, '2019-09-23 11:16:14'),
(28, 42, '2019-09-23 11:16:14'),
(28, 101, '2019-09-23 11:16:14'),
(28, 102, '2019-09-23 11:16:14'),
(28, 103, '2019-09-23 11:16:14'),
(28, 104, '2019-09-23 11:16:14'),
(28, 105, '2019-09-23 11:16:14'),
(28, 240, '2019-09-23 11:16:14'),
(28, 111, '2019-09-23 11:16:14'),
(28, 112, '2019-09-23 11:16:14'),
(28, 113, '2019-09-23 11:16:14'),
(28, 114, '2019-09-23 11:16:14'),
(28, 115, '2019-09-23 11:16:14'),
(28, 415, '2019-09-23 11:16:14'),
(28, 500, '2019-09-23 11:16:14'),
(28, 85, '2019-09-23 11:16:14'),
(28, 1, '2019-09-23 11:16:14'),
(28, 2, '2019-09-23 11:16:14'),
(28, 3, '2019-09-23 11:16:14'),
(28, 4, '2019-09-23 11:16:14'),
(28, 5, '2019-09-23 11:16:14'),
(28, 6, '2019-09-23 11:16:14'),
(28, 7, '2019-09-23 11:16:14'),
(28, 351, '2019-09-23 11:16:14'),
(28, 409, '2019-09-23 11:16:14'),
(28, 410, '2019-09-23 11:16:14'),
(28, 411, '2019-09-23 11:16:14'),
(28, 412, '2019-09-23 11:16:14'),
(28, 413, '2019-09-23 11:16:14'),
(28, 56, '2019-09-23 11:16:14'),
(28, 57, '2019-09-23 11:16:14'),
(28, 59, '2019-09-23 11:16:14'),
(28, 60, '2019-09-23 11:16:14'),
(28, 61, '2019-09-23 11:16:14'),
(28, 397, '2019-09-23 11:16:14'),
(28, 62, '2019-09-23 11:16:14'),
(28, 278, '2019-09-23 11:16:14'),
(28, 63, '2019-09-23 11:16:14'),
(28, 64, '2019-09-23 11:16:14'),
(28, 65, '2019-09-23 11:16:14'),
(28, 66, '2019-09-23 11:16:14'),
(28, 67, '2019-09-23 11:16:14'),
(28, 68, '2019-09-23 11:16:14'),
(28, 69, '2019-09-23 11:16:14'),
(28, 70, '2019-09-23 11:16:14'),
(28, 257, '2019-09-23 11:16:14'),
(28, 258, '2019-09-23 11:16:14'),
(28, 259, '2019-09-23 11:16:14'),
(28, 260, '2019-09-23 11:16:14'),
(28, 261, '2019-09-23 11:16:14'),
(28, 262, '2019-09-23 11:16:14'),
(28, 99, '2019-09-23 11:16:14'),
(28, 135, '2019-09-23 11:16:14'),
(28, 136, '2019-09-23 11:16:14'),
(28, 74, '2019-09-23 11:16:14'),
(28, 75, '2019-09-23 11:16:14'),
(28, 76, '2019-09-23 11:16:14'),
(28, 77, '2019-09-23 11:16:14'),
(28, 78, '2019-09-23 11:16:14'),
(28, 305, '2019-09-23 11:16:14'),
(28, 86, '2019-09-23 11:16:14'),
(28, 287, '2019-09-23 11:16:14'),
(28, 288, '2019-09-23 11:16:14'),
(28, 289, '2019-09-23 11:16:14'),
(28, 290, '2019-09-23 11:16:14'),
(28, 291, '2019-09-23 11:16:14'),
(28, 292, '2019-09-23 11:16:14'),
(28, 313, '2019-09-23 11:16:14'),
(28, 314, '2019-09-23 11:16:14'),
(28, 317, '2019-09-23 11:16:14'),
(28, 318, '2019-09-23 11:16:14'),
(28, 319, '2019-09-23 11:16:14'),
(28, 320, '2019-09-23 11:16:14'),
(28, 321, '2019-09-23 11:16:14'),
(28, 322, '2019-09-23 11:16:14'),
(28, 323, '2019-09-23 11:16:14'),
(28, 324, '2019-09-23 11:16:14'),
(28, 325, '2019-09-23 11:16:14'),
(28, 326, '2019-09-23 11:16:14'),
(28, 381, '2019-09-23 11:16:14'),
(28, 382, '2019-09-23 11:16:14'),
(28, 383, '2019-09-23 11:16:14'),
(28, 384, '2019-09-23 11:16:14'),
(28, 385, '2019-09-23 11:16:14'),
(28, 386, '2019-09-23 11:16:14'),
(28, 402, '2019-09-23 11:16:14'),
(27, 8, '2019-09-23 11:16:25'),
(27, 9, '2019-09-23 11:16:25'),
(27, 10, '2019-09-23 11:16:25'),
(27, 11, '2019-09-23 11:16:25'),
(27, 12, '2019-09-23 11:16:25'),
(27, 13, '2019-09-23 11:16:25'),
(27, 14, '2019-09-23 11:16:25'),
(27, 15, '2019-09-23 11:16:25'),
(27, 16, '2019-09-23 11:16:25'),
(27, 352, '2019-09-23 11:16:25'),
(27, 403, '2019-09-23 11:16:25'),
(27, 17, '2019-09-23 11:16:25'),
(27, 18, '2019-09-23 11:16:25'),
(27, 19, '2019-09-23 11:16:25'),
(27, 20, '2019-09-23 11:16:25'),
(27, 21, '2019-09-23 11:16:25'),
(27, 311, '2019-09-23 11:16:25'),
(27, 312, '2019-09-23 11:16:25'),
(27, 307, '2019-09-23 11:16:25'),
(27, 308, '2019-09-23 11:16:25'),
(27, 22, '2019-09-23 11:16:25'),
(27, 23, '2019-09-23 11:16:25'),
(27, 24, '2019-09-23 11:16:25'),
(27, 25, '2019-09-23 11:16:25'),
(27, 26, '2019-09-23 11:16:25'),
(27, 27, '2019-09-23 11:16:25'),
(27, 327, '2019-09-23 11:16:25'),
(27, 328, '2019-09-23 11:16:25'),
(27, 333, '2019-09-23 11:16:25'),
(27, 329, '2019-09-23 11:16:25'),
(27, 334, '2019-09-23 11:16:25'),
(27, 330, '2019-09-23 11:16:25'),
(27, 331, '2019-09-23 11:16:25'),
(27, 332, '2019-09-23 11:16:25'),
(27, 404, '2019-09-23 11:16:25'),
(27, 416, '2019-09-23 11:16:25'),
(29, 0, '2019-09-25 10:04:05'),
(29, 8, '2019-09-25 10:04:05'),
(29, 9, '2019-09-25 10:04:05'),
(29, 10, '2019-09-25 10:04:05'),
(29, 11, '2019-09-25 10:04:05'),
(29, 12, '2019-09-25 10:04:05'),
(29, 13, '2019-09-25 10:04:05'),
(29, 14, '2019-09-25 10:04:05'),
(29, 15, '2019-09-25 10:04:05'),
(29, 16, '2019-09-25 10:04:05'),
(29, 352, '2019-09-25 10:04:05'),
(29, 403, '2019-09-25 10:04:05'),
(29, 17, '2019-09-25 10:04:05'),
(29, 18, '2019-09-25 10:04:05'),
(29, 19, '2019-09-25 10:04:05'),
(29, 20, '2019-09-25 10:04:05'),
(29, 21, '2019-09-25 10:04:05'),
(29, 311, '2019-09-25 10:04:05'),
(29, 312, '2019-09-25 10:04:05'),
(29, 307, '2019-09-25 10:04:05'),
(29, 308, '2019-09-25 10:04:05'),
(29, 22, '2019-09-25 10:04:05'),
(29, 23, '2019-09-25 10:04:05'),
(29, 24, '2019-09-25 10:04:05'),
(29, 25, '2019-09-25 10:04:05'),
(29, 26, '2019-09-25 10:04:05'),
(29, 27, '2019-09-25 10:04:05'),
(29, 327, '2019-09-25 10:04:05'),
(29, 328, '2019-09-25 10:04:05'),
(29, 333, '2019-09-25 10:04:05'),
(29, 329, '2019-09-25 10:04:05'),
(29, 334, '2019-09-25 10:04:05'),
(29, 330, '2019-09-25 10:04:05'),
(29, 331, '2019-09-25 10:04:05'),
(29, 332, '2019-09-25 10:04:05'),
(29, 404, '2019-09-25 10:04:05'),
(29, 416, '2019-09-25 10:04:05'),
(29, 31, '2019-09-25 10:04:05'),
(29, 32, '2019-09-25 10:04:05'),
(29, 33, '2019-09-25 10:04:05'),
(29, 34, '2019-09-25 10:04:05'),
(29, 35, '2019-09-25 10:04:05'),
(29, 36, '2019-09-25 10:04:05'),
(29, 37, '2019-09-25 10:04:05'),
(29, 38, '2019-09-25 10:04:05'),
(29, 387, '2019-09-25 10:04:05'),
(29, 414, '2019-09-25 10:04:05'),
(29, 39, '2019-09-25 10:04:05'),
(29, 40, '2019-09-25 10:04:05'),
(29, 41, '2019-09-25 10:04:05'),
(29, 42, '2019-09-25 10:04:05'),
(29, 101, '2019-09-25 10:04:05'),
(29, 102, '2019-09-25 10:04:05'),
(29, 103, '2019-09-25 10:04:05'),
(29, 104, '2019-09-25 10:04:05'),
(29, 105, '2019-09-25 10:04:05'),
(29, 240, '2019-09-25 10:04:05'),
(29, 111, '2019-09-25 10:04:05'),
(29, 112, '2019-09-25 10:04:05'),
(29, 113, '2019-09-25 10:04:05'),
(29, 114, '2019-09-25 10:04:05'),
(29, 115, '2019-09-25 10:04:05'),
(29, 415, '2019-09-25 10:04:05'),
(29, 85, '2019-09-25 10:04:05'),
(29, 1, '2019-09-25 10:04:05'),
(29, 2, '2019-09-25 10:04:05'),
(29, 3, '2019-09-25 10:04:05'),
(29, 4, '2019-09-25 10:04:05'),
(29, 5, '2019-09-25 10:04:05'),
(29, 6, '2019-09-25 10:04:05'),
(29, 7, '2019-09-25 10:04:05'),
(29, 351, '2019-09-25 10:04:05'),
(29, 409, '2019-09-25 10:04:05'),
(29, 410, '2019-09-25 10:04:05'),
(29, 411, '2019-09-25 10:04:05'),
(29, 412, '2019-09-25 10:04:05'),
(29, 413, '2019-09-25 10:04:05'),
(29, 56, '2019-09-25 10:04:05'),
(29, 57, '2019-09-25 10:04:05'),
(29, 59, '2019-09-25 10:04:05'),
(29, 60, '2019-09-25 10:04:05'),
(29, 61, '2019-09-25 10:04:05'),
(29, 397, '2019-09-25 10:04:05'),
(29, 62, '2019-09-25 10:04:05'),
(29, 278, '2019-09-25 10:04:05'),
(29, 63, '2019-09-25 10:04:05'),
(29, 64, '2019-09-25 10:04:05'),
(29, 65, '2019-09-25 10:04:05'),
(29, 66, '2019-09-25 10:04:05'),
(29, 67, '2019-09-25 10:04:05'),
(29, 68, '2019-09-25 10:04:05'),
(29, 69, '2019-09-25 10:04:05'),
(29, 70, '2019-09-25 10:04:05'),
(29, 257, '2019-09-25 10:04:05'),
(29, 258, '2019-09-25 10:04:05'),
(29, 259, '2019-09-25 10:04:05'),
(29, 260, '2019-09-25 10:04:05'),
(29, 261, '2019-09-25 10:04:05'),
(29, 262, '2019-09-25 10:04:05'),
(29, 99, '2019-09-25 10:04:05'),
(29, 135, '2019-09-25 10:04:05'),
(29, 136, '2019-09-25 10:04:05'),
(29, 74, '2019-09-25 10:04:05'),
(29, 75, '2019-09-25 10:04:05'),
(29, 76, '2019-09-25 10:04:05'),
(29, 77, '2019-09-25 10:04:05'),
(29, 78, '2019-09-25 10:04:05'),
(29, 305, '2019-09-25 10:04:05'),
(29, 86, '2019-09-25 10:04:05'),
(29, 287, '2019-09-25 10:04:05'),
(29, 288, '2019-09-25 10:04:05'),
(29, 289, '2019-09-25 10:04:05'),
(29, 290, '2019-09-25 10:04:05'),
(29, 291, '2019-09-25 10:04:05'),
(29, 292, '2019-09-25 10:04:05'),
(29, 313, '2019-09-25 10:04:05'),
(29, 314, '2019-09-25 10:04:05'),
(29, 317, '2019-09-25 10:04:05'),
(29, 318, '2019-09-25 10:04:05'),
(29, 319, '2019-09-25 10:04:05'),
(29, 320, '2019-09-25 10:04:05'),
(29, 321, '2019-09-25 10:04:05'),
(29, 322, '2019-09-25 10:04:05'),
(29, 323, '2019-09-25 10:04:05'),
(29, 324, '2019-09-25 10:04:05'),
(29, 325, '2019-09-25 10:04:05'),
(29, 326, '2019-09-25 10:04:05'),
(29, 381, '2019-09-25 10:04:05'),
(29, 382, '2019-09-25 10:04:05'),
(29, 383, '2019-09-25 10:04:05'),
(29, 384, '2019-09-25 10:04:05'),
(29, 385, '2019-09-25 10:04:05'),
(29, 386, '2019-09-25 10:04:05'),
(29, 402, '2019-09-25 10:04:05'),
(29, 417, '2019-09-25 10:04:05'),
(29, 267, '2019-09-25 10:04:05'),
(29, 116, '2019-09-25 10:04:05'),
(29, 117, '2019-09-25 10:04:05'),
(29, 118, '2019-09-25 10:04:05'),
(29, 119, '2019-09-25 10:04:05'),
(29, 120, '2019-09-25 10:04:05'),
(29, 400, '2019-09-25 10:04:05'),
(29, 269, '2019-09-25 10:04:05'),
(29, 140, '2019-09-25 10:04:05'),
(29, 218, '2019-09-25 10:04:05'),
(29, 372, '2019-09-25 10:04:05'),
(29, 373, '2019-09-25 10:04:05'),
(29, 374, '2019-09-25 10:04:05'),
(29, 375, '2019-09-25 10:04:05'),
(29, 376, '2019-09-25 10:04:05'),
(29, 388, '2019-09-25 10:04:05'),
(29, 398, '2019-09-25 10:04:05'),
(29, 501, '2019-09-25 10:04:05'),
(29, 282, '2019-09-25 10:04:05'),
(29, 283, '2019-09-25 10:04:05'),
(29, 284, '2019-09-25 10:04:05'),
(29, 285, '2019-09-25 10:04:05'),
(29, 286, '2019-09-25 10:04:05'),
(29, 401, '2019-09-25 10:04:05'),
(29, 219, '2019-09-25 10:04:05'),
(29, 220, '2019-09-25 10:04:05'),
(29, 221, '2019-09-25 10:04:05'),
(29, 222, '2019-09-25 10:04:05'),
(29, 223, '2019-09-25 10:04:05'),
(29, 224, '2019-09-25 10:04:05'),
(29, 336, '2019-09-25 10:04:05'),
(29, 395, '2019-09-25 10:04:05'),
(29, 276, '2019-09-25 10:04:05'),
(29, 293, '2019-09-25 10:04:05'),
(29, 294, '2019-09-25 10:04:05'),
(29, 295, '2019-09-25 10:04:05'),
(29, 296, '2019-09-25 10:04:05'),
(29, 297, '2019-09-25 10:04:05'),
(29, 298, '2019-09-25 10:04:05'),
(29, 423, '2019-09-25 10:04:05'),
(29, 424, '2019-09-25 10:04:05'),
(29, 425, '2019-09-25 10:04:05'),
(29, 426, '2019-09-25 10:04:05'),
(29, 427, '2019-09-25 10:04:05'),
(29, 428, '2019-09-25 10:04:05'),
(29, 429, '2019-09-25 10:04:05'),
(29, 430, '2019-09-25 10:04:05'),
(29, 431, '2019-09-25 10:04:05'),
(29, 432, '2019-09-25 10:04:05'),
(29, 433, '2019-09-25 10:04:05'),
(29, 434, '2019-09-25 10:04:05'),
(29, 435, '2019-09-25 10:04:05'),
(2, 374, '2019-09-30 09:27:04'),
(2, 375, '2019-09-30 09:27:04'),
(2, 376, '2019-09-30 09:27:04'),
(2, 388, '2019-09-30 09:27:04'),
(2, 398, '2019-09-30 09:27:04'),
(2, 501, '2019-09-30 09:27:04');
