<html>
	<head>
		<title>拼团开团记录</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>

	<body>
		<table border="1px">
			<tr>
				<th colspan="11" style="height: 100px;font-size: 20px;">拼团产品列表</th>
			</tr>
			<tr>
				<th colspan="11">导出时间:{$now_data}</th>
			</tr>

            <tr class="text-c">
                <th width="50">ID</th>
                <th width="150">活动名称</th>
                <th width="150">商品名称</th>
                <th width="80">拼团类型</th>
                <th width="80">零售价</th>
                <th width="80">团长价格</th>
                <th width="100">参团价格</th>
                <th width="250">活动有效时间</th>
                <th width="150">创建人</th>
                <th width="150">拼团状态</th>
                <th width="150">开团时间</th>

            </tr>
            {foreach from=$list item=item name=f1}
                <tr class="text-c">
                    <td>{$item->id}</td>
                    <td>{$item->group_title}</td>
                    <td>{$item->p_name}</td>
                    <td>{$item->groupman}人团</td>
                    <td>{$item->price}</td>
                    <td>{$item->openmoney}</td>
                    <td>{$item->canmoney}</td>
                    <td>开始时间：{$item->start_time}<br/>结束时间：{$item->end_time}</td>
                    <td>{$item->user_name}</td>
                    <td>
                        {if $item->ptstatus==1}
                            拼团中
                        {elseif $item->ptstatus==3}
                            失败
                        {elseif $item->ptstatus==2}
                            成功
                        {/if}
                    </td>
                    <td>{$item->add_time}</td>
                </tr>
            {/foreach}			
		</table>
	</body>
</html>