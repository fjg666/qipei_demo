
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
	
	#proattr td{
		height: 61px;
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
    添加竞拍商品
</nav>
<div id="addpro" class="pd-20 form-scroll" style="background-color: white;">
    <p style="font-size: 16px;color: rgba(65,70,88,1);z-index:99999;" class="page_title">添加竞拍商品</p>
    <form name="form1" id="form1" class="form form-horizontal" style="padding: 0px!important;" method="post" enctype="multipart/form-data" >
      <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>选择竞拍商品：</label>
          <div class="formControls col-10">
             <select name="class" class="select" style="background-color: #ffffff">
                  {$class}
                  <option value="" selected="selected" >请选择商品分类</option>
             </select>
             <select name="brand" class="select" style="background-color: #ffffff">
                   <option value="" >请选择品牌</option>
             </select>
            <input type="text" name="p_name" value="" placeholder="请输入商品名称">
			<input type="button" value="重置" id="btn8" class="reset" style="color: #6A7076;" onclick="empty()" />
            <input  id="my_query" class="btn btn-success" type="button" style="margin-left: 5px;background-color: #2890ff!important;border-color:#2890ff!important;" onclick="get_product()" value="查询">
          </div>
      </div>

      <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;"></label>
          <div class="formControls col-10">
             <div class="tabCon1">
               <div class="mt-20" id="prolist" style='height: 300px;'>
                  <table class="table table-border table-bordered table-bg table-hover table-scroll" style="margin:0 auto;border: 0;height: auto;">
                    <thead>
                      <tr class="text-c">
                        <th></th>                 
                        <th>序号</th>
                        <th>商品名称</th>
                        <th>商家名称</th>
                        <th>库存</th>
                        <th>库存预警值</th>
                        <th>零售价</th>                                     
                      </tr>
                    </thead>
                    <tbody id="proattr">
                     
                    </tbody>
                 </table>
              </div>
         </div>

          </div>
      </div> 
  

        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px!important;">竞拍标题：</label>
            <div class="formControls col-10">
               <input type="text" name="title" value="">
               <span class="addText">（未填写竞拍标题则默认为商品标题）</span>
            </div>
        </div>
         <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>竞拍起拍价：</label>
            <div class="formControls col-10" style="padding-left: -11px;float: left;">
               <input type="text" name="price" value="">
               <input type="hidden" name="">
            </div>
        </div>
        <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>加价幅度：</label>
            <div class="formControls col-10">
               <input type="text" name="add_price" value="">
            </div>
        </div>
        <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>保证金：</label>
          <div class="formControls col-10">
            <input type="text" name="promise" value="">
          </div>
        </div>
       <div class="form_li formListSD row cl">
                <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;margin-right: 14px;">显示标签：</label>
              <div class="form_new_r" style="margin-top: -4px;padding-left: 3px;">
               {$sp_type}
              </div>
       </div>
        <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;">是否显示：</label>
          <div class="formControls col-10" style="margin-top: -4px;padding-left: 17px;">
            <div class="ra1">
                <input style="display: none;" class="inputC1" type="radio" name="is_show" id="see_1" value="1" checked="checked">
                <label for="see_1">是</label>
            </div>
            <div class="ra1">
                <input style="display: none;" class="inputC1" type="radio" name="is_show" id="see_2" value="0">
                <label for="see_2">否</label>
            </div>
          </div>
        </div>
        <div class="row cl">
          <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>竞拍活动时间：</label>
          <div class="formControls col-10">
            <div style="display: inline-block;">
                  <input type="text" class="input-text" value="" placeholder="请输入开始时间"  autocomplete="off" id="starttime" name="starttime">
            </div>至
            <div style="display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="" placeholder="请输入结束时间"  autocomplete="off" id="endtime" name="endtime">
            </div>
          </div>
        </div>
		<div style='height: 100px;'></div>
        <div class="page_h10 page_bort">
                <input class="fo_btn2 btn-right" type="button" name="Submit" value="保存" onclick="check()">
                <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
             
        </div>
    </form>
     
</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}
 
<script type="text/javascript">

 //复选框唯一限制函数
function check_one(i){
 
  if($("input[id="+i+"]").prop("checked")==true){
      $("input[id!="+i+"][name='id[]']").removeAttr("checked");
  }
}

window.onload = function(){
  //一进入页面进行一次请求
  get_product()
  
}
//重置处理
function empty(){
	$('select[name=brand]').val("")
	$('select[name=class]').val("")
	$('input[name=p_name]').val("")
}
 //ajax请求--获取竞拍商品列表

