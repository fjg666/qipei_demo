<html>

	<head>
		<title>单据列表</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>

	<body>
		<table border="1px">
			<tr>
				<th>订单编号</th>
				<th>商品名称</th>
				<th>商品数量</th>
				<th>寄件人</th>
				<th>收件人名称</th>
				<th>联系电话</th>
				<th>联系地址</th>
				<th>下单时间</th>
				<th>付款时间</th>
				<th>发货时间</th>
				<th>备注</th>
			</tr>

			{foreach from=$list item=item name=f1}
				{foreach from=$item->goods item=item2 name=f2 key=key2}
					<tr>
						<td>`{$item->sNo}</td>
						<td>{$item2->p_title}</td>
						<td>{$item2->p_num}</td>
						<td>{$item->sender}</td>
						<td>{$item->recipient}</td>
						<td>`{$item->r_mobile}</td>
						<td>{$item->r_sheng}{$item->r_shi}{$item->r_xian}{$item->r_address}</td>
						<td>{$item->add_time}</td>
						<td>{$item->pay_time}</td>
						<td>{$item->deliver_time}</td>
						<td>{$item->remark}</td>
					</tr>
				{/foreach}
			{/foreach}
		</table>
	</body>

</html>