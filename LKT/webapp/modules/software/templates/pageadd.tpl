<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>图片魔方编辑</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
	</head>

	<body>
		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
		<div class="main-body">
			<div class="panel mb-3 page_bgcolor" id="app">
				{include file="../../include_path/nav.tpl" sitename="面包屑"} {literal}
				<div class="panel-body pd-20 page_absolute">
					<form method="post" return="index.php?module=software&amp;action=pageindex" class="auto-form page_absolute">
						<div class="form-group row" style="padding-top: 20px;">
							<div class="form-group-label col-sm-2 text-right"><label class="col-form-label required">默认样式</label></div>
							<div class="col-sm-8"><img src="style/diy_img/img-block-demo.png" class="mb-3" style="width: 100%; border: 1px solid rgb(238, 238, 238);">
								<div class="alert alert-info rounded-0">单图的图片高度不限定，高度根据原图比例自动调整</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right"><label class="col-form-label required">样式一</label></div>
							<div class="col-sm-8"><img src="style/diy_img/img-block-demo-1.png" class="mb-3" style="width: 100%; border: 1px solid rgb(238, 238, 238);"></div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right"><label class="col-form-label required">样式二</label></div>
							<div class="col-sm-8"><img src="style/diy_img/img-block-demo-2.png" class="mb-3" style="width: 100%; border: 1px solid rgb(238, 238, 238);"></div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right"><label class="col-form-label required">板块名称</label></div>
							<div class="col-sm-8"><input type="text" name="name" value="" class="form-control"></div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right"><label class="col-form-label">板块图片</label></div>
							<div class="col-sm-8">
								<div class="row mb-3">
									<div class="col-sm-5">
										<div class="upload-group">
											<div class="input-group"><input index="0" name="pic_list[0][pic_url]" class="form-control file-input"> <span class="input-group-btn"><a href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" class="btn btn-secondary upload-file" data-original-title="上传文件"><span class="iconfont icon-cloudupload"></span></a>
												</span> <span class="input-group-btn"><a href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" class="btn btn-secondary select-file" data-original-title="从文件库选择"><span class="iconfont icon-viewmodule"></span></a>
												</span> <span class="input-group-btn"><a href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" class="btn btn-secondary delete-file" data-original-title="删除文件"><span class="iconfont icon-close"></span></a>
												</span>
											</div>
											<div class="upload-preview text-center upload-preview"><span class="upload-preview-tip">大小参考示例</span> <img src="" class="upload-preview-img"></div>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="input-group page-link-input"><input readonly="readonly" index="0" name="pic_list[0][url]" value="" class="form-control link-input"> <input index="0" name="pic_list[0][open_type]" type="hidden" class="link-open-type"> <span class="input-group-btn"><a href="javascript:" open-type="navigate,wxapp" class="btn btn-secondary pick-link-btn">选择链接</a></span></div>
									</div>
									<div class="col-sm-2 text-right">
										<a data-index="0" href="javascript:" class="btn btn-danger pic-delete">删除</a>
									</div>
								</div>
								<a href="javascript:" class="btn btn-secondary add-pic">添加</a>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right"><label class="col-form-label">板块样式</label></div>
							<div class="col-sm-6"><label class="radio-label"><input id="radio1" checked="checked" value="0" name="style" type="radio" class="custom-control-input"> <span class="label-icon"></span> <span class="label-text">默认样式</span></label>
								<!---->
								<!---->
							</div>
						</div>
						<div class=" row_cl" style="border-top: 1px solid #ddd;">
							<!--<div class="form-group-label col-sm-2 text-right"></div>-->
							<div class="col-sm-6" style="max-width: 100%;flex: auto;">
								<!--<input name="_csrf" value="wxsUlGbQdM0LdP03a5PcMeF1Gop7cn1rOiGcbf7eP9sxqXZpJa1wRz61ddcjko0K24XBgusPj4sX9WPldq_Fhg==" type="text" style="display: none" class="ta_btn4"></form>-->
								<input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回" class="ta_btn4 ta_btn5">
								<a href="javascript:" class="btn btn-primary auto-form-btn2 ta_btn4">保存</a> 
							</div>
						</div>
						<div class="page_h2"></div>
				{/literal}
				<div class="page_h20" style="display: block;"></div>
			</div>

		</div>

		</div>
		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
	</body>

</html>