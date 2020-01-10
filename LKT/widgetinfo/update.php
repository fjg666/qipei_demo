<?php
require_once('../webapp/lib/DBAction.class.php');

$db = DBAction::getInstance();

header("Content-type:text/json");
$name = $_GET["name"];
$version = $_GET["version"]; //客户端版本号

$sql = "select * from lkt_edition where store_id = ".$_GET['store_id'];
$config = $db->select($sql);

$rsp = array("status" => 0); //默认返回值，不需要升级
if (isset($name) && isset($version)) {
    if ($name === $config[0]->appname && $version !== $config[0]->edition && intval($config[0]->type) !=1) {
    	
        $rsp["status"] = 1;
        $rsp["note"] = $config[0]->content; //release notes
        $rsp["android_url"] = $config[0]->android_url; //android应用升级包下载地址
        $rsp["ios_url"] = $config[0]->ios_url; //ios应用升级包下载地址
        $rsp["version"] = $config[0]->edition; //版本号

		$fp = fopen('../widgetinfo/update.txt',"a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：name:".$name."\nversion:".$version."\n\n");
		fwrite($fp,"返回数据".json_encode($rsp)."\n\n");
		flock($fp, LOCK_UN);
		fclose($fp);
    }
} 
echo json_encode($rsp);

?>