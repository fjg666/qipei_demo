<?php /* Smarty version 2.6.31, created on 2019-12-20 18:01:30
         compiled from ThirdInfo.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style>
	.form-horizontal .row{
		display: flex;
		align-items: center;
	}
</style>
'; ?>

<body>
<nav class="breadcrumb page_bgcolor">
        	
        		
        			<span class="c-gray en"></span>
        			<span  style='color: #414658;'>授权管理</span>
        	
        			<span  class="c-gray en">&gt;</span>
        		
        			<span  style='color: #414658;'>参数设置</span>
        	
</nav>
<div class="pd-20 page_absolute form-scroll" >
	<div class="page_title">参数设置</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0 10px;margin-top: 40px;">
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
        <div class="row cl page_padd">
            <label class="form-label col-4"><span class="c-red">*</span>第三方平台appid：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['appid']; ?>
" placeholder="" name="appid">
            </div>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4"><span class="c-red">*</span>第三方平台秘钥：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['appsecret']; ?>
" placeholder="" name="appsecret">
            </div>
        </div>

        <div class="row cl page_padd">
            <label class="form-label col-4">消息检验Token：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['check_token']; ?>
" placeholder="" name="check_token">
            </div>
        </div>

        <div class="row cl page_padd">
            <label class="form-label col-4">消息加解密key：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['encrypt_key']; ?>
" placeholder="" name="encrypt_key">
            </div>
           
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4">服务器域名：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['serve_domain']; ?>
" name="serve_domain" placeholder="">
                
            </div>
            <span style="color: #97a0b4;">(多个域名以英文,分隔 域名不需要加https)</span>

            
        </div>

        <div class="row cl page_padd">
            <label class="form-label col-4">业务域名：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['work_domain']; ?>
" name="work_domain" placeholder="">
                
            </div>
            <span style="color: #97a0b4;">(多个域名以英文,分隔 域名不需要加https)</span>

            
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4">授权回调地址：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['redirect_url']; ?>
" name="redirect_url" placeholder="">
                
            </div>
            <span style="color: red;"></span>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4">小程序请求地址：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['mini_url']; ?>
" name="mini_url" placeholder="">
                
            </div>
            <span style="color: red;"></span>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4">客服请求地址：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['kefu_url']; ?>
" name="kefu_url" placeholder="">
                
            </div>
            <span style="color: red;"></span>
        </div>
        <div class="row cl page_padd">
            <label class="form-label col-4">体验二维码地址：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['qr_code']; ?>
" name="qr_code" placeholder="">
                
            </div>
            <span style="color: red;"></span>
        </div>
        <!-- <div class="row cl page_padd">
            <label class="form-label col-4">H5页面地址：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['H5']; ?>
" name="H5" placeholder="">
                
            </div>
            <span style="color: red;"></span>
        </div> -->
        <div class="row cl page_padd">
            <label class="form-label col-4">根目录路径：</label>
            <div class="formControls col-8">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['endurl']; ?>
" name="endurl" placeholder="">
                
            </div>
            <span style="color: red;"></span>
        </div>
      
        <div style="height: 100px;"></div>
		
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
                url:\'index.php?module=third&action=ThirdInfo\',
                data:$(\'#form1\').serialize(),// 你的formid
                async: true,
                success: function(data) {
                   if(data.suc == 1){
                        layer.msg(data.msg);
                        setTimeout(function(){
                            location.href=\'index.php?module=third&action=ThirdInfo\';
                        },2000);
                    }else{
                        layer.msg(data.msg);
                    }
                }
            });
        }
    </script>
'; ?>

</body>
</html>