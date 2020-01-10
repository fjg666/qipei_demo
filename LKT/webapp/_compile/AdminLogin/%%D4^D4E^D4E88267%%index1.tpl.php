<?php /* Smarty version 2.6.31, created on 2019-12-20 18:01:06
         compiled from index1.tpl */ ?>
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

    <title>电商管理系统界面</title>
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
                background: rgba(102, 102, 102, .6);
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
                border-radius: 10px;
                padding: 10px 0px;
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
                padding: 16px 0 0;
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
                width: 80%;
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
                margin-right: 30px;

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
                display: none;
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
                border-radius: 50%;
                width: 20px;
                height: 20px;
                display: inline-block;
                color: #fff;
                line-height: 20px;
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

            .Hui-aside{top: 0!important;z-index: 999;}
            .home_aside{background-color: #343B4A;border-right: 0!important;}
            .home_aside .menu_dropdown dl{background-color: transparent;}
            .home_aside .menu_dropdown dt{border: 0!important;}
            .hui_logo{height: 60px;width: 100%;display: flex;justify-content: center;background-color: #232a3a;}
            .Hui-aside .menu_dropdown .active dt{color: #fff;}
            .Hui-aside .menu_dropdown li a:hover{background-color: transparent;color:#fff!important;}
            .hui_logo img{width: 180px;height: 34px;margin: auto;}
            .Hui-aside .menu_dropdown dt{color: #C8CDDC;}
            .Hui-aside .sp5 dt{background-color: #454D60!important;}
            .Hui-aside .menu_dropdown li a{color: #97A0B4;}
            .Hui-header{background-color: white!important;}
            .Hui-userbar > li > a{color: #414658!important;}
            .Hui-header{box-shadow:0px 0px  10px 1px #999;}
            .logi_2{display: none;}
        </style>
    '; ?>

</head>
<body id="body">
<header class="Hui-header cl" style="margin:0;">
    <a class="Hui-logo l" title="H-ui.admin v2.3" href="index.php?module=AdminLogin">
        <img style="width: 100px;" src="images/admin_logo.png"/>

    </a>
    <a class="Hui-logo-m l" href="index.php?module=AdminLogin" title="H-ui.admin"></a>
    <span class="Hui-subtitle l"></span>
    <a class="changeAside" href="javascript:void(0)">
        <img style="width: 20px;" src="images/iIcon/shouqi.png" alt=""/>
    </a>

    <ul class="Hui-userbar">
        <li class="dropDown dropDown_hover headerLi">
            <a href="#" class="dropDown_A">
                <img class="userIdImg" src="images/iIcon/tx.png" alt=""/>
                <span id="nickname1"></span>
                <i class="Hui-iconfont">&#xe6d5;</i>
            </a>
            <ul class=" sp1 dropDown-menu radius box-shadow sysBtn">
                <li>
                    <a _href="#" href="javascript:void(0)" title="修改密码">
                        <i><img src="images/iIcon/xg.png"/>
                            <img src="images/iIcon/xgmm_h.png" style="display: none;"/>
                        </i>
                        &nbsp;修改密码
                    </a>
                </li>
                <li>
                    <a _href="#" title="基本信息">
                        <i><img src="images/iIcon/xinxi.png"/>
                            <img src="images/iIcon/jbxx_h.png" style="display: none;"/>
                        </i>
                        &nbsp;基本信息
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="index.php?module=Login&action=Logout" style="display: flex;align-items: center;" title="退出系统">
                <img src="images/iIcon/tcl.png"/>
            </a>
        </li>
    </ul>
    </div>
    <a href="javascript:;" class="Hui-nav-toggle Hui-iconfont" aria-hidden="false">&#xe667;</a>
</header>
<aside class="Hui-aside home_aside">
    <input runat="server" id="divScrollValue" type="hidden" value=""/>
    <div class="hui_logo">
    	<img src="images/iIcon/logow.png" class="logi_1">
    	<img style="width: 34px;" src="images/logo2.png" class="logi_2" />
    </div>
    <div class="menu_dropdown bk_2">
        <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
            <dl class="menu-system">
                <?php if ($this->_tpl_vars['admin_type'] == 1 && $this->_tpl_vars['item']->title == '权限管理'): ?>
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
                                <li class="textApi ifsAPI"><a _href="<?php echo $this->_tpl_vars['item1']->url; ?>
" data-title="<?php echo $this->_tpl_vars['item1']->title; ?>
" href="javascript:void(0)"><?php echo $this->_tpl_vars['item1']->title; ?>
</a></li>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    </dd>
                <?php else: ?>
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
                                <?php if ($this->_tpl_vars['item1']->title != '图标管理'): ?>
                                <li class="textApi ifsAPI"><a _href="<?php echo $this->_tpl_vars['item1']->url; ?>
" data-title="<?php echo $this->_tpl_vars['item1']->title; ?>
" href="javascript:void(0)"><?php echo $this->_tpl_vars['item1']->title; ?>
</a></li>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    </dd>
                <?php endif; ?>
            </dl>
        <?php endforeach; endif; unset($_from); ?>
    </div>
</aside>
<section class="Hui-article-box" style="margin-bottom: 40px">
    <div id="Hui-tabNav" class="Hui-tabNav">
        <div class="Hui-tabNav-wp" style="opacity: 0;visibility: hidden;">
            <ul id="min_title_list" class="acrossTab cl" style="margin:0;">
                <li class="active"><span>商城管理</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group">
            <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a>
        </div>
        <a class="topTitle" style="" title="商城管理" data-href="index.php?module=Customer">商城管理</a>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="index.php?module=Customer"></iframe>
        </div>
    </div>
</section>
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
        <div class="maskContent1" style="height: 400px;">
            <img class='clsCPW chang_click closeImg' src="images/icon1/gb.png"/>
            <div class='maskTitle' style='display: block;'>基本信息</div>
            <form action="javascript:void(0);" method="post" style='height: 358px;' id="storeInfoForm"  enctype="multipart/form-data">
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
                    <div style="position: relative;height: auto;margin-top: 20px;">
                        <div style="position: absolute; right: 30px; top: -6px; margin:0 auto;display: flex;align-items: center;">
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
        &nbsp;&nbsp;&nbsp;&nbsp;
        <span>0731-86453408</span>
    </div>
    <div class="bottom_right" style="position: relative;left: -90px;">
         <span>
         	<a class="BA"
               href="http://www.laiketui.com">Copyright&nbsp;©&nbsp;2017&nbsp;壹拾捌号网络版权所有[官方网站]&nbsp;&nbsp;</a>
         	<a class="BA" href="http://www.miibeian.gov.cn">湘ICP备17020355号</a>
         </span>
    </div>
</footer>
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
                debugger 
                // $("#fileStoreImg").val(file);
                // 获取 window 的 URL 工具
                var URL = window.URL || window.webkitURL;
                // 通过 file 生成目标 url
                var imgURL = URL.createObjectURL(file);
                //用attr将img的src属性改成获得的url
                $(".changeStoreImg1").attr("src",imgURL);
            }
        })
        
        $(".changeStoreImg1").mouseover(function(){
            $("#changeImgBtn").show()
        })
        $("#changeImgBtn").mouseout(function(){
            $("#changeImgBtn").hide()
        })

        $(".ifsAPI").each(function () {
            var href = $(this).find(\'a\').attr(\'_href\');
            $(this).click(function () {
                $(".show_iframe").remove();
                $("#iframe_box").append(\'<div class="show_iframe"><div class="loading"></div><iframe frameborder="0" src=\' + href + \'></iframe></div>\')
                $(".show_iframe").eq(0).show();
            })
        })
        window.onload = function () {
            var selects = document.getElementsByTagName("select");//通过标签名获取select对象
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
                    }
                });
            }
        })
        $("#changeInf").click(function () {
            let sex = $("[name=sex]:checked").val();
            let birthday = $("#select1").val() + "-" + $("#select2").val() + "-" + $("#select3").val()
            let nickname = $("[name=name]").val();
            let tel = $("[name=tel]").val();

            var data = new FormData($("#storeInfoForm")[0]);
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
                        console.log(res)

                        if (res.status == 3) {
                            layer.msg(res.info);
                            $("#jbxx").hide();
                            $("#nickname1").text(nickname);
                            $("#naickname").val(nickname);
                            data1 = res.re[0];
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
        }

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
            $(this).siblings().find(".t2").css("color", "#97A0B4");
            $(this).find(".t2").css("color", "#C8CDDC");
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
                    $(this).css("color", "#97A0B4");
                })
                $(this).css("color", "#fff");
                console.log(11)
                $(this).parent().parent().parent().parent().siblings().removeClass("sp5");
                $(this).parent().parent().parent().parent().addClass("sp5");
                $(this).parent().parent().parent().parent().siblings().each(function () {
                    $(this).find(".t2").css("color", "#C8CDDC");
                    $(this).find(".asideImgWrap img").eq(1).hide();
                    $(this).find(".asideImgWrap img").eq(0).show();

                });
                $(this).parent().parent().parent().siblings().find(".asideImgWrap img").eq(0).hide();
                $(this).parent().parent().parent().siblings().find(".t2").css("color", "#fff");
                 console.log(12)
                $(this).parent().parent().parent().siblings().find(".asideImgWrap img").eq(1).show();
                $(".topTitle").text($(this).text())
                $(".sp2").find(".asideImg").eq(1).hide();
                $(".sp2").find(".asideImg").eq(0).show();
                $(".sp2").find(".t2").css("color", "#C8CDDC");
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
                    $(this).find(".t2").css("color", "#fff");
                    $(".selected .t2").css("color", "#fff");
                })
                $(this).mouseout(function () {
                    $(this).find(".asideImg").eq(1).hide();
                    $(this).find(".asideImg").eq(0).show();
                    $(this).removeClass("active");
                    $(".selected .t2").css("color", "#C8CDDC");
                    $(".sp5").find(".asideImgWrap img").eq(0).hide();
                    $(".sp5").find(".asideImgWrap img").eq(1).show();
                    $(".t2").css("color", "#C8CDDC");
                    $(".sp5").find(".t2").css("color", "#fff");
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
                        position: "static"
                    })
                   $(".logi_2").hide()
                    $(".logi_1").show()
                    $(".Hui-logo").css("width","200px")
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
                        left: "0px",
                    })
                     $(".logi_2").show()
                    $(".logi_1").hide()
                    $(".Hui-logo").css("width","50px")
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
                            background: "#3F4759",
                        })
                        $(this).find("dd").css({
                            position: "absolute",
                            display: "block",
                            left: "50px",
                            width: "140px",
                            background: "#3F4759",
                        })
                        $(this).find("dt").css({
                            background: "#3F4759",
                        })
                        $(this).find(".t2").css({
                            position: "absolute",
                            display: "block",
                            width: "100px",
                            left: "70px",
                            background: "#3F4759",
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
                        })
                        $(this).css({
                            paddingRight: "0px",
                        })
                        $(this).find("dt").css({
                            background: "#343B4A",
                        })
                        $(this).find(".t2").css({
                            position: "static",
                            display: "none",
                            width: "130px",
                            left: "40px",
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
                	 console.log(16)
                    $(this).css("backgroundColor", $(this).attr("data-color"));
                    $(this).css("color", "#fff");
                })
                $(this).mouseout(function () {
                    $(this).css("backgroundColor", "#fff");
                    $(this).css("color", "#000");
                     console.log(17)
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
                $("#jbxx").show();

            })

            $(".closeA").on("mouseover", function () {
                $(this).find("img").attr("src", "images/icon1/gb_h.png");
            })
            $(".closeA").on("mouseout", function () {
                $(this).find("img").attr("src", "images/icon1/gb.png");
            })
        });
        $(".ifsAPI").each(function () {
            $(this).click(function () {
                if ($("iframe").length > 2) {

                }
            })
        })

        function closeMask(id, url, content) {
            $.ajax({
                type: "post",
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
                }

            });
        }

        function closeMask1() {
            $(".maskNew").remove();
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
                            let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                        } else {
                            layer.msg("启用失败!");
                        }
                    } else {
                        if (res.status == 1) {
                            layer.msg("禁用成功!");
                            let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                        } else if (res.status == 2) {
                            layer.msg("该品牌正在使用，不允禁用!");
                        } else {
                            layer.msg("禁用失败!");
                        }
                    }
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
                    console.log(res)
                    $(".maskNew").remove();
                    if (res.status == "1") {
                        layer.msg("修改成功！");
                        let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                    } else {
                        layer.msg("修改失败！");
                    }
                },
            });
        }

        function closeMask100(id, type, url) {
            $.ajax({
                type: "post",
                url: url + id + \'&type=\' + type,
                async: true,
                dataType: "json",
                success: function (res) {
                    //console.log(res)
                    $(".maskNew").remove();
                    if (res.status == "1") {
                        layer.msg("密码重置成功！");
                        let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                    } else {
                        layer.msg("密码重置失败！");
                    }
                },
            });
        }

        function closeMask4(m, id, user_id, money, s_charge, url) {
            $.get("index.php?module=finance&action=del", {
                \'m\': m,
                \'id\': id,
                \'user_id\': user_id,
                \'money\': money,
                \'s_charge\': s_charge
            }, function (res) {
                $(".maskNew").remove();
                if (res == "1") {
                    layer.msg("操作成功!");
                    let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                } else {
                    layer.msg("操作失败!");
                }
            }, "json");

        }

        function closeMask_1(id, url, type, y_id) {
            $.ajax({
                type: "get",
                url: url + id,
                async: true,
                dataType: "json",
                success: function (res) {
                    $(".maskNew").remove();
                    let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
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
                        ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                    }
                    else {
                        layer.msg("修改失败!");
                    }
                },
            });
        }

        function closeMask12() {
            $(".maskNew").remove();
            let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
            ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
        }

        function closeMask13(type, Id) {
            $.get("index.php?module=member&action=MemberRecordDel", {\'id\': Id, \'type\': type}, function (res) {
                $(".maskNew").remove();
                if (res.status == "1") {
                    layer.msg("删除成功!");
                    let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                    ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                } else {
                    layer.msg("删除失败!");
                }
            }, "json");
        }

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
                        let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                    } else if (res.status == "2") {
                        layer.msg(res.info);
                    } else {
                        layer.msg(content + "失败!");
                    }
                }
            });
        }
        function closeMask4_2(id,url) {
            var password=$("[name=password]").val()
            var password1=$("[name=password1]").val()
            if(password == password1){
                $.get(url, {
                    \'id\': id,
                    \'password\':password,
                }, function (res) {
                    $(".maskNew").remove();
                    if (res.status == "1") {
                        layer.msg("操作成功!");
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    } else {
                        layer.msg("操作失败!");
                    }
                }, "json");
            }else{
                layer.msg("确认密码与新密码不一致!");
            }
        }
        function closeMask_use(id, content, url) {
            $(".maskNew").remove();
            $.ajax({
                type: "get",
                url: url + id,
                async: true,
                dataType: "json",
                success: function (res) {
                    if (content == "启用") {
                        if (res.status == 1) {
                            layer.msg("启用成功!");
                            let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                        } else {
                            layer.msg("启用失败!");
                        }
                    } else {
                        if (res.status == 1) {
                            layer.msg("禁用成功!");
                            let ifs = $(".show_iframe").eq(1).find("iframe")[0].contentWindow.document;
                            ifs.location.href = $(".show_iframe").eq(1).find("iframe").attr("src");
                        } else if (res.status == 2) {
                            layer.msg("该品牌正在使用，不允禁用!");
                        } else {
                            layer.msg("禁用失败!");
                        }
                    }
                }
            });
        }

        // 提示框点确定跳转到相应页面
        function confirm_modify_close(id,url,url1) {
            $.ajax({
                cache: true,
                type: "POST",
                dataType:"json",
                url:url,
                data:{
                    id:id
                },
                async: true,
                success: function(data) {
                    layer.msg(data.status,{time:2000});
                    // 关闭弹窗
                    $(".maskNew").remove();

                    let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                    ifs.location.href= url1;
                }
            });
        }
        function add_name() {
            var id = $("#id").val();
            var url = $("#url").val();
            var res = $("#res").val();
            var name = $("#name").val();
            var status = $("input[name=\'status\']:checked").val();
            $.ajax({
                cache: true,
                type: "POST",
                dataType:"json",
                url:res,
                data:{
                    id:id,
                    name:name,
                    status:status
                },
                async: true,
                success: function(data) {
                    layer.msg(data.status,{time:2000});
                    // 关闭弹窗
                    $(".maskNew").remove();
                    // 关闭弹窗
                    if(data.suc){
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href= url;
                    }

                }
            });
        }

        function Customer_Del(url) {
            $.ajax({
                type: "POST",
                url: url,
                data: {},
                success: function (msg) {
                    var res = JSON.parse(msg)
                    $(".maskNew").remove();
                    if(res.status == 1){
                        layer.msg("操作成功!");
                        let ifs = $(".show_iframe").eq(0).find("iframe")[0].contentWindow.document;
                        ifs.location.href = $(".show_iframe").eq(0).find("iframe").attr("src");
                    }else{
                        layer.msg("操作失败!");
                    }
                },
                complete(XHR, TS){
                    // 无论请求成功还是失败,都要把判断条件改回去
                    choose_class=true
                }
            });
        }

        //循环执行，每隔30秒钟执行一次    ---------------------------验证登入----------------------------------------------

        //  var t1=window.setInterval(refreshCount, 30*1000);
        //  function refreshCount() {
        //        $.ajax({
        //            url: location.href,
        //            type: "post",
        //            data: {
        //            	\'m\':\'check\'
        //            },
        //            success: function(res) {
        //            	var data = JSON.parse(res);
        //            	$(".msgNum1").each(function(i){
        //            		$(this).text(Object.values(data.re)[i])
        //            	})
        //            	$(".msgDiv1").each(function(i){
        //            		let numA=0;
        //            		$(this).parent().find(".msgNum1").each(function(i){
        //            			numA+=parseInt($(this).text());
        //            		})
        //            		if(numA>99){
        //        				numA=99;
        //        				$(this).find(".msgNum").text(numA);
        //            		}
        //            	})
        //            	let numB=0;
        //            	$(".msgUl1 .msgNum").each(function(){
        //            		numB+=parseInt($(this).text())
        //            	})
        //            	if(numB>99){
        //            		numB=99;
        //            	}
        //            	$("#tatalNum").text(numB);
        //
        //                if(data.code == 1) {
        //                	 window.clearInterval(t1);
        //                	parent.location.href=\'index.php?module=Login&action=Logout\';
        //                }else if(data.code == 2){
        //                	 window.clearInterval(t1);
        //                	alert(\'您的账户在其他地方登入，您被迫下线！\'); parent.location.href=\'index.php?module=Login&action=Logout\';
        //                }else{
        //
        //                }
        //            },
        //        });
        //    console.log("定时检查登入----");
        //  }
    </script>
'; ?>


</body>
</html>