<?php /* Smarty version 2.6.31, created on 2019-12-20 15:35:33
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
" id="code" placeholder="请输入数据编码" style="width:200px" class="input-text">
" id="name" placeholder="请输入数据名称" style="width:200px" class="input-text">
" id="attribute_value" placeholder="请输入所属属性值" style="width:200px" class="input-text">
'>
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
</td>
</td>
</td>
</td>
" value="<?php echo $this->_tpl_vars['item']->status; ?>
">
,<?php echo $this->_tpl_vars['item']->id; ?>
)" style="margin: 0;<?php if ($this->_tpl_vars['item']->status == 1): ?>background-color:#5eb95e;<?php else: ?>background-color: #ccc;<?php endif; ?>">
" style="<?php if ($this->_tpl_vars['item']->status == 1): ?>left:30px;<?php else: ?>left:0px;<?php endif; ?>"></div>
</td>
</td>
" title="编辑" >
,'index.php?module=data_dictionary&action=Del&id=','删除')">
</div>
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
