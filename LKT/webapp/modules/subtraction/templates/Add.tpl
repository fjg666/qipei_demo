{include file="../../include_path/header.tpl" sitename="DIY头部"}

<link rel="stylesheet" href="style/zTree/css/demo.css" type="text/css">
<link rel="stylesheet" href="style/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />

{include file="../../include_path/software_head.tpl" sitename="DIY头部"}

{literal}
<style type="text/css">
.formInputSD input, .formInputSD select{
    width: 420px;
}
.form_new_r .ra1 label{
    width: 138px!important;
}
.inputC1:checked +label::before{
    left: 0px;
    top: 11px;
}
.ladder0{
    width: 110px;
    border-color: #d5dbe8;
    padding-left: 6px;
}
.ladder1{
    margin-right: 10px;
}
.ladder2{
    margin-left: 6px;
    margin-right: 6px;
}
.ladder3{
    margin-left: 6px;
    margin-right: 18px;
}
.ladder4{
    width: 60px;
    height: 36px;
    line-height: 36px;
    border: 1px #BFBFBF solid;
    text-align: center;
    color: #6A7076;
    /*margin-left: 18px;*/
    background-color: #ffffff;
}
.ladder5{
    width: 60px;
    height: 36px;
    line-height: 36px;
    border: 1px #0075F2 solid;
    text-align: center;
    color: #FFFFFF;
    background-color: #0075F2;
}
#classSel{
    height: 36px;
    width: 420px;
    border: 1px solid rgba(213,219,232,1);
    padding-left: 10px;
}
#classSel::-webkit-input-placeholder {
    color: #868995;
    font-size: 14px;
}
#treeDemo{
    width:420px;
    height:108px;
    background:rgba(255,255,255,1);
    border:1px solid rgba(213,219,232,1);
    border-radius:2px;
    margin-top: 0;
    border-top: none;
}
.ztree li span.button.chk.radio_false_full, .ztree li span.button.chk.radio_false_full_focus{background-position:-28px 0}
.ztree li span.button.chk.checkbox_true_full {background-position:-14px 0}
.ztree li span.button.chk.checkbox_true_full_focus {background-position:-14px -14px}
.ztree li span.button.switch{width: 0;}
.ztree li a.curSelectedNode{background-color: #ffffff; border: none;}
ul.ztree::-webkit-scrollbar {display:none; width: 0.1px;height: 0.1px;color: transparent;}

.option_container{
    border: 1px solid #D5DBE8;
    background-color: #ffffff;
    height: 36px;
    line-height: 36px;
    margin-right: 12px;
    padding: 0px 0px 0px 12px;
    margin-top: 2px;
    margin-bottom: 10px;
    width: fit-content;
    width: -moz-fit-content;
    width: -webkit-fit-content;
}
.option_container_1{
    padding:10px;
    color: #D5DBE8;
    cursor: pointer;
}
.formTextSD{
    height: 40px;
}
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
{/literal}
</head>
<body style="background-color: #edf1f5;">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;"  onclick="location.href='index.php?module=subtraction';">满减 </a>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;"  onclick="location.href='index.php?module=subtraction';">满减活动列表 </a>
    <span class="c-gray en">&gt;</span>
    添加满减活动
</nav>
<div id="addpro" class="pd-20">
    <form method="post" id="form1" class="form form-horizontal" id="form-category-add" enctype="multipart/form-data" style="background-color: white;">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD" >基本信息</div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red">*</span><span>活动标题：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="title" id="title" value="" placeholder="请输入活动标题"/>
                            <span style="color: #A8B0CB;margin-left: 15px;">（活动标题，如母婴产品促销）</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red">*</span><span>活动名称：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="name" id="name" value="" placeholder="请输入活动名称"/>
                            <span style="color: #A8B0CB;margin-left: 15px;width: 280px;">（活动名称的详情说明。如，母婴贝亲品牌按摩油买一送一，贝亲所有产品满400减30）</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>满减应用范围：</span></div>
                        <div class="form_new_r form_yes" style="color: #414658;font-weight:normal;">
                            {if in_array(1,$range_zfc)}
                                <div class="ra1" onclick="show(1)">
                                    <input name="subtraction_range"  type="radio" checked="checked" style="display: none;" id="is_subtraction-1" class="inputC1" value="1">
                                    <label for="is_subtraction-1">指定分类</label>
                                </div>
                            {/if}
                            {if in_array(2,$range_zfc) }
                                <div class="ra1" onclick="show(2)">
                                    <input name="subtraction_range"  type="radio"  style="display: none;" id="is_subtraction-2" class="inputC1" value="2">
                                    <label for="is_subtraction-2">全场满减</label>
                                </div>
                            {/if}
                            {if in_array(3,$range_zfc) }
                                <div class="ra1" onclick="show(3)">
                                    <input name="subtraction_range"  type="radio"  style="display: none;" id="is_subtraction-3" class="inputC1" value="3">
                                    <label for="is_subtraction-3">指定品牌</label>
                                </div>
                            {/if}
                            {if in_array(4,$range_zfc) }
                                <div class="ra1" onclick="show(4)">
                                    <input name="subtraction_range"  type="radio"  style="display: none;" id="is_subtraction-4" class="inputC1" value="4">
                                    <label for="is_subtraction-4">指定商家满减</label>
                                </div>
                            {/if}
                        </div>
                    </div>
                    <div class="formListSD" id="container" style="display: none;height: 144px;">
                        <div class="formTextSD"><span></span></div>
                        <div class="content_wrap">
                            <input type="text" id="classSel" value="" placeholder="请输入关键字" onclick="showMenu();" autocomplete="off"/>
                            <div id="confirmBtn" onclick="confirmBtnClick()" style="display:inline-block; width:88px;height:36px;line-height:36px; text-align:center; background:rgba(0,117,242,1);border-radius:2px; color: #ffffff;cursor: pointer;">添加</div>
                            <div id="menuContent" class="menuContent" style="display:none; position: absolute;left: 130px;top: 36px;">
                                <ul id="treeDemo" class="ztree"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" id="option_container" style="display: none;">
                        <div class="formTextSD"><span>已选项：</span></div>
                        <input type="hidden" name="menu_list" id="menu_list" value="">
                        <div class="formInputSD" style="display: flex;align-items: normal;flex-direction: column" id="option_container_1">

                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red">*</span><span>满减类型：</span></div>
                        <select name="subtraction_type" class="subtraction_type" id="subtraction_type" style="width:420px;height: 36px;vertical-align: middle;" onClick="activitytype();" >
                            <option value="0">请选择满减类型</option>
                            <option value="1">阶梯满减</option>
                            <option value="2">循环满减</option>
                            <option value="3">满赠</option>
                            <option value="4">满件折扣</option>
                        </select>
                    </div>
                    <div class="formListSD" id="activity_type1" style="display: none;">
                        <div class="formTextSD"><span class="c-red"></span><span></span></div>
                        <div id="ladder">
                            <div style="padding-top: 10px;" id="ladder0">
                                <label class="ladder1" > 单笔订单满</label>
                                <input class="ladder0" type="number" name="full[]" id="full_0" value="" class="input-text inputcss" onblur="full(0)" />
                                <label class="ladder2">元，立减</label>
                                <input class="ladder0" type="number" name="reduce[]" id="reduce_0" value="" class="input-text inputcss" onblur="reduce(0)"/>
                                <label class="ladder3">元</label>
                                <button type="button" id="add_ladder_btn_0" onclick="del_ladder(0)" class="ladder4">删除</button>
                            </div>
                            <div style="padding-top: 10px;" id="ladder1">
                                <label class="ladder1"> 单笔订单满</label>
                                <input class="ladder0" type="number" name="full[]" id="full_1" value="" class="input-text inputcss" onblur="full(1)" />
                                <label class="ladder2">元，立减</label>
                                <input class="ladder0" type="number" name="reduce[]" id="reduce_1" value="" class="input-text inputcss" onblur="reduce(1)"/>
                                <label class="ladder3">元</label>
                                <button type="button" id="add_ladder_btn_1" onclick="del_ladder(1)" class="ladder4">删除</button>
                            </div>
                            <div style="padding-top: 10px;" id="ladder2">
                                <label class="ladder1"> 单笔订单满</label>
                                <input class="ladder0" type="number" name="full[]" id="full_2" value="" class="input-text inputcss" onblur="full(2)" />
                                <label class="ladder2">元，立减</label>
                                <input class="ladder0" type="number" name="reduce[]" id="reduce_2" value="" class="input-text inputcss" onblur="reduce(2)"/>
                                <label class="ladder3">元</label>
                                <button type="button" id="add_ladder_btn_2" onclick="del_ladder(2)" class="ladder4">删除</button>
                            </div>
                            <div style="padding-top: 10px;" id="ladder3">
                                <label class="ladder1"> 单笔订单满</label>
                                <input class="ladder0" type="number" name="full[]" id="full_3" value="" class="input-text inputcss" onblur="full(3)" />
                                <label class="ladder2">元，立减</label>
                                <input class="ladder0" type="number" name="reduce[]" id="reduce_3" value="" class="input-text inputcss" onblur="reduce(3)"/>
                                <label class="ladder3">元</label>
                                <button type="button" id="add_ladder_btn_3" onclick="add_ladder(3)" class="ladder5">添加</button>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" id="activity_type2" style="display: none;">
                        <div class="formTextSD"><span class="c-red"></span><span></span></div>
                        <div >
                            <div style="padding-top: 10px;" >
                                <label class="ladder1" > 购物每满</label>
                                <input class="ladder0" type="number" name="purchase_man" id="purchase_man" value="" class="input-text inputcss"  />
                                <label class="ladder2">元，优惠</label>
                                <input class="ladder0" type="number" name="discount" id="discount" value="" class="input-text inputcss" />
                                <label class="ladder3">元</label>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" id="activity_type3" style="display: none;">
                        <input type="hidden" name="product_json" id="product_json" value='{$product_json}'>
                        <div class="formTextSD"><span class="c-red"></span><span></span></div>
                        <div >
                            <div style="padding-top: 10px;" id="gift0">
                                <label class="ladder1" > 单笔订单满</label>
                                <input class="ladder0" type="number" name="purchase[]" id="purchase_0" value="" class="input-text inputcss"  />
                                <label class="ladder2">元，赠送商品</label>
                                <select name="product[]" class="product" id="product_0" onchange="product(0)" style="width:160px;height: 36px;vertical-align: middle;margin-right: 10px;">
                                    <option  value="0">请选择赠送商品</option>
                                    {foreach from=$product item=item name=f1 key=k}
                                        <option  value="{$item->id}">{$item->product_title}</option>
                                    {/foreach}
                                </select>
                                <button type="button" id="add_commodity_0" onclick="add_commodity(0)" class="ladder5" style="margin-left: -5px;">添加</button>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" id="activity_type4" style="display: none;">
                        <div class="formTextSD"><span class="c-red"></span><span></span></div>
                        <div >
                            <div style="padding-top: 10px;" >
                                <label class="ladder1" > 购买 </label>
                                <input class="ladder0" type="number" name="purchase_jian" id="purchase_jian" value="" class="input-text inputcss" />
                                <label class="ladder2">件，享受</label>
                                <input class="ladder0" type="number" name="fracture" id="fracture" value="" class="input-text inputcss" />
                                <label class="ladder3">折</label>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>满减生效时间：</span></div>
                        <div class="formInputSD">
                            <input type="text" class="input-text" value="{$start_time}" autocomplete="off" placeholder="请输入开始时间" id="start_time" name="start_time" style="width:190px;height: 36px;">
                            <label style="margin-left: 14px;margin-right: 12px;">至</label>
                            <input type="text" class="input-text" value="{$end_time}" autocomplete="off" placeholder="请输入结束时间" id="end_time" name="end_time" style="width:190px;height: 36px;">
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span class="c-red"></span><span>显示位置：</span></div>
                        <select name="position_zfc" class="position_zfc" id="position_zfc" style="width:420px;height: 36px;vertical-align: middle;" >
                            <option value="0">请选择显示位置</option>
                            {foreach from=$position_zfc item=item name=f1 key=k}
                                <option  value="{$item}">{$item}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD" style="width: 128px;"><span style="display: block;margin-top: 14px;">满减宣传图：</span></div>
                        <div class="formInputSD">
                            <div class="upload-group">
                                <div class="input-group row" style="margin-left: -84px;margin-top: 2px;">
                                    <span class="col-sm-1 col-md-1 col-lg-1"></span>
                                    <input index="0" value="{$image}" name="image" class="col-sm-5 col-md-5 col-lg-5 form-control file-input input_width_l" style="width: 1008px;height: 36px;">
                                    <span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1" style="padding-left: 1px;">
                                        <a href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" class="btn upload-file" style="border: 0px solid transparent;">选择</a>
                                    </span>
                                </div>
                                <div class="upload-preview text-center upload-preview " style="top: 12px;width: 320px;height: 134px;border: 0px solid #e3e3e3;">
                                    <div class='border_img'>
                                        {if $item->bottom_img}
                                            <img src="{$item->bottom_img}" class="upload-preview-img jkl" style="width: 169px;height: 134px;">
                                        {else}
                                            <img src="images/class_noimg.jpg" class="upload-preview-img jkl1" style="width: 169px;height: 134px;">
                                        {/if}
                                        <span class="font_l" style="line-height:134px;margin-left: 30px;">(尺寸：750*300)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </table>
		<div style="height: 40px;"></div>
        <div class="row cl page_bort" style="position: fixed; bottom: 0; left: 10px; right: 10px; display: block; margin: 0; width: auto;background: #fff;z-index: 999;">
            <div style="float:right;height: 67px;">
                <input class="btn btn-primary radius ta_btn4" type="button" value="&nbsp;&nbsp;返回&nbsp;&nbsp;" onclick="javascript:history.back(-1);" style="background-color: white!important;color:#2890FF;margin: 16px 60px 16px 0!important;">
                <input class="btn btn-primary radius ta_btn3" type="button" onclick="check()" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" style="margin: 16px 10px!important;">
            </div>
        </div>
        <div class="page_h10"></div>
    </form>
    <div class="page_h10"></div>
</div>

{include file="../../include_path/footer.tpl" sitename="公共尾部"}

<script src="style/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery.ztree.exhide.js"></script>
<script type="text/javascript" src="style/zTree/js/fuzzysearch.js"></script>
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}


