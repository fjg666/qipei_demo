{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
<body class="body_bgcolor">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" >
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>文章标题：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" value="" placeholder="" id="" name="Article_title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">文章副标题：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" value="" placeholder="" id="" name="Article_prompt">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">排序号：</label>
            <div class="formControls col-2">
                <input type="text" class="input-text" value="100" placeholder="" id="" name="sort">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">文章图片：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div class="upload-group">
                    <div class="input-group">
                        <input class="form-control file-input" name="imgurl" value="">
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
                        <img class="upload-preview-img" src="">
                    </div>
                </div>


            </div>
            <div class="col-4"> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>文章内容：</label>
            <div class="formControls col-10">
                <script id="editor" type="text/plain" style="width:100%;height:400px;" name="content"></script>
            </div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
        <div style="height: 10px; clear: both;"></div>
    </form>
    <div class="page_h20"></div>
</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{literal}
<script type="text/javascript">
$(function(){
    var ue = UE.getEditor('editor');
    $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
    });

    var aa=$(".pd-20").height();
	var bb=$("#form1").height()+531;
	if(aa<bb){
		$(".page_h20").css("display","block")
	}else{
		$(".page_h20").css("display","none")
		$(".row_cl").addClass("page_footer")
	}

});
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
        url:'index.php?module=Article&action=add',
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
</script>
{/literal}
</body>
</html>