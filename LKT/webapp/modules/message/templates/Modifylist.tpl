{include file="../../include_path/header.tpl" sitename="DIY头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <form name="form1" id="form1"  class="form form-horizontal" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="{$id}">
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>短信签名：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$SignName}" placeholder="" name="SignName">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>短信模板名称：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$name}" placeholder="" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-8 skin-minimal">
                <select name="type" class="select"  id="type" style="width: 390px;" onClick="show()">
                    <option value="">请选择类型</option>
                    {$select1}
                </select>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="row cl" >
            <label class="form-label col-4"><span class="c-red">*</span>类别：</label>
            <div class="formControls col-8 skin-minimal">
                <select name="type1" class="select"  id="type1" style="width: 390px;" >
                    <option value="">请选择类别</option>
                    {foreach from=$select2 item=item name=f1}
                        <option value="{$item->value}" {if $item->status}selected="selected"{/if}>{$item->text}</option>
                    {/foreach}
                </select>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>短信模板Code：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$TemplateCode}" placeholder="" name="TemplateCode">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>短信接收号码：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$PhoneNumbers}" placeholder="" name="PhoneNumbers">
            </div>
            <label class="col-2" style="font-size: 14px;color:#97A0B4;tex;text-align: left;">(验证短信是否成功！)</label>
        </div>
        <div class="row cl" id="content" >
            <label class="form-label col-4"><span class="c-red">*</span>发送内容：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$content}" placeholder="" name="content">
            </div>
            {literal}<label class="col-2" style="font-size: 14px;color:#97A0B4;tex;text-align: left;">如：您有新的订单待处理，当前状态：${status}，订单摘要:${remark}，请及时处理。</label>{/literal}
        </div>

        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
function show(){
    var type = $("#type").val();
    $.ajax({
        cache: true,
        type: "GET",
        dataType:"json",
        url:'index.php?module=message&action=Addlist',
        data:{
            type: type,
        },
        async: true,
        success: function(data) {
            var select2 = data.select2;
            var res = '<option value="">请选择类型</option>';
            for (var i in select2){
                if(select2[i]['status']){
                    res += `<option selected="selected" value="${select2[i]['value']}">${select2[i]['text']}</option>`
                }else{
                    res += `<option value="${select2[i]['value']}">${select2[i]['text']}</option>`
                }
            }
            $("#type1").empty();
            $("#type1").append(res);
        }
    });
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
        url:'index.php?module=message&action=Modifylist',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href="index.php?module=message&action=List";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>