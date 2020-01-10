<?php /* Smarty version 2.6.31, created on 2020-01-02 15:47:20
         compiled from See.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
    .tab_td td{
        height: auto;
        padding: 0;
    }
</style>
'; ?>

<div class="page-container page_absolute pd-20">
    <div class="tab_table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序号</th>
                    <th>任务标题</th>
                    <th>商品链接ID</th>
                    <th class="tab_title">商品名称</th>
                    <th>任务状态</th>
                    <th>执行时间</th>
                    <th>备注</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                <tr class="text-c tab_td">
                    <td class="tab_num"><?php echo $this->_foreach['f1']['iteration']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->title; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->itemid; ?>
</td>
                    <td class="tab_title">
                        <?php if ($this->_tpl_vars['item']->recycle == 0): ?>
                            <?php if ($this->_tpl_vars['item']->imgurl): ?>
                                <div style="float: left;">
                                    <img onclick="pimg(this)" src="<?php echo $this->_tpl_vars['item']->imgurl; ?>
" style="width: 60px;height: 60px;">
                                </div>
                            <?php endif; ?>
                            <div ><?php echo $this->_tpl_vars['item']->product_title; ?>
</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($this->_tpl_vars['item']->status == 0): ?>
                            待抓取
                        <?php elseif ($this->_tpl_vars['item']->status == 1): ?>
                            <font style="color: green;">抓取中</font>
                        <?php elseif ($this->_tpl_vars['item']->status == 2): ?>
                            <font style="color: #ddd;">抓取成功</font>
                        <?php else: ?>
                            <font style="color: red;">抓取失败</font>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                    <td title="<?php echo $this->_tpl_vars['item']->msg; ?>
" style="max-width: 110px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo $this->_tpl_vars['item']->msg; ?>
</td>
                    <td class="tab_editor">
                        <div class="tab_block">
                            <?php if ($this->_tpl_vars['item']->recycle == 0): ?>
                                <?php if ($this->_tpl_vars['item']->status == 2): ?>
                                    <a href="index.php?module=product&action=Modify&id=<?php echo $this->_tpl_vars['item']->pid; ?>
" title="编辑">
                                        <img src="images/icon1/xg.png"/>&nbsp;编辑
                                    </a>
                                <?php else: ?>
                                    <a href="javascript" title="查看详情" style="width: 88px;">
                                        <img src="images/icon1/ck.png"/>&nbsp;查看商品
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>

</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
</html>