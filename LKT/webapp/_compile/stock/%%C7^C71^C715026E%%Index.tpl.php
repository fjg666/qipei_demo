<?php /* Smarty version 2.6.31, created on 2019-12-30 14:10:26
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<title>库存列表</title>
<?php echo '
<style>
td a{
    width: 29%;
    float: left;
    margin: 2%!important;
}
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
</style>
'; ?>

</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="pd-20 page_absolute">
    <div class="swivch page_bgcolor swivch_bot">
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <a href="index.php?module=stock" class="btn1 swivch_active">库存列表</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][1] == 1): ?>
            <a href="index.php?module=stock&action=Warning" class="btn1 " >库存预警</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
            <a href="index.php?module=stock&action=Enter" class="btn1 " >入货详情</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['button'][3] == 1): ?>
            <a href="index.php?module=stock&action=Shipment" class="btn1 " >出货详情</a>
        <?php endif; ?>
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c text_c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="stock" />
            <input type="text" name="product_number" size='8' value="<?php echo $this->_tpl_vars['product_number']; ?>
" id="product_number" placeholder="请输入商品编码" style="width:200px" class="input-text" onfocus="this.placeholder=''" onblur="this.placeholder='请输入商品编码'">
            <input type="text" name="product_title" size='8' value="<?php echo $this->_tpl_vars['product_title']; ?>
" id="product_title" placeholder="请输入商品名称" style="width:200px" class="input-text" onfocus="this.placeholder=''" onblur="this.placeholder='请输入商品名称'">
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;border-radius: 5px;" class="reset" onclick="empty()" />

            <input name="" id="btn9" class="btn btn-success" type="submit" value="查询">
            <input id="btn1" class="btn btn-success" type="button" value="导出" onclick="excel(location.href)" style="float: right;">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序号</th>
                    <th >商品编码</th>
                    <th class="tab_title">商品名称</th>
                    <th >状态</th>
                    <th >售价</th>
                    <th>规格</th>
                    <th >总库存</th>
                    <th >剩余库存</th>
                    <th >所属店铺</th>
                    <th class="tab_time">上架时间</th>
                    <th class="tab_dat">操作</th>
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
                    <td><?php echo $this->_tpl_vars['item']->product_number; ?>
</td>
                    <td class="tab_title">
                        <div style="float: left;">
                            <img onclick="pimg(this)" src="<?php echo $this->_tpl_vars['item']->imgurl; ?>
" style="width: 60px;height: 60px;">
                        </div>
                        <div ><?php echo $this->_tpl_vars['item']->product_title; ?>
</div>
                    </td>
                    <td>
                        <!-- 0=待审核，1=审核通过，2=审核不通过 -->
                        <?php if ($this->_tpl_vars['item']->status == 2): ?>
                            <span >上架</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 3): ?>
                            <span >下架</span>
                        <?php elseif ($this->_tpl_vars['item']->status == 1): ?>
                            <span >待上架</span>
                        <?php endif; ?>
                    </td>
                    <td>￥<?php echo $this->_tpl_vars['item']->price; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->specifications; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->total_num; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->num; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->shop_name; ?>
</td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                    <td class="tab_dat">
                        <?php if ($this->_tpl_vars['button'][5] == 1): ?>
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=stock&action=See&id=<?php echo $this->_tpl_vars['item']->id; ?>
&pid=<?php echo $this->_tpl_vars['item']->pid; ?>
" title="库存详情" >
                                <img src="images/icon1/ck.png"/>&nbsp;库存详情
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['button'][4] == 1): ?>
                            <a style="text-decoration:none" class="ml-5" onclick="add('index.php?module=stock&action=Add','<?php echo $this->_tpl_vars['item']->id; ?>
','<?php echo $this->_tpl_vars['item']->pid; ?>
',1)" >
                                <img src="images/icon1/add_g.png"/>&nbsp;添加库存
                            </a>
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
$(function(){
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-46-16-16-($(\'.tb-tab\').text()?70:0)
	$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
});
function empty() {
    $("#product_number").val(\'\');
    $("#product_title").val(\'\');
}

function excel(url) {
    export_popup(url);
}
function add(url,id,pid,type) {
    $.ajax({
        type: "GET",
        url: url,
        data: {
            id: id,
            pid: pid
        },
        success: function (msg) {
            var res = JSON.parse(msg)
            $("body", parent.document).append(`
                <div class="maskNew">
                    <div class="maskNewContent" style="width: 540px;height: 331px !important;">
                        <a href="javascript:void(0);" class="closeA" onclick=closeMask1() style="display: block;"><img src="images/icon1/gb.png"/></a>
                        <div class="maskTitle" style="display: block;height:48px;line-height: 40px;padding-left: 19px;font-weight: bold;">添加库存</div>
                        <div style="position: relative;top:20px;font-size: 22px;">
                            <div class="">
                                <label class="maskLeft" style="padding-right: 8px;width: 21%;"><span class="c-red">*</span>增加库存：</label>
                                <div class="maskRight" style="">
                                    <input type="text" class="ipt1" value="" name="add_num" id="add_num" placeholder="请输入增加的库存量"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="">
                                <label class="maskLeft" style="padding-right: 8px;width: 21%;">总库存：</label>
                                <div class="maskRight" style="text-align: left;font-size: 14px;line-height: 36px;">
                                    <input type="hidden" class="ipt1" value="${res.total_num}" name="total_num" id="total_num" />
                                    ${res.total_num}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="">
                                <label class="maskLeft" style="padding-right: 8px;width: 21%;">剩余库存：</label>
                                <div class="maskRight" style="text-align: left;font-size: 14px;line-height: 36px;">
                                    <input type="hidden" class="ipt1" value="${res.num}" name="num" id="num" />
                                    ${res.num}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div style="text-align:right;margin-top:68px;">
                            <button class="closeMask" style="margin-right:4px;background: #fff;color: #008DEF;border: 1px solid #008DEF;" onclick=closeMask1() >取消</button>
                            <button class="closeMask" style="margin-right:20px;background: #008DEF;color: #fff;" onclick=stock_add(\'${url}\',\'${id}\',\'${pid}\',\'${type}\')>确认</button>
                        </div>
                    </div>
                </div>
            `)
        }
    });
}
</script>
'; ?>

</body>
</html>