ALTER TABLE `lkt_third_mini_info`
ADD COLUMN `review_mark`  tinyint(2) NULL DEFAULT 1 COMMENT '审核状态 1：未审核 2：审核中 3：审核失败 4：审核成功' AFTER `auditid`,
ADD COLUMN `issue_mark`  tinyint(2) NULL DEFAULT 1 COMMENT '发布状态 1：未发布  2：发布失败 3：发布成功' AFTER `review_mark`;