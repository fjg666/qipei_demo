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
    <link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css"/>

    <title>活动列表</title>
   
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute">
  <div class="page_h16"></div>
    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=third&action=TemplateMsgAdd">
            <div style="height: 100%;display: flex;align-items: center;">
                      &nbsp;&nbsp;&nbsp;添加消息
             
            </div>
        </a>
    </div>
    <div class="page_h16"></div>
    <div class="">
        <div class="tab_table">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr">
                            <th class="tab_title">序号</th>
                            <th class="tab_title">模板消息名称</th>
                            <th class="tab_imgurl">对应字段</th>
                            <th class="tab_title">模板库id</th>
                            <th class="tab_title">组合关键词</th>
                          	<th class="tab_title">更新时间</th>
                            <th class="tab_editor">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$res item=item key = k}

                        <tr class="text-c tab_td">
                           
                            
                            <td class="tab_title" style="text-align:center!important;">{$k}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->c_name}</td>
                            <td class="tab_title" style="text-align: center!important;">{$item->e_name}</td>
                            <td class="tab_title" style="text-align: center!important;">{$item->stock_id}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->stock_key}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->update_time}</td>    
                            <td class="tab_editor" >
                               <a style="text-decoration:none" class="ml-7" href="index.php?module=third&action=TemplateMsgModify&id={$item->id}" title="编辑">
                                    <img src="images/icon1/xg.png"/>&nbsp;编辑
                               </a> 
                               <a style="text-decoration:none"  class="ml-7" href="javascript:;" onclick="confirm('确认要删除吗？',{$item->id},'index.php?module=third&action=TemplateMsgModify&m=del&id=','删除')" title="删除">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                            </td>
                        
                         
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
        </div> 
    </div>
    
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>

{literal}

<script type="text/javascript">

    function confirm (content,id,url,content1){

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