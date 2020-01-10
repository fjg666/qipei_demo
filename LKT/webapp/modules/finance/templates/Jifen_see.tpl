
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
</head>
{literal}
<style>
input:focus::-webkit-input-placeholder {
	color: transparent;
	/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Jifen" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Jifen_see" />
			<input type="hidden" name="user_id" value="{$user_id}" id="user_id" />
			<div>
				<select id="otype" name="otype" class="select" style="width: 200px;height: 31px;vertical-align: middle;">
					<option value="all" {if $type =='all'} selected{/if}>请选择要查询的类型</option>
					<option value="0" {if $type =='0' } selected{/if}>签到</option>
					<option value="1" {if $type =='1' } selected{/if}>消费</option>
					<option value="2" {if $type =='2' } selected{/if}>关注</option>
					<option value="3" {if $type =='3' } selected{/if}>转积分给好友</option>
					<option value="4" {if $type =='4' } selected{/if}>好友转积分</option>
					<option value="5" {if $type =='5' } selected{/if}>系统扣除</option>
					<option value="6" {if $type =='6' } selected{/if}>系统充值</option>
					<option value="8" {if $type =='8' } selected{/if}>会员购物</option>
				</select>

				<div style="position: relative;display: inline-block;">
					<input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate"  autocomplete="off" style="width:150px;">
				</div>至
				<div style="position: relative;display: inline-block;margin-left: 5px;">
					<input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" autocomplete="off"    style="width:150px;">
				</div>
				<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

				<input type="submit" class="btn btn-success" id="btn1" value="查 询">

				<input type="button" value="导出" class="btn btn-success" id="btn2" onclick="export_popup(location.href)">
			</div>
		</form>
	</div>
	<div class="page_h16"></div>
	<div>
		<table class="table-border tab_content">
			<thead>
				<tr class="text-c tab_tr">
					<th width="100">用户ID</th>
					<th width="130">用户名</th>
					<th width="150">手机号码</th>
					<th width="150">充值积分</th>
					<th width="130">来源</th>
					<th width="150">时间</th>
					<th width="150">充值方式</th>
				</tr>
			</thead>
            <tbody>
	            {foreach from=$list item=item name=f1}
	                <tr class="text-c tab_td">
	                    <td>{$item->user_id}</td>
	                    <td>{$item->user_name}</td>
	         			<td>
	         				{$item->mobile}
	         			</td>
	                    <td>
							{if $item->type ==0 ||$item->type ==2|| $item->type ==4 || $item->type ==6 || $item->type ==7 || $item->type == 8}+{$item->sign_score}{/if}
							{if $item->type ==1 ||$item->type ==3 ||$item->type ==5}-{$item->sign_score}{/if}
	         			</td>
						<td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
						<td>{$item->sign_time}</td>
	                    <td>
	                    	{if $item->type == 0 }签到领积分{/if}
	                    	{if $item->type == 1 }消费积分{/if}
	                    	{if $item->type == 2 }首次关注得积分{/if}
	                    	{if $item->type == 3 }转积分给好友{/if}
	                    	{if $item->type == 4 }好友转积分{/if}
							{if $item->type == 5 }系统扣除{/if}
							{if $item->type == 6 }系统充值{/if}
							{if $item->type == 8 }会员购物{/if}
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
    $("#otype").val('all');
    $("#startdate").val('');
    $("#enddate").val('');
}
</script>
{/literal}
</body>
</html>