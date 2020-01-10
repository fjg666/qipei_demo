<?php /* Smarty version 2.6.31, created on 2019-12-20 17:11:36
         compiled from Index.tpl */ ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/header.tpl", 'smarty_include_vars' => array('sitename' => "公共头部")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<?php echo '
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
                background-color: white;
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
'; ?>

<title>新增会员</title>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<div class="pd-20 page_absolute">
    <div class="swivch swivch_bot page_bgcolor">
        <a href="index.php?module=report&action=Index" class="btn1 active1 swivch_active">新增会员</a>
        <a href="index.php?module=report&action=UserConsume" class="btn1">会员消费报表</a>
        <a href="index.php?module=report&action=UserSource" class="btn1" style="border-right: 1px solid #ddd!important;">会员比例</a>
        <div class="clearfix" style="margin-top: 0px;"></div>
    </div>
    <div class="page_h16"></div>
    <div class="text-c text_c">
        <form method="get" action="index.php" name="form1" class="names">
            <div >
                <input type="hidden" name="module" value="report"  />
                <input type="hidden" name="action" value="Index"  />

                <input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize" />
                
                <div style="position: relative;display: inline-block;">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['startdate']; ?>
" placeholder="请输入开始时间"  autocomplete="off" id="startdate" name="startdate" style="width:150px;">
                </div>至
                <div style="position: relative;display: inline-block;margin-left: 5px;">
                    <input type="text" class="input-text" value="<?php echo $this->_tpl_vars['enddate']; ?>
" placeholder="请输入结束时间"  autocomplete="off" id="enddate" name="enddate" style="width:150px;">
                </div>
                <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076; height: 31px;" class="reset" onclick="empty()" />

                <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">
                
                
            </div>

        </form>
    </div>
     <div class="page_h16"></div>

    <p id="my_day" style="display: none;"><?php echo $this->_tpl_vars['day_arr']; ?>
</p>
    <p id="my_sum_wx" style="display: none;"><?php echo $this->_tpl_vars['sum_arr_wx']; ?>
</p>
    <p id="my_sum_app" style="display:none;"><?php echo $this->_tpl_vars['sum_arr_app']; ?>
</p>
    <div class="mt_20" style="background: #fff ;margin-top: 20px;padding: 20px;">
       <div id="chart" style="height: 400px ; width: 80% ;margin:0 auto;" > </div>
    </div>
   

    <div class="mt-20">
        
        <table class="table table-border table-bordered table-bg table-hover">
            <thead>
                <tr class="text-c">
                  
                    <th width="40">用户ID</th>
                    <th width="150">用户昵称</th>
                    <th width="150">用户来源</th>
                    <th width="150">注册时间</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                    <tr class="text-c">
                        <th width="40"><?php echo $this->_tpl_vars['item']->id; ?>
</th>
                        <th width="150"><?php echo $this->_tpl_vars['item']->user_name; ?>
</th>

                        <th width="150"><?php if ($this->_tpl_vars['item']->source == 1): ?>小程序<?php else: ?>手机App<?php endif; ?></th>
                        <th width="150"><?php echo $this->_tpl_vars['item']->Register_data; ?>
</th>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
           
            </tbody>
        </table>
    </div>
    <div style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
    <div class="page_h20"></div>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>

<!--<script type='text/javascript' src='modpub/js/calendar.js'> </script>
<script type="text/javascript" src="style/js/jquery.js"></script>
<script type="text/javascript" src="style/FineMessBox/js/common.js"></script>
<script type="text/javascript" src="style/FineMessBox/js/subModal.js"></script>-->

<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>

<!--<script src="style/assets/vendor/chartist/js/chartist.min.js"></script>-->
<!--<script src="style/assets/scripts/klorofil-common.js"></script>-->
<script src="style/js/echarts.js" type="text/javascript" charset="utf-8"></script>
<!--<script type="text/javascript" src="style/js/macarons.js"></script>-->

<script type="text/javascript" src="style/js/laydate/laydate.js"></script>

<?php echo '
<script type="text/javascript">
    //日历
    laydate.render({
        elem:\'#startdate\',
        type:\'date\'
    });
    laydate.render({
        elem:\'#enddate\',
        type:\'date\'
    });
    function empty() {
    location.replace(\'index.php?module=report\');
}
    //echart统计图
    var day_arr = JSON.parse($(\'#my_day\').html());
    var sum_arr_wx = JSON.parse($(\'#my_sum_wx\').html());
    var sum_arr_app = JSON.parse($(\'#my_sum_app\').html());
    

    //实例化echarts
    var myChart = echarts.init(document.getElementById(\'chart\'),\'macarons\');
    //设置option
    var option={
        title:{
            text:\'新增用户折线图\'
        },
        tooltip: {
            trigger: \'axis\'
        },
        legend:{
            top:10,
            data:[\'小程序\',\'手机App\']
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
                        type:[\'line\',\'bar\'],
                    }

                }
        },
        dataZoom: [{
            startValue: day_arr[0],
        }, {
            type: \'inside\'
        }],
        xAxis: [{
                axisLabel: {
                   interval:0,
                   rotate:40
                },
                axisLine:{
                    lineStyle:{
                        color:\'red\'
                    }
                },

                type:\'category\',
                boundaryGap: false,
                data: day_arr
            
            }],
        yAxis:{
            type: \'value\',
          minInterval: 1,
        },
        series: [
            {
                name:\'小程序\',
                type:\'line\',
               
                color:[\'#B3EE3A\'],
                data: sum_arr_wx,
                 markPoint : {
                     data : [
                        {type : \'max\', name: \'最大值\'},
                        {type : \'min\', name: \'最小值\'}
                    ],

                },
                markLine : {
                data : [
                    {type : \'average\', name: \'平均值-小程序\'}
                ]
            }
                
               
            },
            {
                name:\'手机App\',
                type:\'line\',
               
                color:[\'#4876FF\'],
                smooth: 0.3,
                data:sum_arr_app,
                 markPoint : {
                     data : [
                        {type : \'max\', name: \'最大值\'},
                        {type : \'min\', name: \'最小值\'}
                    ],

                },
                markLine : {
                data : [
                    {type : \'average\', name: \'平均值-App\'}
                ]
            }
            }

            
            
            
        ]

    }
    myChart.setOption(option);



</script>

'; ?>

</body>
</html>