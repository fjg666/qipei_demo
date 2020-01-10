<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 * @author 周文
 * @date 2018年12月10日
 * @version 2.0
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');
//require_once('/webapp/modules/app/actions/getcodeAction.class.php');
require_once('Apimiddle.class.php');

class bargainAction extends Apimiddle
{

    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
    }

    /**
     * 分配方法
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));

        if ($m == 'getgoodsdetail') {
            $this->getgoodsdetail();
        } else if ($m == 'payfor') {
            $this->payfor();
        } else if ($m == 'cangroup') {
            $this->can_group();
        } else if ($m == 'canOrder') {
            $this->can_order();
        } else if ($m == 'Send_open') {
            $this->Send_open();
        } else if ($m == 'Send_can') {
            $this->Send_can();
        } else if ($m == 'getFormid') {
            $this->getformid();
        } else if ($m == 'orderMember') {
            $this->ordermember();
        } else if ($m == 'orderDetail') {
            $this->orderdetail();
        } else if ($m == 'confirmReceipt') {
            $this->confirmreceipt();
        } else if ($m == 'getcomment') {
            $this->getcomment();
        } else if ($m == 'morepro') {
            $this->morepro();
        } else if ($m == 'bargainhome') {
            $this->bargainhome();
        } else if ($m == 'isgrouppacked') {
            $this->isgrouppacked();
        } else if ($m == 'up_out_trade_no') {
            $this->up_out_trade_no();
        } else if ($m == 'verification') {
            $this->verification();
        } else if ($m == 'removeOrder') {
            $this->removeOrder();
        } else if ($m == 'mybargain') {
            $this->mybargain();
        } else if ($m == 'helpbargain') {
            $this->helpbargain();
        } else if ($m == 'settlement') {
            $this->Settlement();
        } else if ($m == 'createbargain') {
            $this->createbargain();
        } else if ($m == 'shareimg') {
            $this->shareimg();
        } else if ($m == 'createOrder') {
            $this->createOrder();
        } else if ($m == 'getRule') {
            $this->getRule();
        }

        return;
    }

    public function shareimg()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = trim($request->getParameter('store_id'));
        $proId = trim($request->getParameter('proId'));
        $attr_id = trim($request->getParameter('attr_id'));
        $order_no = trim($request->getParameter('order_no'));
        $brStatus = trim($request->getParameter('brStatus'));

        $sql = "SELECT attr_id,goods_id from lkt_bargain_order where order_no = '$order_no'";
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
        $url = "http://xiaochengxu.laiketui.com/V2.4/H5/#/pagesA/bargain/bargainIng?proId=$proId&attr_id=$attr_id&order_no=$order_no&brStatus=$brStatus&friend=true";
        //生成二维码
        $qrcode_path = $this->get_qrcode($url, 'images',4);

        $base64img = $this->base64EncodeImage($qrcode_path);
        $base64img = str_replace("\r\n", "", $base64img);

        echo json_encode(array("code" => 200, "img" => $base64img));exit;

        //合成图片

        //案例二：将活动背景图片设置透明，然后和动态二维码图片合成一张图片
// 图片一
        $path_1 = 'images/kjbg.png';
// 图片二
        $path_2 = $qrcode_path;
// 图片三 商品图片
        $path_4 = 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/'.$c_res[0]->imgurl;
        $goods_img = $this->downImgUrl($path_4);
//创建图片对象
        $image_1 = imagecreatefrompng($path_1);
        $image_2 = imagecreatefrompng($path_2);
        $image_4 = imagecreatefrompng($goods_img);
//创建真彩画布
//imagecreatetruecolor(int $width, int $height)--新建一个真彩色图像
        $image_3 = imageCreatetruecolor(imagesx($image_1),imagesy($image_1));
//为真彩画布创建白色背景
//imagecolorallocate(resource $image, int $red, int $green, int $blue)
        $color = imagecolorallocate($image_3, 255, 255, 255);
//imagefill(resource $image ,int $x ,int $y ,int $color)
//在 image 图像的坐标 x，y（图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）
        imagefill($image_3, 0, 0, $color);
//设置透明
//imagecolortransparent(resource $image [,int $color])
//将image图像中的透明色设定为 color
        imageColorTransparent($image_3, $color);
//复制图片一到真彩画布中（重新取样-获取透明图片）
//imagecopyresampled(resource $dst_image ,resource $src_image ,int $dst_x ,int $dst_y ,int $src_x , int $src_y ,int $dst_w ,int $dst_h ,int $src_w ,int $src_h)
// dst_image:目标图象连接资源
// src_image:源图象连接资源
// dst_x:目标 X 坐标点
// dst_y:目标 Y 坐标点
// src_x:源的 X 坐标点
// src_y:源的 Y 坐标点
// dst_w:目标宽度
// dst_h:目标高度
// src_w:源图象的宽度
// src_h:源图象的高度
        imagecopyresampled($image_3, $image_1, 0, 0, 0, 0, imagesx($image_1), imagesy($image_1), imagesx($image_1), imagesy($image_1));
//与图片二合成
//imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )---拷贝并合并图像的一部分
// //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
        imagecopymerge($image_3, $image_2, 50, 980, 0, 0, imagesx($image_2), imagesy($image_2), 100);
// 输出合成图片
        // //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
        imagecopymerge($image_3, $image_2, 50, 980, 0, 0, imagesx($image_2), imagesy($image_2), 100);
// 输出合成图片
        // //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
        imagecopymerge($image_3, $image_4, 50, 280, 0, 0, imagesx($image_4), imagesx($image_4), 100);
// 输出合成图片
        unlink($qrcode_path);
        unlink($goods_img);
        var_dump(imagepng($image_3,'./merge2.png'));exit;

        $base64img = $this->base64EncodeImage($qrcode_path);
        $base64img = str_replace("\r\n", "", $base64img);


        echo json_encode(array("code" => 200, "img" => $base64img));
    }

    function resize_image($filename, $tmpname, $xmax, $ymax)
    {
        $ext = explode(".", $filename);
        $ext = $ext[count($ext)-1];

        if($ext == "jpg" || $ext == "jpeg")
            $im = imagecreatefromjpeg($tmpname);
        elseif($ext == "png")
            $im = imagecreatefrompng($tmpname);
        elseif($ext == "gif")
            $im = imagecreatefromgif($tmpname);

        $x = imagesx($im);
        $y = imagesy($im);

        if($x <= $xmax && $y <= $ymax)
            return $im;

        if($x >= $y) {
            $newx = $xmax;
            $newy = $newx * $y / $x;
        }
        else {
            $newy = $ymax;
            $newx = $x / $y * $newy;
        }

        $im2 = imagecreatetruecolor($newx, $newy);
        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);
        return $im2;
    }

    /**
     * 下载网络图片
     * @param $imgurl
     * @return string
     */
    function downImgUrl($imgurl) {
        // 获取头像
        $imgPath = "./" . uniqid() . mt_rand(1, 200) . ".png";

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
    public function get_qrcode($url, $uploadImg, $size = 5)
    {
        $qrcode_name = md5(time() . rand(1000, 9999));
        $qrcode_name = 1;
        $value = $url;                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg . '/' . $qrcode_name . '.png';

        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        return $filename;
    }

    /**
     * 砍价商品列表
     */
    public function bargainhome()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));//商城id
        $paegr = trim($request->getParameter('page')); //  '页面'
        $userid = trim($request->getParameter('userid')); //  'userid'
        $select = trim($request->getParameter('select')); //  选中的方式 0 热门  1我的砍价
        $access_id = trim($request->getParameter('access_id')); //  access_id
        //搜索模式替换，0 默认搜索，1 销售搜索，2 价格搜索
        if ($select == 0) {
            $select = 'p.id';
        } elseif ($select == 1) {
            $select = 's.sum';
        } else {
            $select = 'p.group_price';
        }
        //排序搜索
//        $sort = trim($request->getParameter('sort')); // 排序方式  1 asc 升序   0 desc 降序
        $sort = 'asc';

        if ($sort) {
            $sort = ' asc ';
        } else {
            $sort = ' desc ';
        }
        //如果没有传入page 默认传入第一页
        if (!$paegr) {
            $paegr = 1;
        }
        //搜索条数
        $start = ($paegr - 1) * 10;
        $end = $paegr * 10;
        $time = date("Y-m-d H:i:s", time());

        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id' and access_id != ''";
        $userInfo = $db->select($sql);
        if ($access_id == '' || !$userInfo) {
            $sql = "SELECT min(b.id) as bargain_id,b.*,c.* 
                    FROM lkt_bargain_goods as b 
                    LEFT JOIN lkt_configure as c ON b.attr_id = c.id 
                    WHERE store_id = '$store_id'  AND b.id AND '$time' < b.end_time  AND is_show = 1 and 
                    EXISTS( SELECT * 
                    FROM lkt_product_list AS l 
                    where l.id = b.goods_id AND store_id = '$store_id' AND `status` = '0') 
                    group by b.goods_id limit $start,$end";
        } else {
            $userid = 'user_' . $userInfo[0]->id;

            //查询所有砍价商品
            $sql = "SELECT min(b.id) as bargain_id,b.*,c.* 
                    FROM lkt_bargain_goods as b 
                    LEFT JOIN lkt_configure as c ON b.attr_id = c.id 
                    WHERE store_id = '$store_id'  AND b.id  AND '$time' < b.end_time  AND is_show = 1 and 
                    EXISTS( SELECT * 
                    FROM lkt_product_list AS l 
                    where l.id = b.goods_id AND store_id = '$store_id' AND `status` = '0') 
                    group by b.goods_id limit $start,$end";
        }
        $res = $db->select($sql);
        //如果有砍价商品，操纵数据
