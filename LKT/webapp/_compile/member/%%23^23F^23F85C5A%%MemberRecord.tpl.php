<?php /* Smarty version 2.6.31, created on 2019-12-30 11:10:34
         compiled from MemberRecord.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<style>
#btn28{width: 80px!important;background-color: #2890FF!important;border: 1px solid #2890FF!important;}
#btn28:hover{background-color: #2481E5!important;border: 1px solid #2481E5!important;}
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
            <input type="hidden" name="module" value="member"/>
            <input type="hidden" name="action" value="MemberRecord"/>
            <input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize"/>

            <input type="text" name="name" size='8' value="<?php echo $this->_tpl_vars['name']; ?>
" id="name" placeholder="请输入管理员账号" style="width:200px" class="input-text">
            <div style="position: relative;display: inline-block;">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['startdate']; ?>
" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
            </div>
            至
            <div style="position: relative;display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['enddate']; ?>
" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
            </div>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

            <input name="" id="btn1" class="btn btn-success" type="submit" value="查询" style="border-radius: 2px;">
            <div style="float: right;margin-right: -5px;">
                <input id="btn9" class="btn " type="button" value="导出" onclick="export_popup(location.href)" style="background: #008DEF;color: #fff;margin-left: auto;margin-right: 0;">

                <?php if ($this->_tpl_vars['store_type'] == 0): ?>
                    <?php if ($this->_tpl_vars['button'][0] == 1): ?>
                        <input type="button" class="btn btn-danger radius" id="btn28" onclick="multiple_del('batch')" value="批量删除" />
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_label">
                        <div class="tab_auto">
                            <input name="id[]" id="ipt1" type="checkbox" value="" class="inputC">
                            <label for="ipt1" ></label>全选
                        </div>
                    </th>
                    <th>管理员账号</th>
                    <th>事件</th>
                    <th class="tab_time">时间</th>
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
" type="checkbox" class="inputC" value="<?php echo $this->_tpl_vars['item']->id; ?>
">
                            <label for="<?php echo $this->_tpl_vars['item']->id; ?>
" style="margin-left: 6px;"></label>
                        </div>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->admin_name; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->event; ?>
</td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->add_date; ?>
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
$(function(){
    // 根据框架可视高度,减去现有元素高度,得出表格高度
    var Vheight = $(window).height()-56-56-16-($(\'.tb-tab\').text()?70:0)
    $(\'.table-scroll\').css(\'height\',Vheight+\'px\')
});
laydate.render({
    elem: \'#startdate\', //指定元素
    type: \'datetime\'
});
laydate.render({
    elem: \'#enddate\',
    type: \'datetime\'
});
function empty() {
    $("#name").val(\'\');
    $("#startdate").val(\'\');
    $("#enddate").val(\'\');
}

/*批量删除*/
function multiple_del($type) {
    if ($type == \'onekey\') {
        confirm("确认要一键清空吗？", $type);
    } else {
        var checkbox = $("input[name=\'id[]\']:checked");//被选中的复选框对象
        console.log(checkbox)
        var Id = \'\';
        for (var i = 0; i < checkbox.length; i++) {
            Id += checkbox.eq(i).val() + ",";
        }
        console.log(Id)
        if (Id == "") {
            layer.msg(\'未选择数据!\');
            return false;
        }
        confirm("确认要批量删除吗？", $type, Id);
    }
}

function confirm(content, type, id) {
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask13(\'${type}\',\'${id}\') >确认</button>
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