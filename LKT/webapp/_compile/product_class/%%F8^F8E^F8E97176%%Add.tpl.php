<?php /* Smarty version 2.6.31, created on 2019-12-20 16:09:30
         compiled from Add.tpl */ ?>
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
.input_a > a {
    color: #2890FF
}
.upload-preview {
    position: absolute;
    top: 50;
    margin: 0;
    z-index: 50;
    border: none;
    width: 122px;
    height: 160px;
    line-height: 14px;
}
.upload-preview .upload-preview-img {
	width: 78px;
	height: 78px;
	margin-left: 1px;
	margin-top: 1px;
	background: #FFFFFF;
}
select {
    height: 36px;
    border-radius: 2PX;
}
.btn{
    padding: 0;
    height: 36px;
}
.slevel_0{
    width: 150px !important;
    border: 1px solid #D5DBE8;
    height: 25px;
    margin-right: 10px;
}
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
'; ?>

</head>
<body class='iframe-container'>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<nav class="nav-title">
	<span>商品管理</span> 
	<span class='pointer' onclick="javascript :history.back(-1);"><span class="arrows">&gt;</span>商品分类</span> 
	<span class="nav_zi"><span class="arrows">&gt;</span>添加</span>
</nav>

<div class="iframe-content" style="background-color: #fff;">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD title_zi" >新增分类</div>
                <div class="formContentSD">
                    <input type="hidden" name="cid" class="cid" value="<?php echo $this->_tpl_vars['cid']; ?>
">
                    <input type="hidden" name="class[sid]" class="val" value="<?php echo $this->_tpl_vars['cid']; ?>
">
                    <input type="hidden" name="class[level]" class="level" value="<?php echo $this->_tpl_vars['level']; ?>
">
                    <input type="hidden" name="level_1" class="level_1" value="<?php echo $this->_tpl_vars['level']; ?>
">
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red">*</span><span>分类名称：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="class[pname]" value="" datatype="*6-18" placeholder="请输入分类名称" />
                        </div>
                    </div>
                    <div class="formListSD" >
                        <div class="formTextSD"><span class="c-red">*</span><span>分类级别：</span></div>
                        <div class="formInputSD">
                            <select style="border: 1px solid #D5DBE8;display: flex;justify-content: center;" class="form-control link-list-select1 " name="level" onchange="slevel()" id="select_c" <?php if ($this->_tpl_vars['cid'] != 0): ?>disabled="disabled"<?php endif; ?>>
                                <option selected="true" value="0">请选择分类级别</option>
                                <?php echo $this->_tpl_vars['level_list']; ?>

                            </select>
                        </div>
                    </div>
                    <div class="formListSD slevel_box" id="slevel_box" style="display: none;">
                        <div class="formTextSD"><span class="c-red"></span><span>上级分类：</span></div>

                    </div>
                    <div class="formListSD">
                        <div class="formTextBigSD"><span class="must"></span><span>分类图标：</span></div>

                        <div class="formInputSD upload-group multiple">
                            <div id="sortList" class="upload-preview-list uppre_auto">
                                <div class="upload-preview form_new_img" style="display: none;margin-top: -50px !important;">
                                    <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
                                    <img src="images/icon1/add_g_t.png" class="upload-preview-img">
                                    <input type="hidden" name="class[img]" class="file-item-input" value="">
                                </div>
                            </div>

                            <div  class="select-file form_new_file from_i">
                                <div>
                                    <img  src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                                    <span class="form_new_span">上传图片</span>
                                </div>
                            </div>
                            <span class="addText" style="max-width: 350px;">（建议上传120*120px的图片）</span>
                        </div>
                    </div>
                </div>
            </div>
        </table>
        <div style="height: 40px;"></div>
        <div class="row cl page_bort" style="position: fixed; bottom: 0; left: 10px; right: 10px; display: block; margin: 0; width: auto;background: #fff;z-index: 999;">
            <div style="float:right;height: 67px;">
				<input class="btn btn-primary radius ta_btn3 btn-right" type="button" onclick="check()" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
                <input class="btn btn-primary radius ta_btn4 btn-left" type="button" value="&nbsp;&nbsp;返回&nbsp;&nbsp;" onclick="javascript:history.back(-1);" style="background-color: white!important;color:#2890FF;">
            </div>
        </div>
        <div class="page_h10"></div>
    </form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script>
    var str_option = <?php echo $this->_tpl_vars['str_option']; ?>
;
    var superCid = <?php echo $this->_tpl_vars['superCid']; ?>
