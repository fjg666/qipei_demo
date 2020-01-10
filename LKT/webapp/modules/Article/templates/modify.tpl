{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
<body class="body_bgcolor">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post"  enctype="multipart/form-data" >
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" name="editable" value="true" />
        <input type="hidden" name="uploadImg" value="{$uploadImg}" />
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>文章标题：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" name="Article_title" value="{$Article_title}" placeholder="" id="" >
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">文章副标题：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" value="{$Article_prompt}" placeholder="" id="" name="Article_prompt">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2">排序号：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" value="{$sort}" placeholder="" id="" name="sort">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">文章图片：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div class="upload-group">
                    <div class="input-group">
                        <input class="form-control file-input" name="imgurl" value="{$Article_imgurl}">
                        <span class="input-group-btn">
                                        <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="上传文件">
                                            <span class="iconfont icon-cloudupload"></span>
                                        </a>
                                    </span>
                        <span class="input-group-btn">
                                        <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="从文件库选择">
                                            <span class="iconfont icon-viewmodule"></span>
                                        </a>
                                    </span>
                        <span class="input-group-btn">
                                        <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="删除文件">
                                            <span class="iconfont icon-close"></span>
                                        </a>
                                    </span>
                    </div>
                    <div class="upload-preview text-center upload-preview">
                        <span class="upload-preview-tip">240×60</span>
                        <img class="upload-preview-img" src="{$Article_imgurl}">
                    </div>
                </div>
            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>文章内容：</label>
            <div class="formControls col-10"> 
                <script id="editor" type="text/plain" style="width:100%;height:400px;" name="content">{$content}</script> 
            </div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
        <div style="height: 10px;"></div>
    </form>
    <div class="page_h20"></div>
    
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:999;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div>
</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}
<script type="text/javascript">
var aa=$(".pd-20").height();
var bb=$(".table-border").height();
if(aa<583){
    $(".page_h20").css("display","block")
}else{
    $(".page_h20").css("display","none")
}
document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}
function check() {
    $.ajax({
        cache: true,
        type: "POST",
        dataType:"json",
        url:'index.php?module=Article&action=modify',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            console.log(data)
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href="index.php?module=Article";
            }
        }
    });
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
$(function(){
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });
    var ue = UE.getEditor('editor');
    
});
</script>
{/literal}
</body>
</html>