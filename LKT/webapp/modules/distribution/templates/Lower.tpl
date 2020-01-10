<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    {literal}
        <style type="text/css">
            .btn1 {
                padding: 2px 10px;
                height: 34px;
                line-height: 34px;
                display: flex;
                justify-content: center;
                align-items: center;
                float: left;
                color: #6a7076;
                background-color: #fff;
            }
            body {
                font-size: 16px;
            }

            .active1 {
                color: #fff;
                background-color: #2890FF;
            }
            
            .swivch a{height: 36px;line-height: 36px;padding: 0 10px;}
            
            .swivch a:hover {
                text-decoration: none;
                background-color: #2481E5!important;
                color: #fff;
            }

            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
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
    <span style="color: #414658;">查看下级</span>
</nav>
<div class="pd-20 page_absolute">

	<div class="page_h16"></div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th>分销商ID</th>
                <th>推荐人</th>
                <th>分销商</th>
                <th>手机号码</th>
                <th>分销等级</th>
                <th>预计佣金</th>
                <th>打款佣金</th>
                <th>可提现佣金</th>
                <th>提现佣金</th>
                <th>下级分销商</th>
                <th>时间</th>
                <!-- <th style="width: 250px;">操作</th> -->
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c" style="font-size: 5px;">
                    <td style="font-size: 5px;">{$item->user_id}</td>
                    <td style="font-size: 5px;">
                        {if $item->hdimg != '' && $item->user_name}
                            {$item->user_name}
                        {else}
                            总店
                        {/if}
                    </td>
                    <td style="font-size: 5px;">{$item->r_name}</td>
                    <td style="font-size: 5px;">{$item->mobile}</td>
                    <td style="font-size: 5px;">{if $item->s_dengjiname}{$item->s_dengjiname}{else}默认等级{/if}</td>
                    <td style="font-size: 5px;">{$item->yjyj}</td>
                    <td style="font-size: 5px;">{$item->dkyj}</td>
                    <td style="font-size: 5px;">{$item->commission}</td>
                    <td style="font-size: 5px;">{$item->txyj}</td>
                    <td style="font-size: 5px;">总计：{$item->cont}<br/>
                                                直推：{$item->zhitui}<br/>
                    </td>
                    <td style="font-size: 5px;">{$item->add_date}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_h20"></div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
</script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script> 
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

</body>
</html>