{literal}
<script type="text/javascript">
laydate.render({
    elem: '#start_time', //指定元素
    trigger: 'click',
    type: 'datetime'
});
laydate.render({
    elem: '#end_time',
    trigger: 'click',
    type: 'datetime'
});
$(function () {
    document.getElementById('container').style.display = "";
    document.getElementById('option_container').style.display = "";
    chaxun('fenlei');
})
function show(range) {
    if(range == 1){//指定分类
        document.getElementById('container').style.display = "";
        $('#container').height(36)
        // document.getElementById('option_container').style.display = "";
        chaxun('fenlei');
    }else if(range == 2){//全场满减
        document.getElementById('container').style.display = "none";
        document.getElementById('option_container').style.display = "none";
    }else if(range == 3){//指定品牌
        document.getElementById('container').style.display = "";
        $('#container').height(36)
        // document.getElementById('option_container').style.display = "";
        chaxun('pinpai');
    }else if(range == 4){//指定商家
        document.getElementById('container').style.display = "";
        $('#container').height(36)
        // document.getElementById('option_container').style.display = "";
        chaxun('shop_name');
    }
    $("#menu_list").val('');
    $("#option_container_1").empty();
    var cityObj = $("#classSel");
    cityObj.attr("value", '');
}
function chaxun(canshu) {
    $.ajax({
        cache: true,
        type: "GET",
        dataType: "json",
        url: 'index.php?module=subtraction&action=Add&m='+canshu,
        data: {},
        async: true,
        success: function (data) {
            if(data.product_class){
                zNodes = data.product_class;
            }else if(data.brand_class){
                zNodes = data.brand_class;
            }else if(data.shop){
                zNodes = data.shop;
            }
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        }
    });
}
// 满减类型
function activitytype() {
    var subtraction_type = $('#subtraction_type option:selected').val(); // 优惠券类型
    if(subtraction_type == 1){
        document.getElementById('activity_type1').style.display = ""; // 显示
        document.getElementById('activity_type2').style.display = "none"; // 显示
        document.getElementById('activity_type3').style.display = "none"; // 显示
        document.getElementById('activity_type4').style.display = "none"; // 显示
    }else if(subtraction_type == 2){
        document.getElementById('activity_type1').style.display = "none"; // 显示
        document.getElementById('activity_type2').style.display = ""; // 显示
        document.getElementById('activity_type3').style.display = "none"; // 显示
        document.getElementById('activity_type4').style.display = "none"; // 显示
    }else if(subtraction_type == 3){
        document.getElementById('activity_type1').style.display = "none"; // 显示
        document.getElementById('activity_type2').style.display = "none"; // 显示
        document.getElementById('activity_type3').style.display = ""; // 显示
        document.getElementById('activity_type4').style.display = "none"; // 显示
    }else if(subtraction_type == 4){
        document.getElementById('activity_type1').style.display = "none"; // 显示
        document.getElementById('activity_type2').style.display = "none"; // 显示
        document.getElementById('activity_type3').style.display = "none"; // 显示
        document.getElementById('activity_type4').style.display = ""; // 显示
    }
}
// 添加阶梯
function add_ladder(obj) {
    var num = obj + 1;
    var rew = '';
    if(obj == 3){
        rew = '<button type="button" id="add_ladder_btn_'+obj+'" onclick="del_ladder('+obj+')" class="ladder4">删除</button>';
    }else{
        rew = '<button type="button" style="margin-left: 6px;" id="add_ladder_btn_'+obj+'" onclick="del_ladder('+obj+')" class="ladder4">删除</button>';
    }
    var res = '<div style="padding-top: 10px;" id="ladder'+num+'">' +
                    '<label class="ladder1" style="margin-right: 14px;"> 单笔订单满</label>' +
                    '<input class="ladder0" type="number" name="full[]" id="full_'+num+'" value="" class="input-text inputcss" onblur="full('+num+')" />' +
                    '<label class="ladder2" style="margin-left: 10px;margin-right: 10px;">元，立减</label>' +
                    '<input class="ladder0" type="number" name="reduce[]" id="reduce_'+num+'" value="" class="input-text inputcss" onblur="reduce('+num+')"/>' +
                    '<label class="ladder3" style="margin-left: 10px;">元</label>' +
                    '<button type="button" style="margin-left: 6px;" id="add_ladder_btn_'+num+'" onclick="add_ladder('+num+')" class="ladder5">添加</button>' +
                '</div>';
    $("#add_ladder_btn_"+obj).replaceWith(rew);
    $("#ladder"+obj).after(res);
}
// 删除阶梯
function del_ladder(obj) {
    $("#ladder"+obj).remove();
}
// 验证单笔订单满梯增
function full(obj) {
    if(obj == 0){
        var obj1 = obj+1;
        var res = $("#full_"+obj).val();
        var res1 = $("#full_"+obj1).val();
        if(res != ''){
            if(res1 != ''){
                if(Number(res) >= Number(res1)){
                    $("#full_"+obj).val('');
                    layer.msg("单笔订单满没有依次递增");
                    return;
                }
            }
        }
    }else{
        var obj2 = obj+1;
        var obj1 = obj-1;
        var res = $("#full_"+obj).val();
        var res1 = $("#full_"+obj1).val();
        var res2 = $("#full_"+obj2).val();
        if(res != ''){
            if(Number(res) <= Number(res1)){
                $("#full_"+obj).val('');
                layer.msg("单笔订单满没有依次递增");
                return;
            }
            if(res2 != ''){
                if(Number(res) >= Number(res2)){
                    $("#full_"+obj).val('');
                    layer.msg("单笔订单满没有依次递增");
                    return;
                }
            }
        }
    }
}
// 验证立减梯增
function reduce(obj) {
    if(obj == 0){
        var obj1 = obj+1;
        var res = $("#reduce_"+obj).val();
        var res1 = $("#reduce_"+obj1).val();
        if(res != ''){
            if(res1 != ''){
                if(Number(res) >= Number(res1)){
                    $("#reduce_"+obj).val('');
                    layer.msg("立减没有依次递增");
                    return;
                }
            }
        }
    }else{
        var obj1 = obj-1;
        var obj2 = obj+1;
        var res = $("#reduce_"+obj).val();
        var res1 = $("#reduce_"+obj1).val();
        var res2 = $("#reduce_"+obj2).val();
        if(res != ''){
            if(Number(res) <= Number(res1)){
                $("#reduce_"+obj).val('');
                layer.msg("立减没有依次递增");
                return;
            }
            if(res2 != ''){
                if(Number(res) >= Number(res2)){
                    $("#reduce_"+obj).val('');
                    layer.msg("立减没有依次递增");
                    return;
                }
            }
        }
    }
}
// 添加赠品
function add_commodity(obj) {
    var num = obj + 1;
    var product_json = JSON.parse($("#product_json").val());
    var json = '';
    for (var k in product_json) {
        json += '<option  value="'+product_json[k]['id']+'">'+product_json[k]['product_title']+'</option>';
    }
    if(obj == 0){
        var rew = '<button type="button" id="add_commodity_'+obj+'" onclick="del_commodity('+num+')" class="ladder4" style="margin-left: -5px;">删除</button>';
    }else{
        var rew = '<button type="button" id="add_commodity_'+obj+'" onclick="del_commodity('+num+')" class="ladder4">删除</button>';
    }
    var res = '<div style="padding-top: 10px;" id="gift'+num+'">' +
                    '<label class="ladder1" style="margin-right: 14px;"> 单笔订单满</label>' +
                    '<input class="ladder0" type="number" name="purchase[]" id="purchase_'+num+'" value="" class="input-text inputcss"  onblur="purchase('+num+')"/>' +
                    '<label class="ladder2" style="margin-left: 10px;margin-right: 10px;">元，赠送商品</label>' +
                    '<select name="product[]" class="product" id="product_'+num+'" onchange="product('+num+')" style="width:160px;height: 36px;vertical-align: middle;margin-right: 10px;" >' +
                        '<option value="0">请选择赠送商品</option>' +
                        json +
                    '</select>' +
                    '<button type="button" id="add_commodity_'+num+'" onclick="add_commodity('+num+')" class="ladder5">添加</button>' +
                '</div>';
    $("#add_commodity_"+obj).replaceWith(rew);
    $("#gift"+obj).after(res);
}
// 删除赠品
function del_commodity(obj) {
    $("#gift"+obj).remove();
}
// 验证赠品梯增
function purchase(obj) {
    if(obj == 0){
        var obj1 = obj+1;
        var res = $("#purchase_"+obj).val();
        var res1 = $("#purchase_"+obj1).val();
        if(res != ''){
            if(res1 != ''){
                if(Number(res) >= Number(res1)){
                    $("#purchase_"+obj).val('');
                    layer.msg("单笔订单满没有依次递增");
                    return;
                }
            }
        }
    }else{
        var obj2 = obj+1;
        var obj1 = obj-1;
        var res = $("#purchase_"+obj).val();
        var res1 = $("#purchase_"+obj1).val();
        var res2 = $("#purchase_"+obj2).val();
        if(res != ''){
            if(Number(res) <= Number(res1)){
                $("#purchase_"+obj).val('');
                layer.msg("单笔订单满没有依次递增");
                return;
            }
            if(res2 != ''){
                if(Number(res) >= Number(res2)){
                    $("#purchase_"+obj).val('');
                    layer.msg("单笔订单满没有依次递增");
                    return;
                }
            }
        }
    }
}
// 验证赠品是否重复
function product(obj) {
    var options = $(".product option:selected");//获取当前选择项.
    var options1 = $("#product_"+obj+" option:selected").val();//获取当前选择项.
    var temp = []; //一个新的临时数组

    var product_json = JSON.parse($("#product_json").val());
    var json = '<select name="product[]" class="product" id="product_'+obj+'" onchange="product('+obj+')" style="width:160px;height: 36px;vertical-align: middle;margin-right: 10px;" >'+
        '<option value="0">请选择赠送商品</option>';
    for (var k in product_json) {
        json += '<option  value="'+product_json[k]['id']+'">'+product_json[k]['product_title']+'</option>';
    }
    json += '</select>';
    for (var i in options) {
        if(options1 == options[i].value && obj != i && options1 != '请选择赠送商品'){
            $("#product_"+obj).replaceWith(json);
            layer.msg("赠送商品重复，请重现选择");
            return;
        }
    }
}

