CREATE TABLE `lkt_third` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `ticket` varchar(255) DEFAULT NULL COMMENT '获取token的凭证',
  `ticket_time` timestamp NULL DEFAULT NULL COMMENT '凭证更新时间',
  `token` varchar(255) DEFAULT NULL COMMENT '授权token',
  `token_expires` int(11) DEFAULT NULL COMMENT 'token过期时间戳',
  `appid` varchar(50) DEFAULT NULL COMMENT '第三方平台appid',
  `appsecret` varchar(100) DEFAULT NULL COMMENT '第三方平台秘钥',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='第三方授权表';
CREATE TABLE `lkt_third_mini_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `mini_name` varchar(100) DEFAULT NULL COMMENT '小程序名称',
  `authorizer_appid` varchar(100) DEFAULT NULL COMMENT '授权小程序appid',
  `authorizer_access_token``` varchar(255) DEFAULT NULL COMMENT '授权方接口调用凭据（在授权的公众号或小程序具备API权限时，才有此返回值），也简称为令牌',
  `authorizer_expires` int(11) unsigned DEFAULT NULL COMMENT '有效期（在授权的公众号或小程序具备API权限时，才有此返回值）',
  `authorizer_refresh_token` varchar(255) DEFAULT NULL COMMENT '接口调用凭据刷新令牌',
  `update_time` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `func_info` varchar(255) DEFAULT NULL COMMENT '授权给开发者的权限集列表',
  `expires_time` int(11) DEFAULT NULL COMMENT '过期时间戳',
  `company_id` varchar(100) DEFAULT NULL COMMENT '公司id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
