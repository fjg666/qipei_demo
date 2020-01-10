<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>首页导航图标编辑</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
	</head>
	{literal}

	<style>
		html {
			/*隐藏滚动条，当IE下溢出，仍然可以滚动*/
			-ms-overflow-style: none;
		}
	</style>
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
			
			.panel {
				background-color: transparent;
			}
			
			.breadcrumb {
				margin: 0 16px;
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
			
			.auto_form {
				padding: 20px 0;
			}
			
			.mb-3 {
				margin-bottom: 0!important;
			}
			
			.ta_btn4 {
				background-color: white!important;
				border: 1px solid #2890FF!important;
				color: #2890FF!important;
			}
		</style>
	{/literal}	
	<body class="body_bgcolor">
		
		<div class="main-body">
			<div class="panel mb-3 sewo">

					<nav class="breadcrumb page_bgcolor">
								<span class="c-gray en"></span>
								<span style="color: #414658;">图片管理</span>
								<span class="c-gray en">&gt;</span>
						<a style="margin-top: 10px;" onclick="location.href='index.php?module=software&amp;action=navindex';">图标修改 </a>
					</nav>
				
				<div class="panel-body pd-20 page_absolute">
					<form class="auto-form auto_form" method="post" return="index.php?module=software&action=navindex">
						<input type="hidden" name="id" value="{$id}">
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">名称</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" type="text" name="model[name]" value="{$navs->name}">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">唯一标识</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" type="text" name="model[uniquely]" value="{$navs->uniquely}">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">排序</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" type="number" name="model[sort]" value="{$navs->sort}">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">图标</label>
							</div>
							<div class="col-sm-6">
								<div class="upload-group">
									<div class="input-group">
										<input class="form-control file-input" name="model[pic_url]" value="{$navs->pic_url}">
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
										<span class="upload-preview-tip">88&times;88</span>
										<img class="upload-preview-img" src="{$navs->pic_url}">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label">链接</label>
							</div>
							<div class="col-sm-6">
								<div class="input-group page-link-input">
									<input class="form-control link-input" readonly name="model[url]" value="{$navs->url}">
									<input class="link-open-type" name="model[open_type]" value="" type="hidden">

									<span class="input-group-btn">
                                            <a class="btn btn-secondary pick-link-btn" href="javascript:">选择链接</a>
                                        </span>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label">是否显示</label>
							</div>
							<div class="col-sm-6">
								<label class="radio-label">
                                        <input id="radio1" { if $navs->is_hide == 0}checked{/if} value="0" name="model[is_hide]" type="radio" class="custom-control-input">
                                        <span class="label-icon"></span>
                                        <span class="label-text">显示</span>
                                    </label>
								<label class="radio-label">
                                        <input id="radio2" { if $navs->is_hide == 1}checked{/if} value="1" name="model[is_hide]" type="radio" class="custom-control-input">
                                        <span class="label-icon"></span>
                                        <span class="label-text">隐藏</span>
                                    </label>
							</div>
						</div>

						<div class="form-group row page_footer" style="margin-bottom: 0;">
							<div class="col-sm-6 page_out" style="max-width: 100%!important;flex:auto;text-align: center;">

								<input type="button" class="btn btn-default ta_btn4" name="Submit" onclick="javascript:history.back(-1);" value="返回">
								<a class="btn btn-primary auto-form-btn2 ta_btn3" href="javascript:">保存</a>
							</div>
						</div>
					</form>
				</div>
				
			</div>
		</div>
		<!-- </div> -->
		
		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
	</body>

</html>
