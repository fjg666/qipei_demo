<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />

		<title>欢迎登录后台管理系统</title>

		<link rel="icon" href="style/loginSpecial/images/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="style/loginSpecial/images/favicon.ico" type="image/x-icon" />
		<link href="style/loginSpecial/css/default.css" rel="stylesheet" type="text/css" />
		<link href="style/loginSpecial/css/styles.css" rel="stylesheet" type="text/css" />
		<link href="style/loginSpecial/css/demo.css" rel="stylesheet" type="text/css" />
		<link href="style/loginSpecial/css/loaders.css" rel="stylesheet" type="text/css" />
		<script src="style/loginSpecial/js/jquery-2.1.1.min.js"></script>
		{literal}
		<style type="text/css">
			.sysyattr {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				z-index: 9999;
				background: rgba(0, 0, 0, 0.5);
			}
			
			.sysyattr_div {
				width: 100%;
				height: 100%;
				display: flex;
			}
			
			.sys_c {
				width: 35%;
				height: 50%;
				margin: auto;
				background: white;
				border-radius: 20px;
			}
			
			.modalshow {
				display: none;
			}
			
			.modaltitle {
				padding: 10px;
				width: 95%;
				height: 5%;
			}
			
			.bbgx_div {
				position: absolute;
				text-align: center;
				z-index: 101;
				width: 100%;
				text-align: center;
				left: 0%;
				top: 8%;
			}
			
			.bbgx_div bg {
				width: 29%;
				height: auto;
			}
			
			.bd_content {
				position: absolute;
				top: 50%;
				left: 35.5%;
				width: 29%;
				text-align: center;
			}
			
			.bd_content div:nth-of-type(1) {
				font-size: 28px;
				font-family: MicrosoftYaHei;
				font-weight: 400;
				color: rgba(65, 70, 88, 1);
			}
			
			.bd_content div:nth-of-type(2) {
				font-size: 16px;
				font-family: MicrosoftYaHei;
				font-weight: 400;
				color: rgba(106, 112, 118, 1);
				text-align: center;
				margin-top: 39px;
				margin-bottom: 47px;
			}
			
			.bd_content div:nth-of-type(3) {
				width: 220px;
				height: 60px;
				background: linear-gradient(90deg, rgba(105, 176, 252, 1), rgba(40, 144, 255, 1));
				box-shadow: 0px 3px 17px 0px rgba(38, 130, 203, 0.67);
				border-radius: 30px;
				font-size: 24px;
				font-family: MicrosoftYaHei;
				font-weight: 400;
				color: rgba(255, 255, 255, 1);
				line-height: 60px;
				margin-left: 24%;
				cursor: pointer;
			}
			.cha{
				cursor: pointer;
				width:14px;
				height:14px;
				border-radius: 50%;
				border:2px solid white;
				color: white;
				position: absolute;
				top: 18%;
				right: 34.5%;			
			}
			.zhezhao{
				background: rgba(0,0,0,0.8);
				position: absolute;
				width: 100%;
				height: 100%;
			}
			.bg{
				width: 33%;
			}
		</style>
		{/literal}
	</head>

	<body>

		<div class='page'>
			<input type="hidden" id="startdate" value="{$res->startdate}">
			<input type="hidden" id="enddate" value="{$res->enddate}">
			<input type="hidden" id="telltype" value="{$res->type}">
			<!--登陆的弹框-->
			<div class="login" style="position: absolute;">
				<div class="page_login">
					<div class='login_title'>
						<img src="images/iIcon/logo2.png" />
						<p style="color: #fff;font-size: 30px;">大象电商管理系统</p>
						{*<p style="font-size: 14px; color: #fff;">Laike E-commerce Management System</p>*}
					</div>

					<div class='login_fields'>
						<div class='login_fields__id'>
							<div class='icon'>
								<img alt="" class="hoverImg" src='images/iIcon/bh.png'>
								<img alt="" class="hoverImg" style="display: none;" src='images/iIcon/bh_1.png'>
							</div>

							<input name="customer_number" required="required" class="ipt idCord num" placeholder='请输入客户编号' maxlength="32" class="id" type='text' autocomplete="off" />

							<div class='validation'></div>
							<span class="delText">
                        <img src="images/iIcon/qc_1.png" style="display:block;"/>
                    </span>
						</div>

						<div class='login_fields__user'>
							<div class='icon icon1'>
								<img alt="" class="hoverImg" src='images/iIcon/zh.png'>
								<img alt="" class="hoverImg" style="display: none;" src='images/iIcon/zh_1.png'>
							</div>

							<input name="login" required="required" title='' placeholder='请输入用户名' maxlength="16" class="username ipt" type='text' autocomplete="off" />

							<div class='validation'></div>
							<span class="delText">
                        <img src="images/iIcon/qc_1.png" style="display:block;"/>
                    </span>
						</div>

						<div class='login_fields__password'>
							<div class='icon icon1'>
								<img alt="" class="hoverImg" src='images/iIcon/mm.png'>
								<img alt="" class="hoverImg" style="display: none;" src='images/iIcon/mm_1.png'>
							</div>
							<input name="pwd" required="required" class="passwordNumder ipt" placeholder='请输入密码' maxlength="16" type='password' autocomplete="off" title=''>
							<div class='validation'></div>
							<span class="delText">
                        <img src="images/iIcon/qc_1.png" style="display:block;" />
                    </span>
						</div>

						<div class='login_fields__submit'>
							<input type='button' value='登录'>
						</div>
						<div class="errText" style="display: none">
							<div style="height: 100%;width: 100%;">
								<i><img src="images/iIcon/ts.png" alt="" /></i>
								<span style="color:#fff;font-weight: 400;" class="errText_box"></span>
							</div>
						</div>
					</div>

					<div class='success login_fields__submit'></div>
				</div>
			</div>

			<!--版本更新的弹框-->
			{*<div class="zhezhao" id="showattr_1">*}
				{*<div class="bbgx_div">*}
					{*<div class="cha" id="closeModal1" >*}
						{*X*}
					{*</div>*}
					{*<img class="bg" src="images/bb_gx.png" />*}
					{*<div class="bd_content">*}
						{*<div class="">好消息</div>*}
						{*<div>*}
							{*来客电商可以升级新版本了，快去体验吧！*}
						{*</div>*}
						{*<div id="closeModal1_1">*}
							{*立即体验*}
						{*</div>*}
					{*</div>*}
				{*</div>*}
			{*</div>*}
			
		</div>
		{*<footer>
			<p>来客电商 <i> © </i> 专注于小程序电商开发平台</p>
			<p>湖南壹拾捌号网络技术有限公司&nbsp;版权所有
				<a href="http://www.miibeian.gov.cn" class="ipId" style="color: #97a0b4;">湘ICP备17020355号-2</a>
			</p>
		</footer>*}
		<div class='authent'>
			<div class="loader" style="height: 60px;width: 60px;margin-left: 28px;margin-top: 40px">
				<div class="loader-inner ball-clip-rotate-multiple">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
			<p>认证中...</p>
		</div>

		{*<div class="sysyattr modalshow" id="showattr">*}
			{*<!-- 公告弹窗 -->*}
			{*<div class="sysyattr_div">*}
				{*<div class="sys_c">*}
					{*<div class="modaltitle">*}
						{*<div style="float:left;color:#000;">{if $res->type==1}系统维护{else}版本更新{/if}通知</div>*}
						{*<a id="closeModal">*}
							{*<div style="float:right;font-size: 25px;color:gray;">X</div>*}
						{*</a>*}
					{*</div>*}
					{*<hr>*}
					{*<div style="color:red;font-size:22px;text-align: center;">{$res->title}</div>*}
					{*<div style="color:gray;text-align: center;">{if $res->type==1}时间: {$res->startdate} ~ {$res->enddate} {/if}</div>*}
					{*<div style="height:62%;width:90%;border:1px gray solid;border-radius: 10px;margin:10px auto;overflow-y: scroll;color:#000;">*}
						{*<div>{$res->content}</div>*}
					{*</div>*}
				{*</div>*}
			{*</div>*}
		{*</div>*}

		<div class="OverWindows"></div>
		<link href="style/loginSpecial/layui/css/layui.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="style/loginSpecial/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src='style/loginSpecial/js/stopExecutionOnTimeout.js?t=1'></script>
		<script src="style/loginSpecial/layui/layui.js" type="text/javascript"></script>
		<!--<script src="style/loginSpecial/js/Particleground.js" type="text/javascript"></script>-->
		<script src="style/loginSpecial/js/Treatment.js" type="text/javascript"></script>
		<script src="style/loginSpecial/js/jquery.mockjax.js" type="text/javascript"></script>
		<script src="style/loginSpecial/js/controlLogin.js" type="text/javascript"></script>

		{literal}
		<style>
			body .login_fields input[type='text'],
			body .login_fields input[type='password'] {
				/* max-width: 100%; */
			}
			
			.icon1 {
				opacity: 1!!important;
			}
		</style>
		<script type="text/javascript">
			window.onload = function() {
				function jqtoast(text) {
					var errText = $(".errText");
					errText.show();
					$(".errText_box").text(text);
					setTimeout(function() {
						$('.errText').fadeOut(function() {
							errText.hide();
						});
						_this = '';
					}, 5000);
				}

				$(".ipt").each(function() {
					$(this).focus(function() {
						$(this).css("border", "1px solid #fff");
						$(this).addClass("whiteP1");
						$(this).parent().find(".hoverImg").eq(1).show();
						$(this).parent().find(".hoverImg").eq(0).hide();
						$(this).keyup(function() {
							if($(this).val().length > 0) {
								$(this).parent().find(".delText").show();
								$(this).parent().find(".delText").find('img').show();

							}
						});
						if($(this).val().length > 0) {
							$(this).parent().find(".delText").show();
							$(this).parent().find(".delText").find('img').show();
						};
						$(this).siblings()[0].style.opacity = "1";
					});
					$(this).blur(function() {
						$(this).removeClass("whiteP1");
						$(this).css("border", "1px solid #97a0b4");
						$(this).parent().find(".hoverImg").eq(0).show();
						$(this).parent().find(".hoverImg").eq(1).hide();
						$(this).parent().find(".delText").find('img').hide();
					})
				})
				$(".delText").each(function() {
					$(this).click(function() {
						$(this).parent().find(".ipt").val("");
						$(this).hide();
					})
					/* $(this).mouseover(function(){
					     $(this).find("img")[1].style.display="block";
					     $(this).find("img")[0].style.display="none";
					 })
					 $(this).mouseout(function(){
					     $(this).find("img")[0].style.display="block";
					     $(this).find("img")[1].style.display="none";
					 }) */
				})

				var notice_id = '{/literal}{$res->id}{literal}';
				if(getCookie('notice' + notice_id) == '') {
					$('#showattr').removeClass('modalshow');
				}
				$("#closeModal").click(function() {
					$('#showattr').addClass('modalshow');
					setCookie('notice' + notice_id, 'isread', 15);
				})
				
				//版本更新的关闭弹框
				$("#closeModal1").click(function() {
					$('#showattr_1').addClass('modalshow');
				})
				$("#closeModal1_1").click(function() {
					$('#showattr_1').addClass('modalshow');
				})


				function setCookie(c_name, value, expiredays) {
					var exdate = new Date()
					exdate.setDate(exdate.getDate() + expiredays)
					document.cookie = c_name + "=" + escape(value) +
						((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())
				}

				function getCookie(c_name) {
					if(document.cookie.length > 0) {
						c_start = document.cookie.indexOf(c_name + "=")
						if(c_start != -1) {
							c_start = c_start + c_name.length + 1
							c_end = document.cookie.indexOf(";", c_start)
							if(c_end == -1) c_end = document.cookie.length
							return unescape(document.cookie.substring(c_start, c_end))
						}
					}
					return "";
				}

			}
		</script>
		{/literal}
	</body>

</html>