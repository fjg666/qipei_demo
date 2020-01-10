<?php /* Smarty version 2.6.31, created on 2019-12-24 12:14:48
         compiled from Template.tpl */ ?>
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
    <?php echo '
        <style type="text/css">

            td a {
                width: 28%;
                float: left;
                margin: 2% !important;
            }
        </style>
        <style type="text/css">
        	.wrap {
				width: 60px;
				height: 30px;
				background-color: #ccc;
				border-radius: 16px;
				position: relative;
				transition: 0.3s;
				margin-left: 10px;
			}
			.circle {
			    width: 29px;
			    height: 29px;
			    background-color: #fff;
			    border-radius: 50%;
			    position: absolute;
			    left: 0px;
			    transition: 0.3s;
			    box-shadow: 0px 1px 5px rgba(0, 0, 0, .5);
			}
			.circle:hover {
			    transform: scale(1.2);
			    box-shadow: 0px 1px 8px rgba(0, 0, 0, .5);
			}
			
        </style>
    '; ?>

</head>
<body>
<nav class="breadcrumb page_bgcolor">
                    <span class="c-gray en"></span>
                    <span  style='color: #414658;'>授权管理</span>
                    <span  class="c-gray en">&gt;</span>
                    <span  style='color: #414658;'>模板设置</span>
            
</nav>
<div class="pd-20 page_absolute">

    <div class="page_bgcolor">
        <a class="btn newBtn radius" href="index.php?module=third&action=TemplateAdd">
            <div style="height: 100%;display: flex;align-items: center;">
                <img src="images/icon1/add.png"/>&nbsp;添加模板
            </div>
        </a>
    </div>
    <div class="page_h16"></div>
    <div class="text-c">
        <form name="form1" action="index.php" method="get" class="pd_form1">
            <input type="hidden" name="module" value="third"/>
            <input type="hidden" name="action" value="template">
            <input type="hidden" name="pagesize" value="<?php echo $this->_tpl_vars['pagesize']; ?>
" id="pagesize" />
           
            <select name="trade_data" class="select query_select" >
                <option value="">请选择模板行业</option>
                <?php $_from = $this->_tpl_vars['res_trade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
?>
                <option value="<?php echo $this->_tpl_vars['item']->trade_code; ?>
" <?php if ($this->_tpl_vars['item']->trade_code == $this->_tpl_vars['trade_data']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']->trade_text; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
           </select>

           <select name="is_use" class="select query_select">
           		<option value="">选择是否应用</option>

           		<option value="1" <?php if ($this->_tpl_vars['is_use'] == 1): ?>selected="selected" <?php endif; ?>>应用</option>
           		<option value="0" <?php if ($this->_tpl_vars['is_use'] === 0): ?>selected="selected"<?php endif; ?>>不应用</option>
           	
           </select>
           <input type="text" name="title" size='8' value="<?php echo $this->_tpl_vars['title']; ?>
" id="" placeholder=" 模板名称" class="input-text query_inputs">
           <input name="" id="btn1" class="query_cont nmor" type="submit" value="查询" style="width:60px;height: 36px;border-radius: 2px;background: #2890ff;">
        </form>
    </div>
    <div class="page_h16"></div>
    <div class="mt_20 table-scroll" style="height: 72vh;">
            <table class="table-border tab_content">
                    <thead>
                        <tr class="text-c tab_tr">
                            <th class="tab_title">编号</th>
                            <th class="tab_title">名称</th>
                            <th class="tab_title">行业</th>
                            <th class="tab_imgurl">展示图</th>
                          	<th class="tab_title">模板ID</th>
                            <th class="tab_title">简介</th>
                          	<th class="tab_title">是否应用</th>
                            <th class="tab_editor">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<input type="hidden" name="num" value="<?php echo $this->_tpl_vars['num']; ?>
" id="num">
                        <?php $_from = $this->_tpl_vars['res']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
        $this->_foreach['f1']['iteration']++;
?>
                        <tr class="text-c tab_td">
                           
                            
                            <td class="tab_title" style="text-align:center!important;"><?php echo $this->_tpl_vars['item']->id; ?>
</td>
                            <td class="tab_title" style="text-align:center!important;"><?php echo $this->_tpl_vars['item']->title; ?>
</td>
                            <td class="tab_title" style="text-align: center!important;">
                            	
                            	<span><?php echo $this->_tpl_vars['item']->trade_text; ?>
</span>
                               
                            
                            </td>
                            <td class="tab_imgurl"><img src="<?php echo $this->_tpl_vars['item']->image; ?>
" style="width: 60px;height:60px;"/></td>
                            <td class="tab_title" style="text-align: center!important;"><?php echo $this->_tpl_vars['item']->template_id; ?>
</td>
                            <td class="tab_title" style="text-align:center!important;"><?php echo $this->_tpl_vars['item']->lk_desc; ?>
</td>
                            <td>
                            	<div style="display: flex;justify-content: center;">
                            		<div class="change_box" style="width: 60px;">
                            			<div class="wrap" onclick="up(<?php echo $this->_tpl_vars['k']; ?>
,<?php echo $this->_tpl_vars['item']->id; ?>
)" is_use="<?php echo $this->_tpl_vars['item']->is_use; ?>
" style="margin: 0;<?php if ($this->_tpl_vars['item']->is_use == 1): ?>background-color:#5eb95e;<?php else: ?>background-color: #ccc;<?php endif; ?>">
                            				<div class="circle" id="circle_<?php echo $this->_tpl_vars['k']; ?>
