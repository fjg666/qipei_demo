<?php /* Smarty version 2.6.31, created on 2019-12-20 15:40:31
         compiled from Add.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute" >
	<div class="page_title">添加插件</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0;margin-top: 40px;">
        <div class="row cl page_padd">
            <label class="form-label col-4"><span class="c-red">*</span>插件名称：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="" placeholder="" name="name">
            </div>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4"><span class="c-red">*</span>插件标识：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="" placeholder="" name="Identification">
            </div>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4">排序号：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="100" placeholder="" name="sort">
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
        </div>
        <div style="height: 10px;"></div>
    </form>
      <div class="page_h20"></div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
    <script>
    	var aa=$(".pd-20").height();
		if(aa<583){
			$(".page_h20").css("display","block")
		}else{
			$(".page_bort").addClass("page_footer")
			$(".page_h20").css("display","none")
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
                url:\'index.php?module=plug_ins&action=Add\',
                data:$(\'#form1\').serialize(),// 你的formid
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
'; ?>

</body>
</html>