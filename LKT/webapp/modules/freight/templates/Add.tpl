{include file="../../include_path/header.tpl" sitename="DIY头部"}

<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script language="javascript"  src="modpub/js/check.js"> </script>

{literal}
<style type="text/css">
.inputC{
	display: inline-block!important;
	}
.inputC + label{
	display: inline-block!important;
	width: 100px;
    height: 20px;
    border: none;
	}
.inputC +label::before{
	position: absolute;top: 4px;left: -17px;width: 12px;height: 12px;border: 1px solid #ddd;content: "";
}
.inputC:checked +label::before{
	display: inline-block;
	position: absolute;
    left: -17px;
    top: 4px;
}
.keep{
    position: fixed;
    top:0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    filter:alpha(opacity=70);
    -moz-opacity:0.7;
    opacity: 0.7;
    background-color: #000;
    z-index: 3000;
}
.pop_model{
    position: fixed;
    left:20%;
    top: 10%;
    bottom:10%;
    background-color: #fff;
    width: 65%;
    box-shadow: 2px 2px 2px #000;
    z-index: 3001;
    overflow: hidden;
}
.inner_container{
    position: absolute;
    left: 0;
    top: 2rem;
    bottom: 0;
    overflow-x: hidden;
    overflow-y: scroll;

}
/*滚动条样式*/
::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.php_title{
    height: 2rem;
    background-color: #eee;
    color: #333333;
    line-height: 2rem;
    padding-left: 1rem;
    border-bottom: 1px solid #e1e1e1;
}
.content {
    margin:  0 auto;
    padding-top: 10px;
}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <form name="form1" id="form1" enctype="multipart/form-data" method="post" class="form form-horizontal">
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red">*</span>规则名称：</label>
            <div class="formControls col-6">
                <input type="text" class="input-text" value="" placeholder="" id="" name="name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>显示类型：</label>
            <div class="formControls col-xs-8 col-sm-8 skin-minimal" id="type">
                <div class="radio-box">
                    <input name="type" type="radio" id="sex-0" value="0" checked="checked" >
                    <label for="sex-0">按件计费</label>
                </div>
                <div class="radio-box">
                    <input name="type" type="radio" id="sex-1" value="1">
                    <label for="sex-1">按重计费</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2">运费规则：</label>
            <div class="formControls col-2">
                <button class = "btn newBtn radius" style="height: 31px!important;line-height: 31px!important;" type = "button" onclick="choice()" >
                	<div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
		                <img src="images/icon1/add.png"/>&nbsp;新增条目
		           	</div>
                </button >
            </div>
        </div>
        <div class='row cl' id='information' style='width: 80%;padding-left: 100px;display: none'>
            <input type="hidden" class="input-text" value="" name="hidden_freight" id="hidden_freight">
            <table class='table table-border table-bordered table-bg' style='width: 98%;margin-left: 20px;'>
                <thead id="thead_freight">
                <tr>
                    <th style="    width: 60px;">首件/重</th>
                    <th style="    width: 60px;">首费</th>
                    <th style="    width: 60px;">续件/重</th>
                    <th style="    width: 60px;">续费</th>
                    <th style="    width: 60px;text-align: center">省份</th>
                    <th style="width: 8%;">操作</th>
                </tr>
                </thead>
                <tbody id="tbody_freight">

                </tbody>
            </table>
        </div>
        <div class="row cl  page_footer">
            <div class="col-8 col-offset-4 ">
                <input type="button" name="Submit" onclick="check()" value="提 交" class="btn btn-primary radius submit1 ta_btn4">
            </div>
        </div>
    </form>

    <div class="row keep" style="display: none"></div>
    <div class="pop_model" style="display: none">
        <div class="row php_title">
            <span>添加运费规则</span>
            <span style="float: right;margin-right: 1rem;cursor: pointer" title="关闭" onclick="select_hid()">X</span>
        </div>
        <div class="inner_container" id="style-4">
            <div class="weight" style="display: none">
                <div class="row cl" >
                    <label class="form-label col-2"><span class="c-red"></span>首重(克)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="1000" style="width: 90%;" id="first_weight" name="first_weight">
                    </div>
                    <label class="form-label col-2"><span class="c-red"></span>首费(元)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="0" style="width: 90%;" id="first_fee" name="first_fee">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red"></span>续重(克)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="1000" style="width: 90%;" id="continuation_weight" name="continuation_weight">
                    </div>
                    <label class="form-label col-2"><span class="c-red"></span>续费(元)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="0" style="width: 90%;" id="weight_continuation_freight" name="weight_continuation_freight">
                    </div>
                </div>
            </div>
            <div class="piece" style="display: none">
                <div class="row cl" >
                    <label class="form-label col-2"><span class="c-red"></span>首件(个)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="1" style="width: 90%;" id="first_piece" name="first_piece">
                    </div>
                    <label class="form-label col-2"><span class="c-red"></span>运费(元)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" va  lue="0" style="width: 90%;" id="freight" name="freight">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-2"><span class="c-red"></span>续件(个)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="1" style="width: 90%;" id="continuation_piece" name="continuation_piece">
                    </div>
                    <label class="form-label col-2"><span class="c-red"></span>续费(元)：</label>
                    <div class="formControls col-4">
                        <input type="number" class="input-text" value="0" style="width: 90%;" id="piece_continuation_freight" name="piece_continuation_freight">
                    </div>
                </div>
            </div>
            <div class="row cl content">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>请选择省份：</label>
                <div class="formControls col-xs-8 col-sm-8 skin-minimal" id="province" >

                </div>
            </div>
            <div class="row cl" style="margin: 20px auto;">
                <div class="col-8 col-offset-4">
                    <button class = "btn btn-primary radius" style="width: 112px;" type = "button" onclick="save_address()" >提 交</button >
                </div>
            </div>
        </div>
    </div>
