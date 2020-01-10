<?php /* Smarty version 2.6.31, created on 2020-01-02 16:19:03
         compiled from List.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style>
.btn1{
	width: 80px;
	height: 40px;
	line-height: 40px;
	display: flex;
	justify-content: center;
	align-items: center;
	float: left;
	color: #6a7076;
	background-color: #fff;
}
.btn1:hover{
	text-decoration: none;
}
.swivch a:hover{background-color: #2481e5!important;}
input:focus::-webkit-input-placeholder {
	color: transparent;
	/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}

</style>
'; ?>

</head>
<body class="iframe-container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="iframe-content">
    <div class="navigation">
		<?php if ($this->_tpl_vars['button'][0] == 1): ?>
			<div >
				<a href="index.php?module=finance" >提现审核</a>
			</div>
		<?php endif; ?>
		<p class='border'></p>
		<?php if ($this->_tpl_vars['button'][1] == 1): ?>
			<div class='active'>
				<a href="index.php?module=finance&action=List" >提现记录</a>
			</div>
		<?php endif; ?>
		<p class='border'></p>
		<?php if ($this->_tpl_vars['button'][2] == 1): ?>
			<div>
				<a href="index.php?module=finance&action=Config" >钱包参数</a>
			</div>
		<?php endif; ?>
    </div>
    <div class="hr" ></div>
	<div class="mt-20">
		<form action="index.php?module=finance" method="get" name="form1" style="background: #fff;padding: 10px;">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="List" />
			<input type="text" class="input-text" style="width:150px" placeholder="请输入用户名称" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" id="name">
			<input type="text" class="input-text" style="width:150px" placeholder="请输入联系电话" name="mobile" value="<?php echo $this->_tpl_vars['mobile']; ?>
" id="mobile">

			<div style="position: relative;display: inline-block;">
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['startdate']; ?>
" placeholder="请输入开始时间" id="startdate"  autocomplete="off"  name="startdate" style="width:150px;">
			</div>至
			<div style="position: relative;display: inline-block;margin-left: 5px;">
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['enddate']; ?>
" placeholder="请输入结束时间" id="enddate" name="enddate"  autocomplete="off"  style="width:150px;">
			</div>
			<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

			<input type="submit" id="btn1" class="btn btn-success" value="查 询">

			<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float:right;">
		</form>
    </div>
	<div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                	<th width="40">序</th>
		            <th width="150" >账户名</th>
					<th width="130" >来源</th>
					<th width="130" >提交时间</th>
		            <th width="150" >提现金额</th>
		            <th width="150" >提现手续费</th>
		            <th width="150" >银行名称</th>
		            <th width="150" >持卡人姓名</th>
		            <th width="150" >卡号</th>
		            <th width="150" >联系电话</th>
		            <th width="100" >状态</th>
					<th>备注</th>
				</tr>
            </thead>
            <tbody>
	            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
	                <tr class="text-c">
	                    <td><?php echo $this->_foreach['f1']['iteration']; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->name; ?>
</td>
						<td><?php if ($this->_tpl_vars['item']->source == 1): ?>小程序<?php elseif ($this->_tpl_vars['item']->source == 2): ?>APP<?php endif; ?></td>
						<td><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->money; ?>
元</td>
	                    <td><?php echo $this->_tpl_vars['item']->s_charge; ?>
元</td>
	                    <td><?php echo $this->_tpl_vars['item']->Bank_name; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->Cardholder; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->Bank_card_number; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->mobile; ?>
</td>
	                    <td><?php if ($this->_tpl_vars['item']->status == 0): ?><span style="color: #ff2a1f;">未审核</span><?php elseif ($this->_tpl_vars['item']->status == 1): ?><span style="color: #30c02d;">审核通过</span><?php else: ?><span style="color: #7A7A7A;">已拒绝</span><?php endif; ?></td>
						<td><?php echo $this->_tpl_vars['item']->refuse; ?>
</td>
	                </tr>
	            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
	<div class="tb-tab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-44-16-56-16-($(\'.tb-tab\').text()?70:0)
	$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
	
laydate.render({
	elem: \'#startdate\', //指定元素
	type: \'datetime\'
});
laydate.render({
	elem: \'#enddate\',
	type: \'datetime\'
});

function empty() {
    $("#name").val(\'\');
    $("#mobile").val(\'\');
    $("#startdate").val(\'\');
    $("#enddate").val(\'\');
}
</script>
'; ?>

</body>
</html>

