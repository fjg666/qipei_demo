{include file="../../include_path/header.tpl" sitename="头部"}

{literal}
<style type="text/css">
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
input:focus::-webkit-input-placeholder {
    color: transparent;
    /* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}

#btn8:hover {
    border: 1px solid #2890ff !important;
    color: #2890ff !important;
}

#btn9:hover {
    background-color: #2481e5 !important;
}

form .select {
    width: 140px !important;
}

.proSpan {
    font-size: 12px;
    border-radius: 4px;
    color: #ffffff;
    margin: 0px 5px;
    padding: 0px 3px;
}

.xp {
    background-color: #68c8c7;
}

.rx {
    background-color: #ff6c60;
}

.tj {
    background-color: #feb04c;
}
a img{
	margin-top: -3px!important;
}
       .stopCss:hover {
			cursor: not-allowed;
		}
	
	.stopCss {
		width: 56px;
		height: 22px;
		line-height: 22px;
		border: 1px solid #e9ecef;
		color: #d8dbe8!important;
		font-size: 12px;
		border-radius: 2px;
		line-height: 22px;
		display: inline-block;
		margin-left: -2%;
		margin-bottom: 8px;
	}
	.tab_dat a{
		width: 56px!important;
	}
</style>
{/literal}
<body>
<nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    店铺
    <span class="c-gray en">&gt;</span>
    商品审核记录
</nav>

<div class="pd-20 page_absolute">
    <!--导航表格切换-->
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=mch&aciton=Index" class="btn1 " style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">店铺</a>
        {if $button[0] == 1}
            <a href="index.php?module=mch&action=List" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">审核列表</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=mch&action=Set" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">多商户设置</a>
        {/if}
        {if $button[2] == 1}
            <a href="index.php?module=mch&action=Product" class="btn1 swivch_active" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">商品审核</a>
        {/if}
        {if $button[3] == 1}
            <a href="index.php?module=mch&action=Withdraw" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">提现审核</a>
        {/if}
        {if $button[4] == 1}
            <a href="index.php?module=mch&action=Withdraw_list" class="btn1" style="height: 42px !important;border:0!important;width: 112px;">提现记录</a>
        {/if}
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>

    <div class="text-c text_c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="mch"/>
            <input type="hidden" name="action" value="Product"/>

            <select name="mch_status" class="select" style="width: 80px;height: 31px;vertical-align: middle;" id="mch_status">
                <option value="0">请选择审核类型</option>
                <option {if $mch_status == 1}selected='selected'{/if} value="1">待审核</option>
                {*<option {if $mch_status == 2}selected='selected'{/if} value="2">审核通过</option>*}
                <option {if $mch_status == 3}selected='selected'{/if} value="3">审核未通过</option>
            </select>
            <input type="text" name="product_title" size='8' value="{$product_title}" id="product_title" placeholder="请输入商品名称" style="width:200px" class="input-text">
            <input type="text" name="mch_id" size='8' value="{$mch_id}" id="mch_id" placeholder="请输入店铺ID" style="width:200px" class="input-text">
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()"/>
            <input name="" id="btn9" class="btn btn-success" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table-border tab_content">
            <thead>
            <tr class="text-c tab_tr">
                <th>商品ID</th>
                <th class="tab_imgurl">商品图片</th>
                <th class="tab_title">商品标题</th>
                <th>店铺ID</th>
                <th>店铺名称</th>
                <th>分类名称</th>
                <th>库存</th>
                <th>商品状态</th>
                <th>销量</th>
                <th>发布人</th>
                <th class="tab_time">发布时间</th>
                <th>商品品牌</th>
                <th>价格</th>
                <th>显示位置</th>
                <th class="tab_dat">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td>{$item->id}</td>
                    <td class="tab_imgurl">
                        {if $item->img != ''}
                            <span>暂无图片</span>
                        {else}
                            <img onclick="pimg(this)" src="{$item->imgurl}">
                        {/if}
                    </td>
                    <td class="tab_title" style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->product_title}
                        <div class="tab_clear">
                            {foreach from=$item->s_type item=item1 name=f2}
                                {if $item1 == 1}<span class="proSpan xp">新品</span>{/if}
                                {if $item1 == 2}<span class="proSpan rx">热销</span>{/if}
                                {if $item1 == 3}<span class="proSpan tj">推荐</span>{/if}
                            {/foreach}
                        </div>
                    </td>
                    <td>{$item->mch_id}</td>
                    <td>{$item->shop_name}</td>
                    <td>{$item->pname}</td>
                    <td {if $item->num <= $item->min_inventory}style="color: red;" {/if}>{$item->num}</td>
                    <td class="tab_editor">
                        <div class="tab_block">
                            {if $item->mch_status == 1}
                            <span style="color: #FE9331;">待审核</span>
                                                                              
                            {elseif $item->mch_status == 2}
                                <!-- 审核通过 -->
                                {if $item->status == 0}
                                    <span style="background-color: #5eb95e;" class="badge badge-success">已上架</span>
                                {else}
                                    <span class="badge badge-default">已下架</span>
                                {/if}
                            {else}
                            <span style="color: #FF453D;">审核不通过</span>
                            {/if}
                        </div>
                    </td>
                    <td>{$item->volume}</td>
                    <td>{$item->realname}</td>
                    <td class="tab_time">{$item->add_date}</td>
                    <td>{if $item->brand_name != ''}{$item->brand_name}{else}无{/if}</td>
                    <td><span class="tab_span">{$item->price}</span></td>
                    <td>
                        {foreach from=$item->show_adr item=item2 name=f3}
                            {if $item2 == 1}<span style="display: block;">首页</span>{/if}
                            {if $item2 == 2}<span style="display: block;">购物车</span>{/if}
                        {/foreach}
                    </td>
                    <td class="tab_dat">
                        {if $button[6] == 1}
                            <a href="index.php?module=mch&action=Product_see&id={$item->id}"
                               title="查看">
                                <img src="images/icon1/ck.png"/>&nbsp;查看
                            </a>
                        {/if}

                        {if $button[5] == 1}
                            {if $item->mch_status == 1}
                                <a onclick="shenhe(this,{$item->id},1)" title="通过">
                                    <img src="images/icon1/shenhe_success.png"/>&nbsp;通过
                                </a>
                                <a onclick="shenhe(this,{$item->id},2)" title="拒绝">
                                    <img src="images/icon1/shenhe_fail.png"/>&nbsp;拒绝
                                </a>
                            {else}
                                <div class="stopCss">
                                    <img style="margin-top: -3px;" src="images/icon1/shenhe_success_gray.png" />&nbsp;通过
                                </div>
                                <div class="stopCss">
                                    <img style="margin-top: -3px;" src="images/icon1/shenhe_fail_gray.png" />&nbsp;拒绝
                                </div>
                            {/if}
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    {if $pages_show != ''}
        <div class="tb-tab">{$pages_show}</div>
    {/if}
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
// 根据框架可视高度,减去现有元素高度,得出表格高度
var Vheight = $(window).height()-56-42-16-56-16-($('.tb-tab').text()?70:0)
$('.table-scroll').css('height',Vheight+'px')

function empty() {
    $("#mch_status").val('0');
    $("#product_title").val('');
    $("#mch_id").val('');
}

function pimg(obj) {
    var _this = $(obj);//将当前的pimg元素作为_this传入函数
    imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
}

function imgShow(outerdiv, innerdiv, bigimg, _this) {
    var src = _this.attr("src");//获取当前点击的pimg元素中的src属性
    $(bigimg).attr("src", src);//设置#bigimg元素的src属性

    /*获取当前点击图片的真实大小，并显示弹出层及大图*/
    $("<img/>").attr("src", src).load(function () {
        var windowW = $(window).width();//获取当前窗口宽度
        var windowH = $(window).height();//获取当前窗口高度
        var realWidth = this.width;//获取图片真实宽度
        var realHeight = this.height;//获取图片真实高度
        var imgWidth, imgHeight;
        var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

        if (realHeight > windowH * scale) {//判断图片高度
            imgHeight = windowH * scale;//如大于窗口高度，图片高度进行缩放
            imgWidth = imgHeight / realHeight * realWidth;//等比例缩放宽度
            if (imgWidth > windowW * scale) {//如宽度扔大于窗口宽度
                imgWidth = windowW * scale;//再对宽度进行缩放
            }
        } else if (realWidth > windowW * scale) {//如图片高度合适，判断图片宽度
            imgWidth = windowW * scale;//如大于窗口宽度，图片宽度进行缩放
            imgHeight = imgWidth / realWidth * realHeight;//等比例缩放高度
        } else {//如果图片真实高度和宽度都符合要求，高宽不变
            imgWidth = realWidth;
            imgHeight = realHeight;
        }
        $(bigimg).css("width", imgWidth);//以最终的宽度对图片缩放

        var w = (windowW - imgWidth) / 2;//计算图片与窗口左边距
        var h = (windowH - imgHeight) / 2;//计算图片与窗口上边距
        $(innerdiv).css({"top": h, "left": w});//设置#innerdiv的top和left属性
        $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg
    });

    $(outerdiv).click(function () {//再次点击淡出消失弹出层
        $(this).fadeOut("fast");
    });
}

var Id = '';

function shenhe(obj, id,mch_status) {
    var curl = "index.php?module=mch&action=Product_shelves&mch_status="+mch_status+"&id=";
    if(mch_status == 1){
        confirm("确认通过审核并上架此商品吗？", id, curl,mch_status, '审核');
    }else{
        confirm1("确认拒绝此商品吗？", id, curl,mch_status, '拒绝');
    }
}
function confirm(content, id, url,mch_status, content1) {
    $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask('${id}','${url}','${content1}')>确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
}
function confirm1(content, id, url,mch_status, content1) {
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">提示</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style='text-align: center;padding-top: 10px'>
                    <input style='border:1px solid #666;height:30px;line-height: 30px' type="text" placehold='请输入拒绝原因' name='jujue'>
                </div>
                <div style="text-align:center;margin-top:10px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask4_2('${id}','${mch_status}','${url}') >确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
}
</script>
{/literal}
</body>
</html>