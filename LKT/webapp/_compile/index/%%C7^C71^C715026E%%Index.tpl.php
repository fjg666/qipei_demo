<?php /* Smarty version 2.6.31, created on 2019-12-20 15:40:47
         compiled from Index.tpl */ ?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<link href="style/css/dashboard.css" rel="stylesheet" />
		<link rel="stylesheet" href="style/assets/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="style/assets/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="style/assets/vendor/linearicons/style.css">
		<link rel="stylesheet" href="style/assets/vendor/chartist/css/chartist-custom.css">
		<link rel="stylesheet" href="style/assets/css/main.css">
		<link rel="stylesheet" href="style/assets/css/demo.css">
		<link href="style/css/style.css" rel="stylesheet" />
		<link href="style/css/font-awesome.css" rel="stylesheet" />
		<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
		<script src="style/assets/vendor/jquery/jquery.min.js"></script>
		<script src="style/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="style/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="style/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
		<script src="style/assets/vendor/chartist/js/chartist.min.js"></script>
		<script src="style/assets/scripts/klorofil-common.js"></script>
		<script src="style/js/echarts.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="style/js/macarons.js"></script>
		<title>我的桌面</title>
		<?php echo '
		<style type="text/css">
			.leftIcon {
				float: left;
				width: 35%;
				height: 100%;
				text-align: center;
				line-height: 100px;
				border-bottom-left-radius: 5px;
				border-top-left-radius: 5px;
				-moz-border-radius-topleft: 5px;
				-moz-border-radius-bottomleft: 5px;
			}
			
			.row_a .col-md-2 {
				padding: 0 5px;
			}
			
			.rightNum {
				float: left;
				width: 65%;
				height: 100%;
				display: flex;
				align-items: center;
				background: #fff;
				border-bottom-right-radius: 5px;
				border-top-right-radius: 5px;
				-moz-border-radius-topright: 5px;
				-moz-border-radius-bottomright: 5px;
			}
			
			.rightNum div {
				width: 100%;
			}
			
			.rightNum div span {
				display: block;
				width: 100%;
				text-align: center;
			}
			
			.metric {
				height: 100px;
				padding: 0px;
				border: none;
				margin-bottom: 10px;
			}
			
			.number,
			.title {
				font-weight: 600!important;
			}
			
			.percentage {
				display: none;
			}
			
			.main-content {
				padding: 0 5px;
			}
			
			.mainLeft {
				height: 100%;
				float: left;
				width: 40%;
				padding: 0 5px;
			}
			
			.mainRight {
				height: 100%;
				float: left;
				width: 60%;
				padding: 0 5px;
			}
			
			.realDiv {
				width: 100%;
				background: #fff;
				border-radius: 5px;
				height: 240px;
				margin-bottom: 10px;
			}
			
			.tjtDiv {
				width: 100%;
				background: #fff;
				border-radius: 5px;
				margin-bottom: 10px;
			}
			
			.panel-body {
				padding-left: 0px!important;
				padding-right: 0px!important;
			}
			
			.realDivTitle {
				padding: 0px 20px;
				font-size: 16px;
				font-weight: bold;
				font-family: "微软雅黑";
				color: #414658;
				height: 60px;
				line-height: 60px;
			}
			
			.realDivMainNum {
				height: 100px;
				padding: 30px;
				text-align: center;
				vertical-align: bottom;
				border-bottom: 1px solid #eee;
			}
			
			.realDiv3Num {
				height: 60px;
				line-height: 60px;
				margin: 10px 0px;
			}
			
			.realNum3 {
				height: 100%;
				width: 33.33%;
				box-sizing: border-box;
				border-right: 1px solid #eee;
				float: left;
				text-align: center;
				display: flex;
				align-items: center;
			}
			
			.realNum3 p {
				height: 20px;
				line-height: 20px;
				margin-bottom: 31px;
			}
			
			.number {
				font-size: 32px;
				color: #0880ff;
			}
			
			.upText {
				color: #23bf08;
			}
			
			.downText {
				color: #dc3545;
			}
			
			.num {
				font-size: 22px;
				color: #414658;
				margin-bottom: 0px!important;
				position: relative;
				top: -18px;
			}
			
			.numText {
				color: #888f9e;
				font-size: 14px;
			}
			
			.member {
				width: 67%;
				height: 100%;
				border-radius: 5px;
				float: left;
				margin-right: 0.5%;
				background: #fff;
			}
			
			.news {
				width: 32%;
				height: 100%;
				border-radius: 5px;
				float: left;
				margin-left: 0.5%;
				background: #fff;
			}
			
			.title1 {
				position: relative;
				top: -30px;
			}
			
			.title1 a {
				color: #6a7076;
				font-size: 14px;
				font-family: "微软雅黑";
				display: inline-block;
				margin-right: 10px;
			}
			
			.activeTJTBtn {
				color: #0880ff!important;
			}
			
			.tjtDivIn {
				padding: 10px;
			}
			
			.news ul {
				list-style: none;
				padding: 10px;
			}
			
			.news ul li {
				padding: 10px;
				border-bottom: 1px solid #eee;
				height: 70px;
				position: relative;
			}
			
			.news ul li a {
				display: inline-block;
				height: 100%;
				width: 100%;
				position: relative;
			}
			
			.news ul li span {
				color: #414658;
				font-size: 14px;
				overflow: hidden;
				text-overflow: ellipsis;
				display: -webkit-box;
				-webkit-line-clamp: 2;
				-webkit-box-orient: vertical
			}
			
			.newsDate {
				position: absolute;
				right: 0px;
				bottom: -5px;
				font-size: 12px;
				color: #888f9e;
			}
			
			.realNum3 div {
				width: 110%;
			}
			
			.numText {
				/*margin-bottom: 0px!important;*/
			}
			
			.my_mark {
				background: url(\'./images/icon1/mark_0.png\');
				display: inline-block;
				width: 13px;
				height: 13px;
				cursor: pointer;
				/*position: absolute;
                left: 150px;
                top: -2px;*/
				margin-left: 5px;
				margin-bottom: 5px;
			}
			
			.my_mark:hover {
				background: url(\'./images/icon1/mark_1.png\');
			}
			/*.my_mark:hover + .mark_div{
                display: block;
             }*/
			
			.mark_div {
				position: absolute;
				width: 80%;
				height: 30px;
				line-height: 30px;
				background: red;
				left: 85%;
				top: -11px;
				background: #fff;
				box-shadow: 1px 1px 9px rgba(150, 150, 150, 0.8);
				padding-top: -10px;
				display: none;
				z-index: 9999;
			}
			
			.mark_div span {
				width: 10px;
				height: 10px;
				transform: rotate(45deg);
				-ms-transform: rotate(45deg);
				-moz-transform: rotate(45deg);
				-webkit-transform: rotate(45deg);
				-o-transform: rotate(45deg);
				display: inline-block;
				position: absolute;
				top: 11px;
				left: -5px;
				background: white;
				border-left: 1px solid rgba(220, 220, 220, 0.8);
				border-bottom: 1px solid rgba(220, 220, 220, 0.8);
			}

		</style>
		'; ?>

	</head>

	<body>
		<!-- 显示更新 -->
		<div style="position: fixed; left: 35%; top: 222px; width: 400px; z-index: 309; display: none;" class="dialog-simple check-version-dialog artDialog aui-state-focus">
			<div class="aui-outer animated dialogShow">
				<div class="aui-mask"></div>
				<table class="aui-border">
					<tbody>
						<tr>
							<td class="aui-nw"></td>
							<td class="aui-n"></td>
							<td class="aui-ne"></td>
						</tr>
						<tr>
							<td class="aui-w"></td>
							<td class="aui-c">
								<div class="aui-inner">
									<table class="aui-dialog">
										<tbody>
											<tr>
												<td colspan="2" class="aui-header">
													<div class="aui-title-bar dialog-menu" id="check-version-dialog">
														<div class="aui-title" style="cursor: move;">更新提示</div>
														<a class="aui-min"></a>
														<a class="aui-max"></a>
														<a class="aui-close"></a>
													</div>
												</td>
											</tr>
											<tr>
												<td class="aui-icon" style="display: none;">
													<div class="aui-icon-bg" style="background: none;"></div>
												</td>
												<td class="aui-main" style="padding: 0px; width: 330px; height: auto;">
													<div class="aui-content">
														<div class="update-box">
															<div class="title">
																<div class="button-radius">
																	<div class="progress hidden"> <span class="total-size"></span> <span class="download-speed"></span>
																		<div class="progress-bar"></div>
																	</div>
																	<a href="javascript:;" class="update-start"><span>立即更新</span><i class="icon-arrow-right"></i></a>
																</div>
																<a href="javascript:;" class="ver_tips update-self-dialog" target="_blank"><span>自动更新</span></a>
																<a href="javascript:;" class="ver_tips ignore">暂时忽略</a>
																<div class="version">当前版本：<span class="lao_v"></span> | 最新版本：<span class="new_v"></span> <span class="badge" style="background:#f60;">new</span></div>
																<div style="clear:both"></div>
															</div>
															<div class="version-info"> <i>ver <span class="new_v"></span> 更新说明：</i>
																<div class="version-info-content">
																	<p class="content_version">

																	</p>
																	<a class="more" href="index.php" target="_blank" style="position: relative;">查看更多</a>
																	<div style="clear:both"></div>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2" class="aui-footer">
													<div class="aui-buttons" style="display: none;"></div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
							<td class="aui-e"></td>
						</tr>
						<tr>
							<td class="aui-sw"></td>
							<td class="aui-s"></td>
							<td class="aui-se"></td>
						</tr>
					</tbody>
				</table>
				<div class="resize-handle resize-top" resize="top"></div>
				<div class="resize-handle resize-right" resize="right"></div>
				<div class="resize-handle resize-bottom" resize="bottom"></div>
				<div class="resize-handle resize-left" resize="left"></div>
				<div class="resize-handle resize-top-right" resize="top-right"></div>
				<div class="resize-handle resize-bottom-right" resize="bottom-right"></div>
				<div class="resize-handle resize-bottom-left" resize="bottom-left"></div>
				<div class="resize-handle resize-top-left" resize="top-left"></div>
			</div>
		</div>
		<input type="hidden" name="version" id="version" value="<?php echo $this->_tpl_vars['version']; ?>
">
		<!-- 显示更新 -->
		<div class="main" style="background: #edf1f5;">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline" style="background-color: transparent;box-shadow: none;margin-bottom: 0px;">
						<div class="panel-body">
							<input type="hidden" name="day1" value="<?php echo $this->_tpl_vars['today']; ?>
">
							<input type="hidden" name="day2" value="<?php echo $this->_tpl_vars['day_show_1']; ?>
">
							<input type="hidden" name="day3" value="<?php echo $this->_tpl_vars['day_show_2']; ?>
">
							<input type="hidden" name="day4" value="<?php echo $this->_tpl_vars['day_show_3']; ?>
">
							<input type="hidden" name="day5" value="<?php echo $this->_tpl_vars['day_show_4']; ?>
">
							<input type="hidden" name="day6" value="<?php echo $this->_tpl_vars['day_show_5']; ?>
">
							<input type="hidden" name="day7" value="<?php echo $this->_tpl_vars['day_show_6']; ?>
">

							<input type="hidden" name="user_num01" value="<?php echo $this->_tpl_vars['user_num01']; ?>
">
							<input type="hidden" name="user_num02" value="<?php echo $this->_tpl_vars['user_num02']; ?>
">
							<input type="hidden" name="user_num03" value="<?php echo $this->_tpl_vars['user_num03']; ?>
">
							<input type="hidden" name="user_num04" value="<?php echo $this->_tpl_vars['user_num04']; ?>
">
							<input type="hidden" name="user_num05" value="<?php echo $this->_tpl_vars['user_num05']; ?>
">
							<input type="hidden" name="user_num06" value="<?php echo $this->_tpl_vars['user_num06']; ?>
">
							<input type="hidden" name="user_num07" value="<?php echo $this->_tpl_vars['user_num07']; ?>
">
							<input type="hidden" name="user_num" value="<?php echo $this->_tpl_vars['user_num']; ?>
">
							<input type="hidden" name="order01" value="<?php echo $this->_tpl_vars['order01']; ?>
">
							<input type="hidden" name="order02" value="<?php echo $this->_tpl_vars['order02']; ?>
">
							<input type="hidden" name="order03" value="<?php echo $this->_tpl_vars['order03']; ?>
">
							<input type="hidden" name="order04" value="<?php echo $this->_tpl_vars['order04']; ?>
">
							<input type="hidden" name="order05" value="<?php echo $this->_tpl_vars['order05']; ?>
">
							<input type="hidden" name="order06" value="<?php echo $this->_tpl_vars['order06']; ?>
">
							<input type="hidden" name="order07" value="<?php echo $this->_tpl_vars['order07']; ?>
">
							<div class="row">
								<a class="row_a" href="index.php?module=orderslist&status=0&sNo=">
									<div class="col-md-2">
										<div class="metric">

											<div class="leftIcon" style="background: #68c8c7;"><img src="./images/fukuan.png" /></div>
											<div class="rightNum">
												<div>
													<span class="title">待付款</span>
													<span class="number" style="color:#68c8c7 ;"><?php echo $this->_tpl_vars['dfk']; ?>
</span>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</a>
								<a class="row_a" href="index.php?module=orderslist&status=1&sNo=">
									<div class="col-md-2">
										<div class="metric">
											<div class="leftIcon" style="background: #ff6c60;"><img src="./images/fahuo.png" /></div>
											<div class="rightNum">
												<div>
													<span class="title">待发货</span>
													<span class="number" style="color:#ff6c60 ;"><?php echo $this->_tpl_vars['dp']; ?>
</span>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</a>
								<a class="row_a" href="index.php?module=orderslist&status=2&sNo=">
									<div class="col-md-2">
										<div class="metric">
											<div class="leftIcon" style="background: #feb04c;"><img src="./images/shouhuo.png" /></div>
											<div class="rightNum">
												<div>
													<span class="title">待收货</span>
													<span class="number" style="color:#feb04c ;"><?php echo $this->_tpl_vars['yth']; ?>
</span>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</a>
								<a class="row_a" href="index.php?module=orderslist&status=3&sNo=">
									<div class="col-md-2">
										<div class="metric">
											<div class="leftIcon" style="background: #a6d867;"><img src="./images/pingjia.png" /></div>
											<div class="rightNum">
												<div>
													<span class="title">待评价</span>
													<span class="number" style="color:#a6d867 ;"><?php echo $this->_tpl_vars['pj']; ?>
</span>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</a>
								<a class="row_a" href="index.php?module=orderslist&status=4&sNo=">
									<div class="col-md-2">
										<div class="metric">
											<div class="leftIcon" style="background: #57c8f2;"><img src="./images/tuihuo.png" /></div>
											<div class="rightNum">
												<div>·
													<span class="title">退货</span>
													<span class="number" style="color:#57c8f2 ;"><?php echo $this->_tpl_vars['th']; ?>
</span>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</a>
							</div>
							<div class="row">
								<div class="mainLeft">
									<div class="realDiv">
										<div class="realDivTitle">今日营业额</div>
										<div class="realDivMainNum">
											<span class="number"><?php echo $this->_tpl_vars['day_yy']; ?>
 </span>
											<span class="percentage">
                                        <?php if ($this->_tpl_vars['yingye_day'] > 0): ?>
                                            <i class="fa fa-caret-up text-success"></i>
                                        <?php else: ?>
                                        <i class="fa fa-caret-down text-danger"></i>
                                        <?php endif; ?>
                                        <span class="<?php if ($this->_tpl_vars['yingye_day'] > 0): ?>upText<?php else: ?>downText<?php endif; ?>">
                                            <?php echo $this->_tpl_vars['yingye_day']; ?>

                                        </span>
											</span>
										</div>
										<div class="realDiv3Num">
											<!--<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
									  Popover on 左侧
									</button>-->
											<div class="realNum3">
												<div class="numText_copy" style="position: relative;">
													<p class="numText">昨日营业额<span class="my_mark" id="mark_img_1"></span></p>
													<div class="mark_div" id="mark_img_11"><span></span>昨日的有效订单金额</div>
													<p class="num"><?php echo $this->_tpl_vars['yes_yy']; ?>
</p>
												</div>
											</div>
											<div class="realNum3">
												<div class="numText_copy" style="position: relative;">
													<p class="numText">本月营业额<span class="my_mark" id="mark_img_2"></span></p>
													<div class="mark_div" id="mark_img_22"><span></span>本月的有效订单总金额</div>
													<p class="num"><?php echo $this->_tpl_vars['tm01']; ?>
</p>
												</div>
											</div>
											<div class="realNum3">
												<div class="numText_copy" style="position: relative;">
													<p class="numText">累计营业额<span class="my_mark" id="mark_img_3"></span></p>
													<div class="mark_div" id="mark_img_33"><span></span>自开店以来的累积营业额</div>
													<p class="num"><?php echo $this->_tpl_vars['tm02']; ?>
</p>

												</div>
											</div>

											<div class="clearfix"></div>
										</div>
									</div>
									<div class="realDiv">
										<div class="realDivTitle">今日订单数</div>
										<div class="realDivMainNum">
											<span class="number"><?php echo $this->_tpl_vars['daydd']; ?>
</span>
											<span class="percentage">
                                        <?php if ($this->_tpl_vars['dingdan_day'] > 0): ?>
                                            <i class="fa fa-caret-up text-success"></i>
                                        <?php else: ?>
                                        <i class="fa fa-caret-down text-danger"></i>
                                        <?php endif; ?>
                                        <span class="<?php if ($this->_tpl_vars['dingdan_day'] > 0): ?>upText<?php else: ?>downText<?php endif; ?>">
                                            <?php echo $this->_tpl_vars['dingdan_day']; ?>

                                        </span>
											</span>
										</div>
										<div class="realDiv3Num">
											<div class="realNum3">
												<div>
													<p class="numText">昨日订单</p>
													<p class="num"><?php echo $this->_tpl_vars['yesdd']; ?>
</p>

												</div>
											</div>
											<div class="realNum3">
												<div>
													<p class="numText">本月订单</p>
													<p class="num"><?php echo $this->_tpl_vars['tm']; ?>
</p>

												</div>
											</div>

											<div class="realNum3" style="border:none">
												<div>
													<p class="numText">累计订单</p>
													<p class="num"><?php echo $this->_tpl_vars['leiji_dd']; ?>
</p>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="realDiv">
										<div class="realDivTitle">今日访客数</div>
										<div class="realDivMainNum">
											<span class="number"><?php echo $this->_tpl_vars['fangke01']; ?>
</span>
											<span class="percentage">
                                        <?php if ($this->_tpl_vars['fangkebizhi'] > 0): ?>
                                            <i class="fa fa-caret-up text-success"></i>
                                        <?php else: ?>
                                        <i class="fa fa-caret-down text-danger"></i>
                                        <?php endif; ?>
                                        <span class="<?php if ($this->_tpl_vars['fangkebizhi'] > 0): ?>upText<?php else: ?>downText<?php endif; ?>">
                                            <?php echo $this->_tpl_vars['fangkebizhi']; ?>

                                        </span>
											</span>
										</div>
										<div class="realDiv3Num">
											<div class="realNum3">
												<div>
													<p class="numText">昨日访客</p>
													<p class="num"><?php echo $this->_tpl_vars['fangke02']; ?>
</p>

												</div>
											</div>
											<div class="realNum3">
												<div>
													<p class="numText">本月访客</p>
													<p class="num"><?php echo $this->_tpl_vars['fangke03']; ?>
</p>

												</div>
											</div>
											<div class="realNum3" style="border:none">
												<div>
													<p class="numText">累计访客</p>
													<p class="num"><?php echo $this->_tpl_vars['fangke']; ?>
</p>

												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								<div class="mainRight">
									<div class="tjtDiv" style="height: 315px;background: transparent;">
										<div class="member">
											<div class="realDivTitle">会员统计</div>
											<div class="title1" style="float: right; margin-right: 20px">累计会员: <?php echo $this->_tpl_vars['user_num']; ?>
 人</div>
											<div class="tjtDivIn" id="memberTJT" style="height:240px;margin: 0 auto;">

											</div>
										</div>
										<div class="news">
											<div class="realDivTitle" style="border-bottom: 2px solid #eee;">公告</div>
											<ul style="height: 240px;">
												<?php $_from = $this->_tpl_vars['res_notice']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item1']):
        $this->_foreach['f1']['iteration']++;
?>
												<li>
													<a href="index.php?module=notice&action=article&id=<?php echo $this->_tpl_vars['item1']->id; ?>
">
														<span><?php echo $this->_tpl_vars['item1']->name; ?>
</span>
														<div class="newsDate"><?php echo $this->_tpl_vars['item1']->time; ?>
</div>
													</a>
												</li>
												<?php endforeach; endif; unset($_from); ?>
											</ul>
										</div>
										<div class="tjtDivIn" class="clearfix"></div>
									</div>
									<div class="tjtDiv" style="height: 415px;">
										<div class="realDivTitle">订单统计</div>
										<div class="title1" style="float: right; margin-right: 20px">
											<a href="javacript:void(0)" class="activeTJTBtn">最近七天</a>

										</div>
										<div class="tjtDivIn" id="ddTJT" style="height:345px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<?php echo '
		<script type="text/javascript">
			$(document).ready(function(){
				$(\'#mark_img_1\').mouseover(function(){$(\'#mark_img_11\').show();})
				$(\'#mark_img_1\').mouseout(function(){$(\'#mark_img_11\').hide();})
				$(\'#mark_img_2\').mouseover(function(){$(\'#mark_img_22\').show();})
				$(\'#mark_img_2\').mouseout(function(){$(\'#mark_img_22\').hide();})
				$(\'#mark_img_3\').mouseover(function(){$(\'#mark_img_33\').show();})
				$(\'#mark_img_3\').mouseout(function(){$(\'#mark_img_33\').hide();})
			})

			$(function() {
				var data, options;

				var day1 = $(\'input[name=day1]\').val(); // 今天
				var day2 = $(\'input[name=day2]\').val(); // 昨天
				var day3 = $(\'input[name=day3]\').val(); // 前天
				var day4 = $(\'input[name=day4]\').val(); // 4天
				var day5 = $(\'input[name=day5]\').val(); // 5天
				var day6 = $(\'input[name=day6]\').val(); // 6天
				var day7 = $(\'input[name=day7]\').val(); // 7天

				var user_num01 = $(\'input[name=user_num01]\').val(); // 今天注册人数
				var user_num02 = $(\'input[name=user_num02]\').val(); // 昨天注册人数
				var user_num03 = $(\'input[name=user_num03]\').val(); // 前天注册人数
				var user_num04 = $(\'input[name=user_num04]\').val(); // 4天前注册人数
				var user_num05 = $(\'input[name=user_num05]\').val(); // 5天前注册人数
				var user_num06 = $(\'input[name=user_num06]\').val(); // 6天前注册人数
				var user_num07 = $(\'input[name=user_num07]\').val(); // 7天前注册人数
				var user_num = $(\'input[name=user_num]\').val(); // 会员总数
				var order01 = $(\'input[name=order01]\').val(); // 今天注册人数
				var order02 = $(\'input[name=order02]\').val(); // 昨天注册人数
				var order03 = $(\'input[name=order03]\').val(); // 前天注册人数
				var order04 = $(\'input[name=order04]\').val(); // 4天前注册人数
				var order05 = $(\'input[name=order05]\').val(); // 5天前注册人数
				var order06 = $(\'input[name=order06]\').val(); // 6天前注册人数
				var order07 = $(\'input[name=order07]\').val(); // 7天前注册人数
				   
				var myChart = echarts.init(document.getElementById(\'memberTJT\'), \'macarons\');
				myChart.setOption({
					xAxis: {
						data: [day7, day6, day5, day4, day3, day2, day1]
					},
					yAxis: {
						splitLine: {
							show: false
						},
						min: 0,
						minInterval: 10,
					},
					grid: {
						top: 10,
						bottom: 20,
						left: 40,
						right: 20,
					},
					tooltip: {
						formatter: " {a} <br/> {c} "
					},
					series: {
						name: "会员人数",
						data: [
							[day7, user_num07],
							[day6, user_num06],
							[day5, user_num05],
							[day4, user_num04],
							[day3, user_num03],
							[day2, user_num02],
							[day1, user_num01],
						],
						type: "bar",

					},
					color: "#0880ff",

				});
				//          new Chartist.Line(\'#memberTJT\', data, options);
				var myChart1 = echarts.init(document.getElementById(\'ddTJT\'), \'macarons\');
				myChart1.setOption({
					xAxis: {
						data: [day7, day6, day5, day4, day3, day2, day1]
					},
					yAxis: {
						splitLine: {
							show: false
						},
						min: 0,
						minInterval: 1,
					},
					grid: {
						top: 10,
						bottom: 20,
						left: 40,
						right: 20,
					},
					tooltip: {
						formatter: " {a} <br/> {c} "
					},
					color: "#0880ff",
					series: {
						name: "订单数量",
						data: [
							[day7, order07],
							[day6, order06],
							[day5, order05],
							[day4, order04],
							[day3, order03],
							[day2, order02],
							[day1, order01],
						],
						type: "line",
					}
				});
				//          new Chartist.Bar(\'#ddTJT\', data,{
				//              axisX: {
				//                  showGrid: false,
				//
				//              },
				//              axisY: {
				//                  showGrid: false,
				//                  onlyInteger: true,
				//                  offset: 0,
				//              },
				//              chartPadding: {
				//                  left: 20,
				//                  right: 20
				//              },
				//          });
				//          chack_update();
			});

			//关闭更新
			$(".aui-close").click(function() {
				$(".dialog-simple").hide();
			});
			$(".ignore").click(function() {
				$(".dialog-simple").hide();
			});

			//立即更新
			$(".update-start").click(function() {
				var that = $(this);
				that.find("span").text(\'下载中,请稍后..\');
				$.ajax({
					url: "index.php?module=index&upgrade=1&download=true",
					cache: false,
					success: function(res) {
						if(res) {
							var lkt_web_version = $(".lkt_web_version").val();
							var r = confirm("下载成功,是否立即更新?");
							if(r == true) {
								parent.location.href = \'../index.php?updata=\' + lkt_web_version;
							} else {
								$(".dialog-simple").hide();
							}

						} else {
							alert(\'下载失败！\');
						}

					}
				});
			});

			function chack_update() {
				var version = $("#version").val();
				$.ajax({
					url: "index.php?module=index&upgrade=" + version,
					cache: false,
					success: function(res) {
						obj = JSON.parse(res);
						var status = obj.status;
						if(status == 1) {
							var new_v = obj.lkt_web_version;
							var v_content = obj.detail;
							$(".lao_v").text(version);
							$(".new_v").text(new_v);
							$(".content_version").append(v_content);

							$(".dialog-simple").show();
						} else {
							$(".dialog-simple").hide();
						}

					}
				});
			}
			console.log(document.getElementById("skin"));
		</script>
		'; ?>

	</body>

</html>