<?php /* Smarty version 2.6.31, created on 2019-12-30 11:10:33
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style>
   	td a{
        width: 29%;
        margin: 1.5%!important;
        float: left;
    }
	.table-id{
		width:78px
	}
</style>
'; ?>

<body class='iframe-container'>
<nav class="nav-title">
	<span>权限管理</span>
    <span class='nav-to' onclick="javascript:history.back(-1);"><span class="arrows">&gt;</span>管理员列表</span>
</nav>
<div class="iframe-content">
    <?php if ($this->_tpl_vars['store_type'] == 0): ?>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <div style="clear:both;background-color: #edf1f5;">
                <button class="btn newBtn radius" onclick="location.href='index.php?module=member&action=Add';" >
                    <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                        <img src="images/icon1/add.png"/>&nbsp;添加管理员
                    </div>
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="page_h16"></div>
    <div class="iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class='table-id'>账户ID</th>
                    <th>账号</th>
                    <th>所属客户编号</th>
                    <th>绑定角色</th>
                    <th>添加人</th>
                    <th>添加时间</th>
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
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->id; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']->name; ?>
</td>
                    <td><?php echo $this->_tpl_vars['customer_number']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']->role_name; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->admin_name; ?>
</td>
                    <td ><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                    <td class="tab_three">
                        <?php if ($this->_tpl_vars['store_type'] == 0): ?>
                            <?php if ($this->_tpl_vars['button'][1] == 1): ?>
                                <?php if ($this->_tpl_vars['item']->status == 1): ?>
                                    <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm1('确定要启用该管理员吗?',<?php echo $this->_tpl_vars['item']->id; ?>
,'启用','index.php?module=member&action=Status&id=')" title="启用" >
                                        <img src="images/icon1/qy.png"/>&nbsp;启用
                                    </a>
                                <?php elseif ($this->_tpl_vars['item']->status == 2): ?>
                                    <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm1('确定要禁用该管理员吗?',<?php echo $this->_tpl_vars['item']->id; ?>
,'禁用','index.php?module=member&action=Status&id=')" title="禁用" >
                                        <img src="images/icon1/jy.png"/>&nbsp;禁用
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                                <a style="text-decoration:none" class="ml-5" href="index.php?module=member&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑" >
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                </a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][3] == 1): ?>
                                <a title="删除" href="javascript:;" onclick="confirm('确定要删除此管理员吗?',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=member&action=Del&id=')" class="ml-5" style="text-decoration:none">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                            <?php endif; ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-36-16-($(\'.tb-tab\').text()?70:0)
	$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
	
function confirm (content,id,url){
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask_role("${id}","${url}","删除") >确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
}

function confirm1 (content,id,content1,url){
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask2("${id}","${content1}","${url}") >确认</button>
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