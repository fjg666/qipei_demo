<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr>
        <th width="100">用户ID</th>
        <th width="130">用户名</th>
        <th width="150">手机号码</th>
        <th width="150">充值积分</th>
        <th width="130">来源</th>
        <th width="150">时间</th>
        <th width="150">充值方式</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr class="text-c">
            <td>{$item->user_id}</td>
            <td>{$item->user_name}</td>
            <td>
                {$item->mobile}
            </td>
            <td>
                {if $item->type ==0 ||$item->type ==2|| $item->type ==4 || $item->type ==6 || $item->type ==7}+{$item->sign_score}{/if}
                {if $item->type ==1 ||$item->type ==3 ||$item->type ==5}-{$item->sign_score}{/if}
            </td>
            <td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
            <td>{$item->sign_time}</td>
            <td>
                {if $item->type == 0 }签到领积分{/if}
                {if $item->type == 1 }消费积分{/if}
                {if $item->type == 2 }首次关注得积分{/if}
                {if $item->type == 3 }转积分给好友{/if}
                {if $item->type == 4 }好友转积分{/if}
                {if $item->type == 5 }系统扣除{/if}
                {if $item->type == 6 }系统充值{/if}
            </td>
        </tr>
    {/foreach}
</table>
</body>
</html>