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
          height: 307px;
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
	  [v-cloak]{
		display:none;
	}
  </style>
{/literal}
<title>秒杀时段管理</title>
</head>
<body >
<div id="app" v-cloak>
    <nav class="breadcrumb" style="font-size: 16px;"><span class="c-gray en"></span><i class="Hui-iconfont">&#xe67f;</i> 插件管理
        <span class="c-gray en">&gt;</span>
        <a style="margin-top: 10px;" onclick="location.href='index.php?module=seconds&action=Index';">秒杀 </a>
        <span class="c-gray en">&gt;</span>秒杀时段列表
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="page-container pd-20 page_absolute">
        <div class="page_h16"></div>
        <div class="text-c" >
        </div>
        <div class="page_bgcolor page_t">
            <div class="page_h16"></div>
            <a class="btn newBtn radius" @click="open" style="width: 144px;">
                <div style="height: 100%;display: flex;align-items: center;" >
                    <img src="images/icon1/add.png"/>&nbsp;添加秒杀时段
                </div>
            </a>
        </div>
        <div class="page_h16"></div>
        <div class="mt-20 table-scroll">
            <table class="table-border tab_content">
                <thead>
                <tr class="text-c tab_tr">
                    <th style="width:10%">序号</th>
                    <th style="width:30%;">时段名称</th>
                    <th style="width:20%;">开始时间</th>
                    <th style="width:20%">结束时间</th>
                    <th style="width: 350px;">操作</th>
{*                    <th>操作</th>*}
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
                    <td>
                        [[item.starttime]]
                    </td>
                    <td>
                        [[item.endtime]]
                    </td>
                    <td style="display: flex;align-items: center;justify-content: center;">
                        </a>
{*                        <a title="编辑" href="javascript:;"  class="ml-5" @click="edit_activity_time($event,item);" style="display: flex;align-items: center;height: 22px;text-align: center;">*}
{*                            <img src="images/icon1/del.png"/>&nbsp;编辑*}
{*                        </a>*}
                        <a title="删除" href="javascript:;"  class="ml-5" @click="del_activity_time($event,item);" style="display: flex;justify-content: center;align-items: center;height: 22px;text-align: center;">
                            <img src="images/icon1/del.png"/>&nbsp;删除
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: center;display: flex;justify-content: center;">
            <div class="paginationDiv" style="    position: fixed;bottom: 0;border-left: 20px #edf1f5 solid;" v-if="total>limit"> <div class="changePaginationNum">显示
                    <select id="ajaxSee" @change="set_limit">
                        <option  v-for="(item,index) in limits" :value='item'>[[item]]</option>
                    </select>
                    条</div>
                <div class="showDataNum">显示 [[(pages-1)*limit+1]] 到 [[pages*limit > total?total:pages*limit]] ，共 [[total]] 条</div>
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
        </div>
        <div class="page_h20"></div>
        <div class="zhezhao" >
            <div class="add-box" >
                <div class="add-title">
                    [[add_or_edit == 'add'?'添加':'编辑']]秒杀时段
                    <div class="close-add" @click="close"><img src="images/icon/cha.png" alt=""></div>
                </div>
                <div class="page_h10"></div>
                <div class="add-row">
                    <div class="add-row-title"><span style="color: red">*</span>秒杀时段名称：</div>
                    <div class="add-row-ipt-box">
                        <input type="text" name="name" id="name" style="width: 200px;">
                    </div>
                </div>
                <div class="add-row">
                    <div class="add-row-title"><span style="color: red">*</span>开始时间：</div>
                    <div class="add-row-ipt-box">
{*                        <input type="text">*}
                        <input type="text" v-if="total > 0" disabled class="input-text" value="" autocomplete="off" placeholder="" id="starttime" name="starttime" style="width:200px;">
                        <input type="text" v-else   class="input-text" value="" autocomplete="off" placeholder="" id="starttime" name="starttime" style="width:200px;">
                    </div>
                </div>
                <div class="add-row">
                    <div class="add-row-title"><span style="color: red">*</span>结束时间：</div>
                    <div class="add-row-ipt-box">
                        <input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="endtime" name="endtime" style="width:200px;">
                    </div>
                </div>

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
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="style/laydate/laydate.js"></script>
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/vue/vue.js"></script>
{literal}

    <script type="text/javascript">
        var app = new Vue({
            el: '#app',
            delimiters:['[[',']]'],
            data: {
                message: '页面加载于 ' + new Date().toLocaleString(),
                showzhezhao:false,
                showadd:false,
                liststr:"",
                list:[],
                all_list:[],
                limits:[10,25,50,100],
                limit:10,
                add_or_edit:'',
                total:0,//数据总数
                pages:1,
                haspages:0,
                activity_total:0,//是否有进行中的活动 0没有 1 有
                del_item:[],//删除时段数据
                tips:'',//删除提示
            },
            beforeCreate: function () {
                var me = this;
                //初始化数据
                console.log('beforeMount 初始化数据...');
            },
            beforeMount: function () {
                var me = this;

                console.log('beforeMount 钩子执行...');
                me.axios();
                console.log(me.liststr);
                console.log(me.list);
                console.log(me.test);
            },
            methods: {
                axios: function (event) {
                    //初始化数据
                    var me = this;
                    console.log('axios');

                    $.ajax({
                        url:'?module=seconds&action=Settime',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{
                          m:'axios',
                          limit:me.limit,
                          pages:me.pages,
                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            console.log("ajax_success");
                            console.log(res);
                            me.list = res.list;
                            me.all_list = res.all_list;
                            me.total = res.total;
                            me.activity_total = res.activity_total;
                            me.haspages = Math.ceil(me.total/me.limit);
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

                    var myDate = new Date;
                    var year = myDate.getFullYear(); //获取当前年
                    var mon = myDate.getMonth() + 1; //获取当前月
                    var date = myDate.getDate(); //获取当前日
                    var starttime = year+'-'+mon+'-'+date+' '+$("#starttime").val();
                    var endtime = year+'-'+mon+'-'+date+' '+$("#endtime").val();
                    var starttime1 = $("#starttime").val();
                    var endtime1 = $("#endtime").val();

                    let name = $("#name").val();


                    if(name == ''){
                        layer.msg('请填写时段名称！');
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
                    var stime = new Date(starttime).getTime();
                    var now = new Date().getTime();
                    var etime = new Date(endtime).getTime();
                    console.log('开始时间');
                    console.log(stime);
                    if(stime >= etime){
                        layer.msg('结束时间必须大于开始时间!');
                        return false;
                    }

                        if(me.add_or_edit == 'add'){
                            $.ajax({
                                url:'?module=seconds&action=Settime&m=add_activity_time',//地址
                                dataType:'json',//数据类型
                                type:'POST',//类型
                                data:{
                                    name:name,
                                    starttime:starttime1,
                                    endtime:endtime1,
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
                                url:'?module=seconds&action=Settime&m=edit_activity_time',//地址
                                dataType:'json',//数据类型
                                type:'POST',//类型
                                data:{
                                    id:me.add_or_edit,
                                    name:name,
                                    starttime:starttime,
                                    endtime:endtime,
                                },
                                timeout:2000,//超时
                                //请求成功
                                success:function(res){
                                    console.log("ajax_success");
                                    if(res.code==1){
                                        //成功
                                        me.close();
                                        layer.msg(res.msg);
                                        me.axios();
                                    }else{
                                        layer.msg(res.msg);
                                    }
                                },
                                //失败/超时
                                error:function(XMLHttpRequest,textStatus,errorThrown){
                                    console.log("ajax_error");
                                    layer.msg('修改失败！');

                                }
                            })
                        }

                },
                open: function (event) {
                    var me = this;
                    console.log('open');
                    $("#name").val('');
                    $("#type").val('');
                    $("[name='isshow'][value='1']").prop("checked", "checked");
                    $("#starttime").val('');
                    $("#endtime").val('');
                    me.add_or_edit = 'add';
                    me.showzhezhao = true;
                    me.showadd = true;

                   if(me.total > 0){
                       var time_b = '';
                       $.each( me.all_list, function(index, content){
                           if(time_b == ''){
                               time_b = content.endtime
                               console.log(content.endtime);
                           }else{
                               console.log(content.endtime);

                               if(content.starttime != time_b){

                                   $("#starttime").val(time_b);
                                   $(".add-box").show();
                                   $(".zhezhao").css('display','flex');
                               }else{
                                   time_b = content.endtime

                               }
                           }
                       });
                       $("#starttime").val(time_b);
                   }

                    $(".add-box").show();
                    $(".zhezhao").css('display','flex');


                },
                sbm_del:function () {
                    var me = this;
                    console.log(me.del_item.id);
                    $.ajax({
                        url:'?module=seconds&action=Settime&m=del_activity_time',//地址
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
                                me.axios();
                                layer.msg('删除成功！');
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
                del_activity_time:function (event,item) {
                    var me = this;
                    var now = new Date().getTime();
                    var myDate = new Date;
                    var year = myDate.getFullYear(); //获取当前年
                    var mon = myDate.getMonth() + 1; //获取当前月
                    var date = myDate.getDate(); //获取当前日
                    var starttime = year+'-'+mon+'-'+date+' '+item.starttime
                    var endtime = year+'-'+mon+'-'+date+' '+item.endtime
                    var stime = new Date(starttime).getTime();
                    var etime = new Date(endtime).getTime();
                    if(now < etime && now > stime){
                       if(me.activity_total != 0){
                           layer.msg('不可删除正在进行中的时段！');
                           return  false
                       }
                    }
                    me.del_item = item;
                    me.tips = "是否删除此条秒杀时段？";
                    $(".zhezhao").css('display','flex');
                    $(".del-box").show();
                    return  false;
                },
                edit_activity_time:function (event,item) {
                    var me = this;
                    console.log("edit_activity");
                    me.add_or_edit = item.id;
                    me.name = item.name;
                    me.type = item.type;
                    me.isshow = item.id;
                    $("#name").val(item.name);
                    $("#starttime").val(item.starttime);
                    $("#endtime").val(item.endtime);
                    $(".zhezhao").css('display','flex');
                    $(".add-box").show();
                },
                record:function (event) {
                    console.log("record");
                },
                add_pro:function (event) {
                    console.log("add_pro");
                },
                go_time:function () {
                    var me = this;


                }
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
            type: 'time',
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
            type: 'time'
        });

    </script>
{/literal}

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="style/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="style/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/js/H-ui.js"></script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>

</html>