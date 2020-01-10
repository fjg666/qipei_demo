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
    <link href="style/css/style.css?v=1" rel="stylesheet" type="text/css"/>
    <title>佣金日志</title>
    {literal}
        <style>
            .swivch_bot a{
                width: 111px!important;
                height: 42px!important;
                padding: 0!important;
                border: none!important;
                border-right: 1px solid #ddd!important;
            }
            body {
                font-size: 16px;
            }
            .dataTables_wrapper .dataTables_length {
                bottom: 13px;
            }

            ._ul {
                padding: 0 8px;
            }

            ._li {
                float: left;
                width: 99px;
                padding: 8px 0
            }

            ._ul_li {
                border-right: 1px solid #eee;
            }

            .text_ggg > th, .text_ggg > td {
                border-right: 1px solid #eee;
            }

            ._ul:after {
                display: block;
                content: "";
                clear: both;
            }
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
                background-color: #2481e5!important;
                color: #fff;
            }

            td a {
                width: 44%;
                float: left;
                margin: 2% !important;
            }
        </style>
        <script type="text/javascript">
            var al = $('#jq-alert');
            al.on('click','[data-role="cancel"]',function () {
                al.remove();
                if (nofn){
                    param.nofn();
                    nofn = '';
                }
                param = {};
            });
        </script>
    {/literal}
</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>插件管理</span>
	<span class='nav-to' onclick="location.href='index.php?module=distribution&amp;action=Index';"><span class="arrows">&gt;</span>分销商管理</span>
	<span><span class="arrows">&gt;</span>佣金记录</span>
</nav>
<div class="iframe-content" onclick="on()">
    <div class="navigation">
        <div>
    		<a href="index.php?module=distribution">分销商管理</a>
    	</div>
    	<p class='border'></p>
        <div>
    		<a href="index.php?module=distribution&action=Distribution_grade">分销等级</a>
    	</div>
    	<p class='border'></p>
    	<div class='active'>
    		<a href="index.php?module=distribution&action=Commission">佣金记录</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Cash">提现记录</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Distribution_config">分销设置</a>
    	</div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1" action="index.php?module=distribution&action=Commission" method="get">
            <input type="hidden" name="module" value="distribution" />
            <input type="hidden" name="action" value="Commission" />
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />

            <input type="text" class="input-text" style="width:199px" placeholder="请输入分销商名称/手机号码" id="name" name="name" value="{$name}">
            <input type="text" class="input-text" style="width:199px" placeholder="请输入分销商ID"  id="phone" name="phone" value="{$phone}">
            <div style="position: relative;display: inline-block;">
                <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
            </div>
            至
            <div style="position: relative;display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
            </div>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

            <input id="btn1" type="submit" class="btn btn-success" value="查询">
            <input style="float: right;" type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)">
        </form>

    </div>
    <div class="page_h16"></div>
    <div class="iframe-table">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th>分销商ID</th>
                <th>分销商名称</th>
                <th>手机号码</th>
                <th>佣金金额</th>
                <th>会员ID</th>
                <th>分销等级</th>
                <th>分销层级</th>
                <th>佣金说明</th>
                <th>订单编号</th>
                <th>发放状态</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td>{$item->gm_id}</td>
                    <td>{$item->gm_name}</td>
                    <td>{$item->mobile}</td>
                    <td>￥{$item->money}</td>
                    <td>{$item->fx_id}</td>
                    <td>{$item->typename}</td>
                    <td>{$item->level}</td>
                    <td>{$item->event}</td>
                    <td>{$item->sNo}</td>
                    <td>{if $item->status==0 && $item->type==1}待发放{else}已发放{/if}</td>
                    <td>{$item->add_date}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div>{$pages_show}</div>
</div>

{include file="../../include_path/footer.tpl"}
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
{literal}
    <script type="text/javascript">
        laydate.render({
            elem: '#startdate', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#enddate',
            type: 'datetime'
        });
        function empty() {
            $("#name").val('');
            $("#phone").val('');
            $("#startdate").val('');
            $("#enddate").val('');
        }
        function excel(pageto) {
            var pagesize = $("#pagesize").val();
            location.href = location.href + '&pageto=' + pageto + '&pagesize=' + pagesize;
        }
    </script>
{/literal}
</body>
</html>


