
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

    <link rel="stylesheet" type="text/css" href="style/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="style/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="style/css/bootstrap.min.css" />
    {include file="../../include_path/software_head.tpl" sitename="DIY头部"}
    <title>查看砍价活动</title>
    {literal}
        <style type="text/css">

            .reset{
                padding: 7px 14px!important;
                padding-top: 0!important;
                width: auto!important;
                margin: 0 0 0 8px!important;
                border-radius: 3px;
                height: auto!important;
            }

            .pro_img{display: flex;position: relative;flex-direction: column;justify-content: center;}
            .pro_img img{width: 40px;height: 40px;float: left;}
            .protitle p {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                width: 200px;
                margin: 0;
            }

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
                width: 10%!important;
                float: left;
                left: 3px;
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
            .manlevel{
                margin: 10px 0;
            }
            select{
                background: #fff;
            }
            .text-c th{vertical-align: middle!important;}
            table thead tr th{border-bottom: 1px solid #eceeef!important;}
            .form_new_r .ra1 label {width: 100%!important;}
            .form_new_r span{color: #555;}
        </style>
    {/literal}
</head>
<body>
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
  <nav class="breadcrumb" style="font-size: 16px;">
    <span class="c-gray en"></span>
    插件管理
    <span class="c-gray en">&gt;</span>
    <a href="index.php?module=bargain&action=Index" style="color: #555;">砍价</a>
    <span class="c-gray en">&gt;</span>
    砍价商品
    <span class="c-gray en">&gt;</span>
    查看砍价活动
  </nav>
<div id="addpro" class="pd-20" style="background-color: white;">
    <p style="font-size: 15px;" class="page_title">查看砍价活动</p>

    <form name="form1" id="form1" class="form form-horizontal" style="margin-bottom: 60px;" method="post" enctype="multipart/form-data" >
        <div class="row cl" {if $msg->status!=0}style="display: none;"{/if}>
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;padding-right: 0px;"><span class="c-red">*</span>选择砍价商品：</label>
            <div class="formControls col-10">
                <select name="class" id="class" class="select">
                    <option value="" selected="selected" >请选择商品类别</option>
                    {$class}
                </select>
                <select name="brand" id="brand" class="select">
                    <option value="" selected="selected" >请选择产品品牌</option>
                    {$brand}
                </select>
                <input type="text" name="p_name" id="p_name" value="" placeholder="请输入产品名称">
                <input type="button" value="重置" class="reset" style="color: #6A7076;" onclick="empty()" />
                <input  id="my_query" class="btn btn-success" type="button" style="margin-left: 5px;background-color: #2890ff!important;" value="查询">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-2" style="line-height: 25px;margin-top: 0px;"></label>
            <div class="formControls col-10">
                <div class="tabCon1">
                    <div class="mt-20" id="prolist" style="max-height: 300px;overflow-y: auto;">
                        <table class="table table-border table-bordered table-bg table-hover" style="margin:0 auto;border: 0;">
                            <thead>
                                <tr class="text-c">
                                    <th style="width: 5%;"></th>
                                    <th class="tabletd">商品名称</th>
                                    <th style="width: 5%;min-width: 67px;">商品ID</th>
                                    <th style="width: 10%;min-width: 80px;">商家名称</th>
                                    <th style="width: 15%;">库存</th>
                                    <th style="width: 10%;min-width: 95px;">库存预警值</th>
                                    <th style="width: 15%;">零售价</th>
                                </tr>
                            </thead>
                            <tbody id="proattr">
                            {foreach from=$proattr item=item1 key=key}
                                <tr class="text-c" style="height:20px;">
                                    <td>
                                        <input type="checkbox" style="width: 10px;height: 10px;" val-data="{$item1->pid}" class="inputC input_agreement_protocol" id="{$item1->id}" name="id[]" value="{$item1->id}" onchange="check_one({$item1->id})" {if $msg->attr_id==$item1->id}checked{/if} {if $msg->status!=0}disabled{/if}>
                                        <label for="{$item1->id}"></label>
                                    </td>
                                    <td style="display: flex;justify-content: center;height: 100%;">
                                        <div class="pro_img"><img src="{$item1->pro_img}"></div>
                                        <div class="protitle">
                                            <p>{$item1->product_title}</p><p>{$item1->attrtype}</p>
                                        </div>
                                    </td>
                                    <td>{$item1->id}</td>
                                    <td>{$item1->mchname}</td>
                                    <td><span id="pronum{$item1->id}">{$item1->num}</span></td>
                                    <td><span id="min_inventory{$item1->id}">{$item1->min_inventory}</span></td>
                                    <td><span id="mkprice{$item1->id}">{$item1->price}</span></td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <input type="hidden" id="b_id" value="{$msg->id}">
        <input type="hidden" id="b_status" value="{$msg->status}">

        <div class="formContentSD">
          <div class="formListSD">
            <div class="formTextSD"><span class="c-red">*</span><span>砍价最低价：</span></div>
            <div class="form_new_r form_yes" >
                <input type="text" onkeyup="num(this)" id="lowprice" {if $msg->status!=0}readonly="readonly"{/if} value="{$msg->min_price}" autocomplete="off" class="input-text" placeholder="请设置砍价最低价" />
            </div>
          </div>
          <div class="formListSD">
            <div class="formTextSD"><span class="c-red">*</span><span>活动时间：</span></div>
            <div class="form_new_r form_yes" >
                <input type="text" {if $msg->status!=0}readonly="readonly"{/if} id="startdate" value="{$msg->begin_time}" autocomplete="off" class="input-text" placeholder="请选择开始时间" style="border-radius:2px;width: 180px;height: 31px;"/>
                <div style="display: inline;margin: 7px 10px;line-height: 36px;">至</div>
                <input type="text" {if $msg->status!=0}readonly="readonly"{/if} id="enddate" value="{$msg->end_time}" autocomplete="off" class="input-text" placeholder="请选择结束时间" style="border-radius:2px;width: 180px;height: 31px;"/>
            </div>
          </div>
            <span style="color:#C0C0C0;margin-left: 122px;">（商品砍价时间，到时间则活动结束，如未达到最低价，则砍价失败！）</span>
          <div class="formListSD">
            <div class="formTextSD"><span>活动标签：</span></div>
            <div class="form_new_r form_yes" style="width: 90%;">
                {$sp_type}
            </div>
          </div>
          <div class="formListSD">
            <div class="formTextSD"><span>是否显示：</span></div>
            <div class="form_new_r form_yes" style="width: 90%;">
              <div class="ra1" style="min-width: 15%!important;">
                  <input style="display: none;" {if $msg->status!=0}disabled{/if} class="inputC1" type="radio" name="p_show" id="show_1" value="0" {if $msg->is_show ==0}checked="checked"{/if}>
                  <label for="show_1">否</label>
              </div>
              <div class="ra1" style="min-width: 15%!important;">
                  <input style="display: none;" {if $msg->status!=0}disabled{/if} class="inputC1" type="radio" name="p_show" id="show_2" value="1" {if $msg->is_show !=0}checked="checked"{/if}>
                  <label for="show_2">是</label>
              </div>
            </div>
          </div>
          <div class="formListSD">
            <div class="formTextSD"><span class="c-red">*</span><span>砍价方式：</span></div>
            <div class="form_new_r form_yes" style="width: 90%;">
              <div class="ra1" style="min-width: 15%!important;">
                  <input style="display: none;" class="inputC1" type="radio" name="setman" id="setman_1" value="1" {if $msg->man_num!=0}checked{/if} {if $msg->status!=0}disabled{/if}>
                  <label for="setman_1">设置人数</label>
              </div>
              <div class="ra1" style="min-width: 15%!important;">
                  <input style="display: none;" class="inputC1" type="radio" name="setman" id="setman_2" value="2" {if $msg->man_num==0}checked{/if} {if $msg->status!=0}disabled{/if}>
                  <label for="setman_2">不设置人数</label>
              </div>
            </div>
          </div>
          <div class="formListSD">
            <div class="formTextSD"><span></span></div>
            <div class="form_new_r form_yes" style="width: 90%;">

              <div id="issetman" {if $msg->man_num==0}style="display: none;"{/if}>
                <div class="formListSD">
                  <div class="formTextSD">参与人数：</div>
                  <div class="form_new_r form_yes" style="width: 90%;">
                      <input onkeyup="num2(this)" type="number" {if $msg->status!=0}readonly="readonly"{/if} {if $msg->man_num!=0}value="{$msg->man_num}"{/if} min="1" style="border-radius:2px;width: 120px;margin:0;" class="input-text" name="barginman"/>
                      <span style="margin: 5px;">人</span><span style="color:#C0C0C0;margin: 5px;">参与砍价人数</span>
                  </div>
                </div>
                <div class="formListSD">
                  <div class="formTextSD">砍价波动值：</div>
                  <div class="form_new_r form_yes" style="width: 90%;">
                    <span>前</span>
                    <input onkeyup="num(this)" type="number" {if $msg->status!=0}readonly="readonly"{/if} min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="one_man" {if $msg->man_num!=0}value="{$status_data->one_man}"{/if}/>
                    <span>人砍价，最小值</span>
                    <input onkeyup="num(this)" type="number" {if $msg->status!=0}readonly="readonly"{/if} min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="min_one" {if $msg->man_num!=0}value="{$status_data->min_one}"{/if}/>
                    <span>最大值</span>
                    <input onkeyup="num(this)" type="number" {if $msg->status!=0}readonly="readonly"{/if} min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="max_one" {if $msg->man_num!=0}value="{$status_data->max_one}"{/if}/>
                  </div>
                </div>
              </div>

              <div id="notsetman" {if $msg->man_num!=0}style="display: none;"{/if}>
                <div class="formListSD">
                  <div class="formTextSD">砍价波动值：</div>
                  <div class="form_new_r form_yes" style="width: 90%;">
                    <span>最小值</span>
                    <input onkeyup="num(this)" type="number" {if $msg->status!=0}readonly="readonly"{/if} min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="min_not" {if $msg->man_num==0}value="{$status_data->min_not}"{/if}/>
                    <span>最大值</span>
                    <input onkeyup="num(this)" type="number" {if $msg->status!=0}readonly="readonly"{/if} min="1" style="border-radius:2px;width: 120px;height: 31px;margin-left: 10px;" class="input-text" name="max_not" {if $msg->man_num==0}value="{$status_data->max_not}"{/if}/>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>


        {if $msg->status==0}
        <div class="page_h10 page_bort" style="height: 68px!important;margin-top: 140px;border-top: 1px solid #E9ECEF;">
            <input class="fo_btn2" type="button" style="margin-right: 120px!important;" name="Submit" value="保存" onclick="group_tijiao()">
            <input type="button" name="reset" style="margin-right: 10px!important;" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">
        </div>
        {/if}
    </form>

</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}

    <script type="text/javascript">

        function empty(){
            $("#p_name").val('');
            $("#brand").val('');
            $("#class").val('');
        }

        function num(obj){
            obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
            obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
            obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
            obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
            obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
        }
        function num2(ob) {
            if (ob.value.length == 1) {
                ob.value = ob.value.replace(/[^1-9]/g, '')
            } else {
                ob.value = ob.value.replace(/\D/g, '')
            }
        }
        var status = $('#b_status').val();

        function check_one(i){
         
          if($("input[id="+i+"]").prop("checked")==true){
              $("input[id!="+i+"][name='id[]']").removeAttr("checked");
          }

        }

        if (status == 0) {

            laydate.render({
              elem: '#startdate', //指定元素
                trigger: 'click',
              type: 'datetime'
            });
             laydate.render({
              elem: '#enddate',
                 trigger: 'click',
              type: 'datetime'
            });
        }

        $('input[name=setman]').change(function (){

            if (status !=0) {
                return;
            }

            var val = $(this).val();
            if(val == '1'){
               $('#notsetman').hide();
               $('#issetman').show();
            }else{
               $('#issetman').hide();
               $('#notsetman').show();
            }
        });

        function radioChange(i){
            var bargain_end_time = $('#bargain_end_time');
            if(i == 1){
                console.log(1);
                bargain_end_time.attr('disabled','disabled');
                bargain_end_time.val('');
                radio = 1;
                var startdate = $("#bargain_start_time").val();
                console.log(11);

                if(startdate != '' && startdate.length == 19){
                    console.log(111);

                    var day = startdate.split(' ');
                    var str = startdate.replace(/-/g,'/');
                    var d = new Date(str);
                    var oneYear = oneYearPast(d);
                    console.log(1111);

                    oneYear = oneYear + ' ' + day[1];
                    console.log(oneYear);

                    $("#end_year").val(oneYear)
                }
            }else{
                console.log(2);
                bargain_end_time.removeAttr('disabled');
                $("#end_year").val('');
                radio = 2;
            }
        }

        var cid = null;
        $('select[name=class]').change(function (){
            var type = $(this).val();
            if(type == ''){
               return;
            }
            cid = type;
            $.ajax({
              url: 'index.php?module=bargain&action=Addpro&m=getbrand',
              type: 'post',
              data: {cid:type},
              success: function (data){
                data = JSON.parse(data);
                var str = '<option value="" >请选择产品品牌</option>';
                for(var i in data){
                   str += "<option value='"+data[i].brand_id+"'>"+data[i].brand_name+"</option>";    
                }
                $('select[name=brand]').html(str);
              },
              fail: function (err){

              }
            })
        });

        //一年后的今天的前一天
        function oneYearPast(time)
        {
            //var time=new Date();
            var year=time.getFullYear()+1;
            var month=time.getMonth()+1;
            var day=time.getDate();

            if(month<10){
                month="0"+month;
            }

            if(day>1){
                day = day;
            }else{
                month = month-1;
                if(month<10){
                    month="0"+month;
                }
                if(month==0){
                    month = 12;
                }
                day=new Date(year,month,0).getDate();
            }

            var v2=year+'-'+month+'-'+day;
            return v2;
        }

        function validation(obj) {
            var regu = /^\d+$/;
            //var regu = /^[1-9]\d*|0$/;  亲测可用
            if (obj != "") {
                if (!regu.test(obj)) {
                    return false;
                } else {
                    return true;
                }
            }else{
              return false;
            }
        }

        function group_tijiao() {

            var checktext = true;
            var checkids = $("input[name='id[]']:checked");//被选中的复选框对象
            if (checkids.length < 1) {
                layer.msg("请选择一款产品属性");
                checktext = false;
                return;
            }
            if (checkids.length > 1) {
                layer.msg("只能选择一款产品属性哦！");
                checktext = false;
                return;
            }
            var attrid = '';
            var min_price = '';
            var promsg = {};
            var chajiamin = [];
            $.each(checkids, function (index, element) {
                var id = $(element).val();
                var mkprice = parseFloat($('#mkprice' + id).text());
                var barginprice = parseFloat($('#lowprice').val());
                var pronum = $('#pronum'+id).text();
                var min_inventory = $('#min_inventory'+id).text();
                if (!validation(pronum)) {
                    layer.msg("库存数量设置不合格");
                    $('#pronum' + id).addClass('redport');
                    setTimeout(function () {
                        $('#pronum' + id).removeClass('redport');
                    }, 2000);
                    checktext = false;
                    return;
                }
                if (!validation(min_inventory)) {
                    layer.msg("库存预警值设置不合格");
                    $('#min_inventory' + id).addClass('redport');
                    setTimeout(function () {
                        $('#min_inventory' + id).removeClass('redport');
                    }, 2000);
                    checktext = false;
                    return;
                }

                if (barginprice >= mkprice || barginprice == '') {
                    layer.msg("价格设置不标准!");
                    $('#barginprice' + id).addClass('redport');
                    setTimeout(function () {
                        $('#barginprice' + id).removeClass('redport');
                    }, 2000);
                    checktext = false;
                    return;
                }
                if (checktext) {
                    attrid = id;
                    min_price = barginprice;
                }
                var chajia = mkprice-barginprice;
                chajiamin.push(chajia);
            });
            
            var minprice = Math.min.apply(null, chajiamin);       //求差价最小值
            if (!checktext) {
                return;
            }
            
            if(minprice < 1 || minprice == ''){
              layer.msg("最低价设置不标准！");
              return;
            }

            var bar_good = $("input[name='id[]']:checked");
            if(bar_good.length == 0){
              layer.msg('请选择一个砍价商品!');
              return;
            }else{
              $.each(bar_good,function (index,element){
                goodsid = $(element).attr('val-data');
              })
            }

            var obj = {};
            var status_data = {};
            obj['startdate'] = $('#startdate').val();
            obj['enddate'] = $('#enddate').val();
            obj['buytime'] = $('#buytime').val();
            obj['goodsid'] = goodsid;
            obj['is_show'] = $('input[name=p_show]:checked').val();
            // obj['is_type'] = $('input[name=p_type]:checked').val();
            obj['is_type'] = [];
            var checktypes=$("input[name='s_type[]']:checked");
            $.each(checktypes,function (index,element){
                obj['is_type'] += $(element).val()+',';
            })
            obj['id'] = $('#b_id').val();
            var setman = obj['setman'] = $('input[name=setman]:checked').val();
            var one_man = $("input[name='one_man']").val();
            if (one_man != '') {
                var barginman = obj['barginman'] = $('input[name=barginman]').val();
                $.each(obj, function (index, element) {
                    if (element === '') {
                        layer.msg("请填写完整信息");
                        checktext = false;
                        return;
                    }
                });
                if (!checktext) {
                    return;
                }

                var one_man = status_data['one_man'] = $('input[name=one_man]').val();
                var min_one = status_data['min_one'] = $('input[name=min_one]').val();
                var max_one = status_data['max_one'] = $('input[name=max_one]').val();
                if (one_man != '0') {
                    var min_two = status_data['min_two'] = $('input[name=min_two]').val();
                    var max_two = status_data['max_two'] = $('input[name=max_two]').val();
                }

                $.each(status_data, function (index, element) {
                    if (element === '') {
                        layer.msg("参数不允许为空");
                        checktext = false;
                        return;
                    }
                });
                if (!checktext) {
                    return;
                }
                if (!validation(barginman) || parseInt(barginman) <= 1) {
                    layer.msg("参与人数必须为大于1的正整数");
                    checktext = false;
                    return;
                }
                if (!validation(one_man)) {
                    layer.msg("第一个条件的人数设置不合格");
                    checktext = false;
                    return;
                }


                var hour = $("#buytime").val();
                if (hour <= 0) {
                    layer.msg("购买时间应该大于0");
                    checktext = false;
                    return;
                }

                if (parseInt(min_one) >= parseInt(max_one) || (one_man != '0' && parseInt(min_two) >= parseInt(max_two))) {
                    layer.msg("最大值不能小于最小值");
                    checktext = false;
                    return;
                }
                var barginman = $('input[name=barginman]').val();//总人数
                var one_man = $('input[name=one_man]').val();//前人数
                if(parseInt(one_man) >= parseInt(barginman)){
                    layer.msg('总人数应大于第一波人数');
                    return false;
                }
                if(parseInt(max_one) >= minprice || parseInt(max_two) >= minprice){
                   layer.msg("最大值不能大于砍价产品设置的差价");
                   checktext = false;
                   return;
                }

                var two_man = barginman - one_man;
                var min_first = one_man*min_one;
                var all_can = two_man*0.01+min_first;
                if (all_can > minprice) {
                    layer.msg('请设置正确的砍价波动值！');
                    return false;
                }


            } else {
                var min_not = status_data['min_not'] = $('input[name=min_not]').val();
                var max_not = status_data['max_not'] = $('input[name=max_not]').val();
                obj['barginman'] = 0;
                $.each(obj, function (index, element) {
                    if (element === '') {
                        layer.msg("请填写完整信息");
                        checktext = false;
                        return;
                    }
                });
                $.each(status_data, function (index, element) {
                    if (element === '') {
                        layer.msg("参数不允许为空");
                        checktext = false;
                        return;
                    }
                });
                if (!checktext) {
                    return;
                }
                if (parseInt(min_not) >= parseInt(max_not)) {
                    layer.msg("最大值不能小于最小值");
                    checktext = false;
                    return;
                }
                if(parseInt(max_not) >= minprice){
                   layer.msg("最大值不能大于砍价产品设置的差价");
                   checktext = false;
                   return;
                }
            }
            var stime = new Date(obj['startdate']).getTime();
            var etime = new Date(obj['enddate']).getTime(); 
            var now = new Date().getTime();   
            if(etime < now || stime >= etime){
                layer.msg('时间设置不合格!');
                checktext = false;
                return;
            }
            var hour = $("#buytime").val();
            if (hour <= 0) {
                layer.msg("购买时间应该大于0小时");
                checktext = false;
                return;
            }
            if (checktext) {
                obj = JSON.stringify(obj);
                status_data = JSON.stringify(status_data);
                $.ajax({
                    url: "index.php?module=bargain&action=Modify",
                    type: "post",
                    data: {min_price:min_price,attrid:attrid, obj: obj, status_data: status_data, goods_id: goodsid},
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 1) {
                            window.location.href = 'index.php?module=bargain';
                        } else {
                            layer.msg('未知原因,修改失败!');
                        }
                    },
                })
            }
        }

        var goodsid = '';
        window.onload = function(){

            //ajax请求--获取拼团商品列表
            $("#my_query").on("click",function(){
                var pro = $(this).val();
                console.log(pro);
                if(pro == ''){
                   return;
                }
                goodsid = pro;

                //搜索按钮
                var sel1 = $('select[name=class] option:selected').val();
                var sel2 = $('select[name=brand] option:selected').val();
                var sel3 =$('input[name=p_name]').val();
                $("#prolist").removeClass('scrolly');

                $.ajax({
                    url: 'index.php?module=bargain&action=Addpro&m=getproattr_sel',
                    type: 'post',
                    data: {where1:sel1,where2:sel2,where3:sel3},
                    success: function (data){
                        data = JSON.parse(data);
                        var table = '';
                        var i = 0;
                        $.each(data,function(index,element){

                            table += `<tr class="text-c" style="height:20px;"><td><input type="checkbox" style="width: 10px;height: 10px;" val-data="${element.pid}" class="inputC input_agreement_protocol" id="${element.id}" name="id[]" onchange="check_one('${element.id}')" value="${element.id}"><label for="${element.id}"></label></td><td style="display: flex;justify-content: center;height: 100%;"><div class="pro_img"><img src="${element.pro_img}"></div><div class="protitle"><p>${element.product_title}</p><p>${element.attrtype}</p></div></td><td>${element.id}</td><td>${element.mchname}</td><td><span id="pronum${element.id}">${element.num}</span></td><td><span id="min_inventory${element.id}">${element.min_inventory}</span></td><td><span id="mkprice${element.id}">${element.price}</span></td></tr>`;

                            i++;

                        });

                        $("#proattr").html(table);
                    }
                })

            })
        }


    </script>

{/literal}
</body>
</html>