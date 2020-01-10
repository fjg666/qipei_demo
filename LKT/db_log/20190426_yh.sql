ALTER TABLE `lkt_order` ADD INDEX(`user_id`);
ALTER TABLE `lkt_order` ADD INDEX(`store_id`);
ALTER TABLE `lkt_order` ADD INDEX(`sNo`);

ALTER TABLE `lkt_order_details` ADD INDEX(`store_id`);
ALTER TABLE `lkt_order_details` ADD INDEX(`user_id`);
ALTER TABLE `lkt_order_details` ADD INDEX(`r_sNo`);
