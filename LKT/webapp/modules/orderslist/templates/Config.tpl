<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    {literal}
        <style>
            .HuiTab {
                padding: 30px 60px;
            }

            form[name=form1] {
                padding: 0 !important;
            }

            .form .row {
                margin-top: 10px;
            }

            .row .form-label {
                width: 110px !important;
                text-align: left;
            }

            .form-horizontal .form-label {
                padding-right: 0 !important;
            }

            .inputC1:checked + label::before {
                top: 12px;
                left: 1px;
            }

            .form_new_r .ra1 label {
                width: 100px !important;
            }
        </style>
    {/literal}
    <title>订单参数</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page-container page_absolute">
    <div class="page_title">订单设置</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">自动收货时间：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="text" name="auto_the_goods" value="{$auto_the_goods}" class="input-text">
                </div>
                <label style="line-height: 30px;height: 30px;" class="col-xs-4 col-sm-0">天</label>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">订单失效时间：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="text" name="order_failure" value="{$order_failure}" class="input-text">
                    {*                    <text style="color: red;">(0表示不失效)</text>*}
                </div>
                <label style="line-height: 30px;height: 30px;" class="col-xs-4 col-sm-0">小时</label>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">订单售后时间：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="text" name="order_after" value="{$order_after}" class="input-text">
                </div>
                <label style="line-height: 30px;height: 30px;" class="col-xs-4 col-sm-0">天</label>
            </div>
            <div class="row cl">
                <label class="form-label col-2"><span class="c-red"></span>提醒限制：</label>
                <div class="formControls col-xs-8 col-sm-8">
                    <input type="number" name="remind_day" id="remind_day" value="{$remind_day}" class="input-text">
                    <text>天</text>
                    <input type="number" name="remind_hour" id="remind_hour" value="{$remind_hour}" class="input-text"
                           style="margin-left: 5px;">
                    <text>小时</text>
                    <text style="color: red;">(店主查看发货提醒后，买家多久后能再次提醒。0.表示只能提醒一次)</text>
                </div>
            </div>
            <div class="row cl" style="height: 36px;line-height: 32px;">
                <label class="form-label col-xs-4 col-sm-4">发货时限：</label>
                <div class="form_new_r form_yes">
                    <div class="ra1">
                        <input name="sx_set" onchange="form_address(this)" type="radio" checked=""
                               style="display: none;" id="sx_set-1" class="inputC1" value="1">
                        <label for="sx_set-1">设置时间</label>
                    </div>
                    <div class="ra1">
                        <input name="sx_set" onchange="form_address(this)" type="radio" style="display: none;"
                               id="sx_set-2" class="inputC1" value="0">
                        <label for="sx_set-2">不限时间</label>
                    </div>
                    <text style="color: red;">(规定时间内必须发货)</text>
                </div>
            </div>
            <div class="row cl sx-settime">
                <label class="form-label col-2"><span class="c-red"></span>时限：</label>
                <div class="formControls col-xs-8 col-sm-8">
                    <input type="number" name="sx-day" id="sx-day" value="{$day}" class="input-text">
                    <text>天</text>
                    <input type="number" name="sx-hour" id="sx-hour" value="{$hour}" class="input-text"
                           style="margin-left: 5px;">
                    <text>小时</text>
                </div>
            </div>
        </div>
        <div class="page_h16"></div>
        <div class="page_title">打印设置</div>
        <div class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">顾客编码：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="text" name="accesscode" value="{$accesscode}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">校验码：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="text" name="checkword" value="{$checkword}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">月结卡号：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="text" name="custid" value="{$custid}" class="input-text">
                </div>
            </div>
        </div>
        <div class="page_h10 page_bort" style="height: 68px!important;">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
        </div>
    </form>
</div>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
{literal}
    <script type="text/javascript">
        function form_address(obj) {
            var as = $(obj).val();
            if (as == 1) {
                $(".sx-settime").show();
            } else {
                $(".sx-settime").hide();
            }
        }

        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }

        function check() {
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: 'index.php?module=orderslist&action=Config',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    console.log(data)
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {

                        intervalId = setInterval(function () {
                            clearInterval(intervalId);
                            location.href = "index.php?module=orderslist&action=Config";
                        }, 2000);
                    }
                }
            });
        }
    </script>
{/literal}
</body>
</html>