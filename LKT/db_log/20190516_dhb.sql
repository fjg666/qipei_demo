ALTER TABLE `lkt_hotkeywords`
ADD COLUMN `store_id`  int(11) NULL COMMENT ''商城ID'' AFTER `id`,
ADD COLUMN `is_open`  tinyint(4) NULL DEFAULT 0 COMMENT ''是否开启 0.未开启 1.
开启'' AFTER `store_id`,
ADD COLUMN `num`  int(11) NULL DEFAULT 0 COMMENT ''关键词上限'' AFTER `is_open`;

ALTER TABLE `lkt_hotkeywords`
MODIFY COLUMN `keyword`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT
NULL COMMENT ''关键词'' AFTER `num`;

ALTER TABLE `lkt_hotkeywords`
ADD COLUMN `mch_keyword`  text NULL COMMENT ''店铺关键词'' AFTER `keyword`;