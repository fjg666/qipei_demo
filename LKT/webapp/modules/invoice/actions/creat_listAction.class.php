<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Plugin/subtraction.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class creat_listAction extends Action
{

    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  周文
     * @version 2.0
     * @date    2019-2-22
     * @return  订单发货
     */
    public function getDefaultView()
    {
        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');       

        $id = trim($request->getParameter('id')); // 订单id

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:1;

        $goods = array();
        if (!empty($id)) {
            $sql = "select d.user_id,d.id,d.r_sNo,d.p_name,d.size,d.num,o.name,o.mobile,o.sheng,o.shi,o.xian,o.address,o.mch_id,o.remark,p.weight from lkt_order_details as d left join lkt_product_list as p on p.id=d.p_id left join lkt_order as o on d.r_sNo=o.sNo where d.store_id = '$store_id' and d.id in ($id)";
            $res = $db->select($sql);
            if ($res) {
                $res[0]->mch_id = ',1,';
                $mch_id = $res[0]->mch_id;
                $mch_id = substr($mch_id,1);
                $mch_id = substr($mch_id,0,strlen($mch_id)-1);
                if (intval($mch_id) != $shop_id) {
                    $sql = "select realname as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_mch where id='$mch_id'";
                    $mch = $db->select($sql);
                }else{
                    $sql = "select name as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_service_address where store_id='$store_id' order by is_default desc limit 0,1";
                    $mch = $db->select($sql);
                }
                $s_id = $mch_id;
                $sender = $mch[0]->sender;
                $s_mobile = $mch[0]->s_mobile;
                $sss = $this->adddd($mch[0]->s_sheng,$mch[0]->s_shi);
                $s_sheng = $sss['sheng'];
                $s_shi = $sss['shi'];
                $s_xian = $mch[0]->s_xian;
                $s_address = $mch[0]->s_address;
                $remark = $res[0]->remark;
                $recipient = $res[0]->name;
                $r_mobile = $res[0]->mobile;
                $sss = $this->adddd($res[0]->sheng,$res[0]->shi);
                $r_sheng = $sss['sheng'];
                $r_shi = $sss['shi'];
                $r_xian = $res[0]->xian;
                $r_address = $res[0]->address;
                $sNo = $res[0]->r_sNo;
                $r_userid = $res[0]->user_id;
                $title = '';
                $num = 0;
                $weight = 0;
                foreach ($res as $k => $v) {
                    $num += $v->num;
                    $weight += $v->weight;
                    $title .= $v->size.' '.$v->p_name.' ';
                }

                $sql = "select * from lkt_printing where store_id='$store_id' and d_sNo = '$id' and type=1";
                $goods = $db->select($sql);
                if (!$goods) {
                    $sql = "insert into `lkt_printing` (`store_id`, `title`, `sNo`, `d_sNo`, `num`, `weight`, `sender`, `s_mobile`, `s_sheng`, `s_shi`, `s_xian`, `s_address`, `recipient`, `r_mobile`, `r_sheng`, `r_shi`, `r_xian`, `r_address`, `status`, `create_time`, `type`, `remark`,`r_userid`,`s_id`) VALUES ('$store_id', '$title', '$sNo', '$id', '$num', '$weight', '$sender', '$s_mobile', '$s_sheng', '$s_shi', '$s_xian', '$s_address', '$recipient', '$r_mobile', '$r_sheng', '$r_shi', '$r_xian', '$r_address', '0', CURRENT_TIMESTAMP, '1', '$remark', '$r_userid', '$s_id')";
                    $rid = $db->insert($sql,"last_insert_id");

                    $sql = "select * from lkt_printing where store_id='$store_id' and id = '$rid'";
                    $goods = $db->select($sql);
                }
                $ids = '';
                foreach ($goods as $k => $v) {
                    $ids .= $v->id.',';
                }
            }
        }
        
        $request->setAttribute("goods", $goods);
        $request->setAttribute("ids", $ids);
        return View :: INPUT;

    }

    public function adddd($sheng,$shi){

        if(strpos($sheng,'北京') !== false){ 
            $sheng = '北京';
            $shi = '北京市';
        }
        if(strpos($sheng,'天津') !== false){ 
            $sheng = '天津';
            $shi = '天津市';
        }
        if(strpos($sheng,'上海') !== false){ 
            $sheng = '上海';
            $shi = '上海市';
        }
        if(strpos($sheng,'重庆') !== false){ 
            $sheng = '重庆';
            $shi = '重庆市';
        }

        return array('sheng' => $sheng, 'shi' => $shi);
    }


    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-25T10:57:43+0800
     * @return  操作订单详情
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $m = trim($request->getParameter('m'));

        $this->$m();

        echo json_encode(array('status' => 0,'msg'=>'输入值有误！'));exit;
        exit;
    }

    public function getedit(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));

        $sql = "select p.*,u.user_name as r_uname,o.z_price as sum from lkt_printing p left join lkt_user u on p.r_userid=u.user_id left join lkt_order o on p.sNo=o.sNo where p.id='$id'";
        $r = $db->select($sql);
        $detail = $r?(array)$r[0]:array();
        if (!empty($detail)) {
            $d_id = $detail['d_sNo'];
            $d_id = explode(',', $d_id);
            $detail['goods'] = array();
            foreach ($d_id as $k => $v) {
                $sql = "select d.id,p.imgurl,p.product_title,p.product_number,d.size,d.p_name,d.p_price,d.num,d.unit as total from lkt_order_details d left join lkt_product_list p on d.p_id=p.id where d.store_id='$store_id' and d.id='$v'";
                $r = $db->select($sql);
                if ($r) {
                    $r[0]->imgurl = ServerPath::getimgpath($r[0]->imgurl,$store_id);
                    $r[0]->total = floatval($r[0]->p_price)*intval($r[0]->num);

                    $detail['goods'][] = $r[0];
                }
            }

            if ($detail['s_sheng'] == '北京' || $detail['s_sheng'] == '重庆' || $detail['s_sheng'] == '天津' || $detail['s_sheng'] == '上海') {
                $detail['s_sheng'] = $detail['s_sheng'].'市';
                $detail['s_shi'] = '市辖区';
            }

            if ($detail['r_sheng'] == '北京' || $detail['r_sheng'] == '重庆' || $detail['r_sheng'] == '天津' || $detail['r_sheng'] == '上海') {
                $detail['r_sheng'] = $detail['r_sheng'].'市';
                $detail['r_shi'] = '市辖区';
            }

            $sql = "select GroupID from admin_cg_group where G_CName='".$detail['s_sheng']."'";
            $ss = $db->select($sql);
            $detail['s1'] = $ss?$ss[0]->GroupID:'';
            $sql = "select GroupID from admin_cg_group where G_CName='".$detail['s_shi']."' and G_ParentID='".$detail['s1']."'";
            $ss = $db->select($sql);
            $detail['s2'] = $ss?$ss[0]->GroupID:'';
            $sql = "select GroupID from admin_cg_group where G_CName='".$detail['s_xian']."' and G_ParentID='".$detail['s2']."'";
            $ss = $db->select($sql);
            $detail['s3'] = $ss?$ss[0]->GroupID:'';

            $sql = "select GroupID from admin_cg_group where G_CName='".$detail['r_sheng']."'";
            $ss = $db->select($sql);
            $detail['r1'] = $ss?$ss[0]->GroupID:'';
            $sql = "select GroupID from admin_cg_group where G_CName='".$detail['r_shi']."' and G_ParentID='".$detail['r1']."'";
            $ss = $db->select($sql);
            $detail['r2'] = $ss?$ss[0]->GroupID:'';
            $sql = "select GroupID from admin_cg_group where G_CName='".$detail['r_xian']."' and G_ParentID='".$detail['r2']."'";
            $ss = $db->select($sql);
            $detail['r3'] = $ss?$ss[0]->GroupID:'';
        }

        // 平台代发地址
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:1;
        $sql = "select name as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_service_address where store_id='$store_id' order by is_default desc limit 0,1";
        $r = $db->select($sql);

        $sql = "select GroupID from admin_cg_group where G_CName='".$r[0]->s_sheng."'";
        $ss = $db->select($sql);
        $r[0]->p1 = $ss?$ss[0]->GroupID:'';
        $sql = "select GroupID from admin_cg_group where G_CName='".$r[0]->s_shi."' and G_ParentID='".$r[0]->p1."'";
        $ss = $db->select($sql);
        $r[0]->p2 = $ss?$ss[0]->GroupID:'';
        $sql = "select GroupID from admin_cg_group where G_CName='".$r[0]->s_xian."' and G_ParentID='".$r[0]->p2."'";
        $ss = $db->select($sql);
        $r[0]->p3 = $ss?$ss[0]->GroupID:'';

        $detail['pingtai'] = $r[0];

        // 店铺发货地址
        $sql = "select mch_id from lkt_order where sNo='".$detail['sNo']."'";
        $r = $db->select($sql);
        $mch_id = $r?$r[0]->mch_id:0;
        if ($shop_id == $mch_id || $mch_id == 0) {
            $detail['mch'] = $detail['pingtai'];
        }else{
            $sql = "select realname as sender,tel as s_mobile,sheng as s_sheng,shi as s_shi,xian as s_xian,address as s_address from lkt_mch where id='$mch_id'";
            $r = $db->select($sql);

            $sql = "select GroupID from admin_cg_group where G_CName='".$r[0]->s_sheng."'";
            $ss = $db->select($sql);
            $r[0]->m1 = $ss?$ss[0]->GroupID:'';
            $sql = "select GroupID from admin_cg_group where G_CName='".$r[0]->s_shi."' and G_ParentID='".$r[0]->m1."'";
            $ss = $db->select($sql);
            $r[0]->m2 = $ss?$ss[0]->GroupID:'';
            $sql = "select GroupID from admin_cg_group where G_CName='".$r[0]->s_xian."' and G_ParentID='".$r[0]->m2."'";
            $ss = $db->select($sql);
            $r[0]->m3 = $ss?$ss[0]->GroupID:'';

            $detail['mch'] = $r[0];
        }

        // 赠品
        $auto_jian = new subtraction();
        $subtraction_list = $auto_jian->subtraction_order($db,$store_id,$detail['sNo']);
        if (!empty($subtraction_list)) {
            $detail['subtraction_list'] = $subtraction_list;
        }

        if (!empty($detail)) {
            echo json_encode(array('code' => 200,'data'=>$detail));exit;
        }else{
            echo json_encode(array('code' => 404));exit;
        }
    }

    public function getdetails(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $ids = trim($request->getParameter('id'));
        $ids = explode(',', $ids);

        $details = array();
        foreach ($ids as $k => $v) {
            if (!empty($v)) {
                $id = $v;
                $sql = "select p.*,u.user_name as r_uname,m.user_id as s_id,o.z_price as sum from lkt_printing p left join lkt_user u on p.r_userid=u.user_id left join lkt_mch m on p.s_id=m.id left join lkt_order o on p.sNo=o.sNo where p.id='$id'";
                $r = $db->select($sql);
                $detail = $r?(array)$r[0]:array();
                if (!empty($detail)) {
                    $d_id = $detail['d_sNo'];
                    $d_id = explode(',', $d_id);
                    $detail['goods'] = array();
                    foreach ($d_id as $key => $value) {
                        $sql = "select d.id,p.imgurl,p.product_title,p.product_number,d.size,d.p_name,d.p_price,d.num,d.unit as total from lkt_order_details d left join lkt_product_list p on d.p_id=p.id where d.store_id='$store_id' and d.id='$value'";
                        $r = $db->select($sql);
                        if ($r) {
                            $r[0]->imgurl = ServerPath::getimgpath($r[0]->imgurl,$store_id);
                            $r[0]->total = floatval($r[0]->p_price)*intval($r[0]->num);
                            $detail['goods'][] = $r[0];
                        }
                    }
                }
                // 赠品
                $auto_jian = new subtraction();
                $subtraction_list = $auto_jian->subtraction_order($db,$store_id,$detail['sNo']);
                if (!empty($subtraction_list)) {
                    $zengpin = array(
                        'imgurl' => $subtraction_list['imgurl'],
                        'product_title' => '【赠品】'.$subtraction_list['product_title'],
                        'product_number' => $subtraction_list['product_number'],
                        'num' => $subtraction_list['num'],
                        'size' => '',
                        'p_price' => '0.00',
                        'total' => '0.00'
                    );
                    $detail['goods'][] = $zengpin;
                }
                // 赠品 end

                $detail['now'] = date('Y-m-d H:i:s');
                $details[] = $detail;
            }
        }

        if (!empty($details)) {
            echo json_encode(array('code' => 200,'data'=>$details));exit;
        }else{
            echo json_encode(array('code' => 404));exit;
        }

    }

    public function edit(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));

        $sender = addslashes(trim($request->getParameter('sender')));// 寄件人
        $s_mobile = addslashes(trim($request->getParameter('s_mobile')));// 寄件人手机号码
        $s_address = addslashes(trim($request->getParameter('s_address')));// 寄件人地址
        $recipient = addslashes(trim($request->getParameter('recipient')));// 收件人
        $r_mobile = addslashes(trim($request->getParameter('r_mobile')));// 收件人手机号码
        $r_address = addslashes(trim($request->getParameter('r_address')));// 收件人地址



        echo json_encode(array('code' => 200,'msg'=>'修改成功！'));exit;

    }

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>