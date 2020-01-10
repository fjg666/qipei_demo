{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style type="text/css">
.row .form-label{
    width: 14%!important;
}
.btn1{
    width: 112px;
    height: 42px;
    line-height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    float: left;
    color: #6a7076;
    background-color: #fff;
}
.btn1:hover{
    text-decoration: none;
}
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}

.formContentSD{
    padding-left: 50px;
}
.formTitleSD{
    color: #414658;
    font-weight:Bold;
}
.formTextSD{
    width: 140px;
    height: 40px;
}
.inputC1:checked + label::before{
    width: 16px;
    height: 16px;
}
.wrap {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

.circle {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
 /*   left: 0px; */
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.circle:hover {
    transform: scale(1.2);
    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
}
.range1{
    background-color: #F4F7F9;
    height: 36px;
    line-height: 36px;
    margin-right: 12px;
    padding: 0px 0px 0px 12px;
    margin-top: 2px;
    margin-bottom: 10px;
}
.range1_1{
    padding:10px;
}

.text-c .inputC{
    margin-right: -1px;
    width: 0px;
}
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
{/literal}
<body id="asd">
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    满减设置
</nav>
<div class="main pd-20 page_absolute ">
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=subtraction" class="btn1 " style="border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;" >满减活动</a>
        <a href="index.php?module=subtraction&action=Config" class="btn1 swivch_active" style="border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;">满减设置</a>
        <div style="clear: both;"></div>
    </div>

    <div class="page_h16"></div>
    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding: 0!important;">
        <div class="formDivSD">
            <div class="formTitleSD" style="font-size: 16px;">基础设置</div>
            <div class="formContentSD">
                <div class="formListSD">
                    <div class="formTextSD"><span>是否开启满减：</span></div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="is_subtraction"  type="radio" {if $is_subtraction == 1}checked="checked"{/if} style="display: none;" id="is_subtraction-1" class="inputC1" value="1">
                            <label for="is_subtraction-1">是</label>
                        </div>
                        <div class="ra1">
                            <input name="is_subtraction"  type="radio" {if $is_subtraction != 1}checked="checked"{/if} style="display: none;" id="is_subtraction-2" class="inputC1" value="0">
                            <label for="is_subtraction-2">否</label>
                        </div>
                    </div>
                </div>
                <div class="formListSD" >
                    <div class="formTextSD" style="align-items: start;"><span class="c-red">*</span><span style="height: 12px; margin-top: 8px;">满减应用范围：</span></div>
                    <div class="formInputSD" >
                        <table >
                            <thead>
                            <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                <th width="40" style="border-bottom: 0px solid #d5dbe8!important;height: 0px;">
                                    <div style="position: relative;display: flex;height: 30px;align-items: center;float: left;">
                                        <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
                                        <label for="ipt1"></label>
                                        <span >全选</span>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                <td style="height: 0px;">
                                    <div style="display: flex;align-items: center;float: left;">
                                        <input name="range_zfc[]"  id="type_1" type="checkbox" class="inputC inputC_y" value="1" {if in_array(1,$range_zfc)}checked{/if}>
                                        <label for="type_1"></label>
                                        <span >指定分类</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                <td style="height: 0px;">
                                    <div style="display: flex;align-items: center;float: left;">
                                        <input name="range_zfc[]"  id="type_2" type="checkbox" class="inputC inputC_y" value="2" {if in_array(2,$range_zfc)}checked{/if}>
                                        <label for="type_2"></label>
                                        <span >全场满减</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                <td style="height: 0px;">
                                    <div style="display: flex;align-items: center;float: left;">
                                        <input name="range_zfc[]"  id="type_3" type="checkbox" class="inputC inputC_y" value="3" {if in_array(3,$range_zfc)}checked{/if}>
                                        <label for="type_3"></label>
                                        <span >指定品牌</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                <td style="height: 0px;">
                                    <div style="display: flex;align-items: center;float: left;">
                                        <input name="range_zfc[]"  id="type_4" type="checkbox" class="inputC inputC_y" value="4" {if in_array(4,$range_zfc)}checked{/if}>
                                        <label for="type_4"></label>
                                        <span >指定商家满减</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red">*</span><span>满赠商品设置：</span></div>
                    <button type="button" onclick="check2()" style="width: 128px;height: 36px;line-height: 36px;border: 1px #2890FF solid;text-align: center;color: #2890FF;background-color: #ffffff;">添加满赠商品</button>
                    <input type="hidden" name="pro_id" id="pro_id" value="{$pro_id}">
                </div>
                <div id="product_list2" style="margin-left: 150px;margin-top: 14px;margin-bottom: 25px;">

                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span>满减图片显示位置：</span></div>
                    <div class="formInputSD">
                        <input type="text" min="1" name="position" id="position" value="" placeholder="请输入满减图片显示位置"/>
                    </div>
                    <button type="button" onclick="check3()" style="width: 60px;height: 36px;line-height: 36px;border: 1px #2890FF solid;text-align: center;color: #2890FF;margin-left: 5px;background-color: #ffffff;">添加</button>
                    <input type="hidden" name="position_zfc" id="position_zfc" value="{$position_zfc}">
                </div>
                <div class="formListSD" id="formListSD2" style="display: none;">
                    <div class="formInputSD" style="float: left;  display: flex; align-items: center; justify-content: flex-start; flex-wrap: wrap;     margin-left: 151px;" id="position1_1">

                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span>满减包邮设置：</span></div>
                    <div class="formInputSD">
                        <div class="status_box">
                            <input type="hidden" class="status" name="is_shipping" id="is_shipping" value="{$is_shipping}">
                            <div class="wrap">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span></span></div>
                    <div  style="background-color: #F4F7F9;">
                        <div style="padding-top: 10px;">
                            <label style="padding-left: 14px;padding-right: 8px;letter-spacing:3px;">单笔订单满</label>
                            <input style="width: 180px;border-color: #d5dbe8;" type="number" name="z_money" value="{$z_money}" class="input-text inputcss" min="1" />
                            <label >元，免邮费。</label>
                            <span style="color: #A8B0CB;">（如开启满减包邮设置，设置0元时，邮全场商品包邮，除规定不包邮地区外）</span>
                        </div>
                        <div style="padding-top: 14px;padding-bottom: 10px;">
                            <label style="padding-left: 14px;padding-right: 8px;">不包邮地区：</label>
                            <input type="hidden" name="address_id" id="address_id" value="{$address_id}">
                            <input style="width: 360px;border-color: #d5dbe8;" type="text" name="address" id="address" value="" class="input-text inputcss" min="1" />
                            <span style="color: #2890FF;padding: 10px;" onclick="choice()">选择</span>
                            <span style="color: #A8B0CB;">（选择多个省市时，则以逗号分隔显示）</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="border: 1px #E9ECEF solid;"></div>
        <div class="page_h10" style="height: 65px!important;">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 83px!important;">
        </div>
    </form>
    <div class="page_h20"></div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
{include file="../../include_path/footer.tpl"}
{literal}
<script>
    var aa=$(".pd-20").height()-16-56;
    var bb=$(".form-horizontal").height();
    if(aa<bb){
        $(".page_h20").css("display","block")
    }else{
        $(".page_h20").css("display","none")
        $(".row_cl").addClass("page_footer")
    }
    $('.circle').click(function () {
        var left = $(this).css('left');
        left = parseInt(left);
        var status = $(this).parents(".status_box").children(".status");
        if (left == 0) {
            $(this).css('left', '30px'),
                $(this).css('background-color', '#fff'),
                $(this).parent(".wrap").css('background-color', '#5eb95e');
            $(".wrap_box").show();
            status.val(1);
        } else {
            $(this).css('left', '0px'),
                $(this).css('background-color', '#fff'),
                $(this).parent(".wrap").css('background-color', '#ccc');
            $(".wrap_box").hide();
            status.val(0);
        }
    })
    if (document.getElementById('is_shipping').value == 0) {
        $('.circle').css('left', '0px'),
            $('.circle').css('background-color', '#fff'),
            $('.circle').parent(".wrap").css('background-color', '#ccc');
        $(".wrap_box").hide();
    } else {
        $('.circle').css('left', '30px'),
            $('.circle').css('background-color', '#fff'),
            $('.circle').parent(".wrap").css('background-color', '#5eb95e');
        $(".wrap_box").show();
    }

    var position_list = []; // 显示位置
    $(function() {
        commodity_confirm($("#pro_id").val())
        add_address($("#address_id").val().split(','))

        if($("#position_zfc").val() != ''){
            document.getElementById('formListSD2').style.display = "";
            position_list = $("#position_zfc").val().split(',');

            var rew = '';
            for (i=0;i<position_list.length;i++){
                rew += '<div class="range1">'+
                    '<div style=" overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display: inline-block;">'+position_list[i]+
                    '<span class="range1_1" onclick="position_del(\''+position_list[i]+'\')">X</span>'+
                    '</div>'+
                    '</div>';
            }
            $("#position1_1").append(rew);
        }

        // 进网页判断是否已经全选
        var flag=true;
        for(var i=0;i<$('.inputC_y').length;i++){
            if(!$('.inputC_y').eq(i).is(':checked')){
                flag=false
            }
        }
        $("#ipt1").prop('checked',flag)

        // 单选按钮选择
        $(".inputC_y").on('change',function(){
            var flag=true;
            for(var i=0;i<$('.inputC_y').length;i++){
                if(!$('.inputC_y').eq(i).is(':checked')){
                    flag=false
                }
            }
            $("#ipt1").prop('checked',flag)
        })
    })

    // 点击添加满赠商品
    function check2() {
        $("body", parent.document).append(`
            <div class="maskNew">
                <div class="maskNewContent" style="width: 920px;height: 538px !important;">
                    <div style="font-size:16px;color:#414658;border-bottom: 2px solid #E9ECEF;padding: 8px 0px 14px 19px;">
                        <span>添加满赠商品</span>
                        <span style="float: right;padding:0px 19px;" onclick="closeMask1()">X</span>
                    </div>
                    <input type="hidden" name="productid" id="productid" value="">
                    <div class="row cl" style="margin-left: 40px;margin-top:35px;">
                        <div class="formListSD" style="float: left;margin-right: 8px;margin-top:0px;">
                            <div class="formInputSD" style='display: block;'>
                                <div class='selectDiv' onclick="select_class()">
                                    <select name="product_class" class="select" readonly="readonly" style='height: 36px;width: 160px;'>
                                        <option selected="selected" value="0">请选择商品类别</option>
                                    </select>
                                    <div id="div_text" style="font-size: 14px;">

                                    </div>
                                </div>
                                <div id='selectData' class='formInputDiv' style='display: none;'>
                                    <ul id="selectData_1" style="font-size: 14px;">

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="formListSD" style="float: left;margin-right: 8px;margin-top:0px;">
                            <div class="formInputSD" onclick="select_pinpai()">
                                <select name="brand_class" class="select" id="brand_class" style="height: 36px;width: 160px;">
                                    <option selected="selected" value="0">请选择商品品牌</option>
                                </select>
                            </div>
                        </div>
                        <input type="text" name="product_title" size='8' id="product_title" style="width: 240px;height: 36px;" value="" placeholder="请输入商品名称" class="input-text">
                        <input name="" id="btn9" class="btn " type="submit" style="width: 60px;height: 36px;border-radius: 2px;" onclick="chaxun(this)" value="查询">
                    </div>
                    <div id="product_list1" style="margin-left: 40px;margin-top: 14px;width: 840px;">

                    </div>
                    <div id="queren" style="text-align:right;margin-top:24px;margin-right: 39px;display: none;">
                        <button class="closeMask" style="margin-right:4px;color: #2890FF;background-color: #ffffff;border: 1px solid #008DEF;" onclick=closeMask1() >取消</button>
                        <button class="closeMask" style="margin-right:20px;color: #ffffff;background-color: #2890FF;" onclick=commodity_confirm()>确认</button>
                    </div>
                </div>
            </div>
        `)
    }
    // 商品确认
    function commodity_confirm(productid){
        $("#product_list2").empty();
        var productid = $("#pro_id").val() + ',' + productid;
        var str = productid.split(',');
        var temp = []; //一个新的临时数组

        for(var i = 0; i < str.length; i++){
            if(temp.indexOf(str[i]) == -1){
                temp.push(str[i]);
            }
        }

        productid = temp.join(',');
        $.ajax({
            cache: true,
            type: "GET",
            dataType: "json",
            url: 'index.php?module=subtraction&action=Config&m=commodity_confirm',
            data: {
                productid:productid,
            },
            async: true,
            success: function (data) {
                var pro_id = data.pro_id;
                var res = '<div class="tab_table" style="height: auto;">'+
                            '<table class="table-border tab_content" style="background-color: #F4F7F9;">'+
                            '   <thead>' +
                            '       <tr class="text-c tab_tr" style="height: 50px;">' +
                            '           <th style="padding: 9px 10px !important;">商品信息</th>' +
                            '           <th style="padding: 9px 10px !important;">店铺</th>' +
                            '           <th style="padding: 9px 10px !important;">价格</th>' +
                            '           <th style="padding: 9px 10px !important;">库存</th>' +
                            '           <th style="padding: 9px 10px !important;">操作</th>' +
                            '       </tr>' +
                            '   </thead>' +
                            '   <tbody>';
                if(data.product_list.length != 0){
                    product_list = data.product_list;
                    for (var k in product_list) {
                        res += `<tr class="text-c tab_td" >
                               <td style="text-align: left;height: 59px;padding-left: 40px;">
                                   <img src="${product_list[k]['imgurl']}" style="width: 42px;height: 42px;">
                                   ${product_list[k]['product_title']}
                               </td>
                               <td style="height: 59px;">${product_list[k]['mch_name']}</td>
                               <td style="height: 59px;">${product_list[k]['present_price']}</td>
                               <td style="height: 59px;">${product_list[k]['num']}</td>
                               <td style="height: 59px;">
                                    <a onclick="del('${product_list[k]['id']}','${pro_id}')" style="width: 56px;height: 22px;">
                                        <img src="images/icon1/del.png" style="margin-right: 0px;margin-top: -2px;"/>&nbsp;删除
                                    </a>
                               </td>
                            </tr>`;
                    }
                    res += "</tbody>" +
                        "</table>"+
                        "</div>";
                    $("#product_list2").append(res);
                }
                $("#pro_id").val(pro_id);
            }
        });
    }
    // 删除商品
    function del(id,pro_id) {
        $("#product_list2").empty();
        $.ajax({
            cache: true,
            type: "GET",
            dataType: "json",
            url: 'index.php?module=subtraction&action=Config&m=del',
            data: {
                id:id,
                pro_id:pro_id,
            },
            async: true,
            success: function (data) {
                if(data.status == 1){
                    layer.msg('该商品正在参与活动，不能删除！', {time: 1000});
                }
                var pro_id = data.pro_id;
                var res = '<div class="tab_table" style="height: auto;">'+
                    '<table class="table-border tab_content" style="background-color: #F4F7F9;">'+
                    '   <thead>' +
                    '       <tr class="text-c tab_tr" style="height: 50px;">' +
                    '           <th style="padding: 9px 10px !important;">商品信息</th>' +
                    '           <th style="padding: 9px 10px !important;">店铺</th>' +
                    '           <th style="padding: 9px 10px !important;">价格</th>' +
                    '           <th style="padding: 9px 10px !important;">库存</th>' +
                    '           <th style="padding: 9px 10px !important;">操作</th>' +
                    '       </tr>' +
                    '   </thead>' +
                    '   <tbody>';
                if(data.product_list.length != 0){
                    product_list = data.product_list;
                    for (var k in product_list) {
                        res += `<tr class="text-c tab_td" >
                           <td style="text-align: left;height: 59px;padding-left: 40px;">
                               <img src="${product_list[k]['imgurl']}" style="width: 42px;height: 42px;">
                               ${product_list[k]['product_title']}
                           </td>
                           <td style="height: 59px;">${product_list[k]['mch_name']}</td>
                           <td style="height: 59px;">${product_list[k]['present_price']}</td>
                           <td style="height: 59px;">${product_list[k]['num']}</td>
                           <td style="height: 59px;">
                                <a onclick="del('${product_list[k]['id']}','${pro_id}')" style="width: 56px;height: 22px;">
                                    <img src="images/icon1/del.png" style="margin-right: 0px;margin-top: -2px;"/>&nbsp;删除
                                </a>
                           </td>
                        </tr>`;
                    }
                    res += "</tbody>" +
                        "</table>"+
                        "</div>";
                    $("#product_list2").append(res);
                }
                $("#pro_id").val(pro_id);
            }
        });
    }

    // 添加满减图片显示位置
    function check3() {
        var position = $("#position").val();
        document.getElementById('formListSD2').style.display = "";

        if(position == ''){
            layer.msg("请输入显示位置");
            return;
        }
        if(position_list.length != 0){
            for (i=0;i<position_list.length;i++){
                if(position_list[i] == position){
                    layer.msg("请勿添加重复");
                    return;
                }
            }
        }
        $("#position1_1").empty();

        $("#position").val('');
        position_list.push(position);

        var position_zfc = '';
        for (i=0;i<position_list.length;i++){
            position_zfc += position_list[i] + ',';
        }
        $("#position_zfc").val(position_zfc);

        var res = '';
        for (i=0;i<position_list.length;i++){
            res += '<div class="range1">'+
                '<div style=" overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display: inline-block;">'+position_list[i]+
                '<span class="range1_1" onclick="position_del(\''+position_list[i]+'\')">X</span>'+
                '</div>'+
                '</div>';
        }
        $("#position1_1").append(res);
    }

    // 显示位置删除
    function position_del(position) {
        $("body", parent.document).append(`
            <div class="maskNew">
                <div class="maskNewContent">
                    <div style="width: 402px;height: 50px;position: relative;margin-top: 50px;margin-left: 28px;font-size: 16px;text-align: center;">
                        删除此应用显示位置将可能导致此满减活动无法正常使用请谨慎操作！
                    </div>
                    <div style="text-align:center;margin-top:40px;margin-left: 8px;">
                        <button class="closeMask" style="margin-right:4px;color: #2890FF;background-color: #ffffff;border: 1px solid #008DEF;" onclick=closeMask1() >取消</button>
                        <button class="closeMask" style="margin-right:20px;color: #ffffff;background-color: #2890FF;" onclick=position_del_confirm('${position}')>确认删除</button>
                    </div>
                </div>
            </div>
        `)
    }

    // 显示位置删除-确认
    function confirm_position_del(position) {
        for (i=0;i<position_list.length;i++){
            if(position_list[i] == position){
                position_list.splice(i--,1);
            }
        }
        $("#position1_1").empty();

        var position_zfc = '';
        for (i=0;i<position_list.length;i++){
            position_zfc += position_list[i] + ',';
        }
        $("#position_zfc").val(position_zfc);

        if(position_list.length > 0){
            var res = '';
            for (i=0;i<position_list.length;i++){
                res += '<div class="range1">'+
                    '<div style=" overflow:hidden; text-overflow:ellipsis; white-space: nowrap; display: inline-block;">'+position_list[i]+
                    '<span class="range1_1" onclick="position_del(\''+position_list[i]+'\')">X</span>'+
                    '</div>'+
                    '</div>';
            }
            $("#position1_1").append(res);
        }else{
            document.getElementById('formListSD2').style.display = "none";
        }
    }
    // 获取省
    function choice(){
        var address_id = document.getElementById("address_id").value;
        var rew = '';
        $.ajax({
            cache: true,
            type: "get",
            dataType: "json",
            url: 'index.php?module=subtraction&action=Config&m=province',
            data: {
                address_id:address_id,
            },
            async: true,
            success: function (res) {
                if(res.status == 1){
                    var list = res.list;
                    rew+= " <div class='radio-box' style='width: 15%;height: 10px;'><input name='all' class='inputC' type='checkbox' id='sex-all' onchange='sel_all()'><label for='sex-all' style='font-weight: bold;display: inline-block!important;width: 100px;border: none;'>全选</label></div>\n" +
                        "<br>";
                    for (var k in list) {
                        rew += "<div class='radio-box' style='width: 15%;'>" +
                            "<input name='list' class='inputC' type='checkbox' id='sex-"+list[k]['GroupID']+"' value='"+list[k]['GroupID']+"'>" +
                            "<label for='sex-"+list[k]['GroupID']+"' style='display: inline-block!important;width: 100px;border: none;'>"+list[k]['G_CName']+"</label>" +
                            "</div>"
                    }
                    $("body", parent.document).append(`
                        <div class="maskNew">
                            <div class="maskNewContent" style="width: 920px;height: 538px !important;">
                                <div style="font-size:16px;color:#414658;border-bottom: 1px solid red;padding: 8px 0px 14px 19px;">
                                    <span>添加省份</span>
                                    <span style="float: right;padding:0px 19px;" onclick="closeMask1()">X</span>
                                </div>
                                <div class="row cl" style="margin-left: 40px;margin-top:0px;">
                                    ${rew}
                                </div>
                                <div id="queren" style="text-align:right;margin-top:24px;margin-right: 39px;">
                                    <button class="closeMask" style="margin-right:4px;color: #2890FF;background-color: #ffffff;border: 1px solid #008DEF;" onclick=closeMask1() >取消</button>
                                    <button class="closeMask" style="margin-right:20px;color: #ffffff;background-color: #2890FF;" onclick=add_address()>确认</button>
                                </div>
                            </div>
                        </div>
                    `)
                }else{
                    layer.msg("已经全选!");
                }
            },
            error:function(e){
                console.info(e);
            }
        });
    }
    // 选中省显示出来
    function add_address(check_val) {
        var rew = '';
        $.ajax({
            cache: true,
            type: "get",
            dataType: "json",
            url: 'index.php?module=subtraction&action=Config&m=add_province',
            data: {
                data:check_val,
            },
            async: true,
            success: function (res) {
                var address = res.address;
                var address_id = res.address_id;
                $("#address").val(address);
                $("#address_id").val(address_id);
            },
            error:function(e){
                console.info(e);
            }
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
            url:'index.php?module=subtraction&action=Config',
            data:$('#form1').serialize(),// 你的formid
            async: true,
            success: function(data) {
                layer.msg(data.status,{time:1000});
                setTimeout(function(){
                    if(data.suc){
                        location.href="index.php?module=subtraction&action=Config";
                    }
                },1000)
            }
        });
    }
	
</script>
{/literal}
</body>
</html>