<html>
<head>
<title>list</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body> 
<table border="1px">
  <tr class="text-c">
      <th>序号</th>
      <th >用户id</th>
      <th >产品名称</th>
      <th >产品价格</th>
      <th style="width:50px;" >数量</th>
      <th style="width:100px;" >订单号</th>
      <th style="width:100px;" >发布时间</th>
      <th style="width:100px;" >类型</th>
      <th style="width:100px;" >状态</th>
  </tr>
            {foreach from=$list item=item name=f1}
                <tr class="text-c">   
                    <td>{$item->id}</td>
                    <td>{$item->user_id}</td>
                    <td style="text-align:left!important;width: 400px;">{$item->p_name}</td>
                    <td>{$item->p_price}</td>
                    <td>{$item->num}</td>
                    <td>`{$item->r_sNo}</td>
                    <td style="width:100px;">`{$item->add_time}</td>
                    <td style="width: 100px;">
                        {if $item->re_type == 2}
                            <span >仅退款</span>
                        {elseif $item->re_type == 1}
                            <span >退货退款</span>
                        {else}
                            <span >换货</span>
                        {/if}
                    </td>
                    <td style="width:100px;">
                        {if $item->r_type == 0}<span>审核中</span>
                        {elseif $item->r_type == 1 || $item->r_type == 6}<span >待买家发货</span>
                        {elseif $item->r_type == 2 || $item->r_type == 8}<span >已拒绝</span>
                        {elseif $item->r_type == 3 }<span>待商家收货</span>
                        {elseif $item->r_type == 4 || $item->r_type == 9}<span >已退款</span>
                        {else}<span style="color: #ff2a1f;">拒绝并退回商品</span>{/if}
                    </td>
                </tr>
            {/foreach}
</table>
</body>
</html>