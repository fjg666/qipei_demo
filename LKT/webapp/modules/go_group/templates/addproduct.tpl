
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
	<title>添加活动</title>
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
</head>
<body>
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
<nav class="breadcrumb" style="font-size: 16px;">
	<i class="Hui-iconfont">&#xe6ca;</i>
	插件管理
	<span class="c-gray en">&gt;</span>
	<a style="margin-top: 10px;" onclick="location.href='index.php?module=go_group&action=Index';">拼团 </a>
	<span class="c-gray en">&gt;</span>
	<a style="margin-top: 10px;" onclick="location.href='index.php?module=go_group&action=Index';">拼团活动 </a>
	<span class="c-gray en">&gt;</span>
	添加拼团商品
</nav>
<div id="addpro" class="pd-20 form-scroll" style="background-color: white;">
	<p style="font-size: 15px;" class="page_title">添加拼团商品</p>

	<form name="form1" id="form1" class="form form-horizontal" style="margin-bottom: 10px;padding: 10px 0 0 0 !important;" method="post" enctype="multipart/form-data" >
        <div class="row cl">
            <label class="form-label col-2 text-left-n">拼团标题：</label>
            <div class="formControls col-10">
                <input type="text" name="title" value="">
                <span style="margin-left: 10px;font-size: 14px;color:#A8B0CB;">（活动标题如果不填写，默认为商品名称）</span>
            </div>
        </div>
		<div class="row cl">
			<div class="form-label col-2 text-left-n">
				<span class="c-red">*</span>
				<label>选择拼团商品：</label>
			</div>
			<div class="formControls col-10">
				<select name="class" class="select">
					<option value="" selected="selected" >请选择商品分类</option>
                    {$class}
                </select>
				<select name="brand" class="select">
                    <option value="" selected="selected" >请选择品牌</option>
				</select>
				<input type="text" name="p_name" value="" placeholder="请输入商品名称">
				<input  id="my_query" class="btn btn-success" type="button" style="margin-left: 5px;background-color: #2890ff!important;border: 0;" value="查询">
				<input  id="huanyuan" class="btn btn-success" type="button" style="margin-left: 5px;background-color: #2890ff!important;border: 0;" value="重置" >
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-2" style="line-height: 25px;margin-top: 0px;"></label>
			<div class="formControls col-10">
				<div class="tabCon1 tab-scroll">
					<div class="mt-20"  id="prolist">
						<table class="table table-border table-bordered table-bg table-hover" style="margin:0 auto;border: 0;">
							<thead>
							<tr class="text-c">
								<th></th>
								<th>序号</th>
								<th>商品名称</th>
								<th>商品ID</th>
								<th>商家名称</th>
								<th>库存</th>
								<th>库存预警值</th>
								<th>零售价</th>
							</tr>
							</thead>
							<tbody id="proattr">
							{foreach from=$proattr item=item1 key=key}
								<tr class="text-c" style="height:60px!important;">
									<input type="hidden" name="attr_id"  value="{$item1->attr_id}">
									<td class="tab_label">
										<input  type="checkbox" class="inputC input_agreement_protocol" {if $item1->select}checked{/if} attr-data="{$item1->attr_id}" id = "{$item1->id}{$key}" targ="{$item1->id + $key}" name="id[]"  value = "{$item1->id + $key}" style="position: absolute;" onchange="check_one('id{$item1->id}{$key}')">
										<label for="{$item1->id}{$key}">
										</label>
									</td>
									<td>{$key+1}</td>
									<td style="display: flex;align-items: center;">
										<img src ="{$item1->imgurl}" style="width: 40px;height:40px;"> <span class="cont" title="'+element.product_title+'">{$item1->product_title}</span></td>
									<td>{$item1->id}</td>
									<td>{$item1->name}</td>
									<td>{$item1->num}</td>
									<td>{$item1->min_inventory}</td>
									<td>{$item1->price}</td>
								</tr>
								</tr>
							{/foreach}
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>

        <div class="row cl">
            <label class="form-label col-2 text-left-n"><span class="c-red">*</span>拼团人数设置：</label>
            <div class="formControls col-xs-10 col-sm-10" style="border-radius: 5px;">
                <div style="display: flex;margin-bottom: 15px;">
					<input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;添加人数&nbsp;&nbsp;" style="height: 36px!important;width: 118px;margin-right: 20px;" onclick="addlever()">
					<div style="height: 36px;line-height: 36px;font-size: 14px;color: #A8B0CB;">(开团折扣只有开启团长优惠后团长才能享用)</div>
				</div>
                <div id="setlevel">
                    <div class="manlevel" style="margin: 0;">
						<input type="number" max="50" min="2" step="1" class="input-text man_num" value="" name="min_man" style="width:60px;" onkeyup="onkeyup1(this)">&nbsp;&nbsp;人团&nbsp;&nbsp;
                        <span style="margin-left:17px;">折扣价: 参团</span>
                        <input type="text" class="input-text" value=""  name="canprice" style="width:80px;" onkeyup="onkeyup1(this)">
                        %
                        <span style="margin-left: 5px;">开团</span>
                        <input type="text" class="input-text" value=""  name="memberprice" style="width:80px;" onkeyup="onkeyup1(this)">
                        %
                    </div>
                </div>
            </div>
            <div class="col-3">
            </div>
        </div>
		<div class="row cl" >
			<label class="form-label col-xs-4 col-sm-3 text-left-n"><span class="c-red">*</span>开始时间：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" autocomplete="off" placeholder="" id="group_start_time" name="starttime" style="width:160px;">
			</div>
			<div class="col-3">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3 text-left-n"><span class="c-red">*</span>结束时间：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div style="margin-top: 0;display: flex;align-items: center;">
					<input type="radio" value="2" placeholder="" id="endtime" name="endtime" onchange="radioChange(2)" checked style="margin-top: 0;display:none" class="inputC1">
					<label class="radio_blue" for="endtime">定期结束</label>
					<input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="group_end_time" name="group_end_time" style="width:160px;">
				</div>
				<div style="margin-top: 15px;display: flex;align-items: center;">
					<input type="radio" value="1" placeholder="" id="ctime" name="endtime" onchange="radioChange(1)"  style="margin-top: 0;display:none" class="inputC1">
					<label class="radio_blue" for="ctime">长期</label>
					<input type="text" class="input-text" autocomplete="off" value="" placeholder="" id="end_year" name="end_year" style="width:160px;" disabled>
					<span style="margin-left: 15px;font-size: 14px;color:#97A0B4;">（长期的默认期限是一年,开始时间和结束时间不能小于现在时间,且开始时间不能大于结束时间）</span>
				</div>
			</div>
			<div class="col-3">
			</div>
		</div>
			
		<div style="height: 110px;"></div>

		<div class="page_h10 page_bort" style="height: 68px!important;">
			<input class="fo_btn2" type="button" name="Submit" value="保存" onclick="baocungroup()" style="margin-right: 60px!important;">
			<input type="button" name="reset" value="取消" class="fo_btn1" onclick="javascript :history.back(-1);">

		</div>
	</form>

