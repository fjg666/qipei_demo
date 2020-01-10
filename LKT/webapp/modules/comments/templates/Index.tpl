{include file="../../include_path/header.tpl" sitename="公共头部"}
{literal}
<style type="text/css">
@font-face {
	font-family: "iconfont";
	src: url('iconfont.eot?t=1529402722179');
	/* IE9*/
	src: url('iconfont.eot?t=1529402722179#iefix') format('embedded-opentype'), /* IE6-IE8 */
	url('data:application/x-font-woff;charset=utf-8;base64,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') format('woff'), url('iconfont.ttf?t=1529402722179') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/
	url('iconfont.svg?t=1529402722179#iconfont') format('svg');
	/* iOS 4.1- */
}

table a {
	width: 56px;
	margin-right: 4px!important;
}

.iconfont {
	font-family: "iconfont" !important;
	font-size: 16px;
	font-style: normal;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

.icon-zhongping:before {
	content: "\e504";
}

.icon-haoping:before {
	content: "\e608";
}

.icon-frown:before {
	content: "\e77e";
}

.c_content {
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis;
}

#btn8:hover {
	border: 1px solid #2890FF!important;
	color: #2890FF!important;
}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="" style="padding: 0!important;margin: 0 10px;">
	<div class="text-c tetx_c">
		<form name="form1" action="index.php" method="get" class="page_list">
			<input type="hidden" name="module" value="comments" />
			<input type="hidden" name="ordtype" value="{$otype}" />
			<input type="hidden" name="gcode" value="{$status}" />
			<input type="hidden" name="ocode" value="{$ostatus}" />
			<select name="otype" id="otype_" class="select" style="width: 80px;height: 31px;vertical-align: middle;">
				{$comments_str}
			</select>

			<input type="text" name="sNo" size='8' value="{$sNo}" id="sNo_" placeholder="请输入订单编号" style="width:200px" class="input-text">
			<div style="position: relative;display: inline-block;">
				<input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
			</div>
			至
			<div style="position: relative;display: inline-block;margin-left: 5px;">
				<input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
			</div>
			<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

			<input class="btn btn-success" id="btn1" type="submit" value="查询">

		</form>
	</div>
	<div class="page_h16"></div>
	<div class="mt-20 page_mag table-scroll">
		<table class="table table-border table-bordered table-bg table-hover table-sort taber_border">
			<thead>
				<tr class="text-c">
					<th style="color: #414658;padding-left: 20px;">ID</th>
					<th style="color: #414658;">用户ID</th>
					<th style="color: #414658;">订单编号</th>
					<th style="color: #414658;">商品名称</th>
					<th style="color: #414658;">店铺名称</th>
					<th style="color: #414658;">评价类型</th>
					<th style="color: #414658;">评价内容</th>
					<th style="color: #414658;">添加时间</th>
					<th style="color: #414658;">订单金额</th>
					<th style="color: #414658;">订单类型</th>
					<th style="width: 180px;color: #414658;">操作</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$order item=item name=f1}
				<tr class="text-c" style="height: 65px !important;">
					<td style="color: #414658;padding-left: 20px;">{$item->id}</td>
					<td style="width: 60px;color: #414658;">{$item->anonymous}</td>
					<td style="color: #414658;">{$item->r_sNo}</td>
					<td style="text-align: left;color: #414658;">{$item->p_name}</td>
					<td style="text-align: left;color: #414658;">{$item->shop_name}</td>
					<td style="width: 70px;">
						{if $item->CommentType1 == 'GOOD'}
						<span class="icon iconfont icon-haoping" style="color: #43CD80;"></span>
						{elseif $item->CommentType1 == 'NOTBAD'}
						<span style="color: #EEAD0E;" class="icon iconfont icon-zhongping"></span>
						{else}
						<span style="color: #EE4000;" class="icon iconfont icon-frown"></span>
						{/if}
					</td>
					<td style="width: 70px;color: #414658;">
						<div class="c_content" onclick="read('{$item->content}');">{$item->content}</div>
					</td>
					<td style="color: #414658;">{$item->add_time}</td>
					<td style="width: 70px;color: #414658;">{$item->p_price}</td>
					<td style="width: 70px;color: #414658;">{if $item->otype == 'pt'}
						<span>拼团订单</span> {elseif $item->otype == 'KJ'}
							<span>砍价订单</span>{else}{if $item->drawid>0}
						<span>抽奖订单</span> {else}
						<span>普通订单</span> {/if}{/if}
					</td>
					<td style="width: 180px">
						{if $button[0] == 1}
							{if $item->rec}
								<a style="text-decoration:none" href="index.php?module=comments&action=Reply&id={$item->id}" title="回复评论">
								<div style="align-items: center;font-size: 12px;display: flex;">
									<div style="margin:0 auto;;display: flex;align-items: center;">
										<img src="images/icon1/hf.png" />&nbsp;回复
									</div>
								</div>
							</a>
							{/if}
						{/if}
						{if $button[1] == 1}
							<a style="text-decoration:none" href="index.php?module=comments&action=Modify&id={$item->id}" title="修改评价">
								<div style="align-items: center;font-size: 12px;display: flex;">
									<div style="margin:0 auto;;display: flex;align-items: center;">
										<img src="images/icon1/xg.png" />&nbsp;修改
									</div>
								</div>
							</a>
						{/if}
						{if $button[2] == 1}
							<a style="text-decoration:none" href="javascript:void(0);" onclick="del_coms(this,{$item->id})" title="删除评价">
								<div style="align-items: center;font-size: 12px;display: flex;">
									<div style="margin:0 auto;;display: flex;align-items: center;">
										<img src="images/icon1/del.png" />&nbsp;删除
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
var Vheight = $(window).height()-56-56-16-10-($('.tb-tab').text()?70:0)
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
	$("#otype_").val('0');
	$("#sNo_").val('');
	$("#startdate").val('');
	$("#enddate").val('');
	return false;
}

function read(msg) {
	layer.msg(msg);
}

function del_coms(obj, id) {
	var r = confirm("确定删除本条评论吗？", id, 'index.php?module=comments&action=Del&id=', '删除')
}

function confirm(content, id, url, content1) {
	$("body", parent.document).append(`
		<div class="maskNew">
			<div class="maskNewContent">
				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				<div class="maskTitle">删除评论</div>
				<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
				<div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
					${content}
				</div>
				<div style="text-align:center;margin-top:30px">
					<button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
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