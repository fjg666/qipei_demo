{include file="../../include_path/header.tpl" sitename="DIY头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
{literal}
<style type="text/css">
    .tab_td td{
        height: auto;
        padding: 0;
    }
</style>
{/literal}
<div class="page-container page_absolute pd-20">
    <div class="tab_table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序号</th>
                    <th>任务标题</th>
                    <th>商品链接ID</th>
                    <th class="tab_title">商品名称</th>
                    <th>任务状态</th>
                    <th>执行时间</th>
                    <th>备注</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
                    <td>{$item->title}</td>
                    <td>{$item->itemid}</td>
                    <td class="tab_title">
                        {if $item->recycle==0}
                            {if $item->imgurl}
                                <div style="float: left;">
                                    <img onclick="pimg(this)" src="{$item->imgurl}" style="width: 60px;height: 60px;">
                                </div>
                            {/if}
                            <div >{$item->product_title}</div>
                        {/if}
                    </td>
                    <td>
                        {if $item->status==0}
                            待抓取
                        {elseif $item->status==1}
                            <font style="color: green;">抓取中</font>
                        {elseif $item->status==2}
                            <font style="color: #ddd;">抓取成功</font>
                        {else}
                            <font style="color: red;">抓取失败</font>
                        {/if}
                    </td>
                    <td>{$item->add_date}</td>
                    <td title="{$item->msg}" style="max-width: 110px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{$item->msg}</td>
                    <td class="tab_editor">
                        <div class="tab_block">
                            {if $item->recycle==0}
                                {if $item->status==2}
                                    <a href="index.php?module=product&action=Modify&id={$item->pid}" title="编辑">
                                        <img src="images/icon1/xg.png"/>&nbsp;编辑
                                    </a>
                                {else}
                                    <a href="javascript" title="查看详情" style="width: 88px;">
                                        <img src="images/icon1/ck.png"/>&nbsp;查看商品
                                    </a>
                                {/if}
                            {/if}
                        </div>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>

</div>

{include file="../../include_path/footer.tpl"}

</body>
</html>