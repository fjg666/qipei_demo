<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class addFavoritesAction extends Action {
    /*
    时间2018年03月13日
    修改内容：修改首页商品及分类请求数据
    修改人：苏涛
    主要功能：处理小程序首页请求结果
    公司：湖南壹拾捌号网络技术有限公司
     */
    public function getDefaultView() {
        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        if($app != 'similar'){
            if(!empty($access_id)){ // 存在
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }
                $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
                $r = $db->select($sql);
                if($r){
                    $user_id = $r[0]->user_id;
                    $this->db = $db;
                    $this->user_id = $user_id;
                    $this->store_id = $store_id;

                }else{
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }
            }else{
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }
        $this->$app();
        exit;
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 点击收藏
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $pro_id = trim($request->getParameter('pro_id')); // 商品id
        $type = intval($request->getParameter('type'))?intval($request->getParameter('type')):1;
        $user_id = $this->user_id;

        $c = '';
        if ($type == 2) {
            $c = ' and type=2';
        }

        // 根据用户id,产品id,查询收藏表
        $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$pro_id' $c";
        $r = $db->select($sql);
        if ($r) {
            echo json_encode(array('code'=>104,'message'=>'已经收藏！'));
            exit();
        }else{
            // 在收藏表里添加一条数据
            $sql = "insert into lkt_user_collection(store_id,user_id,p_id,add_time,type) values('$store_id','$user_id','$pro_id',CURRENT_TIMESTAMP,'$type')";
            $r = $db->insert($sql,'last_insert_id');
            if($r > 0){
                echo json_encode(array('code'=>200,'collection_id'=>$r,'message'=>'添加成功！'));
                exit();
            }else{
                echo json_encode(array('code'=>105,'message'=>'网络繁忙！'));
                exit();
            }
        }
        return;
    }
    // 查看收藏
    public function collection(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $type = trim($request->getParameter('type'));
        $user_id = $this->user_id;

        $arr = array();

        if($type == 1){
            // 根据用户id、收藏表中的产品id与产品表中的id,查询收藏表(id,产品id)、产品表(产品名称)
            $sql = "select c.id,c.p_id,a.product_title,a.mch_id from lkt_user_collection as c left join lkt_product_list as a on c.p_id = a.id where a.store_id = '$store_id' and c.type=1 and c.user_id = '$user_id' order by c.add_time desc";
            $r_1 = $db->select($sql);
            if($r_1){
                foreach ($r_1 as $k => $v) {
                    $array = (array)$v;
                    $mch_id = $array['mch_id'];
                    // 根据商城ID、用户ID、店铺审核状态通过，查询是否有店铺
                    $sql0 = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id' ";
                    $r0 = $db->select($sql0);
                    if($r0){
                        $array['mch_name'] = $r0[0]->name;
                    }else{
                        $array['mch_name'] = '';
                    }

                    $pid = $array['p_id'];
                    $sql = "select img,price,yprice from lkt_configure where pid = '$pid'";
                    $rr = $db->select($sql);

                    $array['price'] = $rr[0]->price;
                    $array['yprice'] = $rr[0]->yprice;
                    $array['imgurl'] = ServerPath::getimgpath($rr[0]->img);
                    $v = (object)$array;
                    $arr[$k] = $v;
                }
            }
            echo json_encode(array('code'=>200,'data'=>$arr,'message'=>'添加成功！'));
            exit();
        }else{
            // 根据用户id、收藏表中的产品id与产品表中的id,查询收藏表(id,产品id)、产品表(产品名称)
            $sql = "select a.id as shopid,c.id,c.mch_id,a.logo as img,a.name as mch_name,a.collection_num from lkt_user_collection as c left join lkt_mch as a on c.mch_id = a.id where a.store_id = '$store_id' and c.type=1 and c.user_id = '$user_id' order by c.add_time desc";
            $r_1 = $db->select($sql);
            if($r_1){
                foreach ($r_1 as $k => $v) {

                    $shop_id = $v->shopid;
                    $sql0_0 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id'";
                    $r0_0 = $db->select($sql0_0);
                    $v->collection_num = count($r0_0);

                    $v->img = ServerPath::getimgpath($v->img);
                    $arr[$k] = $v;
                }
            }
            echo json_encode(array('code'=>200,'data'=>$arr,'message'=>'添加成功！'));
            exit();
        }

        return;
    }

    // 取消收藏
    public function removeFavorites(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $collection = $request->getParameter('collection'); // 收藏商品id
        $type = intval($request->getParameter('type')); 
        $user_id = $this->user_id;

        $c = '';
        if ($type == 2) {
            $c = ' and type=2';
        }

        $coll = explode(',', $collection);
        $collection = array();
        foreach ($coll as $k => $v) {
            if (!empty($v)) {
                $collection[] = $v;
            }
        }

        $typeArr = array();
        if(!empty($collection)){
            if(is_array($collection)){ // 是数组
                foreach ($collection as $key => $value) {
                    $typeArr[$key] = $value;
                }
            }else if(is_string($collection)){ // 是字符串
                $typestr=trim($collection,','); // 移除两侧的逗号
                $typeArr=explode(',',$typestr); // 字符串打散为数组
            }
        }
        $num = 0;
        //进入正式添加---开启事物
        $db->begin();

        foreach ($typeArr as $k => $v) {
            $sql0 = "select mch_id from lkt_user_collection where store_id = '$store_id' and id = '$v' and user_id = '$user_id' $c";
            $r0 = $db->select($sql0);
            if($r0){
                $mch_id = $r0[0]->mch_id;
                if($mch_id != 0){
                    $sql1 = "update lkt_mch set collection_num = collection_num - 1 where store_id = '$store_id' and id = '$mch_id' ";
                    $r1 = $db->update($sql1);
                    if($r1 == -1){
                        $db->rollback();

                        echo json_encode(array('code'=>105,'message'=>'网络繁忙！'));
                        exit();
                    }
                }
                $sql = "delete from lkt_user_collection where store_id = '$store_id' and id = '$v' and user_id = '$user_id' $c";
                $r = $db->delete($sql);
                if($r > 0){
                    $num = ++$num;
                }
            }else{
                $db->rollback();
                echo json_encode(array('code'=>105,'message'=>'网络繁忙！'));
                exit();
            }
        }
        // 根据收藏id,删除收藏表信息
        if(count($typeArr) == $num){
            $db->commit();

            echo json_encode(array('code'=>200,'message'=>'取消成功！'));
            exit();
        }else{
            $db->rollback();

            echo json_encode(array('code'=>105,'message'=>'网络繁忙！'));
            exit();
        }

        return;
    }

    // 找相似
    public function similar(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $pro_id = trim($request->getParameter('pro_id')); // 商品id
        $list = array();
        $sql_t = "select a.id,a.product_title,a.product_class,a.brand_id,a.imgurl,a.volume,a.keyword,a.mch_id,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$pro_id' ";

        $r_t = $db->select($sql_t);
        if($r_t){
            $mch_id = $r_t[0]->mch_id;
            $keyword = $r_t[0]->keyword; // 品牌id
            $r_t[0]->imgurl = ServerPath::getimgpath($r_t[0]->imgurl);

            // 根据商城ID、用户ID、店铺审核状态通过，查询是否有店铺
            $sql0 = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id' ";
            $r0 = $db->select($sql0);
            if($r0){
                $r_t[0]->mch_name = $r0[0]->name;
            }else{
                $r_t[0]->mch_name = '';
            }
            $sql_t1 = "select a.id,a.product_title,a.imgurl,a.volume,a.mch_id,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.recycle = 0 and a.mch_status = 2 and a.active = 1 and a.keyword like '%$keyword%' group by c.pid  order by a.sort,a.add_date DESC LIMIT 0,20";
            $r_t1 = $db->select($sql_t1);
            if($r_t1){
                foreach ($r_t1 as $k => $v){
                    $mch_id1 = $v->mch_id;
                    $v->imgurl = ServerPath::getimgpath($v->imgurl);

                    // 根据商城ID、用户ID、店铺审核状态通过，查询是否有店铺
                    $sql0 = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id1' ";
                    $r0 = $db->select($sql0);
                    if($r0){
                        $v->mch_name = $r0[0]->name;
                    }else{
                        $v->mch_name = '';
                    }
                }
            }
            $list[] = $r_t1;
            echo json_encode(array('code'=>200,'product'=>$r_t,'list'=>$list,'message'=>'成功！'));
            exit;
        }else{
            echo json_encode(array('code'=>200,'list'=>$list,'message'=>'成功！'));
            exit;
        }
        return;
    }
}
?>