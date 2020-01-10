<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr>
        <th width="150">用户ID</th>
        <th width="130">用户名称</th>
        <th width="130">来源</th>
        <th width="150">余额</th>
        <th width="150">注册时间</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr class="text-c">
            <td>{$item->user_id}</td>
            <td>{$item->user_name}</td>
            <td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
            <td>
                {$item->money}
            </td>
            <td>{$item->Register_data}</td>
        </tr>
    {/foreach}
</table>
</body>
</html>