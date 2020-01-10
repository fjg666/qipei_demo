
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
<title>订单数量报表</title>
</head>
<body>
{include file="../../include_path/nav.tpl" sitename="面包屑"}
<div class="pd-20 page_absolute" >

    <div class="swivch swivch_bot page_bgcolor">
        <a href="index.php?module=report&action=OrderNum" class="btn1 active1 swivch_active">订单概况</a>
    
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c text_c">
        <form method="get" action="index.php" name="form1">
            <div style=" border-left:solid 1px #fff;">
                <input type="hidden" name="module" value="report"  />
                <input type="hidden" name="action" value="OrderNum"  />

                <input type="hidden" name="pagesize" value="{$pagesize}" id="pagesize" />
                
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
   
    <p id="my_day" style="display: none;">{$day_arr}</p>
    <p id="my_sum" style="display: none;">{$sum_arr}</p>
    <p id="my_price" style="display: none;">{$price_arr}</p>
    
 
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover">
            <thead>
                <tr class="text-c">                 
                    <th width="50">订单总数：<span style="color: red;">{$order_all} </span></th>
                    <th width="50">订单总额：<span style="color: red;">¥{$z_price_all} </span></th>
                    <th width="50">有效订单数：<span style="color: red;">{$order_valid} </span></th>
                    <th width="50">有效总额：<span style="color: red;">¥{$z_price_valid} </span></th>
                </tr>
            </thead>
        </table>
  
    </div>

    <div class="mt-20" style="background: #fff ;margin-top: 16px;padding: 16px;">
         <div id="chart" style="height: 400px ;  width: 95% ; margin:0 auto;" ></div>    
    </div>
    
    <div class="mt-20" style="background: #fff ;margin-top: 16px;padding: 16px;">
         <div id="chart1" style="height: 400px ; width: 95% ; margin:0 auto;" ></div>
    </div>

   
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
    <div class="page_h16"></div>
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
<!--<script type="text/javascript" src="style/js/macarons.js"></script>-->
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
        location.replace('index.php?module=report&action=OrderNum');
    }
</script>

<script type="text/javascript">
   
   //echarts初始化-----订单数量折线图
   var myCharts = echarts.init(document.getElementById('chart'),'macarons');
   //获取日期订单数量
   var my_day = JSON.parse($("#my_day").html());
   var my_sum = JSON.parse($("#my_sum").html());

   // console.log(my_day,my_sum);

   var option={
	   	title:{
	            text:'订单数量折线图'
	        },
	        tooltip: {
	            trigger: 'axis'
	        },
	        grid: {
	                  
	            containLabel: true,
	            show:true,
	        },
	        toolbox: {
	             left:800,
	             top:5,
	             feature: {
	                dataZoom: {
	                    show:true,
	                },
	                restore: {},
	                saveAsImage: {},
                    magicType:{
                        type:['line','bar'],
                    }

	            }
	        },
	        dataZoom: [{
	           startValue: my_day[0],
	            }, 
	            {
	            type: 'inside'
	        }],
	         xAxis: {
               

                type:'category',
             
                data: my_day
            
            },
	        yAxis:{
	            type: 'value',
                minInterval: 1,
	        },
	        series:{
	        	name:'订单数',
                type:'line',
               
              
                data: my_sum,
                markPoint : {
                     data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ],

                },
                markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            }
	        }
   }

   myCharts.setOption(option);



   //echarts初始化--------订单总金额折线图
   var my_price = JSON.parse($("#my_price").html());
   var myCharts1 = echarts.init(document.getElementById('chart1'),'macarons');

   var option1 = {
   		title:{
	            text:'销售额折线图'
	        },
	        tooltip: {
	            trigger: 'axis'
	        },
	        grid: {
	                  
                containLabel: true,
                show:true,
	        },
	        toolbox: {
	             left:800,
	             top:5,
	            feature: {
                    dataZoom: {
                        show:true,
                    },
                    restore: {},
                    saveAsImage: {},
                    magicType:{
                        type:['line','bar'],
                    }

                }
	        },
	        dataZoom: [{
	           startValue: my_day[0],
	            }, 
	            {
	            type: 'inside'
	        }],
	         xAxis: {
               
                axisLine:{
                    lineStyle:{
                        color:'red'
                    }
                },

                type:'category',
             
                data: my_day
            
            },
	        yAxis:{
	            type: 'value',
                minInterval: 1,
	        },
	        series:{
	        	name:'销售额',
                type:'line',
               
                color:['#4876FF'],
                data: my_price,
                markPoint : {
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: '平均值'}
                    ]
                }
	        }

   }
   myCharts1.setOption(option1);

</script>
{/literal}
</body>
</html>