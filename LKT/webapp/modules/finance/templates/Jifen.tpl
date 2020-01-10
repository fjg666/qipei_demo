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
	<title>积分列表</title>
	{literal}
	<style>
		td a{
			width: 55%;
			margin: 0 auto!important;
		}
		.dataTables_wrapper .dataTables_length{
			bottom: 13px;
		}
		input:focus::-webkit-input-placeholder {
			color: transparent;
			/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
		}
	</style>
	{/literal}
</head>

<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Jifen" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Jifen" />
			<div>
				<input type="text" class="input-text" style="width:150px" placeholder="请输入用户名称" name="user_name" id="user_name" value="{$user_name}">
				<input type="text" id="mobile" class="input-text" style="width:150px" placeholder="请输入手机号码" name="mobile" value="{$mobile}">
				<div style="position: relative;display: inline-block;">
					<input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" autocomplete="off" style="width:150px;">
				</div>至
				<div style="position: relative;display: inline-block;margin-left: 5px;">
					<input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate"  autocomplete="off" style="width:150px;">
				</div>
				<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

				<input type="submit" class="btn btn-success" id="btn1" value="查 询">

				<input type="button" value="导出" class="btn btn-success" id="btn2" onclick="export_popup(location.href)" style="float:right;">
			</div>
		</form>
	</div>
	
	<div class="page_h16"></div>
	
	<div class="mt-20 table-scroll" style="background: #fff;">
		<table class="table-border tab_content">
			<thead>
				<tr class="text-c tab_tr">
					<th width="150">用户ID</th>
					<th width="130">用户名称</th>
					<th width="150">手机号码</th>
					<th width="150">积分</th>
					<th width="130">来源</th>
					<th width="150">注册时间</th>
					<th width="100">操作</th>
				</tr>
			</thead>
            <tbody>
	            {foreach from=$list item=item name=f1}
	                <tr class="text-c tab_td">
	                    <td>{$item->user_id}</td>
	                    <td>{$item->user_name}</td>
	         			<td>{$item->mobile}</td>
	                    <td>{$item->score}</td>
						<td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
						<td>{$item->Register_data}</td>
	                    <td style="min-width:120px;">
							{if $button[0] == 1}
								<a style="text-decoration:none" class="ml-5" href="index.php?module=finance&action=Jifen_see&user_id={$item->user_id}" title="查看详情">
									<div style="align-items: center;font-size: 12px;display: flex;">
										<div style="margin:0 auto;;display: flex;align-items: center;">
											<img src="images/icon1/ck.png"/>&nbsp;查看详情
										</div>
									</div>
								</a>
							{/if}
	                    </td>
	                </tr>
	            {/foreach}
            </tbody>
        </table>
    </div>
	<div class='tb-tab' style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
	<div class="page_h20"></div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
<script type="text/javascript" src="style/js/Popup.js"></script> <!-- 导出页弹窗-->

{literal}
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-18-($('.tb-tab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')
	
laydate.render({
	elem: '#startdate', //指定元素
	type: 'datetime'
});
laydate.render({
	elem: '#enddate',
	type: 'datetime'
});
function excel(pageto) {
	location.href=location.href+'&pageto='+pageto;
}

var aa=$(".pd-20").height()-56-16;
var bb=$(".table-border").height();
console.log(aa,bb)
if(aa<bb){
	$(".page_h20").css("display","block")
}else{
	$(".page_h20").css("display","none")
}

function empty() {
    $("#user_name").val('');
    $("#mobile").val('');
    $("#startdate").val('');
    $("#enddate").val('');
}
</script>
{/literal}
</body>

</html>