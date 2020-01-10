
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />

	<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
	<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
	<link href="style/css/style.css" rel="stylesheet" type="text/css" />
	<!--<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />-->

	<title>拼团参数</title>
	{literal}
		<style type="text/css">
			.btn1 {
				height: 42px !important;
				padding: 0px 10px;
				line-height: 42px !important;
				width: 112px !important;
				display: flex;
				justify-content: center;
				align-items: center;
				color: #6a7076;
				background-color: #fff;
				font-size: 16px;
				border-right: 1px solid #ddd!important;

			}

			.active1 {
				color: #fff;
				background-color: #62b3ff;
			}


			.swivch a:hover {
				text-decoration: none;
				background-color:#2481e5!important;;
				color: #fff;
			}

			td a {
				margin:5px;
				float: left;
				padding: 3px 5px;
				height:auto;
			}
			td button {
				margin:4px 0 0 0;
				float: left;
				background: white;
				color:  #DCDCDC;
				border: 1px #DCDCDC solid;
				width:56px;
				height:22px;
			}
			#btn2{
				height: 36px;
				background-color: #77c037!important;
			}
			#btn2:hover{
				background-color: #57a821!important;
				border:1px solid #57a821!important;
			}
			form{
				padding: 0 !important;
				background: none !important;
			}

			.HuiTab{
				background-color: #fff;
				padding: 30px 10px;
			}
			.s-title{
				border-bottom: 2px #e0dfdf solid;
				height: 40px;
				line-height: 40px;
				padding: 5px 0 10px 20px;
				font-size: 16px;
				font-weight: bold;
				color: #666;
			}
			.row .form-label{
				width: 20% !important;
				height: 36px;
				line-height: 33px;
			}
			.unit{
				height: 36px;
				line-height: 33px;
			}
			.input-text[type="number"] {
				width: 350px !important;
			}
			.radio{
				margin: 0 20px;
			}
			.form .row {
				margin-top: 0px;
			}
			
			#left-text-box .left-text{
				width: 150px!important;
				padding-right: 0;
			}
			#left-text-box .row{
				margin-left: 0;
				margin-right: 0;
			}
			.form-horizontal .formControls{
				padding-left: 10px;
			}
			
			
			#left-text-box .radio_blue{
				display: block;
				width: 65px!important;
				padding-left: 20px;
				margin: auto; 
				height: 36px;
				line-height: 36px;
			}
		</style>
	{/literal}

</head>
<body style="background: #edf1f5;">

<nav class="breadcrumb" style="font-size: 16px">
	<span class="c-gray en"></span>
	<i class="Hui-iconfont">&#xe6ca;</i>
	插件管理
	<span class="c-gray en">&gt;</span>
	拼团
	<span class="c-gray en">&gt;</span>
	拼团设置
</nav>
<div class="swivch page_bgcolor swivch_bot" style="padding-left: 10px;display: flex;">
	<a href="index.php?module=go_group&action=Index&status=0" class="btn1" style="height: 42px !important;border-radius: 2px 0px 0px 2px !important;border:0!important;border-right: 1px solid #ddd!important;">拼团活动</a>
	<a href="index.php?module=go_group&action=Index&status=4" class="btn1" style="height: 42px !important;border:0!important;border-right: 1px solid #ddd!important;">开团记录</a>
	<a href="index.php?module=go_group&action=Index&status=5" class="btn1" style="height: 42px !important;border:0!important;border-right: 1px solid #ddd!important;">参团记录</a>
	<a href="index.php?module=go_group&action=Config" class="btn1 active1 swivch_active" style=" border-radius: 2px 0px 0px 2px !important;border:0!important;border-right: 1px solid #ddd!important;width: 112px !important;height: 42px !important;">拼团设置</a>

	<div class="clearfix" style="margin-top: 0px;"></div>
