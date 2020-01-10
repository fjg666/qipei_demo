
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

<title>会员设置</title>
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
        </style>
    {/literal}

</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>会员管理</span>
	<span><span class='arrows'>&gt;</span>会员设置</span>
</nav>
<div class="iframe-content">
    <div class="navigation">
    	<div>
    		<a href="index.php?module=userlist&action=Index">会员列表</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=userlist&action=Grade">会员等级</a>
    	</div>
    	<p class='border'></p>
    	<div class='active'>
    		<a href="index.php?module=userlist&action=Config">会员设置</a>
    	</div>
    </div>
    <div class="hr"></div>
    <form name="form1" id="form1" action="index.php?module=userlist&action=Config" class="form form-horizontal form-scroll" method="post"   enctype="multipart/form-data" style='flex: 1;'>
      <div class="config-box">
          <input type="hidden" name="plug_ins_id" value="" placeholder="111" >
          <div id="tab-system" class="HuiTab">
              <div class="s-title" style="font-size: 16px;color:rgba(65,70,88,1);">
                  基础设置
              </div>
              <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">默认头像设置：</label>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div id="sortList" class="upload-preview-list uppre_auto">
                            <div class="upload-preview form_new_img" {if !$wx_headimgurl}style="display: none;"{/if}>
                                <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
                                <img src="{$wx_headimgurl}" class="upload-preview-img" style="margin-top: -23px;width: 78px;height: 78px;">
                                <input type="hidden" name="wx_headimgurl" class="file-item-input" value="{$wx_headimgurl}">
                            </div>
                        </div>
                        <div data-max='2' class="select-file form_new_file from_i" {if $wx_headimgurl}style="display: none;"{/if}>
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
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">默认昵称设置：</label>
                  <div class="formControls col-xs-8" >
                      <input type="text" style="width: 150px!important;" name="wx_name" value="{$wx_name}" class="input-text" placeholder="请输入昵称">
                  </div>
              </div>
              <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">积分设置：</label>
                  <div class="formControls col-xs-8" >
                      <input type="text" style="width: 150px!important;" name="score" value="{$score}" class="input-text" placeholder="积分有效时间">
                      <span class="addText">天后过期（为0则不过期）</span>
                  </div>
              </div>
              <div class="row cl">
                <label class="form-label col-2" style="text-align: right!important;width: 150px!important;margin-left: 70px;">是否续费提醒：</label>
                <div class="formControls col-2">
                    <div class="status_box1">
                        <input type="hidden" class="status1" name="is_auto" id="is_auto" value="{$is_auto}">
                        <div class="wrap wrap1">
                            <div class="circle circle1"></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row cl my_fee" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;;width: 150px!important;margin-left: 70px;">续费提醒：</label>
                  <div class="formControls col-xs-8" >
                      <span>自动续费到期前</span>
                      <input type="text" style="width: 150px!important;" name="auto_time" value="{$auto_time}" class="input-text" placeholder="请输入天数">
                  </div>
                  <span class="unit">天，每次登陆时，自动弹窗提示</span>
              </div>
              <div class="row cl form_li formListSD" style="margin-bottom: 20px;">
                  <label class="form-label col-xs-4 col-sm-4"  style="text-align: right!important;width: 150px!important;margin-left: 70px;"> 开通方式：</label>
                    <div class="form_new_r" style="margin-top: 1px;">
                     {$str_method}

                    </div>
              </div>
              <div class="row cl form_li formListSD" style="margin-bottom: 20px;">
                  <label class="form-label col-xs-4 col-sm-4"  style="text-align: right!important;width: 150px!important;margin-left: 70px;"> 可支持插件：</label>
                    <div class="form_new_r" style="margin-top: 1px;">
                        <table >
                            <thead>
                            <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                <th width="40" style="border-bottom: 0px solid #d5dbe8!important;height: 0px;">
                                    <div style="position: relative;display: flex;height: 30px;align-items: center;float: left;">
                                        <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
                                        <label for="ipt1"></label>
                                        <span >全选</span>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                              <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                  <td style="height: 0px;">
                                      <div style="display: flex;align-items: center;float: left;">
                                          <input name="active[]"  id="type_1" type="checkbox" class="inputC " value="1" {if in_array(1,$active)}checked{/if}>
                                          <label for="type_1"></label>
                                          <span >正价商品</span>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                  <td style="height: 0px;">
                                      <div style="display: flex;align-items: center;float: left;">
                                          <input name="active[]"  id="type_2" type="checkbox" class="inputC " value="2" {if in_array(2,$active)}checked{/if}>
                                          <label for="type_2"></label>
                                          <span >拼团商品</span>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                  <td style="height: 0px;">
                                      <div style="display: flex;align-items: center;float: left;">
                                          <input name="active[]"  id="type_3" type="checkbox" class="inputC " value="3" {if in_array(3,$active)}checked{/if}>
                                          <label for="type_3"></label>
                                          <span >砍价商品</span>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                  <td style="height: 0px;">
                                      <div style="display: flex;align-items: center;float: left;">
                                          <input name="active[]"  id="type_4" type="checkbox" class="inputC " value="4" {if in_array(4,$active)}checked{/if}>
                                          <label for="type_4"></label>
                                          <span >竞拍商品</span>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                  <td style="height: 0px;">
                                      <div style="display: flex;align-items: center;float: left;">
                                          <input name="active[]"  id="type_5" type="checkbox" class="inputC " value="5" {if in_array(5,$active)}checked{/if}>
                                          <label for="type_5"></label>
                                          <span >分销商品</span>
                                      </div>
                                  </td>
                              </tr>
                              <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                  <td style="height: 0px;">
                                      <div style="display: flex;align-items: center;float: left;">
                                          <input name="active[]"  id="type_6" type="checkbox" class="inputC " value="6" {if in_array(6,$active)}checked{/if}>
                                          <label for="type_6"></label>
                                          <span >秒杀商品</span>
                                      </div>
                                  </td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
              </div>
              <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">是否开余额支付：</label>
                <div class="form_new_r" style="margin-top: -4px;">
                  <div class="ra1" style="margin-top: 7px;">
                      <input style="display: none;" class="inputC1" type="radio" name="is_wallet" id="see_1" value="1" {if $is_wallet == '1'}checked="checked"{/if} >
                      <label for="see_1">是</label>
                  </div>
                  <div class="ra1" style="margin-top: 7px;">
                      <input style="display: none;" class="inputC1" type="radio" name="is_wallet" id="see_2" value="0" {if $is_wallet != '1'}checked="checked"{/if} >
                      <label for="see_2">否</label>
                  </div>
                </div> 
              </div>
              <div class="row cl form_li formListSD" style="margin-bottom: 20px;">
                  <label class="form-label col-xs-4 col-sm-4"  style="text-align: right!important;width: 150px!important;margin-left: 70px;"> 等级晋升设置：</label>
                    <div class="form_new_r" style="margin-top: 1px;">
                       <div class="ra1">
                         <input name="upgrade[]" type="checkbox"  id="sex-4" class="inputC" checked="checked"  value="1"><label style="width: 120px!important;" for="sex-4">购买会员服务</label>
                       </div>
                       <div class="ra1">
                         <input name="upgrade[]" {if in_array(2,$upgrade)}checked{/if} type="checkbox" style="width: 150px!important;" id="sex-5" class="inputC"   value="2"><label style="width: 120px!important;" for="sex-5">补差额升级</label>
                       </div>
                    </div>
              </div>
              <div class="row cl">
                <label class="form-label col-2" style="text-align: right!important;width: 150px!important;margin-left: 70px;">会员生日特权：</label>
                <div class="formControls col-2">
                    <div class="status_box2">
                        <input type="hidden" class="status2" name="is_birthday" id="is_birthday" value="{$is_birthday}">
                        <div class="wrap2">
                            <div class="circle2"></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row cl my_bir" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;;width: 150px!important;margin-left: 70px;">续费提醒：</label>
                  <div class="formControls col-xs-8" >
                      <span>购买会员后，会员单天购买任意商品即可获得商品付款金额的</span>
                      <input type="text" style="width: 150px!important;" name="bir_multiple" value="{$bir_multiple}" class="input-text" placeholder="请输入倍数">
                  </div>
                  <span class="unit">倍积分</span>
              </div>
              <div class="row cl">
                <label class="form-label col-2" style="text-align: right!important;width: 150px!important;margin-left: 70px;">会员等比例积分：</label>
                <div class="formControls col-2">
                    <div class="status_box4">
                        <input type="hidden" class="status4" name="is_jifen" id="is_jifen" value="{$is_jifen}">
                        <div class="wrap4">
                            <div class="circle4"></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">积分发放：</label>
                <div class="form_new_r" style="margin-top: -4px;">
                  <div class="ra1" style="margin-top: 7px;">
                      <input style="display: none;" class="inputC1" type="radio" name="jifen_m" id="see_3" value="1" {if $jifen_m == '1'}checked="checked"{/if} >
                      <label for="see_3">收货后</label>
                  </div>
                  &nbsp; &nbsp; &nbsp; &nbsp;
                  <div class="ra1" style="margin-top: 7px;">
                      <input style="display: none;" class="inputC1" type="radio" name="jifen_m" id="see_4" value="0" {if $jifen_m != '1'}checked="checked"{/if} >
                      <label for="see_4">付款后</label>
                  </div>
                </div> 
              </div>
              <div class="row cl">
                <label class="form-label col-2" style="text-align: right!important;width: 150px!important;margin-left: 70px;">会员赠送商品：</label>
                <div class="formControls col-2">
                    <div class="status_box3">
                        <input type="hidden" class="status3" name="is_product" id="is_product" value="{$is_product}">
                        <div class="wrap3">
                            <div class="circle3"></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row cl my_send" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">赠送商品有效期：</label>
                  <div class="formControls col-xs-8" >
                      <input type="number" style="width: 150px!important;" name="valid" value="{$valid}" class="input-text" placeholder="请输入天数">
                  </div>
                  <span class="unit">天</span>
              </div>
              <div class="row cl">
                <label class="form-label col-2" style="text-align: right!important;width: 150px!important;margin-left: 70px;">会员百分比返现：</label>
                <div class="formControls col-2">
                    <div class="status_box5">
                        <input type="hidden" class="status5" name="back" id="back" value="{$back}">
                        <div class="wrap5">
                            <div class="circle5"></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row cl my_back" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;;width: 150px!important;margin-left: 70px;"></label>
                  <div class="formControls col-xs-8" >
                      <span>返现百分比</span>
                      <input type="text" style="width: 150px!important;" name="back_scale" value="{$back_scale}" class="input-text" placeholder="请输入比例">
                  </div>
                  <span class="unit">%</span>
              </div>
              <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;width: 150px!important;margin-left: 70px;">分享海报设置：</label>
                  <div class="formInputSD upload-group multiple" style="display: inline-flex;">
                    <div style="display: flex;">
                        <div  class="upload-preview-list uppre_auto">
                            <div class="upload-preview form_new_img" {if !$poster}style="display: none;"{/if}>
                                <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp two_img" />
                                <img src="{$poster}" class="upload-preview-img" style="margin-top: -23px;width: 78px;height: 78px;">
                                <input type="hidden" name="poster" class="file-item-input" value="{$poster}">
                            </div>
                        </div>
                        <div data-max='2' class="select-file form_new_file two from_i" {if $poster}style="display: none;"{/if}>
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
                <label class="form-label col-2" style="text-align: right!important;width: 150px!important;margin-left: 70px;">会员推荐限制：</label>
                <div class="formControls col-2">
                    <div class="status_box6">
                        <input type="hidden" class="status6" name="is_limit" id="is_limit" value="{$is_limit}">
                        <div class="wrap6">
                            <div class="circle6"></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="row cl my_limit" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;;width: 150px!important;margin-left: 70px;"></label>
                  <div class="formControls col-xs-8" >
                      <span>限制等级选择</span>
                      <select style="width: 150px!important;" name="level" class="select"> 
                         <option value="">请选择等级</option>
                        {foreach from=$grade item=item }
                          <option value="{$item->id}" {if $item->id == $level} selected="selected"{/if}>{$item->name}</option>
                        {/foreach}
                      </select>
                  </div>
                 
              </div>
              <div class="row cl" style="margin-top: 30px;">
                  <label class="form-label col-xs-4 col-sm-4" style="text-align: right!important;;width: 150px!important;margin-left: 70px;">参与分销限制：</label>
                  <div class="formControls col-xs-8" >
                      <select style="width: 150px!important;" name="distribute_l" class="distribute_l"> 
                         <option value="0">普通会员</option>
                        {foreach from=$grade item=item }
                          <option value="{$item->id}" {if $item->id == $distribute_l} selected="selected"{/if}>{$item->name}</option>
                        {/foreach}
                      </select>
                  </div>
                 
              </div>



          </div>   
          <div id="tab-system" class="HuiTab" style='margin-bottom: 0;'>
            <div class="s-title">会员权益</div>
            <div class="row cl" style="margin-bottom: 40px;    display: flex;    justify-content: center;">
              <div class="formControls col-xs-8 col-sm-10 codes">
                <script id="editor" type="text/plain" name="rule" style="width:100%;height:400px;">{$rule}</script>
              </div>
            </div>
          </div>
         
              <div class="page_h10" style="height: 70px!important;position: sticky;bottom: 0;border-top: 1px solid #E9ECEF;padding-top: 15px;margin-top:-10px;background-color: #fff;z-index: 9999;">
                  <button class="btn btn-primary radius" style="float: right;margin-right: 60px;width: 112px;height: 36px;border: none;" type="button" name="mysubmit" onclick="check()" >保存</button>
              </div>
         
      </div>
    </form>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
