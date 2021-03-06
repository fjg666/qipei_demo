<?php /* Smarty version 2.6.31, created on 2019-12-30 21:25:01
         compiled from Withdraw.tpl */ ?>
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
	提现审核列表
</nav>
<div class="pd-20 page_absolute">
	<!--导航表格切换-->
	<div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
		<a href="index.php?module=mch&aciton=Index" class="btn1 " style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">店铺</a>
		<?php if ($this->_tpl_vars['button'][0] == 1): ?>
			<a href="index.php?module=mch&action=List" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">审核列表</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][1] == 1): ?>
			<a href="index.php?module=mch&action=Set" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">多商户设置</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][2] == 1): ?>
			<a href="index.php?module=mch&action=Product" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">商品审核</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][3] == 1): ?>
			<a href="index.php?module=mch&action=Withdraw" class="btn1 swivch_active" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">提现审核</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['button'][4] == 1): ?>
			<a href="index.php?module=mch&action=Withdraw_list" class="btn1" style="height: 42px !important;border:0!important;width: 112px;">提现记录</a>
		<?php endif; ?>
		<div style="clear: both;"></div>
	</div>
	<div class="page_h16"></div>
	<div class="text-c">
		<form name="form1" action="index.php" method="get">
			<input type="hidden" name="module" value="mch" />
			<input type="hidden" name="action" value="Withdraw" />
			<input type="text" class="input-text" style="width:150px" placeholder="请输入店铺的名称	" name="name" id="name" value="<?php echo $this->_tpl_vars['name']; ?>
">
			<input type="text" class="input-text" style="width:150px" placeholder="请输入联系电话" name="mobile" id="mobile" value="<?php echo $this->_tpl_vars['mobile']; ?>
">

			<div style="position: relative;display: inline-block;">
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['startdate']; ?>
" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
			</div>至
			<div style="position: relative;display: inline-block;margin-left: 5px;">
				<input type="text" class="input-text" value="<?php echo $this->_tpl_vars['enddate']; ?>
" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
			</div>
			<input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

			<input type="submit" id="btn1" class="btn btn-success" value="查 询">

			<input type="button" value="导出" id="btn2" class="btn btn-success" onclick="export_popup(location.href)" style="float: right;">
		</form>
	</div>
	<div class="page_h16"></div>
	<div class="mt-20 table-scroll">
		<table class="table-border tab_content">
			<thead>
				<tr class="text-c tab_tr">
					<th class="tab_num">序号</th>
		            <th class="tab_imgurl" >店铺</th>
					<th >联系电话</th>
					<th >状态</th>
					<th class="tab_time">申请时间</th>
		            <th >提现金额</th>
		            <th >提现手续费</th>
					<th >持卡人姓名</th>
					<th >银行名称</th>
					<th >支行名称</th>
		            <th >卡号</th>
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
	                    <td class="tab_num"><?php echo $this->_foreach['f1']['iteration']; ?>
</td>
						<td class="tab_imgurl" >
							<div class="tab_good">
								<img src="<?php echo $this->_tpl_vars['item']->logo; ?>
" class="" style="margin: auto 0px;">
								<div class="goods-info tab_left" style="width: 150px;margin: auto 5px;">
									<div class="mt-1" style="font-weight:bold;color:rgba(65,70,88,1);font-size:14px;"><?php echo $this->_tpl_vars['item']->mch_name; ?>
 </div>
									<div class="mt-1" style="font-size: 14px;color: #888F9E;font-weight:400;margin: 6px 0px;">用户ID：<?php echo $this->_tpl_vars['item']->user_id; ?>
</div>
								</div>
							</div>
						</td>
						<td><?php echo $this->_tpl_vars['item']->mobile; ?>
</td>
						<td><?php if ($this->_tpl_vars['item']->status == 0): ?><span style="color: #ff2a1f;">待审核</span><?php elseif ($this->_tpl_vars['item']->status == 1): ?><span style="color: #30c02d;">审核通过</span><?php else: ?><span style="color: #7A7A7A;">已拒绝</span><?php endif; ?></td>
						<td class="tab_time"><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->money; ?>
元</td>
	                    <td><?php echo $this->_tpl_vars['item']->s_charge; ?>
元</td>
						<td><?php echo $this->_tpl_vars['item']->Cardholder; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']->Bank_name; ?>
</td>
						<td><?php echo $this->_tpl_vars['item']->branch; ?>
</td>
	                    <td><?php echo $this->_tpl_vars['item']->Bank_card_number; ?>
</td>
	                    <td class="tab_editor">
							<?php if ($this->_tpl_vars['button'][5] == 1): ?>
								<a title="通过" href="javascript:void(0);" onclick="examine(this,1,'<?php echo $this->_tpl_vars['item']->id; ?>
','<?php echo $this->_tpl_vars['item']->user_id; ?>
','<?php echo $this->_tpl_vars['item']->money; ?>
','<?php echo $this->_tpl_vars['item']->s_charge; ?>
','index.php?module=mch&action=Withdraw_examine')" >
									<img src="images/icon1/sx.png"/>&nbsp;通过
								</a>
								<a title="拒绝" href="javascript:void(0);" onclick="examine(this,2,'<?php echo $this->_tpl_vars['item']->id; ?>
','<?php echo $this->_tpl_vars['item']->user_id; ?>
','<?php echo $this->_tpl_vars['item']->money; ?>
','<?php echo $this->_tpl_vars['item']->s_charge; ?>
','index.php?module=mch&action=Withdraw_examine')">
									<img src="images/icon1/jy.png"/>&nbsp;拒绝
								</a>
							<?php endif; ?>
						</td>
	                </tr>
	            <?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
	</div>

	<div class='tb_tab' style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
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
    $("#mobile").val(\'\');
    $("#startdate").val(\'\');
    $("#enddate").val(\'\');
}
function examine(obj,m,id,user_id,money,s_charge,url) {
	if(m == 1){
		confirm("确定要通过该用户的申请？",m,id,user_id,money,s_charge,url);
    }else{
		confirm1("请输入拒绝原因",m,id,user_id,money,s_charge,url);
    }
}
function confirm (content,m,id,user_id,money,s_charge,url){
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask4(\'${m}\',\'${id}\',\'${user_id}\',\'${money}\',\'${s_charge}\',\'${url}\') >确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
}
function confirm1 (content,m,id,user_id,money,s_charge,url){
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">提示</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style=\'text-align: center;padding-top: 10px\'>
                	<input style=\'border:1px solid #666;height:30px;line-height: 30px\' type="text" placehold=\'请输入拒绝原因\' name=\'jujue\'>
                </div>
                <div style="text-align:center;margin-top:10px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask4_1(\'${m}\',\'${id}\',\'${user_id}\',\'${money}\',\'${s_charge}\',\'${url}\') >确认</button>
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

