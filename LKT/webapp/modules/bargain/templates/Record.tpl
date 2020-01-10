<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css"/>
    <link href="style/css/style.css" rel="stylesheet" type="text/css"/>

    <title>砍价详情</title>
    {literal}
        <style type="text/css">
           .btn1 {
                padding: 0px 10px;
                height: 36px;
                line-height: 36px;
                display: flex;
                justify-content: center;
                align-items: center;
                float: left;
                color: #6a7076;
                background-color: #fff;
            }

            .active1 {
                color: #fff;
                background-color: #62b3ff;
            }


            .swivch a:hover {
                text-decoration: none;
                background-color:#2481e5!important;;
                color: #fff;
            }

            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
            }
            .wrap {
                width: 60px;
                height: 30px;
                background-color: #ccc;
                border-radius: 16px;
                position: relative;
                transition: 0.3s;
                margin-left: 10px;
            }
            .circle {
                width: 29px;
                height: 29px;
                background-color: #fff;
                border-radius: 50%;
                position: absolute;
                left: 0px;
                transition: 0.3s;
                box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
            }
            .circle:hover {
                transform: scale(1.2);
                box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
            }
            .swivch_bot a{width: 112px!important;padding: 0!important;}
        </style>
    {/literal}
</head>
<body>
<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;' onclick="location='index.php?module=bargain&action=Index'">砍价</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>砍价详情</span>
</nav>
<div class="pd-20 page_absolute">
    <div class="swivch page_bgcolor swivch_bot" style="margin-top: 0px;font-size: 16px;">
        <a href="index.php?module=bargain&action=Record&type=all&goodsid={$goodsid}" class="btn1 {if $type=='all' || $type==''}active1 swivch_active{/if}" style="height: 36px;border-left: none!important;border-top: none!important;border-bottom: none!important;">全部</a>
        <a href="index.php?module=bargain&action=Record&type=0&goodsid={$goodsid}" class="btn1 {if $type=='0'}active1 swivch_active{/if}" style="height: 36px;border-left: 1px solid #ddd!important;border-top: none!important;border-bottom: none!important;">砍价中</a>
        <a href="index.php?module=bargain&action=Record&type=1&goodsid={$goodsid}" class="btn1 {if $type=='1'}active1 swivch_active{/if}" style="height: 36px;border-left: 1px solid #ddd!important;border-top: none!important;border-bottom: none!important;">砍价成功</a>
        <a href="index.php?module=bargain&action=Record&type=2&goodsid={$goodsid}" class="btn1 {if $type=='2'}active1 swivch_active{/if}" style="height: 36px;border-left: 1px solid #ddd!important;border-top: none!important;border-bottom: none!important;">砍价失败</a>
        <div class="page_bgcolor"></div>
    </div>
    <div class="page_h16" style="height: 16px!important;"></div>
    <div class="text-c" style="">
        <form name="form1" action="index.php" method="get" class="pd_form1">
            <input type="hidden" name="module" value="bargain"/>
            <input type="hidden" name="action" value="Record"/>
            <input type="hidden" name="type" value="{$type}"/>
            <input type="hidden" name="goodsid" value="{$goodsid}"/>
            <input type="text" name="username" size='8' value="{$username}" id="" placeholder="请输入用户名称" style="width:200px" class="input-text">
           <input class="query_cont nmor" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16" style="height: 16px!important;"></div>
    <div class="mt_20" style="max-height: 73.5vh;overflow: auto;">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr" >
                            <th class="tab_imgurl" style="border-bottom: 2px solid #E9ECEF!important;">序号</th>
                            <th class="tab_imgurl" style="border-bottom: 2px solid #E9ECEF!important;">会员名称</th>
                            <th class="tab_title" style="border-bottom: 2px solid  #E9ECEF!important;">最低价</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">当前砍价</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">参与时间</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">参与人次</th>
                            <th class="tab_time" style="border-bottom: 2px solid  #E9ECEF!important;">活动状态</th>
                            <th class="tab_editor" style="border-bottom: 2px solid  #E9ECEF!important;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="num" value="{$num}" id="num">
                        {foreach from=$list item=item name=f1 key=k}
                        <tr class="text-c tab_td">
                            <td>{$item->id}</td>
                            <td>{$item->user_name}</td>
                            <td>{$item->min_price}</td>
                            <td>{$item->original_price}</td>
                            <td>{$item->addtime}</td>
                            <td>{$item->count}</td>
                            <td>
                                {if $item->status==0}
                                    <span style="color:orange;">砍价中</span>
                                {elseif $item->status==-1}
                                    <span style="color:green;">砍价失败</span>
                                {else}
                                    <span style="color:red;">砍价成功</span>
                                {/if}
                            </td>
                            <td class="tab_editor" >
                                <a href="index.php?module=bargain&action=Helprecord&order_no={$item->order_no}" title="帮砍详情" style="width: 90px;float: none;">
                                    <img src="images/icon1/ck.png"/>&nbsp;帮砍详情
                                </a>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;position: sticky;bottom: 0;">{$pages_show}</div>
    <!-- <div class="page_h20"></div> -->
