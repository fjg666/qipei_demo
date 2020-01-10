<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

{include file="../../include_path/header.tpl" sitename="公共头部"}

<title>添加模块</title>
{literal}
<style>
td a{
    width: 56px;
    margin: 2%!important;
}
table thead tr th{height: 30px;}
.table-hover tbody tr:hover td{background-color: #EFF8FF;}
</style>
{/literal}
</head>
<body>
    
{include file="../../include_path/nav.tpl" sitename="面包屑"}


<div class="pd-20 page_absolute">
    <div style="clear:both;" class="page_bgcolor">
        <button class="btn newBtn radius" onclick="location.href='index.php?module=software&action=pageadd';" >
            <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                <img style="margin-right: 2px!important;height: 13px; width: 10px;" src="images/icon1/add.png"/>&nbsp;添加模块
            </div>
        </button>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20">
         <table class="table table-border table-bordered table-bg table-hover" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="text-c">
                    <th>ID</th>
                    <th>模块名称</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$lkt_index_page item=item name=f1}
                <tr class="text-c">
                    <td>{$item->id}</td>
                    <td>{$item->name}</td>
                    <td>{$item->add_date}</td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" href="index.php?module=software&action=pagemodify&id={$item->id}&yimage={$item->image}" title="修改" >
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;;display: flex;align-items: center;">
                                <img src="images/icon1/xg.png"/>&nbsp;修改
                                </div>
                            </div>
                        </a>
                        <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要删除此模块吗?',{$item->id},'index.php?module=software&action=pagedel&id=','删除')">
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;;display: flex;align-items: center;"> 
                                <img src="images/icon1/del.png"/>&nbsp;删除
                                </div>
                            </div>
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
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>

<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
{literal}
<script type="text/javascript">
var aa=$(".pd-20").height()-36-16;
var bb=$(".table-border").height();
console.log(aa)
if(aa<bb){
	$(".page_h20").css("display","block")
}else{
	$(".page_h20").css("display","none")
}	
	
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
function appendMask(content,src){
    $("body").append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除订单</div>   
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/${src}.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
                    <button class="closeMask" onclick=closeMask1() >确认</button>
                </div>
                
            </div>
        </div>  
    `)
};
function closeMask(id,url,content){
    $.ajax({
        type:"post",
//      index.php?module=software&action=del&id={$item->id}&yimage={$item->image}
        url:url+id,
        async:true,
        dataType:"json",
        success:function(res){
            if(res.status==1){
                layer.msg("删除成功")
                // location.replace(location.href);
            }
            else{
                layer.msg("删除失败");
            }
        }
        
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