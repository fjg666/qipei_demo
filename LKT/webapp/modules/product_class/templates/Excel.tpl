<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr class="text-c tab_tr">
        <th class="tab_num">分类ID</th>
        <th>分类名称</th>
        <th>分类级别</th>
        <th>添加时间</th>
    </tr>
    {foreach from=$list1 item=item name=f1}
        <tr class="text-c tab_td">
            <td class="tab_num">{$item->cid}</td>
            <td>{$item->pname}</td>
            <td>{$item->level}</td>
            <td>{$item->add_date}</td>
        </tr>
    {/foreach}
</table>
</body>
</html>