</div>
<div class="page_h16"></div>
<div id="left-text-box" class="page-container pd-20 form-scroll" style="padding: unset;margin-top: 65px;">
	<form name="form1" action="" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
		<div class="">
			<div class="page_title">基础设置</div>
{*			<input type="hidden" name="plug_ins_id" value="" placeholder="111" >*}
			<div id="tab-system" class="HuiTab">

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-4 left-text"><span style="color: red;">*</span>拼团限时：</label>
					<div class="formControls col-xs-8 col-sm-8">
						<input type="number" name="group_time" value="{$group_time}" class="input-text" placeholder="请输入限时时间">
						<span class="unit">小时</span>
					</div>

				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-4 left-text"><span style="color: red;">*</span>开团限制：</label>
					<div class="formControls col-xs-8 col-sm-8">
						<input type="number" name="open_num" value="{$open_num}" class="input-text" placeholder="请输入限制个数">
						<span class="unit">个</span>&nbsp;<span class="unit" style="color: #97A0B4;">（用户可开团的上限数量，拼团成功或拼团失败不计入开团数） </span>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-4 left-text"><span style="color: red;">*</span>参团限制：</label>
					<div class="formControls col-xs-8 col-sm-8">
						<input type="number" name="can_num" value="{$can_num}" class="input-text" placeholder="请输入限制个数">
						<span class="unit">次</span>&nbsp;<span class="unit" style="color: #97A0B4;">（用户参团上限数量，拼团成功或拼团失败不计入参团数） </span>
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-4 left-text">是否允许重复参团：</label>
					<div class="formControls col-xs-8 col-sm-8" style="display: flex;">
						<div class="radio" style="margin: 0;">
							<input type="radio" name="can_again" id="optionsRadios1" value="1" {if $can_again == '1'}checked{/if} style="display:none" class="inputC1"> 
							<label class="radio_blue" for="optionsRadios1">是</label>
						</div>
						<div class="radio" style="margin: 0;">
							<input type="radio" name="can_again" id="optionsRadios2" value="0" {if $can_again == '0'}checked{/if} style="display:none" class="inputC1">
							<label class="radio_blue" for="optionsRadios2">否</label>
						</div>
						<div class="radio">
							<label style="margin-top: .6rem;color: #97A0B4;">
								<div>（默认针对同一件商品）</div>
							</label>
						</div>
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-4 left-text">是否开启团长优惠：</label>
					<div class="formControls col-xs-8 col-sm-8" style="display: flex;">
						<div class="radio" style="margin: 0;">
							<input type="radio" name="open_discount" id="optionsRadios3" value="1" {if $open_discount == '1'}checked{/if} style="display:none" class="inputC1">
							<label class="radio_blue" for="optionsRadios3">是</label>
						</div>
						<div class="radio" style="margin: 0;">
							<input type="radio" name="open_discount" id="optionsRadios4" value="0" {if $open_discount == '0'}checked{/if} style="display:none" class="inputC1">
							<label class="radio_blue" for="optionsRadios4">否</label>
						</div>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-4 left-text"><span style="color: red;">*</span>轮播图设置：</label>
					<div class="formControls col-xs-8 col-sm-8" style="display: flex;align-items: center;">
{*						<div id="drop_area"></div>*}
{*						<div style="    margin: 25px;">轮播图尺寸（750*360px）</div>*}
							<div class="formInputSD">
								<div class="upload-group">
									<div class="input-group row" style="margin-left: -84px;margin-top: 2px;">
										<span class="col-sm-1 col-md-1 col-lg-1"></span>
										<input index="0" value="{$image}" name="image" class="col-sm-5 col-md-5 col-lg-5 form-control file-input input_width_l" style="width: 1008px;height: 36px;">
										<span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1" style="padding-left: 1px;">
                                        <a href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" class="btn upload-file" style="border: 0px solid transparent;">选择</a>
                                    </span>
									</div>
									<div class="upload-preview text-center upload-preview " style="top: 12px;left: -5px;width: 400px;height: 134px;border: 0px solid #e3e3e3;">
										<div class='border_img' style="">
											{if $image != ''}
												<img src="{$image}" class="upload-preview-img jkl" style="width: 169px;height: 134px;">
											{else}
												<img src="images/class_noimg.jpg" class="upload-preview-img jkl1" style="width: 169px;height: 134px;">
											{/if}
											<span class="font_l" style="line-height:134px;margin-left: 30px;color: #97A0B4;">（轮播图尺寸：750*360px）</span>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
				<div style="width: 100%;height: 11px;">

				</div>
			</div>


