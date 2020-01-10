<?php /* Smarty version 2.6.31, created on 2019-12-20 16:09:27
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

<?php echo '
<style type="text/css">
td a {
    width: 28%;
    float: left;
    margin: 2% !important;
}
.stopCss:hover {
    cursor: not-allowed;
}
.stopCss {
    width: 88px;
    height: 20px;
    border: 1px solid #e9ecef;
    color: #d8dbe8 !important;
    font-size: 12px;
    border-radius: 2px;
    line-height: 20px;
    display: inline-block;
    margin-left: -2%;
    margin-bottom
}
</style>
'; ?>

<body style="background: #edf1f5;">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="pd-20 page_absolute">
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="product_class"/>
            <input type="text" name="pname" size='8' id="pname" value="<?php echo $this->_tpl_vars['pname']; ?>
" placeholder="分类名称" class="input-text" style="width: 200px;">
            <input name="" id="btn9" class="btn " type="submit" value="查询">
            <input id="btn9" class="btn " type="button" value="导出" onclick="export_popup1('index.php?module=product_class&action=Index&cid=<?php echo $this->_tpl_vars['cid']; ?>
','por_class')" style="float: right;background: #008DEF;color: #fff">
        </form>
        <input type="hidden" id="superCid" value="<?php echo $this->_tpl_vars['cid']; ?>
"/>
    </div>
    <div class="page_h16"></div>
    <div style="clear:both;background-color: #edf1f5;">
        <input type="hidden" name="cid" id="cid" value="<?php echo $this->_tpl_vars['cid']; ?>
">
        <button class="btn newBtn radius" id="syj" onclick="location.href='index.php?module=product_class&action=Index&cid=<?php echo $this->_tpl_vars['cid']; ?>
&m=tc';" <?php if (! $this->_tpl_vars['level']): ?> style="display: none;"<?php endif; ?>>
            <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                <img src="images/icon1/sj.png"/>&nbsp;返回上一级
            </div>
        </button>
        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
            <?php if (! $this->_tpl_vars['level']): ?>
                <button type="button" class="btn newBtn radius" onclick="location.href='index.php?module=product_class&action=Add';">
                    <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                        <img src="images/icon1/add.png"/>&nbsp;新增分类
                    </div>
                </button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">分类ID</th>
                    <th class="tab_imgurl">分类图片</th>
                    <th>分类名称</th>
                    <th>分类级别</th>
                    <th>添加时间</th>
                    <th class="tab_five">操作</th>
                </tr>
            </thead>
            <tbody id="tbody">
            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                <tr class="text-c tab_td">
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->cid; ?>
</td>
                    <td class="tab_imgurl">
                        <?php if ($this->_tpl_vars['item']->img != ''): ?>
                            <image class="pimg" src="<?php echo $this->_tpl_vars['item']->img; ?>
"/>
                        <?php else: ?>
                            <span>暂无图片</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $this->_tpl_vars['item']->pname; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->level; ?>
</td>
                    <td><?php echo $this->_tpl_vars['item']->add_date; ?>
</td>
                    <td class="tab_five" style="width: 200px;">
                        <?php if ($this->_tpl_vars['button'][3] == 1): ?>
                            <a onclick="on_top(this,'<?php echo $this->_tpl_vars['item']->cid; ?>
','<?php echo $this->_tpl_vars['item']->sid; ?>
')" <?php if ($this->_tpl_vars['button'][3] != 1): ?>class="stopCss"<?php endif; ?>>
                                <img src="images/icon1/zd.png"/>&nbsp;置顶
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['button'][1] == 1): ?>
                            <a href="index.php?module=product_class&action=Modify&cid=<?php echo $this->_tpl_vars['item']->cid; ?>
" title="编辑" <?php if ($this->_tpl_vars['button'][1] != 1): ?>class="stopCss"<?php endif; ?>>
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                            <a onclick="del(this,'<?php echo $this->_tpl_vars['item']->cid; ?>
','<?php echo $this->_tpl_vars['item']->status; ?>
')" <?php if ($this->_tpl_vars['button'][2] != 1): ?>class="stopCss"<?php endif; ?>>
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['level'] < $this->_tpl_vars['level_num']): ?>
                            <a href="index.php?module=product_class&action=Index&cid=<?php echo $this->_tpl_vars['item']->cid; ?>
" title="查看该分类的下级" >
                                <img src="images/icon1/ck.png"/>&nbsp;查看下级
                            </a>
                            <?php if ($this->_tpl_vars['button'][0] == 1): ?>
                                <a href="index.php?module=product_class&action=Add&cid=<?php echo $this->_tpl_vars['item']->cid; ?>
&superCid=<?php echo $this->_tpl_vars['cid']; ?>
" title="在此分类下添加" <?php if ($this->_tpl_vars['button'][0] != 1): ?>class="stopCss"<?php endif; ?>>
                                    <img src="images/icon1/add_g.png"/>&nbsp;添加分类
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                </form>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:9999;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
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
;//json对象
<?php echo '
//删除商品，页面跳转字段
del_str = JSON.stringify(del_str);//json字符串
$(function () {
    $(".pimg").click(function () {
        var _this = $(this);//将当前的pimg元素作为_this传入函数
        imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
    });

    // 根据框架可视高度,减去现有元素高度,得出表格高度
    var Vheight = $(window).height()-56-56-16-36-16-($(\'.tb-tab\').text()?70:0)
    $(\'.table-scroll\').css(\'height\',Vheight+\'px\')
});
// 置顶
function on_top(obj, cid, sid) {
    $.ajax({
        type: "POST",
        url: "index.php?module=product_class&action=Stick",
        data: {
            cid: cid,
            sid: sid
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
function del(obj, id, status) {
    if (status == 1) {
        layer.msg(\'该分类有商品,不能删除!\');
    } else {
        confirm("是否删除此分类？", id, \'index.php?module=product_class&action=Del&cid=\',del_str, \'删除\');
    }
}

function confirm(content, id, url,del_str, content1) {
    $("body", parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="height: 223px!important;">
                <div style="position: relative;top:59px;font-size: 22px;text-align: center;color: #414658;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:100px;">
                    <button class="closeMask" style="margin-right:3px;background: #fff;border: 1px solid #008DEF;color: #008DEF;" onclick=closeMask1() >取消</button>
                    <button class="closeMask" style="background: #008DEF;border: 1px solid #eee;color: #fff;" onclick=closeMaskPC(\'${id}\',\'${url}\',\'${del_str}\',\'${content1}\') >确认</button>
                </div>
            </div>
        </div>
    `)
}
</script>
'; ?>

</body>
</html>