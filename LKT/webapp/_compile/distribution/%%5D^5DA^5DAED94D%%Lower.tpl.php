<?php /* Smarty version 2.6.31, created on 2020-01-02 16:19:28
         compiled from Lower.tpl */ ?>
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
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>
    <?php echo '
        <style type="text/css">
            .btn1 {
                padding: 2px 10px;
                height: 34px;
                line-height: 34px;
                display: flex;
                justify-content: center;
                align-items: center;
                float: left;
                color: #6a7076;
                background-color: #fff;
            }
            body {
                font-size: 16px;
            }

            .active1 {
                color: #fff;
                background-color: #2890FF;
            }
            
            .swivch a{height: 36px;line-height: 36px;padding: 0 10px;}
            
            .swivch a:hover {
                text-decoration: none;
                background-color: #2481E5!important;
                color: #fff;
            }

            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
            }
        </style>
    '; ?>


    <title>分销商</title>
</head>
<body>
<nav class="breadcrumb page_bgcolor">
    <span class="c-gray en"></span>
    <span style="color: #414658;">插件管理</span>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=distribution&amp;action=Index';">分销商管理 </a>
    <span class="c-gray en">&gt;</span>
    <span style="color: #414658;">查看下级</span>
</nav>
<div class="pd-20 page_absolute">

	<div class="page_h16"></div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
            <tr class="text-c">
                <th>分销商ID</th>
                <th>推荐人</th>
                <th>分销商</th>
                <th>手机号码</th>
                <th>分销等级</th>
                <th>预计佣金</th>
                <th>打款佣金</th>
                <th>可提现佣金</th>
                <th>提现佣金</th>
                <th>下级分销商</th>
                <th>时间</th>
                <!-- <th style="width: 250px;">操作</th> -->
            </tr>
            </thead>
            <tbody>
            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                <tr class="text-c" style="font-size: 5px;">
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->user_id; ?>
</td>
                    <td style="font-size: 5px;">
                        <?php if ($this->_tpl_vars['item']->hdimg != '' && $this->_tpl_vars['item']->user_name): ?>
                            <?php echo $this->_tpl_vars['item']->user_name; ?>

                        <?php else: ?>
                            总店
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->r_name; ?>
</td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->mobile; ?>
</td>
                    <td style="font-size: 5px;"><?php if ($this->_tpl_vars['item']->s_dengjiname): ?><?php echo $this->_tpl_vars['item']->s_dengjiname; ?>
<?php else: ?>默认等级<?php endif; ?></td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->yjyj; ?>
</td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->dkyj; ?>
</td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->commission; ?>
</td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->txyj; ?>
</td>
                    <td style="font-size: 5px;">总计：<?php echo $this->_tpl_vars['item']->cont; ?>
<br/>
                                                直推：<?php echo $this->_tpl_vars['item']->zhitui; ?>
<br/>
                    </td>
                    <td style="font-size: 5px;"><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
    <div class="page_h20"></div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
</script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script> 
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

</body>
</html>