// zTree搜索下拉多选功能实现
var setting = {
      check: {
        enable: true,//checkbox
        chkboxType: {"Y":"", "N":""}
      },
      view: {
          nameIsHTML: true, //允许name支持html        
          selectedMulti: true,
          showIcon: false,
          showLine: false,
          dblClickExpand: false
        },
      edit: {
        enable: false,
        editNameSelectAll: false
      },
      data: {
        simpleData: {
          enable: true
        }
      },
      callback: {
        beforeClick: beforeClick,
        onCheck: onCheck
      }
    };
var str = '';
var zNodes = [];

// 单击之前
function beforeClick(treeId, treeNode) {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo");
    zTree.checkNode(treeNode, !treeNode.checked, null, true);
    return false;
}
// 一经检查
function onCheck(e, treeId, treeNode) {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
    nodes = zTree.getCheckedNodes(true),
    str = "";

    var allSelNodes = findAllSelNodes();
    for (var i=0, l=allSelNodes.length; i<l; i++) {
        str += allSelNodes[i].name + ",";
    }

    if (str.length > 0 ) str = str.substring(0, str.length-1);

    $("#option_container_1").empty();
    if(str.length > 0){
        var list = str.split(',');
        var res = '';
        for (i=0;i<list.length;i++){
            res += '<div class="option_container">'+
                '<div style=" overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display: inline-block;">'+list[i]+
                '<span class="option_container_1" onclick="del(\''+list[i]+'\',\''+str+'\')">X</span>'+
                '</div>'+
                '</div>';
        }
        // $("#option_container_1").append(res);
    }else{
        document.getElementById('option_container').style.display = "none";
    }
    $("#menu_list").val(str);

    var cityObj = $("#classSel");
    cityObj.attr("value", str);
    selectedData = res;
}
// 删除
function del(obj,str) {
    var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
    var allSelNodes = findAllSelNodes();
    var list = str.split(',');

    for (i=0;i<list.length;i++){
        if(list[i] == obj){
            // 将删除的选项与checkbox同步取消
            for(var j=0; j<allSelNodes.length; j++){
                if(list[i]==allSelNodes[j].name){
                    treeObj.checkNode(allSelNodes[j],false,true,true);
                }
            }
            list.splice(i--,1);
        }
    }
    $("#option_container_1").empty();
    var str1 = '';
    for (i=0;i<list.length;i++){
        str1 += list[i] + ',';
    }
    str = str1.substring(0,str1.length-1)
    var cityObj = $("#classSel");
    cityObj.attr("value", str);
    $("#menu_list").val(str);

    if(list.length > 0){
        // showMenu()
        var res = '';
        for (i=0;i<list.length;i++){
            res += '<div class="option_container">'+
                '<div style=" overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display: inline-block;">'+list[i]+
                '<span class="option_container_1" onclick="del(\''+list[i]+'\',\''+str+'\')">X</span>'+
                '</div>'+
                '</div>';
        }
        $("#option_container_1").append(res);
    }else{
        document.getElementById('option_container').style.display = "none";
    }
    selectedData = res;
}

