<?php /* Smarty version 2.6.31, created on 2019-12-31 16:53:33
         compiled from Modify.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
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
'; ?>

<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute">
    <div class="page_title">管理员修改</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
"/>
        <input type="hidden" name="role_id" value="<?php echo $this->_tpl_vars['role_id']; ?>
"/>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>管理员名称：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" readonly="readonly">
            </div>
            <label class="form-label col-1" style="font-size: 12px;color:#97A0B4;tex;text-align: left;margin-top: 8px;">(不可修改！)</label>
        </div>
        <div class="row cl">
            <label class="form-label col-4">所属客户编号：</label>
            <div class="formControls col-4 input_300">
                <?php echo $this->_tpl_vars['customer_number']; ?>

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
                    <?php echo $this->_tpl_vars['list']; ?>

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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
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
        url: \'index.php?module=member&action=Modify\',
        data: $(\'#form1\').serialize(),// 你的formid
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
'; ?>

</body>
</html>