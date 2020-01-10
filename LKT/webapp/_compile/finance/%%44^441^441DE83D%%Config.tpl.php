<?php /* Smarty version 2.6.31, created on 2020-01-02 16:18:59
         compiled from Config.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style>
.btn1{
    width: 80px;
    height: 40px;
    line-height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    float: left;
    color: #6a7076;
    background-color: #fff;
}
.btn1:hover{
    text-decoration: none;
}
.swivch a:hover{background-color: #2481e5!important;}
input:focus::-webkit-input-placeholder {
    color: transparent;
    /* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}
</style>
'; ?>

</head>
<body class="iframe-container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="iframe-content">
    <div class="navigation">
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <div >
                <a href="index.php?module=finance" >提现审核</a>
            </div>
        <?php endif; ?>
        <p class='border'></p>
        <?php if ($this->_tpl_vars['button'][1] == 1): ?>
            <div >
                <a href="index.php?module=finance&action=List" >提现记录</a>
            </div>
        <?php endif; ?>
        <p class='border'></p>
        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
            <div class='active'>
                <a href="index.php?module=finance&action=Config" >钱包参数</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="hr" ></div>
    <form name="form1" id="form1"  class="form form-horizontal" method="post"  style="margin-top: 10px;"  enctype="multipart/form-data" >
        <div id="tab-system" class="HuiTab" style="margin-bottom: 40px;">
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red">*</span>最小充值金额：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['min_cz']; ?>
" id="min_cz" name="min_cz">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red">*</span>最小提现金额：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['min_amount']; ?>
" id="min_amount" name="min_amount">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red">*</span>最大提现金额：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['max_amount']; ?>
" id="max_amount" name="max_amount">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red">*</span>手续费：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['service_charge']; ?>
" id="service_charge" name="service_charge">
                    <span style="color:#666;">手续费为大于0小于1的小数,如0.005</span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4">钱包单位：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['unit']; ?>
" id="unit" name="unit">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-4">提现基数：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['multiple']; ?>
" id="multiple" name="multiple">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4">转账基数：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['transfer_multiple']; ?>
" id="transfer_multiple" name="transfer_multiple">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-4">充值基数：</label>
                <div class="formControls col-4">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['cz_multiple']; ?>
" id="cz_multiple" name="cz_multiple">
                </div>
            </div>
        </div>
        <div class="page_bort" ></div>
        <div class="page_h10" style="height: 58px!important;">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 83px!important;">
        </div>
    </form>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script>
window.onload=function(){
    $("[type=text],[type=number],[type=file],[type=tel],[type=email],[type=password]").attr("required","required");
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
		url:\'index.php?module=finance&action=Config\',
		data:$(\'#form1\').serialize(),// 你的formid
		async: true,
		success: function(data) {
			layer.msg(data.status,{time:2000});
			if(!data.suc){
				location.href="index.php?module=finance&action=Config";
			}
		}
	});
}
</script>
'; ?>

</body>
</html>