</div>

<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{literal}
<style>
.wrap1 {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

.circle1 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.wrap2 {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

.circle2 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.wrap3 {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

  .circle3 {
      width: 29px;
      height: 29px;
      background-color: #fff;
      border-radius: 50%;
      position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.wrap4 {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

.circle4 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.wrap5 {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

.circle5 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.wrap6 {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}

.circle6 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    left: 0px;
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
</style>
<script>
  $("#sex-4").on('click',function(){
    alert('该项为必填项')
    return false
  })
  //重写alert关闭弹窗方式
  function closeMask1(){
     $(".maskNew").remove();
    return false
  }
document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}
//js开关控制 第一个
if (document.getElementById('is_auto').value == 0) {
    $('.circle1').css('left', '0px'),
        $('.circle1').css('background-color', '#fff'),
        $('.circle1').parent(".wrap1").css('background-color', '#ccc');
} else {
    $('.circle1').css('left', '30px'),
        $('.circle1').css('background-color', '#fff'),
        $('.circle1').parent(".wrap1").css('background-color', '#5eb95e');
}
$('.circle1').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status1 = $(this).parents(".status_box1").children(".status1");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap1").css('background-color', '#5eb95e');
        status1.val(1);
    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap1").css('background-color', '#ccc');
        status1.val(0);
    }
})

//js开关控制 第二个
if (document.getElementById('is_birthday').value == 0) {
    $('.circle2').css('left', '0px'),
        $('.circle2').css('background-color', '#fff'),
        $('.circle2').parent(".wrap2").css('background-color', '#ccc');
    $(".wrap_box").hide();
} else {
    $('.circle2').css('left', '30px'),
        $('.circle2').css('background-color', '#fff'),
        $('.circle2').parent(".wrap2").css('background-color', '#5eb95e');
    $(".wrap_box").show();
}
$('.circle2').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status2 = $(this).parents(".status_box2").children(".status2");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap2").css('background-color', '#5eb95e');
        $(".wrap_box").show();
        status2.val(1);
    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap2").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status2.val(0);
    }
})

