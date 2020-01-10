<!DOCTYPE html>
<html>
<head>
	<title>产品销量报表</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body>
	<table border="1px">
		<tr>
			<th colspan="10" style="height: 100px;font-size: 20px;">商品销量排行报表</th>
		</tr>
		<tr>
			<th colspan="10">导出时间:{$now_date}</th>
		</tr>


        <tr class="text-c">
            <th width="50">商品ID</th>
            <th width="150">商品标题</th>
            <th width="150">分类名称</th>
            <th width="130">发布时间</th>
            <th width="150">销量</th>
            <th width="150">单价</th>
            <th width="150">销售额</th>
           
        </tr>
        {foreach from=$list item=item name=f1}
                <tr class="text-c">
                    <td>{$item->id}</td>
                    <td>{$item->product_title}</td>
                    <td>{$item->product_class} </td>
                    <td style="min-width: 40px;">{$item->add_date}</td>
                    <td style="min-width: 70px;">{$item->volume}</td>
                    <td><span style="color:red;">¥{$item->price}</span></td>
                    <td><span style="color:red;">¥{$item->z_price}</span></td>
                </tr>
        {/foreach}
		
	</table>

</body>
</html>