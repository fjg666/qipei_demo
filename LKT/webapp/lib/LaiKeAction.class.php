<?php

header('Access-Control-Allow-Origin:*');
class LaiKeAction extends Action {

    public function __construct(){
        LaiKeDBHelper::init();
    }

    public function getDefaultView()
    {
        //token认证
        //限流
        //日志
    }

    public function execute()
    {

    }
}
?>
