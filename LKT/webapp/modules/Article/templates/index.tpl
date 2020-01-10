{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style>
   	td a{
        width: 44%;
        margin: 2%!important;
        float: left;
    }
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">
    {if $button[0] == 1}
        <div style="clear:both;" class="page_bgcolor">
            <a class="btn newBtn radius" href="index.php?module=Article&action=add"><img src="images/icon1/add.png"/>&nbsp;发表文章</a>
        </div>
    {/if}
    <div class="page_h16"></div>
    <div class="tab_table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c">
                    <th class="tab_num">序号</th>
                    <th>标题</th>
                    <th>图片</th>
                    <th>排序号</th>
                    <th class="tab_time">发布时间</th>
                    <th>分享次数</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c">
                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
                    <td>{$item->Article_title}</td>
                    {if $item->Article_imgurl != ''}
                        <td><image class="pimg" src="{$item->Article_imgurl}" style="width: 120px;height:80px;"/></td>
                    {else}
                        <td><!-- <image class="pimg" src="{$uploadImg}nopic.jpg" style="width: 120px;height:80px;"/> -->
                            暂无图片
                        </td>
                    {/if}
                    <td>{$item->sort}</td>
                    <td class="tab_time">{$item->add_date}</td>
                    <td>{$item->share_num}</td>
                    <td class="tab_editor">
                    {if $item->Article_id==1}
                        {if $button[1] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=Article&action=modify&id={$item->Article_id}&uploadImg={$uploadImg}" title="修改" >
                                <img src="images/icon1/xg.png"/>&nbsp;修改
                            </a>
                        {/if}
                        {if $button[2] == 1}
                            <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要删除此文章吗?','{$item->Article_id}','index.php?module=Article&action=del&id=','删除')">
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        {/if}
                    {else}
                        {if $button[3] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=Article&action=view&id={$item->Article_id}" title="查看分享列表" >
                                <img src="images/icon1/ck.png"/>&nbsp;查看
                            </a>
                        {/if}

                        {if $button[4] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=Article&action=amount&id={$item->Article_id}" title="分享红包设置" >
                                <img src="images/icon1/sx.png"/>&nbsp;设置
                            </a>
                        {/if}

                        {if $button[1] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=Article&action=modify&id={$item->Article_id}&uploadImg={$uploadImg}" title="修改" >
                                <img src="images/icon1/xg.png"/>&nbsp;修改
                            </a>
                        {/if}
                        {if $button[2] == 1}
                            <a style="text-decoration:none" class="ml-5"href="javascript:void(0);" onclick="confirm('确定要删除此文章吗?','{$item->Article_id}','index.php?module=Article&action=del&id=','删除')">
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
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>

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
        var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放  
          
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
};
</script>
{/literal}
</body>
</html>