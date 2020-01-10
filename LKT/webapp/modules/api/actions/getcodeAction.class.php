<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once('Apimiddle.class.php');
/**
 * [getcodeAction description]
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  苏涛
 * @version 2.0
 * @date    2018-12-12T17:48:13+0800
 * @param   二维码处理 [description]
 */
class getcodeAction extends Apimiddle
{

    public $appid; // 小程序唯一标识
    public $appsecret; // 小程序的 app secret

    public function getDefaultView(){
        $this->execute();
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        if ($m == 'product_share') {
            $this->product_share();
        }
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    /** 制作商品分享带参数二维码
     * 　@param $product_img string 产品图片　
     * @param $qr_code string 二维码图片
     * @param $logo float logo图片   　
     * @param $price string 价格
     * @param $yprice string 原价
     * @param $bottom_img float 底图
     * @param $product_title string 产品标题
     * @param $path string 分享的路径
     * @param $type string 海报的类型-1商城海报 2小店海报 3商品海报 4关注海报
     * return json
     */

    public function product_share()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $this->store_id = $store_id;
        $this->db = $db;
        $uid = '';
        $access_id = addslashes(trim($request->getParameter('access_id'))); // 授权id
        $openid = addslashes(trim($request->getParameter('openid'))); // openid
        $store_type = addslashes(trim($request->getParameter('store_type')));

        if($store_type == 1){
            $uid = $openid;
            $ss = 'wx_id';
        }else{
            $uid = $access_id;
            $ss = 'access_id';
        }

        // 查询会员信息
        $sql = "select user_name,headimgurl,user_id from lkt_user where $ss = '$uid' and store_id = '$store_id'";
        $r = $db -> select($sql);
        
        if($r){
           $nickname =  $r[0]->user_name;
           $head = $r[0]->headimgurl;
           $user_id = $r[0]->user_id;
        }else{
            echo json_encode(array('code' => 108, 'message' => '暂无数据1'));
            exit;
        }

        $type = $request->getParameter('type');
        
        // 商品ID
        $pid =  addslashes(trim($request->getParameter('pid')));

        if($pid){
            // 根据产品id,查询产品数据
            $sql = "select a.*,c.price,c.yprice,c.attribute,c.img from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$pid' and a.status = 0 and a.recycle = 0";
            $res = $db->select($sql);
            if($res){
                $product_img = ServerPath::getimgpath($res['0']->img);
                $price = $res['0']->price;
                $yprice = $res['0']->yprice;
                $product_title = $res['0']->product_title;
                if (strlen($product_title) > 18) {
                    $product_title = mb_substr($product_title, 0, 18, 'utf-8') . '...';
                }
            }else{
                echo json_encode(array('code' => 108, 'message' => '暂无数据2'));
                exit;
            }
        }
        
        //重新生成
        $regenerate = trim($request->getParameter('regenerate'));
        //参数
        $scene = $request->getParameter('scene');
        //默认底图和logo
        $logo = './images/ditu/logo.png';
        //路径
        $path = $request->getParameter('path');

        //定义固定分享图片储存路径 以便删除
        $imgDir = 'product_share_img/';
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $this->appid = $appid;
            $appsecret = $r[0]->appsecret; // 小程序的 app secret
            $this->appsecret = $appsecret;
            $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
            // $uploadImg = $r[0]->uploadImg.'image_'.$store_id.'/'; // 图片上传位置
            $uploadImg = $r[0]->uploadImg; // 图片上传位置
            if(!is_dir($uploadImg)){
                mkdir($uploadImg);
            }
            if (strpos($uploadImg, './') === false) { // 判断字符串是否存在 ../
                $img = $uploadImg_domain . $uploadImg; // 图片路径
            } else {
                $img = $uploadImg_domain . substr($uploadImg, 1); // 图片路径
            }
            $font_file_path = dirname(MO_WEBAPP_DIR);
            $font_file = $font_file_path . substr($uploadImg, 1);
        }


        $tkt_sql = "select * from lkt_extension where type ='$type' and isdefault='1' ";
        $tkt_r = $db->select($tkt_sql);

