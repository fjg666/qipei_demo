ALTER TABLE `lkt_auction_product`
ADD COLUMN `s_type`  varchar(50) NULL COMMENT '������Ʒ��ǩ���ͣ����������ֵ�' AFTER `recycle`,
ADD COLUMN `is_show`  tinyint(2) NULL DEFAULT 1 COMMENT '�Ƿ���ʾ 0 ����ʾ  �� 1 ��ʾ' AFTER `s_type`;