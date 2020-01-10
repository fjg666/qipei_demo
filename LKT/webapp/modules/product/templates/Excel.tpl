<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>

<table border="1px">
    <tr>
        <th>商品ID</th>
        <th >商品标题</th>
        <th>分类名称</th>
        <th>库存</th>
        <th>商品状态</th>
        <th>销量</th>
        <th >发布时间</th>
        <th>商品品牌</th>
        <th>价格</th>
    </tr>

    {foreach from=$list item=item name=f1}
        <tr >
            <td>{$item->id}</td>
            <td >{$item->product_title}
                <div >
                {foreach from=$item->s_type item=item1 name=f2}
                    {if $item1 == 1}新品{/if}
                    {if $item1 == 2}热销{/if}
                    {if $item1 == 3}推荐{/if}
                {/foreach}
                </div>
            </td>
            <td >{$item->pname}</td>

            <td {if $item->num <= $item->min_inventory}style="color: red;" {/if}>{$item->num}</td>

            <td>
                {if $item->status == 2}
                    已上架
                {elseif $item->status == 3}
                    已下架
                {elseif $item->status == 1}
                    待上架
                {/if}
            </td>

            <td >{$item->volume}</td>
            <td >{$item->add_date}</td>
            <td >{if $item->brand_name != ''}{$item->brand_name}{else}无{/if}</td>
            <td>{$item->price}</td>
        </tr>
    {/foreach}
</table>
</body>
</html>