        if (empty($tkt_r)) {
            $tkt_sql = "select * from lkt_extension where type ='$type'";
            $tkt_r = $db->select($tkt_sql);
            if (empty($tkt_r)) {
                $url = $img . $imgDir . 'img.jpg';
                echo json_encode(array('status' => true, 'url' => $url));
                exit;
            }
        }

        $img_token = $tkt_r[0]->add_date;
        $pic_md5 = $img_token . $type . $pid . $path . $scene;
        $pic = md5($pic_md5) . '.jpg';

        if (is_file($uploadImg . $imgDir . $pic)) {
            $url = $img . $imgDir . $pic;
            $waittext = isset($tkt_r[0]->waittext) ? $tkt_r[0]->waittext : '#fff';
            echo json_encode(array('status' => true, 'url' => $url, 'waittext' => $waittext));
            exit;
        }

        $waittext = isset($tkt_r[0]->waittext) ? $tkt_r[0]->waittext : '#fff';

        if ($type == '1') {
            //文章
            if (!empty($r)) {
                $bottom_img = $uploadImg . $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        } else if ($type == '2') {
            //红包
            if (!empty($r)) {
                $bottom_img = $uploadImg . $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        } else if ($type == '3') {
            //商品
            if (!empty($r)) {
                $bottom_img = $uploadImg . $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        } else if ($type == '4') {
           //分销
            if (!empty($r)) {
                $bottom_img = $uploadImg . $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        }else if ($type == '5') {
           //邀请有奖
            if (!empty($r)) {
                $bottom_img = $uploadImg . $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        } else {
            //分销
            if (!empty($r)) {
                $bottom_img = $uploadImg . $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        }


        //创建底图   
        $dest = $this->create_imagecreatefromjpeg($bottom_img);

        $datas = json_decode($data);
        foreach ($datas as $key => $value) {
            $data = [];

            foreach ($value as $k => $v) {
                if ($k == 'left' || $k == 'top' || $k == 'width' || $k == 'height' || $k == 'size') {
                    $v = intval(str_replace('px', '', $v)) * 2;
                }
                $data[$k] = $v;
            }
            if ($value->type == 'head') {
                $this->write_img($dest, $data, $head);
            } else if ($value->type == 'nickname') {
                $dest = $this->write_text($dest, $data, $product_title, $font_file);
            } else if ($value->type == 'qr') {
                if($store_type == 1){
                    $AccessToken = $this->getAccessToken($appid, $appsecret);
                    $share_qrcode = $this->get_share_qrcode($path, $value->width, $user_id, $AccessToken);
                }else{
                    $share_qrcode = $this->get_user_url('get_qrcode');
                }
                
                $dest = $this->write_img($dest, $data, $share_qrcode);

            } else if ($value->type == 'img') {
                    if ($value->src) {
                        $imgs = $uploadImg . $value->src;
                        $dest = $this->write_img($dest, $data, $imgs);
                    }
            } else if ($value->type == 'title') {
                //标题
                $dest = $this->write_text($dest, $data, $product_title, $font_file);
            } else if ($value->type == 'thumb') {
                //商品图合成
                $dest = $this->write_img($dest, $data, $product_img);
            } else if ($value->type == 'marketprice') {
                //价格
                $product_title = '￥' . $price;
                $dest = $this->write_text($dest, $data, $product_title, $font_file);
            } else if ($value->type == 'productprice') {
                //原价
                $product_title = '￥' . $yprice;
                $dest = $this->write_text($dest, $data, $product_title, $font_file);
                $shanchuxian = '—';
                for ($i = 0; $i < (strlen($product_title) - 3) / 4; $i++) {
                    $shanchuxian .= $shanchuxian;
                }
                $dest = $this->write_text($dest, $data, $shanchuxian, $font_file);

            }
        }

        imagejpeg($dest, $uploadImg . $imgDir . $pic);
        $url = $img . $imgDir . $pic;
        echo json_encode(array('status' => true, 'url' => $url, 'waittext' => $waittext));
        exit;
    }

    //创建图片 根据类型
    public function create_imagecreatefromjpeg($pic_path)
    {

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $pathInfo = pathinfo($pic_path);
        if(is_file($pic_path)){
            if (array_key_exists('extension', $pathInfo)) {
                switch (strtolower($pathInfo['extension'])) {
                    case 'jpg':
                    case 'jpeg':
                        $imagecreatefromjpeg = 'imagecreatefromjpeg';
                        break;
                    case 'png':
                        $imagecreatefromjpeg = 'imagecreatefrompng';
                        break;
                    case 'gif':
                    default:
                        $imagecreatefromjpeg = 'imagecreatefromstring';
                        $pic_path = file_get_contents($pic_path, false, stream_context_create($arrContextOptions));
                        break;
                }
            } else {
                $imagecreatefromjpeg = 'imagecreatefromstring';
                $pic_path = file_get_contents($pic_path, false, stream_context_create($arrContextOptions));
            }
        }else {
                $imagecreatefromjpeg = 'imagecreatefromstring';
                $pic_path = file_get_contents($pic_path, false, stream_context_create($arrContextOptions));
        }

        $im = $imagecreatefromjpeg($pic_path);

        return $im;
    }

    public function getRealData($data)
    {
        $data['left'] = intval(str_replace('px', '', $data['left'])) * 2;
        $data['top'] = intval(str_replace('px', '', $data['top'])) * 2;
        $data['width'] = intval(str_replace('px', '', $data['width'])) * 2;
        $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;

        if ($data['size']) {
            $data['size'] = intval(str_replace('px', '', $data['size'])) * 2;
        }
        if ($data['src']) {
            $data['src'] = tomedia($data['src']);
        }

        return $data;
    }

    public function write_img($target, $data, $imgurl)
    {
        $img = $this->create_imagecreatefromjpeg($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
        imagedestroy($img);
        return $target;
    }

    function autowrap($fontsize, $angle, $fontface, $string, $width)
    {
        // 参数分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
        $content = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        preg_match_all("/./u", $string, $arr);
        $letter = $arr[0];
        foreach ($letter as $l) {
            $teststr = $content . $l;
            $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
            if (($testbox[2] > $width) && ($content !== "")) {
                $content .= PHP_EOL;
            }
            $content .= $l;
        }
        return $content;
    }

    public function write_text($dest, $data, $string, $fontfile)
    {

        if ($data['type'] == 'title') {
            $width = imagesx($dest) - $data['left'] * 2;
        } else {
            $width = imagesx($dest) * 2;
        }

        $font_file = $fontfile . 'simhei.ttf';

        $colors = $this->hex2rgb($data['color']);
        $color = imagecolorallocate($dest, $colors['red'], $colors['green'], $colors['blue']);//背景色
        $string = $this->autowrap($data['size'], 0, $font_file, $string, $width);
        $fontsize = $data['size'];
        imagettftext($dest, $fontsize, 0, $data['left'], $data['top'], $color, $font_file, $string);
        return $dest;
    }

    function hex2rgb($colour)
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[1],
                $colour[2] . $colour[3],
                $colour[4] . $colour[5]
            );
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[0],
                $colour[1] . $colour[1],
                $colour[2] . $colour[2]
            );
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array(
            'red' => $r,
            'green' => $g,
            'blue' => $b
        );
    }

    //将颜色代码转rgb
    function wpjam_hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return array($r, $g, $b);
    }

    //获得二维码
    public function get_qrcode($url,$uploadImg,$size = 5) {
            $value = $url;                  //二维码内容  
            $errorCorrectionLevel = 'L';    //容错级别   
            $matrixPointSize = $size;           //生成图片大小    
            $filename = $uploadImg.md5(time().mt_rand(0,1000)).'.png';  
            QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);    
            return   $filename;
    }

    public function get_user_url($type = '')
    {
        $sql = "select uploadImg_domain,uploadImg from lkt_config where store_id = '$this->store_id'";
        $r = $this->db->select($sql);
        if ($r) {

            $uploadImg = $r[0]->uploadImg;  // 图片上传位置
            $uploadImg_domain = $r[0]->uploadImg_domain;
            // $url = $uploadImg_domain.'/index.php?module=user_reg&referrer_id='.$this->user_id;
            $url = 'https://www.laiketui.com';
            if($type == 'get_qrcode'){
                if(empty($uploadImg)){
                    $uploadImg = "./images";
                }

                $product_share_img = $uploadImg.'image_'.$this->store_id.'/product_share_img/';
                if(is_dir($product_share_img) == ''){ // 如果文件不存在
                    mkdir($product_share_img); // 创建文件
                }

                $filename = $this->get_qrcode($url,$product_share_img);
                return $filename;
            }
            return $url;
        }else{
            return '';
        }
    }


    function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($data)) {
            // 发送post请求
            curl_setopt($ch, CURLOPT_POST, 1);
            // 设置发送post请求参数数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // 3.执行会话; $result是微信服务器返回的JSON字符串
        $result = curl_exec($ch);
        // 4.关闭会话
        curl_close($ch);
        return $result;
    }

