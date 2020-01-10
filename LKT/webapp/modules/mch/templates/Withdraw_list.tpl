{include file="../../include_path/header.tpl" sitename="头部"}
{literal}
<style type="text/css">
.btn1{
	width: 80px;
	height: 40px;
	line-height: 40px;
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
.swivch a:hover{
	text-decoration: none;
	background-color: #2481e5!important;
	color: #fff!important;
}
input:focus::-webkit-input-placeholder {
	color: transparent;
	/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}
</style>
{/literal}
<body>
<nav class="breadcrumb" style="font-size: 16px;">
	<span class="c-gray en"></span>
	插件管理
	<span class="c-gray en">&gt;</span>
	店铺
	<span class="c-gray en">&gt;</span>
	提现记录
</nav>
<div class="pd-20 page_absolute">
	<!--导航表格切换-->
	<div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
		<a href="index.php?module=mch&aciton=Index" class="btn1 " style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">店铺</a>
		{if $button[0] == 1}
			<a href="index.php?module=mch&action=List" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">审核列表</a>
		{/if}
		{if $button[1] == 1}
			<a href="index.php?module=mch&action=Set" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">多商户设置</a>
		{/if}
		{if $button[2] == 1}
			<a href="index.php?module=mch&action=Product" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">商品审核</a>
		{/if}
		{if $button[3] == 1}
			<a href="index.php?module=mch&action=Withdraw" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">提现审核</a>
		{/if}
		{if $button[4] == 1}
			<a href="index.php?module=mch&action=Withdraw_list" class="btn1 swivch_active" style="height: 42px !important;border:0!important;width: 112px;">提现记录</a>
		{/if}
		<div style="clear: both;"></div>
	</div>
	<div class="page_h16"></div>
	<div class="text-c">
		<form name="form1" action="index.php" method="get">
			<input type="hidden" name="module" value="mch" />
			<input type="hidden" name="action" value="Withdraw_list" />
			<input type="text" class="input-text" style="width:150px" placeholder="请输入店铺的名称	" name="name" id="name" value="{$name}">
			<input type="text" class="input-text" style="width:150px" placeholder="请输入联系电话" name="mobile" id="mobile" value="{$mobile}">

			<div style="position: relative;display: inline-block;">
				<input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
			</div>至
			<div style="position: relative;display: inline-block;margin-left: 5px;">
				<input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
			</div>
			<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

			<input type="submit" id="btn1" class="btn btn-success" value="查 询">

			<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float: right;">
		</form>
	</div>
	<div class="page_h16"></div>
	<div class="mt-20 table-scroll">
		<table class="table-border tab_content">
			<thead>
				<tr class="text-c tab_tr">
					<th class="tab_num">序号</th>
		            <th class="tab_imgurl" >店铺</th>
					<th >联系电话</th>
					<th >状态</th>
					<th class="tab_time">申请时间</th>
		            <th >提现金额</th>
		            <th >提现手续费</th>
					<th >持卡人姓名</th>
					<th >银行名称</th>
					<th >支行名称</th>
		            <th >卡号</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item=item name=f1}
	                <tr class="text-c tab_td">
	                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
						<td class="tab_imgurl" >
							<div class="tab_good">
								<img src="{$item->logo}" class="" style="margin: auto 0px;">
								<div class="goods-info tab_left" style="width: 150px;margin: auto 5px;">
									<div class="mt-1" style="font-weight:bold;color:rgba(65,70,88,1);font-size:14px;">{$item->mch_name} </div>
									<div class="mt-1" style="font-size: 14px;color: #888F9E;font-weight:400;margin: 6px 0px;">用户ID：{$item->user_id}</div>
								</div>
							</div>
						</td>
						<td>{$item->mobile}</td>
						<td>{if $item->status == 0}<span style="color: #ff2a1f;">待审核</span>{elseif $item->status == 1}<span style="color: #30c02d;">审核通过</span>{else}<span style="color: #7A7A7A;">已拒绝</span>{/if}</td>
						<td class="tab_time">{$item->add_date}</td>
	                    <td>{$item->money}元</td>
	                    <td>{$item->s_charge}元</td>
						<td>{$item->Cardholder}</td>
						<td>{$item->Bank_name}</td>
						<td>{$item->branch}</td>
						<td>{$item->Bank_card_number}</td>
						<td>{$item->refuse}</td>
	                </tr>
	            {/foreach}
			</tbody>
		</table>
	</div>

	<div class='tb-tab' style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}


{literal}
<script type="text/javascript">
// 根据框架可视高度,减去现有元素高度,得出表格高度
var Vheight = $(window).height()-56-42-16-56-16-($('.tb-tab').text()?70:0)
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
</script>
{/literal}
</body>
</html>


