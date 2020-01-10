<?php /* Smarty version 2.6.31, created on 2019-12-20 16:57:27
         compiled from Aboutus.tpl */ ?>
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
        .btn1 {
            width: 80px;
            height: 36px;
            line-height: 36px;
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
            background-color: #2481e5 !important;
            color: #fff !important;
        }
    </style>
'; ?>


<body class="body_bgcolor">

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

<div class="page-container pd-20 page_absolute">
    <div class="swivch swivch_bot page_bgcolor">
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <a href="index.php?module=system&action=Config" class="btn1">基础配置</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][1] == 1): ?>
            <a href="index.php?module=system&action=Agreement" class="btn1" >协议配置</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
            <a href="index.php?module=system&action=Aboutus" class="btn1 swivch_active" >关于我们</a>
        <?php endif; ?>
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>
    <form name="form1" id='form1' class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div id="tab-system" class="HuiTab">

            <div class="row cl">
                <label class="form-label col-2"><span class="c-red">*</span>内容设置：</label>
                <div class="formControls col-10">
                    <script id="editor" type="text/plain" style="width:100%;height:400px;" name="aboutus"><?php echo $this->_tpl_vars['aboutus']; ?>
</script>
                </div>
            </div>

        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/ueditor.tpl", 'smarty_include_vars' => array('sitename' => "ueditor插件")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
    <script type="text/javascript">
        $(function(){
            var ue = UE.getEditor(\'editor\');
            $(\'.skin-minimal input\').iCheck({
                checkboxClass: \'icheckbox-blue\',
                radioClass: \'iradio-blue\',
                increaseArea: \'20%\'
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
                dataType: "json",
                url: \'index.php?module=system&action=Aboutus\',
                data: $(\'#form1\').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        setTimeout(function () {
                            location.href = "index.php?module=system&action=Aboutus";
                        }, 2000)
                    }
                }
            });
        }
    </script>
'; ?>

</body>
</html>