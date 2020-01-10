<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<title>图片魔方编辑</title>
		{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
	</head>

	<body>
		{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}

		<div class="main-body">

			<div class="panel mb-3 page_bgcolor sewo" id="app">
				{include file="../../include_path/nav.tpl" sitename="面包屑"}
				<div class="panel-body pd-20 page_absolute">
					<form class="auto-form page_absolute" method="post" return="index.php?module=software&action=pageindex">
						<input type="hidden" name="id" value="{$list->id}">
						<div class="form-group row" style="padding-top: 20px;">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">默认样式</label>
							</div>
							<div class="col-sm-8">
								<img class="mb-3" src="style/diy_img/img-block-demo.png" style="width: 100%;border: 1px solid #eee;">
								<div class="alert alert-info rounded-0">单图的图片高度不限定，高度根据原图比例自动调整</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">样式一</label>
							</div>
							<div class="col-sm-8">
								<img class="mb-3" src="style/diy_img/img-block-demo-1.png" style="width: 100%;border: 1px solid #eee;">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">样式二</label>
							</div>
							<div class="col-sm-8">
								<img class="mb-3" src="style/diy_img/img-block-demo-2.png" style="width: 100%;border: 1px solid #eee;">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label required">板块名称</label>
							</div>
							<div class="col-sm-8">
								<input class="form-control" type="text" name="name" value="{$list->name}">
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label">板块图片</label>
							</div>
							<div class="col-sm-8">
								{literal}
								<div class="row mb-3" v-for="(item,i) in pic_list">
									<div class="col-sm-5">

										<div class="upload-group">
											<div class="input-group">
												<input class="form-control file-input" v-bind:index="i" v-bind:name="'pic_list['+i+'][pic_url]'" v-model="item.pic_url">
												<span class="input-group-btn">
                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip"
                               data-placement="bottom"
                               title="上传文件">
                              <span class="iconfont icon-cloudupload"></span>
												</a>
												</span>
												<span class="input-group-btn">
                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"
                               data-placement="bottom"
                               title="从文件库选择">
                              <span class="iconfont icon-viewmodule"></span>
												</a>
												</span>
												<span class="input-group-btn">
                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"
                               data-placement="bottom"
                               title="删除文件">
                              <span class="iconfont icon-close"></span>
												</a>
												</span>
											</div>
											<div class="upload-preview text-center upload-preview">
												<span class="upload-preview-tip">大小参考示例</span>
												<img class="upload-preview-img" v-bind:src="item.pic_url">
											</div>
										</div>

									</div>
									<div class="col-sm-5">
										<div class="input-group page-link-input">
											<input class="form-control link-input" readonly v-bind:index="i" v-bind:name="'pic_list['+i+'][url]'" v-model:value="item.url" value="">
											<input class="link-open-type" v-bind:index="i" v-bind:name="'pic_list['+i+'][open_type]'" v-model:value="item.open_type" type="hidden">
											<span class="input-group-btn">
                          <a class="btn btn-secondary pick-link-btn" href="javascript:"
                             open-type="navigate,wxapp">选择链接</a>
                        </span>
										</div>
									</div>
									<div class="col-sm-2 text-right">
										<a class="btn btn-danger pic-delete" v-bind:data-index="i" href="javascript:">删除</a>
									</div>
								</div>
								{/literal}
								<a v-if="pic_list.length<4" class="btn btn-secondary add-pic" href="javascript:">添加</a>
								<div v-else class="text-muted">最多上传4张图片</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="form-group-label col-sm-2 text-right">
								<label class="col-form-label">板块样式</label>
							</div>
							<div class="col-sm-6">
								<label class="radio-label">
                            <input id="radio1" {if $list->style == 0 }checked{/if} value="0" name="style" type="radio"
                                   class="custom-control-input">
                            <span class="label-icon"></span>
                            <span class="label-text">默认样式</span>
                        </label>
								<label class="radio-label" v-if="pic_list.length>1">
                            <input id="radio1" {if $list->style == 1 }checked{/if} value="1" name="style" type="radio"
                                   class="custom-control-input">
                            <span class="label-icon"></span>
                            <span class="label-text">样式一</span>
                        </label>
								<label class="radio-label" v-if="pic_list.length==4">
                            <input id="radio1" {if $list->style == 2 }checked{/if} value="2" name="style" type="radio"
                                   class="custom-control-input">
                            <span class="label-icon"></span>
                            <span class="label-text">样式二</span>
                        </label>
							</div>
						</div>

						<div class=" row_cl" style="border-top: 1px solid #ddd;">
							<!--<div class="form-group-label col-sm-2 text-right">
							</div>-->
							<div class="col-sm-6" style="max-width: 100%;flex: auto;">
								<input type="button" class="ta_btn4 ta_btn5" name="Submit" onclick="javascript:history.back(-1);" value="返回">
								<a class="btn btn-primary auto-form-btn2 ta_btn3 buttom_hover" href="javascript:">保存</a>
							</div>
						</div>
						<div class="page_h2"></div>
					</form>
					<div class="page_h20"></div>
				</div>

			</div>

		</div>
		</div>

		{literal}
	    <script>
	    	var aa=$(".pd-20").height();
			var bb=$(".auto-form").height();
			console.log(aa,bb)
			if(aa<bb){
				$(".page_h20").css("display","block")
			}else{
				$(".page_h20").css("display","none")
				$(".row_cl").addClass("page_footer")
			}
	    	
	    	
	        var upload_url = "/cp/web/index.php?r=upload%2Fimage";
	        var app = new Vue({
	            el: "#app",
	            data: {
	                pic_list: {/literal}{$list->value}{literal},
	            }
	        });

	        $(document).on("click", ".pic-delete", function () {
	            var i = $(this).attr("data-index");
	            app.pic_list.splice(i, 1);
	        });

	        $(document).on("click", ".add-pic", function () {
	            app.pic_list.push({
	                pic_url: '',
	                url: '',
	            });
	            setTimeout(function () {
	                setPlUpload();
	            }, 100);
	        });

	        $(document).on('change', '.file-input', function () {
	            var index = $(this).attr('index');
	            app.pic_list[index].pic_url = $(this).val();
	        });

	        $(document).on("change", ".link-input", function () {
	            var index = $(this).attr("index");
	            app.pic_list[index].url = $(this).val();
	        });

	        $(document).on("change", ".link-open-type", function () {
	            var index = $(this).attr("index");
	            app.pic_list[index].open_type = $(this).val();
	        });

	        function setPlUpload() {
	            $(".pic-upload").plupload({
	                url: upload_url,
	                beforeUpload: function ($this, _this) {
	                    console.log($this);
	                    $($this).btnLoading("Loading");
	                },
	                success: function (res, _this, $this) {
	                    $($this).btnReset().text("上传");
	                    if (res.code == 0) {
	                        var i = $(_this).attr("data-index");
	                        app.pic_list[i].pic_url = res.data.url;
	                    }
	                }
	            });
	        }

	        setTimeout(function () {
	            setPlUpload();
	        }, 1);
	    </script>
	    {/literal}

		{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
	</body>

</html>