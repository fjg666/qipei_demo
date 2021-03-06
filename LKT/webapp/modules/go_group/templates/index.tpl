<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="style/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="style/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="style/lib/Hui-iconfont/1.0.7/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="style/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="style/css/style.css"/>
    <script type="text/javascript" src="style/js/Popup.js"></script>
    {literal}
        <style type="text/css">

            .isclick a {
                color: #ffffff;
            }

            .page_bgcolor .status {
                border: 1px solid #ddd;
                border-right: 0;
            }

            .page_bgcolor .status:last-child {
                border-right: 1px solid #ddd;
            }

            .page_bgcolor div {
                font-size: 16px;
            }

            .status {
                width: 80px;
                height: 34px;
                line-height: 34px;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #fff;
                margin-left: 0px;
            }

            .status a:hover {
                text-decoration: none;
                color: #fff;
            }

            .status:hover {
                background-color: #2481e5;
            }

            .status:hover a {
                color: #fFF;
            }

            .isclick {
                width: 80px;
                height: 34px;
                background: #2890FF;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                border: 1px solid #2890FF !important;
            }

            td a {
                width: 44%;
                margin: 2% !important;
            }

            td button {
                margin: 4px;
                float: left;
                background: white;
                color: #DCDCDC;
                border: 1px #DCDCDC solid;
                width: 56px;
                height: 22px;
            }

            .tc-box {
                width: 100%;
                height: 100vh;
                position: relative;
                position: fixed;
                background: rgba(0, 0, 0, 0.3);
                display: none;
                top: 0;
            }

            .tc-box > div {
                height: 500px;
                width: 70%;
                position: absolute;
                left: 15%;
                top: 10%;
                background: #fff;
            }

            .tc-box-close {
                position: absolute;
                width: 20px;
                height: 20px;
                text-align: center;
                line-height: 20px;
                right: 10px;
                background: #8e8e8e;
                top: 10px;
                color: #fff;
                border-radius: 100%;
                cursor: hand;
            }

            .confirm {
                width: 100%;
                height: 100%;
                z-index: 999;
                position: fixed;
                top: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background: rgba(0, 0, 0, .5);
            }

            .confirm > div {
                background: #fff;
                width: 460px;
                height: 223px;
            }

            .confirm_tips {
                text-align: center;
                height: 150px;
                line-height: 150px;
                font-size: 16px;
                font-family: MicrosoftYaHei;
                font-weight: 400;
                color: rgba(65, 70, 88, 1);
            }

            .confirm_btn > button {
                width: 112px;
                height: 36px;
                line-height: 36px;
                border: 1px solid #2890FF;
                border-radius: 2px;
                color: #2890FF;
            }

            .confirm_btn {
                display: flex;
                justify-content: space-around;
                width: 60%;
                margin-left: 20%;
                text-align: center;
            }

            .hide {
                display: none;
            }

            .qh {
                width: 112px !important;
                height: 42px !important;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box !important;
                border: unset !important;
            }

            .border-right {
                border-right: 1px solid #ddd !important;
            }
        </style>
    {/literal}
    <title>拼团活动管理</title>
