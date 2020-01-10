<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    {literal}
        <style type="text/css">
            .input-text, .scinput_s {
                width: 300px;
            }
            body {
                font-size: 16px;
            }

            .wrap {
                width: 60px;
                height: 30px;
                border-radius: 16px;
                position: relative;
                transition: 0.3s;
                margin: auto;
            }

            .open{
                background-color: #008DEF;
            }
            .close{
                background-color: #ccc;
            }

            .open1{
                left: 30px;
            }
            .close1{
                left: 0;
            }

            .circle {
                width: 29px;
                height: 29px;
                background-color: #fff;
                border-radius: 50%;
                position: absolute;
                transition: 0.3s;
                box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
            }

            .circle:hover {
                transform: scale(1.2);
                box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
            }

            .circle2 {
                width: 29px;
                height: 29px;
                background-color: #fff;
                border-radius: 50%;
                position: absolute;
                transition: 0.3s;
                box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
            }

            .circle2:hover {
                transform: scale(1.2);
                box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
            }

            .wrap_box {
                display: none;
            }

            .ta_btn1 {
                border: 1px solid #2890FF !important;
                color: #2890FF !important;
                text-align: center;
                margin-right: 40px !important;
            }

            form[name=form1] input[type=button] {
                width: 112px !important;
            }

            .formDivSD {
                margin-bottom: 0px !important;
            }

            .formTitleSD {
                font-weight: bold;
                color: #414658;
                border-bottom: 2px solid #E9ECEF;
            }

            .formListSD {
                color: #414658;
                min-height: 0px;
            }

            .formContentSD {
                padding: 30px 0px 30px 60px;
            }

            .formTextSD {
                margin-right: 8px;
            }

            .formTextSD span {
                height: 0px !important;
            }

            .formTextSDD {
                display: flex;
                align-items: center;
                padding-right: 5px;
            }

            .f_left {
                float: left;
            }

            form[name=form1] {
                padding: 0 !important;
            }

            .formTextSD {
                width: 150px;
            }

            .ra1 {
                width: 20px;
                float: left;
            }

            .input-text[type="number"] {
                width: 100px;
            }

            .page_bort {
                border-top: 1px solid #ddd!important;
                position: fixed;
                bottom: 10px!important;
                left: 10px!important;
                right: 10px!important;
                background: #fff!important;
                z-index: 9999;
                display: block!important;
                margin: 0!important;
                width: auto!important;
                height: auto!important;
            }
        </style>
    {/literal}
    <title>编辑分销等级</title>
</head>
<body>
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    <span style="color: #414658;">插件管理</span>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=distribution&amp;action=Index';">分销商管理 </a>
    <span class="c-gray en">&gt;</span>
    <span style="color: #414658;">编辑分销等级</span>
