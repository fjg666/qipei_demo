<?php /* Smarty version 2.6.31, created on 2019-12-30 11:49:49
         compiled from Recharge.tpl */ ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<!--<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />-->
<!--<link href="style/css/style.css" rel="stylesheet" type="text/css" />-->
<title>财务管理</title>
<?php echo '
<style>
input:focus::-webkit-input-placeholder {
	color: transparent;
	/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}
td a{
	width: 50%;
	margin: 0 auto!important;
}
#btn8:hover{border: 1px solid #2890FF!important;color: #2890FF!important;}
</style>
'; ?>

</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Recharge" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Recharge" />

			<input type="text" id="name" class="input-text" style="width:150px" placeholder="请输入用户名称" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
">
			<input type="text" id="mobile" class="input-text" style="width:150px" placeholder="请输入联系电话" name="mobile" value="<?php echo $this->_tpl_vars['mobile']; ?>
">

			<div style="position: relative;display: inline-block;">
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['startdate']; ?>
" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
			</div>至
			<div style="position: relative;display: inline-block;margin-left: 5px;">
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['enddate']; ?>
" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
			</div>
			<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

			<input type="submit" id="btn1" class="btn btn-success" value="查 询">

			<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float:right;">
		</form>
	</div>
	<div class="page_h16"></div>

	<div class="mt-20 table-scroll">
		<table class="table-border tab_content">
			<thead>
			<tr class="text-c tab_tr">
				<th>用户ID</th>
				<th>用户昵称</th>
				<th>充值总金额</th>
				<th>来源</th>
				<th>手机号码</th>
				<th>类型</th>
				<th>充值时间</th>
				<th>状态</th>
			</tr>
			</thead>
			<tbody>
			<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
				<tr class="text-c tab_td">
					<td><?php echo $this->_tpl_vars['item']->user_id; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']->user_name; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']->r_money; ?>
</td>
					<td><?php if ($this->_tpl_vars['item']->source == 1): ?>小程序<?php elseif ($this->_tpl_vars['item']->source == 2): ?>APP<?php endif; ?></td>
					<td><?php echo $this->_tpl_vars['item']->mobile; ?>
</td>
					<td><?php if ($this->_tpl_vars['item']->type == 1): ?>会员充值<?php elseif ($this->_tpl_vars['item']->type == 14): ?>系统充值<?php endif; ?></td>
					<td><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
					<td><span style="color:green;">成功</span></td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
	</div>
	<div class="tb-tab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<!--<script type="text/javascript" src="style/js/H-ui.admin.js"></script>-->
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
<script type="text/javascript" src="style/js/Popup.js"></script> <!-- 导出页弹窗-->

<?php echo '
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-16-($(\'.tb-tab\').text()?70:0)
	$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
	
laydate.render({
	elem: \'#startdate\', //指定元素
	type: \'datetime\'
});
laydate.render({
	elem: \'#enddate\',
	type: \'datetime\'
});

function excel(pageto) {
	location.href=location.href+\'&pageto=\'+pageto;
}
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

