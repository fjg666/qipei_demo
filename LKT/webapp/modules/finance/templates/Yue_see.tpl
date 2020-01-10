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
<!--<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />-->

<title>财务管理</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Yue_see" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Yue_see" />
			<input type="hidden" name="user_id" value="{$user_id}" id="user_id" />

			<div>
				<label class="">入账/支出：</label>
				<select id="otype" name="otype" class="select" style="width: 120px;height: 31px;vertical-align: middle;">
					<option value="" {if $type =='' } selected{/if}>全部</option>
					<option value="1" {if $type =='1' } selected{/if}>用户充值</option>
					<option value="2" {if $type =='2' }selected {/if}>申请提现</option>
					<option value="4" {if $type =='4' } selected{/if}>余额消费</option>
					<option value="5" {if $type =='5' } selected{/if}>退款</option>
					<option value="11" {if $type =='11' } selected{/if}>系统扣款</option>
					<option value="12" {if $type =='12' } selected{/if}>给好友转余额</option>
					<option value="13" {if $type =='13'} selected{/if}>转入余额</option>
					<option value="14" {if $type =='14'} selected{/if}>系统充值</option>
					<option value="20" {if $type =='20'} selected{/if}>抽奖中奖</option>
					<option value="21" {if $type =='21'} selected{/if}>提现成功</option>
					<option value="22" {if $type =='22'} selected{/if}>提现失败</option>
					<option value="23" {if $type =='23'} selected{/if}>取消订单</option>
					<option value="26" {if $type =='26'} selected{/if}>交竞拍押金</option>
					<option value="30" {if $type =='30'} selected{/if}>会员返现</option>
				</select>

				<div style="position: relative;display: inline-block;">
					<input type="text" class="input-text" value="{$starttime}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
				</div>至
				<div style="position: relative;display: inline-block;margin-left: 5px;">
					<input type="text" class="input-text" value="{$group_end_time}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
				</div>
				<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

				<input type="submit" class="btn btn-success" id="btn1" value="查 询">
				&nbsp;
				<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="excel('all')">
			</div>
		</form>
	</div>
	<div class="page_h16"></div>
	<div>
		<table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
					<th width="50" >用户ID</th>
					<th width="130" >用户名称</th>
					<th width="130" >入账/支出</th>
					<th width="150" >金额</th>
					<th width="150" >交易时间</th>
					<th width="150" >备注</th>
		        </tr>
            </thead>
            <tbody>
	            {foreach from=$list item=item name=f1}
	                <tr class="text-c tab_td">
	                    <td>{$item->user_id}</td>
	                    <td>{$item->user_name}</td>
						<td>
							{if $item->type == 1 ||$item->type == 5 || $item->type == 13 || $item->type == 14 || $item->type == 20 || $item->type == 22 || $item->type == 23 || $item->type == 27 || $item->type == 30}入账{/if}
							{if $item->type == 2 ||$item->type == 4 || $item->type == 11 || $item->type == 12 || $item->type == 21 || $item->type == 26}支出{/if}
						</td>
						<td>{$item->money}</td>
						<td>{$item->add_date}</td>
						<td>
							{if $item->type == 1 }用户充值{/if}
							{if $item->type == 2 }申请提现{/if}
							{if $item->type == 4 }余额消费{/if}
							{if $item->type == 5 }退款{/if}
							{if $item->type == 11 }系统扣款{/if}
							{if $item->type == 12 }给好友转余额{/if}
							{if $item->type == 13 }转入余额{/if}
							{if $item->type == 14 }系统充值{/if}
							{if $item->type == 20 }抽奖中奖{/if}
							{if $item->type == 21 }提现成功{/if}
							{if $item->type == 22 }提现失败{/if}
							{if $item->type == 23 }取消订单{/if}
							{if $item->type == 26}交竞拍押金{/if}
							{if $item->type == 27}退竞拍押金{/if}
							{if $item->type == 30}会员返现{/if}
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
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
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
    $("#otype").val('');
    $("#startdate").val('');
    $("#enddate").val('');
}
</script>
{/literal}
</body>
</html>


