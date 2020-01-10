<?php /* Smarty version 2.6.31, created on 2019-12-20 16:57:49
         compiled from Index.tpl */ ?>
<!DOCTYPE HTML>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />

		<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
		<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
		<link href="style/css/style.css" rel="stylesheet" type="text/css" /> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<title>系统参数</title>
		<?php echo '
		<link rel="stylesheet" type="text/css" href="style/css/index.css" /> '; ?>

	</head>

	<body class="body_bgcolor">

		<nav class="breadcrumb page_bgcolor">
	
		
			<span class="c-gray en"></span>
			<span  style='color: #414658;'>小程序设置</span>
	
			<span  class="c-gray en">&gt;</span>
		
			<span  style='color: #414658;'>授权设置</span>
	
        </nav>
		<div class="outer_page">
			<div class="page_title">
				授权小程序
			</div>
			<!--1.第一种状态下的（什么都还没有）-->
			<?php if ($this->_tpl_vars['status'] == 4): ?>
			<section class="i_section">
				<div class="headimg">
					<img src="<?php echo $this->_tpl_vars['head_img']; ?>
" style="width: 100px;height: 100px">
				</div>
				<h1>
					<?php echo $this->_tpl_vars['nick_name']; ?>

				</h1>
				<div class="buttons">
					<button type="button" class="Design" id="Design" onclick="Design()" style="cursor:pointer;">设计小程序</button>
					<button type="button" class="Delete" onclick="confirm('确认要删除吗？',1,'index.php?module=third&action=Index&m=del&id=','删除')">删除小程序</button>
				</div>
			</section>
			<?php endif; ?>
			<!--2.第二种状态下的（下面有一张体验二维码的图片）-->
			<?php if ($this->_tpl_vars['status'] == 2): ?>
			<section class="i_section">
				<div class="headimg2">
					<img src="<?php echo $this->_tpl_vars['head_img']; ?>
" style="width: 100px;height: 100px">
				</div>
				<h1>
					<?php echo $this->_tpl_vars['nick_name']; ?>

				</h1>
				<div class="verify">
					发布状态：<text>审核中</text>
				</div>
				
				<div class="buttons2">
					<button type="button" class="Design" id="Design" onclick="Design()" style="cursor: pointer;">设计小程序</button>
					<button type="button" class="Delete" onclick="confirm('确认要删除吗？',1,'index.php?module=third&action=Index&m=del&id=','删除')">删除小程序</button>
				</div>
				<div class="line"></div>
				<div class="QR1">
					<span class="lookCode">查看体验码</span>
					<div class="examine">
						<img src="<?php echo $this->_tpl_vars['qr_code']; ?>
" width="150px" height="150px">
						<text>用微信扫描二维码</text>
					</div>
				</div>
			</section>
			<?php endif; ?>
			<!--3.第三种状态下的（下面有下载小程序二维码的选择）-->
			<?php if ($this->_tpl_vars['status'] == 1 || $this->_tpl_vars['status'] === 0): ?>
			<section class="i_section">
				<div class="headimg2">
					<img src="<?php echo $this->_tpl_vars['head_img']; ?>
" style="width: 100px;height: 100px">
				</div>
				<h1>
					<?php echo $this->_tpl_vars['nick_name']; ?>

				</h1>
				<div class="verify">
				
					发布状态：<?php if ($this->_tpl_vars['status'] == 1): ?><text style="color: red">审核失败</text><?php elseif ($this->_tpl_vars['status'] === 0 && $this->_tpl_vars['issue_mark'] == 1): ?><text style="color:green ">审核成功，请前往发布</text><?php elseif ($this->_tpl_vars['status'] === 0 && $this->_tpl_vars['issue_mark'] == 3): ?><text style="color:green ">已发布</text><?php endif; ?>
					<img id="tishi_img" class="tishiPic" src="style/images/imags/tishi.png">
				</div>
				<div class="hint" id="tishi_view">
					<!--<img src="style/images/imags/tishi.png">-->
					<div id="hinttext">
						<?php if ($this->_tpl_vars['status'] == 1): ?> <?php echo $this->_tpl_vars['reason']; ?>
 <?php endif; ?>
					</div>
				</div>
				<div class="buttons2">
					<button type="button" class="Design" id="Design" onclick="Design()" style="cursor: pointer;">设计小程序</button>
					<button type="button" class="Delete" style="cursor: pointer;" onclick="confirm('确认要删除吗？',1,'index.php?module=third&action=Index&m=del&id=','删除')">删除小程序</button>
				</div>
				
				<div class="line"></div>
				<div class="three_QR">
					<?php if ($this->_tpl_vars['issue_mark'] == 3): ?>
					<div class="QR1">
						<span class="lookCode">查看体验码</span>
						<div class="examine">
							<img src="<?php echo $this->_tpl_vars['qr_code']; ?>
