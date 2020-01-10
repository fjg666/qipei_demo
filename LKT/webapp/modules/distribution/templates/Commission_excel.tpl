<html>
<head>
<title>list</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body> 
<table border="1px">
  <tr>
    <td align="center">用户id</td>
    <td align="center">订单号</td>
    <td align="center">购买员</td>
    <td align="center">分销员</td>
    <td align="center">分销等级</td>
    <td align="center">电话</td>
    <td align="center">订单类型</td>
    <td align="center">金额</td>
    <td align="center">时间</td>
  </tr>
  {foreach from=$list item=item name=f1}
  <tr>
    <td>{$item->gm_id}</td>
    <td>`{$item->sNo}</td>
    <td>{$item->gm_name}</td>
    <td>{$item->fx_name}</td>
    <td>{$item->typename}</td>
    <td>{$item->mobile}</td>
    <td>
      {if $item->type == 1 }转入（收入）消费金{/if}
      {if $item->type == 2 }提现{/if}
      {if $item->type == 4 }使用消费金{/if}
      {if $item->type == 5 }收入消费金{/if}
      {if $item->type == 6 }系统扣款{/if}
      {if $item->type == 7 }消费金解封{/if}
    </td>
    <td>{$item->money}元</td>
    <td>{$item->add_date}</td>
  </tr>
  {/foreach}
</table>
</body>
</html>