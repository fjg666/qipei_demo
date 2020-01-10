{include file="../../include_path/header.tpl" sitename="公共头部"}
{literal}
<style>
div {
    margin: 0;
    line-height: 1.5;

}
p {
    margin: 0;
    padding: 5px 10px;
    height: 34px;
    line-height: 24px;
    position: relative;
    box-sizing: border-box;
}
.inputC + label {
    top: 3px;
}
.inputC:checked + label::before {
    position: absolute;
    top: 0px;
}
.checks {
    padding-left: 20px;
}

input {
    margin-right: 5px;
}
.permission-list {
    border: none;
}
.checks_one, .checks_hree {
    display: none;
}
.checks_four {
    display: block;
}
.checks_four1{
    display: block;
    padding-left: 40px;
}
</style>
{/literal}
<body style="overflow-x: hidden;">
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>

    <a style="margin-top: 10px; text-decoration:none;"  onclick="location.href='index.php?module=plug_ins';">插件列表 </a>
    <span class="c-gray en">&gt;</span>
    店铺权限
</nav>

<div class="pd-20 page_absolute form-scroll">
	<div class="page_title">店铺权限</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding-top: 0;margin-top: 40px;">
        <input type="hidden" name="id" value="{$id}"/>
        <div class="row cl">
            <label class="form-label col-2"><span class="c-red"></span>角色名称：</label>
            <div class="formControls col-10">
                <input type="text" class="input-text" name="name" value="商户管理" readonly="readonly">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">店铺权限：</label>
            <div class="J_CheckWrap col-xs-8 col-sm-8">
                <div class="permi_click" style="padding-top: 10px!important;">
                    <input type="checkbox" class="inputC" id="user-{$key}" value="{$item->id}" name="permission[]" {if $item->status == 1}checked="checked"{/if}/>
                    <label for="user-{$key}"></label>
                    <span class="for_ns">全选</span>
                </div>
                {foreach from=$list item=item key=key}
                <div class="permission-list" style="padding-top: 10px!important;">
                    <input type="checkbox" class="inputC input0" id="user-{$key}" value="{$item->id}" name="permission[]" {if $item->status == 1}checked="checked"{/if}/>
                    <label for="user-{$key}"></label>
                    <span class="for_n">
                        {$item->title}
                        <span style="color: red;">({$item->title_name})</span>
                    </span>
                    <div class="checks checks_one">
                        {foreach from=$item->res item=item1 key=key1}
                        <div class="permission-list2 checks_two " style="margin:10px 15px;">
                            <input type="checkbox" class="inputC input1" value="{$item1->id}" name="permission[]" {if $item1->status == 1}checked="checked"{/if} id="user-{$key}-{$key1}"/>
                            <label for="user-{$key}-{$key1}"></label>
                            <span class="page_name">{$item1->title}</span>
                            {if $item1->res}
                                <div class="checks checks_hree" style="border-bottom: solid 1px #eee;padding-bottom: 20px">
                                    {foreach from=$item1->res item=item2 key=key2}
                                    <div class="permission-list3 checks_four">
                                        <input type="checkbox" class="inputC input2" value="{$item2->id}" name="permission[]" {if $item2->status == 1}checked="checked"{/if} id="user-{$key}-{$key1}-{$key2}"/>
                                        <label for="user-{$key}-{$key1}-{$key2}"></label>
                                        <span class="page_name">{$item2->title}</span>
                                        {if $item2->res}
                                            {foreach from=$item2->res item=item3 key=key3}
                                                <div class="checks_four checks_four1">
                                                    <input class="inputC input3" type="checkbox" value="{$item3->id}" name="permission[]" {if $item3->status == 1}checked="checked"{/if} id="user-{$key}-{$key1}-{$key2}-{$key3}"/>
                                                    <label for="user-{$key}-{$key1}-{$key2}-{$key3}" style="display: inline-block;"></label>
                                                    <span class="page_name">{$item3->title}</span>
                                                </div>
                                            {/foreach} 
                                        {/if}
                                    </div>
                                    {/foreach} 
                                </div>
                            {/if}
                        </div>
                        {/foreach} 
                    </div>
                </div>
                {/foreach} 
            </div>
        </div>
		<div style="height: 70px;"></div>
        <div class="page_bort">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()">
            <input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
        </div>
    </form>
</div>

{include file="../../include_path/footer.tpl"}
{literal}
<script>
document.onkeydown = function (e) {
    if (!e) e = window.event;
    if ((e.keyCode || e.which) == 13) {
        $("[name=Submit]").click();
    }
}

var aa = $(".pd-20").height();
var bb = $("#form1").height();
if (aa < bb) {
    $(".page_h20").css("display", "block")
} else {
    $(".page_h20").css("display", "none")
}

function check() {
    $.ajax({
        cache: true,
        type: "POST",
        dataType: "json",
        url: 'index.php?module=plug_ins&action=Role',
        data: $('#form1').serialize(),// 你的formid
        async: true,
        success: function (data) {
            layer.msg(data.status, {time: 2000});
            if (data.suc) {
                location.href = "index.php?module=plug_ins";
            }
        }
    });
}