</nav>
<div class="page-container pd-20 page_absolute">
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data" style="padding: 0;">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;border: 1px solid darkgray;">
            <div class="formDivSD">
                <div class="formTitleSD">编辑分销等级</div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span>分销等级：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="s_dengjiname" value="{$re02.s_dengjiname}" class="input-text">
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>升级赠送积分：</span></div>
                        <div class="formInputSD">
                            <div class="status_box" style="padding-right: 50px;">
                                <input type="hidden" class="status" name="integrall" id="integrall" value="{$re->integral}">
                                <div class="wrap {if $re->integral>0}open{else}close{/if}">
                                    <div class="circle {if $re->integral>0}open1{else}close1{/if}"></div>
                                </div>
                            </div>
                            <div class="input" id="open_integral" {if $re->integral <=0}style="display: none;"{/if}>
                              <input type="number" name="integral" id="integral" min="0" max="100000" value="{$re->integral}" placeholder="" class="input-text">
                              <span class="addText">(用户升到此等级可获得奖励积分！)</span>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>会员购物可享折扣：</span></div>
                        <div class="formInputSD">
                            <div class="status_box" style="padding-right: 50px;">
                                <input type="hidden" class="status" name="discountt" id="discountt" value="{$re->discount}">
                                <div class="wrap {if $re->discount>0}open{else}close{/if}">
                                    <div class="circle2 {if $re->discount>0}open1{else}close1{/if}"></div>
                                </div>
                            </div>
                            <div class="input" id="open_discount" {if $re->discount <=0}style="display: none;"{/if}>
                              <input type="number" name="discount" id="discount" min="0" max="100000" value="{$re->discount}" placeholder="" class="input-text">
                              <span class="addText">(请填写0~1的小数！)</span>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>分销收益比例设置：</span></div>
                        <div class="formInputSD">
                            <input type="text" class="input-text" style="border: none!important;" disabled="disabled">
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="form_new_r form_yes" style="width: 45%;">
                            <div class="ra1" style="width: 100px;">
                                <input style="display: none;" class="inputC1" type="radio" name="price_type" id="radio1"
                                       value="0" {if $re02.price_type==0}checked="checked"{/if}>
                                <label for="radio1" class="price_type" data="0" style="margin-left: 0;">百分比</label>
                            </div>
                            <div class="ra1" style="width: 100px;">
                                <input style="display: none;" class="inputC1" type="radio" name="price_type" id="radio2"
                                       value="1" {if $re02.price_type==1}checked="checked"{/if}>
                                <label for="radio2" class="price_type" data="1"
                                       style="width: 80px!important;">固定金额</label>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            级差奖，可获得&nbsp<input type="number" name="different" min="0" value="{$re02.different}"
                                               class="input-text"><font
                                    class="percent">{if $re02.price_type==0}%{else}元{/if}</font>的佣金收益
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            同级奖，可获得&nbsp<input type="number" name="sibling" min="0" value="{$re02.sibling}"
                                               class="input-text"><font
                                    class="percent">{if $re02.price_type==0}%{else}元{/if}</font>&nbsp的佣金收益
                        </div>
                    </div>
                    {foreach from=$re02.levelmoney key=k item=item}
                        {if $k<=$cengji}
                            <div class="formListSD">
                                <div class="formTextSD"></div>
                                <div class="formInputSD">
                                    {$k} 级佣金，可获得&nbsp<input type="number" name="{$k}" min="0" value="{$item}" class="input-text levelmoney"><font class="percent">{if $re02.price_type==0}%{else}元{/if}</font>&nbsp的佣金收益
                                </div>
                            </div>
                        {/if}
                    {/foreach}
                    {section name=total loop=$cengji}
                        {if $smarty.section.total.iteration > $re02.length}
                            <div class="formListSD">
                                <div class="formTextSD"><span>{$smarty.section.total.iteration} 级佣金：</span></div>
                                <div class="formInputSD">
                                    {$smarty.section.total.iteration} 级佣金，可获得&nbsp<input type="number" name="{$smarty.section.total.iteration}" min="0" value="0" class="input-text levelmoney"><font class="percent">{if $re02.price_type==0}%{else}元{/if}</font>&nbsp的佣金收益
                                </div>
                            </div>
                        {/if}
                    {/section}
                    <div class="formListSD">
                        <div class="formTextSD"><span>晋级条件：</span></div>
                        <div class="formInputSD">
                            <input type="text" class="input-text" style="border: none!important;" disabled="disabled">
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            <div class="ra1">
                                <input name="onebuy" type="checkbox" id="onebuy_1" value="1" class="inputC"
                                       {if isset($re02.levelobj.onebuy)}checked{/if}>
                                <label for="onebuy_1" style="margin-top: -24px;position: relative;top: -18px;"></label>
                            </div>
                            <span class="formTextSDD">一次性消费满</span>
                            <input type="number" id="onebuy" value="{$re02.levelobj.onebuy}" class="input-text"
                                   style="width: 100px;">
                            <span class="formTextSDD">元</span>
                        </div>
                    </div>

                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            <div class="ra1">
                                <input name="recomm" type="checkbox" id="recomm_1" value="5" class="inputC"
                                       {if isset($re02.levelobj.recomm)}checked{/if}>
                                <label for="recomm_1" style="margin-top: -24px;position: relative;top: -18px;"></label>
                            </div>
                            <span class="formTextSDD">推荐</span>
                            <input type="number" id="recomm" value="{$re02.levelobj.recomm[0]}" class="input-text"
                                   style="width: 100px;">
                            <span class="formTextSDD">个级别为</span>
                            <select id="recomm1" class="input-text" style="width: 100px;">
                                {foreach from=$levels key=k item=item}
                                    <option value="{$k}" {if $k==$re02.levelobj.recomm[1]}selected{/if}>{$item}</option>
                                {/foreach}
                            </select>
                            <span class="formTextSDD">的会员</span>
                        </div>
                    </div>

                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            <div class="ra1">
                                <input name="manybuy" type="checkbox" id="manybuy_1" value="2" class="inputC"
                                       {if isset($re02.levelobj.manybuy)}checked{/if}>
                                <label for="manybuy_1" style="margin-top: -24px;position: relative;top: -18px;"></label>
                            </div>
                            <span class="formTextSDD">累计消费金额满</span>
                            <input type="number" id="manybuy" value="{$re02.levelobj.manybuy}" class="input-text"
                                   style="width: 100px;">
                            <span class="formTextSDD">元</span>
                        </div>
                    </div>

                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            <div class="ra1">
                                <input name="manyyeji" type="checkbox" id="manyyeji_1" value="3" class="inputC"
                                       {if isset($re02.levelobj.manyyeji)}checked{/if}>
                                <label for="manyyeji_1"
                                       style="margin-top: -24px;position: relative;top: -18px;"></label>
                            </div>
                            <span class="formTextSDD">累计业绩金额满</span>
                            <input type="number" id="manyyeji" value="{$re02.levelobj.manyyeji[0]}" class="input-text"
                                   style="width: 100px;">
                            <span class="formTextSDD">元</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"></div>
                        <div class="formInputSD">
                            <div class="ra1">
                                <input name="manypeople" type="checkbox" id="manypeople_1" value="4" class="inputC"
                                       {if isset($re02.levelobj.manypeople)}checked{/if}>
                                <label for="manypeople_1"
                                       style="margin-top: -24px;position: relative;top: -18px;"></label>
                            </div>
                            <span class="formTextSDD">直推人数满</span>
                            <input type="number" id="manypeople" value="{$re02.levelobj.manypeople[0]}"
                                   class="input-text" style="width: 100px;">
                            <span class="formTextSDD">个，团队人数满</span>
                            <input type="number" id="manypeople1" value="{$re02.levelobj.manypeople[1]}"
                                   class="input-text" style="width: 100px;">
                            <span class="formTextSDD">个</span>
                        </div>
                    </div>

                </div>
        </table>

        <div class="page_h10 page_bort" style="height: 68px!important;">
            <input class="fo_btn2" type="button" onclick="check()" value="保存" name="Submit">
            <a href="index.php?module=distribution&action=Distribution_grade" class="ta_btn1">取消</a>
        </div>

        <div class="page_h10" style="background-color: #edf1f5;"></div>
    </form>
    <div class="page_h20"></div>
