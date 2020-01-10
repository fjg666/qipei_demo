
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/bootstrap.min.css" rel="stylesheet">
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<link href="style/css/iconfont.css" rel="stylesheet">
{literal}
<style type="text/css">
.fileinput-button {
    position: relative;
    display: inline-block;
    overflow: hidden;
}

.fileinput-button input{
    position: absolute;
    left: 0px;
    top: 0px;
    opacity: 0;
    -ms-filter: 'alpha(opacity=0)';
}
</style>
{/literal}
<title>版本配置</title>
{include file="../../include_path/header.tpl" sitename="公共头部"}
</head>

<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="page-container pd-20 page_absolute">
    <form name="form1" id='form1' class="form form-horizontal" method="post" enctype="multipart/form-data" >
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>APP名称：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="appname" value="{$appname}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>版本号：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="edition" value="{$edition}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>Android下载地址：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="android_url" value="{$android_url}" class="input-text" >
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>IOS下载地址：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="ios_url" value="{$ios_url}" class="input-text" >
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red">*</span>是否自动更新提示：</label>
                <div class="formControls col-8 skin-minimal">
                    <div class="form_new_r form_yes" style="width: 90%;">
                        <div class="ra1" style="width: 10%!important;">
                            <input style="display: none;" class="inputC1" type="radio" name="type" id="type0" value="0" {if $type ==0}checked="checked"{/if}>
                            <label for="type0">是</label>
                        </div>
                        <div class="ra1" style="width: 10%!important;">
                            <input style="display: none;" class="inputC1" type="radio" name="type" id="type1" value="1" {if $type ==1}checked="checked"{/if}>
                            <label for="type1">否</label>
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">更新内容：</label>
            <div class="formControls col-xs-8 col-sm-6">
                <script id="editor" type="text/plain" name="content" style="width:100%;height:400px;">{$content}</script> 
            </div>
        </div>
        <div class="page_bort" style="padding-bottom: 15px;bottom: 0!important;">
            <div class="save page_out" >
                <button class="btn btn-default radius ta_btn4" type="reset">取  消</button>
                <input class="btn btn-primary radius submit1 ta_btn3" type="submit" value="保  存" name="Submit" style="width: 112px!important;">
            </div>
        </div>
    </form>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;">
        <img id="bigimg" src="" />
    </div>
</div> 

<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.all.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{literal}
<script type="text/javascript">
    $(function(){
        var ue = UE.getEditor('editor');
    });
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
            url:'index.php?module=edition',
            data:$('#form1').serialize(),// 你的formid
            async: true,
            success: function(data) {
                layer.msg(data.status,{time:2000});
                if(data.suc){
                    setTimeout(function(){
                        location.href="index.php?module=edition";
                    },2000)
                }
            }
        });
    }
</script>
{/literal}
</body>
</html>