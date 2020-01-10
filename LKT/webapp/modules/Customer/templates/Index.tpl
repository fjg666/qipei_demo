{include file="../../include_path/header.tpl" sitename="DIY头部"}
{literal}
<style>
    td a{
        margin: 2% !important;
        float: left;
    }
    .tab_dat{
        width: 200px;
    }
    .tab_dat a{
        width: 56px;
    }
    .tab_table{
        height: auto;
    }
    .tab_dat a img{
        margin-top: -0.2rem;
    }

</style>
{/literal}
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
    <div class="text-c text_c">
        <form name="form1" action="index.php" method="get">
            <input type="hidden" name="module" value="Customer"/>
            <input type="text" name="name" size='8' value="{$name}" id="name" placeholder=" 请输入姓名" style="width:200px" class="input-text">
            购买日期：
            <div style="position: relative;display: inline-block;">
                <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间" id="startdate" name="startdate" style="width:150px;">
            </div>
            至
            <div style="position: relative;display: inline-block;margin-left: 5px;">
                <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间" id="enddate" name="enddate" style="width:150px;">
            </div>
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()"/>

            <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">

            <input id="btn9" class="btn " type="button" value="导出" onclick="export_popup(location.href)" style="float: right;background: #008DEF;color: #fff">
        </form>
    </div>
     <div class="page_h16"></div>
    <div style="clear:both;" class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=Customer&action=Add"><img src="images/icon1/add.png"/>&nbsp;添加商城</a>
    </div>
    <div class="page_h16"></div>

    <input type="hidden" name="length" value="{$list|@count}">

    <div class="tab_table table-scroll" style="height: 71vh;">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th>商城ID</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>价格</th>
                    <th>公司名称</th>
                    <th class="tab_time">购买时间</th>
                    <th class="tab_time">到期时间</th>
                    <th>状态</th>
                    <th class="tab_dat">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td>{$item->id}</td>
                    <td>{$item->name}</td>
                    <td>{$item->mobile}</td>
                    <td>{$item->price}</td>
                    <td>{$item->company}</td>
                    <td class="tab_time">{$item->add_date}</td>
                    <td class="tab_time">{$item->end_date}</td>
                    <td>
                        {if $item->status == 0}
                            <span style="color: #30c02d;">启用</span>
                        {elseif $item->status == 1}
                            <span style="color: #ff2a1f;">到期</span>
                        {else}
                            <span style="color: #ff2a1f;">锁定</span>
                        {/if}
                    </td>
                    <td class="tab_dat">
                        {if $item->status == 0}
                            <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="mcheck('index.php?module=Customer&action=Sstatus&id=','{$item->id}','{$item->status}')" title="锁定">
                                <img src="images/icon1/sd.png"/>&nbsp;锁定
                            </a>
                        {else}
                            <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="mcheck('index.php?module=Customer&action=Sstatus&id=','{$item->id}','{$item->status}')" title="解锁">
                                <img src="images/icon1/sd.png"/>&nbsp;启用
                            </a>
                        {/if}
                        {*<a style="text-decoration:none" class="ml-5" href="index.php?module=Customer&action=See&id={$item->id}" title="查看">*}
                            {*<img src="images/icon1/ck.png"/>&nbsp;查看*}
                        {*</a>*}
                        <a style="text-decoration:none" class="ml-5" href="index.php?module=Customer&action=Modify&id={$item->id}" title="编辑">
                            <img src="images/icon1/xg.png"/>&nbsp;编辑
                        </a>
                        <a style="text-decoration:none" class="ml-5" title="删除" onclick="Del('index.php?module=Customer&action=Del&id={$item->id}','{$item->status}')">
                            <img src="images/icon1/del.png"/>&nbsp;删除
                        </a>
                        <a style="text-decoration:none;width: 88px;" class="ml-5" href="javascript:void(0);" onclick=" confirm1('密码重置','{$item->name}','{$item->admin_id}','index.php?module=Customer&action=Reset&id=')" title="密码重置">
                            <img src="images/icon1/cz.png"/>&nbsp;密码重置
                        </a>

                        <a style="text-decoration:none;width: 88px;" class="ml-5" href="javascript:void(0);" onclick="dump('index.php?module=AdminLogin','{$item->id}','{$item->shop_id}')" title="进入系统">
                            <img src="images/icon1/jrxt.png"/>&nbsp;进入系统
                        </a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div id="pagesId" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
    <div id="innerdiv" style="position:absolute;"><img id="bigimg" src=""/></div>
</div>
{include file="../../include_path/footer.tpl"}

