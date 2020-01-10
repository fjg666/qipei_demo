<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport"
      content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta http-equiv="Cache-Control" content="no-siteapp"/>

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
<link href="style/css/style.css?v=1" rel="stylesheet" type="text/css"/>

<title>分销配置</title>
{literal}
<style type="text/css">
.swivch_bot a{
    width: 111px!important;
    height: 42px!important;
    padding: 0!important;
    border: none!important;
    border-right: 1px solid #ddd!important;
}
body {
    font-size: 16px;
}
.pd-20 {
    padding: 20px;
}

.form-horizontal .row {
    display: table;
    width: 100%;
}

.form .row {
    margin-top: 15px;
}

.form-horizontal .form-label {
    margin-top: 3px;
    cursor: text;
    text-align: right;
    padding-right: 10px;
}

@media (min-width: 768px) .col-sm-2 {
    width: 16.66666667%;
}

@media (min-width: 768px) .col-sm-1,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9 {
    float: left;
}

.col-xs-4 {
    width: 20%;
}

.c-red,
.c-red a,
a.c-red {
    color: red;
}

.form-horizontal .formControls {
    padding-right: 10px;
}

@media (min-width: 768px) .col-sm-8 {
    width: 66.66666667%;
}

@media (min-width: 768px) .col-sm-1,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9 {
    float: left;
}

.col-xs-8 {
    width: 66.66666667%;
}

.form-horizontal .row {
    display: table;
    width: 100%;
}

.form .row {
    margin-top: 15px;
}

.row {
    margin-right: -15px;
    margin-left: -15px;
}

.row {
    box-sizing: border-box;
}

.cl,
.clearfix {
    zoom: 1;
    margin-top: 15px;
}

.form-horizontal .row {
    display: table;
    /*width: 22%;*/
}

.col-lg-3 {
    float: right;
}

#btn_submit:hover {
    background-color: #2481e5 !important;
}

#btn_submit {
    background-color: #2890FF !important;
    height: 36px;
    line-height: 36px;
    padding: 0px 10px;
    color: #fff;
}

.btn1 {
    padding: 0px 10px;
    height: 40px;
    line-height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    float: left;
    color: #6a7076;
    background-color: #fff;
}

.active1 {
    color: #fff;
    background-color: #62b3ff;
}


#tableWrap::-webkit-scrollbar {
    display: none;
}

.table > tbody > tr > td {
    vertical-align: middle;
}

