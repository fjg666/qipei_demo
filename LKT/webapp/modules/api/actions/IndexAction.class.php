<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');
require_once('Apimiddle.class.php');

class IndexAction extends Apimiddle {
    /*
    时间2018年03月13日
    修改内容：修改首页商品及分类请求数据
    修改人：苏涛
    主要功能：处理小程序首页请求结果
    公司：湖南壹拾捌号网络技术有限公司
     */
    public $db;
    public $config;
    public $img;
    public $block_list = [];


    public function getDefaultView() {
        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        //软件类型
        $store_type = trim($request->getParameter('store_type')) ? trim($request->getParameter('store_type')):1;
        //商城id
        $store_id = trim($request->getParameter('store_id')) ? trim($request->getParameter('store_id')):1;

        $this->store_type = $store_type;
        $this->store_id = $store_id;
        $this->$m();

//        if($m == 'index'){
//            $this->index();
//        }elseif ($m == 'get_more') {
//            $this->get_more();
//        }elseif ($m == 'draw') {
//            $this->draw();
//        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    // 获取小程序首页数据
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
            $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
            if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
                $img = $uploadImg_domain . $uploadImg; // 图片路径
            }else{ // 不存在
                $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
            }
            $this->img = $img;
            $title = $r_1[0]->company;
            $logo = ServerPath::getimgpath($r_1[0]->logo);
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        $shou = [];
        $sql_t = "select a.id,a.product_title,a.volume,min(c.price) as price,c.yprice,a.imgurl,c.name,a.distributor_id from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.distributor_id > '0' and a.status = 0 and a.num >0 group by c.pid  order by a.sort DESC LIMIT 0,20";
        $r_t = $db->select($sql_t);

        $user_id = trim($request->getParameter('user_id'));
        $sql = "select g.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where d.store_id = '$store_id' and d.user_id = '$user_id' ";
        $r = $db -> select($sql);
        if($r){
            $sets = unserialize($r[0]->sets);
            $djname = $sets['s_dengjiname'];
        }else{
            $djname = '基础会员';
        }

        if($r){
            $sort= $r[0]->sort;
        }else{
            $sort=0;
        }
        //查询用户等级判断是否升级
        $sql011 = "select id,sort from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = 0";
        $variable = $db->select($sql011);
        $distribus = [];
        //列出等级关系
        if($variable){
            foreach ($variable as $key => $value) {
                if($value->sort > $sort){
                    array_push($distribus,$value->id);
                }
            }
        }

        $distributor = [];

        $subarr = $this -> getsubactive($store_id);     //查询当前是否有满减活动
        if($r_t){
            foreach ($r_t as $k => $v) {
                if(in_array($v->distributor_id, $distribus)){
                    $imgurl = ServerPath::getimgpath($v->imgurl);
                    $pid = $v->id;
                    $price =$v->yprice;
                    $price_yh =$v->price;
                    $distributor[$k] = array('id' => $v->id,'name' => $v->product_title,'price' => $price,'price_yh' => $price_yh,'imgurl' => $imgurl,'volume' => $v->volume);
                }
            }
        }

        //查询商品并分类显示返回JSON至小程序
        $sql_c = 'select cid,pname from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=0 order by sort desc';
        $r_c = $db->select($sql_c);
        $twoList = [];
        if($r_c){
            foreach ($r_c as $key => $value) {
                $sql_e = 'select cid,pname,img from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=\''.$value->cid.'\' order by sort desc LIMIT 0,10';
                $r_e = $db->select($sql_e);
                $icons=[];
                if($r_e){
                    foreach ($r_e as $ke => $ve) {
                        $imgurl = ServerPath::getimgpath($ve->img);
                        $icons[$ke] = array('id' => $ve->cid,'name' => $ve->pname,'img' => $imgurl);
                    }
                }else{
                    $icons=[];
                }

                $ttcid = $value->cid;

                $sql_s = "select a.id,a.product_title,a.s_type,a.volume,min(c.price) as price,c.yprice,a.imgurl,c.name from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.product_class like '%-$ttcid-%' and a.status = 0 and a.num >0 group by c.pid  order by a.sort DESC LIMIT 0,10";
                $r_s = $db->select($sql_s);

                $product = [];
                foreach ($r_s as $k => $v) {
                    $imgurl = ServerPath::getimgpath($v->imgurl);
                    $pid = $v->id;
                    $price =$v->yprice;
                    $price_yh =$v->price;
                    $s_type = explode(',',$v->s_type);
                    $xp = 0;
                    $rexiao = 0;
                    $tuijian = 0;
                    if(!empty($subarr) && in_array($pid,$subarr)){       //判断是否是满减产品
                        $issub = true;
                    }else{
                        $issub = false;
                    }
                    foreach ($s_type as $k1 => $v1){
                        if($v1 == 1){
                            $xp = 1;
                        }else if($v1 == 2){
                            $rexiao = 1;
                        }else if($v1 == 3){
                            $tuijian = 1;
                        }
                    }

                    $product[$k] = array('id' => $v->id,'name' => $v->product_title,'price' => $price,'price_yh' => $price_yh,'imgurl' => $imgurl,'volume' => $v->volume,'xp' => $xp,'rexiao' => $rexiao,'tuijian' => $tuijian,'issub' => $issub);
                }
                $twoList['0'] = array('id' => '0','name' => '首页','count' => 1,'twodata' => $shou,'distributor'=>$distributor);
                $twoList[$key+1] = array('id' => $value->cid,'name' => $value->pname,'count' => 1,'twodata' => $product,'icons'=>$icons);
            }
        }else{
            $twoList['0'] = array('id' => '0','name' => '首页','count' => 1,'twodata' => $shou,'distributor'=>$distributor);
        }

