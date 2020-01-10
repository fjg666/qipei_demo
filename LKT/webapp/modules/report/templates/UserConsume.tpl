
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

{include file="../../include_path/header.tpl" sitename="公共头部"}
{literal}
<style type="text/css">
i{
    cursor: pointer;
}
#delorderdiv{
    margin-left: 20px;
    display: inline;
    color:red;
}
td a{
    width: 90%;
    margin: 2%;
    float: left;
}
.textIpt{
    border: 1px solid #eee;
    padding-left:20px;
    height: 30px;
    line-height: 30px;
}
#allAndNotAll{
    position: absolute;
}
</style>

<style type="text/css">
    .btn1 {
        padding: 0px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        float: left;
        background-color: #fff;
    }

    .active1 {
        color: #fff;
        background-color: #62b3ff;
    }

    .swivch a:hover {
        text-decoration: none;
        background-color: #2481e5!important;
        color: #fff;
    }

    td a {
        width: 28%;
        float: left;
        margin: 2% !important;
    }
</style>
{/literal}
<title>会员消费报表</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}

<div class="pd-20 page_absolute" >
    <div class="swivch swivch_bot page_bgcolor">
        <a href="index.php?module=report&action=Index" class="btn1">新增会员</a>
        <a href="index.php?module=report&action=UserConsume" class="btn1 active1 swivch_active">会员消费报表</a>
        <a href="index.php?module=report&action=UserSource" class="btn1" style="border-right: 1px solid #ddd!important;">会员比例</a>
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c text_c">
        <form method="get" action="index.php" name="form1">
            <div style="border-left:solid 1px #fff;">
                <input type="hidden" name="module" value="report"  />
                <input type="hidden" name="action" value="UserConsume"  />

                <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
                <input type="text" class="input-text" style="width:200px" placeholder="用户昵称" name="name" value="{$name}">
                <select name="source" class="select" style="width: 120px;height: 31px;vertical-align: middle;">
                    <option value="0" selected>用户来源</option>
                    <option value="1" {if $source == 1} selected {/if}>小程序</option>
                    <option value="2" {if $source == 2} selected {/if}>手机App</option>
                </select>
                <div style="position: relative;display: inline-block;">
                    <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间"  autocomplete="off" id="startdate" name="startdate" style="width:150px;">
                </div>至
                <div style="position: relative;display: inline-block;margin-left: 5px;">
                    <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间"  autocomplete="off" id="enddate" name="enddate" style="width:150px;">
                </div>
                <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />
                <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">
                <!--<input type="button" id="btn2" value="导出本页" class="btn btn-success" onclick="excel('ne')">-->
                <input type="button" id="btn2" value="导出全部" class="btn btn-success" onclick="excel('all')" style="width:80px!important;">
            </div>

        </form>
    </div>
    <div class="page_h16"></div>

    <div class="mt-20">
        
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                  
                    <th width="40">ID</th>
                    <th width="150">用户昵称</th>
                    <th width="100">用户来源</th>
                    <th width="100">订单总数量</th>
                    <th width="50">订单总金额</th>
                    <th width="180">退款数量</th>
                    <th width="150">退款总金额</th>
                    <th width="150">有效订单总数量</th>
                    <th width="100">有效订单总金额</th>
                   
                   
                </tr>
            </thead>
            <tbody>
            {foreach from=$res item=item name=f1}
                <tr class="text-c tab_td">
                    
                    <td>{$item->id}</td>
                    <td>{$item->user_name}</td>
                    <td>{if $item->source == 1}小程序{else}手机App{/if}</td>
                    <td>{$item->num}</td>
                    <td>{$item->z_price}</td>
                    <td>{$item->back_num}</td>
                    <td>{$item->back_z_price}</td>
                    <td>{$item->real_num}</td>
                    <td>{$item->real_z_price}</td>
                  
                    
                </tr>
            {/foreach}    
           
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_h20" style="display: block;"></div>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>
<!--<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type='text/javascript' src='modpub/js/calendar.js'> </script>-->

<!--<script type="text/javascript" src="style/FineMessBox/js/common.js"></script>
<script type="text/javascript" src="style/FineMessBox/js/subModal.js"></script>-->


<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<!--<script type="text/javascript" src="style/js/H-ui.admin.js"></script>-->
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

{literal}
<script type="text/javascript">
var aa=$(".pd-20").height()-36-32-$(".text_c").height();
var bb=$(".table-border").height();
console.log($(".text_c").height())
console.log(aa,bb)
if(aa<bb){
	$(".page_h20").css("display","block")
}else{
	$(".page_h20").css("display","none")
}
    //日历
    laydate.render({
        elem:'#startdate',
        type:'date'
    });
    laydate.render({
        elem:'#enddate',
        type:'date'
    });
    function empty() {
        location.replace('index.php?module=report&action=UserConsume');
    }

function excel(pageto) {
    var pagesize = $("#pagesize").val();
    location.href=location.href+'&pageto='+pageto;
}

    </script>
{/literal}
</body>
</html>