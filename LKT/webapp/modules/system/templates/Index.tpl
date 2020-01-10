
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
<title>系统参数</title>

</head>

<body class="body_bgcolor">

{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="page-container pd-20 page_absolute">
    <form name="form1" id='form1' class="form form-horizontal" method="post"   enctype="multipart/form-data" >
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>小程序ID：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="appid" value="{$appid}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>小程序密钥：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="appsecret" value="{$appsecret}" class="input-text">
                </div>
            </div>

        </div>
        <div class="row cl page_bort" >
            <div class="save page_out" >
              
                <button class="btn btn-default radius ta_btn4" type="reset">取  消</button>
                 <input class="btn btn-primary radius submit1 ta_btn3" type="button" onclick="check()" value="保  存" name="Submit" style="width: 112px!important;">
            </div>
        </div>
    </form>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div> 

{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}

<script type="text/javascript" src="style/js/layer/layer.js"></script>
{literal}
<script type="text/javascript">
	document.onkeydown = function (e) {
		            if (!e) e = window.event;
		            if ((e.keyCode || e.which) == 13) {
		                $("[name=Submit]").click();
		            }
	        	}
	function check() {
		console.log(88888)
	    $.ajax({
			cache: true,
			type: "POST",
			dataType:"json",
			url:'index.php?module=system',
			data:$('#form1').serialize(),// 你的formid
			async: true,
			success: function(data) {
				console.log(data)
				layer.msg(data.status,{time:2000});
				if(data.suc){
					 setTimeout(function(){
								location.href="index.php?module=system";
					},2000) 
			}
			}
		});
	}
$('.table-sort').dataTable({
    "aaSorting": [[ 1, "desc" ]],//默认第几个排序
    "bStateSave": true,//状态保存
    "aoColumnDefs": [
      //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
      {"orderable":false,"aTargets":[0,4]}// 制定列不参与排序
    ]
});
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
</script>

{/literal}
</body>
</html>