ALTER TABLE `lkt_user_rule`
ADD COLUMN `store_id`  int(11) UNSIGNED NULL COMMENT '商城id' AFTER `wait`;
ALTER TABLE `lkt_user_grade`
ADD COLUMN `store_id`  int(11) UNSIGNED NULL COMMENT '商城id' AFTER `money`;