</head>
<body style='display: none;'>
<nav class="breadcrumb" style="font-size: 16px;"><span class="c-gray en"></span><i class="Hui-iconfont">&#xe67f;</i>
    拼团列表
    <span class="c-gray en">&gt;</span>拼团
    {if $type=='record'}
        <span class="c-gray en">&gt;</span>
        开团记录列表
    {elseif $type=='canrecord'}
        <span class="c-gray en">&gt;</span>
        参团记录列表
    {else}
        <span class="c-gray en">&gt;</span>
        拼团活动列表
    {/if}

    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container pd-20 page_absolute">
    <div style="display: flex;flex-direction: row;font-size: 16px;" class="page_bgcolor">
        <div class="status qh {if $status==0}isclick{/if} border-right"
             style="border-radius: 2px 0px 0px 2px !important;"><a
                    href="index.php?module=go_group&action=Index&status=0" onclick="statusclick(0)">拼团活动</a></div>
        <div class="status qh {if $status==4}isclick{/if} border-right"><a
                    href="index.php?module=go_group&action=Index&status=4" onclick="statusclick(4)">开团记录</a></div>
        <div class="status qh {if $status==5}isclick{/if} border-right"><a
                    href="index.php?module=go_group&action=Index&status=5" onclick="statusclick(5)">参团记录</a></div>
        <div class="status qh {if $status==6}isclick{/if}" style="border-radius: 0px 2px 2px 0px !important;"><a
                    href="index.php?module=go_group&action=Config" onclick="statusclick(5)">拼团设置</a></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        {if $type=='record' || $type=='canrecord'}
            <form name="form1" action="index.php" method="get" style="display: flex;">
                <input type="hidden" name="module" value="go_group"/>
                <input type="text" name="proname" size='8' value="{$proname}" id="" placeholder="请输入商品名称"
                       style="width:200px" class="input-text">
                <input type="text" name="username" size='8' value="{$username}" id="" placeholder="请输入会员名称"
                       style="width:200px" class="input-text">

                {if $type=='record'}
                    <select style="width: 200px;margin-right: 5px;" name="group_status" class="sel_status">
                        <option value="#">请选择拼团状态</option>
                        <option value="1" {if $group_status=='1'}selected{/if}>进行中</option>
                        <option value="2" {if $group_status=='2'}selected{/if}>已完成</option>
                        <option value="3" {if $group_status=='3'}selected{/if}>失败</option>
                    </select>
                    <select style="width: 200px;margin-right: 5px;" name="group_num" class="sel_status" id="group_num">
                        <option value="#">请选择拼团类型</option>
                        {foreach from=$man_arr item=item}
                        <option value="{$item}" {if $group_num== $item}selected{/if}>{$item}人团</option>
                        {/foreach}
                    </select>

                    <input type="hidden" name="status" value="4"/>

                {else}
                    <input type="hidden" name="status" value="5"/>
                {/if}
                <input type="button" value="重置" id="btn8"
                       style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset"
                       onclick="empty()"/>

                <input name="" id="" class="btn btn-success buttom_hover" type="submit" value="查询">
                {if $type=='record'}
                <input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="    position: absolute;right: 20px;border-radius: 4px;">
                {/if}

            </form>
        {else}
            <form name="form1" action="index.php" method="get" style="display: flex;align-items: center;">
                <input type="hidden" name="module" value="go_group"/>
                <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize"/>
                <input type="text" name="proname" size='8' value="{$proname}" id="" placeholder="请输入商品名称"
                       style="width:200px" class="input-text" autocomplete="off">
                <select style="background: #fff;width:200px;" class="sel_status" name="gstatus">
                    <option value="">请选择活动状态</option>
                    <option value="2" {if $gstatus=='2'}selected{/if}>进行中</option>
                    <option value="1" {if $gstatus=='1'}selected{/if}>未开始</option>
                    <option value="3" {if $gstatus=='3'}selected{/if}>结束</option>
                </select>
                <input name="" id="" class="btn" onclick="empty()" type="button" value="重置" style="margin-left: 8px;">
                <input name="" id="" class="btn btn-success" type="submit" value="查询">
                {*                <input type="button" id="btn2" value="导出" class="btn btn-success" onclick="excel('all')">*}
            </form>
        {/if}
    </div>
    <div class="page_bgcolor page_t">
        {if $type == 'record' || $type == 'canrecord'}

        {else}
            <div class="page_h16"></div>
            <a class="btn newBtn radius" href="index.php?module=go_group&action=Addproduct">
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/add.png"/>&nbsp;添加拼团
                </div>
            </a>
            <a class="btn newBtn radius" style="background: #fff !important;" onclick="del_all()">
                <div style="height: 100%;display: flex;align-items: center;color: #6A7076;">
                    <img src="images/icon1/del.png"/>&nbsp;批量删除
                </div>
            </a>
        {/if}
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table-border tab_content">
            {if $type=='record'}
                <thead>
                <tr class="text-c tab_tr">
                    <th style="width: 70px;">
                        序号
                    </th>
                    <th style="width:120px;">活动名称</th>
                    <th style="width:160px;">商品名称</th>
                    <th style="width:5%;">拼团类型</th>
                    <th>零售价</th>
                    <th>团长价格</th>
                    <th>参团价格</th>
                    <th>活动有效时间</th>
                    <th style="width: 60px !important;">创建人</th>
                    <th style="width: 60px !important;">拼团状态</th>
                    <th style="width: 80px;">开团时间</th>
                    <th style="width: 100px !important;">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$list item=item}
                    <tr class="text-c tab_td">
                        <td>
                            {$item->id}
                        </td>
                        <td>
                            <div title=" {$item->group_title}"
                                 style="height: 60px; overflow: hidden;white-space: nowrap;text-overflow: ellipsis;width:120px;line-height: 60px;">
                                {$item->group_title}
                            </div>
                        </td>
                        <td style="display: flex;align-items: center;border: none;">
                            <div style="width: 60px;height: 60px;">
                                {if $item->imgurl != ''}
                                    <img onclick="pimg(this)" style="width: 60px;height: 60px;" src="{$item->imgurl}">
                                {else}
                                    <span>暂无图片</span>
                                {/if}
                            </div>
                            <div title="{$item->p_name}"
                                 style="height: 60px; overflow: hidden;white-space: nowrap;text-overflow: ellipsis;width:120px;line-height: 60px;">
                                {$item->p_name}
                            </div>
                        </td>
                        <td>
                            {$item->groupman}人团
                        </td>
                        <td>￥{$item->price} </td>
                        <td>￥{$item->openmoney} </td>
                        <td>￥{$item->canmoney} </td>
                        <td>
                            开始时间：{$item->start_time}
                            <br/>
                            结束时间：{$item->end_time}
                        </td>
                        <td>{$item->user_name}</td>
                        <td>
                            {if $item->ptstatus==1}
                                <span style="color: orange;">拼团中</span>
                            {elseif $item->ptstatus==3}
                                <span style="color: red;">失败</span>
                            {elseif $item->ptstatus==2}
                                <span style="color: green">成功</span>
                            {/if}
                        </td>
                        <td style="text-align: center;">
                            {$item->add_time}
                        </td>
                        <td class="tab_editor">
{*                            <a href="#" onclick="canprecord('{$item->ptcode}')" style="width: 80%;">查看详情</a>*}
                            <a href="index.php?module=go_group&action=Canrecord&ptcode={$item->ptcode}" style="width: 80%;">查看详情</a>

                        </td>
                    </tr>
                {/foreach}
                </tbody>
            {elseif $type=='canrecord'}
                <thead>
                <tr class="text-c tab_tr">
                    <th>
                        序号
                    </th>
                    <th style="width:15%;">拼团活动名称</th>
                    <th style="width:15%;">商品名称</th>
                    <th style="width:15%;">拼团类型</th>
                    <th>零售价</th>
                    <th>参团价格</th>
                    <th style="width:8%;">会员名称</th>
                    <th>拼团有效时间</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$list item=item}
                    <tr class="text-c tab_td">
                        <td>
                            {$item->id}
                        </td>
                        <td style="padding: 0 10px;">
                            <div>
                                {$item->group_title}
                            </div>
                        </td>
                        <td style="padding: 0 20px;">
                            <div style="display: flex;align-items: center;border: none;">
                                <div style="width: 60px;height: 60px;">
                                    {if $item->imgurl != ''}
                                        <img onclick="pimg(this)" style="width: 60px;height: 60px;"
                                             src="{$item->imgurl}">
                                    {else}
                                        <span>暂无图片</span>
                                    {/if}
                                </div>
                                <div title="{$item->product_title}"
                                     style="height: 60px; overflow: hidden;white-space: nowrap;text-overflow: ellipsis;width:160px;line-height: 60px;">
                                    {$item->p_name}
                                </div>
                            </div>
                        </td>
                        <td> {$item->groupman}人团</td>
                        <td>￥{$item->price} </td>
                        <td>￥{$item->canmoney}</td>
                        <td>{$item->user_name}</td>
                        <td>
                            <div>开团时间：{$item->add_time}</div>
                            <div>结束时间：{$item->pt_end_time}</div>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            {else}
                <thead>
                <tr class="text-c tab_tr">
                    <th style="width: 30px">
                        <div style="height: 100%;height: 100%;display: flex;justify-content: center;align-items: center;">
                            <input type="checkbox" class="inputC input_agreement_protocol" id="ipt1" name="ipt1"
                                   value="">
                            <label for="ipt1"></label>
                        </div>
                    </th>
                    <th style="width:20%;">拼团活动名称</th>
                    <th style="width:20%;">商品名称</th>
                    <th style="">零售价</th>
                    <th style="">拼团价格</th>
                    <th style="width: 80px;">库存</th>
                    <th style="width:15%;">活动时间</th>
                    <th style="width: 30px;">是否显示</th>
                    <th style="width: 80px;">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$list item=item}
                    <tr class="text-c tab_td">
                        <td>
                            <input type="checkbox" class="inputC input_agreement_protocol"
                                   id="{$item->product_id}-{$item->activity_no}-{$item->g_status}" name="id[]"
                                   value="{$item->product_id}" data-g_status="{$item->g_status}"
                                   style="position: absolute;" onclick="onshelves()">
                            <label for="{$item->product_id}-{$item->activity_no}-{$item->g_status}"></label>
                        </td>
                        <td>
                            <div style="text-align: left;">
                                {$item->group_title}
                            </div>
                            <div style="display: flex;padding: 0 10px;">
                                {if $item->g_status==1}
                                    <span style="color: orange;">未开始</span>
                                {elseif $item->g_status==2}
                                    <span style="color: green;">进行中</span>
                                {else}
                                    <span style="color: red;">已结束</span>
                                {/if}
                            </div>
                        </td>

                        <td style="display: flex;align-items: center;border: none;">
                            <div style="width: 60px;height: 60px;">
                                {if $item->imgurl != ''}
                                    <img onclick="pimg(this)" style="width: 60px;height: 60px;" src="{$item->imgurl}">
                                {else}
                                    <span>暂无图片</span>
                                {/if}
                            </div>
                            <div title="{$item->product_title}"
                                 style="height: 60px; overflow: hidden;text-align:left;padding-left: 10px;white-space: nowrap;text-overflow: ellipsis;width: 200px;line-height: 60px;">
                                {$item->product_title}
                            </div>
                        </td>
                        <td>
                            {$item->price}元
                        </td>
                        <td>
                            <p style="margin: 0 !important;">{$item->min_man}人团</p>
                            <p style="margin: 0 !important;">{$item->min_price}元</p>
                        </td>
                        <td>{$item->num}</td>
                        <td>{$item->actime}</td>
                        <td style="text-align: center;">
                            {if $item->is_show==0}
                                <span>否</span>
                            {else}
                                <span>是</span>
                            {/if}
                        </td>

                        <td class="tab_editor">
                            <div class="tab_block">
                                <div style="display: flex; ">
                                    {if $item->g_status==3}
                                        <button type="button" disabled="true" title="编辑">
                                            <div style="align-items: center;font-size: 12px;display: flex;justify-content: center;">
                                                <img src="images/icon1/ck.png"/>&nbsp;编辑
                                            </div>
                                        </button>
                                    {else}
                                        <a href="index.php?module=go_group&action=Modify&id={$item->product_id}&activity_no={$item->activity_no}"
                                           title="{if $item->g_status==2&&$item->is_show==1}查看{else}编辑{/if}">
                                            <img src="images/icon1/ck.png"/>&nbsp;{if $item->g_status==2&&$item->is_show==1}查看{else}编辑{/if}
                                        </a>
                                    {/if}
                                    {if $item->is_show==0}
                                        <a onclick="aj('{$item->product_id}','1','{$item->activity_no}')"
                                           href="javascript:void(0);" title="显示">
                                            <img src="images/icon1/xj.png"/>&nbsp;显示
                                        </a>
                                    {else}
                                        <a onclick="aj('{$item->product_id}','0','{$item->activity_no}')"
                                           href="jdisplay: flex;align-items: center;avascript:void(0);" title="隐藏">
                                            <img src="images/icon1/sj_g.png"/>&nbsp;隐藏
                                        </a>
                                    {/if}
                                    <a onclick="go_details('{$item->product_title}','{$item->activity_no}')" href="javascript:void(0);"
                                       title="详情">
                                        <img src="images/icon1/shenhe_success.png"/>&nbsp;详情
                                    </a>
                                </div>
                                <div style="display: flex; ">
                                    {if $item->g_status==1||$item->g_status==3}
                                        {if $item->g_status==1 && $item->no_have==1}
                                            {*不能开始*}
                                            <a onclick="aj1({$item->product_id},'2','{$item->starttime}','{$item->endtime}','{$item->status}','{$item->activity_no}','{$item->is_copy}')"
                                               href="javascript:void(0);" title="开始">
                                                <img src="images/icon1/xj.png"/>&nbsp;开始
                                            </a>
                                        {else}
                                            {*能开始*}
                                            <button type="button" disabled="true" title="开始">
                                                <div style="align-items: center;font-size: 12px;display: flex;justify-content: center;">
                                                    <img src="images/icon1/xj.png"/>&nbsp;开始
                                                </div>
                                            </button>
                                        {/if}
                                    {else}
                                        <a onclick="aj1({$item->product_id},'3','{$item->starttime}','{$item->endtime}','{$item->status}','{$item->activity_no}')"
                                           href="javascript:void(0);" title="停止">
                                            <img src="images/icon1/sj_g.png"/>&nbsp;停止
                                        </a>
                                    {/if}
                                    {if $item->g_status!=2}
                                        <a title="删除" href="javascript:;"
                                           onclick="delgrouppro1(this,{$item->product_id},'index.php?module=go_group&action=Member&m=delpro&activity_no={$item->activity_no}&id=')"
                                           class="ml-5" data-g_status="{$item->g_status}">
                                            <img src="images/icon1/del.png"/>&nbsp;删除
                                        </a>
                                    {else}
                                        <button type="button" disabled="true">
                                            <div style="align-items: center;font-size: 12px;display: flex;justify-content: center;">
                                                <img src="images/icon1/del.png"/>&nbsp;删除
                                            </div>
                                        </button>
                                    {/if}
                                    <a onclick="go_copy('{$item->activity_no}')" href="javascript:void(0);" title="复制">
                                        <img src="images/icon1/jfcz.png"/>&nbsp;复制
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            {/if}
        </table>
    </div>
    <div class='tb-tab' style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
