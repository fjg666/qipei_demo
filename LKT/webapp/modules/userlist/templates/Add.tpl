
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<!--<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />-->

<title>砍价设置</title>
    {literal}
        <style type="text/css">
            .swivch_bot a{width: 112px!important;padding: 0!important;}
            body{
              background-color: #edf1f5!important;
            }
            .btn1 {
                padding: 0px 10px;
                height: 36px;
                line-height: 36px;
                display: flex;
                justify-content: center;
                align-items: center;
                float: left;
                color: #6a7076;
                background-color: #fff;
            }

            .active1 {
                color: #fff;
                background-color: #62b3ff;
            }


            .swivch a:hover {
                text-decoration: none;
                background-color:#2481e5!important;;
                color: #fff;
            }

            td a {
                margin:5px;
                float: left;
                padding: 3px 5px;
                height:auto;
            }
            td button {
                margin:4px 0 0 0;
                float: left;
                background: white;
                color:  #DCDCDC;
                border: 1px #DCDCDC solid;
                width:56px;
                height:22px;
            }
            #btn2{
                height: 36px;
                background-color: #77c037!important;
            }
            #btn2:hover{
                background-color: #57a821!important;
                border:1px solid #57a821!important;
            }
            form{
                padding: 0 !important;
                background: none !important;
            }
            .HuiTab{
                background-color: #fff;
                margin-bottom: 10px;
                padding-bottom: 40px;
                height:100vh;
            }
            .s-title{
                font-size: 16px;
                font-weight: bold;
                color: #414658;
                padding: 22px;
                border-bottom: 1px solid #E9ECEF;
            }
            .row .form-label{
                width: 20% !important;
                height: 36px;
                line-height: 33px;
            }
            .unit{
                height: 36px;
                line-height: 33px;
            }
            .input-text[type="number"] {
                width: 350px !important;
            }
            .text{padding-left: 70px;padding-bottom: 12px;}
            .upload-preview-img{width: 90px;height: 90px;}
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
            .form_new_r .inputC{
              width:20px;
            }
            .form_new_r span{
              color: #000000!important;
            }
			
			input::-webkit-input-placeholder { /* WebKit browsers */ 
			color: #999999!important; 
			} 
			input:-moz-placeholder { /* Mozilla Firefox 4 to 18 */ 
			color: #999999!important; 
			} 
			input::-moz-placeholder { /* Mozilla Firefox 19+ */ 
			color: #999999!important; 
			} 
			input:-ms-input-placeholder { /* Internet Explorer 10+ */ 
			color: #999999!important; 
			}
        </style>
    {/literal}

</head>
<body style="display: none">

<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
    <span  style='color: #414658;'>会员管理</span>
      <span  class="c-gray en">&gt;</span>
    <span  style='color: #414658;'>会员等级</span>
     <span  class="c-gray en">&gt;</span>
    <span  style='color: #414658;'>添加会员</span>
