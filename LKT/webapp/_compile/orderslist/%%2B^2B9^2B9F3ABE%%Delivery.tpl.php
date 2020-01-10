<?php /* Smarty version 2.6.31, created on 2019-12-30 15:38:48
         compiled from Delivery.tpl */ ?>
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
	
	<link rel="stylesheet" href="resource/components/select2/select2.min.css"/>
	
    <script src="style/js/jquery.js"></script>
	<script src="resource/components/select2/select2.js"></script>
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
                /* padding: 0 20px 0 20px; */
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
        </style>
    '; ?>

    <title>订单详情</title>
</head>
<body style="width:100%;">
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
                            <span class="search" style='font-size: 14px;display: block; height: 36px;'>
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
                <input class="qd closeMask" type="button" onclick=qd('index.php?module=orderslist&action=Addsign',3)
                       value="保存">
            </div>
        </div>

    </div>
</div>
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
        <div style="background-color: #fff;">
            <p class="ulTitle">商品信息</p>
            <table class="table" style="width: 98%">
                <tr>
                    <th class="center tr_xhx">
                        <input id="all" type="checkbox" class="inputC product_select" onchange="edit_checkbox()"
                               style="display: none;">
                        <label for="all"></label>
                    </td>
                    选择</th>
                    <th class="center tr_xhx">商品名称</th>
                    <th class="center tr_xhx">商品图片</th>
                    <th class="center tr_xhx">数量</th>
                    <th class="center tr_xhx">商品价格</th>
                    <th class="center tr_xhx">规格</th>
                </tr>
                <?php $_from = $this->_tpl_vars['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                    <tr>
                        <td>
                            <input name="id[]" id="<?php echo $this->_tpl_vars['item']->id; ?>
" type="checkbox" data-status='<?php echo $this->_tpl_vars['item']->r_status; ?>
'
                                   class="inputC product_select ckb" value="<?php echo $this->_tpl_vars['item']->id; ?>
">
                            <label for="<?php echo $this->_tpl_vars['item']->id; ?>
"></label>
                        </td>
                        <td><?php echo $this->_tpl_vars['item']->p_name; ?>
</td>
                        <td class="center"><img class='pimg' src="<?php echo $this->_tpl_vars['item']->imgurl; ?>
"
                                                style="margin-right: 20px;margin-left: 15px;" width="50" height="50"/>
                        </td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['item']->num; ?>
</span></td>
                        <td class="center"><span class="grText">￥<?php echo $this->_tpl_vars['item']->p_price; ?>

                            <?php if ($this->_tpl_vars['item']->p_integral): ?>+<img src="images/icon/integral_hei.png" alt="" style="width: 15px;height: 15px;margin: -4px 2px 0 2px;"><?php echo $this->_tpl_vars['item']->p_integral; ?>
<?php endif; ?>
                        </span></td>
                        <td class="center"><span class="grText"><?php echo $this->_tpl_vars['item']->size; ?>
</span></td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </table>

        </div>


        <div style="background-color: white;" class="row_cl">
            <div style="float:  right;margin-right: 60px;width: 112px;">
                <button onclick="send_btn_dd('<?php echo $this->_tpl_vars['goods'][0]->otype; ?>
','<?php echo $this->_tpl_vars['goods'][0]->r_sNo; ?>
')" type="button" class="butten_o">
                    发货
                </button>
            </div>
            <div style="clear: both;height: 20px;"></div>
        </div>
        <!-- 分销商信息 -->

        <div class="page_h20"></div>


    </form>

</section>

<div id="modal-Ship" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="z-index: 1333;">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">发货</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">

                <form name="Ship-form" id="Ship-form" class="form form-horizontal" method="post"
                      enctype="multipart/form-data">
                    <div class="row cl">
                        <label class=" col-xs-4 col-sm-2">快递公司：</label>
                        <div class="formControls col-xs-8 col-sm-10">
                            <select class="select" size="1" name="firmname">
                                <option value="" selected>请选择快递公司</option>
                                <option value="1">菜单一</option>
                                <option value="2">菜单二</option>
                                <option value="3">菜单三</option>
                            </select>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class=" col-xs-4 col-sm-2">快递单号：</label>
                        <div class="formControls col-xs-8 col-sm-10">

                            <div class="radio-box">
                                <input type="radio" title="1" class="radio-2" name="demo-radio1" checked>
                                <label for="radio-2">手动输入</label>
                            </div>

                            <div class="radio-box">
                                <input type="radio" title="0" class="radio-2" name="demo-radio1" checked>
                                <label for="radio-2">自动获取</label>
                            </div>

                        </div>

                        <input type="text" name="numbering" placeholder="请输入正确的快递单号" class="input-text radius size-M">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="onSubmit">确定</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
    <script type="text/javascript">
        var numberingDom = $(\'input[name=numbering]\')
        numberingDom.hide()
        $(\'.radio-2\').on(\'click\', function (event) {
            if (event.target.title === \'1\') {
                numberingDom.show()
				$(this).parents(\'.maskNewContent\').find(\'.select2\').show()
            } else {
                numberingDom.hide()
				$(this).parents(\'.maskNewContent\').find(\'.select2\').hide()
            }
        })

        // 提交数据
        function onSubmit() {
            var resData = $(\'#Ship-form\').serializeArray();
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

        function edit_checkbox() {
            console.log("edit_checkbox");

            var isall = $("#all").is(\':checked\');
            console.log(isall);
            if (isall) {
                // 全选
                $(".ckb").prop("checked", true);
            } else {
                // 全不选
                $(".ckb").prop("checked", false);
            }
        }

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

        var has_dc = false;
        var a = "";

        function send_btn_dd(otype, sNo) {
            console.log("send_btn_dd")
            var checkbox = $("input[name=\'id[]\']:checked");//被选中的复选框对象
            var Id = \'\';

            for (var i = 0; i < checkbox.length; i++) {
                if (checkbox.eq(i).attr(\'data-status\') == 1) {
                    Id += checkbox.eq(i).val() + ",";
                } else {
                    checkbox.eq(i).removeAttr("checked");
                }
            }

            if (Id == "") {
                layer.msg("请选择至少一款产品！");
                return false;
            } else {
                Id = Id.slice(0, -1);
            }

            var oid = Id;   //订单详情id,字符串逗号拼接,如:1,2,3
            var otype = otype ? otype : \'yb\';
            //  调起发货显示界面
            if (has_dc) {
                console.log("has_dc:" + has_dc)
                parent.send_btn_xsfh(oid, otype, sNo);
            } else {
                console.log("has_dc:" + has_dc)
                a = $(".dc");
                $("body", parent.document).find(".dc").remove();
                $("body", parent.document).append(a);
                has_dc = true;
                parent.send_btn_xsfh(oid, otype, sNo);
				
				if($(\'body\',parent.document).find(\'#kuaidi2\')){
					$(\'body\',parent.document).find(\'#kuaidi2\').css(\'display\',\'none\')
				}
				if($(\'#kuaidi2\')){
					$(\'#kuaidi2\').css(\'display\',\'none\')
				}
            }
        };

        function create(otype, sNo, type) {
            var checkbox = $("input[name=\'id[]\']:checked");//被选中的复选框对象
            var Id = \'\';
            for (var i = 0; i < checkbox.length; i++) {
                Id += checkbox.eq(i).val() + ",";
            }
            if (Id == "") {
                layer.msg("请选择至少一款产品！");
                return false;
            } else {
                Id = Id.slice(0, -1);
            }
            if (type == 1) {
                location.href = \'index.php?module=invoice&action=creat_list&id=\' + Id;
            } else {
                location.href = \'index.php?module=invoice&action=creat_listt&id=\' + Id;
            }

        }

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

        function closeMask1() {
            $(".maskNew").remove();
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
		$(\'#kuaidi1\').select2()
		
		// function search_select2(){
		// 	setTimeout(function(){
		// 		if($(\'.select2-container--open\').length==0){
		// 			search_select2()
		// 		}
		// 		// $(\'.select2-container--open\').remove()
		// 		$(\'.search\').append($(\'.select2-container--open\'))
		// 	},1000)
		// }
		// search_select2()
		$(\'.search\').on(\'click\',\'.select2-container\',function(){
			var select2=$(\'.select2-container--open\').css(\'left\',0).css(\'top\',\'36px\').css(\'display\',\'block\')
			$(this).after(select2)
		})
    </script>
'; ?>

</body>
</html>