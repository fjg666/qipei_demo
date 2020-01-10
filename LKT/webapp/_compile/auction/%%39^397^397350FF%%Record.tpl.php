<?php /* Smarty version 2.6.31, created on 2019-12-30 15:10:46
         compiled from Record.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php echo '
        <style type="text/css">
            
            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
            }
        </style>
    '; ?>

</head>
<body>
<nav class="breadcrumb page_bgcolor">
      <span class="c-gray en"></span>
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;cursor: pointer;' onclick="window.history.go(-1);">竞拍</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>竞拍详情</span>
</nav>
<div class="pd-20 page_absolute">

    <div class="switch_a" style="height: 92px;background-color: rgba(88, 146, 240, 0.05);line-height: 90px;border:1px dashed #F00;display: flex;">
        <i class="Hui-iconfont Hui-iconfont-shenhe-weitongguo" style="font-size: 50px;color:#FF0000;margin-left: 30px;"></i>&nbsp;&nbsp;
        <span style="font-size: 20px;">
            <?php if ($this->_tpl_vars['status'] == 0): ?>
                未开始
            <?php elseif ($this->_tpl_vars['status'] == 1): ?>
                竞拍中    
            <?php elseif ($this->_tpl_vars['status'] == 2 && $this->_tpl_vars['is_buy'] === '0'): ?>
                竞拍成功，得主未付款
            <?php elseif ($this->_tpl_vars['status'] == 2 && $this->_tpl_vars['is_buy'] == 1): ?>
                竞拍成功，得主已付款
            <?php elseif ($this->_tpl_vars['status'] == 3): ?>
                <?php if ($this->_tpl_vars['pepole'] < $this->_tpl_vars['low_pepole']): ?>
                    已流拍，竞拍人数未达到开拍人数
                <?php else: ?>
                    <?php if ($this->_tpl_vars['count'] <= 0): ?>
                        已流拍，活动时间未出价
                    <?php else: ?>
                        已流拍，未在规定时间内付款
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </span>
   </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1"  method="get">
            <input type="hidden" name="module" value="auction"/>
            <input type="hidden" name="action" value="Record">
            <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
">
            <input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize" />
            <input type="text" name="user_name" size='8' value="<?php echo $this->_tpl_vars['user_name']; ?>
" id="" placeholder="请输入会员名称" style="width:200px" class="input-text">
            <input name="" id="" class="btn btn-success" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th>
                        <input type="checkbox" class="inputC input_agreement_protocol" id="<?php echo $this->_tpl_vars['item']->id; ?>
" name="id[]" value="">
                        <label for="i1"></label>
                    </th>
                    <th style="width:15%;">序号</th>
                    <th>竞拍会员</th>
                    <th>会员头像</th>
                    <th>出价金额</th>
                    <th>状态</th>
                    <th>出价时间</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
?>
                    <tr class="text-c tab_td">
                        <td>
                            <input type="checkbox" class="inputC input_agreement_protocol" id="<?php echo $this->_tpl_vars['item']->id; ?>
" name="id[]" value="<?php echo $this->_tpl_vars['item']->id; ?>
">
                            <label for="<?php echo $this->_tpl_vars['item']->id; ?>
"></label>
                        </td>
                        <td style="width: 15%"><?php echo $this->_tpl_vars['k']+1+$this->_tpl_vars['item']->offset; ?>
</td>
                        <td><?php echo $this->_tpl_vars['item']->user_name; ?>
</td>
                        <td><img src="<?php echo $this->_tpl_vars['item']->headimgurl; ?>
" alt="" width="60px" height="60px"></td>
                        <td>￥<?php echo $this->_tpl_vars['item']->user_price; ?>
</td>
                        <td>
                            <?php if ($this->_tpl_vars['item']->r_id == $this->_tpl_vars['first_id']): ?>
                                领先
                            <?php else: ?>
                                出局
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $this->_tpl_vars['item']->add_time; ?>

                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>

</body>
</html>