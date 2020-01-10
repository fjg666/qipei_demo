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

  
    <title>编辑分销商信息</title>
    {literal}
        <style type="text/css">
            body {
                font-size: 16px;
            }
            table th {
                border: none;
                font-weight: normal !important;
                font-size: 14px;
            }

            .table th {
                padding: 15px 20px;
            }

            table {
                background-color: #fff;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
            }

            .ulTitle {
                height: 50px;
                line-height: 50px;
                text-align: left;
                padding-left: 20px;
                font-size: 16px;
                color: #414658;
                font-weight: 600;
                font-family: "微软雅黑";
                margin-bottom: 0px;
                border-bottom: 2px solid #eee;
                background: #fff;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }

            .table td {
                border: none;
            }

            .row {
                background-color: #fff;
                margin-top: 0;
            }

            .input {
                background-color: #fff;
                color: #2890ff;
                border: 1px solid #2890ff !important;
                box-sizing: border-box;
            }

            ._fff,
            .ddd_l {
                border: none;
            }

            .activ_l {
                border: 1px solid #eee;
                line-height: 28px;
                padding-left: 5px;
            }
            .input{
                width: 250px;
                padding-left: 10px;
            }     

            .sex_margin {
                margin-right: 15px;
            }
            .form .row{margin-top: 0;}
            .select{
                width: 250px;
                height: 36px!important;
                border-radius: 2px;
                padding-left: 10px;
            }

            .maskNewContent{
                width: 460px;
                height: 222px!important;
                margin: 0 auto;
                position: relative;
                font-size: 18px;
                top: 200px;
                background: #fff;
                border-radius: 2px;
                padding-top: 10px;
                box-sizing: border-box;
            }
            .maskContent{
                height: 50px;
                position: relative;
                top: 50px;
                padding: 0 80px;
                font-size: 16px;
                text-align: center;
            }
            .maskbtn{
                text-align: center;
                margin-top: 67px;
            }
            .maskTitle{
                height: 50px;
                padding-left: 30px;
                line-height: 50px;
                text-align: left;
                color: #414658;
                font-size: 16px;
                border-bottom: 2px solid #e9ecef;
                display: none;
            }
            .closeMask{
                width: 112px;
                height: 36px;
                border: 1px solid #eee;
                border-radius: 2px;
                background: #008DEF;
                color: #fff;
                font-size: 16px;
                line-height: 40px;
                cursor: pointer;
            }
            .closeMask:nth-child(even){
                background: #fff;
                color:#008DEF;
                border: 1px solid #008DEF;
            }
        </style>
    {/literal}
</head>
<body>
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    <span style="color: #414658;">插件管理</span>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=distribution&amp;action=Index';">分销商管理 </a>
    <span class="c-gray en">&gt;</span>
    <span style="color: #414658;">编辑分销商信息</span>
</nav>
<div class="pd-20 page_absolute">
    <div class="Huiform">
        <div class="page_title">
            编辑分销商信息
        </div>
        <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <table class="table table-bg" >
                <tbody>
                <input type="hidden" name="id" value="{$user[0]->uid}">
                <input type="hidden" id="old_pid" name="pid" value="{$user[0]->pid}">
                <input type="hidden" id="old_pname" name="p_name" value="{$user[0]->p_name}">
                <tr>
                    <th class="text-r">头像：</th>
                    <td>
                        <img src="{$user[0]->headimgurl}"
                             style="width: 60px;height:60px;border-radius: 30px;border: 1px solid darkgray;"/>
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 分销商ID：</th>
                    <td>
                        {$user[0]->user_id}
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 分销商名称：</th>
                    <td>
                        <input type="text" name="user_name" value="{$user[0]->user_name}" class="input">
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 推荐人ID：</th>
                    <td>
                        <input type="text" name="pid" id="pid" value="{$user[0]->pid}" class="input" onblur="getpname()">
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 推荐人名称：</th>
                    <td id="p_name">
                        {$user[0]->p_name}
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 手机号码：</th>
                    <td>
                       <input type="text" name="mobile" value="{$user[0]->mobile}" class="input">
                    </td>
                </tr>
                <tr>
                    <th class="text-r">分销等级：</th>
                    <td>
                        <select name="level" class="select">
                            {$level}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="text-r">预计佣金：</th>
                    <td>
                        {$user[0]->yjyj}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">累计佣金：</th>
                    <td>
                        {$user[0]->ljyj}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">可提现佣金：</th>
                    <td>
                        {$user[0]->commission}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">累计消费：</th>
                    <td>
                        {$user[0]->onlyamount}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">推广业绩：</th>
                    <td>
                        {$user[0]->allamount}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">开通时间：</th>
                    <td>
                        <span>{$user[0]->add_date}</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r">注册时间：</th>
                    <td>
                        <span>{$user[0]->Register_data}</span>
                    </td>
                </tr>
                </tbody>
            </table>

           

            <div style="height: 10px"></div>
        </form>
        <div class="cl row row_class" style="border-top: 1px solid #ddd;height: 70px;">
            <div class="col-8 col-offset-4">
                
              
                <input type="button" name="Submit" value="保 存" style="margin-right: 83px !important;" class="btn radius submit1 ta_btn3" onclick='confirm("变更推荐人，将会直接影响推荐人的佣金收益，严重时会造成系统数据错误、无法使用。请在专业技术人员指导下操作！")'>
                <input type="button" value="取 消" style="margin-right: 16px !important;" class="btn input ta_btn4"
                       onclick="window.history.go(-1);"
                       id='_btn_1'>
            </div>
        </div>
        

    </div>
</div>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/h-ui/js/H-ui.js"></script>
{literal}
    <script type="text/javascript">



        function confirm(content) {

            var pid = $("#pid").val();
            var old_pid = $("#old_pid").val();
            if (pid != old_pid) {

                $("body").append(`
                    <div class="maskNew">
                        <div class="maskNewContent">
                            <div class="maskTitle">提示</div>
                            <div class="maskContent" style="top: 35px;">
                                ${content}
                            </div>
                            <div class="maskbtn" style="margin-top: 82px;">
                                <button class="closeMask" style="margin-right:20px" onclick="check()">确认</button>
                                <button class="closeMask" onclick=closeMask1()>取消</button>
                            </div>
                        </div>
                    </div>  
                `)
            }else{
                check();
            }
        }
        function closeMask1() {
            $(".maskNew").remove();
        }
        function check(){
            $(".maskNew").remove();
            $.ajax({
                cache:true,
                type:"POST",
                datatype:'json',
                data:$('#form1').serialize(),
                async:true,
                success:function(data){
                    data = JSON.parse(data)
                    layer.msg(data.status,{time:2000})
                    if(data.code){
                        setTimeout(function(){
                            location.href='./index.php?module=distribution';
                        },1000);
                    }
                }
            });
        }
        function getpname(){
            $.ajax({
                type: "GET",
                url: location.href,
                data: "m=find&pid=" + $("#pid").val(),
                success: function (msg) {
                    var msg = JSON.parse(msg);
                    if (msg.p_name) {
                        $("#p_name").text(msg.p_name);
                    }else{
                        $("#pid").val($("#old_pid").val());
                        $("#p_name").text($("#old_pname").val());
                        layer.msg('推荐人不存在！',{time:2000})
                    }
                }
            });
        }
    </script>
{/literal}
 
</body>
</html>