{literal}
<script type="text/javascript">
// 根据框架可视高度,减去现有元素高度,得出表格高度
var Vheight = $(window).height()-56-56-16-36-16-($('#pagesId').text()?70:0)
$('.table-scroll').css('height',Vheight+'px')
	
laydate.render({
    elem: '#startdate', //指定元素
    type: 'datetime'
});
laydate.render({
    elem: '#enddate',
    type: 'datetime'
});

function empty() {
    $("#name").val('');
    $("#startdate").val('');
    $("#enddate").val('');
}

function dump(url, store_id,mch_id) {
    $.ajax({
        type: "post",
        url: 'index.php?module=Customer&store_id=' + store_id + '&mch_id=' + mch_id,
        async: true,
        dataType: "json",
        success: function (res) {
            window.parent.location.href = url;
        },
    });
}

function mcheck(url, admin_id) {
    $.ajax({
        type: "POST",
        url: url + admin_id,
        async: true,
        dataType: "json",
        success: function (res) {
            layer.msg(res.info, {time: 2000});
            setTimeout(function () {
                location.href = "index.php?module=Customer";
            }, 1000);
        },
    });
}

function Del(url,status) {
    if(status == 0){
        var text = '确认删除此生效商户？ 删除商户后，商户管理员将无法访问商户后台，请谨慎操作。'
    }else{
        var text = '确认删除此商户？'
    }
    $("body", parent.document).append(`
        <div class="pop_body maskNew">
            <div class="pop_flex" style="width: 100%;height: 100%;display: flex;">
                <div class="pop_auto" style="width: 460px;margin: auto;background-color: white;border-radius: 4px;height: 222px;">
                    <div class="pop_title" style="line-height: 60px;height: 60px;border-bottom: 0px solid #E9ECEF;font-size: 18px;color: #414658;font-weight: bold;padding-left: 24px;position: relative;">
                    </div>
                    <div class="pop_content" style="padding: 0px;font-size: 16px;text-align: center;width: 377px;margin: 0px auto;">
                        ${text}
                    </div>
                    <div style="text-align:center;margin-top: 36px;">
                        <button class="closeMask" style="width:112px;background: #ffffff;color: #008DEF;border: 1px solid #008DEF;margin-right:6px;" onclick=closeMask1() >取消</button>
                        <button class="closeMask" style="width:112px;background: #008DEF;color: #ffffff;" onclick=Customer_Del('${url}') >确认</button>
                    </div>
                </div>
            </div>
        </div>
    `)
}
</script>
<script type="text/javascript">
function confirm1(content, name, id, url) {
    $("body", parent.document).append(`
        <div class="pop_body maskNew">
            <div class="pop_flex" style="width: 100%;height: 100%;display: flex;">
                <div class="pop_auto" style="width: 460px;margin: auto;background-color: white;border-radius: 4px;height: 296px;">
                    <div class="pop_title" style="line-height: 60px;height: 60px;border-bottom: 1px solid #E9ECEF;font-size: 18px;color: #414658;font-weight: bold;padding-left: 24px;position: relative;">
                        ${name}${content}
                        <img src="images/icon/cha.png"  onclick=closeMask1() style="position: absolute;top: 20px;right: 20px;width: 20px;height: 20px;background-size: 100% 100%;"/>
                    </div>
                    <div class="pop_content" style="padding: 20px;font-size: 16px;">
                        <div class="pop_input" style="padding: 16px 0 0;font-size: 14px;">
                            <div class="pop_input_l" style="float: left;text-align: right;padding-right: 10px;line-height: 38px;">新密码:</div>
                            <input type="text" placehold='请设置新密码' name='password' style="border: 1px solid #ddd;width:302px;padding: 0;padding-left: 10px;height: 36px;background-color: transparent;">
                        </div>
                         <div class="pop_input" style="padding: 16px 0 0;font-size: 14px;">
                            <div class="pop_input_l" style="float: left;text-align: right;padding-right: 10px;line-height: 38px;">确认密码:</div>
                            <input type="text" placehold='请再次输入新密码' name='password1' style="border: 1px solid #ddd;width:302px;padding: 0;padding-left: 10px;height: 36px;background-color: transparent;">
                        </div>
                    </div>
                    <div style="text-align:right;margin-top: 36px;">
                        <button class="closeMask" style="width:112px;background: #ffffff;color: #008DEF;border: 1px solid #008DEF;margin-right:6px;" onclick=closeMask1() >取消</button>
                        <button class="closeMask" style="width:112px;background: #008DEF;color: #ffffff;margin-right: 20px;" onclick=closeMask4_2('${id}','${url}') >确认</button>
                    </div>
                </div>
            </div>
        </div>
    `)
}
</script>
{/literal}
</body>
</html>