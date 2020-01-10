
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
<link rel="stylesheet" type="text/css" href="style/css/bootstrap-colorpicker.css" />
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
<title>添加等级</title>
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
	.product_select{
    margin-left: 0px!important;
    width: 420px;
    height: 36px;
    border: 1px solid #D5DBE8;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .colorpicker-component{
    margin-top: 10px;
  }

</style>
{/literal}
</head>
<body class='iframe-container'>
  {include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
  <nav class="nav-title">
  	<span>会员管理</span>
  	<span class='nav-to' onclick="location.href='index.php?module=userlist&action=Grade'"><span class='arrows'>&gt;</span>等级管理</span>
  	<span><span class='arrows'>&gt;</span>添加等级</span>
  </nav>
<div class="iframe-content form-scroll" style="background-color: white;">
    <p style="font-size: 15px;" class="page_title">添加等级</p>

    <form name="form1" id="form1" class="form form-horizontal" style="padding: 0px!important;" method="post" enctype="multipart/form-data" >
        
        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px!important;"><span class="c-red">*</span>会员等级名称：</label>
            <div class="formControls col-10">
               <input type="text" name="name" value="" placeholder="请输入会员等级名称" style="width: 290px!important;">
            </div>
        </div>
        <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">我的背景图：</label>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div class="upload-preview-list uppre_auto">
                            <div class="upload-preview form_new_img" {if !$imgurl_my}style="display: none;"{/if}>
                                <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp three_img" />
                                <img src="{$imgurl_my}" class="upload-preview-img" style="margin-top: -23px;width: 78px;height: 78px;">
                                <input type="hidden" name="imgurl_my" class="file-item-input" value="{$imgurl_my}">
                            </div>
                        </div>
                        <div data-max='2' class="select-file form_new_file three from_i" {if $imgurl_my}style="display: none;"{/if}>
                          <div>
                            <img data-max='2' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                            <span class="form_new_span">上传图片</span>
                          </div>
                        </div>
                    </div>
                    <span class="addText">（展示图最多上传一张，建议上传60px*60px的图片）</span>
                </div>
        </div>
        <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">会员背景图：</label>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div class="upload-preview-list uppre_auto">
                            <div class="upload-preview form_new_img" {if !$imgurl}style="display: none;"{/if}>
                                <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp one_img" />
                                <img src="{$imgurl}" class="upload-preview-img" style="margin-top: -23px;width: 78px;height: 78px;">
                                <input type="hidden" name="imgurl" class="file-item-input" value="{$imgurl}">
                            </div>
                        </div>
                        <div data-max='2' class="select-file form_new_file one from_i" {if $imgurl}style="display: none;"{/if}>
                          <div>
                            <img data-max='2' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                            <span class="form_new_span">上传图片</span>
                          </div>
                        </div>
                    </div>
                    <span class="addText">（展示图最多上传一张，建议上传60px*60px的图片）</span>
                </div>
        </div>
        <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">小图标：</label>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div  class="upload-preview-list uppre_auto">
                            <div class="upload-preview form_new_img" {if !$imgurl_s}style="display: none;"{/if}>
                                <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp two_img" />
                                <img src="{$imgurl_s}" class="upload-preview-img" style="margin-top: -23px;width: 78px;height: 78px;">
                                <input type="hidden" name="imgurl_s" class="file-item-input" value="{$imgurl_s}">
                            </div>
                        </div>
                        <div data-max='2' class="select-file form_new_file two from_i" {if $imgurl_s}style="display: none;"{/if}>
                          <div>
                            <img data-max='2' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                            <span class="form_new_span">上传图片</span>
                          </div>
                        </div>
                    </div>
                    <span class="addText">（展示图最多上传一张，建议上传60px*60px的图片）</span>
                </div>
        </div>
        <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;">会员字体颜色：</label>
            <div class="formControls col-10">
               <input id="mycp" type="text" class="form-control" value="" style="width: 290px!important;"  name="font_color" />

            </div>
        </div>
         <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;">日期字体颜色：</label>
            <div class="formControls col-10">
               <input id="mycp1" type="text" class="form-control" value="" style="width: 290px!important;"  name="date_color" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px!important;"><span class="c-red">*</span>晋升条件：</label>
            <div class="formControls col-10">
              <div style="color: #555555;">
                {if in_array(1,$upgrade)}
                  <p>购买会员服务</p>
                {/if}
                {if in_array(2,$upgrade)}
                  <p>补差额升级</p>
                {/if}
               
              
              </div>
            </div>
        </div>
        <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>专属折扣：</label>
            <div class="formControls col-10" style="padding-left: -11px;float: left;">
               <input type="number" name="rate" value="" placeholder="请输入折扣" style="width: 290px!important;padding-left: 10px;" >
               <span>折</span>
            </div>
        </div>
        <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>开通方式：</label>
            <div class="formControls col-10">
              <div style="margin-top: 50px;margin-left: -36px;">
                {if in_array(1,$method)} 
                   <p>包月&nbsp;<input type="number" name="money" value="" style="width: 290px!important;padding-left: 10px;">&nbsp;/每月</p>
                {/if}
                {if in_array(2,$method)} 
                   <p>包季&nbsp;<input type="number" name="money_j" value="" style="width: 290px!important;padding-left: 10px;">&nbsp;/每季</p>
                {/if}
                {if in_array(3,$method)} 
                  <p>包年&nbsp;<input type="number" name="money_n" value="" style="width: 290px!important;padding-left: 10px;">&nbsp;/每年</p>
                {/if}   
              </div>
            </div>
        </div>
		<div class="row cl" style="{if $is_product != 1}display: none;{/if} ">
		   <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>会员赠送商品：</label>
		    <div class="formControls col-10">
				<div class="product_select">
					<div style="margin-left: 5px; color: #868995; font-size: 14px; padding: 7px; height: 14px; box-sizing: content-box; line-height: 14px;"></div>
					<b style="margin-right: 14px;">▼</b>
				</div>
				<input id="product_i" name="pro_id" type="hidden" value="">
				<ul id="product110" style="width:420px;border:1px solid #D5DBE8;border-top: 0;height: 200px; overflow-y: scroll;display: none;">
					
				</ul>
		    </div>
		</div>
        <div class="row cl">
           <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;">备注：</label>
            <div class="formControls col-10">
              <textarea name="remark" style="width: 290px!important;padding-left: 10px;height: 100px;"></textarea>
            </div>
        </div>
		<div style='height: 70px;'></div>
        <div class="page_bort">
                <input class="fo_btn2 btn-right" type="button" name="Submit" value="保存" onclick="check()">
                <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
             
        </div>
    </form>
     
</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
<script type="text/javascript" src="style/js/bootstrap-colorpicker.js"></script>

{literal}
<script type="text/javascript">
  $(function () {
    $('#mycp').colorpicker();
  });
  $(function(){
    $('#mycp1').colorpicker();
  });

</script>
 
<script type="text/javascript">
//图片上传控制js
$(function(){
    //第一张图片
    $("input[name='imgurl']").on("change",function(e){
        var val = $(this).val();
        if (val.length > 0) {
          $('.one').css('display','none');
        }
    });

    $('.one_img').on('click',function(){
        $('.one').css('display','flex');
    })
     //第二张图片
    $("input[name='imgurl_s']").on("change",function(e){
        var val = $(this).val();
        if (val.length > 0) {
          $('.two').css('display','none');
        }
    });

    $('.two_img').on('click',function(){
        $('.two').css('display','flex');
    })
    //第三张图片
    $("input[name='imgurl_my']").on("change",function(e){
        var val = $(this).val();
        if (val.length > 0) {
          $('.three').css('display','none');
        }
    });
    $('.three_img').on('click',function(){
        $('.three').css('display','flex');
    })

});
$.ajax({
	type:'POST',
	datatype:'json',
	url:'index.php?module=userlist&action=Grade&m=getPro',
	success:function(data){
		if(JSON.parse(data).code==200){
			var list=JSON.parse(data).data
			var str=''
			for(var i=0;i<list.length;i++){
				str+=`<li>
					<label style='margin:0;padding-left:12px;font-size:14px;color:#868995;display: flex; align-items: center; height: 30px;'><input type="checkbox" value="${list[i].id}" style="visibility:visible;height: auto!important; margin-top: 0;">${list[i].product_title}</label>
				</li>`
			}
			$('#product110').html(str)
		}
	},
	error:function(res){
	  console.info(res)
	}
})

$('#product110').on('change','input',function(e){
	if($(this).is(':checked')){
		$(this).parents('li').siblings().find('input').prop('checked',false)
		$('#product_i').prop('value',$(this).prop('value'))
		$('.product_select').children('div').css('border','1px dashed #D5DBE8')
		$('.product_select').children('div').text($(this).parent()[0].innerText)
	}else{
		$('#product_i').prop('value','')
		$('.product_select').children('div').text('')
		$('.product_select').children('div').css('border','0')
	}
})

$('.product_select').click(function(){
	if($('#product110').css('display')=='none'){
		$('#product110').css('display','block')
	}else{
		$('#product110').css('display','none')
	}
})

 //选择产品ajax请求 
function check(){
  var name = $('input[name="name"]').val()
  var rate = $('input[name="rate"]').val()
  var money = $('input[name="money"]').val()
  if(name == ''){
    layer.msg('等级名称不能为空',{time:2000})
    return false
  }

  if(rate == ''){
    layer.msg('折率不能为空',{time:2000})
    return false
  }else if(rate <= 0){
    layer.msg('折率必须大于0',{time:2000})
    return false
  }

  if(money == ''){
    layer.msg('费用不能为空',{time:2000})
    return false
  }else if(money <= 0){
    layer.msg('费用必须大于0',{time:2000})
  }

  $.ajax({
    type:'POST',
    datatype:'json',
    data:$('#form1').serialize(),
    url:'index.php?module=userlist&action=GradeAdd',
    success:function(data){
        data = JSON.parse(data)
        layer.msg(data.msg,{time:2000})
        if(data.code == 1){
          location.href='index.php?module=userlist&action=Grade'
        }else{
          return false
        }
    },
    error:function(res){
      console.info(res)
    }
  })
}

</script>

{/literal}
</body>
</html>