//            echo $sql;exit;

        if ($res) {
            if ($userInfo) {
                foreach ($res as $k => $v) {
                    $sql = "SELECT order_no 
                            from lkt_bargain_order 
                            where user_id = '$userid' and attr_id = $v->attr_id and store_id = $store_id and goods_id = '$v->goods_id'";
                    $order_res = $db->select($sql);
                    if ($order_res) {
                        $res[$k]->order_no = $order_res[0]->order_no;
                    }
                }
            }
            foreach ($res as $k => $v) {
                $sql = "SELECT product_title from lkt_product_list where id = " . $v->goods_id;
                $pro_res = $db->select($sql);
                $res[$k]->title = $pro_res[0]->product_title;
                $res[$k]->img = ServerPath::getimgpath($v->img);
                $lefttime = $res[$k]->leftTime = strtotime($v->end_time) - time();//计算活动剩余时间秒数
                $res[$k]->day = $res[$k]->hour = $res[$k]->mniuate = $res[$k]->second = '00';
                $day = $res[$k]->day = floor($lefttime / (3600 * 24));
                $hour = $res[$k]->hour = floor(($lefttime % (3600 * 24)) / 3600);
                $mniuate = $res[$k]->mniuate = floor(($lefttime % 3600) / 60);
                $second = $res[$k]->second = floor(($lefttime % 3600) % 60);
                $_status = $res[$k]->status;
                $res[$k]->status = 4;
                $sql = "select * 
                        from lkt_bargain_order 
                        where store_id = $store_id and goods_id = $v->goods_id and attr_id = $v->attr_id and user_id = '$userid'
                        ORDER BY id DESC
                        LIMIT 0,1";
                $jx_res = $db->select($sql);
                //判断活动是否开始
                $v->isbegin = 1;
                if (strtotime($v->begin_time) > time()) {
                    $v->isbegin = 0;
                    $lefttime = $res[$k]->leftTime = strtotime($v->begin_time) - time();//计算活动剩余时间秒数
                    $day = $res[$k]->day = floor($lefttime / (3600 * 24));
                    $hour = $res[$k]->hour = floor(($lefttime % (3600 * 24)) / 3600);
                    $mniuate = $res[$k]->mniuate = floor(($lefttime % 3600) / 60);
                    $second = $res[$k]->second = floor(($lefttime % 3600) % 60);
                }
                if ($userInfo) {
                    $res[$k]->userInfo = 1;
                    if ($jx_res) {
                        $res[$k]->astatus = $jx_res[0]->status;
                        $res[$k]->jx_res = 1;
                        if ($jx_res[0]->status == 2) {
                            //砍价完成已支付
                            $res[$k]->status = 2;
                        } else if ($res[$k]->leftTime < 0) {
                            //砍价失败
                            $res[$k]->status = 3;
                        } else if ($jx_res[0]->original_price == 0) {
                            //砍价完成，代付款

                            $sql = "SELECT id from lkt_order where status != '6' and status != '7' and status != '8' and  p_sNo = '$v->order_no'";
                            $ishas = $db->select($sql);
                            $res[$k]->hasorder = 0;
                            if ($ishas) {
                                $res[$k]->hasorder = 1;
                                $res[$k]->sNo_id = $ishas[0]->id;
                            }

                            $res[$k]->status = 1;

                        } else if ($jx_res[0]->original_price > 0 && $res[$k]->leftTime > 0) {
                            //开始砍价
                            $res[$k]->status = 0;
                        }
                    }
                }
                unset($res[$k]->id);
                unset($res[$k]->is_delete);
                unset($res[$k]->id);
                unset($res[$k]->begin_time);
                unset($res[$k]->end_time);

            }

//            echo json_encode(array('code' => 1, 'list' => $res, 'groupman' => $g_man, 'groupid' => $gid,'groupname' => $groupname));
            echo json_encode(array('code' => 200, 'list' => $res, 'img' => 'http://xiaochengxu.laiketui.com/V2.2.1/images/brHeadImg.png'));
            exit;
        } else {

            echo json_encode(array('code' => 200, 'list' => $res, 'img' => 'http://xiaochengxu.laiketui.com/V2.2.1/images/brHeadImg.png'));
            exit;
        }
    }

    public function getRule()
    {
        $db = DBAction::getInstance();
        $sql = 'SELECT rule FROM lkt_bargain_config where 1';
        $ruleRes = $db->select($sql);
        if ($ruleRes) {
            $rule = $ruleRes[0]->rule;
            echo json_encode(array('code' => 200, 'rule' => $rule));
        } else {
            echo json_encode(array('code' => 404, 'message' => '暂无设置规则'));
        }
    }

    /**
     * 我的砍价商品
     */
    public function mybargain()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $page = $request->getParameter('page');
        $userid = addslashes(trim($request->getParameter('userid')));
        $access_id = $request->getParameter('access_id');

        $white = [];
        //查询 我的砍价商品
        $total = ($page - 1) * 999;
        $sql = "select m.*,p.product_title,p.imgurl from (select o.*,c.* from lkt_bargain_order as o left join lkt_bargain_goods as c on o.attr_id=c.attr_id) as m left join lkt_product_list as p on m.goods_id=p.id where o.store_id = '$store_id' and o.user_id='$userid' limit $total,8";

        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id'";
        $userInfo = $db->select($sql);
        if (!$userInfo || $access_id == '') {
            echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！！', 'list' => $white));
            exit;
        }
        $userid = 'user_' . $userInfo[0]->id;

        //根据userid查询出该用户下的订单获取 attr_id goods_id
