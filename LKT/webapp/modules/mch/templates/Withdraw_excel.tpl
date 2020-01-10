<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr class="text-c tab_tr">
        <th class="tab_num">序号</th>
        <th class="tab_imgurl" >店铺</th>
        <th >联系电话</th>
        <th >状态</th>
        <th class="tab_time">申请时间</th>
        <th >提现金额</th>
        <th >提现手续费</th>
        <th >持卡人姓名</th>
        <th >银行名称</th>
        <th >支行名称</th>
        <th >卡号</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr>
            <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
            <td class="tab_imgurl" >
                <div class="tab_good">
                    <div class="goods-info tab_left" style="width: 150px;margin: auto 5px;">
                        <div class="mt-1" style="font-weight:bold;color:rgba(65,70,88,1);font-size:14px;">{$item->mch_name} </div>
                        <div class="mt-1" style="font-size: 14px;color: #888F9E;font-weight:400;margin: 6px 0px;">用户ID：{$item->user_id}</div>
                    </div>
                </div>
            </td>
            <td>{$item->mobile}</td>
            <td>{if $item->status == 0}<span style="color: #ff2a1f;">待审核</span>{elseif $item->status == 1}<span style="color: #30c02d;">审核通过</span>{else}<span style="color: #7A7A7A;">已拒绝</span>{/if}</td>
            <td class="tab_time">{$item->add_date}</td>
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