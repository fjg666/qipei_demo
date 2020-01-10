<?php /* Smarty version 2.6.31, created on 2019-12-30 11:13:53
         compiled from Modify.tpl */ ?>
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

  
    <title>用户信息修改</title>
    <?php echo '
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
                  

            .sex_margin {
                margin-right: 15px;
            }
            .form .row{margin-top: 0;}
            input[type=password] {
                background-color: #fff!important;
                color: #414658!important;
                border: 1px solid #d5dbe8!important;
                box-sizing: border-box;
                height: 30px!important;
                width: 88px;
                border-radius: 2px;
            } 
            .table tr th{
                padding: 10px 10px;
            }
            input[type=\'text\'] {
                width: 88px;
                height: 30px!important;
            }
        </style>
    '; ?>

</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute" >
    <div class="Huiform" style="padding-bottom: 39px!important;">
        <div class="page_title" >
            编辑会员信息
        </div>
        <form name="form1" id="form1" class="form form-horizontal"  method="post" enctype="multipart/form-data">
            <table class="table table-bg" style="margin:10px auto;margin-bottom: -10px;">
                <tbody>
                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['user'][0]->id; ?>
">
                <tr>
                    <th class="text-r">会员头像：</th>
                    <td>
                        <img src="<?php echo $this->_tpl_vars['user'][0]->headimgurl; ?>
"
                             style="width: 60px;height:60px;border-radius: 30px;border: 1px solid darkgray;"/>
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员ID：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->user_id; ?>
</span>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员名称：</th>
                    <td>
                         <input type="text" name="user_name" value="<?php echo $this->_tpl_vars['user'][0]->user_name; ?>
"  style="width:175px;border-radius: 3px;">
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员账号：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->zhanghao; ?>
</span>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 会员等级：</th>
                    <td>
                         <select name="grade" class="select" style="background-color: #ffffff;width:175px;;height: 30px;border-radius: 3px;">
                           <?php echo $this->_tpl_vars['user'][0]->grade1; ?>

                        </select>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 专属折扣：</th>
                    <td>
                        <span>
                            <?php echo $this->_tpl_vars['user'][0]->rate; ?>

                        </span>
                    </td>

                </tr>
                <tr>
                    <th class="text-r"> 到期时间：</th>
                    <td id="my_end"> 
                        <?php if ($this->_tpl_vars['user'][0]->grade === '0'): ?>
                            暂无
                        <?php else: ?>
                              <input type="text" value="<?php echo $this->_tpl_vars['user'][0]->grade_end; ?>
" id="grade_end" name="grade_end" style="width:175px;border-radius: 3px;"  autocomplete="off">
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th class="text-r"> 手机号码：</th>
                    <td>
                         <input type="text" value="<?php echo $this->_tpl_vars['user'][0]->mobile; ?>
" name="mobile" style="width:175px;border-radius: 3px;">
                    </td>
                </tr>
                <tr>
                    <th class="text-r">登录密码：</th>
                    <td>
                        <input type="text" name="mima" value="<?php echo $this->_tpl_vars['user'][0]->mima_1; ?>
" style="width:175px;border-radius: 3px;" >
                    </td>
                </tr>
                <tr>
                    <th class="text-r">支付密码：</th>
                    <td>
                        <input type="password" name="password" value="<?php echo $this->_tpl_vars['user'][0]->password; ?>
" style="width:175px;border-radius: 3px;" >
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 账户余额：</th>
                    <td>
                        <input type="text" name="money" value="<?php echo $this->_tpl_vars['user'][0]->money; ?>
" style="width:175px;border-radius: 3px;">
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 积分余额：</th>
                    <td>
                       <input type="text" name="score" value="<?php echo $this->_tpl_vars['user'][0]->score; ?>
" style="width:175px;border-radius: 3px;">
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r">会员生日：</th>
                    <td>
                        <input type="text" name="birthday" id="birthday" value="<?php echo $this->_tpl_vars['user'][0]->birthday; ?>
