<?php /* Smarty version 2.6.31, created on 2019-12-20 16:57:35
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style>
td a{
    width: 90%;
    margin: 2%!important;
}
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}
</style>
'; ?>

<body class="iframe-container" style='display: none;'>
<nav class="nav-title">
	<span>插件管理</span>
	<span><span class="arrows">&gt;</span>签到</span>
	<span><span class="arrows">&gt;</span>签到列表</span>
</nav>
<div class="iframe-content">
    <div class="navigation">
        <div class='active'>
			<a href="index.php?module=sign">签到列表</a>
		</div>
		<p class='border'></p>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <div>
                <a href="index.php?module=sign&action=Config">签到设置</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="hr"></div>
    <div>
        <form class='iframe-search' name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="sign" />
            <input type="text" class="input-text" style="width:195px" placeholder="请输入用户名称" name="name" id="name" value="<?php echo $this->_tpl_vars['name']; ?>
">
            <select name="source" class="select" id="select">
                <option value="" selected>请选择用户来源</option>
                <?php echo $this->_tpl_vars['source']; ?>

            </select>
            <input type="button" value="重置" id="btn8" class="reset" onclick="empty()" />
            <input name="" id="" class="submit" type="submit" value="查询">
        </form>
    </div>
    <div class="hr"></div>
    <div class="iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th width="40">
                        <div style="position: relative;display: flex;height: 30px;align-items: center;">
                            <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
                            <label for="ipt1"></label>
                        </div>
                    </th>
                    <th class="tab_num">用户ID</th>
                    <th>用户名称</th>
                    <th>手机号码</th>
                    <th>用户来源</th>
                    <th>签到积分总量</th>
                    <th>是否连续</th>
                    <th>连续签到天数</th>
                    <th class="tab_time">签到时间</th>
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
                    <td >
                        <div style="display: flex;align-items: center;height: 60px;">
                            <input name="id[]"  id="<?php echo $this->_tpl_vars['item']->id; ?>
" type="checkbox" class="inputC " value="<?php echo $this->_tpl_vars['item']->id; ?>
">
                            <label for="<?php echo $this->_tpl_vars['item']->id; ?>
"></label>
                        </div>
                    </td>
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->user_id; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->user_name; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->mobile; ?>
</td>
                    <td><?php if ($this->_tpl_vars['item']->source == 1): ?>小程序<?php elseif ($this->_tpl_vars['item']->source == 2): ?>APP<?php endif; ?></td>
                    <td><?php echo $this->_tpl_vars['item']->score; ?>
</td>
                    <td><?php if ($this->_tpl_vars['item']->num >= 2): ?>是<?php else: ?>否<?php endif; ?></td>
                    <td><?php echo $this->_tpl_vars['item']->num; ?>
</td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->sign_time1; ?>
</td>
                    <td>
                        <div class="operation">
                            <?php if ($this->_tpl_vars['button'][1] == 1): ?>
                                <div>
                                    <a style="text-decoration:none" href="index.php?module=sign&action=Record&user_id=<?php echo $this->_tpl_vars['item']->user_id; ?>
" title="详情">
                                        <img src="images/icon1/ck.png"/>详情
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                                <div>
                                    <a style="text-decoration:none" onclick="del(this,'<?php echo $this->_tpl_vars['item']->user_id; ?>
','index.php?module=sign&action=Del&user_id=')">
                                        <img src="images/icon1/del.png"/>删除
                                    </a>
                                </div>
                            <?php endif; ?>
						</div>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript">
	$(function(){
		$(\'body\').show();
	})

function empty() {
    $("#name").val(\'\');
    $("#select").val(\'\');
}
/*删除*/
function del(obj,id,url){
    confirm("确认删除此签到记录吗？",id,url,\'删除\');
}
function confirm (content,user_id,url,content1){
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask(\'${user_id}\',\'${url}\',\'${content1}\')>确认</button>
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