</nav>
<div class="page-container" >
    <form name="form1"  id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" >
      <div class="config-box">
          <input type="hidden" name="plug_ins_id" value="" placeholder="111" >
          <div id="tab-system" class="HuiTab">
              <div class="s-title" style="font-size: 16px;color:rgba(65,70,88,1);">
                  添加会员
              </div>
              <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 120px!important;margin-left: 70px;">会员头像：</label>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div>
                           
                                <img src="{$wx_headimgurl}" class="upload-preview-img" style="margin-top: -10px;width: 60px;height: 60px;border-radius: 50%;">
                                <input type="hidden" name="wx_headimgurl" class="file-item-input" value="{$wx_headimgurl}">
                           
                        </div>
                    </div>
                   
                </div>
              </div>
              <div class="row cl" style="margin-top: 10px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 120px!important;margin-left: 70px;">会员昵称：</label>
                  <div class="formControls col-xs-8" >
                      <input type="text" style="width: 180px!important;" name="wx_name" value="{$wx_name}" class="input-text" placeholder="请输入昵称">
                  </div>
              </div>
              <div class="row cl" style="margin-top: 0px;">
                <label class="form-label col-xs-4 col-sm-4"  style="text-align: right!important;width: 120px!important;margin-left: 70px;"> 会员级别：</label>
                <div class="form_new_r" style="margin-top: 1px;">
                 <select name="grade" style="margin-left: 0px!important;width: 180px;">
                  {$str_grade}
                 </select>
                </div>
              </div>
              <div class="row cl method" style="margin-top: 0px;{if $str_method == ''}display: none;{/if}" >
                <label class="form-label col-xs-4 col-sm-4"  style="text-align: right!important;width: 120px!important;margin-left: 70px;"> 续费时间：</label>
                <div class="form_new_r" style="margin-top: 1px;">
                 <select name="method" style="margin-left: 0px!important;width: 180px;">
                   {$str_method}
                 </select>
                </div>
              </div>
              <div class="row cl" style="margin-top: 0px;">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 120px!important;margin-left: 70px;">会员账号：</label>
                <div class="formControls col-xs-8" >
                    <input type="text" style="width: 180px!important;" name="zhanghao" value="" class="input-text" placeholder="请输入账号">
                </div>
              </div>
              <div class="row cl" style="margin-top: 0px;">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 120px!important;margin-left: 70px;">会员密码：</label>
                <div class="formControls col-xs-8" >
                    <input type="password" style="width: 180px!important;" name="mima" value="" class="input-text" placeholder="请输入密码">
                </div>
              </div>
              <div class="row cl" style="margin-top: 0px;">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 120px!important;margin-left: 70px;">确认密码：</label>
                <div class="formControls col-xs-8" >
                    <input type="password" style="width: 180px!important;" name="mima2" value="" class="input-text" placeholder="请再次出入会员密码">
                </div>
              </div>
              <div class="row cl" style="margin-top: 0px;">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 120px!important;margin-left: 70px;">手机号码：</label>
                <div class="formControls col-xs-8" >
                    <input type="text" style="width: 180px!important;" name="mobile" value="" class="input-text" placeholder="请输入手机号码">
                </div>
              </div>
              <div class="row cl" style="margin-top: 0;">
                <label class="form-label col-xs-4 col-sm-4"  style="text-align: right!important;width: 120px!important;margin-left: 70px;"> 账号来源：</label>
                <div class="form_new_r" style="margin-top: 1px;">
                 <select name="source" style="margin-left: 0px!important;width: 180px;">
                   <option value="1">小程序</option>
                   <option value="2">App</option>
                 </select>
                </div>
              </div>
          </div>

      
          <div class="page_h10" style="height: 70px!important;position: sticky;bottom: 0;border-top: 1px solid #E9ECEF;padding-top: 15px;margin-top:-10px;background-color: #fff;z-index: 9999;">
              <button class="btn btn-primary radius" style="float: right;margin-right: 100px;width: 112px;height: 36px;border: none;" type="button" name="mysubmit" onclick="check()">添加</button>
          </div>
         
      </div>
    </form>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{literal}
<script type="text/javascript">
 {/literal}
 var str_method = '{$str_method}'
 {literal} 
document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}

    $(function(){
        var ue = UE.getEditor('editor');

        $("input[name='imgurls[]']").on("change",function(e){
            var val = $(this).val();
            if (val.length > 0) {
              $('.form_new_file').css('display','none');
            }
        });

        $('.file-item-delete-pp').on('click',function(){
            $('.form_new_file').css('display','flex');
        })

    });

    $(function(){
     let grade = $("select[name= 'grade']").val()
     if(grade == 0){
        $('.method').hide()
     }
     $('body').css('display','block')
    })

    //会员级别判断
    $("select[name= 'grade']").on('change',function(){
      let grade = $(this).val()
      if(grade == 0){
        $('.method').hide()
      }else{
        if(str_method != ''){
           $('.method').show()
        }
       
      }
    })

    function check(){
      //非空判断
      let wx_name = $("input[name='wx_name']").val() 
      let zhanghao = $("input[name='zhanghao']").val()
      let mima = $("input[name='mima']").val()
      let mima2 = $("input[name='mima2']").val()
      let mobile = $("input[name='mobile']").val()
      if(!wx_name){
        layer.msg('用户昵称不能为空',{time:2000})
        return false
      }else if(!zhanghao){
        layer.msg('账号不能为空',{time:2000})
        return false
      }else if(!mima){
        layer.msg('密码不能为空',{time:2000})
        return false
      }else if(!mima2){
        layer.msg('确认密码不能为空',{time:2000})
        return false
      }else if(!mobile){
        layer.msg('手机号不能为空',{time:2000})
        return false
      }else if(mima != mima2){
       layer.msg('两次出入密码不一致',{time:2000})
        return false
      }else if(mima.length < 6){
        layer.msg('密码应为六位数的字母或数字',{time:2000})
        return false
      }
      var reg = /^[0-9a-zA-Z]+$/
     
      if(!reg.test(zhanghao)){
         layer.msg('你输入的字符不是数字或者字母',{time:2000})
         return false
      }

      $.ajax({

      type:'POST',
      datatype:'json',
      data:$('#form1').serialize(),
      url:'index.php?module=userlist&action=Add',
      success:function(data){
          data = JSON.parse(data)
          layer.msg(data.msg,{time:2000})
          if(data.code == 1){
            location.href='index.php?module=userlist'
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