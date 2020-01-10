<?php /* Smarty version 2.6.31, created on 2019-12-24 12:16:47
         compiled from ../../include_path/nav.tpl */ ?>
<nav class="breadcrumb page_bgcolor">
	<?php $_from = $this->_tpl_vars['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
		<?php if (($this->_foreach['f1']['iteration'] <= 1)): ?>
			<span class="c-gray en"></span>
			<span  style='color: #414658;'><?php echo $this->_tpl_vars['item']->title; ?>
</span>
		<?php else: ?>
			<span  class="c-gray en">&gt;</span>
			<?php if ($this->_foreach['f1']['total'] == 3 && ( $this->_foreach['f1']['total']-1 ) == $this->_tpl_vars['k']): ?>
				<span  style='color: #414658;'><?php echo $this->_tpl_vars['item']->title; ?>
</span>
			<?php else: ?>
				<a style="margin-top: 10px;"  onclick="javascript :history.back(-1);"><?php echo $this->_tpl_vars['item']->title; ?>
 </a>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
</nav>