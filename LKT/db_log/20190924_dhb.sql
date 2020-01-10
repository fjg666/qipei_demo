-- 权限菜单
CREATE TABLE `lkt_role_menu`  (
  role_id int(11) NOT NULL DEFAULT 0 COMMENT '角色ID',
  menu_id int(11) NOT NULL DEFAULT 0 COMMENT '菜单ID',
  add_date timestamp NULL DEFAULT NULL COMMENT '添加时间'
) engine='myisam' charset='utf8' comment '权限菜单';