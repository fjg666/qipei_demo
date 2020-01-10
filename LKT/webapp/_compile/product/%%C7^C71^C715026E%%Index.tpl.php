<?php /* Smarty version 2.6.31, created on 2019-12-20 16:09:19
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_head.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_img.tpl", 'smarty_include_vars' => array('sitename' => 'DIY_IMG')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<title>商品管理</title>
<?php echo '
<style type="text/css">
#product_title {
    width: 346px;
    border-radius: 2px;
    color: #97A0B4;
    border-color: #D5DBE8;
}

#product_title::-webkit-input-placeholder { /* WebKit browsers */
    color: #97A0B4;
}

#product_title::-moz-placeholder { /* Mozilla Firefox 19+ */
    color: #97A0B4;
}

#product_title:-ms-input-placeholder { /* Internet Explorer 10+ */
    color: #97A0B4;
}

#btn9 {
    border-radius: 2px;
}

#btn1:hover {
    background-color: #2299e4 !important;
    border: 1px solid #2299e4 !important;
}

#btn2:hover {
    background-color: #57a821 !important;
    border: 1px solid #57a821 !important;
}

#btn2 {
    height: 36px;
    background-color: #77c037 !important;
}

#btn3:hover {
    background-color: #299998 !important;
}

#btn4:hover {
    background-color: #eb2923 !important;
}

#btn5:hover {
    background-color: #ee6d1b !important;
}

#btn6:hover {
    background-color: #e5e5e5 !important;
}
#btn8:hover {
    border: 1px solid #2890ff !important;
    color: #2890ff !important;
}

#btn9:hover {
    background-color: #2481e5 !important;
}

#btntaob:hover {
    background-color: #3c66d4 !important;
}

form .select {
    width: 195px !important;
    border-radius: 2px;
}

.proSpan {
    font-size: 12px;
    border-radius: 2px;
    color: #ffffff;
    margin: 0 6px 0 0;
    padding: 0px 3px;
}

.xp {
    background-color: #68c8c7;
}

.rx {
    background-color: #ff6c60;
}

.tj {
    background-color: #feb04c;
}

.btn1 {
    width: 100px;
}

#jbxx, #changePassword {
    position: absolute;
    z-index: 9999999;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(102, 102, 102, .1);
}

.jbxx_div .submit {
    padding: 0;
}

.jbxx_div input::-webkit-outer-spin-button,
.jbxx_div input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

#chang_div {
    position: absolute;
    top: 60px;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    display: flex;
}

.maskContent1 {
    width: 500px;
    margin: auto;
    position: relative;
    background: #fff;
    border-radius: 10px;
    padding: 10px 0px;
    border: 1px solid #d5dbe8;
}

.maskContent1 input[type=submit] {
    width: 100px;
    height: 40px;
    border: 1px solid #eee;
    border-radius: 5px;
    background: #008DEF;
    color: #fff;
    font-size: 16px;
    line-height: 40px;
    display: inline-block;
    margin-right: 30px;
}

.pop_title {
    font-size: 14px;
    line-height: 20px;
    height: 30px;
    border-bottom: 1px solid #E9ECEF;
    color: #414658;
    font-family: "Microsoft Yahei";
    font-weight: bold;
    padding-left: 14px;
    position: relative;
    margin-bottom: 37px;
}

.pop_title img {
    position: absolute;
    top: 4px;
    right: 20px;
    width: 14px;
    height: 14px;
    background-size: 100% 100%;
    z-index: 999;
}

.iptDiv {
    height: 40px;
}

.iptLeft {
    width: 25%;
    float: left;
    text-align: right;
    padding-right: 5px;
    box-sizing: border-box;
    line-height: 35px;
    height: 35px;
}

.iptRight {
    width: 75%;
    float: left;
    color: #414658;
}

.iptRight input {
    border: 1px solid #d5dbe8;
    width: 308px;
    height: 35px;
    line-height: 35px;
    border-radius: 5px;
    padding-left: 10px;
}

