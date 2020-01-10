<?php /* Smarty version 2.6.31, created on 2019-12-30 11:10:35
         compiled from Index.tpl */ ?>
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

</head>
<body class="iframe-container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="iframe-content">
    <?php if ($this->_tpl_vars['store_type'] == 0): ?>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <div style="clear:both;background-color: #edf1f5;">
                <button class="btn newBtn radius" onclick="location.href='index.php?module=role&action=Add';" >
                    <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                        <img src="images/icon1/add.png"/>&nbsp;添加角色
                    </div>
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr" >
                    <th class="tab_num">序号</th>
                    <th>角色</th>
                    <th>描述</th>
                    <th class="tab_time">添加时间</th>
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
                    <td width="100px"><?php echo $this->_tpl_vars['item']->name; ?>
</td>
                    <td class="text-l"><?php echo $this->_tpl_vars['item']->permission; ?>
</td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                    <td class="tab_three">
                        <?php if ($this->_tpl_vars['store_type'] == 0): ?>
                            <?php if ($this->_tpl_vars['button'][1] == 1): ?>
                                <a style="text-decoration:none" class="ml-5" href="index.php?module=role&action=See&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="查看">
                                    <div style="align-items: center;font-size: 12px;display: flex;height: 100%;">
                                        <div style="margin:0 auto;;display: flex;align-items: center;height: 100%;">
                                            <img src="images/icon1/ck.png" style="margin: 0;"/>&nbsp;查看
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                                <a style="text-decoration:none" class="ml-5" href="index.php?module=role&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑" >
                                    <div style="align-items: center;font-size: 12px;display: flex;height: 100%;">
                                        <div style="margin:0 auto;;display: flex;align-items: center;height: 100%">
                                            <img src="images/icon1/xg.png" style="margin: 0;"/>&nbsp;编辑
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][3] == 1): ?>
                                <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要删除这个角色吗?',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=role&action=Del&id=','删除')">
                                    <div style="align-items: center;font-size: 12px;display: flex;height: 100%;">
                                        <div style="margin:0 auto;;display: flex;align-items: center;height: 100%">
                                            <img src="images/icon1/del.png" style="margin: 0;"/>&nbsp;删除
                                        </div>
                                    </div>
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