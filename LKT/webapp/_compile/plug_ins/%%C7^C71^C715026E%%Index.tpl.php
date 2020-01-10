<?php /* Smarty version 2.6.31, created on 2019-12-24 12:16:47
         compiled from Index.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
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
.tab_editor_center{width: 122px;margin: 0 auto;}
.tab_editor_center>a{
    display: flex;
    justify-content: center;
    align-items: center;
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
    <div style="clear:both;" class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=plug_ins&action=Add"><img style="margin-right: 2px!important;height: 14px;" src="images/icon1/add.png"/>&nbsp;添加插件</a>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll" style="background: #fff;height: 82vh;">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序号</th>
                    <th>插件名称</th>
                    <th class="tab_time">发布时间</th>
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
                    <td><?php echo $this->_tpl_vars['item']->name; ?>
</td>
                    <td class="tab_time"><?php echo $this->_tpl_vars['item']->add_time; ?>
</td>
                    <td class="tab_editor">
                        <div class="tab_editor_center">
							<a style="text-decoration:none;" class="ml-5" href="index.php?module=plug_ins&action=Modify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑" >
							    <div style="align-items: center;font-size: 12px;display: flex;">
							        <div style="margin:0 auto;;display: flex;align-items: center;"> 
							        <img src="images/icon1/xg.png" style="margin-top: 0;"/>&nbsp;编辑
							        </div>
							    </div>
							</a>
							<a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要删除此插件吗?',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=plug_ins&action=Del&id=','删除')">
							    <div style="align-items: center;font-size: 12px;display: flex;">
							        <div style="margin:0 auto;;display: flex;align-items: center;"> 
							        <img src="images/icon1/del.png" style="margin-top: 0;"/>&nbsp;删除
							        </div>
							    </div>
							</a>
							<?php if ($this->_tpl_vars['item']->name == '店铺'): ?>
							    <a style="text-decoration:none" class="ml-5" href="index.php?module=plug_ins&action=Role&id=8" title="权限" >
							        <div style="align-items: center;font-size: 12px;display: flex;">
							            <div style="margin:0 auto;;display: flex;align-items: center;">
							                <img src="images/icon1/xg.png" style="margin-top: 0;"/>&nbsp;权限
							            </div>
							        </div>
							    </a>
							<?php endif; ?>
						</div>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
        
    </div>
	<div class="tbtab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div> 

<script type="text/javascript" src="style/js/layer/layer.js"></script> 
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="style/js/H-ui.js"></script> 

<?php echo '
<script type="text/javascript">
$(function(){  
    $(".pimg").click(function(){
        var _this = $(this);//将当前的pimg元素作为_this传入函数
        imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
    });

    // 根据框架可视高度,减去现有元素高度,得出表格高度
    var Vheight = $(window).height()-56-36-16-($(\'.tbtab\').text()?70:0)
    $(\'.table-scroll\').css(\'height\',Vheight+\'px\')
});

function imgShow(outerdiv, innerdiv, bigimg, _this){  
    var src = _this.attr("src");//获取当前点击的pimg元素中的src属性  
    $(bigimg).attr("src", src);//设置#bigimg元素的src属性  
  
        /*获取当前点击图片的真实大小，并显示弹出层及大图*/  
    $("<img/>").attr("src", src).load(function(){  
        var windowW = $(window).width();//获取当前窗口宽度  
        var windowH = $(window).height();//获取当前窗口高度  
        var realWidth = this.width;//获取图片真实宽度  
        var realHeight = this.height;//获取图片真实高度  
        var imgWidth, imgHeight;  
        var scale = 0.8;//缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放  
          
        if(realHeight>windowH*scale) {//判断图片高度  
            imgHeight = windowH*scale;//如大于窗口高度，图片高度进行缩放  
            imgWidth = imgHeight/realHeight*realWidth;//等比例缩放宽度  
            if(imgWidth>windowW*scale) {//如宽度扔大于窗口宽度  
                imgWidth = windowW*scale;//再对宽度进行缩放  
            }  
        } else if(realWidth>windowW*scale) {//如图片高度合适，判断图片宽度  
            imgWidth = windowW*scale;//如大于窗口宽度，图片宽度进行缩放  
                        imgHeight = imgWidth/realWidth*realHeight;//等比例缩放高度  
        } else {//如果图片真实高度和宽度都符合要求，高宽不变  
            imgWidth = realWidth;  
            imgHeight = realHeight;  
        }  
                $(bigimg).css("width",imgWidth);//以最终的宽度对图片缩放  
          
        var w = (windowW-imgWidth)/2;//计算图片与窗口左边距  
        var h = (windowH-imgHeight)/2;//计算图片与窗口上边距  
        $(innerdiv).css({"top":h, "left":w});//设置#innerdiv的top和left属性  
        $(outerdiv).fadeIn("fast");//淡入显示#outerdiv及.pimg  
    });  
      
    $(outerdiv).click(function(){//再次点击淡出消失弹出层  
        $(this).fadeOut("fast");  
    });  
}
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
                    <button class="closeMask" onclick=closeMask1()>取消</button>
                </div>
            </div>
        </div>
    `)
}
</script>
'; ?>

</body>
</html>