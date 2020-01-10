<?php /* Smarty version 2.6.31, created on 2019-12-27 15:25:06
         compiled from Modify.tpl */ ?>
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
<body>
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

<div class="pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
        <input type="hidden" name="uploadImg" value="<?php echo $this->_tpl_vars['uploadImg']; ?>
">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>引导图：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div class="upload-group">
                    <div class="input-group">
                        <input class="form-control file-input " name="image" value="<?php echo $this->_tpl_vars['image']; ?>
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
                        <span class="upload-preview-tip">750×1334</span>
                        <img class="upload-preview-img" src="<?php echo $this->_tpl_vars['image']; ?>
">
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
        <?php if ($this->_tpl_vars['store_type'] != 1): ?>
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red"></span>活动类型：</label>
                <div class="formControls col-4 skin-minimal">
                    <div class="radio-box">
                        <input name="type" type="radio" value="0" checked="checked" <?php if ($this->_tpl_vars['type'] == 0): ?> checked="checked"<?php endif; ?>/>
                        <label for="sex-1">安装</label>
                    </div>
                    <div class="radio-box">
                        <input name="type" type="radio" value="1" <?php if ($this->_tpl_vars['type'] == 1): ?> checked="checked"<?php endif; ?>/>
                        <label for="sex-2">启动</label>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
        <?php endif; ?>
        <div class="row cl">
            <label class="form-label col-4">排序号：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['sort']; ?>
" placeholder="" id="" name="sort">
            </div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

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
                url: \'index.php?module=guide&action=Modify\',
                data: $(\'#form1\').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        location.href = "index.php?module=guide";
                    }
                }
            });
        }
    </script>
'; ?>

</body>
</html>