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
<!--<link rel="stylesheet" type="text/css" href="style/lib/Hui-iconfont/1.0.7/iconfont.css" />-->
<!--<link rel="stylesheet" type="text/css" href="style/skin/default/skin.css" id="skin" />-->
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

    .reset{
        padding: 7px 14px!important;
        width: auto!important;
        margin: 0 0 0 8px!important;
        border-radius: 3px;
        height: auto!important;
    }

    th,td,tr{border: 0!important;border-bottom: 1px solid rgb(221,221,221)!important}
    #my_query{background-color: #2890FF;padding: 7px 14px;width: auto;margin-left: 8px;border-radius: 3px;height: auto!important;}
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
    .btn-success:focus{
      box-shadow: 0 0 0 0px rgba(92, 184, 92, .5)!important;
    }
    .formListSD {
      margin: 10px 10px;
    }
    #lowprice {
      width:180px;
    }
	
	#formcheckbox label:after {
		border: 1px solid #B2BCD1 !important;
		width: 14px !important;
		height: 14px !important;
		border-radius: 2px !important;
		content: "";
		left: 0px !important;
		top: 11px !important;
		position: absolute !important;
		z-index: 11 !important;
	}
</style>
{/literal}
</head>
<body class="body_bgcolor">
  <nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a href="index.php?module=bargain&action=Index" style="color: #555;">砍价</a>
    <span class="c-gray en">&gt;</span>
    砍价商品
    <span class="c-gray en">&gt;</span>
    添加砍价商品
  </nav>
