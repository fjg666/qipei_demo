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

    <title>活动列表</title>
   
</head>
<body>
<nav class="breadcrumb page_bgcolor">
                    <span class="c-gray en"></span>
                    <span  style='color: #414658;'>授权管理</span>
                    <span  class="c-gray en">&gt;</span>
                    <span  style='color: #414658;'>发布管理</span>
            
</nav>
<div class="pd-20 page_absolute">
    <div class="text-c">
        <form name="form1" action="index.php" method="get" class="pd_form1">
            <input type="hidden" name="module" value="third"/>
            <input type="hidden" name="action" value="Review">
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
           
            <select name="status" class="select query_select" >

                <option value="">请选择审核状态</option>
                <option value="0" {if $status === '0'}selected="selected"{/if}>审核成功</option>
                <option value="1" {if $status == 1}selected="selected"{/if}>审核失败</option>
                <option value="2" {if $status == 2}selected="selected"{/if}>审核中</option>
                <option value="4" {if $status == 4}selected="selected"{/if}>未审核</option>
            
           </select>

           <select name="issue_mark" class="select query_select">
           		<option value="">请选择发布状态</option>
           		<option value="1" {if $issue_mark == 1}selected="selected" {/if}>未发布</option>
           		<option value="2" {if $issue_mark == 2}selected="selected" {/if}>发布失败</option>
           		<option value="3" {if $issue_mark == 3}selected="selected" {/if}>发布成功</option>           	
           </select>
           <input type="text" name="nick_name" size='8' value="{$nick_name}" id="" placeholder=" 小程序名称" class="input-text query_inputs">
           <input name="" id="btn1" class="query_cont nmor" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt_20 table-scroll">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr">
                            <th class="tab_title">ID</th>
                            <th class="tab_title">小程序名称</th>
                            <th class="tab_imgurl">小程序头像</th>
                            <th class="tab_title">所属商户</th>
                          	<th class="tab_title">提交时间</th>
                            <th class="tab_title">审核转态</th>
                          	<th class="tab_title">发布转态</th>
                            <th class="tab_editor">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$res item=item}

                        <tr class="text-c tab_td">
                           
                            
                            <td class="tab_title" style="text-align:center!important;">{$item->id}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->nick_name}</td>
                            <td class="tab_imgurl"><img src="{$item->head_img}" style="width: 60px;height:60px;"/></td>
                            <td class="tab_title" style="text-align: center!important;">{$item->name}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->submit_time}</td>
                            <td class="tab title" style="text-align: center!important;">
                            	{if $item->status === 0}
                            	<span style="color:green;">审核成功</span>
                            	{elseif $item->status == 1}
                            	<span style="color: red;">审核失败</span>
                            	{elseif $item->status == 2}
                            	<span style="color: orange;">审核中</span>
                            	{else}
                            	<span >未审核</span>
                            	{/if}
                            </td>
                            <td class="tab_title" style="text-align: center!important;">
                            	{if $item->issue_mark == 1}
                            	<span>未发布</span>
                            	{elseif $item->issue_mark == 2}
                            	<span style="color: red;">发布失败</span>
                            	{elseif $item->issue_mark == 3}
                            	<span style="color:green;">发布成功</span>
                            	{/if}
                            </td>
                            <td class="tab_editor">
                             
                               <a style="text-decoration:none;{if $item->status !== 0 || $tiem->issue_mark == 3}pointer-events: none;opacity: 0.5{/if}"   class="ml-7" onclick="my_sub({$item->auditid})" title="发布" >
                                    <img src="images/icon1/xg.png"/>&nbsp;发布
                               </a> 
                             
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
    </div>
    <div class="tbtab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>

{literal}

<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-16-($('.tbtab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')

	function my_sub(auditid){
		$.ajax({
			type:"POST",
			dataType:"JSON",
			url:'index.php?module=third&action=Review',
			data:{auditid:auditid},
			success:function(data){
				if(data.suc == 1){
					 layer.msg(data.msg,{time:2000});
				}else{

					layer.msg(data.msg,{time:2000});
				}
			}
		});
	}
</script>
{/literal}
</body>
</html>