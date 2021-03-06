<?php /* Smarty version 2.6.31, created on 2019-12-30 10:42:00
         compiled from Yue.tpl */ ?>
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
<?php echo '
<style>
td a{
	width: 44%;
	margin: 0 auto!important;
}
.dataTables_wrapper .dataTables_length{
	bottom: 13px;
}
input:focus::-webkit-input-placeholder {
	color: transparent;
	/* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}

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
		<form name="form1" action="index.php?module=finance&action=Yue" method="get">
			<input type="hidden" name="module" value="finance" />
			<input type="hidden" name="action" value="Yue" />
			<div>
				<input type="text" id="name" class="input-text" style="width:150px" placeholder="请输入用户名称" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
">
				<select name="source" id="source" class="select" style="width: 120px;height: 31px;vertical-align: middle;">
					<option value="0" selected >全部</option>
					<?php echo $this->_tpl_vars['source']; ?>

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
				<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float:right;">
			</div>
		</form>
    </div>
    
    <div class="page_h16"></div>
	<div class="mt-20 table-scroll" >
		<table class="table-border tab_content">
			<thead>
				<tr class="text-c tab_tr">
					<th width="150" >用户ID</th>
					<th width="130" >用户名称</th>
					<th width="130" >来源</th>
					<th width="150" >余额</th>
					<th width="150" >注册时间</th>
		            <th width="100">操作</th>
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
						<td><?php if ($this->_tpl_vars['item']->source == 1): ?>小程序<?php elseif ($this->_tpl_vars['item']->source == 2): ?>APP<?php endif; ?></td>
						<td>
							<?php echo $this->_tpl_vars['item']->money; ?>

						</td>
						<td><?php echo $this->_tpl_vars['item']->Register_data; ?>
</td>
	                    <td style="min-width:120px;">
							<?php if ($this->_tpl_vars['button'][0] == 1): ?>
								<a style="text-decoration:none" class="ml-5" href="index.php?module=finance&action=Yue_see&user_id=<?php echo $this->_tpl_vars['item']->user_id; ?>
" title="查看详情">
							 		<div style="align-items: center;font-size: 12px;display: flex;">
										<div style="margin: 0 auto;display: flex;align-items: center;">
											<img src="images/icon1/ck.png"/>&nbsp;查看详情
										</div>
                                	</div>
								</a>
							<?php endif; ?>
	                    </td>
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
<!--<script type="text/javascript" src="style/js/My97DatePicker/WdatePicker.js"></script>--> 
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
	$("#source").val(0);
	$("#startdate").val(\'\');
	$("#enddate").val(\'\');
}
</script>
'; ?>

</body>
</html>

