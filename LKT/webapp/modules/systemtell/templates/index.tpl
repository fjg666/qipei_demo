{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style>
   	td a{
        width: 44%;
        margin: 2%!important;
        float: left;
    }
</style>
{/literal}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div style="clear:both;" class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=systemtell&action=add"><img style="margin-right: 2px!important;height: 14px; width: 14px;" src="images/icon1/add.png"/>&nbsp;发布公告</a>
    </div>
    <div class="page_h16"></div>
    <div class="tab_table table-scroll" style="height: 82vh;">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th style="width:20%;">标题</th>
                    <th>类型</th>
                    <th class="tab_time">时间</th>
                    <th class="tab_time">添加时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
            {if $list != ''}
                {foreach from=$list item=item name=f1}
                    <tr class="text-c tab_td">
                        <td>{$item->title}</td>
                        <td>{if $item->type==1}系统维护{else}版本更新{/if}</td>
                        <td class="tab_time">{if $item->type==1}{$item->startdate} ~ {$item->enddate}{else}无{/if}</td>
                        <td class="tab_time">{$item->add_time}</td>
                        <td class="tab_editor">
                            <a style="text-decoration:none" class="ml-5" href="index.php?module=systemtell&action=modify&id={$item->id}" title="编辑">
                                <div style="align-items: center;font-size: 12px;display: flex;">
                                    <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                    </div>
                                </div>
                            </a>
                            <a style="text-decoration:none" class="ml-5" href="" onclick="confirm('确定要删除此公告吗?','{$item->id}','index.php?module=systemtell&action=del&id=','删除')">
                                <div style="align-items: center;font-size: 12px;display: flex;">
                                    <div style="margin:0 auto;;display: flex;align-items: center;">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                    </div>
                                </div>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            {else}
                <tr class="text-c"><td colspan="5">暂无数据</td></tr>
            {/if}

            </tbody>
        </table>
    </div>
</div>
<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
{include file="../../include_path/footer.tpl"}
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
{literal}
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-36-16
	$('.table-scroll').css('height',Vheight+'px')
	
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
						<button class="closeMask" onclick=closeMask1() >取消</button>
					</div>
				</div>
			</div>	
		`)
	};
</script>
{/literal}
</body>
</html>