">
							<text>用微信扫描二维码</text>
						</div>
					</div>
					
						
				
					<div class="QR">
						<span class="OQ_title">下载普通二维码</span>
						<a   class="code" id="codeS" my_size="280" href="index.php?module=third&action=Index&m=downPtCode&width=280" download="code">
							<span class="word_span">边长8cm*8cm</span><span class="word_span">建议扫描距离0.5m</span>
						</a>
						<a  class="code" id="codeM" my_size="280"  href="index.php?module=third&action=Index&m=downPtCode&width=525" download="code1">
							<span class="word_span">边长15cm*15cm</span><span class="word_span">建议扫描距离1m</span>
						</a>
						<a  class="code" id="codeL" my_size="280"  href="index.php?module=third&action=Index&m=downPtCode&width=1280" download="code2">
							<span class="word_span">边长50cm*50cm</span><span class="word_span">建议扫描距离2.5m</span>
						</a>
					</div>
					<div class="QR">
						<span class="OQ_title">下载小程序码</span>
						<a  class="dow" id="dowS" my_size="280"  href="index.php?module=third&action=Index&m=downMiniCode&width=280" download="code3">
							<span class="word_span">边长8cm*8cm</span><span class="word_span">建议扫描距离0.5m</span>
						</a>
						<a  class="dow" id="dowM" my_size="280" href="index.php?module=third&action=Index&m=downMiniCode&width=525" download="code4">
							<span class="word_span">边长15cm*15cm</span><span class="word_span">建议扫描距离1m</span>
						</a>
						<a  class="dow" id="dowL" my_size="280" href="index.php?module=third&action=Index&m=downMiniCode&width=1280" download="code5">
							<span class="word_span">边长50cm*50cm</span><span class="word_span">建议扫描距离2.5m</span>
						</a>
					</div>
					
					<?php endif; ?>
				</div>
				
				
			</section>
			<?php endif; ?>

		
			<script type="text/javascript">
                var my_status = <?php echo $this->_tpl_vars['status']; ?>
   
				<?php echo '

				//设计小程序
				function Design() {
					if(my_status == 2){
						layer.msg(\'请等待审核结果！\',{time:2000});
						exit;
					}
					location.href = "index.php?module=third&action=CheckTemplate";
				}
				
				//删除小程序确认弹框

				function confirm (content,id,url,content1){

				    $("body",parent.document).append(`
				        <div class="maskNew">
				            <div class="maskNewContent">
				                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				                <div class="maskTitle">删除</div>
				                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
				                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
				                    ${content}
				                </div>
				                <div style="text-align:center;margin-top:30px">
				                    <button class="closeMask" style="margin-right:20px" onclick=closeMaskThird(\'${id}\',\'${url}\',\'${content1}\')>确认</button>
				                    <button class="closeMask" onclick=closeMask1() >取消</button>
				                </div>
				            </div>
				        </div>
				    `)
				}
				 
				//下载二维码
				// $(".code").on(\'click\',function(){
				//
				// 	var width = $(this).attr(\'my_size\');//二维码宽度
				// 	console.log(\'123\');
				// 	$.ajax({
				//
				// 		cache:true,
				// 		datatype:\'POST\',
				// 		type:\'json\',
				// 		url:\'index.php?module=third&action=Index&m=down_ptcode\',
				// 		data:\'\',
				// 		success:function(data){
				//
				// 		}
				// 	});
				//
				// })


				//下载小程序码
				// $(\'.dow\').on(\'click\',function(){
				// 	var width = $(this).attr(\'my_size\');
				// 	console.log(123)
				// 	$.ajax({
				//
				// 		cache:true,
				// 		datatype:\'POST\',
				// 		type:\'json\',
				// 		url:\'index.php?module=third&action=Index&m=down_minicode\',
				// 		data:\'\',
				// 		success:function(data){
				//
				// 		}
				// 	})
				// })
				$(document).ready(function(){
					console.log(\'123\');
				  $(\'#tishi_img\').mouseover(function(){
				  	 console.log(\'show\');
				  	$(\'#tishi_view\').show();
				  	$(\'#hinttext\').show();
				  })
				  $(\'#tishi_img\').mouseout(function(){
				  	$(\'#tishi_view\').hide();

				  })

				})


			</script>
			'; ?>

	</body>

</html>