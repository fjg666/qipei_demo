<html>

<head>
    <title>订单列表</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>

<body>
<table border="1px">
    <tr>
        <th>订单编号</th>
        <th>创单时间</th>
        <th>产品名称</th>
        <th>规格</th>
        <th>数量</th>
        <th>小计</th>
        <th>订单总计</th>
        <th>数量</th>

        <th>订单状态</th>
        {if $otype == 't2'}
            <th>拼团状态</th>
        {/if}
        <th>订单类型</th>
        <th>会员ID</th>
        <th>联系人</th>
        <th>电话</th>
        <th>地址</th>

        <th>支付方式</th>
        <th>物流单号</th>
        <th>运费</th>
    </tr>

    {foreach from=$order item=item name=f1}
        {foreach from=$item->products item=item2 name=f2 key=key2}
            <tr>
                <td>`{$item->sNo}</td>
                <td>`{$item->add_time}</td>
                <td>{$item2->product_title}</td>
                <td>{$item2->size}</td>
                <td>{$item2->num}</td>
                <td>
                    {if $item->otype == 'KJ' || $item->otype == 'JP'}
                        {$item->z_price}
                    {else}
                        {$item2->num*$item2->p_price}
                    {/if}
                    元
                    {if $item->otype == 'IN'}
                        +<img src="images/icon/integral_hei.png" alt="" style="width: 15px;height: 15px;">
                        {$item->allow}
                    {/if}
                </td>
                <td>
                    {if $item->otype == 'IN'}
                        <div style="display: flex;align-items: center;">&yen;{$item->p_money}+<img src="images/icon/integral_hei.png" alt="" style="width: 15px;height: 15px;">{$item->p_integral}</div>
                    {else}
                        <div>&yen;{$item->z_price}元</div>
                    {/if}
                </td>
                <td>
                    <div>{$item->num}</div>
                </td>

                <td>
                    {$item->status}
                </td>

                {if $otype == 't2'}
                    <td>
                        <div>
                            <span>{$item->pt_status}</span>
                        </div>
                    </td>
                {/if}

                <td>
                    <span>{if $item->otype == 'pt'}拼团订单{elseif $item->otype == 'JP'}竞拍订单{elseif $item->otype == 'KJ'}砍价订单{elseif $item->otype == 'IN'}积分订单{elseif $item->drawid > 0}抽奖订单{else}普通订单{/if}</span>
                </td>
                <td>{if $item->user_id}{$item->user_id}{else}暂无{/if}</td>
                <td>{if $item->name}{$item->name}{else}暂无{/if}</td>
                <td>{if $item->mobile}`{$item->mobile}{else}暂无{/if}</td>
                <td>{if $item->address}{$item->address}{else}暂无{/if}</td>
                <td>
                    {$item->pay}
                </td>
                <td>
                    {if $item->courier_num}`
                        {foreach from=$item->courier_num item=item3 name=f3 key=key3}
                            <div>物流单号{$key3+1}：{$item3}</div>
                        {/foreach}
                    {else}
                        暂无
                    {/if}
                </td>
                <td>{if $item->freight}￥{$item->freight}{else}免邮{/if}</td>
            </tr>
        {/foreach}
    {/foreach}
</table>
</body>

</html>