<?php /* Smarty version 2.6.31, created on 2019-12-30 15:39:09
         compiled from Detail.tpl */ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/flex.css" rel="stylesheet">
    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="style/js/jquery.js"></script>
    <?php echo '
        <style type="text/css">
            .center {
                text-align: center !important;
            }

            .ul1,
            .ul2,
            .ul3 {
                padding: 0px 20px;
            }

            .ul1 li,
            .ul2 li,
            .ul3 li {
                float: left;
                height: 60px;
                line-height: 60px;
                color: #888f9e;
                font-size: 14px;

            }

            .ul2 li input {
                border: 1px solid #ddd;
                padding: 0 14px;
                height: 36px;
            }

            .ul2 li input:hover {
                border: 1px solid #3BB4F2;
            }

            .grText {
                color: #414658;
                font-size: 14px;
            }

            .ulTitle {
                height: 50px;
                line-height: 50px;
                text-align: left;
                font-size: 16px;
                color: #414658;
                font-weight: 600;
                font-family: "微软雅黑";
                margin-bottom: 0px;
                /*margin-top: 20px;*/
                margin-left: 20px;
                margin-right: 20px;
                border-bottom: 1px solid #d9d9d9;
            }

            table th {
                border-bottom: none;
                background-color: #fff;
            }

            table {
                width: 95%;
                margin: 20px auto;
                border: 1px solid #eee !important;

            }

            tr {
                border: 1px solid #fff;
            }

            .table td, .table th {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #fff;
            }

            .order-item {
                border: 1px solid transparent;
                margin-bottom: 1rem;
            }

            .order-item table {
                margin: 0;
            }

            .order-item:hover {
                border: 1px solid #3c8ee5;
            }

            .goods-item {
                margin-bottom: .75rem;
            }

            .goods-item:last-child {
                margin-bottom: 0;
            }

            .goods-name {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .status-item.active {
                color: inherit;
            }

            .badge {
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem
            }

            .badge:empty {
                display: none
            }

            .btn .badge {
                position: relative;
                top: -1px
            }

            a.badge:focus,
            a.badge:hover {
                color: #fff;
                text-decoration: none;
                cursor: pointer
            }

            .badge-pill {
                padding-right: .6em;
                padding-left: .6em;
                border-radius: 10rem
            }

            .badge-default {
                background-color: #636c72
            }

            .badge-default[href]:focus,
            .badge-default[href]:hover {
                background-color: #4b5257
            }

            .badge-primary {
                background-color: #0275d8
            }

            .badge-primary[href]:focus,
            .badge-primary[href]:hover {
                background-color: #025aa5
            }

            .badge-success {
                background-color: #5cb85c
            }

            .badge-success[href]:focus,
            .badge-success[href]:hover {
                background-color: #449d44
            }

            .badge-info {
                background-color: #5bc0de
            }

            .badge-info[href]:focus,
            .badge-info[href]:hover {
                background-color: #31b0d5
            }

            .badge-warning {
                background-color: #f0ad4e
            }

            .badge-warning[href]:focus,
            .badge-warning[href]:hover {
                background-color: #ec971f
            }

            .badge-danger {
                background-color: #d9534f
            }

            .badge-danger[href]:focus,
            .badge-danger[href]:hover {
                background-color: #c9302c
            }

            .mask {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }

            a:hover {
                color: red;
                text-decoration: none;
            }

            .table-bordered th, .table-bordered td {
                border: none;
                text-align: center;
                vertical-align: middle;
            }

            .txc th {
                text-align: center;
            }

            .imgTd img {
                width: 50px;
                height: 50px;
                margin-right: 10px;
            }

            table {
                vertical-align: middle;

            }

            td a {
                float: left;
                width: 100% !important;

            }

            .maskLeft {
                width: 30%;
                float: left;
                text-align: right;
                padding-right: 20px;
                height: 36px;
                line-height: 36px;
            }

            .maskRight {
                width: 70%;
                float: left;
            }

            .ipt1 {
                padding-left: 10px;
                width: 300px;
                height: 36px;
                border: 1px solid #eee;
            }

            .wl_maskNew {
                position: fixed;
                z-index: 9999999;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                display: block;
            }

            .wl_maskNewContent {
                width: 500px;
                height: 519px;
                margin: 0 auto;
                position: relative;
                top: 200px;
                background: #fff;
                border-radius: 10px;
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

            .table td, .table th {
                vertical-align: middle;
            }

            .tr_xhx {
                border-bottom: 2px solid #cccccc;
            }

            .butten_o {
                width: 112px;
                height: 36px;
                background: inherit;
                background-color: rgba(16, 142, 233, 1);
                border: none;
                border-radius: 4px;
                -moz-box-shadow: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                font-family: \'MicrosoftYaHei\', \'Microsoft YaHei\';
                font-weight: 400;
                font-style: normal;
                font-size: 14px;
                color: #FFFFFF;
                text-align: center;
                line-height: 36px;
                margin-top: 20px;
            }

            .butten_o:hover {
                background-color: #2481E5;
            }


            form[name=form1] {
                background: #edf1f5;
                /*padding: 10px;*/
                padding: 0;
                text-align: left;
            }

            .tml_flex {
                width: 44% !important;
                margin: auto;
            }

            .goods-name {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }
        </style>
        <SCRIPT language=javascript>
            function printpr() //预览函数
            {
                document.all("qingkongyema").click();//打印之前去掉页眉，页脚
                document.all("dayinDiv").style.display = "none"; //打印之前先隐藏不想打印输出的元素（此例中隐藏“打印”和“打印预览”两个按钮）
                document.all("breadcrumb").style.display = "none";
                var OLECMDID = 7;
                var PROMPT = 1;
                var WebBrowser = \'<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>\';
                document.body.insertAdjacentHTML(\'beforeEnd\', WebBrowser);
                WebBrowser1.ExecWB(OLECMDID, PROMPT);
                WebBrowser1.outerHTML = "";
                document.all("dayinDiv").style.display = "";//打印之后将该元素显示出来（显示出“打印”和“打印预览”两个按钮，方便别人下次打印）
                document.all("breadcrumb").style.display = "";
            }

            function printTure() //打印函数
            {
                document.all(\'qingkongyema\').click();//同上
                document.all("dayinDiv").style.display = "none";//同上
                document.all("breadcrumb").style.display = "none";//同上
                window.print();
                document.all("dayinDiv").style.display = "";
                document.all("breadcrumb").style.display = "";//同上
            }

            function doPage() {
                layLoading.style.display = "none";//同上
            }


        </SCRIPT>
        <script language="VBScript">
			dim hkey_root,hkey_path,hkey_key
hkey_root="HKEY_CURRENT_USER"
hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup"
//设置网页打印的页眉页脚为空
function pagesetup_null()
on error resume next
Set RegWsh = CreateObject("WScript.Shell")
hkey_key="\\header"
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,""
hkey_key="\\footer"
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,""
end function

//设置网页打印的页眉页脚为默认值
function pagesetup_default()
on error resume next
Set RegWsh = CreateObject("WScript.Shell")
hkey_key="\\header"
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,"&w&b页码，&p/&P"
hkey_key="\\footer"
RegWsh.RegWrite hkey_root+hkey_path+hkey_key,"&u&b&d"
end function




        </script>
    '; ?>

    <title>订单详情</title>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<section class="rt_wrap pd-20" style="margin-bottom: 0;background-color: white;">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" name="where[sNo]" value="<?php echo $this->_tpl_vars['data']['sNo']; ?>
">
        <input type="hidden" name="where[status]" value="<?php echo $this->_tpl_vars['data']['gstatus']; ?>
">

        <div style="margin-bottom: 20px;background-color: #fff;">
            <p class="ulTitle">基本信息</p>
            <ul class="ul1" style="height: 180px;">
                <li style="width: 25%;">订单编号：<span class="grText"><?php echo $this->_tpl_vars['data']['sNo']; ?>
</span></li>
                <li style="width: 25%;">订单类型：
                    <?php if ($this->_tpl_vars['data']['otype'] == 'pt'): ?>
                        <span class="grText">拼团订单</span>
                    <?php elseif ($this->_tpl_vars['data']['otype'] == 'JP'): ?>
                        <span class="grText">竞拍订单</span>
                    <?php elseif ($this->_tpl_vars['data']['otype'] == 'integral'): ?>
                        <span class="grText">积分订单</span>
                    <?php else: ?>

                        <?php if ($this->_tpl_vars['data']['drawid'] > 0): ?>
                            <span class="grText">抽奖订单</span>
                        <?php else: ?>
                            <span class="grText">普通订单</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
                <li style="width: 25%;">订单状态：<span class="grText"><?php echo $this->_tpl_vars['data']['r_status']; ?>
</span></li>

                <li style="width: 25%;">配送费用：
                    <?php if ($this->_tpl_vars['data']['freight'] > 0): ?>
                        <span class="grText">￥<?php echo $this->_tpl_vars['data']['freight']; ?>
</span>
                    <?php else: ?>
                        <span class="grText">免运费</span>
                    <?php endif; ?>
                </li>


                <li style="width: 25%;">订单来源：<span class="grText"><?php if ($this->_tpl_vars['data']['source'] == 1): ?>微信小程序<?php else: ?>APP<?php endif; ?></span>
                </li>
                <li style="width: 25%;">支付方式：
                    <span class="grText">
                        <?php echo $this->_tpl_vars['data']['paytype']; ?>

                        </span>
                </li>


                <li style="width: 25%;">配送方式：
                    <?php if ($this->_tpl_vars['update_s']): ?>
                        <?php if ($this->_tpl_vars['data']['gstatus'] == 2): ?>
                            <select name="updata[express_id]">
                                <?php $_from = $this->_tpl_vars['express']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                                    <option value="<?php echo $this->_tpl_vars['item']->id; ?>
"
                                            <?php if ($this->_tpl_vars['data']['express_name'] == $this->_tpl_vars['item']->kuaidi_name): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']->kuaidi_name; ?>
</option>
                                <?php endforeach; endif; unset($_from); ?>
                            </select>
                        <?php else: ?>
                            <span class="grText"><?php echo $this->_tpl_vars['data']['express_name']; ?>
</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($this->_tpl_vars['data']['express_name']): ?>
                            <span class="grText"><?php echo $this->_tpl_vars['data']['express_name']; ?>
</span>
                        <?php else: ?>
                            <span class="grText">暂无</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
                <li style="width: 25%;">下单时间：
                    <?php if ($this->_tpl_vars['data']['add_time']): ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['add_time']; ?>
</span>
                    <?php else: ?>
                        <span class="grText">暂无</span>
                    <?php endif; ?>
                </li>

                <li style="width: 25%;">付款时间：
                    <span class="grText"><?php if ($this->_tpl_vars['data']['pay_time']): ?><?php echo $this->_tpl_vars['data']['pay_time']; ?>
<?php else: ?>暂无<?php endif; ?></span>
                </li>

                <li style="width: 25%;">发货时间：

                    <?php if ($this->_tpl_vars['data']['deliver_time']): ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['deliver_time']; ?>
</span>
                    <?php else: ?>
                        <span class="grText">暂无</span>
                    <?php endif; ?>
                </li>
                <li style="width: 25%;display: flex;align-items: center;justify-content: left;">快递单号：
                    <?php if ($this->_tpl_vars['update_s']): ?>
                        <?php if ($this->_tpl_vars['data']['gstatus'] == 2): ?>
                            <input type="text" style="height: 25px;" name="updata[courier_num]"
                                   value="<?php echo $this->_tpl_vars['data']['courier_num']; ?>
">
                        <?php else: ?>
                            <span class="grText" style="display: inline-block;"><?php echo $this->_tpl_vars['data']['courier_num']; ?>
</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($this->_tpl_vars['data']['fh'] == 0): ?>
                            <span class="grText" style="display: inline-block;">暂无</span>
                        <?php else: ?>
                            <div style="display: flex;flex-direction:column;justify-content:center;line-height: 20px!important;">
                                <?php $_from = $this->_tpl_vars['data']['courier_num']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item2']):
?>
                                    <a class="send-btn1 goods-name" href="javascript:"
                                       style="display: block;width:200px;"
                                       onclick="send_btn1(this,'<?php echo $this->_tpl_vars['data']['sNo']; ?>
','<?php echo $this->_tpl_vars['item2']['num']; ?>
')">
                                        <span class="grText changeNum"><?php echo $this->_tpl_vars['item2']['num']; ?>
 (<?php echo $this->_tpl_vars['item2']['kuaidi_name']; ?>
)</span>
                                    </a>
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </li>
                <li style="width: 25%;">到货时间：
                    <?php if ($this->_tpl_vars['data']['arrive_time']): ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['arrive_time']; ?>
</span>
                    <?php else: ?>
                        <span class="grText">暂无</span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div style="margin-bottom: 20px;background-color: #fff;">
            <p class="ulTitle">收货人信息</p>
            <ul class="ul2" style="height: 250px;">
                <li style="width: 100%;">收货人：
                    <?php if ($this->_tpl_vars['update_s']): ?>
                        <?php if ($this->_tpl_vars['data']['gstatus'] < 2): ?>
                            <input type="text" style="" name="updata[name]" value="<?php echo $this->_tpl_vars['data']['name']; ?>
">
                        <?php else: ?>
                            <span class="grText"><?php echo $this->_tpl_vars['data']['name']; ?>
</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['name']; ?>
</span>
                    <?php endif; ?>
                </li>
                <li style="width:100%;">联系电话：
                    <?php if ($this->_tpl_vars['update_s']): ?>

                        <?php if ($this->_tpl_vars['data']['gstatus'] < 2): ?>
                            <input type="text" style="" name="updata[mobile]" value="<?php echo $this->_tpl_vars['data']['mobile']; ?>
">
                        <?php else: ?>
                            <span class="grText"><?php echo $this->_tpl_vars['data']['mobile']; ?>
</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['mobile']; ?>
</span>
                    <?php endif; ?>

                </li>
                <li style="width: 100%;">收货地址：
                    <?php if ($this->_tpl_vars['update_s']): ?>
                        <?php if ($this->_tpl_vars['data']['gstatus'] < 2): ?>
                            <input type="text" style="min-width: 250px;" name="updata[address]" value="<?php echo $this->_tpl_vars['data']['address']; ?>
">
                        <?php else: ?>
                            <span class="grText"><?php echo $this->_tpl_vars['data']['address']; ?>
</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['address']; ?>
</span>
                    <?php endif; ?>

                </li>
                <li style="width: 100%;">备注信息：
                    <?php if ($this->_tpl_vars['update_s']): ?>

                        <?php if ($this->_tpl_vars['data']['gstatus'] < 2): ?>
                            <input type="text" style="min-width: 250px;" name="updata[remarks]" value="<?php echo $this->_tpl_vars['data']['remarks']; ?>
">
                        <?php else: ?>
                            <span class="grText"><?php echo $this->_tpl_vars['data']['remarks']; ?>
</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="grText"><?php echo $this->_tpl_vars['data']['remarks']; ?>
</span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div style="background-color: #fff;">
            <p class="ulTitle">商品信息</p>
            <table class="table" style="width: 98%">
                <tr>
                    <th class="center tr_xhx" style="width: 30%">商品名称</th>
                    <th class="center tr_xhx">商品编号</th>
                    <th class="center tr_xhx">数量</th>
                    <th class="center tr_xhx">商品价格</th>
                    <th class="center tr_xhx grade_rate1">会员折扣</th>
                    <th class="center tr_xhx">库存</th>
                    <th class="center tr_xhx">规格</th>
                    <th class="center tr_xhx">运费</th>
                    <th class="center tr_xhx">小计</th>
                    <th class="center tr_xhx" style="    width: 180px;">操作</th>
                </tr>
                <?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                    <tr>
                        <td style="text-align:left;" id="p_name" style="width: 30%">
                            <img class='pimg' src="<?php echo $this->_tpl_vars['item']->pic; ?>
" style="margin-right: 20px;margin-left: 15px;" width="50" height="50"/><?php echo $this->_tpl_vars['item']->p_name; ?>

                        </td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['item']->p_id; ?>
</span></td>
                        <td class="center" rowspan="<?php echo $this->_tpl_vars['item']->index; ?>
"><span class="grText"><?php echo $this->_tpl_vars['item']->num; ?>
</span></td>
                        <td class="center" rowspan="<?php echo $this->_tpl_vars['item']->index; ?>
"><span class="grText" style="display: flex;align-items: center;">
                                 <?php if ($this->_tpl_vars['data']['otype'] == 'KJ' || $this->_tpl_vars['data']['otype'] == 'JP'): ?>
                                     <?php echo $this->_tpl_vars['item']->spz_price; ?>

                                 <?php elseif ($this->_tpl_vars['data']['otype'] == 'integral'): ?>
                                     ￥<?php echo $this->_tpl_vars['item']->p_money; ?>
+<img src="images/icon/integral_hei.png" alt="" style="width: 15px;height: 15px;"><?php echo $this->_tpl_vars['item']->allow; ?>

                                 <?php else: ?>
                                     ￥<?php echo $this->_tpl_vars['item']->p_price; ?>

                                 <?php endif; ?>

                        </span>
                        </td>
                        <td class="center grade_rate" rowspan="<?php echo $this->_tpl_vars['item']->index; ?>
"><?php echo $this->_tpl_vars['item']->grade_rate; ?>
</td>
                        <td class="center" rowspan="<?php echo $this->_tpl_vars['item']->index; ?>
"><span class="grText"><?php echo $this->_tpl_vars['item']->total_num; ?>
</span></td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['item']->size; ?>
</span></td>
                        <td class="center">
                            <span class="grText"><?php if ($this->_tpl_vars['item']->freight): ?><?php echo $this->_tpl_vars['item']->freight; ?>
<?php else: ?>免邮费<?php endif; ?></span>
                        </td>
                        <td class="center">
                            <span class="grText" style="display: flex;align-items: center;">
                                ￥
                                <?php if ($this->_tpl_vars['data']['otype'] == 'KJ' || $this->_tpl_vars['data']['otype'] == 'JP'): ?>
                                   <?php echo $this->_tpl_vars['item']->z_price*$this->_tpl_vars['item']->grade_rate2+$this->_tpl_vars['item']->freight; ?>

                                 <?php elseif ($this->_tpl_vars['data']['otype'] == 'integral'): ?>
                                    <?php echo $this->_tpl_vars['item']->num*$this->_tpl_vars['item']->p_price+$this->_tpl_vars['item']->freight; ?>
+<img src="images/icon/integral_hei.png" alt="" style="width: 15px;height: 15px;"><?php echo $this->_tpl_vars['item']->allow; ?>

                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['item']->num*$this->_tpl_vars['item']->p_price*$this->_tpl_vars['item']->grade_rate2+$this->_tpl_vars['item']->freight; ?>

                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="center">
                            <div style="display: flex;height: 100%;">
                                <?php if ($this->_tpl_vars['button'][0] == 1): ?>
                                    <?php if ($this->_tpl_vars['data']['otype'] == 'pt' && $this->_tpl_vars['data']['gstatus'] == 10): ?>
                                        <a style="text-decoration:none;width: 44%;" class="tml-5 tml_flex"
                                           onclick="confirm('确认要退款吗？','<?php echo $this->_tpl_vars['item']->id; ?>
')">
                                            <div style="align-items: center;font-size: 12px;display: flex;">
                                                <div style="margin:0 auto;display: flex;align-items: center;">
                                                    <img src="images/icon1/ck.png"/>&nbsp;退款
                                                </div>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <a style="text-decoration:none;width: 44%;" class="tml-5 tml_flex"
                                   onclick="go('<?php echo $this->_tpl_vars['data']['sNo']; ?>
')">
                                    <div style="align-items: center;font-size: 12px;display: flex;">
                                        <div style="margin:0 auto;display: flex;align-items: center;">
                                            <img src="images/icon1/ck.png"/>&nbsp;查看
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
                <?php if ($this->_tpl_vars['zp_res']): ?>
                    <tr>
                        <td style="text-align:left;display: flex;align-items: center;" id="p_name">
                            <img class='pimg' src="<?php echo $this->_tpl_vars['zp_res']->img; ?>
" style="margin-right: 20px;margin-left: 15px;"
                                 width="50"
                                 height="50"/>
                            <span style="overflow: hidden;text-overflow:ellipsis;white-space: nowrap;width: 250px;font-size: 14px;"><?php echo $this->_tpl_vars['zp_res']->product_title; ?>
</span>
                        </td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['zp_res']->pid; ?>
</span></td>
                        <td class="center"><span class="grText">1</span></td>
                        <td class="center"><span class="grText">￥<?php echo $this->_tpl_vars['zp_res']->price; ?>
</span>
                        <td class="center"><span class="grText">-</span>
                        </td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['zp_res']->total_num; ?>
</span></td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['zp_res']->id; ?>
</span></td>
                        <td class="center">
                            <span class="grText">免邮费</span>
                        </td>
                        <td class="center"><span class="grText">￥0</span></td>
                        <td class="center">

                        </td>
                    </tr>
                <?php endif; ?>

                <?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                    <?php if (($this->_foreach['f1']['iteration'] <= 1)): ?>
                        <tr>
                            <td colspan="8" style="text-align: right;">
                                <p><span style="color:#000000;">优惠合计：</span><span
                                            style="color:#FF0000;">￥<?php echo $this->_tpl_vars['yh_money']; ?>
</span></p>

                            <td>
                                <p style="text-align: center;"><span style="color:#000000;">合计支付：</span>
                                    <?php if ($this->_tpl_vars['update_s']): ?>
                                        <?php if ($this->_tpl_vars['data']['gstatus'] == 0): ?>
                                            <span style="color:#FF0000;">￥<?php echo $this->_tpl_vars['item']->z_price; ?>
</span>
                                        <?php else: ?>
                                            <span style="color:#FF0000;">￥<?php echo $this->_tpl_vars['item']->z_price; ?>
</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span style="color:#FF0000;">￥<?php echo $this->_tpl_vars['item']->z_price; ?>
</span>
                                    <?php endif; ?>
                                    <?php if ($this->_tpl_vars['data']['otype'] == 'integral'): ?>
                                        <span style="color:#FF0000;">+<img src="images/icon/integral_hei.png" alt="" style="width: 15px;height: 15px;"><?php echo $this->_tpl_vars['item']->allow; ?>
</span>
                                    <?php endif; ?>
                                </p>

                            </td>


                        </tr>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </table>

        </div>

        <?php if ($this->_tpl_vars['update_s']): ?>
            <div style="background-color: white;" class="row_cl">
                <div style="float:  right;margin-right: 60px;width: 112px;">
                    <button onclick="tijiao()" type="button" class="butten_o">保存</button>
                </div>
                <div style="clear: both;height: 20px;"></div>
            </div>
        <?php endif; ?>


        <input type="hidden" name="ddd" value="<?php echo $this->_tpl_vars['data']['lottery_status']; ?>
">
        <input type="hidden" name="ddcc" value="<?php echo $this->_tpl_vars['data']['drawid']; ?>
">
        <!-- 分销商信息 -->
        <div id="outerdiv"
             style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
            <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
        </div>

        <input type="hidden" name="otype" value="<?php echo $this->_tpl_vars['otype']; ?>
" class="otype">
        <input type="hidden" name="oid" value="<?php echo $this->_tpl_vars['data']['sNo']; ?>
" class="oid">

        <div class="page_h20"></div>


    </form>
</section>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<?php echo '
    <script type="text/javascript">
		// 折扣转成数字,如果成功了证明有折扣,如果是NaN则没有折扣
		if(isNaN(parseInt($(\'.grade_rate\').eq(0).text()))){
			$(\'.grade_rate\').remove()
			$(\'.grade_rate1\').remove()
		}
		
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }

        var aa = $(".pd-20").height() - 56;
        var bb = $("#form1").height();
        console.log(aa, bb)
        if (aa < bb) {
            $(".page_h20").css("display", "block")
        } else {
            $(".page_h20").css("display", "none")
            $(".row_cl").addClass("page_footer")
        }
        function tijiao() {
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: location.href + \'&m=updata\',
                data: $(\'#form1\').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    console.log(data)
                    layer.msg(data.msg, {time: 2000});
                    if (data.status) {
                        intervalId = setInterval(function () {
                            clearInterval(intervalId);
                            location.href = history.go(-1);
                            location.reload();
                        }, 2000);
                    }
                }
            });
        }
        $(function () {
            $(".pimg").click(function () {
                var _this = $(this); //将当前的pimg元素作为_this传入函数
                imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
            });
        });

        function imgShow(outerdiv, innerdiv, bigimg, _this) {
            var src = _this.attr("src"); //获取当前点击的pimg元素中的src属性
            $(bigimg).attr("src", src); //设置#bigimg元素的src属性

            /*获取当前点击图片的真实大小，并显示弹出层及大图*/
            $("<img/>").attr("src", src).load(function () {
                var windowW = $(window).width(); //获取当前窗口宽度
                var windowH = $(window).height(); //获取当前窗口高度
                var realWidth = this.width; //获取图片真实宽度
                var realHeight = this.height; //获取图片真实高度
                var imgWidth, imgHeight;
                var scale = 0.8; //缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

                if (realHeight > windowH * scale) { //判断图片高度
                    imgHeight = windowH * scale; //如大于窗口高度，图片高度进行缩放
                    imgWidth = imgHeight / realHeight * realWidth; //等比例缩放宽度
                    if (imgWidth > windowW * scale) { //如宽度扔大于窗口宽度
                        imgWidth = windowW * scale; //再对宽度进行缩放
                    }
                } else if (realWidth > windowW * scale) { //如图片高度合适，判断图片宽度
                    imgWidth = windowW * scale; //如大于窗口宽度，图片宽度进行缩放
                    imgHeight = imgWidth / realWidth * realHeight; //等比例缩放高度
                } else { //如果图片真实高度和宽度都符合要求，高宽不变
                    imgWidth = realWidth;
                    imgHeight = realHeight;
                }
                $(bigimg).css("width", imgWidth); //以最终的宽度对图片缩放

                var w = (windowW - imgWidth) / 2; //计算图片与窗口左边距
                var h = (windowH - imgHeight) / 2; //计算图片与窗口上边距
                $(innerdiv).css({
                    "top": h,
                    "left": w
                }); //设置#innerdiv的top和left属性
                $(outerdiv).fadeIn("fast"); //淡入显示#outerdiv及.pimg
            });

            $(outerdiv).click(function () { //再次点击淡出消失弹出层
                $(this).fadeOut("fast");
            });
        }
    </script>

<script type="text/javascript">
    function check(f) {
        if (Trim(f.product_title.value) == "") {
            alert("产品名称不能为空！");
            f.product_title.value = \'\';
            return false;
        }
        if (Trim(f.keyword.value) == "") {
            alert("关键词不能为空！");
            f.keyword.value = \'\';
            return false;
        }
        if (Trim(f.sort.value) == "") {
            alert("排序不能为空！");
            f.sort.value = \'\';
            return false;
        }
        f.sort.value = Trim(f.sort.value);
        if (!/^(([1-9][0-9]*)|0)(\\.[0-9]{1,2})?$/.test(f.sort.value)) {
            alert("排序号必须为数字，且格式为 ####.## ！");
            f.sort.value = \'\';
            return false;
        }
        console.log(1);
        return true;
    }

    function system_category_add(title, url, w, h) {
        appendMask(title, url, w, h);
    }

    $(".qx").click(function () {
        $(".dc").hide();
        $("#makeInput").val("");
        $(".ipt1").val("")
    })

    function changeDD() {
        let a = $(".dc");
        $("body", parent.document).append(a);
        $("body", parent.document).find(".dc").show();
    };

    function send_btn_dd(obj, otype, id, status, drawid) {
        var dingdan = id;
        var stu = status;
        var oid = $(".oid").val();
        var otype = otype ? otype : \'yb\';
        var sNo = $(\'.order_id\').val(id);
        if (stu == 6) {
            appendMask1(\'订单已关闭，不能发货!\', "ts");
        }

        if (stu == 0) {
            appendMask1(\'订单还没付款!\', "ts");
        }
        console.log(oid, otype, id);
        //  调起发货显示界面
        parent.send_btn_xsfh(id, otype, oid);

    };

    function send_btn1(obj, id, courier_num) {
        var r_sNo = id;
        $.ajax({
            url: \'index.php?module=orderslist&action=Kuaidishow&r_sNo=\' + r_sNo + \'&courier_num=\' + courier_num,
            type: "post",
            data: {},
            success: function (res) {
                var data = JSON.parse(res);
                console.log(data.code);
                if (data.code == 1) {
                    closeMask1();
                    console.log(1);
                    var str = \'\';
                    for (var i = 0; i < data.data.length; i++) {
                        str += \'<div class="time" style="margin-left: 30px;">\' + data.data[i].ftime +
                            \'</div><div class="step" style="font-size: 0.5rem; padding: 5px 20px;    margin-left: 30px;">\' + data.data[
                                i].context + \'</div>\';
                    }
                    wl_appendMask(str, "cg");
                } else {
                    appendMask(\'暂无物流信息！\', "ts");
                }
            },
        });
    };

    function confirm1(content, id, content1) {
        $("body").append(
            `
                <div class="maskNew">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask2("${id}","${content1}") >确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `
        )
    }

    function closeMask2(id, content) {
        $(".maskNew").remove();
        $.ajax({
            type: "post",
            url: "index.php?module=coupon&action=whether&id=" + id,
            async: true,
            success: function (res) {
                console.log(res);
                if (content == "启用") {
                    if (res == 1) {
                        appendMask("启用成功", "cg");
                    } else {
                        appendMask("启用失败", "ts");
                    }
                } else {
                    if (res == 1) {
                        appendMask("禁用成功", "cg");
                    } else {
                        appendMask("禁用失败", "ts");
                    }
                }
            }
        });
    }

    function wl_appendMask(content, src) {
        $("body").append(
            `
                <div class="wl_maskNew">
                    <div class="wl_maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=close_wl_Mask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">物流信息</div>
                        <div style="height: 370px;position: relative;top:20px;font-size: 22px;text-align: center;overflow: scroll;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" onclick=close_wl_Mask1() >确认</button>
                        </div>
                    </div>
                </div>
            `
        )
    }

    function close_wl_Mask1() {
        $(".wl_maskNew").remove();
    }

    function appendMask(content, src) {
        $("body").append(
            `
                <div class="maskNew ">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/${src}.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" onclick=closeMask1() >确认</button>
                        </div>
                    </div>
                </div>
            `
        )
    }

    function appendMask_tj(content, src) {
        $(".dc").hide();
        $("body").append(
            `
                <div class="maskNew ">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/${src}.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" onclick=closeMask_tj() >确认</button>
                        </div>
                    </div>
                </div>
            `
        )
    }

    function closeMask_tj() {
        $(".maskNew").remove();
        $(".dc").show();
    }

    function appendMask1(content, src) {
        $("body").append(
            `
                <div class="maskNew maskNew1">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask4() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/${src}.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" onclick=closeMask4() >确认</button>
                        </div>

                    </div>
                </div>
            `
        )
    }

    function closeMask(id) {
        var sNo = \''; ?>
<?php echo $this->_tpl_vars['data']['sNo']; ?>
<?php echo '\';
        var oid = \''; ?>
<?php echo $this->_tpl_vars['data']['id']; ?>
<?php echo '\';
        var uid = \''; ?>
<?php echo $this->_tpl_vars['data']['user_id']; ?>
<?php echo '\';
        var paytype = \''; ?>
<?php echo $this->_tpl_vars['data']['paytype']; ?>
<?php echo '\';
        var trade_no = \''; ?>
<?php echo $this->_tpl_vars['data']['trade_no']; ?>
<?php echo '\';
        var p_name = $(\'#p_name\').text();
        var z_price = \''; ?>
<?php echo $this->_tpl_vars['data']['z_price']; ?>
<?php echo '\';
        $.ajax({
            type: \'POST\',
            url: \'index.php?module=orderslist&action=Status&otype=pt\',
            dataType: \'json\',
            data: {
                id: oid,
                price: z_price,
                sNo: sNo,
                p_name: p_name,
                paytype: paytype,
                trade_no: trade_no,
                uid: uid
            },
            success: function (data) {
                $(".maskNew").remove();
                if (data.status == 1) {
                    // layer.msg(\'已退款到该用户账上!\',{icon:1,time:800});
                    appendMask1("退款成功!", "cg");
                } else {
                    appendMask("退款失败!", "ts");
                }
            },
            error: function (data) {

            },
        });


    }

    function closeMask1() {
        $(".maskNew").remove();
    }

    //跳转库存列表
    function go(sNo) {
        window.location.href = "index.php?module=stock&action=Index&sNo=" + sNo;
    }

    function closeMask4() {
        $(".maskNew1").remove();
        location.replace(location.href);
    }

    function confirm(content, id) {
        $("body").append(
            `
                <div class="maskNew">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                        <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                            ${content}
                        </div>
                        <div style="text-align:center;margin-top:30px">
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}") >确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `
        )
    }

    function hm() {
        $(".dd").hide();
    }

    $(".fk").click(function () {
        var stu = \''; ?>
<?php echo $this->_tpl_vars['data']['status01']; ?>
<?php echo '\';
        if (stu >= 1) {
            layer.msg(\'订单已付款，请勿重复操作!\', {
                time: 1000
            });
            $(".dc").hide();
        } else {
            var id = \''; ?>
<?php echo $this->_tpl_vars['data']['sNo']; ?>
<?php echo '\';
            $.ajax({
                url: "index.php?module=orderslist&action=Detail",
                type: "post",
                data: {
                    sNo: id,
                    trade: 2
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        alert(data.msg);
                    }
                    window.location.reload();
                },

            });
        }


    })

    /*系统-栏目-添加*/
    function system_category_add(title, url, w, h) {
        layer_show(title, url, w, h);
    }

    $(".qx").click(function () {
        $(".dc").hide();
    })

    function system_category_del(obj, id, control) {

        confirm(\'确认要退款吗？\', \'ts\');
    }
</script>

'; ?>

</body>
</html>