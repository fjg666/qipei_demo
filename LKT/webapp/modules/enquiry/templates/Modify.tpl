<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="style/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="style/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="style/lib/Hui-iconfont/1.0.7/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="style/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="style/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--/meta 作为公共模版分离出去-->
    {literal}
        <style type="text/css">
            body{background-color: #edf1f5;height: 100vh;}
            　　　/*隐藏掉我们模型的checkbox*/
            .my_protocol .input_agreement_protocol {
                appearance: none;
                -webkit-appearance: none;
                outline: none;
                display: none;
            }
            /*未选中时*/
            .my_protocol .input_agreement_protocol+span {
                width: 16px;
                height: 16px;
                background-color: red;
                display: inline-block;
                background: url(../../Images/TalentsRegister/icon_checkbox.png) no-repeat;
                background-position-x: 0px;
                background-position-y: -25px;
                position: relative;
                top: 3px;
            }
            /*选中checkbox时,修改背景图片的位置*/
            .my_protocol .input_agreement_protocol:checked+span {
                background-position: 0 0px
            }
            .inputC:checked +label::before{
                top: -3px;
                position: relative;
            }

            #addpro{
                background: #ccc;
                padding: 20px;
                border-radius: 4px;
            }
            .protitle{
                overflow: hidden;
            }
            .hide{
                display: none;
            }
            .barginprice{
                border-radius: 5px;
                width: 120px;
            }
            .redport{
                border:2px red solid;
            }
            .sysyattr{
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999;
                background: rgba(0,0,0,0.5);

            }
            .sysyattr_div{
                width: 100%;
                height: 100%;
                display:flex;
            }
            .sys_c{
                width:70%;
                height: 70%;
                margin:auto;
                background: white;
                border-radius: 20px;
            }
            .modalshow{
                display: none;
            }
            .modaltitle{
                padding:10px;
                width:100%;
                height:7%;
            }
            .switch-box.active{
                background: #23b700 !important;
            }
            .breadcrumb{padding: 0;margin: 0;margin-left: 10px;background-color: #edf1f5;}
            #form-category-add{padding:0 14px;}
            .text-c th{border: none;border-top: 1px solid #E9ECEF!important;vertical-align:middle!important;}
            .text-c td{border: none;border-bottom: 1px solid #E9ECEF!important;vertical-align:middle;}
            .text-c th:first-child{border-left: 1px solid #E9ECEF!important;}
            .text-c th:last-child{border-right: 1px solid #E9ECEF!important;}
            .text-c td:first-child{border-left: 1px solid #E9ECEF!important;}
            .text-c td:last-child{border-right: 1px solid #E9ECEF!important;}
            .text-c input{border: 1px solid #E9ECEF;margin: auto;padding: 2px 10px;}

            .ra1{
                /*width: 8%!important;*/
                float: left;
            }
            .ra1 label{
                width: 100px!important;
                padding-left: 20px;
                margin: auto;
                height: 36px;
                display: block;
                line-height: 36px;
            }
            input[type=text],.select{
                width: 190px;padding-left: 10px;
            }
            .fo_btn2{
                margin-right: 10px!important;
                color: #fff!important;
                background-color: #2890FF!important;
                border: 1px solid #fff;
                float: right;
                display: block;
                margin: 16px 0;
                width: 112px!important;
            }
            .inputC:checked + label::before {
                display: -webkit-inline-box;
            }
            .tab_label{padding-left: 15px!important;border-left: 1px solid #E9ECEF!important;}
            .scrolly{
                height: 300px;
                overflow-y: scroll;
            }
            /*.scrolly::-webkit-scrollbar { width: 0 !important }*/
            .manlevel{
                margin: 11px 0;
            }
            select{
                background: #fff;
            }
            .cont{
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
                width: 250px;
                text-align: left;
            }


            .form-horizontal .row{margin-left: 0;margin-right: 0;margin-bottom: .5rem;}

            .text-left-n{margin:0!important;padding-right: 0px!important;height: 36px;line-height: 36px;}
            .form-horizontal .formControls{
                padding-left: 10px;
            }

            .inputC:checked +label::before{
                top: -2px;
                height: -1px;
                width:14px;
                height: 14px;
            }


            #addpro .radio_blue{
                display: block;
                width: 100px!important;
                padding-left: 20px;
                margin: 0;
                height: 36px;
                line-height: 36px;
            }
        </style>
    {/literal}
    <title>活动设置</title>
</head>
<body>
<nav class="breadcrumb" style="font-size: 16px;"><span class="c-gray en"></span><i class="Hui-iconfont">&#xe67f;</i> 插件管理
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=seconds&action=Index';">秒杀 </a>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=seconds&action=Addpro&activity_id={$activity_id}';">秒杀时段列表</a>
    <span class="c-gray en">&gt;</span>
    <a style="margin-top: 10px;" onclick="location.href='index.php?module=seconds&action=Prolist&activity_id={$activity_id}&time_id={$time_id}';">秒杀商品列表</a>

    <span class="c-gray en">&gt;</span>添加秒杀商品
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>
<div class="page-container pd-20 page_absolute" >
    <div id="app">
        <form class="form form-horizontal" id="form-category-add" enctype="multipart/form-data">
            <div id="tab-category" class="HuiTab">
                <div class="tabCon">
                    <div style="height:600px;overflow-y: scroll;">
                        <div class="row cl">
                            <div class="form-label col-2 text-left-n">
                                <span class="c-red">*</span>
                                <label>选择秒杀商品：</label>
                            </div>
                            <div class="formControls col-10">
                                <select name="class" class="select" style="height: 36px;" @change="changeclass" id="pro_class">
                                    <option value="" selected="selected">请选择商品分类</option>
                                    <option :value="item.value" v-for="item in list">[[item.name]]</option>
                                </select>

                                <select name="brand" class="select" style="height: 36px;" v-if="brand_list.length == 0" id="brand_class">
                                    <option value="" selected="selected" >请选择品牌</option>
                                </select>

                                <select name="brand" class="select" style="height: 36px;"  v-else >

                                    <option :value="item.brand_id" v-for="item in brand_list">[[item.brand_name]]</option>
                                </select>
                                <input type="text" name="p_name" value="" placeholder="请输入商品名称" id="brand_name">
                                <input id="my_query" class="btn btn-success" type="button" style="margin-left: 5px;background-color: #2890ff!important;border: 0;" value="查询" @click="select">
                                <input id="huanyuan" class="btn btn-success" type="button" style="margin-left: 5px;background-color: #2890ff!important;border: 0;" value="重置" @click="re_pro">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;"></label>
                            <div class="formControls col-10">
                                <div class="tabCon1 tab-scroll">
                                    <div class="mt-20" id="prolist">
                                        <table class="table table-border table-bordered table-bg table-hover" style="margin:0 auto;border: 0;">
                                            <thead>
                                            <tr class="text-c">
                                                <th></th>
                                                <th  style="width: 10%">序号</th>
                                                <th  style="width: 30%">商品名称</th>
                                                <th style="width: 8%">商品ID</th>
                                                <th style="width: 20%">商家名称</th>
                                                <th style="width: 8%">库存</th>
                                                <th style="width: 16%">库存预警值</th>
                                                <th style="width: 15%">零售价</th>
                                            </tr>
                                            </thead>
                                            <tbody id="proattr">
                                            <tr class="text-c" style="height:60px!important;" v-for="(item,index) in prolist">
                                                <input type="hidden" name="attr_id" value="item.attr_id">
                                                <td class="tab_label">
                                                    <input type="radio" class="inputC input_agreement_protocol hide" attr-data="402" :id="item.id" targ="223" name="id[]" :value="item.id" style="position: absolute;" @change="check_one(item.id)">
                                                    <label :for="item.id">
                                                    </label>
                                                </td>
                                                <td>[[index+1]]</td>
                                                <td style="padding: 0 ;">
                                                    <div style="display: flex;align-items: center;width: 350px;">
                                                        <img :src="item.imgurl" style="width: 40px;height:40px;">
                                                        <span class="cont" title="'+element.product_title+'">[[item.product_title]]</span>
                                                    </div>
                                                </td>
                                                <td>[[item.id]]</td>
                                                <td>[[item.name]]</td>
                                                <td>[[item.num]]</td>
                                                <td>[[item.min_inventory]]</td>
                                                <td>[[item.price]]</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3 text-left-n"><span class="c-red">*</span>秒杀价格：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value=""placeholder="" id="price" name="price" style="width:160px;">
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3 text-left-n"><span class="c-red">*</span>秒杀数量：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value=""placeholder="" id="num" name="num" style="width:160px;">
                            </div>
                            <div class="col-3">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3 text-left-n"><span class="c-red">*</span>是否显示：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <div class='switch-box' :class="[is_show==1?'active':'']" @click='change_isshow()' style=''>
                                    <div class='switch-data'></div>
                                </div>
                            </div>
                            <div class="col-3">
                            </div>
                        </div>

                        <div class="row cl page_footer" >
                            <div >
                                <input class="btn btn-primary radius ta_btn4" onclick='javascript:history.back(-1)' type="reset" value="取消" style="background: #fff!important;">
                                <input class="btn btn-primary radius ta_btn3" type="button" value="保存" @click="save">
                            </div>
                        </div>
                    </div>
        </form>
    </div>
</div>
</div>



<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="style/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="style/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="style/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="style/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="style/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="style/laydate/laydate.js"></script>
<script type="text/javascript" src="style/vue/vue.js"></script>

{literal}
    <script type="text/javascript">
        var radio = 1;

        var app = new Vue({
            el: '#app',
            delimiters:['[[',']]'],
            data: {
                message: '页面加载于 ' + new Date().toLocaleString(),
                showzhezhao:false,
                showadd:false,
                liststr:"",
                list:[],
                activity_id:'',
                time_id:'',
                prolist:[],//商品列表数据
                oldprolist:[],//商品列表数据2（不做修改，初始数据）
                brand_list:[],//品牌列表数据
                is_show:1,//是否显示 1 显示 0 不显示
            },
            beforeCreate: function () {
                var me = this;
                //初始化数据
                console.log('beforeMount 初始化数据...');
            },
            beforeMount: function () {
                var me = this;

                console.log('beforeMount 钩子执行...');
                me.activity_id = '{/literal}{$activity_id}{literal}';
                me.time_id = '{/literal}{$time_id}{literal}';
                console.log(me.activity_id);
                console.log(me.time_id);

                me.axios();

            },
            methods: {
                axios: function (event) {
                    //初始化数据
                    var me = this;
                    console.log('axios');

                    $.ajax({
                        url:'?module=seconds&action=Modify',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{
                            m:'axios',
                            activity_id:me.activity_id,
                            time_id:me.time_id,
                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            console.log("ajax_success");
                            console.log(res);
                            me.list = res.classList;
                            me.prolist = me.oldprolist = res.prolist;
                        },
                        //失败/超时
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            console.log("ajax_error");
                            layer.msg('获取数据失败');

                        }
                    })

                },
                check_one:function(id){
                    var i = id
                    console.log('check_one_'+i);
                    if($("input[id="+i+"]").prop("checked")==true){
                        $("input[id!="+i+"][name='id[]']").removeAttr("checked");
                    }
                },
                changeclass:function(){
                    var me = this;
                    console.log('changeclass');
                    var cid = $("#pro_class").val();

                    $.ajax({
                        url:'?module=seconds&action=Modify&m=pro_brand',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{
                            m:'pro_brand',
                            cid:cid,
                            activity_id:me.activity_id,
                            time_id:me.time_id,

                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            console.log("ajax_success");
                            console.log(res);
                            me.brand_list = res;
                            console.log(me.brand_list);

                        },
                        //失败/超时
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            console.log("ajax_error");
                            layer.msg('获取数据失败');

                        }
                    })
                },
                // 是否显示
                change_isshow(){
                    this.is_show=this.is_show==0?1:0
                },
                select:function () {
                    console.log("select");
                    var me = this;
                    var my_brand = $('select[name=brand] option:selected').val();
                    var my_class = $('select[name=class] option:selected').val();
                    var pro_name =$('input[name=p_name]').val();

                    $.ajax({
                        url:'?module=seconds&action=Modify&m=pro_query',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{
                            m:'pro_query',
                            my_brand:my_brand,
                            my_class:my_class,
                            pro_name:pro_name,
                            activity_id:me.activity_id,
                            time_id:me.time_id,
                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            console.log("ajax_success");
                            console.log(res.res);
                            me.prolist = res.res;
                            if( res.res.length == 0){//有拼团商品数据
                                layer.msg('没有秒杀商品')
                            }
                        },
                        //失败/超时
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            console.log("ajax_error");
                            layer.msg('获取数据失败');
                        }
                    })
                },
                re_pro:function () {
                    var me = this;
                    console.log("re_pro");
                    $("#pro_class").val('');
                    me.brand_list = [];
                    $("#brand_name").val('');
                    // me.prolist = me.oldprolist;
                },
                save:function () {
                    var me = this;
                    var price = $("#price").val();
                    var num = $("#num").val();
                    var proid = $('input:radio:checked').val();
                    var kc_num = $('input:radio:checked').parents().next().next().next().next().next().text();
                    var sp_price = $('input:radio:checked').parents().next().next().next().next().next().next().next().text();
                    console.log(price);
                    console.log(num);
                    console.log(proid);
                    if(proid == '' ||proid == undefined){
                        layer.msg('请选择秒杀商品！');
                        return false;
                    }
                    if(price == ''){
                        layer.msg('请设置秒杀价格！');
                        return false;
                    }
                    if(price <= 0){
                        layer.msg('秒杀价格设置不合理！');
                        return false;
                    }
                    if(parseFloat(price) > parseFloat(sp_price)){
                        layer.msg('秒杀价格必须小于零售价！');
                        return false;
                    }
                    if(num == ''){
                        layer.msg('请设置秒杀数量！');
                        return false;
                    }
                    if(num <= 0){
                        layer.msg('秒杀数量设置不合理！');
                        return false;
                    }
                    if(parseFloat(num) > parseFloat(kc_num)){
                        console.log("秒杀数量："+num);
                        console.log("库存："+kc_num);
                        layer.msg('秒杀数量必须小于等于商品库存！');
                        return false;
                    }
                    $.ajax({
                        url:'?module=seconds&action=Modify&m=save',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{
                            m:'save',
                            price:price,
                            num:num,
                            proid:proid,
                            activity_id:me.activity_id,
                            time_id:me.time_id,
                            is_show:me.is_show,
                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            console.log("ajax_success");
                            console.log(res);
                            if(res.code==1){
                                console.log("保存成功");
                                layer.msg('保存成功');
                                location.href='index.php?module=seconds&action=Prolist&activity_id='+me.activity_id+'&time_id='+me.time_id;

                            }else{
                                layer.msg('保存失败');
                            }

                        },
                        //失败/超时
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            console.log("ajax_error");
                            layer.msg('保存失败');
                        }
                    })


                }
            }
        })

        $('.table-sort').dataTable({
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,4]}// 制定列不参与排序
            ]
        });

        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#tab-category").Huitab({
                index:0
            });

        });

    </script>
{/literal}
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>