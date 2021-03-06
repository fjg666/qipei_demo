{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style>
   	td a{
        width: 29%;
        margin: 1.5%!important;
        float: left;
    }
	.table-id{
		width:78px
	}
</style>
{/literal}
<body class='iframe-container'>
<nav class="nav-title">
	<span>权限管理</span>
    <span class='nav-to' onclick="javascript:history.back(-1);"><span class="arrows">&gt;</span>管理员列表</span>
</nav>
<div class="iframe-content">
    {if $store_type == 0}
        {if $button[0] == 1}
            <div style="clear:both;background-color: #edf1f5;">
                <button class="btn newBtn radius" onclick="location.href='index.php?module=member&action=Add';" >
                    <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
                        <img src="images/icon1/add.png"/>&nbsp;添加管理员
                    </div>
                </button>
            </div>
        {/if}
    {/if}
    <div class="page_h16"></div>
    <div class="iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class='table-id'>账户ID</th>
                    <th>账号</th>
                    <th>所属客户编号</th>
                    <th>绑定角色</th>
                    <th>添加人</th>
                    <th>添加时间</th>
                    <th class="tab_three">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$item->id}</td>
					<td>{$item->name}</td>
                    <td>{$customer_number}</td>
					<td>{$item->role_name}</td>
                    <td>{$item->admin_name}</td>
                    <td >{$item->add_date}</td>
                    <td class="tab_three">
                        {if $store_type == 0}
                            {if $button[1] == 1}
                                {if $item->status == 1}
                                    <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm1('确定要启用该管理员吗?',{$item->id},'启用','index.php?module=member&action=Status&id=')" title="启用" >
                                        <img src="images/icon1/qy.png"/>&nbsp;启用
                                    </a>
                                {elseif $item->status == 2}
                                    <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm1('确定要禁用该管理员吗?',{$item->id},'禁用','index.php?module=member&action=Status&id=')" title="禁用" >
                                        <img src="images/icon1/jy.png"/>&nbsp;禁用
                                    </a>
                                {/if}
                            {/if}
                            {if $button[2] == 1}
                                <a style="text-decoration:none" class="ml-5" href="index.php?module=member&action=Modify&id={$item->id}" title="编辑" >
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                </a>
                            {/if}
                            {if $button[3] == 1}
                                <a title="删除" href="javascript:;" onclick="confirm('确定要删除此管理员吗?',{$item->id},'index.php?module=member&action=Del&id=')" class="ml-5" style="text-decoration:none">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                            {/if}
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-36-16-($('.tb-tab').text()?70:0)
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

function confirm1 (content,id,content1,url){
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask2("${id}","${content1}","${url}") >确认</button>
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