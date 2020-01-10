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
<script type="text/javascript" src="style/js/jquery.min.js"></script>
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
	  
	  
	  .form-scroll .form-item .form_new_img{
		  margin-right: 0!important;
	  }
	  .page_bgcolor a{color: #6A7076;}
	  .page_bgcolor .isclick a{color: #FFFFFF;}
	 [v-cloak]{
	  	display:none;
	  }
  </style>
{/literal}
<title>拼团活动管理</title>
</head>
<body style='display: none;'>
<div id="app" class='iframe-container' v-cloak>
	<nav class="nav-title">
		<span>插件管理</span>
		<span><span class="arrows">&gt;</span>秒杀</span>
		<span><span class="arrows">&gt;</span>秒杀设置</span>
	</nav>
    <div class="iframe-content">
        <div style="display: flex;flex-direction: row;font-size: 16px;" class="page_bgcolor">
            <div class="status qh border-right"  style="border-radius: 2px;line-height: 42px;border: 0;margin-left: 0;"><a href="#"  @click="go_index">秒杀列表</a></div>
            <div class="status qh isclick border-right" style='line-height: 42px;margin-left: 0'><a href="#" @click="go_config">秒杀设置</a></div>
        </div>
        <div class="page_h16"></div>
		<div class='form-scroll p-70' style='flex:1'>
			<p class='page_title'>基础设置</p>
			<div class='form-item form-item1'>
				<div class='form-tr'>
					<label>是否开启秒杀活动 ：</label>
					<div class='switch-box' :class="[is_open == 1?'active':'']" @click='change_flag'>
						<div class='switch-data'></div>
					</div>
				</div>
				<div class='form-tr'>
					<label>秒杀商品默认限购数量：</label>
					<input class='input_150' type="number" placeholder="请输入数量" v-model="buy_num">个
				</div>
				<div class='form-tr' style="display: none">
					<label>秒杀活动轮播图设置：</label>
				    <div class="formInputSD upload-group multiple" style="display: inline-flex;">
				      <div style="display: flex;">
				          <div class="upload-preview-list uppre_auto">
				              <div class="upload-preview form_new_img" {if !$imageurl}style="display: none;"{/if}>
				                  <img src="images/iIcon/sha.png" class="form_new_sha file-item-delete-pp three_img" />
				                  <img :src="[[imageurl]]" class="upload-preview-img" style="margin-top: -23px;width: 78px;height: 78px;">
				                  <input id="imgurl" type="hidden" name="imgurl_my" class="file-item-input" :value="[[imageurl]]">
				              </div>
				          </div>
				          <div data-max='2' class="select-file form_new_file three from_i" {if $imageurl} style="display: none;"{/if}>
				            <div>
				              <img data-max='2' src="images/iIcon/sahc.png" data-toggle="tooltip" data-placement="bottom" title="" class="btn-secondary select-file" />
				              <span class="form_new_span">上传图片</span>
				            </div>
				          </div>
				        </div>
				        <span class="addText">（展示图最多上传一张，建议上传750*300px的图片）</span>
				    </div>
				</div>
{*				<div class='form-tr'>*}
{*					<label>秒杀活动提醒：</label>*}
{*					<span>秒杀活动开始前</span>*}
{*					<input class='input_150' type="number" placeholder="请输入时间" v-model="remind" style='margin: 0 12px;'>*}
{*					<span>分钟，提醒。</span>*}
{*				</div>*}
			</div>
			<p class='page_title'>规则设置</p>
			<div class="row cl" style="margin-bottom: 50px;display: flex; width: 100%;justify-content: left;padding-left: 60px;padding-top: 30px;padding-right: 50px;">
				<div class="formControls col-xs-8 col-sm-10 codes">
					<script id="editor" type="text/plain" name="rule" style="width:105%;height:400px;">{$rule}</script>
				</div>
			</div>
		</div>
		<div class='page_bort'>
			<button class='btn btn-primary radius btn-right right' @click='_save'>保存</button>
		</div>
	</div>
</div>
</body>
<script type="text/javascript" src="style/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="style/laydate/laydate.js"></script>
<script type="text/javascript" src="style/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="style/vue/vue.js"></script>
{include file="../../include_path/ueditor.tpl" sitename="ueditor插件"}
{include file="../../include_path/software_head.tpl" sitename="DIY头部"}
{include file="../../include_path/software_img.tpl" sitename="DIY_IMG"}
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
                limits:[10,25,50,100],
                limit:10,
                add_or_edit:'',
                total:0,//数据总数
                pages:1,
                haspages:0,
				guize:'',  //规则
				is_open:'',  //秒杀开关,默认关闭
				buy_num: '',  //秒杀限购数量
				imageurl:'',  //轮播图设置
				imgBase64:'',  //轮播图展示链接
				remind:'10',  //活动提醒
				rule:'',  //规则设置
				editor:'',  // this.rule.getContent()获取规则设置内容
            },
			created() {
				// 富文本js
				this.editor = UE.getEditor('editor');
				this.axios();
			},
            methods: {
                axios: function (event) {
                    //初始化数据
                    var me = this;
                    console.log('axios');
                    console.log(me.limit);
                    $.ajax({
                        url:'?module=seconds&action=Config&m=axios',//地址
                        dataType:'json',//数据类型
                        type:'POST',//类型
                        data:{

                        },
                        timeout:2000,//超时
                        //请求成功
                        success:function(res){
                            console.log("ajax_success");
                            console.log(res);
                            me.list = res;
                            me.is_open = res.is_open;
                            me.imageurl = res.imageurl;
                            me.buy_num = res.buy_num;
                            me.remind = res.remind;
                            me.rule = res.rule;
							var editor = UE.getEditor('editor');
                            console.log(me.rule);
                            console.log(me.haspages);
							if($('body').css('display')=='none'){
								$('body').css('display','block')
							}
                        },
                        //失败/超时
                        error:function(XMLHttpRequest,textStatus,errorThrown){
                            console.log("ajax_error");
                            layer.msg('获取数据失败');

                        }
                    })
                },
				go_config:function () {
				    var me = this;
				    console.log('go_config');
				    location.href='index.php?module=seconds&action=Config';
				},
				go_index:function () {
				    var me = this;
				    console.log('go_config');
				    location.href='index.php?module=seconds&action=Index';
				},
				// 是否开启秒杀
				change_flag(){
					this.is_open=this.is_open==0?1:0
				},
				// 保存
				_save(){
                	var me = this;
					// 图片 $('#imgurl').prop("value")
					console.log(me.is_open==1?'打开':'关闭')
					console.log(me.buy_num)
					console.log(me.remind)
					console.log(me.editor.getContent())
					if(me.buy_num < 1){
						layer.msg('秒杀数量不能小于1');
						return false
					}
					$.ajax({
						url:'?module=seconds&action=Config&m=save',//地址
						dataType:'json',//数据类型
						type:'POST',//类型
						data:{
							is_open:me.is_open,
							buy_num:me.buy_num,
							remind:me.remind,
							rule:me.editor.getContent(),
							imageurl:$('#imgurl').prop("value"),
						},
						timeout:2000,//超时
						//请求成功
						success:function(res){
							console.log("ajax_success");
							console.log(res);
							me.axios();
							layer.msg(res.msg);

						},
						//失败/超时
						error:function(XMLHttpRequest,textStatus,errorThrown){
							console.log("ajax_error");
							layer.msg('获取数据失败');

						}
					})
				}
            }
        })
		$(document).on('click','.save-group-list',function(){
			setTimeout(()=>{
				// 如果图片上传成功,隐藏上传按钮
				if($('#imgurl').prop("value").length>0){
					$('.three').css('display','none');
				}
			},50)
		})
		$('.three_img').on('click',function(){
		    $('.three').css('display','flex');
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