<div id="addpro" class="pd-20  page_absolute form-scroll">
  <div class="page_title">添加砍价商品</div>
  <form method="post" id="form1" class="form form-horizontal page_absolute" id="form-category-add" enctype="multipart/form-data">
    <input type="hidden" name="module" value="bargain" />
    <input type="hidden" name="action" value="Addpro" />

    <div class="formContentSD">
      <div class="formListSD">
        <div class="formTextSD"><span class="c-red">*</span><span>选择砍价商品：</span></div>
        <div class="form_new_r form_yes" style="width: 90%;font-size: 14px;">
              

          <div style="display: inline;">
            <select name="protype" id="protype" class="select" style="border-radius:2px;width: 180px;vertical-align: middle;">
              <option value="" >请选择产品类别</option>
              {$class}
            </select>
          </div>
          <div style="display: inline;margin-left: 8px;">
            <select name="probrand" id="probrand" class="select" style="border-radius:2px;width: 180px;vertical-align: middle;">
               <option value="" >请选择产品品牌</option>            
            </select>
          </div>
          <div style="display: inline;margin-left: 8px;">
            <input type="text" name="proname" id="proname" placeholder="请输入产品名称" style="padding-left: 12px;">
          </div>

          <input type="button" value="重置" class="reset" style="color: #6A7076;" onclick="empty()" />
          <input id="my_query" class="btn btn-success" type="button" value="查询">


        </div>
      </div>


      <div class="formListSD">
          <div class="formTextSD"><span></span></div>
          <div class="form_new_r form_yes" style="width: 90%;">
            <div style="max-height: 300px;overflow-y: auto;width: 100%;">

              <table class="table table-border table-bordered table-bg table-hover" style="margin:0 auto;">
                <thead>
                  <tr class="text-c">
                    <th style="width: 5%;"></th>
                    <th class="tabletd">商品名称</th>
                    <th style="width: 10%;min-width: 67px;">商品ID</th>
                    <th style="width: 10%;min-width: 80px;">商家名称</th>
                    <th style="width: 10%;">库存</th>
                    <th style="width: 10%;min-width: 95px;">库存预警值</th>
                    <th style="width: 10%;">零售价</th>
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
        <div class="formTextSD"><span class="c-red">*</span><span>砍价最低价：</span></div>
        <div class="form_new_r form_yes" >
            <input type="number" onkeyup="num(this)" min="0" id="lowprice" autocomplete="off" class="input-text" placeholder="请设置砍价最低价" />
        </div>
      </div>
      <div class="formListSD">
        <div class="formTextSD"><span class="c-red">*</span><span>活动时间：</span></div>
        <div class="form_new_r form_yes" style="width: 90%;">
            <input type="text" id="startdate" autocomplete="off" class="input-text" placeholder="请选择开始时间" style="border-radius:2px;width: 180px;height: 31px;"/>
            <div style="display: inline;margin: 0 10px;line-height: 36px;">至</div>
            <input type="text" id="enddate" autocomplete="off" class="input-text" placeholder="请选择结束时间" style="border-radius:2px;width: 180px;height: 31px;"/>
            <span style="color:#C0C0C0;margin-left: 20px;">（商品砍价时间，到时间则活动结束，如未达到最低价，则砍价失败！）</span>
        </div>
      </div>
      <div class="formListSD">
        <div class="formTextSD"><span>活动标签：</span></div>
		
        <div id="formcheckbox" class="form_new_r form_yes" style="width: 90%;">
          {$sp_type}
        </div>
		
		
      </div>
      <div class="formListSD">
        <div class="formTextSD"><span>是否显示：</span></div>
        <div class="form_new_r form_yes" style="width: 90%;">
          <div class="ra1" style="min-width: 10%!important;">
              <input style="display: none;" class="inputC1" type="radio" name="p_show" id="show_1" value="0">
              <label for="show_1">否</label>
          </div>
          <div class="ra1" style="min-width: 10%!important;">
              <input style="display: none;" class="inputC1" type="radio" name="p_show" id="show_2" value="1"  checked="checked">
              <label for="show_2">是</label>
          </div>
        </div>
      </div>
      <div class="formListSD">
        <div class="formTextSD"><span class="c-red">*</span><span>砍价方式：</span></div>
        <div class="form_new_r form_yes" style="width: 90%;">
          <div class="ra1" style="min-width: 10%!important;">
              <input style="display: none;" class="inputC1" type="radio" name="setman" id="setman_1" value="1" {if $re.setman !=2}checked="checked"{/if}>
              <label for="setman_1">设置人数</label>
          </div>
          <div class="ra1" style="min-width: 10%!important;">
              <input style="display: none;" class="inputC1" type="radio" name="setman" id="setman_2" value="2" {if $re.setman ==2}checked="checked"{/if}>
              <label for="setman_2">不设置人数</label>
          </div>
        </div>
      </div>
      <div class="formListSD">
        <div class="form_new_r form_yes" style="width: 90%;">

          <div id="issetman">
            <div class="formListSD">
              <div class="formTextSD">参与人数：</div>
              <div class="form_new_r form_yes" style="width: 90%;">
                  <input type="number" min="1" style="border-radius:2px;width: 120px;margin:0;" class="input-text" name="barginman" onkeyup="num2(this)"/>
                  <span style="margin: 5px;">人</span><span style="color:#C0C0C0;margin: 5px;">参与砍价人数</span>
              </div>
            </div>
            <div class="formListSD">
              <div class="formTextSD">砍价波动值：</div>
              <div class="form_new_r form_yes" style="width: 90%;">
                <span>前</span>
                <input type="number" min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="one_man" onkeyup="num(this)"/>
                <span>人砍价，最小值</span>
                <input type="number" min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="min_one" onkeyup="num(this)"/>
                <span>最大值</span>
                <input type="number" min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="max_one" onkeyup="num(this)"/>
              </div>
            </div>
          </div>
          <div id="notsetman">
            <div class="formListSD">
              <div class="formTextSD">砍价波动值：</div>
              <div class="form_new_r form_yes" style="width: 90%;">
                <span>最小值</span>
                <input type="number" min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="min_not" onkeyup="num(this)"/>
                <span>最大值</span>
                <input type="number" min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="max_not" onkeyup="num(this)"/>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

	<div style="height: 70px;"></div>

    <div class="row cl page_bort" style="margin: 0;padding-bottom: 15px;">
        <input class="btn btn-primary radius ta_btn3" style="margin-right: 60px!important;" type="button" onclick="group_tijiao()" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
        <input class="btn btn-primary radius ta_btn4 ta_btn5" style="background-color: white!important;margin-right: 17px!important;" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" onclick="javascript:history.back(-1);">
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

