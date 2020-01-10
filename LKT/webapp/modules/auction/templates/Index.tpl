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
<!--     <link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/> -->

    <title>活动列表</title>
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
        </style>
    {/literal}
</head>
<body style='display: none;'>
<nav class="breadcrumb page_bgcolor page-container" style="padding-top: 0px;font-size: 16px;">
      <span  style='color: #414658;'>插件管理</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>竞拍</span>
      <span  class="c-gray en">&gt;</span>
      <span  style='color: #414658;'>竞拍商品</span>
</nav>
<div class="pd-20 page_absolute">
	<div class="swivch page_bgcolor swivch_bot" style="margin-top: 0px;font-size: 16px;">
        <a href="index.php?module=auction" class="btn1 active1 swivch_active" style="height: 42px!important;width: 90px;border:none!important;border-top-left-radius: 3px;
    border-bottom-left-radius: 3px;">竞拍商品</a>
        <a href="index.php?module=auction&action=Config" class="btn1" style="height: 42px!important;width: 91px;border:none!important; border-top-right-radius: 3px; border-bottom-right-radius: 3px;">竞拍设置</a>
       <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16" style="height: 16px!important;"></div>
    <div class="text-c" style="">
        <form name="form1" action="index.php" method="get" class="pd_form1">
            <input type="hidden" name="module" value="auction"/>
            <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
            <input type="text" name="title" size='8' value="{$title}" id="" placeholder="请输入商品名称" class="input-text query_inputs" style="border: 1px solid rgb(213, 219, 232)!important;">
            <select name="status" class="select query_select" style="background-color: #ffffff">
                <option value="" >请选择活动状态</option>
                <option value="0" {if $status === '0'}selected="selected"{/if} >未开始</option>
                <option value="1" {if $status == 1}selected="selected"{/if}>竞拍中</option>
                <option value="2" {if $status == 2}selected="selected"{/if}> 已结束 </option>
           </select>

           <input type="button" value="重置" id="btn8" class="reset" onclick="empty()" style='color: #6A7076;'/>
           <input name="" id="btn1" class="query_cont nmor" type="submit" value="查询">
        </form>
    </div>
    <div class="page_h16" ></div>
    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=auction&action=Add">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加商品
            </div>
        </a>
        <a href="javascript:;" id="btn6" onclick="datadel('index.php?module=auction&action=Change&m=del&id=','删除')" style="height: 36px;background: #fff;color: #6a7076;border: none;" class="btn btn-danger radius">
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
                            <th class="tab_title" style="border-bottom: 2px solid #E9ECEF!important;text-align: left;">活动商品信息</th>
                            <th class="tab_title" style="border-bottom: 2px solid  #E9ECEF!important;">商家名称</th>
                            <th class="tab_time" style="border-bottom: 2px solid  #E9ECEF!important;">活动时间</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">起拍价</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">当前竞拍价</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">活动标签</th>
                            <th style="border-bottom: 2px solid  #E9ECEF!important;">是否显示</th>
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
                            <td style="display: flex;justify-content: left;">
                                <div style="display: flex; position: relative;flex-direction: column;justify-content: center;width: 70px;height: 88px;">
                                    <img onclick="pimg(this)" class="pro-img" style="width: 60px;height:60px;" src="{$item->image}">
                                </div>
                                <div style="width: 100px;padding-top: 20px;">
                                    <p align="left" style="width: 110px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;margin-bottom: 0px;" title="{$item->title}">{$item->title}</p>
                                    <p style="text-align: left;">
                                        <span style="color:green;">
                                            {if $item->status==0}
                                                <span style="color: orange;">未开始</span>
                                            {elseif $item->status==1}
                                                <span style="color:green;">竞拍中</span>
                                            {elseif $item->status==2}
                                                <span style="color: red;">已结束</span>
                                            {elseif $item->status ==3 }
                                                <span style="color: red">已结束</span>
                                            {/if}
                                        </span>
                                    </p>
                                </div>
                            </td>
                            <td>{$item->name}</td>
                            <td class="tab_time">开始时间：{$item->starttime}<br />结束时间：{$item->endtime}</td>
                            <td>￥{$item->price}</td>
                            <td>￥{$item->current_price}</td>
                            <td>{$item->tag}</td>
                            <td>
                                <div style="display: flex;justify-content: center;align-items: center;">
                                    <div class="change_box">
                                        <div class="wrap" onclick="up({$k},{$item->id})" is_show="{$item->is_show}" style="margin-left: 0;{if $item->is_show==1}background-color:#2890FF;{else}background-color: #ccc;{/if}">
                                            <div class="circle" id="circle_{$k}" style="{if $item->is_show==1}left:30px;{else}left:0px;{/if}"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="tab_editor" >
                               <div style="display: flex;justify-content: center;align-items: center;">
								   <a style="text-decoration:none" class="ml-7" href="index.php?module=auction&action=Record&id={$item->id}" title="详情">
								       <img src="images/icon1/ck.png"/>&nbsp;详情
								   </a> 
								   {if $item->status==0  }
								        <a style="text-decoration:none" class="ml-7" onclick="aj({$item->id})" href="javascript:void(0);" title="开始">   
								               <img src="images/icon1/sj_g.png"/>&nbsp;开始
								        </a> 
								   {/if}  
								   {if $item->status == 1}
								        <a style="text-decoration:none" class="ml-7" onclick="confirm('确认停止该活动的商品活动？',{$item->id},'index.php?module=auction&action=Change&m=siwtch&id=','停止')" href="javascript:void(0);" title="停止">
								               <img src="images/icon1/xj.png"/>&nbsp;停止
								        </a>  
								   {/if}
								    {if $item->status == 0 || ($item->status == 1 && $item->is_show == 0) }
								        <a style="text-decoration:none" class="ml-7" onclick="my_warn({$item->status})" href="index.php?module=auction&action=Modify&id={$item->id}" title="编辑">
								          <img src="images/icon1/xg.png"/>&nbsp;编辑
								        </a> 
								    {/if}
								   {if $item->status != 1 }
								    <a title="删除" href="javascript:;" onclick="confirm('确认删除该竞拍活动商品记录么？',{$item->id},'index.php?module=auction&action=Change&m=del&id=','删除')" class="ml-7" >
								        <img src="images/icon1/del.png"/>&nbsp;删除
								    </a>
								    {/if}
							   </div>
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
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
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
            console.log(123)
            $("input[name=title]").val("")
            $("select[name=status]").val("")
        }

		// 进入页面时控制是否显示的选项选择默认,已放在行内用PHP控制
        // var num = $("input[name='num']").val();
        // var status;
        // for(var i=0;i<num;i++){
        //     status = $("#circle_"+i).parent(".wrap").attr("is_show");
        //     if(status == 0){
        //         // $('#circle_'+i).css('left', '0px'),
        //         $('#circle_'+i).css('background-color', '#fff'),
        //         $('#circle_'+i).parent(".wrap").css('background-color', '#ccc');
        //     }else{
                // $('#circle_'+i).css('left', '30px'),
        //         $('#circle_'+i).css('background-color', '#fff'),
        //         $('#circle_'+i).parent(".wrap").css('background-color', '#2890FF');
        //     }
        //     
        // }
       var have_click = 0
        function up(k,id){
            var status_1 = $("#circle_"+k).parent(".wrap").attr("is_show");
            have_click = have_click + 1
            console.log(have_click)
            if(have_click >= 2){
                 return false
            }
           
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
            $.post("index.php?module=auction&action=Change&m=show",{id:id,is_show:status_1},function(data){
                layer.msg(data.msg,{time:2000});

                location.replace(location.href);

            },'json');

        }

//ajax请求，开始和结束活动
function aj(id){
    $.post("index.php?module=auction&action=Change&m=siwtch",{'id':id},function(res){

            if(res.start == 1){
                layer.msg(res.info, {time: 10000});
                // if(res.suc){
                    location.replace(location.href);
                // }
            }
           

    },'json');

}


  //警告函数
  function my_warn(status){
    
    if(status == 1){
        alert('请谨慎编辑正在进行中的竞拍活动！');
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
    confirm('确认删除所选中的竞拍活动商品记录么？',Id,url,content)
    
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