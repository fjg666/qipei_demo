<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/version.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');

class AddAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //获取参数
    
        
        //获取顶级级分类
        $sql = "select cid,sid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $res = $db->select($sql);

        //option
        $list = '';
      
        if ($res) {
            foreach ($res as $k => $v) {
                $cid_1 = '-'.$v->cid.'-';
            
                $list .= '<option value="'.$cid_1.'">'.$v->pname.'</option>';
                
                

                //查找一级分类数据
                $sql_1 = "select cid,sid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = {$v->cid}";
                $res_1 = $db->select($sql_1);

                if ($res_1) {
                    foreach ($res_1 as $k2 => $v2) {
                        $cid_2 = $cid_1.$v2->cid.'-';
                        $list .= '<option value="'.$cid_2.'">'.'-----'.$v2->pname.'</option>';
                        
                        //查找二级分类数据
                        $sql_2 = "select sid,cid,pname from lkt_product_class where store_id = $store_id and recycle = 0 and sid = {$v2->cid}";
                        $res_2 = $db->select($sql_2);

                        if ($res_2) {
                            foreach ($res_2 as $k3 => $v3) {
                                $cid_3 = $cid_2.$v3->cid.'-';
                                $list .= '<option value="'.$cid_3.'">'.'----------'.$v3->pname.'</option>';
                            }
                        }
                    }
                }
            }
        }
        
        //商品显示标签
        $sp_type = Tools::s_type($db, '商品类型');
     
        $request->setAttribute('class', $list);
        $request->setAttribute('sp_type', $sp_type);

        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收方法参数
        $m = $request->getParameter('m');
        $this -> $m();
    }
    
    //查询商品分类
    public function proBrand()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $cid = addslashes(trim($request->getParameter('cid')));//产品分类id
       
        $cid = explode('-',$cid);
        $cids = '';
        foreach ($cid as $k => $v) {
            if(!empty($v) && empty($cids)){
                $cids .= $v.',';
            }
        }

        $sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%$cids%' order by sort desc";
        $res = $db -> select($sql);
        if(!empty($res)){
            $arr = array();
            foreach ($res as $key => $value) {
                if(in_array($value->brand_id,$arr)){
                    unset($res[$key]);
                }else{
                    $arr[] = $value->brand_id;
                }
            }
        }
        
        echo json_encode($res);
        exit;
    }
    //查询出竞拍商品
    public function proQuery()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = $this->getContext()->getStorage()->read('store_id');
        $my_class = addslashes(trim($request->getParameter('my_class')));
        $my_brand = addslashes(trim($request->getParameter('my_brand')));
        $pro_name = addslashes(trim($request->getParameter('pro_name')));
       
        $condition = ' and b.recycle = 0 ';
        if ($my_class) {
            $condition .= " and b.product_class like '%{$my_class}%' ";
        }
        if ($my_brand) {
            $condition .= " and b.brand_id = '$my_brand' ";
        }
        if ($pro_name) {
            $condition .= " and b.product_title like '%{$pro_name}%' ";
        }
       
        $sql = "select a.num,a.min_inventory,a.attribute,a.price,a.id as attr_id,b.id,b.product_title,b.imgurl,c.name from lkt_configure as a left join lkt_product_list as b on a.pid = b.id left join lkt_mch as c on b.mch_id = c.id  where b.store_id = '$store_id' and c.store_id = '$store_id' and b.active = 4 and b.status = 2  and a.num > 0 ".$condition."group by b.id ";
        $res = $db->select($sql);
       
        foreach ($res as $k =>$v) {
            $v->image = ServerPath::getimgpath($v->imgurl, $store_id);
            $attr = unserialize($v->attribute);
            $attr = array_values($attr);
            if ($attr) {
                if (gettype($attr[0]) != 'string') {
                    unset($attr[0]);
                }
            }
            $v->attr = implode(',', $attr);
        }

        echo json_encode(array('res'=>$res));
        exit;
    }

    public function proAdd()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $attr_id_check = addslashes(trim($request->getParameter('attr_id_check')));//所选商品的规格id
        $id = $request->getParameter('id');//所选商品的id
        $id = $id[0];
        $title = addslashes(trim($request->getParameter('title')));//竞拍标题
        $product_title =  addslashes(trim($request->getParameter('product_title')));//商品标题
        $price = addslashes(trim($request->getParameter('price')));
        $add_price = addslashes(trim($request->getParameter('add_price')));
        $promise = addslashes(trim($request->getParameter('promise')));
        $starttime = addslashes(trim($request->getParameter('starttime')));
        $endtime = addslashes(trim($request->getParameter('endtime')));
        $s_type = $request->getParameter('s_type');//显示标签
        $is_show = addslashes(trim($request->getParameter('is_show')));//是否显示
        $log = new LaiKeLogUtils('common/auction.log');
        //如果竞拍标题为空，则取商品标题
        if (empty($title)) {
            $title = $product_title;
        }
        //将商品的图片变成竞拍的主图
        $sql_1 = "select imgurl,mch_id from lkt_product_list where store_id = '$store_id' and id = '$id'";
        $res_1 = $db->select($sql_1);

        if ($res_1) {
            $image = $res_1[0]->imgurl;
            $mch_id = $res_1[0]->mch_id;
        }
        //根据商品id，规格id查询出市场价
        $sql = "select price  from lkt_configure where  pid = '$id' and id = '$attr_id_check'";
        $res = $db->select($sql);

        if ($res) {
            $market_price = $res[0]->price;
        }
           
        //序列化  产品id，规格id为二维数组
        $pid_arr =array();
        $pid_arr[$id][$attr_id_check] = $attr_id_check;
        $attribute = serialize($pid_arr);

        //对表单数据进行验证

        if (strlen($title) > 60) {
            echo json_encode(array('status'=>'活动标题长度不能超过20个中文字符'));
            exit;
        }
        if (empty($price) ||  intval($price) <= 0) {
            echo json_encode(array('status'=>'竞拍起价不能为空！'));
            exit;
        }
        if ($price <= 0 || intval($price) <= 0) {
            echo json_encode(array('status'=>'竞拍起价不能小于零！'));
            exit;
        }
        if (empty($add_price)  || intval($add_price) <= 0) {
            echo json_encode(array('status'=>'加价幅度不能为空！'));
            exit;
        }
        if ($add_price <= 0  || intval($add_price) <= 0) {
            echo json_encode(array('status'=>'加价幅度不能小于零！'));
            exit;
        }
        if (empty($promise) || intval($promise) <= 0) {
            echo json_encode(array('status'=>'保证金不能为空'));
            exit;
        }
        if ($promise <= 0 || intval($promise) <= 0) {
            echo json_encode(array('status'=>'保证金不能小于0'));
            exit;
        }

        //s_type 转为字符串
        
        if ($s_type) {
            $s_type = implode(',', $s_type);
        }
       
        //查询出竞拍配置信息
        $sql_2 = "select * from lkt_auction_config where store_id = '$store_id'";
        $res_2 = $db->select($sql_2);
        if ($res_2) {
            $low_pepole = $res_2[0]->low_pepole;
            $wait_time = $res_2[0]->wait_time;
            $days = $res_2[0]->days;
        } else {
            $db->admin_record($store_id, $admin_name, '添加竞拍'.$title.'失败', 1);
            echo json_encode(array('status'=>'竞拍配置未设置'));
            exit;
        }

        //竞拍标题重复判断
        $sql = "select * from lkt_auction_product where  store_id = '$store_id' and recycle = 0 and title = '$title'";
        $res = $db->select($sql);
        if ($res) {
            $db->admin_record($store_id, $admin_name, '添加竞拍'.$title.'失败', 1);
            echo json_encode(array('status'=>'竞拍标题不能重复'));
            exit;
        }

        $invalid_time = date('Y-m-d H:i:s', strtotime($endtime." + $days day"));//竞拍活动具体失效日期

        $sql = "insert into lkt_auction_product (store_id,title,starttime,endtime,price,add_price,market_price,current_price,imgurl,attribute,days,invalid_time,promise,low_pepole,wait_time,mch_id,s_type,is_show)"." values ('$store_id','$title','$starttime','$endtime','$price','$add_price','$market_price','$price','$image','$attribute','$days','$invalid_time','$promise','$low_pepole','$wait_time','$mch_id','$s_type','$is_show')";
        $res = $db->insert($sql);

        if ($res < 0) {
            $log -> customerLog(__LINE__.':添加竞拍活动失败，sql为：'.$sql."\r\n");
            $db->admin_record($store_id, $admin_name, '添加竞拍'.$title.'失败', 1);
            echo json_encode(array('status' => '未知原因，添加失败！'));
            exit;
        } else {
            //竞拍活动添加成功，则给redis默认值，防止缓存穿透，缓存雪崩
            //设置key-》value
            $sql_1 = "select MAX(id) as m_id from lkt_auction_product where store_id = $store_id and title = '$title'";
            $res_1 = $db->select($sql_1);
            if($res_1){
                $a_id = $res_1[0]->m_id;
                //最高价key->value
                $key_price = "AC".$a_id.'max_price';
                $value_price =$price;
                //参与人数key->value
                $key_pepole = "AC".$a_id.'pepole';
                $value_pepole = 0;
                //出价条数key->value
                $key_bid_num = "AC".$a_id.'bid_num';
                $value_bid_num = 0;
                //有效期
                $second = (strtotime($invalid_time) - strtotime('now'));    
                //存入redis
                try {
                    $redis = new RedisClusters();
                    $re = $redis->connect();
                    $redis->set($key_price,$value_price,$second);
                    $redis->set($key_pepole,$value_pepole,$second);
                    $redis->set($key_bid_num,$value_bid_num,$second);
                    $redis->close();
                
                } catch (Exception $e) {
                    echo json_encode(array('suc'=>1,'status'=>'已添加活动成功，但竞拍需要redis支持：'.$e->getMessage()));
                    exit;
                  
                }
               
            
            }
            
            //如果redis不存在，则从数据库中读取
            $db->admin_record($store_id, $admin_name, '添加竞拍'.$title.'失败', 1);
            echo json_encode(array('suc'=>1,'status'=>'添加成功'));
            exit;
        }
    }


    public function getRequestMethods()
    {
        return Request :: POST;
    }
}
