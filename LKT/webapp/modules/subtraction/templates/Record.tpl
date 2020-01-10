{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
    <style type="text/css">
        .row .form-label{
            width: 14%!important;
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
        .btn1{
             width: 112px;
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
{/literal}
</head>
<body>
<nav class="breadcrumb page_bgcolor" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    满减
    <span class="c-gray en">&gt;</span>
    满减活动列表
</nav>
<div class="pd-20 page_absolute">
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="subtraction" />
            <input type="hidden" name="action" value="Record" />
            <input type="hidden" name="id" value="{$id}" />
            <input type="text" name="sNo" size='8' id="sNo" value="{$sNo}" id="" placeholder="请输入订单编号" style="width:180px" class="input-text">
            <input type="text" name="user_id" size='8' id="user_id" value="{$user_id}" id="" placeholder="请输入会员编号" style="width:180px" class="input-text">

            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

            <input name="" id="" class="btn btn-success" type="submit" value="查询" >
        </form>
    </div>
    <div class="page_h16"></div>

    <div class="mt-20">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th style="width:15%;">活动名称</th>
                    <th style="width:15%;">活动内容</th>
                    <th>订单编号</th>
                    <th>时间</th>
                    <th>会员编号</th>
                    <th class="tab_three">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td>{$item->name}</td>
                    <td>{$item->name}</td>
                    <td>{$item->sNo}</td>
                    <td>{$item->add_date}</td>
                    <td>{$item->user_id}</td>
                    <td class="tab_three" style="width: 24%;">
                        <div class="tab_block">
                            <a onclick="confirm('确认要删除吗？',{$item->id},'index.php?module=subtraction&action=Subtraction_del&id=','删除')">
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_20"></div>
</div>

{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
    var aa = $(".pd-20").height() - 36 - 16;
    var bb = $(".table-border").height();
    if (aa < bb) {
        $(".page_h20").css("display", "block")
    } else {
        $(".page_h20").css("display", "none")
    }

    function empty() {
        $("#sNo").val('');
        $("#user_id").val('');
    }

    function confirm(content, id, url, content1) {
        $("body", parent.document).append(`
            <div class="maskNew">
                <div class="maskNewContent" style="padding: 50px 0;display:flex;justify-content:center;align-items:center;flex-wrap:wrap;">
                    <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;width:100%">
                        ${content}
                    </div>
                    <div style="text-align:center;">
                        <button class="closeMask" onclick=closeMask1() style="background: #fff;color: #008DEF;border: 1px solid #008DEF;margin-right: 4px;">取消</button>
                        <button class="closeMask" style="background: #008DEF;color: #fff;border: 1px solid #008DEF;" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
                    </div>
                </div>
            </div>
        `)
    }
</script>
{/literal}
</body>
</html>