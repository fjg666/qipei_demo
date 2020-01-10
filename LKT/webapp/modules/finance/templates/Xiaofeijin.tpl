
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<link href="//at.alicdn.com/t/font_353057_iozwthlolt.css" rel="stylesheet">
		<link href="style/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/css/jquery.datetimepicker.min.css" rel="stylesheet">
		<link href="style/css/flex.css" rel="stylesheet">
		<link href="style/css/common.css" rel="stylesheet">
		<link href="style/css/common.v2.css" rel="stylesheet">

		<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
		<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
		<link href="style/css/style.css" rel="stylesheet" type="text/css" />
		<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />

<title>财务管理</title>
{literal}
<style type="text/css">
	.table-bordered th, .table-bordered td{
		border-right: none;
		border-top: none;
	}
</style>
{/literal}

</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe63a;</i> 财务管理 <span class="c-gray en">&gt;</span> 消费金列表 <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="pd-20">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Xiaofeijin" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Xiaofeijin" />
			<div>
			<select name="otype" class="select" style="width: 150px;height: 31px;vertical-align: middle;">
						<option value="all" >类型</option>
						<option value="1" >转入（收入）消费金</option>
						<option value="2" >提现</option>
						<option value="4" >使用消费金</option>
						<option value="5" >收入消费金</option>
						<option value="6" >系统扣款</option>
						<option value="7" >消费金解封</option>
			</select>
	        <input type="text" class="input-text" style="width:150px" placeholder="用户ID" name="name" value="{$name}">
				<span style="margin-left: 10px;">开始时间:</span>
				<input type="text" class="input-text" value="{$starttime}" placeholder="" id="group_start_time" name="starttime" style="width:150px;margin-left: 10px;">
				<span style="margin-left: 10px;">结束时间:</span>
				<input type="text" class="input-text" value="{$group_end_time}" placeholder="" id="group_end_time" name="group_end_time" style="width:150px;margin-left: 10px;">

	        <input type="submit" class="btn btn-success" value="查 询">
	        <input type="button" value="导出" class="btn btn-success" onclick="export_popup(location.href)">
			</div>
			
		</form>
		

    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                	<!-- <th style="width: 5%;height: 40px;">序</th> -->
		            <th style="width: 5%;height: 40px;">用户ID</th>
		            <th style="width: 15%;height: 40px;">用户名</th>
		            <th style="width: 10%;height: 40px;">来源的用户</th>
		            <th style="width: 15%;height: 40px;">手机号码</th>
		            <th style="width: 10%;height: 40px;">会员等级</th>
		            <th style="width: 10%;height: 40px;">充值金额</th>
		            <th style="width: 15%;height: 40px;">充值时间</th>

		            <th style="width: 10%;height: 40px;">充值方式</th>

		            <th style="width: 5%;height: 40px;">操作</th>
		        </tr>
            </thead>
            <tbody>
	            {foreach from=$list item=item name=f1}
	                <tr class="text-c">
	                    <td>{$item->user_id}</td>
	                    <td>{$item->user_name}</td>
	                    <td>{$item->name}</td>
	                     <td>{$item->mobile}</td>
	                     <td>{$item->typename}</td>
	         			<td>
							{if $item->type ==5 ||$item->type ==11 ||$item->type ==12 || $item->type == 13}+{$item->money}{/if}
							{if $item->type ==4 ||$item->type ==6 ||$item->type ==7 ||$item->type ==10 || $item->type == 14}-{$item->money}{/if}
	         			</td>
	                    <td>{$item->add_date}</td>
	                    <td>
							{if $item->type == 4 }使用消费金{/if}
							{if $item->type == 5 }转入消费金{/if}
							{if $item->type == 6 }系统扣除{/if}
							{if $item->type == 7 }消费金解封{/if}
							{if $item->type == 10 }使用消费金抽奖{/if}
							{if $item->type == 11 }中奖获得消费金{/if}
							{if $item->type == 12 }购买赠送{/if}
							{if $item->type == 13 }系统充值{/if}
							{if $item->type == 14 }转出消费金{/if}
	                    </td>
	                    <td>
	                        <a style="text-decoration:none" href="index.php?module=finance&action=Xiaofeijindel&id={$item->id}" title="删除" onclick="return confirm('确定要删除该用户的消费金记录?')">
	                        	<div style="align-items: center;font-size: 12px;display: flex;">
	                            	<div style="margin:0 auto;;display: flex;align-items: center;"> 
	                                <img src="images/icon1/del.png"/>&nbsp;删除
	                            	</div>
                        		</div>
	                        </a>
	                    </td>
	                </tr>
	            {/foreach}
            </tbody>
        </table>
    </div>
	<div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script> 
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="style/js/H-ui.js"></script> 
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>
<script type="text/javascript" src="style/laydate/laydate.js"></script>


{literal}
<script type="text/javascript">
	function excel(pageto) {
		var pagesize = $("[name='DataTables_Table_0_length'] option:selected").val();
		location.href = location.href + '&pageto=' + pageto + '&pagesize=' + 10;
	}
	laydate.render({
		  elem: '#group_start_time', //指定元素
		  type: 'datetime'
	});
	 laydate.render({
		  elem: '#group_end_time', 
		  type: 'datetime'
	});
</script>
{/literal}
</body>
</html>


