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
    <link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>
    {literal}
        <style type="text/css">
            i {
                cursor: pointer;
            }

            .textIpt {
                border: 1px solid #eee;
                padding-left: 20px;
                height: 30px;
                line-height: 30px;
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
        </style>
        <script type="text/javascript">
            setSize();
            addEventListener('resize', setSize);

            function setSize() {
                document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 100 + 'px';
            }

            /*alert弹出层*/
            function jqalert(param) {
                var title = param.title,
                    content = param.content,
                    yestext = param.yestext,
                    notext = param.notext,
                    yesfn = param.yesfn,
                    nofn = param.nofn,
                    id = param.id,
                    url = param.url,
                    nolink = param.nolink,
                    yeslink = param.yeslink,
                    prompt = param.prompt,
                    click_bg = param.click_bg,
                    obj = param.obj,
                    type = param.type,
                    price = param.price,
                    price = Number(price);
                str = `<a style="text-decoration:none" class="ml-5" href="index.php?module=return&action=view&id=${id}" title="查看">
                            <div style="align-items: center;font-size: 12px;display: flex;">
                            <div style="margin: 0 auto;display: flex;align-items: center;">
                            <img src="images/icon1/ck.png"/>&nbsp;查看
                                    </div>
                                </div>
                            </a>`,

                    td = $(obj).parent("td");
                var arr1 = {
                    title,
                    content,
                    yestext,
                    notext,
                    yesfn,
                    nofn,
                    id,
                    url,
                    nolink,
                    yeslink,
                    prompt,
                    click_bg,
                    obj,
                    type,
                    price,
                    str,
                    td
                };
                window.arr1 = arr1;
                window.parent.getData1();
                console.log(window.parent, '子级');
                if (click_bg === undefined) {
                    click_bg = true;
                }
                if (yestext === undefined) {
                    yestext = '确认';
                }
                if (!nolink) {
                    nolink = 'javascript:void(0);';
                }
                if (!yeslink) {
                    yeslink = 'javascript:void(0);';
                }

                var htm = '';
                htm += `<div class="maskNew" id="jq-alert" style="text-align:center;"><div class="alert maskNewContent" style="height:244px!important">`
                if (title) htm += `<div class="MaskTitle" style=" font-size: 15px;font-weight: bold;text-align: left;padding-left: 20px;border-bottom: 2px #E9ECEF solid;padding-bottom: 12px;">${title}</div>`;
                if (prompt) {
                    htm += `<div class="content" style="text-align:center;margin-bottom:30px;">
                             <a href="javascript:void(0);" class="closeA" onclick=closeMask1() >
                                                                <img src="images/icon1/gb.png"/>
                                </a>
                            <div class="prompt" style="display: flex;">
                                <div style="width: 23%">
                                    <p class="prompt-content" style="text-align:right;font-size:15px;margin:30px auto;">${prompt}</p>
                                </div>
                                <div style="width: 77%">
                                     <textarea type="text" style="overflow: visible;font-size:15px;margin-top: 30px !important;border: 1px #D5DBE8 solid;resize: none;margin: 0px;height: 86px;width: 304px;" class="prompt-text textIpt"></textarea>
                                </div>
                            </div>
                            </div>`
                } else {
                    if (type == 1 || type == 6) {
                        htm += `<div class="content" style="text-align:center;margin:30px auto;font-size:22px;">${content}</div>`
                    } else {
                        htm += `<div class="content" style="height: 120px;">
                            <div class="prompt">
                                <p class="prompt-content" style="text-align:center;font-size:18px;margin:30px auto;">${content}</p>
                                <div style="    text-align: center;    margin-bottom: 45px;    margin-top: -20px;">
                                    <span class="pd20" >应退：${price} <input type="hidden" value="${price}" class="ytje"> &nbsp; 实退:</span>
                                    <input type="number" style="width:100px" value="${price}" class="prompt-text inp_maie textIpt">
                                </div>
                            </div>
                            
                        </div>`;
                    }
                }
                if (!notext) {
                    htm += `<div class="fd-btn">
                         <a href="${yeslink}" class="confirm closeMask" style="display:inline-block;font-size:14px" id="yes_btn">${yestext}</a>
                        </div>
                    </div>`
                } else  if (type == 8) {
                    htm += `<div class="fd-btn" style="display: flex;    margin-top: -25px;">
                                <div style="width:23%"></div>
                                 <div style="width: 77%">

                        <a href="${yeslink}"  onclick="yesB()" class="confirm closeMask"   style="display:inline-block;font-size:14px;margin-right:30px;"  id="yes_btn">${yestext}</a>
                        <a href="${nolink}" onclick="closeMask1()" data-role="cancel" class="cancel closeMask" style="display:inline-block;font-size:14px;background-color:#fff;color:#666;">${notext}</a>
                                </div>
                         </div>
                        </div>`
                } else{
                    htm += `<div class="fd-btn">

                        <a href="${yeslink}"  onclick="yesB()" class="confirm closeMask"   style="display:inline-block;font-size:14px;margin-right:30px;"  id="yes_btn">${yestext}</a>
                        <a href="${nolink}" onclick="closeMask1()" data-role="cancel" class="cancel closeMask" style="display:inline-block;font-size:14px;background-color:#fff;color:#666;">${notext}</a>
                         </div>
                        </div>`
                }

                $('body', parent.document).append(htm);
                var al = $('#jq-alert');
                al.on('click', '[data-role="cancel"]', function () {
                    al.remove();

                    if (nofn) {
                        param.nofn();
                        nofn = '';
                    }
                    param = {};
                });
                $(document).delegate('.alert', 'click', function (event) {
                    event.stopPropagation();
                });
                $("#yes_btn").click(
                    function yesB() {
                        if (type == 2 || type == 5 || type == 8) {
                            var text = $(".prompt-text").val();
                            if (text.length > 1) {
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: "id=" + id + '&text=' + text + '&m=' + type,
                                    success: function (res) {
                                        console.log(res);
                                        if (res) {
                                            td.html(str);
                                            td.prev().html('<span style="color:#ff2a1f;">已拒绝</span>');
                                            layer.msg('提交成功');
                                            setTimeout(function () {
                                                al.remove();
                                            }, 300);
                                        } else {
                                            layer.msg('操作失败!');
                                        }
                                    }
                                });

                            } else {
                                jqtoast('原由不能为空!');
                            }
                        } else {

                            var text = $(".prompt-text").val();
                            if (type == 1 || type == 6) {

                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: "id=" + id + '&m=' + type,
                                    success: function (res) {
                                        console.log(res);
                                        if (res == 1) {
                                            td.html(str);
                                            if (type == '4' || type == '9') {
                                                var status = '<span style="color:#8FBC8F;">已退款</span>';
                                            } else {
                                                var status = '<span style="color:#A4D3EE;">待买家发货</span>';
                                            }
                                            td.prev().html('<span style="color:#30c02d;">' + status + '</span>');
                                            jqtoast('提交成功');
                                            setTimeout(function () {
                                                al.remove();
                                            }, 300);
                                        } else {
                                            jqtoast('操作失败!');
                                        }
                                    }
                                });
                            } else {
                                console.log(url)
                                if (Number(text) > 0 && Number(text) <= Number(price)) {
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: "id=" + id + '&m=' + type + '&price=' + Number(text),
                                        success: function (res) {
                                            console.log(res);
                                            if (res == 1) {
                                                td.html(str);
                                                if (type == '4' || type == '9') {
                                                    var status = '<span style="color:#8FBC8F;">已退款</span>';
                                                } else {
                                                    var status = '<span style="color:#A4D3EE;">待买家发货</span>';
                                                }
                                                td.prev().html('<span style="color:#30c02d;">' + status + '</span>');
                                                jqtoast('退款成功' + text);
                                                setTimeout(function () {
                                                    al.remove();
                                                }, 300);
                                            } else {
                                                jqtoast('操作失败!');
                                            }
                                        }
                                    });
                                } else {
                                    jqtoast('输入金额有误,请重新输入!');
                                }

                            }
                        }

                    });

                if (click_bg === true) {
                    $(document).delegate('#jq-alert', 'click', function () {
                        setTimeout(function () {
                            al.remove();
                        }, 300);
                        yesfn = '';
                        nofn = '';
                        param = {};
                    });
                }

            }

            /*toast 弹出提示*/
            function jqtoast(text, sec) {
                var _this = text;
                var this_sec = sec;
                var htm = '';
                htm += '<div class="jq-toast" style="display: none;">';
                if (_this) {
                    htm += '<div class="toast">' + _this + '</div></div>';
                    $('body').append(htm);
                    $('.jq-toast').fadeIn();

                } else {
                    layer.msg('提示文字不能为空');
                }
                if (!sec) {
                    this_sec = 2000;
                }
                setTimeout(function () {
                    $('.jq-toast').fadeOut(function () {
                        $(this).remove();
                    });
                    _this = '';
                }, this_sec);
            }
        </script>
        <style>
            .show-list {
                width: 80%;
                margin: 0 auto;
            }

            .show-list li {
                height: 10px;
                font-size: 18px;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                border-bottom: 1px solid #dcdcdc;
            }

            * {
                margin: 0;
                padding: 0;
                list-style: none;
            }

            a {
                text-decoration: none;
            }

            /*jq-alert弹出层封装样式*/
            .jq-alert {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-flex-direction: row;
                flex-direction: row;
                -webkit-justify-content: center;
                -webkit-align-items: center;
                justify-content: center;
                align-items: center;
                background-color: rgba(0, 0, 0, .3);
                z-index: 99;
            }

            .jq-alert .alert {
                background-color: #FFF;
                width: 440px;
                height: 250px;
                border-radius: 4px;
                overflow: hidden;
            }

            .jq-alert .alert .title {
                position: relative;
                margin: 0;
                font-size: 18px;
                text-align: center;
                font-weight: normal;
                color: rgba(0, 0, 0, .8);
            }

            .jq-alert .alert .content {
                padding: 0 18px;
                font-size: 18px;
                color: rgba(0, 0, 0, .6);
                height: 56%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .jq-alert .alert .content .prompt {
                width: 100%;
            }

            .jq-alert .alert .content .prompt .prompt-content {
                font-size: 18px;
                color: rgba(0, 0, 0, .54);
                margin: 0;
                margin-bottom: 20px;
                /*text-align: center;*/
            }

            .jq-alert .alert .content .prompt .prompt-text {
                height: 73px;
                background: none;
                border: none;
                outline: none;
                width: 100%;
                box-sizing: border-box;
                margin-top: 20px;
                background-color: #FFF;
                border: 1px solid #dcdcdc;
                text-indent: 5px;
            }

            .jq-alert .alert .content .prompt .prompt-text:focus {
                border: 1px solid #2196F3;
                background-color: rgba(33, 150, 243, .08);
            }

            .jq-alert .alert .fd-btn {
                height: 50px;
                position: relative;
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-flex-direction: row;
                flex-direction: row;
                -webkit-justify-content: center;
                -webkit-align-items: center;
                justify-content: center;
                align-items: center;
            }

            .jq-alert .alert .fd-btn:after {
                position: absolute;
                content: "";
                top: 0;
                left: 0;
                width: 100%;
                height: 1px;
                background-color: #F3F3F3;
            }

            .jq-alert .alert .fd-btn a {
                width: 100%;
                font-size: 18px;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                color: rgba(0, 0, 0, .8);
            }

            .jq-alert .alert .fd-btn a.cancel {
                position: relative;
                color: rgba(0, 0, 0, .5);
                line-height: 50px;
            }

            .jq-alert .alert .fd-btn a.cancel:after {
                content: "";
                position: absolute;
                top: .1rem;
                right: 0;
                width: 1px;
                height: .6rem;
                background-color: #F3F3F3;
            }

            .jq-alert .alert .fd-btn a.confirm {
                color: #2196F3;
            }

            .jq-alert .alert .fd-btn a.confirm:active {
                background-color: #2196F3;
                color: #FFF;
            }

            /*toast弹出层*/
            .jq-toast {
                z-index: 999;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                flex-direction: row;
                -webkit-flex-direction: row;
                -ms-flex-direction: row;
                justify-content: center;
                -webkit-justify-content: center;
                align-items: center;
                -webkit-align-items: center;
            }

            .jq-toast .toast {
                max-width: 80%;
                padding: 10px 20px;
                background-color: rgba(0, 0, 0, .48);
                color: #FFF;
                border-radius: 4px;
                font-size: 18px;
            }

            .confirm .cancel {
                text-decoration: none !important;
            }

            .inp_maie {
                height: 32px !important;
                width: 20% !important;
                margin-top: 0 !important;
            }

            #btn8:hover {
                border: 1px solid #2890FF !important;
                color: #2890FF !important;
            }

            .stopCss:hover {
                cursor: not-allowed;
            }
        </style>
    {/literal}
    <title>退货列表</title>
