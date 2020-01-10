<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>

<table border="1px">
    <tr>
        <th class="tab_num">ID</th>
        <th>品牌名称</th>
        <th>所属分类</th>
        <th class="tab_time">添加时间</th>
    </tr>

    {foreach from=$list item=item name=f1}
        <tr >
            <td>{$item->brand_id}</td>
            <td >{$item->brand_name}</td>
            <td >{$item->class_name}</td>
            <td >{$item->brand_time}</td>
        </tr>
    {/foreach}
</table>
</body>
</html>