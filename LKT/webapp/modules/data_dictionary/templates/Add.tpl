{include file="../../include_path/header.tpl" sitename="公共头部"}{literal}<style>input::-webkit-outer-spin-button,input::-webkit-inner-spin-button {    -webkit-appearance: none;}input[type="number"] {    -moz-appearance: textfield;}.inputC1:checked + label::before{    width: 16px;    height: 16px;    top: 11px;    left: 0px;}</style>{/literal}<body>{include file="../../include_path/nav.tpl" sitename="面包屑"}<div class="main pd-20 page_absolute ">    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding: 0!important;">        <div class="formDivSD">            <div class="formTitleSD" style="font-size: 16px;">添加数据字典</div>            <div class="formContentSD">                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>数据编码：</span></div>                    <div class="formInputSD">                        <input type="text" min="1" name="code" id="code" value="" readonly="readonly" style="width: 340px;" />                    </div>                </div>                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>数据名称：</span></div>                    <select name="data_dictionary_id" class="data_dictionary_id" id="data_dictionary_id" style="width:340px;height: 36px;vertical-align: middle;padding-left: 6px;" onClick="data_name();" >                        <option  value="0">请选择数据名称</option>                        {foreach from=$data_dictionary_list item=item name=f1 key=k}                            <option value="{$item->id}" >{$item->name}</option>                        {/foreach}                    </select>                    <button type="button" onclick="add()" style="width: 100px;height: 36px;line-height: 36px;border: 1px #2890FF solid;text-align: center;color: #2890FF;margin-left: 5px;background-color: #ffffff;">添 加</button>                </div>                <div class="formListSD" id="subordinate" style="display: none;">                    <div class="formTextSD"><span class="c-red">*</span><span>所属属性名称：</span></div>                    <select name="name" class="name" id="name" style="width:340px;height: 36px;vertical-align: middle;padding-left: 6px;" >                        <option value="0">请选择属性名称</option>                    </select>                </div>                <div class="formListSD" id="code_value" style="display: none;">                    <div class="formTextSD"><span class="c-red">*</span><span>code：</span></div>                    <div class="formInputSD">                        <input type="text" min="1" name="value" id="value" value="" style="width: 340px;" />                    </div>                </div>                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>值：</span></div>                    <div class="formInputSD">                        <input type="text" min="1" name="text" id="text" value="" style="width: 340px;" />                    </div>                </div>                <div class="formListSD">                    <div class="formTextSD"><span class="c-red">*</span><span>是否生效：</span></div>                    <div class="form_new_r form_yes">                        <div class="ra1">                            <input name="status"  type="radio" checked="checked" style="display: none;" id="status-1" class="inputC1" value="1">                            <label for="status-1">是</label>                        </div>                        <div class="ra1">                            <input name="status"  type="radio" style="display: none;" id="status-2" class="inputC1" value="0">                            <label for="status-2">否</label>                        </div>                    </div>                </div>            </div>        </div>        <div class="page_h10" style="height: 57px!important;width: 98%;position: fixed;bottom: 0;border-top: 1px solid rgba(180, 180, 180, 0.4);border-bottom: 10px solid rgb(237, 241, 245);background-color: #fff;z-index: 9999;">            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 60px!important;">            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">        </div>    </form></div>{include file="../../include_path/footer.tpl"}{literal}<script>var aa=$(".pd-20").height();if(aa<987){    $(".page_h20").css("display","block")}else{    $(".page_h20").css("display","none")    $(".row_cl").addClass("page_footer")}document.onkeydown = function (e) {    if (!e) e = window.event;    if ((e.keyCode || e.which) == 13) {        $("[name=Submit]").click();    }}// 添加数据字典名称function add() {    $("body", parent.document).append(`        <div class="maskNew">            <div class="maskNewContent" style="width: 460px;height: 282px !important;">                <div style="border-bottom: 2px solid #E9ECEF;height: 48px;line-height: 40px;">                    <div style="font-size: 16px;margin-left: 19px;font-weight: bold;">添加数据名称</div>                    <a href="javascript:void(0);" class="closeA" onclick=closeMask1() style="display: block;top:8px"><img src="images/icon1/gb.png"/></a>                </div>                <div >                    <input type="hidden" name="id" id="id" value="">                    <input type="hidden" name="url" id="url" value="index.php?module=data_dictionary&action=Add">                    <input type="hidden" name="res" id="res" value="index.php?module=data_dictionary&action=Add_name">                    <div class="formListSD" style="margin-bottom: 14px;margin-top: 35px;">                        <div class="formTextSD" style='height: 36px;font-size: 14px;'><span class="must">*</span><span>数据名称：</span></div>                        <div class="formInputSD" style='display: block;'>                            <div class='selectDiv'>                                <input type="text" name="name" id="name" value="" style="width: 302px;" />                            </div>                        </div>                    </div>                    <div class="formListSD">                        <div class="formTextSD" style='height: 36px;font-size: 14px;'><span class="must">*</span><span>是否生效：</span></div>                        <div class="form_new_r form_yes">                            <div class="ra1">                                <input name="status"  type="radio" checked="checked" style="display: none;" id="status-1" class="inputC1" value="1">                                <label for="status-1">是</label>                            </div>                            <div class="ra1">                                <input name="status"  type="radio" style="display: none;" id="status-2" class="inputC1" value="0">                                <label for="status-2">否</label>                            </div>                        </div>                    </div>                </div>                <div style="text-align:right;height: 69px;line-height: 69px;margin-top: 8px;">                    <button class="closeMask" onclick=closeMask1() style="margin-right:5px;border: 1px solid #008DEF;border-radius: 2px;background: #fff;color: #008DEF;">取消</button>                    <button onclick=add_name() class="closeMask" style="margin-right:40px;border: 1px solid #008DEF;border-radius: 2px;background: #008DEF;color: #fff;" >保存</button>                </div>            </div>        </div>    `)}// 选择数据字典名称function data_name() {    var data_dictionary_id = document.getElementById("data_dictionary_id").value; // 选择的数据字典名称ID    var options=$("#data_dictionary_id option:selected");//获取当前选择项.    var data_dictionary_name = options.text();    var res = '';    if(data_dictionary_name == '请选择数据名称'){        data_dictionary_name = '';    }    if(data_dictionary_name == '属性名' || data_dictionary_name == '属性值'){        document.getElementById('code_value').style.display = "none"; // 隐藏    }else{        document.getElementById('code_value').style.display = ""; // 显示    }    $.ajax({        cache: true,        type: "POST",        dataType:"json",        url:'index.php?module=data_dictionary&action=Ajax',        data:{            data_dictionary_id:data_dictionary_id,            data_dictionary_name:data_dictionary_name        },        async: true,        success: function(data) {            var code = data.code            $("#code").val(code);            if(data_dictionary_name == '属性值'){                $("#name").empty();                var list = data.list                var res = '';                for (var i in list){                    res += `<option value="${list[i]['id']}">${list[i]['text']}</option>`                }                $("#name").append(res);                document.getElementById('subordinate').style.display = ""; // 显示            }else{                document.getElementById('subordinate').style.display = "none"; // 隐藏            }        }    });}function check() {    $.ajax({        cache: true,        type: "POST",        dataType: "json",        url: 'index.php?module=data_dictionary&action=Add',        data: $('#form1').serialize(),// 你的formid        async: true,        success: function (data) {            layer.msg(data.status, {time: 2000});            if (data.suc) {                location.href = "index.php?module=data_dictionary";            }        }    });}</script>{/literal}</body></html>