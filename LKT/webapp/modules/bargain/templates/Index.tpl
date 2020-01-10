<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-08-14 09:40:19
 * @LastEditTime: 2019-10-08 18:06:10
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

    <title>砍价商品</title>
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
			
			
			.table-border th{
				background-color: #fff;
				z-index: 100;
			}
			.table-border th::after{
				content: '';
				display: block;
				width: 100%;
				height: 2px;
				position: absolute;
				bottom: -1px;
				left: 0;
				background: #E9ECEF;
			}
            .kj-del {
                margin: 2% !important;
                font-size: 12px!important;
                border-radius: 2px;
                border:1px solid rgba(233,236,239,1);
                color:rgba(213,219,232,1);
                width: 54px;
                height: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                cursor: not-allowed;
            }
        </style>
    {/literal}
</head>
<body style='display: none;'>
<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>砍价</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>砍价商品</span>
</nav>
<div class="pd-20 page_absolute">
    <div class="swivch page_bgcolor swivch_bot" style="margin-top: 0px;font-size: 16px;">
        <a href="index.php?module=bargain" class="btn1 active1 swivch_active" style="height: 36px;border: none!important;border-top-left-radius: 2px;border-bottom-left-radius: 2px;">砍价商品</a>
        <a href="index.php?module=bargain&action=Config" class="btn1" style="height: 36px;border: none!important;border-top-right-radius: 2px;border-bottom-right-radius: 2px;">砍价设置</a>
        <div class="page_bgcolor"></div>
    </div>
    <div class="page_h16" style="height: 16px!important;"></div>
    <div class="text-c" style="">
        <form name="form1" action="index.php" method="get" class="pd_form1">
            <input type="hidden" name="module" value="bargain"/>
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
            <input type="text" name="proname" size='8' value="{$proname}" id="proname" placeholder="请输入商品名称" class="input-text query_inputs">
            <select name="bstatus" id="bstatus" class="select query_select">
                <option value="">全部</option>
                <option value="0" {if $bstatus===0}selected{/if}>未开始</option>
                <option value="1" {if $bstatus==1}selected{/if}>进行中</option>
                <option value="2" {if $bstatus==2}selected{/if}>已结束</option>
           </select>

           <input type="button" value="重置" id="btn8" class="reset" onclick="empty()" />
           <input class="query_cont nmor" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16" ></div>
    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=bargain&action=Addpro">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加商品
            </div>
        </a>
        <a href="javascript:;" id="btn6" onclick="datadel('index.php?module=bargain&action=Member&m=delpro&id=','删除')" style="height: 36px;background: #fff;color: #6a7076;border: none;" class="btn btn-danger radius">
        <div style="height: 100%;display: flex;align-items: center;">
            <img src="images/icon1/del.png"/>&nbsp;批量删除
        </div>
      </a>
       
    </div>
    <div class="page_h16"></div>
    <div class="mt_20 table-scroll" style="height: 63.5vh;overflow: auto;">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr" style="border:0!important">
                            <th style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">
                                <div style="position: static;">
                                    <input name="id[]" id="ipt1" type="checkbox" value="0" class="inputC">
                                    <label for="ipt1" style="position: absolute;top: 24px;left: 15px;"></label>
                                </div>
                            </th>
                            <th class="tab_imgurl" style="border-bottom: 2px solid #E9ECEF!important;position:sticky;top:0">活动商品信息</th>
                            <th class="tab_title" style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">零售价/最低价</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">库存</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">活动标签</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">是否显示</th>
                            <th class="tab_time" style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">创建时间</th>
                            <th class="tab_editor" style="border-bottom: 2px solid  #E9ECEF!important;position:sticky;top:0">操作</th>
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
                            <td style="display: flex;justify-content: center;border: none;">
                                <div style="display: flex; position: relative;flex-direction: column;justify-content: center;width: 70px;height: 88px;">
                                    <img onclick="pimg(this)" class="pro-img" style="width: 60px;height:60px;" src="{$item->imgurl}">
                                </div>
                                <div style="width: 100px;padding-top: 20px;">
                                    <p align="left" style="width: 110px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;margin-bottom: 0px;" title="{$item->product_title}">{$item->product_title}</p>
                                    <p style="text-align: left;">
                                        <span style="color:green;">
                                            {if $item->status==3}
                                                <span style="color:red;">已下架</span>
                                            {else}
                                                {if $item->b_status==0}
                                                    <span style="color:orange;">未开始</span>
                                                {elseif $item->b_status==1}
                                                    <span style="color:green;">进行中</span>
                                                {else}
                                                    <span style="color:red;">已结束</span>
                                                {/if}
                                            {/if}
                                        </span>
                                    </p>
                                </div>
                            </td>
                            <td>零售价：￥{$item->price}<br />最低价：￥{$item->min_price}</td>
                            <td>{if $item->num==0}<font style="color:red;">0</font>{else}{$item->num}{/if}</td>
                            <td>{$item->tag}</td>
                            <td>
                                <div style="margin-left: 50px;">
                                    <div class="change_box">
                                        <div class="wrap" onclick="up({$k},{$item->id}{if $item->b_status==2},1{/if})" is_show="{$item->is_show}" style="{if $item->is_show==1}background-color:#2890FF;{else}background-color: #ccc;{/if}">
                                            <div class="circle" data-num="{$item->num}" id="circle_{$k}" style="{if $item->is_show==1}left:30px;{else}left:0px;{/if}"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="tab_time">开始时间：{$item->begin_time}<br />结束时间：{$item->end_time}</td>
                            <td class="tab_editor" >
                               <a href="index.php?module=bargain&action=Modify&id={$item->id}" title="{if $item->b_status==0}编辑{else}查看{/if}">

                                    <img src="images/icon1/xg.png"/>&nbsp;
                                    {if $item->b_status==0}
                                        修改
                                    {else}
                                        查看
                                    {/if}

                                </a>

                                
                                {if $item->b_status==0}
                                    <a href="#" title="砍价开始" onclick="begin({$item->id})">

                                        <img src="images/icon1/kjqy.png"/>&nbsp;开始

                                    </a>
                                {else}
                                    <a href="index.php?module=bargain&action=Record&goodsid={$item->id}" title="砍价详情">

                                        <img src="images/icon1/kjxq.png"/>&nbsp;详情

                                    </a>
                                {/if}


                                {if $item->b_status!=1}
                                    <a onclick="aj({$item->id})" href="javascript:void(0);" title="删除">
                                        <img src="images/icon1/del.png"/>&nbsp;删除
                                    </a>
                                {else}
                                    <div class="kj-del" title="删除">
                                        <img src="images/icon1/shouhouAddress_delete_1.png"/>&nbsp;删除
                                    </div>
                                {/if}
                                
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
    </div>
    <div class='tb-tab' style="text-align: center;display: flex;justify-content: center;position: sticky;bottom: 0;">{$pages_show}</div>
