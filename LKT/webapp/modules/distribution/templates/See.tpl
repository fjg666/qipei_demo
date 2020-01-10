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
   
    <title>分销商详情</title>
    {literal}
        <style type="text/css">
            table th {
                border: none;
                font-weight: normal !important;
                font-size: 14px;
            }
            body {
                font-size: 16px;
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

            label {
                position: relative;
                top: 0;
                font-size: 16px;
                color: #B7BABB;
                line-height: 16px;
                cursor: pointer;
            }

            input[type="radio"] {
                display: none;
            }

            input[type='radio'] + label:before {
                margin-top: -2px;
                content: '';
                display: inline-block;
                width: 15px;
                height: 15px;
                margin-right: 6px;
                border-radius: 100%;
                vertical-align: middle;
                border: 1px solid #2890ff;
                background: #FFFFFF;
            }

          

            .sex_margin {
                margin-right: 15px;
            }
            .form .row{margin-top: 0;}
        </style>
    {/literal}
</head>
<body>
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    <span style="color: #414658;">插件管理</span>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=Distribution&action=Index';">分销商管理 </a>
    <span class="c-gray en">&gt;</span>
    <span style="color: #414658;">分销商详情</span>
</nav>
<div class="pd-20 page_absolute">
    <div class="Huiform">
        <div class="page_title">
            分销商详情
        </div>
        <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <table class="table table-bg">
                <tbody>
                <input type="hidden" name="id" value="{$user[0]->id}">
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
                        {$user[0]->user_name}
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 推荐人ID：</th>
                    <td>
                        {$user[0]->pid}
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 推荐人名称：</th>
                    <td>
                        {$user[0]->p_name}
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 手机号码：</th>
                    <td>
                       {$user[0]->mobile} 
                    </td>
                </tr>
                <tr>
                    <th class="text-r">分销等级：</th>
                    <td>
                        {$user[0]->levelname}
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
                <input type="button" value="返 回" style="margin-right: 83px !important;" class="btn input ta_btn4" onclick="window.history.go(-1);" id='_btn_1'>
            </div>
        </div>

    </div>
</div>


</body>
</html>