        $sql = "select * from lkt_background_color where store_id = '$store_id' and status = 1";
        $r = $db -> select($sql);
        $bgcolor = $r ? $r[0]->color:'#FF6347';

        $sqlfhb = "select user_id from lkt_red_packet_users where store_id = '$store_id' and user_id = '$user_id'";
        $rfhb = $db->select($sqlfhb);

        $indexs = $this->get_index_pages();
        echo json_encode(array('module_list'=>$indexs,'block_list'=>$this->block_list,'djname'=>$djname,'twoList'=>$twoList,'bgcolor'=>$bgcolor,'title'=>$title,'logo'=>$logo,'list'=>$pmd));
        exit();

    }

    public function getsubactive($store_id){
        $db = DBAction::getInstance();
        $subsql = "select goods from lkt_subtraction where store_id = '$store_id' and status = 1";
        $subres = $db -> select($subsql);     //查询当前是否有满减活动
        if(!empty($subres)){
            $subarr = explode(',',$subres[0] -> goods);
        }else{
            $subarr = array();
        }
        return $subarr;
    }

    public function getContent($name)
    {
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $class_name = false;
        $id = 0;
        $db = $this->db;
        $img = $this->img;

        switch ($name) {
            case 'banner': {
                //轮播图
                $sql = "select * from lkt_banner where store_id = '$store_id' and type = 1 order by sort,id";
                $r = $db->select($sql);
                $data = [];
                if($r){
                    foreach($r as $k=>$v){
                        $result = [];
                        $result['id'] = $v->id; // 轮播图id
                        $result['image'] = ServerPath::getimgpath($v->image); // 图片
                        $result['url'] = $v->url; // 链接
                        $data[] = $result;
                        unset($result); // 销毁指定变量
                    }
                }
                break;
            }
            case 'search': {
                // 无需数据
                $data = [];
                break;
            }
            case 'nav': {
                $store_type = $this->store_type;
                $store_id = $this->store_id;
                $sql = "select id,name,pic_url as image,url,open_type from lkt_home_nav where store_id = '$store_id' and `store_type` = '$store_type' and is_delete =0 and is_hide = 0 order by sort desc ";
                $data = $db->select($sql);

                break;
            }
            case 'coupon': {
                // 待完成 优惠券
                $data = [];
                break;
            }
            case 'topic': {
                //专题
                $data = [];
                break;
            }
            case 'pintuan': {
                //
                $data = [];
                break;
            }
            case 'notice': {
                //通知
                $lkt_set_notice = "select id,name from lkt_set_notice where store_id = '$store_id' order by time desc";
                $data = [];
                $res_notice= $db -> select($lkt_set_notice);//公告
                if($res_notice){
                    foreach ($res_notice as $key => $value) {
                        $data[$key] = array('url' => $value->id, 'title' => $value->name);
                    }
                }
                break;
            }
            case 'cat': {
                //所有分类
                $data = [];
                break;
            }
            default: {
                $names = explode('-', $name);
                $name = $names[0];
                $id = $names[1];
                if ($name == 'block') {//自定义首页板块
                    $blocks = $this->HomeBlock_findOne($id);
                    if($blocks){
                        $pic_list = json_decode($blocks->value);
                        $data = array('id' => $blocks->id,'name'=>$blocks->name,'style'=>$blocks->style,'data'=>['pic_list'=>$pic_list],'block_id'=>$blocks->id);
                        array_push($this->block_list, $data);  
                    }else{
                        $data = [];
                    }
                    
                }
                if ($name == 'single_cat') {//单个分类
                    $data = $this->Cat_findOne($id);
                    $class_name = $this->find_cat_name($id);
                }
                break;
            }
        }

        $indexpage = array('name' => $name,'class_name'=>$class_name, 'id' => $id,'block_id' => $id, 'data' =>$data);
        return $indexpage;
    }

    public function HomeBlock_findOne($id)
    {
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $sql_c = "select * from lkt_index_page where store_id = '$store_id' and id = '$id' ";
        $r_c = $this->db->select($sql_c);
        return $r_c ? $r_c[0]:[];
    }



    public function find_cat_name($id)
    {
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $sql_c = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid= '$id' ";
        $r_c = $this->db->select($sql_c);
        return $r_c ? $r_c[0]->pname:'';
    }

    public function Cat_findOne($cid)
    {
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $img = $this->img;
        $type = 0;
        $sqlb = "select a.id,product_title,a.imgurl,a.volume,a.s_type,c.id as cid,c.yprice,c.img,c.name,c.color,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.product_class like '%-$cid-%' and a.status = 0 and a.recycle = 0 group by c.pid order by a.volume desc LIMIT 0,10 ";
        $data = $this->db->select($sqlb);
        $product = [];
        $subarr = $this -> getsubactive($store_id);     //查询当前是否有满减活动
        if(!empty($data)){
            foreach ($data as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->imgurl);/* end 保存*/
                if($type == 1){
                    $cid = $v->product_class;
                }else{
                    $cid = $cid;
                }

                $s_type = explode(',',$v->s_type);
                $xp = 0;
                $rexiao = 0;
                $tuijian = 0;
                foreach ($s_type as $k1 => $v1){
                    if($v1 == 1){
                        $xp = 1;
                    }else if($v1 == 2){
                        $rexiao = 1;
                    }else if($v1 == 3){
                        $tuijian = 1;
                    }
                }

                if(!empty($subarr) && in_array($v->id,$subarr)){       //判断是否是满减产品
                    $issub = true;
                }else{
                    $issub = false;
                }
                $product[$k] = array('id' => $v->id,'name' => $v->product_title,'price' => $v->yprice,'price_yh' => $v->price,'imgurl' => $imgurl,'size'=>$v->cid,'volume' => $v->volume,'s_type' => $v->s_type,'xp' => $xp,'rexiao' => $rexiao,'tuijian' => $tuijian,'issub' => $issub);
            }

        }
        return $product;
    }

    public function getModuleList()
    {
        $mustModule = Navbar::module_list('mustModule');
        // $this->module_list['mustModule']; $authModule = $this->module_list['authModule'];
        $authModule = Navbar::module_list('authModule');

        $store_type = $this->store_type;
        $store_id = $this->store_id;

        //查询分类 顶级
        $sql_c = 'select cid,pname from lkt_product_class where store_id= ' . $store_id . ' and recycle = 0 and sid=0 order by sort desc';
        $r_c = $this->db->select($sql_c);
        if($r_c){
            foreach ($r_c as $key => $value) {
                $arrayName = array('name' => 'single_cat-' . $value->cid, 'display_name' => '分类:' . $value->pname);
                array_push($mustModule, $arrayName);
            }
        }

        //自定义模块
        $sql = "select id,name from lkt_index_page where store_id = '$store_id' and `store_type` = '$store_type' ";
        $r_index = $this->db->select($sql);
        if($r_index){
            foreach ($r_index as $key => $value) {
                $arrayName = array('name' => 'block-' . $value->id, 'display_name' => '版块：' . $value->name);
                array_push($mustModule, $arrayName);
            }
        }

        $newArr = [];
        foreach ($authModule as $item) {
            $newArr[] = $item;
        }

        $module = array_merge($mustModule, $newArr);

        return $module;
    }

    public function get_index_pages()
    {
        $request = $this->getContext()->getRequest();
        // 软件类型
        $store_type = $this->store_type;
        $store_id = $this->store_id;

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'home_page_data'";
        $home_page_data_res = $this->db->select($sql);
        $indexs = [];
        if($home_page_data_res){
            $pages_data = $home_page_data_res[0]->value;
            $pages_data = json_decode($pages_data);
        }else{
            $pages_data = $this->getModuleList();
        }
        foreach ($pages_data as $key => $value) {
            $value = (object)$value;
            $indexs[$key] = $this->getContent($value->name);
        }
        return $indexs;
    }



    // 加载更多商品
    public function get_more(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $paegr = trim($request->getParameter('page')); //  '显示位置'
        $index = trim($request->getParameter('index')); //  '分类ID'

        if(!$paegr){
            $paegr = 1;
        }
        $start = 10*$paegr;
        $end = 10;
        //查询商品并分类显示返回JSON至小程序
        if(!$index){
            echo json_encode(array('prolist'=>[],'status'=>0));
            exit;
        }else{
            //查询商品并分类显示返回JSON至小程序
            $sql_t = "select a.id,a.product_title,a.volume,min(c.price) as price,c.yprice,a.imgurl,c.name from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.num >0 and a.status = 0 and a.recycle = 0 and a.product_class like '%-$index-%' group by c.pid  order by a.sort DESC LIMIT $start,$end";
            $r_s = $db->select($sql_t);
            $product = [];
            if($r_s){
                foreach ($r_s as $k => $v) {
                    $imgurl = ServerPath::getimgpath($v->imgurl);/* end 保存*/
                    $pid = $v->id;
                    $price =$v->yprice;
                    $price_yh =$v->price;
                    $product[$k] = array('id' => $v->id,'name' => $v->product_title,'price' => $price,'price_yh' => $price_yh,'imgurl' => $imgurl,'volume' => $v->volume);
                }
                echo json_encode(array('prolist'=>$product,'status'=>1));
                exit;
            }else{
                echo json_encode(array('prolist'=>$product,'status'=>0));
                exit;
            }
        }
    }
}

?>