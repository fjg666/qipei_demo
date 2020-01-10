
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />

<link rel="stylesheet" type="text/css" href="style/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="style/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css" />
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
<title>添加活动</title>
{literal}
<style type="text/css">
    body{background-color: #edf1f5;height: 100vh;}
  　　　/*隐藏掉我们模型的checkbox*/
    .my_protocol .input_agreement_protocol {
                appearance: none;
                -webkit-appearance: none;
                outline: none;
                display: none;
            }
    /*未选中时*/        
   .my_protocol .input_agreement_protocol+span {
                width: 16px;
                height: 16px;
                background-color: red;
                display: inline-block;
                background: url(../../Images/TalentsRegister/icon_checkbox.png) no-repeat;
                background-position-x: 0px;
                background-position-y: -25px;
                position: relative;
                top: 3px;
            }
   /*选中checkbox时,修改背景图片的位置*/            
   .my_protocol .input_agreement_protocol:checked+span {
                background-position: 0 0px
            }       
            .inputC:checked +label::before{
                top: -3px;
                position: relative;
            }

    #addpro{
        background: #ccc;
        padding: 20px;
        border-radius: 4px;
    }
    .protitle{
        overflow: hidden;
    }
    .barginprice{
        border-radius: 5px;
        width: 120px;
    }
    .redport{
       border:2px red solid;
    }
    .sysyattr{
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 9999;
      background: rgba(0,0,0,0.5);

    }
    .sysyattr_div{
      width: 100%;
      height: 100%;
      display:flex;
    }
    .sys_c{
      width:70%;
      height: 70%;
      margin:auto;
      background: white;
      border-radius: 20px;
    }
    .modalshow{
      display: none;
    }
    .modaltitle{
      padding:10px;
       width:100%;
       height:7%;
    }
    .breadcrumb{padding: 0;margin: 0;margin-left: 10px;background-color: #edf1f5;}     
    #form-category-add{padding:0 14px;}
    .text-c th{border: none;border-top: 1px solid #E9ECEF!important;vertical-align:middle!important;}  
    .text-c td{border: none;border-bottom: 1px solid #E9ECEF!important;vertical-align:middle;}
        .text-c th:first-child{border-left: 1px solid #E9ECEF!important;}
        .text-c th:last-child{border-right: 1px solid #E9ECEF!important;}
        .text-c td:first-child{border-left: 1px solid #E9ECEF!important;}
        .text-c td:last-child{border-right: 1px solid #E9ECEF!important;}
        .text-c input{border: 1px solid #E9ECEF;margin: auto;padding: 2px 10px;}

    .ra1{
        /*width: 8%!important;*/
        float: left;
    }
    .ra1 label{
        width: 100px!important;
        padding-left: 20px;
        margin: auto;
        height: 36px;
        display: block;
        line-height: 36px;
    }
    input[type=text],.select{
      width: 190px;padding-left: 10px;
    }
    .fo_btn2{
      margin-right: 10px!important;
      color: #fff!important;
      background-color: #2890FF!important;
      border: 1px solid #fff;
      float: right;
      display: block;
      margin: 16px 0;
      width: 112px!important;
    }
    .inputC:checked + label::before {
      display: -webkit-inline-box;
    }
    .tab_label{padding-left: 15px!important;border-left: 1px solid #E9ECEF!important;}
    .scrolly{
      height: 300px;
      overflow-y: scroll;
    }
    .addText{
      color: rgb(151, 160, 180);
      margin-left: 10px;
      font-size: 14px !important;
    }
</style>
{/literal}
</head>
<body>
  {include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe6ca;</i>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=auction&action=Index';">竞拍 </a>
    <span class="c-gray en">&gt;</span>
    编辑竞拍商品
</nav>
<div id="addpro" class="pd-20" style="background-color: white;">
    <p style="font-size: 15px;" class="page_title">编辑竞拍商品</p>

    <form name="form1" id="form1" class="form form-horizontal" style="padding: 0px!important;" method="post" enctype="multipart/form-data" >
    

      <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">已选商品：</label>
          <div class="formControls col-10">
             <div class="tabCon1">
               <div class="mt-20" id="prolist">
                  <table class="table table-border table-bordered table-bg table-hover" style="margin:0 auto;border: 0;">
                    <thead>
                      <tr class="text-c">    
                        <th>序号</th>
                        <th>商品名称</th>
                        <th>商家名称</th>
                        <th>库存</th>
                        <th>库存预警值</th>
                        <th>零售价</th>                                     
                      </tr>
                    </thead>
                    <tbody id="proattr">

                      <tr class="text-c" style="height:60px!important;">
                        <td>001</td>
                        <td>
                          <img src="{$imgurl}" style="width: 40px;height:40px;"/>
                        
                          <p style="display: inline-block;"> {$product_title} {$attr}</p>
                        </td>
                        <td>{$mch_name}</td>
                        <td>{$num}</td>
                        <td>{$min_inventory}</td>
                        <td>{$price}</td>
                      </tr>
                     
                    </tbody>
                 </table>
              </div>
         </div>

          </div>
      </div> 
  
        <input type="hidden" name="id" value="{$id}">
        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">竞拍标题：</label>
            <div class="formControls col-10">
               <input type="text" name="title" value="{$title}">
               <span class="addText" ">（未填写竞拍标题则默认为商品标题）</span>
            </div>
        </div>
         <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">竞拍起拍价：</label>
            <div class="formControls col-10">
               <input type="text" name="price" value="{$start_price}" {if $status == 1 }disabled="disabled" style="background-color: rgb(248, 248, 248) !important;" {/if}>
            </div>
        </div>
        <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">加价幅度：</label>
            <div class="formControls col-10">
               <input type="text" name="add_price" value="{$add_price}" >
            </div>
        </div>
        <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">保证金：</label>
          <div class="formControls col-10">
            <input type="text" name="promise" value="{$promise}" {if $status == 1 }disabled="disabled" style="background-color: rgb(248, 248, 248) !important;" {/if}>
          </div>
        </div>
       <div class="form_li formListSD row cl">
                <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">显示标签：</label>
              <div class="form_new_r" style="padding-left: 16px;">{$sp_type}</div>
       </div>
        <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">是否显示：</label>
          <div class="formControls col-10"style="padding-left: 16px;">
            <div class="ra1" >
                <input  style="display: none;" class="inputC1" type="radio" name="is_show" id="see_1" value="1" {if $is_show == 1}checked="checked"{/if}>
                <label for="see_1">是</label>
            </div>
            <div class="ra1">
                <input  style="display: none;" class="inputC1" type="radio" name="is_show" id="see_2" value="0" {if $is_show === '0' }checked="checked"{/if} >
                <label for="see_2">否</label>
            </div>
          </div>
        </div>
        <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;">竞拍活动时间：</label>
          <div class="formControls col-10">
            <div style="display: inline-block;">
                  <input type="text" class="input-text" {if $status == 1 }disabled="disabled" style="background-color: rgb(248, 248, 248) !important;" {/if} value="{$starttime}" placeholder="请输入开始时间"  autocomplete="off" id="starttime" name="starttime">
            </div>至
            <div style="display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="{$endtime}" placeholder="请输入结束时间"  autocomplete="off" id="endtime" name="endtime">
            </div>
          </div>
        </div>
         <div class="page_h10" style="height: 70px!important;"></div>

         <div class="page_h10" style="height: 88px!important;width: 100%;position: sticky;bottom: 0;border-top: 1px solid rgba(180, 180, 180, 0.4);padding-top: 12px;margin-top:100px;background-color: #fff;z-index: 9999;">
                <input class="fo_btn2" type="button" name="Submit" value="保存" onclick="check()">
                <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
                <!-- <button class="btn btn-secondary radius" type="reset" name="reset"><i class="Hui-iconfont">&#xe632;</i> 重 写</button> -->
         </div>
    </form>
    
</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}
 
<script type="text/javascript">
{/literal}
var status = '{$status}'
{literal}
//ajax请求--获取竞拍商品列表

     
//ajax请求--添加竞拍商品
function check() {

    //时间合理判断
    var starttime = $('input[name=starttime]').val();
    var endtime = $('input[name=endtime]').val();
    if(starttime == ''|| endtime == ''){

        layer.msg('时间不能为空！',{time:2000});
        
    }

    var start = new Date(starttime).getTime();
    var end = new Date(endtime).getTime();
    var now = new Date().getTime();
    var regPos = /^\d+(\.\d+)?$/; //非负浮点数
    if(status != 1){
         //金额判断
        let price  = $("input[name='price']").val();
        let add_price  = $("input[name='add_price']").val();
        let promise  = $("input[name='promise']").val();
        if(!regPos.test(price)){
          layer.msg('竞拍起拍价要为数字',{time:2000});
          return false;

        }else if(!regPos.test(add_price)){
          layer.msg('竞拍加价要为数字',{time:2000});
          return false;

        }else if(!regPos.test(promise)){
          layer.msg('竞拍押金要为数字',{time:2000});
          return false;

        }
        if(start + 60000 < now ){//选择现在时间推后60秒

          layer.msg('开始时间不能小于当前时间！');
          return false;
        }
        if(start > end){
          layer.msg('开始时间不能大于结束时间！');
          return false;
        }
    }else{
        let add_price  = $("input[name='add_price']").val();
        if(!regPos.test(add_price)){
          layer.msg('竞拍加价价要为数字',{time:2000});
          return false;

        }
        if(end < now ){
            layer.msg('结束时间不能小于当前时间！');
            return false;
        }
        if(start == end){
          layer.msg('结束时间要大于开始时间！');
          return false
        }
    }
   
   
    
    
   
    $.ajax({
    cache: true,
    type: "POST",
    dataType:"json",
    url:'index.php?module=auction&action=Modify',
    data:$('#form1').serialize(),// 你的formid
    async: true,
    success: function(data) {

      layer.msg(data.status,{time:2000});
      if(data.suc){
        location.href="index.php?module=auction";
      }
    }
  });
}


document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}

//日历插件
 laydate.render({
  elem:'#starttime',
     trigger: 'click',
  type:'datetime'
 });
 laydate.render({
  elem:'#endtime',
    trigger: 'click',
  type:'datetime'
 });





</script>

{/literal}
</body>
</html>