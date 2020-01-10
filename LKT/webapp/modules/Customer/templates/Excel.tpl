<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>

<table border="1px">
    <tr>
        <th>商城ID</th>
        <th>姓名</th>
        <th>手机</th>
        <th>价格</th>
        <th>公司名称</th>
        <th class="tab_time">购买时间</th>
        <th class="tab_time">到期时间</th>
        <th>状态</th>
    </tr>

    {foreach from=$list item=item name=f1}
        <tr >
            <td>{$item->id}</td>
            <td>{$item->name}</td>
            <td>{$item->mobile}</td>
            <td>{$item->price}</td>
            <td>{$item->company}</td>
            <td class="tab_time">{$item->add_date}</td>
            <td class="tab_time">{$item->end_date}</td>
            <td>
                {if $item->status == 0}
                    <span style="color: #30c02d;">启用</span>
                {elseif $item->status == 1}
                    <span style="color: #ff2a1f;">到期</span>
                {else}
                    <span style="color: #ff2a1f;">锁定</span>
                {/if}
            </td>
        </tr>
    {/foreach}
</table>
</body>
</html>