</head>
<body>

<nav class="breadcrumb page_nav">
    <i class="Hui-iconfont">&#xe62d;</i>
    {foreach from=$menu item=item key=k name=f1}
        {if $smarty.foreach.f1.first}
            <span class="c-gray en"></span>
            {$item->title}
        {else}
            <span class="c-gray en">&gt;</span>
            {if $smarty.foreach.f1.total == 3 && ($smarty.foreach.f1.total-1) == $k}
                {$item->title}
            {else}
                <a style="margin-top: 10px;" onclick="location.href='{$item->url}';">{$item->title} </a>
            {/if}
        {/if}
    {/foreach}
</nav>


<div class="" style="padding: 0!important;margin: 0px 10px;margin-bottom: 10px;">
    <input type="hidden" class="price" value="">
    <div class="text-c tetx_c">
        <form name="form1" action="index.php" method="get" class="page_list">
            <input type="hidden" name="module" value="return"/>
            <input type="text" name="p_name" size='8' value="{$p_name}" id="" placeholder="请输入订单号" style="width:200px"
                   class="input-text">
            <select name="r_type" class="select" style="width: 120px;height: 31px;vertical-align: middle;">
                <option value="">请选择订单状态</option>
                {$r_type_str}
            </select>
            <div style="position: relative;display: inline-block;">
                <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate"
                       name="startdate" style="width:150px;">
            </div>
            至
            <div style="position: relative;display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate"
                       name="enddate" style="width:150px;">
            </div>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;"
                   class="reset" onclick="empty()"/>

            <input name="" id="btn1" class="btn btn-success" style="height: 31px;line-height: 31px;" type="submit"
                   value="查询">
            <input type="button" id="btn2" value="导出" style="height: 31px;line-height: 31px;float: right;"
                   class="btn btn-success" onclick="excel('all')">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20" style="margin-top: 0;" style="overflow: scroll;">
        <table class="table table-border table-bordered table-bg table-hover table-sort taber_border tab_content">
            <thead>
            <tr class="text-c tab_tr">
                <th class="tab_num">序号</th>
                <th aria-valuetext="user_id">用户ID</th>
                <th aria-valuetext="p_name">产品名称</th>
                <th aria-valuetext="s_name">店铺名称</th>
                <th aria-valuetext="p_price">产品价格</th>
                <th aria-valuetext="num">数量</th>
                <th aria-valuetext="r_sNo">订单号</th>
                <th class="tab_nowrap" aria-valuetext="real_money">实退金额</th>
                <th class="tab_time" aria-valuetext="add_time">申请时间</th>
                <th class="tab_nowrap" aria-valuetext="re_type">类型</th>
                <th class="tab_nowrap" aria-valuetext="status">状态</th>
                <th class="tab_three">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
                    <td>{$item->user_id}</td>
                    <td>{$item->p_name}</td>
                    <td>{$item->shop_name}</td>
                    <td>{$item->p_price}</td>
                    <td>{$item->num}</td>
                    <td>{$item->r_sNo}</td>
                    <td>
                        {if $item->real_money == '0.00'}
                            未退款
                        {else}
                            {$item->real_money}
                        {/if}
                    </td>
                    <td class="tab_time">{$item->re_time}</td>
                    <td class="tab_nowrap">
                        {if $item->re_type == 2}
                            <span>仅退款</span>
                        {elseif $item->re_type == 1}
                            <span>退货退款</span>
                        {else}
                            <span>换货</span>
                        {/if}
                    </td>
                    <td class="tab_nowrap">
                        {if $item->r_status == 4}
                            {if $item->r_type == 0}
                                <span>审核中</span>
                            {elseif $item->r_type == 1 || $item->r_type == 6}
                                {*<span>待买家发货</span>*}
                                <span>审核通过</span>
                            {elseif $item->r_type == 2 || $item->r_type == 8}
                                <span>已拒绝</span>
                            {elseif $item->r_type == 3 }
                                {*<span>待商家收货</span>*}
                                <span>审核中</span>
                            {elseif $item->r_type == 4 || $item->r_type == 9}
                                <span>审核通过</span>
                                {*<span>已退款</span>*}
                            {else}
                                <span>已拒绝</span>
                                {*<span style="color: #ff2a1f;">拒绝并退回商品</span>*}
                            {/if}
                        {else}
                            {if $item->r_type == 4 || $item->r_type == 9}
                                <span style="color: #7CCD7C;">处理成功</span>
                            {else}
                                <span style="color: #ff2a1f;">已拒绝</span>
                            {/if}
                        {/if}
                    </td>

                    <td class="tab_three">
                        {if $button[0] == 1}
                            <a href="index.php?module=return&action=view&id={$item->id}" title="查看">
                                <img src="images/icon1/ck.png"/>&nbsp;查看
                            </a>
                        {/if}
                        {if $button[1] == 1}
                            {if $item->r_status == 4}
                                {if $item->r_type == 0}
                                    {if $item->re_type == 1}
                                        <a href="javascript:;" title="审核通过"
                                           onclick="is_ok(this,{$item->id},1,'index.php?module=return&action=examine','确定要通过该用户的申请,并让用户寄回?')">
                                            <img src="images/icon1/qy.png"/>&nbsp;通过
                                        </a>
                                        <a href="javascript:;" title="审核拒绝"
                                           onclick="refuse(this,'index.php?module=return&action=examine',{$item->id},2)">
                                            <img src="images/icon1/jy.png"/>&nbsp;拒绝
                                        </a>
                                    {elseif $item->re_type == 2}
                                        <a href="javascript:;" title="审核通过"
                                           onclick="is_ok(this,{$item->id},9,'index.php?module=return&action=examine','审核通过钱款将原路返还,确认通过?')">
                                            <img src="images/icon1/qy.png"/>&nbsp;通过
                                        </a>
                                        <a href="javascript:;" title="审核拒绝"
                                           onclick="refuse(this,'index.php?module=return&action=examine',{$item->id},8)">
                                            <img src="images/icon1/jy.png"/>&nbsp;拒绝
                                        </a>
                                    {else}
                                        <a href="javascript:;" title="审核通过"
                                           onclick="is_ok(this,{$item->id},6,'index.php?module=return&action=examine','确定要通过该用户的申请,并让用户寄回?')">
                                            <img src="images/icon1/qy.png"/>&nbsp;通过
                                        </a>
                                        <a href="javascript:;" title="审核拒绝"
                                           onclick="refuse(this,'index.php?module=return&action=examine',{$item->id},2)">
                                            <img src="images/icon1/jy.png"/>&nbsp;拒绝
                                        </a>
                                    {/if}
                                {elseif $item->r_type == 3}

                                    {if $item->re_type < 3}
                                        <a href="javascript:;" title="同意并退款"
                                           onclick="is_ok(this,{$item->id},4,'index.php?module=return&action=examine','确定已到货并退款到用户?')">
                                            <img src="images/icon1/qy.png"/>&nbsp;通过
                                        </a>
                                    {else}
                                        <a href="javascript:;" title="回寄"
                                           onclick="zxfahuo('{$item->r_sNo}','{$item->id}')">
                                            <img src="images/icon1/sx.png"/>&nbsp;回寄
                                        </a>
                                    {/if}
                                    <a href="javascript:;" title="拒绝并退回商品"
                                       onclick="refuse(this,'index.php?module=return&action=examine',{$item->id},5)">
                                        <img src="images/icon1/jy.png"/>&nbsp;拒绝
                                    </a>
                                {/if}
                            {else}
                                <a title="处理完成" class="tab_none stopCss"
                                   style="color: #d5dbe8!important;border: 1px solid #e9ecef!important;">
                                    <img src="images/iIcon/tg.png"/>&nbsp;通过
                                </a>
                                <a title="处理完成" class="tab_none stopCss"
                                   style="color: #d5dbe8!important;border: 1px solid #e9ecef!important;">
                                    <img src="images/iIcon/jj.png"/>&nbsp;拒绝
                                </a>
                            {/if}

                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_h20"></div>
