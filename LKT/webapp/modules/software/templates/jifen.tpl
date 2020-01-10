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
		<!--<link href="style/lib/icheck/icheck.css" rel="stylesheet" type="text/css" />
		<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
		<link href="style/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />-->
		<link href="style/css/style.css" rel="stylesheet" type="text/css" />

		<title>关注设置积分</title>
		{literal}
		<style type="text/css">
			@font-face {
				font-family: "iconfont";
				src: url('iconfont.eot?t=1530949902201');
				/* IE9*/
				src: url('iconfont.eot?t=1530949902201#iefix') format('embedded-opentype'), /* IE6-IE8 */
				url('data:application/x-font-woff;charset=utf-8;base64,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') format('woff'), url('iconfont.ttf?t=1530949902201') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/
				url('iconfont.svg?t=1530949902201#iconfont') format('svg');
				/* iOS 4.1- */
			}
			
			.iconfont {
				font-family: "iconfont" !important;
				font-size: 30px;
				font-style: normal;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}
			
			.icon-zhengshu-copy:before {
				content: "\e640";
			}
			
			.isbad {
				border: 2px solid red;
			}
			
			.btn1 {
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
			
			.btn1:hover {
				text-decoration: none;
			}
			
			.row .form-label {
				width: 20% !important;
			}
			
			.col-10 {
				width: 80% !important;
			}
			
			.sDiv div {
				display: inline-block;
				float: left;
				height: 31px;
				line-height: 31px;
			}
			
			.sDiv {
				display: inline-block;
				margin: 5px;
				line-height: 31px;
			}
			
			.sDiv label {
				height: 31px;
				line-height: 31px;
			}
			
			.c-red {
				display: inline-block;
				height: 14px;
				line-height: 14px;
				background-color: red;
				padding: 0 3px;
				color: #fff;
			}
			
			label {
				position: relative;
			}
			
			input[type="radio"]+label::before {
				content: "\a0";
				/*不换行空格*/
				display: inline-block;
				font-size: 12px;
				width: 12px;
				height: 12px;
				margin-right: 5px;
				border-radius: 50%;
				border: 1px solid #2890ff;
				line-height: 12px;
			}
			
			input[type="radio"]:checked+label::after {
				background-color: #2890ff;
				display: inline-block;
				width: 8px;
				height: 8px;
				border-radius: 50%;
				content: "\a0";
				position: absolute;
				left: 3px;
				top: 6px;
			}
			
			input[type="radio"] {
				position: absolute;
				clip: rect(0, 0, 0, 0);
			}
			
			.divTitle {
				height: 50px;
				line-height: 50px;
				text-align: left;
				padding-left: 20px;
				font-size: 16px;
				color: #414658;
				font-weight: 600;
				font-family: "microsoft yahei";
				margin-bottom: 0px;
				background-color: #fff;
				border-bottom: 2px solid #eee;
				border-top-left-radius: 10px;
				border-top-right-radius: 10px;
			}
			
			#form1 {
				border-bottom-left-radius: 10px;
				border-bottom-right-radius: 10px;
			}
			
			.form-label {
				font-size: 14px;
				color: #414658;
				margin-top: 0px !important;
				height: 31px;
				line-height: 31px;
			}
			
			.newBtn1 {
				width: 20px;
				height: 20px;
				border-radius: 50%;
				border: 1px solid #a9b1c2;
				background-color: transparent;
				cursor: pointer;
				margin-left: 150px !important;
			}
			
			.delBtn {
				width: 12px;
				height: 4px;
				background-color: #a9b1c2;
				display: inline-block;
				position: relative;
				top: -4px;
			}
		</style>
		{/literal}
	</head>

	<body>

		{include file="../../include_path/nav.tpl" sitename="面包屑"}

		<div class="pd-20 page_absolute">
			<div class="page_title">
				积分设置
			</div>
			<form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
				<div style="margin-left: 60px; padding-left: 40px;border: 1px dashed #fea95a;background-color: #fffbf9;margin-bottom: 10px;border-radius: 5px;">
					<div>
						<h4 style="color: red;">消费规则修改说明: </h4>
						<ul style="color: #6A7076;list-style: initial;padding-left: 20px;">
							<li style="margin-bottom: 4px;">当前等级订单额度必须大于上一等级订单金额,对应的积分也是如此.</li>
							<li style="margin-bottom: 4px;">为保证商家利益,所设置的积分值对应的人民币不得超过订单金额的20%.</li>
							<li style="margin-bottom: 16px;">最高只能添加3个等级.</li>
						</ul>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">首次注册，设置积分值：</label>
					<div class="formControls col-10 ">
						<input type="number" style="width: 150px;border-color: #d5dbe8;" class="input-text" value="{$res->jifennum}" placeholder="" id="" name="jifennum">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-2">是否开启积分转让：</label>
					<div class="formControls col-10" style="height: 31px;line-height: 31px;">
						<div style="display: inline-block;">
							<input type="radio" name="switch" id="switch1" class="a-radio" value="0" {if $res->switch ==0} checked="checked"{/if}>
							<label for="switch1" style="margin: 10px;">关闭</label>
						</div>
						<div style="display: inline-block;">
							<input type="radio" name="switch" id="switch2" class="a-radio" value="1" {if $res->switch ==1} checked="checked"{/if}>
							<label for="switch2" style="margin: 10px;"><span class="b-radio">开启</span></label>
						</div>

					</div>
				</div>

				<!-- dc------------------------------- -->
				<div id="tab-system" class="HuiTab">
					<div class="row cl">
						<label class="form-label col-xs-2 col-sm-2"><span style="color: red;">*</span>积分消费比例：</label>
						<div class="formControls col-xs-2 col-sm-1" style="width: 150px!important;">
							<select style="width: 150px;border-color: #d5dbe8;" name="bili" class="input-text">

							</select>
						</div>
						<div style="height: 31px;line-height: 31px;margin-left: 10px;display: inline-block;">积分 = 1元人民币</div>
					</div>
					<div class="row cl">
						<label class="form-label col-xs-2 col-sm-2"><span style="color: red;">*</span>积分消费规则： </label>
						<div style="display: inline-block;width:750px; background-color: #f4f7f9;padding: 8px;box-sizing: border-box;" class="SD">
							<div class="leverd sDiv">
								<label style="float: left;margin-right: 10px;"><span class="c-red">1 级</span> : 单笔订单满</label>
								<div>
									<input style="width: 150px;border-color: #d5dbe8;" type="number" name="order1" value="" class="input-text" min="1" onblur="modifyValue(event)" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" />
								</div>
								<div style="margin-left:10px;margin-right: 10px;">可抵用</div>
								<div>
									<input style="border-color: #d5dbe8;" type="number" name="score1" value="" class="input-text" min="1" onblur="modifyValue(event)" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" />
								</div>
								<div style="color:#666;">元人民币的积分</div>
								<button class="newBtn1" style="margin-left: 10px;border-color: #2890FF;" type="button" onclick="addlever()" id="addlever1">
                            <img style="margin-right: 0px;width: 12px;height: 12px;position: relative;top: -2px;"
                                 src="images/icon1/add1.png"/>
                        </button>
							</div>
						</div>

					</div>

					<input type="hidden" name="returnbili" value="{$res->bili}" />
					<input type="hidden" name="returnbuy" value="{$str}" />
					<input type="hidden" name="data" value="" />

				</div>

				<!-- dc------------------------------- -->
				<div class="row cl">
					<label class="form-label col-2">积分规则：</label>
					<div class="formControls col-10">
						<script id="editor" type="text/plain" style="height:400px;" name="rule">{$res->rule}</script>
					</div>
				</div>
				<div class="row cl page_bort" style="margin-top: 20px;margin-bottom: 10px;">
					<div>
						<button class="btn btn-secondary radius ta_btn1" type="reset" name="reset"> 重置 </button>
                		<button class="btn btn-primary radius ta_btn3"type="button" name="Submit" onclick="savevalues()"> 提交 </button>
					</div>
				</div>

			</form>

		</div>

		<!--<script type="text/javascript" src="modpub/js/check.js"></script>-->

		<script type="text/javascript" src="style/js/jquery.min.js"></script>
		<!--<script type='text/javascript' src='modpub/js/calendar.js'></script>-->
		<script type="text/javascript" src="style/js/layer/layer.js"></script>
		<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
		<script type="text/javascript" src="style/lib/ueditor/1.4.3/jquery.icheck.min.js"></script>
		<!--<script type="text/javascript" src="style/lib/Validform/5.3.2/Validform.min.js"></script>-->
		<script type="text/javascript" src="style/lib/ueditor/1.4.3/webuploader.min.js"></script>
		<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.config.js"></script>
		<script type="text/javascript" src="style/lib/ueditor/1.4.3/ueditor.all.min.js"></script>
		<!--<script type="text/javascript" src="style/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>-->
		<!--<script type="text/javascript" src="style/js/H-ui.js"></script>-->
		<!--<script type="text/javascript" src="style/js/H-ui.admin.js"></script>-->

		<!-- 新增编辑器引入文件 -->
		<!--<link rel="stylesheet" href="style/kindeditor/themes/default/default.css" />
		<script src="style/kindeditor/kindeditor-min.js"></script>
		<script src="style/kindeditor/lang/zh_CN.js"></script>-->
		{literal}
		<script>
			document.onkeydown = function(e) {
				if(!e) e = window.event;
				if((e.keyCode || e.which) == 13) {
					$("[name=Submit]").click();
				}
			}

			function check() {
				$.ajax({
					cache: true,
					type: "POST",
					dataType: "json",
					url: 'index.php?module=software&action=jifen',
					data: $('#form1').serialize(), // 你的formid
					async: true,
					success: function(data) {
						console.log(data)
						layer.msg(data.status, {
							time: 2000
						});
						if(data.suc) {
							location.href = "index.php?module=software&action=jifen";
						}
					}
				});
			}

			KindEditor.ready(function(K) {
				var editor = K.editor({
					allowFileManager: true,
					uploadJson: "index.php?module=system&action=UploadImg", //上传功能
					fileManagerJson: 'kindeditor/php/file_manager_json.php', //网络空间
				});
				//上传背景图片
				K('#image').click(function() {
					editor.loadPlugin('image', function() {
						editor.plugin.imageDialog({
							//showRemote : false, //网络图片不开启
							//showLocal : false, //不开启本地图片上传
							imageUrl: K('#picurl').val(),
							clickFn: function(url, title, width, height, border, align) {
								K('#picurl').val(url);
								$('#thumb_url').attr("src", url);
								editor.hideDialog();
							}
						});
					});
				});
			});
		</script>
		<script type="text/javascript">
			$(function() {
				$('.skin-minimal input').iCheck({
					checkboxClass: 'icheckbox-blue',
					radioClass: 'iradio-blue',
					increaseArea: '20%'
				});

				$list = $("#fileList"),
					$btn = $("#btn-star"), // 开始上传的id名称
					state = "pending",
					uploader;

				var uploader = WebUploader.create({
					auto: true,
					swf: 'style/lib/webuploader/0.1.5/Uploader.swf',

					// 文件接收服务端。
					server: 'http://lib.h-ui.net/webuploader/0.1.5/server/fileupload.php',

					// 选择文件的按钮。可选。
					// 内部根据当前运行是创建，可能是input元素，也可能是flash.
					pick: '#filePicker',

					// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
					resize: false,
					// 只允许选择图片文件。
					accept: {
						title: 'Images',
						extensions: 'gif,jpg,jpeg,bmp,png',
						mimeTypes: 'image/*'
					}
				});
				uploader.on('fileQueued', function(file) {
					var $li = $(
							'<div id="' + file.id + '" class="item">' +
							'<div class="pic-box"><img></div>' +
							'<div class="info">' + file.name + '</div>' +
							'<p class="state">等待上传...</p>' +
							'</div>'
						),
						$img = $li.find('img');
					$list.append($li);

					// 创建缩略图
					// 如果为非图片文件，可以不用调用此方法。
					// thumbnailWidth x thumbnailHeight 为 100 x 100
					uploader.makeThumb(file, function(error, src) {
						if(error) {
							$img.replaceWith('<span>不能预览</span>');
							return;
						}

						$img.attr('src', src);
					}, thumbnailWidth, thumbnailHeight);
				});
				// 文件上传过程中创建进度条实时显示。
				uploader.on('uploadProgress', function(file, percentage) {
					var $li = $('#' + file.id),
						$percent = $li.find('.progress-box .sr-only');

					// 避免重复创建
					if(!$percent.length) {
						$percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
					}
					$li.find(".state").text("上传中");
					$percent.css('width', percentage * 100 + '%');
				});

				// 文件上传成功，给item添加成功class, 用样式标记上传成功。
				uploader.on('uploadSuccess', function(file) {
					$('#' + file.id).addClass('upload-state-success').find(".state").text("已上传");
				});

				// 文件上传失败，显示上传出错。
				uploader.on('uploadError', function(file) {
					$('#' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
				});

				// 完成上传完了，成功或者失败，先删除进度条。
				uploader.on('uploadComplete', function(file) {
					$('#' + file.id).find('.progress-box').fadeOut();
				});
				uploader.on('all', function(type) {
					if(type === 'startUpload') {
						state = 'uploading';
					} else if(type === 'stopUpload') {
						state = 'paused';
					} else if(type === 'uploadFinished') {
						state = 'done';
					}

					if(state === 'uploading') {
						$btn.text('暂停上传');
					} else {
						$btn.text('开始上传');
					}
				});

				$btn.on('click', function() {
					if(state === 'uploading') {
						uploader.stop();
					} else {
						uploader.upload();
					}
				});

				var ue = UE.getEditor('editor');

			});

			function mobanxuanze() {

			}
		</script>
		{/literal} {literal}
		<script type="text/javascript">
			var retbili = '{/literal}{$res->xiaofeibili}{literal}';
			var retbuy = '{/literal}{$str}{literal}';
			retbuy = JSON.parse(retbuy);
			var a = retbuy.length + 1;
			var optarr = ['1', '10', '50', '100'];
			var option = '';
			$.each(optarr, function(index, element) {
				if(retbili == element) {
					option += '<option value="' + element + '" selected>' + element + '</option>';
				} else {
					option += '<option value="' + element + '">' + element + '</option>';
				}
			});
			$("select[name=bili]").append(option);
			if(retbuy.length > 0) {
				$("input[name=order1]").val(retbuy[0].ordernum);
				$("input[name=score1]").val(retbuy[0].scorenum);

				retbuy.shift();
				//console.log(retbuy);
				var levs = '';
				$.each(retbuy, function(index, element) {
					levs += '<div class="leverd sDiv"><label class="" style="float: left;margin-right:10px;"><span class="c-red">' + element.lever + ' 级</span> : 单笔订单满 </label><div class=""><input type="number" style="width: 150px;border-color: #d5dbe8;" name="order' + element.lever + '" value="' + element.ordernum + '" class="input-text" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" min="1" onblur="modifyValue(event)"></div><div style="margin-left:10px;margin-right: 10px;">可抵用</div><div ><input type="number" style="border-color: #d5dbe8;" name="score' + element.lever + '" value="' + element.scorenum + '" min="1" class="input-text" onblur="modifyValue(event)" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" /></div><div class="" style="color:#666;">  元人民币的积分  </div><button style="margin-left:10px" class=" newBtn1" type="button" onclick="removelever(' + element.lever + ')"><i class="delBtn"></i></button></div>';
				});
				$('.SD').append(levs);

			} else {
				a++;
			}

			function addlever() {

				var node = '<div class="leverd sDiv"><label class="" style="float: left;margin-right:10px;"><span class="c-red">' + a + ' 级</span> : 单笔订单满 </label><div class=""><input type="number" style="width: 150px;border-color: #d5dbe8;" name="order' + a + '" value="" class="input-text" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" min="1" onblur="modifyValue(event)"></div><div style="margin-left:10px;margin-right: 10px;">可抵用</div><div><input type="number" style="border-color: #d5dbe8;" name="score' + a + '" value="" min="1" class="input-text" onblur="modifyValue(event)" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" /></div><div class="" style="color:#666;">  元人民币的积分  </div><button class="newBtn1"  style="margin-left:10px" type="button" onclick="removelever(' + a + ')"><i class="delBtn"></i></button></div>';
				if(a > 4) {
					$("#addlever1").hide();
				} else {
					a++;
					$('.SD').append(node);
				}

			}

			function removelever(i) {

				$("input[name=score" + i + "]").parents('.sDiv').remove();
				$("#addlever1").show();
				$('.leverd').each(function() {
					var j = $(this).find("input[name^='order']").attr('name');
					j = j.substr(-1, 1);
					if(j > i) {
						var levd = $(this).find("span");
						var num = levd.text().substr(0, 1) - 1;
						levd.text(num + ' 级');
						$(this).find("input[name^='order']").attr('name', 'order' + num);
						$(this).find("input[name^='score']").attr('name', 'score' + num);
						$(this).find("button").attr('onclick', 'removelever(' + num + ')');
					}
				})
				a = $('.leverd').length + 1;
			}

			function modifyValue(event) {
				var target = event.target;
				var val = $(target).val();
				if(val.substr(0, 1) === '0' || val.substr(0, 1) === '-') {
					$(target).val(val.substr(1));
				}
			}

			function savevalues() {
				var len = $("input[name^=order]").length;
				var bili = $("select[name=bili]").val();
				var obj = [];
				var data = {};
				for(var i = 0; i < len; i++) {
					var next = parseInt($("input[name^=order]:eq(" + i + ")").val());
					var prev = parseInt($("input[name^=order]:eq(" + (i - 1) + ")").val());
					var orderbad = 'orderbad' + i;
					var noorder = 'noorder' + i;
					if(i > 0) {
						if(next <= prev) {
							//               $("input[name^=order]:eq("+i+")").after('<div style="color:red;" id="'+orderbad+'">不合格</div>');
							//               obj.push(orderbad);       
							layer.msg("积分设置不合格！");
						}
					}
					if($("input[name^=order]:eq(" + i + ")").val() == '') {
						//             $("input[name^=order]:eq("+i+")").after('<div style="color:red;" id="'+noorder+'">不能为空</div>');
						//               obj.push(noorder);
						layer.msg("积分设置不能为空！");
						return false;
					}
				}
				for(var j = 0; j < len; j++) {
					var next1 = parseInt($("input[name^=score]:eq(" + j + ")").val());
					var prev1 = parseInt($("input[name^=score]:eq(" + (j - 1) + ")").val());
					var orderVal = parseInt($("input[name^=order]:eq(" + j + ")").val());
					var scorebad = 'scorebad' + j;
					var noscore = 'noscore' + j;
					var scorebig = 'scorebig' + j;
					if(j > 0) {
						if(next1 <= prev1) {
							//               $("input[name^=score]:eq("+j+")").after('<div style="color:red;" id="'+scorebad+'">不合格</div>');
							//               obj.push(scorebad);
							layer.msg("积分设置不合格！");
							return false;
						}
					}
					if(next1 > Math.floor(orderVal * 0.2)) {
						//            $("input[name^=score]:eq("+j+")").after('<div style="color:red;" id="'+scorebig+'">积分值超过可设置范围</div>');
						//               obj.push(scorebig);
						layer.msg("积分设置超过可设置范围！");
						return false;
					}
					if($("input[name^=score]:eq(" + j + ")").val() == '') {
						//             $("input[name^=score]:eq("+j+")").after('<div style="color:red;" id="'+noscore+'">不能为空</div>');
						//               obj.push(noscore);
						layer.msg("积分设置不能为空！");
						return false;
					}
					data[orderVal] = next1 + '~' + (j + 1);
				}

				// setTimeout(function(){
				//       for(var k = 0;k < obj.length; k++){
				//           var idattr = document.getElementById(obj[k]);
				//           idattr.parentNode.removeChild(idattr);
				//           }
				//       },2000);
				var str = '{';
				$.each(data, function(index, element) {
					str += '"' + index + '":"' + element + '",';
				});

				str = str.substring(0, (str.length - 1));
				str += '}';
				$("input[name=data]").val(str);

				$.ajax({
					cache: true,
					type: "POST",
					dataType: "json",
					url: 'index.php?module=software&action=jifen',
					data: $('#form1').serialize(), // 你的formid
					async: true,
					success: function(data) {
						//console.log(data)
						//layer.msg(data.msg,{time:2000});
						//location.href="index.php?module=software&action=jifen";
						alert(data.msg);
						location.reload();

					}
				});

			}
		</script>
		{/literal}
	</body>

</html>