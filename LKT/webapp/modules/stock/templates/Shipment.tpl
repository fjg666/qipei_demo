{include file="../../include_path/header.tpl" sitename="DIY头部"}

<title>出货详情</title>
{literal}
    <style>
        td a{
            width: 29%;
            float: left;
            margin: 2%!important;
        }
        .btn1{
            width: 80px;
            height: 40px;
            line-height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            float: left;
            color: #6a7076;
            background-color: #fff;
        }
        .btn1:hover{
            text-decoration: none;
        }
        .swivch a:hover{
            text-decoration: none;
            background-color: #2481e5!important;
            color: #fff!important;
        }
    </style>
{/literal}
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">

    <div class="swivch page_bgcolor swivch_bot">
        {if $button[0] == 1}
            <a href="index.php?module=stock" class="btn1 ">库存列表</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=stock&action=Warning" class="btn1 " >库存预警</a>
        {/if}
        {if $button[2] == 1}
            <a href="index.php?module=stock&action=Enter" class="btn1 " >入货详情</a>
        {/if}
        {if $button[3] == 1}
            <a href="index.php?module=stock&action=Shipment" class="btn1 swivch_active" style="border-right: 1px solid #ddd!important;">出货详情</a>
        {/if}
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c text_c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="stock" />
            <input type="hidden" name="action" value="Shipment" />
            <input type="text" name="product_number" size='8' value="{$product_number}" id="product_number" placeholder="请输入商品编码" style="width:200px" class="input-text">
            <input type="text" name="product_title" size='8' value="{$product_title}" id="product_title" placeholder="请输入商品名称" style="width:200px" class="input-text">
            <input type="text" class="input-text seach_bottom" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">

            <span class="select seach_bottom" style="border: 0;vertical-align: middle;">至</span>
            <input type="text" class="input-text seach_bottom" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;border-radius: 5px;" class="reset" onclick="empty()" />

            <input name="" id="btn9" class="btn btn-success" type="submit" value="查询">
            <input id="btn1" class="btn btn-success" type="button" value="导出" onclick="excel(location.href)" style="float: right;">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
            <tr class="text-c tab_tr">
                <th class="tab_num">序号</th>
                <th >商品编码</th>
                <th class="tab_title">商品名称</th>
                <th >售价</th>
                <th>规格</th>
                <th >状态</th>
                <th >出库量</th>
                <th >总库存</th>
                <th class="tab_time">出库时间</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
                    <td>{$item->product_number}</td>
                    <td class="tab_title">
                        <div style="float: left;">
                            <img onclick="pimg(this)" src="{$item->imgurl}" style="width: 60px;height: 60px;">
                        </div>
                        <div >{$item->product_title}</div>
                    </td>
                    <td>￥{$item->price}</td>
                    <td>{$item->specifications}</td>
                    <td>
                        <div class="tab_block">
                            <!-- 0=待审核，1=审核通过，2=审核不通过 -->
                            {if $item->status == 2}
                                <span style="background-color: #5eb95e;" class="badge statu badge-success">已上架</span>
                            {elseif $item->status == 3}
                                <span class="badge statu badge-default">已下架</span>
                            {elseif $item->status == 1}
                                <span class="badge statu badge-default">待上架</span>
                            {/if}
                        </div>
                    </td>
                    <td style="color:red;">{$item->flowing_num}</td>
                    <td>{$item->total_num}</td>
                    <td class="tab_time">{$item->add_date}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
$(function(){
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-46-16-16-($('.tb-tab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')
});
function empty() {
    $("#product_number").val('');
    $("#product_title").val('');
    $("#startdate").val('');
    $("#enddate").val('');
}
function excel(url) {
    export_popup(url);
}
</script>
{/literal}
</body>
</html>