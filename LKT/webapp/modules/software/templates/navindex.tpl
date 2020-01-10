<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>首页导航图标</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
		
		{literal}
		<style>
			.panel-body .left {
				max-width: 153px;
				width: 300px;
				border: 1px solid #eee;
				/*background-color: #f4f5f9;*/
			}

			.left .item {
				width: 100%;
				padding: 0 10px;
				line-height: 40px;
				cursor: pointer;
			}

			.text-more {
				display: inline-block;
				width: 70%;
				overflow: hidden;
				white-space: nowrap;
				text-overflow: ellipsis;
				word-break: break-all;
			}

			.left .item:first-child {
				background-color: #fff;
			}

			.left .item.active {
				background-color: #fff;
			}

			.left .item:hover {
				background-color: #fff;
			}

			.item-icon {
				width: 1rem;
				height: 1rem;
				line-height: 1;
				font-size: 1.3rem;
			}

			.file-item .mask {
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				z-index: 5;
				background-color: rgba(0, 0, 0, .5);
				text-align: center;
				background-image: url('style/diy_img/icon-file-gou.png');
				background-size: 40px 40px;
				background-repeat: no-repeat;
				background-position: center;
			}

			.panel .panel-header {
				border: none;
			}

			.panel .panel-header .nav.nav-right {
				float: left;
				margin-top: 24px;
			}

			.panel .panel-header .nav-link {
				padding: 0;
			}

			.panel-header>p {
				font-size: 16px;
				margin-bottom: 0;
			}

			.nav-item>a {
				color: #fff;
				width: 112px;
				line-height: 36px;
				padding: 0;
				background-color: #38B4ED;
				font-size: 14px;
				text-align: center;
				border-radius: 2px;
			}

			.nav_span {
				border: 1px solid #fff;
				width: 14px;
				line-height: 14px;
				display: inline-block;
				text-align: center;
				font-size: 15px;
			}

			.panel .panel-body {
				padding: 10px;
			}

			.table-bordered td,
			.table-bordered th,
			.table-bordered {
				border: none;
				text-align: center;
				font-size: 14px;
				color: #414658;
			}

			.table th {
				padding: 0 25px;
				line-height: 60px;
			}

			.table td {
				padding: 0 25px;
				line-height: 90px;
			}

			.nav_tr:hover {
				margin: 0 20px;
			}

			.nav_tr:hover {
				background-color: #EFF8FF;
			}

			.btn-primary,
			.btn-danger {
				font-size: 12px;
				color: #888F9E;
				background-color: #fff;
				border: 1px solid #D5DBE8;
			}

			.btn-primary:hover {
				background-color: #fff;
				border-color: #D5DBE8;
				color: #888F9E;
			}

			.btn-danger:hover {
				background-color: #fff;
				border-color: #D5DBE8;
				color: #888F9E;
			}

			.wrap {
		        width: 50px;
		        height: 30px;
		        background-color: #ccc;
		        border-radius: 16px;
		        position: relative;
		        transition: 0.3s;
		        margin-left: 10px;
		    }

		    .circle {
		        width: 28px;
		        height: 28px;
		        background-color: #fff;
		        border-radius: 50%;
		        position: absolute;
		        top: 1px;
		        left: 0px;
		        transition: 0.3s;
		        box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
		    }

		    .circle:hover {
		        transform: scale(1.2);
		        box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
		    }
			.td_h a{height: 30px;line-height: 30px;}
		</style>
		{/literal}
	</head>

	<body class="body_bgcolor">
		
		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
		
		<div class="main-body">

			<div class="panel mb-3 page_bgcolor">
				<div class="panel-header">

					<nav class="breadcrumb page_bgcolor">
								<span class="c-gray en"></span>
								<span style="color: #414658;">图片管理</span>
								<span class="c-gray en">&gt;</span>
						<a style="margin-top: 10px;" onclick="location.href='index.php?module=software&amp;action=navindex';">图标配置 </a>
					</nav>

				</div>
				<div class="panel-body pd-20 page_absolute">

					<ul class="nav nav-right page_bgcolor">
						<li class="nav-item">
							<a class="nav-link" href="index.php?module=software&action=nav">
								<span class='nav_span'>+</span>
								<span>添加图标</span>
							</a>
						</li>
					</ul>
					<div class="page_h16"></div>

					<table class="table table-bordered bg-white">
						<thead>
							<tr>
								<th style="margin-left: 20px;">ID</th>
								<th>名称</th>
								<th>图标</th>
								<th>唯一标识</th>
								<th>排序</th>
								<th>是否显示</th>
								<th style="margin-right: 20px;">操作</th>
							</tr>
						</thead>
						<tbody>
							{foreach from=$navs item=item name=f1}
							<tr class='nav_tr'>
								<td style="margin-left: 20px;">{$item->id}</td>
								<td>{$item->name}</td>
								<td><img src="{$item->pic_url}" style="width: 60px;height: 60px;"></td>
								<td>{$item->uniquely}</td>
								<td>{$item->sort}</td>
								<td style="display: flex;align-items: center;height: 90px;justify-content: center;">
									{if $item->is_hide == 0}
									<div class="status_box">
										<div class="wrap" style="background-color: #5eb95e;">
											<div class="circle" style="left: 22px;background-color: #fff;" onclick="upDown(event,{$item->id},'down');" data-input='down'></div>
										</div>
									</div>
									<!-- </div> -->
									{else}
									<!-- <div class="formControls col-2"> -->
									<div class="status_box">
										<div class="wrap">
											<div class="circle" onclick="upDown(event,{$item->id},'up')" data-input='up'></div>
										</div>
									</div>
									<!-- </div> -->
									{/if}
								</td>
								<td style="margin-right: 20px;" class="td_h">
									<a style="text-decoration:none;padding: 5px;" class="btn btn-sm btn-primary" href="index.php?module=software&action=nav&id={$item->id}" title="编辑">
										<div style="align-items: center;font-size: 12px;display: flex;">
											<div style="margin: 0 auto;display: flex;align-items: center;">
												<img src="images/icon1/xg.png" />&nbsp;编辑
											</div>
										</div>
									</a>
									<a style="text-decoration:none;padding: 5px;" class="btn btn-sm btn-danger nav-del" href="index.php?module=software&action=navindex&type=del&id={$item->id}">
										<div style="align-items: center;font-size: 12px;display: flex;">
											<div style="margin: 0 auto;display: flex;align-items: center;">
												<img src="images/icon1/del.png" style="margin-bottom: 2px;" />&nbsp;删除
											</div>
										</div>
									</a>
								</td>
							</tr>

							{/foreach}
						</tbody>

					</table>
				</div>
			</div>
			{literal}
			<script>
				$('.circle').click(function() {
					var left = $(this).css('left');
					// var status = $(".status");
					left = parseInt(left);
					var status = $(this).parents(".status_box").children(".status");
					if(left == 0) {
						$(this).css('left', '22px'),
							$(this).css('background-color', '#fff'),
							$(this).parent(".wrap").css('background-color', '#5eb95e');
						$(".wrap_box").show();
						status.val(1);
					} else {
						$(this).css('left', '0px'),
							$(this).css('background-color', '#fff'),
							$(this).parent(".wrap").css('background-color', '#ccc');
						$(".wrap_box").hide();
						status.val(0);
					}
				});
				$(document).on('click', '.nav-del', function() {
					var a = $(this);
					console.log(123);
					$.confirm({
						content: "确认删除？",
						confirm: function() {
							$.loading();
							$.ajax({
								url: a.attr("href"),
								dataType: "json",
								type: "POST",
								success: function(res) {
									$.loadingHide();
									$.alert({
										content: res.msg,
										confirm: function() {
											if(res.code == 0) {
												location.reload();
											}
										}
									});
								}
							});
						}
					});
					return false;
				});

				function upDown(event, id, status) {
					console.log(id, status)
					console.log($(event.target).attr('data-input'))
					let attr = $(event.target).attr('data-input')
					let status_l
					if(status)
						if(attr == 'down') {
							var text = '关闭';
							status_l = 1;
						} else if(attr == 'up') {
						var text = '开启';
						status_l = 0;
					} else {
						return
					};
					console.log(status_l)
					$.ajax({
						url: "index.php?module=software&action=navindex&type=edit",
						type: 'post',
						dataType: 'json',
						data: {
							'id': id,
							'status': status_l,
						},
						success: function(res) {
							if(attr == 'down') {
								$(event.target).attr('data-input', 'up')
							} else if(attr == 'up') {
								$(event.target).attr('data-input', 'down')
							}
							console.log($(event.target).attr('data-input'), 789789)
							if(res.code == 0) {
								console.log(789789)
								/* window.location.reload(); */
							}
							if(res.code == 1) {
								/* window.location.reload(); */
								console.log(789789789)
								/* alert(res.msg);
								if (res.return_url) {
									location.href = res.return_url;
								} */
							}
						}
					});
					return false;

				}
			</script>
			{/literal}
		</div>
		
		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
</body>

</html>
