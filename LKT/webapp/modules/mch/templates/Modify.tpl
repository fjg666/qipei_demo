{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
{literal}
<style>
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
{/literal}
<body class="body_bgcolor iframe-container">
<nav class="nav-title">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;color: #0a0a0a;text-decoration:none;"  href="javascript:history.back(-1)">店铺 </a>
    <span class="c-gray en">&gt;</span>
    修改
</nav>
<div class="iframe-content">
    <form name="form1" id="form1" class="form form-horizontal form-scroll" method="post" enctype="multipart/form-data" style="padding: 0px !important;">
        <input type="hidden" name="id" value="{$list->id}">
        <input type="hidden" name="user_id" value="{$list->user_id}">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD">店铺信息修改</div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD" style="width: 128px;flex-direction: column-reverse;margin-top: 8px;margin-right: -21px;margin-left: 30px;">
                            <span style="display: block;">店铺LOGO：</span>
                        </div>
                        <div class="formInputSD">
                            <div class="upload-group">
                                <div class="input-group row" style="margin-left: -69px;margin-top: 2px;">
                                    <span class="col-sm-1 col-md-1 col-lg-1"></span>
                                    <input index="0" value="{$list->logo}" name="mch[logo]" class="col-sm-5 col-md-5 col-lg-5 form-control file-input input_width_l" style="width: 1008px;height: 36px;">
                                    <input type="hidden" name="oldpic" value="{$list->logo}">
                                    <span class="input-group-btn input_border col-sm-1 col-md-1 col-lg-1" style="display: block;padding-left: 2px;">
                                        <a class="btn btn-secondary upload-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="上传文件">
                                            <span class="iconfont icon-cloudupload"></span>
                                        </a>
                                        <a class="btn btn-secondary select-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="从文件库选择">
                                            <span class="iconfont icon-viewmodule"></span>
                                        </a>
                                        <a class="btn btn-secondary delete-file" href="javascript:" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="删除文件">
                                            <span class="iconfont icon-close"></span>
                                        </a>
                                    </span>
                                </div>
                                <div class="upload-preview text-center upload-preview " style="top: 0px;width: 262px;border: 0px solid #e3e3e3;">
                                    <div class='border_img'>
                                        {if $list->logo}
                                            <img src="{$list->logo}" class="upload-preview-img jkl" style="width: 100px;height: 100px;">
                                        {else}
                                            <img src="images/class_noimg.jpg" class="upload-preview-img jkl1" style="width: 100px;height: 100px;">
                                        {/if}
                                        <span class="font_l" >(尺寸：100×100)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>店铺名称：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$list->name}</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>店铺信息：</span></div>
                        <div class="formInputSD">
                            <textarea name="mch[shop_information]" class="form-control input_450" >{$list->shop_information}</textarea>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>经营范围：</span></div>
                        <div class="formInputSD">
                            <textarea name="mch[shop_range]" class="form-control input_450" >{$list->shop_range}</textarea>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>用户名称：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$list->user_name}</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>真实姓名：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$list->realname}</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>身份证号码：</span></div>
                        <div class="formInputSD">
                            <text style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$list->ID_number}</text>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>联系电话：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="mch[tel]" value="{$list->tel}" class="input-text input_450" >
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>联系地址：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="mch[address]" value="{$list->address}" class="input-text input_450" >
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>所属性质：</span></div>
                        <div class="formInputSD">
                            <label class="radio-label">
                                <input type="radio" name="mch[shop_nature]" value="0" {if $list->shop_nature == 0}checked{/if} >
                                <span class="label-icon"></span>
                                <span class="label-text">个人</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="mch[shop_nature]" value="1" {if $list->shop_nature != 0}checked{/if} >
                                <span class="label-icon"></span>
                                <span class="label-text">企业</span>
                            </label>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>是否营业：</span></div>
                        <div class="formInputSD">
                            <label class="radio-label">
                                <input type="radio" name="mch[is_open]" value="0" {if $list->is_open == 0}checked{/if} >
                                <span class="label-icon"></span>
                                <span class="label-text">打烊</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="mch[is_open]" value="1" {if $list->is_open == 1}checked{/if}>
                                <span class="label-icon"></span>
                                <span class="label-text">营业</span>
                            </label>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>营业执照：</span></div>
                        <div class="formInputSD">
                            <div class="upload-group">
                                <div class="upload-preview text-center upload-preview">
                                    <span class="upload-preview-tip">100×100</span>
                                    <img class="upload-preview-img" src="{$list->business_license}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </table>
		<div style='height: 70px;'></div>
        <div class="page_h10 page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>
{include file="../../include_path/footer.tpl"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{literal}
<script type="text/javascript">
laydate.render({
    elem: '#shop_limitation', //指定元素
    type: 'datetime'
});
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
        dataType:"json",
        url:'index.php?module=mch&action=Modify',
        data:$('#form1').serialize(),// 你的formid
        async: true,
        success: function(data) {
            layer.msg(data.status, {time: 1000});
            setTimeout(function(){
                if(data.suc){
                    location.href="index.php?module=mch&action=Index";
                }
            },1000)
        }
    });
}
</script>
{/literal}
</body>
</html>