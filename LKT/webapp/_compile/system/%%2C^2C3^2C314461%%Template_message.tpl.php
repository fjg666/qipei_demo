<?php /* Smarty version 2.6.31, created on 2019-12-20 17:00:54
         compiled from Template_message.tpl */ ?>
<!DOCTYPE html>
<html>
<head>

<link href="style/css/H-ui.admin.css" rel="stylesheet" type="text/css" />

<link href="style/css/style.css" rel="stylesheet" type="text/css" />

<title>模板消息设置</title>
<link rel="stylesheet" href="style/tgt/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="style/css/style.css" />
<?php echo '
<style>
	.col-md-4{
		width: 20%;
	}
	.col-sm-4{
		width: 20%;
	}
    a{
        color: #333;
    }
    a:hover{
        text-decoration: none;
    }
    .breadcrumb span{padding: 0 5px;}
</style>
'; ?>

</head>
<body style="opacity: 1;">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../../include_path/nav.tpl", 'smarty_include_vars' => array('sitename' => "面包屑")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="page-container page_absolute pd-20">

    <form name="form1" action="" class="form form-horizontal" method="post"   enctype="multipart/form-data" style="padding:20px 0;" >
        <div class="border_bg">
              <div class="panel-body" style="padding:0;">
                  <div class="">  
                    <div class="">
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">购买成功通知</label> 
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[pay_success]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->pay_success; ?>
">   
                            <div class="help-block">小程序模板消息编号示例: m1FFBWiae7r4Sx3cMZ7dyt0 </div>    
                                
                        </div>    
                    </div>  
                    <div class="">  
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">订单发货提醒</label> 
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[order_delivery]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->order_delivery; ?>
">    
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>            
                    <div class="">
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">订单支付成功通知</label>   
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[order_success]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->order_success; ?>
">   
                            <div class="help-block">小程序模板消息编号示例: m1FFBWiae7r4Sx3cMZ7dyt0 </div>    
                                
                        </div>            </div>            
                        <div class="">
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">开团成功提醒</label> 
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[group_pay_success]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->group_pay_success; ?>
">    
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>  
                    <div class="">  
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">拼团待成团提醒</label> 
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[group_pending]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->group_pending; ?>
">   
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>            
                    <div class="">
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">拼团成功通知</label> 
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[group_success]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->group_success; ?>
">   
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>  
                    <div class="">  
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">拼团失败通知</label>   
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[group_fail]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->group_fail; ?>
">   
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>  
                    <div class="">  
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">抽奖结果通知</label>   
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[lottery_res]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->lottery_res; ?>
">    
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>  
                    <div class="">    
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">退款成功通知</label>   
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[refund_success]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->refund_success; ?>
">    
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>    
                                
                        </div>    
                    </div>
                    <div class="">  
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">退款通知</label>   
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[refund_res]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->refund_res; ?>
">    
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>   
                                
                        </div>    
                    </div>
                    <div class="">  
                        <label class="col-xs-12 col-sm-4 col-md-4 control-label">领取通知</label>   
                        <div class="col-sm-8 col-xs-12">    
                                
                            <input type="text" name="notice[receive]" class="form-control" value="<?php echo $this->_tpl_vars['notice']->receive; ?>
">    
                            <div class="help-block">小程序模板消息编号示例:  m1FFBWiae7r4Sx3cMZ7dyt0  </div>   
                                
                        </div>    
                    </div>
                     <div style="clear: both;"></div>
                    
                <div class="page_bort" >  
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label" ></label> 
                      <div class="page_out">  
                               
                              <input type="submit" name="submit" value="提交" id="btn1" class="btn col-lg-1 ta_btn1" data-original-title="" title="" style="width: 112px!important;"> 
                              <input type="hidden" name="token" value="41f48483"> 
                              
                       </div> 
                       <div style="clear: both;"></div>
                </div>
              </div>      
            </div>
        </div>

    </form>
    <div class="page_h2"></div>

</div>
</body>
</html>