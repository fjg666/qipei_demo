<?php /* Smarty version 2.6.31, created on 2019-12-31 16:01:26
         compiled from Examine.tpl */ ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style>
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
'; ?>

<body class="body_bgcolor">
<nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;color: #0a0a0a;text-decoration:none;"  href="javascript:history.back(-1)">店铺 </a>
    <span class="c-gray en">&gt;</span>
    审核
</nav>
<div class="pd-20 page_absolute" style="font-size: 16px;">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;">
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['list']->id; ?>
">
        <input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['list']->user_id; ?>
">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD">店铺详情</div>
                <div class="formContentSD">
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>店铺名称：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->name; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>店铺信息：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->shop_information; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>经营范围：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->shop_range; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>用户名称：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->user_name; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>真实姓名：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->realname; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>身份证号码：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->ID_number; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>联系电话：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->tel; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>联系地址：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['list']->address; ?>
</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>所属性质：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php if ($this->_tpl_vars['list']->shop_nature == 0): ?>个人<?php else: ?>企业<?php endif; ?></text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>营业执照：</span></div>
                        <div class="formInputSD">
                            <div class="upload-group">
                                <div class="upload-preview text-center upload-preview">
                                    <span class="upload-preview-tip">100×100</span>
                                    <img class="upload-preview-img" onclick="pimg(this)" src="<?php echo $this->_tpl_vars['list']->business_license; ?>
">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>审核状态：</span></div>
                        <div class="formInputSD">
                            <label class="radio-label">
                                <input type="radio" name="review_status" value="1" checked onClick="show(this)">
                                <span class="label-icon"></span>
                                <span class="label-text">审核通过</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="review_status" value="2" onClick="show(this)">
                                <span class="label-icon"></span>
                                <span class="label-text">审核不通过</span>
                            </label>
                        </div>
                    </div>
                    <div class="formListSD" id="review_result" style="margin: 2px 0px;display: none;">
                        <div class="formTextSD"><span>拒绝理由：</span></div>
                        <div class="formInputSD">
                            <textarea rows="3" cols="60" name="review_result"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </table>
        <div class="page_h10" style="height: 58px!important;border-top: solid 1px #E9ECEF;">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-left: 10px;margin-right: 30px!important;">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
        <div class="page_h10"></div>
    </form>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
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
function show(obj) {
    if (obj.value == \'1\') { // 通过
        document.getElementById(\'review_result\').style.display = "none"; // 拒绝理由隐藏
    } else {
        document.getElementById(\'review_result\').style.display = ""; // 拒绝理由显示
    }
}
function pimg(obj) {
    var _this = $(obj);//将当前的pimg元素作为_this传入函数
    imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
}
function imgShow(outerdiv, innerdiv, bigimg, _this) {
    var src = _this.attr("src");//获取当前点击的pimg元素中的src属性
    $(bigimg).attr("src", src);//设置#bigimg元素的src属性

    /*获取当前点击图片的真实大小，并显示弹出层及大图*/
    $("<img/>").attr("src", src).load(function () {
        var windowW = $(window).width();//获取当前窗口宽度
        var windowH = $(window).height();//获取当前窗口高度
        var realWidth = this.width;//获取图片真实宽度
        var realHeight = this.height;//获取图片真实高度
        var imgWidth, imgHeight;
        var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

        if (realHeight > windowH * scale) {//判断图片高度
            imgHeight = windowH * scale;//如大于窗口高度，图片高度进行缩放
            imgWidth = imgHeight / realHeight * realWidth;//等比例缩放宽度
            if (imgWidth > windowW * scale) {//如宽度扔大于窗口宽度
                imgWidth = windowW * scale;//再对宽度进行缩放
            }
        } else if (realWidth > windowW * scale) {//如图片高度合适，判断图片宽度
            imgWidth = windowW * scale;//如大于窗口宽度，图片宽度进行缩放
            imgHeight = imgWidth / realWidth * realHeight;//等比例缩放高度
        } else {//如果图片真实高度和宽度都符合要求，高宽不变
            imgWidth = realWidth;
            imgHeight = realHeight;
        }
        $(bigimg).css("width", imgWidth);//以最终的宽度对图片缩放

        var w = (windowW - imgWidth) / 2;//计算图片与窗口左边距
        var h = (windowH - imgHeight) / 2;//计算图片与窗口上边距
        $(innerdiv).css({"top": h, "left": w});//设置#innerdiv的top和left属性
        $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg
    });

    $(outerdiv).click(function () {//再次点击淡出消失弹出层
        $(this).fadeOut("fast");
    });
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
        url:\'index.php?module=mch&action=Examine\',
        data:$(\'#form1\').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href = "index.php?module=mch&action=List";
            }
        }
    });
}
</script>
'; ?>

</body>
</html>