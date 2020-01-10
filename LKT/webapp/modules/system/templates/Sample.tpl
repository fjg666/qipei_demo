<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<title>系统参数</title>
		<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
		<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
		<link href="style/css/style.css" rel="stylesheet" type="text/css" />
		<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		{include file="../../include_path/nav.tpl" sitename="面包屑"}

		<!--上面的 thead里面对tr加上标签 tab_tr-->
		<!--下面的 thead里面对tr加上标签 tab_td-->

		<!--左边是选择框的加上 tab_imgurl-->
		<!--左边是序号的加上 tab_num-->
		<!--图片的加上 tab_imgurl-->
		<!--标题的加上 tab_title-->
		<!--时间的加上 tab_time-->
		<!--操作列的 两个的加上tab_editor  三个的加上tab_three  五个的加上 tab_five-->
		<!--文字向左加上tab_left-->

		<div class="pd-20 page_absolute">
			<div class="pd_title">表格第一种情况</div>
			<div class="tab_table">
				<table class="table-border tab_content">
					<thead>
						<tr class="text-c tab_tr">
							<th class="tab_label">
								<div class="tab_auto">
									<input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
									<label for="ipt1" ></label>全选
								</div>
							</th>
							<th>商品ID</th>
							<th class="tab_imgurl">商品图片</th>
							<th class="tab_title">商品标题</th>
							<th>分类名称</th>
							<th>库存</th>
							<th>商品状态</th>
							<th>销量</th>
							<th class="tab_time">发布时间</th>
							<th>商品品牌</th>
							<th>价格</th>
							<th class="tab_editor">操作</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-c tab_td">
							<td class="tab_label">
								<div class="tab_auto">
									<input name="id[]" id="{$item->id}" type="checkbox" class="inputC">
									<label for="{$item->id}" style="margin-left: 6px;"></label>
								</div>
							</td>
							<td>1</td>
							<td class="tab_imgurl">
								<img src="images/ditu/logo.jpg">
							</td>
							<td class="tab_title ">加厚垃圾桶防绣铁丝网办公室家用铁网废纸篓垃圾收纳袋筒包邮
								<div class="tab_clear">
									<span class="proSpan xp">新品</span>
									<span class="proSpan rx">热销</span>
									<span class="proSpan tj">推荐</span>
								</div>
							</td>
							<td>搬家必备</td>

							<td>100</td>

							<td class="tan_status">上架</td>

							<td>50</td>
							<td class="tab_time">2019:01:18 11:01</td>
							<td>自主品牌</td>
							<td><span class="tab_span">￥100</span></td>
							<td class="tab_editor">
								<div class="tab_block">
									<a title="查看">
										<img src="images/icon1/ck.png" />&nbsp;查看
									</a>

									<a title="下架">
										<img src="images/icon1/xj.png" />&nbsp;下架
									</a>
								</div>
								<div class="tab_block">

									<a title="修改">
										<img src="images/icon1/xg.png" />&nbsp;修改
									</a>
									<a>
										<img src="images/icon1/del.png" />&nbsp;删除
									</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!--第二种情况的-->
			<div class="pd_title">表格第二种情况</div>
			<div class="tab_table">
				<table class="table-border tab_content">
					<thead>
						<tr class="text-c tab_tr">
							<th class="tab_num">序号</th>
							<th>用户ID</th>
							<th class="tab_imgurl">商品图片</th>
							<th class="tab_title">商品标题</th>
							<th>分类名称</th>
							<th>库存</th>
							<th>商品状态</th>
							<th>销量</th>
							<th class="tab_time">发布时间</th>
							<th>商品品牌</th>
							<th>价格</th>
							<th class="tab_three">操作</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-c tab_td">
							<td class="tab_num">1</td>
							<td>user87</td>
							<td class="tab_imgurl">
								<img src="images/ditu/logo.jpg">
							</td>
							<td class="tab_title ">加厚垃圾桶防绣铁丝网办公室家用铁网废纸篓垃圾收纳袋筒包邮
								<div class="tab_clear">
									<span class="proSpan xp">新品</span>
									<span class="proSpan rx">热销</span>
									<span class="proSpan tj">推荐</span>
								</div>
							</td>
							<td>搬家必备</td>

							<td>100</td>

							<td class="tan_status">上架</td>

							<td>50</td>
							<td class="tab_time">2019:01:18 11:01</td>
							<td>自主品牌</td>
							<td><span class="tab_span">￥100</span></td>
							<td class="tab_three">
								<a title="查看">
									<img src="images/icon1/ck.png" />&nbsp;查看
								</a>
								<a title="下架">
									<img src="images/icon1/xj.png" />&nbsp;下架
								</a>
								<a title="下架">
									<img src="images/icon1/xj.png" />&nbsp;下架
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!--第三种情况的-->
			<div class="pd_title">表格第三种情况</div>
			<div class="tab_table">
				<table class="table-border tab_content">
					<thead>
						<tr class="text-c tab_tr">
							<th class="tab_num">序号</th>
							<th class="tab_imgurl">商品图片</th>
							<th>分类名称</th>
							<th>分类级别</th>
							<th class="tab_time">发布时间</th>
							<th class="tab_three">操作</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-c tab_td">
							<td class="tab_num">1</td>
							<td class="tab_imgurl">
								<img src="images/ditu/logo.jpg">
							</td>
							<td>搬家必备</td>
							<td class="tan_status">二级</td>
							<td class="tab_time">2019:01:18 11:01</td>
							<td class="tab_five">
								<a title="查看">
									<img src="images/icon1/ck.png" />&nbsp;查看
								</a>
								<a title="下架">
									<img src="images/icon1/xj.png" />&nbsp;下架
								</a>
								<a title="下架">
									<img src="images/icon1/xj.png" />&nbsp;下架
								</a>
								<a title="下架">
									<img src="images/icon1/xj.png" />&nbsp;下架
								</a>
								<a title="下架">
									<img src="images/icon1/xj.png" />&nbsp;下架
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!--第四种情况的-->
			<div class="pd_title">第四种情况的</div>
			<div class="tab_table">
				<table class="table-border tab_content">
					<thead>
						<tr class="text-c tab_tr">
							<th class="tab_label">
								<div class="tab_auto tab_v" >
									<input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
									<label for="ipt1"></label>
								</div>
								订单信息
							</th>
							<th>订单总计</th>
							<th>数量</th>

							<th>订单状态</th>
							<th>订单类型</th>
							<th>买家信息</th>
							<th>支付方式</th>
							<th>物流信息</th>
							<th class="tab_dat">操作</th>
						</tr>
					</thead>
					<tbody>
						<tr class="page_h16">
							<td colspan="9"></td>
						</tr>
						<tr class="tab_head">
								
							<td class="tab_left tab_fals" colspan="9">
								<div class="tab_auto tab_v">
									<input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
									<label for="ipt1"></label>
								</div>
								订单编号：111111111111创单时间：2019:01:18 11:01
							</td>
						</tr>
						<tr class="tab_td">
							<td class="tab_news tab_t">
								<div class="tab_good">
									<img src="images/12222.jpg" class="tab_pic">
	                                <div class="goods-info tab_left">
	                                    <div class="goods-name u2523">dsgsdsdgds</div>
	                                    <div class="mt-1">规格：gdsgsdgdsg</div>
	                                    <div class="mt-1">数量：1件 </div>
	                                    <div>小计：1111元 </div>
	                                </div>
									
                                </div>
							</td>

							<td>¥0.01</td>
							<td>1</td>
							<td>●待发货</td>
							<td>普通订单</td>
							<td class="tab_left">
								<p>联系人：阿萨德</p>
								<p>电话：15111111111</p>
								<p>地址：飞洒可发送萨克卡萨</p>
							</td>
							<td>微信小程序支付</td>
							<td class="tab_left">
								<div>物流单号：暂无</div>
								<div>运费：免邮</div>
							</td>
							<td class="tab_dat">
								<a>
									<img src="images/icon1/ck.png" />&nbsp;订单详情
								</a>
								<a>
									<img src="images/iIcon/bianji.png" />&nbsp;编辑订单
								</a>

								<a>
									<img src="images/iIcon/wul.png" />&nbsp;查看物流
								</a>

								<a>
									<img src="images/iIcon/chaa.png" />&nbsp;关闭订单
								</a>

							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			
			<!--导航表格切换-->
			<div class="pd_title">第一种情况的</div>
			<div class="switch_a">
		        <a href="" class="switch_btn">分销商管理</a>
		        <a href="" >分销商等级</a>
		        <a href="" >分销关系修改</a>
		        <a href="">分销设置</a>
		        <a href="">佣金日志</a>
		        <div class=""></div>
		    </div>
		    
		    <!--导航表格切换-->
			<div class="pd_title">第一种情况的</div>
			  <div>
		        <form name="form1" action="index.php" method="get" class="pd_form1">
		            <div>
						<input type="text" name="sNo" size='8' value="{$sNo}" placeholder="请输入订单编号/姓名/电话" class="input-text query_inputs">
	                    <select name="status" class="select query_select">
	                        <option value="">请选择订单状态</option>
	                    </select>
	                    <select name="otype" class="select query_select">
	                        <option value="">请选择订单类型</option>
	                        <option value="" >xzzxvzx</option>
	                    </select>
	                    <select name="source" class="select query_select">
	                        <option value="">请选择订单来源</option>
	                    </select>
	                    <input type="text" class="input-text query_input" value="" placeholder="请输入开始时间" id="startdate" name="startdate" >
	                
	                	<span class="select">至</span>
	                    <input type="text" class="input-text query_input" value="" placeholder="请输入结束时间" id="enddate" name="enddate">
	                    
	                    <input id="btn1" class="query_cont nmor" type="submit" value="查询" >
	                    <input id="btn1" class="query_cont nmor" type="button" value="导出" onclick="excel('all')">
	                    <input type="button" value="批量删除" class="query_cont nmor" onclick="del_orders()" style="width: 80px!important;">
		            </div>
		        </form>
		    </div>
		    
		    
		    <!--弹窗-->
			<div class="pd_title">第一种情况的弹窗:操作失败/警示弹框</div>
			<div class="pup_div" style="display: none;">
				<div class="pup_flex">
					<div class="pup_auto">
						<img src="images/icon1/ts.png" class="pup_imgurl">
						<div class="pup_title">保存失败</div>
						<div class="pup_word">失败原因：XXXX</div>
						<div class="pup_btn"><div class="pup_btn2">知道了</div></div>
					</div>
				</div>
			</div>
			
			<!--弹窗-->
			<div class="pd_title">第二种情况的弹窗:操作确认/警示弹框</div>
			<div class="pup_div" style="display: none;">
				<div class="pup_flex">
					<div class="pup_auto">
						<img src="images/icon1/ts.png" class="pup_imgurl">
						<div class="pup_title">确认删除此订单？</div>
						<div class="pup_btn"> 
							<div class="pup_btn1">取消</div>
							<div class="pup_btn2">删除</div>
						</div>
						
					</div>
				</div>
			</div>
			
			<!--弹窗-->
			<div class="pd_title">第三种情况的弹窗:内容操作弹框</div>
			<div class="pup_div" style="display: none;">
				<div class="pup_flex">
					<div class="pup_auto">
						<div class="pup_head"><span>添加快递信息</span>
							<img src="images/icon/cha.png">
						</div>
						<div class="pup_input">
							<div class="pup_int">
								<span>快递公司：</span>
								<input type="text" placeholder="请选择/输入快递名称">
							</div>
							<div class="pup_int">
								<span>快递单号：</span>
								<input type="text" placeholder="请输入正确的快递单号">
							</div>
						</div>
						<div class="pup_btn pup_right"> 
							<div class="pup_btn1">取消</div>
							<div class="pup_btn2">删除</div>
						</div>
						
					</div>
				</div>
			</div>
			
			<!--弹窗-->
			<div class="pd_title">第四种情况的弹窗:导出</div>
			<div class="pup_div" style="display: none;">
				<div class="pup_flex">
					<div class="pup_auto">
						<div class="pup_head"><span>导出数据</span>
							<img src="images/icon/cha.png">
						</div>
						
						<div class="pup_dc">
							<div class="pup_dcv">
								<div>
									<img src="images/iIcon/scby.png" />
									<p>导出本页</p>
								</div>
							</div>
							<div class="pup_dcv">
								<div>
									<img src="images/iIcon/dcqb.png" />
									<p>导出全部</p>
								</div>
							</div>
							<div class="pup_dcv"> 
								<div>
									<img src="images/iIcon/dcss.png" />
									<p>导出查询</p>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="pd_title">按钮</div>
			<div class="page_bort">
				<input type="button" name="Submit" value="保存" class="fo_btn2">
				<input type="reset" name="reset" value="取消" class="fo_btn1">
			</div>
			
		</div>

		<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>

		<script type="text/javascript" src="style/js/H-ui.js"></script>

	</body>

</html>