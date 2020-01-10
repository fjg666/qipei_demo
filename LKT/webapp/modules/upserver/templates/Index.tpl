
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

        <title>配置管理</title>
    </head>

    <body>
        <nav class="breadcrumb">
            <i class="Hui-iconfont">&#xe616;</i> 配置管理 
            <span class="c-gray en">&gt;</span> 资源服务配置 
            <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
        </nav>
        <div class="page-container">
            <form name="form1" action="index.php?module=upserver" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
                <div id="tab-system" class="HuiTab">
                    
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>上传服务器</label>
                        <div class="formControls col-xs-8 col-sm-6">
                            <input type="radio" name="upserver" value="1" {if $upserver==1}checked{/if}>本地
                            <input type="radio" name="upserver" value="2" {if $upserver==2}checked{/if} style="margin-left:20px;">阿里云
                            <input type="radio" name="upserver" value="3" {if $upserver==3}checked{/if} style="margin-left:20px;">腾讯云
                            <input type="radio" name="upserver" value="4" {if $upserver==4}checked{/if} style="margin-left:20px;">七牛云
                        </div>
                    </div>
                    
                <div class="row cl" style="text-align: right;">
                    <div class="" style="margin-right: 20px;">
                        <button class="btn btn-primary radius" type="submit" name="Submit">保  存</button>
                        <button class="btn btn-default radius" type="reset">取  消</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
            <div id="innerdiv" style="position:absolute;">
                <img id="bigimg" src="" />
            </div>
        </div> 
        <script type="text/javascript" src="style/js/jquery.js"></script>
        <script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script> 
        <script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script> 
        <script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script> 
        <script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
        <script type="text/javascript" src="style/js/H-ui.js"></script> 
        <script type="text/javascript" src="style/js/H-ui.admin.js"></script>

        <!-- 新增编辑器引入文件 -->
        <link rel="stylesheet" href="style/kindeditor/themes/default/default.css" />

        <script src="style/kindeditor/lang/zh_CN.js"></script>

    </body>
</html>