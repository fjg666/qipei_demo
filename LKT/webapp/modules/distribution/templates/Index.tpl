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
    {literal}
        <style type="text/css">
            .text-c th{z-index: 1!important;}
            .swivch_bot a{
                width: 111px!important;
                height: 42px!important;
                padding: 0!important;
                border: none!important;
                border-right: 1px solid #ddd!important;
            }
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
                margin: 1% 5% !important;
                min-width: 80px!important;
            }
        </style>
    {/literal}
    <title>分销商</title>
    <script type="text/javascript" src="style/js/Popup.js"></script>
</head>
<body class='iframe-container' style='display: none;'>
<nav class="nav-title">
	<span>插件管理</span>
	<span class='nav-to' onclick="location.href='index.php?module=distribution&amp;action=Index';"><span class="arrows">&gt;</span>分销商管理</span>
</nav>
<div class="iframe-content">
	<div class="navigation">
	    <div class='active'>
			<a href="index.php?module=distribution">分销商管理</a>
		</div>
		<p class='border'></p>
	    <div>
			<a href="index.php?module=distribution&action=Distribution_grade">分销等级</a>
		</div>
		<p class='border'></p>
		<div>
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
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="distribution"/>
            <input type="text" name="user_name" size='8' value="{$user_name}" id="user_name" placeholder="请输入分销商名称/手机号码" style="width:200px" class="input-text">
            <input type="text" name="r_name" size='8' value="{$r_name}" id="r_name" placeholder="请输入推荐人名称" style="width:200px" class="input-text">

            <select name="level" id="level" class="select" style="width: 150px;vertical-align: middle;">
                <option value="">请选择分销商等级</option>
                {foreach from=$distributors item=item name=f1}
                    <option {if $level==$item->id}selected="selected"{/if}
                            value="{$item->id}">{$item->name}</option>
                {/foreach}
            </select>

            <div style="position: relative;display: inline-block;">
                <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
            </div>
            至
            <div style="position: relative;display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate"
                       style="width:150px;">
            </div>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

            <input class="btn btn-success" id="btn1" type="submit" value="查询">
            <input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float:right;">

        </form>
    </div>
    <div class="page_h16"></div>
    <div class="iframe-table">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th>分销商ID</th>
                <th>分销名称</th>
                <th>推荐人ID</th>
                <th>推荐人姓名</th>
                <th>手机号码</th>
                <th>分销等级</th>
                <th>预计佣金</th>
                <th>累计佣金</th>
                <th>可提现佣金</th>
                <th>开通时间</th>
                <th style="width: 200px;">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td>{$item->user_id}</td>
                    <td>{$item->r_name}</td>
                    <td>{$item->pid}</td>
                    <td>
                        {if $item->hdimg != '' && $item->user_name}
                            {$item->user_name}
                        {else}
                            总店
                        {/if}
                    </td>
                    <td>{$item->mobile}</td>
                    <td>{if $item->s_dengjiname}{$item->s_dengjiname}{else}默认等级{/if}</td>
                    <td>{$item->yjyj}</td>
                    <td>{$item->dkyj}</td>
                    <td>{$item->commission}</td>
                    <td>{$item->add_date}</td>
                    <td style="width: 200px;">
                        <a style="text-decoration:none;" class="ml-7" href="index.php?module=distribution&action=See&id={$item->user_id}" title="查看详细">
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/ck.png"/>&nbsp;查看详细
                                </div>
                            </div>
                        </a>
                        <a style="text-decoration:none;" class="ml-5" title="编辑"
                           href="index.php?module=distribution&action=Edit&id={$item->user_id}">
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                </div>
                            </div>
                        </a>
                        <a style="text-decoration:none;" class="ml-7" href="index.php?module=distribution&action=Lower&id={$item->user_id}" title="查看下级">
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/xj.png"/>&nbsp;查看下级
                                </div>
                            </div>
                        </a>
                        <a style="text-decoration:none;display: none;" class="ml-5" href="javascript:void(0);"
                           onclick="confirm('删除分销商将导致此用户无法使用分销功能，请谨慎操作！',{$item->id},'index.php?module=distribution&action=Del&id=','删除')">
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </div>
                            </div>
                        </a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div>{$pages_show}</div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
</script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script> 
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

{literal}
    <script type="text/javascript">
		$(function(){
			$('body').show();
		})
		
        laydate.render({
            elem: '#startdate', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#enddate',
            type: 'datetime'
        });
        function empty() {
            $("#user_name").val('');
            $("#r_name").val('');
            $("#level").val('');
            $("#startdate").val('');
            $("#enddate").val('');
        }
        function confirm(content, id, url, content1) {
            $("body", parent.document).append(`
			<div class="maskNew">
				<div class="maskNewContent">
					<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
					<div class="maskTitle">提示</div>
                    <div class="maskContent" style="top: 50px;">
						${content}
					</div>
					<div class="maskbtn">
						<button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
						<button class="closeMask" onclick=closeMask1()>取消</button>
					</div>
				</div>
			</div>	
		`)
        }

        function closeMask(id) {
            $(".maskNew").remove();
            $.ajax({
                type: "post",
                url: "index.php?module=distribution&action=Del&id=" + id,
                async: true,
                success: function (res) {
                    console.log(res);
                    if (res == 1) {
                        appendMask("删除成功", "cg");
                    }
                    else {
                        appendMask("删除失败", "ts");
                    }
                }
            });
        }

        function appendMask(content, src) {
            $("body").append(`
				<div class="maskNew">
					<div class="maskNewContent" style="height:300px">
						<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
						<div class="maskTitle">提示</div>	
						<div style="text-align:center;margin-top:30px"><img src="images/icon1/${src}.png"></div>
						<div style="height: 100px;position: relative;top:20px;font-size: 22px;text-align: center;">
							${content}
						</div>
						<div style="text-align:center;">
							<button class="closeMask" onclick=closeMask1() >确认</button>
						</div>
						
					</div>
				</div>	
			`)
        }

        function closeMask1() {
            $(".maskNew").remove();
            location.replace(location.href);
        }

    </script>
{/literal}
</body>
</html>