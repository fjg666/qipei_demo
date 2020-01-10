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
<body class='iframe-container'>
<nav class="nav-title">
	<span>权限管理</span>
    <span class='nav-to' onclick="javascript:history.back(-1);"><span class="arrows">&gt;</span>管理员列表</span>
	<span><span class="arrows">&gt;</span>添加管理员</span>
</nav>
<div class="iframe-content">
    <form name="form1" id="form1"  class="iframe-table form-scroll" method="post" enctype="multipart/form-data" style='padding: 0;'>
		<p class='page_title'>添加管理员</p>
        <div class="row cl" style='margin-top: 40px;'>
            <label class="form-label col-4"><span class="c-red">*</span>管理员账号：</label>
            <div class="formControls col-4 input_300">
                <input type="text" class="input-text" value="" placeholder="请输入管理员账号" name="name">
            </div>
        </div>
		<div class="row cl">
		    <label class="form-label col-4">所属客户编号：</label>
		    <div class="formControls col-4 input_300">
                {$customer_number}
		    </div>
		</div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>管理员密码：</label>
            <div class="formControls col-4 input_300">
                <input type="password" class="input-text" value="" placeholder="请输入管理员密码" name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-4 input_300">
                <input type="password" class="input-text" value="" placeholder="请输入管理员密码" name="password1">
            </div>
        </div>
        <div class="row cl" style="margin-bottom: 40px;">
            <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>角色：</label>
            <div class="formControls col-xs-8 col-sm-4"> <span class="select-box" style="width:150px;">
                <select class="select" name="role" size="1" style="height: auto!important;">
                    {$list}
                </select>
			</span></div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript:history.back(-1);">
        </div>
    </form>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
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
        url:'index.php?module=member&action=Add',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href="index.php?module=member";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>