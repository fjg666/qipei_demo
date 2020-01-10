<?php
/**
 * 顺丰Bsf接口类
 * Created by PhpStorm.
 * Author: duyaqiong
 * Email:976352324@qq.com
 * Date: 2018/6/8
 */
 
class SF
{
    //顺丰接口配置
    protected $config = [
        'accesscode' => 'xxxx' ,                              //商户号码
        'checkword'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxx',        //商户密匙
        'ssl'        => false,                                      //是否ssl
        'server'     => "http://bsp-oisp.sf-express.com/",          //http
        'uri'        => 'bsp-oisp/sfexpressService',                //接口地址
    ];
    //返回信息
    protected $ret = array(
        'head' => "ERR",
        'message' => '系统错误',
        'code' => -1
    );
 
 
    public function __construct($params = null)
    {
        if (null != $params) {
            $this->config = array_merge($this->config, $params);
        }
    }
 
    /**
     * 顺丰BSP接口主程序 已经已经集成验证
     * @param $xml
     * @return bool|mixed
     */
    public function postXmlBodyWithVerify($xml,$server){
        $xml       = $this->buildXml($xml,$server);
        $verifyCode= $this->sign($xml, $this->config['checkword']);
        $post_data = "xml=$xml&verifyCode=$verifyCode";
        $response  = $this->postXmlCurl($post_data,$this->getPostUrl());
        return $response;
    }
 
 
 
 
 
 
    /**
     * 顺丰BSP下订单接口（含筛选）
     * 下订单接口根据客户需要，可提供以下三个功能：
     * 1) 客户系统向顺丰下发订单。
     * 2) 为订单分配运单号。
     * 3) 筛单（可选，具体商务沟通中双方约定，由顺丰内部为客户配置）。
     * 此接口也用于路由推送注册。客户的顺丰运单号不是通过此下订单接口获取，但却需要获取BSP的路由推送时，
     * 需要通过此接口对相应的顺丰运单进行注册以使用BSP的路由推送 接口。
     *
     * @param string $post['j_company'] //寄件方公司名称
     * @param string $post['j_contact'] //寄件方联系人
     * @param string $post['j_tel']     //寄件方联系电话
     * @param string $post['j_address'] //寄件地址
     * @param string $post['j_province']//寄件方省份   (选填)
     * @param string $post['j_city']    //寄件方城市   (选填)
     * @param string $post['j_county']  //寄件方县区   (选填)
     * @param string $post['orderid']   //客户订单号
     * @param string $post['d_company'] //到件方公司名称(选填)
     * @param string $post['d_contact'] //收件方联系人
     * @param string $post['d_tel']     //收件方联系电话
     * @param string $post['d_address'] //收件方详细地址，如果不传输 d_province/d_city 字段，此详细地址 需包含省市信息，以提高地址识别的 成功率，示例：“广东省深圳市福田 区新洲十一街万基商务大厦 10楼”。
     * @param string $post['d_province']//收件方省份
     * @param string $post['d_city']    //收件方城市
     * @param string $post['d_county']  //收件方县区
     * @param string $post['pay_method']//付款方式：1:寄方付2:收方付3:第三方付
     * @param string $post['express_type']//快件产品类别
     * @param string $post['is_docall'] //是否要求通过是否手持终端通知顺丰收派员收件：1：要求 其它为不要求
     * @param string $post['d_county']  //收件方县区
     * @param array $params             //可选参数的数组
     * @param array $cargoes            //货物名称数组【name:商品名称count:商品数量】
     * @param array $cargoes['name']    //商品
     * @param array $cargoes['count']   //数量
     * @param array $addedServices      //增值服务
     * @param string $post['express_type']//*1顺丰标快；2顺丰特惠；3电商特惠；5顺丰次晨；6顺丰即日；7电商速配；
     * @param string $post['pay_method']  //*付款方式  1寄方付； 2收方付；3第三方付
     * @return string
     */
    public function Order($params = array(), $cargoes = array(), $addedServices = array())
    {

        $order_params = $this->paramsToString($params);
        $cargoes_str  = count($cargoes) > 0 ? $this->paramsToString($cargoes, 'Cargo') : '';
        $addedServices_str = count($addedServices) > 0 ? $this->paramsToString($addedServices, 'AddedService') : '';
        $xml_string   = "<Order$order_params>$cargoes_str$addedServices_str</Order>";
        $data         = $this->postXmlBodyWithVerify($xml_string,'OrderService');
        return  $this->OrderResponse($data,'OrderResponse');
    }
 
