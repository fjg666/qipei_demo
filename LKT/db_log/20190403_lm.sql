ALTER TABLE `lkt_comments`
ADD `type` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''''
COMMENT '评价类型-KJ 砍价评论-PT 拼团评论' AFTER `review_time`;