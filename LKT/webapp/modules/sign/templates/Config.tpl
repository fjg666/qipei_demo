{include file="../../include_path/header.tpl" sitename="DIY头部"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{literal}
<style>
.row .form-label{
    width: 14%!important;
}
.btn1{
    width: 112px;
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
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}

.formContentSD{
    padding-left: 10px;
}
.formTitleSD{
    font-weight:bold;
    font-size: 16px;
    border-bottom: 2px solid #E9ECEF;
}
.formTextSD{
    width: 228px;
    height: 40px;
    font-size: 14px;
}
.inputC1:checked + label::before{
    width: 16px;
    height: 16px;
}
.wopen{
    background-color: #5eb95e;
}
.wclose{
    background-color: #ccc;
}
.copen{
    left:30px;
}
.cclose{
    left:0px;
}
.wrap {
    width: 60px;
    height: 30px;
    background-color: #ccc;
    border-radius: 16px;
    position: relative;
    transition: 0.3s;
}
.circle {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
/*    left: 0px; */
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}

.circle:hover {
    transform: scale(1.2);
    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
}

.circle1 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
	/*  */
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.circle1:hover {
    transform: scale(1.2);
    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
}
.circle2 {
    width: 29px;
    height: 29px;
    background-color: #fff;
    border-radius: 50%;
    position: absolute;
    /*  */
    transition: 0.3s;
    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
}
.circle2:hover {
    transform: scale(1.2);
    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
}
form[name=form1] input[type=button]{width: 112px!important;}

.layui-laydate-content thead tr th{border-bottom: none !important;}
.layui-laydate-content tr{height: auto !important;border: none;}
#editor{width: 105%}
#editor1{width: 105%}

.formListSD{font-size: 14px;}
.formListSD .btn{width:20px;height: 20px;padding: 0;margin-right: 10px;}
.addBtn{display: none;}

.hint{font-size: 14px;color: #97A0B4;margin-bottom: 0;margin-left: 15px;}
.checkSign{font-size: 14px;}
</style>
{/literal}

<body class="iframe-container">
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}

<nav class="nav-title">
	<span>插件管理</span>
	<span><span class="arrows">&gt;</span>签到</span>
	<span><span class="arrows">&gt;</span>签到设置</span>
</nav>
<div class="iframe-content">
	<div class="navigation">
	    <div>
			<a href="index.php?module=sign">签到列表</a>
		</div>
		<p class='border'></p>
	    <div class='active'>
			<a href="index.php?module=sign&action=Config">签到设置</a>
		</div>
	</div>
    <div class="page_h16"></div>
    <form name="form1" id="form1" class="form form-horizontal form-scroll" method="post" enctype="multipart/form-data" style="padding: 0px !important;flex: 1;">
        <table class="table table-bg table-hover " style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD page_title">基础设置</div>
                <div class="formContentSD">
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>签到插件是否启用：</span></div>
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
                        <div class="formTextSD"><span>签到有效期：</span></div>
                        <div class="formInputSD">
                            <div style="position: relative;display: inline-block;">
                                <input type="text" class="input-text" value="{$starttime}" autocomplete="off" placeholder="" id="starttime" name="starttime" style="width:175px;">
                            </div>
                            至
                            <div style="position: relative;display: inline-block;margin-left: 5px;">
                                <input type="text" class="input-text" value="{$endtime}" autocomplete="off" placeholder="" id="endtime" name="endtime" style="width:175px;">
                            </div>
                        </div>
                    </div>
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formTextSD"><span>登陆即提示签到：</span></div>
                        <div class="formInputSD">
                            <div class="status_box">
                                <input type="hidden" class="status" name="is_remind" id="is_remind" value="{$is_remind}">
                                <div class="wrap" style="{if $is_remind==1}background-color:#2890FF;{else}background-color: #ccc;{/if}" {if $is_remind>0}wopen{else}wclose{/if}>
                                    <div class="circle1 {if $is_remind>0}copen{else}cclose{/if}" style="{if $is_remind==1}left:30px;{else}left:0px;{/if}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="formListSD">
					      <div class="formTextSD"><span>允许当天签到多次：</span></div>
					      <div class="formInputSD">
					          <div class="status_box">
					              <input type="hidden" class="status" name="is_many_time" id="is_many_time" value="{$is_many_time}">
					              <div class="wrap" style="{if $is_many_time==1}background-color:#2890FF;{else}background-color: #ccc;{/if}" {if $is_many_time>0}wopen{else}wclose{/if}>
					                  <div class="circle2 {if $is_many_time>0}copen{else}cclose{/if}" style="{if $is_many_time==1}left:30px;{else}left:0px;{/if}"></div>
					            </div>
					        </div>
							<p class='hint'>（开启允许当天签到多次时，当天每次签到则按单次签到成功的积分奖励计算）</p>
					  </div>
					</div>
                    <div class="formListSD checkSign" style='background: #F4F7F9;margin-left: 238px;padding: 10px;flex-direction: column;'>
						<div class="formListSD" style="margin: 0;margin-bottom: 14px;">
						    <div style='line-height: 36px;'>签到次数：</div>
						    <div class="formInputSD">
						       <input type="number" name="score_num" value="{$score_num}" style="margin-right: 8px;width: 100px;">
						       次
						       <span class='hint'>（每天可签到次数最多不能超过6次）</span>
						    </div>
						</div>
						<div class="formListSD" style="margin: 0;">
						    <div style='line-height: 36px;'>间隔时间：</div>
						    <div class="formInputSD">
						        <input type="number" name="reset_h" id="reset_h" {if $reset_h}value="{$reset_h}"{else}value="00"{/if}  class="input-text" style="margin-right: 8px;width: 100px;" >
						        时
						        <input type="number" name="reset_i" id="reset_i" {if $reset_i}value="{$reset_i}"{else}value="00"{/if} class="input-text" style="margin-left: 8px;width: 100px;" >
								分
						        <span class='hint'>（需要隔多少时间重置一次）</span>
						    </div>
						</div>
					</div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>签到奖励设置：</span></div>
                        <div class="formInputSD">

                        </div>
                    </div>
                    <div style="margin-left: 238px;" id="num">
                        <div class="formListSD" >
                            <div class="formInputSD">
                                <span style="margin-right: 12px;">单次签到成功，可获得</span>
                                <input type="number" style="margin-right: 0px;width: 100px;" name="score" value="{$score}" class="input-text" >
                                <span style="margin-left: 12px;">积分奖励</span>
                            </div>
                        </div>
                        <input type="hidden" class="input-text" value="{$num}" name="num" id="num1">
                        {if $continuity == ''}
                            <div class="formListSD" id="num_1" style='align-items: center;'>
                                <div class="formInputSD">
                                    <span style="margin-right: 12px;">连续签到成功</span>
                                    <input type="number" name="continuity_num[]" value="" id="continuity_num1" onblur="jiancha1(1)" class="input-text" style="margin-right: 0px;width: 100px;">
                                    <span style="margin-left: 12px;margin-right: 12px;">天，可获得</span>
                                    <input type="number" name="continuity_score[]" value="" id="continuity_score1" onblur="jiancha2(1)" class="input-text" style="margin-right: 0px;width: 100px;">
                                    <span style="margin-left: 12px;">积分奖励</span>
                                </div>
								<div class="btn " onclick="del(1)" style='margin-left: 20px;'><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
                                <div class="btn addBtn" onclick="add()"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>
								<p class='hint' style='width: 40%;'>（连续签到以天为单位计算，且当天只计算一次；断签后则重新开始）</p>
							</div>
                            <div class="formListSD" id="num_2" style='align-items: center;'>
                                <div class="formInputSD">
                                    <span style="margin-right: 12px;">连续签到成功</span>
                                    <input type="number" name="continuity_num[]" value="" id="continuity_num2" onblur="jiancha1(2)" class="input-text" style="margin-right: 0px;width: 100px;">
                                    <span style="margin-left: 12px;margin-right: 12px;">天，可获得</span>
                                    <input type="number" name="continuity_score[]" value="" id="continuity_score2" onblur="jiancha2(2)" class="input-text" style="margin-right: 0px;width: 100px;">
                                    <span style="margin-left: 12px;">积分奖励</span>
                                </div>
                                <div class="btn " onclick="del(2)" style='margin-left: 20px;'><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
								<div class="btn addBtn" onclick="add()"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>
							</div>
                        {else}
                            {foreach from=$continuity item=item name=f1 key=k}
                                {if $k == 0}
                                    {foreach from=$item item=item1 name=f2 key=k1}
                                        <div class="formListSD" id="num_{$k+1}" style='align-items: center;'>
                                            <div class="formInputSD">
                                                <span style="margin-right: 12px;">连续签到成功</span>
                                                <input type="number" name="continuity_num[]" value="{$k1}" id="continuity_num1" onblur="jiancha1(1)" class="input-text" style="margin-right: 0px;width: 100px;">
                                                <span style="margin-left: 12px;margin-right: 12px;">天，可获得</span>
                                                <input type="number" name="continuity_score[]" value="{$item1}" id="continuity_score1" onblur="jiancha2(1)" class="input-text" style="margin-right: 0px;width: 100px;">
                                                <span style="margin-left: 12px;">积分奖励</span>
                                            </div>
											<div class="btn " onclick="del({$k+1})" style='margin-left: 20px;'><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
											<div class="btn addBtn" onclick="add()"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>
											<p class='hint' style='width: 40%;'>（连续签到以天为单位计算，且当天只计算一次；断签后则重新开始）</p>
                                        </div>
                                    {/foreach}
                                {elseif $k == 1}
                                    {foreach from=$item item=item1 name=f2 key=k1}
                                        <div class="formListSD" id="num_{$k+1}" style='align-items: center;'>
                                            <div class="formInputSD">
                                                <span style="margin-right: 12px;">连续签到成功</span>
                                                <input type="number" name="continuity_num[]" value="{$k1}" id="continuity_num2" onblur="jiancha1(2)" class="input-text" style="margin-right: 0px;width: 100px;">
                                                <span style="margin-left: 12px;margin-right: 12px;">天，可获得</span>
                                                <input type="number" name="continuity_score[]" value="{$item1}" id="continuity_score2" onblur="jiancha2(2)" class="input-text" style="margin-right: 0px;width: 100px;">
                                                <span style="margin-left: 12px;">积分奖励</span>
                                            </div>
                                            <div class="btn " onclick="del({$k+1})" style='margin-left: 20px;'><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
                                            <div class="btn addBtn" onclick="add()"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>
                                        </div>
                                    {/foreach}
                                {else}
                                    {foreach from=$item item=item1 name=f2 key=k1}
                                        <div class="formListSD" id="num_{$k+1}" style='align-items: center;'>
                                            <div class="formInputSD">
                                                <span style="margin-right: 12px;">连续签到成功</span>
                                                <input type="number" name="continuity_num[]" value="{$k1}" id="continuity_num{$k+1}" onblur="jiancha1({$k+1})" class="input-text" style="margin-right: 0px;width: 100px;">
                                                <span style="margin-left: 12px;margin-right: 12px;">天，可获得</span>
                                                <input type="number" name="continuity_score[]" value="{$item1}" id="continuity_score{$k+1}" onblur="jiancha2({$k+1})" class="input-text" style="margin-right: 0px;width: 100px;">
                                                <span style="margin-left: 12px;">积分奖励</span>
                                            </div>
											<div class="btn " onclick="del({$k+1})" style='margin-left: 20px;'><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
											<div class="btn addBtn" onclick="add()"><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>
                                        </div>
                                    {/foreach}
                                {/if}
                            {/foreach}
                        {/if}
                    </div>
                </div>
            </div>
            <div style="padding: 10px 0px;background-color: #edf1f5!important;"></div>

			<div class="formDivSD">
				<div class="formTitleSD page_title">规则设置</div>
				<div class="formContentSD" style="padding-left: 30px;padding-right: 0px;">
                    <div class="formListSD" style="margin: 2px 0px;">
						<div class="formControls col-xs-8 col-sm-10 codes" style="padding-left: 0px;padding-right: 8px;">
							<script id="editor" type="text/plain" name="detail" style="height: 400px;">{$detail}</script>
						</div>
					</div>
				</div>
			</div>

            <div style="padding: 10px 0px;background-color: #edf1f5!important;"></div>

            <div class="formDivSD">
                <div class="formTitleSD page_title">积分使用说明</div>
                <div class="formContentSD" style="padding-left: 30px;padding-right: 0px;">
                    <div class="formListSD" style="margin: 2px 0px;">
                        <div class="formControls col-xs-8 col-sm-10 codes" style="padding-left: 0px;padding-right: 8px;">
                            <script id="editor1" type="text/plain" name="Instructions" style="height: 400px;">{$Instructions}</script>
                        </div>
                    </div>
                </div>
            </div>
        </table>
		<div style="height: 70px;"></div>
        <div class="page_h10 page_bort">
            <input type="button" name="Submit" value="确认" class="fo_btn2 btn-right" onclick="check()">
        </div>
    </form>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}
