<?php /* Smarty version 2.6.31, created on 2019-12-30 21:25:00
         compiled from List.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<style type="text/css">
.btn1{
    width: 80px;
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
input:focus::-webkit-input-placeholder {
    color: transparent;
    /* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}
</style>
'; ?>

<body>
<nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    店铺
    <span class="c-gray en">&gt;</span>
    申请审核记录
</nav>

<div class="pd-20 page_absolute">
    <!--导航表格切换-->
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=mch&aciton=Index" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">店铺</a>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <a href="index.php?module=mch&action=List" class="btn1 swivch_active" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">审核列表</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][1] == 1): ?>
            <a href="index.php?module=mch&action=Set" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">多商户设置</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
            <a href="index.php?module=mch&action=Product" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">商品审核</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][3] == 1): ?>
            <a href="index.php?module=mch&action=Withdraw" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">提现审核</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][4] == 1): ?>
            <a href="index.php?module=mch&action=Withdraw_list" class="btn1" style="height: 42px !important;border:0!important;width: 112px;">提现记录</a>
        <?php endif; ?>
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <!-- 0=待审核，1=审核通过，2=审核不通过 -->
            <input type="hidden" name="module" value="mch"/>
            <input type="hidden" name="action" value="List"/>
            <select name="review_status" id="review_status" class="select" style="width: 130px;vertical-align: middle;">
                <option <?php if ($this->_tpl_vars['review_status'] == ''): ?>selected="selected"<?php endif; ?> value="">请选择审核状态</option>
                <option <?php if ($this->_tpl_vars['review_status'] == '0'): ?>selected="selected"<?php endif; ?> value="0">待审核</option>
                                <option <?php if ($this->_tpl_vars['review_status'] == '2'): ?>selected="selected"<?php endif; ?> value="2">审核不通过</option>
            </select>

            <input type="text" name="name" id="name" size='8' value="<?php echo $this->_tpl_vars['name']; ?>
" placeholder="请输入店铺名称或用户ID" style="width:200px" class="input-text">
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076;" class="reset" onclick="empty()"/>

            <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">
            <input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float: right;">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">店铺ID</th>
                    <th class="tab_imgurl">店铺信息</th>
                    <th>联系人</th>
                    <th class="tab_title">联系电话</th>
                    <th class="tab_time">申请/审核时间</th>
                    <th>审核状态</th>
                    <!--<th>店铺状态</th>-->
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
                    <td class="tab_news tab_t">
                        <div class="tab_good">
                            <img src="<?php echo $this->_tpl_vars['item']->logo; ?>
" class="tab_pic">
                            <div class="goods-info tab_left">
                                <div class="mt-1" style="font-weight:bold;color:rgba(65,70,88,1);font-size:14px;">店铺名称：<?php echo $this->_tpl_vars['item']->name; ?>
 </div>
                                <div class="mt-1" style="font-size: 14px;color: #888F9E;font-weight:400;margin: 6px 0px;">用户ID：<?php echo $this->_tpl_vars['item']->user_id; ?>
</div>
                                <div style="font-size: 14px;color: #888F9E;font-weight:400;">所属用户：<?php echo $this->_tpl_vars['item']->user_name; ?>
</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['item']->realname; ?>
</td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php echo $this->_tpl_vars['item']->tel; ?>
</td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;"><?php if ($this->_tpl_vars['item']->review_status == 0): ?><?php echo $this->_tpl_vars['item']->add_time; ?>
<?php else: ?><?php echo $this->_tpl_vars['item']->review_time; ?>
<?php endif; ?></td>
                    <td>
                        <?php if ($this->_tpl_vars['item']->review_status == 0): ?>
                            <span class="text-info" style="color: #FE9331;">待审核</span>
                        <?php elseif ($this->_tpl_vars['item']->review_status == 1): ?>
                            <span class="text-success" style="color: green;">审核通过</span>
                        <?php else: ?>
                            <span class="text-warning" style="color: #FF453D;">审核不通过</span>
                        <?php endif; ?>
                    </td>

                    <td class="tab_three">
                        <?php if ($this->_tpl_vars['item']->review_status == 0): ?>
                            <?php if ($this->_tpl_vars['button'][5] == 1): ?>
                                <a href="index.php?module=mch&action=Examine&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="审核">
                                    <img src="images/icon1/xg.png"/>&nbsp;审核
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['button'][6] == 1): ?>
                                <a href="index.php?module=mch&action=See&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="查看">
                                    <img src="images/icon1/ck.png"/>&nbsp;查看
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div class="tb-tab"><?php echo $this->_tpl_vars['pages_show']; ?>
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
var Vheight = $(window).height()-56-42-16-56-16-($(\'.tb-tab\').text()?70:0)
$(\'.table-scroll\').css(\'height\',Vheight+\'px\')

function empty() {
    $("#review_status").val(\'\');
    $("#name").val(\'\');
}
</script>
'; ?>

</body>
</html>