//        $sql = "SELECT * from lkt_bargain_order where user_id = '$userid' AND is_delete = 0 limit $total,8";
        $sql = "SELECT * 
                from lkt_bargain_order as o 
                LEFT JOIN lkt_bargain_goods as g on g.attr_id = o.attr_id and g.goods_id = o.goods_id 
                where user_id = '$userid' AND o.is_delete = 0 AND g.is_show = 1 limit $total,8";
        $res = $db->select($sql);

        $jixuArr = [];
        $fukuanArr = [];
        $shibaiArr = [];
        $wanchengArr = [];
        $jixuindex = $fukuanindex = $shibaiindex = $wanchengindex = 0;
        //查询是否存才已经砍过价的商品
        if (!empty($res)) {
            //如果有循环遍历数据  返回结果
            foreach ($res as $k => $v) {
                //商品表
                $sql = "SELECT * from lkt_product_list where id = " . $v->goods_id;
                $goodsRes = $db->select($sql);
                //属性表
                $sql = "SELECT * from lkt_configure where id = " . $v->attr_id;
                $attrRes = $db->select($sql);
                //砍价商品表
                $sql = "SELECT * from lkt_bargain_goods where attr_id = " . $v->attr_id . " and goods_id = " . $v->goods_id . " and store_id = " . $store_id;
                $barGRes = $db->select($sql);
                $v->title = $goodsRes[0]->product_title;

                $res[$k]->bargain_id = $barGRes[0]->id;
                $res[$k]->leftTime = strtotime($barGRes[0]->end_time) - time();
                $res[$k]->img = ServerPath::getimgpath($attrRes[0]->img);


                //计算一共砍了多少钱了
                $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$v->order_no' and store_id = $store_id";
                $sum = $db->select($sql);
                $res[$k]->price = $attrRes[0]->price;
                $res[$k]->success_money = $sum[0]->money;//算到小数点后两位

                //初始化时间
                $res[$k]->hour = "00";
                $res[$k]->mniuate = "00";
                $res[$k]->second = "00";
                $res[$k]->isbegin =  1;
                if ($res[$k]->status == 2) {
                    $fukuanArr[$fukuanindex] = $res[$k];
                    $fukuanindex++;
                } else if ($res[$k]->leftTime < 0) {
                    //失败
                    $res[$k]->status = 3;
                    $shibaiArr[$shibaiindex] = $res[$k];
                    $shibaiindex++;
                } else if ($res[$k]->original_price == 0) {
                    //已完成，待付款
                    $bargain_id = $barGRes[0]->id;
                    $sql = "SELECT id from lkt_order where status != '6' and status != '7' and status != '8' and bargain_id = '$bargain_id' and  p_sNo = '$v->order_no'";
                    $ishas = $db->select($sql);
                    $res[$k]->hasorder = 0;
//                    echo $sql;exit;
                    if ($ishas) {
                        $res[$k]->hasorder = 1;
                        $res[$k]->sNo_id = $ishas[0]->id;
                    }
                    $buytime = $barGRes[0]->buytime;
                    $jutime = $buytime * 60 * 60;//购买时限（秒）
                    $wctime = $v->achievetime;
                    $chatime = time() - $wctime;
                    $res[$k]->status = 1;

                    if ($chatime > $jutime) {
                        $res[$k]->status = 3;
                        $res[$k]->timeout = 1;
                    }
                    $wanchengArr[$wanchengindex] = $res[$k];
                    $wanchengindex++;
                } else {
                    $res[$k]->status = 0;
                    $jixuArr[$jixuindex] = $res[$k];
                    $jixuindex++;
                }
            }
            $new_res = array_merge($jixuArr, $wanchengArr);
            $new_res = array_merge($new_res, $fukuanArr);
            $new_res = array_merge($new_res, $shibaiArr);
            echo json_encode(array('code' => 200, 'list' => $new_res, 'img' => 'http://xiaochengxu.laiketui.com/V2.2.1/images/brHeadImg.png'));
            exit;
        } else {
            $withe = [];
            //如果没有返回结果
            echo json_encode(array('code' => 200, 'list' => $withe, 'img' => 'http://xiaochengxu.laiketui.com/V2.2.1/images/brHeadImg.png'));
            exit;
        }
    }

    /**
     * 获取砍价商品详情
     * 需要帮忙砍价记录
     */
    public function getgoodsdetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $attr_id = trim($request->getParameter('attr_id'));
        $user_id = trim($request->getParameter('user_id'));
        $oid = trim($request->getParameter('order_no'));
        $access_id = trim($request->getParameter('access_id'));
        $ishelp_ = trim($request->getParameter('isHelp'));
        $sql = "SELECT * from lkt_bargain_order WHERE order_no = '$oid'";
        $orderRes = $db->select($sql);
        $list = [];
        $code = 200;
        if ($orderRes) {
            //商品表
            $sql = "SELECT * from lkt_product_list where id = " . $orderRes[0]->goods_id;
            $goodsRes = $db->select($sql);
            //属性表
            $sql = "SELECT * from lkt_configure where id = " . $orderRes[0]->attr_id;
            $attrRes = $db->select($sql);
            //砍价商品表
            $sql = "SELECT * from lkt_bargain_goods where attr_id = " . $orderRes[0]->attr_id . " and goods_id = " . $orderRes[0]->goods_id . " and store_id = " . $store_id;
            $barGRes = $db->select($sql);
            $bargain_id = $barGRes[0]->id;
            $sql = "SELECT id from lkt_order where status != '6' and status != '7' and status != '8' and bargain_id = '$bargain_id' and  p_sNo = '$oid'";
//            echo $sql;exit;
            $ishas = $db->select($sql);
            $orderRes[0]->hasorder = 0;
            if ($ishas) {
                $orderRes[0]->hasorder = 1;
                $orderRes[0]->sNo_id = $ishas[0]->id;
            }

            $orderRes[0]->bargain_id = $barGRes[0]->id;
            $orderRes[0]->title = $goodsRes[0]->product_title;
            $orderRes[0]->title = $goodsRes[0]->product_title;
            $orderRes[0]->img = ServerPath::getimgpath($attrRes[0]->img);
            $orderRes[0]->leftTime = strtotime($barGRes[0]->end_time) - time();
            $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$oid' and store_id = $store_id";
            $sum = $db->select($sql);


            $orderRes[0]->price = $attrRes[0]->price;
            $orderRes[0]->free_money = $orderRes[0]->price - $orderRes[0]->min_price;
            $orderRes[0]->free_money = sprintf("%.2f", $orderRes[0]->free_money);//算到小数点后两位
            $orderRes[0]->success_money = sprintf("%.2f", $sum[0]->money);//算到小数点后两位
            //初始化时分秒
            $orderRes[0]->hour = "00";
            $orderRes[0]->mniuate = "00";
            $orderRes[0]->second = "00";
            $list = $orderRes[0];
            $code = 200;
        }

        //查询帮砍好友
        $sql = "SELECT user_id from lkt_bargain_record where order_no = '$oid'  AND store_id = 1";
        $helpRes = $db->select($sql);
        $help_list = [];
        foreach ($helpRes as $k => $v) {
            $userArr = explode("_", $v->user_id);
            $_userid = $userArr[0] . $userArr[1];
            $sql = "SELECT user_name,headimgurl from lkt_user where user_id = '$_userid'";
            $frdInfo1 = $db->select($sql);
            $sql = "SELECT money from lkt_bargain_record WHERE order_no = '$oid' and user_id ='$v->user_id'";
            $frdInfo2 = $db->select($sql);
            $help_list[$k]['user_name'] = $frdInfo1[0]->user_name;
            $help_list[$k]['bargain_money'] = $frdInfo2[0]->money;
            $help_list[$k]['headimgurl'] = $frdInfo1[0]->headimgurl;
        }
        $loseEfficacy = false;
        $loseEfficacyImg = 'http://xiaochengxu.laiketui.com/V2.4/images/icon1/loseEfficacy@2x.png';
        $celebrate = 'http://xiaochengxu.laiketui.com/V2.4/images/icon1/celebrate.png';
        $is_show = $barGRes[0]->is_show;
        if ($is_show == 0) {
            $loseEfficacy = true;
        }

        if ($ishelp_ == 1) {
            $selSql = "SELECT user_name,headimgurl from lkt_user where access_id = '$access_id'";
            $userRes = $db->select($selSql);
            if ($access_id == '' || !$userRes) {
                $white = [];
                echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！！', 'loseEfficacy' => $loseEfficacy, 'loseEfficacyImg' => $loseEfficacyImg, 'list' => $list, 'help_list' => $help_list));
                exit;
            }
            $selfRes = [];
            $selfRes['user_name'] = $userRes[0]->user_name;
            $selfRes['headimgurl'] = $userRes[0]->headimgurl;
            echo json_encode(array('code' => $code, 'self' => $selfRes, 'list' => $list, 'help_list' => $help_list, 'loseEfficacy' => $loseEfficacy, 'loseEfficacyImg' => $loseEfficacyImg, 'celebrate' => $celebrate));
            exit;
        }
        echo json_encode(array('code' => $code, 'list' => $list, 'help_list' => $help_list, 'loseEfficacy' => $loseEfficacy, 'loseEfficacyImg' => $loseEfficacyImg, 'celebrate' => $celebrate));

        exit;
        $commodityAttr = [];
        $sql_size = "select b.*,c.* from lkt_bargain_goods as b left join lkt_configure as c on b.attr_id=c.id where b.store_id = '$store_id' and attr_id = $attr_id";
        $r_size = $db->select($sql_size);
        $skuBeanList = [];
        $attrList = [];
        //如果有查询结果
        if ($r_size) {
            $attr = [];

            foreach ($r_size as $key => $value) {
                $attribute = unserialize($value->attribute);
                $attributes = [];
                $name = '';
                foreach ($attribute as $k => $v) {
                    $attrList[] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => [], 'all' => []);
                    $attributes[] = array('attributeId' => md5($k), 'attributeValId' => md5($v));
                    $name .= $v;
                }

                $cimgurl = ServerPath::getimgpath($value->img);

                $skuBeanList[$key] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $value->id, 'min_price' => $value->min_price, 'count' => $value->num, 'attributes' => $attributes);

                for ($i = 0; $i < count($attrList); $i++) {
                    $attr = $attrList[$i]['attr'];
                    $all = $attrList[$i]['all'];
                    foreach ($attribute as $k => $v) {
                        if ($attrList[$i]['attrName'] == $k) {
                            $attr_array = array('attributeId' => md5($k), 'id' => md5($v), 'attributeValue' => $v, 'enable' => false, 'select' => false);

                            if (empty($attr)) {
                                array_push($attr, $attr_array);
                                array_push($all, $v);
                            } else {
                                if (!in_array($v, $all)) {
                                    array_push($attr, $attr_array);
                                    array_push($all, $v);
                                }
                            }

                        }
                    }
                    $attrList[$i]['all'] = $all;
                    $attrList[$i]['attr'] = $attr;
                }

            }
            $ishelp = 0;
            //查询给商品砍过价的好友
            $sql = "SELECT user_id,money FROM lkt_bargain_record where store_id = $store_id AND order_no = '$oid'";
            $helpRes = $db->select($sql);
            if ($helpRes) {
                //有好友帮忙砍价
                $ishelp = 1;
//                foreach ($helpRes as $k => $v){
//
//                }
                $helpList = $helpRes;
            } else {
                //没有好友帮忙砍价
                $helpList = [];

            }
        }

        //查询帮砍好友
        $selSql = "SELECT user_name,headimgurl from lkt_user where access_id = '$access_id'";
        $userRes = $db->select($selSql);
        $help_list = [];
        $help_list[0]['user_name'] = $userRes[0]->user_name;
        $help_list[0]['bargain_money'] = $kan;
        $help_list[0]['headimgurl'] = $userRes[0]->headimgurl;
        //如果不是好友砍价 返回结果
        echo $ishelp_;
        exit;

        if ($ishelp_ == 1) {

            echo json_encode(array('list' => $attrList, 'help_list' => $help_list, 'skuBeanList' => $skuBeanList, 'ishelp' => $ishelp));
            exit;

        }

        $selSql = "SELECT user_name,headimgurl from lkt_user where access_id = '$access_id'";
        $userRes = $db->select($selSql);
        $selfRes = [];
        $selfRes['user_name'] = $userRes[0]->user_name;
        $selfRes['bargain_money'] = $kan;
        $selfRes['headimgurl'] = $userRes[0]->headimgurl;
        echo json_encode(array('list' => $attrList, 'self' => $selfRes, 'help_list' => $help_list, 'skuBeanList' => $skuBeanList, 'ishelp' => $ishelp));
        exit;
    }

    /**
     * 创建一条砍价商品订单
     */
    public function createbargain()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $goods_id = $request->getParameter('goods_id');
        $attr_id = $request->getParameter('attr_id');
        $access_id = $request->getParameter('access_id');

