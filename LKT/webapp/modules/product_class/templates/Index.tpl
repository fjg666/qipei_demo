{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}

{literal}
<style type="text/css">
td a {
    width: 28%;
    float: left;
    margin: 2% !important;
}
.stopCss:hover {
    cursor: not-allowed;
}
.stopCss {
    width: 88px;
    height: 20px;
    border: 1px solid #e9ecef;
    color: #d8dbe8 !important;
    font-size: 12px;
    border-radius: 2px;
    line-height: 20px;
    display: inline-block;
    margin-left: -2%;
    margin-bottom
}
</style>
{/literal}
<body style="background: #edf1f5;">

{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="product_class"/>
            <input type="text" name="pname" size='8' id="pname" value="{$pname}" placeholder="分类名称" class="input-text" style="width: 200px;">
            <input name="" id="btn9" class="btn " type="submit" value="查询">
            <input id="btn9" class="btn " type="button" value="导出" onclick="export_popup1('index.php?module=product_class&action=Index&cid={$cid}','por_class')" style="float: right;background: #008DEF;color: #fff">
        </form>
        <input type="hidden" id="superCid" value="{$cid}"/>
    </div>
    <div class="page_h16"></div>
    <div style="clear:both;background-color: #edf1f5;">
        <input type="hidden" name="cid" id="cid" value="{$cid}">
        <button class="btn newBtn radius" id="syj" onclick="location.href='index.php?module=product_class&action=Index&cid={$cid}&m=tc';" {if !$level} style="display: none;"{/if}>
            <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                <img src="images/icon1/sj.png"/>&nbsp;返回上一级
            </div>
        </button>
        {if $button[0] == 1}
            {if !$level}
                <button type="button" class="btn newBtn radius" onclick="location.href='index.php?module=product_class&action=Add';">
                    <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                        <img src="images/icon1/add.png"/>&nbsp;新增分类
                    </div>
                </button>
            {/if}
        {/if}
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">分类ID</th>
                    <th class="tab_imgurl">分类图片</th>
                    <th>分类名称</th>
                    <th>分类级别</th>
                    <th>添加时间</th>
                    <th class="tab_five">操作</th>
                </tr>
            </thead>
            <tbody id="tbody">
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$item->cid}</td>
                    <td class="tab_imgurl">
                        {if $item->img != ''}
                            <image class="pimg" src="{$item->img}"/>
                        {else}
                            <span>暂无图片</span>
                        {/if}
                    </td>
                    <td>{$item->pname}</td>
                    <td>{$item->level}</td>
                    <td>{$item->add_date}</td>
                    <td class="tab_five" style="width: 200px;">
                        {if $button[3] == 1}
                            <a onclick="on_top(this,'{$item->cid}','{$item->sid}')" {if $button[3] != 1}class="stopCss"{/if}>
                                <img src="images/icon1/zd.png"/>&nbsp;置顶
                            </a>
                        {/if}
                        {if $button[1] == 1}
                            <a href="index.php?module=product_class&action=Modify&cid={$item->cid}" title="编辑" {if $button[1] != 1}class="stopCss"{/if}>
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        {/if}
                        {if $button[2] == 1}
                            <a onclick="del(this,'{$item->cid}','{$item->status}')" {if $button[2] != 1}class="stopCss"{/if}>
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        {/if}
                        {if $level < $level_num}
                            <a href="index.php?module=product_class&action=Index&cid={$item->cid}" title="查看该分类的下级" >
                                <img src="images/icon1/ck.png"/>&nbsp;查看下级
                            </a>
                            {if $button[0] == 1}
                                <a href="index.php?module=product_class&action=Add&cid={$item->cid}&superCid={$cid}" title="在此分类下添加" {if $button[0] != 1}class="stopCss"{/if}>
                                    <img src="images/icon1/add_g.png"/>&nbsp;添加分类
                                </a>
                            {/if}
                        {/if}
                    </td>
                </tr>
                </form>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:9999;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
<script type="text/javascript">
var del_str = {$del_str};//json对象
{literal}
//删除商品，页面跳转字段
del_str = JSON.stringify(del_str);//json字符串
$(function () {
    $(".pimg").click(function () {
        var _this = $(this);//将当前的pimg元素作为_this传入函数
        imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
    });

    // 根据框架可视高度,减去现有元素高度,得出表格高度
    var Vheight = $(window).height()-56-56-16-36-16-($('.tb-tab').text()?70:0)
    $('.table-scroll').css('height',Vheight+'px')
});
// 置顶
function on_top(obj, cid, sid) {
    $.ajax({
        type: "POST",
        url: "index.php?module=product_class&action=Stick",
        data: {
            cid: cid,
            sid: sid
        },
        success: function (msg) {
            if (msg == 1) {
                location.replace(location.href);
            } else {
                layer.msg('修改失败！');
            }
        }
    });
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

/*删除*/
function del(obj, id, status) {
    if (status == 1) {
        layer.msg('该分类有商品,不能删除!');
    } else {
        confirm("是否删除此分类？", id, 'index.php?module=product_class&action=Del&cid=',del_str, '删除');
    }
}

function confirm(content, id, url,del_str, content1) {
    $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="height: 223px!important;">
                <div style="position: relative;top:59px;font-size: 22px;text-align: center;color: #414658;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:100px;">
                    <button class="closeMask" style="margin-right:3px;background: #fff;border: 1px solid #008DEF;color: #008DEF;" onclick=closeMask1() >取消</button>
                    <button class="closeMask" style="background: #008DEF;border: 1px solid #eee;color: #fff;" onclick=closeMaskPC('${id}','${url}','${del_str}','${content1}') >确认</button>
                </div>
            </div>
        </div>
    `)
}
</script>
{/literal}
</body>
</html>