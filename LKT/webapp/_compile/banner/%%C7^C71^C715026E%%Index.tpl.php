<?php /* Smarty version 2.6.31, created on 2019-12-20 16:09:43
         compiled from Index.tpl */ ?>

$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
</td>
" style="width: auto;height:80px;"/></td>
</td>
</td>
')" <?php if ($this->_tpl_vars['button'][3] != 1): ?>class="stopCss"<?php endif; ?>>
" title="编辑" >
,'index.php?module=banner&action=Del&id=','删除')">
</div>
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
