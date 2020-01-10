{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style>
td a{
	width: 28%;
	margin: 2%!important;
}
.dataTables_wrapper .dataTables_length{
	bottom: 13px;
}
.btn1{
	width: 80px;
	height: 36px;
	line-height: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
	float: left;
	color: #6a7076;
	background-color: #fff;
}
.btn1:hover{
	text-decoration: none;
}
input:focus::-webkit-input-placeholder {
	color: transparent;
	/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}

.swivch a:hover{background-color: #2481E5 !important;}
#btn8:hover{border: 1px solid #2890FF!important;color: #2890FF!important;}
</style>
{/literal}
<body class="iframe-container">
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="iframe-content">
    <div class="navigation">
		{if $button[0] == 1}
			<div class='active'>
				<a href="index.php?module=finance" >提现审核</a>
			</div>
		{/if}
		<p class='border'></p>
		{if $button[1] == 1}
			<div>
				<a href="index.php?module=finance&action=List" >提现记录</a>
			</div>
		{/if}
		<p class='border'></p>
		{if $button[2] == 1}
			<div>
				<a href="index.php?module=finance&action=Config" >钱包参数</a>
			</div>
		{/if}
	</div>
    <div class="hr" ></div>
	<div class="text-c">
		<form name="form1" action="index.php?module=finance" method="get" class='iframe-search'>
			<input type="hidden" name="module" value="finance" />
			<input type="text" class="input-text" style="width:150px" placeholder="请输入用户名称" name="name" value="{$name}" id="name">
			<input type="text" class="input-text" style="width:150px" placeholder="请输入联系电话" name="mobile" value="{$mobile}" id="mobile">

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
    <div class="mt-20 table-scroll" style="background: #fff;">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                	<th style="width: 30px;">序号</th>
		            <th >用户名称</th>
					<th >来源</th>
					<th >联系电话</th>
					<th >状态</th>
					<th >申请时间</th>
		            <th >提现金额</th>
		            <th >提现手续费</th>
					<th >持卡人姓名</th>
					<th >银行名称</th>
					<th >支行名称</th>
		            <th >卡号</th>
		            <th >操作</th>
		        </tr>
            </thead>
            <tbody>
	            {foreach from=$list item=item name=f1}
	                <tr class="text-c tab_td">
	                    <td>{$smarty.foreach.f1.iteration}</td>
						<td>{$item->name}</td>
						<td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
						<td>{$item->mobile}</td>
						<td>{if $item->status == 0}<span style="color: #ff2a1f;">待审核</span>{elseif $item->status == 1}<span style="color: #30c02d;">审核通过</span>{else}<span style="color: #7A7A7A;">已拒绝</span>{/if}</td>
						<td>{$item->add_date}</td>
	                    <td>{$item->money}元</td>
	                    <td>{$item->s_charge}元</td>
						<td>{$item->Cardholder}</td>
						<td>{$item->Bank_name}</td>
						<td>{$item->branch}</td>
	                    <td>{$item->Bank_card_number}</td>
	                    <td style="min-width: 180px;">
							{if $button[3] == 1}
								<a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="examine(this,1,'{$item->id}','{$item->user_id}','{$item->money}','{$item->s_charge}','index.php?module=finance&action=Del')" >
									<div style="align-items: center;font-size: 12px;display: flex;">
										<div style="margin:0 auto;;display: flex;align-items: center;">
										<img src="images/icon1/sx.png"/>&nbsp;通过
										</div>
									</div>
								</a>
								<a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="examine(this,2,'{$item->id}','{$item->user_id}','{$item->money}','{$item->s_charge}','index.php?module=finance&action=Del')" >
									<div style="align-items: center;font-size: 12px;display: flex;">
										<div style="margin:0 auto;;display: flex;align-items: center;">
										<img src="images/icon1/jy.png"/>&nbsp;拒绝
										</div>
									</div>
								</a>
							{/if}
	                    </td>
	                </tr>
	            {/foreach}
            </tbody>
        </table>
    </div>
	<div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-44-16-56-16-($('.tb-tab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')
	
laydate.render({
	elem: '#startdate', //指定元素
	type: 'datetime'
});
laydate.render({
	elem: '#enddate',
	type: 'datetime'
});

function empty() {
    $("#name").val('');
    $("#mobile").val('');
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
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
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
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style='text-align: center;padding-top: 10px'>
                	<input style='border:1px solid #666;height:30px;line-height: 30px' type="text" placehold='请输入拒绝原因' name='jujue'>
                </div>
                <div style="text-align:center;margin-top:10px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask4_1('${m}','${id}','${user_id}','${money}','${s_charge}','${url}',this)>确认</button>
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


