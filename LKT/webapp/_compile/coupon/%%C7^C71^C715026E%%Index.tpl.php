<?php /* Smarty version 2.6.31, created on 2019-12-30 10:42:03
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
td a{
    width: 44%;
    margin: 2%!important;
    float: left;
}
.btn1{
    padding: 0px 10px;
    height: 36px;
    line-height: 36px;
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
input:focus::-webkit-input-placeholder {
    color: transparent;
    /* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}
.breadcrumb{
	font-size: 16px;
}
</style>
'; ?>

</head>
<body style='display: none;'>
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    卡券
    <span class="c-gray en">&gt;</span>
    优惠券列表
</nav>
<div class="pd-20 page_absolute ">
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=coupon" class="btn1 swivch_active" style="height: 36px;border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;" >优惠券列表</a>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <a href="index.php?module=coupon&action=Config" class="btn1" style="height: 36px;border: none!important;border-top-right-radius: 2px;border-bottom-right-radius: 2px;">优惠券参数</a>
        <?php endif; ?>
 		<div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="coupon" />
            <input type="text" name="name" size='8' id="name" value="<?php echo $this->_tpl_vars['name']; ?>
" id="" placeholder="请输入优惠券名称" style="width:180px" class="input-text">
            <select name="activity_type" id="activity_type" class="select" style="width: 180px;height: 31px;vertical-align: middle;">
                <option  value="0">请选择优惠券类型</option>
                <?php $_from = $this->_tpl_vars['coupon_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                    <option  value="<?php echo $this->_tpl_vars['k']; ?>
" <?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['activity_type']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
            <select name="status" id="status" class="select" style="width: 180px;height: 31px;vertical-align: middle;">
                <option  value="0">是否过期</option>
                <option  value="1" <?php if ($this->_tpl_vars['status'] == 1): ?>selected<?php endif; ?>>过期</option>
                <option  value="2" <?php if ($this->_tpl_vars['status'] == 2): ?>selected<?php endif; ?>>未过期</option>
            </select>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />
            <input name="" id="" class="btn btn-success" type="submit" value="查询" >
        </form>
    </div>
    <div class="page_h16"></div>
    <?php if ($this->_tpl_vars['button'][1] == 1): ?>
        <div style="clear:both;margin-top:0!important;background-color: #edf1f5;" class="btnDiv">
            <a class="btn newBtn radius" href="index.php?module=coupon&action=Add" style="width: 122px;">
                <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                    <img src="images/icon1/add.png" style="margin: 0px;"/>&nbsp;添加优惠券
                </div>
            </a>
        </div>
    <?php endif; ?>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr" >
                    <th class="tab_num">ID</th>
                    <th>优惠券名称</th>
                    <th>优惠券类型</th>
                    <th>可用范围</th>
                    <th>使用门槛</th>
                    <th>面值/折扣</th>
                    <th>总发行量</th>
                    <th>剩余数量</th>
                    <th>是否过期</th>
                    <th class="tab_time">有效时间</th>
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
                    <td>
                        <?php echo $this->_tpl_vars['item']->activity_type; ?>

                    </td>
                    <td><?php echo $this->_tpl_vars['item']->type; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->z_money; ?>
</td>
                    <td>
                        <?php if ($this->_tpl_vars['item']->activity_type == '满减券'): ?>
                            <?php echo $this->_tpl_vars['item']->money; ?>

                        <?php elseif ($this->_tpl_vars['item']->activity_type == '折扣券'): ?>
                            <?php echo $this->_tpl_vars['item']->discount; ?>
折
                        <?php elseif ($this->_tpl_vars['item']->activity_type == '会员赠券'): ?>
                            <?php if ($this->_tpl_vars['item']->money != 0): ?>
                                <?php echo $this->_tpl_vars['item']->money; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['item']->discount; ?>
折
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->circulation; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->num; ?>
</td>
                    <td>
                        <?php if ($this->_tpl_vars['item']->status == 0): ?>
                            <span style="color: #fff;background: #EE2C2C;width:20px;border-radius: 10px;padding: 0 10px;">未启用</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 1): ?>
                            <span style="color: #fff;width:20px;background:#3CB371;border-radius: 10px;padding: 0 10px;">已启用</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 2): ?>
                            <span style="color: #fff;width:20px;background:#EE9A00;border-radius: 10px;padding: 0 10px;">已禁用</span>
                        <?php else: ?>
                            <span style="color: #fff;width:20px;background:#00B2EE;border-radius: 10px;padding: 0 10px;">已结束</span>
                        <?php endif; ?>
                    </td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->end_time; ?>
</td>

                    <td class="tab_three">
                        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=coupon&action=Coupon&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="查看">
                                <img src="images/icon1/ck.png"/>&nbsp;查看
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['button'][3] == 1): ?>
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=coupon&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑">
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['button'][4] == 1): ?>
                            <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" <?php if ($this->_tpl_vars['item']->del_status == 1): ?>onclick="confirm('活动存在未使用的优惠券，是否确认删除？',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=coupon&action=Del&id=','删除')"<?php else: ?>onclick="confirm('是否删除此优惠券活动？',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=coupon&action=Del&id=','删除')"<?php endif; ?>>
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        <?php endif; ?>
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
    $("#activity_type").val(0);
    $("#status").val(0);
}
function confirm (content,id,url,content1){
	$("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="height: 223px!important;">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
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