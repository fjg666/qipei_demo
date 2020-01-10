ALTER TABLE `lkt_product_list`
CHANGE COLUMN `display_position` `initial`  text CHARACTER SET utf8 COLLATE
utf8_general_ci NULL COMMENT '初始值' AFTER `volume`;
ALTER TABLE `lkt_product_list`
MODIFY COLUMN `status`  tinyint(3) NOT NULL DEFAULT 2 COMMENT '状态 0:上架 1:
下架 2:待上架' AFTER `min_inventory`;
ALTER TABLE `lkt_session_id`
ADD COLUMN `type`  varchar(255) NULL COMMENT '类型' AFTER `add_date`;
ALTER TABLE `lkt_session_id`
MODIFY COLUMN `type`  tinyint(4) NULL DEFAULT 0 COMMENT '类型 0.发送短信 1.商
品 2.退货申请 3.评论' AFTER `add_date`;