;
    console.log(superCid)
    var cid = $(".cid").val()
    <?php echo '
    $(function () {
        slevel();
    });
    // 选择分类级别
    function slevel() {
        var arr = [];
        var keds = [];
        for (var i in str_option) {
            arr.push(str_option[i]); //属性
            keds.push(i);
        }
        if(cid != 0){
			$(\'.nav_zi\').html(\'<span class="arrows">&gt;</span>添加子类\')
			$(\'.title_zi\').text(\'添加子类\')
            $(".slevel_box").show();
            $("#slevel_box").empty();
            var res = \'<div class="formTextSD"><span class="c-red"></span><span>上级分类：</span></div>\';
            $("#slevel_box").append(res);
            for (var i = 0; i < arr.length; i++) {
                var tid = i + 1;
                var str = \'<div class="formInputSD slevel_\'+tid+\'">\' +
                    \'<select name="select[\'+tid+\']" class="form-control link-list-select1 slevel_0" onchange="superior(\'+tid+\')" id="select_\'+tid+\'" disabled="disabled">\' +
                    \'<option selected="true" value="0">请选择</option>\';
                for (var j = 0; j < arr[i].length; j++) {
                    if (keds[i] == arr[i][j].cid) {
                        str += \'<option selected="true" value="\' + arr[i][j].cid + \'">\' + arr[i][j].pname + \'</option>\';
                    } else {
                        str += \'<option  value="\' + arr[i][j].cid + \'">\' + arr[i][j].pname + \'</option>\';
                    }
                }
                str += \'</select>\' +
                    \' </div>\';
                $("#slevel_box").append(str);
            }
        }else{
            var select_c = $("#select_c").val();

            $(\'.level\').val(select_c);

            if (select_c < 2) {
                $(".slevel_box").hide();
                $(\'.val\').val(0);
            } else {
                $(".slevel_box").show();
                $("#slevel_box").empty();
                var res = \'<div class="formTextSD"><span class="c-red"></span><span>上级分类：</span></div>\';
                $("#slevel_box").append(res);
                for (var i = 0; i < select_c - 1; i++) {
                    var tid = i + 1;
                    var str = \'<div class="formInputSD slevel_\'+tid+\'">\' +
                        \'<select name="select[\'+tid+\']" class="form-control link-list-select1 slevel_0" onchange="superior(\'+tid+\')" id="select_\'+tid+\'">\' +
                        \'<option selected="true" value="0">请选择</option>\';
                    if(tid == arr.length){
                        for (var j = 0; j < arr[i].length; j++) {
                            if (keds[i] == arr[i][j].cid) {
                                str += \'<option selected="true" value="\' + arr[i][j].cid + \'">\' + arr[i][j].pname + \'</option>\';
                            } else {
                                str += \'<option  value="\' + arr[i][j].cid + \'">\' + arr[i][j].pname + \'</option>\';
                            }
                        }
                    }
                    str += \'</select>\' +
                        \' </div>\';
                    $("#slevel_box").append(str);
                }
            }
        }
    }
    // 选择上级
    function superior(obj) {
        var v=document.getElementById("select_"+obj).value;
        var select_c = $("#select_c").val();
        var level = $(".level").val();

        for (var i = obj; i < select_c; i++) {
            var tid = i + 1;
            RemoveDropDownList(document.getElementById("select_"+tid));
        }
        if(level - 1 == obj){

        }else{
            // 选择了
            if (v != 0) {
                $(\'.val\').val(v);
                $.ajax({
                    type: "GET",
                    url: location.href + \'&action=Ajax&v=\' + v,
                    data: "",
                    success: function (msg) {
                        var num = obj + 1;
                        var res = JSON.parse(msg);
                        $("#select_"+num).html(res);
                    }
                });
            } else {
                var num = obj - 1;
                var v1 = document.getElementById("select_"+num).value;
                $(\'.val\').val(v1);
            }
        }
    }

    function RemoveDropDownList(obj) {
        if (obj) {
            var len = obj.options.length;
            if (len > 0) {
                for (var i = len; i >= 1; i--) {
                    obj.remove(i);
                }
            }
        }
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
            dataType: "json",
            url: \'index.php?module=product_class&action=Add\',
            data: $(\'#form1\').serialize(),// 你的formid
            async: true,
            success: function (data) {
                layer.msg(data.status, {time: 2000});
                console.log(data.suc)
                if (data.suc) {
                    location.href = "index.php?module=product_class&cid="+superCid;
                }
            }
        });
    }
</script>
'; ?>

</body>
</html>