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
            .ac_bottom{
                border-bottom: 2px solid  #E9ECEF!important;
            }
        </style>
    {/literal}
</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>会员管理</span>
	<span><span class='arrows'>&gt;</span>会员等级</span>
</nav>
<div class="iframe-content">
	<div class="navigation">
		<div>
			<a href="index.php?module=userlist&action=Index">会员列表</a>
		</div>
		<p class='border'></p>
		<div class='active'>
			<a href="index.php?module=userlist&action=Grade">会员等级</a>
		</div>
		<p class='border'></p>
		<div>
			<a href="index.php?module=userlist&action=Config">会员设置</a>
		</div>
	</div>
    <div class="hr" ></div>
    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=userlist&action=GradeAdd">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加等级
            </div>
        </a>
    </div>
    <div class="hr"></div>
    <div class="mt_20 iframe-table">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr" >
                            <th  class="tab_title ac_bottom">序号</th>
                            <th class="tab_title ac_bottom">等级名称</th>
                            <th  class="tab_title ac_bottom">晋升条件</th>
                            <th class="tab_time ac_bottom">专属折扣</th>
                            <th class="ac_bottom">备注</th>
                            <th class="tab_editor ac_bottom">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="num" value="{$num}" id="num">
                        {foreach from=$list item=item name=f1 key=k}
                        <tr class="text-c tab_td">
                            <td>{$item->id}</td>
                            <td>{$item->name}</td>
                            <td>
                                {if in_array(1,$upgrade)}
                                  <p>购买会员服务</p>
                                {/if}
                                {if in_array(2,$upgrade)}
                                  <p>补差额升级</p>
                                {/if}
                            </td>
                            <td >{$item->rate}折</td>
                            <td>{$item->remark}</td>
                            <td class="tab_editor" >
                                <a style="text-decoration:none" class="ml-7"  href="index.php?module=userlist&action=GradeModify&id={$item->id}" title="编辑">
                                  <img src="images/icon1/xg.png"/>&nbsp;编辑
                                </a> 
                                <a title="删除" href="javascript:;" onclick="confirm('确认删除该会员等级吗？',{$item->id},'index.php?module=userlist&action=Grade&m=del&id=','删除')" class="ml-7" >
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                                </a>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>



<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>


{literal}
<script type="text/javascript">
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