    /**
     * 顺丰BSP查单接口
     * Created by PhpStorm.
     */
    public function OrderSearch($orderid) {
        $OrderSearch = '<OrderSearch orderid="'.$orderid.'" />';
        $data = $this->postXmlBodyWithVerify($OrderSearch,'OrderSearchService');
        return $this->OrderResponse($data,'OrderResponse');
    }
 
 
 
 
    /**
     * 顺丰BSP查单接口,根据运单号或者订单号【1.运单号,2.订单号】
     * Created by PhpStorm.
     */
    public function OrderSearchByMailnoOrOrderid($orderid,$type=1) {
        $RouteService = "<RouteRequest tracking_type='".$type."' method_type='1' tracking_number='".$orderid."'/>";
        $data = $this->postXmlBodyWithVerify($RouteService,'RouteService');
        return $this->OrderResponse($data,'RouteResponse');
    }
 
 
 
    /**
     * 确认订单
     * @param $orderid
     * @param $mailno
     * @param array $options
     * @return array|bool
     */
    public function OrderConfirm($orderid, $mailno, $options = array())
    {
        return $this->OrderConfirmRequest($orderid, $mailno, 1, $options);
    }
 
 
 
    /**
     * 取消订单
     * @param $orderid
     * @param string $mailno
     * @param array $options
     * @return array|bool
     */
    public function OrderCancel($orderid, $mailno = '', $options = array())
    {
        return $this->OrderConfirmRequest($orderid, $mailno, 2, $options);
    }
 
 
 
    /**
     * 订单确认与取消发送
     * @param $orderid 客户订单号
     * @param $mailno  运单号
     * @param $dealtype  类型【1：确认；2：取消】
     * @param array $options 其他参数
     * @return array
     */
    public function OrderConfirmRequest($orderid, $mailno, $dealtype, $options = array())
    {
        $params = array();
        $params['dealtype'] = $dealtype;
        $params['orderid']  = $orderid;
        $params['mailno ']  = $mailno;
 
        $order_params = $this->paramsToString($params);
        $addedServices_str = count($options) > 0 ? $this->paramsToString($options, 'OrderConfirmOption') : '';
        $xml_string   = "<OrderConfirm$order_params>$addedServices_str</OrderConfirm>";
        $data         = $this->postXmlBodyWithVerify($xml_string,'OrderConfirmService');
        return $this->OrderResponse($data,'OrderConfirmResponse');
    }
 
 
 
    /**
     * 返回结果
     * @param $data
     * @return array
     */
    private function  OrderResponse($data,$type = '') {
        return $this->getResponse($data,$type);
    }
 
 
 
    /**
     * 获取POSTURL地址
     * @return string
     */
    protected function getPostUrl(){
        if($this->config['ssl']){
            return   $this->config['server_ssl'].$this->config['uri'];
        } else {
            return   $this->config['server'].$this->config['uri'];
        }
    }
 
 
    /**
     * get request service name
     * 获取请求服务器名称
     * @param null $class
     * @return string
     */
    public function getServiceName($class=null) {
        if (empty($class)) {
            return basename(str_replace('\\', '/', get_called_class()),'.php');
        }
        return basename(str_replace('\\', '/', $class),'.php');;
    }
 
