{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style>
#btn2 {
    color: #fff !important
}

.maskNewContent {
    height: 280px !important;
}

td a {
    width: 29%;
    margin: 1.5% !important;
    float: left;
}

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
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="swivch page_bgcolor swivch_bot">
        <a href="index.php?module=message" class="btn1">短信列表</a>
        {if $button[0] == 1}
            <a href="index.php?module=message&action=List" class="btn1 " style="border-right: 1px solid #ddd!important;">短信模板</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=message&action=Config" class="btn1 active swivch_active" style="border-right: 1px solid #ddd!important;">核心设置</a>
        {/if}
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>

    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>accessKeyId：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$list[0]->accessKeyId}" placeholder="" name="accessKeyId">
            </div>
            <label class="col-2" style="font-size: 12px;color:#97A0B4;tex;text-align: left;">(阿里云API的密钥ID！)</label>
        </div>
        <div class="row cl">
            <label class="form-label col-4"><span class="c-red">*</span>accessKeySecret：</label>
            <div class="formControls col-4">
                <input type="text" class="input-text" value="{$list[0]->accessKeySecret}" placeholder=""
                       name="accessKeySecret">
            </div>
            <label class="col-2" style="font-size: 12px;color:#97A0B4;tex;text-align: left;">(阿里云API的密钥！)</label>
        </div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

{include file="../../include_path/footer.tpl"}
{literal}
    <script type="text/javascript">
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
                url: 'index.php?module=message&action=Config',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        location.href = "index.php?module=message&action=Config";
                    }
                }
            });
        }
    </script>
{/literal}
</body>
</html>