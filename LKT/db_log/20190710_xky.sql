ALTER TABLE `lkt_config`
ADD COLUMN `message_day`  int(10) NOT NULL DEFAULT 0 COMMENT '消息保留天数' AFTER `aboutus`;
