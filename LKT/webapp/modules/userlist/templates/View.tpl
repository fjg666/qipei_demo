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
   
    <title>用户信息详情</title>
    {literal}
        <style type="text/css">
            table th {
                border: none;
                font-weight: normal !important;
                color: #888f9e;
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
            .table tr th{
                padding: 10px 20px;
            }
        </style>
    {/literal}
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="Huiform" style="padding-bottom: 39px!important;">
        <div class="page_title">
            会员详情
        </div>
        <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
            <table class="table table-bg">
                <tbody>
                <input type="hidden" name="id" value="{$user[0]->id}">
                <tr>
                    <th class="text-r">会员头像：</th>
                    <td>
                        <img src="{$user[0]->headimgurl}"
                             style="width: 60px;height:60px;border-radius: 30px;border: 1px solid darkgray;"/>
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员ID：</th>
                    <td>
                        {$user[0]->user_id}
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员名称：</th>
                    <td>
                        {$user[0]->user_name}
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员账号：</th>
                    <td>
                        {$user[0]->zhanghao}
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员等级：</th>
                    <td>
                        {$user[0]->grade}
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 专属折扣：</th>
                    <td>
                        {$user[0]->rate}
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 到期时间：</th>
                    <td>
                        {if $user[0]->grade == '普通会员'}
                            无
                        {else}
                            {$user[0]->grade_end}
                        {/if}
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 手机号码：</th>
                    <td>
                       {$user[0]->mobile} 
                    </td>
                </tr>
                <tr>
                    <th class="text-r">登录密码：</th>
                    <td>
                        {$user[0]->mima_1}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">支付密码：</th>
                    <td>
                        ******
                    </td>
                </tr>
                <tr>
                    <th class="text-r">账户余额：</th>
                    <td>
                       ￥{$user[0]->money}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">积分余额：</th>
                    <td>
                        {$user[0]->score}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">会员生日：</th>
                    <td>
                        {$user[0]->birthday}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">账号来源：</th>
                    <td>
                        {if $user[0]->source == 1}
                        小程序
                        {elseif $user[0]->source == 2}
                        APP
                        {/if}
                    </td>
                </tr>

                <tr>
                    <th class="text-r">有效订单数：</th>
                    <td>
                      {$user[0]->z_num}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">交易金额：</th>
                    <td>
                      ￥{$user[0]->z_price}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">分享次数：</th>
                    <td>
                      {$user[0]->share_num}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">访问次数：</th>
                    <td>
                      {$user[0]->login_num}
                    </td>
                </tr>
                <tr>
                    <th class="text-r">最后登录：</th>
                    <td>
                        <span>{$user[0]->last_time}</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r">注册时间：</th>
                    <td>
                        <span>{$user[0]->Register_data}</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r">推送CID：</th>
                    <td>
                        <span>{$user[0]->clientid}</span>
                    </td>
                </tr>
                <!-- <tr>
                    <th class="text_r" style="text-align: right;">冻结：</th>
                    <td>
                        {if $user[0]->is_lock == '1'}
                            <span class="ddd_l">已冻结</span>
                        {else}
                            <span class="ddd_l">未冻结</span>
                        {/if}
                    </td>
                </tr> -->
               
                </tbody>
            </table>
          
            <div style="height: 10px"></div>
        </form>
        <div class="cl row row_class" style="border-top: 1px solid #ddd;height: 70px;">
            <div class="col-8 col-offset-4">
                <input type="button" value="取 消" style="margin-right: 16px !important;" class="btn input ta_btn4" onclick="window.history.go(-1);" id='_btn_1'>
            </div>
        </div>

    </div>
</div>


</body>
</html>
