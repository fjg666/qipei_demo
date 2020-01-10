<?php /* Smarty version 2.6.31, created on 2019-12-20 16:57:33
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
.row .form-label{
    width: 14%!important;
}
.btn1{
    width: 112px;
    height: 42px;
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
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}
.btn1{
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
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}
</style>
'; ?>

</head>
<body style='display: none;'>
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    满减
    <span class="c-gray en">&gt;</span>
    满减活动列表
</nav>
<div class="pd-20 page_absolute">
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=subtraction" class="btn1 swivch_active " style="border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;" >满减活动</a>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <a href="index.php?module=subtraction&action=Config" class="btn1" style="border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;">满减设置</a>
        <?php endif; ?>
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="subtraction" />
            <input type="text" name="name" size='8' id="name" value="<?php echo $this->_tpl_vars['name']; ?>
" id="" placeholder="请输入活动标题" style="width:195px" class="input-text">
            <select name="status" id="status" class="select" style="width: 195px;height: 31px;vertical-align: middle;">
                <option  value="0" selected>请选择活动状态</option>
                <option  value="1" <?php if ($this->_tpl_vars['status'] == 1): ?>selected<?php endif; ?>>未开始</option>
                <option  value="2" <?php if ($this->_tpl_vars['status'] == 2): ?>selected<?php endif; ?>>开启</option>
                <option  value="3" <?php if ($this->_tpl_vars['status'] == 3): ?>selected<?php endif; ?>>关闭</option>
                <option  value="4" <?php if ($this->_tpl_vars['status'] == 4): ?>selected<?php endif; ?>>已结束</option>
            </select>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

            <input name="" id="" class="btn btn-success" type="submit" value="查询" >
        </form>
    </div>
    <div class="page_h16"></div>
    <?php if ($this->_tpl_vars['button'][1] == 1): ?>
        <div class="page_bgcolor">
            <a class="btn newBtn radius" href="index.php?module=subtraction&action=Add">
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/add.png"/>&nbsp;添加活动
                </div>
            </a>
        </div>
    <?php endif; ?>

    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table-border tab_content">
            <thead>
            <tr class="text-c tab_tr">
                <th>
                    <input type="checkbox" class="inputC input_agreement_protocol" id="ipt1" name="ipt1" value="">
                    <label for="ipt1"></label>
                </th>
                <th style="width:15%;">活动标题</th>
                <th style="width:15%;">活动名称</th>
                <th>活动状态</th>
                <th>活动类型</th>
                <th>活动时间</th>
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
                    <td>
                        <input type="checkbox" class="inputC input_agreement_protocol" id="<?php echo $this->_tpl_vars['item']->goods_id; ?>
" name="id[]" value="<?php echo $this->_tpl_vars['item']->goods_id; ?>
">
                        <label for="<?php echo $this->_tpl_vars['item']->goods_id; ?>
"></label>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->title; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->name; ?>
</td>
                    <td>
                        <?php if ($this->_tpl_vars['item']->status == 1): ?>
                            <span>未开始</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 2): ?>
                            <span style="color: #0abf0a;">开启</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 3): ?>
                            <span>关闭</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 4): ?>
                            <span style="color: red;">已结束</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->subtraction_type; ?>
</td>
                    <td>
                        <p>开始时间：<?php echo $this->_tpl_vars['item']->starttime; ?>
</p>
                        <p>结束时间：<?php echo $this->_tpl_vars['item']->endtime; ?>
</p>
                    </td>
                    <td class="tab_three" style="width: 24%;">
                        <div class="tab_block">
                            <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                                <?php if ($this->_tpl_vars['item']->status == 1 || $this->_tpl_vars['item']->status == 3): ?>
                                    <a onclick="lkt_status('是否开始此满减活动？',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=subtraction&action=Change&id=','开始')" href="javascript:void(0);" title="开始">
                                        <img src="images/icon1/ck.png"/>&nbsp;开始
                                    </a>
                                <?php elseif ($this->_tpl_vars['item']->status == 2): ?>
                                    <a onclick="lkt_status('是否结束此满减活动？',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=subtraction&action=Change&id=','结束')" href="javascript:void(0);" title="结束">
                                        <img src="images/icon1/ck.png"/>&nbsp;结束
                                    </a>
                                <?php else: ?>
                                    <a href="javascript:void(0);" title="停止">
                                        <img src="images/icon1/ck.png"/>&nbsp;结束
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][3] == 1): ?>
                                <a href="index.php?module=subtraction&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑">
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                </a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][4] == 1): ?>
                                <a onclick="confirm('是否删除此满减活动？',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=subtraction&action=Del&id=','删除')">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['button'][5] == 1): ?>
                                <a href="index.php?module=subtraction&action=Record&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="满减记录" style="width: 79px;">
                                    <img src="images/icon1/dj.png"/>&nbsp;满减记录
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div class='tb-tab' style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
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

// 根据框架可视高度,减去现有元素高度,得出表格高度
var Vheight = $(window).height()-56-42-16-56-16-36-16-($(\'.tb-tab\').text()?70:0)
$(\'.table-scroll\').css(\'height\',Vheight+\'px\')

function empty() {
    $("#name").val(\'\');
    $("#status").val(0);
}

function lkt_status(content, id, url, content1) {
    $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="height: 223px;">
                <div style="position: relative;top:60px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:100px;">
                    <button class="closeMask" onclick=closeMask1() style="background: #fff;color: #008DEF;border: 1px solid #008DEF;margin-right: 4px;">取消</button>
                    <button class="closeMask" style="background: #008DEF;color: #fff;border: 1px solid #008DEF;" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
                </div>
            </div>
        </div>
    `)
}

function confirm(content, id, url, content1) {
    $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <div style="height: 50px;position: relative;top:60px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:86px">
                    <button class="closeMask" onclick=closeMask1() style="background: #fff;color: #008DEF;border: 1px solid #008DEF;margin-right: 4px;">取消</button>
                    <button class="closeMask" style="background: #008DEF;color: #fff;border: 1px solid #008DEF;" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
                </div>
            </div>
        </div>
    `)
}
</script>
'; ?>

</body>
</html>