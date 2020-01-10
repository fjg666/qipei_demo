<?php /* Smarty version 2.6.31, created on 2019-12-30 19:32:26
         compiled from Set.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<style>
html {
    /*隐藏滚动条，当IE下溢出，仍然可以滚动*/
    -ms-overflow-style: none;
}
.panel .panel-body {
    padding: 0 !important;
}

label.required:before {
    right: auto;
}

.panel_title img {
    position: absolute;
    background-size: 100% 100%;
}

.panel_word li {
    list-style: none;
    font-size: 16px;
    color: #414658;
    font-family: "微软雅黑" !important;
}

.panel-body .left {
    max-width: 153px;
    width: 300px;
    border: 1px solid #eee;
    background-color: #f4f5f9;
}

.left .item {
    width: 100%;
    padding: 0 10px;
    line-height: 40px;
    cursor: pointer;
}

.left .item:first-child {
    background-color: #fff;
}

.left .item.active {
    background-color: #fff;
}

.left .item:hover {
    background-color: #fff;
}

.file-item .mask {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 5;
    background-color: rgba(0, 0, 0, .5);
    text-align: center;
    background-image: url(\'style/diy_img/icon-file-gou.png\');
    background-size: 40px 40px;
    background-repeat: no-repeat;
    background-position: center;
}
.input-group-btn {
    width: 80px;
    height: 36px;
    display: flex;
    align-items: center;
    padding: 0;
    margin-left: 20px;
}
.input-group-btn a{
    display: flex;
    align-items: center;
}
.input_a {
    background-color: #fff;
    border: 1px solid #2890FF;
    color: #2890FF;
    border-radius: 2px;
}

.input_a > a {
    color: #2890FF
}
.input_border {
    border: 1px solid #D5DBE8;
    border-radius: 2px;
}
.input_border a{
    color:#888f9e;
}
.btn{width: auto!important;}
.color414{color: #414658!important;}
.border-d5d{border-color: #D5DBE8!important;}
</style>
'; ?>


<body style="background-color: #edf1f5;">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute form-scroll">
	<div class="page_title">
		<?php if (! $this->_tpl_vars['payments']->name): ?>添加支付方式<?php else: ?>修改支付方式<?php endif; ?>
	</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding: 0px;">
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['payments']->id; ?>
">
        <div class="formDivSD">
            <div class="formContentSD">
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span class="color414">支付状态：</span></div>
                    <div class="formInputSD">
                        <label class="radio-label">
                            <input type="radio" name="status" value="0" <?php if ($this->_tpl_vars['payments']->status == 0): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">开启</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="status" value="1" <?php if ($this->_tpl_vars['payments']->status == 1): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">关闭</span>
                        </label>
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span class="color414">支付方式名称：</span></div>
                    <div class="formInputSD">
                        <input class="form-control border-d5d" name="name" value="<?php echo $this->_tpl_vars['payments']->name; ?>
" style="width: 500px;">
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span class="color414">应用客户端：</span></div>
                    <div class="formInputSD">
                        <label class="radio-label">
                            <input type="radio" name="client_type" value="1" <?php if ($this->_tpl_vars['payments']->client_type == 1): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">PC端</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="client_type" value="2" <?php if ($this->_tpl_vars['payments']->client_type == 2): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">移动端</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="client_type" value="3" <?php if ($this->_tpl_vars['payments']->client_type == 3): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">通用</span>
                        </label>
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span class="color414">手续费设置：</span></div>
                    <div class="formInputSD">
                        <label class="radio-label" >
                            <input type="radio" name="poundage_type" onclick="$('#paymentFeeText').text('商品总额的百分比：');" value="0" <?php if ($this->_tpl_vars['payments']->poundage_type == 0): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">按商品总额的百分比</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="poundage_type" onclick="$('#paymentFeeText').text('按固定金额：');" value="1" <?php if ($this->_tpl_vars['payments']->poundage_type == 1): ?>checked<?php endif; ?>>
                            <span class="label-icon"></span>
                            <span class="label-text">按固定金额</span>
                        </label>
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px 10px;">
                    <div class="formTextSD"><span></span></div>
                    <div class="formInputSD">
                        <span class="input-group-addon border-d5d" id='paymentFeeText' style="height: 36px;"><?php if ($this->_tpl_vars['payments']->poundage_type == 0): ?>商品总额的百分比：<?php else: ?>按固定金额：<?php endif; ?></span>
                        <input class="form-control border-d5d" name="poundage" value="<?php echo $this->_tpl_vars['payments']->poundage; ?>
" style="width: 352px;">
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px 10px;">
                    <div class="formTextSD"><span class="color414">排序号：</span></div>
                    <div class="formInputSD" style="flex:1">
                        <input class="form-control border-d5d" name="sort" value="<?php echo $this->_tpl_vars['payments']->sort; ?>
" style="width: 500px;">
                        <div class="text-muted fs-sm" style="color: #97a0b4;font-size: 14px;flex: 1;">(在不同的客户端访问时，会显示不同的支付方式)</div>
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span class="color414">支付说明：</span></div>
                    <div class="formInputSD">
                        <textarea class="form-control border-d5d" name="note" rows="8" style="width: 500px;"><?php echo $this->_tpl_vars['payments']->note; ?>
</textarea>
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD" style="width: 120px;display: flex;align-items: center;justify-content: flex-end;margin-right: 10px;"><span class="color414" style="display: block;margin-top: 14px;">logo：</span></div>
                    <div class="formInputSD" style="flex:1;width:100px">
                        <div class="upload-group">
                            <div class="input-group row" style="margin-left: -84px;margin-top: 2px;">
                                <span class="col-sm-1 col-md-1 col-lg-1"></span>
                                <input index="0" value="<?php echo $this->_tpl_vars['logo']; ?>
" name="logo" class="col-sm-5 col-md-5 col-lg-5 form-control file-input input_width_l border-d5d" style="width: 1008px;height: 36px;">
                                <span class="input-group-btn input_a col-sm-1 col-md-1 col-lg-1" style="margin-left: 6px;">
                                    <a href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" class="btn  select-file">选择文件</a>
                                </span>
                                <span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1 border-d5d" style="margin-left: 8px;">
                                    <a href="javascript:" data-toggle="tooltip" data-placement="bottom" class="btn upload-file border-d5d" style="outline: 0;border: 1px solid transparent!important;box-shadow: 0 0 0 0;">上传文件</a>
                                </span>
                            </div>
                            <div class="upload-preview text-center upload-preview " style="top: -12px;width: 320px;height: 134px;border: 0px solid #e3e3e3;">
                                <div class='border_img' style="text-align: left;">
                                    <img src="images/class_noimg.jpg" class="upload-preview-img jkl1" style="width: 100px;height: 100px;">
                                    <span class="font_l" style="line-height:134px;margin-left: 30px;">(44px*44px)</span>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
		<div style="height: 30px;"></div>
		<div class="page_h10 page_bort">
			<input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()" style="margin-right: 60px!important;">
			<input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
		</div>
	</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
    <script>
        var aa = $(".pane_bo").height();
        var bb = $(".auto_form").height();
        if (aa < bb) {
            $(".page_h20").css("display", "block")
        } else {
            $(".page_h20").css("display", "none")
        }

        $(document).ready(function () {
            $(".sidebar-1").niceScroll();
        })
        function check() {
            $.ajax({
                cache: true,
                type: "POST",
                dataType:"json",
                url:\'index.php?module=payment&action=Set\',
                data:$(\'#form1\').serialize(),// 你的formid
                async: true,
                success: function(data) {
                    layer.msg(data.status,{time:2000});
                    if(data.suc){
                        location.href=\'index.php?module=payment\';
                    }
                }
            });
        }
    </script>
'; ?>


</body>
</html>