<html>
<head>
    <title>list</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<table border="1px">
    <tr class="text-c tab_tr">
        <th class="tab_num">店铺ID</th>
        <th class="tab_imgurl">店铺信息</th>
        <th>联系人</th>
        <th class="tab_title">联系电话</th>
        <th class="tab_time">申请/审核时间</th>
        <th>审核状态</th>
    </tr>
    {foreach from=$list item=item name=f1}
        <tr class="text-c tab_td">
            <td class="tab_num">{$item->id}</td>
            <td class="tab_news tab_t">
                <div class="tab_good">
                    <div class="goods-info tab_left">
                        <div class="mt-1" style="font-weight:bold;color:rgba(65,70,88,1);font-size:14px;">店铺名称：{$item->name} </div>
                        <div class="mt-1" style="font-size: 14px;color: #888F9E;font-weight:400;margin: 6px 0px;">用户ID：{$item->user_id}</div>
                        <div style="font-size: 14px;color: #888F9E;font-weight:400;">所属用户：{$item->user_name}</div>
                    </div>
                </div>
            </td>
            <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->realname}</td>
            <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->tel}</td>
            <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{if $item->review_status == 0}{$item->add_time}{else}{$item->review_time}{/if}</td>
            <td>
                {if $item->review_status == 0}
                    <span class="text-info" style="color: #FE9331;">待审核</span>
                {elseif $item->review_status == 1}
                    <span class="text-success" style="color: green;">审核通过</span>
                {else}
                    <span class="text-warning" style="color: #FF453D;">审核不通过</span>
                {/if}
            </td>
        </tr>
    {/foreach}
</table>
</body>
</html>