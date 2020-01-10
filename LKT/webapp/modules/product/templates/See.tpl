<!DOCTYPE HTML>
<html>

<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<title>修改产品</title>

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}

{literal}
<style type="text/css">
	form[name=form1]{padding: 0!important;}
	form[name=form1] input{margin-right: 0;}
	.set_center{
		background:#FF7F50;
		opacity: 0.9;
	}
	.attr_table td select {
		width: 40px !important;
	}
	.upload-preview .upload-preview-img {
		max-width: 100%;
		max-height: 100%;
		margin: auto auto;
		position: absolute;
		width: 100%;
		height: 100%;
	}
	p{margin-bottom: 0;}
	.formDivSD{
		pointer-events: none;
		margin-bottom: 0px !important;
	}
	.formListSD{
		color:#414658;
	}
	.formTextSD{
		color:#888f9e;
	}

	.formContentSD{
		padding: 30px 60px 30px 60px;
	}
	.formTextSD{
		margin-right: 8px;
	}
	input[type=number]::-webkit-input-placeholder { /* WebKit browsers */
		color: #97A0B4;
	}
	.form_address{
		margin-right: 0px !important;
	}
</style>
{/literal}
</head>

<body class="body_bgcolor">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"} {include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 form-scroll" id="page" >
	<form name="form1" id="form1" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="{$id}">
		<input type="hidden" name="mch_id" class="mch_id" value="{$mch_id}">
		<div class="formDivSD">
			<div class="page_title">基本信息</div>
			<div class="formContentSD">
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>商品标题：</span></div>
					<div class="formInputSD">{$product_title}</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span>副标题：</span></div>
					<div class="formInputSD">{$subtitle}</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>关键词：</span></div>
					<div class="formInputSD">{$keyword}</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>重量：</span></div>
					<div class="formInputSD">{$weight}</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>商品条形码：</span></div>
					<div class="formInputSD">{$scan}</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>商品类别：</span></div>
					<div class="formInputSD">{$product_class_name}</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>商品品牌：</span></div>
					<div class="formInputSD">
						{$brand_class_name}
					</div>
				</div>
				<div class="formListSD">
					<div class="formTextSD"><span class="must">*</span><span>商品展示图：</span></div>
					<div class="formInputSD upload-group multiple">
						<div id="sortList" class="upload-preview-list uppre_auto">
							{if $imgurls}
								{foreach from=$imgurls item=item4 key=key name=f4}
									<div class="upload-preview form_new_img">
										<img src="{$item4->product_url}" class="upload-preview-img">
										<div class="form_new_words {if $item4->is_center}set_center{/if}">{if $item4->is_center}主图{else}设为主图{/if}</div>
										<input type="hidden" name="imgurls[]" class="file-item-input" value="{$item4->product_url}">
									</div>
								{/foreach}
							{else}
								<div class="upload-preview form_new_img" style="display: none;">
									<img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
									<img src="images/icon1/add_g_t.png" class="upload-preview-img">
								</div>
							{/if}
						</div>
					</div>
				</div>
			</div>
			<div class="formSpaceSD"></div>
		</div>

		<div class="formDivSD">
			<div class="page_title">商品属性</div>
			<div class="formContentSD">
				{literal}
					<!-- 有规格 -->
					<div >
						<div class="arrt_bgcolor arrt_fiv">
							<div v-if="attr_group_list && attr_group_list.length>0">
								<table class="attr-table attr_table">
									<thead>
										<tr>
											<th v-for="(attr_group,i) in attr_group_list" v-if="attr_group.attr_list && attr_group.attr_list.length>0">
												{{attr_group.attr_group_name}}
											</th>
											<th>成本价</th>
											<th>原价</th>
											<th>售价</th>
											<th>库存</th>
											<th>单位</th>
											<th>上传图片</th>
										</tr>
									</thead>
									<tr v-for="(item,index) in checked_attr_list" class="arrt_tr">
										<input type="hidden"  v-bind:name="'attr['+index+'][cid]'" :value="item.cid">
										<td v-for="(attr,attr_index) in item.attr_list">
											<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_id]'" v-bind:value="attr.attr_id">

											<input type="hidden" v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_name]'" v-bind:value="attr.attr_name">

											<input type="hidden" v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_group_name]'" v-bind:value="attr.attr_group_name">
											<span>{{attr.attr_name}}</span>
										</td>
										<td>
											{{item.costprice}}
										</td>
										<td>
											{{item.yprice}}
										</td>
										<td>
											{{item.price}}
										</td>
										<td>
											{{item.num}}
										</td>
										<td>
											{{item.unit}}
										</td>
										<td>
											<div  class="upload-group form_group form_flex">
												<div class="form_attr_img ">
													<img :src="item.img" class="upload-preview-img form_att select-file">
												</div>
												<div class="input-group" style="display: none;">
													{{item.img}}
												</div>

											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				{/literal}
			</div>
			<div class="formSpaceSD"></div>
		</div>

		<div class="formDivSD">
			<div class="page_title">商品设置</div>
			<div class="formContentSD">
				<div class="form_li form_num formListSD">
					<div class="form_new_l"><span>*</span>库存预警：</div>
					<div class="form_new_r"><span class="form_li_one">当前库存量小于{$min_inventory}</span><span class="form_li_one">时，商品库存报警</span></div>
				</div>

				<div class="form_li">
					<div class="form_new_l"><span>*</span>运费设置：</div>
					<div class="form_new_r">
						{$freight_name}
					</div>
				</div>

				<div class="form_li formListSD">
					<div class="form_new_l"><span></span>排序号：</div>
					<div class="formInputSD">{$sort}</div>
				</div>
				<div class="form_li formListSD">
					<div class="form_new_l"><span></span>显示标签：</div>
					<div class="form_new_r">{$sp_type}
					</div>
				</div>
				<div class="form_li">
					<div class="form_new_l"><span>*</span>支持活动类型：</div>
					<div class="form_new_r">
						<div class="ra1">
							<input name="active" type="radio" {if $active == 1}checked="checked"{/if} style="display: none;" id="active-1" class="inputC1" value="1">
							<label for="active-1">正价</label>
						</div>
						{$Plugin_arr.res1}
						<div class="ra1">
							<input name="active" type="radio" {if $active == 6}checked="checked"{/if} style="display: none;" id="active-6" class="inputC1" value="6">
							<label for="active-6">会员</label>
						</div>
					</div>
				</div>
				{$Plugin_arr.res2}
				<div class="form_li formListSD" id="show_adr" {if $active != 1}style="display: none"{/if}>
					<div class="form_new_l"><span></span>前端显示位置：</div>
					<div class="form_new_r">{$show_adr}<span>（如果不选，默认显示在全部商品里）</span></div>
				</div>
				<div class="form_li">
					<div class="form_new_l"><span></span>是否支持线下核销：</div>
					<div class="form_new_r form_yes">
						<div class="ra1">
							<input name="is_hexiao" type="radio" {if $is_hexiao == 1}checked="checked"{/if} style="display: none;" id="is_hexiao-1" class="inputC1" value="1">
							<label for="is_hexiao-1">是</label>
						</div>
						<div class="ra1">
							<input name="is_hexiao" type="radio" {if $is_hexiao == 0}checked="checked"{/if} style="display: none;" id="is_hexiao-2" class="inputC1" value="0">
							<label for="is_hexiao-2">否</label>
						</div>
					</div>
				</div>
				<div class="form_address" id="xd_hx" {if $is_hexiao == 0}style="display: none;"{/if}>
					<span>核销地址：{$hxaddress}</span>
				</div>
			</div>
			<div class="formSpaceSD"></div>
		</div>

		<div class="formDivSD">
			<div class="page_title">详细内容</div>
			<div class="formContentSD">
				<div class="formListSD">
					<div class="formTextSD form_word"><span></span>商品详情：</div>
					<div class="formInputSD">
						{$content}
					</div>
				</div>
			</div>
		</div>
		<div class="bottomBtnWrap page_bort">
			<button type="button" onclick="javascript:history.back(-1);" class="bottomBtn backBtnSD btn-right" style="float: right;">返回</button>
		</div>
	</form>
	<div class="page_h10"></div>
</div>

{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{literal}
<script>
var map = new Map();
var page = new Vue({
    el: "#page",
    data: {
        sub_cat_list: [],
        attr_group_list: JSON.parse('{/literal}{$attr_group_list}{literal}', true), //可选规格数据
        attr_group_count: JSON.parse('{/literal}{$attr_group_list}{literal}', true).length,
        checked_attr_list: JSON.parse('{/literal}{$checked_attr_list}{literal}', true), //已选规格数据
        old_checked_attr_list: [],
        goods_card_list: [],
        card_list: [],
        goods_cat_list: [{
            "cat_id": null,
            "cat_name": null
        }],
        select_i: '',
        cbj:'',
        yj:'',
        sj:'',
        kucun:''
    },
	methods: {
		change: function(item, index) {
			this.checked_attr_list[index] = item;
		}
	}
});

document.onkeydown = function(e) {
	if(!e) e = window.event;
	if((e.keyCode || e.which) == 13) {
		$("[name=Submit]").click();
	}
}

</script>
{/literal}
</body>

</html>