<!DOCTYPE html>
<html>
<head>

<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />

<link href="style/css/style.css" rel="stylesheet" type="text/css" />

<title>模板消息</title>
<link rel="stylesheet" href="style/tgt/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="style/css/style.css" />
{literal}
<style>
	.col-md-4{
		width: 20%;
	}
	.col-sm-4{
		width: 20%;
	}
    a{
        color: #333;
    }
    a:hover{
        text-decoration: none;
    }
    .breadcrumb span{padding: 0 5px;}
</style>
{/literal}
</head>
<body style="opacity: 1;">
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="page-container page_absolute pd-20">

    <form name="form1" action="" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding:20px 0;" >
        <div class="border_bg">
              <div class="panel-body" style="padding:0;">
                   {foreach from = $res_list item = item name = f1  key = k} 
                    <div class="">
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">{$item->title}</label> 
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="" class="form-control" value="{$item->template_id}">   
                            <div class="help-block">小程序模板消息编号示例: m1FFBWiae7r4Sx3cMZ7dyt0 </div>    
                                
                        </div>    
                    </div> 
                    {/foreach} 
                          

                    <div style="clear: both;"></div>
              </div>      
            </div>
        </div>

    </form>
    <div class="page_h2"></div>

</div>
</body>
</html>