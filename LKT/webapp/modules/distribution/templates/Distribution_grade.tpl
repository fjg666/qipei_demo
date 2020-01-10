

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css?v=1" rel="stylesheet" type="text/css" />

<title>分销商等级</title>
{literal}
<style type="text/css">
    .swivch_bot a{
        width: 111px!important;
        height: 42px!important;
        padding: 0!important;
        border: none!important;
        border-right: 1px solid #ddd!important;
    }
    body {
        font-size: 16px;
    }
    .btn1 {
        padding: 2px 10px;
        height: 40px;
        line-height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        float: left;
        color: #6a7076;
        background-color: #fff;
    }
    .active1{
        color: #fff;
        background-color: #2890FF;
    }
    .swivch a:hover{
    	text-decoration: none;
    	background-color: #2481e5!important;
    	color: #fff;
    }
    td a{
        width: 23%;
        float: left;
        margin: 1% 5%!important;
    }
    td{
        height: 45px!important;
    }
    tr {
        height: 90px!important;
    }
    /*td{overflow:hidden; text-overflow:ellipsis;display:-webkit-box; -webkit-box-orient:vertical;-webkit-line-clamp:1;}*/
</style>
{/literal}
</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>插件管理</span>
	<span class='nav-to' onclick="location.href='index.php?module=distribution&amp;action=Index';"><span class="arrows">&gt;</span>分销商管理</span>
	<span><span class="arrows">&gt;</span>分销等级</span>
</nav>
<div class="iframe-content">
    <div class="navigation">
        <div>
    		<a href="index.php?module=distribution">分销商管理</a>
    	</div>
    	<p class='border'></p>
        <div class='active'>
    		<a href="index.php?module=distribution&action=Distribution_grade">分销等级</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Commission">佣金记录</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Cash">提现记录</a>
    	</div>
    	<p class='border'></p>
    	<div>
    		<a href="index.php?module=distribution&action=Distribution_config">分销设置</a>
    	</div>
    </div>
    <div class="page_h16"></div>
	<button class="btn radius newBtn" style="width: 135px;" onclick="location.href='index.php?module=distribution&action=Distribution_add';">
		<div style="height: 100%;display: flex;align-items: center;font-size: 14px;">
			<img src="images/icon1/add.png"/>&nbsp;添加分销等级
		</div>
	</button>
    <div class="page_h16"></div>
    <div class="iframe-table">
        <table class="table table-border table-bordered table-bg table-hover table-sort">
            <thead>
                <tr class="text-c">
                    <th>分销等级ID</th>
                    <th>分销等级名称</th>
                    <th>升级条件</th>
                    <th>分销比例</th>
                    <th>赠送积分</th>
                    <th>级差奖</th>
                    <th>同级奖</th>
                    <th style="min-width: 120px;">操作</th>
                </tr>
            </thead>
            <tbody >
                {foreach from=$re02 item=item name=f1}
                <tr class="text-c tab_td" style="font-size: 8px;">
                    <td>{$item->id}</td>
                    <td>{$item->sets.s_dengjiname}</td>
                    <td>
                        {if isset($item->levelobj.onebuy)}
                        一次性消费满{$item->levelobj.onebuy}元,
                        {/if}
                        {if isset($item->levelobj.recomm)}
                        推荐{$item->levelobj.recomm.0}个级别为{$item->levelobj.recomm.1}的会员,
                        {/if}
                        {if isset($item->levelobj.manybuy)}
                        累计消费满{$item->levelobj.manybuy}元,
                        {/if}
                        {if isset($item->levelobj.manyyeji)}
                        累计业绩满{$item->levelobj.manyyeji}元,
                        {/if}
                        {if isset($item->levelobj.manypeople)}
                        直推人数满{$item->levelobj.manypeople.0}个，团队人数满{$item->levelobj.manypeople.1}个
                        {/if}  
                    </td>
                    <td>
                       {foreach from=$item->sets.levelmoney item=money key=k}
                       {if $k<=$re.c_cengji && $k<3}
                        {$k}级：{$money}{if $item->sets.price_type==0}%{else}元{/if},<br />
                       {/if}
                       {/foreach}
                    </td>
                    <td>{$item->integral}</td>
                    <td>{$item->sets.different}{if $item->sets.price_type==0}%{else}元{/if}</td>
                    <td>{$item->sets.sibling}{if $item->sets.price_type==0}%{else}元{/if}</td>
                    <td style="width: 120px;">
                        <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要上移该等级吗?<br/><font style=\'font-size:14px;\'>（注意：调整等级顺序将会影响级差奖以及会员升级！）</font>',{$item->id},'index.php?module=distribution&action=Move&cao=up&id=','上移')" title="上移" >
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;display: flex;align-items: center;"> 
                                <img src="images/icon1/sj_g.png"/>&nbsp;上移
                                </div>
                            </div>
                        </a>
                        <a style="text-decoration:none" class="ml-5" href="index.php?module=distribution&action=Distribution_modify&id={$item->id}" title="编辑" >
                        	<div style="align-items: center;font-size: 12px;display: flex;">
				            	<div style="margin:0 auto;display: flex;align-items: center;"> 
				                <img src="images/icon1/xg.png"/>&nbsp;编辑
				            	</div>
							</div>
                        </a>
                        <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要下移该等级吗?<br/><font style=\'font-size:14px;\'>（注意：调整等级顺序将会影响级差奖以及会员升级！）</font>',{$item->id},'index.php?module=distribution&action=Move&cao=down&id=','下移')" title="下移" >
                            <div style="align-items: center;font-size: 12px;display: flex;">
                                <div style="margin:0 auto;display: flex;align-items: center;"> 
                                <img src="images/icon1/xj.png"/>&nbsp;下移
                                </div>
                            </div>
                        </a>
                        <a style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="confirm('确定要删除该分销等级吗?',{$item->id},'index.php?module=distribution&action=Distribution_del&id=','删除')">
                        	<div style="align-items: center;font-size: 12px;display: flex;">
				            	<div style="margin:0 auto;display: flex;align-items: center;"> 
				                <img src="images/icon1/del.png"/>&nbsp;删除
				            	</div>
							</div>
                        </a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <div>{$pages_show}</div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script> 
<script type="text/javascript" src="style/js/layer/layer.js"></script> 
<script type="text/javascript" src="style/js/H-ui.js"></script> 
{literal}
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-42-16-36-16-($('.tb-tab').text()?70:0)
	$('.table-scroll').css('height',Vheight+'px')
	
    function confirm (content,id,url,content1){
    	$("body",parent.document).append(`
    		<div class="maskNew">
    			<div class="maskNewContent">
    				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
    				<div class="maskTitle">提示</div>
    				<div class="maskContent" style="top: 50px;">
    					${content}
    				</div>
    				<div class="maskbtn" style="margin-top: 100px;">
    					<button class="closeMask" style="margin-right:20px" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
    					<button class="closeMask" onclick=closeMask1()>取消</button>
    				</div>
    			</div>
    		</div>`
        )
    }
</script>
{/literal}
</body>
</html>