</div>
{include file="../../include_path/footer.tpl"}
<script type = "text/javascript" src = "style/js/jquery.js" ></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.all.min.js"></script>
<script type="text/javascript" src="style/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<!-- 新增编辑器引入文件 -->
<link rel="stylesheet" href="style/kindeditor/themes/default/default.css"/>
<script src="style/kindeditor/kindeditor-min.js"></script>
<script src="style/kindeditor/lang/zh_CN.js"></script>
{literal}
<script>
var freight_num = 0;
var freight_list = [];
$("#type").change(function(){
    freight_num = 0;
    freight_list = [];
    $("#hidden_freight").val('');
    $('.keep').hide();
    $('.pop_model').hide();
});
function choice(){
    var type = $('input:radio:checked').val();
    if(freight_num == 0){
        var data = '';
    }else{
        var hidden_freight = document.getElementById("hidden_freight").value;
        var data = hidden_freight;
    }
    var rew = '';

    $.get("index.php?module=freight&action=Province",{data:data,sel_city:sel_city},function(res){
        var res = JSON.parse( res );
        if(res.status == 1){
            var list = res.list;
            rew+= " <div class='radio-box' style='width: 32%;'><input name='all' class='inputC' type='checkbox' id='sex-all' onchange='sel_all()'><label for='sex-all' style='font-weight: bold;'>全选</label></div>" +
                "<br>";
            for (var k in list) {
                rew += "<div class='radio-box' style='width: 32%;'>" +
                            "<input name='list' class='inputC' type='checkbox' id='sex-"+list[k]['GroupID']+"' value='"+list[k]['GroupID']+"'>" +
                            "<label for='sex-"+list[k]['GroupID']+"'>"+list[k]['G_CName']+"</label>" +
                        "</div>"
            }
            document.getElementById("province").innerHTML=rew;
            $('.keep').show();
            $('.pop_model').show();
            if(type == 0){
                $('.piece').show();
                $('.weight').hide();
            }else{
                $('.weight').show();
                $('.piece').hide();
            }
        }else{
            layer.msg("已经全选!");
        }
    });
}
// 关闭
function select_hid(){
    $('.keep').hide();
    $('.pop_model').hide();
}
var sel_city = [];
var add_times = 0;

