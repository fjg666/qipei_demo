ALTER TABLE `lkt_extension`
ADD COLUMN `store_type`  tinyint(4) NULL DEFAULT 1 COMMENT '来源 1.小程序 2.app' AFTER `data`;
ALTER TABLE `lkt_extension`
ADD COLUMN `url`  varchar(255) NULL COMMENT '链接地址' AFTER `keyword`;
ALTER TABLE `lkt_extension`
MODIFY COLUMN `type`  int(2) NOT NULL COMMENT '海报类型 1.文章海报 2.红包海报 3.商品海报 4.分销海报 5.邀请海报 6.竞拍海报' AFTER `kuan`;