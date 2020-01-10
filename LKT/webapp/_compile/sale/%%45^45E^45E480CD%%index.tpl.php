<?php /* Smarty version 2.6.31, created on 2019-12-30 10:50:21
         compiled from index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php echo '

<style>
	
	input[disabled]:hover {
		cursor: not-allowed;
	}
	
	.stopCss:hover {
		cursor: not-allowed;
	}
	
	.stopCss {
		width: 56px;
		height: 20px;
		border: 1px solid #e9ecef;
		color: #d8dbe8!important;
		font-size: 12px;
		border-radius: 2px;
		line-height: 20px;
		margin-right: 8px;
	    float: right;
	    display: block;
	}
	.tab_three .a_button{
		display: block;
	    float: right;
	    margin-top: 0px!important;
	    margin-right: 8px!important;
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
		<?php if ($this->_tpl_vars['button'][0] == 1): ?>
			<div style="clear:both;" class="page_bgcolor">
				<a class="btn newBtn radius" href="index.php?module=sale&action=add"><img src="images/icon1/add.png" />&nbsp;添加地址</a>
			</div>
		<?php endif; ?>
		<div class="page_h16"></div>
		<div class="tab_table table-scroll">
			<table class="table-border tab_content">
				<thead>
					<tr class="text-c tab_tr">
						<th class="tab_num">序号</th>
						<th>发货人</th>
						<th>联系电话</th>
						<th>详细地址</th>
						<th>邮政编码</th>
						<th>是否默认</th>
						<th class="tab_three">操作</th>
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
						<td><?php echo $this->_tpl_vars['item']->name; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']->tel; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']->address_xq; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']->code; ?>
</td>
						<td>
							<?php if ($this->_tpl_vars['item']->is_default == 1): ?><span style="color:#14C261;">默认地址</span><?php else: ?>否<?php endif; ?>
						</td>
						<td class="tab_three">
							<?php if ($this->_tpl_vars['button'][2] == 1): ?>
								<?php if ($this->_tpl_vars['item']->is_default != 1): ?>
									<a class="a_button" onclick="del(this,<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=sale&action=del&id=','删除')" title="删除">
										<img src="images/icon1/del.png" />&nbsp;删除
									</a>
								<?php else: ?>
									<div class="stopCss">
										<img style="margin-top: -3px;" src="images/icon1/shouhouAddress_delete_1.png" />&nbsp;删除
									</div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['button'][3] == 1): ?>
								<?php if ($this->_tpl_vars['item']->is_default != 1): ?>
									<a class="a_button" onclick="is_default(<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=sale&action=is_default&id=')" title="设为默认">
										<img src="images/icon1/qy.png" />&nbsp;默认
									</a>
								<?php else: ?>
									<div class="stopCss">
										<img style="margin-top: -3px;" src="images/icon1/shouhouAddress_mr_1.png" />&nbsp;默认
									</div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['button'][1] == 1): ?>
								<a class="a_button" href="index.php?module=sale&action=modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑">
									<img src="images/icon1/xg.png" />&nbsp;编辑
								</a>
							<?php else: ?>
								<div class="stopCss">
									<img style="margin-top: -3px;" src="images/icon1/shouhouAddress_update_1.png" />&nbsp;修改
								</div>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		</div>
		<div class="page_h20"></div>
	</div>
	<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
		<div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div>
	</div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php echo '
	<script type="text/javascript">
		// 根据框架可视高度,减去现有元素高度,得出表格高度
		var Vheight = $(window).height()-56-36-16
		$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
		
		var y_is_default = document.getElementsByName("is_default");
		var y_id = \'\';
		for(k in y_is_default) {
			if(y_is_default[k].checked) {
				y_id = y_is_default[k].value;
			}
		}

		// 设置默认
		function is_default(id, url) {
			confirm1(\'确认要修改默认吗？\', id, 2, url);
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
                            <button class="closeMask" onclick=closeMask1_1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
		}

		var aa = $(".pd-20").height() - 36 - 16;
		var bb = $(".table-border").height();
		if(aa < bb) {
			$(".page_h20").css("display", "block")
		} else {
			$(".page_h20").css("display", "none")
		}

		/*删除*/
		function del(obj, id, url, content) {
			confirm(\'确认要删除吗？\', id, url, content)
		}

		function confirm(content, id, url, content1) {
			$("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask(\'${id}\',\'${url}\',\'${content1}\')>确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
		}
		
//		开关
function checkNum(){
        if($(\'.switch-anim\').prop(\'checked\')){
            console.log("选中");
        }else{
            console.log("没选中");
        }
    }

	</script>
	'; ?>

</body>

</html>