// 保存
function save_address(){
    freight_num++;
    var type = $('input:radio:checked').val();

    var obj = document.getElementsByName("list");
    var check_val = [];
    var city_str = '';
    for(k in obj){
        if(obj[k].checked){
            check_val.push(obj[k].value);
            city_str = city_str + obj[k].value+',';
        }
    }
    sel_city[add_times] = city_str;
    add_times++;
    $.post("index.php?module=freight&action=Province",{check_val:check_val},function(result){
        var result = JSON.parse( result );
        if(result.status == 1){
            var name = result.name;
            var freight_1 = {};
            if(type == 0){
                var one = document.getElementById("first_piece").value;
                var two = document.getElementById("freight").value;
                var three = document.getElementById("continuation_piece").value;
                var four = document.getElementById("piece_continuation_freight").value;
            }else{
                var one = document.getElementById("first_weight").value;
                var two = document.getElementById("first_fee").value;
                var three = document.getElementById("continuation_weight").value;
                var four = document.getElementById("weight_continuation_freight").value;
            }
            freight_1['one'] = one;
            freight_1['two'] = two;
            freight_1['three'] = three;
            freight_1['four'] = four;
            freight_1['name'] = name;
            var freight_2 = JSON.stringify(freight_1); // 从一个对象中解析出字符串
            freight_list[freight_list.length] = freight_2;

            var freight_list_value = '{';
            for (var i = 0; i < freight_list.length; i++) {
                freight_list_value += '"' + i + '":' + freight_list[i] + ',';
            }
            freight_list_value = freight_list_value.substring(0, freight_list_value.length - 1);
            freight_list_value += '}';
            // 给隐藏域赋值
            $("#hidden_freight").val(freight_list_value);

            var rew1 = "<tr class='tr_freight_num' id='tr_freight_" + freight_num + "'>" +
                            "<td>"+one+"</td>" +
                            "<td>"+two+"</td>" +
                            "<td>"+three+"</td>" +
                            "<td>"+four+"</td>" +
                            "<td>"+name+"</td>" +
                            "<td><span class='btn btn-secondary radius' onclick='freight_del("+freight_num+")' >删除</span></td>" +
                        "</tr>";
            document.getElementById("information").style.display = ''; // 显示表格

            if(freight_num == 1){
                $("#tbody_freight").prepend(rew1);
            }else{
                $("#tbody_freight").append(rew1);
            }
        }
    });
    select_hid();
}
// 删除
function freight_del(obj){

    sel_city[obj-1] = '';
    var obj_1 = obj - 1;
    $("#tr_freight_" + obj).remove();

    delete freight_list[obj_1];
    var freight_list_value = '{';
    for (var i = 0; i < freight_list.length; i++) {
        if(freight_list[i] == 'undefined' || freight_list[i] == '' || !freight_list[i]){
            freight_list_value += '';
        }else{
            freight_list_value += '"' + i + '":' + freight_list[i] + ',';
        }
    }

    freight_list_value = freight_list_value.substring(0, freight_list_value.length - 1);
    freight_list_value += '}';

    $("#hidden_freight").val(freight_list_value);
    var num_1 = $('.tr_freight_num').length;
    if(num_1 == 0){
        freight_num = 0;
        freight_list = [];

        document.getElementById("information").style.display = 'none';
        $('.keep').hide();
        $('.pop_model').hide();
    }
}

function sel_all() {
    if ($("#sex-all").get(0).checked) {
       //全选
        $("input[type='checkbox']").prop("checked", true);
    }else{
        //全不选
        $("input[type='checkbox']").prop("checked", false);
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
        dataType:"json",
        url:'index.php?module=freight&action=Add',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status,{time:2000});
            if(data.suc){
                location.href="index.php?module=freight";
            }
        }
    });
}
</script>
{/literal}
</body>
</html>