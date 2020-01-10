<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 * @author 周文  
 * @date 2019年1月11日  
 * @version 2.0  
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
header('Access-Control-Allow-Origin:*');

class Apimiddle extends Action {	

    public function __construct(){
       $res = $_GET;
       $db = DBAction::getInstance();
       $access_token = isset($res['token'])?addslashes($res['token']):'';
       $module = isset($res['module'])?addslashes($res['module']):'';
       $action = isset($res['action'])?addslashes($res['action']):'';
        
         if($module == 'api'){ // 当值为api时
             if($action != 'app' && $action != 'test' && $action != 'getcode'){ // 当值不为app时,做过滤处理
                 if($access_token == ''){
                    exit('非法请求!');
                 }
                 $sql = "select * from lkt_user where access_token='$access_token'";
                 $check = $db -> select($sql);
                 if(empty($check)){
                    exit('非法请求!');
                 }
             }
         }
        
    }

    public function getDefaultView()
    {
        
    }

    public function execute()
    {
        
    }


}

?>