//        $getPayload_test = Tools::verifyToken($access_id); //对token进行验证签名,如果过期返回false,成功返回数组
//        if($getPayload_test == false){ // 过期
//            echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！'));
//            exit;
//        }

        $white = [];
        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id'";
        $userInfo = $db->select($sql);
        if (!$userInfo || $access_id == '') {
            $message = "未登录，请先登陆！";
            if (!$userInfo) {
                $message = "未登录，请先登陆！,access_id过期";
            } elseif ($access_id == '') {
                $message = "未登录，请先登陆！,access_id为空";
            }
            echo json_encode(array('code' => 404, 'message' => $message, 'list' => $white));
            exit;
        }

        //查询商品价格
        $selSql = "SELECT price FROM lkt_configure where id = $attr_id";
        $selRes = $db->select($selSql);
        $price = $selRes[0]->price;
        //查询订单商品状态参数
        $selSql = "SELECT id,status_data,man_num,min_price FROM `lkt_bargain_goods` WHERE store_id = $store_id AND goods_id = $goods_id AND attr_id = $attr_id";
        $statusRes = $db->select($selSql);
        if (!$statusRes) {
            echo json_encode(array('code' => 0));
            exit;
        }
        $status_data = unserialize($statusRes[0]->status_data);
        $min_price = $statusRes[0]->min_price;//最低价
        $man_num = $statusRes[0]->man_num;//参加人数
        $db->begin();
        $time = time();
        //查询物品设置参数

        $sel_goods_sql = "SELECT `status_data`,`man_num`,`min_price` FROM `lkt_bargain_goods` WHERE `goods_id`= '$goods_id' AND store_id = $store_id GROUP BY `goods_id`";
        $status_data = $db->select($sel_goods_sql);//参数data数据

        //生成订单号

        $order_sNo = 'KJ' . substr($time, 5) . mt_rand(10000, 99999);

        $code = 1;

        $status_data = unserialize($status_data[0]->status_data);//参数数组
        //自己砍一刀
        //查出是自己砍的范围
        if ($man_num == 0) {
            //如果没有设置人数
            $kan = rand(($status_data->min_not) * 10, ($status_data->max_not) * 10) / 10;//随机砍价金额
        } else {
            //设置了人数
            $kan = rand(($status_data->min_one) * 10, ($status_data->max_one) * 10) / 10;//随机砍价金额
        }

        $original_price = $price - $kan - $min_price;
        $data = $statusRes[0]->status_data;
        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id'";
        $userInfo = $db->select($sql);

        if ($access_id == "" || !$userInfo) {
            echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！'));
            exit;
        }
        $userid = 'user_' . $userInfo[0]->id;

        $original_price = sprintf("%.2f", $original_price);//算到小数点后两位
        //添加一条砍价订单
        $bargain_id = $statusRes[0]->id;
        $sql = "SELECT * from lkt_bargain_order where store_id = '$store_id' AND user_id = '$userid' and attr_id = '$attr_id' and bargain_id =  '$bargain_id'  and goods_id = '$goods_id'";

        $isin = $db->select($sql);
        if (!$isin) {

            $sql = "insert into lkt_bargain_order(store_id,user_id,order_no,attr_id,goods_id,original_price,min_price,status,addtime,status_data,bargain_id) values('$store_id','$userid','$order_sNo',$attr_id,$goods_id,'$original_price',$min_price,0,'$time','$data','$bargain_id')";
            $ist = $db->insert($sql);

            //如果添加成功
            if (!$ist) {
                $code = 0;
                $db->rollback();
                exit;
            }

            //生成一条砍价记录
            $istSql = "insert into lkt_bargain_record(store_id,order_no,user_id,money,add_time) values('$store_id','$order_sNo','$userid',$kan,$time)";
            $istRes = $db->insert($istSql);
            if ($istRes) {
            } else {
                $code = 0;
                $db->rollback();
                echo json_encode(array('code' => 1, 'message' => '添加砍价记录失败！'));

            }

            //先扣除一个产品库存
            $updsql = "update lkt_configure set num=num-1 where  id='$attr_id'";
            $updres = $db->update($updsql);

            //如果扣除成功
            if ($updres < 1) {
                $code = 0;
                $db->rollback();
                exit;
                $sql = "select num from lkt_configure where id='$attr_id'";
                $res = $db->select($sql);
                echo json_encode(array('code' => 200, 'codestatus' => 500, 'message' => '库存不足！'));
            }

            //计算砍价差多少到最低
            $cha = $price - $min_price - $kan;
        }

        //查询帮砍好友
        $selSql = "SELECT user_name,headimgurl from lkt_user where access_id = '$access_id'";
        $userRes = $db->select($selSql);
        $help_list = [];
        $help_list[0]['user_name'] = $userRes[0]->user_name;
        $help_list[0]['bargain_money'] = $kan;
        $help_list[0]['headimgurl'] = $userRes[0]->headimgurl;


        if ($code == 1) {
            //如果全部执行成功则执行事件 返回结果
            if ($isin) {
                $db->rollback();
            } else {
                $db->commit();
            }
        } else {
            //返回错误
            echo json_encode(array('code' => 0));
            exit;
        }
        if ($isin) {
            $orderRes = $isin;
        } else {
            $sql = "SELECT * from lkt_bargain_order WHERE order_no = '$order_sNo'";
            $orderRes = $db->select($sql);
        }

        $list = [];
        $code = 1;
        if ($orderRes) {
            //商品表
            $sql = "SELECT * from lkt_product_list where id = " . $orderRes[0]->goods_id;
            $goodsRes = $db->select($sql);
            //属性表
            $sql = "SELECT * from lkt_configure where id = " . $orderRes[0]->attr_id;
            $attrRes = $db->select($sql);
            //砍价商品表
            $sql = "SELECT * from lkt_bargain_goods where attr_id = " . $orderRes[0]->attr_id . " and goods_id = " . $orderRes[0]->goods_id . " and store_id = " . $store_id;
            $barGRes = $db->select($sql);
            $orderRes[0]->bargain_id = $barGRes[0]->id;
            $orderRes[0]->title = $goodsRes[0]->product_title;
            $orderRes[0]->title = $goodsRes[0]->product_title;
            $orderRes[0]->img = ServerPath::getimgpath($attrRes[0]->img);
            $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$order_sNo' and store_id = $store_id";
            $sum = $db->select($sql);

            $orderRes[0]->price = $attrRes[0]->price;
            $orderRes[0]->success_money = sprintf("%.2f", $sum[0]->money);//算到小数点后两位
            $orderRes[0]->free_money = $orderRes[0]->price - $orderRes[0]->min_price;
            $orderRes[0]->free_money = sprintf("%.2f", $orderRes[0]->free_money);//算到小数点后两位
            $orderRes[0]->leftTime = strtotime($barGRes[0]->end_time) - time();
            //初始化时分秒
            $orderRes[0]->hour = "00";
            $orderRes[0]->mniuate = "00";
            $orderRes[0]->second = "00";

            $list = $orderRes[0];
            $code = 200;
        }

        $loseEfficacyImg = 'http://xiaochengxu.laiketui.com/V2.4/images/icon1/loseEfficacy@2x.png';
        $celebrate = 'http://xiaochengxu.laiketui.com/V2.4/images/icon1/celebrate.png';
        if ($isin) {
            echo json_encode(array('code' => 200, 'message' => '已经参加了该商品砍价！', 'status' => 500, 'list' => $list, 'order_no' => $order_sNo, 'celebrate' => $celebrate, 'loseEfficacy' => false, 'loseEfficacyImg' => $loseEfficacyImg, 'min_price' => $min_price, 'help_list' => $help_list));
            exit;
        }

        echo json_encode(array('code' => 200, 'list' => $list, 'celebrate' => $celebrate, 'loseEfficacy' => false, 'loseEfficacyImg' => $loseEfficacyImg, 'order_no' => $order_sNo, 'bargain_money' => $kan, 'min_price' => $min_price, 'difference' => $cha, 'help_list' => $help_list));
        exit;

    }


    public function createOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $uid = $this->user_id;

        $pro_id = intval(trim($request->getParameter('pro_id')));
        $man_num = intval(trim($request->getParameter('man_num')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
        $pro_name = addslashes(trim($request->getParameter('ptgoods_name')));
        $price = (float)(trim($request->getParameter('price')));
        $y_price = (float)(trim($request->getParameter('d_price')));
        $name = addslashes(trim($request->getParameter('name')));
        $sheng = intval(trim($request->getParameter('sheng')));
        $shi = intval(trim($request->getParameter('shi')));
        $quyu = intval(trim($request->getParameter('quyu')));
        $address = addslashes(trim($request->getParameter('address')));
        $tel = addslashes(trim($request->getParameter('tel')));
        $buy_num = intval(trim($request->getParameter('num')));
        $paytype = addslashes(trim($request->getParameter('pay_type')));
        $yunfei = (float)(trim($request->getParameter('yunfei')));
        $frompage = addslashes(trim($request->getParameter('frompage')));
        $ptcode = addslashes(trim($request->getParameter('ptcode')));

        $db->begin();
        $creattime = date('Y-m-d H:i:s');

        $pro_size = $db->select("select attribute,num from lkt_configure where id=$sizeid");
        $pro_size = unserialize($pro_size[0]->attribute);
        $pro_size = implode(',', array_values($pro_size));
        $spz_price = $buy_num * $y_price;
        $code = true;
        $ordernum = 'KJ' . mt_rand(10000, 99999) . date('Ymd') . substr(time(), 5);
        $istsql2 = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,spz_price,sNo,sheng,shi,xian,address,pay,add_time,status,otype,ptcode,ptstatus,pid,groupman) values('$store_id','$uid','$name','$tel',$buy_num,$price,$spz_price,'$ordernum',$sheng,$shi,$quyu,'$address','$paytype','$creattime',0,'pt','$ptcode',0,'$frompage','$man_num')";
        $res2 = $db->insert($istsql2, "last_insert_id");
        if ($res2 < 1) {
            $code = false;
        }


        $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid,freight) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',0,'$pro_size',$sizeid,'$yunfei')";
        $res3 = $db->insert($istsql3);
        if ($res3 < 1) {
            $code = false;
        }

        $updres = $db->update("update lkt_configure set num=num-$buy_num where id=$sizeid");
        if ($updres < 1) {
            $code = false;
        }

        if ($code) {
            $db->commit();
            echo json_encode(array('status' => 1, 'order' => $ordernum, 'total' => $price, 'order_id' => $res2));
            exit;
        } else {
            $db->rollback();
            echo json_encode(array('status' => 0));
            exit;
        }

    }


    /**
     * 获取formid
     * @return bool
     */
    public function getformid()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $uid = addslashes(trim($request->getParameter('userid')));
        $formid = addslashes(trim($request->getParameter('from_id')));

        $fromidsql = "select count(*) as have from lkt_user_fromid where store_id = '$store_id' and open_id='$uid'";
        $fromres = $db->select($fromidsql);
        $fromres = intval($fromres[0]->have);
        $lifetime = date('Y-m-d H:i:s', time() + 7 * 24 * 3600);
        if ($formid != 'the formId is a mock one') {
            if ($fromres < 12) {
                $addsql = "insert into lkt_user_fromid(store_id,open_id,fromid,lifetime) values('$store_id','$uid','$formid','$lifetime')";
                $addres = $db->insert($addsql);
            } else {
                return false;
            }
        }

    }

    /**
     * 接收运单号，商城id
     * @return 结果
     */
    public function barginred()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $oid = addslashes(trim($request->getParameter('oid')));

        $sql = "select o.*,c.price,c.img,p.product_title,u.user_name,u.headimgurl from lkt_bargain_order as o left join lkt_configure as c on o.attr_id=c.id left join lkt_configure as c on o.goods_id=c.id left join lkt_user as u on o.user_id=u.user_id where o.store_id = '$store_id' and order_no='$oid' and u.store_id='$store_id'";

        $res = $db->select($sql);

        $redsql = "select r.*,u.headimgurl from lkt_bargain_record as r left join lkt_user as u on r.user_id=u.user_id where r.store_id = '$store_id' and order_no='$oid' and u.store_id='$store_id'";
        $redres = $db->select($redsql);

        echo json_encode(array('res' => $res, 'redres' => $redres));
        exit;

    }

    /**
     * 运费配置
     * @param $freight
     * @param $num
     * @param $address
     * @return float|int
     */
    public function freight($freight, $num, $address)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$freight'";
        $r_1 = $db->select($sql);
        if ($r_1) {
            $rule = $r_1[0];
            $yunfei = 0;
            if (empty($address)) {
                return 0;
            } else {
                $sheng = $address['sheng'];
                $sql2 = "select G_CName from admin_cg_group where GroupID = '$sheng'";
                $r_2 = $db->select($sql2);
                if ($r_2) {
                    $city = $r_2[0]->G_CName;
                    $rule_1 = $r_1[0]->freight;
                    $rule_2 = unserialize($rule_1);

                    foreach ($rule_2 as $key => $value) {
                        $citys_str = $value['name'];
                        $citys_array = explode(',', $citys_str);
                        $citys_arrays = [];
                        foreach ($citys_array as $k => $v) {
                            $citys_arrays[$v] = $v;
                        }
                        if (array_key_exists($city, $citys_arrays)) {
                            if ($num > $value['three']) {
                                $yunfei += $value['two'];
                                $yunfei += ($num - $value['three']) * $value['four'];
                            } else {
                                $yunfei += $value['two'];
                            }
                        }
                    }
                    return $yunfei;
                } else {
                    return 0;
                }
            }
        } else {
            return 0;
        }
    }

    /**
     * 好友帮忙砍价操作
     */
    public function helpbargain()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $oid = $request->getParameter('order_no');
        $userid = $request->getParameter('userid');
        $access_id = $request->getParameter('access_id');
        $time = time();
        $code = 200;    //状态值
        $status = "fail";

        //查询商品数据
        $sql = "SELECT * from lkt_bargain_order WHERE order_no = '$oid'";
        $orderRes = $db->select($sql);
        $list = [];
        $code = 1;
        if ($orderRes) {
            //商品表
            $sql = "SELECT * from lkt_product_list where id = " . $orderRes[0]->goods_id;
            $goodsRes = $db->select($sql);
            //属性表
            $sql = "SELECT * from lkt_configure where id = " . $orderRes[0]->attr_id;
            $attrRes = $db->select($sql);
            //砍价商品表
            $sql = "SELECT * from lkt_bargain_goods where attr_id = " . $orderRes[0]->attr_id . " and goods_id = " . $orderRes[0]->goods_id . " and store_id = " . $store_id;
            $barGRes = $db->select($sql);
            $orderRes[0]->bargain_id = $barGRes[0]->id;
            $orderRes[0]->title = $goodsRes[0]->product_title;
            $orderRes[0]->title = $goodsRes[0]->product_title;
            $orderRes[0]->img = ServerPath::getimgpath($attrRes[0]->img);
            $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$oid' and store_id = $store_id";
            $sum = $db->select($sql);

            $orderRes[0]->price = $attrRes[0]->price;
            $orderRes[0]->free_money = $orderRes[0]->price - $orderRes[0]->min_price;
            $orderRes[0]->free_money = sprintf("%.2f", $orderRes[0]->free_money);//算到小数点后两位
            $orderRes[0]->success_money = sprintf("%.2f", $sum[0]->money);//算到小数点后两位
            $lefttime = $orderRes[0]->leftTime = strtotime($barGRes[0]->end_time) - time();
            //初始化时分秒
            $orderRes[0]->hour = "00";
            $orderRes[0]->mniuate = "00";
            $orderRes[0]->second = "00";
            $hour = $orderRes[0]->hour = $lefttime / 3600;
            $mniuate = $orderRes[0]->mniuate = ($lefttime % 3600) / 60;
            $second = $orderRes[0]->second = ($lefttime % 3600) % 60;

            $list = $orderRes[0];
            $code = 200;
        }


        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id' and user_id != ''";
        $userInfo = $db->select($sql);
        if ($userInfo) {
            $userid = 'user_' . $userInfo[0]->id;
        }
        if (empty($userInfo[0]->id) || !$userInfo || $access_id == '') {
            echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！！'));
            exit;
        }

        //查询帮砍好友
        $sql = "SELECT user_id from lkt_bargain_record where order_no = '$oid'  AND store_id = 1";
        $helpRes = $db->select($sql);
        $help_list = [];
        foreach ($helpRes as $k => $v) {
            $userArr = explode("_", $v->user_id);
            $_userid = $userArr[0] . $userArr[1];
            $sql = "SELECT user_name,headimgurl from lkt_user where user_id = '$_userid'";
            $frdInfo1 = $db->select($sql);
            $sql = "SELECT money from lkt_bargain_record WHERE order_no = '$oid' and user_id ='$v->user_id'";
            $frdInfo2 = $db->select($sql);
            $help_list[$k]['user_name'] = $frdInfo1[0]->user_name;
            $help_list[$k]['bargain_money'] = $frdInfo2[0]->money;
            $help_list[$k]['headimgurl'] = $frdInfo1[0]->headimgurl;
        }

        //查询一条砍价信息
        $sql = "select o.*,g.* from lkt_bargain_order as o left join lkt_bargain_goods as g on o.attr_id=g.attr_id where o.store_id = '$store_id' and o.order_no='$oid'";
        $res = $db->select($sql);
        list($res) = $res;
        //查询此人是否已经对痛一个订单已经砍过价
        $sql = "SELECT id from lkt_bargain_record WHERE order_no = '$oid' AND user_id = '$userid' AND user_id !='user_'";
        $can_nex = $db->select($sql);

        $times = count($can_nex);

        //判断是否参加过砍价
        if ($times >= 1) {
            //参加过，停止接下来的操作
            echo json_encode(array('$sql' => $sql, 'code' => 200, 'status' => $status, 'statusCode' => 500, 'help_list' => $help_list, 'message' => '你已经对改订单进行过砍价了！', 'list' => $list));
            exit;
        }
        //查询已经有多少人参加砍价
        $sel_hel_num_sql = "SELECT COUNT(*) as num FROM lkt_bargain_record WHERE order_no = '$oid' AND store_id = $store_id";
        $hel_num_Res = $db->select($sel_hel_num_sql);
        $hel_num = $hel_num_Res[0]->num;//已经帮忙砍价的好友人数
        $man_num = intval($res->man_num);
        $db->begin();
        $time = time();
        $status_data = unserialize($res->status_data);
        if (isset($status_data->min_not) && isset($status_data->max_not)) {
            //不限制人数
            $minprice = floatval($status_data->min_not);
            $maxprice = floatval($status_data->max_not);
        } else if ($status_data->one_man <= $hel_num) {
            //限制了人数而且已经达到第一批人数
            $minprice = floatval($status_data->min_two);
            $maxprice = floatval($status_data->max_two);
        } else {
            //限制了人数，人数没达到第一批人数
            $minprice = floatval($status_data->min_one);
            $maxprice = floatval($status_data->max_one);
        }

        $original_price = floatval($res->original_price);        //剩余价格
        $min_price = floatval($res->min_price);       //最低价格
        $chaprice = $original_price - $min_price;
        $chaprice = $original_price;
        if ($man_num == 0) {           //没有限制人数

            if ($original_price >= $maxprice) {    //大于最大值的区间取随机数

                $randprice = mt_rand($minprice * 100, $maxprice * 100) / 100;
                $updsql = "update lkt_bargain_order set original_price = original_price - $randprice where store_id = '$store_id' and order_no='$oid'";
                $updres = $db->update($updsql);
                //判断数据是否处理成功
                if ($updres < 1) {
                    $code = 0;
                    $db->rollback();
                    echo json_encode(array('code' => $code, 'statusCode ' => '500', 'message' => '砍价异常！'));
                    exit;
                    exit;
                }

            } else {            //小于最大值的区间取差价,砍价成功

                $randprice = $chaprice;
                $updsql = "update lkt_bargain_order set original_price = original_price - $randprice,status=1 , achievetime = $time where store_id = '$store_id' and order_no='$oid'";
                $updres = $db->update($updsql);
                //判断数据是否处理成功
                if ($updres < 1) {
                    $code = 0;
                    $db->rollback();
                    echo json_encode(array('code' => $code, 'statusCode ' => '500', 'message' => '砍价异常！'));
                    exit;
                    exit;
                } else {
                    $status = "success";
                }

            }

        } else {                 //设置了限制人数
            $redsql = "select count(*) as num from lkt_bargain_record where store_id = '$store_id' and order_no='$oid'";
            $redres = $db->select($redsql);
            $redres = intval($redres[0]->num);     //查询此订单下的砍价记录数
            $oneman = intval($status_data->one_man);   //前多少个人
            if ($redres < $oneman) {    //在第一波人之内
                $minprice = floatval($status_data->min_one);
                $maxprice = floatval($status_data->max_one);
            } else {           //在第二波人之内
                $minprice = floatval($status_data->min_two);
//                $maxprice = floatval($status_data->max_two);
                $maxprice = floatval($res->original_price);
            }
            $man_num = $res->man_num;
            if ($chaprice >= $maxprice && $man_num != $redres) {    //大于最大值的区间取随机数
                $randprice = mt_rand($minprice * 100, $maxprice * 100) / 100;
                $updsql = "update lkt_bargain_order set original_price=original_price-$randprice where store_id = '$store_id' and order_no='$oid'";
                $updres = $db->update($updsql);

                //判断数据是否处理成功
                if ($updres < 1) {
                    $code = 0;
                    $db->rollback();
                    exit;
                }
            } else {          //小于最大值的区间取差价,砍价成功
                $randprice = $chaprice;
                $updsql = "update lkt_bargain_order SET original_price=original_price-$randprice , status=1 , achievetime = $time where store_id = $store_id and order_no='$oid'";
                $updres = $db->update($updsql);
                if ($updres < 1) {
                    $code = 0;
                    $db->rollback();
                    exit;
                } else {
                    $status = "success";
                }
            }
        }


        $istsql = "insert into lkt_bargain_record(store_id,order_no,user_id,money,add_time) values($store_id,'$oid','$userid','$randprice','$time')";
        $istres = $db->insert($istsql);
        if ($istres < 1) {
            $code = 0;
            $db->rollback();
        } else {
            $db->commit();
        }


        $user_name = $userInfo[0]->user_name;
        $headimg = $userInfo[0]->headimgurl;

        echo json_encode(array('code' => $code, 'statusCode ' => '200', 'user_name' => $user_name, 'headimgurl' => $headimg, 'list' => $list, 'status' => $status, 'help_list' => $help_list, 'randprice' => $randprice));
        exit;

    }

    /**
     * 进入结算页面
     */
    public function Settlement()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $order_id = trim($request->getParameter('order_id')); //
        $uid = trim($request->getParameter('uid')); // 微信id
        //地址
        $address = [];
        //计算运费
        $yunfei = 0;
        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money,consumer_money from lkt_user where store_id = \'' . $store_id . '\' and wx_id=\'' . $uid . '\'';
        $r_user = $db->select($sql_user);
        if ($r_user) {
            $userid = $r_user['0']->user_id; // 用户id
            $user_money = $r_user['0']->money; // 用户余额
            //$user_consumer_money = $r_user['0']->consumer_money; // 用户消费金
        } else {
            echo json_encode(array('status' => 0, 'err' => '网络繁忙！'));
            exit();
        }

        // 根据用户id,查询收货地址
        $sql_a = 'select id from lkt_user_address where store_id = \'' . $store_id . '\' and uid=(select user_id from lkt_user where store_id = \'' . $store_id . '\' and wx_id="' . $uid . '")';
        $r_a = $db->select($sql_a);
        if ($r_a) {
            $arr['addemt'] = 0; // 有收货地址
            // 根据用户id、默认地址,查询收货地址信息
            $sql_e = 'select * from lkt_user_address where store_id = \'' . $store_id . '\' and uid=(select user_id from lkt_user where store_id = \'' . $store_id . '\' and wx_id="' . $uid . '") and is_default = 1';
            $r_e = $db->select($sql_e);
            //$r_e = (array)$r_e['0'];
            $r_e = !empty($r_e) ? (array)$r_e['0'] : array(); // 收货地址
            $arr['adds'] = $r_e;
        } else {
            $arr['addemt'] = 1; // 没有收货地址
            $arr['adds'] = ''; // 收货地址
            $r_e = array();
        }

        $sql = "select o.min_price,c.attribute,p.* from lkt_bargain_order as o left join lkt_configure as c on o.attr_id=c.id left join lkt_product_list as p on o.goods_id=p.id where o.store_id = '$store_id' and o.order_no='$order_id'";
        $res = $db->select($sql);
