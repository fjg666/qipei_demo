{include file="../../include_path/header.tpl" sitename="DIY头部"}
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-top: 0;"> 
        <h1 style="text-align: center;padding-bottom: 20px;">{$Article_title}</h1> 
    </div>
    <div class="page_h16"></div>
    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-top: 0;"> 
        <span class="l" bgColor="white">
        </span> 
        <span class="r">共有数据：<strong>{$total}</strong> 条</span> 
    </div>
    <div class="tab_table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">序</th>
                    <th>用户id</th>
                    <th>微信id</th>
                    <th>微信昵称</th>
                    <th>性别</th>
                    <th class="tab_time">发布时间</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$smarty.foreach.f1.iteration}</td>
                    <td>{$item->user_id}</td>
                    <td>{$item->wx_id}</td>
                    <td>{$item->wx_name}</td>
                    <td>
                        {if $item->sex==0}未知{/if}
                        {if $item->sex==1}男{/if}
                        {if $item->sex==2}女{/if}
                    </td>
                    <td class="tab_time">{$item->share_add}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class="page_h20"></div>
</div>

{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
var aa=$(".pd-20").height()-130;
var bb=$(".table-border").height();
if(aa<bb){
	$(".page_h20").css("display","block")
}else{
	$(".page_h20").css("display","none")
}

</script>
{/literal}
</body>
</html>