<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr>
        <th width="150">用户ID</th>
        <th width="150">用户昵称</th>
        <th width="130">充值总金额</th>
        <th width="50">来源</th>
        <th width="50">手机号码</th>
        <th width="150">注册时间</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr>
            <td>{$item->user_id}</td>
            <td>{$item->user_name}</td>
            <td>{$item->r_money}</td>
            <td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
            <td style="vnd.ms-excel.numberformat:@">{$item->mobile}</td>
            <td>{$item->Register_data}</td>
        </tr>
    {/foreach}
</table>
</body>
</html>