$('#notsetman').hide();
$('input[name=setman]').change(function (){
    var val = $(this).val();
    
    if(val == '1'){
       $('#notsetman').hide();
       $('#issetman').show();
    }else{
       $('#issetman').hide();
       $('#notsetman').show();
    }
});

function empty(){
  $("#probrand").val('');
  $("#protype").val('');
  $("#proname").val('');
}

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

function check_one(i){
  if($("input[id="+i+"]").prop("checked")==true){
      $("input[id!="+i+"][name='id[]']").removeAttr("checked");
  }
}

$(function(){
  get_pro();
})

function get_pro(){

  var pro = ''
  var sel1 = $('select[name=protype]').val();
  var sel2 = $('select[name=probrand]').val();
  var sel3 = $('input[name=proname]').val();

  $.ajax({
      url: 'index.php?module=bargain&action=Addpro&m=getproattr_sel',
      type: 'post',
      data: {where1:sel1,where2:sel2,where3:sel3},
      success: function (data){
        data = JSON.parse(data);
        var table = '';
        if(data.length !== 0){
          var i = 0;
          $.each(data,function(index,element){
            table += `<tr class="text-c" style="height:20px;"><td><input type="checkbox" style="width: 10px;height: 10px;" val-data="${element.pid}" class="inputC input_agreement_protocol" id="${element.id}" name="id[]" onchange="check_one('${element.id}')" value="${element.id}"><label for="${element.id}"></label></td><td style="display: flex;justify-content: center;height: 100%;"><div class="pro_img"><img src="${element.pro_img}"></div><div class="protitle"><p>${element.product_title}</p><p>${element.attrtype}</p></div></td><td>${element.id}</td><td>${element.mchname}</td><td><span id="pronum${element.id}">${element.num}</span></td><td><span id="min_inventory${element.id}">${element.min_inventory}</span></td><td><span id="mkprice${element.id}">${element.price}</span></td></tr>`;
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

$(".btn-success").click(function () {
    get_pro();
})

var cid = null;
$('select[name=protype]').change(function (){
    var type = $(this).val();
    if(type == ''){
       return;
    }
    cid = type;
    $.ajax({
      url: 'index.php?module=bargain&action=Addpro&m=getbrand',
      type: 'post',
      data: {cid:type},
      success: function (data){
        data = JSON.parse(data);
        var str = '<option value="" >请选择产品品牌</option>';
        for(var i in data){
           str += "<option value='"+data[i].brand_id+"'>"+data[i].brand_name+"</option>";    
        }
        $('select[name=probrand]').html(str);
      },
      fail: function (err){

      }
    })
});
var goodsid = null;

$('input[name=one_man]').blur(function (){
  var one_man = $(this).val();
  
    if(one_man == '0' && one_man != ''){
        $('#two_man').hide();
    }else{
        $('#two_man').show();
    }
})


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
        var min_price = '';
        var chajiamin = [];
        $.each(checkids,function (index,element){
            var id = $(element).val();
            var mkprice = parseFloat($('#mkprice'+id).text());
            var pronum = $('#pronum'+id).text();
            var min_inventory = $('#min_inventory'+id).text();
            var barginprice = parseFloat($('#lowprice').val());
            if(!validation(pronum)){
               layer.msg("库存数量设置不合格");
               $('#pronum'+id).addClass('redport');
                setTimeout(function (){
                   $('#pronum'+id).removeClass('redport');
                },2000);
                checktext = false;
                return;
            }
            if(!validation(min_inventory)){
               layer.msg("库存预警值设置不合格");
               $('#min_inventory'+id).addClass('redport');
                setTimeout(function (){
                   $('#min_inventory'+id).removeClass('redport');
                },2000);
                checktext = false;
                return;
            }
            if(barginprice >= mkprice || barginprice == ''){
               layer.msg("价格设置不标准!");
               $('#barginprice'+id).addClass('redport');
                setTimeout(function (){
                   $('#barginprice'+id).removeClass('redport');
                },2000);
                checktext = false;
                return;
            }
            if(checktext){
              attrid = id;
              min_price = barginprice;
            }
            var chajia = mkprice-barginprice;
            chajiamin.push(chajia);
        });

        var min_price = $('#lowprice').val();
        if(min_price < 1 || min_price == ''){
          layer.msg("最低价设置不标准！");
          return;
        }

        var minprice = Math.min.apply(null, chajiamin);       //求差价最小值
         
        if(!checktext){
          return;
        }

        var bar_good = $("input[name='id[]']:checked");
        var goods_id = 0;
        if(bar_good.length == 0){
          layer.msg('请选择一个砍价商品!');
          return;
        }else{
          $.each(bar_good,function (index,element){
            goodsid = $(element).attr('val-data');
            goods_id = $(element).val();
          })
        }

        if (goods_id > 0) {
          var pronum = $('#pronum'+goods_id).text();
          if (pronum <= 0) {
            layer.msg('商品库存不足，无法进行活动!');
            return;
          }
        }

        var obj = {};
        var status_data = {};
        obj['startdate'] = $('#startdate').val();
        obj['enddate'] = $('#enddate').val();
        obj['buytime'] = $('#buytime').val();
        obj['goodsid'] = goodsid;
        obj['is_show'] = $('input[name=p_show]:checked').val();
        obj['is_type'] = [];
        var checktypes=$("input[name='s_type[]']:checked");
        $.each(checktypes,function (index,element){
            obj['is_type'] += $(element).val()+',';
        })


        var setman = obj['setman'] = $('input[name=setman]:checked').val();
        if(setman == 1){
            var barginman = obj['barginman'] = $('input[name=barginman]').val();
            $.each(obj,function (index,element){
                if(element === ''){
                   layer.msg("请填写完整信息");
                   checktext = false;
                   return;
                }
            });
            if(!checktext){
              return;
            }

            var one_man = status_data['one_man'] = $('input[name=one_man]').val();
            var min_one = status_data['min_one'] = $('input[name=min_one]').val();
            var max_one = status_data['max_one'] = $('input[name=max_one]').val();
            if(one_man != '0'){
               var min_two = status_data['min_two'] = $('input[name=min_two]').val();
               var max_two = status_data['max_two'] = $('input[name=max_two]').val();             
            }
            $.each(status_data,function (index,element){
                if(element === ''){
                   layer.msg("参数不允许为空");
                   checktext = false;
                   return;
                }
            });
            if(!checktext){
              return;
            }      
            if(!validation(barginman) || parseInt(barginman) <= 1){
               layer.msg("参与人数必须为大于1的正整数");
               checktext = false;
               return;
            }

            if(!validation(one_man)){
               layer.msg("第一个条件的人数设置不合格");
               checktext = false;
               return;
            }
			
            if(parseFloat(min_one) >= parseFloat(max_one) || (one_man != '0' && parseInt(min_two) >= parseInt(max_two))){
               layer.msg("最大值不能小于最小值");
               checktext = false;
               return;
            }
			
            if(parseInt(max_one) >= minprice || parseInt(max_two) >= minprice){
               layer.msg("最大值不能大于砍价产品设置的差价");
               checktext = false;
               return;
            }
            var barginman = $('input[name=barginman]').val();//总人数
            var one_man = $('input[name=one_man]').val();//前人数
            if(parseInt(one_man) >= parseInt(barginman)){
                layer.msg('总人数应大于第一波人数');
                return false;
            }

            var two_man = barginman - one_man;
            var min_first = one_man*min_one;
            var all_can = two_man*0.01+min_first;
            if (all_can > minprice) {
                layer.msg('请设置正确的砍价波动值！');
                return false;
            }

        }else{
            var min_not = status_data['min_not'] = $('input[name=min_not]').val();
            var max_not = status_data['max_not'] = $('input[name=max_not]').val();
            obj['barginman'] = 0;
            $.each(obj,function (index,element){
                if(element === ''){
                   layer.msg("请填写完整信息");
                   checktext = false;
                   return;
                }
            });
            $.each(status_data,function (index,element){
                if(element === ''){
                   layer.msg("参数不允许为空");
                   checktext = false;
                   return;
                }
            });
            if(!checktext){
              return;
            }
            if(parseInt(min_not) >= parseInt(max_not)){
               layer.msg("最大值不能小于最小值");
               checktext = false;
               return;
            }
            if(parseInt(max_not) >= minprice){
               layer.msg("最大值不能大于砍价产品设置的差价");
               checktext = false;
               return;
            }
        }

        var stime = new Date(obj['startdate']).getTime();
        var etime = new Date(obj['enddate']).getTime(); 
        var now = new Date().getTime();
        now = now - (60 *1000);
        if(stime < now){
          layer.msg('请设置正确的活动开始时间!');
          checktext = false;
          return;
        } 
        if(etime < now || stime >= etime){
            layer.msg('请设置正确的活动时间!');
            checktext = false;
            return;
        }
        var hour = $("#buytime").val();
        if (hour <= 0) {
            layer.msg("购买时间应该大于0小时");
            checktext = false;
            return;
        }

      if(checktext){
        obj = JSON.stringify(obj);
        status_data = JSON.stringify(status_data);
            $.ajax({
               url: "index.php?module=bargain&action=Addpro&m=insertpro",
               type: "post",
               data: {min_price:min_price,attrid:attrid,obj:obj,status_data:status_data},
               dataType: "json",
               success:function(data) {
                   if(data.code == 1){
					
                       window.location.href = 'index.php?module=bargain';
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
    
    $("#lowprice").change(function () {
        var lowprice = $("#lowprice").val();
        $('.barginprice').val(lowprice);
    })

    $('input[name=barginman]').blur(function () {
        tips();
    })
    $('input[name=one_man]').blur(function () {
        tips();
    })

    var fristmax = 0
    function tips() {
        var barginman = $('input[name=barginman]').val();//总人数
        var one_man = $('input[name=one_man]').val();//前人数
        var min_one = $('input[name=min_one]').val();//前最小
        var max_one = $('input[name=max_one]').val();//前最大
        var lowprice = $("#lowprice").val();//最低价
        if(barginman == ''){
            return false;
        }
        if(lowprice == ''){
            return false;
        }
        var aa = $('input[type=checkbox]:checked').parent().next().next().next().next().next().next().children('input').val();
        var bb = $('input[type=checkbox]:checked').parent().next().next().next().next().next().html();

        var chamoney = bb - lowprice
        fristmax = chamoney/barginman;
        $('input[name=min_one]').attr('max',fristmax-1)
        $('input[name=max_one]').attr('max',fristmax)
        console.log(fristmax);
    }
    $('input[name=min_one]').change(function () {
        var me = $(this).val();
        var bb = $('input[type=checkbox]:checked').parent().next().next().next().next().next().html();
        var lowprice = $("#lowprice").val();//最低价
        var barginman = $('input[name=barginman]').val();//总人数
        var chamoney = bb - lowprice
        var fristmax = chamoney/barginman;
        if(me > fristmax && fristmax > 2){
            $(this).val(fristmax-1);
        }else if(me < 0){
            $(this).val(1);
        }
    })

    $('input[name=max_one]').change(function () {
        var me = $(this).val();
        var bb = $('input[type=checkbox]:checked').parent().next().next().next().next().next().html();
        var lowprice = $("#lowprice").val();//最低价
        var barginman = $('input[name=barginman]').val();//总人数
        var chamoney = bb - lowprice
        var fristmax = chamoney/barginman;
        if(me > fristmax && fristmax > 2){
            $(this).val(fristmax);
        }else if(me < 0){
            $(this).val(2);
        }
    })

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