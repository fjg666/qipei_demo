{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style type="text/css">
.row .form-label{
    width: 14%!important;
}
.btn1{
    width:112px;
    height: 42px !important;
    line-height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    float: left;
    color: #6a7076;
    background-color: #fff;
}
.btn1:hover{
    text-decoration: none;
}
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}
.wrap {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
    margin-left: 10px;
}
.circle {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
  /*  left: 0px; */
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}

.circle:hover {
    transform: scale(1.2);
    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
}
.inputC1+label:after{
    left: -1px;
    top: 18px;
}
.inputC1:checked +label::before{
    top: 19px;
}
.text-c .inputC{
    margin-right: -1px;
    width: 0px;
}
.formContentSD{
    padding: 20px 0px;
}
.formTextSD{
    width: 180px;
    height: 40px;
}
.form_new_r .ra1 label{
    line-height: 52px;
}
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
</style>
{/literal}
<body>
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    卡券
    <span class="c-gray en">&gt;</span>
    优惠券设置
</nav>
<div class="pd-20 page_absolute ">
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">

        <a href="index.php?module=coupon" class="btn1 " style="height: 36px;border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;">优惠券列表</a>
        <a href="index.php?module=coupon&action=Config" class="btn1 swivch_active" style="height: 36px;border: none!important;border-top-right-radius: 2px;border-bottom-right-radius: 2px;">优惠券设置</a>
        
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>
    <form name="form1" id="form1" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding: 0px;">
        <div class="formDivSD">
            <div class="formTitleSD">基础设置</div>
            <div class="formContentSD">
                <div class="formListSD" style="margin: 2px 0px;">
                    <div class="formTextSD"><span>是否开启优惠券：</span></div>
                    <div class="formInputSD">
                        <div class="status_box">
                            <input type="hidden" class="status" name="is_status" id="is_status" value="{$is_status}">
                            <div class="wrap" style="{if $is_status==1}background-color:#2890FF;{else}background-color: #ccc;{/if}" {if $is_status>0}wopen{else}wclose{/if}>
                                <div class="circle {if $is_status>0}copen{else}cclose{/if}" style="{if $is_status==1}left:30px;{else}left:0px;{/if}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD" style="margin-top: 6px;"><span>是否自动清除过期优惠券：</span></div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="coupon_del"  type="radio" {if $coupon_del == 1}checked="checked"{/if} style="display: none;" id="coupon_del-1" class="inputC1" value="1" onclick="coupon1(1)">
                            <label for="coupon_del-1">是</label>
                        </div>
                        <div class="ra1">
                            <input name="coupon_del"  type="radio" {if $coupon_del != 1}checked="checked"{/if} style="display: none;" id="coupon_del-2" class="inputC1" value="2" onclick="coupon1(2)">
                            <label for="coupon_del-2">否</label>
                        </div>
                        <span id="tishi" style="color: #A8B0CB;margin-left: 12px;margin-top: 15px;">（这个是指自动清除前端用户已失效的优惠券记录）</span>
                    </div>
                </div>
                <div class="formListSD" id="coupon_del" {if $coupon_del != 1}style="display: none;" {/if}>
                    <div class="formTextSD" style="margin-top: 6px;"><span></span></div>
                    <div class="form_new_r form_yes">
                        <span style="margin-right: 12px;color: #414658;">优惠券过期后</span>
                        <input type="number" style="margin-right: 0px;width: 76px;" name="coupon_day" value="{$coupon_day}" class="input-text" >
                        <span style="margin-left: 12px;color: #414658;">天，系统自动清除。</span>
                    </div>
                </div>
                <div class="formListSD">
                    <div class="formTextSD" style="margin-top: 6px;"><span>是否自动清除过期活动：</span></div>
                    <div class="form_new_r form_yes">
                        <div class="ra1">
                            <input name="activity_del"  type="radio" {if $activity_del == 1}checked="checked"{/if} style="display: none;" id="activity_del-1" class="inputC1" value="1" onclick="coupon2(1)">
                            <label for="activity_del-1">是</label>
                        </div>
                        <div class="ra1">
                            <input name="activity_del"  type="radio" {if $activity_del != 1}checked="checked"{/if} style="display: none;" id="activity_del-2" class="inputC1" value="2" onclick="coupon2(2)">
                            <label for="activity_del-2">否</label>
                        </div>
                        <span id="tishi" style="color: #A8B0CB;margin-left: 12px;margin-top: 15px;">（这个是指自动清除优惠券列表的已过期记录）</span>
                    </div>
                </div>
                <div class="formListSD" id="activity_del" {if $activity_del != 1}style="display: none;" {/if}>
                    <div class="formTextSD" style="margin-top: 6px;"><span></span></div>
                    <div class="form_new_r form_yes">
                        <span style="margin-right: 12px;color: #414658;">活动过期后</span>
                        <input type="number" style="margin-right: 0px;width: 76px;" name="activity_day" value="{$activity_day}" class="input-text" >
                        <span style="margin-left: 12px;color: #414658;">天，系统自动清除。</span>
                    </div>
                </div>
                <div class="formListSD" >
                    <div class="formTextSD"><span>限领设置：</span></div>
                    <div class="form_yes" style="margin-top: -6px;">
                        <div class="ra1" style="margin-bottom: 22px;">
                            <input name="limit_type"  type="radio" {if $limit_type == 0}checked="checked"{/if} style="display: none;" id="limit_type-1" class="inputC1" value="0">
                            <label for="limit_type-1" style="width: 400px;padding-left: 20px;line-height: 50px;">每人限领 1 张</label>
                        </div>
                        <div class="ra1">
                            <input name="limit_type"  type="radio" {if $limit_type == 1}checked="checked"{/if} style="display: none;" id="limit_type-2" class="inputC1" value="1">
                            <label for="limit_type-2" style="width: 400px;padding-left: 20px;line-height: 50px;">每人可领多张</label>
                        </div>
                    </div>
                </div>
                <div class="formListSD" style="margin-top: 56px;">
                    <div class="formTextSD" style="align-items: start;"><span style="height: 12px; margin-top: 8px;">优惠券类型设置：</span></div>
                    <div class="formInputSD" >
                        <table >
                            <thead>
                                <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                    <th width="40" style="border-bottom: 0px solid #d5dbe8!important;height: 0px;">
                                        <div style="position: relative;display: flex;height: 30px;align-items: center;float: left;">
                                            <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
                                            <label for="ipt1"></label>
                                            <span >全选</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                    <td style="height: 0px;">
                                        <div style="display: flex;align-items: center;float: left;">
                                            <input name="coupon_type[]"  id="type_1" type="checkbox" class="inputC inputC_y" value="1" {if in_array(1,$coupon_type)}checked{/if}>
                                            <label for="type_1"></label>
                                            <span >免邮券</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                    <td style="height: 0px;">
                                        <div style="display: flex;align-items: center;float: left;">
                                            <input name="coupon_type[]"  id="type_2" type="checkbox" class="inputC inputC_y" value="2" {if in_array(2,$coupon_type)}checked{/if}>
                                            <label for="type_2"></label>
                                            <span >满减券</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                    <td style="height: 0px;">
                                        <div style="display: flex;align-items: center;float: left;">
                                            <input name="coupon_type[]"  id="type_3" type="checkbox" class="inputC inputC_y" value="3" {if in_array(3,$coupon_type)}checked{/if}>
                                            <label for="type_3"></label>
                                            <span >折扣券</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-c " style="border-bottom: 0px solid #eee;padding: 0px;height: 0px;">
                                    <td style="height: 0px;">
                                        <div style="display: flex;align-items: center;float: left;">
                                            <input name="coupon_type[]"  id="type_4" type="checkbox" class="inputC inputC_y" value="4" {if in_array(4,$coupon_type)}checked{/if}>
                                            <label for="type_4"></label>
                                            <span >会员赠券</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="page_h10" style="height: 68px!important;border-top: solid 1px #E9ECEF;">
            <input type="button" name="Submit" value="保存" class="fo_btn2" onclick="check()" style="margin-right: 60px!important;">
        </div>
    </form>
    <div class="page_h20"></div>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
    // 进网页判断是否已经全选
    var flag=true;
    for(var i=0;i<$('.inputC_y').length;i++){
        if(!$('.inputC_y').eq(i).is(':checked')){
            flag=false
        }
    }
    $("#ipt1").prop('checked',flag)

    // 单选按钮选择
    $(".inputC_y").on('change',function(){
        var flag=true;
        for(var i=0;i<$('.inputC_y').length;i++){
            if(!$('.inputC_y').eq(i).is(':checked')){
                flag=false
            }
        }
        $("#ipt1").prop('checked',flag)
    })

    var aa=$(".pd-20").height()-16-56;
    var bb=$(".form-horizontal").height();
    if(aa<bb){
        $(".page_h20").css("display","block")
    }else{
        $(".page_h20").css("display","none")
        $(".row_cl").addClass("page_footer")
    }
    $('.circle').click(function () {
        var left = $(this).css('left');
        left = parseInt(left);
        var status = $(this).parents(".status_box").children(".status");
        if (left == 0) {
            $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap").css('background-color', '#2890FF');
            $(".wrap_box").show();
            $(status).val(1);
        } else {
            $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap").css('background-color', '#ccc');
            $(".wrap_box").hide();
            $(status).val(0);
        }
    })
    if (document.getElementById('is_status').value == 0) {
        $(".wrap_box").hide();
    } else {
        $(".wrap_box").show();
    }
    function coupon1(obj){
        if(obj == 1){
            document.getElementById('coupon_del').style.display = ""; // 显示
        }else{
            document.getElementById('coupon_del').style.display = "none"; // 隐藏
        }
    }
    function coupon2(obj){
        if(obj == 1){
            document.getElementById('activity_del').style.display = ""; // 显示
        }else{
            document.getElementById('activity_del').style.display = "none"; // 隐藏
        }
    }
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
            url:'index.php?module=coupon&action=Config',
            data:$('#form1').serialize(),// 你的formid
            async: true,
            success: function(data) {
                layer.msg(data.status,{time:1000});
                setTimeout(function(){
                    if(data.suc){
                        location.href="index.php?module=coupon&action=Config";
                    }
                },1000)
            }
        });
    }
</script>
{/literal}
</body>
</html>