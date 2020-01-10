{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style type="text/css">
	.btn1{
    	width: 112px;
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
<body>
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;"  onclick="location.href='index.php?module=coupon';">卡券 </a>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;"  onclick="location.href='index.php?module=coupon';">优惠券列表 </a>
    <span class="c-gray en">&gt;</span>
    查看
</nav>
<div class="pd-20 page_absolute">
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="coupon" />
            <input type="hidden" name="action" value="Coupon" />
            <input type="hidden" name="id" value="{$hid}" />
            <input type="hidden" name="ok" value="1" />
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />

            <input type="text" name="sNo" value="{$sNo}" id="sNo" placeholder="请输入订单编号" style="width:180px" class="input-text">
            <input type="text" name="name" size='8' value="{$name}" id="name" placeholder="请输入会员名称" style="width:180px" class="input-text">
            <select name="status" id="status" class="select" style="width: 180px;height: 31px;vertical-align: middle;">
                <option  value="0">请选择优惠券状态</option>
                <option  value="1" {if $status == 1}selected{/if}>过期</option>
                <option  value="2" {if $status == 2}selected{/if}>未过期</option>
            </select>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />
            <input name="" id="" class="btn btn-success" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序</th>
                    <th class="tab_num">用户ID</th>
                    <th>会员名称</th>
                    <th>优惠券金额/折扣</th>
                    <th>是否使用</th>
                    <th class="tab_time">领取时间</th>
                    <th class="tab_time">到期时间</th>
                    <th >关联订单号</th>
                    <th class="tab_three">操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
                    <td class="tab_num">{$item->user_id}</td>
                    <td>{$item->user_name}</td>
                    <td>
                        {if $item->activity_type == 2}
                            {$item->money}
                        {elseif $item->activity_type == 3}
                            {$item->discount}折
                        {elseif $item->activity_type == '会员赠券'}
                            {if $item->money != 0}
                                {$item->money}
                            {else}
                                {$item->discount}折
                            {/if}
                        {/if}
                    </td>
                    <td>{if $item->type == 0}<span style="color:#30c02d;">正常</span>{elseif $item->type == 1}<span>使用中</span>{elseif $item->type == 2}<span style="color:#ff2a1f">已使用</span>{elseif $item->type == 3}<span style="color: #7A7A7A;">已过期</span>{/if}</td>
                    <td class="tab_time">{$item->add_time}</td>
                    <td class="tab_time">{$item->expiry_time}</td>
                    <td >{$item->sNo}</td>
                    <td class="tab_three">
                        <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('是否删除此优惠券？',{$item->id},'index.php?module=coupon&action=Coupondel&id=','删除')">
                            <img src="images/icon1/del.png"/>&nbsp;删除
                        </a>
                    </td>
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
function empty() {
    $("#sNo").val('');
    $("#name").val('');
    $("#status").val(0);
}
$(function(){
    var xianshi = $("#ajaxSe").val();
    var height = (60 + xianshi*90) + 'px';
    $('.tab_table').css('height',height);
});
var aa=$(".pd-20").height()-56-36-16-16-11;
var bb=$(".table-border").height();
if(aa<bb){
    $(".page_h20").css("display","block")
}else{
    $(".page_h20").css("display","none")
}
function confirm (content,id,url,content1){
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="height: 223px!important;">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div style="height: 50px;position: relative;top:60px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:86px">
                    <button class="closeMask" onclick=closeMask1() style="background: #fff;color: #008DEF;border: 1px solid #008DEF;margin-right: 4px;">取消</button>
                    <button class="closeMask" style="background: #008DEF;color: #fff;border: 1px solid #008DEF;" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
                </div>
            </div>
        </div>
    `)
}
</script>
{/literal}
</body>
</html>