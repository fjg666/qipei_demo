{include file="../../include_path/header.tpl" sitename="DIY头部"}

<title>商品品牌</title>
{literal}
    <style type="text/css">
        td a{
            width: 29%;
            float: left;
            margin: 2%!important;
        }
    </style>
{/literal}

<body class="iframe-container">
<nav class="nav-title">
	<span>商品管理</span>
	<span><span class="arrows">&gt;</span>品牌管理</span>
</nav>
<div class="iframe-content">
    <div class="text-c">
        <form class='iframe-search' name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="brand_class"/>
            <input type="text" name="brand_name" size='8' id="brand_name" value="{$brand_name}" placeholder="品牌名称" class="input-text" style="width: 200px;">
            <input name="" id="btn9" class="btn " type="submit" value="查询">
            <input id="btn9" class="btn " type="button" value="导出" onclick="export_popup(location.href)" style="float: right;background: #008DEF;color: #fff">
        </form>
        <input type="hidden" id="superCid" value="{$cid}"/>
    </div>
    <div class="page_h16"></div>
    {if $button[0] == 1}
        <div style="clear:both;background-color: #edf1f5;">
            <button  class="btn newBtn radius" onclick="location.href='index.php?module=brand_class&action=Add';">
                <img src="images/icon1/add.png" alt="" />新增品牌
            </button>
        </div>
        <div class="page_h16"></div>
    {/if}
    <div class="tab_table iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">ID</th>
                    <th class="tab_imgurl">品牌图片</th>
                    <th>品牌名称</th>
                    <th>所属分类</th>
                    <th class="tab_time">添加时间</th>
                    <th class="tab_three">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$item->brand_id}</td>
                    <td class="tab_imgurl">{if $item->brand_pic != ''}<image class='pimg' src="{$item->brand_pic}" style="width: 50px;height:50px;"/>{else}<span>暂无图片</span>{/if}</td>
                    <td style="color: #414658;">{$item->brand_name}</td>
                    <td style="color: #414658;">{$item->class_name}</td>
                    <td class="tab_time">{$item->brand_time}</td>
                    <td class="tab_three">
                        {if $button[3] == 1}
                            <a onclick="on_top(this,'{$item->brand_id}')" {if $button[3] != 1}class="stopCss"{/if}>
                                <img src="images/icon1/zd.png"/>&nbsp;置顶
                            </a>
                        {/if}
                        {if $button[1] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=brand_class&action=Modify&cid={$item->brand_id}" title="编辑" >
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        {/if}
                        {if $button[2] == 1}
                            {if $item->tistrue=='1'}
                                <font class="ml-5" style="color:red;" title="已删除"><i class="Hui-iconfont">&#xe6e2;</i></font>
                            {else}
                                <a style="text-decoration:none" class="ml-5" href="javascript:void(0)" onclick="confirm('确定要删除此商品品牌吗?','{$item->brand_id}','index.php?module=brand_class&action=Del&cid=','删除')">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                            {/if}
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:9999;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
$(function(){  
    $(".pimg").click(function(){
        var _this = $(this);//将当前的pimg元素作为_this传入函数
        imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
    });
});

function imgShow(outerdiv, innerdiv, bigimg, _this){  
    var src = _this.attr("src");//获取当前点击的pimg元素中的src属性  
    $(bigimg).attr("src", src);//设置#bigimg元素的src属性  
  
        /*获取当前点击图片的真实大小，并显示弹出层及大图*/  
    $("<img/>").attr("src", src).load(function(){  
        var windowW = $(window).width();//获取当前窗口宽度  
        var windowH = $(window).height();//获取当前窗口高度  
        var realWidth = this.width;//获取图片真实宽度  
        var realHeight = this.height;//获取图片真实高度  
        var imgWidth, imgHeight;  
        var scale = 0.9;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放  
          
        if(realHeight>windowH*scale) {//判断图片高度  
            imgHeight = windowH*scale;//如大于窗口高度，图片高度进行缩放  
            imgWidth = imgHeight/realHeight*realWidth;//等比例缩放宽度  
            if(imgWidth>windowW*scale) {//如宽度扔大于窗口宽度  
                imgWidth = windowW*scale;//再对宽度进行缩放  
            }  
        } else if(realWidth>windowW*scale) {//如图片高度合适，判断图片宽度  
            imgWidth = windowW*scale;//如大于窗口宽度，图片宽度进行缩放  
                        imgHeight = imgWidth/realWidth*realHeight;//等比例缩放高度  
        } else {//如果图片真实高度和宽度都符合要求，高宽不变  
            imgWidth = realWidth;  
            imgHeight = realHeight;  
        }  
                $(bigimg).css("width",imgWidth);//以最终的宽度对图片缩放  
          
        var w = (windowW-imgWidth)/2;//计算图片与窗口左边距  
        var h = (windowH-imgHeight)/2;//计算图片与窗口上边距  
        $(innerdiv).css({"top":h, "left":w});//设置#innerdiv的top和left属性  
        $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg  
    });  
      
    $(outerdiv).click(function(){//再次点击淡出消失弹出层  
        $(this).fadeOut("fast");  
    });  
}
// 置顶
function on_top(obj, id) {
    $.ajax({
        type: "POST",
        url: "index.php?module=brand_class&action=Status",
        data: {
            brand_id: id,
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

function closeMask(id){
    $(".maskNew").remove();
    $.ajax({
        type:"post",
        url:""+id,
        async:true,
        success:function(res){
            if(res==1){
                layer.msg("删除成功!");
            }else if(res==2){
                layer.msg("该品牌正在使用，不允删除!");
            }else{
                layer.msg("删除失败!");
            }
        }
    });
}
function closeMask1(){
    $(".maskNew").remove();
    location.replace(location.href);
}
// 删除
function confirm (content,id,url,content1){
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">提示</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
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