$(".permi_click").click(function () {
    if ($(this).find("input").hasClass('activeBtn')) {
        $(this).find('input').prop('checked', true);
        $(this).find("input").removeClass("activeBtn");
        $(this).siblings(".permission-list").find('input').prop('checked', false);
        $(this).siblings('.permission-list').find('input').removeClass("activeBtn");
    } else {
        $(this).find('input').prop('checked', false);
        $(this).find("input").addClass("activeBtn");
        $(this).siblings(".permission-list").find('input').prop('checked', true);
        $(this).siblings('.permission-list').find('input').addClass("activeBtn");
    }
})

$(".for_ns").click(function () {
    if ($(this).siblings("input").hasClass('activeBtn')) {
        $(this).siblings('input').prop('checked', false);
        $(this).siblings("input").removeClass("activeBtn");
        $(this).parent(".permi_click").siblings(".permission-list").find('input').prop('checked', false);
        $(this).parent(".permi_click").siblings(".permission-list").find('input').removeClass("activeBtn");
    } else {
        $(this).siblings('input').prop('checked', true);
        $(this).siblings("input").addClass("activeBtn");
        $(this).parent(".permi_click").siblings(".permission-list").find('input').prop('checked', true);
        $(this).parent(".permi_click").siblings(".permission-list").find('input').addClass("activeBtn");
    }
    event.stopPropagation()
})

$("[type=checkbox]").each(function () {
    $(this).click(function () {
        if ($(this).hasClass('activeBtn')) {//判断是否有class ---是----点击
            if ($(this).siblings("span").text() == "全选") {

            } else {
                let a = 0, b = 0, c = 0;
                $(this).removeClass('activeBtn');
                $(this).parents('.permission-list2').find(".input3").each(function () {
                    if ($(this).prop('checked')) {
                        a += 1;
                    }
                    ;
                })
                $(this).parents('.permission-list2').find(".input2").each(function () {
                    if ($(this).prop('checked')) {
                        b += 1;
                    }
                    ;
                })
                $(this).parents('.permission-list').find(".input1").each(function () {
                    if ($(this).prop('checked')) {
                        c += 1;
                    }
                    ;
                })
                //判断四级input有没有兄弟元素被选中
                if ($(this).hasClass('input3')) {
                    if (a == 0) {//没有兄弟元素被选中时
                        $(this).parents('.permission-list3').find('.input2').prop('checked', false);
                        $(this).parents('.permission-list3').find('.input2').removeClass("activeBtn");
                        if (b == 1) {
                            $(this).parents('.permission-list2').find('.input1').prop('checked', false);
                            $(this).parents('.permission-list2').find('.input1').removeClass("activeBtn");
                            if (c == 1) {
                                $(this).parents('.permission-list').find('.input0').prop('checked', false);
                                $(this).parents('.permission-list').find('.input0').removeClass("activeBtn");
                            }
                        }
                    }
                }

                //判断三级input有没有兄弟元素被选中
                if ($(this).hasClass('input2')) {
                    console.log(b, c);
                    $(this).siblings().find('.input3').prop('checked', false);
                    $(this).siblings().find('.input3').removeClass("activeBtn");
                    if (b == 0) {//没有兄弟元素被选中时
                        $(this).parents('.permission-list2').find('.input1').prop('checked', false);
                        $(this).parents('.permission-list2').find('.input1').removeClass("activeBtn");
                        if (c == 1) {
                            $(this).parents('.permission-list').find('.input0').prop('checked', false);
                            $(this).parents('.permission-list').find('.input0').removeClass("activeBtn");
                        }
                    }
                }
                if ($(this).hasClass('input1')) {
                    $(this).siblings().find('.input3,.input2').prop('checked', false);
                    $(this).siblings().find('.input3,.input2').removeClass("activeBtn");
                    console.log(c);
                    if (c == 0) {
                        $(this).parents('.permission-list').find('.input0').prop('checked', false);
                        $(this).parents('.permission-list').find('.input0').removeClass("activeBtn");
                    }
                }
                if ($(this).hasClass('input0')) {
                    $(this).siblings().find('.input3,.input2,.input1').prop('checked', false);
                    $(this).siblings().find('.input3,.input2,.input1').removeClass("activeBtn");
                }
            }
        }
        else {//判断是否有class ---否---点击
            if ($(this).siblings("span").text() == "全选") {
            } else {
                $(this).addClass("activeBtn");
                $(this).siblings().find('input:checkbox').prop('checked', true);
                $(this).parents('input:checkbox').prop('checked', true);
                $(this).parents('.permission-list3').find('.input2').prop('checked', true);
                $(this).parents('.permission-list2').find('.input1').prop('checked', true);
                $(this).parents('.permission-list').find('.input0').prop('checked', true);
                $(this).siblings().find('input:checkbox').addClass("activeBtn");
                $(this).parents('input:checkbox').addClass("activeBtn");
                $(this).parents('.permission-list3').find('.input2').addClass("activeBtn");
                $(this).parents('.permission-list2').find('.input1').addClass("activeBtn");
                $(this).parents('.permission-list').find('.input0').addClass("activeBtn");
            }
        }
        event.stopPropagation()
    })
})
$(".for_n").click(function () {
    $(this).siblings(".checks_one").slideToggle()
})

$(".page_name").click(function () {
    $(this).siblings(".checks_hree").slideToggle()
    event.stopPropagation()
})
</script>
{/literal}
</body>
</html>