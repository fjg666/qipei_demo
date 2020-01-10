<?php /* Smarty version 2.6.31, created on 2019-12-24 12:14:50
         compiled from TemplateAdd.tpl */ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title>分类添加</title>
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

            .label-help {
                display: inline-block;
                font-size: .65rem;
                background: #555;
                color: #fff;
                border-radius: 999px;
                width: 1rem;
                height: 1rem;
                line-height: 1rem;
                text-align: center;
                text-decoration: none;
                margin-left: .25rem;
            }

            .label-help:hover,
            .label-help:visited {
                color: #fff;
                text-decoration: none;
            }

            .input-group {
                justify-content: flex-start;
                align-items: center;
            }


            .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9 {
                padding: 0;
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

            .text-more {
                display: inline-block;
                width: 70%;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                word-break: break-all;
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

            .item-icon {
                width: 1rem;
                height: 1rem;
                line-height: 1;
                font-size: 1.3rem;
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



            .input_a {
                background-color: #fff;
				border: 1px solid #2890FF;
				color: #2890FF;
				border-radius: 2px;
            }

            .input_a > a {
                color: #2890FF
            }
			.btn{padding: 0;}
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
            .input_border {
                border: 1px solid #D5DBE8;
                border-radius: 2px;
            }
			.input_border a{
				color:#888f9e;
			}
            .upload-preview {
                position: absolute;
                right: 3%;
                top: 0;
                margin: 0;
                z-index: 50;
                border: none;
                width: 122px;
                height: 160px;
            }

            .upload-preview .upload-preview-img {
                width: 91px;
                height: 75px;
            }

            .upload-preview .upload-preview-tip {
                bottom: 0;
                line-height: 10px;
            }

            .upload-preview {
                line-height: 14px;
            }

            .form-group {
                background-color: #fff;
                padding: 10px 50px 30px 50px;
                border-radius: 4px;
            }

            .input-group .form-control {
                flex: 0 0 auto;
                 padding-left: 6px;
                padding-right: 6px;
            }

            .input-group .input_width {
                width: 300px;
            }

            .input-group .input_width_l {
                width: 550px;
            }

            .position_l {
                right: 17%;
            }

            .border_img {
                width: 120px;
                height: 120px;
                border: 1px solid #D5DBE8;
                border-radius: 2px;
                padding: 25px;
                position: relative;

            }

            .border_img > span {
                position: absolute;
                width: 20px;
                height: 20px;
                bottom: 0;
                right: 0;
            }

            .border_img > span > a {
                width: 20px;
                height: 20px;
                padding: 0;
                border: none;
                margin-left: 0;
                background-color: #eee;
            }

            .font_l {
                font-size: 14px;
                color: #97A0B4;
                margin-top: 10px;
            }

            .input-group {
                margin-top: 20px;
                line-height: 14px;
            }

            .btn-danger {
                background-color: #fff;
                border: 1px solid #2890FF;
                color: #2890FF;
            }

            .font_f {
                color: #666666;
                font-size: 14px;
                padding-left: 20px;
            }

            .float_div {
                width: 100%;
            }

            .float_div:after {
                display: block;
                content: \'\';
                clear: both;
            }

            .float_l {
                float: right;
                margin-right: 20px;
            }

            .btn-primary {
                background-color: #2890FF;
                border-color: #2890FF
            }

            .btn_hov:hover {
                background-color: #fff;
                border: 1px solid #2481E5;
                color: #2481E5;
            }

          
            select {

                height: 36px;

                border-radius: 2PX;

            }
			.formControls{margin-right: 10px;}
            .panel {
                background-color: #edf1f5;
            }

            .row_bottom {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 76px;
                border-top: 1px solid #E9ECEF;
            }

            .row_btn {
                width: 112px;
                height: 36px !important;
                line-height: 36px !important;
                padding: 0 !important;
                float: right;
                margin: 20px 60px 0 0;
                display: block;
            }

            .btn-danger {
                border: 1px solid #2890FF;
                color: #2890FF !important;
            }

            .btn-danger a {
                color: #2890FF;
                text-decoration: none;
            }

            .btn-danger:hover {
                border: 1px solid #2890FF !important;
            }

            .btn-danger:hover a {
                color: #2890FF !important;
            }
            .breadcrumb{background-color: transparent!important;}
            .btn{width: auto!important;}
            .ta_btn4,.ta_btn3{text-align: center;}
            .ta_btn4 a,.ta_btn3{text-decoration: none!important;}
			
			.text-left{width: 200px;display: block;text-align: right!important;}
			.panel-body .row{margin-left: 0;}
			.btn-right,.btn-left{
				float: right;
			}
        </style>
    '; ?>

</head>


<body style="background-color: #edf1f5;height: 100vh;">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="main-body">
    <div class="panel mb-3" style="position: static;">
        <nav class="breadcrumb page_bgcolor">
                    <span class="c-gray en"></span>
                    <span  style='color: #414658;'>授权管理</span>
                    <span  class="c-gray en">&gt;</span>
                    <span  style='color: #414658;'>模板设置</span>
                    <span  class="c-gray en">&gt;</span>
                    <span  style='color: #414658;'>添加模板</span>
        </nav>
        <div class="panel-body pd-20 page_absolute">
			<div class="page_title">添加模板</div>
            <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class=" text-right">

                        <div class="upload-group">
                            <div class="input-group row">
                                <span class="col-form-label col-sm-1 col-md-1 col-lg-1 text-left"><font
                                            color=red>*</font>模板名称：</span>
                                <input type="text" name="title"
                                       class="form-control input_fy input_width col-sm-3 col-md-3 col-lg-3"
                                       value="">
                            </div>

                            <div class="input-group row">
                            	<span class=" col-sm-1 col-md-1 col-lg-1 text-left"><font color="red">*</font>行业：</span>
                            	<select name="trade_data"  style="width: 300px;max-width: 25%;border: 1px solid #D5DBE8;display: flex;justify-content: center;" class="form-control link-list-select1 ">
                            		<option value="">请选择所属行业</option>
                                    <?php $_from = $this->_tpl_vars['trade_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                            		<option value="<?php echo $this->_tpl_vars['item']->trade_code; ?>
"><?php echo $this->_tpl_vars['item']->trade_text; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                            		
                            	</select>

                            </div>

                            <div class="input-group row">
                                <span class="col-sm-1 col-md-1 col-lg-1 text-left">模板展示图：</span>
                                <input index="0" value="<?php echo $this->_tpl_vars['item']->top_img; ?>
" name="img_url"
                                       class="form-control input_fy input_width col-sm-3 col-md-3 col-lg-3 file-input ">
                                <span class="input-group-btn input_a col-sm-1 col-md-1 col-lg-1"><a
                                            href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                            title="" class="btn  select-file"
                                    >选择文件</a></span>
                                <span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1"><a
                                            href="javascript:" data-toggle="tooltip" data-placement="bottom"
                                            class="btn upload-file">上传文件</a></span>
                            </div>
                            <div class="upload-preview text-center upload-preview position_l" style="top: 90px;width: 240px;height: 340px;left:60%;">
                                <div class='border_img' style="width: 240px;height: 340px;">
                                    <?php if ($this->_tpl_vars['item']->top_img): ?>
                                        <img src="<?php echo $this->_tpl_vars['item']->top_img; ?>
" class="upload-preview-img jkl" style="width: 240px;height: 340px;">
                                    <?php else: ?>
                                        <img src="./images/class_noimg.jpg" class="upload-preview-img jkl1" style="width: 240px;height: 340px;">
                                    <?php endif; ?>
                                    <span class="input-group-btn"><a style="margin-left: 0;"
                                                                     data-toggle="tooltip" data-placement="bottom"
                                                                     title="" class="btn delete-file">
                                    <img src="images/icon1/del.png" style="margin: auto;vertical-align: middle;"/></a></span>
                                </div>
                                <p class="font_l" style="margin-top: -18px;">(模板展示图效果)</p>
                            </div>

                            <div class="input-group row">
                                <span class="col-form-label col-sm-1 col-md-1 col-lg-1 text-left"><font
                                            color=red>*</font>模板ID：</span>
                                <input type="text" name="template_id"
                                       class="form-control input_fy input_width col-sm-3 col-md-3 col-lg-3"
                                       value="">
                            </div>

                            <div class="input-group row">
                            	<span class="col-form-label col-sm-1 col-md-1 col-lg-1 text-left"><font color=red>*</font>模板简介：</span>
                            	<textarea name="lk_desc" class="form-control input_fy input_width col-sm-3 col-md-3 col-lg-3" style="height: 100px;"> </textarea>	
                            </div>
                        </div>
                        
                    </div>
                </div>

				<div class="bottomBtnWrap page_bort">
					<button type="button"  onclick="check()" class="saveBtnSD bottomBtn btn-right">保存</button >
					<button type="button"  onclick="javascript :history.back(-1);" class="backBtnSD bottomBtn btn-left">取消</button >
				</div>
            </form>

        </div>
    </div>
</div>


<script>
    
    <?php echo '
   

    function check() {

        $.ajax({
            cache: true,
            type: "POST",
            dataType: "json",
            url: \'index.php?module=third&action=TemplateAdd\',
            data: $(\'#form1\').serialize(),// 你的formid
            async: true,
            success: function (data) {
                console.log(data);
                if(data.suc == 1){

                	layer.msg(data.msg,{time:2000});
                   setTimeout(function(){
                    location.href=\'index.php?module=third&action=Template\';
                   },2000);
                	
                }else{
                	layer.msg(data.msg,{time:2000});
                	location.replace();
                }
            }
        });
    }


</script>
'; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>