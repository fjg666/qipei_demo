<?php
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');
//微信模板推送
class WxPush {

    /**
     * 发送模板消息
     */
    public function send_notice($uid,$openid,$title){
        $db = DBAction::getInstance();
        $redis = new RedisClusters();
        $redis->connect();

        $appid = 'wx87a91f823315ec25';
        $appsecret = '9612ee8e6f88d8878ba2de91ee49d355';

        //获取access_token
        if ($redis->get($uid.'access_token')){
            $access_token2 = $redis->get($uid.'access_token');
        }else{
            $json_token=$this>curl_post("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret.'");
            $access_token1=json_decode($json_token,true);
            $access_token2=$access_token1['access_token'];
            $redis->set($uid.'access_token',$access_token2,7200);
            //setcookie($uid.'access_token',$access_token2,7200);
        }

        $redis->close();//关闭句柄
        //模板消息
        $json_template = $this->json_tempalte($openid,$title);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token2;
        $res=$this->curl_post($url,urldecode($json_template));
        if ($res['errcode']==0){
            return '发送成功';
        }else{
            return '发送失败';
        }
    }

    /**
     * 将模板消息json格式化
     */
    public function json_tempalte($openid,$title){
        //模板消息
        $template=array(
            'touser' => ".$openid.",  //用户openid
            'template_id' => "MQM2mVS1VGegUhuZsoGqo3uc67OipjIM0lfFggFoMzs", //在公众号下配置的模板id
            'url' => "http://duoshanghu.bajiaokeji.com/V3/H5/", //点击模板消息会跳转的链接
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode("订单提醒"),'color'=>"#FF0000"),
                'keyword1'=>array('value'=>urlencode("'.$title.'"),'color'=>'#FF0000'),  //订单详情
                'keyword2'=>array('value'=>urlencode(date("Y-m-d H:i:s")),'color'=>'#FF0000'),
                'remark' =>array('value'=>urlencode('备注：点击查看订单！'),'color'=>'#FF0000'), )
        );
        $json_template=json_encode($template);
        return $json_template;
    }


    /**
     * @param $url
     * @param array $data
     * @return mixed
     * curl请求
     */
    function curl_post($url , $data=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
?>