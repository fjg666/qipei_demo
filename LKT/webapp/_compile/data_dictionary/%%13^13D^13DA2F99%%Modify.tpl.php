<?php /* Smarty version 2.6.31, created on 2019-12-30 10:13:26
         compiled from Modify.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo '<style>input::-webkit-outer-spin-button,input::-webkit-inner-spin-button {    -webkit-appearance: none;}input[type="number"] {    -moz-appearance: textfield;}#form1{	padding: 25px 60px;}.inputC1:checked + label::before{    width: 16px;    height: 16px;    top: 11px;    left: 0px;}</style>'; ?>
<body><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><div class="main pd-20 page_absolute ">    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding: 0!important;">        <div class="formDivSD">            <div class="formTitleSD" style="font-size: 16px;">编辑数据字典</div>            <div class="formContentSD">                <input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
">                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>数据编码：</span></div>                    <div class="formInputSD">                        <input type="text" min="1" name="code" id="code" value="<?php echo $this->_tpl_vars['code']; ?>
" readonly="readonly" style="width: 340px;" />                    </div>                </div>                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>数据名称：</span></div>                    <select name="data_dictionary_id" class="data_dictionary_id" id="data_dictionary_id" style="width:340px;height: 36px;vertical-align: middle;padding-left: 6px;" onClick="data_name();" >                        <option  value="0">请选择数据名称</option>                        <?php $_from = $this->_tpl_vars['data_dictionary_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>                            <?php if ($this->_tpl_vars['name'] == $this->_tpl_vars['item']->name): ?>                                <option value="<?php echo $this->_tpl_vars['item']->id; ?>
" selected="selected"><?php echo $this->_tpl_vars['item']->name; ?>
</option>                            <?php else: ?>                                <option value="<?php echo $this->_tpl_vars['item']->id; ?>
" ><?php echo $this->_tpl_vars['item']->name; ?>
</option>                            <?php endif; ?>                        <?php endforeach; endif; unset($_from); ?>                    </select>                    <button type="button" onclick="add()" style="width: 100px;height: 36px;line-height: 36px;border: 1px #2890FF solid;text-align: center;color: #2890FF;margin-left: 5px;background-color: #ffffff;">添 加</button>                </div>                <div class="formListSD" id="subordinate" <?php if ($this->_tpl_vars['name'] != '属性值'): ?> style="display: none;"<?php endif; ?>>                    <div class="formTextSD"><span class="c-red">*</span><span>所属属性名称：</span></div>                    <input type="hidden" name="s_name" id="s_name" value="<?php echo $this->_tpl_vars['s_name']; ?>
">                    <select name="name" class="name" id="name" style="width:340px;height: 36px;vertical-align: middle;padding-left: 6px;" >                        <option value="0">请选择属性名称</option>                    </select>                </div>                <div class="formListSD" id="code_value" <?php if ($this->_tpl_vars['name'] == '属性名' || $this->_tpl_vars['name'] == '属性值'): ?>style="display: none;"<?php endif; ?>>                    <div class="formTextSD"><span class="c-red">*</span><span>code：</span></div>                    <div class="formInputSD">                        <input type="text" min="1" name="value" id="value" value="<?php echo $this->_tpl_vars['value']; ?>
" style="width: 340px;" />                    </div>                </div>                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>值：</span></div>                    <div class="formInputSD">                        <input type="text" min="1" name="text" id="text" value="<?php echo $this->_tpl_vars['text']; ?>
" style="width: 340px;" />                    </div>                </div>                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>是否生效：</span></div>                    <div class="form_new_r form_yes">                        <div class="ra1">                            <input name="status"  type="radio" <?php if ($this->_tpl_vars['status'] == 1): ?>checked<?php endif; ?> style="display: none;" id="status-1" class="inputC1" value="1">                            <label for="status-1">是</label>                        </div>                        <div class="ra1">                            <input name="status"  type="radio" <?php if ($this->_tpl_vars['status'] == 0): ?>checked<?php endif; ?> style="display: none;" id="status-2" class="inputC1" value="0">                            <label for="status-2">否</label>                        </div>                    </div>                </div>            </div>        </div>        <div class="page_h10" style="height: 57px!important;width: 98%;position: fixed;bottom: 0;border-top: 1px solid rgba(180, 180, 180, 0.4);border-bottom: 10px solid rgb(237, 241, 245);background-color: #fff;z-index: 9999;">            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 60px!important;">            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">        </div>    </form></div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo '<script>var s_name = $("#s_name").val();document.onkeydown = function (e) {    if (!e) e = window.event;    if ((e.keyCode || e.which) == 13) {        $("[name=Submit]").click();    }}$(function() {    data_name();});// 添加数据字典名称function add() {    $("body", parent.document).append(`        <div class="maskNew">            <div class="maskNewContent" style="width: 460px;height: 282px !important;">                <div style="border-bottom: 2px solid #E9ECEF;height: 48px;line-height: 40px;">                    <div style="font-size: 16px;margin-left: 19px;font-weight: bold;">添加数据名称</div>                    <a href="javascript:void(0);" class="closeA" onclick=closeMask1() style="display: block;top:8px"><img src="images/icon1/gb.png"/></a>                </div>                <div >                    <input type="hidden" name="id" id="id" value="">                    <input type="hidden" name="url" id="url" value="index.php?module=data_dictionary&action=Modify">                    <input type="hidden" name="res" id="res" value="index.php?module=data_dictionary&action=Add_name">                    <div class="formListSD" style="margin-bottom: 14px;margin-top: 35px;">                        <div class="formTextSD" style=\'height: 36px;font-size: 14px;\'><span class="must">*</span><span>数据名称：</span></div>                        <div class="formInputSD" style=\'display: block;\'>                            <div class=\'selectDiv\'>                                <input type="text" name="name" id="name" value="" style="width: 302px;" />                            </div>                        </div>                    </div>                    <div class="formListSD">                        <div class="formTextSD" style=\'height: 36px;font-size: 14px;\'><span class="must">*</span><span>是否生效：</span></div>                        <div class="form_new_r form_yes">                            <div class="ra1">                                <input name="status"  type="radio" checked="checked" style="display: none;" id="status-1" class="inputC1" value="1">                                <label for="status-1">是</label>                            </div>                            <div class="ra1">                                <input name="status"  type="radio" style="display: none;" id="status-2" class="inputC1" value="0">                                <label for="status-2">否</label>                            </div>                        </div>                    </div>                </div>                <div style="text-align:right;height: 69px;line-height: 69px;margin-top: 8px;">                    <button class="closeMask" onclick=closeMask1() style="margin-right:5px;border: 1px solid #008DEF;border-radius: 2px;background: #fff;color: #008DEF;">取消</button>                    <button onclick=add_name() class="closeMask" style="margin-right:40px;border: 1px solid #008DEF;border-radius: 2px;background: #008DEF;color: #fff;" >保存</button>                </div>            </div>        </div>    `)}// 选择数据字典名称function data_name() {    var data_dictionary_id = document.getElementById("data_dictionary_id").value; // 选择的数据字典名称ID    var options=$("#data_dictionary_id option:selected");//获取当前选择项.    var data_dictionary_name = options.text();    var res = \'\';    if(data_dictionary_name == \'请选择数据名称\'){        data_dictionary_name = \'\';    }    if(data_dictionary_name == \'属性名\' || data_dictionary_name == \'属性值\'){        document.getElementById(\'code_value\').style.display = "none"; // 隐藏    }else{        document.getElementById(\'code_value\').style.display = ""; // 显示    }    $.ajax({        cache: true,        type: "POST",        dataType:"json",        url:\'index.php?module=data_dictionary&action=Ajax\',        data:{            data_dictionary_id:data_dictionary_id,            data_dictionary_name:data_dictionary_name        },        async: true,        success: function(data) {            var code = data.code            $("#code").val(code);            if(data_dictionary_name == \'属性值\'){                $("#name").empty();                var list = data.list;                var res = \'\';                for (var i in list){                    if(s_name == list[i][\'text\']){                        res += `<option value="${list[i][\'id\']}" selected="selected" >${list[i][\'text\']}</option>`                    }else{                        res += `<option value="${list[i][\'id\']}">${list[i][\'text\']}</option>`                    }                }                $("#name").append(res);                document.getElementById(\'subordinate\').style.display = ""; // 显示            }else{                document.getElementById(\'subordinate\').style.display = "none"; // 隐藏            }        }    });}function check() {    $.ajax({        cache: true,        type: "POST",        dataType: "json",        url: \'index.php?module=data_dictionary&action=Modify\',        data: $(\'#form1\').serialize(),// 你的formid        async: true,        success: function (data) {            layer.msg(data.status, {time: 2000});            if (data.suc) {                location.href = "index.php?module=data_dictionary";            }        }    });}</script>'; ?>
</body></html>