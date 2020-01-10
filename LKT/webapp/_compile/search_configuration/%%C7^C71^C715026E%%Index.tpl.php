<?php /* Smarty version 2.6.31, created on 2019-12-20 16:10:46
         compiled from Index.tpl */ ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>系统参数</title>

</head>

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
    <form name="form1" id='form1' class="form form-horizontal" method="post"   enctype="multipart/form-data" >
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-2" style="width: 13% !important;">是否开启：</label>
                <div class="formControls col-2">
                    <div class="status_box">
                        <input type="hidden" class="status" name="is_open" id="is_open" value="<?php echo $this->_tpl_vars['is_open']; ?>
">
                        <div class="wrap" style="<?php if ($this->_tpl_vars['is_open'] == 1): ?>background-color:#5eb95e;<?php else: ?>background-color: #ccc;<?php endif; ?>">
                            <div class="circle" style="<?php if ($this->_tpl_vars['is_open'] == 1): ?>left:30px;<?php else: ?>left:0px;<?php endif; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-2" style="width: 13% !important;">关键词上限：</label>
                <div class="formControls col-xs-8 col-sm-3">
                    <input type="text" name="num" value="<?php echo $this->_tpl_vars['num']; ?>
" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-2" style="width: 13% !important;">关键词：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <textarea rows="3" cols="60" name="keyword"><?php echo $this->_tpl_vars['keyword']; ?>
</textarea>
                    <span style="color: #97A0B4;">关键词请用逗号隔开</span>
                </div>
            </div>
                                                                                                                                                </div>
        <div class="row cl page_bort" >
            <div class="save page_out" >
              
                <button class="btn btn-default radius ta_btn4" type="reset">取  消</button>
                 <input class="btn btn-primary radius submit1 ta_btn3" type="button" onclick="check()" value="保  存" name="Submit" style="width: 112px!important;">
            </div>
        </div>
    </form>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div> 

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript" src="style/js/layer/layer.js"></script>
<?php echo '
<style>
.wrap {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
}

.circle {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    transition: left 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
</style>
<script type="text/javascript">
document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}
$(\'.circle\').click(function () {
    var left = $(this).css(\'left\');
    left = parseInt(left);
    var status = $(this).parents(".status_box").children(".status");
    if (left == 0) {
        $(this).css(\'left\', \'30px\'),
            $(this).css(\'background-color\', \'#fff\'),
            $(this).parent(".wrap").css(\'background-color\', \'#5eb95e\');
        $(".wrap_box").show();
        status.val(1);
    } else {
        $(this).css(\'left\', \'0px\'),
            $(this).css(\'background-color\', \'#fff\'),
            $(this).parent(".wrap").css(\'background-color\', \'#ccc\');
        $(".wrap_box").hide();
        status.val(0);
    }
})
function check() {
    $.ajax({
        cache: true,
        type: "POST",
        dataType:"json",
        url:\'index.php?module=search_configuration\',
        data:$(\'#form1\').serialize(),// 你的formid
        async: true,
        success: function(data) {
            console.log(data)
            layer.msg(data.status,{time:2000});
            if(data.suc){
                setTimeout(function(){
                    location.href="index.php?module=search_configuration";
                },2000)
            }
        }
    });
}
</script>
'; ?>

</body>
</html>