 {include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{literal}
    <script type="text/javascript">

    </script>
{/literal}
<body style=" background: #edf1f5;">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-4"><span class="c-red">*</span>引导图：</label>
            <div class="formControls col-xs-8 col-sm-8">
                <div class="upload-group">
                    <div class="input-group">
                        <input class="form-control file-input " name="image" value="">
                        <span class="input-group-btn">
                            <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="上传文件">
                                <span class="iconfont icon-cloudupload"></span>
                            </a>
                        </span>
                        <span class="input-group-btn">
                            <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="从文件库选择">
                                <span class="iconfont icon-viewmodule"></span>
                            </a>
                        </span>
                        <span class="input-group-btn">
                            <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="删除文件">
                                <span class="iconfont icon-close"></span>
                            </a>
                        </span>
                    </div>
                    <div class="upload-preview text-center upload-preview" >
                        <span class="upload-preview-tip">750×1334</span>
                        <img class="upload-preview-img" src="">
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
        {if $store_type != 1}
            <div class="row cl">
                <label class="form-label col-4"><span class="c-red"></span>类型：</label>
                <div class="formControls col-4 skin-minimal">
                    <div class="radio-box">
                        <input name="type" type="radio" value="0" checked="checked"/>
                        <label for="sex-1">安装</label>
                    </div>
                    <div class="radio-box">
                        <input name="type" type="radio" value="1"/>
                        <label for="sex-2">启动</label>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>
        {/if}
        <div class="row cl">
            <label class="form-label col-4">排序号：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="100" placeholder="" id="" name="sort">
            </div>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

{literal}
    <script>
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }

        function check() {
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: 'index.php?module=guide&action=Add',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    console.log(data)
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        location.href = "index.php?module=guide";
                    }
                }
            });
        }
    </script>
{/literal}
</body>
</html>