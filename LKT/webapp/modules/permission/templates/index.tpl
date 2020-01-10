<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" type="text/css" href="modpub/css/base.css" />
    <link rel="stylesheet" type="text/css" href="style/css/sanming.css" />
    <link rel="stylesheet" type="text/css" href="style/css/Popup.css" />
    <link rel="stylesheet" type="text/css" href="style/css/skin.css" />
</head>
{literal}
<style>
	.iframe-container{
		display: flex;flex-direction: column;
		padding: 10px;margin: 0;
		overflow: hidden;
	}
	#Div_right{
		flex: 1;
		background-color: #ffffff;
	}
	.page_absolute{
		position: absolute;
		top: 48px;
		right: 10px;
		left: 10px;
		bottom: 10px;
		background-color: white!important;
		padding: 0!important;
		display: flex;flex-direction: column;
	}
	.title{
		height: 60px;line-height: 60px;border-bottom: 2px solid #E9ECEF;
		padding-left: 20px;color: #414658;font-size: 16px;font-weight: bold;
	}
	.page_absolute>div{
		flex: 1;
		display: flex;
		flex-direction: column;
		justify-content: center;align-items: center;
	}
	.page_absolute>div p{
		color: #414658;
		font-size: 16px;font-weight: bold;line-height: 16px;
		margin-top: 17px;
	}
	.page_absolute>div a{
		display: flex;justify-content: center;align-items: center;
		width: 112px;height: 36px;
		box-sizing: border-box;
		border: 1px solid #2890FF;
		color: #2890FF;
		font-size: 16px;
		margin-top: 40px;
	}
</style>
{/literal}
<body style="background: #edf1f5;" scroll="yes">
	{include file="../../include_path/nav.tpl" sitename="面包屑"}
	<div class="page_absolute">
		<p class="title">访问受限</p>
		<div>
			<img src="images/iIcon/xz_img.png">
			<p>抱歉，您无权访问此页面</p>
			<a href="javascript:;" onclick="history.back(-1)">返回上一页</a>
		</div>
	</div>
	<script language="javascript" src="style/css/webjs.js"> </script>
</body>
</html>
