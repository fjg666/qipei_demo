<?php /* Smarty version 2.6.31, created on 2019-12-20 15:40:47
         compiled from index.tpl */ ?>
<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-08-27 18:31:49
 * @LastEditTime: 2019-11-20 15:38:47
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
    
    <LINK rel="Bookmark" href="/favicon.ico">
    <LINK rel="Shortcut Icon" href="/favicon.ico"/>
    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>
    <link href="style/skin/default/skin.css" rel="stylesheet" type="text/css" id="skin"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="style/js/message.js"></script>
    <link rel="stylesheet" type="text/css" href="style/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/css/message.css">
    <link rel="stylesheet" href="style/css/changeIndex.css"/>
    <link rel="stylesheet" href="resource/components/select2/select2.min.css"/>
        <title>来客电商管理系统</title>
    <?php echo '
        <style type="text/css">
            #changeImgText{position: absolute;display: inline-block;width: 28px;height: 28px;
            font-size: 14px;top: 8px;left: 15px;color: #fff;pointer-events: none;}
            #changeStoreImg{height: 60px!important;width: 60px!important;padding: 0;opacity: 0;}
            #changeImgBtn{
                width: 60px!important;
                height: 60px!important;
                border-radius: 50%;
                position: absolute;
                left: 0;
                top: 0;
                background:rgba(0,0,0,0.4);
                display: none;
            }
            .textInput{
                height: 72px!important;
                border:1px solid #d5dbe8;
                width: 85%;
            }
            .changeStoreImg{
                position: absolute;border-radius: 50%;width: 60px;height: 60px;color: #fff;top: 0;background: rgba(0,0,0,0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                box-sizing: border-box;
                padding: 10px 15px;
                cursor: pointer;
                display: none;
            }
            .closeImg{position: absolute;top: 16px;right: 15px;}
            .inp_maie {
                height: 32px;
                width: 20% !important;
                margin-top: 0px !important;
                padding-left: 10px;
                margin-left: 10px;
            }

            .maskLeft {
                width: 25%;
                float: left;
                text-align: right;
                padding-right: 20px;
                height: 36px;
                line-height: 36px;
            }

            .maskRight {
                width: 60%;
                float: left;
            }

            .ipt1 {
                padding-left: 10px;
                width: 300px;
                height: 36px;
                border: 1px solid #eee;
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

            .bk_2 {
                /*overflow: scroll;*/
            }

            .bk_2::-webkit-scrollbar {
                display: none;
            }

            .Hui-article {
                top: 65px;
            }

            #Hui-tabNav {
                height: 65px;
                background: none;
            }

            .topTitle {
                display: inline-block;
                height: 65px;
                line-height: 65px;
                font-size: 18px;
                padding-left: 30px;
                color: #414658;
                position: relative;
                top: -35px;
            }

            .Hui-userbar li a img {
                width: 18px;
                height: 18px;
            }

            .userIdImg {
                width: 35px !important;
                height: 35px !important;
                border-radius: 50%;
            }

            .dropDown-menu li {
                height: 40px;
                line-height: 40px;
            }

            .dropDown-menu li a {
                height: 40px;
                line-height: 40px;
            }

            .dropDown-menu li a:hover {
                background: #f6f7f8;
            }

            .dropDown_A:hover {
                background: none !important;
            }

            .Hui-userbar > li > a:hover, .Hui-userbar > li.current > a {
                background-color: none !important;
            }

            .sp5 dt {
                border-left: 3px solid #008DEF;
                box-sizing: border-box;
            }

            .mask1 {
                position: absolute;
                z-index: 9999999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                display: none;
            }

            .mask1Content {
                width: 500px;
                height: 300px;
                margin: 0 auto;
                position: relative;
                top: 200px;
                background: #fff;
                border-radius: 10px;
            }

            .closeMask {
                /*width: 100px;
                height: 50px;
                border: 1px solid #eee;
                border-radius: 5px;
                background: #008DEF;
                color: #fff;
                font-size: 16px;
                line-height: 50px;
                position: absolute;
                bottom: 30px;
                left: 200px;*/
            }

            #jbxx, #changePassword {
                position: absolute;
                z-index: 9999999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0,0,0,.6);
                display: none;
            }

            #chang_div {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                display: flex;
            }

            .maskContent1 {
                width: 500px;
                margin: auto;
                position: relative;
                background: #fff;
                border-radius: 4px;
            }

            .maskTitle {
                height: 50px;
                padding-left: 30px;
                line-height: 50px;
                text-align: left;
                color: #414658;
                font-size: 16px;
                border-bottom: 2px solid #e9ecef;
            }

            .iptDiv {
                height: 40px;
            }

            .iptLeft {
                width: 25%;
                float: left;
                text-align: right;
                padding-right: 5px;
                box-sizing: border-box;
                line-height: 35px;
                height: 35px;
            }

            .iptRight {
                width: 75%;
                float: left;
                color: #414658;
            }

            .iptRight input {
                border: 1px solid #d5dbe8;
                width: 85%;
                height: 35px;
                line-height: 35px;
                border-radius: 5px;
                padding-left: 20px;
            }

            ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
                color: #97a0b4;
            }

            :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
                color: #97a0b4;
            }

            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color: #97a0b4;
            }

            :-ms-input-placeholder { /* Internet Explorer 10-11 */
                color: #97a0b4;
            }

            .maskContent1 input[type=submit] {
                width: 100px;
                height: 40px;
                border: 1px solid #eee;
                border-radius: 5px;
                background: #008DEF;
                color: #fff;
                font-size: 16px;
                line-height: 40px;
                display: inline-block;
              

            }

            .closeMaskBtn {
                width: 100px;
                height: 40px;
                border-radius: 5px;
                background: #fff;
                color: #008DEF;
                border: 1px solid #008DEF;
                font-size: 16px;
                line-height: 40px;
                display: inline-block;
                text-align: center;
                box-sizing: border-box;
                cursor: pointer;
                margin-right: 10px;
            }

            .closeA {
                position: absolute;
                right: 10px;
                top: 15px;
                width: 30px;
                height: 30px;
                color: #eee;
            }

            /*个人资料*/
            .mezl_img {
                padding-top: 35px;
                text-align: center;
            }

            .mezl_img img {
                width: 88px;
                height: 88px;
                display: block;
                margin: 0 auto;
                border-radius: 50%;
                background-size: 100% 100%;
            }

            .mezl_name {
                font-size: 16px;
                color: #414658;
                padding: 15px 10px 0px;
            }

            .mezl_zhz {
                font-size: 14px;
                color: #97a0b4;
                line-height: 28px;
            }

            .mezl_radio span {
                padding: 0 10px;
            }

            .mezl_radio input {
                margin-top: 0px;
                width: 15px;
            }

            .mezl_radio label {
                margin-right: 20px;
            }

            .mezl_sie {
                width: 88.5%;
            }

            .mezl_sie div {
                width: 30%;
                margin-right: 2%;
                float: left;
                position: relative;
            }

            .jbxx_div input {
                padding-left: 10px;
            }

            .mezl_si select {
                width: 100%;
                border: 1px solid #d5dbe8;
                height: 35px;
                line-height: 35px;
                border-radius: 5px;
                outline: none;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                padding-left: 10px;

            }

            .mezl_sie div:after {
                content: "";
                width: 10px;
                height: 5px;
                background-image: url(images/xia.png);
                background-size: 100% 100%;
                position: absolute;
                right: 8px;
                top: 15px;
                pointer-events: none;
            }

            .jbxx_div .submit {
                padding: 0;
            }

            .jbxx_div input::-webkit-outer-spin-button,
            .jbxx_div input::-webkit-inner-spin-button {
                -webkit-appearance: none;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }

            .magic-radio {
                position: absolute;
                opacity: 0;
            }

            .magic-radio + label {
                position: relative;
                padding-left: 30px;
                cursor: pointer;
                vertical-align: middle;
            }

            .magic-radio + label:hover:before {
                animation-duration: 0.4s;
                animation-fill-mode: both;
                animation-name: hover-color;
            }

            .magic-radio + label.radio1:before, .magic-radio + label.radio2:before {
                position: absolute;
                top: 0;
                left: 0;
                display: inline-block;
                width: 15px;
                height: 15px;
                content: \'\';
                border: 1px solid #B4BED2
            }

            .magic-radio + label:after {
                position: absolute;
                display: none;
                content: \'\'
            }

            .mezl_radio {
                padding-top: 6px;
            }

            .magic-radio[disabled] + label {
                cursor: not-allowed;
                color: #e4e4e4;
            }

            .magic-radio:checked + label:before {
                animation-name: none;
            }

            .magic-radio:checked + label:after {
                display: block;
            }

            .magic-radio + label:before {
                border-radius: 50%;
            }

            .magic-radio + label.radio1:after, .magic-radio + label.radio2:after {
                top: 0px;
                left: 0px;
                width: 11px;
                height: 11px;
                margin: 2.5px;
                border-radius: 50%;
                background: #2890FF;
            }

            .message-bell-btn {
                margin: 0px;
            }

            .icon-xiaoxi {
                display: none;
            }

            .icon-tixing {
                display: flex;
                align-items: center;
                height: 18px;
                width: 18px;
            }

            .icon-tixing:before {
                display: inline-block;
                content: "";
                width: 18px;
                height: 18px;
                background: url(images/iIcon/xiaoxi.png) no-repeat;
                background-size: 18px 18px;
                padding: 0px 10px;
                position: relative;
                top: 6px;
            }

            .message-bell {
                height: 60px;
                line-height: 60px;
            }

            #changePsw {
                cursor: pointer;
            }

            #changeInf {
                cursor: pointer;
            }

            #msgDiv {
                width: 200px;
                height: 160px;
                position: fixed;
                z-index: 999;
                background-color: #f6f7f8;
                right: 30px;
                box-sizing: border-box;
                display: none;
            }

            .msgUl1 {
                border: 1px solid #eee;
            }

            #msgDiv .msgUl1 li {
                height: 38px;
                color: #414658;
                border: 1px solid #eee;
            }

            .msgNum {
                background-color: #ff453d;
                border-radius: 10px;
                width: 28px;
                height: 16px;
                display: inline-block;
                color: #fff;
                line-height: 15px;
                text-align: center;
                font-size: 12px;
                position: relative;
            }
            .msgDiv1 {
                line-height: 30px;
                height: 30px;
                padding: 5px 12px;
            }

            .msgDiv2 {
                height: 160px;
                width: 196px;
                margin: 0 auto;
                padding: 0px 12px;
                background-color: #fff;
                position: relative;
                box-sizing: border-box;
                display: none;
                z-index: 999999999999;
            }

            .msgNumDiv {
                display: inline-block;
                height: 30px;
                line-height: 30px;
                float: right;

            }

            .msgUpDown {
                float: right;
                margin-left: 10px;
            }

            .msgUl2 li {
                border: none !important;
                border-bottom: 1px solid #eee !important;
            }

            .msgUl2 li:last-child {
                border: none !important;
            }

            .msgNum1 {
                color: #ff453d;
                font-size: 12px;
            }

            .msgUl2 li div {
                height: 38px;
                line-height: 38px;
            }

            .msgText {
                color: #888f9e;
                font-size: 12px;
            }

            .msgDiv3 {
                pointer-events: none;
            }

            .bottom_foot {
                height: 40px;
                width: 100%;
                background-color: #222;
                color: #ddd;
                z-index: 5000;
                position: fixed;
                bottom: 0;
                left: 0;
                line-height: 40px;
            }

            .bottom_left {
                float: left;
                padding-left: 20px;
            }

            .bottom_right {
                float: right;
            }

            .mui-icon {
                font-family: Muiicons;
                font-size: 24px;
                font-weight: 400;
                font-style: normal;
                line-height: 1;
                display: inline-block;
                text-decoration: none;
                -webkit-font-smoothing: antialiased;
            }

            .mui-icon-phone:before {
                content: \'\\e200\';
            }

            .BA {
                color: #ddd
            }

            #tatalNum {
                position: absolute;
                z-index: 9999;
                top: 13px;
                right: 4px;
            }
            .form_passwd input{height: 36px;border-radius: 0;border: 1px solid #ddd;}
            .form_passwd .clearfix{margin-top: 0;display: block;}
            .form_passwd .iptLeft {width: 110px;padding-right: 10px;line-height: 36px;height: 36px;}
            .form_passwd  input{width: 288px;padding-left: 10px;}
            .from_btn{margin-top: 10px;margin-bottom: 40px;}
            .from_btn input,.from_btn buttom{height: 36px!important;line-height: 36px!important;padding: 0;width: 112px!important;
                margin-bottom: 40px;}
            .from_btn input{margin-right: 14px!important;float: left;margin-left: 131px;}
            .from_btn buttom{float: right;margin-right: 131px;}
            .form_passwd .iptDiv {padding: 16px 0 0;}
            .maskTitle {
                font-size:16px;
                font-weight:bold;
                color:rgba(65,70,88,1);
            }

            .formInputDiv{
                display: flex;
                border: 1px solid #D5DBE8;
            }
            .formInputDiv ul{margin: 0;width:100%;height: 171px;overflow-y: scroll;}
            .formInputDiv ul:not(:last-child){border-right: 1px solid #D5DBE8;}
            .formInputDiv li{height: 30px;line-height: 30px;cursor: pointer;font-size: 14px;color: #6A7076;user-select:none;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;padding: 0 12px;}
            .formInputDiv li:hover{color: #0880FF;}
            .formInputDiv .active{position: relative;background: #0880FF;color: #fff!important;}

            .selectDiv{position: relative;height: 36px;}
            .selectDiv>div{position: absolute;top:0;left: 0;width: 100%;height: 100%;display: flex;align-items: center;padding-left: 12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;padding-right: 15px;}
            .selectDiv p{margin-bottom: 0;}
            .selectItem span{margin: 0 5px;}
			
			
			.wl_maskNew {
			    position: fixed;
			    z-index: 9999999;
			    top: 0;
			    bottom: 0;
			    left: 0;
			    right: 0;
			    background: rgba(0, 0, 0, 0.6);
			    display: flex;
				align-items: center;
				justify-content: center;
			}
			
			.wl_maskNewContent {
				display: flex;
				flex-direction: column;
			    width: 920px;
			    height: 600px;
			    background: #fff;
			    border-radius: 4px;
			}
			
			.wl_maskNew .maskTitle{
				display: block;
				position: relative;
				height: 58px;
				line-height: 58px;
			}
			
			.wl_mask_data{
				font-size: 14px;overflow: auto;flex:1;
				padding: 40px;margin-bottom: 40px;
			}
			.wl_mask_data>div>div{display: flex;margin-bottom: 5px;}
			.wl_mask_data p{margin: 0;}
			.wl_mask_data label{
				width: 70px;
				margin-right: 10px;
			}
			.wl_mask_data .time{color: #97A0B4;margin-right: 14px;}
			.wl_mask_data .time li,.wl_mask_data .time+ul li{
				height: 24px;
				line-height: 24px;
				margin: 10px 0;
			}
			.wl_mask_data .time+ul{
				position: relative; top: 20px;
				flex: 1;
			}
			.wl_mask_data .time+ul li{
				padding-left: 11px;
				border-left: 1px solid #E9ECEF;
				position: relative;
			}
			.wl_mask_data .time+ul li:after{
				content: \'\';
				width:5px;height: 5px;background: #D5DBE8;
				position: absolute;left: -3px;bottom: -7px;
				border-radius: 50%;
			}
			.wl_mask_data .time+ul li:first-child::before{
				content: \'\';
				width:10px;height: 10px;background: #2890FF;
				position: absolute;left: -5px;top: -13px;
				border-radius: 50%;
			}
			.wl_mask_data .time+ul p{
				position: absolute;
				top: -12px; line-height: 14px;
			}
			.wl_mask_data .time+ul li:last-child{
				border-left: 0;
			}
			.wl_mask_data .time+ul li:last-child:after{
				background: transparent;
			}
			
			.wl_mask_data .baoguo{
				align-items: center;
				color: #2890FF;
			}
			.wl_mask_data .genzong{
				overflow:hidden;
			}
			.wl_mask_data>div{
				margin-bottom:50px
			}
			.wl_mask_data>div:last-child{
				margin-bottom: 0;
			}
			
			.bigUl li{
				width: auto;
				padding: 0 20px;
				font-size: 18px;
			}
        </style>
    '; ?>

</head>
<body id="body">

 <!-- 快递发货 -->
<div class="dc ccc" style="display:none;">
    <div class="maskNewContent" style="height: 312px!important;">
        <div class="maskTitle" style="display: block;">
            发货
        </div>

        <a href="javascript:void(0);" onclick="dc()" class="closeA qx" style="display: block;">
            <img src="images/icon1/gb.png"/>
        </a>

        <div id="tab-category" class="HuiTab">
            <div class="" style="margin-top: 45px;">
                <div class="">
                    <input type="hidden" name="sNo" value="" class="order_id">
                    <input type="hidden" name="otype" value="" class="otype">
                    <input type="hidden" name="oid" value="" class="oid">
                    <input type="hidden" name="trade" value="3">
                    <label class="maskLeft" style="">快递公司：</label>
                    <div class="formControls maskRight" style="width: 60%;float: left;">
                        <form name="hh" action="" method="post">
                            <span class="search">
                                <select name="kuaidi" id="kuaidi1" style="width: 300px;height: 36px;">
                                    <?php $_from = $this->_tpl_vars['express']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                                        <option value="<?php echo $this->_tpl_vars['item']->id; ?>
"><?php echo $this->_tpl_vars['item']->kuaidi_name; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>

                                <select name="kuaidi" id="kuaidi2" style="width: 300px;height: 36px;">
                                    <option value="57">顺丰</option>
                                </select>

                            </span>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-3">
                    </div>
                </div>

                <div class="">
                    <label class="maskLeft" style="">快递单号：</label>

                    <div class="maskRight" style="">
                        <div class="radio-box">
                            <input type="radio" title="1" class="radio-2" name="demo-radio1" checked>
                            <label for="radio-2">手动输入</label>
                        </div>

                        <div class="radio-box">
                            <input type="radio" title="0" class="radio-2" name="demo-radio1">
                            <label for="radio-2">自动获取</label>
                        </div>
                    </div>
                    
                    <div class="maskRight" style="">
                        <input type="text" class="ipt1" value="" name="danhao" placeholder="请输入正确的快递单号"/>
                    </div>

                    <div class="clearfix"></div>
                </div>
                
            </div>
        </div>

        <div class="row cl">
            <div class="col-9 " style="margin-left:40%">
                <input class="qd closeMask" type="button" onclick="dc()" value="取消">
                <input class="qd closeMask" type="button" onclick=qd('index.php?module=orderslist&action=addsign',3) value="保存">
            </div>
        </div>

    </div>
</div>
<!-- 快递发货结束 -->

<header class="Hui-header cl" style="margin:0;">
    <a class="Hui-logo l" title="H-ui.admin v2.3" href="index.php?module=AdminLogin">
        <img style="width: 100px;" src="images/admin_logo.png">
    </a>
    <a class="Hui-logo-m l" href="index.php?module=AdminLogin" title="H-ui.admin"></a>
    <span class="Hui-subtitle l"></span>
    <a class="changeAside" href="javascript:void(0)">
        <img style="width: 20px;" src="images/iIcon/qh.png" alt=""/>
    </a>
    <ul class="bigUl">
        <li <?php if ($this->_tpl_vars['type'] == 0): ?>class="active"<?php endif; ?>><a href="index.php?module=AdminLogin">平台</a></li>
        <?php $_from = $this->_tpl_vars['role_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
            <li <?php if ($this->_tpl_vars['type'] == $this->_tpl_vars['item']->type): ?>class="active"<?php endif; ?>><a href="index.php?module=AdminLogin&type=<?php echo $this->_tpl_vars['item']->type; ?>
"><?php echo $this->_tpl_vars['item']->title_name; ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>

    <ul class="Hui-userbar">
        <li class="dropDown dropDown_hover headerLi">
            <a href="#" class="dropDown_A">
                <img class="userIdImg" src="images/iIcon/tx.png" alt=""/>
                <span id="nickname1"></span>
                <i class="Hui-iconfont">&#xe6d5;</i>
            </a>
            <ul class=" sp1 dropDown-menu radius box-shadow sysBtn">
                <li>
                    <a _href="index.php?module=product_class" href="javascript:void(0)" title="修改密码">
                        <i><img src="images/iIcon/xg.png"/>
                            <img src="images/iIcon/xgmm_h.png" style="display: none;"/>
                        </i>
                        &nbsp;修改密码
                    </a>
                </li>

                <li>
                    <a _href="index.php?module=product_class" title="基本信息1">
                        <i><img src="images/iIcon/xinxi.png"/>
                            <img src="images/iIcon/jbxx_h.png" style="display: none;"/>
                        </i>
                        &nbsp;基本信息
                    </a>
                </li>
            </ul>
        </li>
        <li class="headerLi" style="height: 60px;">
            <!--<div id="message"></div>-->
            <a href="#javascript" id="msgBtn"><img src="images/iIcon/xiaoxi.png"/></a>
            <span class="msgNum" id="tatalNum" style="right: -11px;top: 12px;">0</span>
            <div id="msgDiv">
                <div id="msgWrap">
                    <ul class="msgUl1">
                        <li>
                            <div class="msgDiv1">
                                <div class="msgDiv3">
                                    <span id="asd">订单提醒</span>
                                    <span class="msgUpDown">
                                        <img src="images/icon1/down.png"/>
                                    </span>
                                    <div class="msgNumDiv">
                                        <span class="msgNum">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="msgDiv2">
                                <ul class="msgUl2">
                                    <li>
                                        <div class="ifsAPI">
                                            <a _href="index.php?module=orderslist&action=Index&news_status=0&readd=0&mch_id=<?php echo $this->_tpl_vars['mch_id']; ?>
&x_order=1"  href="javascript:void(0)">
                                                <span class="msgText">您有新订单</span>
                                                <div class="msgNumDiv">
                                                    <span class="msgNum1">0</span>
                                                </div>
                                            </a>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="ifsAPI">
                                            <a _href="index.php?module=orderslist&action=Index&news_status=1"  href="javascript:void(0)">
                                                <span class="msgText">待发货订单</span>
                                                <div class="msgNumDiv">
                                                <span class="msgNum1">0</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ifsAPI">
                                            <a _href="index.php?module=return&action=Index&readd=0&mch_id=<?php echo $this->_tpl_vars['mch_id']; ?>
"  href="javascript:void(0)">
                                                <span class="msgText">售后待处理订单</span>
                                                <div class="msgNumDiv">
                                                <span class="msgNum1">0</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ifsAPI">
                                            <a _href="index.php?module=orderslist&action=Index&news_status=1&delivery_status=1&readd=0&mch_id=<?php echo $this->_tpl_vars['mch_id']; ?>
"  href="javascript:void(0)">
                                                <span class="msgText">订单发货提醒</span>
                                                <div class="msgNumDiv">
                                                <span class="msgNum1">0</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="msgDiv1">
                                <div class="msgDiv3">
                                    <span>商品提醒</span>
                                    <span class="msgUpDown">
                                <img src="images/icon1/down.png"/>
                            </span>
                                    <div class="msgNumDiv">
                                    <span class="msgNum">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="msgDiv2"></div>
                        </li>
                        <li>
                            <div class="msgDiv1">
                                <div class="msgDiv3">
                                    <span>会员提醒</span>
                                    <span class="msgUpDown">
                                <img src="images/icon1/down.png"/>
                            </span>
                                    <div class="msgNumDiv">
                                    <span class="msgNum">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="msgDiv2"></div>
                        </li>
                        <li>
                            <div class="msgDiv1">
                                <div class="msgDiv3">
                                    <span>公告提醒</span>
                                    <span class="msgUpDown">
                                <img src="images/icon1/down.png"/>
                            </span>
                                    <div class="msgNumDiv">
                                    <span class="msgNum">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="msgDiv2"></div>
                        </li>
                    </ul>
                </div>

        </li>
        <li id="Hui-skin" class="headerLi dropDown right dropDown_hover">
            <a href="javascript:;" title="换肤">
                <i class="" style="font-size:18px"> <img src="images/iIcon/hf_1.png"/></i>
            </a>
            <ul class="dropDown-menu radius box-shadow changeColor"
                style="    position: absolute;left: -35px!important;width: 120px;">
                <li class="color1"><a href="javascript:;" data-val="default" data-color="#000" style="background-color: #fff; color: #000;" title="默认（黑色）">默认（黑色）</a></li>

                <li class="color2"><a href="javascript:;" data-val="blue" data-color="#2d6dcc" style="background-color: #fff;color: #000;" title="蓝色">蓝色</a></li>

                <li class="color3"><a href="javascript:;" data-val="green" data-color="#19a97b" style="background-color: #fff;color: #000;" title="绿色">绿色</a></li>

                <li class="color4"><a href="javascript:;" data-val="red" data-color="#c81623" style="background-color: #fff;color: #000;" title="红色">红色</a></li>

                <li class="color5"><a href="javascript:;" data-val="yellow" data-color="#ffd200" style="background-color: #fff;color: #000;" title="黄色">黄色</a></li>

                <li class="color6"><a href="javascript:;" data-val="orange" data-color="#ff4a00" style="background-color: #fff;color: #000;" title="橙色">橙色</a></li>
            </ul>
        </li>
        <?php if ($this->_tpl_vars['admin_type'] == 1): ?>
            <li>
                <a href="javascript:void(0);" onclick="dump('index.php?module=AdminLogin')" title="返回">
                    <img src="images/iIcon/fh.png"/>
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="index.php?module=Login&action=Logout" title="退出系统">
                <img src="images/iIcon/tc.png"/>
            </a>
        </li>
    </ul>
    </div>
    <a href="javascript:;" class="Hui-nav-toggle Hui-iconfont" aria-hidden="false">&#xe667;</a>
</header>
<aside class="Hui-aside" style="background: #fff;position:fixed;top: 60px;bottom: 0px;overflow: auto !important;">
    <input runat="server" id="divScrollValue" type="hidden" value=""/>
    <div class="menu_dropdown bk_2" style="padding-bottom: 40px;">
        <?php if ($this->_tpl_vars['type'] == 0): ?>
            <input type="hidden" id="type1" name="" value="<?php echo $this->_tpl_vars['type']; ?>
"/>
            <dl id="menu-article" class="active sp2 sp5">
                <dt>
                <span class="asideImgWrap">
                    <img class="asideImg" src="images/iIcon/sy_1.png"/>
                    <img class="asideImg" src="images/iIcon/sy.png"/>
                </span>
                    <a class="index1" href="index.php?module=AdminLogin" data-title="系统首页">
                        <span class="t2" style="color: #0080ff;">系统首页</span>
                    </a>
                </dt>
            </dl>
        <?php endif; ?>
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
            <dl class="menu-system">
                <dt>
                    <span class="asideImgWrap">
                        <img class="asideImg" src="<?php echo $this->_tpl_vars['item']->image; ?>
" style="width: 19px;height: 18px;"/>
                        <img class="asideImg" src="<?php echo $this->_tpl_vars['item']->image1; ?>
" style="width: 19px;height: 18px;"/>
                    </span>
                    <span class="t2"><?php echo $this->_tpl_vars['item']->title; ?>
</span>
                    <span class="asideImgWrapRight">
                        <img class="asideImgRight" src="images/iIcon/sq.png"/>
                        <img class="asideImgRight" src="images/iIcon/zk.png"/>
                    </span>
                </dt>
                <dd>
                    <ul>
                        <?php $_from = $this->_tpl_vars['item']->res; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item1']):
        $this->_foreach['f2']['iteration']++;
?>
                            <?php if ($this->_tpl_vars['item1']->title == '满减'): ?>
                                <li class="textApi ifsAPI"><a _href="<?php echo $this->_tpl_vars['item1']->url; ?>
" id="subtraction" data-title="<?php echo $this->_tpl_vars['item1']->title; ?>
" href="javascript:void(0)"><?php echo $this->_tpl_vars['item1']->title; ?>
</a></li>
                            <?php else: ?>
                                <li class="textApi ifsAPI"><a _href="<?php echo $this->_tpl_vars['item1']->url; ?>
" data-title="<?php echo $this->_tpl_vars['item1']->title; ?>
" href="javascript:void(0)"><?php echo $this->_tpl_vars['item1']->title; ?>
</a></li>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </ul>
                </dd>
            </dl>
        <?php endforeach; endif; unset($_from); ?>
    </div>
</aside>
<section class="Hui-article-box" style="margin-bottom: 40px">
    <div id="Hui-tabNav" class="Hui-tabNav">
        <div class="Hui-tabNav-wp" style="opacity: 0;visibility: hidden;">
            <ul id="min_title_list" class="acrossTab cl" style="margin:0;">
                <li class="active"><span>系统首页</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group">
            <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a
                    id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i
                        class="Hui-iconfont">&#xe6d7;</i></a>
        </div>
        <a class="topTitle" style="" title="系统首页" data-href="index.php?module=index">系统首页</a>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div class="loading"></div>
            <?php if ($this->_tpl_vars['type'] == 0): ?>
                <iframe scrolling="yes" frameborder="0" src="index.php?module=index"></iframe>
            <?php elseif ($this->_tpl_vars['type'] == 1): ?>
                <iframe scrolling="yes" frameborder="0" src="index.php?module=index"></iframe>
            <?php else: ?>
                <iframe scrolling="yes" frameborder="0" src="index.php?module=index"></iframe>
            <?php endif; ?>
        </div>
    </div>
</section>
<div class="mask1">
    <div class="mask1Content">
        <div style="height: 100px;position: relative;top: 30%;font-size: 22px;text-align: center;">
            平台开发中，敬请期待！
        </div>
        <div style="top: 20%;position: relative;text-align: center;">
            <button class="closeMask">确认</button>
        </div>

    </div>
</div>
<div id="changePassword">
    <div id="chang_div">
        <div class="maskContent1" style="border-radius:4px;padding: 0;">
            <form action="javascript:void(0);" method="post" class="form_passwd">
                <div class="pop_title">修改密码
                    <img src="images/icon/cha.png" class="clsCPW"/>
                </div>
                    <div style="padding: 20px;">
                <div class="iptDiv">
                    <div class="iptLeft">
                                原密码：
                    </div>
                        <input type="password" placeholder="请输入原密码" name="oldPW" value=""/>
                    <div class="clearfix"></div>
                </div>
                
                <div class="iptDiv">
                    <div class="iptLeft">
                        新密码：
                    </div>
                        <input type="password" placeholder="请输入新密码" name="newPW" value=""/>
                    <div class="clearfix"></div>
                </div>
                <div class="iptDiv">
                    <div class="iptLeft">
                        确认密码：
                    </div>
                        <input type="password" placeholder="请再次输入新密码" name="curNewPW" value=""/>
                    <div class="clearfix"></div>
                </div>
               </div>
                <div class="from_btn">
                    <input type="submit" id="changePsw" value="确认"/>
                    <buttom class="closeMaskBtn clsCPW">取消</buttom>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="jbxx" class="jbxx_div">
    <div id="chang_div">
        <div class="maskContent1" style="height: 700px;">
            <img class='clsCPW chang_click closeImg' src="images/icon1/gb.png"/>
            <div class='maskTitle' style='display: block;'>基本信息</div>
            <form action="javascript:void(0);" method="post" style='height: 630px;' id="storeInfoForm"  enctype="multipart/form-data">
                <input type="hidden" name="action" value="maskContent"/>
                <div class='topForm' >
                     <div class="iptDiv">
                        <div class="iptLeft" style='height: 40px;line-height: 40px;'>
                            头像：
                        </div>
                        <div class="iptRight">
                            <img style="border-radius: 50%;width: 40px;height: 40px;" src="images/iIcon/tx.png" alt="" name="portrait"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!--input框-->
                    <div class="iptDiv">
                        <div class="iptLeft">
                            昵称：
                        </div>
                        <div class="iptRight">
                            <input type="text" placeholder="请填写您的昵称" id="naickname" name="name" value=""/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="iptDiv">
                        <div class="iptLeft">
                            生日：
                        </div>
                        <div class="iptRight mezl_si">
                            <div class="mezl_sie">
                                <div><select onchange="setDays()" id="select1" name="year"></select></div>
                                <div><select onchange="setDays()" id="select2" name="mouth"></select></div>
                                <div><select id="select3" name="day"></select></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="iptDiv">
                        <div class="iptLeft">
                            性别：
                        </div>
                        <div class="iptRight mezl_radio ">
                            <input class="magic-radio" type="radio" name="sex" id="r1" value="1" checked>
                            <label for="r1" class="radio1">男</label>
                            <input class="magic-radio" type="radio" name="sex" id="r2" value="2">
                            <label for="r2" class="radio2">女</label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="iptDiv">
                        <div class="iptLeft">
                            手机号码：
                        </div>
                        <div class="iptRight">
                            <input type="number" placeholder="请填写您的手机号" name="tel" value=""/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                </div>
                <div style='padding:0 50px 0 47px;margin: 20px 0;'>
                    <div style='border-bottom: 1px solid #E9ECEF;'></div>
                </div>
                <div class='bottomForm'>
                    <div class="iptDiv">
                        <div class="iptLeft" style='height: 40px;line-height: 40px;'>
                            店铺头像：
                        </div>
                        <div class="iptRight" style='position: relative;' >
                            <img style="border-radius: 50%;width: 60px;height: 60px;" class='changeStoreImg1' src="images/iIcon/tx.png" alt="" name="logo"/>
                            <div id='changeImgBtn'>
                                <input type="file"  accept="image/*" id='changeStoreImg'   />
                                <input type="file"  accept="image/*" id='fileStoreImg' name='fileStoreImg' style="display: none;"  />
                                <span id='changeImgText'>修改信息</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="iptDiv">
                        <div class="iptLeft">
                            店铺名称：
                        </div>
                        <div class="iptRight" style='height: 35px;line-height: 35px;'>
                            <input type="text" placeholder="请填写您的店铺名称" name="shop_name" value=""/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="iptDiv">
                        <div class="iptLeft">
                            经营范围：
                        </div>
                        <div class="iptRight">
                            <input type="text" placeholder="请填写您的经营范围" name="shop_range" value=""/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="iptDiv" style='height: 80px;'>
                        <div class="iptLeft">
                            店铺信息：
                        </div>
                        <div class="iptRight ">
                           <textarea name='shop_information' class='textInput'></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div style='padding:0;margin: 20px 0;'>
                        <div style='border-bottom: 1px solid #E9ECEF;'></div>
                    </div>
                    <div style="position: relative;height: auto;margin-top: 20px;">
                        <div style="position: absolute; right: 30px; margin:0 auto;display: flex;align-items: center;">
                            <button class="closeMaskBtn clsCPW coljks">取消</button>
                            <input type="submit" value="保存" id="changeInf" class="submit"/>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
<footer class='bottom_foot'>
    <div class="bottom_left">
        <span>联系地址：长沙市岳麓区绿地中央广场5栋3408</span>
        <span>0731-86453408</span>
    </div>
    <div class="bottom_right" style="position: relative;left: -90px;">
         <span>
            <a class="BA"
               href="http://www.laiketui.com">Copyright&nbsp;©&nbsp;2018&nbsp;壹拾捌号网络版权所有[官方网站]&nbsp;&nbsp;</a>
            <a class="BA" href="http://www.miibeian.gov.cn">湘ICP备17020355号</a>
         </span>
    </div>
</footer>
<div class="maskNew" id="parentmask" style="display: none;"></div>
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>

<?php echo '
<script type="text/javascript">
    
    let fileStoreImg = null;
    $("#changeStoreImg").change(function(e){
        var files = e.target.files, file;
        if (files && files.length > 0) {
            // 获取目前上传的文件
            file = files[0];// 文件大小校验的动作
            if(file.size > 1024 * 1024 * 2) {
                alert(\'图片大小不能超过 2MB!\');
                return false;
            }
            fileStoreImg = file;
            // $("#fileStoreImg").val(file);
            // 获取 window 的 URL 工具
            var URL = window.URL || window.webkitURL;
            // 通过 file 生成目标 url
            var imgURL = URL.createObjectURL(file);
            //用attr将img的src属性改成获得的url
            $(".changeStoreImg1").attr("src",imgURL);
        }
    })
    $(function(){
        refreshCount();
    });
    
    $(".changeStoreImg1").mouseover(function(){
        $("#changeImgBtn").show()
    })
    $("#changeImgBtn").mouseout(function(){
        $("#changeImgBtn").hide()
    })
    var radioType = 1

    
    function send_btn_xsfh(oid,otype,sNo) {
        console.log("send_btn_xsfh");
        $(".ipt1").val(\'\');
        $(".order_id").val(oid);
        $(".oid").val(sNo);
        $(".otype").val(otype);
        $(".dc").show();

        //  订单输入框
        var numberingDom = $(\'input[name=danhao]\')
        var kuaidi1Dom = $(\'#kuaidi1\')
        var kuaidi2Dom = $(\'#kuaidi2\')

        
        if(radioType === 2){
            kuaidi2Dom.show()
            kuaidi1Dom.hide()
        } else if(radioType === 1) {
            kuaidi1Dom.show()
            kuaidi2Dom.hide()
        }
        
        $(\'.radio-2\').on(\'click\',function(event){
            // 1 | 手动输入
            if(event.target.title === \'1\'){
                numberingDom.show()
                kuaidi1Dom.show()
                kuaidi2Dom.hide()
                radioType = 1
            } else {
                numberingDom.hide()
                kuaidi1Dom.hide()
                kuaidi2Dom.show()
                radioType = 2
            }
        })

    };

    function dump(url) {
        $.ajax({
            type: "get",
            url: \'index.php?module=AdminLogin&store_id1=tc\',
            async: true,
            dataType: "json",
            success: function (res) {
                console.log(url)
                window.parent.location.href = url;
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    }

    $(".ifsAPI").each(function () {
        var href = $(this).find(\'a\').attr(\'_href\');
        var id = $(this).find(\'a\').attr(\'id\');
        $(this).click(function () {
            $(".show_iframe").remove();
            if(id) {
                $("#iframe_box").append(\'<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src=\' + href + \' id=\' + id + \'></iframe></div>\')
            }else{
                $("#iframe_box").append(\'<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src=\' + href + \'></iframe></div>\')
            }
            $(".show_iframe").eq(0).show();
        })
    })
    if ($("#type1").val() != 0) {
        let aBtn = $(".menu-system").eq(0);
        aBtn.find(\'dt\').addClass("selected");
        aBtn.find(\'dd\').show();
        aBtn.find(\'.t2\').css(\'color\', \'#2890ff\');
        aBtn.find(\'.asideImg\').eq(0).hide();
        aBtn.find(\'.asideImgRight\').eq(0).hide();
        aBtn.find(\'.asideImg\').eq(1).show();
        aBtn.find(\'.asideImgRight\').eq(1).show();
        aBtn.find(\'.ifsAPI\').eq(0).find(\'a\').css(\'color\', \'#2890ff\');
        aBtn.find(\'.ifsAPI\').eq(0).click();
    }

    window.onload = function () {
        var selects = [document.getElementById("select1"),document.getElementById("select2"),document.getElementById("select3")];//通过标签名获取select对象
        var date = new Date();
        var nowYear = date.getFullYear();//获取当前的年
        for (var i = nowYear - 100; i <= nowYear; i++) {
            var optionYear = document.createElement("option");
            optionYear.innerHTML = i;
            optionYear.value = i;
            selects[0].appendChild(optionYear);
        }
        for (var i = 1; i <= 12; i++) {
            var optionMonth = document.createElement("option");
            optionMonth.innerHTML = i;
            optionMonth.value = i;
            selects[1].appendChild(optionMonth);
        }
        getDays(selects[1].value, selects[0].value, selects);
    }
    let data1;
    $.ajax({
        type: "post",
        url: "index.php?module=AdminLogin&action=maskContent",
        async: true,
        dataType: "json",
        success: function (data) {
            data1 = data.re[0];
            $("#nickname1").html(data1.nickname);
        },
        error: function (res) {
            $(".dc").hide();
            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
            ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
        }
    });
    $("#msgBtn,#msgWrap").mouseout(function () {
        $("#msgDiv").hide();
    })
    $("#msgDiv,#msgBtn").mouseover(function (event) {
        $("#msgDiv").show();
    })
    let aDiv = document.getElementsByClassName("msgDiv2")
    for (let i = 0; i < $(".msgDiv2").length; i++) {
        aDiv[i].addEventListener("mouseover", function () {
            $("#msgDiv").show();
        })
    }
    $(".msgDiv1").each(function (i) {
        $(this).click(function () {
            //没点击的最原始状态
            if (parseInt($("#msgDiv").css("height")) == 160) {
                $(".msgDiv2").eq(i).show();
                $("#msgDiv").css("height", "320")
                $(this).parent().css("padding-bottom", "160px")
            }//点击后
            else {
                if ($(this).parent().find(".msgDiv2").is(":visible")) {
                    //如果取消单个下拉菜单
                    console.log("s");
                    $(".msgDiv2").eq(i).hide();
                    $("#msgDiv").css("height", "160");
                    $(this).parent().css("padding-bottom", "0px")
                }
                else {
                    $(".msgDiv2").hide();
                    $(".msgUl1 li").each(function () {
                        $(this).css("padding-bottom", "0px")
                    })
                    $(".msgDiv2").eq(i).show();
                    $(this).parent().css("padding-bottom", "120px")

                }
            }
        })
    })
    $(".msgUl2 li").each(function () {
        $(this).mouseover(function () {
            $(this).find(".msgText").css("color", "#2991ff")
        });
        $(this).mouseout(function () {
            $(this).find(".msgText").css("color", "#888f9e")
        })
    })
    $("#changePsw").click(function () {
        let oldPW = $("[name=oldPW]").val();
        let newPW = $("[name=newPW]").val();
        let curPW = $("[name=curNewPW]").val();
        console.log(newPW.length, curPW);
        if (newPW == curPW && newPW.length > 5) {
            $.ajax({
                type: "post",
                url: "index.php?module=AdminLogin&action=changePassword",
                async: true,
                dataType: "json",
                data: {
                    oldPW,
                    newPW,
                    curPW,
                },
                success: function (res) {
                    if (res.status == 3) {
                        layer.msg(res.info);
                        $("#changePassword").hide();
                        location.replace(location.href);
                    }
                    else {
                        layer.msg(res.info);
                    }
                },
                error: function (res) {
                    $(".dc").hide();
                    layer.msg(\'您没有该权限！\');
                    // location.replace(location.href);
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
            });
        }
        else {
            layer.msg("请输入正确信息！")
        }
    })
    $("#changeInf").click(function () {
        let sex = $("[name=sex]:checked").val();
        let birthday = $("#select1").val() + "-" + $("#select2").val() + "-" + $("#select3").val()
        let portrait = $("[name=portrait]").attr(\'src\');
        let nickname = $("[name=name]").val();
        let tel = $("[name=tel]").val();
        let storeImg=$(\'.changeStoreImg1\').attr(\'src\')
        let shop_name = $("[name=shop_name]").val();
        let shop_range = $("[name=shop_range]").val();
        let shop_information = $("[name=shop_information]").val();


        var data = new FormData($("#storeInfoForm")[0]);
        data.append("fileStoreImg", fileStoreImg);
        if (sex.length > 0 && birthday.length > 0 && tel.length == 11 && nickname.length > 0) {
            $.ajax({
                type: "post",
                url: "index.php?module=AdminLogin&action=maskContent",
                async: true,
                // dataType: "json",
                data : data,
                processData : false,
                contentType : false,
                success: function (res1) {
                    var res = JSON.parse(res1);

                    if (res.status == 3) {
                        layer.msg(res.info);
                        $("#jbxx").hide();
                        $("#nickname1").text(nickname);
                        $("#naickname").val(nickname);
                        data1 = res.re[0];
                        // $("#tel").val(data1.tel);
                        $("[name=tel]").val(data1.tel)
                    }
                    else {
                        layer.msg(res.info);
                    }
                    location.reload()
                },
                error: function (res) {
                    $(".dc").hide();
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
            });
        }
        else {
            layer.msg("请输入完整信息！");
        }
    })
    
    function setContent(a, event) {
        var select = $("#hh");
        /* select.html(""); */

        for (i = 0; i < Arr.length; i++) {
            //若找到包含txt的内容的，则添option
            if (Arr[i].indexOf(a.value) >= 0) {
                var option = $("<option value=\'" + array[i] + "\'></option>").text(Arr[i]);
                select.append(option);
            }
        }
        if (event.keyCode == 40) {
            //按向下的键之后跳转到列表中
            //焦点转移并且选中第一个值
            $("#hh").focus();
            $("#hh").find("option:first").attr("selected", "true");
            return false;
        }
    };

    function setDemo(a, event) {
        $("#makeInput").val("");
        $("#hh").css({
            "display": "block"
        });
        var select = $("#hh");
    };

    // 获取某年某月存在多少天
    function getDaysInMonth(month, year) {
        var days;
        if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
            days = 31;
        } else if (month == 4 || month == 6 || month == 9 || month == 11) {
            days = 30;
        } else {
            if ((year % 4 == 0 && year % 100 != 0) || (year % 400 == 0)) {     // 判断是否为润二月
                days = 29;
            } else {
                days = 28;
            }
        }
        return days;
    };

    function setDays() {
        
        var id="met_cl";
        var dov=document.getElementById(id)
        
        var selects = dov.getElementsByTagName("select");
        var year = selects[0].options[selects[0].selectedIndex].value;
        var month = selects[1].options[selects[1].selectedIndex].value;
        getDays(month, year, selects);
    }

    function getDays(month, year, selects) {
        var days = getDaysInMonth(month, year);
        selects[2].options.length = 0;
        for (var i = 1; i <= days; i++) {
            var optionDay = document.createElement("option");
            optionDay.innerHTML = i;
            optionDay.value = i;
            selects[2].appendChild(optionDay);
        }
    }

    /*菜单导航*/
    $(".sp1 li").each(function () {
        $(this).mouseover(function () {
            $(".dropDown_A").css("background", "none")
        })
    })
    $(".none").each(function () {
        $(this).click(function () {
            $(".mask1").show();
        })
    })
    $(".closeMask").click(function () {
        $(".mask1").hide();
    })

    $(".clsCPW").on("click", function () {
        $("#changePassword").hide();

    })
    $(".sp2").click(function () {
        $(this).siblings().find(".t2").css("color", "#333");
        $(this).find(".t2").css("color", "#148cf1");
        $(this).find(".asideImgWrap img").eq(0).hide();
        $(this).find(".asideImgWrap img").eq(1).show();
        $(".bk_2 div").each(function () {
            $(this).removeClass("sp5");
            $(".sp2").addClass("sp5");
        })

        $(this).siblings().find(".asideImgWrap img").eq(1).hide();
        $(this).siblings().find(".asideImgWrap img").eq(0).show();
        $(this).siblings().find(".asideImgWrapRight img:odd").hide();
        $(this).siblings().find(".asideImgWrapRight img:even").show();
    })
    $(".textApi a").each(function () {
        $(this).click(function () {
            $(".textApi a").each(function () {
                $(this).css("color", "#666");
            })
            $(this).css("color", "#148cf1");
            $(this).parent().parent().parent().parent().siblings().removeClass("sp5");
            $(this).parent().parent().parent().parent().addClass("sp5");
//      $(this).parent().parent().siblings().find(".asideImgWrap");
            $(this).parent().parent().parent().parent().siblings().each(function () {
                $(this).find(".t2").css("color", "#333");
                $(this).find(".asideImgWrap img").eq(1).hide();
                $(this).find(".asideImgWrap img").eq(0).show();

            });
            $(this).parent().parent().parent().siblings().find(".asideImgWrap img").eq(0).hide();
            $(this).parent().parent().parent().siblings().find(".t2").css("color", "#0080ff");
            $(this).parent().parent().parent().siblings().find(".asideImgWrap img").eq(1).show();
            $(".topTitle").text($(this).text())
            $(".sp2").find(".asideImg").eq(1).hide();
            $(".sp2").find(".asideImg").eq(0).show();
            $(".sp2").find(".t2").css("color", "#333");
        })

    });

    function tab_titleList(obj) {
        var bStop = false,
            bStopIndex = 0,
            href = $(obj).attr(\'data-href\'),
            title = $(obj).attr("data-title"),
            topWindow = $(window.parent.document),
            show_navLi = topWindow.find("#min_title_list li"),
            iframe_box = topWindow.find("#iframe_box");
        if (!href || href == "") {
            layer.msg("data-href不存在，v2.5版本之前用_href属性，升级后请改为data-href属性");
            return false;
        }
        if (!title) {
            layer.msg("v2.5版本之后使用data-title属性");
            return false;
        }
        if (title == "") {
            layer.msg("data-title属性不能为空");
            return false;
        }
        show_navLi.each(function () {
            if ($(this).find(\'span\').attr("data-href") == href) {
                bStop = true;
                bStopIndex = show_navLi.index($(this));
                return false;
            }
        });
        if (!bStop) {
            creatIframe(href, title);
            min_titleList();
        } else {
            show_navLi.removeClass("active").eq(bStopIndex).addClass("active");
            iframe_box.find(".show_iframe").hide().eq(bStopIndex).show().find("iframe").attr("src", href);
        }
    }

    $(function () {
        MessagePlugin.init({
            elem: "#message",
            msgData: [
                {text: "暂无信息", id: 1, readStatus: 1},
            ],
            msgUnReadData: 0,
            noticeUnReadData: 0,
            msgClick: function (obj) {
                layer.msg($(obj).text());
            },
            noticeClick: function (obj) {
                layer.msg("提醒点击事件");
            },
            allRead: function (obj) {
                layer.msg("全部已读");
            },
            getNodeHtml: function (obj, node) {
                if (obj.readStatus == 1) {
                    node.isRead = true;
                } else {
                    node.isRead = false;
                }
                var html = "<p>" + obj.text + "</p>";
                node.html = html;
                return node;
            }
        });
        $(".menu-system").each(function () {
            $(this).mouseover(function () {
                $(this).find(".asideImg").eq(0).hide();
                $(this).find(".asideImg").eq(1).show();
                $(this).addClass("active");
                $(this).find(".t2").css("color", "#148cf1");
                $(".selected .t2").css("color", "#148cf1");
            })
            $(this).mouseout(function () {
                $(this).find(".asideImg").eq(1).hide();
                $(this).find(".asideImg").eq(0).show();
                $(this).removeClass("active");
                $(".selected .t2").css("color", "#333");
                $(".sp5").find(".asideImgWrap img").eq(0).hide();
                $(".sp5").find(".asideImgWrap img").eq(1).show();
                $(".t2").css("color", "#333");
                $(".sp5").find(".t2").css("color", "#148cf1");
            })

            $(this).click(function () {
                if (!$(".changeAside").hasClass("changed")) {
                    $(".menu-system dt").each(function () {
                        if ($(this).hasClass("selected")) {
                            $(this).find(".asideImgRight").eq(0).hide();
                            $(this).find(".asideImgRight").eq(1).show();
                        }
                        else {
                            $(this).find(".asideImgRight").eq(1).hide();
                            $(this).find(".asideImgRight").eq(0).show();
                        }
                    });
                }
            })
        });
        $(".changeAside").click(function () {
            if ($(this).hasClass("changed")) {
                $(this).removeClass("changed");
                $("aside").animate({width: "200"});//200
                $(".Hui-article-box").animate({left: "200"});//200
                $(".Hui-aside .menu_dropdown dl dt").animate({paddingLeft: "30"})
                setTimeout(function () {
                    $(".t2,.asideImgWrapRight").show();
                }, 500);
                $(".asideImg").css("left", "0px");
                $("#menu-article a").css({
                    width: "50px",
                    height: "50px",
                    position: "static"
                })
            }
            else {
                $(this).addClass("changed");
                $("aside").animate({width: "50"});//200
                $(".Hui-article-box").animate({left: "50"});//200
                $(".t2,.asideImgWrapRight").hide();
                $(".Hui-aside .menu_dropdown dl dt").animate({paddingLeft: "0"});//30
                $(".asideImg").css("left", "15px");
                $(".menu-system dd ").hide();
                $(".asideImgRight:odd").hide();
                $(".asideImgRight:even").show();
                $("#menu-article a").css({
                    position: "absolute",
                    width: "50px",
                    height: "50px",
                    left: "0px",
                })

            }
        });
        $(".menu-system").each(function () {
            $(this).mouseover(function () {
                $(this).removeClass("active");

            })
            $(this).mouseover(function () {
                if ($(".changeAside").hasClass("changed")) {
                    $(".menu-system dt").addClass("selected");
                    $(this).css({
                        paddingRight: "190px",
                        background: "#f6f7f8",
                    })
                    $(this).find("dd").css({
                        position: "absolute",
                        display: "block",
                        left: "50px",
                        width: "140px",
                        background: "#f6f7f8",
                    })
                    $(this).find("dt").css({
                        background: "#f6f7f8",
                    })
                    $(this).find(".t2").css({
                        position: "absolute",
                        display: "block",
                        width: "100px",
                        left: "70px",
                        background: "#f6f7f8",
                    })
                    $(".Hui-aside .menu_dropdown dd li a").css({
                        paddingLeft: "25px",
                    })
                    $(".Hui-aside .menu_dropdown dd ul").css("padding", 0)
                }

            })
            $(this).mouseout(function () {
                if ($(".changeAside").hasClass("changed")) {
                    $(".menu-system dt").removeClass("selected");
                    $(this).find("dd").css({
                        position: "static",
                        display: "none",
                        left: "50px",
                        width: "200px",
                        background: "#fff",
                    })
                    $(this).css({
                        paddingRight: "0px",
                        background: "#fff",
                    })
                    $(this).find("dt").css({
                        background: "#fff",
                    })
                    $(this).find(".t2").css({
                        position: "static",
                        display: "none",
                        width: "130px",
                        left: "40px",
                        background: "#fff",
                    })
                    $(".Hui-aside .menu_dropdown dd li a").css({
                        paddingLeft: "52px",
                    })
                    $(".Hui-aside .menu_dropdown dd ul").css("padding", "3px,8px")
                }

            })
        })
        $(".sp2 .asideImgWrap img").eq(1).show();
        $(".sp2 .asideImgWrap img").eq(0).hide();
        $(".changeColor li a").each(function () {
            $(this).mouseover(function () {
                $(this).css("backgroundColor", $(this).attr("data-color"));
                $(this).css("color", "#fff");
            })
            $(this).mouseout(function () {
                $(this).css("backgroundColor", "#fff");
                $(this).css("color", "#000");
            })
        })
        $(".sysBtn li a").each(function () {
            $(this).mouseover(function () {
                $(this).find("img").eq(0).hide();
                $(this).find("img").eq(1).show();
            })
            $(this).mouseout(function () {
                $(this).find("img").eq(1).hide();
                $(this).find("img").eq(0).show();
            })
        })
        $(".sysBtn li a").eq(0).click(function () {
            $("#changePassword").show();
            $("[name=oldPW]").val("");
            $("[name=newPW]").val("");
            $("[name=curNewPW]").val("");
        })
        $(".chang_click").click(function () {
            $(".jbxx_div").hide()
        })

        $(".coljks").click(function () {
            $(".jbxx_div").hide()
        })

        $(".sysBtn li a").eq(1).click(function () {
            if (data1.portrait) {
                $("[name=portrait]").attr("src", data1.portrait)
            }
            if (data1.nickname) {
                $("[name=name]").val(data1.nickname)
            }
            if (data1.tel) {
                $("[name=tel]").val(data1.tel)
            }
            $("[name=sex]").eq(data1.sex - 1).prop("checked", true);
            if (data1.birthday) {
                let birthday1 = data1.birthday.split("-");
                // if ($("#select1").val() == "1918" && $("#select2").val() == \'1\' && $("#select3").val() == "1") {
                    $("#select1").val(birthday1[0]);
                    $("#select2").val(birthday1[1]);
                    $("#select3").val(birthday1[2]);
                // }
            }
            if (data1.logo) {
                $("[name=logo]").attr("src", data1.logo)
            }
            if ($("[name=shop_name]").val().length == 0) {
                $("[name=shop_name]").val(data1.shop_name)
            }
            if ($("[name=shop_range]").val().length == 0) {
                $("[name=shop_range]").val(data1.shop_range)
            }
            if ($("[name=shop_information]").val().length == 0) {
                $("[name=shop_information]").val(data1.shop_information)
            }
            $.ajax({
                type: "post",
                url: "index.php?module=AdminLogin&action=maskContent",
                async: true,
                dataType: "json",
                success: function (data) {
                    data1 = data.re[0];
                    $("#nickname1").html(data1.nickname);
                },
                error: function (res) {
                    $(".dc").hide();
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
            });
            $("#jbxx").show();

        })
        $(".closeA").on("portrait", function () {
            $(this).find("img").attr("src", "images/icon1/gb_h.png");
        })
        $(".closeA").on("mouseout", function () {
            $(this).find("img").attr("src", "images/icon1/gb.png");
        })
    });

    function closeMask_p1(id, url, content) {
        $.ajax({
            type: "post",
            url: url + id,
            dataType: "json",
            data: {},
            async: true,
            success: function (data) {
                $(".maskNew").remove();
                console.log(data.status)
                if (data.suc) {
                    layer.msg(data.status);
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = history.go(-1);
                }else {
                    layer.msg(data.status);
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }

    function closeMask__1(id, url, content) {
        $.ajax({
            type: "post",
            url: url + id,
            dataType: "json",
            data: {},
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    console.log("res.status == 1");
                    layer.msg(res.info);
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.reload();
                    // ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
                else if (res.status == "2") {
                    console.log("res.status == 2");
                    layer.msg(res.info);
                }
                else {
                    console.log("else");
                    layer.msg(res.info);
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }

    function closeMask(id, url, content) {
        $.ajax({
            type: "post",
            url: url + id,
            dataType: "json",
            data: {},
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    layer.msg(content + "成功!");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.reload();
                    // ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
                else if (res.status == "2") {
                    layer.msg(res.info);
                }
                else {
                    layer.msg(content + "失败!");
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }
    // 提示框点确定跳转到相应页面
    function confirm_modify_close(url) {
        $(".maskNew").remove();
        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
        ifs.location.href= url;
    }
    function closeMaskPP(id, url,del_str, content) {//商品删除ajax请求，跳转相应页数
        del_str = JSON.parse(del_str);

        $.ajax({
            type: "post",
            url: url + id,
            dataType: "json",
            data: {},
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    layer.msg(content + "成功!");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.reload();
                    ifs.location.href=\'index.php?module=product&action=Index&cid=\'+del_str.cid+\'&brand_id=\'+del_str.brand_id+\'&status=\'+status+\'&s_type=\'+\'&product_title=\'+del_str.product_title+\'&show_adr=\'+del_str.show_adr+\'&page=\'+del_str.page+\'&pagesize=\'+del_str.pagesize
                }
                else if (res.status == "2") {
                    layer.msg(res.info);
                }
                else {
                    layer.msg(content + "失败!");
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }

    function closeMaskPC(id, url,del_str, content) {//商品分类删除ajax请求，跳转相应页数
        del_str = JSON.parse(del_str);
        $.ajax({
            type: "post",
            url: url + id,
            dataType: "json",
            data: {},
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                console.log(res.status)
                if (res.status == "1") {
                    layer.msg(content + "成功!");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.reload();
                   ifs.location.href=\'index.php?module=product_class&action=Index&cid=\'+del_str.cid+\'&pname=\'+del_str.pname+\'&pagesize=\'+del_str.pagesize+\'&page=\'+del_str.page
                }
                else if (res.status == "2") {
                    layer.msg(res.info);
                }
                else {
                    layer.msg(content + "失败!");
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }
    
    function closeMaskThird(id, url, content) {//第三方授权弹框
        $.ajax({
            type: "post",
            url: url + id,
            dataType: "json",
            data: {},
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    layer.msg(content + "成功!");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href=\'index.php?module=third&action=auth\';
                    // ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
                else if (res.status == "2") {
                    layer.msg(res.info);
                }
                else {
                    layer.msg(content + "失败!");
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }

    function closeMaskaa(id, url, content) {
        $.ajax({
            type: "get",
            url: url + id,
            dataType: "json",
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                console.log(res.status)
                if (res.status == "1") {
                    layer.msg(content + "成功!");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
                else if (res.status == "2") {
                    layer.msg(res.info);
                }
                else {
                    layer.msg(content + "失败!");
                }
            },
            error: function (err) {
                $(".maskNew").remove();
                layer.msg(err + "未知错误，请求失败！");
            }

        });
    }

    function closeMask1() {
        $(".maskNew").remove();
    }
    function closeMask1_1() {
        $(".maskNew").remove();
        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
    }

    function closeMask2(id, content, url) {
        $(".maskNew").remove();
        $.ajax({
            type: "post",
            url: url + id,
            async: true,
            dataType: "json",
            success: function (res) {
                if (content == "启用") {
                    if (res.status == 1) {
                        layer.msg("启用成功!");
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    } else {
                        layer.msg("启用失败!");
                    }
                } else {
                    if (res.status == 1) {
                        layer.msg("禁用成功!");
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    } else if (res.status == 2) {
                        layer.msg("该品牌正在使用，不允禁用!");
                    } else {
                        layer.msg("禁用失败!");
                    }
                }
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    }

    function closeMask3(id, type, url) {
        $.ajax({
            type: "post",
            url: url + id + \'&type=\' + type,
            async: true,
            dataType: "json",
            success: function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    localStorage.setItem("id_list",\'\');
                    layer.msg("修改成功！");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }else if (res.status == 2) {
                    layer.msg(\'该商品有参与插件活动，无法下架！\');
                }else if (res.status == 3) {
                    layer.msg(\'该商品有未完成的订单，无法下架！\');
                }else if (res.status == 4) {
                    layer.msg(\'请先去完善商品信息！\');
                } else {
                    layer.msg("修改失败！");
                }
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    }
    var play = true;
    function closeMask4(m, id, user_id, money, s_charge, url) {
        if (!play) {return;}
        play = false;
        $.get(url, {
            \'m\': m,
            \'id\': id,
            \'user_id\': user_id,
            \'money\': money,
            \'s_charge\': s_charge
        }, function (res) {
            $(".maskNew").remove();
            play = true;
            if (res == "1") {
                layer.msg("操作成功!2");
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                 ifs.location.href = \'index.php?module=finance\';
                // ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            } else {
                layer.msg("操作失败!");
            }
        }, "json").error(function(){
			$(".maskNew").remove();
            play = true;
			layer.msg("操作失败!");
		});
    }
    function closeMask4_1(m, id, user_id, money, s_charge, url ,that) {
        if (!play) {return;}
        play = false;
		if(!$(that).prop(\'flag\')){
			$(that).prop(\'flag\',true)
			var reason=$("[name=jujue]").val()
			$.get(url, {
			    \'m\': m,
			    \'id\': id,
			    \'user_id\': user_id,
			    \'money\': money,
			    \'s_charge\': s_charge,
			    \'reason\':reason,
			
			}, function (res) {
			    $(".maskNew").remove();
                play = true;
			    if (res == "1") {
			        layer.msg("操作成功!");
			        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                     console.log( $(ifs).find(\'.swivch_active\').attr(\'href\'))
                     ifs.location.href = \'index.php?module=finance\';
			    } else {
			        layer.msg("操作失败!");
			    }
			}, "json").error(function(){
				$(".maskNew").remove();
                play = true;
				layer.msg("操作失败!");
			});
		}
    }
    function closeMask4_2(id, mch_status, url) {
        var reason=$("[name=jujue]").val()
        $.get(url, {
            \'id\': id,
            \'mch_status\': mch_status,
            \'reason\':reason,
        }, function (res) {
            $(".maskNew").remove();
            if (res == "1") {
                layer.msg("操作成功!");
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(ifs).find(\'.swivch_active\').attr(\'href\');
            } else {
                layer.msg("操作失败!");
            }
        }, "json").error(function(){
			$(".maskNew").remove();
			layer.msg("操作失败!");
		});

    }

    function closeMask_1(id, url, type, y_id) {
        $.ajax({
            type: "get",
            url: url + id,
            async: true,
            dataType: "json",
            success: function (res) {
                $(".maskNew").remove();
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                let y_is_default = ifs.getElementsByName("is_default");

                if (res.status == "1") {
                    if (type == 1) {
                        console.log($(ifs).find("#is_default_" + id))
                        $(ifs).find("#is_default_" + id).attr("checked", false);
                    } else {
                        $(ifs).find("#is_default_" + y_id).attr("checked", false);
                        $(ifs).find("#is_default_" + id).attr("checked", true);
                    }
                    layer.msg("修改成功!");
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }
                else {
                    layer.msg("修改失败!");
                }
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    };

    function closeMask12() {
        $(".maskNew").remove();
        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
    }

    function closeMask13(type, Id) {
        $.get("index.php?module=member&action=MemberRecordDel", {\'id\': Id, \'type\': type}, function (res) {
            $(".maskNew").remove();
            if (res.status == "1") {
                layer.msg("删除成功!");
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            } else {
                layer.msg("删除失败!");
            }
        }, "json");
    }

    function closeMask14(type, id) {
        $.ajax({
            type: "GET",
            url: \'index.php?module=twelve_draw&action=listdel\',
            data: "m=" + type + "&id=" + id,
            dataType: \'json\',
            success: function (msg) {
                layer.msg(msg.status);
                if (msg.suc) {
                    location.href = "index.php?module=twelve_draw";
                }
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    }

    function dc() {
        $(".dc").hide();
    }

    function show_dc() {
        console.log("show_dc")
        $(".dc").show();
    }

    /**
    * 判断发货选择类型
    */
    function isType(){
        if(radioType === 1){
            return \'#kuaidi1\'
        }
        return \'#kuaidi2\'
    }

    function qd(url, type) {

        var res = isType()

        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
        let id = $(\'.order_id\').val(); // 订单号
        let oid = $(\'.oid\').val(); // 订单号

        let express = $(res).val(); // 快递公司id

        let express_name = $(res).find("option:selected").text(); // 快递公司名称
        let courier_num = $(\'input[name=danhao]\').val(); // 快递单号

        let otype = $(".otype").val(); // 类型
        let data;
        if (type == 1 || type == 3) {
            data = {
                sNo: id,
                trade: 3,
                express: express,
                courier_num: courier_num,
                otype: otype,
                express_name: express_name,
                express_type: radioType
            };
        } else if (type == 2) {
            data = {sNo: id, express: express, courier_num: courier_num, express_name: express_name, express_type: radioType};
        }
        
        $.ajax({
            url: url,
            type: "post",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    layer.msg(data.succ);
                    setTimeout(function () {
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href =\'index.php?module=orderslist&action=Detail&id=\'+oid;
                    }, 1000)
                } else {
                    layer.msg(data.err);
                }
                $(".dc").hide();
                $("#makeInput").val("");
                $(".ipt1").val("")
            },
            error: function (res) {
                /*  $(".dc").remove(); */
                layer.msg(\'发货失败！\');
                setTimeout(function () {
                    // location.replace(location.href);
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }, 1000)
            }
        });
    };

    function qd_(url, type) {
        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
        let id = $(\'.order_id\').val(); // 订单号
        let oid = $(\'.oid\').val(); // 订单号
        let express = $(\'select[name=kuaidi]\').val(); // 快递公司id
        let express_name = $(\'select[name=kuaidi]\').find("option:selected").text(); // 快递公司名称
        let courier_num = $(\'input[name=danhao_]\').val(); // 快递单号
        let otype = $(".otype").val(); // 类型
        let data;
        if (type == 1 || type == 3) {
            data = {
                sNo: id,
                trade: 3,
                express: express,
                courier_num: courier_num,
                otype: otype,
                express_name: express_name
            };
        } else if (type == 2) {
            data = {sNo: id, express: express, courier_num: courier_num, express_name: express_name};
        }

        $.ajax({
            url: url,
            type: "post",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    layer.msg(data.succ);
                    setTimeout(function () {
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href =\'index.php?module=orderslist&action=Detail&id=\'+oid;
                    }, 1000)
                } else {
                    layer.msg(data.err);
                }
                $(".dc").hide();
                $("#makeInput").val("");
                $(".ipt1").val("")
            },
            error: function (res) {
                /*  $(".dc").remove(); */
                layer.msg(\'发货失败！\');
                setTimeout(function () {
                    // location.replace(location.href);
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                }, 1000)
            }
        });
    };

    function stock_add(url,id,pid,type) {
        var add_num = $("#add_num").val();
        var total_num = $("#total_num").val();
        var num = $("#num").val();
        $.ajax({
            cache: true,
            type: "POST",
            dataType:"json",
            url:url,
            data: {
                id: id,
                pid: pid,
                add_num: add_num,
                total_num: total_num,
                num: num,
            },
            async: true,
            success: function(data) {
                $(".maskNew").hide();
                layer.msg(data.status,{time:2000});
                if(data.suc){
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    if(type == 1){
                        ifs.location.href = \'index.php?module=stock\';
                    }else{
                        ifs.location.href = \'index.php?module=stock&action=Warning\';
                    }
                }
            }
        });
    }

    <!-- 查询分类品牌联动开始 -->
    // 点击分类框
    var selectFlag = true  //判断点击分类框请求有没有完成,没完成继续点击不会再次请求
    var choose_class = true  //判断选择分类请求有没有完成,没完成继续点击不会再次请求
    function select_class(){
        var class_str = $(\'.selectDiv option\').val()
        var brand_str = $("#brand_class option:selected").val();
        if($(\'#selectData\').css(\'display\')==\'none\'){
            $(\'#selectData\').css(\'display\',\'flex\')

            if(selectFlag&&choose_class){
                selectFlag=false
                $.ajax({
                    type: "GET",
                    url: \'index.php?module=product&action=Ajax\',
                    data: {
                        \'class_str\':class_str,
                        \'brand_str\':brand_str
                    },
                    success: function (msg) {
                        $(\'#brand_class\').empty()
                        $(\'#selectData_1\').empty()
                        obj = JSON.parse(msg)
                        var brand_list = obj.brand_list
                        var class_list = obj.class_list
                        var rew = \'\';
                        if(class_list.length != 0){
                            var num = class_list.length-1;
                            display(class_list[num])
                        }

                        for(var i=0;i<brand_list.length;i++){
                            if(brand_list[i].status == true){
                                rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                            }else{
                                rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                            }
                        }
                        $(\'#brand_class\').append(rew)
                    },
                    complete(XHR, TS){
                        // 无论请求成功还是失败,都要把判断条件改回去
                        selectFlag=true
                    }
                });
            }
        }else{
            $(\'#selectData\').css(\'display\',\'none\')
        }
    }
    // 选择分类
    function class_level(obj,level,cid,type){
        var text = obj.innerHTML
        var text_num = $(\'.selectDiv>div>p\').length

        $(\'.selectDiv option\').text(\'\').attr(\'value\',cid)

        $(obj).addClass(\'active\').siblings().removeClass(\'active\')
        var brand_str = $("#brand_class option:selected").val();
        // 给当前元素添加class，清除同级别class
        // 获取ul标签数量
        var num = $("#selectData ul").length;
        if(selectFlag&&choose_class){
            choose_class=false
            $.ajax({
                type: "POST",
                url: \'index.php?module=product&action=Ajax\',
                data: {
                    "cid":cid,
                    "brand_str":brand_str,
                },
                success: function (msg) {
                    $(\'#brand_class\').empty()
                    $(\'#selectData_1\').empty()
                    res = JSON.parse(msg)
                    var class_list = res.class_list
                    var brand_list = res.brand_list
                    var rew = \'\';
                    var html = $(\'.selectDiv>div\').html().replace(/^\\s*|\\s*$/g,"");// 去除字符串内两头的空格

                    if(type == \'\'){
                        if(text_num - 2 == level){
                            var text_num1 = text_num - 1;
                            var parent=document.getElementById("div_text");
                            var son0=document.getElementById("p"+text_num);
                            var son1=document.getElementById("p"+text_num1);
                            parent.removeChild(son0);
                            parent.removeChild(son1);
                            if(class_list.length == 0){ // 该分类没有下级
                                if(html==\'\'){
                                    str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'></p>`
                                }else{
                                    $(\'.del_sel\').remove()
                                    str=`<p class=\'selectItem\' id="p${text_num1}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id=\'p${text_num1+1}\' onclick=\'del_sel(this)\'></p>`
                                }
                                $(\'#selectData\').css(\'display\',\'none\')
                            }else{
                                display(class_list[0])
                                if(html==\'\'){
                                    str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                }else{
                                    $(\'.del_sel\').remove()
                                    str=`<p class=\'selectItem\' id="p${text_num1}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id="p${text_num1+1}" onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                }
                            }
                        }else{
                            if(class_list.length == 0){ // 该分类没有下级
                                if(html==\'\'){
                                    str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'></p>`
                                }else{
                                    $(\'.del_sel\').remove()
                                    str=`<p class=\'selectItem\' id="p${text_num}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id=\'p${text_num+1}\' onclick=\'del_sel(this)\'></p>`
                                }
                                $(\'#selectData\').css(\'display\',\'none\')
                            }else{
                                display(class_list[0])
                                if(html==\'\'){
                                    str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                }else{
                                    $(\'.del_sel\').remove()
                                    str=`<p class=\'selectItem\' id="p${text_num}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id="p${text_num+1}" onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                }
                            }
                        }
                        $(\'.selectDiv>div\').append(str)
                    }else{
                        display(class_list[0])
                    }

                    for(var i=0;i<brand_list.length;i++){
                        if(brand_list[i].status == true){
                            rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                        }else{
                            rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                        }
                    }
                    $(\'#brand_class\').append(rew)
                },
                complete(XHR, TS){
                    // 无论请求成功还是失败,都要把判断条件改回去
                    choose_class=true
                }
            });
        }
    }
    // 显示分类
    function display(class_list) {
        var res = \'\';
        for(var i=0;i<class_list.length;i++){
            if(class_list[i].status == true){
                res += `<li class=\'active\' value=\'${class_list[i].cid}\' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},\'\')">${class_list[i].pname}</li>`;
                continue
            }
            res += `<li value=\'${class_list[i].cid}\' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},\'\')">${class_list[i].pname}</li>`;
        }
        $(\'#selectData_1\').append(res)
    }
    // 删除选中的类别
    function del_sel(me,level,cid){
        if(cid){
            if(level == 0){
                var cid1 = 0;
                class_level(me,level,cid1,\'type\')
            }else{
                var cid1 = $(\'#p\'+level).eq(0).attr(\'tyid\');
                class_level(me,level-1,cid1,\'type\')
            }
            $(me).nextAll().remove()
            $(me).remove()
            if($(\'.selectDiv>div\').html()==\'\'){
                $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',0)
            }else{
                if(cid1 == 0){
                    $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',cid1)
                }else{
                    $(\'.selectDiv option\').text(\'\').attr(\'value\',cid1)
                    $(\'.selectDiv>div\').append(`<p class=\'selectItem del_sel\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`)
                }
            }
            if(level){
                event.stopPropagation()
            }
        }
    }

    function select_pinpai(){
        var class_str = $("[name=product_class]").val();
        if(class_str == \'\' || class_str <= 0){
            layer.msg("请先选择商品类别！", {
                time: 2000
            });
        }
    }
    <!-- 查询分类品牌联动结束 -->

    <!-- 满减开始 -->
    // 店铺-调用子页面方法
    function range_del_confirm(range) {
        var childWin=$("body").find("iframe[id=subtraction]")[0].contentWindow;
        childWin.confirm_range_del(range);
        $(".maskNew").remove();
    }
    // 查询商品
    function chaxun(obj) {
        var cid = $("#cid").val();
        var brand_id = $("#brand_id").val();
        var product_title = $("#product_title").val();
        $(obj).attr("disabled",true);
        $("#product_list1").empty();
        $.ajax({
            cache: true,
            type: "GET",
            dataType: "json",
            url: \'index.php?module=subtraction&action=Config&m=chaxun\',
            data: {
                class_id:cid,
                brand_class_id:brand_id,
                title:product_title
            },
            async: true,
            success: function (data) {
                if(data.product_list == \'\' || data.product_list == \'undefined\'){
                    layer.msg(\'查无此商品\', {time: 1000});
                }else{
                    var res = \'<div class="tab_table" style="height: auto;">\'+
                        \'<table class="table-border tab_content" style="border: 1px solid #E9ECEF;">\'+
                        \'   <thead>\' +
                        \'       <tr class="text-c tab_tr" style="height: 50px;">\' +
                        \'           <th width="40" style="padding: 9px 10px!important;">\' +
                        \'               <div style="position: relative;display: flex;height: 30px;align-items: center;">\' +
                        \'                   <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC" >\' +
                        \'                   <label for="ipt1" onclick="quanxuan()"></label>\' +
                        \'                   <span >全选</span>\' +
                        \'               </div>\' +
                        \'           </th>\' +
                        \'           <th  colspan="2" style="padding: 9px 10px!important;">商品名称</th>\' +
                        \'           <th style="padding: 9px 10px!important;">店铺</th>\' +
                        \'           <th style="padding: 9px 10px!important;">价格</th>\' +
                        \'           <th style="padding: 9px 10px!important;">库存</th>\' +
                        \'       </tr>\' +
                        \'   </thead>\' +
                        \'   <tbody>\';
                    if(data.product_list.length != 0){
                        product_list = data.product_list;
                        for (var k in product_list) {
                            res += `<tr class="text-c tab_td" >
                                <td style="height: 59px;">
                                    <div style="display: flex;align-items: center;height: 60px;">
                                        <input name="product[]"  id="${product_list[k][\'id\']}" type="checkbox" class="inputC product" value="${product_list[k][\'id\']}">
                                        <label for="${product_list[k][\'id\']}"></label>
                                    </div>
                                </td>

                               <td style="width: 80px;height: 59px;" >
                                   <img src="${product_list[k][\'imgurl\']}" style="width: 42px;height: 42px;">
                               </td>
                               <td style="text-align: left;height: 59px;">
                                   <text>${product_list[k][\'product_title\']}</text>
                               </td>
                               <td style="height: 59px;">${product_list[k][\'mch_name\']}</td>
                               <td style="height: 59px;">${product_list[k][\'present_price\']}</td>
                               <td style="height: 59px;">${product_list[k][\'num\']}</td>
                            </tr>`;
                        }
                        res += "</tbody>" +
                            "</table>"+
                            "</div>";

                        pages_show = data.pages_show;
                        res += `<div style="text-align: center;display: flex;justify-content: center;">${pages_show}</div>`;

                        document.getElementById(\'queren\').style.display = "";

                        $("#product_list1").append(res);
                        $(obj).attr("disabled",false);
                    }
                }
            }
        });
    }
    // 选择商品页面跳转
    function tiaozhuan(url) {
        $("#product_list1").empty();
        $.ajax({
            cache: true,
            type: "GET",
            dataType: "json",
            url: url,
            async: true,
            success: function (data) {
                var res = \'<div class="tab_table" style="height: auto;">\'+
                    \'<table class="table-border tab_content" style="border: 1px solid #E9ECEF;">\'+
                    \'   <thead>\' +
                    \'       <tr class="text-c tab_tr" style="height: 50px;">\' +
                    \'           <th width="40" style="padding: 9px 10px!important;">\' +
                    \'               <div style="position: relative;display: flex;height: 30px;align-items: center;">\' +
                    \'                   <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC" >\' +
                    \'                   <label for="ipt1" onclick="quanxuan()"></label>\' +
                    \'                   <span >全选</span>\' +
                    \'               </div>\' +
                    \'           </th>\' +
                    \'           <th  colspan="2" style="padding: 9px 10px!important;">商品名称</th>\' +
                    \'           <th style="padding: 9px 10px!important;">店铺</th>\' +
                    \'           <th style="padding: 9px 10px!important;">价格</th>\' +
                    \'           <th style="padding: 9px 10px!important;">库存</th>\' +
                    \'       </tr>\' +
                    \'   </thead>\' +
                    \'   <tbody>\';
                if(data.product_list.length != 0){
                    product_list = data.product_list;
                    for (var k in product_list) {
                        res += `<tr class="text-c tab_td" >
                                <td style="height: 59px;">
                                    <div style="display: flex;align-items: center;height: 60px;">
                                        <input name="product[]"  id="${product_list[k][\'id\']}" type="checkbox" class="inputC product" value="${product_list[k][\'id\']}">
                                        <label for="${product_list[k][\'id\']}"></label>
                                    </div>
                                </td>

                               <td style="width: 80px;height: 59px;" >
                                   <img src="${product_list[k][\'imgurl\']}" style="width: 42px;height: 42px;">
                               </td>
                               <td style="text-align: left;height: 59px;">
                                   <text>${product_list[k][\'product_title\']}</text>
                               </td>
                               <td style="height: 59px;">${product_list[k][\'mch_name\']}</td>
                               <td style="height: 59px;">${product_list[k][\'present_price\']}</td>
                               <td style="height: 59px;">${product_list[k][\'num\']}</td>
                            </tr>`;
                    }
                    res += "</tbody>" +
                        "</table>"+
                        "</div>";

                    pages_show = data.pages_show;
                    res += `<div style="text-align: center;display: flex;justify-content: center;">${pages_show}</div>`;
                    $("#product_list1").append(res);
                }
                serch = false;
            }
        });
    }
    // 点击确认
    function commodity_confirm() {
        var checkbox = $("input[name=\'product[]\']:checked");//被选中的复选框对象
        if(checkbox.length > 0){
            $.each($("input[name=\'product[]\']"),function (index,element) {
                if($(element).prop(\'checked\') == false){
                    $(element).parents(\'.protype1\').remove();
                }
            });
            productid = \'\';
            for(var i=0;i<checkbox.length;i++){
                productid += checkbox.eq(i).val()+",";
            }
        }else{
            layer.msg("请选择需要的商品");
            return false;
        }

        var childWin=$("body").find("iframe[id=subtraction]")[0].contentWindow;
        childWin.commodity_confirm(productid);
        $(".maskNew").remove();
    }
    // 全选
    function quanxuan() {
        var checkbox=document.getElementById("ipt1").checked;//被选中的复选框对象
        var str=document.getElementsByClassName("product");
        if(checkbox == false){
            for(var i=0;i<str.length;i++){
                //如果没有被选中
                if(!str[i].checked){
                    //改变选中框的属性，让它选中
                    str[i].checked=true;
                }
            }
        }else{
            for(var i=0;i<str.length;i++){
                //如果没有被选中
                if(str[i].checked){
                    //改变选中框的属性，让它选中
                    str[i].checked=false;
                }
            }
        }
    }
    // 店铺-调用子页面方法
    function position_del_confirm(position) {
        var childWin=$("body").find("iframe[id=subtraction]")[0].contentWindow;
        childWin.confirm_position_del(position);
        $(".maskNew").remove();
    }
    // 全选
    function sel_all() {
        if ($("#sex-all").get(0).checked) {
            //全选
            $("input[type=\'checkbox\']").prop("checked", true);
        }else{
            //全不选
            $("input[type=\'checkbox\']").prop("checked", false);
        }
    }
    // 选择地址
    function add_address() {
        var obj = document.getElementsByName("list");
        var check_val = [];
        for(k in obj){
            if(obj[k].checked)
                check_val.push(obj[k].value);
        }
        var childWin=$("body").find("iframe[id=subtraction]")[0].contentWindow;
        childWin.add_address(check_val);
        $(".maskNew").remove();
    }
    <!-- 满减结束 -->

    function closeMask_role(id, url, content) {
        $.ajax({
            type: "GET",
            url: url + id,
            dataType: "json",
            async: true,
            success: function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    layer.msg(content + "成功!");
                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                } else if (res.status == "2") {
                    layer.msg(res.info);
                } else {
                    layer.msg(content + "失败!");
                }
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    }

    function getData1() {
        var ifs1 = $(".show_iframe").eq(0).find("iframe")[0].contentWindow;
        window.ifs1 = ifs1;
    }

    function yesC() {
        var title = ifs1.arr1.title,
            content = ifs1.arr1.content,
            yestext = ifs1.arr1.yestext,
            notext = ifs1.arr1.notext,
            yesfn = ifs1.arr1.yesfn,
            nofn = ifs1.arr1.nofn,
            id = ifs1.arr1.id,
            url = ifs1.arr1.url,
            nolink = ifs1.arr1.nolink,
            yeslink = ifs1.arr1.yeslink,
            prompt = ifs1.arr1.prompt,
            click_bg = ifs1.arr1.click_bg,
            obj = ifs1.arr1.obj,
            type = ifs1.arr1.type,
            price = ifs1.arr1.price,
            price = Number(price);
        str = ifs1.arr1.str;
        td = ifs1.arr1.td;
        var price = Number($(".prompt-text").val());
        $.ajax({
            type: "GET",
            url: url,
            data: {
                user_id: id,
                m: type,
                price: price
            },
            success: function (res) {
                console.log(res)
                if (res == 1) {
                    $(".maskNew").remove();
                    layer.msg(\'提交成功\');
                    setTimeout(function () {
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    }, 1000);
                } else {
                    $(".maskNew").remove();
                    layer.msg(\'操作失败!\');
                }
            },
            error: function (res) {
                $(".dc").hide();
                layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
    }

    function yesB() {
        var title = ifs1.arr1.title,
            content = ifs1.arr1.content,
            yestext = ifs1.arr1.yestext,
            notext = ifs1.arr1.notext,
            yesfn = ifs1.arr1.yesfn,
            nofn = ifs1.arr1.nofn,
            id = ifs1.arr1.id,
            url = ifs1.arr1.url,
            nolink = ifs1.arr1.nolink,
            yeslink = ifs1.arr1.yeslink,
            prompt = ifs1.arr1.prompt,
            click_bg = ifs1.arr1.click_bg,
            obj = ifs1.arr1.obj,
            type = ifs1.arr1.type,
            price = ifs1.arr1.price,
            price = Number(price);
        str = ifs1.arr1.str;
        td = ifs1.arr1.td;
        if (type == 2 || type == 5 || type == 8) {
            var text = $(".prompt-text").val();
            if (text.length > 0) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "id=" + id + \'&text=\' + text + \'&m=\' + type,
                    success: function (res) {
                        console.log(res);
                        if (res) {
                            td.html(str);
                            td.prev().html(\'<span style="color:#ff2a1f;">已拒绝</span>\');
                            $(".maskNew").remove();
                            layer.msg(\'提交成功\');
                            setTimeout(function () {
                                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                            }, 1000);
                        } else {
                            layer.msg(\'操作失败!\');
                        }
                    },
                    error: function (res) {
                        $(".dc").hide();
                        layer.msg(\'您没有该权限！\');
                        // location.replace(location.href);
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    }
                });

            } else {
                layer.msg(\'拒绝理由不能为空!\');
            }
        } else {
            var text = $(".prompt-text").val();
            if (type == 1 || type == 6) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: "id=" + id + \'&m=\' + type,
                    success: function (res) {
                        console.log(res);
                        if (res == 1) {
                            td.html(str);
                            if (type == \'4\' || type == \'9\') {
                                var status = \'<span style="color:#8FBC8F;">已退款</span>\';
                            } else {
                                var status = \'<span style="color:#A4D3EE;">待买家发货</span>\';
                            }
                            td.prev().html(\'<span style="color:#30c02d;">\' + status + \'</span>\');
                            $(".maskNew").remove();
                            layer.msg(\'提交成功\');
                            setTimeout(function () {
                                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                            }, 1000);

                        }else if(res == 3){
                            layer.msg(\'请先在系统管理中设置售后地址！\');
                        } else {
                            layer.msg(\'操作失败!\');
                        }
                    },
                    error: function (res) {
                        $(".dc").hide();
                        layer.msg(\'您没有该权限！\');
                        // location.replace(location.href);
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    }
                });
            }
            else {
                console.log(Number(text), Number(price), price);
                if (Number(text) > 0 && Number(text) <= Number(price)) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: "id=" + id + \'&m=\' + type + \'&price=\' + Number(text),
                        success: function (res) {
                            console.log(res);
                            if (res == 1) {
                                td.html(str);
                                if (type == \'4\' || type == \'9\') {
                                    var status = \'<span style="color:#8FBC8F;">已退款</span>\';
                                } else {
                                    var status = \'<span style="color:#A4D3EE;">待买家发货</span>\';
                                }
                                td.prev().html(\'<span style="color:#30c02d;">\' + status + \'</span>\');
                                $(".maskNew").remove();
                                layer.msg(\'退款成功\');
                                setTimeout(function () {
                                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                                    ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                                }, 1000);
                            }else if(res == 3){
                                layer.msg(\'请先在系统管理中设置售后地址！\');
                            }else if(res == 2){
                                layer.msg(\'商户余额不足，退款失败！\');
                            }else {
                                console.log(\'res__________\');
                                console.log(res);
                                layer.msg(\'操作失败!\');
                            }
                        },
                        error: function (res) {
                            $(".dc").hide();
                            layer.msg(\'您没有该权限！\');
                            // location.replace(location.href);
                            let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                        }
                    });
                } else {
                    layer.msg(\'输入金额有误,请重新输入!\');
                }

            }
        }

    };
    //循环执行，每隔30秒钟执行一次    ---------------------------验证登入----------------------------------------------
    var t1 = window.setInterval(refreshCount, 30 * 1000);

    function refreshCount() {
        $.ajax({
            url: location.href,
            type: "post",
            data: {
                \'m\': \'check\'
            },
            success: function (res) {
                var data = JSON.parse(res);
                var numB = 0;
                $(".msgNum1").each(function (i) {
                    $(this).text(Object.values(data.re)[i]);
                    numB += Number(Object.values(data.re)[i]);
                })
                $(".msgDiv1").each(function (i) {
                    let numA = 0;
                    $(this).parent().find(".msgNum1").each(function (i) {
                        numA += Number($(this).text());
                    })

                    if (numA > 99) {
                        numA = 99+\'+\';
                    }
                    $(this).find(".msgNum").text(numA);
                })

                if (numB > 99) {
                    numB = 99+\'+\';
                }
                $("#tatalNum").text(numB);

                if(data.status == 1) {
                    window.clearInterval(t1);
                    alert(\'您的账户已被锁定，请联系客服！\');
                    parent.location.href=\'index.php?module=Login&action=Logout\';
                }
                // if(data.code == 1) {
                //     window.clearInterval(t1);
                //     parent.location.href=\'index.php?module=Login&action=logout\';
                // }else if(data.code == 2){
                //     window.clearInterval(t1);
                //     alert(\'您的账户在其他地方登入，您被迫下线！\'); parent.location.href=\'index.php?module=Login&action=logout\';
                // }else{
                //
                // }
            },
            error: function (res) {
                $(".dc").hide();
                // layer.msg(\'您没有该权限！\');
                // location.replace(location.href);
                let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
            }
        });
        console.log("定时检查登入----");
    }
	
	function export_close1(url,type,por_class) {
	
	    $("#pup_div").remove();
	    if(por_class == \'por_class\'){
			var src = url+\'&pageto=\'+type
	        $(\'iframe\').eq(0).attr("src",src)
		}else{
			var src=$(\'iframe\').eq(0).attr("src") +\'&pageto=\'+type;
	        $(\'iframe\').eq(0).attr("src",src)
	    }
	}
</script>
'; ?>


</body>
</html>