<?php /* Smarty version 2.6.31, created on 2019-12-30 10:13:26
         compiled from Modify.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
">
" readonly="readonly" style="width: 340px;" />
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
" selected="selected"><?php echo $this->_tpl_vars['item']->name; ?>
</option>
" ><?php echo $this->_tpl_vars['item']->name; ?>
</option>
">
" style="width: 340px;" />
" style="width: 340px;" />
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
