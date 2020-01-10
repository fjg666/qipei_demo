<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/flex.css" rel="stylesheet">
    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="style/js/jquery.js"></script>
    {literal}
        <style type="text/css">
            .center {
                text-align: center !important;
            }

            .ul1,
            .ul2,
            .ul3 {
                padding: 0px 20px;
            }

            .ul1 li,
            .ul2 li,
            .ul3 li {
                float: left;
                height: 60px;
                line-height: 60px;
                color: #888f9e;
                font-size: 14px;
                
            }
            .ul2 li input{border: 1px solid #ddd;padding: 0 14px;height: 36px;}
            .ul2 li input:hover{border: 1px solid #3BB4F2;}

            .grText {
                color: #414658;
                font-size: 14px;
            }

            .ulTitle {
                height: 50px;
                line-height: 50px;
                text-align: left;
                font-size: 16px;
                color: #414658;
                font-weight: 600;
                font-family: "微软雅黑";
                margin-bottom: 0px;
                /*margin-top: 20px;*/
                margin-left: 20px;
                margin-right: 20px;
                border-bottom: 1px solid #d9d9d9;
                /* padding: 0 20px 0 20px; */
            }

            table th {
                border-bottom: none;
                background-color: #fff;
            }

            table {
                width: 95%;
                margin: 20px auto;
                border: 1px solid #eee !important;

            }

            tr {
                border: 1px solid #fff;
            }

            .table td, .table th {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #fff;
            }

            .order-item {
                border: 1px solid transparent;
                margin-bottom: 1rem;
            }

            .order-item table {
                margin: 0;
            }

            .order-item:hover {
                border: 1px solid #3c8ee5;
            }

            .goods-item {
                margin-bottom: .75rem;
            }

            .goods-item:last-child {
                margin-bottom: 0;
            }

            .goods-name {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .status-item.active {
                color: inherit;
            }

            .badge {
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem
            }

            .badge:empty {
                display: none
            }

            .btn .badge {
                position: relative;
                top: -1px
            }

            a.badge:focus,
            a.badge:hover {
                color: #fff;
                text-decoration: none;
                cursor: pointer
            }

            .badge-pill {
                padding-right: .6em;
                padding-left: .6em;
                border-radius: 10rem
            }

            .badge-default {
                background-color: #636c72
            }

            .badge-default[href]:focus,
            .badge-default[href]:hover {
                background-color: #4b5257
            }

            .badge-primary {
                background-color: #0275d8
            }

            .badge-primary[href]:focus,
            .badge-primary[href]:hover {
                background-color: #025aa5
            }

            .badge-success {
                background-color: #5cb85c
            }

            .badge-success[href]:focus,
            .badge-success[href]:hover {
                background-color: #449d44
            }

            .badge-info {
                background-color: #5bc0de
            }

            .badge-info[href]:focus,
            .badge-info[href]:hover {
                background-color: #31b0d5
            }

            .badge-warning {
                background-color: #f0ad4e
            }

            .badge-warning[href]:focus,
            .badge-warning[href]:hover {
                background-color: #ec971f
            }

            .badge-danger {
                background-color: #d9534f
            }

            .badge-danger[href]:focus,
            .badge-danger[href]:hover {
                background-color: #c9302c
            }

            .mask {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;

            }

            a:hover {
                color: red;
                text-decoration: none;
            }

            .table-bordered th, .table-bordered td {
                border: none;
                text-align: center;
                vertical-align: middle;
            }

            .txc th {
                text-align: center;
            }

            .imgTd img {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }

            table {
                vertical-align: middle;

            }

            td a {
                float: left;
                width: 100% !important;

            }

            .maskLeft {
                width: 30%;
                float: left;
                text-align: right;
                padding-right: 20px;
                height: 36px;
                line-height: 36px;
            }

            .maskRight {
                width: 70%;
                float: left;
            }

            .ipt1 {
                padding-left: 10px;
                width: 300px;
                height: 36px;
                border: 1px solid #eee;
            }

            .wl_maskNew {
                position: fixed;
                z-index: 9999999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                display: block;
            }

            .wl_maskNewContent {
                width: 500px;
                height: 519px;
                margin: 0 auto;
                position: relative;
                top: 200px;
                background: #fff;
                border-radius: 10px;
            }

            .dc {
                position: fixed;
                z-index: 999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                display: block;
            }

            .table td, .table th {
                vertical-align: middle;
            }

            .tr_xhx {
                border-bottom: 2px solid #cccccc;
            }

            .butten_o {
                width: 112px;
                height: 36px;
                background: inherit;
                background-color: rgba(16, 142, 233, 1);
                border: none;
                border-radius: 4px;
                -moz-box-shadow: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                font-family: 'MicrosoftYaHei', 'Microsoft YaHei';
                font-weight: 400;
                font-style: normal;
                font-size: 14px;
                color: #FFFFFF;
                text-align: center;
                line-height: 36px;
                margin-top: 20px;
            }
            
            .butten_o:hover{background-color: #2481E5;}

            

            form[name=form1] {
                background: #edf1f5;
                /*padding: 10px;*/
                padding: 0;
                text-align: left;
            }
            
            .tml_flex{width: 44%!important;margin:auto;}
        </style>
  {/literal}
    <title>生成快递单</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
    <section class="rt_wrap pd-20" style="margin-bottom: 0;background-color: white;">
        <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <div style="background-color: #fff;" id="printPage">
                <p class="ulTitle">生成快递单</p>
                <!-- <div style="page-break-after:always;"></div> -->
                <table class="table" style="width: 98%">
                    <tr>
                        <th class="center tr_xhx">商品信息</th>
                        <th class="center tr_xhx">快递</th>
                        <th class="center tr_xhx">数量</th>
                        <th class="center tr_xhx">重量</th>
                        <th class="center tr_xhx">收件信息</th>
                        <th class="center tr_xhx">寄件人</th>
                        <th class="center tr_xhx">打印状态</th>
                        <th class="center tr_xhx">备注</th>
                        <th class="center tr_xhx">操作</th>
                    </tr>
                    {foreach from=$goods item=item name=f1}
                        <tr>
                            <td>{$item->title}</td>
                            <td class="center">{$item->express}<br />{$item->expresssn}</td>
                            <td class="center">{$item->num}</td>
                            <td class="center">{$item->weight}</td>
                            <td class="center">
                                <span class="grText">
                                    {$item->recipient}  {$item->r_mobile}<br />
                                    {$item->r_address}
                                </span>
                            </td>
                            <td class="center"><span class="grText">{$item->sender}</span></td>
                            <td class="center"><span class="grText">{if $item->status==0}未打印{else}已打印{/if}</span></td>
                            <td class="center"><span class="grText">{if $item->remark==' '}无{else}{$item->remark}{/if}</span></td>
                            <td class="tab_dat">
                                <div class="hover_a" onclick="edit({$item->id})" title="编辑" style="border: none!important;">
                                    <img style="margin-top: -3px;" src="images/icon1/xg.png"/>&nbsp;编辑
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </table>

            </div>

            
            <div style="position: fixed;bottom: 0;background-color: #fff;width: 100%;">
                <a style="margin-left: 60px;float: left;padding-top: 30px;color: #108ee9;" href="index.php?module=invoice&action=template&type=2">模版管理</a>
                <div style="margin-left: 60px;float: left;padding-top: 24px;">打印份数设置：<input type="number" id="putnum" value="1">份</div>
                <div style="float:  right;margin-right: 60px;width: 112px;">
                    <!-- <button onclick="location='index.php?module=invoice&action=creat_list&r_sNo={$goods[0]->r_sNo}'" style="border: 1px solid #2481E5;background-color: #fff;color: #2481E5;" type="button" class="butten_o">生成发货单</button> -->
                    <button onclick="print()" type="button" class="butten_o">生成快递单</button>
                </div>
                <div style="clear: both;height: 20px;"></div>
            </div>
            <!-- 分销商信息 -->

            <div class="page_h20"></div>


        </form>
    </section>
    <script type="text/javascript" src="style/js/jquery.js"></script>
    <script type="text/javascript" src="style/js/jquery.min.js"></script>
    <script type="text/javascript" src="style/js/layer/layer.js"></script>
    <script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="style/js/H-ui.js"></script>
    <!-- 打印 -->
    <script type="text/javascript" src="style/js/jquery.jqprint-0.3.js"></script>
    <script type="text/javascript" src="style/js/jquery-migrate-1.2.1.min.js"></script>
    <!-- 打印end -->
</body>

{literal}
    <script type="text/javascript">
        function print(){
            var num = $("#putnum").val();
            var text = $("#printPage").html();
            for (var i = 1; i < num; i++) {
                $('#printPage').append(text);
            }
            $("#printPage").jqprint();
            $('#printPage').html(text);
        }
        function edit(id){
            $.ajax({
                type: "get",
                url: "index.php?module=invoice&action=creat_list&id="+id,
                async: true,
                success: function (res) {
                    console.log(res)
                }
            });
        }
    </script>
{/literal}
</html>
