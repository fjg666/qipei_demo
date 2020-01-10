{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style type="text/css">
.inputC+label{border: 0;position: relative;}
.inputC+label:after{
    position: absolute;
    top: 2px;
    left: 0;
    width: 12px;
    height: 12px;
    border: 1px solid #ddd;
    content:"";
}
.inputC:checked +label::before{
    top: 3px;
    position: absolute;
    left: 0;
    height: 12px;
}
.radio-box{
    padding-left: 0px;
    padding-right: 10px;
}
.formTitleSD{
    font-weight: Bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
    height: 58px;
}
.formContentSD{
    padding: 28px 60px;
}
.formListSD{
    margin: 14px 0px;
}
.inputC:checked + label::before{
    width: 14px;
    height: 14px;
}

.formContentSD_left_text_color{
	color: #888f9e;
}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute form-scroll">
	<div class="page_title">查看商城</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0px;">
        <div class="formDivSD">
            <div class="formContentSD">
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">客户名称：</span></div>
                    <div class="formInputSD">
                        {$customer->name}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">客户编号：</span></div>
                    <div class="formInputSD">
                        {$customer->customer_number}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">公司名称：</span></div>
                    <div class="formInputSD">
                        {$customer->company}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">手机号：</span></div>
                    <div class="formInputSD">
                        {$customer->mobile}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">价格：</span></div>
                    <div class="formInputSD">
                        {$customer->price}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">邮箱：</span></div>
                    <div class="formInputSD">
                        {$customer->email}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">管理员账号：</span></div>
                    <div class="formInputSD">
                       {$customer->set_admin_name}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">管理员密码：</span></div>
                    <div class="formInputSD">
                        {$customer->password}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">到期时间：</span></div>
                    <div class="formInputSD">
                        {$customer->end_date}
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">客户端：</span></div>
                    <div class="formInputSD">
                        {foreach from=$role item=item key=key}
                        <div class="radio-box">
                            <input name="role[]" class="inputC input0" type="checkbox" id="sex-{$item->id}" value="{$item->id}" style="width: 0px;" {if $item->status != ''}checked{/if} disabled>
                            <label for="sex-{$item->id}"></label>
                            {$item->name}
                        </div>
                        {/foreach} 
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD"><span class="c-red"></span><span class="formContentSD_left_text_color">插件：</span></div>
                    <div class="formInputSD">
                        {foreach from=$list item=item key=key}
                        <div class="radio-box">
                            <input name="plug_in[]" class="inputC input0" type="checkbox" id="user-{$key}" value="{$item->id}" style="width: 0px;" {if $item->status != 0}checked="checked"{/if} disabled/>
                            <label for="user-{$key}"></label>
                            {$item->name}
                        </div>
                        {/foreach} 
                    </div>
                </div>
            </div>
        </div>
		
		<!-- 新增底部背景 -->
		<div style="height: 40px;background: #fff;"></div>
		
        <div class="page_h10 page_bort">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-right" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>
{include file="../../include_path/footer.tpl"}
</body>
</html>
