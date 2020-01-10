<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>首页设置</title>

		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}

	</head>
	<body class="body_bgcolor">
		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
		<div class="main-body">
			<div class="panel mb-3 page_bgcolor sewo" id="app">
			
				{include file="../../include_path/nav.tpl" sitename="面包屑"}
				
				{literal}
				<div class="panel-body pd-20 page_absolute">
					<form class="page_absolute page_from" method="post">

						<div class="clearfix row page_absolute" style="margin: 0;padding: 30px 30px 0!important;">
							<div class="mobile-box">
								<div class="mobile-screen">
									<div class="mobile-navbar">商城首页</div>
									<div class="mobile-content">
										<ol class="edit-box" id="sortList">
											<li v-for="(item,i) in edit_list" class="module-item" v-bind:data-module-name="item.name">
												<div style="position: relative;height: 0;z-index:2;">
													<div class="operations">
														<a href="javascript:" class="operate-icon item-delete" v-bind:data-index="i">
															<img style="width: 16px;height: 16px" src="style/diy_img/icon-delete.png">
														</a>
														<a href="javascript:" class="operate-icon item-update" v-bind:data-name="item.name" v-if="item.name.indexOf('video') >= 0">
															<img style="width: 16px;height: 16px" src="style/diy_img/icon-edit.png">
														</a>
													</div>
												</div>
												<div v-html="item.content"></div>
											</li>
										</ol>
									</div>
								</div>
							</div>

							<div class="right-box col-sm-8">
								<div class="mb-3 all-module-list">
									<div class="panel_padding">可选模块</div>
									<div class="panel_float">
										<div v-for="(item,i) in module_list" class="module-item" v-bind:data-module-name="item.name">
											<div class='panel_module'>
												<span hidden>{{item.name}}</span>
												<div class="module-name">{{item.display_name}}</div>
												<div v-if="allow_list.indexOf(item.name) >= 0">
													<a href="javascript:" class="module-option item-add edit" v-bind:data-index="i">添加</a>
													<a href="javascript:" class="module-option item-update edit" v-bind:data-index="i">编辑</a>
												</div>
												<a v-else href="javascript:" class="module-option item-add" v-bind:data-index="i">添加</a>
											</div>
										</div>
									</div>
								</div>
								<div class="text-muted">
									<p>提示：图片魔方可以添加到小程序端，如果没有可以
										<a href="index.php?module=software&action=pageindex">点击这里添加图片魔方</a>；</p>
									<p class='text_padding'>首页更新小程序端下拉刷新就可以看到。</p>
								</div>
								
								
								
							</div>

							<div class="right-box" style="width: 766px;">
								<div class="panel mb-3 all-module-list" v-if="selected == 'topic'">
									<div class="panel-header">专题自定义</div>
									<div class="panel-body" style="padding-right: 15px;">
										<div class="form-group row">
											<div class="form-group-label col-sm-2 text-right">
												<label class="col-form-label">首页专题显示数量</label>
											</div>
											<div class="col-sm-6">
												<select class="form-control" name="topic[count]" v-model="update_list.topic.count">
													<option value="1">1</option>
													<option value="2">2</option>
												</select>
											</div>
										</div>

										<div class="form-group row">
											<div class="form-group-label col-sm-2 text-right">
												<label class="col-form-label">专题LOGO1</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="topic[logo_1]" data-index="logo_1" v-model="update_list.topic.logo_1">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">104&times;32</span>
														<img class="upload-preview-img" :src="update_list.topic.logo_1">
													</div>
												</div>
												<div>专题显示数量为1是显示</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-2 text-right">
												<label class="col-form-label">专题LOGO2</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="topic[logo_2]" data-index="logo_2" v-model="update_list.topic.logo_2">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">104&times;50</span>
														<img class="upload-preview-img" :src="update_list.topic.logo_2">
													</div>
												</div>
												<div>专题显示数量为2是显示</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-2 text-right">
												<label class="col-form-label">专题标签</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="topic[heated]" data-index="heated" v-model="update_list.topic.heated">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">54&times;28</span>
														<img class="upload-preview-img" :src="update_list.topic.heated">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="panel mb-3 all-module-list" v-if="selected == 'notice'">
									<div class="panel-header">公告自定义</div>
									<div class="panel-body" style="padding-right: 15px;">
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">公告名称</label>
											</div>
											<div class="col-sm-6">
												<input class="form-control" type="text" name="notice[name]" v-model="update_list.notice.name">

												<div class="text-danger fs-sm">建议：公告名称最好不要超过4个字</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">公告内容</label>
											</div>
											<div class="col-sm-6">
												<textarea class="form-control" type="text" rows="3" placeholder="请填写商城公告" name="notice" v-model="notice"></textarea>
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">公告背景色</label>
											</div>
											<div class="col-sm-6">
												<input type="color" name="notice[bg_color]" v-model="update_list.notice.bg_color">
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">公告文字颜色</label>
											</div>
											<div class="col-sm-6">
												<input type="color" name="notice[color]" v-model="update_list.notice.color">
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">公告图标</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="notice[icon]" data-index="icon" v-model="update_list.notice.icon">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">36&times;36</span>
														<img class="upload-preview-img" :src="update_list.notice.icon">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--视频自定义-->
								<div class="panel mb-3 all-module-list" :style="{display:selected=='video'?'block':'none'}">
									<div class="panel-header">视频自定义</div>
									<div class="panel-body" style="padding-right: 15px;">
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">视频链接</label>
											</div>
											<div class="col-sm-6">
												<div class="video-picker" data-url="style/index.php?r=upload%2Fvideo">
													<div class="input-group">
														<input class="video-picker-input video form-control img" name="video[][url]" v-model="video.url" data-index="video_url" placeholder="请输入视频源地址或者选择上传视频">
														<a href="javascript:" class="btn btn-secondary video-picker-btn">选择视频</a>
													</div>
													<div class="video-preview"></div>
													<div>
														<span class="text-danger">支持格式mp4;支持编码H.264;</span>
													</div>
													<div>
														<span class="text-success">支持腾讯视频;例如：https://v.qq.com/x/page/h056607xye8.html</span>
													</div>
													<div>
														<span class="text-danger">视频大小不能超过2 M</span>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">封面图</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="video[][pic_url]" v-model="video.pic_url" data-index="pic_url">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">750&times;400</span>
														<img class="upload-preview-img" :src="video.pic_url">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--优惠券自定义-->
								<div class="panel mb-3 all-module-list" v-if="selected == 'coupon'">
									<div class="panel-header">优惠券自定义</div>
									<div class="panel-body" style="padding-right: 15px;">
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">未领取图</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="coupon[bg]" v-model="update_list.coupon.bg" data-index="coupon_bg">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">750&times;400</span>
														<img class="upload-preview-img" :src="update_list.coupon.bg">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="form-group-label col-sm-3 text-right">
												<label class="col-form-label">已领取图</label>
											</div>
											<div class="col-sm-6">
												<div class="upload-group">
													<div class="input-group">
														<input class="form-control file-input img" name="coupon[bg_1]" v-model="update_list.coupon.bg_1" data-index="coupon_bg_1">
														<span class="input-group-btn">
																<a class="btn btn-secondary upload-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="上传文件">
																	<span class="iconfont icon-cloudupload"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary select-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="从文件库选择">
																	<span class="iconfont icon-viewmodule"></span>
														</a>
														</span>
														<span class="input-group-btn">
																<a class="btn btn-secondary delete-file"
                                                                   href="javascript:" data-toggle="tooltip"
                                                                   data-placement="bottom"
                                                                   title="删除文件">
																	<span class="iconfont icon-close"></span>
														</a>
														</span>
													</div>
													<div class="upload-preview text-center upload-preview">
														<span class="upload-preview-tip">750&times;400</span>
														<img class="upload-preview-img" :src="update_list.coupon.bg_1">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class='btn_div page_bort page_out page_absolute' style="margin: 0;">
							<a class="btn btn—border btn_div_l ta_btn4" href="javascript:" onclick="location.replace(location.href)">取消</a>
							<a class="btn btn-primary submit-btn ta_btn3" href="javascript:">保存</a>
							<div style="clear: both;"></div>
						</div>
						<div class="page_h2"></div>
					</form>
				</div>
				{/literal}
			</div>
		</div>
		</div>

		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}

		{literal}

		<script>
			
			
			var app = new Vue({
						el: "#app",
						data: {
							module_list: {/literal}{$module_list}{literal},
								edit_list: {/literal}{$home_page_data}{literal},
									allow_list: [],
									selected: '',
									update_list: {/literal}{$home_page_data}{literal},
										notice: "",
										selected_id: -1,
										video: ""
									}
								});
							$(document).on("click", ".item-add", function() {
								var index = $(this).attr("data-index");
								var list = app.module_list[index];
								var obj = JSON.parse(JSON.stringify(list));
								console.log(obj);
								if(obj.name == 'video') {
									var count = 0;
									$(app.edit_list).each(function(i) {
										if(app.edit_list[i].name.indexOf('video') != -1) {
											var arr = app.edit_list[i].name.split('-');
											if(parseInt(arr[1]) > count) {
												count = parseInt(arr[1]);
											}
										}
									});
									count += 1;
									obj.name = obj.name + '-' + count;
									var video_default = JSON.parse(JSON.stringify(app.update_list.video[0]));
									video_default['name'] = count;
									app.update_list.video.push(video_default);
								}
								// console.log(obj.name);
								app.edit_list.push(obj);
							});
							$(document).on("click", ".item-delete", function() {
								var index = $(this).attr("data-index");
								var item = $(this).parents(".module-item");
								var timeout = 200;
								item.slideUp(timeout, function() {
									item.addClass("delete");
									app.edit_list[index].delete = true;
								});
								var name = $(item).attr('data-module-name');
								var arr = name.split('-');
								var list = app.update_list.video;
								var new_list = [];
								$(list).each(function(i) {
									if(list[i].name == arr[1]) {
										return;
									} else {
										new_list.push(list[i]);
									}
								});
								app.update_list.video = new_list;
							});

							function removeArr(list, index) {
								var new_list = [];
								$(list).each(function(i) {
									if(i === index) {
										return;
									} else {
										new_list[i] = list[i];
									}
								});
								return new_list;
							}

							Sortable.create(document.getElementById("sortList"), {
								animation: 150,
							}); // That's all.

							$(document).on("click", ".submit-btn", function() {
								var module_list = [];
								 var text_name = $(this).parents('.sewo').children(".breadcrumb").children("a").text();
								$(".edit-box .module-item").each(function(i) {
									if($(this).hasClass("delete"))
										return;
									var name = $(this).attr("data-module-name");
									module_list.push({
										name: name,
									});
								});
								// app.update_list.video.splice(0, 1);
								var btn = $(this);
								var success = $(".form-success");
								var error = $(".form-error");
								success.hide();
								error.hide();
								btn.btnLoading(btn.text());
								$.ajax({
									type: "post",
									dataType: "json",
									data: {
										_csrf: _csrf,
										module_list: JSON.stringify(module_list),
										update_list: JSON.stringify(app.update_list),
										notice: app.notice
									},
									success: function(res) {
										$.alerts({
											content: res.msg,
											title:text_name,
											confirm: function() {
												if(res.code == 0) {
													location.reload();
												}
											}
										});
									}
								});
							});

							$(document).on('click', '.item-update', function() {
								var index = $(this).attr("data-index");
								if(index) {
									app.selected = app.module_list[index].name
								}
								var name = $(this).attr("data-name");
								if(name) {
									var arr = name.split('-');
									app.selected = arr[0];
									app.selected_id = arr[1];
									$(app.update_list.video).each(function(i) {
										if(app.update_list.video[i].name == arr[1]) {
											app.video = app.update_list.video[i];
										}
									});
								}
							});

							$(document).on('change', ".img", function() {
								var index = $(this).data('index');
								var val = $(this).val();
								if(index == 'logo_1') {
									app.update_list.topic.logo_1 = val;
								}
								if(index == 'logo_2') {
									app.update_list.topic.logo_2 = val;
								}
								if(index == 'heated') {
									app.update_list.topic.heated = val;
								}
								if(index == 'icon') {
									app.update_list.notice.icon = val;
								}
								if(index == 'pic_url') {
									$(app.update_list.video).each(function(i) {
										if(app.update_list.video[i].name == app.selected_id) {
											app.update_list.video[i].pic_url = val;
										}
									});
								}
								if(index == 'video_url') {
									$(app.update_list.video).each(function(i) {
										if(app.update_list.video[i].name == app.selected_id) {
											app.update_list.video[i].url = val;
										}
									});
								}
								if(index == 'coupon_bg') {
									app.update_list.coupon.bg = val;
								}
								if(index == 'coupon_bg_1') {
									app.update_list.coupon.bg_1 = val;
								}
							});
		</script>
		
		{/literal}

	</body>
</html>