//js开关控制 第三个
if (document.getElementById('is_product').value == 0) {
    $('.circle3').css('left', '0px'),
        $('.circle3').css('background-color', '#fff'),
        $('.circle3').parent(".wrap3").css('background-color', '#ccc');
} else {
    $('.circle3').css('left', '30px'),
        $('.circle3').css('background-color', '#fff'),
        $('.circle3').parent(".wrap3").css('background-color', '#5eb95e');
}
$('.circle3').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status3 = $(this).parents(".status_box3").children(".status3");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap3").css('background-color', '#5eb95e');
        status3.val(1);
    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap3").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status3.val(0);
    }
})
//js开关控制 第四个
if (document.getElementById('is_jifen').value == 0) {
    $('.circle4').css('left', '0px'),
        $('.circle4').css('background-color', '#fff'),
        $('.circle4').parent(".wrap4").css('background-color', '#ccc');
} else {
    $('.circle4').css('left', '30px'),
        $('.circle4').css('background-color', '#fff'),
        $('.circle4').parent(".wrap4").css('background-color', '#5eb95e');
}
$('.circle4').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status4 = $(this).parents(".status_box4").children(".status4");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap4").css('background-color', '#5eb95e');
        status4.val(1);
    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap4").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status4.val(0);
    }
})