</div>



<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>


{literal}
    <script type="text/javascript">
        var aa=$(".pd-20").height()-56-48-36-36;
        var bb=$(".table-border").height();

        if(aa<bb){
            $(".page_h20").css("display","block")
        }else{
            $(".page_h20").css("display","none")
        }
        var Id = '';
        /*重置*/
        function empty() {
            location.replace('index.php?module=bargain');
        }

        var num = $("input[name='num']").val();
        var status;
        for(var i=0;i<num;i++){
            status = $("#circle_"+i).parent(".wrap").attr("is_show");
            console.log(status);
            if(status == 0){

                $('#circle_'+i).css('left', '0px'),
                $('#circle_'+i).css('background-color', '#fff'),
                $('#circle_'+i).parent(".wrap").css('background-color', '#ccc');
            }else{

                $('#circle_'+i).css('left', '30px'),
                $('#circle_'+i).css('background-color', '#fff'),
                $('#circle_'+i).parent(".wrap").css('background-color', '#2890FF');
            }
            
        }

        function up(k,id){

            var status_1 = $("#circle_"+k).parent(".wrap").attr("is_show");


            if(status_1 == 0){

                $('#circle_'+k).css('left', '30px'),
                $('#circle_'+k).css('background-color', '#fff'),
                $('#circle_'+k).parent(".wrap").css('background-color', '#2890FF');
                $('#circle_'+k).parent(".wrap").attr("is_show",1);
               
            }else{

                $('#circle_'+k).css('left', '0px'),
                $('#circle_'+k).css('background-color', '#fff'),
                $('#circle_'+k).parent(".wrap").css('background-color', '#ccc');
                $('#circle_'+k).parent(".wrap").attr("is_show",0);
            }
            var status_1 = $("#circle_"+k).parent(".wrap").attr("is_show");

            $.post("index.php?module=bargain&action=Member&m=is_market", {'id': id, 'type': status_1}, function (res){

                if (res.status == 1) {
                    layer.msg("操作成功！",{time:2000});
                    location.replace(location.href);
                } else {
                    layer.msg("操作失败！",{time:2000});
                }
                location.replace(location.href);

            }, "json");
        }



//ajax请求，开始和结束活动
function aj(id) {
    $.post("index.php?module=bargain&action=Member&m=delpro", {'id': id}, function (res) {
        $(".maskNew").remove();
        if (res.status == 1) {
            layer.msg("操作成功！");
            location.replace(location.href);
        } else {
            layer.msg("操作失败！");
        }

    }, "json");
}


  //警告函数
  function my_warn(status){
    
    if(status == 1){
        alert('编辑后果自负');
    }
    
  }


        /*批量删除*/
function datadel(url,content){

    var checkbox=$("input[name='id[]']:checked");//被选中的复选框对象
    
    var Id = '';
    for(var i=0;i<checkbox.length;i++){
        Id+=checkbox.eq(i).val()+",";
    }
    if(Id==""){
        layer.msg("未选择数据！");
        return false;
    }
    confirm('确认删除所选中的砍价活动商品记录么？',Id,url,content)
    
}

function confirm (content,id,url,content1){
    $("body",parent.document).append(`
        <div class="maskNew">
            <div class="maskNewContent" style="padding-top:0px;">
                <a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
                <div class="maskTitle">删除</div>
                <div style="font-size: 16px;text-align: center;padding:60px 0;">
                    ${content}
                </div>
                <div style="text-align:center;">
                    <button class="closeMask" style="margin-right:20px" onclick=closeMask('${id}','${url}','${content1}')>确认</button>
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