</div>
<div class="dc" style="display:none;">
    <div class="maskNewContent">
        <div class="maskTitle ">
            添加快递信息
        </div>
        <a href="javascript:void(0);" onclick="dc()" class="closeA qx" style="display: block;"><img
                    src="images/icon1/gb.png"/></a>
        <form action="" method="post" class="form form-horizontal" id="form-category-add"
              enctype="multipart/form-data">
            <div id="tab-category" class="HuiTab">
                <div class="" style="margin-top: 45px;">
                    <div class="">
                        <input type="hidden" name="sNo" value="" class="order_id">
                        <input type="hidden" name="otype" value="yb" class="otype">
                        <input type="hidden" name="oid" value="{$data.oid}" class="oid">
                        <input type="hidden" name="trade" value="3">
                        <label class="maskLeft" style="">快递公司：</label>
                        <div class="formControls maskRight" style="width: 60%;float: left;">
                            <form name="hh" action="" method="post">
                                    <span class="search">
                                        <input class="ww ipt1" id="makeInput" autocomplete="off"
                                               onkeyup="setContent(this,event);" onfocus="setDemo(this,event)"
                                               type="text" placeholder="请选择或输入快递名称">
                                        <select name="kuaidi" class="selectName" id="hh"
                                                style=" position: absolute;z-index:99;width: 153px;margin-top: 1px;margin-left: 0px;"
                                                onkeyup="getfocus(this,event)" onclick="choose(this)" size="10"
                                                id="num1">
                                            {foreach from=$express item = item name=f1}
                                                <option value="{$item->id}">{$item->kuaidi_name}</option>
                                            {/foreach}
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
                            <input type="text" class="ipt1" value="" name="danhao" placeholder="请输入正确的快递单号"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-9 " style="margin-left:40%">
                    <input class="qd closeMask" type="button"
                           onclick="qd('index.php?module=orderslist&action=addsign',3)" value="提交">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>
