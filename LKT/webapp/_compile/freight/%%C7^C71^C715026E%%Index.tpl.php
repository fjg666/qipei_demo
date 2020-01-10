<?php /* Smarty version 2.6.31, created on 2019-12-30 20:17:30
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
.add_rules {
	clear: both;
	background-color: #edf1f5;
	padding-bottom: 10px;
}

.mt-10 {
	margin: 0!important;
}

.page_add a:hover {
	background-color: #2299E4!important;
}
#btn6:hover {
	background-color: #e5e5e5 !important;
}

#btn6 {
	width: 100px;
	height: 36px;
	text-align: center;
	float: left;
	margin: 10px 0px;
	border-radius: 4px;
}

#btn6 img {
	margin-left: 15px;
	margin-top: -2px;
}
.page_add{
	padding: 10px 8px 10px 0!important;
}
</style>
'; ?>

<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute">
	<div class="text-c">
		<form name="form1" action="index.php" method="get">
			<input type="hidden" name="module" value="freight" />
			<input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize" />

			<input type="text" name="name" size='8' value="<?php echo $this->_tpl_vars['name']; ?>
" id="" placeholder="请输入规则名称" style="width:200px" class="input-text">
			<input name="" id="btn1" class="btn btn-success" type="submit" value="查询" style="margin-right: 5px!important;">
		</form>
	</div>

	<div id="" style="overflow: hidden;background: #edf1f5;">
		<?php if ($this->_tpl_vars['button'][0] == 1): ?>
			<div class="add_rules page_add" style="float: left;">
				<a class="btn newBtn radius" style="border: none!important;" href="index.php?module=freight&action=Add"><img src="images/icon1/add.png" />&nbsp;添加规则</a>
			</div>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][2] == 1): ?>
			<a id="btn6" style="background: #fff;color: #6a7076;border: none;height: 36px;" onclick="dels('content','url')" >
				<div style="height: 100%;display: flex;align-items: center;" >
					<img src="images/icon1/del.png" /> &nbsp;批量删除
				</div>
			</a>
		<?php endif; ?>
	</div>
	<div class="page_h16"></div>

	<div class="mt-10 table-scroll">
		<table class="table table-border table-bordered table-bg table-hover taber_border tab_content">
			<thead>
				<tr class="text-c tab_tr">
					<th class="tab_label">
						<div class="tab_auto">
							<input name="all" id="i1" type="checkbox" class="inputC " value="<?php echo $this->_tpl_vars['item']->id; ?>
">
							<label for="i1"></label>
						</div>
					</th>
					<th>规则名称</th>
					<th>是否默认</th>
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
						<td class="tab_label">
							<div class="tab_auto">
								<input name="id[]" id="<?php echo $this->_tpl_vars['item']->id; ?>
" type="checkbox" class="inputC ckb" value="<?php echo $this->_tpl_vars['item']->id; ?>
">
								<label for="<?php echo $this->_tpl_vars['item']->id; ?>
"></label>
							</div>
						</td>
						<td><?php echo $this->_tpl_vars['item']->name; ?>
</td>
						<td>
							<input name="is_default" id="is_default_<?php echo $this->_tpl_vars['item']->id; ?>
" <?php if ($this->_tpl_vars['button'][3] == 1): ?> onclick="is_default(<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=freight&action=Is_default&id=')" <?php endif; ?> type="radio" value="<?php echo $this->_tpl_vars['item']->id; ?>
" style="margin-right: 5px;" <?php if ($this->_tpl_vars['item']->is_default == 1): ?>checked="checked"<?php endif; ?>>默认
						</td>
						<td class="tab_editor">
							<?php if ($this->_tpl_vars['button'][1] == 1): ?>
								<a href="index.php?module=freight&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="修改">
									<img src="images/icon1/xg.png" />&nbsp;修改
								</a>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['button'][2] == 1): ?>
								<a onclick="del(this,<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=freight&action=Del&id=','删除')">
									<img src="images/icon1/del.png" />&nbsp;删除
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
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
	<div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript">
// 根据框架可视高度,减去现有元素高度,得出表格高度
var Vheight = $(window).height()-56-56-56-($(\'.tb-tab\').text()?70:0)
$(\'.table-scroll\').css(\'height\',Vheight+\'px\')

var y_is_default = document.getElementsByName("is_default");
var y_id = \'\';
for(k in y_is_default) {
	if(y_is_default[k].checked) {
		y_id = y_is_default[k].value;
	}
}

// //批量删除
function dels(content,url) {
	console.log(\'del\');
	var y = 0;
	var i = 0;

	var pList = \'\';
	$("[name=\'id[]\']").each(function () {
		if ($(this).is(\':checked\')) {
			pList[y] = $(this).val();
			y++;
			pList += $(this).val() + ",";
		}
	});
	if(y == 0){
		layer.msg("请选择要删除的数据！");
		return false;
	}
	pList = pList.substring(0,pList.length-1);

	var url = "index.php?module=freight&action=Del&id=";
	confirm__(\'确认要删除吗？\', pList, url, content)

}

// 设置默认
function is_default(id, url) {
	if(y_id == id) {
		confirm1(\'确认要取消默认吗？\', id, 1, url)
	} else {
		confirm1(\'确认要修改默认吗？\', id, 2, url)
	}
}

var Id = \'\';
/*删除*/
function del(obj, id, url, content) {
	confirm(\'确认要删除吗？\', id, url, content)
}

function confirm__(content, id, url, content1) {
	$("body", parent.document).append(`
		<div class="maskNew">
			<div class="maskNewContent">
				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				<div class="maskTitle">提示</div>
				<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
				<div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
					${content}
				</div>
				<div style="text-align:center;margin-top:30px">
					<button class="closeMask" style="margin-right:20px" onclick=closeMask__1(\'${id}\',\'${url}\',\'${content1}\') >确认</button>
					<button class="closeMask" onclick=closeMask1() >取消</button>
				</div>
			</div>
		</div>
	`)
}

function confirm(content, id, url, content1) {
	$("body", parent.document).append(`
		<div class="maskNew">
			<div class="maskNewContent">
				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				<div class="maskTitle">提示</div>
				<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
				<div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
					${content}
				</div>
				<div style="text-align:center;margin-top:30px">
					<button class="closeMask" style="margin-right:20px" onclick=closeMask(\'${id}\',\'${url}\',\'${content1}\') >确认</button>
					<button class="closeMask" onclick=closeMask1() >取消</button>
				</div>
			</div>
		</div>
	`)
}

function confirm1(content, id, type, url, content1) {
	$("body", parent.document).append(`
		<div class="maskNew">
			<div class="maskNewContent">
				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				<div class="maskTitle">提示</div>
				<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
				<div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
					${content}
				</div>
				<div style="text-align:center;margin-top:30px">
					<button class="closeMask" style="margin-right:20px" onclick=closeMask_1(\'${id}\',\'${url}\',\'${type}\') >确认</button>
					<button class="closeMask" onclick=closeMask1() >取消</button>
				</div>
			</div>
		</div>
	`)
}

</script>
'; ?>

</body>
</html>