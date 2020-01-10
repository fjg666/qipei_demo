<?php /* Smarty version 2.6.31, created on 2020-01-02 15:43:23
         compiled from Auth.tpl */ ?>

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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>系统参数</title>
<?php echo ' 
	<style type="text/css">
		body{
			background-color: #fff;
		}
		li{
			margin-left: 20px;
		}
		.box{
			float: left;
			width: 42%;
			/*height: 460px;*/
			padding-bottom: 50px;
			margin: 0;
			margin-left: 5%;
			box-shadow:0px 0px 16px 0px rgba(0, 0, 0, 0.1);
			border-radius:4px;
			margin-bottom: 50px;
			background-color: #fff;
		}
		h1{
			margin: 0 auto; 
			text-align: center;
			width :210px;
			height:22px;
			font-size:22px;
			font-family:MicrosoftYaHei;
			font-weight:400;
			color:rgba(65,70,88,1);
			line-height:100px;
		}
		h2{
			text-align: center; 
			width:auto;height:15px;
			font-size:16px;
			font-family:MicrosoftYaHei;
			font-weight:400;
			color:rgba(65,70,88,1);
			line-height:22px;
		}
		p{
			font-size: 13px;
			font-family: MicrosoftYaHei;
			font-weight: 400;
			color: rgba(151,160,180,1);
			line-height: 25px;
			text-align: center;
			margin: 26px auto 46px auto;
		}
		.headimg{
			width:64px;
			height:64px;
			background:rgba(230,230,230,1);
			border-radius:50%; 
			margin: 124px auto 25px auto;
		}
		.registered{
			width:50px;
			height:54px;
			border-radius:4px; 
			margin: 124px auto 25px auto;
		}
		img{
			width:64px;
			height:64px;
		}
		.right button{
			background-color: #fff;
			/*width:160px;*/
			height:36px;
			margin-top: 30px;
			margin-left: 46px;
			border:1px solid rgba(213,219,232,1);
			border-radius:2px;
			width: 80%;
			margin:0 auto;
			display: block;
			z-index: 99;
		}
		.sq_button{
			display:block;
			margin: 0 auto;
			width:160px;
			height:36px;
			background:rgba(40,144,255,1);
			border-radius:2px;
			font-size:16px;
			font-family:MicrosoftYaHei;
			font-weight:400;
			color:rgba(254,254,254,1);
			text-align: center;
			line-height: 36px;
			
		}
		.sq_button:hover{
			color:rgba(254,254,254,1);
		}
		.bigBox{
			margin-top: 100px;
		}
	</style>
'; ?>

</head>

<body class="body_bgcolor">

		<nav class="breadcrumb page_bgcolor">
	
		
			<span class="c-gray en"></span>
			<span  style='color: #414658;'>小程序设置</span>
	
			<span  class="c-gray en">&gt;</span>
		
			<span  style='color: #414658;'>授权设置</span>
	
        </nav>
		<input type="hidden" name="url" value="<?php echo $this->_tpl_vars['url']; ?>
">
		<div class="pd-20 page_absolute" style="height: max-content;">
			<div class="page_title">
				授权小程序
			</div>
		
				<div class="bigBox" style="width: auto;">
					<div class="box left">				
						<h1>我已有小程序</h1>
						<div class="headimg">
							<img src="style/images/imags/head.png" />
						</div>
						<h2>授权小程序后，即可发布小程序</h2>
						<p style="width: 80%;height: 24px;line-height: 20px;">小程序个人开放的服务类目是有严格规定的，
							内容不在服务类目中的，是审核不通过的。
						</p>
						<a class="sq_button" href="<?php echo $this->_tpl_vars['url']; ?>
">直接授权</a>
					</div>
					<div class="box right">
						<h1>我还没有小程序账号</h1>
						<div style="width: 30%; float: left;">
							<div class="registered">
								<img src="style/images/imags/again.png"/>
							</div>
							
							<h2>复用公众号资质快速注册</h2>
							<p style="width:  80%;height: 35px;line-height: 20px;">适用已有已认证公众号的用户</p>
							<button id="direct-register">注册小程序账号</button>
						</div>
						<div style="width: 30%;float: left; margin-left: 5%;">
							<div class="registered">
								<img src="style/images/imags/green.png"/>
							</div>
							
							<h2>线下门店绿色通道注册</h2>
							<p style="width:  80%;height: 35px;line-height: 20px;">适用拥有线下门店提供线上服务的用户</p>
							<button id="direct-register2" >注册小程序账号</button>
						</div>
						<div style="width: 30%;float: left;margin-left: 5%;">
							<div class="registered">
								<img src="style/images/imags/direct.png" />
							</div>
							
							<h2>直接注册小程序</h2>
							<p style="width:  80%;height: 35px;line-height: 20px;">适用没有已认证公众号的用户</p>
							<button id="direct-register3">注册小程序账号</button>
						</div>
					</div>
				</div>
			
		</div>
		<?php echo '
		
		<script type="text/javascript">
			
			var url = $("input[name=\'url\']").val();
			
			$(\'#direct-register\').on(\'click\',function(){
				
				console.log(\'123\')
				window.open(\'https://developers.weixin.qq.com/miniprogram/introduction/#%E5%85%AC%E4%BC%97%E5%8F%B7%E5%85%B3%E8%81%94%E5%B0%8F%E7%A8%8B%E5%BA%8F\');
			})
			$(\'#direct-register2\').on(\'click\',function(){
				location.href=\'\';
				window.open(\'https://developers.weixin.qq.com/miniprogram/introduction/#%E5%B0%8F%E7%A8%8B%E5%BA%8F%E6%B3%A8%E5%86%8C\')
			})
			$(\'#direct-register3\').on(\'click\',function(){
				window.open(\'https://developers.weixin.qq.com/miniprogram/introduction/#%E5%B0%8F%E7%A8%8B%E5%BA%8F%E6%B3%A8%E5%86%8C\');
			})
			$(\'.direct-auth\').click=function(){
				location.href=url;
			}

		</script>
		'; ?>

</body>
</html>