</div>

{include file="../../include_path/footer.tpl" sitename="公共底部"}
{include file="../../include_path/software_footer.tpl" sitename="DIY底部"}
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}

{literal}

	<script type="text/javascript">

		/**
		 * 选择日期类型
		 * 1 长期
		 * 2 限时
		 * @param i
		 */
		function radioChange(i){
			var group_end_time = $('#group_end_time');
			if(i == 1){
				console.log(1);
				group_end_time.attr('disabled','disabled');
				group_end_time.val('');
				radio = 1;
				var startdate = $("#group_start_time").val();
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
				group_end_time.removeAttr('disabled');
				$("#end_year").val('');
				radio = 2;
			}
		}

		/**
		 * 计算一年后的今天
		 * @param time
		 * @returns {string}
		 */
		function oneYearPast(time)
		{
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

		/**
		 * 保存拼团数据
		 * @returns {boolean}
		 */
        function baocungroup(){
			var pList = '{';
			var goods_id = '';
			var each_times = 0;
			$("input[type='checkbox']").each(function () {
				//如果选中状态
				if ($(this).is(':checked')) {
					//判断每一次的id是否相等
					if(goods_id == ''){
						goods_id = $(this).val();
					}else if (goods_id != $(this).val()){
						layer.msg('请选择同一个产品id号的商品');
						pList = [];
						goods_id = '';
						checkdata = false;
						return;
					}
					let attr = $(this).attr('attr-data');
					pList +='"'+attr+'":"~",';
					each_times++;
				}
			});

			console.log(each_times);
            if(each_times == 0){
                layer.msg('请选择拼团商品');
                checkdata = false;
                return;
            }
            pList=pList.substring(0,pList.length-1);
            pList +='}';

            var checkdata = true;
            var gdata = {};
            var timehour = gdata['timehour'] = $("input[name=timehour]").val();
            var starttime = gdata['starttime'] = $("input[name=starttime]").val();
            var groupnum = gdata['groupnum'] = $("input[name=groupnum]").val();
            var productnum = gdata['productnum'] = $("input[name=productnum]").val();
            var overtype = gdata['overtype'] = $("input[name=endtime]:checked").val();
            var endtime = $("input[name=group_end_time]").val();

            var manlevel = $('.manlevel');
            var glevel = {};

            $.each(manlevel,function (index,element){
                var min_man = parseInt($(element).children('input[name=min_man]').val());
                var canprice = $(element).children('input[name=canprice]').val();
                var memberprice = $(element).children('input[name=memberprice]').val();
                var man_num = $(element).children('.man_num').val();
                console.log("man_num");
                console.log(man_num);
                if(glevel[min_man]){
                    layer.msg('人数设置参数重复');
                    checkdata = false;
                    return;
                }
                if(min_man == ''){
					layer.msg('人数设置参数不能为空');
					checkdata = false;
					return;
				}
				if(man_num == ''){
					layer.msg('人数设置参数不能为空');
					checkdata = false;
					return;
				}
                if(canprice == '' || memberprice == ''){
                    layer.msg('价格设置参数不能为空');
                    checkdata = false;
                    return;
                }
                if(parseInt(canprice) < parseInt(memberprice)){
                    layer.msg('参团价格不能小于开团价格');
                    checkdata = false;
                    return;
                }
                glevel[min_man] = canprice+'~'+memberprice;
            })
			console.log('rule_end1');

            if(checkdata == true){
                if(timehour == ''){
                    layer.msg('拼团倒计时设置不能为空');
                    checkdata = false;
                    return;
                }else if(starttime == ''){

                    layer.msg('开始时间设置不能为空');
                    checkdata = false;
                    return;
                }else if($("input[name=endtime]:checked").val() == 2 && endtime == ''){

                    layer.msg('结束时间设置不能为空');
                    checkdata = false;
                    return;
                }else if(groupnum == ''){

                    layer.msg('团数限制不能为空');
                    checkdata = false;
                    return;
                }else if(productnum == ''){

                    layer.msg('产品购买件数限制不能为空');
                    checkdata = false;
                    return;
                }
            }
			console.log('rule_end');
            if(checkdata == true){
                var stime = new Date(starttime).getTime();
                var now = new Date().getTime();
				now = now - (3600 *1000);

				if(overtype == '2'){
                    gdata['endtime'] = endtime;
                    var etime = new Date(endtime).getTime();

                    console.log('开始时间');
                    console.log(stime);
                    if(stime < now || etime < now || stime >= etime){
                        layer.msg('时间设置不合格!');
                        return false;
                    }
                }else{
                    gdata['endtime'] = 'changqi';
                    if(stime < now){
						layer.msg('开始时间必须大于当前时间!');
                        return false;
                    }
                }

				var title = $("input[name='title']").val();

				gdata = JSON.stringify(gdata);
                $.ajax({
                    url:"index.php?module=go_group&action=Addgroup",
                    type:"post",
                    data:{gdata:gdata,glevel:glevel,tuanZ:pList,goods_id:goods_id,group_title:title},
                    dataType:"json",
                    success:function(data) {
                        if(data.code == 1){
                            layer.msg('添加成功!',{time:1000},function(){
                                window.location.href = 'index.php?module=go_group';
                            });
                        }else{
                            layer.msg('发布失败!');
                        }
                    },
                })
            }
        }

		/**
		 * 复选框唯一限制函数
		 * @param i
		 */
		function check_one(i){

			var arr=i.split('id');

			console.log(arr);
			i = arr[1];
			console.log('check_one_'+i);
			if($("input[id="+i+"]").prop("checked")==true){
				$("input[id!="+i+"][name='id[]']").removeAttr("checked");
			}
		}

		/**
		 * 页面加载的时候执行
		 */
		window.onload = function(){
			var old_pro_html = '';

			//ajax请求--获取拼团商品列表
			$("#my_query").on("click",function(){

				var my_brand = $('select[name=brand] option:selected').val();
				var my_class = $('select[name=class] option:selected').val();
				var pro_name =$('input[name=p_name]').val();

				$.ajax({

					type:"POST",
					dataType:"json",
					data:{my_brand:my_brand,my_class:my_class,pro_name:pro_name},
					url:"index.php?module=go_group&action=Addproduct&m=pro_query",
					success:function(data){

						var res = data.res;
						var table = '';
						if(old_pro_html == ''){
							old_pro_html = $("#proattr").html();
							console.log('设置old_pro_html');
							console.log(old_pro_html);
						}
						if(res.length > 0){//有拼团商品数据

							$.each(res,function(index,element){
								table += '<tr class="text-c" style="height:60px!important;">' +
                                    '<input type="hidden" name="attr_id"  value="'+element.attr_id+'">' +
                                    '<td class="tab_label">' +
                                    '<input  type="checkbox" class="inputC input_agreement_protocol" attr-data="'+element.attr_id+'" id = "'+element.id+index+'" targ="'+element.id+index+'" name="id[]" onchange="check_one('+element.id+index+')" value = "'+element.id+'" style="position: absolute;">' +

										' <label for="'+element.id+index+'">' +
                                    '</label>' +
                                    '</td>' +
                                    '<td>'+(index+1)+'</td>' +
                                    '<td style="display: flex;align-items: center;">' +
                                    // '<img src ="'+element.image+'" style="width: 40px;height:40px;">'+element.product_title+' '+ element.attr+'</td>' +
                                    '<img src ="'+element.image+'" style="width: 40px;height:40px;"><span class="cont" title="'+element.product_title+'">'+element.product_title+'</span></td>' +
                                    ' <td>'+element.id+'</td> ' +
                                    ' <td>'+element.name+'</td> ' +
                                    '<td>'+element.num+'</td> ' +
                                    '<td>'+element.min_inventory+'</td> ' +
                                    '<td>'+element.price+'</td>' +
                                    '</tr>';
								$("#proattr").html(table);
							})

						}else{//无拼团数据
							$("#proattr").empty();
							layer.msg('没有拼团商品',{time:2000})
						}

						var table_height = $("#prolist").css('height');//单位为px
						table_height = table_height.slice(0,-2);
						if(table_height >= 200){
							$("#prolist").addClass('scrolly');
						}
					}

				})



			})

			/**
			 * ajax请求--获取商品品牌
			 * 根据分类变化请求对应的品牌
			 */
			$("select[name='class']").on('change',function(){
				var cid = $("select[name='class']").val();
				console.log('cid='+cid);
				if(cid == ''){
					console.log('终止');
					// var brand = '<option value="">请选择品牌</option>'
					// $("select[name='brand']").html(brand)
					return false
				}
				$.ajax({
					url:"index.php?module=go_group&action=Addproduct&m=pro_brand",
					type:"post",
					data:{cid:cid},
					dataType:"JSON",
					success:function(data){
						console.log(data)
						if(data.length > 0){
							var brand = '<option value="">请选择品牌</option>'
							$.each(data,function(index,element){
								brand += '<option value="'+element.brand_id+'">'+element.brand_name+'</option>';
							})
							$("select[name='brand']").html(brand)
							console.log(brand)
						}

					}
				})

			})
			/**
			 * 还原搜索栏
			 */
			$("#huanyuan").click(function () {
				if(old_pro_html != ''){
					$("#proattr").html(old_pro_html);
				}
				$("select[name='class']").val('');
				var brand = '<option value="">请选择品牌</option>'
				$("select[name='brand']").html(brand)
				$("input[name='p_name']").val('');
			})
		}

		/**
		 * 添加拼团人数比例
		 */
		function addlever() {

			var node = '<div class="manlevel">' +
					'<input type="number"  max="50" min="1" class="input-text man_num ct-rs" value="" name="min_man" style="width:60px;" onkeyup="onkeyup1(this)">&nbsp;&nbsp;人团&nbsp;&nbsp;' +
					'<span style="margin-left:20px;">折扣价: 参团' +
					'</span><input type="number" class="input-text" value=""  name="canprice" style="width:80px;margin-left:5px;" onkeyup="onkeyup1(this)">&nbsp;%' +
					'<span style="margin-left: 10px;">开团</span>' +
					'<input type="number" class="input-text" value=""  name="memberprice" style="width:80px;margin-left:5px;" onkeyup="onkeyup1(this)">&nbsp;%' +
					'<input class="btn btn-primary radius" type="button" onclick="removepro(event)" value="删除" style="margin-left:10px;height: 36px!important;">' +
					'</div>';

			var setlevel = $('#setlevel');
			setlevel.append(node);
		}

		function onkeyup1(ob){
			if(ob.value.length==1){ob.value=ob.value.replace(/[^1-9]/g,'')}else{ob.value=ob.value.replace(/\D/g,'')}
		}

		function removepro(event){
			var goods = event.srcElement.parentNode;
			goods.parentNode.removeChild(goods);

		}

		document.onkeydown = function (e) {
			if (!e) e = window.event;
			if ((e.keyCode || e.which) == 13) {
				$("[name=Submit]").click();
			}
		}

		laydate.render({
			elem: '#group_start_time', //指定元素
			trigger: 'click',
			type: 'datetime',
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
			elem: '#group_end_time',
			trigger: 'click',
			type: 'datetime'
		});





	</script>

{/literal}
</body>
</html>