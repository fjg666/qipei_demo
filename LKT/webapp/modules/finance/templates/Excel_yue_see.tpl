<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr>
        <th width="50" >用户ID</th>
        <th width="130" >用户名称</th>
        <th width="130" >入账/支出</th>
        <th width="150" >金额</th>
        <th width="150" >交易时间</th>
        <th width="150" >备注</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr class="text-c">
            <td>{$item->user_id}</td>
            <td>{$item->user_name}</td>
            <td>
                {if $item->type == 1 ||$item->type == 5 || $item->type == 13 || $item->type == 14 || $item->type == 20 || $item->type == 22 || $item->type == 23}入账{/if}
                {if $item->type == 2 ||$item->type == 4 || $item->type == 11 || $item->type == 12 || $item->type == 21}支出{/if}
            </td>
            <td>{$item->money}</td>
            <td>{$item->add_date}</td>
            <td>
                {if $item->type == 1 }用户充值{/if}
                {if $item->type == 2 }申请提现{/if}
                {if $item->type == 4 }余额消费{/if}
                {if $item->type == 5 }退款{/if}
                {if $item->type == 11 }系统扣款{/if}
                {if $item->type == 12 }给好友转余额{/if}
                {if $item->type == 13 }转入余额{/if}
                {if $item->type == 14 }系统充值{/if}
                {if $item->type == 20 }抽奖中奖{/if}
                {if $item->type == 21 }提现成功{/if}
                {if $item->type == 22 }提现失败{/if}
                {if $item->type == 23 }取消订单{/if}
            </td>
        </tr>
    {/foreach}
</table>
</body>
</html>