</div>



<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>


{literal}
<script type="text/javascript">
	$(function(){
		$('body').show();
	})

    $(".input_agreement_protocol").bind("click",function () {
        var $sel = $(".input_agreement_protocol");
        var b = true;
        for (var i = 0; i < $sel.length; i++) {
            if ($sel[i].checked == false) {
                b = false;
                break;
            }
        }
        $("#ipt1").prop("checked", b);
    })
	
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-42-16-56-16-36-16-($('.tb-tab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')
	
    var Id = '';
    /*重置*/
    function empty() {
        $("#proname").val('');
        $("#bstatus").val('');
    }

    function up(k,id,no=0){

        if (no > 0) {
            layer.msg("已经结束的活动不允许进行更改！",{time:2000});
            return;
        }

        var status_1 = $("#circle_"+k).parent(".wrap").attr("is_show");


        if(status_1 == 0){

            var num = $("#circle_"+k).attr('data-num');
            if (num == 0) {
                layer.msg("商品库存不足，请先增添库存！",{time:2000});
                return;
            }

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

        var url = 'index.php?module=bargain&action=Member&m=delpro&id=';

        confirm ('确认删除所选中的砍价活动商品记录么？',id,url,'删除');

    }

    function begin(id) {

        var url = 'index.php?module=bargain&action=Member&m=kaishi&id=';

        confirm (' 确认手动开始活动吗？',id,url,'确认');
    }


    function top1(id) {
        $.post("index.php?module=bargain&action=Member&m=top", {'id': id}, function (res) {
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