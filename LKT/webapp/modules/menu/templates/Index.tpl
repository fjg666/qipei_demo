{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style>
td a {
    width: 44%;
    margin: 2% !important;
    float: left;
}
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="text-c text_c">
        <form name="form1" action="index.php" method="get" style="background: #fff;">
            <input type="hidden" name="module" value="menu"/>
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize"/>

            <input type="text" name="title" size='8' value="{$title}" id="title" placeholder="请输入菜单名称" style="width:200px" class="input-text">
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()"/>

            <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">

        </form>
    </div>
    <div class="page_h16"></div>
    <div class="page_bgcolor">
	    <a class="btn newBtn radius " onclick="location.href='index.php?module=menu&action=Add';">
	        <div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
	            <img src="images/icon1/add.png"/>&nbsp;添加菜单
	        </div>
	    </a>
	</div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">

        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr" >
                    <th style="width:100px">菜单ID</th>
                    <th>菜单名称</th>
                    <th style="width:100px">所属ID</th>
                    <th class="tab_time">添加时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item=item name=f1}
                    <tr class="text-c tab_tr">
                        <td style="text-align: left;padding-left:38px;">{$item->id_id}</td>
                        <td>{$item->title}</td>
                        <td style="text-align: left;padding-left:38px;">{$item->s_id}</td>
                        <td class="tab_time">{$item->add_time}</td>
                        <td class="tab_editor">
                            <a style="text-decoration:none;width: 56px;height: 22px;" class="ml-5" href="index.php?module=menu&action=Modify&id={$item->id}" title="编辑">
                                <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                            <a style="text-decoration:none;width: 58px;height: 22px;" class="ml-5" title="删除" href="javascript:;" onclick="del(this,{$item->id},'index.php?module=menu&action=Del&id=','删除')">
                                <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div class="tbtab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-16-36-16-($('.tbtab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')
	
function empty() {
    $("#title").val('');
}

/*删除*/
function del(obj, id, url, content) {
    confirm('确认要删除吗？', id, url, content);
}

function confirm(content, id, url, content1) {
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
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask_role('${id}','${url}','${content1}') >确认</button>
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