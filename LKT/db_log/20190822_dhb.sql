/*
Navicat MySQL Data Transfer

Source Server         : 192.168.0.156
Source Server Version : 50516
Source Host           : 192.168.0.156:3306
Source Database       : dadu_shopping

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2013-03-08 10:58:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ds_country`
-- ----------------------------
DROP TABLE IF EXISTS `ds_country`;
CREATE TABLE `ds_country` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `zh_name` varchar(50) NOT NULL,
  `code` varchar(5) NOT NULL DEFAULT '',
  `code2` varchar(5) NOT NULL DEFAULT '',
  `is_show` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否显示 1 显示 0 不显示',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ds_country
-- ----------------------------
INSERT INTO `ds_country` VALUES ('1', 'Afghanistan', '阿富汗', 'AF', '93', '1');
INSERT INTO `ds_country` VALUES ('2', 'Albania', '阿尔巴尼亚', 'AL', '355', '1');
INSERT INTO `ds_country` VALUES ('3', 'Algeria', '阿尔及利亚', 'DZ', '213', '1');
INSERT INTO `ds_country` VALUES ('4', 'American Samoa', '萨摩亚', 'AS', '684', '1');
INSERT INTO `ds_country` VALUES ('5', 'Andorra', '安道尔共和国', 'AD', '376', '1');
INSERT INTO `ds_country` VALUES ('6', 'Angola', '安哥拉', 'AO', '244', '1');
INSERT INTO `ds_country` VALUES ('7', 'Anguilla', '安圭拉', 'AI', '1-264', '1');
INSERT INTO `ds_country` VALUES ('8', 'Antarctica', '南极洲', 'AQ', '672', '1');
INSERT INTO `ds_country` VALUES ('9', 'Antigua and Barbuda', '安提瓜和巴布达', 'AG', '1-268', '1');
INSERT INTO `ds_country` VALUES ('10', 'Argentina', '阿根廷', 'AR', '54', '1');
INSERT INTO `ds_country` VALUES ('11', 'Armenia', '亚美尼亚', 'AM', '374', '1');
INSERT INTO `ds_country` VALUES ('12', 'Aruba', '阿鲁巴', 'AW', '297', '1');
INSERT INTO `ds_country` VALUES ('13', 'Australia', '澳大利亚', 'AU', '61', '1');
INSERT INTO `ds_country` VALUES ('14', 'Austria', '奥地利', 'AT', '43', '1');
INSERT INTO `ds_country` VALUES ('15', 'Azerbaijan', '阿塞拜疆', 'AZ', '994', '1');
INSERT INTO `ds_country` VALUES ('16', 'Bahamas', '巴哈马', 'BS', '1-242', '1');
INSERT INTO `ds_country` VALUES ('17', 'Bahrain', '巴林', 'BH', '973', '1');
INSERT INTO `ds_country` VALUES ('18', 'Bangladesh', '孟加拉国', 'BD', '880', '1');
INSERT INTO `ds_country` VALUES ('19', 'Barbados', '巴巴多斯', 'BB', '1-246', '1');
INSERT INTO `ds_country` VALUES ('20', 'Belarus', '白俄罗斯', 'BY', '375', '1');
INSERT INTO `ds_country` VALUES ('21', 'Belgium', '比利时', 'BE', '32', '1');
INSERT INTO `ds_country` VALUES ('22', 'Belize', '伯利兹城', 'BZ', '501', '1');
INSERT INTO `ds_country` VALUES ('23', 'Benin', '贝宁', 'BJ', '229', '1');
INSERT INTO `ds_country` VALUES ('24', 'Bermuda', '百慕大', 'BM', '1-441', '1');
INSERT INTO `ds_country` VALUES ('25', 'Bhutan', '不丹', 'BT', '975', '1');
INSERT INTO `ds_country` VALUES ('26', 'Bolivia', '玻利维亚', 'BO', '591', '1');
INSERT INTO `ds_country` VALUES ('27', 'Bosnia and Herzegovina', '波斯尼亚和黑塞哥维那', 'BA', '387', '1');
INSERT INTO `ds_country` VALUES ('28', 'Botswana', '博茨瓦纳', 'BW', '267', '1');
INSERT INTO `ds_country` VALUES ('29', 'Bouvet Island', '布维岛', 'BV', '', '1');
INSERT INTO `ds_country` VALUES ('30', 'Brazil', '巴西', 'BR', '55', '1');
INSERT INTO `ds_country` VALUES ('31', 'British Indian Ocean Territory', '英属印度洋领地', 'IO', '1-284', '1');
INSERT INTO `ds_country` VALUES ('32', 'Brunei Darussalam', '文莱达鲁萨兰国', 'BN', '673', '1');
INSERT INTO `ds_country` VALUES ('33', 'Bulgaria', '保加利亚', 'BG', '359', '1');
INSERT INTO `ds_country` VALUES ('34', 'Burkina Faso', '布基纳法索', 'BF', '226', '1');
INSERT INTO `ds_country` VALUES ('35', 'Burundi', '布隆迪', 'BI', '257', '1');
INSERT INTO `ds_country` VALUES ('36', 'Cambodia', '柬埔寨', 'KH', '855', '1');
INSERT INTO `ds_country` VALUES ('37', 'Cameroon', '喀麦隆', 'CM', '237', '1');
INSERT INTO `ds_country` VALUES ('38', 'Canada', '加拿大', 'CA', '1', '1');
INSERT INTO `ds_country` VALUES ('39', 'Cape Verde', '佛得角', 'CV', '238', '1');
INSERT INTO `ds_country` VALUES ('40', 'Cayman Islands', '开曼群岛', 'KY', '1-345', '1');
INSERT INTO `ds_country` VALUES ('41', 'Central African Republic', '中非共和国', 'CF', '236', '1');
INSERT INTO `ds_country` VALUES ('42', 'Chad', '乍得', 'TD', '235', '1');
INSERT INTO `ds_country` VALUES ('43', 'Chile', '智利', 'CL', '56', '1');
INSERT INTO `ds_country` VALUES ('44', 'China', '中国', 'CN', '86', '1');
INSERT INTO `ds_country` VALUES ('45', 'Christmas Island', '圣延岛', 'CX', '61', '1');
INSERT INTO `ds_country` VALUES ('46', 'Cocos (Keeling) Islands', '科科斯群岛', 'CC', '61', '1');
INSERT INTO `ds_country` VALUES ('47', 'Colombia', '哥伦比亚', 'CO', '57', '1');
INSERT INTO `ds_country` VALUES ('48', 'Comoros', '科摩罗', 'KM', '269', '1');
INSERT INTO `ds_country` VALUES ('49', 'Congo', '刚果', 'CG', '242', '1');
INSERT INTO `ds_country` VALUES ('50', 'Congo, The Democratic Republic Of The', '刚果民主共和国', 'ZR', '243', '1');
INSERT INTO `ds_country` VALUES ('51', 'Cook Islands', '库克群岛', 'CK', '682', '1');
INSERT INTO `ds_country` VALUES ('52', 'Costa Rica', '哥斯达黎加', 'CR', '506', '1');
INSERT INTO `ds_country` VALUES ('53', 'Cote D\'Ivoire', 'Cote D\'Ivoire', 'CI', '225', '1');
INSERT INTO `ds_country` VALUES ('54', 'Croatia (local name: Hrvatska)', '克罗地亚', 'HR', '385', '1');
INSERT INTO `ds_country` VALUES ('55', 'Cuba', '古巴', 'CU', '53', '1');
INSERT INTO `ds_country` VALUES ('56', 'Cyprus', '塞浦路斯', 'CY', '357', '1');
INSERT INTO `ds_country` VALUES ('57', 'Czech Republic', '捷克', 'CZ', '420', '1');
INSERT INTO `ds_country` VALUES ('58', 'Denmark', '丹麦', 'DK', '45', '1');
INSERT INTO `ds_country` VALUES ('59', 'Djibouti', '吉布提', 'DJ', '253', '1');
INSERT INTO `ds_country` VALUES ('60', 'Dominica', '多米尼克国', 'DM', '1-767', '1');
INSERT INTO `ds_country` VALUES ('61', 'Dominican Republic', '多米尼加共和国', 'DO', '1-809', '1');
INSERT INTO `ds_country` VALUES ('62', 'East Timor', '东帝汶', 'TP', '670', '1');
INSERT INTO `ds_country` VALUES ('63', 'Ecuador', '厄瓜多尔', 'EC', '593', '1');
INSERT INTO `ds_country` VALUES ('64', 'Egypt', '埃及', 'EG', '20', '1');
INSERT INTO `ds_country` VALUES ('65', 'El Salvador', '萨尔瓦多', 'SV', '503', '1');
INSERT INTO `ds_country` VALUES ('66', 'Equatorial Guinea', '赤道几内亚', 'GQ', '240', '1');
INSERT INTO `ds_country` VALUES ('67', 'Eritrea', '厄立特里亚国', 'ER', '291', '1');
INSERT INTO `ds_country` VALUES ('68', 'Estonia', '爱沙尼亚', 'EE', '372', '1');
INSERT INTO `ds_country` VALUES ('69', 'Ethiopia', '埃塞俄比亚', 'ET', '251', '1');
INSERT INTO `ds_country` VALUES ('70', 'Falkland Islands (Malvinas)', '福克兰群岛', 'FK', '500', '1');
INSERT INTO `ds_country` VALUES ('71', 'Faroe Islands', '法罗群岛', 'FO', '298', '1');
INSERT INTO `ds_country` VALUES ('72', 'Fiji', '斐济', 'FJ', '679', '1');
INSERT INTO `ds_country` VALUES ('73', 'Finland', '芬兰', 'FI', '358', '1');
INSERT INTO `ds_country` VALUES ('74', 'France', '法国', 'FR', '33', '1');
INSERT INTO `ds_country` VALUES ('75', 'France Metropolitan', '法国大都会', 'FX', '33', '1');
INSERT INTO `ds_country` VALUES ('76', 'French Guiana', '法属圭亚那', 'GF', '594', '1');
INSERT INTO `ds_country` VALUES ('77', 'French Polynesia', '法属玻里尼西亚', 'PF', '689', '1');
INSERT INTO `ds_country` VALUES ('78', 'French Southern Territories', 'French Southern Territories', 'TF', '', '1');
INSERT INTO `ds_country` VALUES ('79', 'Gabon', '加蓬', 'GA', '241', '1');
INSERT INTO `ds_country` VALUES ('80', 'Gambia', ' 冈比亚', 'GM', '220', '1');
INSERT INTO `ds_country` VALUES ('81', 'Georgia', '格鲁吉亚', 'GE', '995', '1');
INSERT INTO `ds_country` VALUES ('82', 'Germany', '德国', 'DE', '49', '1');
INSERT INTO `ds_country` VALUES ('83', 'Ghana', '加纳', 'GH', '233', '1');
INSERT INTO `ds_country` VALUES ('84', 'Gibraltar', '直布罗陀', 'GI', '350', '1');
INSERT INTO `ds_country` VALUES ('85', 'Greece', '希腊', 'GR', '30', '1');
INSERT INTO `ds_country` VALUES ('86', 'Greenland', '格陵兰', 'GL', '299', '1');
INSERT INTO `ds_country` VALUES ('87', 'Grenada', '格林纳达', 'GD', '1-473', '1');
INSERT INTO `ds_country` VALUES ('88', 'Guadeloupe', '瓜德罗普岛', 'GP', '590', '1');
INSERT INTO `ds_country` VALUES ('89', 'Guam', '关岛', 'GU', '1-671', '1');
INSERT INTO `ds_country` VALUES ('90', 'Guatemala', '危地马拉', 'GT', '502', '1');
INSERT INTO `ds_country` VALUES ('91', 'Guinea', '几内亚', 'GN', '224', '1');
INSERT INTO `ds_country` VALUES ('92', 'Guinea-Bissau', '几内亚比绍', 'GW', '245', '1');
INSERT INTO `ds_country` VALUES ('93', 'Guyana', '圭亚那', 'GY', '592', '1');
INSERT INTO `ds_country` VALUES ('94', 'Haiti', '海地', 'HT', '509', '1');
INSERT INTO `ds_country` VALUES ('95', 'Heard and Mc Donald Islands', 'Heard and Mc Donald Islands', 'HM', '', '1');
INSERT INTO `ds_country` VALUES ('96', 'Honduras', '洪都拉斯', 'HN', '504', '1');
INSERT INTO `ds_country` VALUES ('97', 'Hong Kong', '香港', 'HK', '852', '1');
INSERT INTO `ds_country` VALUES ('98', 'Hungary', '匈牙利', 'HU', '36', '1');
INSERT INTO `ds_country` VALUES ('99', 'Iceland', '冰岛', 'IS', '354', '1');
INSERT INTO `ds_country` VALUES ('100', 'India', '印度', 'IN', '91', '1');
INSERT INTO `ds_country` VALUES ('101', 'Indonesia', '印度尼西亚', 'ID', '62', '1');
INSERT INTO `ds_country` VALUES ('102', 'Iran (Islamic Republic of)', 'Iran (Islamic Republic of)', 'IR', '98', '1');
INSERT INTO `ds_country` VALUES ('103', 'Iraq', '伊拉克', 'IQ', '964', '1');
INSERT INTO `ds_country` VALUES ('104', 'Ireland', '爱尔兰', 'IE', '353', '1');
INSERT INTO `ds_country` VALUES ('105', 'Isle of Man', '英国属地曼岛', 'IM', '', '1');
INSERT INTO `ds_country` VALUES ('106', 'Israel', '以色列', 'IL', '972', '1');
INSERT INTO `ds_country` VALUES ('107', 'Italy', '意大利', 'IT', '39', '1');
INSERT INTO `ds_country` VALUES ('108', 'Jamaica', '牙买加', 'JM', '1-876', '1');
INSERT INTO `ds_country` VALUES ('109', 'Japan', '日本', 'JP', '81', '1');
INSERT INTO `ds_country` VALUES ('110', 'Jordan', '约旦', 'JO', '962', '1');
INSERT INTO `ds_country` VALUES ('111', 'Kazakhstan', '哈萨克', 'KZ', '7', '1');
INSERT INTO `ds_country` VALUES ('112', 'Kenya', '肯尼亚', 'KE', '254', '1');
INSERT INTO `ds_country` VALUES ('113', 'Kiribati', '吉尔巴斯', 'KI', '686', '1');
INSERT INTO `ds_country` VALUES ('114', 'Kuwait', '科威特', 'KW', '965', '1');
INSERT INTO `ds_country` VALUES ('115', 'Kyrgyzstan', '吉尔吉斯', 'KG', '996', '1');
INSERT INTO `ds_country` VALUES ('116', 'Lao People\'s Democratic Republic', 'Lao People\'s Democratic Republic', 'LA', '', '1');
INSERT INTO `ds_country` VALUES ('117', 'Latvia', '拉脱维亚', 'LV', '371', '1');
INSERT INTO `ds_country` VALUES ('118', 'Lebanon', '黎巴嫩', 'LB', '961', '1');
INSERT INTO `ds_country` VALUES ('119', 'Lesotho', '莱索托', 'LS', '266', '1');
INSERT INTO `ds_country` VALUES ('120', 'Liberia', '利比里亚', 'LR', '231', '1');
INSERT INTO `ds_country` VALUES ('121', 'Libyan Arab Jamahiriya', '利比亚', 'LY', '218', '1');
INSERT INTO `ds_country` VALUES ('122', 'Liechtenstein', '列支敦士登', 'LI', '423', '1');
INSERT INTO `ds_country` VALUES ('123', 'Lithuania', '立陶宛', 'LT', '370', '1');
INSERT INTO `ds_country` VALUES ('124', 'Luxembourg', '卢森堡', 'LU', '352', '1');
INSERT INTO `ds_country` VALUES ('125', 'Macau', '澳门地区', 'MO', '853', '1');
INSERT INTO `ds_country` VALUES ('126', 'Madagascar', '马达加斯加', 'MG', '261', '1');
INSERT INTO `ds_country` VALUES ('127', 'Malawi', '马拉维', 'MW', '265', '1');
INSERT INTO `ds_country` VALUES ('128', 'Malaysia', '马来西亚', 'MY', '60', '1');
INSERT INTO `ds_country` VALUES ('129', 'Maldives', '马尔代夫', 'MV', '960', '1');
INSERT INTO `ds_country` VALUES ('130', 'Mali', '马里', 'ML', '223', '1');
INSERT INTO `ds_country` VALUES ('131', 'Malta', '马尔他', 'MT', '356', '1');
INSERT INTO `ds_country` VALUES ('132', 'Marshall Islands', '马绍尔群岛', 'MH', '692', '1');
INSERT INTO `ds_country` VALUES ('133', 'Martinique', '马提尼克岛', 'MQ', '596', '1');
INSERT INTO `ds_country` VALUES ('134', 'Mauritania', '毛里塔尼亚', 'MR', '222', '1');
INSERT INTO `ds_country` VALUES ('135', 'Mauritius', '毛里求斯', 'MU', '230', '1');
INSERT INTO `ds_country` VALUES ('136', 'Mayotte', '马约特', 'YT', '269', '1');
INSERT INTO `ds_country` VALUES ('137', 'Mexico', '墨西哥', 'MX', '52', '1');
INSERT INTO `ds_country` VALUES ('138', 'Micronesia', '密克罗尼西亚', 'FM', '691', '1');
INSERT INTO `ds_country` VALUES ('139', 'Moldova', '摩尔多瓦', 'MD', '373', '1');
INSERT INTO `ds_country` VALUES ('140', 'Monaco', '摩纳哥', 'MC', '377', '1');
INSERT INTO `ds_country` VALUES ('141', 'Mongolia', '外蒙古', 'MN', '976', '1');
INSERT INTO `ds_country` VALUES ('142', 'Montenegro', 'Montenegro', 'MNE', '382', '1');
INSERT INTO `ds_country` VALUES ('143', 'Montserrat', '蒙特色纳', 'MS', '1-664', '1');
INSERT INTO `ds_country` VALUES ('144', 'Morocco', '摩洛哥', 'MA', '212', '1');
INSERT INTO `ds_country` VALUES ('145', 'Mozambique', '莫桑比克', 'MZ', '258', '1');
INSERT INTO `ds_country` VALUES ('146', 'Myanmar', '缅甸', 'MM', '95', '1');
INSERT INTO `ds_country` VALUES ('147', 'Namibia', '那米比亚', 'NA', '264', '1');
INSERT INTO `ds_country` VALUES ('148', 'Nauru', '瑙鲁', 'NR', '674', '1');
INSERT INTO `ds_country` VALUES ('149', 'Nepal', '尼泊尔', 'NP', '977', '1');
INSERT INTO `ds_country` VALUES ('150', 'Netherlands', '荷兰', 'NL', '31', '1');
INSERT INTO `ds_country` VALUES ('151', 'Netherlands Antilles', '荷兰安的列斯群岛', 'AN', '599', '1');
INSERT INTO `ds_country` VALUES ('152', 'New Caledonia', '新加勒多尼亚', 'NC', '687', '1');
INSERT INTO `ds_country` VALUES ('153', 'New Zealand', '新西兰', 'NZ', '64', '1');
INSERT INTO `ds_country` VALUES ('154', 'Nicaragua', '尼加拉瓜', 'NI', '505', '1');
INSERT INTO `ds_country` VALUES ('155', 'Niger', '尼日尔', 'NE', '227', '1');
INSERT INTO `ds_country` VALUES ('156', 'Nigeria', '尼日利亚', 'NG', '234', '1');
INSERT INTO `ds_country` VALUES ('157', 'Niue', '纽鄂岛', 'NU', '683', '1');
INSERT INTO `ds_country` VALUES ('158', 'Norfolk Island', '诺福克岛', 'NF', '672', '1');
INSERT INTO `ds_country` VALUES ('159', 'North Korea', '朝鲜', 'KP', '850', '1');
INSERT INTO `ds_country` VALUES ('160', 'Northern Mariana Islands', '北马里亚纳群岛', 'MP', '1670', '1');
INSERT INTO `ds_country` VALUES ('161', 'Norway', '挪威', 'NO', '47', '1');
INSERT INTO `ds_country` VALUES ('162', 'Oman', '阿曼', 'OM', '968', '1');
INSERT INTO `ds_country` VALUES ('163', 'Pakistan', '巴基斯坦', 'PK', '92', '1');
INSERT INTO `ds_country` VALUES ('164', 'Palau', '帛琉', 'PW', '680', '1');
INSERT INTO `ds_country` VALUES ('165', 'Palestine', '巴勒斯坦', 'PS', '970', '1');
INSERT INTO `ds_country` VALUES ('166', 'Panama', '巴拿马', 'PA', '507', '1');
INSERT INTO `ds_country` VALUES ('167', 'Papua New Guinea', '巴布亚新几内亚', 'PG', '675', '1');
INSERT INTO `ds_country` VALUES ('168', 'Paraguay', '巴拉圭', 'PY', '595', '1');
INSERT INTO `ds_country` VALUES ('169', 'Peru', '秘鲁', 'PE', '51', '1');
INSERT INTO `ds_country` VALUES ('170', 'Philippines', '菲律宾共和国', 'PH', '63', '1');
INSERT INTO `ds_country` VALUES ('171', 'Pitcairn', '皮特凯恩岛', 'PN', '872', '1');
INSERT INTO `ds_country` VALUES ('172', 'Poland', '波兰', 'PL', '48', '1');
INSERT INTO `ds_country` VALUES ('173', 'Portugal', '葡萄牙', 'PT', '351', '1');
INSERT INTO `ds_country` VALUES ('174', 'Puerto Rico', '波多黎各', 'PR', '1-787', '1');
INSERT INTO `ds_country` VALUES ('175', 'Qatar', '卡塔尔', 'QA', '974', '1');
INSERT INTO `ds_country` VALUES ('176', 'Reunion', 'Reunion', 'RE', '262', '1');
INSERT INTO `ds_country` VALUES ('177', 'Romania', '罗马尼亚', 'RO', '40', '1');
INSERT INTO `ds_country` VALUES ('178', 'Russian Federation', '俄罗斯联邦', 'RU', '7', '1');
INSERT INTO `ds_country` VALUES ('179', 'Rwanda', '卢旺达', 'RW', '250', '1');
INSERT INTO `ds_country` VALUES ('180', 'Saint Kitts and Nevis', '圣吉斯和尼维斯', 'KN', '', '1');
INSERT INTO `ds_country` VALUES ('181', 'Saint Lucia', '圣卢西亚', 'LC', '', '1');
INSERT INTO `ds_country` VALUES ('182', 'Saint Vincent and the Grenadines', '圣文森和格林纳丁斯', 'VC', '', '1');
INSERT INTO `ds_country` VALUES ('183', 'Samoa', '美属萨摩亚', 'WS', '685', '1');
INSERT INTO `ds_country` VALUES ('184', 'San Marino', 'San Marino', 'SM', '378', '1');
INSERT INTO `ds_country` VALUES ('185', 'Sao Tome and Principe', '圣多美和普林西比', 'ST', '', '1');
INSERT INTO `ds_country` VALUES ('186', 'Saudi Arabia', '沙特阿拉伯', 'SA', '966', '1');
INSERT INTO `ds_country` VALUES ('187', 'Senegal', '塞内加尔', 'SN', '221', '1');
INSERT INTO `ds_country` VALUES ('188', 'Serbia', '塞尔维亚共和国', 'SRB', '381', '1');
INSERT INTO `ds_country` VALUES ('189', 'Seychelles', '塞锡尔群岛', 'SC', '248', '1');
INSERT INTO `ds_country` VALUES ('190', 'Sierra Leone', '塞拉利昂', 'SL', '232', '1');
INSERT INTO `ds_country` VALUES ('191', 'Singapore', '新加坡', 'SG', '65', '1');
INSERT INTO `ds_country` VALUES ('192', 'Slovakia (Slovak Republic)', '斯洛伐克（斯洛伐克人的共和国）', 'SK', '421', '1');
INSERT INTO `ds_country` VALUES ('193', 'Slovenia', '斯洛文尼亚', 'SI', '386', '1');
INSERT INTO `ds_country` VALUES ('194', 'Solomon Islands', '索罗门群岛', 'SB', '677', '1');
INSERT INTO `ds_country` VALUES ('195', 'Somalia', '索马里', 'SO', '252', '1');
INSERT INTO `ds_country` VALUES ('196', 'South Africa', '南非', 'ZA', '27', '1');
INSERT INTO `ds_country` VALUES ('197', 'South Korea', '韩国', 'KR', '82', '1');
INSERT INTO `ds_country` VALUES ('198', 'Spain', '西班牙', 'ES', '34', '1');
INSERT INTO `ds_country` VALUES ('199', 'Sri Lanka', '斯里兰卡', 'LK', '94', '1');
INSERT INTO `ds_country` VALUES ('200', 'St. Helena', '圣海伦娜', 'SH', '290', '1');
INSERT INTO `ds_country` VALUES ('201', 'St. Pierre and Miquelon', '圣皮埃尔和密克罗', 'PM', '508', '1');
INSERT INTO `ds_country` VALUES ('202', 'Sudan', '苏丹', 'SD', '249', '1');
INSERT INTO `ds_country` VALUES ('203', 'Suriname', '苏里南', 'SR', '597', '1');
INSERT INTO `ds_country` VALUES ('204', 'Svalbard and Jan Mayen Islands', '冷岸和央麦恩群岛', 'SJ', '', '1');
INSERT INTO `ds_country` VALUES ('205', 'Swaziland', '斯威士兰', 'SZ', '268', '1');
INSERT INTO `ds_country` VALUES ('206', 'Sweden', '瑞典', 'SE', '46', '1');
INSERT INTO `ds_country` VALUES ('207', 'Switzerland', '瑞士', 'CH', '41', '1');
INSERT INTO `ds_country` VALUES ('208', 'Syrian Arab Republic', '叙利亚', 'SY', '963', '1');
INSERT INTO `ds_country` VALUES ('209', 'Taiwan', '台湾地区', 'TW', '886', '1');
INSERT INTO `ds_country` VALUES ('210', 'Tajikistan', '塔吉克', 'TJ', '992', '1');
INSERT INTO `ds_country` VALUES ('211', 'Tanzania', '坦桑尼亚', 'TZ', '255', '1');
INSERT INTO `ds_country` VALUES ('212', 'Thailand', '泰国', 'TH', '66', '1');
INSERT INTO `ds_country` VALUES ('213', 'The former Yugoslav Republic of Macedonia', '前马其顿南斯拉夫共和国', 'MK', '389', '1');
INSERT INTO `ds_country` VALUES ('214', 'Togo', '多哥', 'TG', '228', '1');
INSERT INTO `ds_country` VALUES ('215', 'Tokelau', '托克劳', 'TK', '690', '1');
INSERT INTO `ds_country` VALUES ('216', 'Tonga', '汤加', 'TO', '676', '1');
INSERT INTO `ds_country` VALUES ('217', 'Trinidad and Tobago', '千里达托贝哥共和国', 'TT', '1-868', '1');
INSERT INTO `ds_country` VALUES ('218', 'Tunisia', '北非共和国', 'TN', '216', '1');
INSERT INTO `ds_country` VALUES ('219', 'Turkey', '土耳其', 'TR', '90', '1');
INSERT INTO `ds_country` VALUES ('220', 'Turkmenistan', '土库曼', 'TM', '993', '1');
INSERT INTO `ds_country` VALUES ('221', 'Turks and Caicos Islands', '土克斯和开科斯群岛', 'TC', '1-649', '1');
INSERT INTO `ds_country` VALUES ('222', 'Tuvalu', '图瓦卢', 'TV', '688', '1');
INSERT INTO `ds_country` VALUES ('223', 'Uganda', '乌干达', 'UG', '256', '1');
INSERT INTO `ds_country` VALUES ('224', 'Ukraine', '乌克兰', 'UA', '380', '1');
INSERT INTO `ds_country` VALUES ('225', 'United Arab Emirates', '阿拉伯联合酋长国', 'AE', '971', '1');
INSERT INTO `ds_country` VALUES ('226', 'United Kingdom', '英国', 'UK', '44', '1');
INSERT INTO `ds_country` VALUES ('227', 'United States', '美国', 'US', '1', '1');
INSERT INTO `ds_country` VALUES ('228', 'United States Minor Outlying Islands', '美国小离岛', 'UM', '', '1');
INSERT INTO `ds_country` VALUES ('229', 'Uruguay', '乌拉圭', 'UY', '598', '1');
INSERT INTO `ds_country` VALUES ('230', 'Uzbekistan', '乌兹别克斯坦', 'UZ', '998', '1');
INSERT INTO `ds_country` VALUES ('231', 'Vanuatu', '瓦努阿图', 'VU', '678', '1');
INSERT INTO `ds_country` VALUES ('232', 'Vatican City State (Holy See)', '梵蒂冈(罗马教廷)', 'VA', '39', '1');
INSERT INTO `ds_country` VALUES ('233', 'Venezuela', '委内瑞拉', 'VE', '58', '1');
INSERT INTO `ds_country` VALUES ('234', 'Vietnam', '越南', 'VN', '84', '1');
INSERT INTO `ds_country` VALUES ('235', 'Virgin Islands (British)', '维尔京群岛(英国)', 'VG', '1284', '1');
INSERT INTO `ds_country` VALUES ('236', 'Virgin Islands (U.S.)', '维尔京群岛(美国)', 'VI', '1340', '1');
INSERT INTO `ds_country` VALUES ('237', 'Wallis And Futuna Islands', '沃利斯和富图纳群岛', 'WF', '681', '1');
INSERT INTO `ds_country` VALUES ('238', 'Western Sahara', '西撒哈拉', 'EH', '685', '1');
INSERT INTO `ds_country` VALUES ('239', 'Yemen', '也门', 'YE', '967', '1');
INSERT INTO `ds_country` VALUES ('240', 'Yugoslavia', '南斯拉夫', 'YU', '381', '1');
INSERT INTO `ds_country` VALUES ('241', 'Zambia', '赞比亚', 'ZM', '260', '1');
INSERT INTO `ds_country` VALUES ('242', 'Zimbabwe', '津巴布韦', 'ZW', '263', '1');