var selectedData

//点击把选择项加入‘已选项’
function confirmBtnClick(){
    if(selectedData){
        console.log('click')
        $("#option_container_1").empty();
        $("#option_container_1").append(selectedData);
        document.getElementById('option_container').style.display = "flex";
        selectedData = ''
        var cityObj = $("#classSel");
        cityObj.attr("value", "");
    }
}
// 找到所有选中的checkbox
function findAllSelNodes(){
    var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
    var nodes = treeObj.transformToArray(treeObj.getNodes());
    var selectedNodes = [];
    for(var i=0; i<nodes.length; i++){
        if(nodes[i].checked){
            selectedNodes.push(nodes[i])
        }
    }
    return selectedNodes;
}
// 显示菜单
function showMenu() {
    var cityObj = $("#classSel");
    var cityOffset = $("#classSel").offset();
    cityObj.attr("value", "");
    cityObj.trigger("propertychange");
    $('#container').height(150)
    $("#menuContent").slideDown("fast");
    // $("#menuContent").css({left:cityOffset.left + "px", top:cityOffset.top + cityObj.outerHeight() + "px"}).slideDown("fast");

    $("body").bind("mousedown", onBodyDown);
}
// 隐藏菜单
function hideMenu() {
    $("#menuContent").fadeOut("fast");
    $("body").unbind("mousedown", onBodyDown);
    $('#container').height(36)
}
// 上下颠倒
function onBodyDown(event) {
    if (!(event.target.id == "menuBtn" || event.target.id == "classSel" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
        hideMenu();
    }
}

$(document).ready(function(){
    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
});
    
var code;
    
function setCheck() {
    var zTree = $.fn.zTree.getZTreeObj("treeDemo"),
    py = $("#py").attr("checked")? "p":"",
    sy = $("#sy").attr("checked")? "s":"",
    pn = $("#pn").attr("checked")? "p":"",
    sn = $("#sn").attr("checked")? "s":"",
    type = { "Y":py + sy, "N":pn + sn};
    zTree.setting.check.chkboxType = type;
    showCode('setting.check.chkboxType = { "Y" : "' + type.Y + '", "N" : "' + type.N + '" };');
}
function showCode(str) {
    if (!code) code = $("#code");
    code.empty();
    code.append("<li>"+str+"</li>");
}

$(document).ready(function(){
    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    setCheck();
    $("#py").bind("change", setCheck);
    $("#sy").bind("change", setCheck);
    $("#pn").bind("change", setCheck);
    $("#sn").bind("change", setCheck);
});
$(document).ready(function(){
    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    fuzzySearch('treeDemo','#classSel',null,true); //初始化模糊搜索方法
});

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
        url: 'index.php?module=subtraction&action=Add',
        data: $('#form1').serialize(),// 你的formid
        async: true,
        success: function (data) {
            layer.msg(data.status, {time: 1000});
            setTimeout(function(){
                if(data.suc){
                    location.href="index.php?module=subtraction";
                }
            },1000)
        }
    });
}
</script>
{/literal}
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>