<?php /* Smarty version 2.6.31, created on 2019-12-30 21:24:57
         compiled from Set.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
	.btn1 {
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
	
	.btn1:hover {
		text-decoration: none;
	}
	
	.swivch a:hover {
		text-decoration: none;
		background-color: #2481e5!important;
		color: #fff!important;
	}
	
	input:focus::-webkit-input-placeholder {
		color: transparent;
		/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
	}
	
	.row .form-label {
		width: 13%!important;
	}
	
	#form1 {
		padding: 40px 40px 10px 40px!important;
		margin-bottom: 10px;
	}
</style>
'; ?>


<body class="body_bgcolor iframe-container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<nav class="nav-title">
	<span class="c-gray en"></span> 插件管理
	<span class="c-gray en">&gt;</span> 店铺
	<span class="c-gray en">&gt;</span> 多商户设置
</nav>

<div class="iframe-content">
	<!--导航表格切换-->
	<div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
		<a href="index.php?module=mch&aciton=Index" class="btn1 " style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">店铺</a>
		<?php if ($this->_tpl_vars['button'][0] == 1): ?>
			<a href="index.php?module=mch&action=List" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">申请审核</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][1] == 1): ?>
			<a href="index.php?module=mch&action=Set" class="btn1 swivch_active" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">多商户设置</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][2] == 1): ?>
			<a href="index.php?module=mch&action=Product" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">商品审核</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][3] == 1): ?>
			<a href="index.php?module=mch&action=Withdraw" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">提现审核</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][4] == 1): ?>
			<a href="index.php?module=mch&action=Withdraw_list" class="btn1" style="height: 42px !important;border:0!important;width: 112px;">提现记录</a>
		<?php endif; ?>
		<div style="clear: both;"></div>
	</div>
	<div class="page_h16"></div>

	<form name="form1" id="form1" class="form form-horizontal iframe-table" method="post" enctype="multipart/form-data">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>店铺默认LOGO：</label>
			<div class="formControls col-xs-8 col-sm-6" style="margin-left: -16px;">
				<div class="upload-group">
					<div class="input-group">
						<input type="hidden" name="oldpic" value="<?php echo $this->_tpl_vars['logo']; ?>
">
						<input class="form-control file-input" name="logo" value="<?php echo $this->_tpl_vars['logo']; ?>
">
						<span class="input-group-btn">
						<a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip"
						   data-placement="bottom" title="" data-original-title="上传文件">
							<span class="iconfont icon-cloudupload"></span>
						</a>
						</span>
						<span class="input-group-btn">
						<a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"
						   data-placement="bottom" title="" data-original-title="从文件库选择">
							<span class="iconfont icon-viewmodule"></span>
						</a>
						</span>
						<span class="input-group-btn">
						<a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"
						   data-placement="bottom" title="" data-original-title="删除文件">
							<span class="iconfont icon-close"></span>
						</a>
						</span>
					</div>
					<div class="upload-preview text-center upload-preview">
						<span class="upload-preview-tip">100×100</span>
						<img class="upload-preview-img" src="<?php echo $this->_tpl_vars['logo']; ?>
">
					</div>
				</div>
			</div>
			<div class="col-4"></div>
		</div>
		<div class="row cl">
			<label class="form-label col-4"><span class="c-red">*</span>结算方式：</label>
			<div class="col-sm-6" style="margin-left: -16px;">
				<label class="radio-label">
				<input type="radio" name="settlement" value="0" <?php if ($this->_tpl_vars['settlement'] == 0): ?>checked<?php endif; ?> >
				<span class="label-icon"></span>
				<span class="label-text">按天结算</span>
			</label>
				<label class="radio-label">
				<input type="radio" name="settlement" value="1" <?php if ($this->_tpl_vars['settlement'] == 1): ?>checked<?php endif; ?>>
				<span class="label-icon"></span>
				<span class="label-text">按月结算</span>
			</label>
				<label class="radio-label">
				<input type="radio" name="settlement" value="2" <?php if ($this->_tpl_vars['settlement'] == 2): ?>checked<?php endif; ?>>
				<span class="label-icon"></span>
				<span class="label-text">按季度结算</span>
			</label>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-4"><span class="c-red">*</span>最低提现金额：</label>
			<div class="formControls col-6" style="margin-left: -16px;">
				<input type="text" name="min_charge" value="<?php echo $this->_tpl_vars['min_charge']; ?>
" class="input-text input_190">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-4"><span class="c-red">*</span>最大提现金额：</label>
			<div class="formControls col-6" style="margin-left: -16px;">
				<input type="text" name="max_charge" value="<?php echo $this->_tpl_vars['max_charge']; ?>
" class="input-text input_190">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-4"><span class="c-red">*</span>手续费：</label>
			<div class="formControls col-6" style="margin-left: -16px;">
				<input type="text" name="service_charge" value="<?php echo $this->_tpl_vars['service_charge']; ?>
" class="input-text input_190">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">提现说明：</label>
			<div class="formControls col-xs-8 col-sm-10 codes" style="margin-left: -16px;">
				<script id="editor" type="text/plain" name="illustrate" style="width:100%;height:400px;"><?php echo $this->_tpl_vars['illustrate']; ?>
</script>
			</div>
		</div>
		<div class="row cl" style="margin-bottom: 40px;">
			<label class="form-label col-xs-4 col-sm-2">入驻协议：</label>
			<div class="formControls col-xs-8 col-sm-10 codes" style="margin-left: -16px;">
				<script id="editor1" type="text/plain" name="agreement" style="width:100%;height:400px;"><?php echo $this->_tpl_vars['agreement']; ?>
</script>
			</div>
		</div>
		<div class='hr'></div>
		<div class="page_bort">
			<input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
		</div>
	</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/ueditor.tpl", 'smarty_include_vars' => array('sitename' => "ueditor插件")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script>
$(function() {
	var ue = UE.getEditor(\'editor\');
});
$(function() {
	var ue = UE.getEditor(\'editor1\');
});
document.onkeydown = function(e) {
	if(!e) e = window.event;
	if((e.keyCode || e.which) == 13) {
		$("[name=Submit]").click();
	}
}

function check() {
	$.ajax({
		cache: true,
		type: "POST",
		dataType: "json",
		url: \'index.php?module=mch&action=Set\',
		data: $(\'#form1\').serialize(), // 你的formid
		async: true,
		success: function(data) {
			console.log(data)
			layer.msg(data.status, {
				time: 2000
			});
			if(data.suc) {
				location.href = "index.php?module=mch&action=Set";
			}
		}
	});
}
</script>
'; ?>

</body>

</html>