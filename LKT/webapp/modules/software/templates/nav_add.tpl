<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>首页导航图标添加</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
	</head>

	<body class="body_bgcolor">
		

		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
		
		<div class="main-body" >
			<div class="panel  sewo page_bgcolor" >

					<nav class="breadcrumb page_bgcolor">
								<span class="c-gray en"></span>
								<span style="color: #414658;">图片管理</span>
								<span class="c-gray en">&gt;</span>
						<a style="margin-top: 10px;" onclick="location.href='index.php?module=software&amp;action=navindex';">图标添加 </a>
					</nav>
				
				{literal}
				<div class="panel-body pd-20 page_absolute">
					<form class="auto-form" method="post" return="index.php?module=software&action=navindex">
						<div class="form-group row" style="padding-top: 20px;">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">名称</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" type="text" name="model[name]" value="">
							</div>
						</div>
						<div class="form-group row" >
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">唯一标识</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" type="text" name="model[uniquely]" value="">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">排序</label>
							</div>
							<div class="col-sm-6">
								<input class="form-control" type="number" name="model[sort]" value="100">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">图标</label>
							</div>
							<div class="col-sm-6">
								<div class="upload-group">
									<div class="input-group">
										<input class="form-control file-input" name="model[pic_url]" value="">
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
										<img class="upload-preview-img" src="">
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
									<input class="form-control link-input" readonly name="model[url]" value="">
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
                                        <input id="radio1" checked value="0" name="model[is_hide]" type="radio" class="custom-control-input">
                                        <span class="label-icon"></span>
                                        <span class="label-text">显示</span>
                                    </label>
								<label class="radio-label">
                                        <input id="radio2" value="1" name="model[is_hide]" type="radio" class="custom-control-input">
                                        <span class="label-icon"></span>
                                        <span class="label-text">隐藏</span>
                                    </label>
							</div>
						</div>

						<div class=" page_footer">
							<!--<div class="form-group-label col-sm-2 text-right">
							</div>-->
							<div class="page_out">
								<input type="button" class="btn btn-default ta_btn4 ta_btn5" name="Submit" onclick="javascript:history.back(-1);" value="返回">
								<a class="btn btn-primary auto-form-btn2 ta_btn3 buttom_hover" href="javascript:">保存</a>
							</div>
						</div>
					</form>
				</div>
				{/literal}
			</div>
		</div>

		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
</body>

</html>
