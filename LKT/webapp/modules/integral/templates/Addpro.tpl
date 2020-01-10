<!--_meta 作为公共模版分离出去-->
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
<link rel="stylesheet" type="text/css" href="style/css/style.css" /> 
<title>活动设置</title>
 {literal}
<style type="text/css">
    body{font-size:14px;color: #555;}
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
    .protitle{
        overflow: hidden;
    }
    .barginprice{
        border-radius: 2px;
        width: 120px;
    }
    .redport{
       border:2px red solid;
    }
    .pinput{
       width:100px;
       text-align: center;
    }
    .ra1{min-width: 10%!important;left: 3px;}

    th,td,tr{border: 0!important;border-bottom: 1px solid rgb(221,221,221)!important}
    #my_query,#my_reset{background-color: #2890FF;padding: 7px 14px;width: auto;margin-left: 8px;border-radius: 3px;height: auto!important;margin-right: 0;}
	#my_reset{border: 1px solid #D5DBE8;color: #6a7076;background-color: #FFFFFF;}
    .pro_img{display: flex;
    position: relative;
    flex-direction: column;
    justify-content: center;}
    .pro_img img{width: 40px;height: 40px;float: left;}
    .protitle p{overflow: hidden;white-space: nowrap;text-overflow: ellipsis;width: 200px;margin: 0;}
    td{border: none!important;}
    .text-c td{border-bottom: 1px solid #eceeef!important;vertical-align: middle;}
    .text-c th{vertical-align: middle!important;}
    table thead tr th{border-bottom: 1px solid #eceeef!important;}
    .inputC:checked +label::before{top: 0;}
    input[type=text] {margin: 0!important;}
    .form_new_r .ra1 label {width: 100%!important;}
    .form_new_r span{color: #555;}
</style>
{/literal}
</head>
<body class="body_bgcolor">
  <nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a href="index.php?module=integral&action=Index" style="color: #555;">积分商城</a>
    <span class="c-gray en">&gt;</span>
    添加商品
  </nav>
<div id="addpro" class="pd-20  page_absolute form-scroll">
  <div class="page_title">添加商品</div>
  <form method="post" id="form1" class="form form-horizontal page_absolute" id="form-category-add" enctype="multipart/form-data">
    <input type="hidden" name="module" value="integral" />
    <input type="hidden" name="action" value="Addpro" />
    <input type="hidden" name="id" value="{$id}" id="id" />

    <div class="formContentSD">
      <div class="formListSD">
        <div class="formTextSD"><span>选择商品：</span></div>
        <div class="form_new_r form_yes" style="width: 90%;font-size: 14px;">
              

          <div style="display: inline;">
            <select name="protype" class="select" style="border-radius:2px;width: 180px;vertical-align: middle;">
              <option value="" >请选择产品类别</option>
                    {$class}
            </select>
          </div>
          <div style="display: inline;margin-left: 8px;">
            <select name="probrand" class="select" style="border-radius:2px;width: 180px;vertical-align: middle;">
               <option value="" >请选择产品品牌</option>            
            </select>
          </div>
          <div style="display: inline;margin-left: 8px;">
            <input type="text" name="proname" id="proname" placeholder="请输入产品名称" style="padding-left: 12px;">
          </div>
		  <input id="my_reset" class="btn" type="button" value="重置">
          <input id="my_query" class="btn btn-success" type="button" value="查询">
        </div>
      </div>
<!--     </div>

    <div class="formContentSD"> -->
      <div class="formListSD">
          <div class="formTextSD"><span></span></div>
          <div class="form_new_r form_yes" style="width: 90%;">
            <div style="height: 300px;overflow-y: auto;width: 100%;">

              <table class="table table-border table-bordered table-bg table-hover" style="margin:0 auto;">
                <thead>
                  <tr class="text-c">
                    <th style="width: 5%;"></th>
                    <th class="tabletd">商品名称</th>
                    <th style="width: 5%;min-width: 70px;">商品ID</th>
                    <th style="width: 10%;min-width: 80px;">商家名称</th>
                    <th style="width: 15%;">库存</th>
                    <th style="width: 10%;min-width: 95px;">库存预警值</th>
                    <th style="width: 15%;">零售价</th>
                  </tr>
                </thead>
                <tbody id="proattr">

                </tbody>
              </table>
              <div id="loadding">
              
              </div>

            </div>
          </div>
        </div>
      </div>



    <div class="formContentSD">
      <div class="formListSD">
        <div class="formTextSD"><span>商品价格：</span></div>
        <div class="form_new_r form_yes" style="width: 90%;">
            <input onkeyup="num2(this)" type="number" value="{$pro->integral}" name="integral" id="integral" class="input-text" placeholder="兑换所需积分" style="border-radius:2px;width: 180px;height: 31px;margin: 0;"/>
            <div style="display: inline;margin: 0 10px;line-height: 36px;">（积分）+</div>
            <input type="number" value="{$pro->money}" name="money" id="money" class="input-text" placeholder="兑换所需余额" style="border-radius:2px;width: 180px;height: 31px;margin: 0;" onkeyup="num(this)"/>
            <div style="display: inline;margin: 0 10px;line-height: 36px;">（现金）</div>
            <span style="color:#C0C0C0;margin-left: 20px;"></span>
        </div>
      </div>
    </div>

	<div style="height: 70px;"></div>

    <div class="row cl page_bort" style="margin: 0;">
      <div class="">
        <input class="btn btn-primary radius ta_btn3" style="margin-right: 60px!important;" type="button" onclick="group_tijiao()" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
        <input class="btn btn-primary radius ta_btn4 ta_btn5" style="background-color: white!important;margin-right: 17px!important;" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" onclick="javascript:history.back(-1);">
      </div>
    </div>
    <div style="height: 20px;"></div>
  </form>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
{include file="../../include_path/footer.tpl" sitename="公共尾部"}
<!--请在下方写此页面业务相关的脚本-->

<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
{literal}
<script type="text/javascript">
laydate.render({
  elem: '#startdate', //指定元素
    trigger: 'click',
  type: 'datetime'
});
 laydate.render({
  elem: '#enddate',
     trigger: 'click',
  type: 'datetime'
});

function check_one(i){
 
  if($("input[id="+i+"]").prop("checked")==true){
      $("input[id!="+i+"][name='id[]']").removeAttr("checked");
  }
}

$("#my_query").click(function () {
    //搜索按钮
    getpro();
})

$("#my_reset").click(function(){
	// 重置按钮
	$("select[name=protype]").val('');
	$("select[name=probrand]").val('');
	$("#proname").val('');
})


function num(obj){
    obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
    obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
}
function num2(ob) {
    if (ob.value.length == 1) {
        ob.value = ob.value.replace(/[^1-9]/g, '')
    } else {
        ob.value = ob.value.replace(/\D/g, '')
    }
}

function getpro(id){

    var pro = ''
    var sel1 =     $('select[name=protype]').val();
    var sel2 =     $('select[name=probrand]').val();
    var sel3 =     $('input[name=proname]').val();

    $.ajax({
        url: 'index.php?module=integral&action=Addpro&m=getproattr_sel',
        type: 'post',
        data: {where1:sel1,where2:sel2,where3:sel3,id:id},
        success: function (data){
          data = JSON.parse(data);
          var table = '';
          if(data.length !== 0){
            var i = 0;
            $.each(data,function(index,element){
              var gou = '';
              if (element.gou == 1) {
                gou = 'checked';
              }
              table += `<tr class="text-c" style="height:20px;"><td><input type="checkbox" style="width: 10px;height: 10px;" val-data="${element.pid}" class="inputC input_agreement_protocol" id="${element.id}" name="id[]" onchange="check_one('${element.id}')" ${gou} value="${element.id}"><label for="${element.id}"></label></td><td style="display: flex;justify-content: center;height: 100%;"><div class="pro_img"><img src="${element.pro_img}"></div><div class="protitle"><p>${element.product_title}</p><p>${element.attrtype}</p></div></td><td>${element.id}</td><td>${element.mchname}</td><td><span id="pronum${element.id}">${element.num}</span></td><td><span id="min_inventory${element.id}">${element.min_inventory}</span></td><td><span id="mkprice${element.id}">${element.price}</span></td></tr>`;
              i++;
            });
            $('#proattr').html(table);
            $('#loadding').html('');
          } else {
            table = `<div style="border: 1px solid #eceeef;height: 200px;display: flex;"><span>无此商品或类似的商品</span></div>`
            $('#loadding').html(table);
            $('#proattr').html('');
          }
        },
        fail: function (err){

        }
    })
}

var cid = null;
$('select[name=protype]').change(function (){
    var type = $(this).val();
    if(type == ''){
       return;
    }
    cid = type;
    $.ajax({
      url: 'index.php?module=integral&action=Addpro&m=getbrand',
      type: 'post',
      data: {cid:type},
      success: function (data){
        data = JSON.parse(data);
        var str = '<option value="" >请选择产品品牌</option>';
        for(var i in data){
           str += "<option value='"+data[i].brand_id+"'>"+data[i].brand_name+"</option>";    
        }
        //console.log(str);
         $('select[name=probrand]').html(str);
         $('select[name=selectpro] option:gt(0)').remove();
      },
      fail: function (err){

      }
    })
});
var goodsid = null;

function validation(obj) {         
    var regu = /^\d+$/;
    //var regu = /^[1-9]\d*|0$/;  亲测可用
    if (obj != "") {
        if (!regu.test(obj)) {
            return false;
        } else {
            return true;
        }
    }else{
      return false;
    }
}



    function group_tijiao() {

      var checktext = true;
      var checkids=$("input[name='id[]']:checked");//被选中的复选框对象
        if(checkids.length < 1){
           layer.msg("请选择一款产品属性");
           checktext = false;
           return;
        }
        if(checkids.length > 1){
           layer.msg("只可以选择一款产品属性哦！");
           checktext = false;
           return;
        }
        var attrid = '';
        $.each(checkids,function (index,element){

            goodsid = $(element).attr('val-data');
            attrid = $(element).val();
            var pronum = $('#pronum'+attrid).text();
			if (pronum <= 0) {
				layer.msg('商品库存不足，无法添加!');
				checktext = false;
				return;
			}

        });

        var integral = $("#integral").val();
        if (!validation(integral) || parseInt(integral) < 1) {
        	layer.msg('兑换所需积分需为正整数!');
			    checktext = false;
			    return;
        }

        var obj = {};
        obj['integral'] = $('#integral').val();
        obj['money'] = $('#money').val();
        obj['goodsid'] = goodsid;
        obj['attrid'] = attrid;
        obj['id'] = $('#id').val();

      if(checktext){
        obj = JSON.stringify(obj);
            $.ajax({
               url: "index.php?module=integral&action=Addpro&m=insertpro",
               type: "post",
               data: {obj:obj},
               dataType: "json",
               success:function(data) {
                   if(data.code == 1){
                    layer.msg(data.msg);
                    window.location.href = 'index.php?module=integral&action=Index';
                   }else{
                       layer.msg(data.msg);
                   }
               },
             })
        } 
    }

      var record={ 
      num:"",
      id:'' 
      }
  var checkDecimal=function(n,m){
          //对文本进行正则处理
      var decimalReg=/^\d{0,8}\.{0,1}(\d{1,2})?$/;//var decimalReg=/^[-\+]?\d{0,8}\.{0,1}(\d{1,2})?$/; 
      if(n.value!=""&&decimalReg.test(n.value)){ 
      record.num=n.value;
      record.id = m; 
      }else{ 
      if(n.value!=""){
       if(record.id == m){
        n.value=record.num;
        }else{
        n.value='';  
        } 
       } 
     } 
   } 

$('.table-sort').dataTable({
  "aaSorting": [[ 1, "desc" ]],//默认第几个排序
  "bStateSave": true,//状态保存
  "aoColumnDefs": [
    //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
    {"orderable":false,"aTargets":[0,4]}// 制定列不参与排序
  ]
});

$(function(){

    var id = $('#id').val();
   	getpro(id);

	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	$("#tab-category").Huitab({
		index:0
	});
});

</script>
{/literal}
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>