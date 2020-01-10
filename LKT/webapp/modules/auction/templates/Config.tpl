
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

<title>竞拍配置</title>
    {literal}
        <style type="text/css">
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
            /*.config-box{*/
                /*background-color: #fff;*/
                /*padding: 10px;*/
            /*}*/
            .HuiTab{
                background-color: #fff;
                padding: 10px;
                margin-bottom: 20px;
            }
            .s-title{
                border-bottom: 2px #e0dfdf solid;
                height: 40px;
                line-height: 40px;
                padding: 5px 0 10px 20px;
                font-size: 18px;
                font-weight: bold;
                color: #666;
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
            .addText{
                  color: rgb(151, 160, 180);
                  margin-left: 10px;
                  font-size: 14px !important;
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
              /*  left: 0px; */
                transition: 0.3s;
                box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
            }

            .circle:hover {
                transform: scale(1.2);
                box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
            }
        </style>
    {/literal}

</head>
<body>

<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
  
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>竞拍</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>竞拍设置</span>
</nav>
<div class="page-container" style="padding-bottom: 0px!important;">
    <div class="swivch page_bgcolor swivch_bot" style="margin-top: -26px;font-size: 16px;">
        <a href="index.php?module=auction" class="btn1" style="height: 42px!important;width: 91px;border: none!important;border-top-left-radius: 3px;
    border-bottom-left-radius: 3px;">竞拍商品</a>
        <a href="index.php?module=auction&action=Config" class="btn1 active1 swivch_active" style="height: 42px!important;width: 90px;border:none!important;border-top-right-radius: 3px;border-bottom-right-radius: 3px;">竞拍设置</a>
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"  style="height: 16px!important;"></div>
    <form name="form1" id="form1"  class="form form-horizontal" method="post"   enctype="multipart/form-data" >
      <div class="config-box">
          <input type="hidden" name="plug_ins_id" value="" placeholder="111" >
          <div id="tab-system" class="HuiTab" style="padding: 10px 0!important;">
              <div class="s-title" style="font-size: 16px;color:rgba(65,70,88,1);">
                  基础设置
              </div>
              <div class="row cl" style="margin-top: 30px;display: flex;align-items: center;">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: left!important;width: 110px!important;margin-left: 70px;margin-top: 0;">是否开启插件：</label>
                <div class="formControls col-xs-8">
                   <div class="status_box">
                            <input type="hidden" class="open" name="is_open" id="is_open" value="{$is_open}">
                            <div class="wrap" style="margin-left: 0;{if $is_open==1}background-color:#2890FF;{else}background-color: #ccc;{/if}" {if $is_open>0}wopen{else}wclose{/if}>
                                <div class="circle {if $is_open>0}copen{else}cclose{/if}" style="{if $is_open==1}left:30px;{else}left:0px;{/if}"></div>
                            </div>
                   </div>
                </div>
              </div>
              <div class="row cl">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: left!important;width: 110px!important;margin-left: 70px;">最低开拍人数：</label>
                  <div class="formControls col-xs-8" >
                      <input type="number" style="width: 150px!important;" name="low_pepole" value="{$low_pepole}" class="input-text" placeholder="请输入最低开拍人数">
                  </div>
                  <span class="unit">人</span>
              </div>
              <div class="row cl">
                  <label class="form-label col-xs-4 col-sm-4"  style="text-align: left!important;width: 110px!important;margin-left: 70px;">出价等待时间：</label>
                  <div class="formControls col-xs-8 ">
                      <input type="number" name="wait_time" style="width: 150px!important;" value="{$wait_time}" class="input-text" placeholder="请输入出价等待时间">
                  </div>
                  <span class="unit">秒</span>
              </div>    
              <div class="row cl" style="margin-bottom: 20px;">
                  <label class="form-label col-xs-4 col-sm-4"  style="text-align: left!important;width: 110px!important;margin-left: 70px;padding-left: 28px;"> 保留天数：</label>
                  <div class="formControls col-xs-8 ">
                      <input type="number" style="width: 150px!important;" name="days" value="{$days}" class="input-text" placeholder="请输入保留天数">
                  </div>
                  <span class="unit">天</span>&nbsp;<span class="addText" >（活动结束后在竞拍列表保留的天数，默认为七天）</span>
              </div>
             
          </div>
         
          <div id="tab-system" class="HuiTab" style="margin-top: -10px!important;padding: 10px 0!important;">
              <div class="s-title" style="font-size: 16px;color:rgba(65,70,88,1);">
                  规则设置
              </div>

              <div class="row cl" style="margin-bottom: 40px;padding-left: 50px;display: flex;justify-content: center;margin-top: 30px;">
                  <div class="formControls" style="padding: 15px 20px 0px 20px;width: 85%;margin-left: -13%;">
                      <script id="editor" type="text/plain" name="content" style="width:100%;height:500px;">{$content}</script>
                  </div>
              </div>

          </div>
          <div class="page_h10" style="height: 48px!important;width: 100%;position: sticky;bottom: 0;border-top: 1px solid rgba(180, 180, 180, 0.4);padding-top: 15px;margin-top:-20px;background-color: #fff;z-index: 9999;">
              <button class="btn btn-primary radius" style="float: right;margin-right: 60px!important;width: 112px;height: 36px;" type="button" name="mysubmit" onclick="check()">保存</button>
             <!--  <button class="btn btn-default radius" type="button"  style="float: right;margin-right: 10px;width: 112px;height: 36px;"  onclick="window.history.go(-1)">取消</button> -->
          </div><!-- ta_btn4 -->
         
      </div>
    </form>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>

<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{literal}

<script>
    $(function(){
        var ue = UE.getEditor('editor');
    });
    $('.circle').click(function () {
        var left = $(this).css('left');
        left = parseInt(left);
        var open = $(this).parents(".status_box").children(".open");
        if (left == 0) {
            $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap").css('background-color', '#2890FF');
            $(open).val(1);
        } else {
            $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap").css('background-color', '#ccc');
            $(open).val(0);
        }
    })
    if (document.getElementById('is_open').value == 0) {
        $('.circle').css('left', '0px'),
        $('.circle').css('background-color', '#fff'),
        $('.circle').parent(".wrap").css('background-color', '#ccc');
    } else {
        $('.circle').css('left', '30px'),
        $('.circle').css('background-color', '#fff'),
        $('.circle').parent(".wrap").css('background-color', '#2890FF');
    }

    function check(){

      $.ajax({
     
        type:'POST',
        dataType:'json',
        data:$('#form1').serialize(),
        url:'index.php?module=auction&action=Config',
        success:function(data){
          console.info(data);
          layer.msg(data.msg,{time:2000});
          if(data.suc){
            location.href = "index.php?module=auction";
          }
        },
        error:function(res){
            console.info(res);
        }

      })
    }
</script>

{/literal}
</body>
</html>