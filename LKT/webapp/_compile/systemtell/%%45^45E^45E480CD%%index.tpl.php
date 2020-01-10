<?php /* Smarty version 2.6.31, created on 2019-12-20 15:35:25
         compiled from index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<style>
   	td a{
        width: 44%;
        margin: 2%!important;
        float: left;
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
    <div style="clear:both;" class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=systemtell&action=add"><img style="margin-right: 2px!important;height: 14px; width: 14px;" src="images/icon1/add.png"/>&nbsp;发布公告</a>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll" style="height: 82vh;">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th style="width:20%;">标题</th>
                    <th>类型</th>
                    <th class="tab_time">时间</th>
                    <th class="tab_time">添加时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($this->_tpl_vars['list'] != ''): ?>
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                    <tr class="text-c tab_td">
                        <td><?php echo $this->_tpl_vars['item']->title; ?>
</td>
                        <td><?php if ($this->_tpl_vars['item']->type == 1): ?>系统维护<?php else: ?>版本更新<?php endif; ?></td>
                        <td class="tab_time"><?php if ($this->_tpl_vars['item']->type == 1): ?><?php echo $this->_tpl_vars['item']->startdate; ?>
 ~ <?php echo $this->_tpl_vars['item']->enddate; ?>
<?php else: ?>无<?php endif; ?></td>
                        <td class="tab_time"><?php echo $this->_tpl_vars['item']->add_time; ?>
</td>
                        <td class="tab_editor">
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=systemtell&action=modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑">
                                <div style="align-items: center;font-size: 12px;display: flex;">
                                    <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                    </div>
                                </div>
                            </a>
                            <a style="text-decoration:none" class="ml-5" href="" onclick="confirm('确定要删除此公告吗?','<?php echo $this->_tpl_vars['item']->id; ?>
','index.php?module=systemtell&action=del&id=','删除')">
                                <div style="align-items: center;font-size: 12px;display: flex;">
                                    <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                    </div>
                                </div>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            <?php else: ?>
                <tr class="text-c"><td colspan="5">暂无数据</td></tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<?php echo '
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-36-16
	$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
	
    function confirm (content,id,url,content1){
		$("body",parent.document).append(`
			<div class="maskNew">
				<div class="maskNewContent">
					<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
					<div class="maskTitle">提示</div>	
					<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
					<div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
						${content}
					</div>
					<div style="text-align:center;margin-top:30px">
						<button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
						<button class="closeMask" onclick=closeMask1() >取消</button>
					</div>
				</div>
			</div>	
		`)
	};
</script>
'; ?>

</body>
</html>