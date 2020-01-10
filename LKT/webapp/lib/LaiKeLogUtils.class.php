<?php

/**
 * LKT 日志输出帮助类
 * 方法一： LaiKeLogUtils::lktLog("日志内容");
 * 方法二：
 *         $lktlog = new LaiKeLogUtils("app/order.log");
 *         $lktlog->customerLog("日志内容");
 */
class LaiKeLogUtils{

    /**
     * 日志记录内容
     */
    const LOGROOTPATH = './webapp/log/';

    /**
     * 通用日志输出
     */
    const COMMONLOGPATH = "./webapp/log/common/lkt.log";


    /**
     * 构造函数
     * @param $logpath   指定./webapp/log/目录下的日志输出，调用 customerLog
     */
    function __construct($logpath){
        $this->fullpath = LaiKeLogUtils::LOGROOTPATH.$logpath;
    }

    /**
     * 通用日志记录
     */
    public static function lktLog($msg){
        try{
            self::baseLog(LaiKeLogUtils::COMMONLOGPATH,$msg);
        } catch (Exception $e) {
            echo "通用日志输出错误:".$e;
        }
    }

    /**
     * 自定义日志输出
     */
    public function customerLog($msg){
        try{
            LaiKeLogUtils::baseLog($this->fullpath,$msg);
        } catch (Exception $e) {
            echo "自定义日志输出错误:".$e;
        }
    }

    /**
     * 日志记录
     */
    public static function baseLog($path,$msg){
        try{
            if (!file_exists(dirname($path))){
                mkdir ($path,0777,true);
            }
            $fp = fopen($path,'a+');
            flock($fp,LOCK_EX);
            fwrite($fp,"日期：".date("Y-m-d H:i:s")."\r\n".$msg."\r\n");
            flock($fp,LOCK_UN);
            fclose($fp);
        }catch (Exception $e){
            echo "日志输出错误:".$e;
        }
    }

}

?>