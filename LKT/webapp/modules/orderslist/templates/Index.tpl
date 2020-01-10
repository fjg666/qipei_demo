<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/flex.css" rel="stylesheet">
    {include file="../../include_path/header.tpl" sitename="DIY头部"}

    {literal}
        <style type="text/css">
            #delorderdiv {
                margin-left: 20px;
                display: inline;
                color: red;
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

            .btn-success:focus, .btn-success:active, .btn-success.active {
                background-color: #2890FF !important;
            }

            .btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.active {
                border: 0 !important;
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

            .table-bordered td {
                border-bottom: 1px solid #eee !important;
            }

            .table {
                border-collapse: collapse;
            }

            form[name=form1] {
                padding: 10px;
                text-align: left;
                height: 36 !important;
            }

            input::-webkit-input-placeholder {
                color: #cccccc;
                font-size: 14px;
                text-align: left;
            }

            option {
                color: #cccccc;
                font-size: 14px;
                text-align: center;
            }

            .seach_test {
                font-family: 'MicrosoftYaHei', 'Microsoft YaHei';
                font-weight: 400;
                font-style: normal;
                font-size: 12px;
                color: #666666;
                text-align: right;
                line-height: 18px;
            }

            .butten_o {
                width: 69px;
                height: 28px;
                background: inherit;
                background-color: rgba(153, 153, 153, 1);
                border: none;
                border-radius: 4px;
                -moz-box-shadow: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                font-family: 'MicrosoftYaHei', 'Microsoft YaHei';
                font-weight: 400;
                font-style: normal;
                font-size: 14px;
                color: #FFFFFF;
                text-align: center;
                line-height: 21px;
            }

            .seach_span {
                position: relative;
            }

            #u2386_img {
                position: absolute;
                right: 10px;
                top: 5px;
                width: 14px;
                height: 14px;
            }

            .txc {
                background: #fff;
            }

            .custom-control {
                position: relative;
                display: -webkit-inline-box;
                display: -webkit-inline-flex;
                display: -ms-inline-flexbox;
                display: inline-flex;
                min-height: 1.5rem;
                padding-left: 1.5rem;
                margin-right: 1rem;
                cursor: pointer;
                float: left;
            }

            .goods-item {
                padding: 10px;
                margin-top: -1px;
            }

            .goods-item:last-child {
                margin-bottom: 0;
            }

            .goods-pic {
                width: 5.5rem;
                height: 5.5rem;
                display: inline-block;
                background-color: #ddd;
                background-size: cover;
                background-position: center;
                margin-right: 1rem;
            }

            .ml-ttt {
                margin-left: 20px;
            }

            .goods-info {
                text-align: left;
            }

            .fs-0 {
                margin-left: 35px;
            }

            .ttt_tr {
                margin-top: 10px;
            }

            span {
                color: #818181;
            }

            th {
                color: #818181;
            }

            .u2523 {
                font-family: 'PingFangSC-Semibold', 'PingFang SC Semibold', 'PingFang SC';
                font-weight: 650;
                font-style: normal;
                font-size: 14px;
                color: #414658;
            }

            #u2554 {
                font-size: 13px;
                color: #818181;
            }

            .ax_label {
                font-size: 14px;
                text-align: left;
            }

            .ax_default {
                font-family: 'ArialMT', 'Arial';
                font-weight: 400;
                font-style: normal;
                font-size: 13px;
                color: #333333;
                text-align: left;
                line-height: normal;
            }

            .caozuo_b:hover {
                color: #38b4ed;
            }

            label {
                display: inline-block;
                margin-bottom: 0;
            }

            .tml-5 {
                margin: 5px 0;
            }

            p {
                margin: 0;
            }

            .wlmk_div {
                display: flex;
                justify-content: flex-start;
            }

            .wlmk_box {
                text-align: right;
                visibility: visible;
                color: #818181;
            }

            .wlmk_box_2 {
                text-align: left;
            }

            .btn-success:hover {
                background: #2481e5;
            }

            .fs-0 {
                display: flex;
                align-items: center;
            }

            form .select {
                height: 100%;
            }

            form[name=form1] input {
                height: 100%;
            }

            .f9e {
                color: #888F9E;
            }

            #btn8:hover {
                border: 1px solid #2890FF !important;
                color: #2890FF !important;
            }

            .nmor {
                border: 0;
                border-radius: 4px;
                background-color: #2890FF !important;
                color: white !important;
            }

            .nmor:hover {
                background-color: #2481e5 !important;
            }

            .tab_dat a {
                width: 88px !important;
                color: #888f9e !important;
                cursor: pointer;
            }

            .tab_dat a img {
                margin-top: -3px;
            }

            .float_right {
                float: right;
            }

            .unable {
                color: #d6dce9 !important;
                border-color: #E9ECEF !important;

            }

            .stopCss:hover {
                cursor: not-allowed;
            }

            .stopCss {
                width: 88px;
                height: 20px;
                border: 1px solid #e9ecef;
                color: #d8dbe8 !important;
                font-size: 12px;
                border-radius: 2px;
                line-height: 20px;
                display: inline-block;
                margin-left: -2%;
                margin-bottom: 8px;
            }

            .textColor {
                color: #414658;
            }

            .tab_dat .hover_a:hover {
                color: rgb(40, 144, 255) !important;
            }

            .tab_news label {
                margin-left: 0px !important;
            }

            .tab_tb_news label {
                padding-left: 10px !important;
            }

            .custom-control {
                padding-left: 0px !important;
            }

        </style>
    {/literal}
    <title>订单列表</title>
