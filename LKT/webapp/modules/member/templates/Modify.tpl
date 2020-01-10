{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style>
.iframe-table .row{
    display: flex;
    align-items: center;
    padding-left: 30px;
}
.row .form-label{
    color: #414658;
    font-size: 14px;
    margin-right: 3px;
}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="page_title">管理员修改</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{$id}"/>
        <input type="hidden" name="role_id" value="{$role_id}"/>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>管理员名称：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" name="name" value="{$name}" readonly="readonly">
            </div>
            <label class="form-label col-1" style="font-size: 12px;color:#97A0B4;tex;text-align: left;margin-top: 8px;">(不可修改！)</label>
        </div>
        <div class="row cl">
            <label class="form-label col-4">所属客户编号：</label>
            <div class="formControls col-4 input_300">
                {$customer_number}
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red"></span>新密码：</label>
            <div class="formControls col-4">
                <input type="password" class="input-text" value="" name="x_password" >
            </div>
        </div>

        <div class="row cl" id="role" style="margin-bottom: 40px;">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>角色：</label>
            <div class="formControls col-xs-8 col-sm-4"> <span class="select-box" style="width:150px;">
                <select class="select" name="role" size="1" style="height: auto!important;">
                    {$list}
                </select>
            </span></div>
        </div>

        <div class="page_bort"></div>
        <div class="page_h10" style="height: 58px!important;">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 83px!important;">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
<script>
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
        dataType: "json",
        url: 'index.php?module=member&action=Modify',
        data: $('#form1').serialize(),// 你的formid
        async: true,
        success: function (data) {
            layer.msg(data.status, {time: 2000});
            if (data.suc) {
                location.href = "index.php?module=member";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>