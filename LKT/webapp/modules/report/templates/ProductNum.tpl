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
        <a class="btn newBtn radius" href="javascript:;">
            <div style="height: 100%;display: flex;align-items: center;">
                      &nbsp;&nbsp;&nbsp;商品报表
             
            </div>
        </a>
    </div>
    <div class="page_h16"></div>
    <div class="text-c" class="pd_form1" style="height: 60px;">
        <table class="table-border tab_content">
            <tr class="text-c tab_tr">
                <th class="tab_title" style="font-size: 17px;">上架商品数 ：&nbsp;<span style="color: red;font-size: 17px;">{$product_num}</span></th>
                
                <th style="left: -20%;font-size: 17px;" class="tab_title">对接店铺数 ：&nbsp;<span style="color: red;font-size: 17px;">{$customer_num}</span></th>
            </tr>
        </table>
       
    </div>
    <div class="page_h16"></div>
    <div class="text-c" style="height: 600px;background-color: #fff;">
       
        <div id="chart" style="height: 600px ;  width: 95% ; margin:30px auto;">
            
        </div>

    </div>
     <div class="page_h16"></div>
    <div class="text-c" style="height: 600px;background-color: #fff;">
     
        <div id="chart1" style="height: 600px; width: 95%;margin: 30px auto;">
            
        </div>    
    </div>

    <div class="page_h16"></div>

   
    <div class="">

        <div class="tab_table">

            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr">
                            <th class="tab_title">序号</th>
                            <th class="tab_title">商品编号</th>
                            <th class="tab_title">商品名称</th>
                            <th class="tab_imgurl">商品图片</th>
                            <th class="tab_title">商品规格</th>
                            <th class="tab_title">总库存</th>
                            <th class="tab_title">剩余库存</th>
                            <th class="tab_title">预警时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$res_stock item=item key=k}

                        <tr class="text-c tab_td">
                           
                            
                            <td class="tab_title" style="text-align:center!important;">{$k}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->product_number}</td>
                            <td class="tab_title" style="text-align:center!important;">{$item->product_title}</td>
                            <td class="tab_imgurl"><img src="{$item->image}" style="width: 60px;height:60px;"/></td>
                            <td class="tab_title" style="text-align: center!important;">{$item->specifications}</td>
                            <td class="tab title" style="text-align: center!important;">{$item->total_num}</td>
                            <td class="tab title" style="text-align: center!important;">{$item->num}</td>
                            <td class="tab title" style="text-align: center!important;">{$item->add_date}</td>
                           
                        </tr>
                        {/foreach}
                    </tbody>
            </table>
        </div> 
    </div>
    <div style="text-align: center;display: flex;justify-content: center;">{$pages_show}</div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>
<script src="style/js/echarts.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="style/js/macarons.js"></script>



 
<script type="text/javascript">
    
    var in_out = {$in_out};
    console.log(in_out);
    
    //前十销量排行echarts
    var res_top_title_0 = "{$res_top_title_0}"; 
    var res_top_title_1 = "{$res_top_title_1}";
    var res_top_title_2 = "{$res_top_title_2}";
    var res_top_title_3 = "{$res_top_title_3}";
    var res_top_title_4 = "{$res_top_title_4}";
    var res_top_title_5 = "{$res_top_title_5}";
    var res_top_title_6 = "{$res_top_title_6}";
    var res_top_title_7 = "{$res_top_title_7}";
    var res_top_title_8 = "{$res_top_title_8}";
    var res_top_title_9 = "{$res_top_title_9}";

    var res_top_volume_0 = "{$res_top_volume_0}";
    var res_top_volume_1 = "{$res_top_volume_1}";
    var res_top_volume_2 = "{$res_top_volume_2}";
    var res_top_volume_3 = "{$res_top_volume_3}";
    var res_top_volume_4 = "{$res_top_volume_4}";
    var res_top_volume_5 = "{$res_top_volume_5}";
    var res_top_volume_6 = "{$res_top_volume_6}";
    var res_top_volume_7 = "{$res_top_volume_7}";
    var res_top_volume_8 = "{$res_top_volume_8}";
    var res_top_volume_9 = "{$res_top_volume_9}";
   
    
    


{literal}
    
    //前十销量echarts
    var myCharts = echarts.init(document.getElementById('chart'),'macarons'); //echarts初始化
  
    var option ={//设置echarts选项

        title:{
            text:'商品前十销量排行',
            x:'right'
        },
        tooltip:{
            trigger:'item',
            formatter:"{a} <br/>{b} : {c} ({d}%)"
        },
        legend:{
            orient:'vertical',
            left:'left',
            data:[res_top_title_0,res_top_title_1,res_top_title_2,res_top_title_3,res_top_title_4,res_top_title_5,res_top_title_6,res_top_title_7,res_top_title_8,res_top_title_9]
        },
        series:[
            {
                name:'销量排行',
                type:'pie',
                radius:'60%',
                center:['50%','60%'],
                data:[
                    {value:res_top_volume_0,name:res_top_title_0},
                    {value:res_top_volume_1,name:res_top_title_1},
                    {value:res_top_volume_2,name:res_top_title_2},
                    {value:res_top_volume_3,name:res_top_title_3},
                    {value:res_top_volume_4,name:res_top_title_4},
                    {value:res_top_volume_5,name:res_top_title_5},
                    {value:res_top_volume_6,name:res_top_title_6},
                    {value:res_top_volume_7,name:res_top_title_7},
                    {value:res_top_volume_8,name:res_top_title_8},
                    {value:res_top_volume_9,name:res_top_title_9}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]

    };

    myCharts.setOption(option);

    //循环设置参数数组
    var class_name = [];//一级分类名称
    var num_in = [];//入库
    var num_out = [];//出库
    var num = [];//剩余库存

    for(var i=0;i<in_out.length;i++){

        class_name[i] = in_out[i].pname;
        num_in[i] = in_out[i].num_in;
        num_out[i] = in_out[i].num_out;
        num[i] = in_out[i].num;

    }
   

    //入库出库统计echarts

    var myCharts1 = echarts.init(document.getElementById('chart1'),'macarons');

    var option1 = {
        title : {
            text: '商品库存对比',
            x:'right'
        },
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
        },
        legend: {
            data:['入库数量','出库数量','剩余库存']
        },
       
       
        xAxis : [
            {
                type : 'category',
                data : class_name
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'入库数量',
                type:'bar',
                data:num_in,
               
               
            },
            {
                name:'出库数量',
                type:'bar',
                data:num_out,
               
            },
            {
                name:'剩余库存',
                type:'bar',
                data:num,
               
            }
        ]
    }
    myCharts1.setOption(option1); 

</script>
{/literal}
</body>
</html>