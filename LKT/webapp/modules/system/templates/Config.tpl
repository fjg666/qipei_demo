{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}

{literal}
    <style>
        .btn1 {
            width: 80px;
            height: 36px;
            line-height: 36px;
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

        .swivch a:hover {
            text-decoration: none;
            background-color: #2481e5 !important;
            color: #fff !important;
        }
        .row .form-label{
            width: 16% !important;
        }
        .form-horizontal .form-label{
            margin-top: 7px;
        }
    </style>
{/literal}
<body class="body_bgcolor">

{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class=" pd-20 page_absolute">
    <div class="swivch swivch_bot page_bgcolor">
        {if $button[0] == 1}
            <a href="index.php?module=system&action=Config" class="btn1 swivch_active">基础配置</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=system&action=Agreement" class="btn1" >协议配置</a>
        {/if}
        {if $button[2] == 1}
            <a href="index.php?module=system&action=Aboutus" class="btn1" >关于我们</a>
        {/if}
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>

    <form name="form1" id='form1' class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div id="tab-system" class="HuiTab">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>是否需要注册：</label>
                <div class="form_new_r form_yes" style="padding-left: 16px;">
                    <div class="ra1">
                        <input name="is_register" type="radio" {if $is_register != 2} checked=""{/if} style="display: none;" {if $is_register != '' && $is_register != 0}disabled="disabled"{/if} id="is_register-1" class="inputC1" value="1">
                        <label for="is_register-1">注册</label>
                    </div>
                    <div class="ra1">
                        <input name="is_register" type="radio" {if $is_register == 2} checked=""{/if} style="display: none;" {if $is_register != '' && $is_register != 0}disabled="disabled"{/if} id="is_register-2" class="inputC1" value="2">
                        <label for="is_register-2">免注册</label>
                    </div>
                    <text style="margin-top: 7px;color: red;">第一次保存后不能更改,请谨慎选择</text>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>公司LOGO：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <div class="upload-group">
                        <div class="input-group">
                            <input type="hidden" name="oldpic" value="{$logo}" >
                            <input class="form-control file-input" name="image" value="{$logo}">
                            <span class="input-group-btn">
                                <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="上传文件">
                                    <span class="iconfont icon-cloudupload"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="从文件库选择">
                                    <span class="iconfont icon-viewmodule"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="删除文件">
                                    <span class="iconfont icon-close"></span>
                                </a>
                            </span>
                        </div>
                        <div class="upload-preview text-center upload-preview">
                            <span class="upload-preview-tip">100×100</span>
                            <img class="upload-preview-img" src="{$logo}">
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>首页logo：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <div class="upload-group">
                        <div class="input-group">
                            <input type="hidden" name="oldpic1" value="{$logo1}" >
                            <input class="form-control file-input" name="image1" value="{$logo1}">
                            <span class="input-group-btn">
                                <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="上传文件">
                                    <span class="iconfont icon-cloudupload"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="从文件库选择">
                                    <span class="iconfont icon-viewmodule"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="删除文件">
                                    <span class="iconfont icon-close"></span>
                                </a>
                            </span>
                        </div>
                        <div class="upload-preview text-center upload-preview" style="width: 176px;height: 52px;">
                            <span class="upload-preview-tip">172X40</span>
                            <img class="upload-preview-img" src="{$logo1}" >
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>微信用户默认头像：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <div class="upload-group">
                        <div class="input-group">
                            <input class="form-control file-input" name="wx_image" value="{$wx_headimgurl1}">
                            <span class="input-group-btn">
                                <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="上传文件">
                                    <span class="iconfont icon-cloudupload"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="从文件库选择">
                                    <span class="iconfont icon-viewmodule"></span>
                                </a>
                            </span>
                            <span class="input-group-btn">
                                <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip"
                                   data-placement="bottom" title="" data-original-title="删除文件">
                                    <span class="iconfont icon-close"></span>
                                </a>
                            </span>
                        </div>
                        <div class="upload-preview text-center upload-preview">
                            <span class="upload-preview-tip">100×100</span>
                            <img class="upload-preview-img" src="{$wx_headimgurl1}">
                        </div>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>小程序名称：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="company" value="{$company}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>微信用户默认名：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="wx_name" value="{$wx_name}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">H5页面地址：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="H5_domain" value="{$H5_domain}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">用户ID默认前缀：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="hidden" name="yuser_id" value="{$user_id}" class="input-text">
                    <input type="text" name="user_id" value="{$user_id}" class="input-text">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-4">前端消息保留天数：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <input type="text" name="message_day" value="{$message_day}" class="input-text">天
                    （为空则不自动删除）
                </div>
            </div>
            <div class="row cl" style="padding-bottom: 80px;">
                <label class="form-label col-xs-4 col-sm-4">客服：</label>
                <div class="formControls col-xs-8 col-sm-6">
                    <textarea rows="3" cols="60" name="customer_service">
                    {$customer_service}
                    </textarea>
                </div>
            </div>
        </div>
        <div class="page_bort" >
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
        </div>
    </form>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{literal}
    <script type="text/javascript">
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }

        function check() {
            console.log(88888)
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: 'index.php?module=system&action=Config',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        setTimeout(function () {
                            location.href = "index.php?module=system&action=Config";
                        }, 2000)
                    }
                }
            });
        }

        $(function () {
            $(".pimg").click(function () {
                var _this = $(this);//将当前的pimg元素作为_this传入函数
                imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
            });
        });

        function imgShow(outerdiv, innerdiv, bigimg, _this) {
            var src = _this.attr("src");//获取当前点击的pimg元素中的src属性
            $(bigimg).attr("src", src);//设置#bigimg元素的src属性

            /*获取当前点击图片的真实大小，并显示弹出层及大图*/
            $("<img/>").attr("src", src).load(function () {
                var windowW = $(window).width();//获取当前窗口宽度
                var windowH = $(window).height();//获取当前窗口高度
                var realWidth = this.width;//获取图片真实宽度
                var realHeight = this.height;//获取图片真实高度
                var imgWidth, imgHeight;
                var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

                if (realHeight > windowH * scale) {//判断图片高度
                    imgHeight = windowH * scale;//如大于窗口高度，图片高度进行缩放
                    imgWidth = imgHeight / realHeight * realWidth;//等比例缩放宽度
                    if (imgWidth > windowW * scale) {//如宽度扔大于窗口宽度
                        imgWidth = windowW * scale;//再对宽度进行缩放
                    }
                } else if (realWidth > windowW * scale) {//如图片高度合适，判断图片宽度
                    imgWidth = windowW * scale;//如大于窗口宽度，图片宽度进行缩放
                    imgHeight = imgWidth / realWidth * realHeight;//等比例缩放高度
                } else {//如果图片真实高度和宽度都符合要求，高宽不变
                    imgWidth = realWidth;
                    imgHeight = realHeight;
                }
                $(bigimg).css("width", imgWidth);//以最终的宽度对图片缩放

                var w = (windowW - imgWidth) / 2;//计算图片与窗口左边距
                var h = (windowH - imgHeight) / 2;//计算图片与窗口上边距
                $(innerdiv).css({"top": h, "left": w});//设置#innerdiv的top和left属性
                $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg
            });

            $(outerdiv).click(function () {//再次点击淡出消失弹出层
                $(this).fadeOut("fast");
            });
        }
    </script>
{/literal}
</body>
</html>