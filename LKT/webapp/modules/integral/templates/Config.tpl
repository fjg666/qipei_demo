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

<title>积分设置</title>
    {literal}
        <style type="text/css">
            .swivch_bot a{width: 112px!important;padding: 0!important;}
            body{
              background-color: #edf1f5!important;
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
                left: 0px;
                transition: 0.3s;
                box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
            }
            .circle:hover {
                transform: scale(1.2);
                box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
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
        </style>
    {/literal}

</head>
<body>

<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>商城设置</span>
</nav>
<div class="pd-20 page_absolute">
    <div class="swivch page_bgcolor swivch_bot" style="margin-top: 0px;font-size: 16px;">
        <a href="index.php?module=integral" class="btn1" style="border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;border-right: 1px solid #ddd!important;">积分商城</a>
        <a href="index.php?module=integral&action=Config" class="btn1 active1 swivch_active" style="border: none!important;border-top-right-radius: 2px;border-bottom-right-radius: 2px;">商城设置</a>
        <div class="page_bgcolor"></div>
    </div>
    <div class="page_h16"  style="height: 16px!important;"></div>
	
    <form id="form1" name="form1" class="form form-horizontal">
      <div class="config-box">
          <div id="tab-system" class="HuiTab">
              <div class="s-title">
                  基础设置
              </div>
              <div class="text" style="padding-top: 26px;">
                  是否开启积分商城： 
                  <div style="position: relative;top: -25px;left: 130px;width: 20%;">
                      <div class="change_box">
                        <input type="hidden" class="status" name="status" id="status" value="{$status}">
                          <div class="wrap" onclick="up()" is_show="{$status}" style="{if $status==1}background-color:#2890FF;{else}background-color: #ccc;{/if}">
                              <div class="circle" id="circle_" style="{if $status==1}left:30px;{else}left:0px;{/if}"></div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="text" style="padding-top: 20px;">
                  <span>轮播图设置：</span>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div id="sortList" class="upload-preview-list uppre_auto">
                            <div class="upload-preview form_new_img" {if !$bg_img}style="display: none;"{/if}>
                                <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
                                <img src="{$bg_img}" class="upload-preview-img" style="position: absolute;">
                                <input type="hidden" name="imgurls[]" class="file-item-input" value="{$bg_img}">
                            </div>
                        </div>
                        <div data-max='5' class="select-file form_new_file from_i" {if $bg_img}style="display: none;"{/if}>
                          <div>
                            <img data-max='5' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
                            <span class="form_new_span">上传图片</span>
                          </div>
                        </div>
                    </div>
                    <span class="addText">（展示图最多上传一张，建议上传750px*300px的图片）</span>
                </div>
              </div>
          </div>

          <div id="tab-system" class="HuiTab">
            <div class="s-title">规则设置</div>
            <div class="row cl" style="margin-bottom: 40px;    display: flex;    justify-content: center;">
              <div class="formControls col-xs-8 col-sm-10 codes">
                <script id="editor" type="text/plain" name="content" style="width:100%;height:400px;">{$content}</script>
              </div>
            </div>
          </div>
         
			  <div class="page_h10" style="height: 70px!important;position: sticky;bottom: 0;border-top: 1px solid #E9ECEF;padding-top: 15px;margin-top:-10px;background-color: #fff;z-index: 9999;">
				<button class="btn btn-primary radius" style="float: right;margin-right: 100px;width: 112px;height: 36px;border: none;" onclick="check()" type="button" name="mysubmit" >保存</button>
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

<script>
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


    function up(){

        var status_1 = $("#circle_").parent(".wrap").attr("is_show");

        if(status_1 == 0){

            $('#circle_').css('left', '30px'),
            $('#circle_').css('background-color', '#fff'),
            $('#circle_').parent(".wrap").css('background-color', '#2890FF');
            $('#circle_').parent(".wrap").attr("is_show",1);
            $("#status").val(1);
           
        }else{

            $('#circle_').css('left', '0px'),
            $('#circle_').css('background-color', '#fff'),
            $('#circle_').parent(".wrap").css('background-color', '#ccc');
            $('#circle_').parent(".wrap").attr("is_show",0);
            $("#status").val(0);
        }

        var status_1 = $("#circle_").parent(".wrap").attr("is_show");
    }
	
	function check() {

		$.ajax({
			cache: true,
			type: "POST",
			url: 'index.php?module=integral&action=Config',
			data: $('#form1').serialize(),
			async: true,
			success: function (data) {
                data = JSON.parse(data);
                console.log(data)
				if (data.status == 1) {
					layer.msg('设置成功！', {time: 1000},function (){
						location.href = "index.php?module=integral&action=Config";
					});
				} else {
					layer.msg('设置失败请检查！');   
				}
			}
		});
	}

</script>

{/literal}
</body>
</html>