td a {
    text-align: center;
}
.formDivSD{
    margin-bottom: 0px !important;
}
.formTitleSD{
    font-weight:bold;
    color:#414658;
    border-bottom: 2px solid #E9ECEF;
}
.formListSD{
    color:#414658;
    min-height: 0px;
}
.formContentSD{
    padding: 30px 0px 30px 60px;
}
.formTextSD{
    margin-right: 8px;
}
.formTextSD span {
    height: 0px!important;
}
.inputC1:checked +label::before {
    top: 12px!important;
    left: 1px!important;
}
#tab-system{padding-left: 6%;}
.swivch_bot a,{height: 36px!important;line-height: 36px!important;}
form[name=form1] input[type=button]{width:112px!important;}
.swivch_bot a:hover{background-color: #2481e5!important;}
.ra1{width: 9%!important;float: left;}
</style>
{/literal}
</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>插件管理</span>
	<span class='nav-to' onclick="location.href='index.php?module=distribution&amp;action=Index';"><span class="arrows">&gt;</span>分销商管理</span>
	<span><span>&gt;</span>分销设置</span>
</nav>

<div class="iframe-content">
    <div class="navigation">
        <div>
    		<a href="index.php?module=distribution">分销商管理</a>
    	</div>
    	<p class='border'></p>
        <div>
    		<a href="index.php?module=distribution&action=Distribution_grade">分销等级</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Commission">佣金记录</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Cash">提现记录</a>
    	</div>
    	<p class='border'></p>
    	<div class='active'>
    		<a href="index.php?module=distribution&action=Distribution_config">分销设置</a>
    	</div>
    </div>
    <div class="page_h16"></div>
    <form name="form1" id="form1" class="iframe-table" method="post" enctype="multipart/form-data" style="padding: 0!important;">
        <table class="table table-bg table-hover" style="width: 100%;height:100px;border-radius: 30px;">
            <div class="formDivSD">
                <div class="formTitleSD page_title">基础设置</div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span>是否开启插件：</span></div>
                        <div class="form_new_r form_yes" style="width: 90%;">
                            <div class="ra1" style="width: 6%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="status" id="status_1" value="1" {if $status ==1}checked="checked"{/if}>
                                <label for="status_1">开启</label>
                            </div>
                            <div class="ra1" style="width: 6%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="status" id="status_0" value="0" {if $status ==0}checked="checked"{/if}>
                                <label for="status_0">关闭</label>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>分销内购：</span></div>
                        <div class="form_new_r form_yes" style="width: 90%;">
                            <div class="ra1" style="width: 6%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="c_neigou" id="neigou_2" value="2" {if $re.c_neigou ==2}checked="checked"{/if}>
                                <label for="neigou_2">开启</label>
                            </div>
                            <div class="ra1" style="width: 6%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="c_neigou" id="neigou_1" value="1" {if $re.c_neigou != 2}checked="checked"{/if}>
                                <label for="neigou_1">关闭</label>
                            </div>
                            <span class="addText" style="margin-left: 5px;">(开启分销内购，分销商自己购买商品，享受一级佣金，上级享受二级佣金，上上级享受三级佣金)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>等级晋升设置：</span></div>
                        <div class="form_new_r form_yes" style="width: 90%;">
                            <div class="ra1" style="width: 12%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="c_uplevel" id="uplevel_2" value="2" {if $re.c_uplevel ==2}checked="checked"{/if}>
                                <label for="uplevel_2" style="width: 100%!important;margin-left: 10px;">满足所有选项</label>
                            </div>
                            <div class="ra1" style="width: 12%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="c_uplevel" id="uplevel_1" value="1" {if $re.c_uplevel != 2}checked="checked"{/if}>
                                <label for="uplevel_1" style="width: 100%!important;margin-left: 10px;">满足任意一项</label>
                            </div>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>规则统计方式：</span></div>
                        <div class="form_new_r form_yes" style="width: 90%;">
                            <div class="ra1" style="width: 6%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="c_pay" id="pay_1" value="1" {if $re.c_pay ==1}checked="checked"{/if}>
                                <label for="pay_1">付款后</label>
                            </div>
                            <div class="ra1" style="width: 6%!important;">
                                <input style="display: none;" class="inputC1" type="radio" name="c_pay" id="pay_2" value="2" {if $re.c_pay !=1}checked="checked"{/if}>
                                <label for="pay_2">收货后</label>
                            </div>
                            <span class="addText" style="margin-left: 5px;">(消费条件统计的方式)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>分销层级：</span></div>
                        <div class="formInputSD">
                            <input type="number" min="1" name="c_cengji" value="{$re.c_cengji}"/>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>佣金计算方式：</span></div>
                        <div class="formInputSD">
                            <select name="c_yjjisuan" class="select">
                                <option value="0" {if empty($re.c_yjjisuan)}selected{/if}>商品现价（默认）</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="formSpaceSD"></div>
            </div>
            <div class="formDivSD">
                <div class="formTitleSD page_title">奖金设置</div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span>推荐店铺奖：</span></div>
                        <div class="formInputSD">
                            <input type="number" name="re_mch" value="{$re.re_mch}"/>
                            <span class="addText">(单位：%)</span>
                        </div>
                    </div>
                </div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span>个人进货奖：</span></div>
                        <div class="formInputSD">
                            <span class="addText">(条件与奖励应上下对应.多个层级请用英文,隔开)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>累计进货达：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="one_on" value="{$re.one[0]}"/>
                            <span class="addText">(单位：元)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>奖励金额：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="one_put" value="{$re.one[1]}"/>
                            <span class="addText">(单位：元)</span>
                        </div>
                    </div>
                </div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span>团队业绩奖：</span></div>
                        <div class="formInputSD">
                            <span class="addText">(条件与奖励应上下对应.多个层级请用英文,隔开 / 极差制)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>团队业绩达：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="team_on" value="{$re.team[0]}"/>
                            <span class="addText">(单位：元)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>提成比例：</span></div>
                        <div class="formInputSD">
                            <input type="text" name="team_put" value="{$re.team[1]}"/>
                            <span class="addText">(单位：%)</span>
                        </div>
                    </div>
                </div>
                <div class="formSpaceSD"></div>
            </div>
            <div class="formDivSD">
                <div class="formTitleSD page_title">提现设置</div>
                <div class="formContentSD">
                    <div class="formListSD">
                        <div class="formTextSD"><span>最低提现：</span></div>
                        <div class="formInputSD">
                            <input type="number" name="cash_min" value="{$re.cash_min}"/>
                            <span class="addText">(达到该额度才允许提现)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>最高提现金额：</span></div>
                        <div class="formInputSD">
                            <input type="number" name="cash_max" value="{$re.cash_max}"/>
                            <span class="addText">(为空或0表示无限制)</span>
                        </div>
                    </div>
                    <div class="formListSD">
                        <div class="formTextSD"><span>提现手续费：</span></div>
                        <div class="formInputSD">
                            <input type="number" name="cash_charge" value="{$re.cash_charge}"/>
                            <span class="addText">(提现时候扣除的手续费百分比)</span>
                        </div>
                    </div>
                </div>
                <div class="formSpaceSD"></div>
            </div>
            <div class="formDivSD">
                <div class="formTitleSD page_title">规则设置</div>
                <div class="formContentSD" style="margin-bottom: 10px;">
                    <div class="formListSD" style="align-items: end;margin-top: 10px;">
                        <div class="formControls col-xs-8 col-sm-10 codes" style="padding-left: 0px;padding-right: 8px;">
                            <script id="editor" type="text/plain" name="content" style="height:400px;width: 115%;">{$re.content}</script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="formDivSD">
                <div class="formTitleSD">规则设置</div>
                <div class="formContentSD">
                    <div class="form_li form_num formListSD" style="margin-bottom: 10px;">
                        <div class="formTextSD" style="align-items: end;margin-top: 10px;"><span>分销规则：</span></div>
                        <div class="formControls col-xs-8 col-sm-10 codes" style="padding-left: 0px;padding-right: 8px;">
                            <script id="editor" type="text/plain" name="content" style="width:100%;height:400px;">{$re.content}</script>
                        </div>
                    </div>
                </div>
            </div> -->
        </table>
        <div class="page_h10 page_bort" style="height: 68px!important;margin-bottom: 10px;">
            <input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" onclick="check()" style="margin-right: 60px!important;">
            <!-- <input type="reset" value="取消" class="fo_btn1"> -->
        </div>
    </form>
</div>
</div>
<div id="outerdiv"
     style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/footer.tpl" sitename="公共底部"} 
<!-- 新增编辑器引入文件 -->
<!-- <link rel="stylesheet" href="style/kindeditor/themes/default/default.css"/>
<script src="style/kindeditor/kindeditor-min.js"></script>
<script src="style/kindeditor/lang/zh_CN.js"></script> -->
{literal}
    <script type="text/javascript">
		var formheight=$(window).height()-56-42-16
		$('#form1').css('height',formheight+'px')
		
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }

        //------活动类型全选
        function active_select() {
            var $sel = $(".active_select");
            var b = true;
            for (var i = 0; i < $sel.length; i++) {
                if ($sel[i].checked == false) {
                    b = false;
                    break;
                }
            }
            $(".active_all").prop("checked", b);
        }

        function active_all(obj) {
            $(".active_select").prop("checked", $(obj).prop("checked"));
        }
        //------活动类型全选

        $(function() {
            //活动类型检测
            active_select();
            $("#imgurls").change(function() {
                var files = this.files;
                if(files && files.length > 5) {
                    layer.msg("超过5张");
                    this.value = "" //删除选择
                    // $(this).focus(); //打开选择窗口
                }
            });
            //富文本编辑器
            var ue = UE.getEditor('editor');
            //分销显示
            $("#xd_fx").hide();
            $("#xd_fx").find(".select").val(0);
        })

        function check() {
            var regu = /^\d+$/;
            var cenji = $("input[name=c_cengji]").val();
            if(!regu.test(cenji) || parseInt(cenji) < 1){
                layer.msg('层级数只能大于等于1');
                return;
            }

            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: 'index.php?module=distribution&action=Distribution_config',
                data: $('#form1').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    console.log(data)                  
                    if (data.suc) {
                        layer.msg(data.status, {time: 1000},function (){
                            location.href = "index.php?module=distribution&action=Distribution_config";
                        });           
                    }
                }
            });
        }

       
    </script>

{/literal}
</body>
</html>