input:focus::-webkit-input-placeholder {
    color: transparent;
    /* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
}

.tab_three>div{display: flex; flex-flow: row wrap;width: 200px;justify-content: center;align-items: center;}
.tab_three>div a{margin: 4px 2px!important;}


.formInputDiv{
    display: flex;
    width: 195px;
    border: 1px solid #D5DBE8;
}
.formInputDiv ul{width: 195px;margin: 0;height: 171px;overflow-y: scroll;}
.formInputDiv ul:not(:last-child){border-right: 1px solid #D5DBE8;}
.formInputDiv li{height: 30px;line-height: 30px;cursor: pointer;font-size: 14px;color: #6A7076;user-select:none;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;padding: 0 12px;}
.formInputDiv li:hover{color: #0880FF;}
.formInputDiv .active{position: relative;background: #0880FF;color: #fff!important;}

.selectDiv{position: relative;width: 180px;height: 36px;}
.selectDiv>div{position: absolute;top:0;left: 0;width: 100%;height: 100%;display: flex;align-items: center;padding-left: 12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;padding-right: 15px;}
.selectDiv p{margin-bottom: 0;}
.selectItem span{margin: 0 5px;}
form .input_180{width: 180px!important}
#form1{display: flex;}
</style>
'; ?>

</head>
<body style="background-color: #edf1f5!important">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="pd-20 page_absolute">
    <div class="text-c text_c">
        <form name="form1" id="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="product"/>
            <input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize"/>

            <div style="float: left;margin-right: 8px;">
                <div class='selectDiv' onclick="select_class()" >
                    <select name="cid" class="select input_180" readonly="readonly" style='margin-right: 0;'>
                        <?php if ($this->_tpl_vars['class_id']): ?>
                            <option selected="selected" value="<?php echo $this->_tpl_vars['class_id']; ?>
"></option>
                        <?php else: ?>
                            <option selected="selected" value="0">请选择商品类别</option>
                        <?php endif; ?>
                    </select>
                    <div id="div_text">
                        <?php if ($this->_tpl_vars['class_id']): ?>
                            <?php $_from = $this->_tpl_vars['ctypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                                <?php if (($this->_foreach['f1']['iteration'] <= 1)): ?>
                                    <p class='selectItem' id='p<?php echo $this->_tpl_vars['k']+1; ?>
' tyid='<?php echo $this->_tpl_vars['item']->cid; ?>
' onclick='del_sel(this,<?php echo $this->_tpl_vars['item']->level; ?>
,<?php echo $this->_tpl_vars['item']->cid; ?>
)'><?php echo $this->_tpl_vars['item']->pname; ?>
</p>
                                <?php else: ?>
                                    <p class='selectItem' id='p<?php echo $this->_tpl_vars['k']+1; ?>
' tyid='<?php echo $this->_tpl_vars['item']->cid; ?>
' onclick='del_sel(this,<?php echo $this->_tpl_vars['item']->level; ?>
,<?php echo $this->_tpl_vars['item']->cid; ?>
)'><span>&gt;</span><?php echo $this->_tpl_vars['item']->pname; ?>
</p>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div id='selectData' class='formInputDiv' style='display: none;'>
                    <ul id="selectData_1">

                    </ul>
                </div>
            </div>
            <div class="formInputSD" onclick="select_pinpai()" style="float: left;margin-right: 2px;">
                <select name="brand_id" class="select input_180" id="brand_class">
                    <?php $_from = $this->_tpl_vars['brand_class']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                        <option value="<?php echo $this->_tpl_vars['item']->brand_id; ?>
" <?php if ($this->_tpl_vars['item']->brand_id == $this->_tpl_vars['brand_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']->brand_name; ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </div>
            <select name="active" class="select input_180"  id="active" onClick="activitytype();">
                <option value="0" <?php if ($this->_tpl_vars['active'] == 0): ?>selected="selected"<?php endif; ?>>请选择商品类型</option>
                <option value="1" <?php if ($this->_tpl_vars['active'] == 1): ?>selected="selected"<?php endif; ?>>正价</option>
                <?php echo $this->_tpl_vars['select4']; ?>

                <option value="6" <?php if ($this->_tpl_vars['active'] == 6): ?>selected="selected"<?php endif; ?>>会员</option>
            </select>

            <select name="status" class="select input_180"  id="status">
                <option value="">请选择商品状态</option>
                <?php echo $this->_tpl_vars['select2']; ?>

            </select>
            <select name="show_adr" class="select input_180" id="show_adr" <?php if ($this->_tpl_vars['active'] != 1): ?>style="display: none;"<?php endif; ?>>
                <?php echo $this->_tpl_vars['select3']; ?>

            </select>
            <input type="text" name="product_title" size='8' id="product_title" value="<?php echo $this->_tpl_vars['product_title']; ?>
" placeholder="请输入商品名称" class="input-text input_180">
            <input type="text" name="mch_name" id="mch_name" value="<?php echo $this->_tpl_vars['mch_name']; ?>
" placeholder="请输入店铺名称" class="input-text input_180">

            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()"/>

            <input name="" id="btn9" class="btn " type="submit" value="查询">

            <input id="btn9" class="btn " type="button" value="导出" onclick="export_popup(location.href)" style="background: #008DEF;color: #fff;margin-left: auto;margin-right: 0;">
        </form>
    </div>

    <div class="page_h16">

    </div>
    <div style="clear:both;margin-top:0!important;background-color: #edf1f5;" class="btnDiv">
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <?php if ($this->_tpl_vars['mch_id'] == '0'): ?>
                <a class="btn btn1 radius" id="btn1" style="background-color:#38b4ed;color: #fff;height: 36px;" onclick="tc(<?php echo $this->_tpl_vars['item']->id; ?>
)" href="javascript:void(0);">
                    <div style="height: 100%;display: flex;align-items: center;">
                        <img src="images/icon1/add.png"/>&nbsp;发布商品
                    </div>
                </a>
            <?php else: ?>
                <a class="btn btn1 radius" id="btn1" style="background-color:#38b4ed;color: #fff;height: 36px;"
                   href="index.php?module=product&action=Add">
                    <div style="height: 100%;display: flex;align-items: center;">
                        <img src="images/icon1/add.png"/>&nbsp;发布商品
                    </div>
                </a>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][4] == 1): ?>
            <a class="btn btn1 radius" id="btntaob" style="background-color:#5387DD;color: #fff;" href="index.php?module=taobao&action=Index" >
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/taobaobtn.png" style="width: 14px;height: 14px;"/>&nbsp;<span>淘宝抓取</span>
                </div>
            </a>

            <a class="btn btn1 radius btn_up" id="btn2" style="background-color:#77c037;color: #fff;" href="javascript:;" onclick="operation(1,'index.php?module=product&action=Operation&id=')">
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/sj.png"/>&nbsp;<span>商品上架</span>
                </div>
            </a>
            <a class="btn btn1 radius btn_xp" id="btn3" style="background-color:#42b4b3;color: #fff;" href="javascript:;" onclick="operation(3,'index.php?module=product&action=Operation&id=')">
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/xp.png"/>&nbsp;<span>设为新品</span>
                </div>
            </a>
            <a class="btn btn1 radius btn_rx" id="btn4" style="background-color:#ff453d;color: #fff;" href="javascript:;" onclick="operation(5,'index.php?module=product&action=Operation&id=')">
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/rx.png"/>&nbsp;<span>设为热销</span>
                </div>
            </a>
            <a class="btn btn1 radius btn_tj" id="btn5" style="background-color:#fe9331;color: #fff;">
                <div style="height: 100%;display: flex;align-items: center;" href="javascript:;" onclick="operation(7,'index.php?module=product&action=Operation&id=')">
                    <img src="images/icon1/tj.png"/>&nbsp;<span>设为推荐</span>
                </div>
            </a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
            <a href="javascript:;" id="btn6" onclick="datadel('index.php?module=product&action=Del&id=','删除')" style="background: #fff;color: #6a7076;border: none;" class="btn btn1 btn-danger radius">
                <div style="height: 100%;display: flex;align-items: center;">
                    <img src="images/icon1/del.png"/>&nbsp;批量删除
                </div>
            </a>
        <?php endif; ?>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <input type="hidden" name="store_id" id="store_id" value="<?php echo $this->_tpl_vars['store_id']; ?>
">
        <table class="table-border tab_content">
            <thead>
            <tr class="text-c tab_tr">
                <th class="tab_label">
                    <div class="tab_auto">
                        <input onclick="product_all(this)" type="checkbox" id="product-99" class="inputC product_all" value="99">
                        <label for="product-99"></label>
                    </div>
                </th>
                <th>商品编号</th>
                <th class="tab_imgurl">商品图片</th>
                <th class="tab_title">商品标题</th>
                <th>商品分类</th>
                <th>品牌</th>
                <th>价格</th>
                <th>库存</th>
                <th>商品状态</th>
                <th>所属店铺</th>
                                <th>销量</th>
                <th class="tab_time">上架时间</th>
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
                    <td class="tab_label">
                        <div class="tab_auto">
                            <input name="id[]" id="<?php echo $this->_tpl_vars['item']->id; ?>
" type="checkbox" class="inputC product_select" value="<?php echo $this->_tpl_vars['item']->id; ?>
" onclick="onshelves(<?php echo $this->_tpl_vars['item']->id; ?>
)">
                            <label for="<?php echo $this->_tpl_vars['item']->id; ?>
"></label>
                        </div>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->id; ?>
</td>
                    <td class="tab_imgurl">
                        <?php if ($this->_tpl_vars['item']->img != ''): ?>
                            <span>暂无图片</span>
                        <?php else: ?>
                            <img onclick="pimg(this)" src="<?php echo $this->_tpl_vars['item']->imgurl; ?>
">
                        <?php endif; ?>
                    </td>
                    <td class="tab_title "><?php echo $this->_tpl_vars['item']->product_title; ?>

                        <div class="tab_clear">
                            <?php $_from = $this->_tpl_vars['item']->s_type; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item1']):
        $this->_foreach['f2']['iteration']++;
?>
                                <?php if ($this->_tpl_vars['item1'] == 1): ?><span class="proSpan xp">新品</span><?php endif; ?>
                                <?php if ($this->_tpl_vars['item1'] == 2): ?><span class="proSpan rx">热销</span><?php endif; ?>
                                <?php if ($this->_tpl_vars['item1'] == 3): ?><span class="proSpan tj">推荐</span><?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->pname; ?>
</td>
                    <td><?php if ($this->_tpl_vars['item']->brand_name != ''): ?><?php echo $this->_tpl_vars['item']->brand_name; ?>
<?php else: ?>无<?php endif; ?></td>
                    <td><span class="tab_span"><?php echo $this->_tpl_vars['item']->price; ?>
</span></td>

                    <td <?php if ($this->_tpl_vars['item']->num <= $this->_tpl_vars['item']->min_inventory): ?>style="color: red;" <?php endif; ?>><?php echo $this->_tpl_vars['item']->num; ?>
</td>
                    <td class="tab_editor">
                        <div class="tab_block">
                            <!-- 0=待审核，1=审核通过，2=审核不通过 -->
                            <?php if ($this->_tpl_vars['item']->status == 2): ?>
                                <span style="background-color: #5eb95e;" class="badge statu badge-success">已上架</span>
                            <?php elseif ($this->_tpl_vars['item']->status == 3): ?>
                                <span class="badge statu badge-default">已下架</span>
                            <?php elseif ($this->_tpl_vars['item']->status == 1): ?>
                                <span class="badge statu badge-default">待上架</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->shop_name; ?>
</td>
                                        <td><?php echo $this->_tpl_vars['item']->volume; ?>
</td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->upper_shelf_time; ?>
</td>
                    <td class="tab_three">
                       <div>
						   <?php if ($this->_tpl_vars['button'][1] == 1): ?>
						       <?php if ($this->_tpl_vars['item']->status == 2): ?>
						           <a onclick="modify(this,<?php echo $this->_tpl_vars['item']->status; ?>
,'index.php?module=product&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
')" style="color: rgb(136, 143, 158);">
						               <img src="images/icon1/xg.png"/>&nbsp;编辑
						           </a>
						       <?php else: ?>
						           <a href="index.php?module=product&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" style="color: rgb(136, 143, 158);" title="编辑">
						               <img src="images/icon1/xg.png"/>&nbsp;编辑
						           </a>
						       <?php endif; ?>
						   <?php endif; ?>
						   <?php if ($this->_tpl_vars['button'][2] == 1): ?>
						       <a onclick="del(<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=product&action=Del&id=')" style="color: rgb(136, 143, 158);">
						           <img src="images/icon1/del.png"/>&nbsp;删除
						       </a>
						   <?php endif; ?>
                           <?php if ($this->_tpl_vars['button'][6] == 1): ?>
                               <a href="index.php?module=product&action=Copy&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="复制" style="">
                                   <img src="images/icon1/copy.png"/>&nbsp;复制
                               </a>
                           <?php endif; ?>
                           <?php if ($this->_tpl_vars['button'][7] == 1): ?>
                               <?php if ($this->_tpl_vars['item']->upper_status): ?>
                                   <a onclick="move_upward('<?php echo $this->_tpl_vars['item']->id; ?>
','<?php echo $this->_tpl_vars['item']->upper_id; ?>
','<?php echo $this->_tpl_vars['item']->underneath_id; ?>
','<?php echo $this->_tpl_vars['item']->upper_status; ?>
')" href="javascript:void(0);" title="上移">
                                       <img src="images/icon1/moveUp.png" style='width: 12px; height: 12px;'/>&nbsp;上移
                                   </a>
                               <?php else: ?>
                                   <a onclick="move_upward('<?php echo $this->_tpl_vars['item']->id; ?>
','<?php echo $this->_tpl_vars['item']->upper_id; ?>
','<?php echo $this->_tpl_vars['item']->underneath_id; ?>
','<?php echo $this->_tpl_vars['item']->upper_status; ?>
')" href="javascript:void(0);" title="下移">
                                       <img src="images/icon1/moveDown.png" style='width: 12px; height: 12px;'/>&nbsp;下移
                                   </a>
                               <?php endif; ?>
                               <a onclick="on_top(<?php echo $this->_tpl_vars['item']->id; ?>
)" href="javascript:void(0);" title="置顶">
                                   <img src="images/icon1/zd.png"/>&nbsp;置顶
                               </a>
                           <?php endif; ?>

						   <?php if ($this->_tpl_vars['button'][5] == 1): ?>
						       <?php if ($this->_tpl_vars['item']->status == 2): ?>
						           <a onclick="aj(<?php echo $this->_tpl_vars['item']->id; ?>
)" href="javascript:void(0);" title="下架">
						               <img src="images/icon1/xj.png"/>&nbsp;下架
						           </a>
						       <?php else: ?>
						           <a onclick="aj(<?php echo $this->_tpl_vars['item']->id; ?>
)" href="javascript:void(0);" title="上架">
						               <img src="images/icon1/sj_g.png"/>&nbsp;上架
						           </a>
						       <?php endif; ?>
						   <?php endif; ?>
					   </div>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div class="tab_footer"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:9999;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div></div>
<div id="jbxx" class="jbxx_div" style="display: none;">
    <div id="chang_div">
        <div class="maskContent1">
            <a class="closeA clsCPW chang_click"><img src="images/icon1/gb.png"/></a>
            <form action="javascript:void(0);" name="form2" id='form2' method="post">
                <div class="pop_title">设置店铺信息
                    <img src="images/icon/cha.png" class="clsCPW"/>
                </div>
                <div class="upload-group">
                    <div class="input-group row" style="margin-left: 0px !important;">
                        <div class="iptLeft">
                            店铺头像：
                        </div>
                        <div>
                            <input index="0" value="<?php echo $this->_tpl_vars['logo']; ?>
" name="logo" class="form-control file-input"
                                   style="border: 1px solid #d5dbe8;width: 130px;height: 35px;line-height: 35px;border-radius: 5px;padding-left: 10px;">
                        </div>
                        <div style="border: solid 1px #2890FF;padding: 6px 15px;border-radius: 5px;margin-left: 12px;">
                            <a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title=""
                               class="select-file" style="color: #2890FF;font-size: 12px;">选择文件</a>
                        </div>
                        <div style="border: solid 1px #d5dbe8;padding: 6px 15px;margin-left: 6px;border-radius: 5px;">
                            <a href="javascript:" data-toggle="tooltip" data-placement="bottom" class="upload-file"
                               style="color: #888f9e;font-size: 12px;">上传文件</a>
                        </div>
                    </div>
                    <div class="upload-preview text-center upload-preview" style="margin-left: 120px;">
                        <img class="upload-preview-img" src="<?php echo $this->_tpl_vars['logo']; ?>
">
                    </div>
                    <div class="iptRight">
                        <span style="display: block;margin-left: 224px;margin-top: -66px;color: #888f9e;">（120px*120px）</span>
                    </div>
                </div>

                <div class="iptDiv" style="margin-top: 10px;">
                    <div class="iptLeft">
                        店铺名称：
                    </div>
                    <div class="iptRight">
                        <input type="text" placeholder="请填写店铺名称" name="name" value=""/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="iptDiv" style="margin-top: -10px;">
                    <div class="iptLeft">
                        经营范围：
                    </div>
                    <div class="iptRight">
                        <input type="text" placeholder="请填写店铺经营范围" name="confines" value=""/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="iptDiv" style="margin-top: -10px;">
                    <div class="iptLeft">
                        店铺信息：
                    </div>
                    <div class="iptRight">
                        <textarea rows="3" cols="40" name="shop_information"
                                  style="color:#888f9e;border-color:#d5dbe8;padding-left: 10px;">请填写店铺简介信息
                        </textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div style="float: right;margin-right: 14px;margin-top: 60px;margin-bottom: 10px;">
                    <button type="button" onclick="check()" class="saveBtnSD bottomBtn" style="float: right;margin-right: 10px;">
                        保存
                    </button>
                    <button type="button" class="backBtnSD bottomBtn clsCPW" style="float: right;margin-right: 0px;">
                        取消
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/software_footer.tpl", 'smarty_include_vars' => array('sitename' => "DIY底部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <script type="text/javascript">
        var del_str = <?php echo $this->_tpl_vars['del_str']; ?>

        del_str = JSON.stringify(del_str);
        <?php echo '
        var store_id = $("#store_id").val();
        var Id = localStorage.getItem("id_list"+store_id);

        $(function(){
            if(Id){
                id_list(Id)
            }

            // 根据框架可视高度,减去现有元素高度,得出表格高度
			var Vheight = $(window).height()-56-60-16-36-16-70
			$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
        });
        // 重置
        function empty() {
            $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',0)
            $(\'.selectDiv>div\').html(\'\')

            $("#brand_class").val(0);
            $("#s_type").val(0);
            $("#status").val(\'\');
            $("#active").val(0);
            $("#show_adr").val(0);
            $("#product_title").val(\'\');
            $("#mch_name").val(\'\');
            document.getElementById(\'show_adr\').style.display = "none"; // 显示
        }

        function modify(obj,status,url) {
            if(status == 2){
                confirm_modify("确认修改此上架商品吗？", url);
            }
        }
        function confirm_modify(content, url) {
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
                            <button class="closeMask" style="margin-right:20px" onclick=confirm_modify_close(\'${url}\')>确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        }

        // 商品类型
        function activitytype(){
            var activity_type = $(\'#active option:selected\').val(); // 优惠券类型
            if(activity_type == 1){
                document.getElementById(\'show_adr\').style.display = ""; // 显示
            }else {
                document.getElementById(\'show_adr\').style.display = "none"; // 隐藏
            }
        }
        function tc() {
            document.getElementById(\'jbxx\').style.display = ""; // 隐藏
        }

        $(".clsCPW").on("click", function () {
            document.getElementById(\'jbxx\').style.display = "none"; // 隐藏
        })
        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }

        function check() {
            $.ajax({
                cache: true,
                type: "GET",
                dataType: "json",
                url: \'index.php?module=product&action=Add&m=mch\',
                data: $(\'#form2\').serialize(),// 你的formid
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        setTimeout(function () {
                            location.href = "index.php?module=product&action=Add";
                        }, 2000)
                    }
                }
            });
        }

        //全选
        function product_all(obj) {
            $(".product_select").prop("checked", $(obj).prop("checked"));
            var checkbox = $("input[name=\'id[]\']:checked");//被选中的复选框对象
            var checkbox1 = $("input[name=\'id[]\']");//被选中的复选框对象
            var Id_1 = \'\'; // 复选框选中的值
            var Id_2 = \'\'; // 复选框的值
            if(Id == \'\'){ // 当ID字符串为空时，添加商品ID
                for (var i = 0; i < checkbox.length; i++) {
                    Id += checkbox.eq(i).val() + ",";
                }
                Id = Id.substring(0,Id.length-1);
            }else{ // 当ID字符串不为空时
                for (var i = 0; i < checkbox.length; i++) {
                    Id_1 += checkbox.eq(i).val() + ",";
                }
                Id_1 = Id_1.substring(0,Id_1.length-1); // 复选框选中的值

                for (var i = 0; i < checkbox1.length; i++) {
                    Id_2 += checkbox1.eq(i).val() + ",";
                }
                Id_2 = Id_2.substring(0,Id_2.length-1);  // 复选框的值
                if(Id_1 == \'\'){ // 复选框没有选中的值
                    var a1 = Id.split(\',\'); // ID字符串转数组
                    var a2 = Id_2.split(\',\'); // 复选框字符串转数组
                    for (var i = 0; i < a2.length; i++) {
                        a1.splice($.inArray(a2[i],a1),1); // 删除数组中指定元素
                    }
                    Id = a1.join(\',\');
                }else{  // 复选框有选中的值
                    Id += \',\';
                    for (var i = 0; i < checkbox.length; i++) {
                        Id += checkbox.eq(i).val() + ",";
                    }
                    Id = Id.substring(0,Id.length-1);
                }
            }
            if(Id != \'\'){
                var a = Id.split(\',\');
                var temp = []; // 一个新的临时数组
                for(var i = 0; i < a.length; i++){
                    if(temp.indexOf(a[i]) == -1){
                        if(a[i] != \'\' && a[i] != \'null\' && a[i] != null){
                            temp.push(a[i]);
                        }
                    }
                }
                Id = temp.join(\',\');
            }
            localStorage.setItem("id_list"+store_id,Id);
            id_list(Id)
        }

        var aa = $(".page_absolute").height() - $(".btnDiv").height() - $(".text_c").height() - 16;
        var bb = $(".table-border").height();
        if (aa < bb) {
            $(".page_h20").css("display", "block")
        } else {
            $(".page_h20").css("display", "none")
            $(".tab_footer").addClass("table_footer")
            $(".paginationDiv").css("padding", "25px 0")
        }

        function pimg(obj) {
            var _this = $(obj);//将当前的pimg元素作为_this传入函数
            imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
        }

        function imgShow(outerdiv, innerdiv, bigimg, _this) {
            var src = _this.attr("src");//获取当前点击的pimg元素中的src属性
            $(bigimg).attr("src", src);//设置#bigimg元素的src属性

            /*获取当前点击图片的真实大小，并显示弹出层及大图*/
            $("<img/>").attr("src", src).load(function () {
                var windowW = $(window).width();//获取当前窗口宽度
                var windowH = $(window).height();//获取当前窗口高度
                var realWidth = this.width;//获取图片真实宽度
                var realHeight = this.height;//获取图片真实高度
                var imgWidth, imgHeight;
                var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放

                if (realHeight > windowH * scale) {//判断图片高度
                    imgHeight = windowH * scale;//如大于窗口高度，图片高度进行缩放
                    imgWidth = imgHeight / realHeight * realWidth;//等比例缩放宽度
                    if (imgWidth > windowW * scale) {//如宽度扔大于窗口宽度
                        imgWidth = windowW * scale;//再对宽度进行缩放
                    }
                } else if (realWidth > windowW * scale) {//如图片高度合适，判断图片宽度
                    imgWidth = windowW * scale;//如大于窗口宽度，图片宽度进行缩放
                    imgHeight = imgWidth / realWidth * realHeight;//等比例缩放高度
                } else {//如果图片真实高度和宽度都符合要求，高宽不变
                    imgWidth = realWidth;
                    imgHeight = realHeight;
                }
                $(bigimg).css("width", imgWidth);//以最终的宽度对图片缩放

                var w = (windowW - imgWidth) / 2;//计算图片与窗口左边距
                var h = (windowH - imgHeight) / 2;//计算图片与窗口上边距
                $(innerdiv).css({"top": h, "left": w});//设置#innerdiv的top和left属性
                $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg
            });

            $(outerdiv).click(function () {//再次点击淡出消失弹出层
                $(this).fadeOut("fast");
            });
        }

        /*删除*/
        function del(id, url) {
            confirm("确认删除此商品吗？", id, url,del_str, \'删除\');
        }

        function aj(id) {
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: \'index.php?module=product&action=Shelves&id=\'+id,
                data: {},
                async: true,
                success: function (res) {
                    if (res.status == "1") {
                        $.get("index.php?module=product&action=Shelves", {\'id\': id}, function (res) {
                            $(".maskNew").remove();
                            if (res.status == 1) {
                                layer.msg(res.info);
                                intervalId = setInterval(function () {
                                    clearInterval(intervalId);
                                    location.replace(location.href);
                                }, 2000);

                            }else {
                                layer.msg(res.info);
                            }
                        }, "json");
                    }else if (res.status == 2) {
                        layer.msg(\'该商品有参与插件活动，无法下架！\');
                    }else if (res.status == 3) {
                        layer.msg(\'该商品有未完成的订单，无法下架！\');
                    }else if (res.status == 4) {
                        layer.msg(\'请先去完善商品信息！\');
                    } else {
                        layer.msg("修改失败！");
                    }
                }
            });
        }

        /*批量删除*/
        function datadel(url, content) {
            var checkbox = $("input[name=\'id[]\']:checked");//被选中的复选框对象
            var Id = \'\';
            for (var i = 0; i < checkbox.length; i++) {
                Id += checkbox.eq(i).val() + ",";
            }
            if (Id == "") {
                layer.msg("未选择数据！");
                return false;
            }
            confirm(\'确认要删除吗？\', Id, url,del_str, content)
        }

        /*批量操作*/
        function operation(type, url) {
            if (Id == "" || Id == null) {
                layer.msg("未选择数据！");
                return false;
            }

            var nums = "";
            var btn_up = $(".btn_up span").text();
            var btn_xp = $(".btn_xp span").text();
            var btn_rx = $(".btn_rx span").text();
            var btn_tj = $(".btn_tj span").text();
            if(type == 1 &&btn_up == "商品下架"){
                type = 2;
            }else if(type == 3 && btn_xp == "取消新品"){
                type = 4;
            }else if(type == 5 && btn_rx == "取消热销"){
                type = 6;
            }else if(type == 7 && btn_tj == "取消推荐"){
                type = 8;
            }
            confirm2("确认修改吗？", Id, type, url);
        }
        /*复选框*/
        function onshelves(obj) {
            if(Id){
                var a = Id.split(\',\');
                if(in_array(obj,a)){
                    for(let i=0;i<a.length;i++){
                        if(a[i]==obj){
                            a.splice(i,1);
                            break;//该行代码变成i--,则移除所有2
                        }
                    }
                    Id = a.join(\',\');
                }else{
                    Id += \',\' + obj;
                }
            }else{
                Id += obj;
            }
            localStorage.setItem("id_list"+store_id,Id);
            id_list(Id)
        }
        // 检查字符串是否存在数组中
        function in_array(stringToSearch, arrayToSearch) {
            for (s = 0; s < arrayToSearch.length; s++) {
                thisEntry = arrayToSearch[s].toString();
                if (thisEntry == stringToSearch) {
                    return true;
                }
            }
            return false;
        }
        // 根据复选框ID字符串，查询改变商品状态和标签
        function id_list(obj) {
            localStorage.setItem("id_list"+store_id,Id);
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: \'index.php?module=product&id_list=\'+obj,
                data: {},
                async: true,
                success: function (data) {
                    if (data.status == true){
                        $(".btn_up span").text("商品上架")
                        $(".btn_up img").attr(\'src\', \'images/icon1/sj.png\')
                    } else {
                        $(".btn_up span").text("商品下架")
                        $(".btn_up img").attr(\'src\', \'images/icon1/xj1.png\')
                    }
                    if (data.xp == true){
                        $(".btn_xp span").text("设为新品")
                    } else {
                        $(".btn_xp span").text("取消新品")
                    }
                    if (data.rx == true){
                        $(".btn_rx span").text("设为热销")
                    } else {
                        $(".btn_rx span").text("取消热销")
                    }
                    if (data.tj == true){
                        $(".btn_tj span").text("设为推荐")
                    } else {
                        $(".btn_tj span").text("取消推荐")
                    }

                    var $sel = $(".product_select");
                    if(obj){
                        var a = obj.split(\',\');
                        for (var i = 0; i < $sel.length; i++) {
                            if(in_array($sel[i].value,a)){
                                $("#"+$sel[i].value).prop("checked",true);
                            }else{
                                $("#"+$sel[i].value).prop("checked",false);
                            }
                        }
                    }
                }
            });
        }

        function confirm(content, id, url,del_str, content1) {
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
                            <button class="closeMask" style="margin-right:20px" onclick=closeMaskPP(\'${id}\',\'${url}\',\'${del_str}\',\'${content1}\')>确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        }

        function confirm2(content, id, type, url) {
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
                            <button class="closeMask" style="margin-right:20px" onclick=closeMask3(\'${id}\',\'${type}\',\'${url}\') >确认</button>
                            <button class="closeMask" onclick=closeMask1() >取消</button>
                        </div>
                    </div>
                </div>
            `)
        }

        document.onkeydown = function (e) {
            if (!e) e = window.event;
            if ((e.keyCode || e.which) == 13) {
                $("[name=Submit]").click();
            }
        }
        // 置顶
        function on_top(id) {
            $.ajax({
                type: "POST",
                url: "index.php?module=product&action=Stick",
                data: {
                    id: id
                },
                success: function (msg) {
                    if (msg == 1) {
                        location.replace(location.href);
                    } else {
                        layer.msg(\'修改失败！\');
                    }
                }
            });
        }
        // 上移
        function move_upward(id,upper_id,underneath_id,upper_status) {
            $.ajax({
                type: "GET",
                url: "index.php?module=product&action=Stick",
                data: {
                    id: id,
                    upper_id: upper_id,
                    underneath_id: underneath_id,
                    upper_status: upper_status,
                },
                success: function (msg) {
                    if (msg == 1) {
                        layer.msg(\'修改成功！\');
                        location.replace(location.href);
                    } else {
                        layer.msg(\'修改失败！\');
                    }
                }
            });
        }

        // 点击分类框
        var selectFlag = true  //判断点击分类框请求有没有完成,没完成继续点击不会再次请求
        var choose_class = true  //判断选择分类请求有没有完成,没完成继续点击不会再次请求
        function select_class(){
            var class_str = $(\'.selectDiv option\').val()
            var brand_str = $("#brand_class option:selected").val();
            if($(\'#selectData\').css(\'display\')==\'none\'){
                $(\'#selectData\').css(\'display\',\'flex\')

                if(selectFlag&&choose_class){
                    selectFlag=false
                    $.ajax({
                        type: "GET",
                        url: \'index.php?module=product&action=Ajax\',
                        data: {
                            \'class_str\':class_str,
                            \'brand_str\':brand_str
                        },
                        success: function (msg) {
                            $(\'#brand_class\').empty()
                            $(\'#selectData_1\').empty()
                            obj = JSON.parse(msg)
                            var brand_list = obj.brand_list
                            var class_list = obj.class_list
                            var rew = \'\';
                            if(class_list.length != 0){
                                var num = class_list.length-1;
                                display(class_list[num])
                            }

                            for(var i=0;i<brand_list.length;i++){
                                if(brand_list[i].status == true){
                                    rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                                }else{
                                    rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                                }
                            }
                            $(\'#brand_class\').append(rew)
                        },
                        complete(XHR, TS){
                            // 无论请求成功还是失败,都要把判断条件改回去
                            selectFlag=true
                        }
                    });
                }
            }else{
                $(\'#selectData\').css(\'display\',\'none\')
            }
        }
        // 选择分类
        function class_level(obj,level,cid,type){
            var text = obj.innerHTML
            var text_num = $(\'.selectDiv>div>p\').length

            $(\'.selectDiv option\').text(\'\').attr(\'value\',cid)

            $(obj).addClass(\'active\').siblings().removeClass(\'active\')
            var brand_str = $("#brand_class option:selected").val();
            // 给当前元素添加class，清除同级别class
            // 获取ul标签数量
            var num = $("#selectData ul").length;
            if(selectFlag&&choose_class){
                choose_class=false
                $.ajax({
                    type: "POST",
                    url: \'index.php?module=product&action=Ajax\',
                    data: {
                        "cid":cid,
                        "brand_str":brand_str,
                    },
                    success: function (msg) {
                        $(\'#brand_class\').empty()
                        $(\'#selectData_1\').empty()
                        res = JSON.parse(msg)
                        var class_list = res.class_list
                        var brand_list = res.brand_list
                        var rew = \'\';
                        var html = $(\'.selectDiv>div\').html().replace(/^\\s*|\\s*$/g,"");// 去除字符串内两头的空格

                        if(type == \'\'){
                            if(text_num - 2 == level){
                                var text_num1 = text_num - 1;
                                var parent=document.getElementById("div_text");
                                var son0=document.getElementById("p"+text_num);
                                var son1=document.getElementById("p"+text_num1);
                                parent.removeChild(son0);
                                parent.removeChild(son1);
                                if(class_list.length == 0){ // 该分类没有下级
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'></p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num1}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id=\'p${text_num1+1}\' onclick=\'del_sel(this)\'></p>`
                                    }
                                    $(\'#selectData\').css(\'display\',\'none\')
                                }else{
                                    display(class_list[0])
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num1}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id="p${text_num1+1}" onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }
                                }
                            }else{
                                if(class_list.length == 0){ // 该分类没有下级
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'></p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id=\'p${text_num+1}\' onclick=\'del_sel(this)\'></p>`
                                    }
                                    $(\'#selectData\').css(\'display\',\'none\')
                                }else{
                                    display(class_list[0])
                                    if(html==\'\'){
                                        str=`<p class=\'selectItem\' id=\'p1\' tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'>${text}</p><p class=\'selectItem del_sel\' id=\'p2\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }else{
                                        $(\'.del_sel\').remove()
                                        str=`<p class=\'selectItem\' id="p${text_num}" tyid=\'${cid}\' onclick=\'del_sel(this,${level},${cid})\'><span>&gt;</span>${text}</p><p class=\'selectItem del_sel\' id="p${text_num+1}" onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`
                                    }
                                }
                            }
                            $(\'.selectDiv>div\').append(str)
                        }else{
                            display(class_list[0])
                        }

                        for(var i=0;i<brand_list.length;i++){
                            if(brand_list[i].status == true){
                                rew += `<option selected value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                            }else{
                                rew += `<option value="${brand_list[i].brand_id}">${brand_list[i].brand_name}</option>`;
                            }
                        }
                        $(\'#brand_class\').append(rew)
                    },
                    complete(XHR, TS){
                        // 无论请求成功还是失败,都要把判断条件改回去
                        choose_class=true
                    }
                });
            }
        }
        // 显示分类
        function display(class_list) {
            var res = \'\';
            for(var i=0;i<class_list.length;i++){
                if(class_list[i].status == true){
                    res += `<li class=\'active\' value=\'${class_list[i].cid}\' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},\'\')">${class_list[i].pname}</li>`;
                    continue
                }
                res += `<li value=\'${class_list[i].cid}\' onclick="class_level(this,${class_list[i].level},${class_list[i].cid},\'\')">${class_list[i].pname}</li>`;
            }
            $(\'#selectData_1\').append(res)
        }
        // 删除选中的类别
        function del_sel(me,level,cid){
            if(cid){
                if(level == 0){
                    var cid1 = 0;
                    class_level(me,level,cid1,\'type\')
                }else{
                    var cid1 = $(\'#p\'+level).eq(0).attr(\'tyid\');
                    class_level(me,level-1,cid1,\'type\')
                }
                $(me).nextAll().remove()
                $(me).remove()
                if($(\'.selectDiv>div\').html()==\'\'){
                    $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',0)
                }else{
                    if(cid1 == 0){
                        $(\'.selectDiv option\').text(\'请选择商品类别\').attr(\'value\',cid1)
                    }else{
                        $(\'.selectDiv option\').text(\'\').attr(\'value\',cid1)
                        $(\'.selectDiv>div\').append(`<p class=\'selectItem del_sel\' onclick=\'del_sel(this)\'><span>&gt;</span>请选择</p>`)
                    }
                }
                if(level){
                    event.stopPropagation()
                }
            }
        }

        function select_pinpai(){
            var class_str = $("[name=product_class]").val();
            if(class_str == \'\' || class_str <= 0){
                layer.msg("请先选择商品类别！", {
                    time: 2000
                });
            }
        }
    </script>
'; ?>

</body>
</html>