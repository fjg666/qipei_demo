<?php /* Smarty version 2.6.31, created on 2019-12-20 15:35:18
         compiled from Add.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<style type="text/css">
.input-text {
    width: 300px;
}
.wrap {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s
}
.inputC+label{border: 0;position: relative;}
.inputC+label:after{
    position: absolute;
    top: 2px;
    left: 0;
    width: 12px;
    height: 12px;
    border: 1px solid #ddd;
    content:"";
}
.inputC:checked +label::before{
    top: 3px;
    position: absolute;
    left: 0;
    height: 12px;
}
.circle {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}

.circle:hover {
    transform: scale(1.2);
    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
}

.radio-box{
    padding-left: 0px;
    padding-right: 10px;
}
.formTitleSD{
    font-weight: Bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
    height: 58px;
}
.formContentSD{
    padding: 28px 60px;
}
.formListSD{
    margin: 14px 0px;
}
.inputC:checked + label::before{
    width: 14px;
    height: 14px;
}
</style>
'; ?>

<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute form-scroll">
	<div class="page_title">添加商城</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;">
        <div class="formDivSD">
            <div class="formContentSD" >
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>客户名称：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" name="name">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>客户编号：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" name="customer_number">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>公司名称：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" name="company">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>商城根目录域名：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" name="domain">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>手机号：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" name="phone">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>价格：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" name="price">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>邮箱：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" id="" name="email">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>管理员账号：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="" placeholder="" name="set_admin_name">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>管理员密码：</span></div>
                    <div class="formInputSD">
                        <input type="password" class="input-text" value="" placeholder="" name="password">
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span>到期时间：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['endtime']; ?>
" placeholder="" id="endtime" name="endtime" style="width:150px;">
                    </div>
                </div>
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span>是否启用：</span></div>
                    <div class="formInputSD">
                        <div class="status_box">
                            <input type="hidden" value="0" name="status" class="status">
                            <div class="wrap" >
                                <div class="circle" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div style="height: 40px;"></div>
        <div class="page_h10 page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()" style="margin-right: 60px!important;">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-right" onclick="javascript :history.back(-1);">
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
var aa=$(".pd-20").height();
var bb=$("#form1").height();
if(aa<bb){
	$(".page_h20").css("display","block")
}else{
	$(".page_h20").css("display","none")
	$(".row_cl").addClass("page_footer")
}
laydate.render({
    elem: \'#endtime\',
    trigger: \'click\',
    type: \'datetime\'
});
$(function () {
    $(\'.circle\').click(function () {
        var left = $(this).css(\'left\');
        var status = $(".status");
        left = parseInt(left);
        if (left == 0) {
            $(this).css(\'left\', \'30px\'),
                $(this).css(\'background-color\', \'#fff\'),
                $(\'.wrap\').css(\'background-color\', \'#2890FF\');
            status.val(0);
        } else {
            $(this).css(\'left\', \'0px\'),
                $(this).css(\'background-color\', \'#fff\'),
                $(\'.wrap\').css(\'background-color\', \'#ccc\');
            status.val(1);
        }
    })
    $(\'.circle\').css(\'left\', \'30px\'),
        $(\'.circle\').css(\'background-color\', \'#fff\'),
        $(\'.wrap\').css(\'background-color\', \'#2890FF\');

})
document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}
function check() {
    var gyscompany = $(\'input[name=gyscompany\').val();
    var is_hexiao = $(\'#is_hexiao\').val();
    if(is_hexiao == 1 && gyscompany == \'\'){
        layer.msg(\'请填写供应商信息!\');
        return false;
    }
    $.ajax({
        cache: true,
        type: "POST",
        dataType:"json",
        url:\'index.php?module=Customer&action=Add\',
        data:$(\'#form1\').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href=\'index.php?module=Customer\';
            }
        }
    });
}
</script>
'; ?>

</body>
</html>