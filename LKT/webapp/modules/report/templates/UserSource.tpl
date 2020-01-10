
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
        height: 40px;
        line-height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        float: left;
        color: #6a7076;
        background-color: #fff;
                        width:85px;
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
<title>会员来源报表</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}


<div class="pd-20 page_absolute">

    <div class="swivch swivch_bot page_bgcolor">
        <a href="index.php?module=report&action=Index" class="btn1">新增会员</a>
        <a href="index.php?module=report&action=UserConsume" class="btn1">会员消费报表</a>
        <a href="index.php?module=report&action=UserSource" class="btn1 active1 swivch_active">会员比例</a>
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c text_c">
        <form method="get" action="index.php" name="form1">
            <div >
                <input type="hidden" name="module" value="report"  />
                <input type="hidden" name="action" value="UserSource"  />

             
                <div style="position: relative;display: inline-block;">
                    <input type="text" class="input-text" value="{$startdate}" placeholder="请输入开始时间"  autocomplete="off" id="startdate" name="startdate" style="width:150px;">
                </div>至
                <div style="position: relative;display: inline-block;margin-left: 5px;">
                    <input type="text" class="input-text" value="{$enddate}" placeholder="请输入结束时间"  autocomplete="off" id="enddate" name="enddate" style="width:150px;">
                </div>
                <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

                <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">
                
                
            </div>

        </form>
    </div>
     <div class="page_h16"></div>
    <input type="hidden" name="my_wx"  value="{$num_wx}">
    <input type="hidden" name="my_app" value="{$num_app}">
  
    

    <div class="mt-20" style="background: #fff;padding:20px;">
        <div id="chart" style="height: 600px ; width: 80% ;margin:0 auto;" ></div>
      
    </div>
    <div style="text-align: center;display: flex;justify-content: center;"></div>
    <div class="page_h2"></div>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>

<!--<script type='text/javascript' src='modpub/js/calendar.js'> </script>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/FineMessBox/js/common.js"></script>
<script type="text/javascript" src="style/FineMessBox/js/subModal.js"></script>-->

<!--<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>-->
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<!--<script type="text/javascript" src="style/js/H-ui.admin.js"></script>-->
<!--<script src="style/assets/vendor/chartist/js/chartist.min.js"></script>-->
<!--<script src="style/assets/scripts/klorofil-common.js"></script>-->
<script src="style/js/echarts.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

{literal}

<script type="text/javascript">
    //日历
    laydate.render({
        elem:'#startdate',
        type:'date'
    });
    laydate.render({
        elem:'#enddate',
        type:'date'
    });

    function empty(){
        location.replace('index.php?module=report&action=user_source');
    }

</script>

<script type="text/javascript">
    //获取当前时间
    var my_time = getFormatDate();
    console.log(my_time);
   //echarts 统计图
   var num_wx = $('input[name=my_wx]').val();
   var num_app = $('input[name=my_app]').val();

   //初始化echarts
   var myChart = echarts.init(document.getElementById('chart'),null,{renderer:'svg'});
   //设置参数
   option = {
    tooltip: {
        trigger: 'item',
        formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left:50,
        top:220,
        data:['微信小程序','手机App']
    },
    title: {
    	text:'用户来源比例图',
    	left:50,
        top:130,
    	textStyle:{
    		color:'#2287FE',
    		fontSize:30,
            lineHeight: 200,
    	},
    	subtext:'来客电商-----'+my_time,
        selected:{
            '微信小程序':true,
        }

    },
    color:[
        '#F8DD29',
        '#F49610'
    ],
    series: [
        {
            name:'访问来源',
            type:'pie',
            radius: ['50%', '70%'],
            avoidLabelOverlap: false,
            label: {
                normal: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '30',
                        fontWeight: 'bold'
                    }
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data:[
                {value:num_wx, name:'微信小程序'},
                {value:num_app, name:'手机App'}
               
            ]
        }
    ]
};
function getFormatDate(){
    var nowDate = new Date();
    var year = nowDate.getFullYear();
    var month = nowDate.getMonth() + 1 < 10 ? "0" + (nowDate.getMonth() + 1) : nowDate.getMonth() + 1;
    var date = nowDate.getDate() < 10 ? "0" + nowDate.getDate() : nowDate.getDate();
   
    return year + "-" + month + "-" + date;
}

  	myChart.setOption(option);	
</script>


{/literal}
</body>
</html>