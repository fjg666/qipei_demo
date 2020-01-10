{include file="../../include_path/header.tpl" sitename="DIY头部"}

{literal}
<style>
.int-table{
    height:81%;
    overflow: overlay;
}

.table-title{
    top: 0;
    position: sticky;
    background: #fff;
    z-index: 9999;
    border-bottom: 2px solid #E9ECEF!important;
}
</style>
{/literal}
<body>
<nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    <i class="Hui-iconfont">&#xe623;</i>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a href="index.php?module=sign">签到</a>
    <span class="c-gray en">&gt;</span>
    签到详情
</nav>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="mt-20 text-c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="sign" />
            <input type="hidden" name="action" value="Record" />
            <input type="hidden" name="user_id" value="{$user_id}" />

            <input type="text" class="input-text" value="{$starttime}" placeholder="请输入开始时间" autocomplete="off" id="starttime" name="starttime" style="width:180px;">
            至
            <input type="text" class="input-text" value="{$endtime}" placeholder="请输入结束时间" autocomplete="off" id="endtime" name="endtime" style="width:180px;margin-left: 10px;">

            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />
            <input name="" id="" class="btn btn-success" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16"></div>

    <div class="int-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="table-title">会员名称</th>
                    <th class="tab_time table-title">签到时间</th>
                    <th class="table-title">签到积分</th>
                    <th class="table-title">备注</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$list item=item name=f1}
                    <tr class="text-c tab_td">
                        <td>{$item->user_name}</td>
                        <td class="tab_time">{$item->sign_time}</td>
                        <td >{$item->sign_score}</td>
                        <td>{$item->record}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_h20"></div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
function empty() {
    $("#starttime").val('');
    $("#endtime").val('');
}
var aa=$(".pd-20").height()-16-56;
var bb=$(".table-border").height();
if(aa<bb){
    $(".page_h20").css("display","block")
}else{
    $(".page_h20").css("display","none")
}
laydate.render({
    elem: '#starttime', //指定元素
    type: 'datetime'
});
laydate.render({
    elem: '#endtime',
    type: 'datetime'
});
</script>
{/literal}
</body>
</html>