<script type="text/javascript" src="style/laydate/laydate.js"></script>
<script language="javascript" src="style/ssd1.js"></script>

{literal}
    <script type="text/javascript">
        function closeDD() {
            $(".dc").hide()
        }

        laydate.render({
            elem: '#startdate', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#enddate',
            type: 'datetime'
        });

        function empty() {
            location.replace('index.php?module=return');
        };

        var aa = $(".page_absolute").height() - $(".tetx_c").height();
        var bb = $(".taber_border").height();
        console.log(aa, bb)
        if (aa < bb) {
            $(".page_h20").css("display", "block")
        } else {
            $(".page_h20").css("display", "none")
        }

        function excel(pageto) {
            var pagesize = $("[name='DataTables_Table_0_length'] option:selected").val();
            var page = $(".current").text();
            var type_asc = $(".sorting_asc").attr('aria-valuetext');
            var type_desc = $(".sorting_desc").attr('aria-valuetext');
            if (type_asc && !type_desc) {
                var sort = 'asc';
                var sort_name = type_asc;
            } else {
                var sort = 'desc';
                var sort_name = type_desc;
            }
            location.href = location.href + '&pageto=' + pageto + '&pagesize=' + pagesize + '&page=' + page + '&sort=' + sort + '&sort_name=' + sort_name;
        }

        function refuse(obj, url, id, type) {
            jqalert({
                title: '填写理由',
                prompt: '拒绝理由：',
                yestext: '提交',
                notext: '取消',
                id: id,
                url,
                obj: obj,
                type: type,
            })
        };

        function zxfahuo(sNo, id) {
            console.log(sNo, id)
            //layer_show('添加快递信息', 'index.php?module=return&action=addsign&id=' + id + '&sNo=' + sNo, 600, 400);
            //<input type="hidden" name="sNo" value="" class="order_id">
            // <input type="hidden" name="otype" value="{$otype}" class="otype">
            // <input type="hidden" name="oid" value="{$data.oid}" class="oid">
            // <input type="hidden" name="trade" value="3">
            let a = $(".dc");
            console.log(a)
            $(".oid").val(sNo);
            $(".order_id").val(id);
            $("body", parent.document).find(".dc").remove();

            $("body", parent.document).append(a);

            $("body", parent.document).find(".dc").show();

            // $(".returnDD").show();


        }

        function is_ok(obj, id, type, url, content) {
            console.log(type == 4 || type == 9);
            if (type == 4 || type == 9) {
                $.ajax({
                    type: "GET",
                    url,
                    data: "id=" + id + '&f=check' + '&m=' + type,
                    success: function (res) {
                        if (res) {
                            console.log(res);
                            $(".price").val(res);
                            jqalert({
                                title: '提示',
                                content: content,
                                yestext: '确定',
                                url: url,
                                id: id,
                                notext: '取消',
                                obj: obj,
                                type: type,
                                price: res
                            })
                        } else {
                            layer.msg('操作失败!');
                        }
                    }
                });
            } else if (type == 7) {
                send_btn(id);
            } else {
                jqalert({
                    title: '提示',
                    content: content,
                    yestext: '确定',
                    url: url,
                    id: id,
                    notext: '取消',
                    obj: obj,
                    type: type,
                })
            }

        };

    </script>
{/literal}
</body>
</html>