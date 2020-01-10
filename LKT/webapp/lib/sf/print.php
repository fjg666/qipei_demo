<?php
/**
 * 顺丰Bsf接口类
 * Created by PhpStorm.
 * Author: duyaqiong
 * Email:976352324@qq.com
 * Date: 2018/6/8
 */
 
class Express
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

    public function go_print($post){


        $url = "http://localhost:4040/sf/waybill/print?type=V2.0.FM_poster_100mm150mm&output=image";
        //1.根据业务需求确定请求地址,并确定是否替换版本
        $reqURL = $this->handle_url($url,false);//true 不需要  false 需要

        //2.组装参数  丰密参数 true设置 false 不设置
        $post_json_data = $this->assembly_param($post,true);

        //3.发送请求
        $result = $this->send_post($reqURL, $post_json_data);

        //如果url是打印图片 则保存图片到本地
        if(strpos($reqURL, "image")){
            //4.处理结果数据
            $imageData = $this->handle_data($result);
            //5图片保存到本地
            $res = $this->save_image($imageData);
            return $res;
        }
        return false;
    }

    /**
     *保存图片到本地
     * @param unknown $imageData
     */
    function save_image($imageData){
        $showtime=date("YmdHis",time()+8*3600);
        //判断是否包含多张图片
        if(strpos($imageData, "\",\"")){
            $var=explode("\",\"",$str);
            $i=0;
            foreach ($var as $value){
                $i++;
                $imgName = "./express/sf_".$showtime."-".$i.".jpg";
                return $this->generate_image($imageData, $imgName);
            }
        }else{
            $imgName = "./express/sf_".$showtime.".jpg";
            return $this->generate_image($imageData, $imgName);
        }
    }

    /**
     * 处理url
     * @param unknown $reqURL 
     * @param unknown $notTopLogo true 不需要  false 需要
     * @return mixed
     */
    function handle_url($reqURL,$notTopLogo){
        
        if ( $notTopLogo && strpos($reqURL, "V2.0"))
        {
            $reqURL = str_replace("V2.0", "V2.1",$reqURL);;
        }
        
        if ($notTopLogo && strpos($reqURL,"V3.0"))
        {
            $reqURL = str_replace("V3.0", "V3.1",$reqURL);
        }
        
        return $reqURL;
    }

    /**
     * 发送post请求
     *
     * @param string $url
     *            请求地址
     * @param array $post_data
     *            post键值对数据
     * @return string
     */
    function send_post($reqURL, $post_data)
    {
        
        // echo "url:" .$reqURL;
        // echo "\n";
        // echo "参数:" .$post_data;
        //curl验证成功
        $ch = curl_init($reqURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post_data)
        ));
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
       
        if(strpos($reqURL, "image")=== false){
            // echo "\n";
            // echo "返回:".$result;
        }
        return $result;
    }

    /**
     * 处理数据
     * @param unknown $result
     */
    function handle_data($result){
        
        $startIndex = strpos($result,"[")+1;
        $substrLen = strrpos($result,"]") - $startIndex;
        $imageData = substr($result,$startIndex,$substrLen);
        
        /**
         * 如果以 \ 开头 ,截取
         */
        if(strpos($imageData,"\\")===0){
            $imageData = substr($imageData,1);
        }
        
        /**
         * 如果以 \ 结尾 ,截取
         */
        if(substr_compare($imageData, "\\", -strlen("\\")) === 0){
            $imageData = substr($imageData,0,(strlen($imageData)-1));
        }
        
        //换行符替换为空
        str_replace("\\n", "",$imageData);
        return $imageData;
    }

    /**
     * 
     * @param unknown $imgStr 图片文件内容
     * @param unknown $imgName 图片地址+名称
     * @return boolean
     */
    function generate_image($imgStr, $imgName){
        if ($imgStr == null){
            return false;
        }
        
        $r = file_put_contents($imgName, base64_decode($imgStr));
        
        // echo "\n";
        if (!$r) {
            // echo $imgName." 图片生成失败\n";
            return false;
        }else{
            // echo $imgName." 图片生成成功\n";
            return $imgName;
        }
    }

    /**
     * 组装参数
     * @param unknown $fengmi
     * @return string
     */
    function assembly_param($post,$fengmi){
        
        
        $waybillDto = new WaybillDto();
        $waybillDto->appId = $post['accesscode']; //对应丰桥平台获取的clientCode
        $waybillDto->appKey = $post['checkword']; //对应丰桥平台获取的checkWord
        $waybillDto->monthAccount = $post['custid']; //月结卡号
        $waybillDto->mailNo = $post['expresssn'];// 单号
        
        //收件人信息
        $waybillDto->consignerProvince = $post['r_sheng'];
        $waybillDto->consignerCity = $post['r_shi'];
        $waybillDto->consignerCounty = $post['r_xian'];
        $waybillDto->consignerAddress = $post['r_address']; //详细地址建议最多30个字  字段过长影响打印效果
        // $waybillDto->consignerCompany = "来客电商";
        $waybillDto->consignerMobile = $post['r_mobile'];
        $waybillDto->consignerName = $post['recipient'];
        $waybillDto->consignerShipperCode = "";// 寄件人邮政编码（国际件必传）
        $waybillDto->consignerTel = "";
        
        
        //寄件人信息
        $waybillDto->deliverProvince = $post['s_sheng'];
        $waybillDto->deliverCity = $post['s_shi'];
        $waybillDto->deliverCounty = $post['s_xian'];
        $waybillDto->deliverAddress = $post['s_address']; //详细地址建议最多30个字  字段过长影响打印效果
        // $waybillDto->deliverCompany = "来客推";
        $waybillDto->deliverName = $post['sender'];
        $waybillDto->deliverMobile = $post['s_mobile'];
        $waybillDto->deliverShipperCode = "";
        $waybillDto->deliverTel = "";
        
        
        $waybillDto->destCode = $post['destcode']; //目的地代码 参考顺丰地区编号
        $waybillDto->zipCode = $post['origincode']; //原寄地代码 参考顺丰地区编号
        

        //1 ：标准快递   2.顺丰特惠   3： 电商特惠   5：顺丰次晨  6：顺丰即日  7.电商速配   15：生鲜速配
        $waybillDto->expressType = 1;
        $waybillDto->payMethod = 1; // 1寄方付 2收方付 3第三方月结支付
        $waybillDto->mainRemark = $post['remark'];//主运单备注

        //加密项
        $waybillDto->encryptCustName = false;//加密寄件人及收件人名称
        $waybillDto->encryptMobile = false;//加密寄件人及收件人联系手机

        $cargoInfoList = array();
        foreach ($post['goods'] as $k => $v) {
            $cargo[$k] = new CargoInfoDto();
            $cargo[$k]->cargo = $v->product_title;
            $cargo[$k]->cargoCount = $v->num;
            $cargo[$k]->remark = $v->size;
            $cargo[$k]->cargoUnit = $v->unit;
            $cargoInfoList[] = $cargo[$k];
        }

        $waybillDto->cargoInfoDtoList = $cargoInfoList;


        if ($fengmi)
        {
            $rlsMain = new RlsInfoDto();
            $rlsMain->abFlag = "A";
            $rlsMain->codingMapping = "F33";
            $rlsMain->codingMappingOut = "1A";
            $rlsMain->destRouteLabel = "755WE-571A3";
            $rlsMain->destTeamCode = "012345678";
            $rlsMain->printIcon = "";
            $rlsMain->proCode = "T4";
            $rlsMain->qrcode = "MMM={'k1':'755WE','k2':'021WT','k3':'','k4':'T4','k5':'".$post['expresssn']."','k6':''}";
            $rlsMain->sourceTransferCode = "021WTF";
            $rlsMain->waybillNo = "SF7551234567890";
            $rlsMain->xbFlag = "XB";
            
            $rlsInfoDtoList=array($rlsMain);
            
            // if (null != ($waybillDto->returnTrackingNo))
            // {
            //     $rlsBack = new RlsInfoDto();
            //     $rlsBack->waybillNo = $waybillDto->returnTrackingNo;
            //     $rlsBack->destRouteLabel = "021WTF";
            //     $rlsBack->printIcon = "11110000";
            //     $rlsBack->proCode = "T4";
            //     $rlsBack->abFlag = "A";
            //     $rlsBack->xbFlag = "XB";
            //     $rlsBack->codingMapping = "1A";
            //     $rlsBack->codingMappingOut = "F33";
            //     $rlsBack->destTeamCode = "87654321";
            //     $rlsBack->sourceTransferCode = "755WE-571A3";
            //     //对应下订单设置路由标签返回字段twoDimensionCode 该参
            //     $rlsBack->qrcode = "MMM={'k1':'21WT','k2':'755WE','k3':'','k4':'T4','k5':'SF1060081717189','k6':''}";
                
            //     array_push($rlsInfoDtoList,$rlsBack);
            // }
            
            $waybillDto->rlsInfoDtoList = $rlsInfoDtoList;
            
        }
          
        $waybillDtoList = array($waybillDto);
        $post_json_data = json_encode($waybillDtoList,JSON_UNESCAPED_UNICODE);
        return  $post_json_data;
    }

}



