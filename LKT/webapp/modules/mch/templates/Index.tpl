{include file="../../include_path/header.tpl" sitename="头部"}
{literal}
    <style type="text/css">
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
        input:focus::-webkit-input-placeholder {
            color: transparent;
            /* transparent是全透明黑色(black)的速记法，即一个类似rgba(0,0,0,0)这样的值 */
        }
    </style>
{/literal}
<body style='display: none;'>
<nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    店铺
</nav>

<div class="pd-20 page_absolute">
    <!--导航表格切换-->
    <div class="swivch swivch_bot page_bgcolor" style="font-size: 16px;">
        <a href="index.php?module=mch&aciton=Index" class="btn1 swivch_active" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">店铺</a>
        {if $button[0] == 1}
            <a href="index.php?module=mch&action=List" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">审核列表</a>
        {/if}
        {if $button[1] == 1}
            <a href="index.php?module=mch&action=Set" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">多商户设置</a>
        {/if}
        {if $button[2] == 1}
            <a href="index.php?module=mch&action=Product" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">商品审核</a>
        {/if}
        {if $button[3] == 1}
            <a href="index.php?module=mch&action=Withdraw" class="btn1" style="height: 42px !important;border:0!important;width: 112px;border-right: 1px solid #ddd!important;">提现审核</a>
        {/if}
        {if $button[4] == 1}
            <a href="index.php?module=mch&action=Withdraw_list" class="btn1" style="height: 42px !important;border:0!important;width: 112px;">提现记录</a>
        {/if}
        <div style="clear: both;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1" action="index.php" method="get">
            <!-- 0=待审核，1=审核通过，2=审核不通过 -->
            <input type="hidden" name="module" value="mch"/>
            <select name="is_open" id="is_open" class="select" style="width: 130px;vertical-align: middle;">
                <option {if $is_open == ''}selected="selected"{/if} value="">请选择营业状态</option>
                <option {if $is_open == '0'}selected="selected"{/if} value="0">未营业</option>
                <option {if $is_open == '1'}selected="selected"{/if} value="1">营业</option>
            </select>

            <input type="text" name="name" id="name" size='8' value="{$name}" placeholder="请输入店铺名称或用户ID" style="width:200px" class="input-text">
            <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076;" class="reset" onclick="empty()"/>

            <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">

        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt-20 table-scroll">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num">店铺ID</th>
                    <th class="tab_imgurl">店铺信息</th>
                    <th>联系人</th>
                    <th class="tab_title">联系电话</th>
                    <th>商户余额</th>
                    <th class="tab_time">入驻时间</th>
                    <th class="tab_three">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach from=$list item=item name=f1}
                <tr class="text-c tab_td">
                    <td class="tab_num">{$item->id}</td>
                    <td class="tab_news tab_t">
                        <div class="tab_good">
                            <img src="{$item->logo}" class="tab_pic">
                            <div class="goods-info tab_left">
                                <div class="mt-1" style="font-weight:bold;color:rgba(65,70,88,1);font-size:14px;">店铺名称：{$item->name} </div>
                                <div class="mt-1" style="font-size: 14px;color: #888F9E;font-weight:400;margin: 6px 0px;">用户ID：{$item->user_id}</div>
                                <div style="font-size: 14px;color: #888F9E;font-weight:400;">所属用户：{$item->user_name}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->realname}</td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->tel}</td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->account_money}</td>
                    <td style="font-weight:400;color:rgba(65,70,88,1);font-size: 14px;">{$item->review_time}</td>
                    <td class="tab_three">
                        {if $button[5] == 1}
                            <a href="index.php?module=mch&action=See&id={$item->id}" title="查看">
                                <img src="images/icon1/ck.png"/>&nbsp;查看
                            </a>
                        {/if}
                        {if $button[6] == 1}
                            <a href="index.php?module=mch&action=Modify&id={$item->id}" title="修改">
                                <img src="images/icon1/xg.png"/>&nbsp;修改
                            </a>
                        {/if}
                        {if $button[7] == 1}
                            {if $status}
                                <a onclick="del({$item->id},'index.php?module=mch&action=Del&id=')">
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
    <div class="tab_footer tb-tab">{$pages_show}</div>
</div>
{include file="../../include_path/footer.tpl"}
{literal}
<script type="text/javascript">
$(function(){
    $('body').show();
})

// 根据框架可视高度,减去现有元素高度,得出表格高度
var Vheight = $(window).height()-56-42-16-56-16-($('.tb-tab').text()?70:0)
$('.table-scroll').css('height',Vheight+'px')

function empty() {
    $("#is_open").val('');
    $("#name").val('');
}
/*删除*/
function del(id, url) {
    confirm("确认删除此店铺吗？", id, url,'删除');
}
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
}
</script>
{/literal}
</body>
</html>