<script>

// 设置连续签到最后一条的添加按钮为显示
$(function(){
	$('.addBtn').eq($('.addBtn').length-1).css('display','block')
})

var left = 0;
$('.circle').click(function () {
    left = $(this).css('left');
    left = parseInt(left);
    var status = $(this).parents(".status_box").children(".status");
    if (left == 0) {
        $(this).css('left', '30px'),
        $(this).css('background-color', '#fff'),
        $(this).parent(".wrap").css('background-color', '#2890FF');
        $(".wrap_box").show();
        status.val(1);
    } else {
        $(this).css('left', '0px'),
        $(this).css('background-color', '#fff'),
        $(this).parent(".wrap").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status.val(0);
    }
})
if (document.getElementById('is_status').value == 0) {
	// 已用PHP在行内控制
    $(".wrap_box").hide();
} else {
    $(".wrap_box").show();
}
$('.circle1').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status = $(this).parents(".status_box").children(".status");
    if (left == 0) {
        $(this).css('left', '30px'),
        $(this).css('background-color', '#fff'),
        $(this).parent(".wrap").css('background-color', '#2890FF');
        $(".wrap_box").show();
        status.val(1);
    } else {
        $(this).css('left', '0px'),
        $(this).css('background-color', '#fff'),
        $(this).parent(".wrap").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status.val(0);
    }
})
if (document.getElementById('is_remind').value == 0) {
    $(".wrap_box").hide();
} else {
    $(".wrap_box").show();
}
$('.circle2').click(function () {
    var left = $(this).css('left');
    left = parseInt(left);
    var status = $(this).parents(".status_box").children(".status");
    if (left == 0) {
        $(this).css('left', '30px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap").css('background-color', '#2890FF');
        $(".wrap_box").show();
        status.val(1);
        $('.checkSign').css('display','block')

    } else {
        $(this).css('left', '0px'),
            $(this).css('background-color', '#fff'),
            $(this).parent(".wrap").css('background-color', '#ccc');
        $(".wrap_box").hide();
        status.val(0);
        $('.checkSign').css('display','none')

    }
})
if (document.getElementById('is_many_time').value == 0) {
    // 已用PHP在行内控制
    $(".wrap_box").hide();
    $('.checkSign').css('display','none')
} else {
    $(".wrap_box").show();
    $('.checkSign').css('display','block')
}
laydate.render({
    elem: '#starttime', //指定元素
    type: 'datetime'
});
laydate.render({
    elem: '#endtime',
    type: 'datetime'
});
$("#reset_h").blur(function () {
    var m = $("#reset_h").val();
    if (Number(m) < 0) {
        layer.msg("小时不能为负数");
        $("#reset_h").val('00');
        return false;
    } else if (Number(m) > 24) {
        layer.msg("小时不能超过24");
        $("#reset_h").val('24');
        return false;
    }
});
$("#reset_i").blur(function () {
    var m = $("#reset_i").val();
    if (Number(m) < 0) {
        layer.msg("分钟不能为负数");
        $("#reset_i").val('00');
        return false;
    } else if (Number(m) > 59) {
        layer.msg("分钟不能超过59");
        $("#reset_i").val('59');
        return false;
    }
});

var num = $("#num1").val();
// 增加连续签到设置
function add() {
    num++;
    var rew = '';
    rew = "<div class='formListSD' id='num_" + num + "' style='align-items:center;'>" +
        "<div class='formInputSD'>" +
        "<span style='margin-right: 12px;'>连续签到成功</span>" +
        "<input type='number' name='continuity_num[]' value='' id='continuity_num"+num+"' onblur='jiancha1("+num+")' class='input-text' style='margin-right: 0px;width: 100px;'>" +
        "<span style='margin-left: 12px;margin-right: 12px;'>次，可获得</span>" +
        "<input type='number' name='continuity_score[]' value='' id='continuity_score"+num+"' onblur='jiancha2("+num+")' class='input-text' style='margin-right: 0px;width: 100px;'>" +
        "<span style='margin-left: 12px;'>积分奖励</span>" +
        "</div>" +
		`<div class="btn " onclick="del(${num})" style='margin-left: 20px;'><img src="./images/iIcon/jian.png" style="width: 100%;margin-right:0"></div>
                                <div class="btn addBtn" onclick="add()" style='display:block'><img src="./images/iIcon/jia.png"  style="width: 100%;margin-right:0"></div>`+
        "</div>";
		$('.addBtn').css('display','none')
    $("#num").append(rew);
}

// 删除连续签到最后一条设置
function del(i) {
    if (num > 1) {
        $('#num_' + i).remove();
		var str=`<p class='hint' style='width: 40%;'>（连续签到以天为单位计算，且当天只计算一次；断签后则重新开始）</p>`
		$('#num1').next().find('.hint').remove()
		$('#num1').next().append(str)
		$('.addBtn').eq($('.addBtn').length-1).css('display','block')
		num--
    }
}

function jiancha1(obj){
    if(obj == 1){
        var obj1 = obj+1;
        var res = $("#continuity_num"+obj).val();
        var res1 = $("#continuity_num"+obj1).val();

        if(res != ''){
            if(res == 1){
                layer.msg("连续天数不能为1天");
                $("#continuity_num"+obj).val('');
                return;
            }
            if(res1 != ''){
                if(Number(res) >= Number(res1)){
                    layer.msg("次数没有依次递增");
                    $("#continuity_num"+obj).val('');
                    return;
                }
            }
        }
    }else{
        var obj2 = obj+1;
        var obj1 = obj-1;
        var res = $("#continuity_num"+obj).val();
        var res1 = $("#continuity_num"+obj1).val();
        var res2 = $("#continuity_num"+obj2).val();

        if(res != ''){
            if(Number(res) <= Number(res1)){
                layer.msg("次数没有依次递增");
                $("#continuity_num"+obj).val('');
                return;
            }
            if(res2 != ''){
                if(Number(res) >= Number(res2)){
                    layer.msg("次数没有依次递增");
                    $("#continuity_num"+obj).val('');
                    return;
                }
            }
        }
    }
}
function jiancha2(obj){
    if(obj == 1){
        var obj1 = obj+1;
        var res = $("#continuity_score"+obj).val();
        var res1 = $("#continuity_score"+obj1).val();
        if(res != ''){
            if(res1 != ''){
                if(Number(res) >= Number(res1)){
                    layer.msg("奖励积分没有依次递增");
                    $("#continuity_score"+obj).val('');
                    return;
                }
            }
        }
    }else{
        var obj1 = obj-1;
        var obj2 = obj+1;
        var res = $("#continuity_score"+obj).val();
        var res1 = $("#continuity_score"+obj1).val();
        var res2 = $("#continuity_score"+obj2).val();
        if(res != ''){
            if(Number(res) <= Number(res1)){
                layer.msg("奖励积分没有依次递增");
                $("#continuity_score"+obj).val('');
                return;
            }
            if(res2 != ''){
                if(Number(res) >= Number(res2)){
                    layer.msg("奖励积分没有依次递增");
                    $("#continuity_score"+obj).val('');
                    return;
                }
            }
        }
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
        dataType: "json",
        url: 'index.php?module=sign&action=Config',
        data: $('#form1').serialize(),// 你的formid
        async: true,
        success: function (data) {
            layer.msg(data.status, {time: 2000});
            if (data.suc) {
                location.href = "index.php?module=sign&action=Config";
            }
        }
    });
}

$(function(){
	//使用插件
    var ue = UE.getEditor('editor',{
		initialFrameWidth: null
	});
});
$(function(){
   var ue = UE.getEditor('editor1');
});

function init(){
	$('.circle1').css('left', '0px'),
	$('.circle1').css('background-color', '#fff'),
	$('.circle1').parent(".wrap").css('background-color', '#ccc');
	$(".wrap_box").hide();
	// status.val(0); 
	$('.circle').css('left', '0px'),
	$('.circle').css('background-color', '#fff'),
	$('.circle').parent(".wrap").css('background-color', '#ccc');
	$(".wrap_box").hide();

    $('.circle2').css('left', '0px'),
    $('.circle2').css('background-color', '#fff'),
    $('.circle2').parent(".wrap").css('background-color', '#ccc');
    $(".wrap_box").hide();

	status.val(0);
}

if(left != 0){
	init();
}

</script>
{/literal}
</body>
</html>