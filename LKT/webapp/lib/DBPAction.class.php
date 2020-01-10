<?php
require_once(dirname(dirname(__FILE__)).'/config/db_config.php');
class DBPAction{
	/*
     * Auth: 凌烨棣 Date : 2019-08-29
     * 本类是用来预处理mysql操作，提高写入速度
     * 利用单例模式创建一个业务逻辑的实例 客户可以通过getInstance方法来得到DBPAction的实例
     * 在整个运行周期中，该实例只会被创建一次
     * 作为单例模式的需要，构造子方法被设置为private私有方法，不让客户端调用
     * 作为单例模式的需要，克隆方法设置为private私有方法，不让客户的调用
     * 作为单例模式的需要，提供DBAction类型的私有变量让getInstance方法使用作为返回
     * 作为单例模式的需要，提供getInstance方法来为客户端得到DBAction的实例
     */
	private function  __construct(){

	}
	private function __clone(){

	}

	public  $mConnId; //连接标识

	private static $instance = null;

	public static function getInstance(){
		if(self :: $instance == null){
			self :: $instance = new self();
			self :: $instance -> DBPconnect();
		}

		mysqli_query(self :: $instance -> mConnId,"SET NAMES 'UTF8'");
		mysqli_query(self :: $instance -> mConnId,"SET SESSION time_zone = '+8:00'");

		return self :: $instance;
	}

	public function DBPconnect(){
		$this -> mConnId = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD,MYSQL_DATABASE);
		if(!$this->mConnId){
			print " 连接数据库失败!可能是mysql数据库用户名或密码不正确!<br>";
            return false;
		}
	}

	public function query($sql){
		$result = mysqli_query($this->mConnId,$sql);
        return $result;
	}


    //查询
    public function select($sql) {
        $sql = trim($sql);
        if (empty ($sql)) {return;}
        $rs = $this->query($sql);
        if ((!$rs) || empty ($rs)) {return;}
        $data = array();
        while ($rd = mysqli_fetch_object($rs)) {
            $data[] = $rd;
        }
        mysqli_free_result($rs);
        return $data;
    }

   	/**
     * 预处理
     * @param $sql 预处理语句
     */ 
    public function prepare($sql){
    	$stmt = $this->mConnId->prepare($sql);
    	return $stmt;
    }
}