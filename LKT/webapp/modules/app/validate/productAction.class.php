<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class productAction extends Action {
    /*
    时间2018年03月15日
    修改内容：所有商品购买付款下订单等操作API请求
    修改人：苏涛
    主要功能：处理商品数据，返回购物请求结果
    备注：api-JSON
     */
    public function getDefaultView() {
        return;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $store_id = trim($request->getParameter('store_id'));
        $this->$store_id = $store_id;
        if($m == 'index'){
            $this->index();
        }else if($m == 'add_cart'){
            $this->add_cart();
        }else if($m == 'listdetail'){
            $this->listdetail();
        }else if($m == 'get_more'){
            $this->get_more();
        }else if($m == 'Settlement'){ // 结算页面
            $this->Settlement();
        }else if($m == 'Shopping'){
            $this->Shopping();
        }else if($m == 'delcart'){
            $this->delcart();
        }else if($m == 'delAll_cart'){
            $this->delAll_cart();
        }else if($m == 'to_Collection'){
            $this->to_Collection();
        }else if($m == 'up_cart'){
            $this->up_cart();
        }else if($m == 'payment'){ // 生产订单
            $this->payment();
        }else if($m == 'up_order'){
            $this->up_order();
        }else if($m == 'comment'){
            $this->comment();
        }else if($m == 't_comment'){
            $this->t_comment();
        }else if($m == 'new_product'){
            $this->new_product();
        }else if($m == 'wallet_pay'){
            $this->wallet_pay();
        }else if ($m == 'select_size') {
               //属性选择
              $this->select_size();
        }else if ($m == 'save_formid') {
              //普通商品储存from_id 用于发货 退款等操作信息推送
              $this->save_formid();
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 获取产品详情
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // 获取产品id
        $store_id = $request->getParameter('store_id');
        $id = trim($request->getParameter('pro_id'));
        $openid = $_POST['openid'];// 根据微信id,查询用户id
        $choujiangid = $request->getParameter('choujiangid');
        $wx_id = $request->getParameter('wx_id');
        $price01 ='';
        $type01 ='';

        $sql1 = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql1);

        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'./') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,1); // 图片路径
        }
        $sql = "select * from lkt_user where wx_id = '$openid'";
        $r = $db->select($sql);
        $user_id = $r[0]->user_id;
        // 根据用户id、产品id,获取收藏表信息
        $sql = "select * from lkt_user_collection where user_id = '$user_id' and p_id = '$id'";
        $rr = $db->select($sql);
        if($rr){
            $type = 1;
            $collection_id = $rr['0']->id;
        }else{
            $type = 0;
            $collection_id = '';
        }
        $time = date("Y-m-d");
        // 根据用户id,在足迹表里插入一条数据
        $sql_collection = "select * from lkt_user_footprint where user_id = '$user_id' and p_id = '$id' and add_time like '$time%' ";
        $rr_collection = $db->select($sql_collection);

        if(empty($rr_collection)){
            $sql = "insert into lkt_user_footprint(user_id,p_id,add_time) values('$user_id','$id',CURRENT_TIMESTAMP)";
            $rrr = $db->insert($sql);
        }


        // 根据产品id,查询产品数据
        $sql = 'select a.*,c.price,c.yprice,c.name,c.color,c.size,c.img from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid '."where a.id =  $id ";
        $res = $db -> select($sql);
        if($res == ''){
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }else{
            $img_arr =  [];
            $sql_img = "select product_url,id from lkt_product_img where product_id = '$id'";
            $r = $db->select($sql_img);
            if($r){
                foreach ($r as $key => $value) {
                    $img_arr[$key] = $img.$value->product_url;
                }
            }else{
                $img_arr['0'] = $img.$res['0']->img;
            }
            $class =  $res['0'] -> product_class;
            $typestr=trim($class,'-');
            $typeArr=explode('-',$typestr);
            //  取数组最后一个元素 并查询分类名称
            $cid = end($typeArr);
            $sql_p = "select pname from lkt_product_class where cid ='".$cid."'";
            $r_p = $db->select($sql_p);
            $pname = $r_p['0']->pname;
            $product = [];
            $imgurl = $img.$res['0']->img;
            $content = $res['0']->content;
            $new_content = preg_replace('/(<img.+?src=")(.*?)/','$1//xiaochengxu.laiketui.com$2', $content);
            $product['id'] = $res['0']->id;
            $product['shop_id'] = $res['0']->id;
            $product['name'] = $res['0']->product_title;
            $product['intro'] = $res['0']->product_title;
            $product['num'] = $res['0']->num;
            $product['price'] = $res['0']->yprice;
            $product['price_yh'] = $res['0']->price;
            $product['price11'] =$price01 ? $price01:'';
            $product['type01'] =$type01 ? $type01:'';
            $product['photo_x'] = $imgurl;
            $product['photo_d'] =$res['0']->img;
            $product['content'] = $new_content;
            $product['pro_number'] = $res['0']->id;
            $product['company'] = '件';
            $product['cat_name'] = $pname;
            $product['brand'] = '来客推';
            $product['img_arr'] = $img_arr;
            $product['choujiangid'] = $choujiangid? '':$choujiangid;
            $product['volume'] = $res['0']->volume;
            if($type1 == 1){
                $product['type111'] = 1;
                $wx_id =$wx_id ;
            }else{
            $product['type111'] = 2;
            $wx_id ='';
            }

            if(!empty($res[0]->brand_id)){
                $b_id =$res[0]->brand_id;
                $sql01 = "select brand_name from lkt_brand_class where brand_id = '$b_id'";
                $r01 = $db->select($sql01);
            }
            if(!empty($r01)){
                 $product['brand_name'] = $r01[0]->brand_name;
            }else{
                 $product['brand_name'] = '无';
            }

             $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.size,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.wx_id where a.pid = '$id'";
            $r_c = $db->select($sql_c);
            $arr=[];
            foreach ($r_c as $key => $value) {
                $va = (array)$value;
                $va['time'] = substr($va['add_time'],0,10);
                //-------------2018-05-03  修改  作用:返回评论图片
                $comments_id = $va['id'];
                $comments_sql = "select comments_url from lkt_comments_img where comments_id = '$comments_id' ";
                $comment_res = $db->select($comments_sql);
                $va['images'] ='';
                if($comment_res){
                    $va['images'] = $comment_res;
                    $array_c = [];
                    foreach ($comment_res as $kc => $vc) {
                       $url = $vc->comments_url;
                       $array_c[$kc] = array('url' =>$img.$url);
                    }
                    $va['images'] = $array_c;

                }
                //-------------2018-07-27  修改
                $ad_sql = "select content from lkt_reply_comments where cid = '$comments_id' and uid = 'admin' ";
                $ad_res = $db->select($ad_sql);
                if($ad_res){
                    $reply_admin = $ad_res[0]->content;
                }else{
                    $reply_admin = '';
                }

                $va['reply'] = $reply_admin;

                $obj = (object)$va;
                $arr[$key] = $obj;
            }
            $commodityAttr = [];
            $sql_size = "select * from lkt_configure where pid = '$id' AND num > 0";
            $r_size = $db->select($sql_size);
            $array_price = [];
            $array_yprice = [];
            if ($r_size) {
                foreach ($r_size as $key => $value) {
                    $array_price[$key] = $value->price;
                    $array_yprice[$key] = $value->yprice;
                    $attrValueList[0] = array('attrKey' => '型号', 'attrValue' => $value->name);
                    $attrValueList[1] = array('attrKey' => '规格', 'attrValue' => $value->size);
                    $attrValueList[2] = array('attrKey' => '颜色', 'attrValue' => $value->color);
                    $cimgurl = $img.$value->img;
                    $commodityAttr[$key] = array('priceId' => $value->id,'price' => $value->price,'stock' => $value->num,'img' => $cimgurl, 'attrValueList' => $attrValueList,'name' => $value->name,'size' => $value->size,'color' => $value->color,);
                }
            }
            //排序
            asort($array_price);
            asort($array_yprice);
            //获取价格区间并返回
            $qj_price = reset($array_price)==end($array_price)? reset($array_price):reset($array_price).'-'.end($array_price);
            $qj_yprice = reset($array_yprice)==end($array_yprice)? reset($array_yprice):reset($array_yprice).'-'.end($array_yprice);
            //返回JSON 
            echo json_encode(array('status'=>1,'pro'=>$product,'qj_price'=>$qj_price,'qj_yprice'=>$qj_yprice,'attrValueList'=>'','commodityAttr'=>$commodityAttr,'collection_id'=>$collection_id,'comments'=>$arr,'type'=>$type,'wx_id' =>$wx_id));
            exit();
        }
    }
    public function select_size()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //接收属性JSON数据  
        $json = json_decode (file_get_contents('php://input'));
        $pid = $json->pid;
        $index = $json->index; //  'index',
        $skey = $json->key; //  'key',
        $value =$json->value; //  'value',
        $select =[];   //'select',
        $attrValueList = $json->attrValueList;

        $num = 0;
        foreach ($attrValueList as $kt => $vt) {
            $selected = $vt->selectedValue;
            if($selected){
                $num = $num+1;
            }
            $select[$kt]=$vt->selectedValue;
        }
        $name=$select['0'];
        $size=$select['1'];
        $color=$select['2'];

        $sql_size = "select name,size,color from lkt_configure where pid = '$pid' AND num > 0";
        $r_size = $db->select($sql_size);
        $keds = [];

        if ($r_size) {
            foreach ($r_size as $k => $v) {
                //查找对应属性
                if($num == 1){
                    //第一种情况 只选择一个时 显示 自己没选的对应可选的
                    if(!empty($name)){
                        if($v->name == $name){
                            @array_push($keds,$v->size,$v->color);
                            foreach ($r_size as $kr => $vr) {
                                if($vr->color == $v->color || $vr->size == $v->size){
                                    @array_push($keds,$vr->name);   
                                }
                            }
                        }
                    }

                    if(!empty($size)){
                        if($v->size == $size){
                            @array_push($keds,$v->name,$v->color);
                            foreach ($r_size as $kr => $vr) {
                                if($vr->name == $v->name || $vr->color == $v->color){
                                    @array_push($keds,$vr->size);
                                }
                            }
                        }
                    }

                    if(!empty($color)){
                        if($v->color == $color){
                            @array_push($keds,$v->size,$v->name);
                            foreach ($r_size as $kr => $vr) {
                                if($vr->name == $v->name || $vr->size == $v->size){
                                    @array_push($keds,$vr->color);  
                                }
                            }
                        }
                        
                    }
                }else if($num == 2){
                    //第二种情况 选择两个 并 
                    if(!empty($name) && !empty($size)){
                        if($v->name == $name && $v->size == $size){
                            @array_push($keds,$v->color);
                        }

                    }

                    if(!empty($size) && !empty($color)){
                        if($v->size == $size && $v->color == $color){
                            @array_push($keds,$v->name);
                        }
                    }

                    if(!empty($color) && !empty($name)){
                        if($v->color == $color && $v->name == $name){
                            @array_push($keds,$v->size);
                        }
                        
                    }

                    if($skey == '型号'){
                        foreach ($r_size as $kr => $vr) {
                            if($v->name == $vr->name && $v->size == $vr->size){
                                @array_push($keds,$vr->color);
                            }
                        }
                    } else if($skey == '规格'){
                        foreach ($r_size as $kr => $vr) {
                            if($v->name == $vr->name && $v->color == $vr->color){
                                @array_push($keds,$vr->size);
                            }
                        }
                    }else{
                        foreach ($r_size as $kr => $vr) {
                            if($v->name == $vr->name && $v->size == $vr->size){
                                @array_push($keds,$vr->color);
                            }
                        }
                    }



                }else{
                    //如果所选的都不为空 且全部对应不上属性所有值
                    if(!empty($color) && !empty($name) && !empty($size)){

                            if($skey == '型号'){
                                if($v->size == $size && $v->color == $color && $v->name != $value){
                                    @array_push($keds,$v->name);
                                }
                            } else if($skey == '规格'){
                                if($v->color == $color && $v->name == $name && $v->size != $value){
                                    @array_push($keds,$v->size);
                                }
                            }else{
                                if($v->name == $name && $v->size == $size && $v->color != $value){
                                    @array_push($keds,$v->color);
                                }
                            }

                    }
                }
            }
        }
        @array_push($keds,$value);
        $keds = array_unique($keds);
        //删除重复值 
        $new_attr = [];
        foreach ($attrValueList as $key => $val) {         
            $ss = $val->attrValues;
            foreach ($ss as $k => $v) {
                if($v == $select[$key]){
                    $val->attrValueStatus[$k] = true;
                }else{
                    $val->attrValueStatus[$k] = false;
                }

                foreach ($keds as $ks => $vs) {
                    if($vs == $v){
                        $val->attrValueStatus[$k] = true;
                    }
                }
            }
            $new_attr[$key]= $val;

        }
        $arrayName = array('attrValueList' =>$new_attr ,'status' =>true ,'keds'=>$keds,'select'=>$select);
        echo json_encode($arrayName);
        exit;

    }
    //普通商品储存from_id 用于发货 退款等操作信息推送
    public function save_formid(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $uid = addslashes(trim($request->getParameter('userid')));
        $formid = addslashes(trim($request->getParameter('from_id')));
        $lifetime = date('Y-m-d H:i:s',time() + 7*24*3600);
        if($formid != 'the formId is a mock one' && $formid != ''){          
                $addsql = "insert into lkt_user_fromid(open_id,fromid,lifetime) values('$uid','$formid','$lifetime')";
                $addres = $db -> insert($addsql);
                echo json_encode(array('status'=>1,'succ'=>$addres));
        }
    }

    // 加入购物车
    public function add_cart(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $Uid = trim($request->getParameter('uid')); //  '微信id',
        $Goods_id = trim($request->getParameter('pid')); //  '产品id',
        $Goods_num = trim($request->getParameter('num')); //  '数量',
        $size_id =trim($request->getParameter('sizeid')); //  '商品属性id',
        $pro_type =trim($request->getParameter('pro_type')); //  '点击类型',
        if(empty($Uid) || empty($Goods_id) || empty($Goods_id) || empty($size_id)){
            echo json_encode(array('status'=>0,'info'=>'添加失败请重新提交!!'));
        }else{
            $sql = "select user_id from lkt_user where wx_id = '$Uid'";
            $r_1 = $db->select($sql);
            $user_id = $r_1[0]->user_id;

            $sql_k = "select num from lkt_configure where pid = '$Goods_id' and num >0";
            $res_k = $db->select($sql_k);
            $num = $res_k[0]->num;
            if($num >= $Goods_num){
                //查询购物车是否有过改商品，有则修改 无则新增
                $sql_c = "select Goods_num,id from lkt_cart where Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                $res = $db->select($sql_c);
                if ($res) {
                    //根据点击的类型进行修改
                    if($pro_type == 'buynow'){
                        $sql_u = "update lkt_cart set Goods_num = '$Goods_num' where Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                        $r_u = $db->update($sql_u);
                    }else{
                        $sql_u = "update lkt_cart set Goods_num = Goods_num+'$Goods_num' where Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                        $r_u = $db->update($sql_u);
                    }
                    echo json_encode(array('status'=>1,'cart_id'=>$res['0']->id));
                }else{
                    $sql = "insert into lkt_cart (user_id,Uid,Goods_id,Goods_num,Create_time,Size_id) values('$user_id','$Uid','$Goods_id','$Goods_num',CURRENT_TIMESTAMP,$size_id) ";
                    $r = $db -> insert($sql,'last_insert_id');
                    if($r){
                        echo json_encode(array('status'=>1,'cart_id'=>$r));
                    }else{
                        echo json_encode(array('status'=>0,'err'=>'添加失败请重新提交!'));
                    }
                }                  
            }else{
                echo json_encode(array('status'=>0,'err'=>'库存不足！'));
            }
        }
        exit;
    }
    public function listdetail(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = trim($request->getParameter('cid')); //  '分类ID'
        $paegr = trim($request->getParameter('page')); //  '页面'
        $select = trim($request->getParameter('select')); //  选中的方式 0 默认  1 销量   2价格
        if($select == 0){
             $select = 'a.add_date'; 
        }elseif ($select == 1) {
             $select = 'a.volume'; 
        }else{
             $select = 'c.price'; 
        }

        $sort = trim($request->getParameter('sort')); // 排序方式  1 asc 升序   0 desc 降序
        if($sort){
             $sort = ' asc '; 
        }else{
             $sort = ' desc '; 
        }
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$this->store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }
        if(!$paegr){
            $paegr = 1;
        }
        $start = ($paegr-1)*10;
        $end = $paegr*10;
        $sql = 'select a.id,a.product_title,volume,c.price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.product_class like \'%-'.$id."-%' order by $select $sort LIMIT $start,$end ";
        // echo $sql;
        $r = $db->select($sql);
        if($r){
            $product = [];
            foreach ($r as $k => $v) {
                $imgurl = $img.$v->img;/* end 保存*/
                $names = ' '.$v->name . $v->color ;
                if($v->name == $v->color || $v->name == '默认'){
                    $names = '';
                }
                $product[$k] = array('id' => $v->id,'name' => $v->product_title . $names,'price' => $v->yprice,'price_yh' => $v->price,'imgurl' => $imgurl,'size'=>$v->sizeid,'volume' => $v->volume,'s_type' => $v->s_type);
            }
            echo json_encode(array('status'=>1,'pro'=>$product));
            exit;
        }else{
            echo json_encode(array('status'=>0,'err'=>'没有了！'));
            exit;
        }
    }
    // 加载更多商品
    public function get_more(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = trim($request->getParameter('cid')); //  '分类ID'
        $paegr = trim($request->getParameter('page')); //  '分页显示'
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$this->store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }
        if(!$paegr){
            $paegr = 1;
        }
        $start = ($paegr-1)*10;
        $end = $paegr*10;
        $sql = 'select a.id,a.product_title,a.volume,c.price,c.yprice,c.img,c.name,c.color,c.id AS sizeid from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.product_class like \'%-'.$id.'-%\' and c.num >0 order by a.sort LIMIT $start,$end';
        $r = $db->select($sql);
        if($r){
            $product = [];
            foreach ($r as $k => $v) {
                $imgurl = $img.$v->img;/* end 保存*/
                $names = ' '.$v->name . $v->color ;
                if($v->name == $v->color || $v->name == '默认'){
                    $names = '';
                }
                $product[$k] = array('id' => $v->id,'name' => $v->product_title .$names,'price' => $v->yprice,'size'=>$v->sizeid,'price_yh' => $v->price,'imgurl' => $imgurl,'volume' => $v->volume);
            }
            echo json_encode(array('status'=>1,'pro'=>$product));
            exit;
        }else{
            echo json_encode(array('status'=>0,'pro'=>''));
            exit;
        }
    }
    // 进入结算页面
    public function Settlement(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $software_name = trim($request->getParameter('software_name')); // 软件名称
        $cart_id = trim($request->getParameter('cart_id')); //  购物车id
        $uid = trim($request->getParameter('uid')); // 微信id
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$this->store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }

        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money,score from lkt_user where wx_id=\''.$uid.'\'';
        $r_user = $db->select($sql_user);
        $userid = $r_user['0']->user_id; // 用户id
        $user_money = $r_user['0']->money; // 用户余额
        $user_score = $r_user['0']->score; // 用户积分

        // 根据用户id,查询收货地址
        $sql_a = 'select id from lkt_user_address where uid=\''.$userid.'\'';
        $r_a = $db->select($sql_a);
        if(!empty($r_a)){
            $arr['addemt']=0; // 有收货地址
            // 根据用户id、默认地址,查询收货地址信息
            $sql_e = 'select * from lkt_user_address where uid=\''.$userid.'\' and is_default = 1';
            $r_e = $db->select($sql_e);
            if(!empty($r_e)){
                $arr['adds'] = (array)$r_e['0']; // 收货地址
            }else{
                // 根据用户id、默认地址,查询收货地址信息
                $aaaid = $r_a[0]->id;
                $sql_q = "select * from lkt_user_address where id= '$aaaid'";
                $r_q = $db->select($sql_q);
                $arr['adds'] = (array)$r_q['0']; // 收货地址 
                $sql_u = "update lkt_user_address set is_default = 1 where id = '$aaaid'";
                $db->update($sql_u);
                
            }
            
        }else{
            $arr['addemt']=1; // 没有收货地址
            $arr['adds'] = ''; // 收货地址
        }
        $typestr=trim($cart_id,','); // 移除两侧的逗号
        $typeArr=explode(',',$typestr); // 字符串打散为数组
        //  取数组最后一个元素 并查询分类名称
        $zong =0;

        foreach ($typeArr as $key => $value) {
            // 联合查询返回购物信息
            $sql_c = 'select a.Goods_num,a.Goods_id,a.id,m.product_title,m.volume,c.price,c.name,c.color,c.size,c.img,c.yprice from lkt_cart AS a LEFT JOIN lkt_product_list AS m ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id  where c.num >0 and a.id = \''.$value.'\'';
            $r_c = $db->select($sql_c);
            $product = (array)$r_c['0']; // 转数组

            $size = $product['name'].' '.$product['size'].' '.$product['color'];
            if($product['name'] == $product['size'] && $product['size'] == $product['color']){
                $size = $product['name'];
            }

            $product['photo_x'] = $img.$product['img'];/* 拼接图片链接*/
            $num = $product['Goods_num']; // 产品数量
            $price = $product['price']; // 产品价格
            $product['size'] = $size; // 产品价格
            $zong += $num*$price; // 产品总价
            $res[$key] = $product; 
        }
        $arr['price'] = $zong; // 产品总价
        $arr['pro'] = $res; // 产品信息

        $time = date("Y-m-d H:i:s"); // 当前时间
        // 查询当前有哪些满减活动
        $sql = "select * from lkt_coupon_activity where start_time <= '$time' and '$time' < end_time and activity_type = 3 order by z_money";
        $r_activity = $db->select($sql);
        $reduce_money = 0;
        $arr['name'] = ''; // 活动名称
        $arr['reduce_money'] = ''; // 满减金额
        if($r_activity){
            foreach ($r_activity as $k => $v) {
                $reduce_id = $v->id; // 满减活动id
                $z_money = $v->z_money; // 满足多少
                if($zong > $z_money){
                    $arr['name'] = $v->name; // 活动名称
                    $asd[] = $v->name; // 活动名称
                    $reduce_money = $v->money; // 减的金额
                    $arr['reduce_money'] = $v->money; // 满减金额
                }
            }
            $zong = $zong - $reduce_money;
        }else{
            $arr['name'] = ''; // 活动名称
            $arr['reduce_money'] = ''; // 满减金额
        }

        // $sql = "select id from lkt_software where type = 0 and name = '$software_name' order by id desc";
        // $rrrr = $db->select($sql);
        // foreach ($rrrr as $key => $value) {
        //     $software_id[] = $value->id;
        // }
        $software_id = $software_name;
        // var_dump($software_id);exit;
        // foreach ($software_id as $ke => $val) {
            // 根据用户id,查询优惠券状态为 (使用中)
            $sql = "select * from lkt_coupon where user_id = '$userid' and software_id = '$software_id' and type = 1";
            $r = $db->select($sql);
            if($r){
                $r = $r;
                // break;
            }else{
                $r = '';
            }
        // }
        if($r){
            foreach ($r as $k => $v) {
                $id = $v->id; // 优惠券id
                // 根据优惠券id,查询订单表(查看优惠券是否绑定)
                $sql = "select id from lkt_order where coupon_id = '$id' ";
                $rr = $db->select($sql);
                if(empty($rr)){ // 没有数据,表示优惠券没绑定
                    $money = $v->money; // 优惠券金额
                    if($money >= $zong){
                        // 当优惠券金额比总价格高时,修改优惠券状态为(未使用)
                        $sql = "update lkt_coupon set type = 0 where id = '$id'";
                        $db->update($sql);
                        $arr['coupon_id'] = ''; // 付款金额
                        $arr['money'] = ''; // 优惠券金额
                        $arr['coupon_money'] = $zong; // 付款金额
                        $arr['user_money'] = $user_money; // 用户余额
                        $arr['user_score'] = $user_score; // 用户积分
                        echo json_encode(array('status'=>0,'arr'=>$arr,'err'=>'优惠券金额过大!'));
                        exit;
                    }else{
                        $arr['coupon_id'] = $id; // 付款金额
                        $arr['money'] = $v->money; // 优惠券金额
                        $arr['coupon_money'] = $zong - $money; // 付款金额
                        $arr['user_money'] = $user_money; // 用户余额
                        $arr['user_score'] = $user_score; // 用户积分
                        echo json_encode(array('status'=>1,'arr'=>$arr));
                        exit;
                    }
                }else{ // 有数据
                    $arr['coupon_id'] = ''; // 付款金额
                    $arr['money'] = ''; // 优惠券金额
                    $arr['coupon_money'] = $zong; // 付款金额
                    $arr['user_money'] = $user_money; // 用户余额
                    $arr['user_score'] = $user_score; // 用户积分
                    echo json_encode(array('status'=>1,'arr'=>$arr));
                    exit;
                }
            }
        }else{
            $arr['money'] = ''; 
            $arr['coupon_id'] = '';
            $arr['coupon_money'] = $zong; // 付款金额
            $arr['user_money'] = $user_money; // 用户余额
            $arr['user_score'] = $user_score; // 用户积分
            echo json_encode(array('status'=>1,'arr'=>$arr));
            exit;
        }
    }

    // 显示购物车列表
    public function Shopping(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$this->store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }
        $arr = [];
        $uid = trim($request->getParameter('user_id')); //  '分类ID'
        $sql_c = 'select a.*,c.price,c.name,c.color,c.size,c.img,c.num as pnum,m.product_title,c.id AS sizeid from lkt_cart AS a LEFT JOIN lkt_product_list AS m  ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id where c.num >0 and a.Uid = \''.$uid.'\'';
        
        $r_c = $db->select($sql_c);
        foreach ($r_c as $key => $value) {
            $imgurl = $img.$value->img;/* end 保存*/
            $size = $value->name.' '.$value->size.' '.$value->color;
            if($value->name == $value->size && $value->size == $value->color){
                $size = $value->name;
            }
            $arr[$key] = array('id' => $value->id,'uid' => $uid,'pnum' => $value->pnum,'sizeid' => $value->sizeid,'pid' => $value->Goods_id,'size' => $size,'price' => $value->price,'num' => $value->Goods_num,'pro_name' => $value->product_title,'imgurl' =>$imgurl);
        }
        echo json_encode(array('status' => 1, 'cart' => $arr));
        exit;
    }

    // 清空购物车
    public function delAll_cart(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $user_id = addslashes(trim($request->getParameter('user_id')));
        $sql = 'delete from lkt_cart where Uid="'.$user_id.'"';
        $res = $db -> delete($sql);
        if($res){
            echo json_encode(array('status'=>1,'succ'=>'操作成功!'));
            exit;
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit;
        }
    }


    // 删除购物车指定商品  
    public function delcart(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $carts = addslashes(trim($request->getParameter('carts')));

        $cartstr=trim($carts,','); // 移除两侧的逗号
        $cartArr=explode(',',$cartstr); // 字符串打散为数组
        //循环删除指定的购物车商品
        foreach ($cartArr as $key => $value) {
            $sql = 'delete from lkt_cart where id="'.$value.'"';
            $res = $db -> delete($sql);
        }

        if($res){
            echo json_encode(array('status'=>1,'succ'=>'操作成功!'));
            exit;
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit;
        }
    }

    // 移动购物车指定商品去收藏  
    public function to_Collection(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //购物车商品
        $carts = $request->getParameter('carts');
        //用户id
        $userid = addslashes(trim($request->getParameter('user_id')));

        $cartstr=trim($carts,','); // 移除两侧的逗号
        $cartArr=explode(',',$cartstr); // 字符串打散为数组
        //循环移动并删除指定的购物车商品
        foreach ($cartArr as $key => $value) {
            //查询商品id
            $csql = "select Goods_id from lkt_cart where id='$value' ";
            $cres = $db -> select($csql);
            $pid = $cres[0]->Goods_id;
            //添加至收藏
            $this->addFavorites($userid,$pid);
            //删除指定购物车id
            $sql = 'delete from lkt_cart where id="'.$value.'"';
            $res = $db -> delete($sql);
        }

        if($res){
            echo json_encode(array('status'=>1,'succ'=>'操作成功!'));
            exit;
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit;
        }
    }

    public function addFavorites($openid,$pid){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // $openid = $_POST['openid']; // 微信id
        // $pid = $_POST['pid']; // 产品id
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where wx_id = '$openid'";
        $r = $db->select($sql);
        $user_id = $r[0]->user_id;
        // 根据用户id,产品id,查询收藏表
        $sql = "select * from lkt_user_collection where user_id = '$user_id' and p_id = '$pid'";
        $r = $db->select($sql);
        if (!$r) {
            // 在收藏表里添加一条数据
            $sql = "insert into lkt_user_collection(user_id,p_id,add_time) values('$user_id','$pid',CURRENT_TIMESTAMP)";
            $r = $db->insert($sql);
        }
    }

    // 用户修改购物车数量操作
    public function up_cart(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $cart_id = trim($request->getParameter('cart_id'));
        $num = trim($request->getParameter('num'));
        $user_id = trim($request->getParameter('user_id'));

        $sql_num = "select c.num from lkt_cart as a LEFT JOIN lkt_configure AS c ON a.Size_id = c.id where a.id = '$cart_id'";
        $r_num = $db->select($sql_num);
        $pnum = $r_num[0]->num;

        if($pnum > $num){
            $sql_u = "update lkt_cart set Goods_num = '$num' where id = '$cart_id' and Uid = '$user_id'";
            $r_u = $db->update($sql_u);
            if($r_u){
                echo json_encode(array('status'=>1,'succ'=>'操作成功!'));
                exit;
            }else{
                echo json_encode(array('status'=>0,'err'=>'操作失败!'));
                exit;
            }   
        }else{
                echo json_encode(array('status'=>0,'err'=>'库存不足!'));
                exit;
        }

    
    }

    //余额支付
    public function wallet_pay(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $uid = trim($request->getParameter('uid')); // 微信id
        $total = trim($request->getParameter('total')); // 付款余额
        // 根据微信id,查询用户列表(支付密码,钱包余额,用户id)
        $sql_user = "select password,money,user_id from lkt_user where wx_id='$uid'";
        $r_user = $db->select($sql_user);
        $user_money = $r_user['0']->money; // 用户余额
        $userid = $r_user['0']->user_id; // 用户id

        if($user_money > $total){
            // 根据微信id,修改用户余额
            $sql = "update lkt_user set money = money-'$total' where user_id = '$userid'";
            $r = $db->update($sql);
            $event = $userid.'使用了'.$total.'元余额';
            $sqll = "insert into lkt_record (user_id,money,oldmoney,event,type) values ('$userid','$total','$user_money','$event',4)";
            $rr = $db->insert($sqll);
            echo json_encode(array('status' => 1, 'succ' => '扣款成功!')); 
        }else{
            echo json_encode(array('status' => 0, 'err' => '余额不足！'));
        }
        exit;
    }

    // 创建订单操作
    public function payment(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();
        $cart_id = trim($request->getParameter('cart_id')); // 购物车id
        $uid = trim($request->getParameter('uid')); // 微信id
        $type = trim($request->getParameter('type')); // 用户支付方式
        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $r_name =  trim($request->getParameter('name')); // 用户使用满减金额名称
        $reduce_money =  trim($request->getParameter('reduce_money')); // 用户使用满减金额
        $allow = trim($request->getParameter('allow')); // 用户使用积分
        $total = $_POST['total']; // 付款金额
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$this->store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }
        if($r_name){
            $coupon_activity_name = $r_name;
        }else{
            $coupon_activity_name = '';
        }
        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money from lkt_user where wx_id=\''.$uid.'\'';
        $r_user = $db->select($sql_user);
        $userid = $r_user['0']->user_id; // 用户id
        $user_money = $r_user['0']->money; // 用户余额
        
        if($type == 'wallet_Pay' && $user_money < $total){ // 当余额小于付款金额
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '余额不足！'));
            exit;
        }else{
            // 根据用户id、默认地址,查询地址信息
            $sql_a = 'select * from lkt_user_address where uid=\''.$userid.'\' and is_default = 1';
            $r_a = $db->select($sql_a);
            $name = $r_a['0']->name; // 联系人
            $mobile = $r_a['0']->tel; // 联系电话
            $address = $r_a['0']->address_xq; // 加省市县的详细地址
            $z_num = 0;
            $z_price = 0;
            $sheng = $r_a['0']->sheng; // 省
            $shi = $r_a['0']->city; // 市
            $xian = $r_a['0']->quyu; // 县
            $sNo = $this ->order_number(); // 生成订单号
            //  拆分购物ID 依次插入数据库
            $typestr=trim($cart_id,',');
            $typeArr=explode(',',$typestr);
            foreach ($typeArr as $key => $value) {
                // 联合查询返回购物信息
                $sql_c = "select a.Size_id,a.Goods_num,a.Goods_id,a.id,m.product_title,m.volume,c.price,c.name,c.color,c.size,c.img,c.yprice from lkt_cart AS a LEFT JOIN lkt_product_list AS m ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id where a.id = '$value' and c.num >= a.Goods_num ";

                $r_c = $db->select($sql_c);
                $od_id = [];
                if(!empty($r_c)){
                    $product = (array)$r_c['0']; // 转数组
                    $product['photo_x'] = $img.$product['img'];/* 拼接图片链接*/
                    $num = $product['Goods_num']; // 商品数量
                    $z_num += $num; // 商品数量
                    $price = $product['price']; // 商品价格
                    $z_price += $num*$price; // 总价
                    $pid = $product['Goods_id']; // 商品id
                    $product_title = $product['product_title']; // 商品名称
                     $size_id = $product['Size_id']; // 商品Size_id  
                    //写入配置
                    $size = $product['name'].' '.$product['size'].' '.$product['color'];
                    if($product['name'] == $product['size'] && $product['size'] == $product['color']){
                        $size = $product['name'];
                    }
                    // 循环插入订单附表
                   $sql_d = 'insert into lkt_order_details(user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid) VALUES '."('$userid','$pid','$product_title','$price','$num','件','$sNo',CURRENT_TIMESTAMP,0,'$size','$size_id')";

                    $od_id[$key] = $db->insert($sql_d,'last_insert_id');

                    // 删除对应购物车内容
                    $sql_del = 'delete from lkt_cart where id="'.$value.'"';
                    $res_del = $db -> delete($sql_del);

                }else{
                    //回滚删除已经创建的订单
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                    exit;
                }
            }
            $spz_price = $z_price;
            // 判断积分使用
            if ($allow >0 && $allow != 'undefined') {
                $z_price = $z_price - $allow;
            }else{
                $allow = 0;
            }

            // 判断满减金额
            if ($reduce_money >0 && $reduce_money != 'undefined') {
                $z_price = $z_price - $reduce_money;
            }else{
                $reduce_money = 0;
            }
            //判断优惠券
            if($coupon_id){
                $sql = "select * from lkt_coupon where id = '$coupon_id'";
                $r_coupon = $db->select($sql);
                $c_money = $r_coupon[0]->money;
                $z_price = $z_price - $c_money;
            }else{
                $coupon_id = 0;
                $c_money = 0;
                $z_price = $z_price;
            }

            // 在订单表里添加一条数据
            $sql_o = 'insert into lkt_order(user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,remark,pay,add_time,status,coupon_id,allow,coupon_activity_name,spz_price,reduce_price,coupon_price) VALUES '."('$userid','$name','$mobile','$z_num','$z_price','$sNo','$sheng','$shi','$xian','$address',' ','$type',CURRENT_TIMESTAMP,0,'$coupon_id','$allow','$coupon_activity_name','$spz_price','$reduce_money','$c_money')";
            $r_o = $db->insert($sql_o,"last_insert_id");
            if($r_o > 0){
                $sql = "update lkt_user set score = score - '$allow' where user_id = '$userid'";
                $db->update($sql);

                $db->commit();
                //返回
                $arr = array('pay_type' => $type,'sNo' => $sNo,'coupon_money' => $z_price,'coupon_id' => $coupon_id,'order_id' => $r_o);
                echo json_encode(array('status' => 1, 'arr' => $arr));
                exit;
            }else{
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '请勿重复下单！'));
                exit;
            }
        }
    }

    // 生成订单号
    private function order_number(){
        return date('Ymd',time()).time().rand(10,99);//18位
    }

    // 付款后修改订单状态,并修改商品库存
    public function up_order(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $allow = trim($request->getParameter('allow')); // 用户使用积分
        $coupon_money = trim($request->getParameter('coupon_money')); // 付款金额
        $order_id = trim($request->getParameter('order_id')); // 订单号
        $user_id = trim($request->getParameter('user_id')); // 微信id
        $d_yuan = trim($request->getParameter('d_yuan')); // 抵扣余额
        $trade_no = trim($request->getParameter('trade_no')); // 抵扣余额
        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money from lkt_user where wx_id=\''.$user_id.'\'';
        $r_user = $db->select($sql_user);
        if($r_user){
            $userid = $r_user['0']->user_id; // 用户id
            $user_money =  $r_user['0']->money; // 用户余额
            if($allow){
                $record = "会员" . $userid . "消费了" . $allow . "积分";
                $sql = "insert into lkt_sign_record (user_id,sign_score,record,sign_time,type) values ('$userid','$allow','$record',CURRENT_TIMESTAMP,1)";
                $r_sign = $db->insert($sql);
            }
            if($d_yuan){
                // 使用组合支付的时候 lkt_combined_pay
                $sql = "update lkt_user set money = money-'$d_yuan' where user_id = '$userid'";
                $r = $db->update($sql);
                $weixin_pay = $coupon_money - $d_yuan;
                //写入日志
                $sqll = "insert into lkt_combined_pay (weixin_pay,balance_pay,total,order_id,add_time,user_id) values ('$weixin_pay','$d_yuan','$coupon_money','$order_id',CURRENT_TIMESTAMP,'$user_id')";
                $rr = $db->insert($sqll);
                // 根据修改支付方式
                $sql_combined = "update lkt_order set pay = 'combined_Pay' where sNo = '$order_id' and user_id = '$userid' ";
                $r_combined = $db->update($sql_combined);

                //微信支付记录-写入日志
                $event = $userid.'使用组合支付了'.$coupon_money.'元--订单号:'.$order_id;
                $sqll = "insert into lkt_record (user_id,money,oldmoney,event,type) values ('$userid','$coupon_money','$d_yuan','$event',4)";
                $rr = $db->insert($sqll);
            }

            if($trade_no){
                //微信支付记录-写入日志
                $event = $userid.'使用微信支付了'.$coupon_money.'元--订单号:'.$order_id;
                $sqll = "insert into lkt_record (user_id,money,oldmoney,event,type) values ('$userid','$coupon_money','$d_yuan','$event',4)";
                $rr = $db->insert($sqll);
            }

            // 根据用户id、优惠券id,修改优惠券状态(已使用)
            $sql = "update lkt_coupon set type = 2 where user_id = '$userid' and id = '$coupon_id'";
            $db->update($sql);
            // 根据订单号、用户id,修改订单状态(未发货)
            $sql_u = "update lkt_order set status = 1,trade_no='$trade_no' where sNo = '$order_id' and user_id = '$userid' ";
            $r_u = $db->update($sql_u);
            // 根据订单号,查询商品id、商品名称、商品数量
            $sql_o = "select p_id,num,p_name,sid from lkt_order_details where r_sNo = '$order_id' ";
            $r_o = $db->select($sql_o);
            // 根据订单号,修改订单详情状态(未发货)
            $sql_d = "update lkt_order_details set r_status = 1 where r_sNo = '$order_id' ";
            $r_d = $db->update($sql_d);
            // 修改产品数据库数量
            $pname = '';
            foreach ($r_o as $key => $value) {
                $pid = $value->p_id; // 商品id
                $num = $value->num; // 商品数量
                $p_name = $value->p_name; // 商品名称
                $sid = $value->sid; // 商品属性id
                $pname .= $p_name;
                // 根据商品id,修改商品数量
                $sql_p = "update lkt_configure set  num = num - $num where id = $sid";
                $r_p = $db->update($sql_p); 
                // 根据商品id,修改卖出去的销量
                $sql_x = "update lkt_product_list set volume = volume + $num,num = num-$num where id = $pid";
                $r_x = $db->update($sql_x); 
            }

            if($r_u){
                // 根据订单号,查询订单id、订单金额
                $sql_id = "select id,z_price from lkt_order where sNo = '$order_id' ";
                $r_id = $db->select($sql_id);
                $id = $r_id['0']->id; // 订单id
                $time =date("Y-m-d h:i:s",time()); // 当前时间
                echo json_encode(array('status'=>1,'succ'=>'操作成功!','sNo' => $order_id,'coupon_money' => $coupon_money,'id' => $id,'pname'=>$pname,'time'=>$time));
                exit;
            }else{
                echo json_encode(array('status'=>0,'err'=>'操作失败!'));
                exit;
            }
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit;
        }
    }

     // 发送评论数据
    public function comment(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $order_id = trim($request->getParameter('order_id')); // 订单号
        $user_id = trim($request->getParameter('user_id')); // 微信id
        $pid = trim($request->getParameter('pid')); // 商品id
        $attribute_id = trim($request->getParameter('attribute_id')); // 属性id
        $store_id = trim($request->getParameter('store_id')); // 商品id
        // 查询系统参数
        $sql1 = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql1);

        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }

        $sql_user = 'select user_id from lkt_user where wx_id=\''.$user_id.'\'';
        $r_user = $db->select($sql_user);

        if($r_user){
            if($pid && $attribute_id){
                $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid from lkt_order_details AS a LEFT JOIN lkt_configure AS m ON a.sid = m.id  where a.r_sNo = '$order_id' and a.p_id = '$pid' and a.sid = '$attribute_id' and a.r_status = 3 ";
            }else{
                $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid from lkt_order_details AS a LEFT JOIN lkt_configure AS m ON a.sid = m.id  where a.r_sNo = '$order_id' and (a.r_status = 3 or a.r_status = 1 or a.r_status = -1)";
            }
            $r_o = $db->select($sql_o);
            
            if($r_o){
                foreach ($r_o as $key => $value) {
                    $arr = (array)$value;
                    $imgurl = $arr['img'];/* end 保存*/
                    $arr['commodityIcon']=$img.$imgurl;
                    $obj = (object)$arr;
                    $res[$key] = $obj;
                }
                echo json_encode(array('status'=>1,'commentList'=>$res));
                exit;
            }
        }
    }
    //添加评论
    public function t_comment(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $type = trim($request->getParameter('type'));
        if($type == 'file'){
            //处理评论图片
            $id = trim($request->getParameter('id'));//评论ID
            // 查询配置表信息
            $store_id = trim($request->getParameter('store_id'));
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            $uploadImg = $r[0]->uploadImg;  
            // 图片上传位置
            if(empty($uploadImg)){
                $uploadImg = "./images";
            }
            $imgURL=($_FILES['imgFile']['tmp_name']);
            $type = str_replace('image/', '.', $_FILES['imgFile']['type']);
            $imgURL_name=time().mt_rand(1,1000).$type;
            move_uploaded_file($imgURL,$uploadImg.$imgURL_name);
            $sql ="insert into lkt_comments_img(comments_url,comments_id,add_time) VALUES ('$imgURL_name','$id',CURRENT_TIMESTAMP)";
            $res = $db->insert($sql);
            
            if(!$res){
                echo json_encode(array('status'=>0,'err'=>'修改失败'));
                exit;
            }
        }else{
            //接收评论JSON数据  
            $json = json_decode (file_get_contents('php://input'));
            $comments = $json->comments;
            $r_d = 0;
            $oid = '';

            $store_id = trim($request->getParameter('store_id'));
            // 查询配置表信息
            $sql1 = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql1);

            $uploadImg = $r[0]->uploadImg; 
            // 图片上传位置
            if(empty($uploadImg)){
                $uploadImg = "./images";
            }
            //敏感词表
            require('badword.src.php');

            foreach ($comments as $key => $value){
                $oid =  $value->orderId; // 订单号
                $uid =  $value->userid; // 微信id
                $pid =  $value->commodityId; // 商品id
                $images =  $value->images; // 商品id
                $size =  $value->size; // 属性名称
                $attribute_id =  $value->attribute_id; // 属性id
                $content =  $value->content; // 评论内容
                $badword1 = array_combine($badword,array_fill(0,count($badword),'*'));

                $content = preg_replace ( "/\s(?=\s)/","\\1", $this->strtr_array($content, $badword1));

                //特殊字符处理
                $content = htmlentities($content);

                $CommentType =  $value->score; // 评论类型
                $arr = array();
                if($content != '' || count($images) != 0){
                    $sql_c = "select oid from lkt_comments where oid = '$oid' and pid = '$pid' and attribute_id = '$attribute_id' ";
                    $r_c = $db->select($sql_c);
                    if(empty($r_c['0'])){
                        $sql_d = 'insert into lkt_comments(oid,uid,pid,attribute_id,size,content,CommentType,add_time) VALUES '."('$oid','$uid','$pid','$attribute_id','$size','$content','$CommentType',CURRENT_TIMESTAMP)";
                        $cid[$value->pingid] = $db->insert($sql_d,'last_insert_id');
                        if($cid){
                            $sql_d = "update lkt_order_details set r_status = 5 where r_sNo = '$oid' and sid = '$attribute_id'";
                            $r_d = $db->update($sql_d);

                            $sql = "select r_status from lkt_order_details where r_sNo = '$oid'";
                            $rr = $db->select($sql);
                            if($rr){
                                foreach($rr as $k => $v){
                                    $r_status[] = $v->r_status;
                                }
                                $arr = array_count_values($r_status);
                                if($arr[5] == count($rr)){
                                    $sql = "update lkt_order set status = 5 where sNo = '$oid'";
                                    $db->update($sql);
                                }
                            }
                            echo json_encode(array('status'=>1,'succ'=>'评论成功!','arrid'=>$cid));
                            exit; 
                        }else{
                            echo json_encode(array('status'=>0,'err'=>'修改失败'));
                            exit;
                        }
                    }else{
                        echo json_encode(array('status'=>0,'err'=>'亲!评论过了1'));
                        exit; 
                    } 
                }
            }
        }
    }
    //替换
    function strtr_array($str,$replace_arr) {
        $maxlen = 0;$minlen = 1024*128;
        if (empty($replace_arr)) return $str;
        foreach($replace_arr as $k => $v) {
            $len = strlen($k);
            if ($len < 1) continue;
            if ($len > $maxlen) $maxlen = $len;
            if ($len < $minlen) $minlen = $len;
        }
        $len = strlen($str);
        $pos = 0;$result = '';
        while ($pos < $len) {
            if ($pos + $maxlen > $len) $maxlen = $len - $pos; 
            $found = false;$key = '';
            for($i = 0;$i<$maxlen;++$i) $key .= $str[$i+$pos]; 
            for($i = $maxlen;$i >= $minlen;--$i) {
                $key1 = substr($key, 0, $i);
                if (isset($replace_arr[$key1])) {
                    $result .= $replace_arr[$key1];
                    $pos += $i;
                    $found = true;
                    break;
                }
            }
            if(!$found) $result .= $str[$pos++];
        }
        return $result;
    }
    //显示新产品
    public function new_product(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = trim($request->getParameter('cid')); //  '分类ID'
        $paegr = trim($request->getParameter('page')); //  '页面'

        $select = trim($request->getParameter('select')); //  选中的方式 0 默认  1 销量   2价格
        if($select == 0){
             $select = 'a.add_date'; 
        }elseif ($select == 1) {
             $select = 'a.volume'; 
        }else{
             $select = 'price'; 
        }

        $sort = trim($request->getParameter('sort')); // 排序方式  1 asc 升序   0 desc 降序
        if($sort){
             $sort = ' asc '; 
        }else{
             $sort = ' desc '; 
        }
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$this->store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }
        if(!$paegr){
            $paegr = 1;
        }
        $start = ($paegr-1)*10;
        $end = 10;
        // $sql = "select a.id,a.product_title,volume,c.price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.s_type = \'" .$id."' and c.num >0 order by $select $sort LIMIT $start,$end ";
        $sql ="select a.id,a.product_title,a.volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.s_type = ".$id." and a.num >0 group by c.pid order by $select $sort LIMIT $start,$end ";
        // print_r($sql);die;
        $r = $db->select($sql);
        if($r){
            $product = [];
            foreach ($r as $k => $v) {
                $imgurl = $img.$v->img;/* end 保存*/
                // $names = ' '.$v->name . $v->color ;
                // if($v->name == $v->color || $v->name == '默认'){
                //     $names = '';
                // }
                $pid = $v->id;
                $sql_ttt = "select price,yprice from lkt_configure where pid ='$pid' order by price asc ";
                $r_ttt = $db->select($sql_ttt);
                $price =$r_ttt[0]->yprice;
                $price_yh =$r_ttt[0]->price;
                $product[$k] = array('id' => $v->id,'name' => $v->product_title ,'price' => $price,'price_yh' => $price_yh,'imgurl' => $imgurl,'volume' => $v->volume,'s_type' => $v->s_type);
            }
            echo json_encode(array('status'=>1,'pro'=>$product));
            exit;
        }else{
            echo json_encode(array('status'=>0,'err'=>'没有了！'));
            exit;
        }
    }
}
?>