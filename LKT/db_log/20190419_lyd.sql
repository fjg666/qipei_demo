ALTER TABLE `lkt_third`
ADD COLUMN `redirect_url`  text NULL COMMENT '授权回调地址' AFTER `work_domain`,
ADD COLUMN `mini_url`  text NULL COMMENT '小程序接口地址' AFTER `redirect_url`,
ADD COLUMN `kefu_url`  text NULL COMMENT '客服接口url' AFTER `mini_url`,
ADD COLUMN `qr_code`  text NULL COMMENT '体验二维码url' AFTER `kefu_url`;