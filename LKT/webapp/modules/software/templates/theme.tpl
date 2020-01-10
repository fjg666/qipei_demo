<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>小程序标题设置</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
		
		{literal}
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
			}
			
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
			
			.panel {
				background-color: #edf1f5;
				padding: 0px;
			}
			
			.panel .panel-body {
				padding: 10px 20px
			}
			
			.panel .panel-header {
				border: none;
				font-size: 16px;
			}
			
			.text-right {
				width: 100%;
				position: relative;
			}
			
			.file-input,
			.input_fy {
				width: 572px;
				height: 36px;
				border: 1px solid #D5DBE8;
				border-radius: 2PX;
			}
			
			.btn-secondary:hover {
				background-color: #2890FF;
				color: #fff;
			}
			
			.btn-secondary.btn-loading:after {
				background-image: '';
				border-radius: 2PX;
				color: #fff;
			}
			
			.btn-secondary {
				color: #fff;
			}
			
			.btn-secondary {
				background-color: #2890FF;
			}
			
			.input_a {
				background-color: #2890FF;
			}
			
			.input_a>a {
				color: #fff
			}
			
			.input-group-btn {
				width: 80px;
				line-height: 30px;
				margin-left: 20px;
			}
			
			.input_border {
				border: 1px solid #D5DBE8;
				border-radius: 2PX;
			}
			
			.upload-preview {
				position: absolute;
				right: 3%;
				top: 0;
				margin: 0;
				z-index: 50;
				border: none;
				width: 122px;
				height: 160px;
			}
			
			.upload-preview .upload-preview-img {
				width: 91px;
				height: 75px;
			}
			
			.upload-preview .upload-preview-tip {
				bottom: 0;
				line-height: 10px;
			}
			
			.upload-preview {
				line-height: 14px;
			}
			
			.form-group {
				background-color: #fff;
				padding: 10px 20px 30px 20px;
				border-radius: 4px;
			}
			
			.input-group .form-control {
				flex: 0 0 auto;
				padding: 0 6px;
			}
			
			.input-group .input_width {
				width: 300px;
			}
			
			.input-group .input_width_l {
				width: 550px;
			}
			
			.position_l {
				right: 17%;
			}
			
			.border_img {
				width: 120px;
				height: 120px;
				border: 1px solid #D5DBE8;
				border-radius: 2px;
				padding: 25px;
				position: relative;
			}
			
			.border_img>span {
				position: absolute;
				width: 20px;
				height: 20px;
				bottom: 0;
				right: 0;
			}
			
			.border_img>span>a {
				width: 20px;
				height: 20px;
				padding: 0;
				border: none;
				margin-left: 0;
				background-color: #eee;
			}
			
			.font_l {
				font-size: 14px;
				color: #97A0B4;
				margin-top: 10px;
			}
			
			.input-group {
				margin-top: 20px;
				line-height: 14px;
			}
			
			.btn-danger {
				background-color: #fff;
				border: 1px solid #2890FF;
				color: #2890FF;
			}
			
			.font_f {
				color: #666666;
				font-size: 14px;
				padding-left: 20px;
			}
			
			.float_div {
				width: 100%;
			}
			
			.float_div:after {
				display: block;
				content: '';
				clear: both;
			}
			
			.float_l {
				float: right;
				margin-right: 20px;
			}
			
			.btn-primary {
				background-color: #2890FF;
				border-color: #2890FF
			}
			
			.btn-danger:hover {
				background-color: #fff;
				border: 1px solid #2890FF;
				color: #2890FF;
			}
			
			.btn-primary:hover {
				background-color: #2890FF;
				border-color: #2890FF
			}
			
			.breadcrumb {
				background: #fff;
			}
		</style>
		{/literal}
	</head>

	<body class="body_bgcolor">
		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
		<div class="main-body sewo">
			{include file="../../include_path/nav.tpl" sitename="面包屑"}
			<div class="panel mb-3">

				<div class="panel-body pd-20 page_absolute">

					<form class="auto-form page_absolute" method="post">

						{foreach from=$navs item=item key=key name=f1}
						<div class="form-group">
							<div class=" text-right">

								<div class="upload-group">
									<div class="input-group row">
										<span class="col-form-label col-sm-1 col-md-1 col-lg-1">标题名称：</span>
										<input type="text" name="model[{$key}][title]" class="form-control input_fy input_width col-sm-3 col-md-3 col-lg-3" value="{$item->title}">
										<input style="display: none;" name="model[{$key}][name]" value="{$item->name}">
									</div>
									<div class="input-group row">
										<span class="col-sm-1 col-md-1 col-lg-1">顶部图片：</span>
										<input index="0" value="{$item->top_img}" name="model[{$key}][top_img]" class="col-sm-5 col-md-5 col-lg-5 form-control file-input input_width_l">
										<span class="input-group-btn input_a col-sm-1 col-md-1 col-lg-1"><a
                                                href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                title="" class="btn  select-file"
                                        ><span>选择文件</span></a>
										</span>
										<span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1"><a
                                                href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                class="btn upload-file">上传文件</a></span>
									</div>
									<div class="upload-preview text-center upload-preview position_l">
										<div class='border_img'>
											{if $item->top_img}
											<img src="{$item->top_img}" class="upload-preview-img"> {else}
											<img src="images/class_noimg.jpg" class="upload-preview-img"> {/if}
											<span class="input-group-btn"><a style="margin-left: 0;"
                                                                         data-toggle="tooltip" data-placement="bottom"
                                                                         title="" class="btn delete-file"><img
                                                        src="images/icon1/del.png"/></a></span>
										</div>
										<p class="font_l">(顶部图片预览效果)</p>
									</div>
								</div>
								<div class="upload-group">
									<div class="input-group row">
										<span class="col-sm-1 col-md-1 col-lg-1">底部图片：</span>
										<input index="0" value="{$item->bottom_img}" name="model[{$key}][bottom_img]" class="col-sm-5 col-md-5 col-lg-5 form-control file-input input_width_l">
										<span class="input-group-btn input_a col-sm-1 col-md-1 col-lg-1"><a
                                                href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                title="" class="btn select-file"
                                        ><span>选择文件</span></a>
										</span>
										<span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1"><a
                                                href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                                title="" class="btn upload-file"
                                        ><span>上传文件</span></a>
										</span>
									</div>
									<div class="upload-preview text-center upload-preview ">
										<div class='border_img'>
											{if $item->bottom_img}
											<img src="{$item->bottom_img}" class="upload-preview-img"> {else}
											<img src="images/class_noimg.jpg" class="upload-preview-img"> {/if}
											<span class="input-group-btn"><a style="margin-left: 0;"
                                                                         data-toggle="tooltip" data-placement="bottom"
                                                                         title="" class="btn delete-file"
                                            ><img src="images/icon1/del.png"/></a></span>
										</div>
										<p class="font_l">(底部图片预览效果)</p>
									</div>
								</div>
							</div>
							
						</div>
						<div class="page_h16"></div>
						{/foreach}

						<div class=" row" style="padding: 20px;">
							<div class="form-group-label  text-right"></div>
							<div class="col-sm-12 font_f">
								<span>保存后需删除小程序重新登录、或者等小程序缓存自动失效(时间不确定)</span>
							</div>
						</div>
						<div class=" page_bort" style="padding:10px 0 20px;">
							<div class="form-group-label text-right"></div>
							<div class="float_div">
								
								<div class="btn btn-danger text-center cancel-group-list float_l ta_btn4"  onclick="_reload()">
									<a href="javascript:void(0);">取消</a>
								</div>
								<a class="btn btn-primary auto-form-btn2 float_l ta_btn3" href="javascript:">保存</a>
								<!-- <a class="btn btn-primary auto-form-btn" href="javascript:">保存</a>
                        <div class="btn btn-danger text-center cancel-group-list">取消</div> -->
							</div>
						</div>
						<div class="page_h16"></div>
					</form>

				</div>
			</div>
		</div>

		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
	</body>

</html>