    /**
     * 拼接XML字符串
     * @param $bodyData
     * @return string
     */
    public function buildXml($bodyData,$server){
        $xml = '<Request service="'.$server.'" lang="zh-CN">' .
            '<Head>'.$this->config['accesscode'].'</Head>' .
            '<Body>' . $bodyData . '</Body>' .
            '</Request>';
        return $xml;
    }
 
 
    /**
     * 计算验证码
     * data 是拼接完整的报文XML
     * check_word 是顺丰给的接入码
     * @param string $data
     * @param string $check_word
     * @return string
     */
    public static function sign($data, $check_word) {
        $string = trim($data).trim($check_word);
        $md5    = md5(mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string)), true);
        $sign   = base64_encode($md5);
        return $sign;
    }
 
 
    /**
     * XML to 数组.
     * @param string $xml XML string
     * @return array|\SimpleXMLElement
     */
    public static function parse($xml)
    {
        $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
        if (is_object($data) && get_class($data) === 'SimpleXMLElement') {
            $data = self::arrarval($data);
        }
        return $data;
    }
 
 
    /**
     * XML to 对象
     * @param $xml
     * @return \SimpleXMLElement
     */
    public static function parseRaw($xml)
    {
        $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
        return $data;
    }
 
 
    /**
     * 对象 to 数组.
     * @param string $data
     * @return array
     */
    private static function arrarval($data)
    {
        if (is_object($data) && get_class($data) === 'SimpleXMLElement') {
            $data = (array) $data;
        }
        if (is_array($data)) {
            foreach ($data as $index => $value) {
                $data[$index] = self::arrarval($value);
            }
        }
        return $data;
    }
 
 
    /**
     * 转换顺丰返回XML
     * @param $data
     * @param $name
     * @return array
     */
    public function getResponse($data, $name) {
        $ret = array();
        $xml = @simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
        if ($xml){
            $ret['head'] = (string)$xml->Head;
            if ($xml->Head == 'OK'){
                $ret = array_merge($ret , $this->getData($xml, $name));
            }
            if ($xml->Head == 'ERR'){
                $ret = array_merge($ret , $this->getErrorMessage($xml));
            }
        }
        return $ret;
    }
 
 
    /**
     * 获取错误信息
     * @param $xml
     * @return array
     */
    public function getErrorMessage($xml) {
        $ret = array();
        $ret['message'] = (string)$xml->ERROR;
        if (isset($xml->ERROR[0])) {
            foreach ($xml->ERROR[0]->attributes() as $key => $val) {
                $ret[$key] = (string)$val;
            }
        }
        return $ret;
    }
 
    /**
     * 获取xml字段
     * @param $xml
     * @param $name
     * @return array
     */
    public function getData($xml, $name) {
        $ret = array();
        if (isset($xml->Body->$name)){
            foreach ($xml->Body->$name as $v) {
                foreach ($v->attributes() as $key => $val) {
                    $ret[$key] = (string)$val;
                }
            }
        }
        return $ret;
    }
 
 
    /**
     * 转换属性为XML字符串
     * @param array $params
     * @param string $xml_Name
     * @return string
     */
    protected function paramsToString($params = [], $xml_Name = '')
    {
        $string = '';
        $return_string = '';
        if ($xml_Name && is_array($params)) {
            foreach ($params as $key => $value) {
                if ( is_array($value)){
                    $string = $this->paramsToString($value);
                }else{
                    $string .= " $key=\"$value\"";
                }
                $return_string .= "<$xml_Name$string></$xml_Name>";
            }
        } elseif (!$xml_Name && is_array($params)) {
            foreach ($params as $k => $v) {
                $string .= " $k=\"$v\"";
            }
            $return_string = $string;
        }
 
        return $return_string;
    }
 
 
    /**
     * 作用：以post方式提交xml到对应的接口url
     * @param $data
     * @param $url
     * @param int $second
     * @return bool|mixed
     */
    public function postXmlCurl($data,$url,$second=60)
    {
        try{
            header("Content-type: text/html; charset=utf-8");
            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
            curl_setopt($ch, CURLOPT_TIMEOUT, $second);//超时设置
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $data = curl_exec($ch);//运行curl
            curl_close($ch);
            return $data;
        }catch (\Exception $e) {
            return false;
        }
    }
 
 
}