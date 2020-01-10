<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<title>添加产品</title>

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

			.formDivSD{
				margin-bottom: 0px !important;
			}
			.formListSD{
				color:#414658;
			}
			.formContentSD{
				padding: 0px 0px 30px 60px;
				margin-top: 40px;
			}
			.formTextSD{
				margin-right: 8px;
			}
			input[type=number]::-webkit-input-placeholder { /* WebKit browsers */
				color: #97A0B4;
			}
			.form_address{
				margin-right: 60px;
			}
			
			.formInputDiv{
				display: flex;
				width: 300px;
				border: 1px solid #D5DBE8;
			}
			.formInputDiv ul{width: 300px;margin: 0;max-height: 171px;overflow-y: scroll;}
			.formInputDiv ul:not(:last-child){border-right: 1px solid #D5DBE8;}
			.formInputDiv li{height: 30px;line-height: 30px;cursor: pointer;font-size: 14px;color: #6A7076;user-select:none;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;padding: 0 12px;}
			.formInputDiv li:hover{color: #0880FF;}
			.formInputDiv .active{position: relative;background: #0880FF;color: #fff!important;}
			
			.selectDiv{position: relative;width: 300px;height: 36px;}
			.selectDiv>div{position: absolute;top:0;left: 0;width: 100%;height: 100%;display: flex;align-items: center;padding-left: 12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;padding-right: 15px;}
			.selectDiv p{margin-bottom: 0;}
			.selectItem span{margin: 0 5px;}
			
			.Attribute{background: #2890FF;color: #FFFFFF!important;width: 100px;height: 36px;line-height: 36px;text-align: center;border-radius: 2px;font-size: 14px;}
			
			.attr_table a{color: #2890FF; border: 0; min-width: 35px;}
			.attr_table input{width: 100px!important;height: 36px!important;line-height: 36px!important;font-size: 14px;color: #414658!important;text-align: center;}
			.arrt_fiv{margin-left: 128px;}
			.attr_table th{padding: 0 10px;}

			.xiabiao{display: inline-block; width: 0; height: 0; border: 5px solid transparent; border-top-color: #414658; border-top-width: 6px; border-bottom-width: 0;margin-left: 5px;}
			.th_xz{justify-content: center;cursor: pointer;position: relative;}
			.th_xz>ul{
				position: absolute; top: 21px; background: #ffffff; width: 120%;z-index: 99;
			}
			.th_xz>ul li{
				height: 30px;
				line-height: 30px;
				font-weight: 300;
				user-select:none;
			}
			.th_xz>ul li.active{
				background: #2890FF;
				color: #FFFFFF;
			}
		</style>
		{/literal}
	</head>

	<body class="iframe-container">
		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
		<nav class="nav-title">
			<span>商品管理</span> 
			<span class='pointer' onclick="javascript :history.back(-1);"><span class="arrows">&gt;</span>商品列表</span> 
			<span><span class="arrows">&gt;</span>添加</span>
		</nav>
		<div class="iframe-content form-scroll" id="page">
			<form name="form1" id="form1" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="{$id}">
				<div class="formDivSD">
					<div class="page_title">基本信息</div>
					<div class="formContentSD">
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>汽配名称：</span></div>
							<div class="formInputSD">
								<input type="text" required="required" value="{$product_title}" name="product_title">
								
								<span class="addText">（标题长度须在20个中文字符内）</span>
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span>副标题：</span></div>
							<div class="formInputSD">
								<input type="text" value="{$subtitle}" name="subtitle">
								<span class="addText">（简洁表达商品，用来显示在首页产品，避免截取时不能表达是什么商品。）</span>
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>关键词：</span></div>
							<div class="formInputSD"><input type="text" value="{$keyword}" name="keyword">
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>重量：</span></div>
							<div class="formInputSD">
								<input type="number" onkeypress="return noNumbers(event)" value="{$weight}" min="0" name="weight">
								<span class="addText">克</span>
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>商品编码：</span></div>
							<div class="formInputSD"><input type="text" required="required" value="{$product_number}" name="product_number" readonly="readonly" style="background-color: #F8F8F8 !important;"></div>
						</div>
						<div class="formListSD">
							<div class="formTextSD" style='height: 36px;'><span class="must">*</span><span>汽配类别：</span></div>
							<div class="formInputSD" style='display: block;'>
								<div class='selectDiv' onclick="select_class()">
									<select name="product_class" class="select" readonly="readonly" style='margin-right: 0;'>
										<option selected="selected" value="0">请选择汽配类别</option>
									</select>
									<div id="div_text">
										
									</div>
								</div>
								<div id='selectData' class='formInputDiv' style='display: none;'>
									<ul id="selectData_1">

									</ul>
								</div>
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>汽配品牌：</span></div>
							<div class="formInputSD" onclick="select_pinpai()">
								<select name="brand_class" class="select" id="brand_class">
									<option selected="selected" value="0">请选择汽配品牌</option>
								</select>
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextBigSD"><span class="must">*</span><span>汽配展示图：</span></div>

							<div class="formInputSD upload-group multiple">
								<div id="sortList" class="upload-preview-list uppre_auto">
									{if $imgurls }
										{foreach from=$imgurls item=item4 key=key name=f4}
										<div class="upload-preview form_new_img">
											<img src="images/iIcon/sha.png" class="form_new_sha file-item-delete" />
											<img src="{$item4->product_url}" class="upload-preview-img">
											<div class="form_new_words {if $item4->is_center}set_center{/if}" onclick="set_center(this)">{if $item4->is_center}主图{else}设为主图{/if}</div>
											<input type="hidden" name="imgurls[]" class="file-item-input" value="{$item4->product_url}">
										</div>
										{/foreach}
									{else}
										<div class="upload-preview form_new_img" style="display: none;">
											<img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp" />
											<img src="images/icon1/add_g_t.png" class="upload-preview-img">
											<div class="form_new_words" onclick="set_center(this)">设为主图</div>
											<input type="hidden" name="imgurls[]" class="file-item-input" value="">
										</div>
									{/if}
								</div>

								<div data-max='5' class="select-file form_new_file from_i">
									<div>
										<img data-max='5' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
										<span class="form_new_span">上传图片</span>
									</div>
								</div>
								<span class="addText" style="max-width: 350px;">（展示图最多上传五张，建议上传500px*500px的图片，主图未设置则默认第一张）</span>
							</div>
						</div>
					</div>
					<div class="formSpaceSD"></div>
				</div>

				<div class="formDivSD">
					<div class="page_title">汽配属性</div>
					<div class="formContentSD">
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>成本价：</span></div>
							<div class="formInputSD">
								<input required="required" type="number" name="initial[cbj]" onkeypress="return noNumbers(event)" onblur="set_cbj(this);" min="0" value="" placeholder="请设置商品的默认成本价" >
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>原价：</span></div>
							<div class="formInputSD">
								<input required="required" type="number" name="initial[yj]" onkeypress="return noNumbers(event)" onblur="set_yj(this);" min="0" value="" placeholder="请设置商品的默认原价" >
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>售价：</span></div>
							<div class="formInputSD">
								<input required="required" type="number" name="initial[sj]" onkeypress="return noNumbers(event)" onblur="set_sj(this);" min="0" value="" placeholder="请设置商品的默认售价" >
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>单位：</span></div>
							<div class="formInputSD">
								<select name="initial[unit]" class="select " style="width: 300px;" id="unit">
									<option selected="selected" value="0">请选择单位</option>
									{$unit}
								</select>
							</div>
						</div>
						<div class="formListSD">
							<div class="formTextSD"><span class="must">*</span><span>库存：</span></div>
							<div class="formInputSD">
								<input id='kucun' type="number" name="initial[kucun]" oninput="value=value.replace(/[^\d]/g,'')" required="required" onblur="set_kucun(this);" min="0" value="" placeholder="请设置商品的默认库存" >
							</div>
						</div>
						{literal}
						<!-- 有规格 -->
						<div >
							<div class="arrt_block">
								<div class="formTextSD">规则/属性：</div>
								<a href="javascript:;" class='Attribute'>添加属性</a>
							</div>
							<div class="arrt_bgcolor arrt_fiv" v-if='attrTitle.length>0'>
								<div>
									<table class="attr-table attr_table">
										<thead>
											<tr>
												<th v-for="(attr_group,i) in attrTitle" v-if="attr_group.attr_list && attr_group.attr_list.length>0">
													<div class='align-center th_xz' @click="isShow(attr_group)">
														{{attr_group.attr_group_name}}
														<span class='xiabiao'></span>
														<ul v-show="attr_group.isShow">
															<li v-for="(item,index) in attr_group.attr_list" @click.stop="chooseMe(item)" :class="{active:item.chooseMe}">{{item.attr_name}}</li>
														</ul>
													</div>
												</th>
												<th style=''>成本价</th>
												<th style=''>原价</th>
												<th style=''>售价</th>
												<th style=''>库存</th>
												<th>单位</th>
												<th style='width: 220px;'>条形码</th>
												<th style='width: 85px;'>上传图片</th>
											</tr>
										</thead>
										<tbody>
											<!-- 第一行的价格库存等数据是固定的 -->
											<tr v-if="index==0" v-for='(item,index) in strArr' :key='index'>
												<td v-for="(attr,attr_index) in item.attr_list">
													<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_id]'" v-model="attr.attr_id">
													<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_name]'" v-model="attr.attr_name">
													<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_group_name]'" v-model="attr.attr_group_name">
													<span>{{attr.attr_name}}</span>
												</td>
												<td>
													<div>
														<input type="hidden" v-bind:name="'attr['+index+'][costprice]'" :value="cbj">
														<span>{{cbj}}</span>
													</div>
												</td>
												<td>
													<div>
														<input type="hidden" v-bind:name="'attr['+index+'][yprice]'" :value="yj">
														<span>{{yj}}</span>

													</div>
												</td>
												<td>
													<div>
														<input type="hidden" v-bind:name="'attr['+index+'][price]'" :value="sj">
														<span>{{sj}}</span>

													</div>
												</td>
												<td>
													<div>
														<input type="hidden" v-bind:name="'attr['+index+'][num]'" :value="kucun">
														<span>{{kucun}}</span>
													</div>
												</td>
												<td>
													<input type="hidden" v-bind:name="'attr['+index+'][unit]'" :value="unit" style="border: 0px;background-color: transparent;" readOnly="readOnly">
													<span>{{unit}}</span>
												</td>
												<td>
													<div>
														<input type="text" v-bind:name="'attr['+index+'][bar_code]'"  v-model="item.code" style='width: 140px!important;'>
														<a href="javascript:;">扫码</a>
													</div>
												</td>
												<td>
													<div  class="upload-group form_group form_flex">
														<div class="form_attr_img ">
															<img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-c"/>
															<img src="images/icon1/add_g_t.png" class="upload-preview-img form_att select-file">
														</div>
														<div class="input-group" style="display: none;">
															<input value="" class="form-control file-input" v-bind:name="'attr['+index+'][img]'">
														</div>
													</div>
												</td>
											</tr>
											<tr v-if="index>0" v-for='(item,index) in strArr' :key='index'>
												<td v-for="(attr,attr_index) in item.attr_list">
													<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_id]'" v-model="attr.attr_id">
													<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_name]'" v-model="attr.attr_name">
													<input type="hidden"  v-bind:name="'attr['+index+'][attr_list]['+attr_index+'][attr_group_name]'" v-model="attr.attr_group_name">
													<span>{{attr.attr_name}}</span>
												</td>
												<td>
													<div>
														<input type="number" v-bind:name="'attr['+index+'][costprice]'" :value="cbj">
													</div>
												</td>
												<td>
													<div>
														<input type="number" v-bind:name="'attr['+index+'][yprice]'" :value="yj">
													</div>
												</td>
												<td>
													<div>
														<input type="number" v-bind:name="'attr['+index+'][price]'" :value="sj">
													</div>
												</td>
												<td>
													<div>
														<input type="number" v-bind:name="'attr['+index+'][num]'" :value="kucun">
													</div>
												</td>
												<td>
													<input type="hidden" v-bind:name="'attr['+index+'][unit]'" :value="unit" style="border: 0px;background-color: transparent;" readOnly="readOnly">
													<span>{{unit}}</span>
												</td>
												<td>
													<div>
														<input type="text" v-bind:name="'attr['+index+'][bar_code]'" v-model="item.code" style='width: 140px!important;'>
														<a href="javascript:;">扫码</a>
													</div>
												</td>
												<td>
													<div  class="upload-group form_group form_flex">
														<div class="form_attr_img ">
															<img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-c"/>
															<img src="images/icon1/add_g_t.png" class="upload-preview-img form_att select-file">
														</div>
														<div class="input-group" style="display: none;">
															<input value="" class="form-control file-input" v-bind:name="'attr['+index+'][img]'">
														</div>
													</div>
												</td>
											</tr>
										</tbody>
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
							<div class="form_new_r">
								<span class="form_li_one">当前库存量小于</span>
								<input type="number" oninput="value=value.replace(/[^\d]/g,'')" required="required" value="{$min_inventory}" min="0" name="min_inventory">
								<span class="form_li_one">时，商品库存报警</span><span>（可在库存列表中查看明细，预警数据将以红色加粗显示）</span>
							</div>
						</div>
						<div class="form_li" formListSD>
							<div class="form_new_l"><span>*</span>运费设置：</div>
							<div class="formInputSD">
								<select name="freight" class="select ">
									{*<option selected="selected" value="0">运费模板名称</option>*}
									{foreach from=$freight item=item1 name=f2}
										<option value="{$item1->id}">{$item1->name}</option>
									{/foreach}
								</select>
							</div>
						</div>

						<div class="form_li formListSD">
							<div class="form_new_l"><span></span>显示标签：</div>
							<div class="form_new_r">{$sp_type}</div>
						</div>
						<div class="form_li formListSD">
							<div class="form_new_l"><span>*</span>支持活动类型：</div>
							<div class="form_new_r form_yes">
								<div class="ra1">
									<input name="active" onchange="active_select(this)" type="radio" checked="" style="display: none;" id="active-1" class="inputC1" value="1">
									<label for="active-1">正价</label>
								</div>
								{* {$Plugin_arr.res1} *}
								<div class="ra1">
									<input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-6" class="inputC1" value="6">
									<label for="active-6">会员</label>
								</div>
							</div>
						</div>
						{$Plugin_arr.res2}
						<div class="form_li formListSD" id="show_adr">
							<div class="form_new_l"><span></span>前端显示位置：</div>
							<div class="form_new_r">{$show_adr}<span>（如果不选，默认显示在全部商品里）</span></div>
						</div>
						<div class="form_li formListSD">
							<div class="form_new_l"><span></span>是否支持线下核销：</div>
							<div class="form_new_r form_yes">
								<div class="ra1">
									<input name="is_hexiao" onchange="form_address(this)" type="radio" style="display: none;" id="is_hexiao-1" class="inputC1" value="1">
									<label for="is_hexiao-1">是</label>
								</div>
								<div class="ra1">
									<input name="is_hexiao" onchange="form_address(this)" type="radio" checked="" style="display: none;" id="is_hexiao-2" class="inputC1" value="0">
									<label for="is_hexiao-2">否</label>
								</div>
							</div>

						</div>
						<div class="form_address" id="xd_hx" style="display: none;">
							<span>核销地址：</span>
							<input type="text" name="kxaddress">
						</div>
					</div>
					<div class="formSpaceSD"></div>
				</div>

				<div class="formDivSD">
					<div class="page_title">详细内容</div>
					<div class="formContentSD">
						<div class="form_li form_num formListSD" style="margin-bottom: 40px;">
							<label class="form_new_l" style="margin-top: 0px;">商品详情：</label>
							<div class="formControls col-xs-8 col-sm-10 codes" style="padding-left: 0px;padding-right: 8px;">
								<script id="editor" type="text/plain" name="content" style="width:100%;height:400px;">{$content}</script>
							</div>
						</div>
					</div>
				</div>
				<div class="page_h10 page_bort">
					<input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()" style="margin-right: 60px!important;">
					<input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
				</div>
			</form>
			<div class="page_h10"></div>
		</div>

		{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"} 
		{include file="../../include_path/footer.tpl" sitename="公共底部"} 
		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
		{literal}
        
		<script>
			$(document).on('click', '#unit', function() {
                var unit = $("#unit").val();
				console.log(unit)
                page.unit = $("#unit").val();
				$(".unit").val(unit);
                // $("#unit1").prepend(unit);
			});

			$(function() {
				//活动类型检测
				active_select();
				$("#imgurls").change(function() {
					var files = this.files;
					if(files && files.length > 5) {
						layer.msg("超过5张");
						this.value = "" //删除选择
						// $(this).focus(); //打开选择窗口
					}
				});
				//富文本编辑器
				var ue = UE.getEditor('editor');

                $("#show_adr").show();
                //分销显示
				$("#xd_fx").hide();
				$("#xd_fx").find(".select").val(0);
			})

			//控制价格显示小数点2位
			function noNumbers(e){  
				var keynum  
				var keychar  
				var numcheck  
				if(window.event) // IE  
				{  
					keynum = e.keyCode  
				}  
				else if(e.which) // Netscape/Firefox/Opera  
				{  
					keynum = e.which  
				}  
				keychar = String.fromCharCode(keynum);
				//判断是数字,且小数点后面只保留两位小数
				if(!isNaN(keychar)){
					var index=e.currentTarget.value.indexOf(".");
					if(index >= 0 && e.currentTarget.value.length-index >2){
						return false;
					}
					return true;
				}
				//如果是小数点 但不能出现多个 且第一位不能是小数点
				if("."== keychar ){
					if(e.currentTarget.value==""){
						return false;
					}
					if(e.currentTarget.value.indexOf(".") >= 0){
						return false;
					}
					return true;
				}
				return false;
			}

			//线下核销地址显示
			function form_address(obj) {
				var as = $(obj).val();
				console.log(as);
				if(as == 1){
					$("#xd_hx").show();
				}else{
					$("#xd_hx").hide();

				}
			}
			// 选择类型
			function active_select(obj) {
                var as = $(obj).val();
                if(as == 1){
                    $("#show_adr").show();
                    $("#xd_fx").hide();
                }else if(as == 5){
                    $("#show_adr").hide();
                    $("#xd_fx").show();
				}else{
                    $("#show_adr").hide();
                    $("#xd_fx").hide();
                    $("#xd_fx").find(".select").val(0);
				}
			}

	        //设置成本价等
			function set_cbj(obj) {
				page.cbj = $(obj).val();
			}
			// 设置原价
			function set_yj(obj) {
				page.yj = $(obj).val();
			}
			// 设置现价
			function set_sj(obj) {
				page.sj = $(obj).val();
			}
			// 设置总库存
			function set_kucun(obj) {
				page.kucun = $(obj).val();
			}
			//设置主图---设置排序
			function set_center(obj) {
				$(".form_new_words").each(function(i){
				   $(this).removeClass('set_center');
				   $(this).text('设为主图');
				   $(this).next().attr("name","imgurls[]");
				   $(this).parent().css("order",i);
				});
				$(obj).addClass('set_center');
				$(obj).text('主图');
				$(obj).next().attr("name","imgurls[center]");
				$(obj).parent().css("order","-1");
			}
			//设置主图---设置排序

			var Map = function() {
                this._data = [];
				this.set = function(key, val) {
					for(var i in this._data) {
						if(this._data[i].key == key) {
							this._data[i].val = val;
							return true;
						}
					}
					this._data.push({
						key: key,
						val: val,
					});
					return true;
				};
				this.get = function(key) {
					for(var i in this._data) {
						if(this._data[i].key == key)
							return this._data[i].val;
					}
					return null;
				};
				this.delete = function(key) {
					for(var i in this._data) {
						if(this._data[i].key == key) {
							this._data.splice(i, 1);
						}
					}
					return true;
				};
			};
			var map = new Map();

			var page = new Vue({
				el: "#page",
				data: {
					sub_cat_list: [],
                    attrTitle: JSON.parse('[]', true), //可选规格数据
                    strArr: JSON.parse('[]', true), //已选规格数据
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
					kucun:'',
                    unit:'',
                    bar_code:'',
				},
				methods: {
					change: function(item, index) {
                        this.strArr[index] = item;
					},
					chooseMe(item){
						item.chooseMe=!item.chooseMe
						var tr = $(`[value='${item.attr_name}']`).parents('tr')
						for(var i=0;i<tr.length;i++){
							var dis,disName;
							var oldName = $(tr).eq(i).attr('disName')
							var oldDis = $(tr).eq(i).css('display')
							if(!oldName){
								dis=item.chooseMe?'':'none';
								disName=item.chooseMe?'':item.attr_name
							}else if(oldName==item.attr_name){
								dis=''
								disName=''
							}else if(oldName.indexOf(item.attr_name)<0){
								dis=oldDis
								disName=item.chooseMe?oldName:(oldName + '' + item.attr_name)
							}else if(oldName.indexOf(item.attr_name)>=0){
								dis=oldDis
								disName=oldName.replace(item.attr_name,'')
							}
							$(tr).eq(i).css('display',dis).attr('disName',disName)
						}
					},
					isShow(attr_group){
						attr_group.isShow=!attr_group.isShow
					}
				}
			});

			document.onkeydown = function(e) {
				if(!e) e = window.event;
				if((e.keyCode || e.which) == 13) {
					$("[name=Submit]").click();
				}
			}

			var t_check = true;

	        var GetLength = function (str) {
				///<summary>获得字符串实际长度，中文2，英文1</summary>
				///<param name="str">要获得长度的字符串</param>
				var realLength = 0, len = str.length, charCode = -1;
				for (var i = 0; i < len; i++) {
					charCode = str.charCodeAt(i);
					if (charCode >= 0 && charCode <= 128) realLength += 1;
					else realLength += 2;
				}
	          return realLength;
	        };

			function check() {
				if(!t_check){
					layer.msg('请勿重复提交！', {
						time: 2000
					});
					return false;
				}

				t_check = false;

				$.ajax({
					cache: true,
					type: "POST",
					dataType: "json",
					url: 'index.php?module=product&action=Add',
					data: $('#form1').serialize(), // 你的formid
					async: true,
					success: function(data) {
						t_check = true;
						layer.msg(data.status, {
							time: 2000
						});
						if(data.suc) {
                            location.href = "index.php?module=product";
						}
					}
				});
			}

			function select_pinpai(){
				var class_str = $("[name=product_class]").val();
				if(class_str == '' || class_str <= 0){
					layer.msg("请先选择商品类别！", {
						time: 2000
					});
				}
			}

            // 点击分类框
			var selectFlag = true  //判断点击分类框请求有没有完成,没完成继续点击不会再次请求
			var choose_class = true  //判断选择分类请求有没有完成,没完成继续点击不会再次请求
            function select_class(){
                var class_str = $('.selectDiv option').val()
                var brand_str = $("#brand_class option:selected").val();
                if($('#selectData').css('display')=='none'){
					$('#selectData').css('display','flex')

                    if(selectFlag&&choose_class){
						selectFlag=false
						$.ajax({
						    type: "GET",
						    url: 'index.php?module=product&action=Ajax',
						    data: {
						        'class_str':class_str,
						        'brand_str':brand_str
						    },
						    success: function (msg) {
						        $('#brand_class').empty()
								$('#selectData_1').empty()
						        obj = JSON.parse(msg)
						        var brand_list = obj.brand_list
						        var class_list = obj.class_list
						        var rew = '';
								if(class_list.length != 0){
						            var num = class_list.length-1;
						            display(class_list[num])
								}
						
						        for(var i=0;i<brand_list.length;i++){
						            if(brand_list[i].status == true){
						                rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
						            }else{
						                rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
						            }
						        }
						        $('#brand_class').append(rew)
						    },
							complete(XHR, TS){
								// 无论请求成功还是失败,都要把判断条件改回去
								selectFlag=true
							}
						});
					}
                }else{
                    $('#selectData').css('display','none')
                }
            }
            // 选择分类
            function class_level(obj,level,cid,type){
                var text = obj.innerHTML
				var text_num = $('.selectDiv>div>p').length

                $('.selectDiv option').text('').attr('value',cid)

                $(obj).addClass('active').siblings().removeClass('active')
                var brand_str = $("#brand_class option:selected").val();
                // 给当前元素添加class，清除同级别class
                // 获取ul标签数量
                var num = $("#selectData ul").length;
				if(selectFlag&&choose_class){
					choose_class=false
					$.ajax({
					    type: "POST",
					    url: 'index.php?module=product&action=Ajax',
					    data: {
					        "cid":cid,
					        "brand_str":brand_str,
					    },
					    success: function (msg) {
					        $('#brand_class').empty()
							$('#selectData_1').empty()
					        res = JSON.parse(msg)
					        var class_list = res.class_list
					        var brand_list = res.brand_list
					        var rew = '';
					        if(type == ''){
					            if(text_num - 2 == level){
					                var text_num1 = text_num - 1;
					                var parent=document.getElementById("div_text");
					                var son0=document.getElementById("p"+text_num);
					                var son1=document.getElementById("p"+text_num1);
					                parent.removeChild(son0);
					                parent.removeChild(son1);
					                if(class_list.length == 0){ // 该分类没有下级
					                    if($('.selectDiv>div').html()==''){
					                        str=`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'></p>`
					                    }else{
					                        $('.del_sel').remove()
					                        str=`<p class='selectItem' id="p${text_num1}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id='p${text_num1+1}' onclick='del_sel(this)'></p>`
					                    }
					                    $('#selectData').css('display','none')
					                }else{
					                    display(class_list[0])
					                    if($('.selectDiv>div').html()==''){
					                        str=`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
					                    }else{
					                        $('.del_sel').remove()
					                        str=`<p class='selectItem' id="p${text_num1}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id="p${text_num1+1}" onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
					                    }
					                }
					            }else{
					                if(class_list.length == 0){ // 该分类没有下级
					                    if($('.selectDiv>div').html()==''){
					                        str=`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'></p>`
					                    }else{
					                        $('.del_sel').remove()
					                        str=`<p class='selectItem' id="p${text_num}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id='p${text_num+1}' onclick='del_sel(this)'></p>`
					                    }
					                    $('#selectData').css('display','none')
					                }else{
					                    display(class_list[0])
					                    if($('.selectDiv>div').html()==''){
					                        str=`<p class='selectItem' id='p1' tyid='${cid}' onclick='del_sel(this,${level},${cid})'>${text}</p><p class='selectItem del_sel' id='p2' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
					                    }else{
					                        $('.del_sel').remove()
					                        str=`<p class='selectItem' id="p${text_num}" tyid='${cid}' onclick='del_sel(this,${level},${cid})'><span>&gt;</span>${text}</p><p class='selectItem del_sel' id="p${text_num+1}" onclick='del_sel(this)'><span>&gt;</span>请选择</p>`
					                    }
					                }
					            }
					            $('.selectDiv>div').append(str)
					        }else{
					            display(class_list[0])
					        }
					
					        for(var i=0;i<brand_list.length;i++){
					            if(brand_list[i].status == true){
					                rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
					            }else{
					                rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
					            }
					        }
					        $('#brand_class').append(rew)
					    },
						complete(XHR, TS){
							// 无论请求成功还是失败,都要把判断条件改回去
							choose_class=true
						}
					});
				}
            }
            // 显示分类
            function display(class_list) {
                var res = '';
                for(var i=0;i<class_list.length;i++){
                    if(class_list[i].status == true){
                        res += `<li class='active' value='${class_list[i].cid}' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},'')">${class_list[i].pname}</li>`;
                        continue
                    }
                    res += `<li value='${class_list[i].cid}' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},'')">${class_list[i].pname}</li>`;
                }
                $('#selectData_1').append(res)
            }
			// 删除选中的类别
			function del_sel(me,level,cid){
				if(cid){
                    if(level == 0){
                        var cid1 = 0;
                        class_level(me,level,cid1,'type')
                    }else{
                        var cid1 = $('#p'+level).eq(0).attr('tyid');
                        class_level(me,level-1,cid1,'type')
                    }
                    $(me).nextAll().remove()
                    $(me).remove()
                    if($('.selectDiv>div').html()==''){
                        $('.selectDiv option').text('请选择商品类别').attr('value',0)
                    }else{
                        if(cid1 == 0){
                            $('.selectDiv option').text('请选择商品类别').attr('value',cid1)
                        }else{
                            $('.selectDiv option').text('').attr('value',cid1)
                            $('.selectDiv>div').append(`<p class='selectItem del_sel' onclick='del_sel(this)'><span>&gt;</span>请选择</p>`)
                        }
                    }
                    if(level){
                        event.stopPropagation()
                    }
                }
			}

            var num = 0;
			var _chooseVal = '';//选中的数据
			var _chooseText = '';//选中的数据
			var attrFlag=true  //控制添加属性只能点一次
			// 点击添加属性按钮 
			$('.Attribute').on('click',()=>{
				if(attrFlag){
					attrFlag=false
					var price1 = $("input[name='initial[cbj]']").val() //成本价
					var price2 = $("input[name='initial[yj]']").val() //原价
					var price3 = $("input[name='initial[sj]']").val() //售价
					var size = $("#unit").val() //单位
					var kucun = $("input[name='initial[kucun]']").val() //库存
					
					if(!(price1&&price2&&price3&&size!=0&&kucun)){
						layer.msg("商品属性不能为空！");
						attrFlag=true
						return
					}
					$.ajax({
					    type: "GET",
					    url: 'index.php?module=product&action=Ajax&m=attribute',
					    data: {
					        "strArr":page.attrTitle
						},
					    success: function (msg) {
					        var obj = JSON.parse(msg)
					        var attribute = obj.attribute
							var res = '';
					        var rew = '';
					        if(obj.rew){
					            var list = obj.rew
								var num1 = 0;
					            for(var i in list){
					                rew += `<div class='attr-size' id="attribute_${num1}">${i}</div>
					                <div class='form_new_r' id="attribute-${num1}" style='margin-left: 2px;'>`;
					                for(var j in list[i]){
					                    if(list[i][j].status == true){
					                        rew += `<div class="ra1">
												   <input name='attribute[]' id="attribute_${num1}-${j}" type="checkbox" checked value="${list[i][j].value}" title="${i}" class="inputC">
												   <label for="attribute_${num1}-${j}">${list[i][j].value}</label>
												</div>`;
					                    }else{
					                        rew += `<div class="ra1">
												   <input name='attribute[]' id="attribute_${num1}-${j}" type="checkbox" value="${list[i][j].value}" title="${i}" class="inputC">
												   <label for="attribute_${num1}-${j}">${list[i][j].value}</label>
												</div>`;
					                    }
									}
					                rew += `</div>`
					                num1 = num1+1;
								}
					        }
					        var _chooseVal_0 = _chooseVal.split(',');
					        for(var i in attribute){
                                if(in_array(attribute[i]['text'],_chooseVal_0)){
                                    //selFlag 控制选择属性时候,在属性还没有加载到页面中之前不能取消选择
                                    res += `<li class="active selFlag" value="${attribute[i]['text']}">${attribute[i]['text']}</li>`;
                                }else{
                                    res += `<li class="selFlag" value="${attribute[i]['text']}">${attribute[i]['text']}</li>`;
                                }
					        }
							
							$("body",parent.document).append(`<div class="maskNew">
								<div class="maskNewContent mask-content">
								   <p class='mask-title'>添加属性</p>
								   <div class='mask-content-data'>
									  <div style='position: relative;display: flex;align-items: center;'>
										<label style='margin: 0;'>请选择属性名称：</label>
										<select name="attribute" id="attribute" value='${_chooseVal}'>
											<option selected="true" value="0">${_chooseText?_chooseText:'请选择'}</option>
										</select>
										<div class='chooser_attr'></div>
										<ul style='display:none'>
											${res}
										</ul>
									  </div>
									  ${rew}
								   </div>
								   <div class='mask-bottom'>
										<input type="button" value='取消'>
										<input type="button" value='添加'>
								   </div>
								</div>
							</div>`)
                            $("body",parent.document).find('.mask-bottom input[value=添加]').on('click',function(){
                                // 获取选中的属性名称的value值————颜色,尺寸
                                var _attr=$(this).parents('.maskNew').find('.inputC:checked')

                                // 规格标题————颜色,尺寸
                                var sizeTitleArr = $(this).parents('.maskNew').find('select[name=attribute]').attr('value').split(',')
                                var title = $(this).parents('.maskNew').find('select[name=attribute] option').eq(0).text().split(',');
                                /** 属性名数组开始 **/
                                // 表格标题的数据
                                th_title=[]
                                // 最终需要渲染的数据
                                var strArr=[]
                                for(var i=0;i<title.length;i++){
                                    th_title.push({attr_group_name:title[i],attr_list:[],isShow:false})
                                    for(var j=0;j<_attr.length;j++){
                                        if($(_attr).eq(j).attr('title')==title[i]){
                                            th_title[i].attr_list.push({'attr_name':$(_attr).eq(j).val(),'chooseMe':true})
                                        }
                                    }
                                }
                                /** 属性名数组结束 **/
                                for(var i=0;i<th_title.length;i++){
                                    if(th_title[i].attr_list.length == 0){
                                        $(this).parents('.maskNew').append(`
							<div id='attr_tc' style='position: fixed; top: 50%; left: 50%; margin-left: -50px; margin-top: -15px; width: 100px; height: 30px; line-height: 30px; background: rgba(0,0,0,0.6); color: #fff; text-align: center; border-radius: 3px;'>请选择属性</div>
						`)
                                        setTimeout(()=>{
                                            $(this).parents('.maskNew').find('#attr_tc').remove()
                                        },1000)
                                        return
                                    }
                                }
                                page.attrTitle = th_title

                                // 求出表格中总共有多少行
                                var listX=1
                                for(var i=0;i<th_title.length;i++){
                                    listX=th_title[i].attr_list.length*listX
                                }

                                var price1 = $("input[name='initial[cbj]']").val() //成本价
                                var price2 = $("input[name='initial[yj]']").val() //原价
                                var price3 = $("input[name='initial[sj]']").val() //售价
                                var size = $("#unit").val() //单位
                                var kucun = $("input[name='initial[kucun]']").val() //库存
                                for(var i=0;i<listX;i++){
                                    strArr.push({
                                        "cbj":price1,
                                        "yj":price2,
                                        "sj":price3,
                                        "unit":size,
                                        "kucun":kucun,
                                        "image":'', //图片
                                        "bar_code": '',// 条形码
                                        "attr_list":[]
                                    })
                                }

                                var _listX = listX  //代表当前属性有多少行,默认为总行数
                                function digui(i){
                                    var xx=0  // 代表当前行数
                                    var name=th_title[i].attr_group_name  //代表当前规格的标题,比如颜色/大小
                                    //listX为表格总行数
                                    if(i==0){
                                        // 如果当前规格是第一个
                                        // 当前规格有多少个,比如颜色,有蓝色白色两个
                                        for(var j=0;j<th_title[i].attr_list.length;j++){
                                            var value=th_title[i].attr_list[j].attr_name
                                            // 总行数除当前规格的个数,得出当前规格每个占多少行,比如白色白色白色,黑色黑色黑色
                                            for(var x=0;x<listX/th_title[i].attr_list.length;x++){
                                                strArr[xx].attr_list.push({'attr_id':'','attr_name':value,'attr_group_name':name})
                                                xx++
                                            }
                                        }
                                    }else if(i<th_title.length-1){
                                        // 如果当前规格不是最后一个
                                        // 当前规格的前一个每个属性有多少行,即当前规格和后面规格相乘的总行数
                                        _listX = Math.round(_listX/th_title[i-1].attr_list.length)

                                        // 外面这层循环代表当前属性在内循环完成之后进入新的循环,比如白色白色黑色黑色红色红色,完成之后再次白色白色黑色黑色红色红色循环,总行数除以前一个属性每个属性有多少行,得出总循环数
                                        for(var l=0;l<listX/_listX;l++){
                                            for(var j=0;j<th_title[i].attr_list.length;j++){
                                                var value=th_title[i].attr_list[j].attr_name
                                                // 当前规格的前一个每个属性行数,除当前
                                                for(var x=0;x<_listX/th_title[i].attr_list.length;x++){
                                                    strArr[xx].attr_list.push({'attr_id':'','attr_name':value,'attr_group_name':name})
                                                    xx++
                                                }
                                            }
                                        }
                                    }else{
                                        // 如果当前规格属性是最后一个,格式是x,l,xl x,l,xl循环
                                        for(var x=0;x<listX/th_title[i].attr_list.length;x++){
                                            for(var j=0;j<th_title[i].attr_list.length;j++){
                                                var value=th_title[i].attr_list[j].attr_name
                                                strArr[xx].attr_list.push({'attr_id':'','attr_name':value,'attr_group_name':name})
                                                xx++
                                            }
                                        }
                                    }
                                    i++
                                    if(i<th_title.length){
                                        digui(i)
                                    }
                                }

                                digui(0)
                                // 输出所有选中的选项
                                page.strArr = strArr
                                // 关闭弹窗
                                $(this).parents('.maskNew').remove()
                                // 重新设置添加属性可以点击
                                attrFlag=true
                            })
                            // 点击显示属性选择框
                            $("body",parent.document).find('.mask-content-data .chooser_attr').on('click',function(){
                                $(this).next().toggle()
                            })
                            $("body",parent.document).find('.mask-content-data ul li').on('click',function(){
                                if($(this).hasClass('selFlag')){
                                    $(this).toggleClass('selFlag')
                                    $(this).toggleClass('active')
                                    if($(this).hasClass('active')){
                                        // 选中,则在输入框中添加
                                        var str = $(this).text()
                                        var val = $(this).attr('value')
                                        var newVal = val
                                        var oldVal = $(this).parents('div').find('#attribute').attr('value')
                                        var oldStr = $(this).parents('div').find('#attribute option').text()
                                        if(oldVal){
                                            val = oldVal+','+val
                                            str = oldStr + ',' +str
                                        }
                                        _chooseVal = val
                                        _chooseText = str

                                        $(this).parents('div').find('#attribute option').text(str)
                                        $(this).parents('div').find('#attribute').attr('value',val)

                                        // 请求数据
                                        var attribute_name = newVal;
                                        var _str=attribute_name
                                        $(this).attr('checkValue',_str)
                                        var me =this
                                        $.ajax({
                                            type: "GET",
                                            url: 'index.php?module=product&action=Ajax&m=attribute_name',
                                            data: {
                                                "attribute_name":attribute_name
                                            },
                                            success: function (msg) {
                                                var obj = JSON.parse(msg)
                                                var attribute_value = obj.attribute_value
                                                var rew = `<div class='attr-size' id="attribute_${num}">${attribute_name}</div>
								<div class='form_new_r' id="attribute-${num}" style='margin-left: 2px;'>`;
                                                for(var i in attribute_value){
                                                    if(attribute_value[i].status == true){
                                                        rew += `<div class="ra1">
											   <input name='attribute[]' id="attribute_${num}-${i}" type="checkbox" checked value="${attribute_value[i].value}" title="${attribute_name}" class="inputC">
											   <label for="attribute_${num}-${i}">${attribute_value[i].value}</label>
											</div>`;
                                                    }else{
                                                        rew += `<div class="ra1">
											   <input name='attribute[]' id="attribute_${num}-${i}" type="checkbox" value="${attribute_value[i].value}" title="${attribute_name}" class="inputC">
											   <label for="attribute_${num}-${i}">${attribute_value[i].value}</label>
											</div>`;
                                                    }

                                                }
                                                rew += `</div>`
                                                num = num+1;
                                                $(me).parents('.mask-content-data').append(rew)

                                                $(me).toggleClass('selFlag')
                                            }
                                        });
                                    }else{
                                        // 取消选中,则删除输入框中对应的项
                                        var str = $(this).text()
                                        var val = $(this).attr('value')
                                        var removeVal=val
                                        var oldVal = $(this).parents('div').find('#attribute').attr('value')
                                        var oldStr = $(this).parents('div').find('#attribute option').text()
                                        str = oldStr.replace(','+str,'').replace(str+',','').replace(str,'')
                                        val = oldVal.replace(','+val,'').replace(val+',','').replace(val,'')
                                        if(val==''){
                                            str = '请选择'
                                        }
                                        _chooseVal = val
                                        _chooseText = str
                                        $(this).parents('div').find('#attribute option').text(str)
                                        $(this).parents('div').find('#attribute').attr('value',val)
                                        // 删除属性
                                        var attrArr = $(this).parents('.mask-content-data').find('.attr-size')
                                        for(var i=0;i<$(attrArr).length;i++){
                                            if($(attrArr).eq(i).text()==removeVal){
                                                $(attrArr).eq(i).next().remove()
                                                $(attrArr).eq(i).remove()
                                                break
                                            }
                                        }

                                        $(this).toggleClass('selFlag')
                                    }
                                }
                            })
                            $("body",parent.document).find('.mask-bottom input[value=取消]').on('click',function(){
                                if(page.strArr.length == 0){
                                    _chooseVal = '',
                                        _chooseText = ''
                                }
                                $(this).parents('.maskNew').remove()
                                attrFlag=true
                            })
					    }
					});
				}
			})


			function in_array(stringToSearch, arrayToSearch) {
				for (s = 0; s < arrayToSearch.length; s++) {
					thisEntry = arrayToSearch[s].toString();
					if (thisEntry == stringToSearch) {
						return true;
					}
				}
				return false;
			}
		</script>
		{/literal}
	</body>

</html>