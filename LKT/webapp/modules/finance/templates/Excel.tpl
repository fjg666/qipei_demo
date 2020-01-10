<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr>
        <th width="40">序</th>
        <th width="150">用户名称</th>
        <th width="130">来源</th>
        <th width="150">联系电话</th>
        <th width="100">状态</th>
        <th width="130">申请时间</th>
        <th width="150">提现金额</th>
        <th width="150">提现手续费</th>
        <th width="150">持卡人姓名</th>
        <th width="100">银行名称</th>
        <th width="150">支行名称</th>
        <th width="150">卡号</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr>
            <td>{$smarty.foreach.f1.iteration}</td>
            <td>{$item->name}</td>
            <td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
            <td>{$item->mobile}</td>
            <td>{if $item->status == 0}<span style="color: #ff2a1f;">待审核</span>{elseif $item->status == 1}<span style="color: #30c02d;">审核通过</span>{else}<span style="color: #7A7A7A;">已拒绝</span>{/if}</td>
            <td>{$item->add_date}</td>
            <td>{$item->money}元</td>
            <td>{$item->s_charge}元</td>
            <td>{$item->Cardholder}</td>
            <td>{$item->Bank_name}</td>
            <td>{$item->branch}</td>
            <td>`{$item->Bank_card_number}</td>
        </tr>
    {/foreach}
</table>
</body>
</html>