</head>

<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="" style="margin: 0px 10px;">
    <div class="text-c" style="display: flex;">
        <form name="form1" action="index.php" method="get" style="width: 100%;padding: 10px;height: 36px;">
            <input type="hidden" name="module" value="orderslist"/>
            <input type="hidden" name="having" value="123"/>
            <input type="hidden" name="ordtype" value="{$otype}"/>
            <input type="hidden" name="gcode" value="{$status}"/>
            <input type="hidden" name="ocode" value="{$ostatus}"/>
            <div>
                <input type="text" name="sNo" id="sNo_" size='8' value="{$sNo}" placeholder="请输入订单编号/姓名/电话/会员ID"
                       style="width:230px;height: 31px;" class="input-text seach_bottom">
                <select name="otype" class="select seach_bottom" id="otype_"
                        style="width: 130px;font-size: 14px;height: 31px;color: #cccccc;vertical-align: middle;">
                    <option value="">请选择订单类型</option>
                    {foreach from=$ordtype item="item" key="key"}
                        <option value="{$key}" {if $otype==$key}selected{/if}>{$item}</option>
                    {/foreach}
                </select>
                <select name="status" class="select seach_bottom" id="status_"
                        style="width: 130px;font-size: 14px;height: 31px;color: #cccccc;vertical-align: middle;">
                    <option value="">请选择订单状态</option>
                    {$class}
                </select>

                <input type="text" class="input-text seach_bottom" value="{$startdate}" placeholder="请输入开始时间"
                       id="startdate" name="startdate" style="width:150px;">
                <span style='display: inline-block;height: 36px;'>
                    <span style='display: flex;align-items:center;'>
                        至
                    </span>
                </span>

                <input type="text" class="input-text seach_bottom" value="{$enddate}" placeholder="请输入结束时间" id="enddate"
                       name="enddate" style="width:150px;margin-left:5px;">

                <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076;"
                       class="reset seach_bottom" onclick="empty()"/>
                <input style="border-radius: 2px;" id="btn1" class="seach_bottom nmor" type="submit" value="查询">
                <input style="margin-right: 0px;" id="btn1" class="seach_bottom nmor float_right" type="button"
                       value="导出" onclick="export_popup(location.href)">
                {if $button[3] == 1}
                    <input style="margin-right: 8px;width: 80px!important;" type="button" value="批量删除"
                           class="seach_bottom nmor float_right" onclick="del_orders()">
                {/if}
            </div>
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll" style="overflow:scroll;width: 101%;">
        <table class="table-border tab_content">
            <thead>
            <tr class="txc tab_tr">
                <th class="tab_news">
                    <label class="custom-control custom-checkbox">
                        <input name="orders_all" value="all" type="checkbox" class="custom-control-input orders_all">
                        <span class="custom-control-indicator"></span>
                    </label>
                    订单信息
                </th>
                <th>订单总计</th>
                <th>数量</th>

                <th>订单状态</th>
                {if $otype == 't2'}
                    <th>拼团状态</th>
                {/if}
                <th>订单类型</th>

                <th>买家信息</th>
                <th>支付方式</th>
                <th>物流信息</th>
                <th class="tab_dat">操作</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$order item=item name=f1}
                <tr class="tab_head">
                    <td colspan="{if $otype == 't2'}10{else}9{/if}" class="tab_tb_news">
                        <label class="custom-control custom-checkbox">
                            <input name="orders[]" value="{$item->sNo}" type="checkbox"
                                   class="custom-control-input orders_select">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">
                                {if $item->p_sNo == ''}
                                    <span class="ml-ttt f9e">订单编号：{$item->sNo}</span>
                                {else}
                                    <span class="ml-ttt f9e">订单编号：{$item->p_sNo}</span>
                                {/if}
                                {if $item->real_sno != '' && $item->status !='待付款' }
                                    <span class="ml-ttt f9e">商户订单编号：{$item->real_sno}</span>
                                {/if}
                                <span class="ml-ttt f9e">创单时间：{$item->add_time}</span>
								<span class="ml-ttt f9e">店铺：{$item->mchname}</span>
                            </span>
                        </label>
                    </td>
                </tr>
                <tr class="tab_td">
                    <td class="tab_news">
                        {foreach from=$item->products item=item2 name=f2 key=key2}
                            <!-- 只显示一个 -->
                            {if $key2 < 1}
                                <div class="goods-item" flex="dir:left box:first">
                                    <div class="fs-0 f9e">
                                        <div class="goods-pic" style="background-image: url('{$item2->imgurl}')"></div>
                                    </div>
                                    <div class="goods-info">
                                        <div class="goods-name u2523">{$item2->product_title}</div>
                                        <div class="mt-1">
                                                <span class="fs-sm f9e">规格：
                                                    <span class="text-danger">
                                                        <span class="mr-3 c658 textColor">{$item2->size}</span>
                                                    </span>
                                                </span>
                                        </div>
                                        <div class="mt-1">
                                            <span class="fs-sm f9e">数量：<span
                                                        class="text-danger  textColor">{$item2->num}
                                                    件</span></span>
                                        </div>
                                        <div>
                                            <span class="fs-sm f9e" style="display: flex;align-items: center;">小计：
                                                <span class="text-danger mr-4  textColor"
                                                      style="display: flex;align-items: center;">
                                                {if $item->otype == 'KJ' || $item->otype == 'JP'}
                                                    {$item->z_price}
                                                {else}
                                                    {$item2->num*$item2->p_price}
                                                {/if}
                                                    元{if $item->otype == 'IN'}+<img src="images/icon/integral_hei.png"
                                                                                    alt=""
                                                                                    style="width: 15px;height: 15px;">{$item->allow}{/if}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </td>

                    <td>
                        {if $item->otype == 'IN'}
                            <div style="display: flex;align-items: center;">&yen;{$item->p_money}+<img
                                        src="images/icon/integral_hei.png" alt=""
                                        style="width: 15px;height: 15px;">{$item->p_integral}</div>
                        {else}
                            <div>&yen;{$item->z_price}</div>
                        {/if}
                    </td>
                    <td>
                        <div>{$item->num}</div>
                    </td>

                    <td>
                        <div class="text" style="visibility: visible;">
                            <p>
                                <span style="font-size: 18px;font-family:'Helvetica';color:{$item->bgcolor}">●</span><span
                                        style="font-family:'MicrosoftYaHei', 'Microsoft YaHei';color:#414658;"> </span><span
                                        style="font-family:'MicrosoftYaHei', 'Microsoft YaHei';color:#888f9e;">{$item->status}</span>
                            </p>
                        </div>
                    </td>

                    {if $otype == 't2'}
                        <td>
                            <div>
                                <span class='f9e'>{$item->pt_status}</span>
                            </div>
                        </td>
                    {/if}

                    <td>
                        <div>
                            <span>{if $item->otype == 'pt'}拼团订单{elseif $item->otype == 'JP'}竞拍订单{elseif $item->otype == 'KJ'}砍价订单{elseif $item->otype == 'IN'}积分订单{elseif $item->otype == 'MS'}秒杀订单{elseif $item->drawid > 0}抽奖订单{else}普通订单{/if}</span>

                        </div>
                    </td>
                    <td>
                        <div id="u2554" class="ax_default ax_label">
                            <div id="u2554_div" class=""></div>
                            <div id="u2555" class="text" style="visibility: visible;">
                                <p>
                                    <span class='f9e' style="display: inline-block;width: 60px;">会员ID：</span>
                                    <span class="textColor">{if $item->user_id}{$item->user_id}{else}暂无{/if}</span>

                                </p>
                                <p>
                                    <span class='f9e' style="display: inline-block;width: 60px;">联系人：</span>
                                    <span class="textColor">{if $item->name}{$item->name}{else}暂无{/if}</span>

                                </p>
                                <p class="tab_nowrap ">
                                    <span class="f9e"
                                          style="display: inline-block;width: 60px;">电 &nbsp;&nbsp;&nbsp;话：</span>
                                    <span class="textColor">{if $item->mobile}{$item->mobile}{else}暂无{/if}</span>

                                </p>
                                <p>
                                    <span class="f9e"
                                          style="display: inline-block;width: 60px;">地 &nbsp;&nbsp;&nbsp;址：</span>
                                    <span class="textColor">{if $item->address}{$item->address}{else}暂无{/if}</span>

                                </p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div>
                                <span>
                                    {$item->pay}
                                </span>
                        </div>
                    </td>
                    <td>
                        <div class="wlmk_div">
                            <div class="wlmk_box" style="width: 100px;">
                                {if !empty($item->courier_num)}
                                    {foreach from=$item->courier_num item=item3 name=f3 key=key3}
                                        <div class="f9e">物流单号{$key3+1}：</div>
                                    {/foreach}
                                {else}
                                    <div class="f9e">物流单号：</div>
                                {/if}
                                <div class="f9e">运费：</div>
                            </div>
                            <div class="wlmk_box_2">
                                {if !empty($item->courier_num)}
                                    {foreach from=$item->courier_num item=item3 name=f3 key=key3}
                                        <div class="goods-name" style="width:200px;">{$item3}</div>
                                    {/foreach}
                                {else}
                                    <div>暂无</div>
                                {/if}
                                <div>{if $item->freight}￥{$item->freight}{else}免邮{/if}</div>
                            </div>
                        </div>
                    </td>
                    <td class="tab_dat">
                        {if $button[0] == 1}
                            <a class="hover_a" href="index.php?module=orderslist&action=Detail&id={$item->sNo}"
                               title="订单详情">
                                <img src="images/icon1/ck.png"/>&nbsp;订单详情
                            </a>
                        {else}
                            <div class="stopCss" title="">
                                <img style="margin-top: -3px;" src="images/icon1/shouhouAddress_jz_1.png"/>&nbsp;禁止修改
                            </div>
                        {/if}
                        {if $button[1] == 1}
                            {if $item->statu <= 3}
                                {if $item->statu == 0 && $item->is_mch == 1}
                                    <div class="stopCss">
                                        <img style="margin-top: -3px;" src="images/iIcon/bianji.png"/>&nbsp;编辑订单
                                    </div>
                                {else}
                                    <a class="hover_a"
                                       href="index.php?module=orderslist&action=Modify&id={$item->sNo}&type=updata"
                                       title="编辑订单">
                                        <img src="images/icon1/xg.png"/>&nbsp;编辑订单
                                    </a>
                                {/if}
                            {else}
                                <div class="stopCss">
                                    <img style="margin-top: -3px;" src="images/iIcon/bianji.png"/>&nbsp;编辑订单
                                </div>
                            {/if}
                        {/if}
                        {if $button[2] == 1}
                            {if $item->statu == 1}
                                <a class="hover_a" href="index.php?module=orderslist&action=Delivery&id={$item->sNo}">
                                    <img src="images/icon1/ck.png"/>&nbsp;发货
                                </a>
                            {else}
                                {if $item->courier_num}
                                    <a class="hover_a"
                                       onclick="send_btn1(this,'{$item->sNo}','{$item->products[0]->courier_num}')">
                                        <img src="images/iIcon/wul.png"/>&nbsp;查看物流
                                    </a>
                                {else}
                                    <div class="stopCss">
                                        <img style="margin-top: -3px;" src="images/iIcon/wul_gray.png"/>&nbsp;查看物流
                                    </div>
                                {/if}
                            {/if}
                        {/if}
                        {if $button[4] == 1}
                            {if $item->statu == 0}
                                <a class="hover_a" onclick="colse('{$item->sNo}')">
                                    <img src="images/iIcon/chaaG.png"/>&nbsp;关闭订单
                                </a>
                            {elseif $item->courier_num!="" && $button[2] == 1 && $item->statu != 1}
                            {else}
                                <div class="stopCss">
                                    <img style="margin-top: -3px;" src="images/iIcon/chaa.png"/>&nbsp;查看物流
                                </div>
                            {/if}
                        {/if}

                    </td>
                </tr>
                <tr class="page_h16">
                    <td colspan="{if $otype == 't2'}10{else}9{/if}"></td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>

    {if $total>10}
        <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    {/if}