function get_product(){
  var my_brand = $('select[name=brand] option:selected').val()
  var my_class = $('select[name=class] option:selected').val()
  var pro_name =$('input[name=p_name]').val()
  
 
  $.ajax({

    type:"POST",
    dataType:"json",
    data:{my_brand:my_brand,my_class:my_class,pro_name:pro_name},
    url:"index.php?module=auction&action=Add&m=proQuery",
    success:function(data){

         var res = data.res;
         var table = '';
         if(res.length > 0){//有竞拍商品数据

          $.each(res,function(index,element){
            table += '<tr class="text-c" style="height:60px!important;"><input type="hidden" name="attr_id"  value="'+element.attr_id+'"><td class="tab_label"><input  type="checkbox" class="inputC input_agreement_protocol" id = "'+element.id+index+'" targ="'+element.id+index+'" name="id[]" value = "'+element.id+'" style="position: absolute;" onchange="check_one('+element.id+index+')"> <label for="'+element.id+index+'"></label></td><td>'+(index+1)+'</td><td style="text-align:left;"><img src ="'+element.image+'" style="width: 40px;height:40px;">'+element.product_title+'</td> <td>'+element.name+'</td> <td>'+element.num+'</td> <td>'+element.min_inventory+'</td> <td>'+element.price+'</td></tr>';
            $("#proattr").html(table);
          })

         }else{//无竞拍数据
            $("#proattr").empty();
            layer.msg('没有竞拍商品',{time:2000})
         }
         $("#prolist").removeClass('scrolly');
         var table_height = $("#prolist").css('height');//单位为px
         table_height = table_height.slice(0,-2);
        
         if(table_height >= 300){
          
            $("#prolist").addClass('scrolly');
         }
    } 

  })
}

//ajax请求--获取商品品牌
$("select[name='class']").on('click',function(){
	var cid = $(this).val();
	if(cid == ''){
		return false
	}
	$.ajax({
		url:"index.php?module=auction&action=Add&m=proBrand",
		type:"post",
		data:{cid:cid},
		dataType:"JSON",
		success:function(data){
			console.log(data)
			if(data.length > 0){
				var brand = '<option value="">请选择品牌</option>'
				$.each(data,function(index,element){
					brand += '<option value="'+element.brand_id+'">'+element.brand_name+'</option>';
				})
				$("select[name='brand']").html(brand)
				console.log(brand)
			}else{
        $("select[name='brand']").html('<option value="" >请选择品牌</option>')
      }
			
		}
	})
	
 })
//ajax请求--添加竞拍商品
function check() {

    //金额判断
    let price  = $("input[name='price']").val();
    let add_price  = $("input[name='add_price']").val();
    let promise  = $("input[name='promise']").val();
    var regPos = /^\d+(\.\d+)?$/; //非负浮点数
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

    //时间合理判断
    var starttime = $('input[name=starttime]').val();
    var endtime = $('input[name=endtime]').val();
    if(starttime == ''|| endtime == ''){

        layer.msg('时间不能为空！',{time:2000});
        return false;
    }

    var start = new Date(starttime).getTime();
    var end = new Date(endtime).getTime();
    var now = new Date().getTime();
   
    if(start+600000 < now ){//选择现在则向后推迟60秒

        layer.msg('开始时间不能小于当前时间！');
        return false;
    }
    if(end < now ){
        layer.msg('结束时间不能小于当前时间！');
        return false;
    }
    if(start > end){
        layer.msg('开始时间不能大于结束时间！');
        return false;
    }
    if(start == end){
      layer.msg('结束时间要大于开始时间！');
      return false
    }
    
    //商品唯一性判断
    var product_id = $("input[name='id[]']:checked");
    if(product_id.length < 1){
      layer.msg('请选择商品',{time:2000});
      return false
    }
    if(product_id.length > 1){
      layer.msg('只能选择一个商品',{time:2000});
       return false
    }
    
   //获取选中的规格id
    var attr_id_check = $("input[name='id[]']:checked").parent().prev().val();
    //如果竞拍标题为空，则取商品标题
    var title = $("input[name='title']").val();
    var product_title = '';
    if(title == 0){
      product_title = $("input[name='id[]']:checked").parent().next().next().text();
    }


    console.log(attr_id_check);
    console.log(product_title)
    var rr = $('#form1').serialize();
    $.ajax({
    cache: true,
    type: "POST",
    dataType:"json",
    url:'index.php?module=auction&action=Add&m=proAdd',
    data:'attr_id_check='+attr_id_check+'&product_title='+product_title+'&'+$('#form1').serialize(),// 你的formid
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