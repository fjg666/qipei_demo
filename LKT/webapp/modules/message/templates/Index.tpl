{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style>
td a{
    width: 29%;
    margin: 1.5%!important;
    float: left;
}
.btn1{
    width: 80px;
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
</style>
{/literal}
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">

    <div class="swivch page_bgcolor swivch_bot">
        <a href="index.php?module=message" class="btn1 active swivch_active">短信列表</a>
        {if $button[0] == 1}
            <a href="index.php?module=message&action=List" class="btn1 " style="border-right: 1px solid #ddd!important;">短信模板</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=message&action=Config" class="btn1 " style="border-right: 1px solid #ddd!important;">核心设置</a>
        {/if}
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>

    <div class="page_h16"></div>

    {if $store_type == 0}
        <div style="clear:both;" class="page_bgcolor">
            <a class="btn newBtn radius" href="index.php?module=message&action=Add"><img src="images/icon1/add.png"/>&nbsp;添加</a>
        </div>
    {/if}
    <div class="page_h16"></div>
    <div class="tab_table table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">ID</th>
                    <th width="150px">短信模板名称</th>
                    <th width="100px">类型</th>
                    <th>内容</th>
                    <th class="tab_time">修改时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$item->id}</td>
                    <td>{$item->name}</td>
                    <td>{if $item->type == 0}验证码{elseif $item->type == 1}短信消息{/if}</td>
                    <td>{$item->content}</td>
                    <td class="tab_time">{$item->add_time}</td>
                    <td class="tab_editor">
                        {if $button[3] == 1}
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=message&action=Modify&id={$item->id}" title="编辑" >
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        {/if}
                        {if $button[4] == 1}
                            <a title="删除" href="javascript:;" onclick="confirm('确定要删除短信模板么？',{$item->id},'index.php?module=message&action=Del&id=')" class="ml-5" style="text-decoration:none">
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class='tb-tab' style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-42-16-36-16-($('.tb-tab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')

function confirm (content,id,url){
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask_role("${id}","${url}","删除") >确认</button>
                    <button class="closeMask" onclick=closeMask1() >取消</button>
                </div>
            </div>
        </div>
    `)
}
</script>
{/literal}
</body>
</html>