</div>

{include file="../../include_path/footer.tpl"}

<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>


{literal}
    <script type="text/javascript">

        // 根据框架可视高度,减去现有元素高度,得出表格高度
        var Vheight = $(window).height() - 56 - 56 - 16 - ($('.tb-tab').text() ? 70 : 0)
        $('.table-scroll').css('height', Vheight + 'px')

        /**
         * [description]
         * <p>Copyright (c) 2018-2019</p>
         * <p>Company: www.laiketui.com</p>
         * @Author  苏涛
         * @version 2.0
         * @date    2018-12-22T19:06:17+0800
         * 全选删除-----
         */

        $(".orders_all").bind("click",
            function () {
                $(".orders_select").prop("checked", $(this).prop("checked"));
            });
        $(".orders_select").bind("click",
            function () {
                var $sel = $(".orders_select");
                var b = true;
                for (var i = 0; i < $sel.length; i++) {
                    if ($sel[i].checked == false) {
                        b = false;
                        break;
                    }
                }
                $(".orders_all").prop("checked", b);
            })


        function del_orders() {
            var $sel = $(".orders_select");
            var b = true;
            con_str = '';
            for (var i = 0; i < $sel.length; i++) {
                if ($sel[i].checked == true) {
                    con_str += $sel[i].value + ',';
                }
            }
            if (con_str.length) {
                // confirm123("确认删除此所选订单？此操作不可恢复！", con_str, 'index.php?module=orderslist&m=del&data=', '删除');
                confirm123("确认删除此所选订单？此操作不可恢复！", con_str, 'index.php?module=orderslist&action=Del&data=', '删除');
            } else {
                layer.msg('请选择需要删除的订单!');
            }
        }

        function confirm123(content, id, url, content1) {
            $("body", parent.document).append(`
            <div class="maskNew">
                <div class="maskNewContent">
                    <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                    <div class="maskTitle">删除</div>
                    <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                    <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                        ${content}
                    </div>
                    <div style="text-align:center;margin-top:30px">
                        <button class="closeMask" style="margin-right:20px" onclick=closeMask('${id}','${url}','${content1}') >确认</button>
                        <button class="closeMask" onclick=closeMask1() >取消</button>
                    </div>
                </div>
            </div>
        `)
        }

        function colse(oid) {
            confirm123("确认关闭此订单？", oid, 'index.php?module=orderslist&action=Close&oid=', '关闭');
        }


        function go(url, type) {
            location.href = url + '&type=' + type;
        }

        function empty() {
            $("#sNo_").val('');
            $("#otype_").val('');
            $("#status_").val('');
            $("#startdate").val('');
            $("#enddate").val('');
            return false;
            location.replace('index.php?module=orderslist');
        }

        laydate.render({
            elem: '#startdate', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#enddate',
            type: 'datetime'
        });

        function check(f) {
            if (Trim(f.product_title.value) == "") {
                layer.msg("产品名称不能为空！");
                f.product_title.value = '';
                return false;
            }
            if (Trim(f.keyword.value) == "") {
                layer.msg("关键词不能为空！");
                f.keyword.value = '';
                return false;
            }
            if (Trim(f.sort.value) == "") {
                layer.msg("排序不能为空！");
                f.sort.value = '';
                return false;
            }
            f.sort.value = Trim(f.sort.value);
            if (!/^(([1-9][0-9]*)|0)(\.[0-9]{1,2})?$/.test(f.sort.value)) {
                layer.msg("排序号必须为数字，且格式为 ####.## ！");
                f.sort.value = '';
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
        })

        function send_btn(obj, otype, id, status, drawid) {
            console.log(status, drawid);
            var dingdan = id;
            var stu = status;
            $('.order_id').val(id);
            $('.otype').val(otype ? otype : 'yb');

            if (stu == 6) {
                layer.msg('订单已关闭，不能发货!');
            }
            if (stu >= 2 && stu != 6) {
                layer.msg('订单已发货，请勿重复操作!');
            }

            if (stu == 0) {
                layer.msg('订单还没付款!');
            }

            if (stu == 1) {
                if (drawid == 0) {//普通订单\
                    console.log(4564);
                    let a = $(".dc");
                    console.log(a);
                    $("body", parent.document).append(a);
                    $("body", parent.document).find(".dc").show();
                    /* $("body",parent.document).find("#hh").show(); */
                } else {
                    layer.msg('抽奖订单请进入订单详情后发货！');
                }
            }
        };

        function send_btn1(obj, id, courier_num) {
            var r_sNo = id;
            $.ajax({
                url: 'index.php?module=orderslist&action=Kuaidishow&r_sNo=' + r_sNo,
                type: "post",
                data: {},
                success: function (res) {
                    var data = JSON.parse(res);
                    console.log(data.code);
                    if (data.code == 1) {
                        console.log(data.list.length);
                        var num = data.list.length;

                        if (data.list.length == 1) {
                            //单物流
                            if(data.list[0].code==0){
                                layer.msg("暂无物流信息！");
                                return false
                            }
                            var str1 = '';
                            var str2 = '';
                            var kuaidi_name = data.list[0].kuaidi_name;
                            var courier_num = data.list[0].courier_num;

                            if(data.list[0].code==1){
                                for (var i = 0; i < data.list[0].data.length; i++) {
                                    str1 += '<li>' + data.list[0].data[i].ftime + '</li>';
                                    str2 += '   <li><p>' + data.list[0].data[i].context + '</p></li>';
                                }
                            }else{
                                str1 = '';
                                str2 = '暂无物流信息！';
                            }

                        } else {
                            //多物流
                            var str1 = '';
                            var str2 = '';
                            for(var i = 0; i < data.list.length;i++){
                                str1 += '  <div>\n' +
                                    '<div class="baoguo">\n' +
                                    '<img src="images/icon/baoguo.png" style="width: 15px;height: 14px;margin-right: 6px;">\n' +
                                    '<p>包裹'+(i+1)+'</p>\n' +
                                    '</div>\n' +
                                    '<div>\n' +
                                    '<label>物流公司：</label>\n' +
                                    '<p>'+data.list[i].kuaidi_name+'</p>\n' +
                                    '</div>\n' +
                                    '<div>\n' +
                                    '<label>运单号码：</label>\n' +
                                    '<p>'+data.list[i].courier_num+'</p>\n' +
                                    '</div>\n' +
                                    '<div class="genzong" style="max-height:100px;">\n' +
                                    '<label>物流跟踪：</label>\n' +
                                    '<ul class="time">\n';
                                if(data.list[i].code==1){
                                    for (var ii = 0;ii<data.list[i].data.length;ii++){
                                        str1 +='<li>'+data.list[i].data[ii].ftime+'</li>';
                                    }
                                }
                                   str1 += '</ul>\n' +
                                    '<ul>\n';

                                if(data.list[i].code==1){
                                    for (var ii1 = 0;ii1<data.list[i].data.length;ii1++){
                                        str1 +='<li><p>'+data.list[i].data[ii1].context+'</p></li>';
                                    }
                                }else{
                                    str1 +='<li><p>暂无物流信息！</p></li>';
                                }
                                     str1 += '</ul>\n' +
                                    '</div>\n' +
                                    '<div>\n' +
                                    '<label></label>\n' +
                                    '<p class="ckgd" style="display: flex;align-items: center;cursor: pointer;margin-top: 5px;">\n' +
                                    '显示全部\n' +
                                    '<img src="images/icon1/storeBottom.png" style="width: 12px;height: 7px;margin-left: 10px;">\n' +
                                    '</p>\n' +
                                    '</div>\n' +
                                    '</div> ';
                            }
                        }
                        wl_appendMask(str1, str2,kuaidi_name,courier_num, num, "cg");
						$("body", parent.document).find('.ckgd').click(function(){
							console.log($(this).parent().prev().css('max-height'))
							if($(this).parent().prev().css('max-height')=='100px'){
								$(this).find('img').css('transform','rotate(180deg)')
								$(this).parent().prev().css('max-height','')
							}else{
								$(this).find('img').css('transform','rotate(0)')
								$(this).parent().prev().css('max-height','100px')
							}
							
						})

                    } else {
                        layer.msg('暂无物流信息！');
                    }
                },
            });
        }


        function excel(pageto) {
            var pagesize = $("[name='DataTables_Table_0_length'] option:selected").val();
            location.href = location.href + '&pageto=' + pageto + '&pagesize=' + 10;
        }

        var i = 0;
        $('select[name=otype]').change(function () {
            let ss = $(this).children('option:selected').val();
            if (ss == 't2') {
                $('select[name=status]').empty();
                $('select[name=status]').append("<option value=''>拼团状态</option><option value='g0'>待付款</option><option value='g1'>拼团中</option><option value='g2'>拼团成功</option><option value='g3'>拼团失败</option>");
            } else {
                // 待付款、待发货、待收货、待评价、退货、已完成、已关闭
                $('select[name=status]').empty();
                $('select[name=status]').append("<option value=''>订单状态</option><option value='0'>待付款</option><option value='1'>待发货</option><option value='2'>待收货</option><option value='3'>待评价</option><option value='4'>退货</option><option value='5'>已完成</option><option value='6'>已关闭</option>");
                $('select[name=ostatus]').remove();
            }
        })

        $('select[name=status]').change(function () {
            let ss = $('select[name=otype]').children('option:selected').val();
            let gg = $(this).children('option:selected').val();
            console.log(gg);
            if (gg == 'g2') {
                $('#fail').remove();
                $('select[name=status]').after("<select name='ostatus' class='select' id='success' style='width: 80px;vertical-align: middle;margin-left: 5px;margin-top: 10px;'><option value='0' selected>全部</option><option value='1' selected>待发货</option><option value='2'>待收货</option><option value='3'>待评价</option></select>");
            } else if (gg == 'g3') {
                $('#success').remove();
                $('select[name=status]').after("<select name='ostatus' class='select' id='fail' style='width: 80px;vertical-align: middle;margin-left: 5px;margin-top: 10px;'><option value='0' selected>全部</option><option value='10' selected>未退款</option><option value='11'>已退款</option></select>");
            } else {
                $('select[name=ostatus]').remove();
            }
        })

        var having = $('input[name=having]').val();
        var otype = $('input[name=ordtype]').val();
        var gstatus = $('input[name=gcode]').val();
        var ostatus = $('input[name=ocode]').val();
        if (having == '123') {
            var tv = $('select[name=otype]').children('option:selected').val();
            if (tv == 't2') {
                $('select[name=status]').empty();
                $('select[name=status]').append("<option value=''>拼团状态</option>");
                var options = {
                    g0: '待付款',
                    g1: '拼团中',
                    g2: '拼团成功',
                    g3: '拼团失败'
                };
                var str = '';

                $.each(options, function (index, element) {
                    str = '<option value="' + index + '"';
                    if (gstatus == index) {
                        str += ' selected';
                    }
                    str += '>' + element + '</option>';
                    $('select[name=status]').append(str);
                })


                var gv = $('select[name=status]').children('option:selected').val();
                if (gstatus == 'g2') {
                    $('#fail').remove();
                    $('select[name=status]').after("<select name='ostatus' class='select' id='success' style='width: 80px;height: 31px;vertical-align: middle;margin-left: 5px;'></select>");
                    var options = {
                        1: '待发货',
                        2: '待收货',
                        3: '待评价'
                    };
                    var str = '';
                    $.each(options, function (index, element) {
                        str = '<option value="' + index + '"';
                        if (ostatus == index) {
                            str += ' selected';
                        }
                        str += '>' + element + '</option>';
                        $('select[name=ostatus]').append(str);
                    })
                } else if (gstatus == 'g3') {
                    $('#success').remove();
                    $('select[name=status]').after("<select name='ostatus' class='select' id='fail' style='width: 80px;height: 31px;vertical-align: middle;margin-left: 5px;margin-top: 9px;'><select>");
                    var options = {
                        10: '未退款',
                        11: '已退款'
                    };
                    var str = '';
                    $.each(options, function (index, element) {
                        str = '<option value="' + index + '"';
                        if (ostatus == index) {
                            str += ' selected';
                        }
                        str += '>' + element + '</option>';
                        $('select[name=ostatus]').append(str);
                    })
                } else {
                    $('select[name=ostatus]').remove();
                }
            }

        }

        //实现全选与反选
        var ids = [];
        $("#allAndNotAll").click(function () {
            if (this.checked) {
                $("input[name=checkid]").each(function (index) {
                    $(this).prop("checked", true);
                    var val = $(this).val();
                    arrModify(ids, val, 1);
                });
            } else {
                $("input[name=checkid]").each(function (index) {
                    $(this).prop("checked", false);
                    var val = $(this).val();
                    arrModify(ids, val, 2);
                });
            }

        });

        Array.prototype.indexOf = function (val) {
            for (var i = 0; i < this.length; i++) {
                if (this[i] == val) return i;
            }
            return -1;
        }
        Array.prototype.remove = function (val) {
            var index = this.indexOf(val);
            if (index > -1) {
                this.splice(index, 1);
            }
        }

        function arrModify(arr, val, type) { //１为增加元素  2为删除元素
            if (type == 1) {
                var index = $.inArray(val, arr);
                if (index === -1) arr.push(val);
            } else if (type == 2) {
                arr.remove(val);
            }
            return arr;
        }

        function selectId(i) {
            i = i.toString();
            var index = $.inArray(i, ids); //判断数组中是否存在该值,如存在返回下标值,如不存在，返回-1
            if ($('#checkid' + i).prop('checked') == true) {
                if (index === -1) ids.push(i);
            } else {
                ids.remove(i);
            }
        }

        Array.prototype.distinct = function () { //数组去重
            var arr = this,
                result = [],
                i,
                j,
                len = arr.length;
            for (i = 0; i < len; i++) {
                for (j = i + 1; j < len; j++) {
                    if (arr[i] === arr[j]) {
                        j = ++i;
                    }
                }
                result.push(arr[i]);
            }
            return result;
        }

        // 单条
        // `<div class="wl_maskNew" style="width:100vw">
        // 	<div class="wl_maskNewContent">
        // 		<a href="javascript:void(0);" class="closeA" onclick="close_wl_Mask1()"><img src="images/icon1/gb.png"></a>
        // 		<div class="maskTitle">
        // 			物流信息
        // 			<img src="../../../../images/icon/close2x.png" style='position: absolute;width:16px;height:16px;right: 20px;top: 23px;cursor: pointer;'>
        // 		</div>
        // 		<div class='wl_mask_data'>
        // 			<div>
        // 				<label>物流公司：</label>
        // 				<p>圆通速递</p>
        // 			</div>
        // 			<div>
        // 				<label>运单号码：</label>
        // 				<p>808045314511212</p>
        // 			</div>
        // 			<div>
        // 				<label>物流跟踪：</label>
        // 				<ul class="time">
        // 					<li>2019-09-19 19:33:30</li>
        // 					<li>2019-09-19 19:33:30</li>
        // 					<li>2019-09-19 19:33:30</li>
        // 					<li>2019-09-19 19:33:30</li>
        // 					<li>2019-09-19 19:33:30</li>
        // 					<li>2019-09-19 19:33:30</li>
        // 					<li>2019-09-19 19:33:30</li>
        // 				</ul>
        // 				<ul>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 					<li>
        // 						<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 					</li>
        // 				</ul>
        // 			</div>
        // 		</div>
        // 	</div>
        // </div>`
        <!-- 多条 -->
        // `<div class="wl_maskNew" style="width:100vw">
        // 	<div class="wl_maskNewContent">
        // 		<a href="javascript:void(0);" class="closeA" onclick="close_wl_Mask1()"><img src="images/icon1/gb.png"></a>
        // 		<div class="maskTitle">
        // 			物流信息
        // 			<img src="../../../../images/icon/close2x.png" style='position: absolute;width:16px;height:16px;right: 20px;top: 23px;cursor: pointer;'>
        // 		</div>
        // 		<div class='wl_mask_data'>
        // 			<div>
        // 				<div class='baoguo'>
        // 					<img src="../../../../images/icon/baoguo.png" style='width: 15px;height: 14px;margin-right: 6px;'>
        // 					<p>包裹1</p>
        // 				</div>
        // 				<div>
        // 					<label>物流公司：</label>
        // 					<p>圆通速递</p>
        // 				</div>
        // 				<div>
        // 					<label>运单号码：</label>
        // 					<p>808045314511212</p>
        // 				</div>
        // 				<div class='genzong' style='height:100px;'>
        // 					<label>物流跟踪：</label>
        // 					<ul class="time">
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 					</ul>
        // 					<ul>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 					</ul>
        // 				</div>
        // 				<div>
        // 					<label></label>
        // 					<p style='display: flex;align-items: center;cursor: pointer;margin-top: 5px;'>
        // 						显示全部
        // 						<img src="../../../../images/icon1/storeBottom.png" style='width: 12px;height: 7px;margin-left: 10px;'>
        // 					</p>
        // 				</div>
        // 			</div>
        // 			<div>
        // 				<div class="baoguo">
        // 					<img src="../../../../images/icon/baoguo.png" style="width: 15px;height: 14px;margin-right: 6px;">
        // 					<p>包裹1</p>
        // 				</div>
        // 				<div>
        // 					<label>物流公司：</label>
        // 					<p>圆通速递</p>
        // 				</div>
        // 				<div>
        // 					<label>运单号码：</label>
        // 					<p>808045314511212</p>
        // 				</div>
        // 				<div class="genzong" style="height:100px;">
        // 					<label>物流跟踪：</label>
        // 					<ul class="time">
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 						<li>2019-09-19 19:33:30</li>
        // 					</ul>
        // 					<ul>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 						<li>
        // 							<p>【长沙市】 您的快件已送达 星蓝湾北门幸福购妈妈驿站</p>
        // 						</li>
        // 					</ul>
        // 				</div>
        // 				<div>
        // 					<label></label>
        // 					<p style="display: flex;align-items: center;cursor: pointer;margin-top: 5px;">
        // 						显示全部
        // 						<img src="../../../../images/icon1/storeBottom.png" style="width: 12px;height: 7px;margin-left: 10px;">
        // 					</p>
        // 				</div>
        // 			</div>
        // 		</div>
        // 	</div>
        // </div>`

		$("body", parent.document).on('click','.wl_maskNew .closeB',function(){
			$(this).parents('.wl_maskNew').remove()
		})
        function wl_appendMask(content1, content2,kuaidi_name,courier_num, type, src) {
            if (type > 1) {
                $("body", parent.document).append(`
               <div class="wl_maskNew" style="width:100vw">
        	<div class="wl_maskNewContent">
        		<a href="javascript:void(0);" class="closeA"><img src="images/icon1/gb.png"></a>
        		<div class="maskTitle">
        			物流信息
        			<img class="closeB" src="images/icon/close2x.png" style='position: absolute;width:16px;height:16px;right: 20px;top: 23px;cursor: pointer;'>
        		</div>
        		<div class='wl_mask_data'>
        		      ${content1}
        		</div>
        	</div>
        </div>
            `);
            } else {
                $("body", parent.document).append(`
               <div class="wl_maskNew" style="width:100vw">
        	<div class="wl_maskNewContent">
        		<a href="javascript:void(0);" class="closeA" onclick="close_wl_Mask1()"><img src="images/icon1/gb.png"></a>
        		<div class="maskTitle">
        			物流信息
        			<img class="closeB" src="images/icon/close2x.png" style='position: absolute;width:16px;height:16px;right: 20px;top: 23px;cursor: pointer;'>
        		</div>
        		<div class='wl_mask_data'>
        			<div>
        				<label>物流公司：</label>
        				<p>${kuaidi_name}</p>
        			</div>
        			<div>
        				<label>运单号码：</label>
        				<p>${courier_num}</p>
        			</div>
        			<div>
        				<label>物流跟踪：</label>
        				<ul class="time">
        					 ${content1}
        				</ul>
        				<ul>
        					${content2}
        				</ul>
        			</div>
        		</div>
        	</div>
        </div>
            `);
            }
        }

        function close_wl_Mask1() {
            $(".wl_maskNew").remove();
        }

        function appendMask(content, src) {
            $("body").append(`
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
            `)
        }

        function appendMask_tj(content, src) {
            $(".dc").hide();
            $("body").append(`
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
            `)
        }

        function closeMask_tj() {
            $(".maskNew").remove();
            $(".dc").show();
        }

        function appendMask1(content, src) {
            $("body").append(`
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
            `)
        }

        function closeMask(id) {
            $(".maskNew").remove();
            $.ajax({
                type: "post",
                url: "index.php?module=coupon&action=Del&id=" + id,
                async: true,
                success: function (res) {
                    console.log(res)
                    if (res == 1) {
                        layer.msg("删除成功!");
                    } else {
                        layer.msg("删除失败!");
                    }
                }
            });
        }

        function closeMask1() {
            $(".maskNew").remove();
        }

        function closeMask4() {
            $(".maskNew1").remove();
            location.replace(location.href);
        }

        function confirm(content, id) {
            $("body").append(`
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
            `)
        }

        function hm() {
            $(".dd").hide();
        }
    </script>
    <script type="text/javascript">
    </script>
{/literal}
</body>

</html>