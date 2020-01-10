<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>用户中心</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
	</head>
	{literal}
	<style>
			.label-help {
				display: inline-block;
				font-size: .65rem;
				background: #555;
				color: #fff;
				border-radius: 999px;
				width: 1rem;
				height: 1rem;
				line-height: 1rem;
				text-align: center;
				text-decoration: none;
				margin-left: .25rem;
			}
			
			.label-help:hover,
			.label-help:visited {
				color: #fff;
				text-decoration: none;
			}
		</style>
		
		<style>
			.panel-body .left {
				max-width: 153px;
				width: 300px;
				border: 1px solid #eee;
				background-color: #f4f5f9;
			}
			
			.left .item {
				width: 100%;
				padding: 0 10px;
				line-height: 40px;
				cursor: pointer;
			}
			
			.text-more {
				display: inline-block;
				width: 70%;
				overflow: hidden;
				white-space: nowrap;
				text-overflow: ellipsis;
				word-break: break-all;
			}
			
			.left .item:first-child {
				background-color: #fff;
			}
			
			.left .item.active {
				background-color: #fff;
			}
			
			.left .item:hover {
				background-color: #fff;
			}
			
			.item-icon {
				width: 1rem;
				height: 1rem;
				line-height: 1;
				font-size: 1.3rem;
			}
			
			.file-item .mask {
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				z-index: 5;
				background-color: rgba(0, 0, 0, .5);
				text-align: center;
				background-image: url('style/diy_img/icon-file-gou.png');
				background-size: 40px 40px;
				background-repeat: no-repeat;
				background-position: center;
			}
			
		</style>
		<style>
				.col,
				.col-1,
				.col-10,
				.col-11,
				.col-12,
				.col-2,
				.col-3,
				.col-4,
				.col-5,
				.col-6,
				.col-7,
				.col-8,
				.col-9,
				.col-lg,
				.col-lg-1,
				.col-lg-10,
				.col-lg-11,
				.col-lg-12,
				.col-lg-2,
				.col-lg-3,
				.col-lg-4,
				.col-lg-5,
				.col-lg-6,
				.col-lg-7,
				.col-lg-8,
				.col-lg-9,
				.col-md,
				.col-md-1,
				.col-md-10,
				.col-md-11,
				.col-md-12,
				.col-md-2,
				.col-md-3,
				.col-md-4,
				.col-md-5,
				.col-md-6,
				.col-md-7,
				.col-md-8,
				.col-md-9,
				.col-sm,
				.col-sm-1,
				.col-sm-10,
				.col-sm-11,
				.col-sm-12,
				.col-sm-2,
				.col-sm-3,
				.col-sm-4,
				.col-sm-5,
				.col-sm-6,
				.col-sm-7,
				.col-sm-8,
				.col-sm-9,
				.col-xl,
				.col-xl-1,
				.col-xl-10,
				.col-xl-11,
				.col-xl-12,
				.col-xl-2,
				.col-xl-3,
				.col-xl-4,
				.col-xl-5,
				.col-xl-6,
				.col-xl-7,
				.col-xl-8,
				.col-xl-9 {
					padding: 0;
					margin: 0;
				}
				
				.mobile-box {
					width: 219px;
					height: 450px;
					background-image: url("style/diy_img/mobile-iphone.png");
					background-size: cover;
					position: relative;
					font-size: .85rem;
					float: left;
					margin-right: 1rem;
				}
				
				.mobile-box .mobile-screen {
					position: absolute;
					top: 52px;
					left: 12px;
					right: 13px;
					bottom: 54px;
					border: 1px solid #999;
					background: #f5f7f9;
					overflow-y: hidden;
					overflow-x: hidden;
				}
				
				.mobile-box .mobile-navbar {
					position: absolute;
					top: 0px;
					left: 0px;
					right: 0px;
					height: 38px;
					line-height: 38px;
					text-align: center;
					background: #fff;
				}
				
				.mobile-box .mobile-content {
					position: absolute;
					top: 38px;
					left: 0;
					right: 0;
					bottom: 0;
					overflow-y: auto;
					overflow-x: hidden;
				}
				
				.mobile-box .mobile-content::-webkit-scrollbar {
					width: 2px;
				}
				
				.content-block.header-block {
					height: 89px;
					padding: 1rem;
					background-size: cover;
					background-position: center;
				}
				
				.content-block.menu-block {
					margin: .25rem 0 1rem;
				}
				
				.right-box .order-list>div {
					border: 1px solid #e3e3e3;
					cursor: pointer;
				}
				
				.right-box .order-list>div:hover {
					background: #f6f8f9;
				}
				
				.right-box .order-list>div:last-child {
					border-right-width: 1px;
				}
				
				.right-box .menu-box {
					border: 1px solid #e3e3e3;
				}
				
				.right-box .menu-box .menu-header {
					padding: .5rem;
					margin-top: -10px;
				}
				
				.right-box .menu-box .menu-list {
					padding: .5rem;
					background: #f6f8f9;
				}
				
				.right-box .menu-box .menu-item {
					background: #fff;
					padding: .5rem;
				}
				
				.panel-body {
					overflow: hidden!important;
				}
				/*.panel{background-color: rgb(245, 247, 249);}*/
				
				.panel .panel-header {
					border-bottom: 1px solid #eee;
					padding: 1rem;
				}
				
				.panel .panel-body {
					padding: 0;
					background-color: #fff;
					padding: 35px 30px;
				}
				
				.input_a {
					background-color: #2890FF;
					height: 30px;
					width: 80px;
					margin-left: 20px;
				}
				
				.input_a>a {
					color: #fff
				}
				/* .input_border>a{color:#2890FF} */
				
				.input_border>a:hover {
					color: #2890FF;
				}
				
				.input_text {
					height: 36px;
				}
				
				.input_border {
					border: 1px solid #D5DBE8;
					border-radius: 2PX;
					background-color: #fff;
					color: #2890FF;
					height: 30px;
					width: 80px;
					margin-left: 10px;
				}
				
				.btn-secondary {
					background-color: #2890FF;
					border: none;
				}
				
				.delete_img {
					width: 120px;
					height: 120px;
					border: 1px solid #D5DBE8;
					position: relative;
				}
				
				.delete_img>img {
					width: 100%;
					height: 40px;
					margin-top: 30%;
				}
				
				.upload-preview {
					line-height: 20px;
					border: none;
					height: 156px;
				}
				
				.delete_p {
					width: 120px;
					text-align: center;
					font-size: 14px;
					color: #97A0B4;
					margin: 0;
				}
				
				.btn-secondary {
					width: 20px;
					height: 20px;
					background-color: #eee;
					padding: 0;
				}
				
				.btn-secondary:hover {
					background-color: #eee;
				}
				
				.delete_span {
					width: 20px;
					height: 20px;
					position: absolute;
					bottom: 1px;
					right: 0;
				}
				
				.input_flex {
					display: flex;
					justify-content: flex-start;
					align-items: center;
				}
				
				.text-height {
					line-height: 156px;
				}
				
				.text-right {
					padding: 0 12px;
					font-size: 14px;
					color: #414658;
				}
				
				.radio-label input[type=radio]~.label-icon {
					width: 14px;
					height: 14px;
				}
				
				.radio-label input[type=radio]~.label-text {
					font-size: 14px;
					color: #414658;
				}
				
				.form-group {
					margin-bottom: 40px;
				}
				
				.text_center_f {
					float: left;
					margin-bottom: 40px;
					width: 100px;
					height: 80px;
					margin-right: 20px;
					line-height: 38px;
					text-align: center;
					border: 1px solid #D5DBE8;
				}
				
				.pl-3 {
					padding: 0!important;
					width: 100%;
					text-align: center;
					font-size: 16px;
					color: #414658;
				}
				
				.right-box .menu-box {
					border: none;
				}
				
				.right-box .menu-box .menu-list {
					background-color: #fff;
				}
				
				.menu-list>div>span:after {
					display: block;
					content: '';
					clear: both;
				}
				
				.clear_both {
					justify-content: flex-end;
					padding-right: 10%;
				}
				
				.btn-primary {
					width: 112px;
					height: 29px;
					background-color: #2890FF;
					border-radius: 2px;
					border: none;
					line-height: 29px;
					padding: 0;
				}
				
				.btn-primary:hover {
					background-color: #2890FF;
					border-radius: 2px;
				}
				
				.input_clear {
					width: 112px;
					height: 36px;
					border: 1px solid #2890FF;
					border-radius: 2px;
					margin-right: 10px;
					line-height: 25px;
				}
				
				.input_a_l>a {
					font-size: 12px;
					color: #999999;
				}
				
				.input_a_l>a:hover {
					color: #2890FF;
					text-decoration: none;
				}
				
				.border_a {
					padding-right: 5px;
					border-right: 1px solid #D5DBE8;
				}
				.row {margin:0;}
			</style>
		
	{/literal}


	<body class="body_bgcolor">
		<div class="main-body">
			{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}

			<div class="panel mb-3 page_bgcolor sewo" id="app" style="display: none">
			 {include file="../../include_path/nav.tpl" sitename="面包屑"} 
			 {literal}
				<div class="pd-20 page_absolute" >
					<form class="page_absolute page_forn" method="post" style="padding: 20px;">

						<div class="row row_h">
							<div class="left-box" style="margin: 20px;">
								<div class="mobile-box">
									<div class="mobile-screen">
										<div class="mobile-navbar">用户中心</div>
										<div class="mobile-content">
											<div class="content-block header-block" :style="c_user_center_bg">
												<div flex="dir:left box:first" v-if="top_style == 0">
													<div>
														<div style="display: inline-block;border: 2px solid #fff;background: #e3e3e3;width: 35px;height: 35px;border-radius: 999px"></div>
													</div>
													<div style="font-weight: bold;color: #fff;padding: .5rem 1rem">用户昵称</div>
												</div>
												<div flex="dir:left main:center" v-if="top_style == 1">
													<div class="text-center">
														<div style="display: inline-block;border: 2px solid #fff;background: #e3e3e3;width: 35px;height: 35px;border-radius: 999px"></div>
														<div style="font-weight: bold;color: #fff;">用户昵称</div>
													</div>
												</div>
												<div flex="dir:left box:first cross:center" v-if="top_style == 2" style="background-color: #fff;margin-top: 20px;border-radius: 5px;height: 44px;;">
													<div style="display: inline-block;border: 2px solid #fff;background: #e3e3e3;width: 35px;height: 35px;border-radius: 999px"></div>
													<div style="font-weight: bold;padding: .5rem 1rem">用户昵称</div>
												</div>
											</div>
											<div class="content-block order-block bg-white">
												<div style="padding: .35rem .75rem;border-bottom: 1px solid #eee">全部订单</div>
												<div flex="dir:left box:mean" v-if="orders">
													<div class="text-center pt-1 pb-1">
														<img :src="orders.status_0.icon" style="width: 17px;height: 16px">
														<div style="transform: scale(0.8);">{{orders.status_0.text}}</div>
													</div>
													<div class="text-center pt-1 pb-1">
														<img :src="orders.status_1.icon" style="width: 17px;height: 16px">
														<div style="transform: scale(0.8);">{{orders.status_1.text}}</div>
													</div>
													<div class="text-center pt-1 pb-1">
														<img :src="orders.status_2.icon" style="width: 17px;height: 16px">
														<div style="transform: scale(0.8);">{{orders.status_2.text}}</div>
													</div>
													<div class="text-center pt-1 pb-1">
														<img :src="orders.status_3.icon" style="width: 17px;height: 16px">
														<div style="transform: scale(0.8);">{{orders.status_3.text}}</div>
													</div>
													<div class="text-center pt-1 pb-1">
														<img :src="orders.status_4.icon" style="width: 17px;height: 16px">
														<div style="transform: scale(0.8);">{{orders.status_4.text}}</div>
													</div>
												</div>
											</div>
											<div class="content-block menu-block">
												<div flex="dir:left box:justify cross:center" v-if="menu_style == 0" v-for="(item,index) in menus" style="background: #fff;border-bottom: 1px solid #eee;padding: .25rem .5rem;">
													<div>
														<img :src="item.icon" style="width: 15px;height: 15px;">
													</div>
													<div class="pl-2">{{item.name}}</div>
												</div>
												<div flex="dir:left cross:center" v-if="menu_style == 1" style="background: #fff;border-bottom: 1px solid #eee;padding: .25rem .5rem;flex-wrap: wrap">
													<div class="text-center" v-for="(item,index) in menus" style="width: 25%;">
														<img :src="item.icon" style="width: 15px;height: 15px;">
														<div>{{item.name}}</div>
													</div>
												</div>
											</div>
											<div class="content-block copyright-block text-center" v-if="copyright">
												<img v-if="copyright.icon" :src="copyright.icon" style="height: 18px">
												<div class="fs-sm mb-2">{{copyright.text}}</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="right-box  col-sm-8">
								<div class="form-group row" style="margin: 20px 0 0;">
									<div class="form-group-label col-sm-2 text-right text-height">
										<label class="col-form-label">头部背景图片</label>
									</div>
									<div class="upload-group col-sm-10 input_flex row">
										<div class="input-group col-sm-8 row input_flex" style="height: 36px;">
											<input class="form-control file-input input_text col-sm- col-md-6 col-lg-6" name="user_center_bg" v-model.lazy="user_center_bg">
											<span class="input-group-btn input_a   col-sm-2 col-md-2 col-lg-2" style="height: 36px;line-height: 36px;">
                                       			<a class="btn select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" style="width: 100%;text-align: center;margin-left: 0;">
                                       				<span >选择文件</span>
											</a>
											</span>
											<span class="input-group-btn input_border input_border col-sm-2 col-md-2 col-lg-2" style="height: 36px;line-height: 36px;">
                                       			<a class="btn upload-file " href="javascript:" data-toggle="tooltip" data-placement="bottom" style="width: 100%;text-align: center;margin-left: 0;">
                                       				<span>上传文件</span>
											</a>
											</span>
										</div>
										<div class="upload-preview text-center upload-preview col-sm-3">
											<div class="delete_img">
												<img class="upload-preview-img" :src="user_center_bg" style="margin-top: 30%;">
												<span class="delete_span">
													<a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom">
														<img src="images/icon1/del.png"/>
													</a>
												</span>
											</div>
											<p class="delete_p">顶部效果预览</p>
											<p class="delete_p">尺寸：750&times;348</p>

										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="form-group-label col-sm-2 text-right">
										<label class="col-form-label">文字颜色</label>
									</div>
									<div class="col-sm-6" style="max-width: 360px">
										<label class="radio-label">
                                                <input id="radio1" :checked="top_style==0?'checked':''" value="0" name="top_style" type="radio" class="custom-control-input"
                                                 v-model="top_style">
                                                <span class="label-icon"></span>
                                                <span class="label-text">样式一</span>
                                            </label>
										<label class="radio-label">
                                                <input id="radio1" :checked="top_style==1?'checked':''" value="1" name="top_style" type="radio" class="custom-control-input"
                                                 v-model="top_style">
                                                <span class="label-icon"></span>
                                                <span class="label-text">样式二</span>
                                            </label>
										<label class="radio-label">
                                                <input id="radio1" :checked="top_style==2?'checked':''" value="2" name="top_style" type="radio" class="custom-control-input"
                                                 v-model="top_style">
                                                <span class="label-icon"></span>
                                                <span class="label-text">样式三</span>
                                            </label>
									</div>
								</div>

								<div class="form-group row">
									<div class="form-group-label col-sm-2 col-md-2 text-right">
										<label class="col-form-label">订单栏</label>
									</div>
									<div class="col-sm-10 col-md-10">
										<div class="order-list" v-if="orders">
											<div class="text-center text_center_f pt-1 pb-1 edit-order" data-index="status_0">
												<img :src="orders.status_0.icon" style="width: 32px;height: 32px">
												<div style="transform: scale(0.8);">{{orders.status_0.text}}</div>
											</div>
											<div class="text-center text_center_f pt-1 pb-1 edit-order" data-index="status_1">
												<img :src="orders.status_1.icon" style="width: 32px;height: 32px">
												<div style="transform: scale(0.8);">{{orders.status_1.text}}</div>
											</div>
											<div class="text-center text_center_f pt-1 pb-1 edit-order" data-index="status_2">
												<img :src="orders.status_2.icon" style="width: 32px;height: 32px">
												<div style="transform: scale(0.8);">{{orders.status_2.text}}</div>
											</div>
											<div class="text-center text_center_f pt-1 pb-1 edit-order" data-index="status_3">
												<img :src="orders.status_3.icon" style="width: 32px;height: 32px">
												<div style="transform: scale(0.8);">{{orders.status_3.text}}</div>
											</div>
											<div class="text-center text_center_f pt-1 pb-1 edit-order" data-index="status_4">
												<img :src="orders.status_4.icon" style="width: 32px;height: 32px">
												<div style="transform: scale(0.8);">{{orders.status_4.text}}</div>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<div class="form-group-label col-sm-2 text-right">
										<label class="col-form-label">菜单栏</label>
									</div>
									<div class="col-sm-10">
										<div class="menu-box">

											<div class="menu-list">
												<draggable :list="menus" :options="{animation: 200,}">
													<transition-group name="list-complete">
														<div class="menu-item text_center_f" v-for="(item,index) in menus" :key="index">

															<img :src="item.icon" style="width: 32px;height: 32px;">

															<div class="pl-3">{{item.name}}</div>
															<div class="input_a_l" style="display: none;">
																<a :data-index="index" href="javascript:" class="edit-menu border_a">编辑</a>
																<a :data-index="index" href="javascript:" class="delete-menu">删除</a>
															</div>
														</div>
													</transition-group>
												</draggable>
											</div>
											<div class="menu-header clearfix">
												<a class="" href="javascript:" data-toggle="modal" data-target=".add-menu-modal">添加</a>
											</div>
										</div>
									</div>
								</div>

								<template v-if="copyright && false">
									<div class="form-group row">
										<div class="form-group-label col-sm-2 text-right">
											<label class="col-form-label">底部版权文字</label>
										</div>
										<div class="col-sm-6" style="max-width: 360px">
											<input class="form-control" v-model="copyright.text">
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-2 text-right">
											<label class="col-form-label">底部版权图标</label>
										</div>
										<div class="col-sm-6" style="max-width: 360px">
											<div class="upload-group">
												<div class="input-group">
													<input class="form-control file-input" name="copyright_icon" v-model.lazy="copyright.icon">
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="上传文件">
                                                                <span class="iconfont icon-cloudupload"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="从文件库选择">
                                                                <span class="iconfont icon-viewmodule"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="删除文件">
                                                                <span class="iconfont icon-close"></span>
													</a>
													</span>
												</div>
												<div class="upload-preview text-center upload-preview">
													<span class="upload-preview-tip">240&times;60</span>
													<img class="upload-preview-img" :src="copyright.icon">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-2 text-right">
											<label class="col-form-label">底部版权链接</label>
										</div>
										<div class="col-sm-6" style="max-width: 360px">
											<div class="input-group page-link-input">
												<input class="form-control link-input" readonly name="copyright_url" v-model="copyright.url">
												<input class="link-open-type" name="copyright_open_type" v-model="copyright.open_type" type="hidden">
												<span class="input-group-btn">
                                                        <a class="btn btn-secondary pick-link-btn" href="javascript:">选择链接</a>
                                                    </span>
											</div>
										</div>
									</div>
								</template>

								

							</div>

						</div>
						<div class="page_out page_bort">
									<div class="ta_btn4">
										<a class="btn input_clear" href="javascript:" onclick="_reload()">取消</a>
									</div>
									<div class="ta_btn3" >
										<a class="btn btn-primary save-user-center" style="height: 36px;line-height: 36px;" href="javascript:">保存</a>
									</div>
							<div class="page_h2"></div>
						</div>
					</form>
					<div class="page_h20"></div>

					<!-- 我的钱包 -->
					<div class="modal edit-wallet-modal" data-backdrop="static" style="z-index: 1041">
						<div class="modal-dialog" role="document">
							<div class="panel">
								<div class="panel-header">
									<span>我的钱包编辑</span>
									<a href="javascript:" class="panel-close" data-dismiss="modal">×</a>
								</div>
								<div class="panel-body" v-if="edit_wallet">

									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
											<label class="col-form-label required">标识</label>
										</div>
										<div class="col-sm-9">
											<span v-if="edit_wallet.id==='wallet'">我的钱包</span>
											<span v-if="edit_wallet.id==='integral'">积分</span>
											<span v-if="edit_wallet.id==='balance'">余额</span>
										</div>
									</div>

									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
											<label class="col-form-label required">名称</label>
										</div>
										<div class="col-sm-9">
											<input class="form-control" v-model.lazy="edit_wallet.text">
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
											<label class="col-form-label required">图标</label>
										</div>
										<div class="col-sm-9">
											<div class="upload-group">
												<div class="input-group">
													<input class="form-control file-input" v-model.lazy="edit_wallet.icon" name="edit_wallet_icon">
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="上传文件">
                                                                <span class="iconfont icon-cloudupload"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="从文件库选择">
                                                                <span class="iconfont icon-viewmodule"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="删除文件">
                                                                <span class="iconfont icon-close"></span>
													</a>
													</span>
												</div>
												<div class="upload-preview text-center upload-preview">
													<span class="upload-preview-tip">60&times;57</span>
													<img class="upload-preview-img" :src="edit_wallet.icon">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
										</div>
										<div class="col-sm-9">
											<a class="btn btn-primary edit-wallet-save" href="javascript:">确认</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="modal edit-order-modal" data-backdrop="static" style="z-index: 1041">
						<div class="modal-dialog" role="document">
							<div class="panel">
								<div class="panel-header">
									<span>订单栏图标编辑</span>
									<a href="javascript:" class="panel-close" data-dismiss="modal">×</a>
								</div>
								<div class="panel-body" v-if="edit_order">
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
											<label class="col-form-label required">名称</label>
										</div>
										<div class="col-sm-9">{{edit_order.text}}</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
											<label class="col-form-label required">图标</label>
										</div>
										<div class="col-sm-9">
											<div class="upload-group">
												<div class="input-group">
													<input class="form-control file-input" v-model.lazy="edit_order.icon" name="edit_order_icon">
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="上传文件">
                                                                <span class="iconfont icon-cloudupload"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="从文件库选择">
                                                                <span class="iconfont icon-viewmodule"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="删除文件">
                                                                <span class="iconfont icon-close"></span>
													</a>
													</span>
												</div>
												<div class="upload-preview text-center upload-preview">
													<span class="upload-preview-tip">60&times;57</span>
													<img class="upload-preview-img" :src="edit_order.icon">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right">
										</div>
										<div class="col-sm-9">
											<a class="btn btn-primary edit-order-save" href="javascript:">确认</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="modal add-menu-modal" data-backdrop="static" style="z-index: 1041">
						<div class="" role="document" style="height: 100%;width: 100%;display: flex;">
							<div class="panel" style="height: 600px;width: 800px;overflow: auto;margin: auto;">
								<div class="panel-header">
									<span>添加菜单</span>
									<a href="javascript:" class="panel-close" data-dismiss="modal">×</a>
								</div>
								<div class="panel-body clearfix">
									<div style="background: #f6f8f9;padding: .5rem">
										<div flex="dir:left box:justify cross:center" style="padding: .5rem;background: #fff;margin: .25rem 0" v-if="menu_list" v-for="(item,index) in menu_list">
											<div>
												<img :src="item.icon" style="width: 21px;height: 21px;display: inline-block">
											</div>
											<div class="pl-3">{{item.name}}</div>
											<div>
												<a href="javascript:" class="add-menu" :data-index="index">添加</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal edit-menu-modal" data-backdrop="static" style="z-index: 1041;">
						<div class="" role="document" style="width: 100%;height: 100%;display: flex;">
							<div class="panel" style="width: 800px;margin: auto;">
								<div class="panel-header">
									<span>菜单编辑</span>
									<a href="javascript:" class="panel-close" data-dismiss="modal">×</a>
								</div>
								<div class="panel-body" v-if="edit_menu">
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right" style="max-width: 100px!important;">
											<label class="col-form-label required">名称</label>
										</div>
										<div class="col-sm-9" style="max-width: 650px!important;flex: auto;">
											<input class="form-control" v-model.lazy="edit_menu.name">
										</div>
									</div>
									<div class="form-group row" v-if="edit_menu.id=='fenxiao'">
										<div class="form-group-label col-sm-3 text-right">
											<label class="col-form-label required">名称2<br></label>
										</div>
										<div class="col-sm-9">
											<input class="form-control" v-model.lazy="edit_menu.name_1">
										</div>
									</div>
									<div class="form-group row">
										<div class="form-group-label col-sm-3 text-right" style="max-width: 100px!important;">
											<label class="col-form-label required">图标</label>
										</div>
										<div class="col-sm-9" style="max-width: 650px!important;flex: auto;">
											<div class="upload-group">
												<div class="input-group">
													<input class="form-control file-input" v-model.lazy="edit_menu.icon" name="edit_menu_icon">
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="上传文件" style="padding-top: 7px;">
                                                                <span class="iconfont icon-cloudupload"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="从文件库选择" style="padding-top: 7px;">
                                                                <span class="iconfont icon-viewmodule"></span>
													</a>
													</span>
													<span class="input-group-btn">
                                                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                             title="删除文件" style="padding-top: 7px;">
                                                                <span class="iconfont icon-close"></span>
													</a>
													</span>
												</div>
												<div class="upload-preview text-center upload-preview" style="width: 80px;height: 80px;padding: 0;border: 1px solid #ddd;">
													<span class="upload-preview-tip" style="bottom: 0;top: auto;left: auto;right: 5px;">50&times;50</span>
													<img class="upload-preview-img" style="display: block;margin-top: 5px;" :src="edit_menu.icon">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row" style="margin-bottom: 0;">
										<div class="form-group-label col-sm-3 text-right">
										</div>
										<div class="col-sm-9">
											<a class="btn btn-primary edit-menu-save ta_btn4" href="javascript:">确认</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<script>
				
				var app = new Vue({
					el: '#app',
					data: {
						user_center_bg: null,
						orders: null,
						// wallets: null,
						menus: null,
						edit_order: null,
						edit_wallet: null,
						edit_menu: null,
						menu_list: null,
						copyright: null,
						menu_style: null,
						top_style: null,
						is_wallet: null,
						is_order: null,
						manual_mobile_auth: null,
					},
					computed: {
						c_user_center_bg: function() {
							return this.user_center_bg ? 'background-image:url(' + this.user_center_bg + ');' : '';
						}
					},
				});
				$('#app').show();
				var edit_order_index = null;
				var edit_wallet_index = null;
				var edit_menu_index = null;

				$.ajax({
					url: 'index.php?module=software&action=userflex&m=link',
					dataType: 'json',
					success: function(res) {
						app.user_center_bg = res.data.user_center_bg;
						app.orders = res.data.orders;
						// app.wallets = res.data.wallets;
						app.menus = res.data.menus;
						app.copyright = res.data.copyright;
						app.menu_list = res.menu_list;
						app.menu_style = res.data.menu_style;
						app.top_style = res.data.top_style;
						app.is_wallet = res.data.is_wallet;
						app.is_order = res.data.is_order;
						app.manual_mobile_auth = res.data.manual_mobile_auth;
						$("html").getNiceScroll().resize();
						$("body").niceScroll();
						$(".mobile-content").niceScroll();
					}
				});

				$(document).on('change', 'input[name="user_center_bg"]', function() {
					app.user_center_bg = $(this).val();
				});
				$(document).on('change', 'input[name="edit_order_icon"]', function() {
					app.edit_order.icon = $(this).val();
				});
				$(document).on('change', 'input[name="edit_menu_icon"]', function() {
					app.edit_menu.icon = $(this).val();
				});
				$(document).on('change', 'input[name="copyright_icon"]', function() {
					app.copyright.icon = $(this).val();
				});
				$(document).on('change', 'input[name="copyright_url"]', function() {
					app.copyright.url = $(this).val();
				});
				$(document).on('change', 'input[name="copyright_open_type"]', function() {
					app.copyright.open_type = $(this).val();
				});

				$(document).on('change', 'input[name="edit_wallet_icon"]', function() {
					app.edit_wallet.icon = $(this).val();
				});

				$(document).on('click', '.edit-order', function() {
					edit_order_index = $(this).attr('data-index');
					app.edit_order = JSON.parse(JSON.stringify(app.orders[edit_order_index]));
					$('.edit-order-modal').modal('show');
				});

				$(document).on('click', '.edit-order-save', function() {
					for(var i in app.edit_order) {
						app.orders[edit_order_index][i] = app.edit_order[i];
					}
					$('.edit-order-modal').modal('hide');
				});
				$(document).on('mouseenter', '.text_center_f', function() {
					$(this).find('.input_a_l').css('display', 'block')
					console.log()
				});
				$(document).on('mouseleave', '.text_center_f', function() {
					$(this).find('.input_a_l').css('display', 'none')
					console.log()
				});


				$(document).on('click', '.add-menu', function() {
					var index = parseInt($(this).attr('data-index'));
					app.menus.push(app.menu_list[index]);
					$('.add-menu-modal').modal('hide');
				});
				$(document).on('click', '.delete-menu', function() {
					var index = parseInt($(this).attr('data-index'));
					app.menus.splice(index, 1);
				});
				$(document).on('click', '.edit-menu', function() {
					edit_menu_index = parseInt($(this).attr('data-index'));
					app.edit_menu = JSON.parse(JSON.stringify(app.menus[edit_menu_index]));
					$('.edit-menu-modal').modal('show');
				});
				$(document).on('click', '.edit-menu-save', function() {
					for(var i in app.edit_menu) {
						app.menus[edit_menu_index][i] = app.edit_menu[i];
					}
					$('.edit-menu-modal').modal('hide');
				});

				$(document).on('click', '.save-user-center', function() {
					var btn = $(this);
					 var text_name = $(this).parents('.sewo').children(".breadcrumb").children("a").text();
					btn.btnLoading(btn.text());
					$.ajax({
						type: 'post',
						dataType: 'json',
						data: {
							_csrf: _csrf,
							data: JSON.stringify({
								user_center_bg: app.user_center_bg,
								orders: app.orders,
								// wallets: app.wallets,
								menus: app.menus,
								copyright: app.copyright,
								menu_style: app.menu_style,
								top_style: app.top_style,
								is_wallet: app.is_wallet,
								is_order: app.is_order,
								manual_mobile_auth: app.manual_mobile_auth,
							}),
						},
						success: function(res) {
							console.log(1)
							$.alerts({
								content: res.msg,
								title:text_name,
								confirm: function() {
									console.log(12)
									if(res.code == 0) {
										location.reload();
									} else {
										btn.btnReset();
									}
								}
							});
						}
					});
				});
				
				
				
			</script>
			{/literal}
			 {include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
		</div>
		</div>
		
		

	</body>

</html>
