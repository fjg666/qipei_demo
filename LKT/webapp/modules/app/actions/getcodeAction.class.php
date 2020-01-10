<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/alipay/test.php');

/**
 * [getcodeAction description]
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  苏涛
 * @version 2.0
 * @date    2018-12-12T17:48:13+0800
 * @param   二维码处理 [description]
 */
class getcodeAction extends LaiKeAction
{

    public $appid; // 小程序唯一标识
    public $appsecret; // 小程序的 app secret

    public function getDefaultView(){
        $this->execute();
    }

    /*
    * param ori_img 原图像的名称和路径
    * param new_img 生成图像的名称
    * param percent 表示按照原图的百分比进行缩略，此项为空时默认按50%
    * param width 指定缩略后的宽度
    * param height 指定缩略后的高度
    *
    * 注：当 percent width height 都传入值的时候，且percent>0时，优先按照百分比进行缩略
    * by：//www.jb51.net 更多源码与你分享
    * 温馨提示：使用此功能要在php.ini中开启 gd2
    *
    **/

    function makeThumb($ori_img, $new_img, $percent=50, $width=0, $height=0){

        $original = getimagesize($ori_img); //得到图片的信息，可以print_r($original)发现它就是一个数组
        //$original[2]是图片类型，其中1表示gif、2表示jpg、3表示png
        switch($original[2]){
            case 1 : $s_original = imagecreatefromgif($ori_img);
                break;
            case 2 : $s_original = imagecreatefromjpeg($ori_img);
                break;
            case 3 : $s_original = imagecreatefrompng($ori_img);
                break;
        }

        if($percent > 0){
            $width = $original[0] * $percent / 100;
            $width = ($width > 0) ? $width : 1;
            $height = $original[1] * $percent / 100;
            $height = ($height > 0) ? $height : 1;
        }

        //创建一个真彩的画布
        $canvas = imagecreatetruecolor($width,$height);
        imagecopyresized($canvas, $s_original, 0, 0, 0, 0, $width, $height, $original[0], $original[1]);
        //header("Content-type:image/jpeg");
        //imagejpeg($canvas); //向浏览器输出图片
        $loop = imagejpeg($canvas, $new_img); //生成新的图片
        return $loop;
    }

    public function get_mini_code($url,$APPID,$APPSECRET,$code_width=165){
        header('content-type:text/html;charset=utf-8');
        //      获取access_token
        $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$APPSECRET";
        //      缓存access_token
        $_SESSION['access_token'] = "";
        $_SESSION['expires_in'] = 0;
        $ACCESS_TOKEN = "";
        if(!isset($_SESSION['access_token']) || (isset($_SESSION['expires_in']) && time() > $_SESSION['expires_in']))
        {

            $json = $this->httpRequest( $access_token );
            $json = json_decode($json,true);
            $_SESSION['access_token'] = $json['access_token'];
            $_SESSION['expires_in'] = time()+7200;
            $ACCESS_TOKEN = $json["access_token"];
        }
        else{
            $ACCESS_TOKEN =  $_SESSION["access_token"];
        }
        //      构建请求二维码参数
        //      path是扫描二维码跳转的小程序路径，可以带参数?id=xxx
        //      width是二维码宽度
        $qcode ="https://api.weixin.qq.com/wxa/getwxacode?access_token=$ACCESS_TOKEN";
//        $qcode ="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=$ACCESS_TOKEN";
        //        $param = json_encode(array("path"=>"pages/goods/goodsDetailed?pro_id=80","width"=> 150));
        $param = json_encode(array("path"=>$url,"width"=> 50));

        //      POST参数
        $result = $this->httpRequest( $qcode, $param,"POST");
        //      生成二维码
        $file_path = 'images/product_share_img/';
        $qrcode_name = md5(time() . rand(1000, 9999));
        $filename = $file_path.$qrcode_name.'.jpg';
        $qrcode_name = file_put_contents($filename, $result);

        $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".jpg";

        list($width, $height)=getimagesize($filename);
        $per=round($code_width/$height,3);
        $n_w=$width*$per;
        $n_h=$height*$per;

        $new=imagecreatetruecolor($n_w, $n_h);
        $img=imagecreatefromjpeg($filename);
        //copy部分图像并调整
        imagecopyresized($new, $img,0, 0,0, 0,$n_w, $n_h, $width, $height);
        //图像输出新图片、另存为
        imagejpeg($new, $imgPath);
        imagedestroy($new);
        imagedestroy($img);
        // unlink($filename);
        $filename = $imgPath;
        return $filename;
        //        $base64_image ="data:image/jpeg;base64,".base64_encode( $result );
        //        echo $base64_image;
    }

    public function upimg($filename,$code_width=200){
        $type = explode('.',$filename);
        if ($type[1] == 'png' || $type[1] == 'PNG'){
            $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".png";
        }else{
            $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".jpg";
        }

        list($width, $height)=getimagesize($filename);
        $per=round($code_width/$height,3);
        $n_w=$width*$per;
        $n_h=$height*$per;

        $new=imagecreatetruecolor($n_w, $n_h);
        if ($type[1] == 'png' || $type[1] == 'PNG'){
            $img=imagecreatefrompng($filename);
        }else{
            $img=imagecreatefromjpeg($filename);
        }
//copy部分图像并调整
        imagecopyresized($new, $img,0, 0,0, 0,$n_w, $n_h, $width, $height);
//图像输出新图片、另存为
        imagejpeg($new, $imgPath);
        imagedestroy($new);
        imagedestroy($img);
        unlink($filename);
        $filename = $imgPath;
        return $filename;
    }

