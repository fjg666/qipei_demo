{include file="../../include_path/header.tpl" sitename="公共头部"}

{literal}
<style>
#form1 .form-label{
	width: 115px!important;
}
#form1 .row{display: flex;align-items: center;}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
	<div class="page_title">编辑插件</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0 60px;margin-top: 40px;">
        <input type="hidden" name="id" value="{$id}">
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>首页插件名称：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$name}" placeholder="" id="" name="name">
            </div>
        </div>
        <div class="row cl page_padd" style="padding: 0;">
            <label class="form-label col-4"><span class="c-red">*</span>插件标识：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$Identification}" placeholder="" name="Identification">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-4">排序号：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$sort}" placeholder="" id="" name="sort">
            </div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
        </div>
    </form>
    <div class="page_h20"></div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script>
var aa = $(".pd-20").height();
var bb = $(".form").height();
if (aa < bb) {
    $(".page_h20").css("display", "block")
} else {
    $(".page_h20").css("display", "none")
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
        url:'index.php?module=plug_ins&action=Modify',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                intervalId = setInterval(function () {
                    clearInterval(intervalId);
                    location.href=history.go(-1);location.reload();
                }, 2000);
            }
        }
    });
}
</script>
{/literal}
</body>
</html>