{*			<div class="row cl">*}
{*				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-4">*}
					<button class="btn btn-primary radius hidden form-btn" type="submit" name="Submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
{*					<button class="btn btn-default radius" type="reset">&nbsp;&nbsp;重置&nbsp;&nbsp;</button>*}
{*				</div>*}
{*			</div>*}

		</div>
		<div class="page_h16" style="height: 10px !important;"></div>
		{*border-left: 10px #edf1f5 solid;*}
		<div id="tab-system" class="HuiTab" style="padding: unset;display: flex;">
{*			<div style="width: 18px;background: #edf1f5;">*}

{*			</div>*}
			<div>
				<div class="page_title">
					规则设置
				</div>
				<div class="row cl" style="margin-bottom: 50px;    display: flex; width: 100%;   justify-content: left;padding-left: 30px;padding-top: 30px;">
					<div class="formControls col-xs-8 col-sm-10 codes">
						<script id="editor" type="text/plain" name="rule" style="width:105%;height:400px;">{$rule}</script>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div style="height: 20px;"></div>
</div>

<div class="page_bort">
	<button class="btn btn-primary radius btn-right" type="submit" name="Submit"  onclick="sbm()" style="float: right;"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
</div>
<div class="page_h16" style="height: 10px;"></div>

</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{literal}

	<script>

		function sbm(){
				console.log('click............1');

				var group_time = $("input[name='group_time']").val();
				console.log(group_time);
				var open_num = $("input[name='open_num']").val();
				console.log(open_num);
				var can_num = $("input[name='can_num']").val();
				console.log(can_num);
				var can_again = $("input[name='can_again']:checked").val();
				console.log(can_again);
				var open_discount = $("input[name='open_discount']:checked").val();
				console.log(open_discount);
				var image = $("input[name='image']").val();
				console.log(image);
			var ue = UE.getEditor('editor');
			var rule = ue.getContent();
				console.log(rule);

				if(group_time == ''){
					layer.msg("拼团时限不能为空！");
					return false
				}
				if(group_time <= 0){
					layer.msg("拼团时限必须为正整数！");
					return false

				}
				if(open_num == ''){
					layer.msg("开团数量不能为空！");
					return false

				}
				if(open_num <= 0){
					layer.msg("开团数量必须为正整数！");
					return false

				}
				if(can_num == ''){
					layer.msg("参团数量不能为空！");
					return false

				}
				if(can_num <= 0){
					layer.msg("参团数量必须为正整数！");
					return false

				}
			$.ajax({
				url:'?module=go_group&action=Config',//地址
				dataType:'json',//数据类型
				type:'POST',//类型
				data:{
					group_time:group_time,
					open_num:open_num,
					can_num:can_num,
					can_again:can_again,
					open_discount:open_discount,
					image:image,
					rule:rule,
				},
				timeout:2000,//超时
				//请求成功
				success:function(res){

					console.log("ajax_success");
					if(res.code==1){
						//成功
						layer.msg('设置成功！');
					}else{
						layer.msg('设置失败！');
					}
				},
				//失败/超时
				error:function(XMLHttpRequest,textStatus,errorThrown){
					console.log("ajax_error");
				}
			})
				// $(".form-btn").click();
		}

		$(function(){
			var ue = UE.getEditor('editor');

			$("input[name='imgurls[]']").on("change",function(e){
				var val = $(this).val();
				if (val.length > 0) {
					$('.form_new_file').css('display','none');
				}
			});

			$('.file-item-delete-pp').on('click',function(){
				$('.form_new_file').css('display','flex');
			})


		});
	</script>

{/literal}
</body>
</html>