<?php /* Smarty version 2.6.31, created on 2019-12-31 16:53:47
         compiled from Yue_see.tpl */ ?>
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

<title>财务管理</title>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php?module=finance&action=Yue_see" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Yue_see" />
			<input type="hidden" name="user_id" value="<?php echo $this->_tpl_vars['user_id']; ?>
" id="user_id" />

			<div>
				<label class="">入账/支出：</label>
				<select id="otype" name="otype" class="select" style="width: 120px;height: 31px;vertical-align: middle;">
					<option value="" <?php if ($this->_tpl_vars['type'] == ''): ?> selected<?php endif; ?>>全部</option>
					<option value="1" <?php if ($this->_tpl_vars['type'] == '1'): ?> selected<?php endif; ?>>用户充值</option>
					<option value="2" <?php if ($this->_tpl_vars['type'] == '2'): ?>selected <?php endif; ?>>申请提现</option>
					<option value="4" <?php if ($this->_tpl_vars['type'] == '4'): ?> selected<?php endif; ?>>余额消费</option>
					<option value="5" <?php if ($this->_tpl_vars['type'] == '5'): ?> selected<?php endif; ?>>退款</option>
					<option value="11" <?php if ($this->_tpl_vars['type'] == '11'): ?> selected<?php endif; ?>>系统扣款</option>
					<option value="12" <?php if ($this->_tpl_vars['type'] == '12'): ?> selected<?php endif; ?>>给好友转余额</option>
					<option value="13" <?php if ($this->_tpl_vars['type'] == '13'): ?> selected<?php endif; ?>>转入余额</option>
					<option value="14" <?php if ($this->_tpl_vars['type'] == '14'): ?> selected<?php endif; ?>>系统充值</option>
					<option value="20" <?php if ($this->_tpl_vars['type'] == '20'): ?> selected<?php endif; ?>>抽奖中奖</option>
					<option value="21" <?php if ($this->_tpl_vars['type'] == '21'): ?> selected<?php endif; ?>>提现成功</option>
					<option value="22" <?php if ($this->_tpl_vars['type'] == '22'): ?> selected<?php endif; ?>>提现失败</option>
					<option value="23" <?php if ($this->_tpl_vars['type'] == '23'): ?> selected<?php endif; ?>>取消订单</option>
					<option value="26" <?php if ($this->_tpl_vars['type'] == '26'): ?> selected<?php endif; ?>>交竞拍押金</option>
					<option value="30" <?php if ($this->_tpl_vars['type'] == '30'): ?> selected<?php endif; ?>>会员返现</option>
				</select>

				<div style="position: relative;display: inline-block;">
					<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['starttime']; ?>
" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
				</div>至
				<div style="position: relative;display: inline-block;margin-left: 5px;">
					<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['group_end_time']; ?>
" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
				</div>
				<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

				<input type="submit" class="btn btn-success" id="btn1" value="查 询">
				&nbsp;
				<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="excel('all')">
			</div>
		</form>
	</div>
	<div class="page_h16"></div>
	<div>
		<table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
					<th width="50" >用户ID</th>
					<th width="130" >用户名称</th>
					<th width="130" >入账/支出</th>
					<th width="150" >金额</th>
					<th width="150" >交易时间</th>
					<th width="150" >备注</th>
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
						<td>
							<?php if ($this->_tpl_vars['item']->type == 1 || $this->_tpl_vars['item']->type == 5 || $this->_tpl_vars['item']->type == 13 || $this->_tpl_vars['item']->type == 14 || $this->_tpl_vars['item']->type == 20 || $this->_tpl_vars['item']->type == 22 || $this->_tpl_vars['item']->type == 23 || $this->_tpl_vars['item']->type == 27 || $this->_tpl_vars['item']->type == 30): ?>入账<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 2 || $this->_tpl_vars['item']->type == 4 || $this->_tpl_vars['item']->type == 11 || $this->_tpl_vars['item']->type == 12 || $this->_tpl_vars['item']->type == 21 || $this->_tpl_vars['item']->type == 26): ?>支出<?php endif; ?>
						</td>
						<td><?php echo $this->_tpl_vars['item']->money; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
						<td>
							<?php if ($this->_tpl_vars['item']->type == 1): ?>用户充值<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 2): ?>申请提现<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 4): ?>余额消费<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 5): ?>退款<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 11): ?>系统扣款<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 12): ?>给好友转余额<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 13): ?>转入余额<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 14): ?>系统充值<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 20): ?>抽奖中奖<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 21): ?>提现成功<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 22): ?>提现失败<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 23): ?>取消订单<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 26): ?>交竞拍押金<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 27): ?>退竞拍押金<?php endif; ?>
							<?php if ($this->_tpl_vars['item']->type == 30): ?>会员返现<?php endif; ?>
						</td>
	                </tr>
	            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
	<div style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script> 
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
<?php echo '
<script type="text/javascript">
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
    $("#otype").val(\'\');
    $("#startdate").val(\'\');
    $("#enddate").val(\'\');
}
</script>
'; ?>

</body>
</html>