<div class="confirm hide">
    <div>
        <div class="confirm_tips">是否删除这个拼团</div>
        <div class="confirm_btn">
            <button class="confirm_cancel" style="background: #fff;">取消</button>
            <button class="confirm_confirm" style="background: #2890FF;color: #fff;">确认</button>
        </div>
    </div>
</div>
<div class="tc-box" style="z-index: 999999999">
    <div id="ifm-box">
        <div class="tc-box-close">x</div>
        <iframe id="ifm" scrolling="yes" src="" height="100%" width="100%"></iframe>
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="style/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="style/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/js/H-ui.js"></script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>
{literal}
    <script type="text/javascript">
        $(function () {
            $('body').show();
        })

        // 根据框架可视高度,减去现有元素高度,得出表格高度
        if ($('.isclick').text() == '拼团活动') {
            var Vheight = $(window).height() - 56 - 42 - 16 - 56 - 52 - 16 - ($('.tb-tab').text() ? 70 : 0)
            $('.table-scroll').css('height', Vheight + 'px')
        } else {
            var Vheight = $(window).height() - 56 - 42 - 16 - 56 - 16 - ($('.tb-tab').text() ? 70 : 0)
            $('.table-scroll').css('height', Vheight + 'px')
        }

        function excel(pageto) {
            var pagesize = $("#pagesize").val();
            location.href = location.href + '&pageto=' + pageto + '&pagesize=' + pagesize;
        }

        // 删除活动商品
        function delgrouppro1(ev, id, url) {
            var g_status = $(ev).attr('data-g_status');
            if (g_status == '2') {
                layer.msg('正在活动中的产品无法删除!');
                return false;
            }
            console.log(url);
            confirm('确认要删除吗？', id, url, '删除');
        }

        //删除选择
        function del_all(ev) {
            var idstr = '';
            var can_del = true;
            $("input:checkbox[name='id[]']:checked").each(function (index) {
                var id = $(this).attr("id");
                let arr = id.split('-');
                if (arr[2] == '2') {
                    console.log('状态：' + arr[2]);
                    can_del = false

                } else {
                    idstr = idstr + arr[1] + ','
                }
                console.log(index);
            });
            if(!can_del){
                layer.msg('正在活动中的产品无法删除!');
                return false;
            }
            if(idstr == ""){
                layer.msg("请选择拼团活动！")
                return  false;
            }
            idstr = idstr.substr(0, idstr.length - 1);
            console.log('所选id：' + idstr);
            var url = "index.php?module=go_group&action=Member&m=del_all_pro&id=";
            confirm('是否删除所选拼团活动？', idstr, url, '删除');
            return false;
        }
        //跳转详情页面
        function go_details(name,activity_no) {

            location.href = 'index.php?module=go_group&status=4&proname=' + name+'&activity_no='+activity_no;

        }
        //复制
        function go_copy(activity_no) {
            console.log("go_copy");

            $.ajax({
                type: "post",
                url: 'index.php?module=go_group&action=Member&m=copy&activity_no=' + activity_no,
                async: true,
                success: function (res) {
                    var ress = JSON.parse(res);
                    if (ress.status === 1) {
                        layer.msg("复制完成！");
                        location.href = 'index.php?module=go_group&action=Modify&id='+ress.id+'&activity_no='+ress.activity_no;
                    } else {
                        layer.msg("复制失败！");
                    }
                },
            });

        }

        function empty() {

            $(".sel_status").val('');
            $("input[name='proname']").val('');
            $("input[name='username']").val('');
            $("#group_num").val('#');
        }

        function statusclick(d) {
            $('.status').each(function (i) {
                if (d == i) {
                    $(this).addClass('isclick');
                } else {
                    $(this).removeClass('isclick');
                }
            })
        }

        /*批量删除*/
        function datadel(url, content) {
            var checkbox = $("input[name='id[]']:checked");//被选中的复选框对象
            var Id = '';
            for (var i = 0; i < checkbox.length; i++) {
                var g_status = checkbox.eq(i).attr('data-g_status');
                if (g_status == '2') {
                    layer.msg('正在活动中的产品无法删除!');
                    return false;
                }
                Id += checkbox.eq(i).val() + ",";
            }
            if (Id == "") {
                layer.msg("未选择数据！");
                return false;
            }
            confirm('确认要删除吗？', Id, url, content)

        }

        //显示隐藏拼团活动
        function aj(id, type, activity_no) {
            var text = '';
            var type_ = '';
            if (type == 1) {
                text = '是否显示所选拼团活动？'
                type_ = '显示';
            } else {
                text = '是否隐藏所选拼团活动？'
                type_ = '隐藏';
            }
            var url = 'index.php?module=go_group&action=Member&m=contpro&activity_no=' + activity_no + '&type=' + type + '&id=';
            confirm_aj(text, id, url, type_);
            return false;
        }

        //隐藏显示功能选择弹窗
        function confirm_aj(content, id, url, content1) {
            console.log(url)
            $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="padding-top:0px;height: 223px !important;">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="font-size: 16px;text-align: center;padding:60px 0;">
                    ${content}
                </div>
                <div style="text-align:center;">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask('${id}','${url}','${content1}')>确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
        }

      //弹窗
        function confirm(content, id, url, content1) {
            $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="padding-top:0px;height: 223px !important;">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="font-size: 16px;text-align: center;padding:60px 0;">
                    ${content}
                </div>
                <div style="text-align:center;">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask('${id}','${url}','${content1}')>确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
        }

        //开始活动
        function aj1(id, type, start, end, status, activity_no, is_copy) {
            if (type == '2') {
                var startdate = new Date(start).getTime();
                var enddate = new Date(end).getTime();
                var now = new Date().getTime();
                if (status == '1') {
                    layer.msg("商品下架，无法开启!");
                    return false;
                }
                if (is_copy == '1') {
                    layer.msg("复制活动不能手动开启！");
                    return false;
                }
            }
            var text = '';
            var type_ = '';
            if (type == '2') {
                //开始
                text = '是否开始所选拼团活动？';
                type_ = '开始';
            } else if (type == '3') {
                //结束
                text = '是否结束所选拼团活动？';
                type_ = '结束';
            }

            var url = 'index.php?module=go_group&action=Member&m=is_market&activity_no=' + activity_no + '&type=' + type + '&id=';
            confirm_aj(text,id,url,type_);
            console.log(url);

        }

        /*批量操作*/
        function operation(url) {
            var checkbox = $("input[name='id[]']:checked");//被选中的复选框对象
            var Id = '';
            for (var i = 0; i < checkbox.length; i++) {
                Id += checkbox.eq(i).val() + ",";
            }
            if (Id == "") {
                layer.msg("未选择数据！");
                return false;
            }
            var btn_up = $(".btn_up span").text();
            if (btn_up == "商品上架") {
                nums = 'up';
            } else {
                nums = 'down';
            }
            confirm2("确认修改吗？", Id, url, nums);
        }

        //开启弹窗
        function confirm2(content, id, url, nums) {
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMaskba('${id}','${url}','${nums}') >确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
        }
        //关闭弹窗
        function closeMaskba(id, url, nums) {
            $.ajax({
                type: "post",
                url: url + id + '&type=' + nums,
                async: true,
                success: function (res) {
                    $(".maskNew").remove();

                    res = JSON.parse(res);
                    if (res.status == "1") {
                        layer.msg("修改成功！");
                        location.replace(location.href);
                    } else {
                        layer.msg("修改失败！");
                    }
                },
            });
        }
        //关闭弹窗
        function closeMask1() {
            $(".maskNew").remove();
        }

        function onshelves() {
            console.log("onshelves");
            var checkbox = $("input[name='id[]']:checked");//被选中的复选框对象

            var check_text = checkbox.parents(".tab_label").siblings(".tan_status");

            $("input:checkbox[name='id[]']").each(function (index) {

            });
            var allCheckNum = $("input:checkbox[name='id[]']").length;
            var checkedNum = $("input:checkbox[name='id[]']:checked").length;
            if (allCheckNum == checkedNum) {
                $("#ipt1").attr("checked",true);
            }

            if (checkbox.length == 0) {
                $(".btn_up span").text("商品上架")
            } else {
                for (var j = 0; j < check_text.length; j++) {
                    var ts = check_text.eq(j).text();
                    ts = ts.trim();
                    if (ts == "上架") {
                        $(".btn_up span").text("商品下架")
                    } else {
                        $(".btn_up span").text("商品上架")
                    }

                }
            }

        }

        $(".btn_sty").click(function () {
            // alert(1);
            $(".btn_sty").removeClass('sel_btn');
            $(this).addClass('sel_btn');
        })


        function canprecord(ptcode) {
            $("#ifm").attr("src", "index.php?module=go_group&action=Canrecord&ptcode=" + ptcode);
            $(".tc-box").show();
        }

        $(".tc-box").click(function () {
            $(".tc-box").hide();
        })
    </script>
{/literal}
</body>
</html>