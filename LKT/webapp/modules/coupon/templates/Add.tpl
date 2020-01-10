{include file="../../include_path/header.tpl" sitename="DIY头部"}
<link rel="stylesheet" href="style/zTree/css/demo.css" type="text/css">
<link rel="stylesheet" href="style/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
{literal}
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
input[type="number"] {
    -moz-appearance: textfield;
}
.layui-laydate-content thead tr th{border-bottom: none !important;}
.layui-laydate-content tr{height: auto !important;border: none;}
#product_id_1 select{width: 195px;height: 36px;border-radius: 2px;border: none;vertical-align: middle;margin-right: 8px;}
.protype label{width: auto;height: 36px;line-height: 36px;float: left;background-color: transparent;text-align: center;padding: 0 10px;}
th img{width: 100px;height: 100px;}
.form_new_r .ra1 label{
    width: 90px !important;
}
.inputC1:checked + label::before{
    width: 16px;
    height: 16px;
    top: 11px;
    left: 0px;
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
    width:403px;
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
.ztree{padding-left: 10px;}
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
.formListSD{
    padding-left: 40px !important;
}
.formTextSD{
    height: 40px;
}
.formDivSD{
    padding-bottom: 100px;
}
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
{/literal}
<body style="background-color: #edf1f5!important;">
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;"  onclick="location.href='index.php?module=coupon';">卡券 </a>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;"  onclick="location.href='index.php?module=coupon';">优惠券列表 </a>
    <span class="c-gray en">&gt;</span>
    添加优惠券
</nav>
<div class="pd-20" style="background: #ffffff" >
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD">基本信息</div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red">*</span><span>优惠券类型：</span></div>
                    <select name="activity_type" class="activity_type" id="activity_type" style="width:245px;height: 36px;vertical-align: middle;padding-left: 6px;" onClick="activitytype();" >
                        <option  value="0">请选择优惠券类型</option>
                        {foreach from=$coupon_type item=item name=f1 key=k}
                            <option  value="{$k}" >{$item}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red">*</span><span>优惠券名称：</span></div>
                    <div class="formInputSD">
                        <input type="text" name="name" id="name" value="" style="width: 245px;" placeholder="请输入优惠券名称"/>
                    </div>
                </div>
                <div class="formListSD" id="grade1" style="display: none;">
                    <div class="formTextSD"><span class="c-red">*</span><span>会员等级：</span></div>
                    <select name="grade" class="grade" id="grade" style="width:245px;height: 36px;vertical-align: middle;padding-left: 6px;" >
                        <option  value="0">请选择会员等级</option>
                        {foreach from=$res item=item name=f1 key=k}
                            <option  value="{$item->id}" >{$item->name}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="formListSD" id="type_type" style="display: none;">
                    <div class="formTextSD"><span>类型：</span></div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="type_type"  type="radio" checked="" style="display: none;" id="type_type-1" class="inputC1" value="1" onClick="onClick_type(this)">
                            <label for="type_type-1">满减</label>
                        </div>
                        <div class="ra1">
                            <input name="type_type"  type="radio" style="display: none;" id="type_type-2" class="inputC1" value="2" onClick="onClick_type(this)">
                            <label for="type_type-2">折扣</label>
                        </div>
                    </div>
                </div>
                <div class="formListSD" id="circulation1">
                    <div class="formTextSD"><span class="c-red">*</span><span>发行数量：</span></div>
                    <div class="formInputSD">
                        <input type="text" name="circulation" id="circulation" value="" style="width: 125px;" />
                        <span style="color: #A8B0CB;margin-left: 7px;">张</span>
                    </div>
                </div>
                <div class="formListSD" id="money1" style="display: none;">
                    <div class="formTextSD"><span class="c-red">*</span><span>面值：</span></div>
                    <div class="formInputSD">
                        <input type="text" name="money" id="money" value="" style="width: 125px;" />
                        <span style="color: #A8B0CB;margin-left: 7px;">元</span>
                    </div>
                </div>
                <div class="formListSD" id="discount1" style="display: none;">
                    <div class="formTextSD"><span class="c-red">*</span><span>折扣值：</span></div>
                    <div class="formInputSD">
                        <input type="text" name="discount" id="discount" value="" style="width: 125px;" />
                        <span style="color: #A8B0CB;margin-left: 7px;">折</span>
                    </div>
                </div>
                <div class="formListSD" id="z_money1">
                    <div class="formTextSD"><span class="c-red">*</span><span>消费门槛：</span></div>
                    <div class="formInputSD">
                        <span style="margin-right: 8px;">消费</span>
                        <input type="text" name="z_money" id="z_money" value="" style="width: 125px;" />
                        <span >元可使用</span>
                        <span style="color: #A8B0CB;margin-left: 15px;">（为0，则无限制）</span>
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span>可用范围：</span></div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="type"  type="radio" checked="" style="display: none;" id="type-1" class="inputC1" value="1" onClick="show(this)">
                            <label for="type-1">全部商品</label>
                        </div>
                        <div class="ra1">
                            <input name="type"  type="radio" style="display: none;" id="type-2" class="inputC1" value="2" onClick="show(this)">
                            <label for="type-2">指定商品</label>
                        </div>
                        <div class="ra1">
                            <input name="type"  type="radio" style="display: none;" id="type-3" class="inputC1" value="3" onClick="show(this)">
                            <label for="type-3">指定分类</label>
                        </div>
                    </div>
                </div>
                <div class="formListSD" id="container" style="display: none;height: 150px;">
                    <div class="formTextSD"><span></span></div>
                    <div class="content_wrap" style="position: relative;">
                        <input type="text" autocomplete="off" id="classSel" value="" placeholder="请输入关键字" onclick="showMenu();" />
                        <div id="confirmBtn" onclick="confirmBtnClick()" style="display:inline-block; width:88px;height:36px;line-height:36px; text-align:center; background:rgba(0,117,242,1);border-radius:2px; color: #ffffff;cursor: pointer;">添加</div>
                        <div id="menuContent" class="menuContent" style="position: absolute;">
                            <ul id="treeDemo" class="ztree"></ul>
                        </div>
                    </div>
                </div>
                <div class="formListSD" id="option_container" style="display: none;">
                    <div class="formTextSD"><span>已选项：</span></div>
                    <input type="hidden" name="menu_list" id="menu_list" value="">
                    <div class="formInputSD" style="display: flex;align-items: normal;flex-direction: column" id="option_container_1"></div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span>优惠券跳转配置：</span></div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="skip_type"  type="radio" checked="" style="display: none;" id="skip_type-1" class="inputC1" value="1" onClick="skip(this)">
                            <label for="skip_type-1">首页</label>
                        </div>
                        <div class="ra1">
                            <input name="skip_type"  type="radio" style="display: none;" id="skip_type-2" class="inputC1" value="2" onClick="skip(this)">
                            <label for="skip_type-2">自定义</label>
                        </div>
                    </div>
                </div>
                <div class="formListSD" id="url1" style="display: none;">
                    <div class="formTextSD"><span class="c-red">*</span><span>跳转方式：</span></div>
                    <div class="formInputSD">
                        <input type="text" name="url" id="url" value="" style="width: 500px;" />
                    </div>
                </div>
                <div class="formListSD" id="time1">
                    <div class="formTextSD"><span>有效时间 ：</span></div>
                    <div class="formInputSD">
                        <input type="text" class="input-text" value="{$start_time}" autocomplete="off" placeholder="请输入开始时间" id="start_time" name="start_time" style="width:190px;height: 36px;">
                        <label style="margin-right: 6px;">至</label>
                        <input type="text" class="input-text" value="{$end_time}" autocomplete="off" placeholder="请输入结束时间" id="end_time" name="end_time" style="width:190px;height: 36px;">
                    </div>
                </div>
                <div class="formListSD" id="receive1" >
                    <div class="formTextSD"><span class="c-red">*</span><span>领取限制：</span></div>
                    <div class="formInputSD" {if $limit_type == 1}style="display: none;" {/if}>
                        <span style="margin-right: 8px;">每人限领1张</span>
                    </div>
                    <div class="formInputSD" {if $limit_type != 1}style="display: none;" {/if}>
                        <span style="margin-right: 8px;">每人限领</span>
                        <input type="number" name="receive" value="" style="width: 125px;" />
                        <span >张</span>
                    </div>
                </div>
                <div class="formListSD" id="time2" style="display: none;">
                    <div class="formTextSD"><span>有效时间 ：</span></div>
                    <div class="formInputSD" >
                        <span style="margin-right: 8px;">开通会员当天后的</span>
                        <input type="number" name="day" value="" style="width: 125px;" />
                        <span >天可使用</span>
                    </div>
                </div>
                <div class="formListSD" id="receive1" >
                    <div class="formTextSD"><span class="c-red">*</span><span>使用说明：</span></div>
                    <div class="formInputSD" >
                        <textarea rows="3" cols="60" name="Instructions" style="border: 1px #D5DBE8 solid;">
                        </textarea>
                    </div>
                </div>
            </div>
        </table>
        <div class="page_h10" style="height: 64px!important;width: 98%;position: fixed;bottom: 0;border-top: 1px solid rgba(180, 180, 180, 0.4);border-bottom: 10px solid rgb(237, 241, 245);background-color: #fff;z-index: 9999;">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 60px!important;">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

{include file="../../include_path/footer.tpl"}
<script src="style/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript" src="style/zTree/js/jquery.ztree.exhide.js"></script>
<script type="text/javascript" src="style/zTree/js/fuzzysearch.js"></script>
{literal}
<script>
function activitytype(){
    var activity_type = document.getElementById("activity_type").value; // 优惠券类型
    if(activity_type == 1){
        document.getElementById('circulation1').style.display = ""; // 显示
        document.getElementById('money1').style.display = "none"; // 隐藏
        document.getElementById('discount1').style.display = "none"; // 隐藏
        document.getElementById('time1').style.display = ""; // 显示
        document.getElementById('receive1').style.display = ""; // 显示
        document.getElementById('time2').style.display = "none"; // 隐藏
        document.getElementById('grade1').style.display = "none"; // 隐藏
        document.getElementById('type_type').style.display = "none"; // 隐藏
    }else if(activity_type == 2){
        document.getElementById('circulation1').style.display = ""; // 显示
        document.getElementById('money1').style.display = ""; // 显示
        document.getElementById('discount1').style.display = "none"; // 隐藏
        document.getElementById('time1').style.display = ""; // 显示
        document.getElementById('receive1').style.display = ""; // 显示
        document.getElementById('time2').style.display = "none"; // 隐藏
        document.getElementById('grade1').style.display = "none"; // 隐藏
        document.getElementById('type_type').style.display = "none"; // 隐藏
    }else if(activity_type == 3){
        document.getElementById('circulation1').style.display = ""; // 显示
        document.getElementById('money1').style.display = "none"; // 隐藏
        document.getElementById('discount1').style.display = ""; // 显示
        document.getElementById('time1').style.display = ""; // 显示
        document.getElementById('receive1').style.display = ""; // 显示
        document.getElementById('time2').style.display = "none"; // 隐藏
        document.getElementById('grade1').style.display = "none"; // 隐藏
        document.getElementById('type_type').style.display = "none"; // 隐藏
    }else if(activity_type == 4){
        document.getElementById('circulation1').style.display = "none"; // 隐藏
        document.getElementById('money1').style.display = ""; // 显示
        document.getElementById('discount1').style.display = "none"; // 隐藏
        document.getElementById('time1').style.display = "none"; // 隐藏
        document.getElementById('receive1').style.display = "none"; // 隐藏
        document.getElementById('time2').style.display = ""; // 显示
        document.getElementById('grade1').style.display = ""; // 显示
        document.getElementById('type_type').style.display = ""; // 显示
    }
}
function onClick_type(obj){
    if (obj.value == '1') { // 首页
        document.getElementById('money1').style.display = ""; // 显示
        document.getElementById('discount1').style.display = "none"; // 隐藏
    } else if (obj.value == '2') { // 自定义
        document.getElementById('money1').style.display = "none"; // 隐藏
        document.getElementById('discount1').style.display = ""; // 显示
    }
}
$("#money").blur(function () {
    var money = document.getElementById('money').value; // 减
    $("#money1").val(money);
});
laydate.render({
    elem: '#start_time', //指定元素
    type: 'datetime',
    trigger: 'click' //自动弹出控件的时间，采用click弹出
});
laydate.render({
    elem: '#end_time',
    type: 'datetime',
    trigger: 'click' //自动弹出控件的时间，采用click弹出
});
function skip(obj) {
    if (obj.value == '1') { // 首页
        document.getElementById('url1').style.display = "none"; // 隐藏
    } else if (obj.value == '2') { // 自定义
        document.getElementById('url1').style.display = ""; // 显示
    }
}

var product_page = 1  //指定商品查询的页数
var product_flag = true
var search_flag = false  //是否是搜索
$('#treeDemo').scroll(function(event){
	// 如果是指定商品
	if($(this).hasClass('treeDemo1')){
		var searchName = $('#classSel').val()
		var boxHeight=$(this).children().height()*$(this).children().length  //盒子内元素的总高度
		var scrollHeight = $(this).scrollTop()+ $(this).height()   //滚动内容所处位置
		// 当滚动到底部时
		if(boxHeight==scrollHeight && product_flag){
			product_page++
			chaxun('product',searchName)
		}
	}
});

function show(obj) {
    if (obj.value == '1') { // 全部商品
        document.getElementById('container').style.display = "none"; // 优惠劵类型id
        document.getElementById('option_container').style.display = "none"; // 优惠劵类型id
		$('#treeDemo').removeClass('treeDemo1')
		$('#classSel').removeClass('classSel1')
    } else if (obj.value == '2') { // 指定商品
        document.getElementById('container').style.display = ""; // 优惠劵类型id
        document.getElementById('menuContent').style.display = "none"; 
        $('#container').height(36)
		$('#treeDemo').addClass('treeDemo1')
		$('#classSel').addClass('classSel1')
		product_page = 1
		product_flag = true
        chaxun('product');
    } else if (obj.value == '3') { // 指定分类
        document.getElementById('container').style.display = ""; // 优惠劵类型id
        document.getElementById('menuContent').style.display = "none"; 
        $('#container').height(36)
		$('#treeDemo').removeClass('treeDemo1')
		$('#classSel').removeClass('classSel1')
        chaxun('fenlei');
    }
    $("#menu_list").val('');
    $("#option_container_1").empty();
    var cityObj = $("#classSel");
    cityObj.attr("value", '');
}

$('#classSel').bind('input',function(){
	// 如果是指定商品
	if($(this).hasClass('classSel1')){
		var searchName = $(this).val()
		product_page = 1
		product_flag = true
		search_flag = true
		if(searchName==''){
			search_flag = false
		}
		chaxun('product',searchName)
	}
})
function chaxun(canshu,searchName) {
    $.ajax({
        cache: true,
        type: "GET",
        dataType: "json",
        url: 'index.php?module=coupon&action=Add&m='+canshu,
        data: {
            page: canshu=='product'?product_page:'',
			name: search_flag?searchName:''
        },
        async: true,
        success: function (data) {
            if(data.product_class){
                if(product_page==1){
                    zNodes = data.product_class;
                }else{
                    // 目前最后一个元素的ID编号
                    zNodes = zNodes.concat(data.product_class);
                }
                if(data.product_class.length<10){
                    product_flag=false
                }
            }else if(data.list){
                zNodes = data.brand_class;
            }
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        }
    });
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
        url: 'index.php?module=coupon&action=Add',
        data: $('#form1').serialize(),// 你的formid
        async: true,
        success: function (data) {
            layer.msg(data.status, {time: 1000});
            setTimeout(function(){
                if(data.suc){
                    location.href="index.php?module=coupon";
                }
            },1000)
        }
    });
}
</script>
{/literal}
</body>
</html>