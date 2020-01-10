<html>
<head>
	<title>用户消费报表</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body>
	<table border="1px">
		<tr>
			<th colspan="10" style="height: 100px;font-size: 20px;">用户消费排行报表</th>
		</tr>
		<tr>
			<th colspan="10">导出时间:{$now_date}</th>
		</tr>


        <tr class="text-c">
            <th width="50">ID</th>
            <th width="150">用户昵称</th>
            <th width="150">用户来源</th>
            <th width="150">订单总数量</th>
            <th width="130">订单总金额</th>
            <th width="150">退款数量</th>
            <th width="150">退款总金额</th>
            <th width="150">有效订单总数量</th>
            <th width="100">有效订单总金额</th>
           
        </tr>
        {foreach from=$res item=item name=f1}
        <tr>
            <th>{$item->id}</th>
            <th>{$item->user_name}</th>
            <th>{if $item->source == 1}小程序{else}手机App{/if}</th>
            <th>{$item->num}</th>
            <th>{$item->z_price}</th>
            <th>{$item->back_num}</th>
            <th>{$item->back_z_price}</th>
            <th>{$item->real_num}</th>
            <th>{$item->real_z_price}</th>
        </tr>
        {/foreach}
	</table>
</body>
</html>