    //把请求发送到微信服务器换取二维码
    function httpRequest($url, $data='', $method='GET'){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if($method=='POST')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        if ($m == 'product_share') {
            $this->product_share();
        }elseif ($m == 'share'){
            $this->share();
        }elseif ($m == 'test'){
            $this->get_mini_code();
        }elseif ($m == 'share_shop'){
            $this->share_shop();
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
        $store_type = addslashes(trim($request->getParameter('store_type'))); // 来源
        $this->store_type = $store_type;

        $product_type = addslashes(trim($request->getParameter('product_type')));//商品类型 JP-竞拍商品
        $auction_id = addslashes(trim($request->getParameter('auction_id')));//竞拍商品id
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
            $sql = "select user_name,headimgurl,user_id from lkt_user where access_id = '$access_id' and store_id = '$store_id'";
            $r = $db->select($sql);
            if($r){
                $nickname =  $r[0]->user_name;
                $head = $r[0]->headimgurl;
                $user_id = $r[0]->user_id;
            }else{
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        $type = $request->getParameter('type');
        if (intval($type) == 4) {
            $this->comm_share();
            return;
        }

        $product_title = '';
        if($product_type == 'JP'){//竞拍商品
            $pid = $auction_id;
            if($pid){
                $sql = "select id,title,market_price,price,imgurl from lkt_auction_product where store_id = '$store_id' and id = '$pid'";
                $res = $db->select($sql);
                if($res){
                    $product_img = ServerPath::getimgpath($res['0']->imgurl);
                    $price = $res['0']->price;
                    $yprice = $res['0']->market_price;
                    $product_title = $res['0']->title;
                    if(strlen($product_title) > 18){
                        $product_title = mb_substr($product_title,0,18,'utf-8').'...';
                    }
                }else{
                    echo json_encode(array('code'=>108,'message'=>'暂无数据'));
                    exit;
                }
            }
        }else{//普通商品
            // 商品ID
            $pid =  addslashes(trim($request->getParameter('pid')));
            if($pid){
                // 根据产品id,查询产品数据
                $sql = "select a.*,c.price,c.yprice,c.attribute,c.img from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$pid' and a.status = 0 and a.recycle = 0";
                $res = $db->select($sql);
                if($res){
                    $product_img = ServerPath::getimgpath($res['0']->imgurl);
                    $price = $res['0']->price;
                    $yprice = $res['0']->yprice;
                    $product_title = $res['0']->product_title;
                    if (strlen($product_title) > 18) {
                        $product_title = mb_substr($product_title, 0, 18, 'utf-8') . '...';
                    }
                }else{
                    echo json_encode(array('code' => 108, 'message' => '暂无数据'));
                    exit;
                }
            }
        }

        //重新生成
        $regenerate = trim($request->getParameter('regenerate'));

        //路径
        $path = $request->getParameter('path'); // 前端路径
        //参数
        $scene = $request->getParameter('scene'); // 商品ID变量
        $proType = addslashes(trim($request->getParameter('proType')));  //参数
        $reUser = addslashes(trim($request->getParameter('reUser')));  //参数
        //默认底图和logo
        $logo = './images/ditu/logo.png';


        //定义固定分享图片储存路径 以便删除
        $imgDir = 'product_share_img/';
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret
            $this->appid = $appid;
            $this->appsecret = $appsecret;
            $upserver = $r[0]->upserver; // 上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云
            $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
            $uploadImg = $r[0]->uploadImg; // 图片上传位置
            $domain = $r[0]->domain; // 小程序域名
            $app_domain_name = $r[0]->app_domain_name; // APPA域名
            if($upserver == '2'){
                $common = LKTConfigInfo::getOSSConfig();
                $dir = $store_id . '/' . $store_type . '/';
                $img = 'https://' . $common["bucket"] . '.' . $common["endpoint"] . '/' . $dir ; // 图片路径
            }else{
                if(!is_dir($uploadImg)){ // 函数检查指定的文件是否是一个目录。
                    mkdir($uploadImg,0777); // 不存在就创建
                }
                if (strpos($uploadImg, './') === false) { // 判断字符串是否存在 ../
                    $img = $uploadImg_domain . $uploadImg . $imgDir; // 图片路径
                } else {
                    $img = $uploadImg_domain . substr($uploadImg, 1) . $imgDir; // 图片路径
                }
            }
            $font_file_path = dirname(MO_WEBAPP_DIR); // 函数返回路径中的目录部分
            $font_file = $font_file_path . substr($uploadImg, 1);
        }

        // 根据商城ID、海报类型、来源、默认，查询推广图片表
        $tkt_sql = "select * from lkt_extension where store_id = '$store_id' and type ='$type' and isdefault='1' and store_type = '$store_type' ";
        $tkt_r = $db->select($tkt_sql);


        if (empty($tkt_r)) { // 不存在
            $url = $img . 'img.jpg';
            echo json_encode(array('code' => 200,'status' => true, 'url' => $url, 'message' => '成功1'));
            exit;
        }
        $img_token = $tkt_r[0]->add_date; // 添加时间
        $pic_md5 = time() . $img_token . $type . $pid . $path . $scene; // 添加时间、海报类型、商品ID、前端路径、商品ID变量
        $pic = md5($pic_md5) . '.jpg'; // 图片名称
        $waittext = isset($tkt_r[0]->waittext) ? $tkt_r[0]->waittext : '#fff'; // 等待语


        if($store_type == 1){ // 小程序
            $link_address = $domain . '&'.$scene . '='.$pid; // 链接地址
        }else if($store_type == 2){ // APP
            $link_parameter = json_encode(array("store_id"=>$store_id,"store_type"=>$store_type,"type"=>$type,"$scene"=>$pid,"proType"=>$proType,'reUser'=>$reUser));
            $link_address = $app_domain_name . '/H5/?shareDate=' . urlencode($link_parameter) ; // 链接地址
        }
        if (is_file($img . $pic)) { // 存在
            $url = $img . $pic;
            echo json_encode(array('code' => 200,'status' => true, 'url' => $url, 'waittext' => $waittext, 'message' => '成功2'));
            exit;
        }

        if ($type == '1') {
            //文章
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        } else if ($type == '2') {
            //红包
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        } else if ($type == '3') {
            //商品
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg; // 背景图片
                $data = $tkt_r[0]->data;
            }
        } else if ($type == '4') {
            //分销
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        }else if ($type == '5') {
            //邀请有奖
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        }else if($type == '6'){
            //竞拍
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        }else {
            //分销
            if (!empty($r)) {
                $bottom_img = $tkt_r[0]->bg;
                $data = $tkt_r[0]->data;
            }
        }
        // 创建底图
        $dest = $this->create_imagecreatefromjpeg($bottom_img);

        $datas = json_decode($data);

        $Wo = 0;//图片原宽
        $Wr = 0;//图片img宽度
        $Ho = 0;//图片原高
        $Hr = 0;//图片img高度
        $count = 0;
        foreach ($datas as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k == 'imageSize' && $count == 0) {
                    $count = 1;
                    foreach ($v as $imgk => $val) {
                        $sval = intval(str_replace('px', '', $val));
                        switch ($imgk) {
                            case 'height':
                                $Hr = $sval;
                                break;
                            case 'naturalHeight':
                                $Ho = $sval;
                                break;
                            case 'width':
                                $Wr = $sval;
                                break;
                            case 'naturalWidth':
                                $Wo = $sval;
                                break;
                        }
                    }
                }
            }
        }

        foreach ($datas as $key => $value) {
            $data = array();
            foreach ($value as $k => $v) {
                if( $k == 'left' || $k == 'top' || $k == 'width' || $k == 'height' || $k == 'size'){
                    $v = intval(str_replace('px', '', $v));
                    // todo 优化精确值
                    switch($k){
                        case "left"     :  $v=  ceil($v* round($Wo/$Wr)-55); break;
                        case "top"      :  $v=  ceil($v*round($Ho/$Hr)+25); break;
                        case "width"    :  $v=  ceil(round(($v*$Wo)/$Wr))-10; break;
                        case "height"   :  $v=  ceil(($v*$Ho)/$Wr); break;
                    }
                }
                if ($k != 'imageSize' ) {
                    $data[$k] = $v;
                }
            }

            if ($value->type == 'head') { // 头像
                $head = $head."?x-oss-process=image/resize,w_".$data['width']."/circle,r_100/format,png";
                $data['height'] = $data['width'];
                $dest = $this->write_img($dest, $data, $head);
            } else if ($value->type == 'nickname') { // 昵称
                $dest = $this->write_text($dest, $data, $nickname, $font_file);
            } else if ($value->type == 'qr') { // 二维码
                if($store_type == 1){
                    $AccessToken = $this->getAccessToken($appid, $appsecret);
                    $share_qrcode = $this->get_share_qrcode($path, $value->width, $user_id, $AccessToken);
                }else{
                    $share_qrcode = $this->get_user_url('get_qrcode',$link_address,$pic);
                }
                $data["height"] =  $data["width"];
                $dest = $this->write_img($dest, $data, $share_qrcode);
            } else if ($value->type == 'img') { // 图片
                if ($value->src) {
                    $imgs = $uploadImg . $value->src;
                    $dest = $this->write_img($dest, $data, $imgs);
                }
            } else if ($value->type == 'title') { // 商品名称
                //标题
                $dest = $this->write_text($dest, $data, $product_title, $font_file);
            } else if ($value->type == 'thumb') { // 商品图片
                //商品图合成
                $dest = $this->write_img($dest, $data, $product_img);
            } else if ($value->type == 'marketprice') { // 商品现价
                //价格
                $product_title = '￥' . $price;
                $dest = $this->write_text($dest, $data, $product_title, $font_file);
            } else if ($value->type == 'productprice') { // 商品原价
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

        if($upserver == '2'){ // 如果上传到阿里云
            $ossClient = OSSCommon::getOssClient();
            $common = LKTConfigInfo::getOSSConfig();
            $path = $dir . $pic;

            $ossClient->uploadFile($common['bucket'], $path, $uploadImg . $imgDir . $pic);
        }
        $url = $img . $pic;

        echo json_encode(array('code' => 200,'status' => true, 'url' => $url, 'waittext' => $waittext,'message' => '成功3'));
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

        $pathInfo = pathinfo($pic_path); // 函数以数组的形式返回文件路径的信息。
        if(is_file($pathInfo['basename'])){
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
            // 把整个文件读入一个字符串中
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
    // 写入文件
    public function write_img($target, $data, $imgurl)
    {

        $img = $this->create_imagecreatefromjpeg($imgurl);

        $w = imagesx($img);
        $h = imagesy($img);

        imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h); // 函数用于拷贝部分图像并调整大小。
        imagedestroy($img); // 函数用于销毁图像资源。

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
        if(!empty($data['type'])){
            if ($data['type'] == 'title') {
                $width = imagesx($dest) - $data['left'] * 2;
            } else {
                $width = imagesx($dest) * 2;
            }
        }else{
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

    // 获得二维码，并储存到本地
    public function get_qrcode($url,$uploadImg,$size = 5) {

        $value = $url;                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg.md5(time().mt_rand(0,1000)).'.png';

        QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);

        return $filename;
    }
    // 把二维码
    public function get_user_url($type = '',$url,$pic)
    {
        $sql = "select upserver,uploadImg_domain,uploadImg,domain,app_domain_name from lkt_config where store_id = '$this->store_id'";
        $r = $this->db->select($sql);
        if ($r) {
            $uploadImg = $r[0]->uploadImg;  // 图片上传位置
            $uploadImg_domain = $r[0]->uploadImg_domain;
//            $url = 'https://www.laiketui.com';
//            $upserver = $r[0]->upserver; // 上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云
//            $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
//            $uploadImg = $r[0]->uploadImg; // 图片上传位置
//            $domain = $r[0]->domain; // 小程序域名
//            $app_domain_name = $r[0]->app_domain_name; // APPA域名

            if($type == 'get_qrcode'){
                if(empty($uploadImg)){
                    $uploadImg = "./images";
                }
                $product_share_img = $uploadImg.'image_'.$this->store_id.'/product_share_img/';

                if(is_dir($product_share_img) == ''){ // 如果文件不存在
                    mkdir($product_share_img, 0777); // 创建文件
                }

                $filename = $this->get_qrcode($url,$product_share_img);
//                if($upserver == '2'){ // 如果上传到阿里云
//                    require_once(MO_LIB_DIR . '/aliyun-oss-php-sdk-2.3.0/samples/Object.php');
//                    $ossClient = Common::getOssClient();
//
//                    $dir = $this->store_id . '/' . $this->store_type . '/';
//                    $path = $dir . trim(strrchr($filename, '/'),'/');
////                    $path = $dir . $pic;
//
//                    $ossClient->uploadFile(Common::bucket, $path, $filename);
//                    $filename = 'https://' . Common::bucket . '.' . Common::endpoint . '/' . $path;
//                }
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



    /**
     * 分销
     */
    public function comm_share(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = addslashes(trim($request->getParameter('store_type'))); // 来源
        $access_id = addslashes(trim($request->getParameter('access_id'))); // 来源

        //查询用户头像、名字
        $sel_user_sql = "SELECT user_name, headimgurl,user_id
                    FROM lkt_user
                    WHERE access_id = '$access_id'";
        $user_res = $db->select($sel_user_sql);

        if(!$user_res){
            echo json_encode(array('code'=>500,'msg'=>'授权码无效!!'));
            exit;
        }
        $user_id = $user_res[0]->user_id;
        $user_name = $user_res[0]->user_name;
//        $headimgurl = $user_res[0]->headimgurl.'?x-oss-process=image/resize,w_150/circle,r_100/format,png';
        $headimgurl = $user_res[0]->headimgurl;
        $sql = "select name from lkt_customer where id = '$store_id'";
        $r = $db->select($sql);
        $store_name = $r[0]->name;

        $url = "pages/login/login?fatherId=".$user_id;

        if($store_type == 1){
            //小程序
            $sql = "select * from lkt_payment_config where pid = '5' and store_id = '$store_id' ";
            $r = $db->select($sql);

            $value = $r ? $r[0]:[];
            if ($value) {
                $list = json_decode($value->config_data);
                $appid = $list->appid;
                $appsecret = $list->appsecret;
            }

            $qrcode_path = $this->get_mini_code($url,$appid,$appsecret,550);
        }else{
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            if (!empty($r[0]->H5_domain)) {
                $url = $r[0]->H5_domain.$url;
            }
            //生成二维码
            if ($store_type == 2) {
                $qrcode_path = $this->get_qrcode1($url, 'images/product_share_img',15);
                $qrcode_path = $this->upimg($qrcode_path,560);
            }else{
                $url = "pages/login/login";
                $query_param = "fatherId=".$user_id;
                $qrcode_path = $this->get_qrcode2($store_id,$url,$query_param, 'images/product_share_img',15);
                $qrcode_path = $this->upimg($qrcode_path,750);
            }
        }

        //合成图片
        //案例二：将活动背景图片设置透明，然后和动态二维码图片合成一张图片
        $path_1 = 'images/product_share_img/share_bg.png';
        $path_2 = $qrcode_path;
        $logo = $this->downImgUrl($headimgurl);//下载头像
        $logo = $this->upimg($logo,150);

        $text1 = '我是 '.$user_name;
        $text2 = '我为 '.$store_name.' 代言';

        //创建图片对象
        $image_1 = $this->getImageType($path_1);
        $image_2 = $this->getImageType($path_2);
        $image_6 = $this->getImageType($logo);
        $image_3 = imageCreatetruecolor(imagesx($image_1),imagesy($image_1));
        $color = imagecolorallocate($image_3, 255, 255, 255);
        imagefill($image_3, 0, 0, $color);
        imagecopyresampled($image_3, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));
        //与图片二合成
        //二维码
        if($store_type == 1){
            imagecopymerge($image_3, $image_2, 400, 290, 0, 0, imagesx($image_2), imagesy($image_2), 100);
        }else{
            if ($store_type == 2) {
                imagecopymerge($image_3, $image_2, 400, 270, 0, 0, imagesx($image_2), imagesy($image_2), 100);
            }else{
                imagecopymerge($image_3, $image_2, 400, 270, 0, 0, imagesx($image_2), imagesy($image_2)-150, 100);
            }

        }
        //店铺头像
        // imagecopy($image_3, $image_6, 300, 120, 0, 0, imagesx($image_6), imagesy($image_6));
        //文字水印
        $font1 = 'images/product_share_img/PINGFANG BOLD.TTF';//字体,字体文件需保存到相应文件夹下
        $font2 = 'images/product_share_img/PINGFANG MEDIUM.TTF';//字体,字体文件需保存到相应文件夹下

        $black = imagecolorallocate($image_3, 2, 2, 2);//字体颜色 RGB
        $white = imagecolorallocate($image_3, 255, 255, 255);//字体颜色 RGB
        $hui = imagecolorallocate($image_3, 170,170,170);//字体颜色 RGB

        $circleSize = 0; //旋转角度

        // $nameWidth1 = mb_strlen($text1)*24;
        // $x1 = (700-floatval($nameWidth1))/2;
        // imagefttext($image_3, 24, $circleSize, $x1, 305, $black, $font2, $text1);

        // $nameWidth2 = mb_strlen($text2)*24;
        // $x2 = (700-floatval($nameWidth2))/2;
        // imagefttext($image_3, 24, $circleSize, $x2, 345, $black, $font2, $text2);

        // 输出合成图片
        $versin = 2;//版本号

        $share_img_name = time().$user_id.$versin.'_share.png';

        $share_img_path = 'images/product_share_img/'.$share_img_name;
        imagepng($image_3,$share_img_path);
        $base64img = $this->base64EncodeImage($share_img_path);
        $base64img = str_replace("\r\n", "", $base64img);
        unlink($qrcode_path);
        unlink($logo);

        $sql = "select endurl from lkt_third where id = 1";
        $r = $db->select($sql);
        $share_img_path = $r[0]->endurl.$share_img_path;

        // $html = "<img src='$base64img'>";
        // echo $html;exit;

        echo json_encode(array('code' => 200,'status' => true, 'url' => $share_img_path, 'message' => '成功'));
        exit;
    }

    /**
     * 店铺分享
     */
    public function share_shop()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $shop_id = trim($request->getParameter('shop_id'));
        $access_id = trim($request->getParameter('access_id'));
        $type = trim($request->getParameter('type'));

        //查询用户头像、名字
        $sel_user_sql = "SELECT user_name, headimgurl,user_id
                    FROM lkt_user
                    WHERE access_id = '$access_id'";
        $user_res = $db->select($sel_user_sql);

        if(!$user_res){
            echo json_encode(array('code'=>500,'msg'=>'授权码无效!!'));
            exit;
        }

        //查询店铺信息
        $sql0 = "select * from lkt_mch where store_id = '$store_id' and id = '$shop_id'";
        $r0 = $db->select($sql0);
        $mch_data = array();
        if($r0){
            $mch_data['logo'] = ServerPath::getimgpath($r0[0]->logo,$store_id);
            $mch_data['name'] = $r0[0]->name;

            $sql1 = "select id,product_class from lkt_product_list where store_id = '$store_id' and mch_id = '$shop_id' and mch_status = 2 and status = 2 and recycle = 0 and active = 1 order by add_date desc ";
            $r1 = $db->select($sql1);
            $mch_data['quantity_on_sale'] = count($r1);//在售数量

            $sql_3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid ";
            $r3 = $db->select($sql_3);
            $mch_data['quantity_sold'] = 0;
            if($r3){
                foreach($r3 as $k => $v){
                    $mch_data['quantity_sold'] += $v->volume;  // 已售数量
                }
            }

            $sql0_0 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id'";
            $r0_0 = $db->select($sql0_0);
            $mch_data['collection_num'] = count($r0_0);//收藏人数
        }else{
            echo json_encode(array('code'=>404,'msg'=>'店铺不存在!'));
            exit;
        }

        $url = "pagesA/store/store?is_share=true&shop_id=".$shop_id;

        if($store_type == 1){
            //小程序
            $sql = "select * from lkt_payment_config where pid = '5' and store_id = '$store_id' ";
            $r = $db->select($sql);

            $value = $r ? $r[0]:[];
            if ($value) {
                $list = json_decode($value->config_data);
                $appid = $list->appid;
                $appsecret = $list->appsecret;
            }

            $qrcode_path = $this->get_mini_code($url,$appid,$appsecret,350);
            $this->makeThumb($qrcode_path,$qrcode_path,0,350,350);
        }else{
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            if (!empty($r[0]->H5_domain)) {
                $url = $r[0]->H5_domain.$url;
            }
            //生成二维码
            $qrcode_path = $this->get_qrcode1($url, 'images/product_share_img',11);
//            $this->makeThumb($qrcode_path,$qrcode_path,0,395,390);
        }



        $mch_data['logo'] = $mch_data['logo']."?x-oss-process=image/resize,m_fixed,h_100,w_100/format,png";

        //合成图片
        //案例二：将活动背景图片设置透明，然后和动态二维码图片合成一张图片
        // 图片一
        $path_1 = 'images/product_share_img/shop_bg.png';
        // 图片二
        $path_2 = $qrcode_path;

        $logo = $this->downImgUrl($mch_data['logo']);//下载店铺logo

        //创建图片对象
        $image_1 = imagecreatefrompng($path_1);
        $image_2 = $this->getImageType($path_2);
        $image_6 = $this->getImageType($logo);
        $image_3 = imageCreatetruecolor(imagesx($image_1),imagesy($image_1));
        $color = imagecolorallocate($image_3, 255, 255, 255);
        imagefill($image_3, 0, 0, $color);
        imagecopyresampled($image_3, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));
        //与图片二合成
        //二维码
        if($store_type != 1){
            imagecopymerge($image_3, $image_2, 80, 400, 0, 0, imagesx($image_2), imagesy($image_2), 100);
        }else{
            imagecopymerge($image_3, $image_2, 105, 400, 0, 0, imagesx($image_2), imagesy($image_2), 100);
        }
        //店铺头像
        imagecopy($image_3, $image_6, 225, 60, 0, 0, imagesx($image_6), imagesy($image_6));
        //文字水印
        $font1 = 'images/product_share_img/PINGFANG BOLD.TTF';//字体,字体文件需保存到相应文件夹下
        $font2 = 'images/product_share_img/PINGFANG MEDIUM.TTF';//字体,字体文件需保存到相应文件夹下

        $black = imagecolorallocate($image_3, 0, 0, 0);//字体颜色 RGB
        $white = imagecolorallocate($image_3, 255, 255, 255);//字体颜色 RGB
        $hui = imagecolorallocate($image_3, 170,170,170);//字体颜色 RGB

        $circleSize = 0; //旋转角度

        $nameWidth = mb_strlen($mch_data['name'])*24;
        $x = (550-floatval($nameWidth))/2;

        imagefttext($image_3, 18, $circleSize, $x, 200, $white, $font2, $mch_data['name']);//店铺名称
        $width1 = $this->get_text_width($mch_data['quantity_on_sale'],$font1,18);
        $x1 = (190-$width1)/2;
        imagefttext($image_3, 18, $circleSize, $x1, 270, $white, $font1, $mch_data['quantity_on_sale']);
        imagefttext($image_3, 14, $circleSize, 60, 300, $hui, $font1, '在售商品');
        $width2 = $this->get_text_width($mch_data['quantity_sold'],$font1,18);
        $x2 = (556-$width2)/2;
        imagefttext($image_3, 18, $circleSize, $x2, 270, $white, $font1, $mch_data['quantity_sold']);
        imagefttext($image_3, 14, $circleSize, 260, 300, $hui, $font1, '已售');
        $width3 = $this->get_text_width($mch_data['collection_num'],$font1,18);
        $x3 = (910-$width3)/2;
        imagefttext($image_3, 18, $circleSize, $x3, 270, $white, $font1, $mch_data['collection_num']);
        imagefttext($image_3, 14, $circleSize, 420, 300, $hui, $font1, '关注人数');


        imagefttext($image_3, 18, $circleSize, 170, 845, $black, $font1, '长按识别图中二维码');

        // 输出合成图片
        $versin = 2;//版本号

        $share_img_name = time().$shop_id.$versin.'_share.png';

        $share_img_path = 'images/product_share_img/'.$share_img_name;
        imagepng($image_3,$share_img_path);
        unlink($qrcode_path);
        unlink($logo);

        $imgUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&type=img';
        echo json_encode(array('code' => 200 , 'imgUrl' => $share_img_path));
        exit;

    }

    public  function get_text_width($str, $fontFamily, $fontSize){

        // 计算总占宽
        $dimensions = imagettfbbox($fontSize, 0, $fontFamily, $str);
        $textWidth = abs($dimensions[4] - $dimensions[0]);

        return $textWidth;
    }

    /**
     * 图片分享
     */
    public function share()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $proId = trim($request->getParameter('proId'));
        $attr_id = trim($request->getParameter('attr_id'));
        $order_no = trim($request->getParameter('order_no'));
        $brStatus = trim($request->getParameter('brStatus'));
        $type = trim($request->getParameter('type'));
        $access_id = trim($request->getParameter('access_id'));
        $href = trim($request->getParameter('href'));
        $share_type = intval($request->getParameter('share_type'));

        file_put_contents('images/product_share_img/1log.txt', '开始',FILE_APPEND);

        //查询用户头像、名字
        $sel_user_sql = "SELECT user_name, headimgurl,user_id
                    FROM lkt_user
                    WHERE access_id = '$access_id'";
        $user_res = $db->select($sel_user_sql);

        if(!$user_res){
            echo json_encode(array('code'=>500,'msg'=>'授权码无效!!'));
            exit;
        }

        $isfx = false;//是否为分销商品
        $goods_id = $proId;

        // 如果是积分商品
        if ($share_type == 2) {
            $sql = "select g.integral,g.money,a.product_title,a.id as goods_id,c.img as imgurl from lkt_integral_goods as g left join lkt_product_list as a on g.goods_id=a.id left join lkt_configure as c on g.attr_id = c.id  where g.id = '$proId'";
            $c_res = $db->select($sql);
            $goods_id = $c_res[0]->goods_id;
        }


        $sql = "SELECT p.product_title, p.imgurl, p.separate_distribution,p.active, c.price
                FROM lkt_product_list AS p
                LEFT JOIN lkt_configure AS c ON p.id = c.pid
                where p.id = $goods_id
                ORDER BY c.price";
        $c_res = $db->select($sql);

        //计算价格
        if($c_res ){
            $priceStr = $c_res[0]->price;
            $pro_type_no = $c_res[0]->active; //商品类型 1正常商品 2拼团商品 3砍价商品 4竞拍商品
            if($pro_type_no == 2){
                //如果是拼团商品 查询出参团的最低价格
                $activity_no = intval($request->getParameter('activity_no'));


                if($type == 'pt'){
                    $guigesql = "select group_level from lkt_group_product 
                 where product_id = $proId and store_id = $store_id and activity_no = $activity_no";
                }else{
                    $guigesql = "select group_level from lkt_group_product 
                 where product_id = $proId and store_id = $store_id and is_delete = 0 and g_status != 1 order by id desc";
                }
                $guigeres = $db->select($guigesql);
                $level = $guigeres[0]->group_level;
                //计算拼团的最低价 和 对应的参团人数hg
                $sel_attr_sql = "select c.price
            from lkt_configure as c 
            left join lkt_product_list as p on c.pid=p.id 
            where c.pid=$proId";
                $min_price = '';
                $sel_attr_Res = $db->select($sel_attr_sql);
                foreach ($sel_attr_Res as $k => $v3){
                    if($min_price == ''){
                        $min_price = $v3->price;
                    }else if($min_price > $v3->price){
                        $min_price = $v3->price;
                    }
                }

                //查询最低价格的和 拼团人数
                $kai_min_bili = $min_bili = 100;
                $kai_min_man = $min_man = 100;
                $level = unserialize($level);
                if($type == 'pt'){
                    foreach ($level as $k => $v__){
                        $bili = explode('~',$v__);
                        if($min_bili > $bili[0]){
                            $min_bili = $bili[0];
                            $min_man = $k;
                        }
                    }
                }else{
                    $sNo = trim($request->getParameter('sNo'));

                    $sql_grp = "SELECT goo.groupman
                                FROM lkt_order as o 
                                left JOIN lkt_group_open as goo on o.ptcode = goo.ptcode
                                where o.sNo ='$sNo' and o.store_id = $store_id ";
                    $grp_res = $db->select($sql_grp);
                    if(!empty($grp_res)){
                        $groupman = $grp_res[0]->groupman;
                        $bili = explode('~',$level[$groupman]);
                        $min_bili = $bili[0];
                    }
                }
                $min_price = floatval($min_price)*intval($min_bili)/100;
                $priceStr = sprintf("%.2f", $min_price);

            }else if($pro_type_no == 3){
                //如果是砍价商品 查询出砍价完成后的价格
                $sql = "SELECT bargain_id from lkt_bargain_order where order_no = '$order_no'";
                $go_res = $db->select($sql);
                if($go_res){
                    $bid = $go_res[0]->bargain_id;
                    $sql = "SELECT min_price from lkt_bargain_goods where id = $bid";
                    $go_res1 = $db->select($sql);
                    if($go_res1){
                        $priceStr = $go_res1[0]->min_price;
                    }
                }
            }
        }else{
            echo json_encode(array('code'=>404,'msg'=>'商品不存在！'));
            exit;
        }

        $fx_sql = "SELECT is_distribution
                    FROM  `lkt_product_list` 
                    WHERE id =$proId";
        $is_fx_res = $db->select($fx_sql);
        if($is_fx_res){
            if($is_fx_res[0]->is_distribution == 1){
                $isfx = true;
            }
        }

        $pic_size = 3;
        $product_title = $c_res[0]->product_title;
        $url = "pages/goods/goodsDetailed?productId=".$proId."&isfx=true";
        if($isfx){
            $user_id = $user_res[0]->user_id;
            $url = "pages/goods/goodsDetailed?productId=".$proId."&isfx=true&fatherId=".$user_id;
        }else if($type == 'pt'){
            //如果是拼团
            $activity_no = trim($request->getParameter('activity_no'));
            $url = "pagesA/group/groupDetailed?pro_id=".$proId."&activity_no=$activity_no&isfx=true";
            $pic_size = 4;
        }else if($type == 'pt_end'){
            //如果是拼团结束页面
            $url = "pagesA/group/group_end?sNo=$sNo&friend=true";
            $url_ = "pagesA/group/group_end";
            $query_param = "sNo=$sNo&friend=true";
            $pic_size = 4;
        }else if ($order_no!=''){
            $sql = "SELECT attr_id,goods_id,bargain_id from lkt_bargain_order where order_no = '$order_no'";
            $go_res = $db->select($sql);
            $attr_id = $go_res[0]->attr_id;
            $goods_id = $go_res[0]->goods_id;
            $sql = "SELECT product_title,imgurl, c.price
                FROM lkt_product_list as p
                LEFT JOIN lkt_configure as c on c.pid = p.id
                where p.id = $goods_id and c.id = $attr_id;";
            $c_res = $db->select($sql);
            $proId = $go_res[0]->goods_id;
            $attr_id = $go_res[0]->attr_id;
            $bargain_id = $go_res[0]->bargain_id;
            $url = "pagesA/bargain/bargainIng?proId=$proId&attr_id=$attr_id&order_no=$order_no&brStatus=$brStatus&friend=true&bargain_id=$bargain_id";
        }else if($type == "JP"){
            //$url = "pagesA/bidding/bidding_detailed?biddingId=$proId&type=1";
            $bindding_id = trim($request->getParameter('bindding_id'));//竞拍活动id
            $sql = "select title,current_price from lkt_auction_product where store_id = '$store_id' and id = '$bindding_id'";
            $res = $db->select($sql);
            $product_title = $res[0]->title;
            $priceStr = $res[0]->current_price;
            //将跳转上交竞拍押金的路劲参数序列化
            $bid = new stdClass;
            $bid->bindding_id = $bindding_id;
            $bid->type = 1;
            $bid->isfx = true;
            $bid_str = json_encode($bid);
            $url = "pagesA/bidding/bidding_detailed?bid=$bid_str";
        }

        // 如果是积分商品
        if ($share_type == 2) {
            $url = "pagesB/integral/integral_detail?pro_id=$proId&isfx=true";

            $sql = "select g.integral,g.money,a.product_title,c.img as imgurl from lkt_integral_goods as g left join lkt_product_list as a on g.goods_id=a.id left join lkt_configure as c on g.attr_id = c.id  where g.id = '$proId'";
            $c_res = $db->select($sql);
            $priceStr = $c_res[0]->integral.'积分';
            $product_title = $c_res[0]->product_title;
            if (floatval($c_res[0]->money) > 0) {
                $priceStr = '￥'.$c_res[0]->money.'+'.$c_res[0]->integral.'积分';
            }
            $pic_size = 4;
        }
//        影响了所有的分享路径
//        if ($href && !empty($href)) {
//            $url = $href;
//        }

        if($store_type == 1){
            //微信小程序
            $sql = "select * from lkt_payment_config where pid = '5' and store_id = '$store_id' ";
            $r = $db->select($sql);

            $sql = "select domain from lkt_config where store_id = '$store_id'";
            $r_db = $db->select($sql);

            $value = $r ? $r[0]:[];
            if ($value) {
                $list = json_decode($value->config_data);
                $appid = $list->appid;
                $appsecret = $list->appsecret;
            }
            $qrcode_path = $this->get_mini_code($url,$appid,$appsecret);
        }else if($store_type == 3){
            //支付宝小程序
            $url = $url_;
            $qrcode_path = $this->get_qrcode2($store_id,$url,$query_param, 'images/product_share_img',5);

            $qrcode_path = $this->upimg($qrcode_path,200);
        }else{
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            if (!empty($r[0]->H5_domain)) {
                $url = $r[0]->H5_domain.$url;
            }
            //生成二维码
            $qrcode_path = $this->get_qrcode1($url, 'images/product_share_img',$pic_size);
        }

        $user_name = $user_res[0]->user_name;
        $head_img_url = $user_res[0]->headimgurl."?x-oss-process=image/resize,m_fixed,h_50,w_50/circle,r_100/format,png";

        //合成图片

        // 底图
        $path_1 = 'images/product_share_img/bg.jpg';
        // 二维码
        $path_2 = $qrcode_path;
        $path_2 = $this->upimg($path_2,150);
        //用户头像
        $head_img = $this->downImgUrl($head_img_url);//下载用户头像
        $head_img = $this->upimg($head_img,50);

        // 商品图
        $path_4 = ServerPath::getimgpath($c_res[0]->imgurl);//获取图片地址
        $goods_img = $this->downImgUrl($path_4);//下载商品图片
        $goods_img_rand = rand(100000,999999);

        $goods_img_obj = \think\Image::open($goods_img);
        $goods_img1 = "images/product_share_img/goods_img_$goods_img_rand.jpg";
        list($width, $height)=getimagesize($goods_img);
        if($width>=$height){
            $goods_img_nw = 550/$height*$width;
            $goods_img_nh = 550;
        }else{
            $goods_img_nh = 550/$width*$height;
            $goods_img_nw = 550;
        }

        $goods_img_obj
            ->thumb($goods_img_nw,$goods_img_nh,\think\Image::THUMB_FIXED)
            ->save($goods_img1,'jpg');
        unlink($goods_img);
        $goods_img = $goods_img1;
        list($width, $height)=getimagesize($goods_img);

        //查询logo
        $sel_log_sql = "select logo from lkt_config where store_id = $store_id";
        $log_res = $db->select($sel_log_sql);

        $image = \think\Image::open($path_1);
        //字体
        $font2 = 'images/product_share_img/PINGFANG MEDIUM.TTF';//字体,字体文件需保存到相应文件夹下
        $font1 = 'images/product_share_img/PINGFANG BOLD.TTF';//字体,字体文件需保存到相应文件夹下
        $goods_local = array(0,0);
        $qrcode_local = array(360,620);
        $logo_local = array(360,620);
        $priceStr_local = array(50,814);
        $text1_local = array(362,814);
        $text2_local = array(180,915);
        $text3_local = array(190,945);
        $text4_local = array(100,600);
        $red = "#ff0000";
        $hui = "#999999";
        $black = "#000000";

        $versin = 2;//版本号

        //判断是否为分销产品
        if($isfx){
            $share_img_name = time().$proId.$versin.'_share.jpg';
        }else{
            $share_img_name = time().$proId.$versin.'_share.jpg';
        }

        $share_img_path = 'images/product_share_img/'.$share_img_name;
        $image
            ->water($goods_img,$goods_local)//商品图片
            ->water($path_2,$qrcode_local)//二维码
            ->water($head_img,array(30,580))//头像
            ->text($priceStr,$font1,26,$red,$priceStr_local)
            ->text("扫描二维码查看",$font2,17,$hui,$text1_local)
            ->text("来客推提供技术支持",$font1,15,$hui,$text2_local)
            ->text("www.laiketui.com",$font2,15,$hui,$text3_local)
            ->text($user_name."  分享",$font2,18,$black,$text4_local);

        //log
        if(!empty($log_res)){
            $logg = ServerPath::getimgpath($log_res[0]->logo,$store_id);
            $loggg = $this->downImgUrl($logg);
            $log_type = $this->getImageType_text($loggg);
            $logo_name = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".$log_type";
            $logo_img = \think\Image::open($loggg);
            $logo_img->thumb(80,80,\think\Image::THUMB_FIXED)->save($logo_name);
            $image->water($logo_name,array(24,24));//logo
            unlink($logo_name);
        }

        $str_arr = $this->autoLineSplit($product_title,$font2,20,'utf8',300);
        $font_y = 610;
        $time = 0;
        for ($i = 0; $i<count($str_arr); $i++){
            $font_y = $font_y+40;
            $image->text($str_arr[$time],$font2,20,$black,array(30,$font_y));
            $time++;
        }
        $image->save($share_img_path,'jpg');

        unlink($qrcode_path);
        unlink($goods_img);
        unlink($head_img);
        echo json_encode(array('code' => 200 ,'imgUrl' => $share_img_path));
        exit;
    }

    /**
     *
     * @param $picname
     * @return resource|null
     */
    function getImageType($picname){
        $ename=getimagesize($picname);
        $ename=explode('/',$ename['mime']);
        $ext=$ename[1];
        $image = null;
        switch($ext){
            case "png":
                $image=imagecreatefrompng($picname);
                break;
            case "jpeg":
                $image=imagecreatefromjpeg($picname);
                break;
            case "jpg":
                $image=imagecreatefromjpeg($picname);
                break;
            case "gif":
                $image=imagecreatefromgif($picname);
                break;
        }
        return $image;
    }

    /**
     *
     * @param $picname
     * @return resource|null
     */
    function getImageType_text($picname){
        $ename=getimagesize($picname);
        $ename=explode('/',$ename['mime']);
        $ext=$ename[1];
        $image = null;
        return $ext;
    }


    /**
     * 字符串换行
     * @param $str
     * @param $fontFamily
     * @param $fontSize
     * @param $charset
     * @param $width
     * @return array
     */
    function autoLineSplit ($str, $fontFamily, $fontSize, $charset, $width) {
        $result = array();

        $len = (strlen($str) + mb_strlen($str, $charset)) / 2;
//        echo $len; exit;
        // 计算总占宽
        $dimensions = imagettfbbox($fontSize, 0, $fontFamily, $str);
        $textWidth = abs($dimensions[4] - $dimensions[0]);

        // 计算每个字符的长度
        $singleW = $textWidth / $len;
        // 计算每行最多容纳多少个字符
        $maxCount = floor($width / $singleW);

        while ($len > $maxCount) {
            // 成功取得一行
            $result[] = mb_strimwidth($str, 0, $maxCount, '', $charset);
            // 移除上一行的字符
            $str = str_replace($result[count($result) - 1], '', $str);
            // 重新计算长度
            $len = (strlen($str) + mb_strlen($str, $charset)) / 2;
        }
        // 最后一行在循环结束时执行
        $result[] = $str;

        return $result;
    }

    /**
     * 下载网络图片
     * @param $imgurl
     * @return string
     */
    function downImgUrl($imgurl) {

        // 获取头像
        $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".png";

        //合成头像
        $ch = curl_init($imgurl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, '');
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);   //只需要设置一个秒的数量就可以
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $img = curl_exec($ch);
        curl_close($ch);
        file_put_contents($imgPath, $img);
        return $imgPath;
    }

    function base64EncodeImage($image_file)
    {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    // 获得二维码，并储存到本地
    public function get_qrcode1($url, $uploadImg, $size = 5)
    {
        $qrcode_name = md5(time() . rand(1000, 9999));
        $value = str_replace("&amp;","&",$url);                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg . '/' . $qrcode_name . '.png';

        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        return $filename;
    }

    // 获得二维码，并储存到本地
    public function get_qrcode2($store_id,$url,$query_param, $uploadImg, $size = 5)
    {
        $appid = $this->config_data->appid;
        $data['$store_id'] = $store_id;
        $data['$url'] = $url;
        $data['$query_param'] = $query_param;
        $data['$uploadImg'] = $uploadImg;
//        echo  json_encode($data);exit;
        $code_url = TestImage::getcode($url,$query_param, $uploadImg,$store_id,'分销推广二维码');

        $img = $this->downImgUrl($code_url.'jpg');

        return $img;
    }


}
?>