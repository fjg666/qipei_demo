{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style>
td a{
    width: 90%;
    margin: 2%!important;
}
.swivch a:hover{
    text-decoration: none;
    background-color: #2481e5!important;
    color: #fff!important;
}
</style>
{/literal}
<body class="iframe-container" style='display: none;'>
<nav class="nav-title">
	<span>插件管理</span>
	<span><span class="arrows">&gt;</span>签到</span>
	<span><span class="arrows">&gt;</span>签到列表</span>
</nav>
<div class="iframe-content">
    <div class="navigation">
        <div class='active'>
			<a href="index.php?module=sign">签到列表</a>
		</div>
		<p class='border'></p>
        {if $button[0] == 1}
            <div>
                <a href="index.php?module=sign&action=Config">签到设置</a>
            </div>
        {/if}
    </div>
    <div class="hr"></div>
    <div>
        <form class='iframe-search' name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="sign" />
            <input type="text" class="input-text" style="width:195px" placeholder="请输入用户名称" name="name" id="name" value="{$name}">
            <select name="source" class="select" id="select">
                <option value="" selected>请选择用户来源</option>
                {$source}
            </select>
            <input type="button" value="重置" id="btn8" class="reset" onclick="empty()" />
            <input name="" id="" class="submit" type="submit" value="查询">
        </form>
    </div>
    <div class="hr"></div>
    <div class="iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th width="40">
                        <div style="position: relative;display: flex;height: 30px;align-items: center;">
                            <input name="ipt1" id="ipt1" type="checkbox" value="" class="inputC">
                            <label for="ipt1"></label>
                        </div>
                    </th>
                    <th class="tab_num">用户ID</th>
                    <th>用户名称</th>
                    <th>手机号码</th>
                    <th>用户来源</th>
                    <th>签到积分总量</th>
                    <th>是否连续</th>
                    <th>连续签到天数</th>
                    <th class="tab_time">签到时间</th>
                    <th class="tab_editor">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td >
                        <div style="display: flex;align-items: center;height: 60px;">
                            <input name="id[]"  id="{$item->id}" type="checkbox" class="inputC " value="{$item->id}">
                            <label for="{$item->id}"></label>
                        </div>
                    </td>
                    <td class="tab_num">{$item->user_id}</td>
                    <td>{$item->user_name}</td>
                    <td>{$item->mobile}</td>
                    <td>{if $item->source == 1}小程序{elseif $item->source == 2}APP{/if}</td>
                    <td>{$item->score}</td>
                    <td>{if $item->num >= 2}是{else}否{/if}</td>
                    <td>{$item->num}</td>
                    <td class="tab_time">{$item->sign_time1}</td>
                    <td>
                        <div class="operation">
                            {if $button[1] == 1}
                                <div>
                                    <a style="text-decoration:none" href="index.php?module=sign&action=Record&user_id={$item->user_id}" title="详情">
                                        <img src="images/icon1/ck.png"/>详情
                                    </a>
                                </div>
                            {/if}
                            {if $button[2] == 1}
                                <div>
                                    <a style="text-decoration:none" onclick="del(this,'{$item->user_id}','index.php?module=sign&action=Del&user_id=')">
                                        <img src="images/icon1/del.png"/>删除
                                    </a>
                                </div>
                            {/if}
						</div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div>{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
	$(function(){
		$('body').show();
	})

function empty() {
    $("#name").val('');
    $("#select").val('');
}
/*删除*/
function del(obj,id,url){
    confirm("确认删除此签到记录吗？",id,url,'删除');
}
function confirm (content,user_id,url,content1){
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
                <div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
                    ${content}
                </div>
                <div style="text-align:center;margin-top:30px">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask('${user_id}','${url}','${content1}')>确认</button>
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