class WaybillDto
{    
    public $mailNo;
    public $expressType;
    public $payMethod;
    public $returnTrackingNo;
    public $monthAccount;
    public $orderNo;
    public $zipCode;
    public $destCode;
    public $payArea;
    public $deliverCompany;
    public $deliverName;
    public $deliverMobile;
    public $deliverTel;
    public $deliverProvince;
    public $deliverCity;
    public $deliverCounty;
    public $deliverAddress;
    public $deliverShipperCode;
    public $consignerCompany;
    public $consignerName;
    public $consignerMobile;
    public $consignerTel;
    public $consignerProvince;
    public $consignerCity;
    public $consignerCounty;
    public $consignerAddress;
    public $consignerShipperCode;
    public $logo;
    public $sftelLogo;
    public $topLogo;
    public $topsftelLogo;
    public $appId;
    public $appKey;
    public $electric;
    public $cargoInfoDtoList;
    public $rlsInfoDtoList;
    public $insureValue;
    public $codValue;
    public $codMonthAccount;
    
    
    public $mainRemark;
    public $returnTrackingRemark;
    public $childRemark;
    public $custLogo;
    public $insureFee;
    
    public $encryptCustName; //加密寄件人及收件人名称
    public $encryptMobile; //加密寄件人及收件人联系手机
}
class CargoInfoDto
{    
    var $cargo;    
    var $parcelQuantity;    
    var $cargoCount;    
    var $cargoUnit;    
    var $cargoWeight;    
    var $cargoAmount;    
    var $cargoTotalWeight;
    var $remark;    
    var $sku;
}
class RlsInfoDto
{
    public $abFlag;
    public $codingMapping;
    public $codingMappingOut;
    public $destRouteLabel;
    public $destTeamCode;
    public $printIcon;
    public $proCode;
    public $qrcode;
    public $sourceTransferCode;
    public $waybillNo;
    public $xbFlag;
}