//        $yunfei = $this->freight($attrres->freight, 1, $r_e);
        echo json_encode(array('res' => $res, 'yunfei' => $yunfei, 'address' => $arr));
        exit;

    }


    /**
     *
     */
    public function can_order()
    {
        $db = DBAction::getInstance();
        $db->begin();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = addslashes(trim($request->getParameter('uid')));
        $form_id = addslashes(trim($request->getParameter('fromid')));
        $oid = addslashes(trim($request->getParameter('oid')));
        $pro_id = intval(trim($request->getParameter('pro_id')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
        $groupid = addslashes(trim($request->getParameter('groupid')));
        $man_num = intval(trim($request->getParameter('man_num')));
        $pro_name = addslashes(trim($request->getParameter('ptgoods_name')));
        $price = (float)(trim($request->getParameter('price')));
        $y_price = (float)(trim($request->getParameter('d_price')));
        $name = addslashes(trim($request->getParameter('name')));
        $sheng = intval(trim($request->getParameter('sheng')));
        $shi = intval(trim($request->getParameter('shi')));
        $quyu = intval(trim($request->getParameter('quyu')));
        $address = addslashes(trim($request->getParameter('address')));
        $tel = addslashes(trim($request->getParameter('tel')));
        $lack = intval(trim($request->getParameter('lack')));
        $buy_num = intval(trim($request->getParameter('num')));
        $paytype = addslashes(trim($request->getParameter('paytype')));
        $trade_no = addslashes(trim($request->getParameter('trade_no')));
        $status = intval(trim($request->getParameter('status')));
        $ordstatus = $status == 1 ? 9 : 0;

        $creattime = date('Y-m-d H:i:s');
        $pro_size = $db->select("select name,color,size from lkt_configure where id=$sizeid");
        $pro_size = $pro_size[0]->name . $pro_size[0]->color . $pro_size[0]->size;
        $selsql = "select ptnumber,ptstatus,endtime from lkt_group_open where store_id = '$store_id' and group_id='$groupid' and ptcode='$oid'";
        $selres = $db->select($selsql);

        if (!empty($selres)) {
            $ptnumber = $selres[0]->ptnumber;
            $ptstatus = $selres[0]->ptstatus;
            $endtime = strtotime($selres[0]->endtime);
        }
        $ordernum = 'PT' . mt_rand(10000, 99999) . date('Ymd') . substr(time(), 5);
        $user_id = $db->select("select user_id from lkt_user where store_id = '$store_id' and wx_id='$uid'");
        $uid = $user_id[0]->user_id;

        if ($endtime >= time()) {
            if (($ptnumber + 1) < $man_num) {

                $istsql2 = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,pay,add_time,otype,ptcode,pid,ptstatus,status,trade_no) values( '$store_id','$uid','$name','$tel',$buy_num,$price,'$ordernum',$sheng,$shi,$quyu,'$address','$paytype','$creattime','pt','$oid','$groupid',$status,$ordstatus,'$trade_no')";
                $res2 = $db->insert($istsql2);
                if ($res2 < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => $istsql2));
                    exit;
                }

                $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',-1,'$pro_size',$sizeid)";
                $res3 = $db->insert($istsql3);
                if ($res3 < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => $istsql3));
                    exit;
                }

                $updsql = "update lkt_group_open set ptnumber=ptnumber+1 where store_id = '$store_id' and group_id='$groupid' and ptcode='$oid'";
                $updres = $db->update($updsql);
                if ($updres < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => $updsql));
                    exit;
                }

                $updres = $db->update("update lkt_configure set num=num-$buy_num where id=$sizeid");
                if ($updres < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => "update lkt_configure set num=num-$buy_num where id=$sizeid"));
                    exit;
                }

                $db->commit();
                $idres = $db->select("select id from lkt_order where store_id = '$store_id' and sNo='$ordernum'");
                if (!empty($idres)) $idres = $idres[0]->id;
                echo json_encode(array('order' => $ordernum, 'gcode' => $oid, 'group_num' => $oid, 'ptnumber' => $ptnumber, 'id' => $idres, 'endtime' => $endtime, 'code' => 1));
                exit;


            } else if (($ptnumber + 1) === $man_num) {
                $istsql2 = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,pay,add_time,otype,ptcode,pid,ptstatus,status,trade_no) values('$store_id','$uid','$name','$tel',$buy_num,'$price','$ordernum',$sheng,$shi,$quyu,'$address','$paytype','$creattime','pt','$oid','$groupid',$status,$ordstatus,'$trade_no')";
                $res2 = $db->insert($istsql2);

                if ($res2 < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => $istsql2));
                    exit;
                }

                $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',-1,'$pro_size',$sizeid)";
                $res3 = $db->insert($istsql3);
                if ($res3 < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => $istsql3));
                    exit;
                }

                $updsql = "update lkt_group_open set ptnumber=ptnumber+1,ptstatus=2 where store_id = '$store_id' and group_id='$groupid' and ptcode='$oid'";
                $updres = $db->update($updsql);

                if ($updres < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => $updsql));
                    exit;
                }
                $updres = $db->update("update lkt_order set ptstatus=2,status=1 where store_id = '$store_id' and pid='$groupid' and ptcode='$oid' and status!=6");
                if ($updres < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => "update lkt_order set ptstatus=2,status=1 where store_id = '$store_id' and pid='$groupid' and ptcode='$oid'"));
                    exit;
                }
                $selmsg = "select m.*,d.p_name,d.p_price,d.num,d.sid from (select o.id,o.user_id,o.ptcode,o.sNo,o.z_price,u.wx_id as uid from lkt_order as o left join lkt_user as u on o.user_id=u.user_id where o.store_id = '$store_id' and o.pid='$groupid' and o.ptcode='$oid') as m left join lkt_order_details as d on m.sNo=d.r_sNo";
                $msgres = $db->select($selmsg);

                foreach ($msgres as $k => $v) {

                    $fromidsql = "select fromid,open_id from lkt_user_fromid where open_id='$v->uid' and id=(select max(id) from lkt_user_fromid where store_id = '$store_id' and open_id='$v->uid')";
                    $fromidres = $db->select($fromidsql);
                    foreach ($fromidres as $ke => $val) {
                        if ($val->open_id == $v->uid) {
                            $msgres[$k]->fromid = $val->fromid;
                        }
                    }
                }
                $updres = $db->update("update lkt_configure set num=num-$buy_num where id=$sizeid");
                if ($updres < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => "update lkt_configure set num=num-$v->num where id=$v->sid"));
                    exit;
                }
                if ($res2 > 0 && $res3 > 0) {
                    $sql = "select * from lkt_notice where store_id = '1'";
                    $r = $db->select($sql);
                    $template_id = $r[0]->group_success;

                    $this->Send_success($msgres, date('Y-m-d H:i:s', time()), $template_id, $pro_name);
                    $db->commit();
                    echo json_encode(array('order' => $msgres, 'gcode' => $oid, 'code' => 2));
                    exit;
                }
            } else if ($ptnumber == $man_num) {
                $updres = $db->update("update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$uid'");
                if ($updres < 1) {
                    $db->rollback();
                    echo json_encode(array('code' => 3, 'sql' => "update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$uid'"));
                    exit;
                }
                $db->commit();
                echo json_encode(array('code' => 3));
                exit;
            } else {

            }


        } else {
            $updres = $db->update("update lkt_user set money=money+$price where user_id='$uid'");
            if ($updres < 1) {
                $db->rollback();
                echo json_encode(array('code' => 3, 'sql' => "update lkt_user set money=money+$price where user_id='$uid'"));
                exit;
            }
            $db->commit();
            echo json_encode(array('code' => 4));
            exit;
        }


    }


    /**
     *
     */
    public function isgrouppacked()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $oid = addslashes(trim($request->getParameter('oid')));
        $selsql = "select ptnumber from lkt_group_open where store_id = '$store_id' and ptcode='$oid'";
        $selres = $db->select($selsql);
        if ($selres) {
            $hasnum = $selres[0]->ptnumber;
            echo json_encode(array('hasnum' => $hasnum));
            exit;
        } else {
            echo json_encode(array('hasnum' => 0));
            exit;
        }

    }

    /**
     *
     */
    public function confirmreceipt()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $oid = addslashes(trim($request->getParameter('oid')));
        $groupid = addslashes(trim($request->getParameter('groupid')));
        $updsql = "update lkt_order set status=3 where store_id = '$store_id' and sNo='$oid' and pid='$groupid'";
        $updres = $db->update($updsql);

        if ($updres > 0) {
            echo json_encode(array('code' => 1));
            exit;
        }

    }

    /**
     * @param $url
     * @param null $data
     * @return bool|string
     */
    function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
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


    public function Send_open()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('user_id'));  //--
        $form_id = trim($request->getParameter('form_id'));//--
        $page = trim($request->getParameter('page'));      //--
        // $oid = trim($request->getParameter('oid'));
        $f_price = trim($request->getParameter('price'));
        $f_price = $f_price . '元';
        $f_sNo = trim($request->getParameter('order_sn'));
        $f_pname = trim($request->getParameter('f_pname'));
        $opentime = date('Y-m-d H:i:s', time());
        $endtime = trim($request->getParameter('endtime'));
        $sum = trim($request->getParameter('sum'));
        $sum = $sum . '元';
        $member = trim($request->getParameter('member'));
        $endtime = explode(':', $endtime);
        $endtime = $endtime[0] . '小时' . $endtime[1] . '分钟';

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $opentime = array('value' => $opentime, "color" => "#173177");
            $f_pname = array('value' => $f_pname, "color" => "#173177");
            $f_sNo = array('value' => $f_sNo, "color" => "#173177");
            $f_price = array('value' => $f_price, "color" => "#173177");
            $endtime = array('value' => $endtime, "color" => "#173177");
            $sum = array('value' => $sum, "color" => "#173177");
            $member = array('value' => $member, "color" => "#173177");
            $tishi = array('value' => '您可以邀请您的好友一起来拼团，邀请的人越多，成功的几率越高哦!', "color" => "#FF4500");
            $o_data = array('keyword1' => $member, 'keyword2' => $opentime, 'keyword3' => $endtime, 'keyword4' => $f_price, 'keyword5' => $sum, 'keyword6' => $f_sNo, 'keyword7' => $f_pname, 'keyword8' => array('value' => '已开团-待成团', "color" => "#FF4500"), 'keyword9' => $tishi);

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

            $sql = "select * from lkt_notice where id = '1'";
            $r = $db->select($sql);
            $template_id = $r[0]->group_pay_success;

            $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $template_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));

            $da = $this->httpsRequest($url, $data);

            echo json_encode($da);

            exit();
        }

    }

    public function Send_can()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('user_id'));  //--
        $form_id = trim($request->getParameter('form_id'));//--
        $page = trim($request->getParameter('page'));      //--
        $f_price = trim($request->getParameter('price'));
        $f_price = $f_price . '元';
        $f_sNo = trim($request->getParameter('order_sn'));
        $f_pname = trim($request->getParameter('f_pname'));
        $opentime = date('Y-m-d H:i:s', time());
        $endtime = intval($request->getParameter('endtime')) - time();
        $sum = trim($request->getParameter('sum'));
        $sum = $sum . '元';
        $man_num = trim($request->getParameter('man_num'));
        $hours = ceil($endtime / 3600);
        $minute = ceil(($endtime % 3600) / 60);
        $endtime = $hours . '小时' . $minute . '分钟';

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $opentime = array('value' => $opentime, "color" => "#173177");
            $f_pname = array('value' => $f_pname, "color" => "#173177");
            $f_sNo = array('value' => $f_sNo, "color" => "#173177");
            $f_price = array('value' => $f_price, "color" => "#173177");
            $endtime = array('value' => $endtime, "color" => "#173177");
            $sum = array('value' => $sum, "color" => "#173177");
            $man_num = array('value' => $man_num, "color" => "#173177");

            $o_data = array('keyword1' => $f_pname, 'keyword2' => $f_price, 'keyword3' => $sum, 'keyword4' => $endtime, 'keyword5' => array('value' => '待成团', "color" => "#FF4500"), 'keyword6' => $opentime, 'keyword7' => $man_num, 'keyword8' => $f_sNo);

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
            $sql = "select * from lkt_notice where id = '1'";
            $r = $db->select($sql);
            $template_id = $r[0]->group_pending;
            $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $template_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));

            $da = $this->httpsRequest($url, $data);

            echo json_encode($da);

            exit();
        }

    }

    /**
     * 发送成功
     * @param $arr
     * @param $endtime
     * @param $template_id
     * @param $pro_name
     */
    public function Send_success($arr, $endtime, $template_id, $pro_name)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }
        foreach ($arr as $k => $v) {
            $data = array();
            $data['access_token'] = $AccessToken;
            $data['touser'] = $v->uid;
            $data['template_id'] = $template_id;
            $data['form_id'] = $v->fromid;
            $data['page'] = "pages/order/detail?orderId=$v->id";
            $z_price = $v->z_price . '元';
            $p_price = $v->p_price . '元';
            $minidata = array('keyword1' => array('value' => $pro_name, 'color' => "#173177"), 'keyword2' => array('value' => $z_price, 'color' => "#173177"), 'keyword3' => array('value' => $v->sNo, 'color' => "#173177"), 'keyword4' => array('value' => '拼团成功', 'color' => "#FF4500"), 'keyword5' => array('value' => $p_price, 'color' => "#FF4500"), 'keyword6' => array('value' => $endtime, 'color' => "#173177"));
            $data['data'] = $minidata;

            $data = json_encode($data);
            $da = $this->httpsRequest($url, $data);
            $delsql = "delete from lkt_user_fromid where open_id='$v->uid' and fromid='$v->fromid'";
            $db->delete($delsql);

        }


    }

    /**
     * 获取AccessToken
     * @param $appID
     * @param $appSerect
     * @return false|string
     */
    function getAccessToken($appID, $appSerect)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = "accessToken"; // 文件名
        if (is_file($fileName)) {
            $modifyTime = filemtime($fileName);
            if (($currentTime - $modifyTime) < 7200) {
                // 可用, 直接读取文件的内容
                $accessToken = file_get_contents($fileName);
                return $accessToken;
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

    /*

   * 发送请求

   　@param $ordersNo string 订单号　

     @param $refund string 退款单号

     @param $price float 退款金额

     return array

   */

    /*
   * 发送请求
   @param $ordersNo string 订单号　
   @param $refund string 退款单号
   @param $price float 退款金额
   return array
   */
    private function wxrefundapi($ordersNo, $refund, $total_fee, $price)
    {
        //通过微信api进行退款流程
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select mch_id from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $mch_id = $r[0]->mch_id; // 商户mch_id

            require_once(MO_LIB_DIR . '/WxPayPubHelper/' . $mch_id . '_WxPay.pub.config.php');
            $this->SSLCERT_PATH = WxPayConf_pub::SSLCERT_PATH;
            $this->SSLKEY_PATH = WxPayConf_pub::SSLKEY_PATH;
            $this->APPID = WxPayConf_pub::APPID;
            $this->MCHID = WxPayConf_pub::MCHID;
            $this->APPSECRET = WxPayConf_pub::APPSECRET;
            $this->KEY = WxPayConf_pub::KEY;

            $appid = WxPayConf_pub::APPID;
            $appsecret = WxPayConf_pub::APPSECRET;
            $mch_key = WxPayConf_pub::KEY;

        }

        require_once(MO_LIB_DIR . '/WxPayPubHelper/' . $mch_id . '_WxPay.pub.config.php');
        $this->cert = WxPayConf_pub::SSLCERT_PATH;
        $this->key = WxPayConf_pub::SSLKEY_PATH;

        $parma = array('appid' => $appid, 'mch_id' => $mch_id, 'nonce_str' => $this->createNoncestr(), 'out_refund_no' => $refund, 'out_trade_no' => $ordersNo, 'total_fee' => $total_fee, 'refund_fee' => $price, 'op_user_id' => $appid);
        $parma['sign'] = $this->getSign($parma, $mch_key);
        $xmldata = $this->arrayToXml($parma);

        $xmlresult = $this->postXmlSSLCurl($xmldata, 'https://api.mch.weixin.qq.com/secapi/pay/refund');
        $result = $this->xmlToArray($xmlresult);

        return $result;
    }

    /*
     * 生成随机字符串方法
     */
    protected function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /*
     * 对要发送到微信统一下单接口的数据进行签名
     */
    protected function getSign($Obj, $mch_key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $mch_key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /*
     *排序并格式化参数方法，签名时需要使用
     */
    protected function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
//        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    /**
     * 数组转字符串方法
     * @param $arr
     * @return string
     */
    protected function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * xml转数组
     * @param $xml
     * @return mixed
     */
    protected function xmlToArray($xml)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    /**
     * 需要使用证书的请求
     * @param $xml
     * @param $url
     * @param int $second
     * @return bool|string
     */
    private function postXmlSSLCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释

        // $cert = str_replace('lib', 'filter', MO_LIB_DIR) . '/apiclient_cert.pem';
        // $key = str_replace('lib', 'filter', MO_LIB_DIR) . '/apiclient_key.pem';

        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, $this->SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, $this->SSLKEY_PATH);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
            curl_close($ch);
            return false;
        }
    }


    public function getRequestMethods()
    {
        return Request :: POST;
    }

    /**
     * 临时存放微信付款信息
     */
    public function up_out_trade_no()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $pagefrom = trim($request->getParameter('pagefrom'));
        $uid = addslashes(trim($request->getParameter('uid')));
        $oid = addslashes(trim($request->getParameter('oid')));
        $form_id = addslashes(trim($request->getParameter('fromid')));
        $pro_id = intval(trim($request->getParameter('pro_id')));
        $man_num = intval(trim($request->getParameter('man_num')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
        $groupid = addslashes(trim($request->getParameter('groupid')));
        $pro_name = addslashes(trim($request->getParameter('ptgoods_name')));
        $price = (float)(trim($request->getParameter('price')));
        $y_price = (float)(trim($request->getParameter('d_price')));
        $name = addslashes(trim($request->getParameter('name')));
        $sheng = intval(trim($request->getParameter('sheng')));
        $shi = intval(trim($request->getParameter('shi')));
        $quyu = intval(trim($request->getParameter('quyu')));
        $address = addslashes(trim($request->getParameter('address')));
        $tel = addslashes(trim($request->getParameter('tel')));
        $lack = intval(trim($request->getParameter('lack')));
        $buy_num = intval(trim($request->getParameter('num')));
        $paytype = addslashes(trim($request->getParameter('paytype')));
        $trade_no = addslashes(trim($request->getParameter('trade_no')));
        $status = intval(trim($request->getParameter('status')));
        $time_over = addslashes(trim($request->getParameter('time_over')));
        $ordstatus = $status == 1 ? 9 : 0;

        if ($pagefrom == 'kaituan') {
            $array = array('uid' => $uid, 'form_id' => $form_id, 'oid' => $oid, 'pro_id' => $pro_id, 'sizeid' => $sizeid, 'groupid' => $groupid, 'man_num' => $man_num, 'pro_name' => $pro_name, 'price' => $price, 'y_price' => $y_price, 'name' => $name, 'sheng' => $sheng, 'shi' => $shi, 'quyu' => $quyu, 'address' => $address, 'tel' => $tel, 'lack' => $lack, 'buy_num' => $buy_num, 'paytype' => $paytype, 'trade_no' => $trade_no, 'status' => $status, 'ordstatus' => $ordstatus, 'time_over' => $time_over, 'pagefrom' => $pagefrom);
        } else {
            $array = array('uid' => $uid, 'form_id' => $form_id, 'oid' => $oid, 'pro_id' => $pro_id, 'sizeid' => $sizeid, 'groupid' => $groupid, 'man_num' => $man_num, 'pro_name' => $pro_name, 'price' => $price, 'y_price' => $y_price, 'name' => $name, 'sheng' => $sheng, 'shi' => $shi, 'quyu' => $quyu, 'address' => $address, 'tel' => $tel, 'lack' => $lack, 'buy_num' => $buy_num, 'paytype' => $paytype, 'trade_no' => $trade_no, 'status' => $status, 'ordstatus' => $ordstatus, 'pagefrom' => $pagefrom);
        }


        $data = serialize($array);

        $sql = "insert into lkt_order_data(trade_no,data,addtime) values('$trade_no','$data',CURRENT_TIMESTAMP)";
        $rid = $db->insert($sql);

        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $sql = "delete from lkt_order_data where addtime < '$yesterday'";
        $db->delete($sql);

        echo json_encode(array('data' => $array));
        exit();
    }

    /**
     *
     */
    public function verification()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $trade_no = addslashes(trim($request->getParameter('trade_no')));
        $gmsg = $db->select("select id,sNo,ptcode from lkt_order where store_id = '$store_id' and trade_no='$trade_no'");

        if ($gmsg) {
            echo json_encode(array('status' => 1, 'data' => $gmsg[0]));
            exit();
        } else {
            echo json_encode(array('status' => 0));
            exit();
        }
    }

    /**
     * 删除订单
     */
    public function removeOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = $request->getParameter('openid');
        $id = $request->getParameter('id');

        $msgsql = "select o.id,o.user_id,o.ptcode,o.sNo,o.z_price,o.add_time,o.pay,o.trade_no,d.p_name,d.p_price,d.num,d.sid,u.money from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo left join lkt_user as u on o.user_id=u.user_id where o.store_id = '$store_id' and o.id=$id";
        $msg = $db->select($msgsql);

        if (!empty($msg)) {
            $user_id = $msg[0]->user_id;
            $paytype = $msg[0]->pay;
            $trade_no = $msg[0]->trade_no;    //支付单号
            $sNo = $msg[0]->sNo;    //订单号
            $p_name = $msg[0]->p_name;    //订单号
            $price = floatval($msg[0]->z_price);
            $z_price = $msg[0]->z_price * 100;    //订单金额
            $money = $msg[0]->money;   //余额
            $num = $msg[0]->num;   //购买数量
            $sid = $msg[0]->sid;   //产品属性号
        }
        $db->begin();
        $sql = "update lkt_order set status=6 where store_id = '$store_id' and id=$id";
        $updres = $db->update($sql);

        if ($updres < 0) {
            $db->rollback();
            echo json_encode(array('code' => 0, 'err' => '取消失败'));
            exit;
        }
        if ($paytype == 'wallet_Pay' || $paytype == 'combined_Pay') {    //余额支付或者组合支付
            $updsql1 = "update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$user_id'";
            $updres1 = $db->update($updsql1);
            //微信支付记录-写入日志
            $event = $user_id . '退回拼团订单款' . $price . '元--订单号:' . $sNo;
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$money','$event',5)";
            $rr = $db->insert($sqll);
            if ($updres1 < 0) {
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '取消失败,退款未成功'));
                exit;
            }
        } else if ($paytype == 'wxPay') {
            $refund = $ordernum = date('Ymd') . mt_rand(10000, 99999) . substr(time(), 5);
            $res1 = $this->wxrefundapi($trade_no, $refund, $z_price, $z_price);
            if ($res1['return_code'] != 'SUCCESS') {
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '取消失败,退款未成功'));
                exit;
            }
        }

        $updres = $db->update("update lkt_configure set num=num+$num where id=$sid");
        if ($updres < 0) {
            $db->rollback();
            echo json_encode(array('code' => 0, 'sql' => "update lkt_configure set num=num-$num where id=$sid"));
            exit;
        }

        $db->commit();
        $fromres1 = $this->get_fromid($openid);
        $fromid = $fromres1['fromid'];
        $sql = "select * from lkt_notice where store_id = '$store_id'";
        $r = $db->select($sql);
        $template_id = $r[0]->refund_success;
        $this->Send_fail($openid, $fromid, $sNo, $p_name, $price,
            $template_id, 'pages/user/user', $paytype);
        echo json_encode(array('code' => 1, 'err' => '取消成功'));
        exit;
    }


    public function get_fromid($openid)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $fromidsql = "select fromid,open_id from lkt_user_fromid where open_id='$openid' and id=(select max(id) from lkt_user_fromid where store_id = '$store_id' and open_id='$openid')";
        $fromidres = $db->select($fromidsql);
        if ($fromidres) {
            $fromid = $fromidres[0]->fromid;
            $arrayName = array('openid' => $openid, 'fromid' => $fromid);
            return $arrayName;
        } else {
            return array('openid' => $openid, 'fromid' => '123456');
        }


    }

    public function Send_fail($uid, $fromid, $sNo, $p_name, $price, $template_id, $page, $paytype)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret
            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }
        $paytype = $paytype == "wxPay" ? "退回到微信" : '退回到钱包';
        $data = array();
        $data['access_token'] = $AccessToken;
        $data['touser'] = $uid;
        $data['template_id'] = $template_id;
        $data['form_id'] = $fromid;
        $data['page'] = $page;
        $price = $price . '元';
        $minidata = array('keyword1' => array('value' => $sNo, 'color' => "#173177"), 'keyword2' => array('value' => $p_name, 'color' => "#173177"), 'keyword3' => array('value' => $price, 'color' => "#173177"), 'keyword4' => array('value' => $paytype, 'color' => "#FF4500"), 'keyword5' => array('value' => '拼团失败--退款', 'color' => "#FF4500"));
        $data['data'] = $minidata;

        $data = json_encode($data);

        $da = $this->httpsRequest($url, $data);
        $delsql = "delete from lkt_user_fromid where open_id='$uid' and fromid='$fromid'";
        $db->delete($delsql);

    }

}

?>