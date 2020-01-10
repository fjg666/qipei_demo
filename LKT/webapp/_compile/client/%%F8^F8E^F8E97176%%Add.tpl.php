<?php /* Smarty version 2.6.31, created on 2019-12-20 15:42:28
         compiled from Add.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "DIY头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<link href="https://www.layuicdn.com/layui/css/layui.css" rel="stylesheet" type="text/css" />
<style>
#form1{
	padding: 40px 60px;
}
#form1>div{
	display: flex;align-items: center;
	margin-bottom: 15px;
}
.must{
	color: #FF453D;
	margin-right: 5px;
}
.ipt_name{
	width: 530px;height: 36px;border: 1px solid #D5DBE8;border-radius:2px;
}
.leftText{
	font-size: 14px;
	color: #414658;
	margin-right: 8px;
}
.layui-form-checked[lay-skin=primary] i{
	border-color: #2890FF!important;
	background-color: #2890FF;
}
.layui-form-checkbox[lay-skin=primary]:hover i{
	border-color: #2890FF!important;
}
.layui-tree-iconClick .layui-icon-file{
	font-size: 0;
}
.border_0,.border_50{
	width: auto;
}
.border_0::before,.border_0::after{
	border: 0!important;
}
.border_50::before{
	height: 50%!important;
}
.layui-tree-lineExtend::after{
	content: \'\';
	display: block;
	clear: both;
}
#test12{
	flex: 1;
}
#form1 .bindQ{
    align-items: flex-start;
}
#form1 .leftText{
    height: 36px;
    line-height: 36px;
}
</style>
'; ?>

<body class="iframe-container">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="iframe-table form-scroll">
	<div class="page_title">添加角色</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <div>
			<div class="leftText"><span class="must">*</span>角色名称：</div>
			<input class="ipt_name" name="name" type="text" id="name">
		</div>
		<div class="bindQ">
			<div class="leftText"><span class="must">*</span>绑定权限：</div>
			<div id="test12" class="demo-tree-more"></div>
		</div>
    </form>
	<div style="height: 70px;"></div>
	<div class="page_h10 page_bort">
		<input type="button" name="Submit" value="保存" class="fo_btn2 btn-right" lay-demo="getChecked">
		<input type="button" name="reset" value="取消" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script type="text/javascript" src="https://www.layuicdn.com/layui/layui.js"></script>
<script>
'; ?>

var list = <?php echo $this->_tpl_vars['list']; ?>
;
<?php echo '

layui.use([\'tree\', \'util\'], function(){

    var tree = layui.tree,layer = layui.layer,util = layui.util
  
    //模拟数据 title节点标题  id节点唯一索引值，用于对指定节点进行各类操作 field	节点字段名  children	子节点
    // spread	节点是否初始展开，默认 false  checked	节点是否初始为选中状态,默认 false  disabled	节点是否为禁用状态。默认 false
    var data = JSON.parse(JSON.stringify(list))

    //基本演示
    tree.render({
        elem: \'#test12\'
        ,data: data
        ,showCheckbox: true  //是否显示复选框
        ,id: \'demoId1\'
        ,isJump: false ,//是否允许点击节点时弹出新窗口跳转
        edit:false
        ,click: function(obj){  //点击时的反应

        }
    });
  
    //按钮事件
    util.event(\'lay-demo\', {
        getChecked: function(othis){
            var checkedData = tree.getChecked(\'demoId1\'); //获取选中节点的数据
            var name = $("#name").val();
            var id_list = []
            for (var k in checkedData){
                var checkedData1 = checkedData[k];
                for (var k1 in checkedData1.children) {
                    id_list.push(checkedData1.children[k1][\'id\']);
                    var checkedData2 = checkedData1.children[k1];
                    if(checkedData2.children){
                        for (var k2 in checkedData2.children) {
                            id_list.push(checkedData2.children[k2][\'id\']);
                            var checkedData3 = checkedData2.children[k2];
                            if(checkedData3.children){
                                for (var k3 in checkedData3.children) {
                                    id_list.push(checkedData3.children[k3][\'id\']);
                                    var checkedData4 = checkedData3.children[k3];
                                    if(checkedData4.children){
                                        for (var k4 in checkedData4.children) {
                                            id_list.push(checkedData4.children[k4][\'id\']);
                                            var checkedData5 = checkedData4.children[k4];
                                            if(checkedData5.children){
                                                for (var k5 in checkedData5.children) {
                                                    id_list.push(checkedData5.children[k5][\'id\']);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $.ajax({
                cache: true,
                type: "POST",
                dataType: "json",
                url: \'index.php?module=client&action=Add\',
                data: {
                    name:name,
                    id_list:id_list,
                },
                async: true,
                success: function (data) {
                    layer.msg(data.status, {time: 2000});
                    if (data.suc) {
                        location.href = "index.php?module=client";
                    }
                }
            });
        }
    });
});

</script>
'; ?>

</body>
</html>