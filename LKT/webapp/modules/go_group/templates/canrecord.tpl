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
    <!--<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>-->

    <title>活动列表</title>
    {literal}
        <style type="text/css">
            .btn1 {
                padding: 0px 10px;
                height: 40px;
                line-height: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                float: left;
                color: #6a7076;
                background-color: #fff;
            }

            .active1 {
                color: #fff;
                background-color: #62b3ff;
            }


            .swivch a:hover {
                text-decoration: none;
                background-color: #2481e5!important;;
                color: #fff;
            }

            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
            }

            .btn_sty{
                height: 30px;
                padding: 18px 30px;
                background: #e6e6e6;
                font-weight: bold;
                color: #1d1d1d;
                font-size: 14px;
            }
            .sel_btn{
                background: #fff;
                border-bottom: none;
                color: #30b5f7;
            }
        </style>
    {/literal}
</head>
<body>
<nav class="breadcrumb" style="font-size: 16px;padding: 0 10px;">
    <i class="Hui-iconfont">&#xe6ca;</i>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=go_group&action=Index';">拼团 </a>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=go_group&action=Index&status=4';">开团记录列表 </a>
    <span class="c-gray en">&gt;</span>
    查看详情
</nav>
<div class="pd-20 page_absolute">
    <div class="page_h16"></div>
    <div class="mt-20">
        <input type="hidden" name="goods_id" value="{$goods_id}"/>
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th>序号</th>
                <th>商品名称</th>
                <th>会员名称</th>
                <th>零售价</th>
                <th>参团价格</th>
                <th>参团时间</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c">
                    <td>{$item->id}</td>
                    <td style="width: 200px;">
                        <div style="display: flex;align-items: center;border: none;">
                            <div style="width: 60px;height: 60px;">
                                {if $item->imgurl != ''}
                                    <img onclick="pimg(this)" style="width: 60px;height: 60px;"
                                         src="{$item->imgurl}">
                                {else}
                                    <span>暂无图片</span>
                                {/if}
                            </div>
                            <div title="{$item->product_title}"
                                 style="height: 60px; overflow: hidden;white-space: nowrap;text-overflow: ellipsis;width:250px;line-height: 60px;">
                                {$item->p_name}
                            </div>
                        </div>
                    </td>
                    <td>{$item->user_name}</td>
                    <td>{$item->price} 元</td>
                    <td>{$item->can_price} 元</td>
                    <td>{$item->add_time}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
</body>
</html>