" style="<?php if ($this->_tpl_vars['item']->is_use == 1): ?>left:30px;<?php else: ?>left:0px;<?php endif; ?>"></div>
                            			</div>
                            		</div>
                            	</div>
                            </td>
                            <td class="tab_editor">
                               <div style="width: 100%;display: flex;align-items: center;justify-content: center;">
								   <a style="text-decoration:none" class="ml-7" href="index.php?module=third&action=TemplateModify&id=<?php echo $this->_tpl_vars['item']->id; ?>
" title="编辑">
								        <img src="images/icon1/xg.png"/>&nbsp;编辑
								   </a> 
								                                
								   <a title="删除" href="javascript:;" onclick="confirm('确认要删除吗？',<?php echo $this->_tpl_vars['item']->id; ?>
,'index.php?module=third&action=TemplateModify&m=del&id=','删除')" class="ml-7" >
								                   <img src="images/icon1/del.png"/>&nbsp;删除                
								   </a>
							   </div>
                            </td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </tbody>
            </table>
        
    </div>
    <div class="tbtab" style="text-align: center;display: flex;justify-content: center;"><?php echo $this->_tpl_vars['pages_show']; ?>
</div>
</div>

<script type="text/javascript" src="style/js/jquery.js"></script>

<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/layer/layer.js"></script>
<!--<script type="text/javascript" src="style/lib/My97DatePicker/WdatePicker.js"></script>-->
<script type="text/javascript" src="style/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="style/js/H-ui.js"></script>
<script type="text/javascript" src="style/js/H-ui.admin.js"></script>

<?php echo '
<script type="text/javascript">
	// 根据框架可视高度,减去现有元素高度,得出表格高度
	var Vheight = $(window).height()-56-56-16-36-16-($(\'.tbtab\').text()?70:0)
	$(\'.table-scroll\').css(\'height\',Vheight+\'px\')
	function up(k,id){
		var status_1 = $("#circle_"+k).parent(".wrap").attr("is_use");

		if(status_1 == 0){
			$(\'#circle_\'+k).css(\'left\', \'30px\'),
	        $(\'#circle_\'+k).css(\'background-color\', \'#fff\'),
	        $(\'#circle_\'+k).parent(".wrap").css(\'background-color\', \'#5eb95e\');
	        $(\'#circle_\'+k).parent(".wrap").attr("is_use",1);
		}else{
			$(\'#circle_\'+k).css(\'left\', \'0px\'),
	        $(\'#circle_\'+k).css(\'background-color\', \'#fff\'),
	        $(\'#circle_\'+k).parent(".wrap").css(\'background-color\', \'#ccc\');
	        $(\'#circle_\'+k).parent(".wrap").attr("is_use",0);
		}

		$.ajax({
			type:"POST",
			dataType:"json",
			url:\'index.php?module=third&action=Template\',
			data:{
			    id:id,
			    is_use:status_1
			},
			success:function(data){
				if(data.suc == 1){
					layer.msg(data.msg,{time:2000});
				}else{
					layer.msg(data.msg,{time:2000});
					location.href=\'index.php?module=third&action=Template\';
				}
			}
		});
	}

    function confirm (content,id,url,content1){
		$("body",parent.document).append(`
			<div class="maskNew">
				<div class="maskNewContent">
					<a href="javascript:void(0);" class="closeA" onclick=closeMask1() ><img src="images/icon1/gb.png"/></a>
					<div class="maskTitle">删除</div>
					<div style="text-align:center;margin-top:30px"><img src="images/icon1/ts.png"></div>
					<div style="height: 50px;position: relative;top:20px;font-size: 22px;text-align: center;">
						${content}
					</div>
					<div style="text-align:center;margin-top:30px">
						<button class="closeMask" style="margin-right:20px" onclick=closeMask(\'${id}\',\'${url}\',\'${content1}\')>确认</button>
						<button class="closeMask" onclick=closeMask1() >取消</button>
					</div>
				</div>
			</div>
		`)
	}
</script>
'; ?>

</body>
</html>