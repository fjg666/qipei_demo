<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-09-24 15:28:28
 * @LastEditTime: 2019-09-25 09:22:52
 * @LastEditors: Please set LastEditors
 -->
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

    <title>积分商城</title>
    {literal}
        <style type="text/css">
            .swivch_bot a{width: 112px!important;padding: 0!important;}
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
			
			#sssss:hover {
				border: 1px solid rgb(213, 219, 232) !important;
			}
        </style>
    {/literal}
</head>
<body style='display: none;'>
<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>积分商城</span>
</nav>
<div class="pd-20 page_absolute">
    <div class="swivch page_bgcolor swivch_bot" style="margin-top: 0px;font-size: 16px;">
        <a href="index.php?module=integral" class="btn1 active1 swivch_active" style="border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;border-right: 1px solid #ddd!important;">积分商城</a>
        <a href="index.php?module=integral&action=Config" class="btn1" style="border: none!important;border-top-right-radius: 2px;border-bottom-right-radius: 2px;">商城设置</a>
        <div class="page_bgcolor"></div>
    </div>
    <div class="page_h16" style="height: 16px!important;"></div>
    <div class="text-c" style="">
        <form name="form1" action="index.php" method="get" class="pd_form1">
            <input type="hidden" name="module" value="integral"/>
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
            <input type="text" name="proname" size='8' value="{$proname}" id="proname" placeholder="请输入商品名称" class="input-text query_inputs">
           <input type="button" value="重置" id="btn8" class="reset" onclick="empty()" />
           <input class="query_cont nmor" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16" ></div>
    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=integral&action=Addpro">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加商品
            </div>
        </a>
        <a href="javascript:;" id="btn6" onclick="datadel('index.php?module=integral&action=Addpro&m=delpro&id=','删除')" style="height: 36px;background: #fff;color: #6a7076;border: none;" class="btn btn-danger radius">
        <div style="height: 100%;display: flex;align-items: center;">
            <img src="images/icon1/del.png"/>&nbsp;批量删除
        </div>
      </a>
       
    </div>
    <div class="page_h16"></div>
    <div class="mt_20 table-scroll">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr" >
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">
                                <div style="position: static;">
                                    <input name="id[]" id="ipt1" type="checkbox" value="0" class="inputC">
                                    <label for="ipt1" style="position: absolute;top: 24px;left: 15px;"></label>
                                </div>
                            </th>
                            <th class="tab_imgurl" style="border-bottom: 2px solid #E9ECEF!important;">序号</th>
                            <th class="tab_imgurl" style="border-bottom: 2px solid #E9ECEF!important;">活动商品信息</th>
                            <th class="tab_title" style="border-bottom: 2px solid  #E9ECEF!important;">兑换所需积分</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">兑换所需余额</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">库存</th>
                            <th class="tab_editor" style="border-bottom: 2px solid  #E9ECEF!important;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="num" value="{$num}" id="num">
                        {foreach from=$list item=item name=f1 key=k}
                        <tr class="text-c tab_td">
                            <td class="tab_label" style="padding-left: 15px!important;">
                                <input type="checkbox" class="inputC input_agreement_protocol" id="{$item->id}" name="id[]" value="{$item->id}" style="position: absolute;">
                                <label for="{$item->id}"></label>
                            </td>
                            <td>{$item->sort}</td>
                            <td style="display: flex;justify-content: center;border: none;">
                                <div style="display: flex; position: relative;flex-direction: column;justify-content: center;width: 70px;height: 88px;">
                                    <img onclick="pimg(this)" class="pro-img" style="width: 60px;height:60px;" src="{$item->imgurl}">
                                </div>
                                <div style="width: 100px;padding-top: 35px;">
                                    <p align="left" style="width: 110px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;margin-bottom: 0px;" title="{$item->product_title}">{$item->product_title}</p>
                                </div>
                            </td>
                            <td>{$item->integral}</td>
                            <td>{$item->money}</td>
                            <td {if $item->inventory==0}style="color: red;"{/if}>{$item->num}</td>
                            <td class="tab_editor" >
                                <a href="index.php?module=integral&action=Addpro&id={$item->id}" title="编辑">
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                                </a>

                                <a onclick="top1('{$item->id}')" href="javascript:void(0);" title="置顶">
                                    <img src="images/icon1/sj_g.png"/>&nbsp;置顶
                                </a>

                                {if $item->candel==1}
                                <a onclick="aj({$item->id})" href="javascript:void(0);" title="删除">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                                {else}
                                <div style="width: 56px;height:22px;cursor: not-allowed;color: #d8dbe8;font-size: 12px;border: 1px solid #e9ecef;margin-top: 30px;display: flex;justify-content: center;align-items: center;">
                                    <img style="opacity:0.3" src="images/icon1/del.png"/>&nbsp;删除
                                </div>
                                {/if}
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
    </div>
    <div class='tb-tab' style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>


{literal}
    <script type="text/javascript">
		$(function(){
			$('body').show();
		})
		
		// 根据框架可视高度,减去现有元素高度,得出表格高度
		var Vheight = $(window).height()-56-42-16-56-16-36-16-($('.tb-tab').text()?70:0)
		$('.table-scroll').css('height',Vheight+'px')
        
        var Id = '';
        /*重置*/
        function empty() {
            $("#proname").val('');
        }

        $(".input_agreement_protocol").bind("click",function () {
            var $sel = $(".input_agreement_protocol");
            console.log($sel.length)
            var b = true;
            for (var i = 0; i < $sel.length; i++) {
                console.log($sel[i].checked)
                if ($sel[i].checked == false) {
                    b = false;
                    break;
                }
            }
            console.log(b);
            $("#ipt1").prop("checked", b);
        })

//ajax请求，开始和结束活动
function aj(id) {

    var url = 'index.php?module=integral&action=Addpro&m=delpro&id=';

    confirm ('确认删除所选中的积分商品吗？',id,url,'删除');

}


function top1(id) {
    $.post("index.php?module=integral&action=Addpro&m=top", {'id': id}, function (res) {
        $(".maskNew").remove();
        if (res.status == 1) {
            layer.msg("操作成功！");
            location.replace(location.href);
        } else {
            layer.msg("操作失败！");
        }

    }, "json");
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
    confirm('确认删除所选中的积分商品吗？',Id,url,content)
    
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