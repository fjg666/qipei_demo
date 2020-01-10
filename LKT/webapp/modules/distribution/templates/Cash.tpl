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
    <link href="style/css/style.css?v=1" rel="stylesheet" type="text/css"/>
    <title>提现记录</title>
    {literal}
        <style>
            .swivch_bot a{
                width: 111px!important;
                height: 42px!important;
                padding: 0!important;
                border: none!important;
                border-right: 1px solid #ddd!important;
            }
            body {
                font-size: 16px;
            }
            .dataTables_wrapper .dataTables_length {
                bottom: 13px;
            }

            ._ul {
                padding: 0 8px;
            }

            ._li {
                float: left;
                width: 99px;
                padding: 8px 0
            }

            ._ul_li {
                border-right: 1px solid #eee;
            }

            .text_ggg > th, .text_ggg > td {
                border-right: 1px solid #eee;
            }

            ._ul:after {
                display: block;
                content: "";
                clear: both;
            }
        </style>
        <style type="text/css">
            .btn1 {
                padding: 0px 10px;
                height: 40px;
                line-height: 40px;
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
                background-color: #2481e5!important;
                color: #fff;
            }

            td a {
                width: 44%;
                float: left;
                margin: 2% !important;
            }
        </style>
    {/literal}
</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>插件管理</span>
	<span class='nav-to' onclick="location.href='index.php?module=distribution&amp;action=Index';"><span class="arrows">&gt;</span>分销商管理</span>
	<span><span>&gt;</span>提现记录</span>
</nav>
<div class="iframe-content">
    <div class="navigation">
        <div>
    		<a href="index.php?module=distribution">分销商管理</a>
    	</div>
    	<p class='border'></p>
        <div>
    		<a href="index.php?module=distribution&action=Distribution_grade">分销等级</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Commission">佣金记录</a>
    	</div>
    	<p class='border'></p>
    	<div class='active'>
    		<a href="index.php?module=distribution&action=Cash" class="swivch_active">提现记录</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Distribution_config">分销设置</a>
    	</div>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 text-c">
        <form name="form1" action="index.php?module=distribution" method="get">
            <input type="hidden" name="module" value="distribution" />
            <input type="hidden" name="action" value="Cash" />
            <input type="text" class="input-text" style="width:150px" placeholder="请输入分销商名称/手机号码" id="name" name="name" value="{$name}">
            <input type="text" class="input-text" style="width:150px" placeholder="请输入持卡人姓名" id="mobile" name="mobile" value="{$mobile}">
            <select name="source" id="source" class="select" style="width: 120px;vertical-align: middle;background-color: rgb(255, 255, 255);">
                <option value="" selected>请选择审核状态</option>
                <option value="1" {if $source==1}selected{/if}>待审核</option>
                <option value="2" {if $source==2}selected{/if}>审核通过</option>
                <option value="3" {if $source==3}selected{/if}>已拒绝</option>
            </select>

            <div style="position: relative;display: inline-block;">
                <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
            </div>至
            <div style="position: relative;display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
            </div>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

            <input type="submit" id="btn1" class="btn btn-success" value="查 询">

            <input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float:right;">
        </form>
    </div>
    
    <div class="page_h16"></div>
    <div class="iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th style="width: 30px;">分销商ID</th>
                    <th >分销商名称</th>
                    <th >手机号码</th>
                    <th >提现金额</th>
                    <th >提现手续费</th>
                    <th >持卡人姓名</th>
                    <th >银行名称</th>
                    <th >支行名称</th>
                    <th >银行卡号</th>
                    <th >状态</th>
                    <th >提现时间</th>
                    <th >操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item=item name=f1}
                    <tr class="text-c tab_td">
                        <td>{$item->user_id}</td>
                        <td>{$item->name}</td>
                        <td>{$item->mobile}</td>
                        <td>{$item->money}元</td>
                        <td>{$item->s_charge}元</td>
                        <td>{$item->Cardholder}</td>
                        <td>{$item->Bank_name}</td>
                        <td>{$item->branch}</td>
                        <td>{$item->Bank_card_number}</td>
                        <td>{if $item->status == 0}<span style="color: #ff2a1f;">待审核</span>{elseif $item->status == 1}<span style="color: #30c02d;">审核通过</span>{else}<span style="color: #7A7A7A;">已拒绝</span>{/if}</td>
                        <td>{$item->add_date}</td>
                        <td style="width: 150px;">
                            {if $button == 1 && $item->status==0}
                                <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="examine(this,1,'{$item->id}','{$item->user_id}','{$item->money}','{$item->s_charge}','index.php?module=distribution&action=Cash_del')" >
                                    <div style="align-items: center;font-size: 12px;display: flex;">
                                        <div style="margin:0 auto;;display: flex;align-items: center;">
                                        <img src="images/icon1/sx.png"/>&nbsp;通过
                                        </div>
                                    </div>
                                </a>
                                <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="examine(this,2,'{$item->id}','{$item->user_id}','{$item->money}','{$item->s_charge}','index.php?module=distribution&action=Cash_del')" >
                                    <div style="align-items: center;font-size: 12px;display: flex;">
                                        <div style="margin:0 auto;;display: flex;align-items: center;">
                                        <img src="images/icon1/jy.png"/>&nbsp;拒绝
                                        </div>
                                    </div>
                                </a>
                            {/if}
                            {if $item->status == 1}<span style="color: #30c02d;">审核通过</span>{elseif $item->status == 2}<span style="color: #7A7A7A;">已拒绝</span>{/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div>{$pages_show}</div>
</div>

<script type="text/javascript" src="style/js/Popup.js"></script>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>

{literal}
    <script type="text/javascript">
		
        laydate.render({
            elem: '#startdate', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#enddate',
            type: 'datetime'
        });
        function excel(pageto) {
            location.href=location.href+'&pageto='+pageto;
        }
        function empty() {
            $("#name").val('');
            $("#mobile").val('');
            $("#source").val('');
            $("#startdate").val('');
            $("#enddate").val('');
        }
        function examine(obj,m,id,user_id,money,s_charge,url) {

            if(m == 1){
                confirm("确定要通过该用户的申请？",m,id,user_id,money,s_charge,url);
            }else{
                confirm1("请输入拒绝原因",m,id,user_id,money,s_charge,url);
            }
        }
        function confirm (content,m,id,user_id,money,s_charge,url){
            $("body",parent.document).append(`
                <div class="maskNew">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div class="maskContent" style="top: 50px;">
                            ${content}
                        </div>
                        <div class="maskbtn">
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask4('${m}','${id}','${user_id}','${money}','${s_charge}','${url}') >确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        }
        function confirm1 (content,m,id,user_id,money,s_charge,url){
            $("body",parent.document).append(`
                <div class="maskNew">
                    <div class="maskNewContent">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle">提示</div>
                        <div class="maskContent" style="top: 35px;">
                            ${content}
                        </div>
                        <div style='text-align: center;padding-top: 30px'>
                            <input style='border:1px solid #666;height:30px;line-height: 30px' type="text" placehold='请输入拒绝原因' name='jujue'>
                        </div>
                        <div style="text-align:center;margin-top:15px">
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask4_1('${m}','${id}','${user_id}','${money}','${s_charge}','${url}') >确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        }
    </script>
{/literal}
</body>
</html>


