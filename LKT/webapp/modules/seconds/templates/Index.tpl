<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="style/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="style/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="style/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="style/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="style/css/style.css" />
{literal}
  <style type="text/css">
   
     .isclick a{
        color: #ffffff;
     }
     .page_bgcolor .status{border: 1px solid #ddd;border-right: 0;}
     .page_bgcolor .status:last-child{border-right: 1px solid #ddd;}
     .page_bgcolor div{
         font-size: 16px;
     }
     .status{
     	width: 80px;
     	height: 34px;
     	line-height: 34px;
	    display: flex;
	    justify-content: center;
	    align-items: center;
	    background-color: #fff;
	    margin-left: 0px;
     }
     .status a:hover{
     	text-decoration: none;
     	color: #fff;
     }
     .status:hover{
     	background-color: #2481e5;
     }
     .status:hover a{
     	color: #fFF;
     }
     .isclick{
     	width:80px;
     	height:34px;
     	background: #2890FF;
     	display: flex;
     	flex-direction: row;
     	align-items: center;
     	justify-content: center;
     	border: 1px solid #2890FF!important;
     }
     td a{
            width: 44%;
            margin: 2%!important;
        }
     
      td button {
          margin:4px;
          float: left;
          background: white;
          color:  #DCDCDC;
          border: 1px #DCDCDC solid;
          width:56px;
          height:22px;
      }
     .tc-box{
         width: 100%;
         height: 100vh;
         position: relative;
         position: fixed;
         background: rgba(0,0,0,0.3);
         display: none;
         top: 0;
     }
     .tc-box > div{
         height: 500px;
         width: 70%;
         position: absolute;
         left: 15%;
         top: 10%;
         background: #fff;
     }
     .tc-box-close{
         position: absolute;
         width: 20px;
         height: 20px;
         text-align: center;
         line-height: 20px;
         right: 10px;
         background: #8e8e8e;
         top: 10px;
         color: #fff;
         border-radius: 100%;
         cursor:hand;
     }
      .confirm{
          width: 100%;
          height: 100%;
          z-index: 999;
          position: fixed;
          top: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          background: rgba(0,0,0,.5);
      }
     .confirm > div{
         background: #fff;
         width: 460px;
         height: 223px;
     }
      .confirm_tips{
          text-align: center;
          height: 150px;
          line-height: 150px;
          font-size:16px;
          font-family:MicrosoftYaHei;
          font-weight:400;
          color:rgba(65,70,88,1);
      }
      .confirm_btn > button{
          width:112px;
          height:36px;
          line-height: 36px;
          border:1px solid #2890FF;
          border-radius:2px;
          color: #2890FF;
      }
      .confirm_btn{
          display: flex;
          justify-content: space-around;
          width: 60%;
          margin-left: 20%;
          text-align: center;
      }

      .hide{
          display: none;
      }

      .qh{
          width: 112px !important;
          height: 42px !important;
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box !important;
          border: unset !important;
      }
	  
	  .border-right{
		  border-right: 1px solid #ddd!important;
	  }
      .add-row{
          display: flex;
          height: 50px;
      }
      .add-title{
          display: flex;
          justify-content: space-between;
          height: 60px;
          border-bottom: 2px #eaeaea solid;
          font-size: 16px;font-weight: bold;
          padding-left: 20px;
          line-height: 60px;
      }
      .close-add{
          padding-right:15px ;
      }
      .close-add img{
          width: 20px;
      }
      .add-row-title{
          width: 165px;
          width: 165px;
          text-align: right;
          height: 50px;
          line-height: 50px;
          font-size: 16px;
      }
      .add-row-ipt-box{
          height: 50px;
          display: flex;
          align-items: center;
      }
     .add-row-ipt-box input .add-row-ipt-box select{
         height: 50px;
         display: flex;
         align-items: center;
         width: 200px;
     }
      .flex{
          display: flex;
      }
      .zhezhao{
          width: 100%;
          height: 100%;
          position: fixed;
          top: 0;
          background: #0000009c;
          display: flex;
          justify-content: center;
          align-items: center;
          z-index: 99999;
          display: none;
      }
      .add-box{
          height: 399px;
          width: 460px;
          background: #fff;
          border-radius: 5px;
          display: none;
      }
      .del-box{
          width: 460px;
          height: 223px;
          background: #fff;
          border-radius: 5px;
          display: none;
      }
     .inputC1+label:after{
         left: 22px !important;
         top: 3px !important;
     }
     .inputC1:checked +label::before{
         left: 23px !important;
         top: 4px !important;
     }
      .add-btn{
          width:112px;
          height:35px;
          border-radius:2px;
          text-align: center;
          line-height: 35px;
          cursor:pointer;
      }
	  
	  .btn_div{
		  display: flex;align-items: center;flex-wrap: wrap;justify-content: center;
		  width: 160px;
          margin: 0 auto;
	  }
	  .btn_div a{
		  display: flex;align-items: center;height: 22px;justify-content: center;
	  }
	  .btn_div a:nth-of-type(odd){width: 82px;}
	  .btn_div a:nth-of-type(even){width: 56px;}
	  .btn_div a:hover{
		  color: #2890FF;
		  border-color: #2890FF;
	  }
	  
	  .add-row-ipt-box>div{
		  width: 65px; padding-left: 3px;
	  }
	  
	[v-cloak]{
		display:none;
	}
  </style>
{/literal}
<title>拼团活动管理</title>
</head>
<body style='display: none;'>
<div id="app" class="iframe-container" v-cloak>
	<nav class="nav-title">
		<span>插件管理</span>
		<span><span class="arrows">&gt;</span>秒杀</span>
		<span><span class="arrows">&gt;</span>秒杀列表</span>
	</nav>
    <div class="iframe-content">
        <div class="navigation">
            <div class="active"><a href="#"  @click="axios">秒杀列表</a></div>
			<p class='border'></p>
            <div><a href="#" @click="go_config">秒杀设置</a></div>
        </div>
        <div class='hr'></div>
        <div class="text-c iframe-search">
            <form name="form1" action="#" method="get" style="display: flex;align-items: center;">
                <input type="hidden" name="module" value="go_group" />
                <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
                <input type="text" name="activityname" size='8' v-model="activityname" id="" placeholder="请输入秒杀活动名称" class="input-text input_180" autocomplete="off">
                <select style="background: #fff;margin-right: 5px;" v-model="msstatus" class="sel_status input_180" name="msstatus">
                    <option value="">请选择秒杀状态</option>
                    <option value="1" >未开始</option>
                    <option value="2" >进行中</option>
                    <option value="3" >结束</option>
                </select>
                <select style="background: #fff;margin-right: 10px!important;" class="sel_status input_180" v-model="mstype" name="mstype">
                    <option value="">请选择秒杀类型</option>
                    <option value="1" >限时秒杀</option>
{*                    <option value="2" >品牌秒杀</option>*}
{*                    <option value="3" >专题秒杀</option>*}
                </select>
                <input name="" id="" class="btn" @click="empty" type="button" value="重置">
                <input name="" id="" class="btn btn-success" type="button" value="查询" @click="axios()">
                {*                <input type="button" id="btn2" value="导出" class="btn btn-success" onclick="excel('all')">*}
            </form>
        </div>
        <div class='hr'></div>
		<div class="flex">
            <a class="btn newBtn radius" @click="open" style="width: auto;padding: 0 18px;margin-right: 8px;">
                <div class='flex' style="height: 100%;align-items: center;font-size: 14px;" >
                    <img src="images/icon1/add.png" style='margin: 0 4px 0 0!important;'/>&nbsp;添加秒杀
                </div>
            </a>
            <a class="btn newBtn radius" @click="go_time" style="width: auto;background: #32B16C !important;padding: 0 18px;">
                <div class='flex' style="height: 100%;align-items: center;font-size: 14px;" >
                    <img src="images/seckill_s.png" style='margin: 0 4px 0 0!important;height: auto;'/>&nbsp;秒杀时段列表
                </div>
            </a>
        </div>
        <div class='hr'></div>
        <div class="iframe-table">
            <table class="table-border tab_content">
                <thead>
                <tr class="text-c tab_tr">
                    <th>序号</th>
                    <th>秒杀活动名称</th>
                    <th>活动状态</th>
                    <th>活动类型</th>
                    <th>活动时间</th>
{*                    <th>是否显示</th>*}
                    <th>操作</th>
{*                  <th>操作</th>*}
                </tr>
                </thead>
                <tbody>
                <tr class="text-c tab_td" v-for="item,index in list">
                    <td>
                        [[item.id]]
                    </td>
                    <td>
                        [[item.name]]
                    </td>
                    <td :style="'color:'+(item.status == '2'?'#0CBC35':item.status == '3'?'#FC152B':'')">
                        [[item.status == '1'?'未开始':item.status == '2'?'进行中':item.status == '3'?'已结束':'']]
                    </td>
                    <td>
                        [[item.type == '1'?'限时秒杀':item.type == '2'?'品牌秒杀':item.type == '3'?'专题秒杀':'']]
                    </td>
                    <td>
                        开始时间：[[item.starttime]]<br>
                        结束时间：[[item.endtime]]
                    </td>
{*                    <td>*}
{*						<div class='switch-box' :class="[item.isshow==1?'active':'']" @click='change_isshow(item)' style='margin: 0 auto;'>*}
{*							<div class='switch-data'></div>*}
{*						</div>*}
{*                    </td>*}
                    <td>
						<div class='btn_div'>
							{*                        <button>按钮</button>*}
							<a title="添加商品" href="javascript:;"  class="ml-5" @click="add_pro($event,item);">
							    <img src="images/icon1/add_g.png"/>&nbsp;添加商品
							</a>
							<a title="编辑" href="javascript:;"  class="ml-5" @click="edit_activity($event,item);">
							    <img src="images/icon1/xg.png"/>&nbsp;编辑
							</a>
							<a title="秒杀记录" href="javascript:;"  class="ml-5" @click="record(item);">
							    <img src="images/icon1/ck.png"/>&nbsp;秒杀记录
							</a>
							<a title="删除" href="javascript:;"  class="ml-5" @click="del_activity($event,item);">
							    <img src="images/icon1/del.png"/>&nbsp;删除
							</a>
						</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="paginationDiv iframe-tab" v-if="total>limit">
        	<div class="changePaginationNum align-center">显示
                <select id="ajaxSee" @change="set_limit" style='margin-left:6px;margin-right:15px'>
                    <option  v-for="(item,index) in limits" :value='item'>[[item]]</option>
                </select>
                条</div>
            <div class="showDataNum align-center">显示 [[(pages-1)*limit+1]] 到 [[pages*limit > total?total:pages*limit]] ，共 [[total]] 条</div>
            <ul class="pagination">
                <li class="">
                </li>
                <li style="padding: 0px 2px;" v-if="pages>1">
                    <a style="width:80px" @click="set_pages('prev')">上一页</a>
                </li>
                <li :class="item == pages?'active':''" style="padding: 0px 2px;" v-for="(item , index) in haspages" @click="set_pages(item)">
                    <a href="#">[[item]]</a>
                </li>
        
                <li style="padding: 0px 2px;" v-if="haspages>1 && haspages != pages">
                    <a style="width:80px" @click="set_pages('next')">下一页</a>
                </li>
                <li>
                </li></ul>
            <div class="clearfix">
            </div>
        </div>
        <div class="zhezhao">
            <div class="add-box" >
                <div class="add-title">
                    [[add_or_edit=="add"?"添加秒杀活动":"编辑秒杀活动"]]
                    <div class="close-add" @click="close"><img src="images/icon/cha.png" alt=""></div>
                </div>
                <div class="page_h10"></div>
                <div class="add-row">
                    <div class="add-row-title">秒杀活动名称：</div>
                    <div class="add-row-ipt-box">
                        <input type="text" name="name" id="name" style="width: 200px;">
                    </div>
                </div>
                <div class="add-row">
                    <div class="add-row-title">秒杀类型：</div>
                    <div class="add-row-ipt-box">
{*                      <input type="text" name="type" id="type">*}
                        <select name="type" id="type" style="width: 200px;height: 36px;" v-if="add_or_edit=='add'">
                            <option value="1">限时秒杀</option>
{*                            <option value="2">品牌秒杀</option>*}
{*                            <option value="3">专题秒杀</option>*}
                        </select>
                        <select name="type" id="type" style="width: 200px;height: 36px;" v-else disabled>
                            <option value="1">限时秒杀</option>
{*                            <option value="2">品牌秒杀</option>*}
{*                            <option value="3">专题秒杀</option>*}
                        </select>
                    </div>
                </div>
                <div class="add-row">
                    <div class="add-row-title">开始时间：</div>
                    <div class="add-row-ipt-box">
{*                        <input type="text">*}
                        <input type="text" class="input-text" value="" autocomplete="off" placeholder="" id="starttime" name="starttime" style="width:200px;">
                    </div>
                </div>
                <div class="add-row">
                    <div class="add-row-title">结束时间：</div>
                    <div class="add-row-ipt-box">
                        <input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="endtime" name="endtime" style="width:200px;">
                    </div>
                </div>

{*                <div class="add-row">*}
{*                    <div class="add-row-title">是否显示：</div>*}
{*                    <div class="add-row-ipt-box" style="width: 200px;display: flex;">*}
{*                        <div>*}
{*                            <input name="isshow"  type="radio" checked="checked" style="display: none;" id="is_subtraction-1" class="inputC1" value="1">*}
{*                            <label for="is_subtraction-1">是</label>*}
{*                        </div>*}
{*                        <div>*}
{*                            <input name="isshow"  type="radio"  style="display: none;" id="is_subtraction-2" class="inputC1" value="0">*}
{*                            <label for="is_subtraction-2">否</label>*}
{*                        </div>*}
{*                    </div>*}
{*                </div>*}
                <div style="height: 75px;justify-content: space-evenly;align-items: center;" class="flex">
                        <div class="add-btn" @click="sbm" style="background:rgba(40,144,255,1);color: #fff;">确定</div>
                        <div class="add-btn" @click="close"  style="border:1px solid rgba(40,144,255,1);color: rgb(40,144,255);">取消</div>
                </div>
            </div>
            <div class="del-box" >
                <div style="height: 148px;text-align: center;line-height: 190px;font-size: 18px;">
                    [[tips]]
                </div>
                <div style="height: 75px;justify-content: space-evenly;align-items: center;" class="flex">
                    <div class="add-btn" @click="sbm_del" style="background:rgba(40,144,255,1);color: #fff;">确定</div>
                    <div class="add-btn" @click="close"  style="border:1px solid rgba(40,144,255,1);color: rgb(40,144,255);">取消</div>
                </div>
            </div>
        </div>
    </div>

    <div class="tc-box" style="z-index: 999999999">
        <div id="ifm-box">
            <div class="tc-box-close">x</div>
            <iframe id="ifm" scrolling="yes" src="" height="100%" width="100%"></iframe>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="style/laydate/laydate.js"></script>
<script type="text/javascript" src="style/vue/vue.js"></script>
{literal}

    <script type="text/javascript">
		$(function(){
			$('body').show();
		})
		
		// 根据框架可视高度,减去现有元素高度,得出表格高度
		// var Vheight = $(window).height()-56-42-16-56-16-36-16-70
		// $('.table-scroll').css('height',Vheight+'px')
		
        var app = new Vue({
            el: '#app',
            delimiters:['[[',']]'],
            data: {
                message: '页面加载于 ' + new Date().toLocaleString(),
                showzhezhao:false,
                showadd:false,
                liststr:"",
                list:[],
                limits:[10,25,50,100],
                limit:10,
                add_or_edit:'',
                total:0,//数据总数
                pages:1,
                haspages:0,
                mstype:"",
                activityname:"",
                msstatus:"",
                time_count:0,//有效的秒杀时段总数
                tips:'',
                del_item:[],//删除数据
            },
            beforeCreate: function () {
                var me = this;
                //初始化数据
                console.log('beforeMount 初始化数据...');
            },
            beforeMount: function (option) {
                var me = this;

                console.log('beforeMount 钩子执行...');
                me.axios();
            },
            methods: {
                axios: function (event) {
                    //初始化数据
                    var me = this;
                    console.log('axios');
                    console.log(me.limit);
                    $.ajax({
                        url:'?module=seconds&action=Member&m=axios',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{
                            limit:me.limit,
                            pages:me.pages,
                            mstype:me.mstype,
                            activityname:me.activityname,
                            msstatus:me.msstatus,
                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            me.list = res.list;
                            me.total = res.total;
                            me.haspages = Math.ceil(me.total/me.limit);
                            me.time_count = res.time_count;
							
							// setTimeout(function(){
							// 	$(".btn_div a").hover(function(){
							// 		console.log(111)
							// 	},function(){
							// 		console.log(222)
							// 	});
							// },100)
                        },
                        //失败/超时
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            console.log("ajax_error");
                            layer.msg('获取数据失败');

                        }
                    })

                },
                set_pages:function(value){
                    var me = this;
                    console.log(value);
                    if(value == 'next'){
                        me.pages = me.pages+1;
                    }else if(value == 'prev'){
                        me.pages = me.pages-1;
                    }else{
                        me.pages = value;
                    }
                    me.axios();
                },
                set_limit:function(){
                    var me = this;
                    me.limit = $("#ajaxSee").val();
                    me.pages = 1;
                    console.log( me.limit);
                    me.axios();
                },
                close: function (event) {
                    var me = this;
                    console.log('close');
                    me.showzhezhao = false;
                    me.showadd = false;
                    $(".add-box").hide();
                    $(".del-box").hide();
                    $(".zhezhao").hide();
                },
                sbm: function (event) {
                    var me = this;
                    console.log('sbm');
                    let name = $("#name").val();
                    let type = $("#type").val();
                    let starttime = $("#starttime").val();
                    let endtime = $("#endtime").val();
                    let starttime_ = starttime+' 00:00:00';
                    let endtime_ = endtime+' 00:00:00';
                    let isshow = $("input[name='isshow']:checked").val();

                    if(name == ''){
                        layer.msg('请填写活动名称！');
                        return false;
                    }
                    if(starttime == ''){
                        layer.msg('请选择开始时间！');
                        return false;
                    }
                    if(endtime == ''){
                        layer.msg('请选择结束时间！');
                        return false;
                    }
                    var stime = new Date(starttime_).getTime();
                    var now = new Date().getTime();
                    var etime = new Date(endtime_).getTime();

                    var myDate = new Date;
                    var year = myDate.getFullYear(); //获取当前年
                    var mon = myDate.getMonth() + 1; //获取当前月
                    var date = myDate.getDate(); //获取当前日
                    var nowtime = year+'-'+mon+'-'+date+' 00:00:00'
                    var nowtime = new Date(nowtime).getTime();

                    console.log('开始时间');
                    console.log(stime);
                    console.log(etime);
                    console.log(now);
                    if( etime < nowtime || stime > etime){
                        layer.msg('时间设置不合格!');
                        return false;
                    }

                    if( stime < now){
                        if(stime != nowtime){
                            layer.msg('开始时间必须大于等于当前时间！');
                            return false;
                        }
                    }
                    if(me.add_or_edit == 'add'){

                        $.ajax({
                            url:'?module=seconds&action=Member&m=add_activity',//地址
                            dataType:'json',//数据类型
                            type:'POST',//类型
                            data:{name:name,
                                type:type,
                                starttime:starttime,
                                endtime:endtime,
                                isshow:isshow
                            },
                            timeout:2000,//超时
                            //请求成功
                            success:function(res){
                                console.log("ajax_success");
                                if(res.code==1){
                                    //成功
                                    me.close();
                                    layer.msg('添加完成');
                                    me.axios();
                                }else{
                                    layer.msg(res.msg);
                                }
                            },
                            //失败/超时
                            error:function(XMLHttpRequest,textStatus,errorThrown){
                                console.log("ajax_error");
                                layer.msg('添加失败');

                            }
                        })
                    }else{
                        $.ajax({
                            url:'?module=seconds&action=Member&m=edit_activity',//地址
                            dataType:'json',//数据类型
                            type:'POST',//类型
                            data:{
                                id:me.add_or_edit,
                                name:name,
                                type:type,
                                starttime:starttime,
                                endtime:endtime,
                                isshow:isshow,
                            },
                            timeout:2000,//超时
                            //请求成功
                            success:function(res){
                                console.log("ajax_success");
                                if(res.code==1){
                                    //成功
                                    me.close();
                                    layer.msg('添加完成');
                                    me.axios();
                                }else{
                                    layer.msg(res.msg);
                                }
                            },
                            //失败/超时
                            error:function(XMLHttpRequest,textStatus,errorThrown){
                                console.log("ajax_error");
                                layer.msg('添加失败');

                            }
                        })
                    }

                },
                open: function (event) {
                    var me = this;
                    $("#name").val('');
                    $("#type").val('');
                    $("[name='isshow'][value='1']").prop("checked", "checked");
                    $("#starttime").val('');
                    $("#starttime").attr("disabled",false);
                    $("#endtime").val('');
                    me.add_or_edit = 'add';
                    me.showzhezhao = true;
                    me.showadd = true;
                    $(".add-box").show();
                    $(".zhezhao").css('display','flex');

                },
                sbm_del:function () {
                    var me = this;
                    console.log(me.del_item.id);
                    $.ajax({
                            url:'?module=seconds&action=Member&m=del_activity',//地址
                            dataType:'json',//数据类型
                            type:'POST',//类型
                            data:{
                                id:me.del_item.id,
                            },
                            timeout:2000,//超时
                            //请求成功
                            success:function(res){
                                console.log("ajax_success");
                                if(res.code==1){
                                    //成功
                                    layer.msg('删除成功！');
                                    me.axios();
                                }else{
                                    layer.msg('删除失败！');
                                }
                            },
                            //失败/超时
                            error:function(XMLHttpRequest,textStatus,errorThrown){
                                console.log("ajax_error");
                            }
                        })

                    me.close();
                    return false



                },
                del_activity:function (event,item) {
                    console.log("del_activity");
                    var me = this;
                    $(".zhezhao").css('display','flex');
                    $(".del-box").show();
                    me.del_item = item;

                    me.tips = '是否删除此条秒杀活动？';
                    if(item.status == 2){
                        me.tips = '活动正在进行，请谨慎删除！';
                    }
                    return  false;

                },
                edit_activity:function (event,item) {
                    var me = this;
                    console.log("edit_activity");
                    me.add_or_edit = item.id;
                    me.name = item.name;
                    me.type = item.type;
                    me.isshow = item.id;
                    $("#name").val(item.name);
                    $("#type").val(item.type);
                    $("[name='isshow'][value='"+item.isshow+"']").prop("checked", "checked");
                    $("#starttime").val(item.starttime);
                    $("#starttime").attr("disabled",false);
                    if(item.status == 2){
                        $("#starttime").attr("disabled",true);
                    }
                    $("#endtime").val(item.endtime);
                    $(".zhezhao").css('display','flex');
                    $(".add-box").show();
                },
                record:function (item) {
                    console.log("record");
                    location.href='index.php?module=seconds&action=Record&activity_id='+item.id;
                },
                add_pro:function (event,item) {
                    console.log("add_pro");
                    var me = this;
                    if(me.time_count > 0){
                        location.href='index.php?module=seconds&action=Addpro&activity_id='+item.id;
                    }else{
                        layer.confirm("你还没有设置秒杀时段，是否跳转时段设置页面",{
                            title: '提示！',
                            btn: ['确定','取消']
                        },function(){
                            location.href='index.php?module=seconds&action=Settime';
                        },function(){
                        });
                    }

                },
                go_time:function () {
                    var me = this;
                    console.log('go_time');
                    location.href='index.php?module=seconds&action=Settime';
                },
                go_config:function () {
                    var me = this;
                    console.log('go_config');
                    location.href='index.php?module=seconds&action=Config';
                },
				change_isshow(item){
					//在修改结果没出来之前,不能再次点击修改
					if(!item.flag_one){
						//储存isshow初始值
						var is_flag=item.isshow
						item.flag_one=true
						item.isshow=item.isshow==1?0:1;
						$.ajax({
						    url:'?module=seconds&action=Member&m=edit_show',//地址
						    dataType:'json',//数据类型
						    type:'POST',//类型
						    data:{
						        id:item.id,
								isshow: item.isshow
						    },
						    timeout:2000,//超时
						    //请求成功
						    success:function(res){
						        console.log("ajax_success");
						        if(res.code==1){
						            //成功
									item.flag_one=false
						            layer.msg('修改成功！');
						            me.axios();
						        }else{
									//修改失败改回来
									item.flag_one=false
									item.isshow=is_flag;
						            layer.msg('修改失败！');
						        }
						    },
						    //失败/超时
						    error:function(XMLHttpRequest,textStatus,errorThrown){
								//修改失败改回来
								item.flag_one=false
								item.isshow=is_flag;
								layer.msg('修改失败！');
						        console.log("ajax_error");
						    }
						})
					}
				},
                empty(){
                    var me = this
                    me.mstype = '';
                    me.activityname = '';
                    me.msstatus = '';
                },
				
            }
        })

        var aa=$(".pd-20").height()-32-$(".page_bgcolor").height()-$(".page_t").height();
        var bb=$(".table-border").height();

        if(aa<bb){
            $(".page_h20").css("display","block")
        }else{
            $(".page_h20").css("display","none")
        }
        laydate.render({
            elem: '#starttime', //指定元素
            trigger: 'click',
            type: 'date',
            done: function(value, date){
                var radio = $("input[name=endtime]:checked").val();

                if(radio == 1){
                    var day = value.split(' ');
                    var str = value.replace(/-/g,'/');
                    var d = new Date(str);
                    var oneYear = oneYearPast(d);
                    oneYear = oneYear + ' ' + day[1];
                    $("#end_year").val(oneYear)
                }
                //alert('你选择的日期是：' + value + '\n获得的对象是' + JSON.stringify(date));
            }
        });
        laydate.render({
            elem: '#endtime',
            trigger: 'click',
            type: 'date'
        });
		
		$("#app").on("mouseover mouseout",".btn_div a",function(event){
			if(event.type == "mouseover"){
			//鼠标悬浮
				if($(this).prop('title')=='添加商品'){
					$(this).find('img').prop('src','images/icon1/add_g_h.png')
				}else if($(this).prop('title')=='编辑'){
					$(this).find('img').prop('src','images/icon1/xg_h.png')
				}else if($(this).prop('title')=='秒杀记录'){
					$(this).find('img').prop('src','images/icon1/ck_h.png')
				}else if($(this).prop('title')=='删除'){
					$(this).find('img').prop('src','images/icon1/del_h.png')
				}
			}else if(event.type == "mouseout"){
				//鼠标离开
				if($(this).prop('title')=='添加商品'){
					$(this).find('img').prop('src','images/icon1/add_g.png')
				}else if($(this).prop('title')=='编辑'){
					$(this).find('img').prop('src','images/icon1/xg.png')
				}else if($(this).prop('title')=='秒杀记录'){
					$(this).find('img').prop('src','images/icon1/ck.png')
				}else if($(this).prop('title')=='删除'){
					$(this).find('img').prop('src','images/icon1/del.png')
				}
			}
		})
    </script>
{/literal}

<!--_footer 作为公共模版分离出去-->

<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="style/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="style/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/js/H-ui.js"></script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>

</html>