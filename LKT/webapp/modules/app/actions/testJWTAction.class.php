<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JWT.php');
    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 余辉
     * @content 小程序的Token示例代码
     * @date 2019年2月20日
     * @version 1.0
     */
    
class testJWTAction extends Action {

    public function getDefaultView() {
    	
    	/*
	 * 使用该插件生成Token，首先要引入：require_once(MO_LIB_DIR . '/JWT.php');
	 * iat：生成token时间
	 * exp: 过期时间
	 */
	
	
    	 //生成Token ，两小时后过期
    $payload=array('iat'=>time(),'exp'=>time()+7200);
    print_r($payload);
    $token=Jwt::getToken($payload);
    echo "<pre>";
    echo $token;
    echo "<br><br>";
    
     //对token进行验证签名,如果过期返回false,成功返回数组
    $getPayload_test=Jwt::verifyToken($token);
    var_dump($getPayload_test);
    echo "<br><br>";
    	
    	
    	/*
    	 * 登陆验证思路
    	 * 登陆成功之后:
    	 * 1、使用Jwt::getToken($payload)生成新的token，将其存入access_id字段，update ntb_user set access_id='新token' where mobile=''
    	 * 2、然后将Token通过json返回给前端，前端将Token存入localstorage里面去,例如localstorage.set('access_id',token)
    	 * 3、每一次调用用户数据的时候，都将token传值过去，现在代码传的是access_id，也是一个意思
    	 * 4、重点：每一次传值token过去的时候都要调用一下Jwt::verifyToken($token)方法，判断有没有过期，如果过期，需要提示重新登陆
    	 */
    	
    	
    	/*
    	 * 无登陆情况下如何将商品加入购物车，并且与其他用户购物车的商品做区分
    	 * 1、在没有登陆的情况下，点击某一商品进入购物车，在对应的API里面，需要生成新的Token，将其存入购物车表（table）的session_id字段
    	 * 2、然后将Token通过json返回给前端，前端将Token存入localstorage里面去,例如localstorage.set('session_id',token)
    	 * 3、登陆成功之后，此时APP的localstorage里面应该存了两个值，一个access_id,一个session_id，所以在登陆的时候，需要根据session_id把购物输的userid字段给更新了
    	 * 4、注意，在登陆请求的时候需要传本地的session_id这个参数过去，这样才会根据session_id这个条件来更新登陆成功之后的userid字段了
    	 */

    
        return;
    }

    public function execute(){
        
        return;
    } 

    public function getRequestMethods(){
        return Request :: POST;
    }

    

}
?>