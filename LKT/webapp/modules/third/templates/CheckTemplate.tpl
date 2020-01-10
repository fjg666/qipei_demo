<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<link href="style/css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style/css/check_template.css" />
		<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
		
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
		<title>系统参数</title>
	</head>

	<body class="body_bgcolor">
		

		<div class="titile">
			小程序设置 > 授权设置 > 设计小程序
		</div>
		<nav class="topnav">
			<div class="navleft">
				选择模板
			</div>
			<div class="navright">
				自定义模板
			</div>
		</nav>
		<div class="box">
			<section class="designleft">
				<div class="content">
					<h1>预览模板效果</h1>
					<img id="preSrc" src="style/images/imags/boardImg.png">
				</div>
			</section>
			<div class="lrClass">
			<section class="designright">
				<div id="tab">
					<ul>
						{foreach from = $trade_all item = item key = k}
						<li  class="off pid{$item->trade_code} pid " trade_code = "{$item->trade_code}">{$item->trade_text}</li>
						{/foreach}
						<!-- <li class="off">餐饮</li> -->
						
					</ul>
					<div id="firstPage" class="show outer-div">
						
						
						<section class="imgs"   >
							{foreach from=$res item=item name=f1 key=k}
                         
							<section {if $k == 0}{/if} class="img kid{$item->trade_data} kid" trade_code="{$item->trade_data}">
								<input type="hidden" name="template_id" value="{$item->template_id}">
								<img class="dangPic" src="{$item->image}">
								<!--立即使用弹框-->
								<div class="cover-div">
									<button class="nowUse">立即使用</button>
								</div>
								<!--打勾-->
								<div class="select-div">
									<div class="sanjiao"></div>
									<div class="gou">√</div>
								</div>
							
						    </section>
						    {/foreach}
						    </section>
					
							

							
						
					</div>
					<div id="secondPage" class="hide outer-div">
						<section class="imgs">
							<section class="img">
								<img class="dangPic" src="style/images/imags/boardImg.png">
								<!--立即使用弹框-->
								<div class="cover-div">
									<button class="nowUse">立即使用</button>
								</div>
								<!--打勾-->
								<div class="select-div">
									<div class="sanjiao"></div>
									<div class="gou">√</div>
								</div>
							</section>
							<section class="img">
								<img class="dangPic" src="style/images/imags/boardImg.png">
								<!--立即使用弹框-->
								<div class="cover-div">
									<button class="nowUse">立即使用</button>
								</div>
								<!--打勾-->
								<div class="select-div">
									<div class="sanjiao"></div>
									<div class="gou">√</div>
								</div>
							</section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
						</section>
					</div>
					<div id="thirdPage" class="hide outer-div">
						<section class="imgs">
							<section class="img"><img class="dangPic" src="style/images/imags/boardImg.png"></section>
							<section class="img"><img class="dangPic" src="style/images/imags/boardImg.png"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
						</section>
					</div>
					<div id="thirdPage" class="hide outer-div">
						<section class="imgs">
							<section class="img"><img class="dangPic" src="style/images/imags/boardImg.png"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
						</section>
					</div>
					<div id="thirdPage" class="hide outer-div">
						<section class="imgs">
							<section class="img"><img class="dangPic" src="style/images/imags/boardImg.png">
							</section>

							<section class="img"><img class="dangPic" src="style/images/imags/boardImg.png"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
							<section class="img"></section>
						</section>
					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
					<div id="thirdPage" class="hide outer-div">

					</div>
				</div>

			</section>
			</div>
			<input type="hidden" name="status" id="status" value="{$status}">
			<div id="buttons">
				{if $status === 0}
				   <button type="button" id="issue" onclick="fabu({$auditid})" >发布</button>
				{else}
				   <button type="button" id="issue" onclick="del()"  {if $status == 2}disabled="disabled"{/if}>审核发布</button>
				{/if}

				<button type="button" id="cancel" onclick="calChoose()">取消</button>
			
				
			</div>
		</div>

		       <div class="maskNew" style="display: none;">
	            <div class="maskNewContent" style="width: 345px;
		height: 270px!important;
		margin: 0 auto;
		position: relative;
		font-size: 18px;
		top: 30%;
		background: #fff;
		border-radius: 10px;
		padding-top: 10px;
		box-sizing: border-box;">
	                <div class="maskTitle">发布</div>
	                <div style="text-align:center;margin-top:30px"><img style="width:36px;height:36px;" src="images/icon1/ts.png"></div>
	                <div style="font-size: 16px;
	    text-align: center;
	    margin-top: 14px;">
	
	                    确定要审核发布吗？

						<p style="margin: 20px auto;
	    text-align: left;
	    margin-left: 30px;
	    font-size: 14px;
	    font-family: MicrosoftYaHei;
	    font-weight: 400;
	    color: rgba(151,160,180,1);
	    line-height: 22px;">
	                            1、微信官方审核需要1-5天，结果将微信通知。<br>
								2、审核通过后，将立即更新到线上。<br>
								3、审核期间，不支持再提交审核发布。<br>
	                        </p>
	                </div>
	                <div style="text-align:center;">
	                    <button class="closeMask" style="margin-right:20px" onclick="check_template()">确认</button>
	                    <button class="closeMask" onclick= "my_cansel()">取消</button>
	                </div>
	            </div>
	        </div>

	 <script type="text/javascript" src="style/js/layer/layer.js"></script>  
	 <script src="style/js/check_template.js" type="text/javascript" charset="utf-8"></script>     
	
	</body>

</html>