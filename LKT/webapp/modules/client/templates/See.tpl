{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
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
            content: '';
            display: block;
            clear: both;
        }
        #test12{
            flex: 1;
        }
        #form1 .bindQ{
            align-items: flex-start;
        }
    </style>
{/literal}
<body class="iframe-container">
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="iframe-table form-scroll">
    <div class="page_title">查看角色</div>
    <form name="form1" id="form1" class="form form-horizontal" method="post" enctype="multipart/form-data">
        <input class="ipt_name" name="id" type="hidden" id="id" value="{$id}">
        <div>
            <div class="leftText"><span class="must">*</span>角色名称：</div>
            {$name}
        </div>
        <div class="bindQ">
            <div class="leftText"><span class="must">*</span>绑定权限：</div>
            <div id="test12" class="demo-tree-more"></div>
        </div>
    </form>
    <div style="height: 70px;"></div>
    <div class="page_h10 page_bort">
        <input type="button" name="reset" value="返回" class="fo_btn1 btn-left" onclick="javascript :history.back(-1);">
    </div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
    <script type="text/javascript" src="https://www.layuicdn.com/layui/layui.js"></script>
<script>
{/literal}
    var list = {$list};
{literal}
console.log(list)
    layui.use(['tree', 'util'], function(){

        var tree = layui.tree,layer = layui.layer,util = layui.util

        //模拟数据 title节点标题  id节点唯一索引值，用于对指定节点进行各类操作 field	节点字段名  children	子节点
        // spread	节点是否初始展开，默认 false  checked	节点是否初始为选中状态,默认 false  disabled	节点是否为禁用状态。默认 false
        var data = JSON.parse(JSON.stringify(list))

        //基本演示
        tree.render({
            elem: '#test12'
            ,data: data
            ,showCheckbox: true  //是否显示复选框
            ,id: 'demoId1'
            ,isJump: false ,//是否允许点击节点时弹出新窗口跳转
            edit:false
            ,click: function(obj){  //点击时的反应

            }
        });
    });

</script>
{/literal}
</body>
</html>
