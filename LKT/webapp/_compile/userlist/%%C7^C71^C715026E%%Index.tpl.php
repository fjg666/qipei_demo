<?php /* Smarty version 2.6.31, created on 2019-12-20 16:10:05
         compiled from Index.tpl */ ?>
<!--
 * @Descripttion: 
 * @version: V3
 * @Author: 凌烨棣
 * @Date: 2019-09-30 14:05:55
 * @LastEditors: 凌烨棣
 * @LastEditTime: 2019-12-12 17:14:47
 -->

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link href="style/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<!--<link href="style/lib/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="style/js/jquery.js"></script>
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
.tab_table{
    height: auto;
}
.textIpt{
    border: 1px solid #eee;
    padding-left:20px;
    height: 30px;
    line-height: 30px;
}

.fd-btn a:first-child{background-color: #2890FF!important;}
.fd-btn a:first-child:hover{background-color: #2481E5!important;color: white!important;}
.fd-btn a:last-child:hover{border:1px solid #2481E5!important;color: #2481E5!important;}

#allAndNotAll{
    position: absolute;
}
#btn8:hover{border: 1px solid #2890FF!important;color: #2890FF!important;}
.btn1 {
    padding: 0px 10px;
    height: 36px;
    line-height: 36px;
    display: flex;
    justify-content: center;
    align-items: center;
    float: left;
    color: #6a7076;
    background-color: #fff;
}
.active1 {
    color: #fff;
    background-color: #62b3ff;
}
.swivch a:hover {
    text-decoration: none;
    background-color:#2481e5!important;;
    color: #fff;
}
</style>
<script type="text/javascript">
setSize();
addEventListener(\'resize\',setSize);
function setSize() {
    document.documentElement.style.fontSize = document.documentElement.clientWidth/750*100+\'px\';
}
/*alert弹出层*/
function jqalert(param) {
    var title = param.title,
        content = param.content,
        yestext = param.yestext,
        notext = param.notext,
        yesfn = param.yesfn,
        nofn = param.nofn,
        id = param.id,
        url = param.url,
        nolink = param.nolink,
        yeslink = param.yeslink,
        prompt = param.prompt,
        click_bg = param.click_bg,
        obj = param.obj,
        type = param.type,
        price = param.price,
        str = \'<a style="text-decoration:none" class="ml-5" href="index.php?module=return&action=view&id=\'+param.id+\'" title="查看"><i class="Hui-iconfont">&#xe63e;</i></a>\',
        td = $(obj).parent("td");
        if(type=="score"){
            title="积分充值"
        }
        else if(type=="money"){
            title="金额充值"
        }
    console.log(id);
    if (click_bg === undefined){
        click_bg = true;
    }
    if (yestext === undefined){
        yestext = \'确认\';
    }
    if (!nolink){
        nolink = \'javascript:void(0);\';
    }
    if (!yeslink){
        yeslink = \'javascript:void(0);\';
    }

    var htm = \'\';
    htm +=\'<div class="maskNew" id="jq-alert"><div class="maskNewContent alert" style="height:250px">\';
    if(title) htm+=\'<div class="maskTitle" style="font-weight:600">\'+title+\'</div>\';
    if (prompt){
        if(type=="score"){
            prompt="积分金额："
        }
        else if(type=="money"){
            prompt="余额金额："
        }
        htm += \'<div class="content"  style="text-align:center;font-size:22px;margin:0 auto;padding-top: 20px;"><div class="prompt">\';
        htm += `<span class="prompt-content"style=" display:inline-block;text-align:center;font-size:16px;margin-top:30px;padding-right:10px">${prompt}</span>
                    <input type="number" style="width:200px;padding-left:20px" placeholder="请输入充值的金额"  maxlength="11" oninput="if(value.length>10)value=value.slice(0,10)"
                    min="0" max="1000000" class="prompt-text textIpt">
                    <div style="color:#ff453d;font-size:12px;margin-top:10px;"><i><img style="margin-right:5px;width:12px;height:12px;" src="images/icon1/ts.png"/></i>扣除请添加负号</div>

                </div>`
        htm +=\'</div>\';
    }else {
        if(type == 1){
            htm+=\'<div class="content"  style="text-align:center;font-size:18px;margin:30px auto;padding-top: 20px;">\'+content+\'</div>\';
        }else{
            htm += \'<div class="content" style="padding-top: 20px;"><div class="prompt"  style="text-align:center;font-size:18px;margin-bottom:30px;">\';
            htm += \'<div class="prompt-content">\'+content+\'</div>\';
            htm += \'<span class="pd20">应退：\'+price+\' <input type="hidden" value="\'+price+\'" class="ytje">   &nbsp; 实退:</span><input type="text" value="\'+price+\'" class="prompt-text inp_maie"></div>\';
            htm +=\'</div>\';
        }

    }
    if (!notext){
        htm+=\'<div class="fd-btn"><a href="\'+yeslink+\'" class="confirm closeMask" id="yes_btn" style="display:inline-block;">\'+yestext+\'</a></div>\'
        htm+=\'</div>\';
    }else {
        htm+=\'<div class="fd-btn" style="text-align:center;font-size:18px;margin:30px auto;">\'+

            \'<a href="\'+yeslink+\'" class="confirm closeMask" style="display:inline-block;margin-right:30px;height:35px;line-height:35px;font-size:14px"  id="yes_btn">\'+yestext+\'</a>\'+
            \'<a href="\'+nolink+\'"  data-role="cancel" class="cancel closeMask" style="display:inline-block;background:#fff;color:#007aff;height:35px;line-height:35px;font-size:14px">\'+notext+\'</a>\'+

            \'</div>\';
        htm+=\'</div>\';
    }
    $(\'body\').append(htm);
    var al = $(\'#jq-alert\');
    al.on(\'click\',\'[data-role="cancel"]\',function () {
        al.remove();
        if (nofn){
            param.nofn();
            nofn = \'\';
        }
        param = {};
    });
    $(document).delegate(\'.alert\',\'click\',function (event) {
        event.stopPropagation();
    });
    $("#yes_btn").click( function () {

        var price = Number($(".prompt-text").val());
        console.log(price);
        if(price > 1000000){
            alert(\'充值金额不能大于1000000\');
            return false
         
        }

        $.ajax({
            type: "GET",
            url: url,
            data:{
                user_id:id,
                m:type,
                price:price
            },
            success: function(res){
                console.log(res)
                if(res == 1){
                    layer.msg(\'提交成功\');
                    setTimeout(function () {
                        al.remove();
                        location.replace(location.href);
                    },300);
                }else{
                    layer.msg(\'操作失败!\');
                }
            }
        });
    });

    if(click_bg === true){
        $(document).delegate(\'#jq-alert\',\'click\',function () {
            setTimeout(function () {
                al.remove();
            },300);
            yesfn =\'\';
            nofn = \'\';
            param = {};
        });
    }

}
/*toast 弹出提示*/
function jqtoast(text,sec) {
    var _this = text;
    var this_sec = sec;
    var htm = \'\';
    htm += \'<div class="jq-toast" style="display: none;">\';
    if (_this){
        htm +=\'<div class="toast">\'+_this+\'</div></div>\';
        $(\'body\').append(htm);
        $(\'.jq-toast\').fadeIn();

    }else {
        jqalert({
            title:\'提示\',
            content:\'提示文字不能为空\',
            yestext:\'确定\'
        })
    }
    if (!sec){
        this_sec = 2000;
    }
    setTimeout(function () {
        $(\'.jq-toast\').fadeOut(function () {
            $(this).remove();
        });
        _this = \'\';
    },this_sec);
}
</script>

<style>
.show-list{
    width:80%;
    margin: 0 auto;
}
.show-list li{
    height: 10px;
    font-size: 18px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    border-bottom: 1px solid #dcdcdc;
}
*{
    margin: 0;
    padding:0;
    list-style: none;
}
a{
    text-decoration: none;
}

/*jq-alert弹出层封装样式*/
.jq-alert{
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: row;
    flex-direction: row;
    -webkit-justify-content: center;
    -webkit-align-items: center;
    justify-content: center;
    align-items: center;
    background-color: rgba(0,0,0,.3);
    z-index: 99;
}
.jq-alert .alert{
    background-color: #FFF;
    width:440px;
    height:250px;
    border-radius: 4px;
    overflow: hidden;
}
.jq-alert .alert .title{
    position: relative;
    margin: 0;
    font-size: 18px;
    text-align: center;
    font-weight: normal;
    color: rgba(0,0,0,.8);
}
.jq-alert .alert .content{
    padding:0 18px;
    font-size: 18px;
    color: rgba(0,0,0,.6);
    height: 56%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.jq-alert .alert .content .prompt{
    width:100%;
}
.jq-alert .alert .content .prompt .prompt-content{
    font-size: 18px;
    color: rgba(0,0,0,.54);
    margin: 0;
    margin-bottom: 20px;
    /*text-align: center;*/
}
.jq-alert .alert .content .prompt .prompt-text{
    height: 50px;
    background:none;
    border:none;
    outline: none;
    width: 100%;
    box-sizing: border-box;
    margin-top: 20px;
    background-color: #FFF;
    border:1px solid #dcdcdc;
    text-indent:5px;
    text-align: center;
}
.jq-alert .alert .content .prompt .prompt-text:focus{
    border: 1px solid #2196F3;
    background-color: rgba(33,150,243,.08);
}
.jq-alert .alert .fd-btn{
    height: 50px;
    position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-direction: row;
    flex-direction: row;
    -webkit-justify-content: center;
    -webkit-align-items: center;
    justify-content: center;
    align-items: center;
}
.jq-alert .alert .fd-btn:after{
    position: absolute;
    content: "";
    top:0;
    left:0;
    width:100%;
    height: 1px;
    background-color: #F3F3F3;
}
.jq-alert .alert .fd-btn a{
    width:100%;
    font-size: 18px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    color: rgba(0,0,0,.8);
}
.jq-alert .alert .fd-btn a.cancel{
    position: relative;
    color: rgba(0,0,0,.5);
    line-height: 50px;
}
.jq-alert .alert .fd-btn a.cancel:after{
    content: "";
    position: absolute;
    top:.1rem;
    right:0;
    width: 1px;
    height: .6rem;
    background-color: #F3F3F3;
}
.jq-alert .alert .fd-btn a.confirm{
    color: #2196F3;
}
.jq-alert .alert .fd-btn a.confirm:active{
    background-color: #2196F3;
    color: #FFF;
}

/*toast弹出层*/
.jq-toast{
    z-index: 999;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    flex-direction: row;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    justify-content: center;
    -webkit-justify-content: center;
    align-items: center;
    -webkit-align-items: center;
}
.jq-toast .toast{
    max-width: 80%;
    padding: 10px 20px;
    background-color: rgba(0,0,0,.48);
    color: #FFF;
    border-radius: 4px;
    font-size: 18px;
}
.confirm .cancel{
    text-decoration: none !important;
}
.inp_maie{
    height: 32px !important;
    width: 20% !important;
    margin-top: 0 !important;
}
.dj{
    color: #fff;
    font-size: 12px;
    border-radius: 2px;
    width: 40%;
    display: block;
    margin: 5px;
    float: left;
}
#DataTables_Table_0_length{
    position: absolute;
    bottom: 3px;
    padding-bottom: 10px;
    left: 20px;
}
#DataTables_Table_0_info{
    margin-left: 20px;
}
#btn1:hover{
    background-color: #2481e5!important;
}
.tab_td .tab_five a:nth-child(6){
    width: 44%!important;}
	
.tab_td .tab_five{overflow: visible;}

.tab_five a:hover .icon_sj{
	border-top-color: #2890FF
}
.gd_div{
	margin: 4px 4px 4px 0;height: 22px;position: relative;float: left;
}
.gd_div  ul{
	background: #FFFFFF;
	border: 1px solid #EEEEEE;
	border-radius: 2px;
}
.gd_div li {
	width: 56px;
	height: 22px;
	line-height: 22px;
	cursor: pointer;
	color: #414658;
}
.gd_div li:hover{
	background: #2890FF;
	color: #FFFFFF;
}
.gd_div li span{
	display: inline-block;
	font-size: 11px;
	transform: scale(0.9);
}
</style>
'; ?>

<title>订单列表</title>
</head>
<body class='iframe-container'>
<nav class="nav-title">
	<span>会员管理</span>
	<span><span class='arrows'>&gt;</span>会员列表</span>
</nav>
<div class="iframe-content">
    <div class="navigation">
		<div class='active'>
			<a href="index.php?module=userlist&action=Index">会员列表</a>
		</div>
		<p class='border'></p>
		<div>
			<a href="index.php?module=userlist&action=Grade">会员等级</a>
		</div>
		<p class='border'></p>
		<div>
			<a href="index.php?module=userlist&action=Config">会员设置</a>
		</div>
    </div>
    <div class="hr" ></div>
    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=userlist&action=Add">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加会员
            </div>
        </a>
    </div>
    <div class="hr" ></div>
    <div class="text-c">
        <form method="get" action="index.php" name="form1" class='iframe-search'>
            <div style="border-left:solid 1px #fff;">
                <input type="hidden" name="module" value="userlist"  />
                <input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize" />
                <input type="text" class="input-text"  autocomplete="off" style="width:200px" placeholder="请输入会员id" name="user_id" value="<?php echo $this->_tpl_vars['user_id']; ?>
">
                <input type="text" class="input-text"  autocomplete="off" style="width:200px" placeholder="请输入会员名称" name="user_name" value="<?php echo $this->_tpl_vars['user_name']; ?>
">
                <select name="grade" class="select" style="width: 140px;vertical-align: middle;background-color: rgb(255, 255, 255);">
                    <option value="" >请选择会员等级</option>
                    <?php echo $this->_tpl_vars['grade']; ?>

                </select>
                <select name="is_out" class="select" style="width: 140px;vertical-align: middle;background-color: rgb(255, 255, 255);">
                    <option value="" >是否过期</option>
                    <option value="0" <?php if ($this->_tpl_vars['is_out'] === '0'): ?>selected="selected"<?php endif; ?>>未过期</option>
                    <option value="1" <?php if ($this->_tpl_vars['is_out'] === '1'): ?>selected="selected"<?php endif; ?>>已过期</option>
                </select>
                <select name="source" class="select" style="width: 140px;vertical-align: middle;background-color: rgb(255, 255, 255);">
                    <option value=""  >请选择账号来源</option>
                    <option value="1" <?php if ($this->_tpl_vars['source'] == 1): ?> selected <?php endif; ?>>小程序</option>
                    <?php if ($this->_tpl_vars['is_app'] == 1): ?>
                    <option value="2" <?php if ($this->_tpl_vars['source'] == 2): ?> selected <?php endif; ?>>手机App</option>
                    <?php endif; ?>
                   
                </select>
                <input type="text" class="input-text" autocomplete="off" style="width:200px" placeholder="请输入手机号码" name="tel" value="<?php echo $this->_tpl_vars['tel']; ?>
">
                <input type="button" value="重置" id="btn8" style="border: 1px solid #D5DBE8; color: #6a7076;" class="reset" onclick="empty()" />

                <input name="" id="btn1" class="btn btn-success" type="submit" value="查询">
                <input type="button" id="btn2" value="导出" class="btn btn-success" onclick="export_popup(location.href)" style="float:right;">
            </div>
        </form>
    </div>
    <div class="hr"></div>
    <div class="tab_table iframe-table">
        <table class="table-border tab_content">
            <thead>
                <tr class="text-c tab_tr">
                    <th class="tab_num" style="font-weight: bold;">会员ID</th>
                    <th class="tab_imgurl" style="font-weight: bold;">会员头像</th>
                    <th class="tab_title" style="font-weight: bold;">会员昵称</th>
                    <th class="tab_title" style="font-weight: bold;">会员账号</th>
                    <th class="tab_title" style="font-weight: bold;">会员级别</th>
                    <th class="tab_title" style="font-weight: bold;">会员手机号码</th>
                    <th class="tab_title" style="font-weight: bold;">账户余额</th>
                    <th class="tab_title" style="font-weight: bold;">积分余额</th>
                    <th class="tab_title" style="font-weight: bold;">账号来源</th>
                    <th class="tab_num" style="font-weight: bold;">有效订单数</th>
                    <th class="tab_num" style="font-weight: bold;">交易金额</th>
                    <th class="tab_num" style="font-weight: bold;">分享次数</th>
                    <th class="tab_num" style="font-weight: bold;">是否过期</th>
                    <th class="tab_time" style="font-weight: bold;">续费时间</th>
                    <th class="tab_time" style="font-weight: bold;">注册时间</th>
                    <th class="tab_five" style="font-weight: bold;">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                <tr class="text-c tab_td">
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->user_id; ?>
</td>
                    <td class="tab_imgurl"><image class='pimg' src="<?php echo $this->_tpl_vars['item']->headimgurl; ?>
" /></td>
                    <td class="tab_title" style="text-align: center!important;"><?php echo $this->_tpl_vars['item']->user_name; ?>
</td>    
                    <td class="tab_title" style="text-align: center!important;"><?php echo $this->_tpl_vars['item']->zhanghao; ?>
</td>
                    <td class="tab_title" style="text-align: center!important"><?php echo $this->_tpl_vars['item']->grade; ?>
</td>
                    <td class="tab_title" style="text-align: center!important;"><?php echo $this->_tpl_vars['item']->mobile; ?>
</td>
                    <td class="tab_title" style="text-align: center!important;">￥<?php echo $this->_tpl_vars['item']->money; ?>
</td>
                    <td class="tab_title" style="text-align: center!important;"><?php echo $this->_tpl_vars['item']->score; ?>
</td>
                    <td class="tab_title" style="text-align: center!important;">
                        <?php if ($this->_tpl_vars['item']->source == 1): ?>
                        小程序
                        <?php elseif ($this->_tpl_vars['item']->source == 2): ?>
                        APP
                        <?php endif; ?>
                    </td>
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->z_num; ?>
</td>
                    <td class="tab_num">￥<?php echo $this->_tpl_vars['item']->z_price; ?>
</td>
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->share_num; ?>
</td>
                    <td class="tab_num">
                        <?php if ($this->_tpl_vars['item']->is_out == 1): ?>
                            是
                        <?php else: ?>
                            否
                        <?php endif; ?>
                    </td>
                    <td class="tab_time">
                        <?php if ($this->_tpl_vars['item']->grade == '普通会员'): ?>
                            暂无
                        <?php else: ?>
                            <?php echo $this->_tpl_vars['item']->grade_end; ?>

                        <?php endif; ?>
                    </td>
                    <td class="tab_num"><?php echo $this->_tpl_vars['item']->Register_data; ?>
</td>
                    <td   class="tab_five">
                        <?php if ($this->_tpl_vars['button'][1] == 1): ?>
                            <a  href="index.php?module=userlist&action=View&id=<?php echo $this->_tpl_vars['item']->user_id; ?>
" title="查看" >
                                <img src="images/icon1/ck.png"/>&nbsp;查看
                            </a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['button'][3] == 1): ?>
                            <a  title="编辑" href="index.php?module=userlist&action=Modify&id=<?php echo $this->_tpl_vars['item']->user_id; ?>
">
                                  <img src="images/icon1/xg.png"/>&nbsp;编辑
                            </a>
                        <?php endif; ?>

                        <?php if ($this->_tpl_vars['button'][2] == 1): ?>
                            <?php if ($this->_tpl_vars['item']->level == ''): ?>
                            <a  href="javascript:void(0);" onclick="confirm('确定要删除此用户吗?','<?php echo $this->_tpl_vars['item']->user_id; ?>
','index.php?module=userlist&action=Del&id=','删除')">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                            <?php else: ?>
                            <a  href="javascript:void(0);" onclick="return false;" style="opacity: 0.3">
                                    <img src="images/icon1/del.png"/>&nbsp;删除
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        </br>
                        <?php if ($this->_tpl_vars['button'][0] == 1): ?>
							<div class='gd_div'>
								<a href="javascript:;" title="更多" style='width: 56px!important;display: flex;align-items: center;justify-content: center;margin: 0;'>
										更多&nbsp;
										<i class='icon_sj'></i>
								 </a>
								 <ul style='position: absolute;top: 22px;background: #FFFFFF;z-index: 99;left: 0;display: none;'>
								 	<li onclick="refuse(this,'<?php echo $this->_tpl_vars['item']->user_id; ?>
','money','请输入充值的余额，扣除添加负号')"><span>余额充值</span></li>
								 	<li onclick="refuse(this,'<?php echo $this->_tpl_vars['item']->user_id; ?>
','score','请输入充值的积分金额，扣除添加负号')"><span>积分充值</span></li>
								 	<li onclick="lv_modify('<?php echo $this->_tpl_vars['item']->user_id; ?>
')"><span>等级修改</span></li>
								 </ul>
							</div>
							 <!-- <a href="javascript:;" title="充值余额" onclick="refuse(this,'<?php echo $this->_tpl_vars['item']->user_id; ?>
','money','请输入充值的余额，扣除添加负号')">
								  <img src="images/icon1/yecz.png"/>&nbsp;充值余额
							  </a>
							  <a href="javascript:;" title="充值积分" onclick="refuse(this,'<?php echo $this->_tpl_vars['item']->user_id; ?>
','score','请输入充值的积分金额，扣除添加负号')">
								  <img src="images/icon1/jfcz.png"/>&nbsp;充值积分
							  </a> -->
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
    <div class="tb-tab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>

<div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;"><div id="innerdiv" style="position:absolute;"><img id="bigimg" src="" /></div></div>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/laydate/laydate.js"></script>
<script type="text/javascript" src="style/js/Popup.js"></script> <!-- 导出页弹窗-->

<?php echo '
<script type="text/javascript">

//layui日历插件
laydate.render({
    elem: \'#startdate\', //指定元素
    type: \'date\'
});
laydate.render({
    elem: \'#enddate\',
    type: \'date\'
});

function excel(pageto) {
    var pagesize = $("#pagesize").val();
    location.href=location.href+\'&pageto=\'+pageto+\'&pagesize=\'+pagesize;
}
function empty() {
   $("input[name=\'user_id\']").val("")
   $("input[name=\'user_name\']").val("")
   $("select[name=\'grade\']").val("")
   $("select[name=\'is_out\']").val("")
   $("select[name=\'source\']").val("")
   $("input[name=\'tel\']").val("")
}
function refuse(obj,id,type,text) {
    jqalert({
        title:\'充值\',
        prompt:text,
        yestext:\'提交\',
        notext:\'取消\',
        id:id,
        url:"index.php?module=userlist&action=Recharge",
        obj:obj,
        type:type,
    })
};

var ids= [];

Array.prototype.indexOf = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
}
Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
}


Array.prototype.distinct = function(){   //数组去重
    var arr = this,
        result = [],
        i,
        j,
        len = arr.length;
    for(i = 0; i < len; i++){
        for(j = i + 1; j < len; j++){
            if(arr[i] === arr[j]){
                j = ++i;
            }
        }
        result.push(arr[i]);
    }
    return result;
}




function appendMask(content,src){
	$("body").append(`
		<div class="maskNew">
			<div class="maskNewContent">
				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				<div class="maskTitle">提示</div>	
				<div style="text-align:center;margin-top:30px"><img src="images/icon1/${src}.png"></div>
				<div style="height: 50px;position: relative;top:20px;font-size: 18px;text-align: center;">
					${content}
				</div>
				<div style="text-align:center;margin-top:30px">
					<button class="closeMask" onclick=closeMask1() >确认</button>
				</div>
				
			</div>
		</div>	
	`)
};
function closeMask(id,url){
	$.ajax({
    	type:"get",
    	url:+id,
    	async:true,
    	success:function(res){
    		console.log(res)
    		if(res==1){
    			appendMask("删除成功","cg");
    		}
    		else{
    			appendMask("删除失败","ts");
    		}
    	}
    	
   });
  }
function closeMask1(){
	$(".maskNew").remove();
	location.replace(location.href);
}
function confirm (content,id,url,content1){
	$("body",parent.document).append(`
		<div class="maskNew">
			<div class="maskNewContent">
				<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
				<div class="maskTitle">提示</div>	
				<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
				<div style="height: 50px;position: relative;top:20px;font-size: 18px;text-align: center;">
					${content}
				</div>
				<div style="text-align:center;margin-top:30px">
					<button class="closeMask" style="margin-right:20px;font-size:14px;left:100px;border-radius:3px;" onclick=closeMask("${id}","${url}","${content1}") >确认</button>
					<button class="closeMask" style="font-size:14px" onclick=closeMask1() >取消</button>
				</div>
			</div>
		</div>	
	`)
};

// 修改等级
function lv_modify(user_id){
	$.ajax({
	    type: "POST",
	    url: "index.php?module=userlist&action=Index&m=getGrade",
		dataType:\'json\',
	    data:{
	        user_id
	    },
	    success: function(res){
	        if(res.code==200){
				var str=res.grade==0?\'none\':\'block\'
				$("body",parent.document).append(`
					<div class="maskNew">
						<div class="maskNewContent">
							<div style="display: flex; flex-direction: column; justify-content: center; width: 296px; height: 84px; margin: 0 auto; padding-top: 40px;">
								<div>
									<span>会员等级：</span>
									<select id=\'grade_change\' style=\'width: 200px;height: 36px;padding-left: 5px;\'>
										${res.grade_str}
									</select>
									<input type="hidden" value=\'${user_id}\'>
								</div>
								<div style="padding-top: 12px;display:${str}">
									<span>生效时间：</span>
									<select id=\'time_change\' style=\'width: 200px;height: 36px;padding-left: 5px;\'>
										${res.time_str}
									</select>
								</div>
							</div>
							<div style="position: absolute; text-align: center; margin-top: 30px; width: 100%; bottom: 50px;">
								<button id=\'mask_qd\' class="closeMask" style="margin-right:20px;font-size:14px;left:100px;border-radius:3px;">确认</button>
								<button class="closeMask" style="font-size:14px" onclick=closeMask1()>取消</button>
							</div>
						</div>
					</div>
				`)
			}
	    }
	});
}

	// 点击更多
	$(document).on(\'click\',\'.gd_div a\',function(){
		if($(this).next().css(\'display\')==\'none\'){
			$(this).next().css(\'display\',\'block\')
		}else{
			$(this).next().css(\'display\',\'none\')
		}
	})
	$(document).on(\'click\',\'.gd_div ul\',function(){
		$(this).css(\'display\',\'none\')
	})

	// 会员列表等级修改
	$("body",parent.document).on(\'change\',\'#grade_change\',function(){
		var str
		if($(this).val()==0){
			str=\'none\'
		}else{
			str=\'block\'
		}
		$(this).parents(\'.maskNewContent\').find(\'#time_change\').parent().css(\'display\',str)
	})
	
	$("body",parent.document).on(\'click\',\'#mask_qd\',function(){
		var user_id=$(this).parents(\'.maskNewContent\').find(\'#grade_change\').next().val()
		var grade=$(this).parents(\'.maskNewContent\').find(\'#grade_change\').val()
		var method=$(this).parents(\'.maskNewContent\').find(\'#time_change\').val()
		var that=this
		$.ajax({
		    type: "POST",
		    url: "index.php?module=userlist&action=Index&m=modifyGrade",
			dataType:\'json\',
		    data:{
		        user_id,grade,method
		    },
		    success: function(res){
				$(that).parents(".maskNew").remove();
                layer.msg(res.msg); 
		        if(res.code==200){
					location.replace(location.href);
				}else{
					
				}
		    }
		});
	})
    </script>
'; ?>

</body>
</html>