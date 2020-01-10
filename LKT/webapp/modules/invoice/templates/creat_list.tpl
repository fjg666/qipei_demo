<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-08-26 09:09:11
 * @LastEditTime: 2019-09-03 09:34:13
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

    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/flex.css" rel="stylesheet">
    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/model.dd.css" rel="stylesheet" type="text/css">
    <script src="style/js/jquery.js"></script>
    {literal}
        <style type="text/css">
            .center {
                text-align: center !important;
            }

            .ul1,
            .ul2,
            .ul3 {
                padding: 0px 20px;
            }

            .ul1 li,
            .ul2 li,
            .ul3 li {
                float: left;
                height: 60px;
                line-height: 60px;
                color: #888f9e;
                font-size: 14px;
                
            }
            .ul2 li input{border: 1px solid #ddd;padding: 0 14px;height: 36px;}
            .ul2 li input:hover{border: 1px solid #3BB4F2;}

            .grText {
                color: #414658;
                font-size: 14px;
            }

            .ulTitle {
                height: 50px;
                line-height: 50px;
                text-align: left;
                font-size: 16px;
                color: #414658;
                font-weight: 600;
                font-family: "微软雅黑";
                margin-bottom: 0px;
                /*margin-top: 20px;*/
                margin-left: 20px;
                margin-right: 20px;
                border-bottom: 1px solid #d9d9d9;
                /* padding: 0 20px 0 20px; */
            }

            table th {
                border-bottom: none;
                background-color: #fff;
            }

            table {
                width: 95%;
                margin: 20px auto;
                border: 1px solid #eee !important;

            }

            tr {
                border: 1px solid #fff;
            }

            .table td, .table th {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #fff;
            }

            .order-item {
                border: 1px solid transparent;
                margin-bottom: 1rem;
            }

            .order-item table {
                margin: 0;
            }

            .order-item:hover {
                border: 1px solid #3c8ee5;
            }

            .goods-item {
                margin-bottom: .75rem;
            }

            .goods-item:last-child {
                margin-bottom: 0;
            }

            .goods-name {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .status-item.active {
                color: inherit;
            }

            .badge {
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem
            }

            .badge:empty {
                display: none
            }

            .btn .badge {
                position: relative;
                top: -1px
            }

            a.badge:focus,
            a.badge:hover {
                color: #fff;
                text-decoration: none;
                cursor: pointer
            }

            .badge-pill {
                padding-right: .6em;
                padding-left: .6em;
                border-radius: 10rem
            }

            .badge-default {
                background-color: #636c72
            }

            .badge-default[href]:focus,
            .badge-default[href]:hover {
                background-color: #4b5257
            }

            .badge-primary {
                background-color: #0275d8
            }

            .badge-primary[href]:focus,
            .badge-primary[href]:hover {
                background-color: #025aa5
            }

            .badge-success {
                background-color: #5cb85c
            }

            .badge-success[href]:focus,
            .badge-success[href]:hover {
                background-color: #449d44
            }

            .badge-info {
                background-color: #5bc0de
            }

            .badge-info[href]:focus,
            .badge-info[href]:hover {
                background-color: #31b0d5
            }

            .badge-warning {
                background-color: #f0ad4e
            }

            .badge-warning[href]:focus,
            .badge-warning[href]:hover {
                background-color: #ec971f
            }

            .badge-danger {
                background-color: #d9534f
            }

            .badge-danger[href]:focus,
            .badge-danger[href]:hover {
                background-color: #c9302c
            }

            .mask {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;

            }

            a:hover {
                color: red;
                text-decoration: none;
            }

            .table-bordered th, .table-bordered td {
                border: none;
                text-align: center;
                vertical-align: middle;
            }

            .txc th {
                text-align: center;
            }

            .imgTd img {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }

            table {
                vertical-align: middle;

            }

            td a {
                float: left;
                width: 100% !important;

            }

            .maskLeft {
                width: 30%;
                float: left;
                text-align: right;
                padding-right: 20px;
                height: 36px;
                line-height: 36px;
            }

            .maskRight {
                width: 70%;
                float: left;
            }

            .ipt1 {
                padding-left: 10px;
                width: 300px;
                height: 36px;
                border: 1px solid #eee;
            }

            .wl_maskNew {
                position: fixed;
                z-index: 9999999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                display: block;
            }

            .wl_maskNewContent {
                width: 500px;
                height: 519px;
                margin: 0 auto;
                position: relative;
                top: 200px;
                background: #fff;
                border-radius: 10px;
            }

            .dc {
                position: fixed;
                z-index: 999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                display: block;
            }

            .table td, .table th {
                vertical-align: middle;
            }

            .tr_xhx {
                border-bottom: 2px solid #cccccc;
            }

            .butten_o {
                width: 112px;
                height: 36px;
                background: inherit;
                background-color: rgba(16, 142, 233, 1);
                border: none;
                border-radius: 4px;
                -moz-box-shadow: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                font-family: 'MicrosoftYaHei', 'Microsoft YaHei';
                font-weight: 400;
                font-style: normal;
                font-size: 14px;
                color: #FFFFFF;
                text-align: center;
                line-height: 36px;
                margin-top: 20px;
            }
            
            .butten_o:hover{background-color: #2481E5;}
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
    <title>生成发货单</title>
</head>
<body style="width: 100%;">
{include file="../../include_path/nav.tpl" sitename="面包屑"}
    <section class="rt_wrap pd-20" style="margin-bottom: 0;background-color: white;">
        <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <input type="hidden" id="ids" value="{$ids}">
            <div style="background-color: #fff;" id="printPage">
                <p class="ulTitle">生成发货单</p>
                <!-- <div style="page-break-after:always;"></div> -->
                <table class="table" style="width: 98%">
                    <tr>
                        <th class="center tr_xhx">商品信息</th>
                        <th class="center tr_xhx">数量</th>
                        <th class="center tr_xhx">收件信息</th>
                        <th class="center tr_xhx">寄件人</th>
                        <th class="center tr_xhx">打印状态</th>
                        <th class="center tr_xhx">备注</th>
                        <th class="center tr_xhx">操作</th>
                    </tr>
                    {foreach from=$goods item=item name=f1}
                        <tr>
                            <td>{$item->title}</td>
                            <td class="center">{$item->num}</td>
                            <td class="center">
                                <span class="grText">
                                    {$item->recipient}  {$item->r_mobile}<br />
                                    {$item->r_address}
                                </span>
                            </td>
                            <td class="center"><span class="grText">{$item->sender}</span></td>
                            <td class="center"><span class="grText">{if $item->status==0}未打印{else}已打印{/if}</span></td>
                            <td class="center"><span class="grText">{if $item->remark==' '}无{else}{$item->remark}{/if}</span></td>
                            <td class="tab_dat">
                                <div class="hover_a" onclick="edit({$item->id})" title="编辑" style="border: none!important;">
                                    <img style="margin-top: -3px;" src="images/icon1/xg.png"/>&nbsp;编辑
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                </table>

            </div>


            
            <div style="position: fixed;bottom: 0;background-color: #fff;width: 100%;">
                <a style="margin-left: 60px;float: left;padding-top: 30px;color: #108ee9;" href="index.php?module=invoice&action=template&type=1">模版管理</a>
                <div style="margin-left: 60px;float: left;padding-top: 24px;">打印份数设置：<input type="number" id="putnum" value="1">份</div>
                <div style="float:  right;margin-right: 60px;width: 112px;">
                    <!-- <button onclick="location='index.php?module=invoice&action=creat_list&r_sNo={$goods[0]->r_sNo}'" style="border: 1px solid #2481E5;background-color: #fff;color: #2481E5;" type="button" class="butten_o">生成发货单</button> -->
                    <button onclick="print()" type="button" class="butten_o">生成发货单</button>
                </div>
                <div style="clear: both;height: 20px;"></div>
            </div>
            <!-- 分销商信息 -->

            <div class="page_h20"></div>
        
        </form>
    </section>
<div id="app">







<div id="modal-demo" class="modal felxx" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="z-index: 10000;height:100%;max-width: 920px;box-shadow:0 0px 0px 0px rgba(0, 0, 0, 0);display:flex;">
        <div class="modal-content radius box-modal">

            <div class="modal-header item-head">
                <h3 class="modal-title item-title">编辑订单</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>

            <div class="modal-body">

            <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" >

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

                            <select id="Select1" v-model="data.Select1" onchange="selectCity();">
                                <option value="" selected="true">省/直辖市</option>
                            </select>

                            <select id="Select2" v-model="data.Select2" onchange="selectCountry()">
                                <option value="" selected="true">请选择</option>
                            </select>

                            <select id="Select3" v-model="data.Select3" >
                                <option value="" selected="true">请选择</option>
                            </select>

                            <input type="text"  v-model="data.saddress" value="" class="input-text" style="width: auto;">
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
                      
                      <div style="margin-left: 148px;height: 150px;overflow: auto;" >
                          <div class="col-xs-4 col-sm-10" style="display: flex;" id="items" v-for="(item,index) in data.goods" :key="index" >
                                
                            <span>
                                <select id="pet-select">
                                    <option v-for="(item2,index2) in data.goods" :key="index2" v-model="item2.id" v-text="item2.p_name"></option>
                                </select>
                            </span>

                            <span>
                                <input type="text" placeholder="商品编号" v-model="item.product_number" size="10"/>
                            </span>
                            <span>
                                <input type="text" placeholder="规格/属性" v-model="item.size" size="10"/>
                            </span>
                            <span>
                                <input type="text" placeholder="单价" v-model="item.p_price" size="10"/>
                            </span>
                            <span>
                                <input type="text" placeholder="数量" v-model="item.num" size="10"/>
                            </span>
                            <span class="bb-btn">
                                <div @click="popsp(index)">-</div>
                                <!-- <div @click="addsp()">+</div> -->
                            </span>
                          </div>

                      </div>
                  </div>

                  <div class="row" style="margin-left: 3px;">
                      <label class=" col-xs-4 col-sm-2">平台代发：</label>
                      <div class="col-xs-4 col-sm-4">
                          <input  class="switch" type="checkbox" value="1" v-model="data.isopen" style="height:24px !important;visibility: initial;"/>
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

                            <select id="Select4" v-model="data.Select4" onchange="selectCity2();">
                                <option value="" selected="true">省/直辖市</option>
                            </select>

                            <select id="Select5" v-model="data.Select5" onchange="selectCountry2()">
                                <option value="" selected="true">请选择</option>
                            </select>

                            <select id="Select6" v-model="data.Select6" >
                                <option value="" selected="true">请选择</option>
                            </select>

                            <input type="text" v-model="data.address" value="" class="input-text" style="width: auto;">

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
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<!-- 打印 -->
<script type="text/javascript" src="style/js/jquery.jqprint-0.3.js"></script>
<script type="text/javascript" src="style/js/jquery-migrate-1.2.1.min.js"></script>
<!-- 打印end -->

{include file="./templateEditModel.tpl"}
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">

var app = new Vue({
    el: '#app',
    data: {
        // 绑定数据
        data:{}
    },
    created:function(){
        // 打开模态框
    },
    methods:{
        modelHide:function(){
            console.log('隐藏')
            $('#modal-demo').modal('hide')
        },
        // 新增
        addsp:function(){
            this.data.goods.push({})
        },
        // 删除
        popsp:function(index){
            this.data.goods.splice(index,1)
        },
        // 保存
        modelCheck:function(){
            console.log(this.data)
        }
    }
})
    function edit(id){
        $.ajax({
            type: "post",
            url: "index.php?module=invoice&action=creat_list&m=getedit&id=" + id,
            async: true,
            success: function (res) {
                var res = JSON.parse(res)
                if(res.code === 200){
                    

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
                }

            }
        });
        
    }
    // 打印
    
    function print(){
        var num = $("#putnum").val();
        var id = $("#ids").val();

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
                        text += `<div class="modal-content radius box-modal" style="height:642px;" id="print_content">
                        <div class="modal-header item-head">
                          <h3 class="modal-title item-title" style="width: 100%;text-align: center;">商品/宝贝发货单</h3>
                          <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                        </div>
                        <div style="width:919px;height:50px;background:rgba(240,242,244,1);">
                          订单编号： ${data.sNo}
                        </div>
                        <div class="modal-body">

                            <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >

                                <div class="row">
                                  <label class=" col-xs-4 col-sm-2">买家：</label>
                                  <span><input value="${data.r_uname}" class="col-sm-2 input-text radius"></span>
                                  <span><input value="${data.r_userid}" class="col-sm-2 input-text radius"></span>
                                  <span><input value="${data.recipient}" class="col-sm-2 input-text radius"></span>
                                  <span><input value="${data.r_mobile}" class="col-sm-2 input-text radius"></span>
                                </div>

                                <div class="row">
                                  <label class=" col-xs-2 col-sm-2">地址：</label>
                                  <div class="col-xs-4 col-sm-4">
                                    <span>
                                      <input value="${data.r_address}" class="input-text radius">
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
                                    <td>${data.goods[i].product_title}</td>
                                    <td>${data.goods[i].product_number}</td>
                                    <td>${data.goods[i].size}</td>
                                    <td>￥${data.goods[i].p_price}</td>
                                    <td>${data.goods[i].num}</td>
                                    <td>￥${data.goods[i].total}</td>
                                </tr>`;
                                z++;
                            }

                            text += hhh;

                            text += `</tbody>
                          </table>
                          <div style="display:flex;justify-content: space-between;">
                            <div style="display:flex">
                              <div>买家留言：</div>
                              <div style="width: 520px;height: 72px;margin-left: 14px;">
                                <input type="text" value="${data.remark}" class="textarea radius" style="height: 72px;">
                              </div>
                            </div>
                            <div style="width: 200px;">
                              <div style="display: flex;justify-content: space-between;">商品总数：<span>${data.num}件</span></div>
                              <div style="display: flex;justify-content: space-between;">商品总额：<span>￥${data.sum}</span></div>
                            </div>
                          </div>
                        </div>
                        <div style="width:919px;height:6px;background:rgba(240,242,244,1);"></div>
                        <div>
                          <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
                            <div class="row">
                              <label class="col-xs-4 col-sm-2">卖家：</label>
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
                      </div>`;
                    }
                }
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
  

    $(function(){
        Init();
        Init2()
    })
    function Init2(){
        var   dropElement4 = document.getElementById("Select4"); 
        var   dropElement5 = document.getElementById("Select5"); 
        var   dropElement6 = document.getElementById("Select6");

        RemoveDropDownList(dropElement4);
        RemoveDropDownList(dropElement5);
        RemoveDropDownList(dropElement6);
        
        var country;
        var province;
        var city;
        var url = "index.php?module=invoice&action=ajax&GroupID=0";

        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;i++)
                {
                    var opp = new Array(); 
                    opp = String(strs[i]).split(","); 
                    var eOption = document.createElement("option");   
                    eOption.value = opp[1];
                    eOption.text = opp[0];
                    dropElement4.add(eOption);
                }
                if ($("#Select5").val().length > 0) {
                    selectCity2();
                }
            }
        });
    }

    function Init(){
      var   dropElement1=document.getElementById("Select1"); 
      var   dropElement2=document.getElementById("Select2"); 
      var   dropElement3=document.getElementById("Select3");

      RemoveDropDownList(dropElement1);
      RemoveDropDownList(dropElement2);
      RemoveDropDownList(dropElement3);
      var country;
      var province;
      var city;
      var url = "index.php?module=invoice&action=ajax&GroupID=0";
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;i++)
                {
                    var opp= new Array(); 
                    opp=String(strs[i]).split(","); 
                    var   eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement1.add(eOption);
                }
                if ($("#Select2").val().length > 0) {
                    selectCity();
                }
            }
        });
    }

    function selectCity(){
      var   dropElement1=document.getElementById("Select1"); 
      var   dropElement2=document.getElementById("Select2"); 
      var   dropElement3=document.getElementById("Select3"); 
      var   name=dropElement1.value;

      RemoveDropDownList(dropElement2);
      RemoveDropDownList(dropElement3);

      if(name!=""){

        var url = "index.php?module=invoice&action=ajax&GroupID="+name;
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;   i++){
                    var opp= new Array(); 
                    opp = String(strs[i]).split(","); 

                    var eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement2.add(eOption);
                }
                if ($("#Select3").val().length > 0) {
                    selectCountry();
                }
            }
        });
      }
    }

    function selectCity2(){
        var dropElement4 = document.getElementById("Select4"); 
        var dropElement5 = document.getElementById("Select5"); 
        var dropElement6 = document.getElementById("Select6"); 
        var name = dropElement4.value;

        RemoveDropDownList(dropElement5);
        RemoveDropDownList(dropElement6);

        if(name!=""){

            var url = "index.php?module=invoice&action=ajax&GroupID="+name;
            $.ajax({
                url:url,
                success: function(text) {

                    var strs= new Array(); 
                    strs=text.split("|"); 
                    
                    for(var i=0; i<strs.length-1;   i++){
                        var opp= new Array(); 
                        opp = String(strs[i]).split(","); 

                        var eOption=document.createElement("option");   
                        eOption.value=opp[1];
                        eOption.text=opp[0];
                        dropElement5.add(eOption);
                    }
                    
                    if ($("#Select6").val().length > 0) {
                        selectCountry2();
                    }
                }
            });
        }
    } 

    function selectCountry(){
      var   dropElement1=document.getElementById("Select1"); 
      var   dropElement2=document.getElementById("Select2"); 
      var   dropElement3=document.getElementById("Select3"); 
      var   name=dropElement2.value;

      RemoveDropDownList(dropElement3);

      if(name!=""){

        var url = "index.php?module=invoice&action=ajax&GroupID="+name;
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;i++){
                    var opp= new Array(); 
                    opp=String(strs[i]).split(","); 
                    var   eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement3.add(eOption);
                }
            }
        });
      }
    }

    function selectCountry2(){
      var   dropElement4=document.getElementById("Select4"); 
      var   dropElement5=document.getElementById("Select5"); 
      var   dropElement6=document.getElementById("Select6"); 
      var   name=dropElement5.value;

      RemoveDropDownList(dropElement6);

      if(name!=""){

        var url = "index.php?module=invoice&action=ajax&GroupID="+name;
        $.ajax({
            url:url,
            success: function(text) {
                var strs= new Array(); 
                strs=text.split("|"); 
                for(var i=0; i<strs.length-1;i++){
                    var opp= new Array(); 
                    opp=String(strs[i]).split(","); 
                    var   eOption=document.createElement("option");   
                    eOption.value=opp[1];
                    eOption.text=opp[0];
                    dropElement6.add(eOption);
                }
            }
        });
      }
    }

    function RemoveDropDownList(obj){   
        if(obj){
            var   len=obj.options.length;   
            if(len>0){  
                for(var i=len;i>=1;i--){   
                    obj.remove(i);   
                }
            }
        }
    }
</script>
{/literal}


</body>


</html>