    //生成红包文字
    function madeCode(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $id = trim($request->getParameter('id'));
        $wx_id = $request->getParameter('openid');
        // 查询公司名称
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $company = $r[0]->company;
        $instring = $company . '给你发红包啦';

        echo json_encode(array('status' => 1, 'text' => $instring));
        exit();
        return;
    }
    
    function getAccessToken($appID, $appSerect,$re = '')
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = $appID."_accessToken";
        // 文件名
        if (is_file($fileName)) {
            if($re == ''){
                $modifyTime = filemtime($fileName);
                if (($currentTime - $modifyTime) < 7200) {
                    // 可用, 直接读取文件的内容
                    $accessToken = file_get_contents($fileName);
                    return $accessToken;
                }                
            }

        }
        // 重新发送请求
        $result = $this->httpsRequest($url);
        $jsonArray = json_decode($result, true);
        // 写入文件
        $accessToken = $jsonArray['access_token'];
        file_put_contents($fileName, $accessToken);
        return $accessToken;
    }
    //获得二维码-微信小程序
    public function get_share_qrcode($path, $width, $id, $AccessToken)
    {
        // header('content-type:image/jpeg');  测试时可打开此项 直接显示图片
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if (strpos($uploadImg, '../') === false) { // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        } else { // 不存在
            $img = $uploadImg_domain . substr($uploadImg, 2); // 图片路径
        }
        $pid = $request->getParameter('pid');
        $path_name = str_replace('/', '_', $path);
        $filename = $path_name . '_share_' . $id . '_' . $pid . '.jpeg';///
        $imgDir = 'product_share_img/';
        $width = 430;
        //要生成的图片名字
        $newFilePath = $uploadImg . $imgDir . $filename;
        if (is_file($newFilePath)) {
            return $newFilePath;
        } else {
            $scene = $request->getParameter('scene');
            //获取三个重要参数 页面路径  图片宽度  文章ID
            //--B $arr = ["page"=> $path, "width"=>$width,'scene'=>$scene];
            //--A
            $arr = ["path" => $path . '?' . $scene, "width" => $width];
            $data = json_encode($arr);
            //把数据转化JSON 并发送
            // 接口A: 适用于需要的码数量较少的业务场景 接口地址：
            $interface_wx = 'https://api.weixin.qq.com/wxa/getwxacode?access_token=';
            $url = $interface_wx . $AccessToken;

            // 接口B：适用于需要的码数量极多的业务场景
            // $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $AccessToken;
            // 接口C：适用于需要的码数量较少的业务场景
            // $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=' . $AccessToken;
            //获取二维码API地址

            $da = $this->httpsRequest($url, $data);
            //发送post带参数请求 

            //新增access_token过期验证
            $json = json_decode($da);
            if (isset($json->errcode)) {
                $AccessToken = $this->getAccessToken($this->appid, $this->appsecret, 1);
                $url = $interface_wx . $AccessToken;
                $da = $this->httpsRequest($url, $data);
            }
            // var_dump($json,$da,isset($json->errcode),empty($json));exit;
            // header('content-type:image/jpeg');
            // echo $da;exit;
            $newFile = fopen($newFilePath, "w"); //打开文件准备写入
            fwrite($newFile, $da); //写入二进制流到文件
            fclose($newFile); //关闭文件
            return $newFilePath;
        }

    }

}
?>