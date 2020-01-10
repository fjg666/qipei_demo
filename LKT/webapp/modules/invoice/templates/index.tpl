<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-09-02 15:36:06
 * @LastEditTime: 2019-09-30 16:00:37
 * @LastEditors: Please set LastEditors
 -->
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link href="style/css/flex.css" rel="stylesheet">
    
    {include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<link href="style/css/model.dd.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<style>
.modal-open .modal {
  overflow-x: hidden;
  overflow-y: auto;
}
.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1040;
  background-color: #000;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: 30px auto;
}

.modal-content {
	position: relative;
	display: -webkit-box;
	display: -webkit-flex;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-webkit-flex-direction: column;
	-ms-flex-direction: column;
	flex-direction: column;
	background-color: #fff;
	-webkit-background-clip: padding-box;
	background-clip: padding-box;
	border: 1px solid rgba(0, 0, 0, .2);
	border-radius: .3rem;
	outline: 0
}
.modal-header {
	display: -webkit-box;
	display: -webkit-flex;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-webkit-align-items: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: justify;
	-webkit-justify-content: space-between;
	-ms-flex-pack: justify;
	justify-content: space-between;
	padding: 15px;
	border-bottom: 1px solid #eceeef
}
.modal-body {
	position: relative;
	-webkit-box-flex: 1;
	-webkit-flex: 1 1 auto;
	-ms-flex: 1 1 auto;
	flex: 1 1 auto;
	padding: 15px
}
.modal-footer {
	display: -webkit-box;
	display: -webkit-flex;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-webkit-align-items: center;
	-ms-flex-align: center;
	align-items: center;
	-webkit-box-pack: end;
	-webkit-justify-content: flex-end;
	-ms-flex-pack: end;
	justify-content: flex-end;
	padding: 15px;
	border-top: 1px solid #eceeef
}






    
    td a{
        width: 90%;
        margin: 2%!important;
    }
    .btn1{
        width: 112px;
        height: 36px;
        line-height: 36px;
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


    .stopCss:hover {
        cursor: not-allowed;
    }
    .stopCss {
        width: 88px;
        height: 20px;
        border: 1px solid #e9ecef;
        color: #d8dbe8 !important;
        font-size: 12px;
        border-radius: 2px;
        line-height: 20px;
        display: inline-block;
        margin-left: -2%;
        margin-bottom
    }

    .model-line{
        height:447px;
        width:1px;
        border-left: 1px solid #E9ECEF;
    }
    .card-left {

    }
    .card-right {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 447px;
        flex-direction: column;
    }
    .right-effect {
        width:377px;
        height:300px;
        box-shadow:0px 0px 16px 0px rgba(0, 0, 0, 0.1);
    }
    .right-text {
        margin-top:22px;
        font-size:14px;
        font-weight:400;
        color:rgba(151,160,180,1);
    }
    button.btn.item-btn1 {
        width: 112px;
        height: 36px;
        border: 1px solid rgba(40,144,255,1);
        border-radius: 2px;
        color: rgba(40,144,255,1);
    }

    button.btn.btn-primary.item-btn2 {
        width: 112px;
        height: 36px;
        background: rgba(40,144,255,1);
        border-radius: 2px;
    }
</style>
{/literal}
<body style="width:100%;">
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="" style="margin: 0px 10px;" >
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=invoice" class="btn1 swivch_active" style="height: 42px !important;border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;">发货单</a>
        <a href="index.php?module=invoice&action=indexx" class="btn1" style="height: 42px !important;border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;">快递单</a>
        <div style="clear: both;"></div>
    </div>

    <div class="page_h16"></div>
    <div class="text-c" style="display: flex;">

        <form name="form1" action="index.php" method="get" style="width: 100%;padding: 10px;">
            <input type="hidden" name="module" value="invoice" />
            <select name="r_time" class="select" id="r_time" style="width: 100px;height: 31px;vertical-align: middle;">
                <option value="1" {if $r_time==1}selected{/if}>下单时间</option>
                <option value="2" {if $r_time==2}selected{/if}>付款时间</option>
                <option value="3" {if $r_time==3}selected{/if}>发货时间</option>
            </select>
            <input type="text" class="input-text seach_bottom" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
            <span style='display: inline-block;height: 36px;'>
                <span style='display: flex;align-items:center;'>
                    至
                </span>
            </span>
            <input type="text" class="input-text seach_bottom" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;margin-left:5px;">
            <select name="print_type" class="select" id="print_type" style="width: 150px;height: 31px;vertical-align: middle;">
                <option value="" >请选择打印状态</option>
                <option value="1" {if $print_type==1}selected{/if}>已打印</option>
                <option value="2" {if $print_type==2}selected{/if}>未打印</option>
            </select>
            <!-- <select name="o_status" class="select" id="o_status" style="width: 150px;height: 31px;vertical-align: middle;">
                <option value="" >请选择订单状态</option>
                <option value="1" {if $o_status==1}selected{/if}>未发货</option>
                <option value="2" {if $o_status==2}selected{/if}>已发货</option>
            </select> -->
            <input type="text" class="input-text" style="width:150px" placeholder="请输入下单人名称" name="recipient" id="recipient" value="{$recipient}">
            <input type="text" class="input-text" style="width:150px" placeholder="请输入下单人手机号" name="r_mobile" id="r_mobile" value="{$r_mobile}">
            <input type="text" class="input-text" style="width:150px" placeholder="请输入订单号" name="sNo" id="sNo" value="{$sNo}">

            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />
            <input name="" id="" class="btn btn-success" type="submit" value="查询">

            <input style="margin-right: 0px;float: right;" id="btn1" class="btn btn-success" type="button" value="导出" onclick="export_popup(location.href)">
        </form>
        
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll" style="padding-bottom: 80px;">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th width="40">
                        <div style="position: relative;display: flex;height: 30px;align-items: center;">
                            <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
                            <label for="ipt1"></label>
                        </div>
                    </th>
                    <th>订单号</th>
                    <th class="tab_num" style="width: 20%;">商品信息</th>
                    <th>数量</th>
                    <th>收件信息</th>
                    <th>寄件人</th>
                    <th>打印状态</th>
                    <th>备注</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
               <tr class="text-c tab_td">
                    <td >
                        <div style="display: flex;align-items: center;height: 60px;">
                            <input name="id[]"  id="{$item->id}" type="checkbox" class="inputC " value="{$item->id}">
                            <label for="{$item->id}"></label>
                        </div>
                    </td>
                    <td>{$item->sNo}</td>
                    <td class="tab_num" style="text-align: justify;"><div style="width:305px;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden;">{$item->title}</div></td>
                    <td>{$item->num}</td>
                    <td style="text-align: justify;width: 219px;">
                        {$item->recipient}  {$item->r_mobile}
                        <br />
                        <div style="width: 219px;">
                            {$item->r_sheng}
                            {$item->r_shi}
                            {$item->r_xian}
                            {$item->r_address}
                        </div>

                    
                    </td>
                    <td>{$item->sender}</td>
                    <td>{if $item->status == 1}已打印{else}未打印{/if}</td>
                    <td>{$item->remark}</td>

                    <td class="tab_editor">
                        <div class="hover_a" onclick="edit({$item->id})" title="编辑" style="border: none!important;">
                            <img style="margin-top: -3px;" src="images/icon1/xg.png"/>&nbsp;编辑
                        </div>
                    </td>

                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class='tb-tab' style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    </div>

    <div style="position: fixed;bottom: 0;background-color: #fff;width: 98%;">
        <span style="margin-left: 60px;float: left;padding-top: 13px;color: #108ee9;font-size: 30px;">+</span>
        <a style="margin-left: 6px;float: left;padding-top: 26px;color: #108ee9;" href="index.php?module=invoice&action=template&type=1">模版管理</a>
        <div style="margin-left: 19px;float: left;padding-top: 24px;">
            <span style="color:#414658;">选择快递模版：</span>
            <select name="print_type" class="select" id="print_type" style="width: 108px;height: 31px;vertical-align: middle;">
                {foreach from=$tpl item=item name=f1}
                <option value="{$item->id}" data-ename="{$item->e_name}" {if $item->id==1}selected{/if}>{$item->name}</option>
                {/foreach}
            </select>
        </div>
        <div style="margin-left: 20px;float: left;padding-top: 24px;">
            
            <span style="color:#414658;">打印份数设置：</span>
            <input style="width: 60px;" type="number" id="putnum" value="1">
            <span style="color:#414658;">份</span>
            
        </div>
        <div style="float:  right;margin-right: 60px;width: 112px;">
            <button onclick="print()" type="button" class="btn btn-success" style="margin-top: 25px;">生成发货单</button>
        </div>
        <div style="clear: both;height: 20px;"></div>
    </div>

    <!-- 打印 -->
    <script type="text/javascript" src="style/js/jquery.jqprint-0.3.js"></script>
    <script type="text/javascript" src="style/js/jquery-migrate-1.2.1.min.js"></script>
    <!-- 打印end -->
    
</div>
<div id="app">
    <div id="modal-demo" class="modal felxx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog" style="z-index: 10000;max-width: 840px;box-shadow:0 0px 0px 0px rgba(0, 0, 0, 0);display:flex;">
            <div class="modal-content radius box-modal" style="width: 840px">
    
                <div class="modal-header">
                    <h3 class="modal-title item-title">编辑订单</h3>
                    <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                </div>
    
                <div class="modal-body">
    
                <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" >

                        <input type="hidden" :value="data.r_sheng" :data-id="data.r1" name="sheng" id="sheng">
                        <input type="hidden" :value="data.r_shi" :data-id="data.r2" name="shi" id="shi">
                        <input type="hidden" :value="data.r_xian" :data-id="data.r3" name="xian" id="xian">
                        <input type="hidden" :value="data.s_sheng" :data-id="data.s1" name="sheng" id="sheng2">
                        <input type="hidden" :value="data.s_shi" :data-id="data.s2" name="shi" id="shi2">
                        <input type="hidden" :value="data.s_xian" :data-id="data.s3" name="xian" id="xian2">
    
                        <input type="hidden" name="module" value="invoice">
                        <input type="hidden" name="action" value="creat_list">
                        <input type="hidden" name="m" value="edit">
    
                        <div class="row" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">收件人：</label>
                            <div class="col-xs-4 col-sm-4">
                                <input type="text" v-model="data.recipient" id="recipient"></input>
                            </div>
                        </div>
    
                        <div class="row" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">联系电话：</label>
                            <div class="col-xs-4 col-sm-4">
                                <input type="text" v-model="data.r_mobile" id="r_mobile"></input>
                            </div>
                        </div>
    
                        <div class="row" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">联系地址：</label>
    
                            <!-- <div class="col-xs-4 col-sm-8">
                                <span>
                                    <input type="text" :value="data.r_address" id="r_address"></input>
                                </span>
                            </div> -->
                            <div class="formControls col-xs-8 col-sm-10">
    
                                <select id="Select1" v-model="data.Select1" @change="getCountyData(data.Select1,0)">
                                    <option value="" selected="true">省/直辖市</option>
                                    <option v-for="(item,i) in addressOne.province" :value="item.value" selected="true" v-text="item.text"></option>
                                </select>
    
                                <select id="Select2" v-model="data.Select2" @change="getAreaData(data.Select2,0)">
                                    <option value="" selected="true">请选择</option>
                                    <option v-for="(item,i) in addressOne.county" :value="item.value" selected="true" v-text="item.text"></option>
                                </select>
    
                                <select id="Select3" v-model="data.Select3">
                                    <option value="" selected="true">请选择</option>
                                    <option v-for="(item,i) in addressOne.area" :value="item.value" selected="true" v-text="item.text"></option>
                                </select>
    
                                <input type="text"  v-model="data.r_address" class="input-text" style="width: auto;">
                            </div>
    
                        </div>
    
                        <div class="row" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">订单编号：</label>
                            
                            <div class="col-xs-4 col-sm-4">
                                <span v-text="data.sNo"></span>
                            </div>
                        </div>
    
                        <div class="row" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">宝贝/商品：</label>
                            
                            <div style="margin-left: 135px;height: 150px;overflow: auto;" >
                                <div class="col-xs-4 col-sm-10" style="display: flex;" id="items" v-for="(item,index) in data.goods" :key="index" >

                                    <span>
                                        <select id="pet-select" v-model="item.id" disabled="disabled">
                                            <option v-for="(item2,index2) in data.goods" :key="index2" :value="item2.id" v-text="item2.p_name"></option>
                                        </select>
                                    </span>
                                    
                                    <span style="margin-left: 8PX;">
                                        <input type="text" placeholder="商品编号" v-model="item.product_number" size="10" readonly="readonly" />
                                    </span>
                                    <span>
                                        <input type="text" placeholder="规格/属性" v-model="item.size" size="10" readonly="readonly"/>
                                    </span>
                                    <span>
                                        <input type="text" placeholder="单价" v-model="item.p_price" size="10" readonly="readonly"/>
                                    </span>
                                    <span>
                                        <input type="text" placeholder="数量" v-model="item.num" size="10" readonly="readonly"/>
                                    </span>

                                    <span class="bb-btn" v-if="data.goods.length !== 1">
                                        <div @click="popsp(index)" style="text-align: center;">-</div>
                                        <!-- <div @click="addsp()">+</div> -->
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        <div class="row" style="margin-left: 3px;" v-if="data.subtraction_list">
                            <label class=" col-xs-4 col-sm-2">赠品：</label>
                            
                            <div style="margin-left: 148px;overflow: auto;" >
                                <div class="col-xs-4 col-sm-10" style="display: flex;" >

                                   <span>
                                        <input type="text" placeholder="商品名称" v-model="data.subtraction_list.product_title" readonly="readonly" style="width: 380px;" />
                                    </span>
                                    
                                    <span>
                                        <input type="text" placeholder="商品编号" v-model="data.subtraction_list.product_number" size="10" readonly="readonly" />
                                    </span>
                                     <span>
                                        <input type="text" placeholder="单价" value="0.00" size="10" readonly="readonly"/>
                                    </span>
                                    <span>
                                        <input type="text" placeholder="数量" v-model="data.subtraction_list.num" size="10" readonly="readonly"/>
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        <div class="row" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">平台代发：</label>
                            <div class="col-xs-4 col-sm-4">
                                <input  class="switch" type="checkbox" v-model="data.isopen" @click="openSwitch" style="height:24px !important;visibility: initial;"/>
                            </div>
                        </div>
    
                        <div class="row cl" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">寄件人：</label>
                            <div class="col-xs-4 col-sm-4">
                                <input type="text" v-model="data.sender" id="sender"></input>
                            </div>
                        </div>
    
                        <div class="row cl" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">寄件人联系电话：</label>
                            <div class="col-xs-4 col-sm-4">
                                <input type="text" v-model="data.s_mobile" id="s_mobile"></input>
                            </div>
                        </div>
    
                        <div class="row cl" style="margin-left: 3px;">
                            <label class=" col-xs-4 col-sm-2">寄件人地址：</label>
                            <div class="formControls col-xs-8 col-sm-10">
    
                                <select id="Select4" v-model="data.Select4" @change="getCountyData(data.Select4,1)">
                                    <option value="" selected="true">省/直辖市</option>
                                    <option v-for="(item,i) in addressTwo.province" :value="item.value" selected="true" v-text="item.text"></option>
                                </select>
    
                                <select id="Select5" v-model="data.Select5" @change="getAreaData(data.Select5,1)">
                                    <option value="" selected="true">请选择</option>
                                    <option v-for="(item,i) in addressTwo.county" :value="item.value" selected="true" v-text="item.text"></option>
                                </select>
    
                                <select id="Select6" v-model="data.Select6" >
                                    <option value="" selected="true">请选择</option>
                                    <option v-for="(item,i) in addressTwo.area" :value="item.value" selected="true" v-text="item.text"></option>
                                </select>
    
                                <input type="text" v-model="data.s_address" class="input-text" style="width: auto;">
    
                            </div>
                        </div>
    
                </form>
    
                </div>
    
                <div class="modal-footer">
                    <button class="btn item-btn1" @click="modelHide()">取消</button>
                    <button class="btn btn-primary item-btn2" @click="modelCheck()">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="../../include_path/footer.tpl"}
{include file="./templateEditModel.tpl"}
{literal}
<script type="text/javascript">
    // 根据框架可视高度,减去现有元素高度,得出表格高度
    var Vheight = $(window).height()-56-42-16-56-16-($('.tb-tab').text()?70:0)
    $('.table-scroll').css('height',Vheight+'px')
    laydate.render({
        elem: '#startdate', //指定元素
        type: 'datetime'
    });
    laydate.render({
        elem: '#enddate',
        type: 'datetime'
    });
    
    function empty() {
        $("#r_time").val(1);
        $("#startdate").val('');
        $("#enddate").val('');
        $("#print_type").val('');
        $("#o_status").val('');
        $("#recipient").val('');
        $("#r_mobile").val('');
        $("#sNo").val('');
    }

    function print(){

        var num = $("#putnum").val();

        if(num < 1){
            layer.msg("请填写正确的打印数量！");
            return false;
        }

        var checkbox=$("input[name='id[]']:checked");//被选中的复选框对象
        if (checkbox.length < 1) {
            layer.msg("请选择至少一个订单进行打印！");
            return false;
        }
        var id = '';
        for(var i=0;i<checkbox.length;i++){
            id += checkbox.eq(i).val()+',';
        }

        $.ajax({
            type: "post",
            url: "index.php?module=invoice&action=creat_list&m=getdetails&id="+id,
            async: true,
            success: function (res) {
                var text = '';
                res = JSON.parse(res);
                // debugger
                if (res.code == 200) {
                    for (var n = 0; n < res.data.length; n++) {
                        var data = res.data[n];
                        text += `<div class="modal-content radius box-modal" id="print_content">
                        <div class="modal-header item-head">
                          <h3 class="modal-title item-title" style="width: 100%;text-align: center;">商品/宝贝发货单</h3>
                          <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                        </div>
                        <div style="width:919px;height:50px;background:rgba(240,242,244,1);display: flex;align-items: center;padding-left: 20px;">
                          订单编号： ${data.sNo}
                        </div>
                        <div class="modal-body">

                            <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
                                <div class="row">
                                  <label class="col-xs-4 col-sm-1">买家：</label>

                                  <span><input value="${data.r_uname}" class="col-sm-2 input-text radius" style="width: 161px;"></span>
                                  <span><input value="${data.r_userid}" class="col-sm-2 input-text radius" style="width: 161px;"></span>
                                  <span><input value="${data.recipient}" class="col-sm-2 input-text radius" style="width: 161px;"></span>
                                  <span><input value="${data.r_mobile}" class="col-sm-2 input-text radius" style="width: 161px;"></span>
                                  
                                </div>

                                <div class="row">
                                  <label class=" col-xs-2 col-sm-1">地址：</label>
								  
                                  <div class="col-10">
                                    <span>
                                      <input value="${data.r_sheng}${data.r_shi}${data.r_xian}${data.r_address}" class="input-text radius">
                                    </span>
                                  </div>
                                </div>
                            </form>
                        </div>
                        <div style="width:919px;height:6px;background:rgba(240,242,244,1);"></div>
                        <div style="margin: 20px 40px;">
                          <table class="table table-border table-bg table-bordered">
                            <thead>
                              <tr>
                                <th>序号</th>
                                <th>商品图片</th>
                                <th>商品名称</th>
                                <th>商品编码</th>
                                <th>规格</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>金额</th>
                              </tr>
                            </thead>
                            <tbody>`;

                            var hhh = '';
                            var z = 1;
                            for (var i = 0; i < data.goods.length; i++) {
                                hhh += `<tr>
                                    <td>${z}</td>
                                    <td>
                                      <img src="${data.goods[i].imgurl}" style="width:40px;height:40px"/>
                                    </td>
                                    <td style="width: 360px;">${data.goods[i].product_title}</td>
                                    <td>${data.goods[i].product_number}</td>
                                    <td>${data.goods[i].size}</td>
                                    <td>￥${data.goods[i].p_price}</td>
                                    <td style="text-align: center;">${data.goods[i].num}</td>
                                    <td>￥${data.goods[i].total}</td>
                                </tr>`;
                                z++;
                            }

                            text += hhh;

                            text += `</tbody>
                          </table>
                          <div style="display:flex;justify-content: space-between;padding-top: 14px;">
                            <div style="display:flex">
                              <div>买家留言：</div>
                              <div style="width: 520px;height: 72px;margin-left: 14px;">
                                <textarea name="textarea"  class="textarea radius" style="height: 72px;">${data.remark}</textarea>
                              </div>
                            </div>
                            <div style="width: 200px;display: flex;flex-direction: column;justify-content: space-between;">
                              <div style="display: flex;justify-content: space-between;">商品总数：<span>${data.num}件</span></div>
                              <div style="display: flex;justify-content: space-between;">商品总额：<span>￥${data.sum}</span></div>
                            </div>
                          </div>
                        </div>
                        <div style="width:919px;height:6px;background:rgba(240,242,244,1);"></div>
                        <div>
                          <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
                            <div class="row" style="margin-bottom: 15px;">
                              <label class="col-xs-4 col-sm-1" style="text-align: end;">卖家：</label>
                              <div class="col-xs-10 col-sm-10">
                                <span><input type="text" value="${data.sender}"/></span>
                                <span><input type="text" value="${data.s_id}"/></span>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer" style="display:flex;">
                          <span>谢谢您一如既往的支持小店，小店会继续努力！</span>
                          <span>打印时间： ${data.now}</span>
                        </div>
                      </div><div style="page-break-after: always;"></div>`;
                    }
                }
                // text += `<div style="page-break-after: always;"></div>`;
                var texts = '';
                for (var i = 0; i < num; i++) {
                    texts += text;
                }
                $('#print_html').append(texts);

                $("#modal-edit").modal("show");

                $("#print_html").jqprint();

                $('#print_html').html('');

                $("#modal-edit").modal("hide");

            }
        });
    }

    // 编辑框渲染
    var app = new Vue({
        el: '#app',
        data: {
            // 绑定数据
            data:{Select4:''},
            addressOne:{province:[],county:[],area:[]},
            addressTwo:{province:[],county:[],area:[]}
        },
        created:function(){
            // 打开模态框
            var url = "index.php?module=invoice&action=ajax&GroupID=0";
            var vm = this
            
            $.ajax({
                url:url,
                success: function(text) {
                    var strs = text.split("|"); 
                    for(var i=0; i<strs.length-1;i++){
                        var opp = strs[i].split(",")
                        var obj = { value:opp[1],text:opp[0] }
                        vm.addressOne.province.push(obj)
                        vm.addressTwo.province.push(obj)
                    }
                }
            })

        },
        methods:{
            openSwitch:function(event){
                var vm = this
                if(!this.data.isopen){
                    this.data.sender = this.data.pingtai.sender
                    this.data.s_mobile = this.data.pingtai.s_mobile
                    this.data.s_address = this.data.pingtai.s_address
                    this.data.Select4 = this.data.pingtai.p1
                    this.data.Select5 = this.data.pingtai.p2
                    this.data.Select6 = this.data.pingtai.p3

                    if(this.data.Select4){

                        var promise = new Promise(function(resolve,reject){
                            vm.getCountyData(vm.data.Select4,1,0)
                            resolve()
                        })
                        promise.then(function(){
                            vm.getAreaData(vm.data.Select5,1,0)
                        })
                         
                    }
                    return 
                }
                this.data.sender = this.data.mch.sender
                this.data.s_mobile = this.data.mch.s_mobile
                this.data.s_address = this.data.mch.s_address
                this.data.Select4 = this.data.mch.m1
                this.data.Select5 = this.data.mch.m2
                this.data.Select6 = this.data.mch.m3
                
                if(this.data.Select4){
                    var promise = new Promise(function(resolve,reject){
                        vm.getCountyData(vm.data.Select4,1,0)
                        resolve()
                    })
                    promise.then(function(){
                        vm.getAreaData(vm.data.Select5,1,0)
                    })
                    
                    
                }
                
            },
            setAddressOneCounty:function(arr,is){
                if(is != 0){
                    this.data.Select2 = ""
                    this.data.Select3 = ""
                }
                this.addressOne.county = []
                this.addressOne.area = []
                this.addressOne.county.push(...arr)
            },
            setAddressTwoCounty:function(arr,is){
                if(is != 0){
                    this.data.Select5 = ""
                    this.data.Select6 = ""
                }
                this.addressTwo.county = []
                this.addressTwo.area = []
                this.addressTwo.county.push(...arr)
            },
            getCountyData:function(id,is,ofs){
                
                var url = "index.php?module=invoice&action=ajax&GroupID=" + id;
                var vm = this
                $.ajax({
                    url:url,
                    success: function(text) {
                        var strs = text.split("|"); 
                        var arr = []
                        for(var i=0; i<strs.length-1;i++){
                            var opp = strs[i].split(",")
                            arr.push({ value:opp[1],text:opp[0] })
                        }
                        if(is === 0){
                            vm.setAddressOneCounty(arr,ofs)
                        } else {
                            vm.setAddressTwoCounty(arr,ofs)
                        }
                    }
                })
            },
            setAddressOneArea:function(arr,is){
                if(is != 0){
                    this.data.Select3 = ""
                }
                this.addressOne.area = []
                this.addressOne.area.push(...arr)
            },
            setAddressTwoArea:function(arr,is){
                if(is != 0){
                    this.data.Select6 = ""
                }
                this.addressTwo.area = []
                this.addressTwo.area.push(...arr)
            },
            getAreaData:function(id,is,ofs){
                var url = "index.php?module=invoice&action=ajax&GroupID=" + id;
                var vm = this
                $.ajax({
                    url:url,
                    success: function(text) {
                        var strs = text.split("|");
                        var arr = []
                        for(var i=0; i<strs.length-1;i++){
                            var opp = strs[i].split(",")
                            arr.push({ value:opp[1],text:opp[0] })
                        }

                        if(is === 0){
                            vm.setAddressOneArea(arr,ofs)
                        } else {
                            vm.setAddressTwoArea(arr,ofs)
                        }
                    }
                })
            },
            // 隐藏
            modelHide:function(){
                $('#modal-demo').modal('hide')
            },
            // 新增
            addsp:function(){
                this.data.goods.push({})
            },
            // 删除
            popsp:function(index){
                if(this.data.goods.length === 1){
                    return 
                }

                var d_sNo = this.data.d_sNo
                d_sNo = d_sNo.split(',')
                d_sNo.splice(index,1)
                this.data.d_sNo = d_sNo.join(',')
                this.data.goods.splice(index,1)

                if(this.data.goods.length === 1){
                    $(".bb-btn").css('display','none')
                }
            },
            getAddressOne:function(){
                let { Select1, Select2, Select3 } = this.data
                for(let item of this.addressOne.province){
                    if(item.value == Select1){
                        this.data.r_sheng = item.text
                        break;
                    }
                }

                for(let item of this.addressOne.county){
                    if(item.value == Select2){
                        this.data.r_shi = item.text
                        break;
                    }
                }

                for(let item of this.addressOne.area){
                    if(item.value == Select3){
                        this.data.r_xian = item.text
                        break;
                    }
                }
            },
            getAddressTwo:function(){
                let { Select4, Select5, Select6 } = this.data
                for(let item of this.addressTwo.province){
                    if(item.value == Select4){
                        this.data.s_sheng = item.text
                        break;
                    }
                }

                for(let item of this.addressTwo.county){
                    if(item.value == Select5){
                        this.data.s_shi = item.text
                        break;
                    }
                }

                for(let item of this.addressTwo.area){
                    if(item.value == Select6){
                        this.data.s_xian = item.text
                        break;
                    }
                }

            },
            // 保存
            setAddress:function(callback){
                let {Select1,Select2,Select3,Select4,Select5,Select6} = this.data
                this.data.r1 = Select1
                this.data.r2 = Select2
                this.data.r3 = Select3

                this.data.s1 = Select4
                this.data.s2 = Select5
                this.data.s3 = Select6

                this.getAddressOne()
                this.getAddressTwo()

            },
            modelCheck:function(){
                this.setAddress()
                
                if (this.data.isopen) {
                    this.data.isopen = 1;
                }else{
                    this.data.isopen = 0;
                }

                $.ajax({
                    type: "post",
                    url: "index.php?module=invoice",
                    async: true,
                    data: this.data,
                    success: function (res) {
                        console.log(res);
                        layer.msg("编辑成功！");
                        $('#modal-demo').modal('hide');
                        location.reload();
                    }
                });


                
                
            }
        }
    })
    
    // 编辑
    function edit(id){

        $.ajax({
            type: "post",
            url: "index.php?module=invoice&action=creat_list&m=getedit&id=" + id,
            async: true,
            success: function (res) {
                
                var res = JSON.parse(res)
                if(res.code === 200){
                    console.log(res.data);
                    for(var i = 0;i < 6;i++){
                        res.data['Select' + (i+1)] = ''
                    }

                    res.data['saddress'] = ''
                    res.data['faddress'] = ''
                    if(res.data.isopen === '0'){
                        res.data.isopen = false
                    }

                    app.data = res.data

                    $('#modal-demo').modal('show');

                    res.data.Select1 = res.data.r1;
                    res.data.Select2 = res.data.r2;
                    res.data.Select3 = res.data.r3;
                    
                    res.data.Select4 = res.data.s1;
                    res.data.Select5 = res.data.s2;
                    res.data.Select6 = res.data.s3;

                    if(res.data.Select4){
                        var promise = new Promise(function(resolve,reject){
                            app.getCountyData(res.data.Select4,1,0)
                            resolve()
                        })

                        promise.then(function(){
                            app.getAreaData(res.data.Select5,1,0)
                        })
                        
                        
                    }

                    if(res.data.Select1){

                        var promise = new Promise(function(resolve,reject){
                            app.getCountyData(res.data.Select1,0,0)
                            resolve()
                        })

                        promise.then(function(){
                            app.getAreaData(res.data.Select2,0,0)
                        })
                    }
                }

            }
        });
    }

</script>
{/literal}
</body>
</html>