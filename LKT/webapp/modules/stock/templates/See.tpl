{include file="../../include_path/header.tpl" sitename="DIY头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序号</th>
                    <th >商品编码</th>
                    <th class="tab_title">商品名称</th>
                    <th >售价</th>
                    <th>规格</th>
                    <th>状态</th>
                    <th >入库/出库</th>
                    <th class="tab_time">发生时间</th>
                    <th >备注</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td>{$smarty.foreach.f1.iteration}</td>
                    <td>{$item->product_number}</td>
                    <td>
                        <div style="float: left;">
                            <img onclick="pimg(this)" src="{$item->imgurl}" style="width: 60px;height: 60px;">
                        </div>
                        <div >{$item->product_title}</div>
                    </td>
                    <td>￥{$item->price}</td>
                    <td>{$item->specifications}</td>
                    <td>
                        <div class="tab_block">
                            {if $item->status == 2}
                                <span style="background-color: #5eb95e;" class="badge statu badge-success">已上架</span>
                            {elseif $item->status == 3}
                                <span class="badge statu badge-default">已下架</span>
                            {elseif $item->status == 1}
                                <span class="badge statu badge-default">待上架</span>
                            {/if}
                        </div>
                    </td>
                    {if $item->type == 0}
                        {if $item->flowing_num >= 15}
                            <td style="color: #0abf0a;font-weight:bold">+{$item->flowing_num}</td>
                        {else}
                            <td style="color: #0abf0a;">+{$item->flowing_num}</td>
                        {/if}
                    {elseif $item->type == 1}
                        {if $item->flowing_num >= 15}
                            <td style="color:red;font-weight:bold">-{$item->flowing_num}</td>
                        {else}
                            <td style="color:red;">-{$item->flowing_num}</td>
                        {/if}

                    {elseif $item->type == 2}
                        <td>{$item->flowing_num}</td>
                    {/if}
                    <td class="tab_time">{$item->add_date}</td>
                    <td ></td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_h20"></div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">

var aa=$(".pd-20").height()-56;
var bb=$(".table-border").height();
if(aa<bb){
	$(".page_h20").css("display","block")
}else{
	$(".page_h20").css("display","none")
}
</script>
{/literal}
</body>
</html>