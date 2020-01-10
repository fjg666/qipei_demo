<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<link href="style/css/boot.css" rel="stylesheet" type="text/css"/>
<link href="style/css/style2.css" rel="stylesheet" type="text/css"/>
<link href="style/css/style.css" rel="stylesheet" type="text/css" />

{literal}
<style type="text/css">
.pd-20 {
    padding: 20px;
}

.form-horizontal .row {
    display: table;
    width: 100%;
}
body {
    font-size: 16px;
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
    width: 22%;
    margin-left: 40%;
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
    padding: 2px 10px;
    height: 44px;
    line-height: 44px;
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

.breadcrumb a{text-decoration: none;color: #333;font-size: 13px;}
.breadcrumb span{padding: 0 5px;}
.form-control{border: 1px solid #ddd;}
select[name=dengji]{border: 1px solid #ddd;}

.page_footer input{border: 1px solid #2890FF;}
.swivch_bot a{height: 36px!important;line-height: 36px!important;}
.swivch_bot a:hover{background-color: #2481e5!important;}

</style>
{/literal}
<title>分销关系修改</title>

</head>
<body>
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    <span style="color: #414658;">插件管理</span>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=distribution&amp;action=Index';">分销商管理 </a>
    <span class="c-gray en">&gt;</span>
    <span style="color: #414658;">分销关系修改</span>
</nav>
<div class="main pd-20 page_absolute" >

    <div class="swivch page_bgcolor swivch_bot">
        <a href="index.php?module=distribution" class="btn1">分销商管理</a>
        <a href="index.php?module=distribution&action=Distribution_grade" class="btn1">分销等级</a>
        <a href="index.php?module=distribution&action=Commission" class="btn1">佣金日志</a>
        <a href="index.php?module=distribution&action=Cash" class="btn1">提现记录</a>
        <a href="index.php?module=distribution&action=Distribution_config" style="border-right: 1px solid #ddd !important;" class="btn1">分销设置</a>
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
	<div class="page_h16"></div>
    <form id="dataform" method="post" class="form-horizontal form ">
        <input type="hidden" name="module" value="distribution"/>
        <input type="hidden" name="action" value="Set"/>
        <div class=" panel-default taber_border">
            <div class="panel-body ">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>
                        选择会员</label>
                    <div class="col-sm-4">
                        <input type="hidden" id="mid" name="mid" class="form-control" value="">

                        <div class="input-group">
                            <input type="text" name="uid" maxlength="30" id="member" class="form-control" readonly="">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="selectMember('member')"
                                        data-original-title="" title="">选择会员
                                </button>
                                <button class="btn btn-danger" type="button"
                                        onclick="$('#mid').val('');$('#member').val('');$('#memberavatar').hide()"
                                        data-original-title="" title="">清除选择
                                </button>
                            </div>
                        </div>
                        <span id="memberavatar" class="help-block" style="display:none"><img
                                    style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src=""></span>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"> 选择分销商等级</label>
                    <div class="col-sm-4">

                        <div class="formControls col-xs-8 col-sm-6" style="padding-left: 0px">
                            <select name="dengji" class="select"
                                    style="width: 210px;height: 31px;vertical-align: middle;">
                                <option value="0"> 请选择分销商等级</option>
                                {foreach from=$grade item=item name=f1}
                                    <option value="{$item->id}"> {$item->name}</option>
                                {/foreach}
                            </select><br/>
                        </div>

                        <span id="memberavatar" class="help-block" style="display:none"><img
                                    style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src=""></span>
                    </div>
                </div> -->


                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span
                                style="color:red">*</span>选择上级分销商</label>
                    <div class="col-sm-4">
                        <input type="hidden" id="agentid" name="agentid" class="form-control" value="">

                        <div class="input-group">
                            <input type="text" name="pid" maxlength="30" id="agent" class="form-control" readonly="">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="selectMember('agent')"
                                        data-original-title="" title="">选择上级分销商
                                </button>
                                <button class="btn btn-danger" type="button"
                                        onclick="$('#agentid').val('');$('#agent').val('');$('#agentavatar').hide()"
                                        data-original-title="" title="">清除选择
                                </button>
                            </div>
                        </div>
                        <span id="agentavatar" class="help-block" style="display:none"><img
                                    style="width:100px;height:100px;border:1px solid #ccc;padding:1px"></span>
                        <span class="help-block">修改后， 只有关系链改变, 只能是没有购买过商品的会员 ,请谨慎选择</span>
                        <span class="help-block" style="color:red">注：1.不修改等级则不需要选等级，若用户不是分销商则为新添加</span>
                        <span class="help-block" style="color:red">注：2.且会员和分销商不能为同一人</span>
                        <span class="help-block" style="color:red">注：3.总店的上级不能修改,总级为公司顶级</span>
                    </div>
                </div>

                <div class="form-group page_footer">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label "></label>
                    <div class="col-sm-9 page_out" >
                        <input id="btn_submit" class="ta_btn4" type="button" name="Submit" value="保存" class="btn" onclick="check()">
                        <input type="hidden" name="token" value="41f48483" class="ta_btn4">
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
<!--
<div class="row">

    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin: 0!important;padding: 0!important;">

        <div class="ibox float-e-margins">

        </div>

    </div>

</div>-->

<div id="modal-module-menus-notice" class="modal fade in" tabindex="-1" aria-hidden="false"
     style="display: none; padding-right: 7px;">
    <div class="modal-dialog" style="width: 920px;">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 id="modalTitle">选择会员</h3></div>
            <div class="modal-body">
                <div class="row">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" value="" id="search-kwd-notice"
                               placeholder="请输入昵称/姓名/手机号">
                        <span class="input-group-btn"><button type="button" class="btn btn-default"
                                                              onclick="search_members();" data-original-title=""
                                                              title="">搜索</button></span>
                    </div>
                </div>
                <div id="module-menus-notice" style="padding-top:5px;">
                    <div style="max-height:500px;overflow:auto;" id="tableWrap">
                        <table class="table table-hover">
                            <tbody id="tbody_box">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="close_1" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
            </div>
        </div>

    </div>
</div>
</script>

<script src="style/js/jquery.min.js"></script>
<script src="style/js/bootstrap.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
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
                url: 'index.php?module=distribution&action=Set',
                data: $('#dataform').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    console.log(data)
                    layer.msg(data.msg, {time: 1000},function (){
                     if (data.status) {
                        location.href = "index.php?module=distribution&action=Set";
                     }
                    });
                }
            });
        }

        var str = '';
        var ad = '';

        function selectMember(e) {
            console.log(e);
            ad = e;
            if (str.length < 1) {
                $.ajax({
                    type: "GET",
                    url: location.href,
                    data: "type=e&m=find",
                    success: function (msg) {
                        var msg = JSON.parse(msg);
                        //console.log(msg);
                        for (var i = 0; i < msg.length; i++) {
                            str += '<tr><td ><img src="' + msg[i].headimgurl + '" style="width:30px;height:30px;padding1px;border:1px solid #ccc"> ' + msg[i].user_name + '</td><td></td><td></td><td style="width:80px;"> <a href="javascript:;" onclick="select_member(\'' + msg[i].user_id + '\')" name="' +e+msg[i].user_id+'" data-level="'+ msg[i].level + '">选择</a></td></tr>';
                        }
                        $("#tbody_box").html(str);
                        $("#modal-module-menus-notice").show();
                    }
                });
            } else {
                $("#tbody_box").html(str);
                $("#modal-module-menus-notice").show();
            }
            console.log(ad);
        }

        function select_member(id) {
            var obj = '#' + ad;
            $(obj).val(id);
            $("#modal-module-menus-notice").hide();
            var level = $("a[name="+ad+id+"]").attr('data-level');       
            if(ad == 'member' && level != null){
               $("option[value="+level+"]").prop('selected',true);
            }
        }

        function search_members() {
            var keyword = $("#search-kwd-notice").val();
            var strstr = '';
            if (keyword.length > 0) {
                $.ajax({
                    type: "GET",
                    url: location.href,
                    data: "m=find&keyword=" + keyword,
                    success: function (msg) {
                        var msg = JSON.parse(msg);
                        console.log(msg);
                        for (var i = 0; i < msg.length; i++) {
                            strstr += '<tr><td ><img src="' + msg[i].headimgurl + '" style="width:30px;height:30px;padding1px;border:1px solid #ccc"> ' + msg[i].user_name + '</td><td></td><td></td><td style="width:80px;"> <a href="javascript:;" onclick="select_member(\'' + msg[i].user_id + '\')">选择</a></td></tr>';
                        }
                        $("#tbody_box").html(strstr);
                    }
                });
            } else {
                $.ajax({
                    type: "GET",
                    url: location.href,
                    data: "m=find",
                    success: function (msg) {
                        var msg = JSON.parse(msg);
                        console.log(msg);
                        for (var i = 0; i < msg.length; i++) {
                            strstr += '<tr><td ><img src="' + msg[i].headimgurl + '" style="width:30px;height:30px;padding1px;border:1px solid #ccc"> ' + msg[i].user_name + '</td><td></td><td></td><td style="width:80px;"> <a href="javascript:;" onclick="select_member(\'' + msg[i].user_id + '\')">选择</a></td></tr>';
                        }
                        $("#tbody_box").html(strstr);
                    }
                });
            }
        }

        $("#close_1").click(function () {

            $("#modal-module-menus-notice").hide();

        });
        $(".close").click(function () {

            $("#modal-module-menus-notice").hide();

        });

        //选择链接

        $(".select_link").click(function () {

            $(this).hide();

        });
    </script>
{/literal}

</body>

</html>