" style="width: 175px;"  autocomplete="off">
                    </td>
                </tr>
                <tr>
                    <th width="100" class="text-r"> 账号来源：</th>
                    <td>
                        <span>
                            <?php if ($this->_tpl_vars['user'][0]->source == 1): ?>
                            小程序
                            <?php elseif ($this->_tpl_vars['user'][0]->source == 2): ?>
                            APP
                            <?php endif; ?>
                        </span>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 有效订单数：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->z_num; ?>
</span>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 交易金额：</th>
                    <td>
                        <span>￥<?php echo $this->_tpl_vars['user'][0]->z_price; ?>
</span>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 分享次数：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->share_num; ?>
</span>
                    </td>

                </tr>
                <tr>
                    <th width="100" class="text-r"> 访问次数：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->login_num; ?>
</span>
                    </td>

                </tr>
                <tr>
                    <th class="text-r">最后登录：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->last_time; ?>
</span>
                    </td>
                </tr>
                <tr>
                    <th class="text-r">注册时间：</th>
                    <td>
                        <span><?php echo $this->_tpl_vars['user'][0]->Register_data; ?>
</span>
                    </td>
                </tr>


<!-- 
                <tr>
                    <th class="text_r" style="text-align: right;">冻结：</th>
                    <td>
                     

                        <div class="radio-box">
                            <input type="radio" id="lock_y" name="is_lock" value="1" <?php if ($this->_tpl_vars['user'][0]->is_lock == '1'): ?>checked="checked"<?php endif; ?>>
                            <label for="lock_y" style="cursor: pointer;">冻结</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="lock_n" name="is_lock" value="0" <?php if ($this->_tpl_vars['user'][0]->is_lock == '0'): ?>checked="checked"<?php endif; ?>>
                            <label for="lock_n" style="cursor: pointer;">不冻结</label>
                        </div>
                    </td>
                </tr> -->
                
                
                </tbody>
            </table>

           

            <div style="height: 10px"></div>
        </form>
        <div class="cl row row_class" style="border-top: 1px solid #ddd;height: 70px;">
            <div class="col-8 col-offset-4">
                
              
                <input type="button" name="Submit" value="保 存" style="margin-right: 83px !important;" class="btn radius submit1 ta_btn3" onclick='check()'>
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
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

    
<?php echo '
<script type="text/javascript">
'; ?>
    
     var end = "<?php echo $this->_tpl_vars['end']; ?>
"
<?php echo '
  //日历插件
 laydate.render({
  elem:\'#grade_end\',
  trigger: \'click\',
  type:\'datetime\'
 });
 laydate.render({
    elem:\'#birthday\',
    trigger:\'click\',
    type:\'datetime\'
 })
 $("select[name=\'grade\']").on(\'change\',function(){
    var logo  = $(this).val();
    if(logo === \'0\'){//选择为普通会员
        $("#my_end").html(\'暂无\')
    }else{
        $("#my_end").html(\'<input type="text" value="\'+end+\'" id="grade_end" name="grade_end" placeholder="请输入到期时间" style="width: 250px;"  autocomplete="off">\')
        //页面重新加载，重新加载日历插件
        laydate.render({
          elem:\'#grade_end\',
          trigger: \'click\',
          type:\'datetime\'
        });
    }
 });

function check(){
    let grade = $("select[name=\'grade\']").val()
    let grade_end = $("input[name=\'grade_end\']").val()
    if(grade != 0){
        if(grade_end == \'0100-01-01 00:00:00\'){
            layer.msg(\'请设置会员的到期时间\',{time:2000})
            return false
        }
    }
    $.ajax({
        cache:true,
        type:"POST",
        datatype:\'json\',
        data:$(\'#form1\').serialize(),
        url:\'index.php?module=userlist&action=Modify\',
        async:true,
        success:function(data){
              data = JSON.parse(data)
            layer.msg(data.status,{time:2000})

            if(data.suc){
                setTimeout(function(){
                    location.href=\'index.php?module=userlist\';
                },1000);
            }
        }
    });
}
    </script>
'; ?>

 
</body>
</html>