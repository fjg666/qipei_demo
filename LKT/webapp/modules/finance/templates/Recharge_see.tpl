
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

	<title>财务管理</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Recharge" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Recharge_see" />
			<input type="hidden" name="user_id" value="{$user_id}" id="user_id" />
			<div style="position: relative;display: inline-block;">
				<input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
			</div>至
			<div style="position: relative;display: inline-block;margin-left: 5px;">
				<input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
			</div>
			<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

			<input type="submit" id="btn1" class="btn btn-success" value="查 询">

			<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)">
		</form>
	</div>
	<div class="page_h16"></div>

	<div class="mt-20">
		<table class="table-border tab_content">
			<thead>
			<tr class="text-c tab_tr">
				<th width="150">用户ID</th>
				<th width="150">用户昵称</th>
				<th width="130">操作金额</th>
				<th width="50">来源</th>
				<th width="50">手机号码</th>
				<th width="150">添加时间</th>
				<th width="100">类型</th>
			</tr>
			</thead>
			<tbody>
			{foreach from=$list item=item name=f1}
				<tr class="text-c tab_td">
					<td>{$item->user_id}</td>
					<td>{$item->user_name}</td>
					<td>{$item->money}</td>
					<td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
					<td>{$item->mobile}</td>
					<td>{$item->add_date}</td>
					<td>
						{if $item->type == 1}充值{/if}
						{if $item->type == 14}系统充值{/if}
					</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	</div>
	<div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<!--<script type="text/javascript" src="style/js/H-ui.js"></script>-->
<!--<script type="text/javascript" src="style/js/H-ui.admin.js"></script>-->
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

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
function excel(pageto) {
	location.href=location.href+'&pageto='+pageto;
}
function empty() {
    $("#startdate").val('');
    $("#enddate").val('');
}
</script>
{/literal}
</body>
</html>


