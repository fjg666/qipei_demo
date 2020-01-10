
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
<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>

<title>系统参数</title>

</head>

<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe62d;</i>
    {foreach from=$menu item=item key=k name=f1}
        {if $smarty.foreach.f1.first}
            <span class="c-gray en"></span>
            {$item->title}
        {else}
            <span class="c-gray en">&gt;</span>
            {if $smarty.foreach.f1.total == 3 && ($smarty.foreach.f1.total-1) == $k}
                {$item->title}
            {else}
                <a style="margin-top: 10px;"  onclick="location.href='{$item->url}';">{$item->title} </a>
            {/if}
        {/if}
    {/foreach}
</nav>
<div class="page-container">
    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>联系人：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="name" value="{$list->name}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>联系电话：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="tel" value="{$list->tel}" class="input-text">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>详细地址：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="address" value="{$list->address}" class="input-text">
                </div>
            </div>

        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-4">
                <input class="btn btn-primary radius submit1" type="button" onclick="check()" name="Submit" value="保  存">
                <!-- <button class="btn btn-default radius" type="reset">&nbsp;&nbsp;清空&nbsp;&nbsp;</button> -->
            </div>
        </div>
    </form>
</div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script> 
{literal}
<script type="text/javascript">
	document.onkeydown = function (e) {
	            if (!e) e = window.event;
	            if ((e.keyCode || e.which) == 13) {
	                $("[name=Submit]").click();
	            }
        	}
function check() {
    $.ajax({
		cache: true,
		type: "POST",
		dataType:"json",
		url:'index.php?module=return&action=Set',
		data:$('#form1').serialize(),// 你的formid
		async: true,
		success: function(data) {
			console.log(data)
			layer.msg(data.status,{time:2000});
			if(data.suc){
				location.href="index.php?module=return&action=Set";
			}
		}
	});
}
</script>
{/literal}
</body>
</html>