</div>

</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{literal}
<script type="text/javascript">
    var aa = $(".pd-20").height();
    var bb = $(".table-hover").height();

    if (aa < bb) {
        $(".page_h20").css("display", "block")
    } else {
        $(".page_h20").css("display", "none")
        $(".row_cl").addClass("page_footer")
    }
    document.onkeydown = function (e) {
        if (!e) e = window.event;
        if ((e.keyCode || e.which) == 13) {
            $("[name=Submit]").click();
        }
    }

    $('.circle').click(function () {
        var left = $(this).css('left');
        left = parseInt(left);
        var status = $(this).parents(".status_box").children(".status");
        if (left == 0) {
            $(this).addClass('open1'),
            $(this).removeClass('close1'),
            $(this).parent(".wrap").addClass('open'),
            $(this).parent(".wrap").removeClass('close'),
            $("#open_integral").show();
            status.val(1);
        } else {
            $(this).removeClass('open1'),
            $(this).addClass('close1'),
            $(this).parent(".wrap").removeClass('open'),    
            $(this).parent(".wrap").addClass('close'),
            $("#open_integral").hide();
            $("#integral").val(0);
            status.val(0);
        }
    })

    $('.circle2').click(function () {
        var left = $(this).css('left');
        left = parseInt(left);
        var status = $(this).parents(".status_box").children(".status");
        if (left == 0) {
            $(this).addClass('open1'),
            $(this).removeClass('close1'),
            $(this).parent(".wrap").addClass('open'),
            $(this).parent(".wrap").removeClass('close'),
            $("#open_discount").show();
            status.val(1);
        } else {
            $(this).removeClass('open1'),
            $(this).addClass('close1'),
            $(this).parent(".wrap").removeClass('open'),    
            $(this).parent(".wrap").addClass('close'),
            $("#open_discount").hide();
            $("#discount").val(0);
            status.val(0);
        }
    })

    function check() {
        var checklevel = $("input[type=checkbox]:checked");
        var levelobj = {};
        var check = true;
        if (checklevel.length < 1) {
            layer.msg('请至少选择一个升级条件!');
            return;
        }
        $.each(checklevel, function (index, element) {               //获取升级条件信息
            var sellevel = $(element).attr('name');
            if (sellevel != 'manypro') {
                var levelval = $('#' + sellevel).val();
                if (levelval == '') {
                    layer.msg('所选择对应的条件值不能为空!');
                    check = false;
                } else {
                    if (sellevel == 'manyyeji' || sellevel == 'manypeople' || sellevel == 'recomm') {
                        var cengji = $('#' + sellevel + '1').val();
                        levelval = levelval + ',' + cengji;
                    }
                    levelobj[sellevel] = levelval;
                }
            } else {
                levelobj[sellevel] = '';
            }
        })

        var level = $('.levelmoney');
        var levelmoney = {};
        $.each(level, function (index, element) {
            var money = $(element).val();
            var levelnum = $(element).attr('name');
            if (money == '') {
                layer.msg('佣金不能为空!');
                check = false;
            } else {
                levelmoney[levelnum] = money;
            }
        });
        var id = '{/literal}{$re->id}{literal}';
        var s_dengjiname = $("input[name=s_dengjiname]").val();
        var sort = $("input[name=sort]").val();
        var price_type = $("input[name=price_type]:checked").val();
        var integral = $("input[name=integral]").val();
        var discount = $("input[name=discount]").val();
        var zhekou = $("input[name=zhekou]").val();
        var member_proportion = $("input[name=member_proportion]").val();
        var different = $("input[name=different]").val();
        var sibling = $("input[name=sibling]").val();
        if (check) {
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: 'index.php?module=distribution&action=Distribution_modify',
                data: {
                    id: id,
                    s_dengjiname: s_dengjiname,
                    sort: sort,
                    price_type: price_type,
                    integral: integral,
                    discount: discount,
                    zhekou: zhekou,
                    member_proportion: member_proportion,
                    levelobj: levelobj,
                    levelmoney: levelmoney,
                    different: different,
                    sibling: sibling
                },// 你的formid
                async: true,
                success: function (data) {
                    //console.log(data)
                    if (data.status == 1) {
                        layer.msg(data.msg, {time: 1000}, function () {
                            location.href = "index.php?module=distribution&action=Distribution_grade";
                        });
                    } else {
                        layer.msg(data.msg, {time: 1000});
                    }
                }
            });
        }
    }

    $('.price_type').click(function () {
        var price_type = $(this).siblings('input');
        if ($(price_type).val() == 1) {
            $('.percent').html('元');
        } else {
            $('.percent').html('%');
        }
    });

</script>
{/literal}
</body>
</html>