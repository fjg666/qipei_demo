<html>
	<head>
		<title>用户列表</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>

	<body>
		<table border="1px">
			<tr>
				<th colspan="10" style="height: 100px;font-size: 20px;">用户列表</th>
			</tr>
			<tr>
				<th colspan="10">导出时间:{$now_data}</th>
			</tr>

            <tr class="text-c">
                <th width="50">会员ID</th>
                <th width="150">会员账号</th>
                <th width="150">会员手机号码</th>
                <th width="150">账户余额</th>
                <th width="130">积分余额</th>
                <th width="150">订单数</th>
                <th width="150">交易金额</th>
                <th width="150">分享次数</th>
                <th width="150">注册时间</th>
            </tr>
            {foreach from=$list item=item name=f1}
                <tr class="text-c">
                    <td>{$item->user_id}</td>
                    <td>{$item->zhanghao}</td>
                    <td>{$item->mobile}</td>
                    <td>￥{$item->money}</td>
                    <td>{$item->score}</td>
                    <td>{$item->z_num}</td>
                    <td>{$item->z_price}</td>
                    <td>{$item->share_num}</td>
                    <td>{$item->Register_data}</td>
                </tr>
            {/foreach}			
		</table>
	</body>
</html>