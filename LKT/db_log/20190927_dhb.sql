ALTER TABLE `lkt_message`
ADD COLUMN `SignName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
COMMENT ''短信签名'' AFTER `store_id`;