//js开关控制 第五个
if (document.getElementById('back').value == 0) {
    $('.circle5').css('left', '0px'),
        $('.circle5').css('background-color', '#fff'),
        $('.circle5').parent(".wrap5").css('background-color', '#ccc');
} else {
    $('.circle5').css('left', '30px'),
        $('.circle5').css('background-color', '#fff'),
        $('.circle5').parent(".wrap5").css('background-color', '#5eb95e');
}
$('.circle5').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status5 = $(this).parents(".status_box5").children(".status5");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap5").css('background-color', '#5eb95e');
        status5.val(1);
    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap5").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status5.val(0);
    }
})

//js开关控制 第六个
if (document.getElementById('is_limit').value == 0) {
    $('.circle6').css('left', '0px'),
        $('.circle6').css('background-color', '#fff'),
        $('.circle6').parent(".wrap6").css('background-color', '#ccc');
} else {
    $('.circle6').css('left', '30px'),
        $('.circle6').css('background-color', '#fff'),
        $('.circle6').parent(".wrap6").css('background-color', '#5eb95e');
}
$('.circle6').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status6 = $(this).parents(".status_box6").children(".status6");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap6").css('background-color', '#5eb95e');
        status6.val(1);
    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap6").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status6.val(0);
    }
})


