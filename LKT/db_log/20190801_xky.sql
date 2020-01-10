ALTER TABLE `lkt_user_collection`
ADD COLUMN `type`  int(11) NULL DEFAULT 1 COMMENT '收藏类型 1.普通收藏 2.积分商城收藏' AFTER `mch_id`;