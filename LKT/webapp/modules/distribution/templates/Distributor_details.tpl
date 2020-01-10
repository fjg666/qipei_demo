
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
{literal}
<style type="text/css">
    body {
        font-size: 16px;
    }
    .btn1 {
        padding: 2px 5px;
        height: 40px;
        line-height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        float: left;
        color: #6a7076;
        background-color: #fff;
    }
    .active{
        color: #fff;
        background-color: #62b3ff;
    }
    .swivch{
        margin-bottom: 10px;
    }
</style>
{/literal}
<title>分销商</title>
</head>
<body>
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    <span style="color: #414658;">插件管理</span>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=distribution&amp;action=Index';">分销商管理 </a>
    <span class="c-gray en">&gt;</span>
    <span style="color: #414658;">分销商</span>
</nav>
<div class="pd-20">
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                    <th>序</th>
                    <th>级别</th>
                    <th>昵称</th>
                    <th>手机号码</th>
                    <th>分销级别</th>
                    <th>时间</th>
                </tr>
            </thead>
            <tbody  >
                {foreach from=$re item=item name=f1}
                    <tr class="text-c" style="font-size: 5px;">
                        <td style="font-size: 5px;">{$smarty.foreach.f1.iteration}</td>
                        <td style="font-size: 5px;">{$item->uplevel}</td>
                        <td style="font-size: 5px;"><image class='pimg' src="{$item->headimgurl}" style="width: 30px;height:30px;border-radius: 30px;border: 1px solid darkgray;"/><br/>{$item->user_name}</td>
                        <td style="font-size: 5px;">{$item->mobile}</td>
                        <td style="font-size: 5px;">{$item->s_dengjiname}</td>
                        <td style="font-size: 5px;">注册时间：{$item->Register_data}</br>代理时间：{$item->add_date}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script>

{literal}
<script type="text/javascript">
$('.table-sort').dataTable({
    "aaSorting": [[ 0, "asc" ]],//默认第几个排序
    "bStateSave": true,//状态保存
    "aoColumnDefs": [
      //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
      {"orderable":false,"aTargets":[0,4]}// 制定列不参与排序
    ]
});
</script>
{/literal}
</body>
</html>