//编辑器初始化
    $(function(){
        var ue = UE.getEditor('editor');
        //第一张图片
        $("input[name='wx_headimgurl']").on("change",function(e){
            var val = $(this).val();
            if (val.length > 0) {
              $('.form_new_file').css('display','none');
            }
        });

        $('.file-item-delete-pp').on('click',function(){
            $('.form_new_file').css('display','flex');
        })
        //第二张图片
        $("input[name='poster']").on("change",function(e){
          var val = $(this).val();
          if (val.length > 0) {
            $('.two').css('display','none');
          }
        });

        $('.two_img').on('click',function(){
            $('.two').css('display','flex');
        })


    });
//全选按钮控制    
$(function(){
  var flag = true
  $("input[name='active[]']").each(function(){
    if($(this).prop("checked") == false){
      flag = false
    }
  })
  if(flag){
      $("input[name='ipt1']").prop("checked",true)
  }else{
    $("input[name='ipt1']").prop("checked",false)
  }

})    
//可支持插件全选控制
$("input[name='active[]']").on('click',function(){
    var my_flag = $(this).prop("checked");
    if(my_flag == false){
      $("input[name='ipt1']").prop("checked",false)
	  return
    }
	
	var iptArr = $("input[name='active[]']")
	var iptFlag = true
	for(var i=0;i<iptArr.length;i++){
		if(!$(iptArr).eq(i).prop("checked")){
			iptFlag=false
			break
		}
	}
	$("input[name='ipt1']").prop("checked",iptFlag)
})

//自动续费提醒开关控制
$(function(){
   let flag1 = $("input[name='is_auto']").val()
   if(flag1 != 1){
     $('.my_fee').hide()
   }
})
$('.circle1').on('click',function(){
  let flag2 = $("input[name='is_auto']").val()
  if(flag2 == 1){
    $('.my_fee').show()
  }else{
    $('.my_fee').hide()
  }
})

//会员生日开关显示控制
$(function(){
   let flag1 = $("input[name='is_birthday']").val()
   if(flag1 != 1){
     $('.my_bir').hide()
   }
})
$('.circle2').on('click',function(){
  let flag2 = $("input[name='is_birthday']").val()
  if(flag2 == 1){
    $('.my_bir').show()
  }else{
    $('.my_bir').hide()
  }
})


//会员赠送商品开关
$(function(){
  let flag1 = $("input[name='is_product']").val()
  if(flag1 != 1){
    $('.my_send').hide()
  }
})
$('.circle3').on('click',function(){
  let flag2 = $("input[name='is_product']").val()
  if(flag2 == 1){
    $('.my_send').show()
  }else{
    $('.my_send').hide()
  }
})

//会员返现比例开关显示控制
$(function(){
  let flag1 = $("input[name='back']").val()
  if(flag1 != 1){
    $('.my_back').hide()
  }
})

$('.circle5').on('click',function(){
  let flag2 = $("input[name='back']").val()
  if(flag2 == 1){
    $('.my_back').show()
  }else{
    $('.my_back').hide()
  }
})
//会员等级限制开关显示控制
$(function(){
   let flag1 = $("input[name='is_limit']").val()
   if(flag1 != 1){
      $('.my_limit').hide()
   }
})
$('.circle6').on('click',function(){
  let flag2 = $("input[name='is_limit']").val()
  if(flag2 == 1){
    $('.my_limit').show()
  }else{
    $('.my_limit').hide()
  }
})

 function check(){

      $.ajax({
     
        type:'POST',
        dataType:'json',
        data:$('#form1').serialize(),
        url:'index.php?module=userlist&action=Config',
        success:function(data){
          console.info(data);
          layer.msg(data.msg,{time:2000});
          if(data.code == 1){
            location.href = "index.php?module=userlist";
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